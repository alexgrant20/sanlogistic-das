<?php

namespace App\Http\Requests\Driver;

use Illuminate\Foundation\Http\FormRequest;

class StoreActivityRequest extends FormRequest
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
      'do_number' => 'required|string',
      'arrival_location_id' => 'required|string',
      'vehicle_id' => 'required|string',
      'do_image' => 'required|image|mimes:png,jpg,jpeg',
      'departure_odo_image' => 'required|image|mimes:png,jpg,jpeg',
      'departure_odo' => 'required|integer',
      'departure_location_id' => 'required|integer',
    ];
  }

  public function attributes()
  {
    return [
      'do_number' => 'Nomor DO',
      'arrival_location_id' => 'Lokasi Awal',
      'vehicle_id' => 'Kendaraan',
      'do_image' => 'Gambar DO',
      'departure_odo_image' => 'Gambar ODO',
      'departure_odo' => 'Odometer Awal',
      'departure_location_id' => 'Lokasi Akhir',
    ];
  }
}
