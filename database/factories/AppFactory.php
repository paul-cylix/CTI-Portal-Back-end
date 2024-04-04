<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\App>
 */
class AppFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'employee_id' => fake()->numberBetween(1,10),
            'mode' => fake()->randomElement(['In','Out']),
            'category_id' => fake()->numberBetween(1,10),
            'notes' => fake()->sentence(6, true),
            'date_entry' => fake()->date($format = 'Y-m-d', $max = 'now'),
            'time_entry' => fake()->dateTime($max = 'now', $timezone = null),
            'loc_address' =>fake()->address(),
            'latitude' => fake()->latitude($min = -90, $max = 90),
            'longitude' => fake()->longitude($min = -180, $max = 180),
            'images' => fake()->name(),
            'timestart' => fake()->numerify('#############'),
            'push_status' => fake()->numberBetween(1,1),
            'first_in' => fake()->numberBetween(0,1)
        ];
    }
}
