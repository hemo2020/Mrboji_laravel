<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateModelRequest;
use App\Models\Models;
use App\Models\User;
use App\Services\Admin\BrandService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;

class ModelController extends Controller
{
    public function __construct(public BrandService $brandService)
    {
    }
    public function index()
    {
        if(!in_array(Auth::user()->role, [User::ADMIN, User::WRITER])) {
            return redirect()->route('admin.dashboard');
        }
        $data = Models::query()
            ->with('brand')
            ->get();
        return view('admin.model.list', compact('data'));
    }

    public function create(): View
    {
        $brands = $this->brandService->getBrandDropdown();
        return view('admin.model.create', compact('brands'));
    }

    public function save(CreateModelRequest $request): JsonResponse
    {
        $inputs = $request->validated();
        Models::query()->create($inputs);
        return response()->json(['message' => 'Model Created successfully', 'redirectTo' => route('admin.models')], 200);
    }

    public function edit(Models $model): View
    {
        $brands = $this->brandService->getBrandDropdown();
        return view('admin.model.create', compact('model', 'brands'));
    }

    public function update(CreateModelRequest $request, Models $model): JsonResponse
    {
        $data = $request->validated();
        $model->update($data);

        return response()->json(['message' => 'Model Updated successfully', 'redirectTo' => route('admin.models')], 200);
    }

    public function destroy(Models $model): JsonResponse
    {
        $model->delete();
        return response()->json(['message' => 'Model deleted successfully!', 'reload' => true]);
    }

    public function getModelDropdown(Request $request): JsonResponse
    {
        $search = $request->get('search', '');

        $models = Models::query()->select('id', 'name as text');

        if (!empty($search)) {
            $models->where(function($query) use($search) {
                $query->orWhere('name', 'like', '%' . $search . '%');
            });
        }

        if (!empty($request->brand_id)) {
            $models->where('brand_id', $request->brand_id);
        }

        $models = $models->latest()->simplePaginate(200);

        $data['more'] = $models->hasMorePages();
        $data['results'] = $models->toArray()['data'];

        return response()->json($data, 200);
    }
}
