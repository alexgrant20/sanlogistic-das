<?php

use App\Http\Controllers\Admin\ActivityController;
use App\Http\Controllers\Admin\FinanceController;
use App\Http\Controllers\Admin\PersonController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\AddressController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\VehicleController;
use App\Http\Controllers\Admin\CompanyController;
use Illuminate\Support\Facades\Route;


Route::prefix('/admin')->group(function () {
  // Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard')->middleware('auth.admin');

  Route::resource('/users', UserController::class, [
    'names' => [
      'index' => 'admin.user.index',
      'create' => 'admin.user.create',
      'store' => 'admin.user.store',
      'edit' => 'admin.user.edit',
      'update' => 'admin.user.update',
      'destroy' => 'admin.user.destroy'
    ]
  ])->middleware('auth.admin');

  Route::middleware('auth.admin')->controller(AddressController::class)->group(function () {
    Route::prefix('/addresses')->group(function () {
      Route::get('/export/excel', 'exportExcel')->name('export.address');
      Route::post('/import/excel', 'importExcel')->name('import.address');
      Route::get('/city/{id}', 'city');
      Route::get('/district/{id}', 'district');
      Route::get('/sub_district/{id}', 'subDistrict');
      Route::get('/location', 'location');
    });
    Route::resource('/addresses', AddressController::class, [
      'names' => [
        'index' => 'admin.address.index',
        'create' => 'admin.address.create',
        'store' => 'admin.address.store',
        'edit' => 'admin.address.edit',
        'update' => 'admin.address.update',
        'destroy' => 'admin.address.destroy'
      ]
    ])->except(['show']);
  });

  Route::middleware('auth.admin')->controller(ActivityController::class)->group(function () {
    Route::prefix('/activities')->group(function () {
      Route::get('/export/excel', 'exportExcel');
      Route::post('/import/excel', 'importExcel');
    });
    Route::resource('/activities', ActivityController::class, [
      'names' => [
        'index' => 'admin.activity.index',
        'create' => 'admin.activity.create',
        'store' => 'admin.activity.store',
        'edit' => 'admin.activity.edit',
        'update' => 'admin.activity.update',
        'destroy' => 'admin.activity.destroy'
      ],
    ]);
  });

  Route::middleware('auth.admin')->controller(PersonController::class)->group(function () {
    Route::prefix('/people')->group(function () {
      Route::get('/export/excel', 'exportExcel');
      Route::post('/import/excel', 'importExcel');
    });
    Route::resource('/people', PersonController::class, [
      'names' => [
        'index' => 'admin.person.index',
        'create' => 'admin.person.create',
        'store' => 'admin.person.store',
        'edit' => 'admin.person.edit',
        'update' => 'admin.person.update',
        'destroy' => 'admin.person.destroy'
      ],
    ]);
  });

  Route::middleware('auth.admin')->controller(VehicleController::class)->group(function () {
    Route::prefix('/vehicles')->group(function () {
      Route::get('/export/excel', 'exportExcel');
      Route::post('/import/excel', 'importExcel');
      Route::get('/migrate/image', 'migrateImage')->name('admin.vehicle.migrate_image');
      Route::get('/vehicle_type/{id}', 'vehicleType');
      Route::get('/vehicle_variety/{id}', 'vehicleVariety');
      // Option
    });
    Route::resource('/vehicles', VehicleController::class, [
      'names' => [
        'index' => 'admin.vehicle.index',
        'create' => 'admin.vehicle.create',
        'store' => 'admin.vehicle.store',
        'edit' => 'admin.vehicle.edit',
        'update' => 'admin.vehicle.update',
        'destroy' => 'admin.vehicle.destroy'
      ],
    ]);
  });

  Route::middleware('auth.admin')->controller(CompanyController::class)->group(function () {
    Route::prefix('/companies')->group(function () {
      Route::get('/export/excel', 'exportExcel');
      Route::post('/import/excel', 'importExcel');
      Route::get('/migrate/image', 'migrateImage')->name('admin.company.migrate_image');
    });
    Route::resource('/companies', CompanyController::class, [
      'names' => [
        'index' => 'admin.company.index',
        'create' => 'admin.company.create',
        'store' => 'admin.company.store',
        'edit' => 'admin.company.edit',
        'update' => 'admin.company.update',
        'destroy' => 'admin.company.destroy'
      ],
    ]);
  });

  Route::middleware('auth.admin')->controller(ProjectController::class)->group(function () {
    Route::get('/assign/vehicle/{project:name}', 'indexAssignVehicle');
    Route::get('/assign/person/{project:name}', 'indexAssignPerson');
    Route::get('/assign/address/{project:name}', 'indexAssignAddress');
    Route::post('/assign/vehicle', 'assignVehicle');
    Route::post('/assign/person', 'assignPerson');
    Route::post('/assign/address', 'assignAddress');
    Route::get('/project/vehicle', 'vehicles');
    Route::get('/project/address', 'address');
    Route::get('/project/person', 'people');
    Route::prefix('/projects')->group(function () {
      Route::get('/export/excel', 'exportExcel');
      Route::post('/import/excel', 'importExcel');
    });
    Route::resource('/projects', ProjectController::class, [
      'names' => [
        'index' => 'admin.project.index',
        'create' => 'admin.project.create',
        'store' => 'admin.project.store',
        'edit' => 'admin.project.edit',
        'update' => 'admin.project.update',
        'destroy' => 'admin.project.destroy'
      ],
    ]);
  });

  Route::middleware('auth.admin')->controller(FinanceController::class)->group(function () {
    Route::prefix('/finances')->group(function () {
      Route::get('/acceptance', 'acceptance')->name('admin.finance.acceptance');
      Route::get('/payment', 'payment')->name('admin.finance.payment');
      Route::post('/approve', 'approve')->name('admin.finance.approve');
      Route::post('/reject', 'reject')->name('admin.finance.reject');
      Route::post('/pay', 'pay')->name('admin.finance.pay');
      Route::get('/acceptance/{activity:id}/edit', 'edit');
      Route::put('/acceptance/{activity:id}', 'audit');
    });
    Route::post('/activity/accepted/export/excel', 'exportExcel')->name('admin.finance.export.accepted.excel');
  });
});