<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $department = [['id' => 1,'name' =>'Information Technology'],['id' => 2,'name' =>'Accounting'],['id' => 3,'name' =>'Human Resource']];
        $digit = fake()->numberBetween(0,2);

        $position = [['id' => 1,'name' =>'Technical Support Coordinator'],['id' => 2,'name' =>'Project Management Staff'],['id' => 3,'name' =>'Customer Support Staff']];
        $numero = fake()->numberBetween(0,2);


        

        return [
            'name' => fake()->name(),
            'email' => fake()->safeEmail(),
            'email_verified_at' => now(),
            'password' => Hash::make('secret'), // password
            'remember_token' => Str::random(10),
            'user_id' => fake()->unique()->numerify('###'),
            'employee_id' => fake()->unique()->numberBetween(1,10),
            'manager_id' => fake()->unique()->numerify('###'),
            'department_id' => $department[$digit]['id'],
            'department_name' => $department[$digit]['name'],
            'position_id' => $position[$numero]['id'],
            'position_name' => $position[$numero]['name'],
            'rank' => fake()->randomElement(['Employee','Manager']),
        ];

    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return static
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}
