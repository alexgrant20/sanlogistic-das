<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Exports\AddressExport;
use App\Models\Address;
use App\Http\Requests\StoreAddressRequest;
use App\Http\Requests\UpdateAddressRequest;
use App\Imports\AddressImport;
use App\Models\AddressType;
use App\Models\Area;
use App\Models\PoolType;
use App\Models\Province;
use App\Models\City;
use App\Models\District;
use App\Models\Subdistrict;
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

    return view('admin.addresses.index', [
      'addresses' => Address::with([
        'addressType',
        'subdistrict',
        'subdistrict.district',
        'subdistrict.district.city',
        'subdistrict.district.city.province'
      ])->latest()->get(),
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
      'areas' => Area::all(),
      'pool_types' => PoolType::all(),
      'address_types' => AddressType::all(),
      'provinces' => Province::all()->sortBy('name'),
    ]);
  }

  public function store(StoreAddressRequest $request)
  {
    try {

      DB::beginTransaction();

      Address::create($request->safe()->except(['province_id', 'city_id', 'district_id']));

      DB::commit();

      $notification = array(
        'message' => 'Address has been created!',
        'alert-type' => 'success',
      );

      return to_route('admin.address.index')->with($notification);
    } catch (Exception $e) {
      DB::rollBack();

      $notification = array(
        'message' => 'Address failed to create!',
        'alert-type' => 'error',
      );

      return to_route('admin.address.create')->withInput()->with('error', $e->getMessage());
    }
  }

  public function edit(Address $address)
  {
    return view('admin.addresses.edit', [
      'title' => 'Update Address',
      'address' => $address,
      'areas' => Area::all(),
      'pool_types' => PoolType::all(),
      'address_types' => AddressType::all(),
      'provinces' => Province::all(),
    ]);
  }

  public function update(UpdateAddressRequest $request, Address $address)
  {
    try {

      DB::beginTransaction();

      $address->update($request->safe()->except(['province_id', 'city_id', 'district_id']));

      DB::commit();

      $notification = array(
        'message' => 'Address has been updated!',
        'alert-type' => 'success',
      );

      return to_route('admin.address.index')->with($notification);
    } catch (Exception $e) {
      DB::rollBack();

      $notification = array(
        'message' => 'Address failed to update!',
        'alert-type' => 'error',
      );

      return redirect("/admin/addresses/{$address->id}/edit")->withInput()->with($notification);
    }
  }

  public function destroy(Address $address)
  {
    //
  }

  public function city($id)
  {
    $data = City::where('province_id', $id)->orderBy('name')->get();
    // dd($data);
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
    $data = Address::where('latitude', '!=', 'null')
      ->where('longitude', '!=', 'null')
      ->get(['name', 'latitude', 'longitude']);
    return response()->json($data->toArray());
  }

  public function importExcel(Request $request)
  {
    try {
      $request->validate([
        'file' => 'required|mimes:csv,xls,xlsx'
      ]);

      $file = $request->file('file')->store('file-import/address/');

      $import = new AddressImport;
      $import->import($file);

      if ($import->failures()->isNotEmpty()) {
        return back()->with('importErrorList', $import->failures());
      }

      $notification = array(
        'message' => 'Address has been imported!',
        'alert-type' => 'success',
      );

      return to_route('admin.address.index')->with($notification);
    } catch (Exception $e) {

      $notification = array(
        'message' => 'Address failed to import!',
        'alert-type' => 'error',
      );

      return to_route('admin.address.index')->with($notification);
    }
  }

  public function exportExcel(Request $request)
  {
    $timestamp = now()->timestamp;
    $params = $request->input('ids');
    $ids = preg_split("/[,]/", $params);
    return Excel::download(new AddressExport($ids), "addresses_export_{$timestamp}.xlsx");
  }
}