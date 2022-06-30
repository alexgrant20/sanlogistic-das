<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateActivityCostRequest extends FormRequest
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
      'bbm_amount' => 'nullable|integer|min:0',
      'toll_amount' => 'nullable|integer|min:0',
      'retribution_amount' => 'nullable|integer|min:0',
      'parking_amount' => 'nullable|integer|min:0',
    ];
  }
}