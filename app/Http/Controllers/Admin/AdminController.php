<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Driver;

class AdminController extends Controller
{
	public function fillDriverLastLocation()
	{
		$driver = Driver::with(['user', 'user.activity' => function ($q) {
			$q->latest();
		}])
			->get()
			->map(function ($q) {
				$data['user_id'] = $q->user->id;
				$data['last_activity_id'] = $q->user->activity->first()->id ?? 135;

				return $data;
			});

		Driver::upsert(
			$driver->toArray(),
			['user_id'],
			['last_activity_id']
		);
	}
}
