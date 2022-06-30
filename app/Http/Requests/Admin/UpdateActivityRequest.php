<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateActivityRequest extends FormRequest
{
  public function authorize()
  {
    return true;
  }

  public function getValidatorInstance()
  {
    $this->formatMoneyTable();

    return parent::getValidatorInstance();
  }

  protected function formatMoneyTable()
  {
    $this->merge([
      'bbm_amount' => convertMoneyInt($this->request->get('bbm_amount')),
      'toll_amount' => convertMoneyInt($this->request->get('toll_amount')),
      'parking_amount' => convertMoneyInt($this->request->get('parking_amount')),
      'retribution_amount' =>  convertMoneyInt($this->request->get('retribution_amount')),
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
      'arrival_date' => 'required|date',
      'arrival_odo' => 'required|integer|gt:departure_odo',
      'arrival_odo_image' => 'nullable|image|mimes:png,jpg,jpeg',
      'bbm_amount' => 'nullable|integer|min:0',
      'toll_amount' => 'nullable|integer|min:0',
      'retribution_amount' => 'nullable|integer|min:0',
      'parking_amount' => 'nullable|min:0',
      'bbm_image' => 'nullable|prohibited_if:bbm_amount, 0|image|mimes:png,jpg,jpeg',
      'toll_image' => 'nullable|prohibited_if:toll_amount, 0|image|mimes:png,jpg,jpeg',
      'retribution_image' => 'nullable|prohibited_if:retribution_amount, 0|image|mimes:png,jpg,jpeg',
      'parking_image' => 'nullable|prohibited_if:parking_amount, 0|image|mimes:png,jpg,jpeg',
      'status' => 'required|string',
      'type' => 'required|string',
    ];
  }
}