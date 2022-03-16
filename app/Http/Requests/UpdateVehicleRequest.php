<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateVehicleRequest extends FormRequest
{
  /**
   * Determine if the user is authorized to make this request.
   *
   * @return bool
   */
  public function authorize()
  {
    return true;
  }

  /**
   * Get the validation rules that apply to the request.
   *
   * @return array
   */
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
      'kir_image' => 'image',
      'stnk_number' => 'required|string',
      'stnk_expire' => 'required|date',
      'stnk_image' => 'image',
      'front_image' => 'image',
      'left_image' => 'image',
      'right_image' => 'image',
      'back_image' => 'image',
    ];
  }
}