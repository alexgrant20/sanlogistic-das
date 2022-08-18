<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\IndexController;
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


Route::get('/', [IndexController::class, 'index'])->name('index')->middleware('auth');

Route::controller(AuthController::class)->group(function () {
  Route::prefix('/login')->middleware('guest')->group(function () {
    Route::get('', 'index')->name('login');
    Route::post('', 'login');
  });
  Route::post('/logout', 'logout')->name('logout')->middleware('auth');
});

require __DIR__ . '/admin.php';

require __DIR__ . '/driver.php';