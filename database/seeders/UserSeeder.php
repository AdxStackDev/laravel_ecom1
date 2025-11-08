<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Silber\Bouncer\BouncerFacade as Bouncer;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Create roles
        Bouncer::role()->firstOrCreate(['name' => 'admin']);
        Bouncer::role()->firstOrCreate(['name' => 'editor']);
        Bouncer::role()->firstOrCreate(['name' => 'viewer']);

        // Create admin user
        $admin = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            ['name' => 'Admin', 'password' => Hash::make('password')]
        );
        
        Bouncer::assign('admin')->to($admin);

        // Create editor user
        $editor = User::factory()->create(['email' => 'editor@example.com']);
        Bouncer::assign('editor')->to($editor);

        // Bulk create viewers
        User::factory()->count(10)->create()->each(fn($u) => Bouncer::assign('viewer')->to($u));
    }
}

