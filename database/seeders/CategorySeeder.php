<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Uncategorized',
                'slug' => 'uncategorized',
                'description' => 'Default category',
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'name' => 'Technology',
                'slug' => 'technology',
                'description' => 'Technology posts',
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'name' => 'Tutorials',
                'slug' => 'tutorials',
                'description' => 'Tutorial posts',
                'is_active' => true,
                'sort_order' => 3,
            ],
        ];
        foreach ($categories as $cat) {
            Category::firstOrCreate(['slug' => $cat['slug']], $cat);
        }
    }
}
