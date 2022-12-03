<?php

namespace App\Models;

use App\Blameable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
	use HasFactory, Blameable;

	protected $guarded = [
		'id'
	];

	public function company()
	{
		return $this->belongsTo(Company::class);
	}

	public function getRouteKeyName()
	{
		return 'name';
	}
}