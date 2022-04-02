<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Address;
use App\Models\AddressType;
use App\Models\Area;
use App\Models\Company;
use App\Models\CompanyType;
use App\Models\Department;
use App\Models\Person;
use App\Models\Project;
use App\Models\Regional;
use App\Models\SimType;
use App\Models\Vehicle;
use App\Models\VehicleBrand;
use App\Models\VehicleLicensePlateColor;
use App\Models\VehicleTowing;
use App\Models\VehicleType;
use App\Models\VehicleVariety;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
  /**
   * Seed the application's database.
   *
   * @return void
   */
  public function run()
  {
    User::create([
      'person_id' => '1',
      'role_id' => '1',
      'username' => 'stevenAlexander',
      'password' => bcrypt('password')
    ]);

    VehicleLicensePlateColor::create([
      'name' => 'yellow'
    ]);

    VehicleLicensePlateColor::create([
      'name' => 'black'
    ]);

    Address::factory(100)->create();
    Company::factory(20)->create();
    AddressType::factory(10)->create();
    CompanyType::factory(5)->create();
    VehicleBrand::factory(10)->create();
    VehicleType::factory(30)->create();
    VehicleVariety::factory(200)->create();
    Project::factory(20)->create();
    Area::factory(30)->create();
    Regional::factory(20)->create();
    VehicleTowing::factory(10)->create();
    Vehicle::factory(20)->create();
    Department::factory(10)->create();
    SimType::factory(5)->create();
    Person::factory(20)->create();
  }
}