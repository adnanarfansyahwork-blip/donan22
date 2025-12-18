<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PostTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('post_types')->insert([
            [
                'id' => 1,
                'name' => 'Software',
                'slug' => 'software',
                'description' => 'Software applications and programs for PC',
                'icon' => 'fas fa-download',
                'is_active' => 1,
                'created_at' => '2025-09-27 17:28:19',
                'updated_at' => '2025-09-27 17:28:19',
            ],
            [
                'id' => 2,
                'name' => 'Games',
                'slug' => 'games',
                'description' => 'PC games, mobile games, and console games',
                'icon' => 'fas fa-gamepad',
                'is_active' => 1,
                'created_at' => '2025-09-27 17:28:19',
                'updated_at' => '2025-09-27 17:28:19',
            ],
            [
                'id' => 3,
                'name' => 'Blog',
                'slug' => 'blog',
                'description' => 'Step-by-step tutorials and guides',
                'icon' => 'fas fa-book',
                'is_active' => 1,
                'created_at' => '2025-09-27 17:28:19',
                'updated_at' => '2025-10-08 02:56:20',
            ],
            [
                'id' => 4,
                'name' => 'Mobile Apps',
                'slug' => 'mobile-apps',
                'description' => 'Android and iOS applications',
                'icon' => 'fas fa-mobile-alt',
                'is_active' => 1,
                'created_at' => '2025-09-27 17:28:19',
                'updated_at' => '2025-09-27 17:28:19',
            ],
            [
                'id' => 5,
                'name' => 'Windows Software',
                'slug' => 'windows-software',
                'description' => 'Windows specific applications',
                'icon' => 'fab fa-windows',
                'is_active' => 1,
                'created_at' => '2025-09-27 17:28:19',
                'updated_at' => '2025-09-27 17:28:19',
            ],
            [
                'id' => 6,
                'name' => 'Mac Software',
                'slug' => 'mac-software',
                'description' => 'macOS specific applications',
                'icon' => 'fab fa-apple',
                'is_active' => 1,
                'created_at' => '2025-09-27 17:28:19',
                'updated_at' => '2025-09-27 17:28:19',
            ],
            [
                'id' => 7,
                'name' => 'Game',
                'slug' => 'game',
                'description' => 'PC and mobile games',
                'icon' => 'fas fa-gamepad',
                'is_active' => 1,
                'created_at' => '2025-09-27 19:01:48',
                'updated_at' => '2025-09-27 19:01:48',
            ],
            [
                'id' => 8,
                'name' => 'Mobile App',
                'slug' => 'mobile-app',
                'description' => 'Android and iOS applications',
                'icon' => 'fas fa-mobile-alt',
                'is_active' => 1,
                'created_at' => '2025-09-27 19:01:48',
                'updated_at' => '2025-09-27 19:01:48',
            ],
            [
                'id' => 9,
                'name' => 'Guide',
                'slug' => 'guide',
                'description' => 'How-to guides and documentation',
                'icon' => 'fas fa-book',
                'is_active' => 1,
                'created_at' => '2025-09-27 19:01:48',
                'updated_at' => '2025-09-27 19:01:48',
            ],
        ]);
    }
}
