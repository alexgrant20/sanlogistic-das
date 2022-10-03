<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class AreaRequest extends FormRequest
{

  public function authorize()
  {
    return true;
  }

  public function rules()
  {
    return [
      'name' => 'required|unique:areas,name,' . optional($this->area)->id,
      'regional_id' => 'required|integer',
      'description' => 'nullable|string'
    ];
  }
}