<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
  public function authorize()
  {
    return true;
  }

  public function rules()
  {
    return [
      'username' => "required|unique:users,username,{$this->user->id},NULL,id,deleted_at,NULL",
      'password' => 'nullable|min:5',
      'role' => 'required|exists:roles,name',
    ];
  }
}