<?php

use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\CaseController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ModelController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\CarController;
use Illuminate\Support\Facades\Route;

Route::prefix('')->group(function () {
    Route::middleware('auth')->name('admin.')->group(function() {
       Route::prefix('a_users')->group(function() {
           Route::get('/', [UserController::class, 'index'])->name('users');
           Route::get('create/{modal?}', [UserController::class, 'create'])->name('user.create');
           Route::post('save', [UserController::class, 'save'])->name('user.save');
           Route::get('{user}/edit/{modal?}', [UserController::class, 'edit'])->name('user.edit');
           Route::put('{user}/update', [UserController::class, 'update'])->name('user.update');
           Route::delete('{user}/delete', [UserController::class, 'delete'])->name('user.delete');
           Route::post('user-drop-down', [UserController::class, 'getUserDropdown'])->name('user_drop_down');
       });

        Route::prefix('a_brands')->group(function() {
            Route::get('/', [BrandController::class, 'index'])->name('brands');
            Route::get('create', [BrandController::class, 'create'])->name('brand.create');
            Route::post('save', [BrandController::class, 'save'])->name('brand.save');
            Route::get('{brand}/edit', [BrandController::class, 'edit'])->name('brand.edit');
            Route::put('{brand}/update', [BrandController::class, 'update'])->name('brand.update');
            Route::delete('{brand}/delete', [BrandController::class, 'destroy'])->name('brand.delete');
            Route::post('brand-drop-down', [BrandController::class, 'getBrandDropdown'])->name('brand_drop_down');
        });

        Route::prefix('a_models')->group(function() {
            Route::get('/', [ModelController::class, 'index'])->name('models');
            Route::get('create', [ModelController::class, 'create'])->name('model.create');
            Route::post('save', [ModelController::class, 'save'])->name('model.save');
            Route::get('{model}/edit', [ModelController::class, 'edit'])->name('model.edit');
            Route::put('{model}/update', [ModelController::class, 'update'])->name('model.update');
            Route::delete('{model}/delete', [ModelController::class, 'destroy'])->name('model.delete');
            Route::post('model-drop-down', [ModelController::class, 'getModelDropdown'])->name('model_drop_down');
        });

        Route::prefix('a_cars')->group(function() {
            Route::get('/', [CarController::class, 'index'])->name('cars');
            Route::get('create', [CarController::class, 'create'])->name('car.create');
            Route::post('save', [CarController::class, 'save'])->name('car.save');
            Route::get('{car}/edit', [CarController::class, 'edit'])->name('car.edit');
            Route::put('{car}/update', [CarController::class, 'update'])->name('car.update');
            Route::delete('{car}/delete', [CarController::class, 'destroy'])->name('car.delete');
        });

        Route::prefix('a_cases')->group(function() {
            Route::get('/', [CaseController::class, 'index'])->name('cases');
            Route::post('get-datatable', [CaseController::class, 'getCasesDatatable'])->name('case.get-datatable');
            Route::get('create', [CaseController::class, 'create'])->name('case.create');
            Route::post('save', [CaseController::class, 'save'])->name('case.save');
            Route::get('{case}/edit', [CaseController::class, 'edit'])->name('case.edit');
            Route::put('{case}/update', [CaseController::class, 'update'])->name('case.update');
            Route::get('{case}/show', [CaseController::class, 'show'])->name('case.show');
            Route::delete('{case}/delete', [CaseController::class, 'destroy'])->name('case.delete');
            Route::put('{case}/assign-to-pricing', [CaseController::class, 'assignToPricing'])->name('case.assign-to-pricing');

            Route::put('{case}/submit-pricing', [CaseController::class, 'submitPricing'])->name('case.submit.pricing');
            Route::put('{case}/close', [CaseController::class, 'closeCase'])->name('case.close');
            Route::put('{case}/complete', [CaseController::class, 'completeCase'])->name('case.complete');
            Route::post('get-part-price', [CaseController::class, 'getPartPrice'])->name('case.get-part-price');
        });

        Route::get('/', [DashboardController::class, 'index']);
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::get('load-notifications', [DashboardController::class, 'loadNotifications'])->name('load-notifications');

    });

    require __DIR__.'/auth.php';
});

