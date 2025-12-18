<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Post;
use App\Models\Administrator;
use App\Models\Category;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        // Stats
        $stats = [
            'total_posts' => Post::count(),
            'published_posts' => Post::published()->count(),
            'draft_posts' => Post::draft()->count(),
            'total_users' => Administrator::count(),
            'total_comments' => Comment::count(),
            'pending_comments' => Comment::pending()->count(),
        ];

        // Recent posts
        $recentPosts = Post::with('author', 'category')
            ->latest()
            ->limit(5)
            ->get();

        // Pending comments
        $pendingComments = Comment::pending()
            ->with('post', 'user')
            ->latest()
            ->limit(5)
            ->get();

        // Top posts by views
        $topPosts = Post::published()
            ->orderByDesc('views_count')
            ->limit(5)
            ->get();
            
        // Categories with post count
        $topCategories = Category::active()
            ->withCount('posts')
            ->orderByDesc('posts_count')
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact(
            'stats',
            'recentPosts',
            'pendingComments',
            'topPosts',
            'topCategories'
        ));
    }
}



