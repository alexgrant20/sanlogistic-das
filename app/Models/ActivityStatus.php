<?php

namespace App\Models;

use App\Blameable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityStatus extends Model
{
  use HasFactory, Blameable;

  protected $guarded = ['id'];

  public function activity()
  {
    return $this->belongsTo(Activity::class);
  }
}