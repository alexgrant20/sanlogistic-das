<?php

namespace App\Models;

use App\Blameable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Schema;

class User extends Authenticatable
{
  use HasFactory, Blameable;

  protected $guarded = [
    'id'
  ];

  protected $hidden = [
    'password',
  ];

  protected $with = ['role'];

  public function person()
  {
    return $this->belongsTo(Person::class);
  }

  public function role()
  {
    return $this->belongsTo(Role::class);
  }

  public function activities()
  {
    return $this->hasMany(Activity::class);
  }

  public function Driver()
  {
    return $this->hasOne(Driver::class);
  }

  public function hasRole(String $role)
  {
    return $this->role->name === $role;
  }

  public function hasRoles(array $roles)
  {
    return in_array($this->role->name, $roles);
  }
}