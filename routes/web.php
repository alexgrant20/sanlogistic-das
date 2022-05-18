<?php

use App\Http\Controllers\ActivityController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\FinanceController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\OptionController;
use App\Http\Controllers\PersonController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\UserController;
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
Route::resource('/users', UserController::class)->middleware('auth');

Route::get('/addresses/export/excel', [AddressController::class, 'exportExcel'])->middleware('auth');
Route::post('/addresses/import/excel', [AddressController::class, 'importExcel'])->middleware('auth');
Route::get('/addresses/city/{id}', [AddressController::class, 'city'])->middleware('auth');
Route::get('/addresses/district/{id}', [AddressController::class, 'district'])->middleware('auth');
Route::get('/addresses/sub_district/{id}', [AddressController::class, 'subDistrict'])->middleware('auth');
Route::get('/addresses/location', [AddressController::class, 'location'])->middleware('auth');
Route::resource('/addresses', AddressController::class)->middleware('auth');

Route::get('/activities/export/excel', [ActivityController::class, 'exportExcel'])->middleware('auth');
Route::post('/activities/import/excel', [ActivityController::class, 'importExcel'])->middleware('auth');
Route::resource('/activities', ActivityController::class)->middleware('auth');

Route::get('/people/export/excel', [PersonController::class, 'exportExcel'])->middleware('auth');
Route::post('/people/import/excel', [PersonController::class, 'importExcel'])->middleware('auth');
Route::resource('/people', PersonController::class)->middleware('auth');

Route::get('/vehicles/export/excel', [VehicleController::class, 'exportExcel'])->middleware('auth');
Route::post('/vehicles/import/excel', [VehicleController::class, 'importExcel'])->middleware('auth');
Route::get('/vehicles/migrate/image', [VehicleController::class, 'migrateImage'])->middleware('auth');
// Option
Route::get('/vehicles/vehicle_type/{id}', [VehicleController::class, 'vehicleType'])->middleware('auth');
Route::get('/vehicles/vehicle_variety/{id}', [VehicleController::class, 'vehicleVariety'])->middleware('auth');
Route::resource('/vehicles', VehicleController::class)->middleware('auth');

Route::get('/companies/export/excel', [CompanyController::class, 'exportExcel'])->middleware('auth');
Route::post('/companies/import/excel', [CompanyController::class, 'importExcel'])->middleware('auth');
Route::get('/companies/migrate/image', [CompanyController::class, 'migrateImage'])->middleware('auth');
Route::resource('/companies', CompanyController::class)->middleware('auth');

// === Project ===
// Export & Import
Route::get('/projects/export/excel', [ProjectController::class, 'exportExcel'])->middleware('auth');
Route::post('/projects/import/excel', [ProjectController::class, 'importExcel'])->middleware('auth');

// Assign
Route::get('/projects/assign/vehicle/{project:name}', [ProjectController::class, 'indexAssignVehicle'])->middleware('auth');
Route::get('/projects/assign/person/{project:name}', [ProjectController::class, 'indexAssignPerson'])->middleware('auth');
Route::get('/projects/assign/address/{project:name}', [ProjectController::class, 'indexAssignAddress'])->middleware('auth');
Route::post('/projects/assign/vehicle', [ProjectController::class, 'assignVehicle'])->middleware('auth');
Route::post('/projects/assign/person', [ProjectController::class, 'assignPerson'])->middleware('auth');
Route::post('/projects/assign/address', [ProjectController::class, 'assignAddress'])->middleware('auth');
Route::get('/project/vehicle', [ProjectController::class, 'vehicles'])->middleware('auth');
Route::get('/project/address', [ProjectController::class, 'address'])->middleware('auth');
Route::get('/project/person', [ProjectController::class, 'people'])->middleware('auth');

Route::resource('/projects', ProjectController::class)->middleware('auth');
//================

Route::post('/activity/accepted/export/excel', [FinanceController::class, 'exportExcel'])->middleware('auth');
Route::get('/finances/acceptance', [FinanceController::class, 'acceptance'])->middleware('auth');
Route::get('/finances/payment', [FinanceController::class, 'payment'])->middleware('auth');
Route::post('/finances/approve', [FinanceController::class, 'approve'])->middleware('auth');
Route::post('/finances/reject', [FinanceController::class, 'reject'])->middleware('auth');
Route::post('/finances/pay', [FinanceController::class, 'pay'])->middleware('auth');
Route::get('/finances/acceptance/{activity:id}/edit', [FinanceController::class, 'edit'])->middleware('auth');
Route::put('/finances/acceptance/{activity:id}', [FinanceController::class, 'audit'])->middleware('auth');