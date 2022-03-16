<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehicleBrand extends Model
{
  use HasFactory;

  protected $table = 'vehicles_brands';

  protected $guarded = ['id'];
}