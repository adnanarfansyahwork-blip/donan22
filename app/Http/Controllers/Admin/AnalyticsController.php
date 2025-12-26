<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\PageView;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AnalyticsController extends Controller
{
    public function index()
    {
        // Get daily views for last 30 days (using posts published date as reference)
        $dailyViews = Post::select(
                DB::raw('DATE(published_at) as date'),
                DB::raw('SUM(views_count) as views')
            )
            ->whereNotNull('published_at')
            ->where('published_at', '>=', now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Get top posts
        $topPosts = Post::select('id', 'title', 'views_count', 'downloads_count')
            ->orderByDesc('views_count')
            ->take(10)
            ->get();

        // Get traffic summary
        $stats = [
            'total_views' => Post::sum('views_count'),
            'total_downloads' => Post::sum('downloads_count'),
            'today_views' => Post::whereDate('published_at', today())->sum('views_count'),
            'this_month_views' => Post::whereYear('published_at', now()->year)
                ->whereMonth('published_at', now()->month)
                ->sum('views_count'),
        ];

        return view('admin.analytics.index', compact('dailyViews', 'topPosts', 'stats'));
    }

    public function export()
    {
        $posts = Post::select('title', 'slug', 'views_count', 'downloads_count', 'created_at', 'published_at')
            ->orderByDesc('views_count')
            ->get();

        $filename = 'analytics_export_' . date('Y-m-d') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename={$filename}",
        ];

        $callback = function() use ($posts) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Title', 'Slug', 'Views', 'Downloads', 'Created', 'Published']);
            
            foreach ($posts as $post) {
                fputcsv($file, [
                    $post->title,
                    $post->slug,
                    $post->views_count,
                    $post->downloads_count,
                    $post->created_at,
                    $post->published_at,
                ]);
            }
            
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}

