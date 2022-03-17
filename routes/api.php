<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\VehicleController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy buildding your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
	return $request->user();
});

// Option
Route::get('/vehicles/vehicle-type/{id}', [VehicleController::class, 'vehicleType']);
Route::get('/vehicles/vehicle-variety/{id}', [VehicleController::class, 'vehicleVariety']);

Route::get('/addresses/city/{id}', [AddressController::class, 'city']);
Route::get('/addresses/district/{id}', [AddressController::class, 'district']);
Route::get('/addresses/sub-district/{id}', [AddressController::class, 'subDistrict']);
Route::get('/addresses/location', [AddressController::class, 'location']);