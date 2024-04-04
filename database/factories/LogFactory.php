<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Log;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Log>
 */
class LogFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'user_id' => fake()->numberBetween(1,10),
            'date_entry' => fake()->date($format = 'Y-m-d', $max = 'now'),
            'clock_in' => fake()->dateTime($max = 'now', $timezone = null),
            'clock_out' => fake()->dateTime($max = 'now', $timezone = null),
            'status' => fake()->randomElement([Log::RJCT,Log::ACTV,Log::APVL]),
            'push_status' => fake()->numberBetween(0,1),
        ];
    }
}
