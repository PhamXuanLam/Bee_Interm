<?php

namespace Database\Factories;

use App\Models\Commune;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class CustomerFactory extends Factory
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
            'email' => fake()->email(),
            'phone' => fake()->phoneNumber(),
            'birthday' => fake()->date(),
            'full_name' => fake()->name,
            'password' => bcrypt("123"),
            'status' => random_int(0, 1),
            'commune_id' => $commune->id,
            'district_id' => $district->id,
            'province_id' => $province->id,
            'address' => $province->name . ' - ' . $district->name . ' - ' . $commune->name,
        ];
    }
}
