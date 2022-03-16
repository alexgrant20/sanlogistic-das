<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Project>
 */
class ProjectFactory extends Factory
{
  /**
   * Define the model's default state.
   *
   * @return array<string, mixed>
   */
  public function definition()
  {
    return [
      'company_id' => $this->faker->numberBetween(1, 200),
      'name' => $this->faker->unique()->firstName(),
      'date_start' => '2022-02-02',
      'date_end' => '2022-12-12',
    ];
  }
}