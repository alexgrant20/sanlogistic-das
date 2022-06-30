<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProjectRequest extends FormRequest
{
  public function authorize()
  {
    return true;
  }

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