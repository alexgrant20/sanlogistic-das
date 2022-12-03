<?php

namespace Database\Factories;

use App\Models\AddressType;
use App\Models\Area;
use App\Models\PoolType;
use App\Models\Subdistrict;
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
      'address_type_id' => rand(1, 6),
      'area_id' => Area::factory(),
      'subdistrict_id' => Subdistrict::factory(),
      'pool_type_id' => PoolType::factory(),
      'name' => $this->faker->unique()->name(),
      'full_address' => $this->faker->address(),
      'longitude' => $this->faker->randomFloat(),
      'latitude' => $this->faker->randomFloat(),
      'post_number' => $this->faker->randomNumber(6)
    ];
  }
}