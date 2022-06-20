<?php

namespace Database\Factories;

use App\Models\City;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Person>
 */
class PersonFactory extends Factory
{
  /**
   * Define the model's default state.
   *
   * @return array<string, mixed>
   */
  public function definition()
  {
    return [
      'project_id' => random_int(1, 20),
      'department_id' => random_int(1, 10),
      'area_id' => random_int(1, 30),
      'city_id' => City::factory(),
      'name' => $this->faker->name(),
      'image' => $this->faker->name(),
      'place_of_birth' => $this->faker->address(),
      'date_of_birth' => $this->faker->date(),
      'phone_number' => $this->faker->phoneNumber(),
      'joined_at' => $this->faker->date(),
      'note' => $this->faker->sentence(),
      'full_address' => $this->faker->address()
    ];
  }
}