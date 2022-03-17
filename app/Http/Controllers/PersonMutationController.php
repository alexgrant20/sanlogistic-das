<?php

namespace App\Http\Controllers;

use App\Models\PersonMutation;
use App\Http\Requests\StorePersonMutationRequest;
use App\Http\Requests\UpdatePersonMutationRequest;

class PersonMutationController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		//
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \App\Http\Requests\StorePersonMutationRequest  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(StorePersonMutationRequest $request)
	{
		//
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\Models\PersonMutation  $personMutation
	 * @return \Illuminate\Http\Response
	 */
	public function show(PersonMutation $personMutation)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\Models\PersonMutation  $personMutation
	 * @return \Illuminate\Http\Response
	 */
	public function edit(PersonMutation $personMutation)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \App\Http\Requests\UpdatePersonMutationRequest  $request
	 * @param  \App\Models\PersonMutation  $personMutation
	 * @return \Illuminate\Http\Response
	 */
	public function update(UpdatePersonMutationRequest $request, PersonMutation $personMutation)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Models\PersonMutation  $personMutation
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(PersonMutation $personMutation)
	{
		//
	}
}