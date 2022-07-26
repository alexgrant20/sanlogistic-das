<?php

use App\Http\Controllers\Driver\ActivityController;
use App\Http\Controllers\Driver\AddressController;
use App\Http\Controllers\Driver\MenuController;
use App\Http\Controllers\Driver\VehicleController;
use Illuminate\Support\Facades\Route;

Route::prefix('driver')->name('driver.')->middleware('auth', 'driver')->group(function () {

  // Route::get('/activities/create', \App\Http\Livewire\Driver\Activity\Create::class)->name('activity.create');

  Route::resource('/activities', ActivityController::class, [
    'names' => [
      'index' => 'activity.index',
      'create' => 'activity.create',
      'store' => 'activity.store',
      'edit' => 'activity.edit',
      'update' => 'activity.update',
      'destroy' => 'activity.destroy'
    ],
  ]);

  Route::controller(MenuController::class)->name('menu.')->group(function () {
    Route::get('/profile', 'profile')->name('profile');
    Route::get('/checklist', 'checklist')->name('checklist');
    Route::get('/location/{id?}', 'location')->name('location');
  });
});