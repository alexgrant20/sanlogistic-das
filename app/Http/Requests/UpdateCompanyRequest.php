<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCompanyRequest extends FormRequest
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
      'address_id' => 'required|integer',
      'company_type_id' => 'required|integer',
      'name' => "required|string|unique:companies,name,{$this->company->id}",
      'phone_number' => 'required|integer',
      'email' => 'required|email:dns',
      'website' => 'nullable|url',
      'director' => 'required|string',
      'npwp' => 'required|integer',
      'fax' => 'nullable|integer',
      'siup_image' => 'nullable|image',
      'siup' => 'required|string',
      'siup_expire' => 'required|date',
      'sipa' => 'required|string',
      'sipa_expire' => 'required|date',
      'sipa_image' => 'nullable|image',
      'note' => 'nullable|string'
    ];
  }
}