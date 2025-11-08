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
        // The common password for all users
        $commonPassword = Hash::make('12345');

        // Create roles
        Bouncer::role()->firstOrCreate(['name' => 'admin']);
        Bouncer::role()->firstOrCreate(['name' => 'editor']);
        Bouncer::role()->firstOrCreate(['name' => 'viewer']);

        // Create admin user
        $admin = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            ['name' => 'Admin', 'password' => $commonPassword]
        );
        Bouncer::assign('admin')->to($admin);

        // Create editor user
        // The 'create' method on the factory can accept overrides for attributes
        $editor = User::factory()->create([
            'email' => 'editor@example.com',
            'password' => $commonPassword,
        ]);
        Bouncer::assign('editor')->to($editor);

        // Bulk create viewers
        // The 'state' method can set attributes before creating the models
        User::factory()
            ->count(10)
            ->state([
                'password' => $commonPassword,
            ])
            ->create()
            ->each(fn($u) => Bouncer::assign('viewer')->to($u));
    }
}
