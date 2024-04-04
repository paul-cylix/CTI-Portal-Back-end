<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            // 'name' => fake()->word(),
            // 'hex_color' => fake()->hexcolor(),
            // 'width' => fake()->numberBetween(1, 200),
            // 'width_log' => fake()->numberBetween(1, 200),
            // 'width_inout' => fake()->numberBetween(1, 200),
            // 'left_inout' => fake()->numberBetween(1, 200)
        ];
    }
}
