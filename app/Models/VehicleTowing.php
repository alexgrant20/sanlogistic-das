<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehicleTowing extends Model
{
  use HasFactory;

  protected $table = 'vehicles_towings';

  protected $guarded = ['id'];
}