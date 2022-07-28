<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehicleLastStatus extends Model
{
  use HasFactory;

  public $guarded = ['id'];

  public function vehicle()
  {
    return $this->belongsTo(Vehicle::class);
  }

  public function address()
  {
    return $this->belongsTo(Address::class);
  }
}