<?php

use App\Http\Controllers\ActivityController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PersonController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\VehicleController;
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
  return view('index');
})->middleware('auth');

Route::get('/login', [LoginController::class, 'index'])->name('login')->middleware('guest');
Route::post('/login', [LoginController::class, 'authenticate'])->middleware('guest');

Route::resource('/addresses', AddressController::class)->middleware('auth');

Route::resource('/activities', ActivityController::class)->middleware('auth');

Route::resource('/people', PersonController::class)->middleware('auth');

Route::resource('/vehicles', VehicleController::class)->middleware('auth');

Route::resource('/companies', CompanyController::class)->middleware('auth');

Route::resource('/projects', ProjectController::class)->middleware('auth');