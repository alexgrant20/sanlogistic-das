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
      'project_id' => Project::factory(),
      'department_id' => Department::factory(),
      'area_id' => Area::factory(),
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