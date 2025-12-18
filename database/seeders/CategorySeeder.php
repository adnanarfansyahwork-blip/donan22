<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('categories')->insert([
            [
                'id' => 1,
                'name' => 'Game PC',
                'slug' => 'game-pc',
                'description' => 'PC games for Windows and Mac',
                'icon_url' => 'fas fa-gamepad',
                'meta_title' => 'PC Games - Download Latest Games',
                'meta_description' => 'Download the latest PC games for Windows and Mac',
                'is_active' => 1,
                'status' => 'active',
                'sort_order' => 1,
                'created_at' => '2025-09-27 17:28:19',
                'updated_at' => '2025-09-27 17:28:19',
            ],
            [
                'id' => 2,
                'name' => 'Software',
                'slug' => 'software',
                'description' => 'Software applications and programs',
                'icon_url' => 'fas fa-download',
                'meta_title' => 'Software Downloads',
                'meta_description' => 'Download the latest software applications',
                'is_active' => 1,
                'status' => 'active',
                'sort_order' => 2,
                'created_at' => '2025-09-27 17:28:19',
                'updated_at' => '2025-09-27 17:28:19',
            ],
            [
                'id' => 3,
                'name' => 'Blog',
                'slug' => 'blog',
                'description' => 'Blog articles and tutorials',
                'icon_url' => 'fas fa-blog',
                'meta_title' => 'Blog - Tips & Tutorials',
                'meta_description' => 'Read our latest blog articles and tutorials',
                'is_active' => 1,
                'status' => 'active',
                'sort_order' => 3,
                'created_at' => '2025-09-27 17:28:19',
                'updated_at' => '2025-09-27 17:28:19',
            ],
            [
                'id' => 4,
                'name' => 'Mobile Apps',
                'slug' => 'mobile-apps',
                'description' => 'Android and iOS applications',
                'icon_url' => 'fas fa-mobile-alt',
                'meta_title' => 'Mobile Apps - Android & iOS',
                'meta_description' => 'Download the latest mobile applications',
                'is_active' => 1,
                'status' => 'active',
                'sort_order' => 4,
                'created_at' => '2025-09-27 17:28:19',
                'updated_at' => '2025-09-27 17:28:19',
            ],
            [
                'id' => 5,
                'name' => 'Windows Software',
                'slug' => 'windows-software',
                'description' => 'Software for Windows OS',
                'icon_url' => 'fab fa-windows',
                'meta_title' => 'Windows Software Downloads',
                'meta_description' => 'Download the latest Windows software',
                'is_active' => 1,
                'status' => 'active',
                'sort_order' => 5,
                'created_at' => '2025-09-27 17:28:19',
                'updated_at' => '2025-09-27 17:28:19',
            ],
            [
                'id' => 6,
                'name' => 'Mac Software',
                'slug' => 'mac-software',
                'description' => 'Software for macOS',
                'icon_url' => 'fab fa-apple',
                'meta_title' => 'Mac Software Downloads',
                'meta_description' => 'Download the latest macOS software',
                'is_active' => 1,
                'status' => 'active',
                'sort_order' => 6,
                'created_at' => '2025-09-27 17:28:19',
                'updated_at' => '2025-09-27 17:28:19',
            ],
        ]);
    }
}
