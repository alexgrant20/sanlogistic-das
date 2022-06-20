<?php

use App\Http\Controllers\Driver\ActivityController;
use App\Http\Controllers\Driver\AddressController;
use App\Http\Controllers\Driver\DashboardController;
use App\Http\Controllers\Driver\VehicleController;
use Illuminate\Support\Facades\Route;

Route::prefix('driver')->group(function () {
  // Route::get('/dashboard', [DashboardController::class, 'index'])->name('driver.home')->middleware('auth.driver');
  Route::resource('/activities', ActivityController::class, [
    'names' => [
      'index' => 'driver.activity.index',
      'create' => 'driver.activity.create',
      'store' => 'driver.activity.store',
      'edit' => 'driver.activity.edit',
      'update' => 'driver.activity.update',
      'destroy' => 'driver.activity.destroy'
    ],
  ])->middleware('auth.driver');
  Route::get('/vehicles/get/', [VehicleController::class, 'get'])->middleware('auth.driver');
  Route::get('/addresses/get/', [AddressController::class, 'get'])->middleware('auth.driver');
});