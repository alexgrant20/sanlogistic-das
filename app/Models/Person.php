<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
  use HasFactory;

  protected $guarded = ['id'];

  public function project()
  {
    return $this->belongsTo(Project::class);
  }

  public function department()
  {
    return $this->belongsTo(Department::class);
  }

  public function area()
  {
    return $this->belongsTo(Area::class);
  }

  public function address()
  {
    return $this->belongsTo(Address::class);
  }

  public function user()
  {
    return $this->hasOne(User::class);
  }
}