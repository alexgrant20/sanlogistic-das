<?php

namespace App\Http\Controllers;

use App\Models\Regional;
use App\Http\Requests\StoreRegionalRequest;
use App\Http\Requests\UpdateRegionalRequest;

class RegionalController extends Controller
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
     * @param  \App\Http\Requests\StoreRegionalRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRegionalRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Regional  $regional
     * @return \Illuminate\Http\Response
     */
    public function show(Regional $regional)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Regional  $regional
     * @return \Illuminate\Http\Response
     */
    public function edit(Regional $regional)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateRegionalRequest  $request
     * @param  \App\Models\Regional  $regional
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRegionalRequest $request, Regional $regional)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Regional  $regional
     * @return \Illuminate\Http\Response
     */
    public function destroy(Regional $regional)
    {
        //
    }
}
