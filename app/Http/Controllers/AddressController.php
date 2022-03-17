<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Http\Requests\StoreAddressRequest;
use App\Http\Requests\UpdateAddressRequest;
use App\Models\AddressType;
use App\Models\Area;
use App\Models\PoolType;
use App\Models\Province;

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
			'title' => 'Addresses'
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
		//
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
			'title' => 'Update Address'
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
		//
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
}