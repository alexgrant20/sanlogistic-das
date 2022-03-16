<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehicleVariety extends Model
{
  use HasFactory;

  protected $table = 'vehicles_varieties';

  protected $with = ['vehicleType'];

  public function vehicleType()
  {
    return $this->belongsTo(VehicleType::class, 'vehicle_type_id');
  }
}