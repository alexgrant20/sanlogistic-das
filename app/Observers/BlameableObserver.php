<?php

namespace App\Observers;

use Illuminate\Database\Eloquent\Model;

class BlameableObserver
{
  // Make it null for seeding purpose

  public function creating(Model $model)
  {
    $model->created_by = auth()->user()->id ?? null;
    $model->updated_by = auth()->user()->id ?? null;
  }

  public function updating(Model $model)
  {
    $model->updated_by = auth()->user()->id ?? null;
  }
}