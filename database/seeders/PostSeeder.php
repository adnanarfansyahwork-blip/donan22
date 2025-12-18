<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\Category;
use App\Models\PostType;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $category = Category::first();
        $postType = PostType::first();
        $user = User::first();
        if ($category && $postType && $user) {
            Post::firstOrCreate([
                'slug' => 'contoh-post',
            ], [
                'title' => 'Contoh Post',
                'slug' => 'contoh-post',
                'excerpt' => 'Ini adalah contoh post.',
                'content' => 'Konten lengkap untuk contoh post.',
                'user_id' => $user->id,
                'category_id' => $category->id,
                'post_type_id' => $postType->id,
                'status' => Post::STATUS_PUBLISHED,
                'published_at' => now(),
            ]);
        }
    }
}
