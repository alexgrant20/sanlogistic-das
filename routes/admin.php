<?php

use App\Http\Controllers\Admin\ActivityController;
use App\Http\Controllers\Admin\FinanceController;
use App\Http\Controllers\Admin\PersonController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\AddressController;
use App\Http\Controllers\Admin\VehicleController;
use App\Http\Controllers\Admin\CompanyController;
use Illuminate\Support\Facades\Route;


Route::prefix('/admin')->name('admin.')->middleware('auth', 'admin')->group(function () {

  Route::resource('/users', UserController::class, [
    'names' => [
      'create' => 'user.create',
      'store' => 'user.store',
      'edit' => 'user.edit',
      'update' => 'user.update',
      // 'destroy' => 'user.destroy'
    ]
  ])->except(['index', 'destroy', 'show']);

  Route::controller(AddressController::class)->name('address.')->group(function () {
    Route::prefix('/addresses')->group(function () {
      Route::get('/export/excel', 'exportExcel')->name('export.excel');
      Route::post('/import/excel', 'importExcel')->name('import.excel');
      Route::get('/city/{id}', 'city')->name('city');
      Route::get('/district/{id}', 'district')->name('district');
      Route::get('/sub_district/{id}', 'subDistrict')->name('sub-district');
      Route::get('/location', 'location')->name('location');
    });
    Route::resource('/addresses', AddressController::class, [
      'names' => [
        'index' => 'index',
        'create' => 'create',
        'store' => 'store',
        'edit' => 'edit',
        'update' => 'update',
        'destroy' => 'destroy'
      ]
    ])->except(['show']);
  });

  Route::controller(ActivityController::class)->name('activity.')->group(function () {
    Route::prefix('/activities')->group(function () {
      Route::get('/export/excel', 'exportExcel')->name('export.excel');
      Route::post('/import/excel', 'importExcel')->name('import.excel');
      Route::get('/showLog/{activity:id}', 'showLog')->name('log');
    });
    Route::resource('/activities', ActivityController::class, [
      'names' => [
        'index' => 'index',
        'create' => 'create',
        'store' => 'store',
        'edit' => 'edit',
        'update' => 'update',
        'destroy' => 'destroy'
      ],
    ])->except('show', 'destory');
  });

  Route::controller(PersonController::class)->name('person.')->group(function () {
    Route::prefix('/people')->group(function () {
      Route::get('/export/excel', 'exportExcel')->name('export.excel');
      Route::post('/import/excel', 'importExcel')->name('import.excel');
    });
    Route::resource('/people', PersonController::class, [
      'names' => [
        'index' => 'index',
        'create' => 'create',
        'store' => 'store',
        'edit' => 'edit',
        'update' => 'update',
        'destroy' => 'destroy'
      ],
    ]);
  });

  Route::controller(VehicleController::class)->name('vehicle.')->group(function () {
    Route::prefix('/vehicles')->group(function () {
      Route::get('/export/excel', 'exportExcel')->name('export.excel');
      Route::post('/import/excel', 'importExcel')->name('import.excel');
      Route::get('/migrate/image', 'migrateImage')->name('migrate.image');
      Route::get('/vehicle_type/{id}', 'vehicleType')->name('type');
      Route::get('/vehicle_variety/{id}', 'vehicleVariety')->name('variety');
    });
    Route::resource('/vehicles', VehicleController::class, [
      'names' => [
        'index' => 'index',
        'create' => 'create',
        'store' => 'store',
        'edit' => 'edit',
        'update' => 'update',
        'destroy' => 'destroy'
      ],
    ]);
  });

  Route::controller(CompanyController::class)->name('company.')->group(function () {
    Route::prefix('/companies')->group(function () {
      Route::get('/export/excel', 'exportExcel')->name('export.excel');
      Route::post('/import/excel', 'importExcel')->name('import.excel');
      // Route::get('/migrate/image', 'migrateImage')->name('admin.company.migrate_image');
    });
    Route::resource('/companies', CompanyController::class, [
      'names' => [
        'index' => 'index',
        'create' => 'create',
        'store' => 'store',
        'edit' => 'edit',
        'update' => 'update',
        'destroy' => 'destroy'
      ],
    ]);
  });

  Route::controller(ProjectController::class)->name('project.')->group(function () {
    Route::get('/assign/vehicle/{project:name}', 'indexAssignVehicle')->name('index.assign.vehicle');
    Route::get('/assign/person/{project:name}', 'indexAssignPerson')->name('index.assign.person');
    Route::get('/assign/address/{project:name}', 'indexAssignAddress')->name('index.assign.address');
    Route::post('/assign/vehicle', 'assignVehicle')->name('store.assign.vehicle');
    Route::post('/assign/person', 'assignPerson')->name('store.assign.person');
    Route::post('/assign/address', 'assignAddress')->name('store.assign.address');
    Route::get('/project/vehicle', 'vehicles')->name('vehicle');
    Route::get('/project/address', 'address')->name('address');
    Route::get('/project/person', 'people')->name('person');
    Route::prefix('/projects')->group(function () {
      Route::get('/export/excel', 'exportExcel')->name('export.excel');
      Route::post('/import/excel', 'importExcel')->name('import.excel');
    });
    Route::resource('/projects', ProjectController::class, [
      'names' => [
        'index' => 'index',
        'create' => 'create',
        'store' => 'store',
        'edit' => 'edit',
        'update' => 'update',
        'destroy' => 'destroy'
      ],
    ]);
  });

  Route::controller(FinanceController::class)->name('finance.')->group(function () {
    Route::prefix('/finances')->group(function () {
      Route::get('/acceptance', 'acceptance')->name('acceptance');
      Route::get('/payment', 'payment')->name('payment');
      Route::post('/approve', 'approve')->name('approve');
      Route::post('/reject', 'reject')->name('reject');
      Route::post('/pay', 'pay')->name('pay');
      Route::get('/acceptance/{activity:id}/edit', 'edit')->name('acceptance.edit');
      Route::put('/acceptance/{activity:id}', 'audit')->name('audit');
    });
    Route::post('/activity/accepted/export/excel', 'exportExcel')->name('export.excel.accepted');
  });
});