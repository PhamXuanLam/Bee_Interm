<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Admin>
 */
class AdminFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "user_name" => fake()->userName(),
            'email' => fake()->email(),
            'password' => Hash::make("admin"), // password
            "birthday" => fake()->date(),
            "first_name" => fake()->firstName(),
            "last_name" => fake()->lastName(),
            "status" => random_int(0, 1),
            'remember_token' => Str::random(10),
        ];
    }
}
