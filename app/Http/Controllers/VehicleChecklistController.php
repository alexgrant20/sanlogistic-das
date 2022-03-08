<?php

namespace App\Http\Controllers;

use App\Models\VehicleChecklist;
use App\Http\Requests\StoreVehicleChecklistRequest;
use App\Http\Requests\UpdateVehicleChecklistRequest;

class VehicleChecklistController extends Controller
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
     * @param  \App\Http\Requests\StoreVehicleChecklistRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreVehicleChecklistRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\VehicleChecklist  $vehicleChecklist
     * @return \Illuminate\Http\Response
     */
    public function show(VehicleChecklist $vehicleChecklist)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\VehicleChecklist  $vehicleChecklist
     * @return \Illuminate\Http\Response
     */
    public function edit(VehicleChecklist $vehicleChecklist)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateVehicleChecklistRequest  $request
     * @param  \App\Models\VehicleChecklist  $vehicleChecklist
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateVehicleChecklistRequest $request, VehicleChecklist $vehicleChecklist)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\VehicleChecklist  $vehicleChecklist
     * @return \Illuminate\Http\Response
     */
    public function destroy(VehicleChecklist $vehicleChecklist)
    {
        //
    }
}
