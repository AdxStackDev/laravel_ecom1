<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Tag;
use App\Models\Category;
use App\Models\User;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // Ensure some users exist
        User::factory()->count(10)->create();

        // Use existing categories (from CategorySeeder)
        $categories = Category::inRandomOrder()->pluck('id');

        // Create products assigned to random categories
        $products = Product::factory()
            ->count(200)
            ->state(fn() => ['category_id' => $categories->random()])
            ->create();

        // Attach 1-5 random tags per product
        $tagIds = Tag::pluck('id')->all();
        $products->each(function ($product) use ($tagIds) {
            $product->tags()->sync(collect($tagIds)->shuffle()->take(rand(1, 5))->all());
        });
    }
}

