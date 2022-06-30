<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateVehicleRequest extends FormRequest
{
  public function authorize()
  {
    return true;
  }

  public function rules()
  {
    return [
      'project_id' => 'required|integer',
      'area_id'  => 'required|integer',
      'vehicle_variety_id' => 'required|integer',
      'vehicle_type_id' => 'required|integer',
      'vehicle_brand_id' => 'required|integer',
      'address_id' => 'required|integer',
      'owner_id' => 'required|integer',
      'vehicle_towing_id' => 'required|integer',
      'license_plate' => "required|string|unique:vehicles,license_plate,{$this->vehicle->id}",
      'vehicle_license_plate_color_id' => 'required|integer',
      'frame_number' => 'required|string',
      'registration_number' => 'required|string',
      'engine_number' => 'required|string',
      'modification' => 'required|string',
      'internal_code' => 'required|string',
      'capacity' => 'required|string',
      'wheel' => 'required|integer',
      'odo' => 'required|integer',
      'registration_year' => 'required|regex:/^[1-2][0-9]{3}/',
      'note' => 'nullable|string',
      'kir_number' => 'required|string',
      'kir_expire' => 'required|date',
      'kir_image' => 'nullable|image|mimes:png,jpg,jpeg',
      'stnk_number' => 'required|string',
      'stnk_expire' => 'required|date',
      'stnk_image' => 'nullable|image|mimes:png,jpg,jpeg',
      'front_image' => 'nullable|image|mimes:png,jpg,jpeg',
      'left_image' => 'nullable|image|mimes:png,jpg,jpeg',
      'right_image' => 'nullable|image|mimes:png,jpg,jpeg',
      'back_image' => 'nullable|image|mimes:png,jpg,jpeg',
    ];
  }
}