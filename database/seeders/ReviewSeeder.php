<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Review;
use App\Models\Product;
use App\Models\User;

class ReviewSeeder extends Seeder
{
    public function run(): void
    {
        if (User::count() === 0) {
            User::factory()->count(20)->create();
        }

        Product::all()->each(function ($product) {
            $users = User::inRandomOrder()->limit(5)->get();
            Review::factory()
                ->count(rand(0, 8))
                ->for($product, 'product') // sets product_id
                ->state(fn () => ['user_id' => $users->random()->id]) // choose existing user
                ->create();
        });
    }
}

