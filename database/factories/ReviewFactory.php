<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Review;
use App\Models\User;
use App\Models\Product;

class ReviewFactory extends Factory
{
    protected $model = Review::class;

    public function definition(): array
    {
        return [
            'user_id'    => User::factory(),
            'product_id' => Product::factory(),
            'rating'     => $this->faker->numberBetween(1, 5),
            'title'      => $this->faker->sentence(6),
            'body'       => $this->faker->optional()->paragraph(3),
        ];
    }
}

