<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Company>
 */
class CompanyFactory extends Factory
{
  /**
   * Define the model's default state.
   *
   * @return array<string, mixed>
   */
  public function definition()
  {
    return [
      'address_id' => $this->faker->numberBetween(1, 100),
      'company_type_id' => $this->faker->numberBetween(1, 5),
      'name' => $this->faker->unique()->company(),
      'phone_number' => $this->faker->phoneNumber(),
      'email' => $this->faker->email(),
      'note' => '',
      'website' => $this->faker->url(),
      'director' => $this->faker->name(),
      'npwp' => Str::random(10),
      'fax' => '1231245'
    ];
  }
}