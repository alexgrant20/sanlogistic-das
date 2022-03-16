<?php

namespace App\Http\Requests;

use Clockwork\Request\Request;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProjectRequest extends FormRequest
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
      'company_id' => 'required|string',
      'name' => "required|string|unique:projects,name,{$this->project->id}",
      'date_start' => 'required|date|before:date_end',
      'date_end' => 'required|date',
      'catatan' => 'nullable|string'
    ];
  }
}