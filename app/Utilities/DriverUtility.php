<?php

namespace App\Utilities;

use App\Interface\DriverInterface;
use App\Models\Address;

class DriverUtility implements DriverInterface
{
	public function getLocation(): Address
	{
		$driver = auth()->user()->driver;

		$driverHasLastLocation = !empty($driver->last_location_id);

		return $driverHasLastLocation ? $driver->lastLocation : Address::find(self::DEFAULT_DRIVER_LOCATION);
	}
}