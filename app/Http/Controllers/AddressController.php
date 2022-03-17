<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Http\Requests\StoreAddressRequest;
use App\Http\Requests\UpdateAddressRequest;
use App\Models\AddressType;
use App\Models\Area;
use App\Models\PoolType;
use App\Models\Province;
use App\Models\City;
use App\Models\District;
use App\Models\Subdistrict;
use Exception;
use Illuminate\Support\Facades\DB;

class AddressController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		return view('addresses.index', [
			'addresses' => Address::with(['addressType'])->latest()->get(),
			'title' => 'Addresses',
		]);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		return view('addresses.create', [
			'title' => 'Create Address',
			'areas' => Area::all(),
			'pool_types' => PoolType::all(),
			'address_types' => AddressType::all(),
			'provinces' => Province::all(),
		]);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \App\Http\Requests\StoreAddressRequest  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(StoreAddressRequest $request)
	{
		try {

			DB::beginTransaction();

			Address::create($request->safe()->except(['province_id', 'city_id', 'district_id']));

			DB::commit();
			return redirect('/addresses')->with('success', "New address has been added!");
		} catch (Exception $e) {
			DB::rollBack();
			return redirect('/addresses/create')->withInput()->with('error', $e->getMessage());
		}
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\Models\Address  $address
	 * @return \Illuminate\Http\Response
	 */
	public function show(Address $address)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\Models\Address  $address
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Address $address)
	{
		return view('addresses.edit', [
			'title' => 'Update Address',
			'address' => $address,
			'areas' => Area::all(),
			'pool_types' => PoolType::all(),
			'address_types' => AddressType::all(),
			'provinces' => Province::all(),
		]);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \App\Http\Requests\UpdateAddressRequest  $request
	 * @param  \App\Models\Address  $address
	 * @return \Illuminate\Http\Response
	 */
	public function update(UpdateAddressRequest $request, Address $address)
	{
		try {

			DB::beginTransaction();

			$address->update($request->safe()->except(['province_id', 'city_id', 'district_id']));

			DB::commit();
			return redirect('/addresses')->with('success', "New address has been added!");
		} catch (Exception $e) {
			DB::rollBack();
			return redirect('/addresses/create')->withInput()->with('error', $e->getMessage());
		}
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Models\Address  $address
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Address $address)
	{
		//
	}

	public function city($id)
	{
		$data = City::where('province_id', $id)->get();
		return response()->json($data);
	}

	public function district($id)
	{
		$data = District::where('city_id', $id)->get();
		return response()->json($data);
	}

	public function subDistrict($id)
	{
		$data = Subdistrict::where('district_id', $id)->get();
		return response()->json($data);
	}

	public function location()
	{
		$data = Address::all(['name', 'latitude', 'longitude']);
		return response()->json($data->toArray());
	}
}