<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Exports\VehicleExport;
use Exception;
use App\Models\Area;
use App\Models\Address;
use App\Models\Company;
use App\Models\Project;
use App\Models\Vehicle;
use App\Models\VehicleBrand;
use App\Models\VehicleImage;
use App\Models\VehicleTowing;
use App\Models\VehicleDocument;
use App\Models\VehicleType;
use App\Models\VehicleVariety;
use Illuminate\Support\Facades\DB;
use App\Models\VehicleLicensePlateColor;
use App\Http\Requests\StoreVehicleRequest;
use App\Http\Requests\UpdateVehicleRequest;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\VehicleImport;

class VehicleController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $vehicles =  Vehicle::with('owner', 'project', 'vehiclesDocuments', 'area', 'vehicleVariety', 'address', 'vehicleTowing')->latest()->get();

    $vehiclesDocuments = ['stnk', 'kir'];
    $vehiclesImages = ['front', 'left', 'right', 'back'];

    $totalVehicleImage = VehicleImage::all()->count();
    $totalVehicleDocument = VehicleDocument::all()->count();
    $totalVehicle = $vehicles->count();

    if (
      $totalVehicle * count($vehiclesDocuments) !== $totalVehicleDocument ||
      $totalVehicle * count($vehiclesImages) !== $totalVehicleImage
    ) return to_route('admin.vehicle.migrate_image');


    return view('admin.vehicles.index', [
      'vehicles' => $vehicles,
      'title' => 'Vehicles',
      'importPath' => '/admin/vehicles/import/excel',
    ]);
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    return view('admin.vehicles.create', [
      'vehiclesBrands' => VehicleBrand::all(),
      'areas' => Area::all(),
      'projects' => Project::all(),
      'companies' => Company::all(),
      'addresses' => Address::all(),
      'vehiclesTowings' => VehicleTowing::all(),
      'vehiclesLPColors' => VehicleLicensePlateColor::all(),
      'title' => 'Create Vehicle',
    ]);
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \App\Http\Requests\StoreVehicleRequest  $request
   * @return \Illuminate\Http\Response
   */
  public function store(StoreVehicleRequest $request)
  {

    try {
      // Init Configuration
      $otherTable = [
        'kir_number',
        'kir_expire',
        'kir_image',
        'stnk_number',
        'stnk_expire',
        'stnk_image',
        'front_image',
        'left_image',
        'right_image',
        'back_image',
      ];
      $timestamp = now()->timestamp;
      $documents = ['kir', 'stnk'];
      $images = ['front', 'left', 'right', 'back'];
      $imagesQuery = [];
      $documentsQuery = [];

      DB::beginTransaction();

      $newVehicle = Vehicle::create($request->safe()->except($otherTable));
      $vehicleID = $newVehicle['id'];
      $vehicleLP = str_replace(' ', '', $newVehicle['license_plate']);

      foreach ($documents as $doc) {

        if ($request->file("{$doc}_image")) {
          $fileName = "{$doc}-{$vehicleLP}-{$timestamp}.{$request->file("{$doc}_image")->extension()}";
          $imagePath = $request->file("{$doc}_image")->storeAs("{$doc}-images", $fileName, 'public');
        }

        array_push($documentsQuery, [
          'vehicle_id' => $vehicleID,
          'type' => $doc,
          'number' => $request["${doc}_number"],
          'image' => $imagePath,
          'expire' => $request["${doc}_expire"],
          'active' => $request["{$doc}_expire"] > now() ? 1 : 0,
        ]);
      }

      foreach ($images as $img) {

        if ($request->file("{$img}_image")) {
          $fileName = "{$img}-{$vehicleLP}-{$timestamp}.{$request->file("{$img}_image")->extension()}";
          $imagePath = $request->file("{$img}_image")->storeAs("{$img}-images", $fileName, 'public');
        }

        array_push($imagesQuery, [
          'vehicle_id' => $vehicleID,
          'type' => $img,
          'image' => $imagePath,
        ]);
      }

      VehicleDocument::insert($documentsQuery);
      VehicleImage::insert($imagesQuery);

      DB::commit();

      $notification = array(
        'message' => 'Vehicle successfully created!',
        'alert-type' => 'success',
      );

      return to_route('admin.vehicle.index')->with($notification);
    } catch (Exception $e) {
      DB::rollback();
      $notification = array(
        'message' => 'Vehicle failed to create!',
        'alert-type' => 'error',
      );
      return to_route('admin.vehicle.create')->withInput()->with($notification);
    }
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\Vehicle  $vehicle
   * @return \Illuminate\Http\Response
   */
  public function show(Vehicle $vehicle)
  {
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Models\Vehicle  $vehicle
   * @return \Illuminate\Http\Response
   */
  public function edit(Vehicle $vehicle)
  {
    $kir = $vehicle->vehiclesDocuments->where('type', 'kir')->first();
    $stnk = $vehicle->vehiclesDocuments->where('type', 'stnk')->first();
    $front = $vehicle->vehicleImages->where('type', 'front')->first();
    $back = $vehicle->vehicleImages->where('type', 'back')->first();
    $left = $vehicle->vehicleImages->where('type', 'left')->first();
    $right = $vehicle->vehicleImages->where('type', 'right')->first();

    return view('admin.vehicles.edit', [
      'vehiclesBrands' => VehicleBrand::all(),
      'areas' => Area::all(),
      'projects' => Project::all(),
      'companies' => Company::all(),
      'addresses' => Address::all(),
      'vehiclesTowings' => VehicleTowing::all(),
      'vehiclesLPColors' => VehicleLicensePlateColor::all(),
      'vehicle' => $vehicle,
      'stnk' => is_null($stnk) ? [] : $stnk,
      'kir' => is_null($kir) ? [] : $kir,
      'front' => $front,
      'back' => $back,
      'left' => $left,
      'right' => $right,
      'title' => "Update Vehicle {$vehicle->license_plate}"
    ]);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \App\Http\Requests\UpdateVehicleRequest  $request
   * @param  \App\Models\Vehicle  $vehicle
   * @return \Illuminate\Http\Response
   */
  public function update(UpdateVehicleRequest $request, Vehicle $vehicle)
  {
    try {
      // Init Configuration
      $otherTable = [
        'kir_number',
        'kir_expire',
        'kir_image',
        'stnk_number',
        'stnk_expire',
        'stnk_image',
        'front_image',
        'left_image',
        'right_image',
        'back_image',
        'vehicle_type_id',
        'vehicle_brand_id'
      ];
      $timestamp = now()->timestamp;
      $documents = ['kir', 'stnk'];
      $images = ['front', 'left', 'right', 'back'];


      $vehicleLP = str_replace(' ', '', $request->license_plate);

      DB::beginTransaction();

      $vehicle->update($request->safe()->except($otherTable));

      foreach ($documents as $doc) {

        $document = $vehicle->vehiclesDocuments->where('type', $doc)->first();
        $imagePath = $document->image;

        if ($request->file("{$doc}_image")) {
          $fileName = "{$doc}-{$vehicleLP}-{$timestamp}.{$request->file("{$doc}_image")->extension()}";
          $imagePath = $request->file("{$doc}_image")->storeAs("{$doc}-images", $fileName, 'public');
        }

        $document->update([
          'number' => $request["${doc}_number"],
          'image' => $imagePath,
          'expire' => $request["${doc}_expire"],
          'active' => $request["{$doc}_expire"] > now() ? 1 : 0,
        ]);
      }

      foreach ($images as $imgType) {

        $vehicleImage = $vehicle->vehicleImages->where('type', $imgType)->first();
        $imagePath = $vehicleImage->image;

        if ($request->file("{$imgType}_image")) {
          $fileName = "{$imgType}-{$vehicleLP}-{$timestamp}.{$request->file("{$imgType}_image")->extension()}";
          $imagePath = $request->file("{$imgType}_image")->storeAs("{$imgType}-images", $fileName, 'public');
        }

        $vehicleImage->update([
          'image' => $imagePath,
        ]);
      }

      DB::commit();

      $notification = array(
        'message' => 'Vehicle successfully updated!',
        'alert-type' => 'success',
      );

      return to_route('admin.vehicle.index')->with($notification);
    } catch (Exception $e) {

      DB::rollback();

      $notification = array(
        'message' => 'Vehicle failed to create!',
        'alert-type' => 'error',
      );
      return redirect("/admin/vehicles/{$vehicle->license_plate}/edit")->withInput()->with($notification);
    }
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\Vehicle  $vehicle
   * @return \Illuminate\Http\Response
   */
  public function destroy(Vehicle $vehicle)
  {
    //
  }

  public function migrateImage()
  {
    try {
      $vehicles = Vehicle::with('vehicleImages', 'vehiclesDocuments')->get();
      $totalVehicles = $vehicles->count();
      $vehiclesDocuments = VehicleDocument::all();
      $vehiclesImages = VehicleImage::all();

      $documentsTypes = ['kir', 'stnk'];
      $imgTypes = ['front', 'left', 'right', 'back'];
      $totalDocType = count($documentsTypes);
      $totalImgType = count($imgTypes);
      $docNeedMigrate = true;
      $imgNeedMigrate = true;
      $queryImages = [];
      $queryDocuments = [];

      // Vehicles Document Full
      if ($totalVehicles * $totalDocType === $vehiclesDocuments->count()) {
        $docNeedMigrate = false;
      }

      // Vehicles Images Full
      if ($totalVehicles * $totalImgType === $vehiclesImages->count()) {
        $imgNeedMigrate = false;
      }

      $notification = array(
        'message' => 'Migration is not needed!',
        'alert-type' => 'warning',
      );


      if (!$imgNeedMigrate && !$docNeedMigrate) {
        return to_route('admin.vehicle.index')->with($notification);
      }

      foreach ($vehicles as $vehicle) {

        if ($docNeedMigrate) {
          foreach ($documentsTypes as $docType) {
            if (!$vehicle->vehiclesDocuments->contains('type', $docType)) {
              array_push($queryDocuments, [
                'vehicle_id' => $vehicle->id,
                'type' => $docType,
                'number' => 0,
                'image' => env('DEFAULT_IMAGE'),
                'expire' => now(),
                'active' => 0,
              ]);
            }
          }
        }

        if ($imgNeedMigrate) {
          foreach ($imgTypes as $imgType) {
            if (!$vehicle->vehicleImages->contains('type', $imgType)) {
              array_push($queryImages, [
                'vehicle_id' => $vehicle->id,
                'type' => $imgType,
                'image' => env('DEFAULT_IMAGE'),
              ]);
            }
          }
        }
      }

      DB::beginTransaction();


      if ($docNeedMigrate) {
        VehicleDocument::insert($queryDocuments);
      }

      if ($imgNeedMigrate) {
        VehicleImage::insert($queryImages);
      }

      DB::commit();

      $notification = array(
        'message' => 'Vehicle image successfully migrated!',
        'alert-type' => 'success',
      );

      return to_route('admin.vehicle.index')->with($notification);
    } catch (Exception $e) {
      DB::rollBack();

      $notification = array(
        'message' => 'Vehicle image failed to migrate!',
        'alert-type' => 'error',
      );
      return to_route('admin.vehicle.index')->with($notification);
    }
  }

  public function exportExcel(Request $request)
  {
    $timestamp = now()->timestamp;
    $params = $request->input('ids');
    $ids = preg_split("/[,]/", $params);
    return Excel::download(new VehicleExport($ids), "vehicles_export_{$timestamp}.xlsx");
  }

  public function importExcel(Request $request)
  {
    try {
      $request->validate([
        'file' => 'required|mimes:csv,xls,xlsx'
      ]);

      $file = $request->file('file')->store('file-import/vehicle/');

      $import = new VehicleImport;
      $import->import($file);

      if ($import->failures()->isNotEmpty()) {
        return back()->with('importErrorList', $import->failures());
      }

      $notification = array(
        'message' => 'Vehicle successfully imported!',
        'alert-type' => 'success',
      );

      return to_route('admin.vehicle.index')->with($notification);
    } catch (Exception $e) {

      $notification = array(
        'message' => 'Vehicle failed to import!',
        'alert-type' => 'error',
      );

      return to_route('admin.vehicle.index')->with($notification);
    }
  }

  // Api Route
  public function vehicleType($id)
  {
    $data = VehicleType::where('vehicle_brand_id', $id)->get();
    return response()->json($data);
  }

  public function vehicleVariety($id)
  {
    $data = VehicleVariety::where('vehicle_type_id', $id)->get();
    return response()->json($data);
  }
}
