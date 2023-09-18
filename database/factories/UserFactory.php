<?php

namespace Database\Factories;

use App\Models\Commune;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

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
    public function definition(): array
    {
        $communes = Commune::query()
            ->with(['district', 'district.province'])
            ->select(['*'])
            ->get();
        $commune = $communes->random();
        $district = $commune->district;
        $province = $district->province;
        return [
            "user_name" => fake()->userName(),
            'email' => fake()->email(),
            'password' => Hash::make("user"), // password
            "birthday" => fake()->date(),
            "first_name" => fake()->firstName(),
            "last_name" => fake()->lastName(),
            "status" => random_int(0, 1),
            'remember_token' => Str::random(10),
            'avatar' => time() . '.png',
            'commune_id' => $commune->id,
            'district_id' => $district->id,
            'province_id' => $province->id,
            'address' => $province->name . ' - ' . $district->name . ' - ' . $commune->name,
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
