<?php

namespace App\Utilities;

use App\Interface\DriverInterface;
use App\Models\Address;
use App\Models\Driver;

class DriverUtility implements DriverInterface
{
  public function getLocation(Driver $driver): Address
  {
    $driverHasLastLocation = !empty($driver->last_location_id);

    return $driverHasLastLocation ? $driver->lastLocation : Address::find(self::DEFAULT_DRIVER_LOCATION);
  }
}
