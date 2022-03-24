<?php

namespace App\Observers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class BlameableObserver
{
	// Make it null for seeding purpose

	public function creating(Model $model)
	{
		$model->created_by = Auth::user()->id ?? null;
		$model->updated_by = Auth::user()->id ?? null;
	}

	public function updating(Model $model)
	{
		$model->updated_by = Auth::user()->id ?? null;
	}
}