<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehicleDocument extends Model
{
  use HasFactory;

  protected $table = 'vehicles_documents';

  protected $guarded = ['id'];

  public function vehicle()
  {
    return $this->belongsTo(Vehicle::class);
  }
}