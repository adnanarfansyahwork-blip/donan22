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
        // Get daily views for last 30 days
        $dailyViews = PageView::select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('COUNT(*) as views')
            )
            ->where('created_at', '>=', now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Get top posts
        $topPosts = Post::select('id', 'title', 'views', 'downloads')
            ->orderByDesc('views')
            ->take(10)
            ->get();

        // Get traffic summary
        $stats = [
            'total_views' => Post::sum('views'),
            'total_downloads' => Post::sum('downloads'),
            'today_views' => PageView::whereDate('created_at', today())->count(),
            'this_week_views' => PageView::where('created_at', '>=', now()->startOfWeek())->count(),
            'this_month_views' => PageView::where('created_at', '>=', now()->startOfMonth())->count(),
        ];

        return view('admin.analytics.index', compact('dailyViews', 'topPosts', 'stats'));
    }

    public function export()
    {
        $posts = Post::select('title', 'slug', 'views', 'downloads', 'created_at', 'published_at')
            ->orderByDesc('views')
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
                    $post->views,
                    $post->downloads,
                    $post->created_at,
                    $post->published_at,
                ]);
            }
            
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}

