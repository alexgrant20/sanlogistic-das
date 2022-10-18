<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Address;
use App\Models\AddressType;
use App\Models\Area;
use App\Models\City;
use App\Models\Company;
use App\Models\CompanyType;
use App\Models\Department;
use App\Models\District;
use App\Models\Driver;
use App\Models\Person;
use App\Models\PoolType;
use App\Models\Project;
use App\Models\Province;
use App\Models\Regional;
use App\Models\SimType;
use App\Models\Subdistrict;
use App\Models\Vehicle;
use App\Models\VehicleBrand;
use App\Models\VehicleLicensePlateColor;
use App\Models\VehicleTowing;
use App\Models\VehicleType;
use App\Models\VehicleVariety;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class SecondarySeeder extends Seeder
{
  public function run()
  {
    Department::factory(10)->create();
    SimType::factory(5)->create();
    CompanyType::factory(5)->create();
    VehicleBrand::factory(10)->create();
    VehicleType::factory(30)->create();
    VehicleVariety::factory(20)->create();
    Regional::factory(20)->create();
    Area::factory(30)->create();
    Province::factory(20)->create();
    City::factory(20)->create();
    District::factory(20)->create();
    Subdistrict::factory(20)->create();
    PoolType::factory(10)->create();
    Address::factory(20)->create();
    Company::factory(20)->create();
    Project::factory(20)->create();
    Person::factory(20)->create();
    VehicleTowing::factory(10)->create();
    Vehicle::factory(20)->create();
  }
}