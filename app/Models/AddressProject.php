<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AddressProject extends Model
{
  use HasFactory;

  protected $guarded = ['id'];

  public function address()
  {
    return $this->belongsTo(Address::class);
  }

  public function project()
  {
    return $this->belongsTo(Project::class);
  }
}
