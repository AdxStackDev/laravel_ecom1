<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Category;

class ProductFactory extends Factory
{
    public function definition(): array
    {
        $name = $this->faker->unique()->words(3, true);
        return [
            'user_id'     => User::factory(),
            'category_id' => Category::factory(),
            'name'        => ucfirst($name),
            'slug'        => Str::slug($name) . '-' . Str::random(5),
            'description' => $this->faker->optional()->paragraphs(2, true),
            'price'       => $this->faker->randomFloat(2, 10, 9999),
            'stock'       => $this->faker->numberBetween(0, 500),
            'metadata'    => ['color' => $this->faker->safeColorName(), 'size' => $this->faker->randomElement(['S','M','L'])],
        ];
    }
}

