<?php

namespace Database\Factories;

use App\Models\ProductCategory;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $userList = User::query()->get();
        $categories = ProductCategory::query()->get();
        return [
            "user_id" => $userList->random()->id,
            "sku" => fake()->userName(),
            "name" => fake()->name(),
            "stock" => random_int(1, 100),
            "avatar" => fake()->image(),
            "expired_at" => fake()->date(),
            "category_id" => $categories->random()->id,
            'price' => random_int(100, 1000)
        ];
    }
}
