<?php

namespace App\Http\Requests\Driver;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateActivityRequest extends FormRequest
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

  // Too return json error
  // protected function failedValidation(Validator $validator)
  // {
  //   throw new HttpResponseException(response()->json($validator->errors(), 422));
  // }

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
      'parking_amount' => convertMoneyInt($this->request->get('parking_amount'))
    ]);
  }

  public function rules()
  {
    return [
      'arrival_id' => 'required|integer',
      'arrival_odo' => 'required|integer',
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