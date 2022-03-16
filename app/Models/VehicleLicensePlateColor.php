<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehicleLicensePlateColor extends Model
{
  use HasFactory;

  protected $table = 'vehicles_license_plate_colors';

  protected $guarded = ['id'];
}