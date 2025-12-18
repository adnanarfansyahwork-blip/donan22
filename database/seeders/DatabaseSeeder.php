<?php

namespace Database\Seeders;

use App\Models\Administrator;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create default admin user
        Administrator::firstOrCreate(
            ['username' => 'admin'],
            [
                'email' => 'admin@donan22.com',
                'password_hash' => Hash::make('admin123'),
                'role' => 'admin',
            ]
        );

        // Create default user for posts
        $user = User::firstOrCreate(
            ['email' => 'user@donan22.com'],
            [
                'name' => 'Default User',
                'password' => Hash::make('user123'),
            ]
        );

        // Seed post types, categories, and posts
        $this->call([
            PostTypeSeeder::class,
            CategorySeeder::class,
            PostSeeder::class,
        ]);
    }
}
