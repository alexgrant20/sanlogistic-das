<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehicleType extends Model
{
  use HasFactory;

  protected $table = 'vehicles_types';

  protected $with = ['vehicleBrand'];

  public function vehicleBrand()
  {
    return $this->belongsTo(VehicleBrand::class, 'vehicle_brand_id');
  }
}