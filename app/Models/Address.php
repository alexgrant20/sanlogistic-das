<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
	use HasFactory;

	protected $guarded = ['id'];

	public function addressType()
	{
		return $this->belongsTo(AddressType::class, 'address_type_id');
	}

	public function area()
	{
		return $this->belongsTo(Area::class);
	}

	public function subdistrict()
	{
		return $this->belongsTo(Subdistrict::class);
	}

	public function poolType()
	{
		return $this->belongsTo(PoolType::class, 'pool_type_id');
	}
}