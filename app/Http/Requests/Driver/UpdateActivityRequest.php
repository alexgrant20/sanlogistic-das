<?php

namespace App\Http\Requests\Driver;

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
      'bbm_amount' => (int) convertMoneyInt($this->get('bbm_amount')),
      'toll_amount' => (int) convertMoneyInt($this->get('toll_amount')),
      'parking_amount' => (int) convertMoneyInt($this->get('parking_amount'))
    ]);
  }

  public function rules()
  {
    return [
      'arrival_location_id' => 'required|integer',
      'arrival_odo' => 'required|integer|gt:' . $this->activity->departure_odo . '|lt:' . $this->activity->departure_odo + 800,
      'arrival_odo_image' => 'required|image|mimes:png,jpg,jpeg',
      'bbm_amount' => 'nullable|integer',
      'toll_amount' => 'nullable|integer',
      'parking_amount' => 'nullable|integer',
      'bbm_image' => 'required_unless:bbm_amount,0|prohibited_if:bbm_amount, 0|image|mimes:png,jpg,jpeg',
      'toll_image' => 'required_unless:toll_amount,0|prohibited_if:toll_amount, 0|image|mimes:png,jpg,jpeg',
      'parking_image' => 'required_unless:parking_amount,0|prohibited_if:parking_amount, 0|image|mimes:png,jpg,jpeg',
    ];
  }
}
