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
            // Default
            [
                'name' => 'Uncategorized',
                'slug' => 'uncategorized',
                'description' => 'Default category for unclassified posts',
                'is_active' => true,
                'show_in_menu' => false,
                'sort_order' => 999,
            ],
            
            // Main Categories - Software
            [
                'name' => 'Software',
                'slug' => 'software',
                'description' => 'Software applications and tools',
                'is_active' => true,
                'show_in_menu' => true,
                'sort_order' => 1,
            ],
            [
                'name' => 'Activator',
                'slug' => 'activator',
                'description' => 'Software activation tools',
                'parent_id' => null, // Will be set after Software is created
                'is_active' => true,
                'show_in_menu' => true,
                'sort_order' => 2,
            ],
            [
                'name' => 'Antivirus',
                'slug' => 'antivirus',
                'description' => 'Antivirus and security software',
                'is_active' => true,
                'show_in_menu' => true,
                'sort_order' => 3,
            ],
            [
                'name' => 'Audio Editor',
                'slug' => 'audio-editor',
                'description' => 'Audio editing and music production software',
                'is_active' => true,
                'show_in_menu' => true,
                'sort_order' => 4,
            ],
            [
                'name' => 'Video Editor',
                'slug' => 'video-editor',
                'description' => 'Video editing software and tools',
                'is_active' => true,
                'show_in_menu' => true,
                'sort_order' => 5,
            ],
            [
                'name' => 'Photo Editor',
                'slug' => 'photo-editor',
                'description' => 'Photo editing and manipulation software',
                'is_active' => true,
                'show_in_menu' => true,
                'sort_order' => 6,
            ],
            [
                'name' => 'Art & Design',
                'slug' => 'art-design',
                'description' => 'Graphic design and digital art software',
                'is_active' => true,
                'show_in_menu' => true,
                'sort_order' => 7,
            ],
            [
                'name' => 'Downloader',
                'slug' => 'downloader',
                'description' => 'Download managers and tools',
                'is_active' => true,
                'show_in_menu' => true,
                'sort_order' => 8,
            ],
            [
                'name' => 'Office',
                'slug' => 'office',
                'description' => 'Office productivity software',
                'is_active' => true,
                'show_in_menu' => true,
                'sort_order' => 9,
            ],
            [
                'name' => 'Utilities',
                'slug' => 'utilities',
                'description' => 'System utilities and tools',
                'is_active' => true,
                'show_in_menu' => true,
                'sort_order' => 10,
            ],
            [
                'name' => 'Multimedia',
                'slug' => 'multimedia',
                'description' => 'Multimedia applications',
                'is_active' => true,
                'show_in_menu' => true,
                'sort_order' => 11,
            ],
            [
                'name' => 'Security',
                'slug' => 'security',
                'description' => 'Security and privacy tools',
                'is_active' => true,
                'show_in_menu' => true,
                'sort_order' => 12,
            ],
            [
                'name' => 'Driver',
                'slug' => 'driver',
                'description' => 'Device drivers and updaters',
                'is_active' => true,
                'show_in_menu' => true,
                'sort_order' => 13,
            ],
            [
                'name' => 'Engineering',
                'slug' => 'engineering',
                'description' => 'Engineering and CAD software',
                'is_active' => true,
                'show_in_menu' => true,
                'sort_order' => 14,
            ],
            [
                'name' => 'Recovery',
                'slug' => 'recovery',
                'description' => 'Data recovery and backup software',
                'is_active' => true,
                'show_in_menu' => true,
                'sort_order' => 15,
            ],
            [
                'name' => 'Converter',
                'slug' => 'converter',
                'description' => 'File format converters',
                'is_active' => true,
                'show_in_menu' => true,
                'sort_order' => 16,
            ],
            [
                'name' => 'Screen Recorder',
                'slug' => 'screen-recorder',
                'description' => 'Screen recording software',
                'is_active' => true,
                'show_in_menu' => true,
                'sort_order' => 17,
            ],
            
            // Tutorial Categories
            [
                'name' => 'Tutorial',
                'slug' => 'tutorial',
                'description' => 'How-to guides and tutorials',
                'is_active' => true,
                'show_in_menu' => true,
                'sort_order' => 20,
            ],
            [
                'name' => 'Tips & Tricks',
                'slug' => 'tips-tricks',
                'description' => 'Tips and tricks for various software',
                'is_active' => true,
                'show_in_menu' => true,
                'sort_order' => 21,
            ],
            [
                'name' => 'Windows',
                'slug' => 'windows',
                'description' => 'Windows tips and tutorials',
                'is_active' => true,
                'show_in_menu' => true,
                'sort_order' => 22,
            ],
            [
                'name' => 'Mac',
                'slug' => 'mac',
                'description' => 'macOS tips and tutorials',
                'is_active' => true,
                'show_in_menu' => true,
                'sort_order' => 23,
            ],
            [
                'name' => 'Linux',
                'slug' => 'linux',
                'description' => 'Linux tips and tutorials',
                'is_active' => true,
                'show_in_menu' => true,
                'sort_order' => 24,
            ],
            
            // Other Categories
            [
                'name' => 'Games',
                'slug' => 'games',
                'description' => 'PC Games and gaming content',
                'is_active' => true,
                'show_in_menu' => true,
                'sort_order' => 30,
            ],
            [
                'name' => 'News',
                'slug' => 'news',
                'description' => 'Technology news and updates',
                'is_active' => true,
                'show_in_menu' => true,
                'sort_order' => 40,
            ],
            [
                'name' => 'Review',
                'slug' => 'review',
                'description' => 'Software and hardware reviews',
                'is_active' => true,
                'show_in_menu' => true,
                'sort_order' => 41,
            ],
        ];
        
        foreach ($categories as $cat) {
            Category::firstOrCreate(['slug' => $cat['slug']], $cat);
        }
    }
}
