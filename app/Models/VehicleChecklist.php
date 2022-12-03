<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehicleChecklist extends Model
{
  use HasFactory;

  public $guarded = [
    'id'
  ];

  public function user()
  {
    return $this->belongsTo(User::class);
  }

  public function vehicle()
  {
    return $this->belongsTo(Vehicle::class);
  }

  public function address()
  {
    return $this->belongsTo(Address::class);
  }

  public function vehicleChecklistImage()
  {
    return $this->hasMany(VehicleChecklistImage::class);
  }
}
