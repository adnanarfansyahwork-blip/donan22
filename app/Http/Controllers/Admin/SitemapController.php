<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\SitemapService;
use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SitemapController extends Controller
{
    public function index(): View
    {
        $sitemapPath = base_path('sitemap.xml');
        $sitemapExists = file_exists($sitemapPath);
        
        $sitemapInfo = null;
        $urls = [];
        
        if ($sitemapExists) {
            $sitemapInfo = [
                'size' => filesize($sitemapPath),
                'modified' => filemtime($sitemapPath),
                'readable' => is_readable($sitemapPath),
            ];
            
            // Parse sitemap to get URLs
            try {
                $xml = simplexml_load_file($sitemapPath);
                if ($xml) {
                    foreach ($xml->url as $url) {
                        $urls[] = [
                            'loc' => (string) $url->loc,
                            'lastmod' => (string) ($url->lastmod ?? ''),
                            'changefreq' => (string) ($url->changefreq ?? ''),
                            'priority' => (string) ($url->priority ?? ''),
                        ];
                    }
                }
            } catch (\Exception $e) {
                // Sitemap parse error
            }
        }
        
        // Get stats for comparison
        $stats = [
            'total_posts' => Post::published()->count(),
            'total_categories' => Category::active()->count(),
            'sitemap_urls' => count($urls),
        ];
        
        // Robots.txt info
        $robotsPath = base_path('robots.txt');
        $robotsExists = file_exists($robotsPath);
        $robotsContent = $robotsExists ? file_get_contents($robotsPath) : null;
        
        return view('admin.sitemap.index', compact(
            'sitemapExists',
            'sitemapInfo',
            'urls',
            'stats',
            'robotsExists',
            'robotsContent'
        ));
    }
    
    public function generate(SitemapService $sitemapService): RedirectResponse
    {
        try {
            $sitemapService->generate();
            return back()->with('success', 'Sitemap generated successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to generate sitemap: ' . $e->getMessage());
        }
    }
    
    public function preview(): View
    {
        $sitemapPath = base_path('sitemap.xml');
        $content = file_exists($sitemapPath) ? file_get_contents($sitemapPath) : null;
        
        return view('admin.sitemap.preview', compact('content'));
    }
    
    public function updateRobots(Request $request): RedirectResponse
    {
        $request->validate([
            'content' => 'required|string',
        ]);
        
        try {
            file_put_contents(base_path('robots.txt'), $request->content);
            return back()->with('success', 'Robots.txt updated successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to update robots.txt: ' . $e->getMessage());
        }
    }
}
