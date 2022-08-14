<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePersonRequest extends FormRequest
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
      'project_id' => 'required|integer',
      'department_id' => 'required|integer',
      'area_id' => 'required|integer',
      'name' => 'required|string',
      'image' => 'nullable|image',
      'place_of_birth' => 'required|string',
      'date_of_birth' => 'required|date',
      'phone_number' => 'required|string',
      'joined_at' => 'required|date',
      'note' => 'nullable|string',
      'ktp' => 'required|alpha_num',
      'ktp_address' => 'required|string',
      'ktp_image' => 'nullable|image',
      'sim' => 'required|string',
      'sim_type_id' => 'required|integer',
      'sim_expire' => 'required|date',
      'sim_address' => 'required|string',
      'sim_image' => 'nullable|image',
      'assurance' => 'required|alpha_num',
      'assurance_image' => 'nullable|image',
      'bpjs_kesehatan' => 'required|alpha_num',
      'bpjs_kesehatan_image' => 'nullable|image',
      'bpjs_ketenagakerjaan' => 'required|alpha_num',
      'bpjs_ketenagakerjaan_image' => 'nullable|image',
      'npwp' => 'required|alpha_num',
      'npwp_image' => 'nullable|image',
      'nik' => 'required|string'
    ];
  }
}