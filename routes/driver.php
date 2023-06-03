<?php

use App\Http\Controllers\Driver\ActivityController;
use App\Http\Controllers\Driver\ChecklistController;
use App\Http\Controllers\Driver\MenuController;
use Illuminate\Support\Facades\Route;

Route::prefix('driver')->name('driver.')->middleware('auth')->group(function () {

  Route::get('/activities/public-transport', [ActivityController::class, 'createPublicTransport'])->name('activity.create-public-transport');
  Route::post('/activities/public-transport', [ActivityController::class, 'storePublicTransport'])->name('activity.store-public-transport');
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

  Route::resource('/checklists', ChecklistController::class);
});
