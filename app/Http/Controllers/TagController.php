<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Category;
use Illuminate\View\View;

class TagController extends Controller
{
    public function show($slug): View
    {
        $tag = str_replace('-', ' ', $slug);

        $posts = Post::published()
            ->where('tags', 'like', "%{$tag}%")
            ->with('category')
            ->orderByDesc('published_at')
            ->paginate(12);

        // Get related tags
        $relatedTags = [];
        $postsWithTags = Post::published()
            ->whereNotNull('tags')
            ->limit(50)
            ->pluck('tags');
        
        foreach($postsWithTags as $postTags) {
            $tagArray = array_map('trim', explode(',', $postTags));
            $relatedTags = array_merge($relatedTags, $tagArray);
        }
        $relatedTags = array_unique($relatedTags);
        $relatedTags = array_slice($relatedTags, 0, 20);

        // Categories
        $categories = Category::active()
            ->withCount(['posts' => function($query) {
                $query->where('status', 'published');
            }])
            ->orderBy('sort_order')
            ->get();

        return view('tag', compact('tag', 'posts', 'relatedTags', 'categories'));
    }
}
