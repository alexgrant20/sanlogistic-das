<?php

use App\Http\Controllers\Driver\ActivityController;
use App\Http\Controllers\Driver\AddressController;
use App\Http\Controllers\Driver\ChecklistController;
use App\Http\Controllers\Driver\MenuController;
use App\Http\Controllers\Driver\VehicleController;
use Illuminate\Support\Facades\Route;

Route::prefix('driver')->name('driver.')->middleware('auth')->group(function () {

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
    Route::get('/finances', 'finance')->name('finance');
    Route::get('/locations/{id?}', 'location')->name('location');
    Route::get('/last-statuses/{vehicleId}', 'getChecklistLastStatus')->name('lastStatus.get');
  });

  Route::controller(ChecklistController::class)->name('checklist.')->group(function () {
    Route::get('/checklists', 'index')->name('index');
    Route::get('/checklists/create', 'create')->name('create');
    Route::post('/checklists', 'store')->name('store');
  });
});