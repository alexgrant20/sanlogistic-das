<?php

namespace App\Models;

use App\Blameable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
  use HasFactory, Blameable;

  protected $guarded = [
    'id'
  ];

  public function companyType()
  {
    return $this->hasMany(CompanyType::class);
  }

  public function companyDocuments()
  {
    return $this->hasMany(CompanyDocument::class);
  }

  public function city()
  {
    return $this->belongsTo(City::class);
  }

  public function getRouteKeyName()
  {
    return 'name';
  }
}