<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\AddressType;
use App\Models\VehicleLicensePlateColor;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
  public function run()
  {
    $this->call([
      ProvinceSeeder::class,
      CitySeeder::class,
      DistrictSeeder::class,
      SubdistrictSeeder::class,
    ]);

    Role::firstOrCreate(['name' => 'super-admin']);

    $user = User::firstOrCreate([
      'username' => 'admin',
      'password' => Hash::make('admin')
    ]);

    $user->assignRole('super-admin');

    VehicleLicensePlateColor::create(
      ['name' => 'black']
    );

    VehicleLicensePlateColor::create(
      ['name' => 'yellow']
    );

    AddressType::insert(
      [
        ['name' => 'Kantor Utama'],
        ['name' => 'Tujuan Pengiriman'],
        ['name' => 'Pool'],
        ['name' => 'Station'],
        ['name' => 'Workshop'],
        ['name' => 'PKB/SAMSAT']
      ]
    );
  }
}