<?php

namespace Database\Factories;

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
      'project_id' => $this->faker->numberBetween(1, 20),
      'area_id' => $this->faker->numberBetween(1, 30),
      'vehicle_variety_id' => $this->faker->numberBetween(1, 200),
      'address_id' => $this->faker->numberBetween(1, 200),
      'owner_id' => $this->faker->numberBetween(1, 5),
      'vehicle_towing_id' => $this->faker->numberBetween(1, 100),
      'vehicle_license_plate_color_id' => $this->faker->numberBetween(1, 2),
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