<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VehicleChecklistImage extends Model
{
  public $fillable = ['image', 'description', 'vehicle_checklist_id'];

  public function vehicleChecklist()
  {
    return $this->belongsTo(VehicleChecklist::class);
  }
}
