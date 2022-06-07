<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityPayment extends Model
{
  protected $guarded = ['id'];

  public function activityStatus()
  {
    return $this->belongsTo(ActivityStatus::class);
  }
}