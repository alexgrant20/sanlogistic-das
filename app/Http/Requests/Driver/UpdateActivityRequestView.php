<?php

namespace App\Http\Requests\Driver;

use Illuminate\Foundation\Http\FormRequest;

class UpdateActivityRequestView extends FormRequest
{
  public function rules()
  {
    return [
      'arrival_id' => 'required|integer',
      'arrival_odo' => 'required|integer|gt:' . $this->activity->departure_odo,
      'arrival_odo_image' => 'required|image|mimes:png,jpg,jpeg',
      'bbm_amount' => 'nullable',
      'toll_amount' => 'nullable',
      'parking_amount' => 'nullable',
      'bbm_image' => 'required_unless:bbm_amount,Rp. 0|prohibited_if:bbm_amount, Rp. 0|image|mimes:png,jpg,jpeg',
      'toll_image' => 'required_unless:toll_amount,Rp. 0|prohibited_if:toll_amount, Rp. 0|image|mimes:png,jpg,jpeg',
      'parking_image' => 'required_unless:parking_amount,Rp. 0|prohibited_if:parking_amount, Rp. 0|image|mimes:png,jpg,jpeg',
    ];
  }
}