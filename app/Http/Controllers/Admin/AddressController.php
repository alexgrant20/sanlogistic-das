<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Exports\AddressExport;
use App\Models\Address;
use App\Http\Requests\Admin\StoreAddressRequest;
use App\Http\Requests\Admin\UpdateAddressRequest;
use App\Imports\AddressImport;
use App\Models\AddressType;
use App\Models\Area;
use App\Models\PoolType;
use App\Models\Province;
use App\Models\City;
use App\Models\District;
use App\Models\Subdistrict;
use App\Transaction\Constants\NotifactionTypeConstant;
use Exception;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class AddressController extends Controller
{

  public function index(Request $request)
  {
    if ($request->user()->cannot('viewAny', Address::class)) {
      abort(404);
    }

    # QB
    $addresses = DB::table('addresses')
      ->leftJoin('address_types', 'addresses.address_type_id', '=', 'address_types.id')
      ->leftJoin('subdistricts', 'addresses.subdistrict_id', '=', 'subdistricts.id')
      ->leftJoin('districts', 'subdistricts.district_id', '=', 'districts.id')
      ->leftJoin('cities', 'districts.city_id', '=', 'cities.id')
      ->leftJoin('provinces', 'cities.province_id', '=', 'provinces.id')
      ->orderByDesc('addresses.created_at')
      ->get(
        [
          'addresses.id',
          'addresses.name',
          'addresses.full_address',
          'subdistricts.name AS subdistrict_name',
          'districts.name AS district_name',
          'address_types.name AS address_types_name',
          'cities.name AS cities_name',
          'provinces.name AS provinces_name'
        ]
      );

    return view('admin.addresses.index', [
      'addresses' => $addresses,
      'title' => 'Addresses',
      'importPath' => '/admin/addresses/import/excel',
    ]);
  }

  public function create(Request $request)
  {
    if ($request->user()->cannot('create', Address::class)) {
      abort(403);
    }

    return view('admin.addresses.create', [
      'title' => 'Create Address',
      'address' => new Address(),
      'areas' => Area::orderBy('name')->get(),
      'pool_types' => PoolType::orderBy('name')->get(),
      'address_types' => AddressType::orderBy('name')->get(),
      'provinces' => Province::orderBy('name')->get(),
    ]);
  }

  public function store(StoreAddressRequest $request)
  {
    $addressPayload = $request->safe()->toArray();

    Address::create($addressPayload);

    return to_route('admin.address.index')
      ->with(genereateNotifaction(NotifactionTypeConstant::SUCCESS, 'activity', 'created'));
  }

  public function edit(Address $address)
  {
    return view('admin.addresses.edit', [
      'title' => 'Update Address',
      'address' => $address,
      'areas' => Area::orderBy('name')->get(),
      'pool_types' => PoolType::orderBy('name')->get(),
      'address_types' => AddressType::orderBy('name')->get(),
      'provinces' => Province::orderBy('name')->get(),
    ]);
  }

  public function update(UpdateAddressRequest $request, Address $address)
  {
    $address->update($request->safe()->toArray());

    return to_route('admin.address.index')
      ->with(genereateNotifaction(NotifactionTypeConstant::SUCCESS, 'address', 'created'));
  }

  public function city($id)
  {
    $data = City::where('province_id', $id)->orderBy('name')->get();
    return response()->json($data);
  }

  public function district($id)
  {
    $data = District::where('city_id', $id)->orderBy('name')->get();
    return response()->json($data);
  }

  public function subDistrict($id)
  {
    $data = Subdistrict::where('district_id', $id)->orderBy('name')->get();
    return response()->json($data);
  }

  public function location()
  {
    $data = Address::whereNotNull('latitude')
      ->whereNotNull('longitude')
      ->get(['name', 'latitude', 'longitude']);

    return response()->json($data->toArray());
  }

  public function importExcel(Request $request)
  {
    $request->validate([
      'file' => 'required|mimes:csv,xls,xlsx'
    ]);
    $import = new AddressImport;

    try {
      $file = $request->file('file')->store('file-import/address/');
      $import->import($file);
    } catch (Exception $e) {
      return to_route('admin.address.index')
        ->with(genereateNotifaction(NotifactionTypeConstant::ERROR, 'address', 'import'));
    }

    if ($import->failures()->isNotEmpty()) {
      return back()->with('importErrorList', $import->failures());
    }

    return to_route('admin.address.index')
      ->with(genereateNotifaction(NotifactionTypeConstant::ERROR, 'address', 'imported'));
  }

  public function exportExcel(Request $request)
  {
    $timestamp = now()->timestamp;
    $params = $request->input('ids');
    $ids = preg_split("/[,]/", $params);
    return Excel::download(new AddressExport($ids), "addresses_export_{$timestamp}.xlsx");
  }
}