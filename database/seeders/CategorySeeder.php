<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        // 10 root categories
        Category::factory()->count(10)->create();

        // Each root gets 3 children
        Category::all()->each(function ($parent) {
            Category::factory()->count(3)->create(['parent_id' => $parent->id]);
        });
    }
}
