<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents; // optional but recommended while seeding

    public function run(): void
    {
        $this->call([
            CategorySeeder::class,
            TagSeeder::class,
            ProductSeeder::class,
            ReviewSeeder::class,
            UserSeeder::Class,
        ]);
    }
}

