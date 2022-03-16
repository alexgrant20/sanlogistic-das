<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Address>
 */
class AddressFactory extends Factory
{
  /**
   * Define the model's default state.
   *
   * @return array<string, mixed>
   */
  public function definition()
  {
    return [
      'address_type_id' => random_int(1, 10),
      'area_id' => 1,
      'subdistrict_id' => 1,
      'pool_type_id' => 1,
      'name' => $this->faker->unique()->name(),
      'full_address' => $this->faker->address(),
      'longitude' => $this->faker->randomFloat(),
      'latitude' => $this->faker->randomFloat(),
      'post_number' => $this->faker->randomNumber(6, true)
    ];
  }
}