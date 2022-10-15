<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateActivityRequest extends FormRequest
{
  public function authorize()
  {
    return true;
  }

  protected function prepareForValidation()
  {
    $this->merge([
      'bbm_amount' => convertMoneyInt($this->get('bbm_amount')),
      'toll_amount' => convertMoneyInt($this->get('toll_amount')),
      'parking_amount' => convertMoneyInt($this->get('parking_amount')),
      'maintenance_amount' =>  convertMoneyInt($this->get('maintenance_amount')),
      'load_amount' =>  convertMoneyInt($this->get('load_amount')),
      'unload_amount' =>  convertMoneyInt($this->get('unload_amount')),
    ]);
  }


  public function rules()
  {
    return [
      'user_id' => 'required|integer',
      'vehicle_id' => 'required|integer',
      'project_id' => 'required|integer',
      'departure_location_id' => 'required|integer|different:arrival_location_id',
      'arrival_location_id' => 'required|integer|different:departure_location_id',
      'do_date' => 'required|date',
      'do_number' => 'required|string',
      'do_image' => 'nullable|image|mimes:png,jpg,jpeg',
      'departure_date' => 'required|date',
      'departure_odo' => 'required|integer',
      'departure_odo_image' => 'nullable|image|mimes:png,jpg,jpeg',
      'arrival_date' => 'date',
      'arrival_odo' => 'integer|gt:departure_odo',
      'arrival_odo_image' => 'nullable|image|mimes:png,jpg,jpeg',
      'bbm_amount' => 'nullable|min:0',
      'toll_amount' => 'nullable|min:0',
      'maintenance_amount' => 'nullable|min:0',
      'load_amount' => 'nullable|min:0',
      'unload_amount' => 'nullable|min:0',
      'parking_amount' => 'nullable|min:0',
      'bbm_image' => 'nullable|prohibited_if:bbm_amount, 0|image|mimes:png,jpg,jpeg',
      'toll_image' => 'nullable|prohibited_if:toll_amount, 0|image|mimes:png,jpg,jpeg',
      'parking_image' => 'nullable|prohibited_if:parking_amount, 0|image|mimes:png,jpg,jpeg',
      'status' => 'required|string',
      'type' => 'required|string',
    ];
  }
}