<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Car>
 */
class CarFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'model' =>  $this->faker->randomElement(['xuv', 'sadan', 'nano']),
            'brand' =>  $this->faker->name,
            'year' =>  2023,
        ];
    }
}
