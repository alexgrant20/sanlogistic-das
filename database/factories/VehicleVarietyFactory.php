<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\VehicleVariety>
 */
class VehicleVarietyFactory extends Factory
{
  /**
   * Define the model's default state.
   *
   * @return array<string, mixed>
   */
  public function definition()
  {
    return [
      'vehicle_type_id' => $this->faker->numberBetween(1, 20),
      'name' => $this->faker->unique()->name(),
    ];
  }
}