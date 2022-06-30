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
      'username' => "required|unique:users,username,{$this->user->id}",
      'password' => 'nullable|min:5',
      'role_id' => 'required',
    ];
  }
}