<?php

namespace App\Models;

use App\Blameable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
  use HasFactory, Blameable;

  protected $guarded = ['id'];

  public function driver()
  {
    return $this->belongsTo(User::class, 'user_id');
  }

  public function vehicle()
  {
    return $this->belongsTo(Vehicle::class);
  }

  public function project()
  {
    return $this->belongsTo(Project::class);
  }

  public function departureLocation()
  {
    return $this->belongsTo(Address::class, 'departure_location_id');
  }

  public function arrivalLocation()
  {
    return $this->belongsTo(Address::class, 'arrival_location_id');
  }

  public function activityStatus()
  {
    return $this->hasOne(ActivityStatus::class);
  }
}