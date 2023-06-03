<?php

namespace App\Http\Requests\Driver;

use Illuminate\Foundation\Http\FormRequest;

class UpdateActivityRequest extends FormRequest
{

  public function authorize()
  {
    return true;
  }

  protected function prepareForValidation()
  {
    $this->merge([
      'bbm_amount' => (int) convertMoneyInt($this->get('bbm_amount')),
      'toll_amount' => (int) convertMoneyInt($this->get('toll_amount')),
      'parking_amount' => (int) convertMoneyInt($this->get('parking_amount'))
    ]);
  }

  public function rules()
  {
    return [
      'arrival_location_id' => 'required|integer',
      'arrival_odo' => 'required|integer|gt:' . $this->activity->departure_odo . '|lt:' . $this->activity->departure_odo + 800,
      'arrival_odo_image' => 'required|image|mimes:png,jpg,jpeg',
      'bbm_amount' => 'nullable|integer',
      'toll_amount' => 'nullable|integer',
      'parking_amount' => 'nullable|integer',
      'bbm_image' => 'required_unless:bbm_amount,0|prohibited_if:bbm_amount, 0|image|mimes:png,jpg,jpeg',
      'toll_image' => 'required_unless:toll_amount,0|prohibited_if:toll_amount, 0|image|mimes:png,jpg,jpeg',
      'parking_image' => 'required_unless:parking_amount,0|prohibited_if:parking_amount, 0|image|mimes:png,jpg,jpeg',
    ];
  }

  public function attributes()
  {
    return [
      'arrival_location_id' => 'Lokasi Tujuan',
      'arrival_odo' => 'Odometer Akhir',
      'arrival_odo_image' => 'Gambar ODO',
      'bbm_amount' => 'Jumlah Pembelian BBM',
      'toll_amount' => 'Biaya Toll',
      'parking_amount' => 'Biaya Parkir',
      'bbm_image' => 'Bukti Pembelian BBM',
      'toll_image' => 'Bukti Pembayaran Toll',
      'parking_image' => 'Bukti Pembayaran Parkir',
    ];
  }
}
