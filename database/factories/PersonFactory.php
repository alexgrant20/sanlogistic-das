<?php

namespace Database\Factories;

use App\Models\Area;
use App\Models\City;
use App\Models\Department;
use App\Models\Project;
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
      'project_id' => rand(1, 20),
      'department_id' => rand(1, 10),
      'area_id' => rand(1, 30),
      'name' => $this->faker->name(),
      'image' => null,
      'place_of_birth' => $this->faker->address(),
      'date_of_birth' => $this->faker->date(),
      'phone_number' => $this->faker->phoneNumber(),
      'joined_at' => $this->faker->date(),
      'note' => $this->faker->sentence(),
      'nik' => rand(1, 20),
    ];
  }
}