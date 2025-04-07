<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateBrandRequest;
use App\Models\Brand;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;

class BrandController extends Controller
{
    public function __construct()
    {
    }
    public function index()
    {
        if(!in_array(Auth::user()->role, [User::ADMIN, User::WRITER])) {
            return redirect()->route('admin.dashboard');
        }
        $data = Brand::query()->get();
        return view('admin.brand.list', compact('data'));
    }

    public function create(): View
    {
        return view('admin.brand.create');
    }

    public function save(CreateBrandRequest $request): JsonResponse
    {
        $inputs = $request->validated();
        Brand::query()->create($inputs);
        return response()->json(['message' => 'Brand Created successfully', 'redirectTo' => route('admin.brands')], 200);
    }

    public function edit(Brand $brand): View
    {
        return view('admin.brand.create', compact('brand'));
    }

    public function update(CreateBrandRequest $request, Brand $brand): JsonResponse
    {
        $data = $request->validated();
        $brand->update($data);

        return response()->json(['message' => 'Brand Updated successfully', 'redirectTo' => route('admin.brands')], 200);
    }

    public function destroy(Brand $brand): JsonResponse
    {
        $brand->delete();
        return response()->json(['message' => 'Brand deleted successfully!', 'reload' => true]);
    }

    public function getBrandDropdown(Request $request): JsonResponse
    {
        $search = $request->get('search', '');

        $brands = Brand::query()->select('id', 'name as text');

        if (!empty($search)) {
            $brands->where(function($query) use($search) {
                $query->orWhere('name', 'like', '%' . $search . '%');
            });
        }

        $brands = $brands->latest()->simplePaginate(200);

        $data['more'] = $brands->hasMorePages();
        $data['results'] = $brands->toArray()['data'];

        return response()->json($data, 200);
    }
}
