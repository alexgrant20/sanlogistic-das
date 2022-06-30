<?php

namespace Database\Factories;

use App\Models\Address;
use App\Models\Area;
use App\Models\Company;
use App\Models\Project;
use App\Models\VehicleLicensePlateColor;
use App\Models\VehicleTowing;
use App\Models\VehicleVariety;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Vehicle>
 */
class VehicleFactory extends Factory
{
  /**
   * Define the model's default state.
   *
   * @return array<string, mixed>
   */
  public function definition()
  {
    return [
      'project_id' => rand(1, 20),
      'area_id' => rand(1, 30),
      'vehicle_variety_id' => rand(1, 20),
      'address_id' => rand(1, 20),
      'owner_id' => rand(1, 20),
      'vehicle_towing_id' => rand(1, 10),
      'vehicle_license_plate_color_id' => random_int(1, 2),
      'license_plate' => $this->faker->unique()->name(),
      'frame_number' => $this->faker->randomNumber(9, true),
      'registration_number' => $this->faker->randomNumber(9, true),
      'engine_number' => $this->faker->randomNumber(9, true),
      'modification' => $this->faker->paragraph(1),
      'internal_code' => $this->faker->randomNumber(9, true),
      'capacity' => $this->faker->numberBetween(200, 300),
      'wheel' => $this->faker->numberBetween(8, 12),
      'odo' => $this->faker->randomNumber(4, true),
      'registration_year' => $this->faker->year()

    ];
  }
}