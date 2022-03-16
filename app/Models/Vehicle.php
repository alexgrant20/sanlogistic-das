<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
  use HasFactory;

  protected $guarded = ['id'];

  public function vehiclesDocuments()
  {
    return $this->hasMany(VehicleDocument::class);
  }

  public function project()
  {
    return $this->belongsTo(Project::class);
  }

  public function area()
  {
    return $this->belongsTo(Area::class);
  }

  public function vehicleVariety()
  {
    return $this->belongsTo(VehicleVariety::class, 'vehicle_variety_id');
  }

  public function address()
  {
    return $this->belongsTo(Address::class);
  }

  public function owner()
  {
    return $this->belongsTo(Company::class, 'owner_id');
  }

  public function vehicleTowing()
  {
    return $this->belongsTo(VehicleTowing::class, 'vehicle_towing_id');
  }

  public function vehicleImages()
  {
    return $this->hasMany(VehicleImage::class);
  }

  public function getRouteKeyName()
  {
    return 'license_plate';
  }
}