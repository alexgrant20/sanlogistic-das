<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
  public function authorize()
  {
    return true;
  }

  public function rules()
  {
    return [
      'username' => 'required|unique:users,username,NULL,id,deleted_at,NULL',
      'password' => 'required|min:5',
      'role' => 'required|exists:roles,name',
      'person_id' => 'required|unique:users,person_id|exists:people,id,NULL,id,deleted_at,NULL'
    ];
  }
}