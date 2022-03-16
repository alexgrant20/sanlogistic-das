<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
  use HasFactory;

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

  public function address()
  {
    return $this->belongsTo(Address::class);
  }

  public function getRouteKeyName()
  {
    return 'name';
  }
}