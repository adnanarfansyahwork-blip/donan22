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
        $basePath = base_path();
        
        // Define all sitemap files
        $sitemapFiles = [
            'sitemap.xml' => ['name' => 'Sitemap Index', 'description' => 'Main sitemap index pointing to all sub-sitemaps'],
            'sitemap-posts.xml' => ['name' => 'Posts Sitemap', 'description' => 'All published posts/articles'],
            'sitemap-categories.xml' => ['name' => 'Categories Sitemap', 'description' => 'All active categories'],
            'sitemap-pages.xml' => ['name' => 'Pages Sitemap', 'description' => 'Static pages (about, contact, etc)'],
        ];
        
        $sitemaps = [];
        $totalUrls = 0;
        
        foreach ($sitemapFiles as $filename => $meta) {
            $path = $basePath . '/' . $filename;
            $exists = file_exists($path);
            $urls = [];
            $urlCount = 0;
            
            if ($exists) {
                try {
                    $xml = simplexml_load_file($path);
                    if ($xml) {
                        // Check if sitemap index
                        if (isset($xml->sitemap)) {
                            foreach ($xml->sitemap as $sitemap) {
                                $urls[] = [
                                    'loc' => (string) $sitemap->loc,
                                    'lastmod' => (string) ($sitemap->lastmod ?? ''),
                                    'type' => 'sitemap',
                                ];
                            }
                            $urlCount = count($urls);
                        } else {
                            // Regular sitemap
                            foreach ($xml->url as $url) {
                                $urls[] = [
                                    'loc' => (string) $url->loc,
                                    'lastmod' => (string) ($url->lastmod ?? ''),
                                    'changefreq' => (string) ($url->changefreq ?? ''),
                                    'priority' => (string) ($url->priority ?? ''),
                                ];
                            }
                            $urlCount = count($urls);
                            $totalUrls += $urlCount;
                        }
                    }
                } catch (\Exception $e) {
                    // Sitemap parse error
                }
            }
            
            $sitemaps[$filename] = [
                'name' => $meta['name'],
                'description' => $meta['description'],
                'filename' => $filename,
                'exists' => $exists,
                'info' => $exists ? [
                    'size' => filesize($path),
                    'modified' => filemtime($path),
                ] : null,
                'urls' => $urls,
                'url_count' => $urlCount,
                'public_url' => url($filename),
            ];
        }
        
        // Get stats for comparison
        $stats = [
            'total_posts' => Post::published()->count(),
            'total_categories' => Category::active()->count(),
            'sitemap_urls' => $totalUrls,
            'sitemap_files' => count(array_filter($sitemaps, fn($s) => $s['exists'])),
        ];
        
        // Robots.txt info
        $robotsPath = base_path('robots.txt');
        $robotsExists = file_exists($robotsPath);
        $robotsContent = $robotsExists ? file_get_contents($robotsPath) : null;
        
        return view('admin.sitemap.index', compact(
            'sitemaps',
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
