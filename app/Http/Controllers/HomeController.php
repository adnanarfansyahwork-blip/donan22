<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\PostType;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        // Latest posts
        $latestPosts = Post::published()
            ->with(['category', 'postType', 'user'])
            ->recent()
            ->limit(12)
            ->get();

        // Featured posts
        $featuredPosts = Post::published()
            ->featured()
            ->with(['category', 'postType'])
            ->limit(6)
            ->get();

        // Popular software
        $popularSoftware = Post::published()
            ->software()
            ->with(['category', 'softwareDetail'])
            ->popular()
            ->limit(8)
            ->get();

        // Popular mobile apps
        $popularApps = Post::published()
            ->mobileApps()
            ->with(['category', 'softwareDetail'])
            ->popular()
            ->limit(8)
            ->get();

        // Latest tutorials
        $tutorials = Post::published()
            ->tutorials()
            ->with(['category', 'user'])
            ->recent()
            ->limit(6)
            ->get();

        // Categories for sidebar
        $categories = Category::active()
            ->menu()
            ->parents()
            ->withCount(['posts' => fn($q) => $q->published()])
            ->ordered()
            ->get();

        return view('home', compact(
            'latestPosts',
            'featuredPosts',
            'popularSoftware',
            'popularApps',
            'tutorials',
            'categories'
        ));
    }
}
