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
      'retribution_amount' =>  convertMoneyInt($this->get('retribution_amount')),
    ]);
  }

  public function rules()
  {
    return [
      'bbm_amount' => 'nullable',
      'toll_amount' => 'nullable',
      'retribution_amount' => 'nullable',
      'parking_amount' => 'nullable',
    ];
  }
}