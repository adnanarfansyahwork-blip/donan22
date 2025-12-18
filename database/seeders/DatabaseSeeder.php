<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Run seeders in correct order (respecting foreign keys)
        $this->call([
            AdministratorSeeder::class,
            CategorySeeder::class,
            PostTypeSeeder::class,
            SettingSeeder::class,
        ]);
    }
}
