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
use App\Http\Requests\Admin\StoreVehicleRequest;
use App\Http\Requests\Admin\UpdateVehicleRequest;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\VehicleImport;
use App\Transaction\Constants\NotifactionTypeConstant;
use App\Transaction\Constants\VehicleDTConstant;

class VehicleController extends Controller
{
  public function __construct()
  {
    $this->middleware('can:vehicle-create', ['only' => ['create', 'store']]);
    $this->middleware('can:vehicle-edit', ['only' => ['edit', 'update']]);
    $this->middleware('can:vehicle-view', ['only' => ['index']]);
  }

  public function index()
  {
    $vehicles = DB::table('vehicles')
      ->leftJoin('companies', 'vehicles.owner_id', '=', 'companies.id')
      ->leftJoin('projects', 'vehicles.project_id', '=', 'projects.id')
      ->leftJoin('areas', 'vehicles.area_id', '=', 'areas.id')
      ->leftJoin('vehicle_varieties', 'vehicles.vehicle_variety_id', '=', 'vehicle_varieties.id')
      ->leftJoin('vehicle_types', 'vehicle_varieties.vehicle_type_id', '=', 'vehicle_types.id')
      ->leftJoin('vehicle_brands', 'vehicle_types.vehicle_brand_id', '=', 'vehicle_brands.id')
      ->leftJoin('addresses', 'vehicles.address_id', '=', 'addresses.id')
      ->leftJoin('vehicle_towings', 'vehicles.vehicle_towing_id', '=', 'vehicle_towings.id')
      ->leftJoin('vehicle_last_statuses AS vls', 'vehicles.id', '=', 'vls.vehicle_id')
      ->leftJoin('vehicle_documents AS kir', function ($join) {
        $join->on('kir.vehicle_id', '=', 'vehicles.id');
        $join->where('kir.type', '=', 'kir');
      })
      ->leftJoin('vehicle_documents AS stnk', function ($join) {
        $join->on('stnk.vehicle_id', '=', 'vehicles.id');
        $join->where('stnk.type', '=', 'stnk');
      })
      ->get([
        'vehicles.id',
        'license_plate',
        'vehicle_license_plate_color_id',
        'companies.name AS company_name',
        'projects.name AS project_name',
        'vehicles.status AS status',
        'vehicle_brands.name AS vehicle_brand',
        'vehicle_types.name AS vehicle_type',
        'vehicles.odo',
        'kir.expire AS kir_expire',
        'stnk.expire AS stnk_expire',
        'vls.id AS vehicle_last_status_id',
      ]);

    return view('admin.vehicles.index', [
      'vehicles' => $vehicles,
      'title' => 'Vehicles',
      'importPath' => '/admin/vehicles/import/excel',
    ]);
  }

  public function create()
  {
    return view('admin.vehicles.create', [
      'vehicle' => new Vehicle(),
      'vehiclesBrands' => VehicleBrand::orderBy('name')->get(),
      'areas' => Area::orderBy('name')->get(),
      'projects' => Project::orderBy('name')->get(),
      'companies' => Company::orderBy('name')->get(),
      'addresses' => Address::orderBy('name')->get(),
      'vehiclesTowings' => VehicleTowing::orderBy('name')->get(),
      'vehiclesLPColors' => VehicleLicensePlateColor::orderBy('name')->get(),
      'title' => 'Create Vehicle',
    ]);
  }

  public function store(StoreVehicleRequest $request)
  {
    $timestamp = now()->timestamp;
    $imagesQuery = [];
    $documentsQuery = [];

    DB::beginTransaction();
    try {

      $vehicle = Vehicle::create($request->safe()->except(VehicleDTConstant::DOCUMENT_TYPE_INPUT));
      $vehicleLP = str_replace(' ', '', $vehicle->license_plate);

      foreach (VehicleDTConstant::DOCUMENT_TYPE as $docType) {
        $imageKey = "{$docType}_image";
        $imagePath = $request->hasFile($imageKey)
          ? uploadImage($request->file($imageKey), $docType, $vehicleLP, $timestamp)
          : "";

        array_push($documentsQuery, [
          'vehicle_id' => $vehicle->id,
          'type' => $docType,
          'number' => $request->get("{$docType}_number"),
          'image' => $imagePath,
          'expire' => $request->get("{$docType}_expire"),
          'active' => $request->get("{$docType}_expire") > now() ? 1 : 0,
        ]);
      }

      foreach (VehicleDTConstant::IMAGE_TYPE as $img) {

        $imageKey = "{$img}_image";
        $imagePath = $request->hasFile($imageKey)
          ? uploadImage($request->file($imageKey), $img, $vehicleLP, $timestamp)
          : "";

        array_push($imagesQuery, [
          'vehicle_id' => $vehicle->id,
          'type' => $img,
          'image' => $imagePath,
        ]);
      }
      VehicleDocument::insert($documentsQuery);
      VehicleImage::insert($imagesQuery);
    } catch (Exception $e) {
      DB::rollback();

      return back()->withInput()->with(genereateNotifaction(NotifactionTypeConstant::ERROR, 'vehicle', 'create'));
    }

    DB::commit();

    return to_route('admin.vehicles.index')->with(genereateNotifaction(NotifactionTypeConstant::SUCCESS, 'vehicle', 'created'));
  }

  public function edit(Vehicle $vehicle)
  {
    $vehicle->loadMissing('vehiclesDocuments', 'vehicleImages');

    $vehicleDocuments = $vehicle->vehiclesDocuments->mapWithKeys(function ($vehicleDocument) {
      return [$vehicleDocument->type => $vehicleDocument];
    });
    $vehicleImages = $vehicle->vehicleImages->pluck('image', 'type');

    return view('admin.vehicles.edit', [
      'vehiclesBrands' => VehicleBrand::orderBy('name')->get(),
      'areas' => Area::orderBy('name')->get(),
      'projects' => Project::orderBy('name')->get(),
      'companies' => Company::orderBy('name')->get(),
      'addresses' => Address::orderBy('name')->get(),
      'vehiclesTowings' => VehicleTowing::orderBy('name')->get(),
      'vehiclesLPColors' => VehicleLicensePlateColor::orderBy('name')->get(),
      'vehicle' => $vehicle,
      'vehicleDocuments' => $vehicleDocuments,
      'vehicleImages' => $vehicleImages,
      'title' => "Update Vehicle {$vehicle->license_plate}"
    ]);
  }

  public function update(UpdateVehicleRequest $request, Vehicle $vehicle)
  {
    $timestamp = now()->timestamp;
    $vehicleLP = str_replace(' ', '', $request->license_plate);
    $documents = collect($vehicle->vehiclesDocuments->all());
    $images = collect($vehicle->vehicleImages->all());

    DB::beginTransaction();

    try {
      $vehicle->update($request->safe()->except(VehicleDTConstant::DOCUMENT_TYPE_INPUT));

      foreach (VehicleDTConstant::DOCUMENT_TYPE as $docType) {
        $document = $documents->firstWhere('type', $docType);

        $imageKey = "{$docType}_image";
        $imagePath = $request->hasFile($imageKey)
          ? uploadImage($request->file($imageKey), $docType, $vehicleLP, $timestamp)
          : $document->image ?? null;

        VehicleDocument::updateOrCreate(
          [
            'id' => $document->id ?? null,
            'vehicle_id' => $vehicle->id,
            'type' => $docType,
          ],
          [
            'number' => $request->get("{$docType}_number"),
            'expire' => $request->get("{$docType}_expire"),
            'active' => $request->get("{$docType}_expire") > now() ? 1 : 0,
            'image' => $imagePath,
          ]
        );
      }

      foreach (VehicleDTConstant::IMAGE_TYPE as $imgType) {
        $imageOld = $images->firstWhere('type', $imgType);

        $imageKey = "{$imgType}_image";
        $imagePath = $request->hasFile($imageKey)
          ? uploadImage($request->file($imageKey), $imgType, $vehicleLP, $timestamp)
          : $imageOld->image ?? null;

        VehicleImage::updateOrCreate(
          [
            'id' => $imageOld->id ?? null,
            'vehicle_id' => $vehicle->id,
            'type' => $imgType,
          ],
          [
            'image' => $imagePath
          ]
        );
      }
    } catch (Exception $e) {

      dd($e->getMessage());
      DB::rollback();

      return back()->withInput()->with(genereateNotifaction(NotifactionTypeConstant::ERROR, 'vehicle', 'updated'));
    }

    DB::commit();

    return to_route('admin.vehicles.index')->with(genereateNotifaction(NotifactionTypeConstant::SUCCESS, 'vehicle', 'updated'));
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
    $request->validate([
      'file' => 'required|mimes:csv,xls,xlsx'
    ]);
    $import = new VehicleImport;

    try {
      $file = $request->file('file')->store('file-import/vehicle/');
      $import->import($file);
    } catch (Exception $e) {
      return to_route('admin.vehicles.index')->with(genereateNotifaction(NotifactionTypeConstant::ERROR, 'vehicle', 'import'));
    }

    if ($import->failures()->isNotEmpty()) {
      return back()->with('importErrorList', $import->failures());
    }

    return to_route('admin.vehicles.index')->with(genereateNotifaction(NotifactionTypeConstant::SUCCESS, 'vehicle', 'imported'));
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
