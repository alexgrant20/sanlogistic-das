<?php

namespace App\Http\Requests\Driver;

use Illuminate\Foundation\Http\FormRequest;

class UpdateActivityRequestView extends FormRequest
{
  public function rules()
  {
    return [
      'arrival_id' => 'required|integer',
      'arrival_odo' => 'required|integer|gt:' . $this->activity->departure_odo,
      'arrival_odo_image' => 'required|image|mimes:png,jpg,jpeg',
      'bbm_amount' => 'nullable',
      'toll_amount' => 'nullable',
      'parking_amount' => 'nullable',
      'bbm_image' => 'required_unless:bbm_amount,Rp. 0|prohibited_if:bbm_amount, Rp. 0|image|mimes:png,jpg,jpeg',
      'toll_image' => 'required_unless:toll_amount,Rp. 0|prohibited_if:toll_amount, Rp. 0|image|mimes:png,jpg,jpeg',
      'parking_image' => 'required_unless:parking_amount,Rp. 0|prohibited_if:parking_amount, Rp. 0|image|mimes:png,jpg,jpeg',
    ];
  }

  public function attributes()
  {
    return [
      'arrival_id' => 'Lokasi Tujuan',
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
