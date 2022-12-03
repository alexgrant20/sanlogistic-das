<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
  use HasFactory;

  protected $guarded = [
    'id'
  ];

  public function lastActivity()
  {
    return $this->belongsTo(Activity::class, 'last_activity_id');
  }

  public function user()
  {
    return $this->belongsTo(User::class);
  }
}