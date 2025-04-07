<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CaseAssignToRequest;
use App\Http\Requests\CaseRequest;
use App\Http\Requests\GetPartPriceRequest;
use App\Http\Requests\SubmitPricingRequest;
use App\Http\Resources\CaseResource;
use App\Models\CasePricing;
use App\Models\Cases;
use App\Models\User;
use App\Services\Admin\CaseService;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;

class CaseController extends Controller
{
    public function __construct(CaseService $caseService)
    {
        $this->caseService = $caseService;
    }
    public function index(): View
    {
        $authUser = Auth::user();
        $pricingUsers = User::query()->where('role', User::PRICING)->pluck('name', 'id');

        $columns = [
            'case_no' => 'Case no',
            'brand' => 'Brand',
            'model' => 'Model',
            'year' => 'Year',
            'vin' => 'Vin',
            'created_by_name' => 'Created By',
            'assigned_to' => 'Assign To',
            'status' => 'Status',
            'action' => 'Action',
        ];

        $statusList = Cases::STATUSES;

        if(!in_array($authUser->role,  [User::ADMIN, User::WRITER])) {
            unset($columns['action']);
            unset($statusList[0]);
        }
        return view('admin.case.index', compact('pricingUsers', 'columns', 'statusList'));
    }

    public function methodToGetCases($start, $length, $request): array
    {
        $cases = Cases::query()->with([
            'createdBy'
        ]);

        $authUser = Auth::user();

        if ($authUser->isWriter()) {
            $cases->where('created_by', $authUser->id);
        }

        if ($authUser->isPricing()) {
            $cases->where('assigned_to', $authUser->id);
        }

        $cases->when($request->get('status') && $request->get('status') != 'null', function ($q) use ($request){
            $q->where('status', $request->get('status'));
        })->when($request->get('dates'), function ($q) use ($request){
            $dates = explode(' to ', $request->get('dates'));
            $q->whereBetween(DB::raw("DATE(created_at)"), [date('Y-m-d', strtotime($dates[0])), date('Y-m-d', strtotime($dates[1]))]);
        })->when(data_get($request->get('search'), 'value'), function ($q) use ($request, $authUser){
            $search = $request->get('search');
            $searchVal = data_get($search, 'value');

            $q->where(function($query) use ($searchVal, $authUser){
                $query->orWhere('case_no','like','%'. $searchVal.'%');
                $query->orWhere('status','like','%'. $searchVal.'%');
                $query->orWhere('brand','like','%'. $searchVal.'%');
                $query->orWhere('model','like','%'. $searchVal.'%');
                $query->orWhere('year','like','%'. $searchVal.'%');
                $query->orWhere('vin','like','%'. $searchVal.'%');

                if (!$authUser->isWriter()) {
                    $query->orWhereHas('createdBy', function ($query) use ($searchVal) {
                        $query->where('name', 'like', '%' . $searchVal . '%');
                    });
                }

                if (!$authUser->isPricing()) {
                    $query->orWhereHas('assignedTo', function ($query) use ($searchVal) {
                        $query->where('name', 'like', '%' . $searchVal . '%');
                    });
                }
            });

        });

        $total = $cases->newQuery()->count();

        $orderBy = 'updated_at';
        $order = $request->get('order');
        $orderByColumnId = $order[0]['column'] ?? '';
        $orderByDir = $order[0]['dir'] ?? 'desc';

        if (!empty($orderByColumnId)) {
            $orderByColumnName = $request->get('columns')[$orderByColumnId]['data'];
            if ($orderByColumnName == 'status') {
                $orderBy = 'updated_at';
            } else if ($orderByColumnName == 'created_by_name') {
                $orderBy = User::query()->select('name')->whereColumn('cases.created_by', 'id')->orderBy('name', $orderByDir)->limit(1);
            } else {
                $orderBy = $orderByColumnName;
            }
        }

        $cases->orderBy($orderBy, $orderByDir);

        if ($length >= 0) {
            $cases->offset($start)->limit($length);
        }

        $data = $cases->get();

        return compact('total', 'data');
    }

    public function getCasesDatatable(Request $request): JsonResponse
    {
        $draw = $request->get('draw');
        $start = $request->get('start');
        $length = $request->get('length');


        $search = (isset($filter['value']))? $filter['value'] : false;

        $total_members = 1000; // get your total no of data;
        $members = $this->methodToGetCases($start, $length, $request); //supply start and length of the table data

        $data = array(
            'draw' => $draw,
            'recordsTotal' => $members['total'],
            'recordsFiltered' => $members['total'],
            'data' => CaseResource::collection($members['data']),
        );

        return response()->json($data);

    }

    public function create(): View
    {
        return view('admin.case.create');
    }

    public function save(CaseRequest $request): JsonResponse
    {
        $inputs = $request->validated();

        if (!empty($inputs['assigned_to'])) {
            $inputs['status'] = Cases::IN_PROGRESS;
        }

        $parts = $inputs['parts'];
        unset($inputs['parts']);

        DB::beginTransaction();
        try {
            $case = Cases::query()->create($inputs);
            $case->pricing()->createMany($parts);

            DB::commit();
            return response()->json(['message' => 'Cases Created successfully', 'redirectTo' => route('admin.cases')], 200);
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Case Create Exception: ' . $e->getMessage());
            return response()->json(['message' => 'Something went wrong' . $e->getMessage()], 500);
        }

    }
    public function show(Cases $case): View
    {
        $case->load('pricing');
        return view('admin.case.show', compact('case'));
    }

    public function edit(Cases $case): View
    {
        $case->load('pricing');
        return view('admin.case.create', compact('case'));
    }

    public function update(CaseRequest $request, Cases $case): JsonResponse
    {
        $inputs = $request->validated();

        $parts = $inputs['parts'];
        unset($inputs['parts']);

        DB::beginTransaction();
        try {
            $case->pricing()->delete();
            $case->update($inputs);
            $case->pricing()->createMany($parts);

            DB::commit();
            return response()->json(['message' => 'Cases Updated successfully', 'redirectTo' => route('admin.cases')], 200);
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Case Create Exception: ' . $e->getMessage());
            return response()->json(['message' => 'Something went wrong' . $e->getMessage()], 500);
        }
    }

    public function destroy(Cases $case): JsonResponse
    {
        $case->delete();
        return response()->json(['message' => 'case deleted successfully!', 'reload' => true]);
    }

    public function assignToPricing(CaseAssignToRequest $request, Cases $case): JsonResponse
    {
        $data = $request->validated();

        if(!in_array($case->status, [Cases::IN_PROGRESS, Cases::PENDING])) {
            return response()->json(['message' => 'You can not assign complete or close case to anyone! Please refresh page', 'reload' => true], 412);
        }

        $data['status'] = Cases::IN_PROGRESS;
        $case->update($data);

        $response = [
            'message' => 'Cases Assign successfully',
            'status' => Cases::getStatusLabel($data['status']),
            'reload' => false,
        ];

        return response()->json($response, 200);
    }

    public function submitPricing(SubmitPricingRequest $request, Cases $case): JsonResponse
    {
        $inputs = $request->validated();

        if (in_array($case->status, [Cases::IN_PROGRESS])) {
            $parts = $case->pricing()->get()->keyBy('id');

            foreach ($inputs['parts'] as $part) {
                $pricing = $parts[$part['id']];
                $pricing->part_no = $part['part_no'];
                $pricing->price = $part['price'];
                $pricing->discount = $part['discount'];
                $pricing->save();
            }
        }

        return response()->json(['message' => 'Cases Updated successfully', 'redirectTo' => route('admin.cases')], 200);
    }

    public function closeCase(Cases $case): JsonResponse
    {
        if ($case->status == Cases::COMPLETED) {
            $case->status = Cases::CLOSE;
            $case->closing_date = now();
            $case->save();
            return response()->json(['message' => 'Cases Updated successfully', 'redirectTo' => route('admin.cases')], 200);
        }

        return response()->json(['message' => 'Cases is not completed! Please reload and try again.'], 412);
    }

    public function completeCase(Cases $case): JsonResponse
    {
        if ($case->status == Cases::IN_PROGRESS) {

            if ($this->caseService->validatePartPricing($case)) {
                $case->status = Cases::COMPLETED;
                $case->save();
                return response()->json(['message' => 'Cases Completed successfully', 'redirectTo' => route('admin.cases')], 200);
            } else {
                return response()->json(['message' => 'Please fill all part detail to complete.'], 422);
            }
        }

        return response()->json(['message' => 'Cases is not IN Progress! Please reload and try again.'], 412);
    }

    public function getPartPrice(GetPartPriceRequest $request, Cases $case): JsonResponse
    {
        $inputs = $request->validated();
        $twoMonthsAgo = Carbon::now()->subMonths(2);

        $part = CasePricing::query()
                    ->where('part_no', $inputs['part_no'])
                    ->where('created_at', '>=', $twoMonthsAgo)
                    ->latest()
                    ->first();

        return response()->json(['price' => $part->price ?? 0, 'discount' => $part->discount ?? 0], 200);
    }
}
