<?php

namespace App\Http\Requests\Driver;

use Illuminate\Foundation\Http\FormRequest;

class StorePublicTransportActivityRequest extends FormRequest
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
			'arrival_location_id' => 'required|integer',
			'departure_location_id' => 'required|string',
		];
	}

	public function attributes()
	{
		return [
			'arrival_location_id' => 'Lokasi Awal',
			'departure_location_id' => 'Lokasi Akhir',
		];
	}
}
