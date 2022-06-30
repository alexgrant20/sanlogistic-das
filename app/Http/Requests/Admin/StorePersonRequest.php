<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StorePersonRequest extends FormRequest
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
      'city_id' => 'required|integer',
      'name' => 'required|string',
      'image' => 'required|image|mimes:png,jpg,jpeg',
      'place_of_birth' => 'required|string',
      'date_of_birth' => 'required|date',
      'phone_number' => 'required|string',
      'joined_at' => 'required|date',
      'note' => 'nullable|string',
      'ktp' => 'required|string',
      'ktp_address' => 'required|string',
      'ktp_image' => 'required|image|mimes:png,jpg,jpeg',
      'sim' => 'required|string',
      'sim_type_id' => 'required|integer',
      'sim_expire' => 'required|date',
      'sim_address' => 'required|string',
      'sim_image' => 'required|image|mimes:png,jpg,jpeg',
      'assurance' => 'required|string',
      'assurance_image' => 'required|image|mimes:png,jpg,jpeg',
      'bpjs_kesehatan' => 'required|string',
      'bpjs_kesehatan_image' => 'required|image|mimes:png,jpg,jpeg',
      'bpjs_ketenagakerjaan' => 'required|string',
      'bpjs_ketenagakerjaan_image' => 'required|image|mimes:png,jpg,jpeg',
      'npwp' => 'required|alpha_num',
      'npwp_image' => 'required|image|mimes:png,jpg,jpeg',
      'full_address' => 'required|string'
    ];
  }
}