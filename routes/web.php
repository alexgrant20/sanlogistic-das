<?php

use App\Http\Controllers\ActivityController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\OptionController;
use App\Http\Controllers\PersonController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\VehicleController;
use App\Http\Livewire\Vehicle;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
  return view('index', [
    'title' => 'Home'
  ]);
})->middleware('auth');

Route::get('/login', [LoginController::class, 'index'])->name('login')->middleware('guest');
Route::post('/login', [LoginController::class, 'authenticate'])->middleware('guest');
Route::post('/logout', [LoginController::class, 'logout'])->middleware('auth');

// Route::get('/addresses/getAllLocation')
Route::get('/addresses/export/excel', [AddressController::class, 'exportExcel']);
Route::resource('/addresses', AddressController::class)->middleware('auth');

Route::get('/activities/export/excel', [ActivityController::class, 'exportExcel']);
Route::resource('/activities', ActivityController::class)->middleware('auth');

Route::get('/people/export/excel', [PersonController::class, 'exportExcel']);
Route::resource('/people', PersonController::class)->middleware('auth');

Route::get('/vehicles/export/excel', [VehicleController::class, 'exportExcel']);
Route::post('/vehicles/import/excel', [VehicleController::class, 'importExcel']);
Route::get('/vehicles/migrate/image', [VehicleController::class, 'migrateImage'])->middleware('auth');
Route::resource('/vehicles', VehicleController::class)->middleware('auth');

Route::get('/companies/export/excel', [CompanyController::class, 'exportExcel']);
Route::get('/companies/migrate/image', [CompanyController::class, 'migrateImage'])->middleware('auth');
Route::resource('/companies', CompanyController::class)->middleware('auth');

Route::get('/projects/export/excel', [ProjectController::class, 'exportExcel']);
Route::resource('/projects', ProjectController::class)->middleware('auth');