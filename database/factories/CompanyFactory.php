<?php

namespace Database\Factories;

use App\Models\City;
use App\Models\CompanyType;
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
      'company_type_id' => CompanyType::factory(),
      'name' => $this->faker->unique()->company(),
      'phone_number' =>  $this->faker->randomNumber(6),
      'email' => $this->faker->email(),
      'note' => '',
      'website' => $this->faker->url(),
      'director' => $this->faker->name(),
      'npwp' => $this->faker->randomNumber(6),
      'fax' =>  $this->faker->randomNumber(6),
      'city_id' => City::factory(),
      'full_address' => $this->faker->address(),
    ];
  }
}