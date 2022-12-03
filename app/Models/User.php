<?php

namespace App\Models;

use App\Blameable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
  use HasFactory, Blameable, HasRoles;

  protected $guarded = [
    'id'
  ];

  protected $hidden = [
    'password',
  ];

  public function person()
  {
    return $this->belongsTo(Person::class);
  }

  public function activities()
  {
    return $this->hasMany(Activity::class);
  }

  public function Driver()
  {
    return $this->hasOne(Driver::class);
  }
}