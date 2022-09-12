<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateActivityCostRequest extends FormRequest
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
      'bbm_amount' => 'nullable',
      'toll_amount' => 'nullable',
      'maintenance_amount' => 'nullable',
      'load_amount' => 'nullable',
      'unload_amount' => 'nullable',
      'parking_amount' => 'nullable',
    ];
  }
}