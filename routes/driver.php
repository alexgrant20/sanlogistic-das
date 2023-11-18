<?php

use App\Http\Controllers\Driver\ActivityController;
use App\Http\Controllers\Driver\ChecklistController;
use App\Http\Controllers\Driver\MenuController;
use App\Models\Activity;
use Illuminate\Support\Facades\Route;

Route::prefix('driver')->name('driver.')->middleware('auth')->group(function () {

  Route::get('/activities/public-transport', [ActivityController::class, 'createPublicTransport'])->name('activity.create-public-transport');
  Route::post('/activities/public-transport', [ActivityController::class, 'storePublicTransport'])->name('activity.store-public-transport');

  Route::controller(ActivityController::class)->prefix('activity')->name('activity.')->group(function() {
    Route::get('/', 'index')->name('index');
    Route::get('/create', 'create')->name('create');
    Route::post('/', 'store')->name('store');
    Route::get('/{activity}/edit', 'edit')->name('edit');
    Route::put('/{activity}', 'update')->name('update');
  });

  Route::controller(MenuController::class)->name('menu.')->group(function () {
    Route::get('/profile', 'profile')->name('profile');
    Route::get('/finances', 'finance')->name('finance');
    Route::get('/locations/{id?}', 'location')->name('location');
    Route::get('/last-statuses/{vehicleId}', 'getChecklistLastStatus')->name('lastStatus.get');
  });

  Route::resource('/checklists', ChecklistController::class);
});
