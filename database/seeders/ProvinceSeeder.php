<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProvinceSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $file_path = resource_path('sql/provinces.sql');

    DB::unprepared(
      file_get_contents($file_path)
    );
  }
}