<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
  use HasFactory;

  /**
   * The attributes that are mass assignable.
   *
   * @var array<int, string>
   */

  protected $guarded = [
    'id'
  ];

  /**
   * The attributes that should be hidden for serialization.
   *
   * @var array<int, string>
   */
  protected $hidden = [
    'password',
  ];

  /**
   * The attributes that should be cast.
   *
   * @var array<string, string>
   */
  protected $casts = [];

  public function person()
  {
    return $this->belongsTo(Person::class);
  }

  public function role()
  {
    return $this->belongsTo(Role::class);
  }

  public function lastActivity()
  {
    return $this->belongsTo(Activity::class, 'last_activity_id');
  }

  public function activities()
  {
    return $this->hasMany(Activity::class);
  }
}