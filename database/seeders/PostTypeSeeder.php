<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PostType;

class PostTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = [
            [
                'name' => 'Software',
                'slug' => 'software',
                'description' => 'Software posts',
                'icon' => 'fa fa-desktop',
                'is_active' => true,
            ],
            [
                'name' => 'Mobile Apps',
                'slug' => 'mobile-apps',
                'description' => 'Mobile app posts',
                'icon' => 'fa fa-mobile',
                'is_active' => true,
            ],
            [
                'name' => 'Tutorial',
                'slug' => 'tutorial',
                'description' => 'Tutorial posts',
                'icon' => 'fa fa-book',
                'is_active' => true,
            ],
            [
                'name' => 'Article',
                'slug' => 'article',
                'description' => 'Article posts',
                'icon' => 'fa fa-file-text',
                'is_active' => true,
            ],
        ];
        foreach ($types as $type) {
            PostType::firstOrCreate(['slug' => $type['slug']], $type);
        }
    }
}
