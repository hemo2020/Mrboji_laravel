<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CarRequest;
use App\Models\Car;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;

class CarController extends Controller
{
    public function __construct()
    {
    }
    public function index(): View
    {
        $data = Car::query()->get();
        return view('admin.car.list', compact('data'));
    }

    public function create(): View
    {
        return view('admin.car.create');
    }

    public function save(CarRequest $request): JsonResponse
    {
        $inputs = $request->validated();
        Car::query()->create($inputs);
        return response()->json(['message' => 'Car Created successfully', 'redirectTo' => route('admin.cars')], 200);
    }

    public function edit(Car $car): View
    {
        return view('admin.car.create', compact('car'));
    }

    public function update(CarRequest $request, Car $car): JsonResponse
    {
        $data = $request->validated();
        $car->update($data);

        return response()->json(['message' => 'Car Updated successfully', 'redirectTo' => route('admin.cars')], 200);
    }

    public function destroy(Car $car): JsonResponse
    {
        $car->delete();
        return response()->json(['message' => 'car deleted successfully!', 'reload' => true]);
    }
}
