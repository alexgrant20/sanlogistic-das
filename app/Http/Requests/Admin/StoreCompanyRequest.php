<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreCompanyRequest extends FormRequest
{
  public function authorize()
  {
    return true;
  }

  public function rules()
  {
    return [
      'city_id' => 'required|integer',
      'company_type_id' => 'required|integer',
      'name' => 'required|string|unique:companies',
      'phone_number' => 'required|string',
      'email' => 'required|email:dns',
      'website' => 'nullable|url',
      'director' => 'required|string',
      'npwp' => 'required|string',
      'fax' => 'nullable|string',
      'siup_image' => 'required|image|mimes:png,jpg,jpeg',
      'siup' => 'required|string',
      'siup_expire' => 'required|date',
      'sipa' => 'required|string',
      'sipa_expire' => 'required|date',
      'sipa_image' => 'required|image|mimes:png,jpg,jpeg',
      'note' => 'nullable|string',
      'full_address' => 'required|string',
    ];
  }
}