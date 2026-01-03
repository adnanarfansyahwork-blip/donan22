<?php

namespace App\Services;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;

class SitemapService
{
    protected string $basePath;
    protected string $appUrl;

    public function __construct()
    {
        // Generate sitemap in base path (document root) instead of public folder
        // This is needed because Hostinger's document root is /public_html/ not /public_html/public/
        $this->basePath = base_path();
        
        // Normalize URL: Always use non-www version for canonical consistency
        // This prevents duplicate content issues between www and non-www
        $this->appUrl = $this->normalizeUrl(config('app.url'));
    }

    /**
     * Normalize URL to ensure consistency (remove www prefix for canonical URL).
     * SEO Best Practice: Use one canonical version to avoid duplicate content.
     */
    protected function normalizeUrl(string $url): string
    {
        // Remove www. prefix for canonical consistency
        return preg_replace('/^(https?:\/\/)www\./i', '$1', $url);
    }

    /**
     * Generate all sitemaps (index + individual sitemaps).
     */
    public function generate(): bool
    {
        // Generate individual sitemaps
        $this->generatePostsSitemap();
        $this->generateCategoriesSitemap();
        $this->generatePagesSitemap();
        
        // Generate sitemap index
        $result = $this->generateSitemapIndex();
        
        // Ping Google to notify sitemap update (SEO)
        if ($result && app()->environment('production')) {
            $this->pingSearchEngines($this->appUrl . '/sitemap.xml');
        }
        
        return $result;
    }

    /**
     * Generate sitemap index file.
     */
    protected function generateSitemapIndex(): bool
    {
        $xml = new \SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"/>');

        $sitemaps = [
            ['loc' => $this->appUrl . '/sitemap-posts.xml', 'lastmod' => now()->toW3cString()],
            ['loc' => $this->appUrl . '/sitemap-categories.xml', 'lastmod' => now()->toW3cString()],
            ['loc' => $this->appUrl . '/sitemap-pages.xml', 'lastmod' => now()->toW3cString()],
        ];

        foreach ($sitemaps as $sitemap) {
            $sitemapEl = $xml->addChild('sitemap');
            $sitemapEl->addChild('loc', htmlspecialchars($sitemap['loc']));
            $sitemapEl->addChild('lastmod', $sitemap['lastmod']);
        }

        return $this->saveXml($xml, 'sitemap.xml');
    }

    /**
     * Generate posts sitemap.
     */
    protected function generatePostsSitemap(): bool
    {
        $xml = new \SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"/>');

        // Add homepage
        $this->addUrl($xml, $this->appUrl, now()->toW3cString(), 'daily', '1.0');

        // Add posts (only indexable posts)
        $posts = Post::published()
            ->where('is_indexable', true)
            ->latest('published_at')
            ->get();

        foreach ($posts as $post) {
            $this->addUrl(
                $xml,
                $this->appUrl . '/post/' . $post->slug,
                $post->updated_at->toW3cString(),
                'weekly',
                '0.8'
            );
        }

        return $this->saveXml($xml, 'sitemap-posts.xml');
    }

    /**
     * Generate categories sitemap.
     */
    protected function generateCategoriesSitemap(): bool
    {
        $xml = new \SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"/>');

        // Add categories listing page
        $this->addUrl($xml, $this->appUrl . '/categories', now()->toW3cString(), 'weekly', '0.7');

        // Add individual categories
        $categories = Category::active()->get();
        foreach ($categories as $category) {
            $this->addUrl(
                $xml,
                $this->appUrl . '/category/' . $category->slug,
                $category->updated_at->toW3cString(),
                'weekly',
                '0.6'
            );
        }

        return $this->saveXml($xml, 'sitemap-categories.xml');
    }

    /**
     * Generate static pages sitemap.
     */
    protected function generatePagesSitemap(): bool
    {
        $xml = new \SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"/>');

        $staticPages = [
            ['url' => $this->appUrl . '/software', 'priority' => '0.7', 'changefreq' => 'daily'],
            ['url' => $this->appUrl . '/mobile-apps', 'priority' => '0.7', 'changefreq' => 'daily'],
            ['url' => $this->appUrl . '/tutorials', 'priority' => '0.7', 'changefreq' => 'daily'],
            ['url' => $this->appUrl . '/about', 'priority' => '0.5', 'changefreq' => 'monthly'],
            ['url' => $this->appUrl . '/contact', 'priority' => '0.5', 'changefreq' => 'monthly'],
            ['url' => $this->appUrl . '/privacy-policy', 'priority' => '0.3', 'changefreq' => 'yearly'],
            ['url' => $this->appUrl . '/terms-of-service', 'priority' => '0.3', 'changefreq' => 'yearly'],
        ];

        foreach ($staticPages as $page) {
            $this->addUrl($xml, $page['url'], now()->toW3cString(), $page['changefreq'], $page['priority']);
        }

        return $this->saveXml($xml, 'sitemap-pages.xml');
    }

    /**
     * Add URL entry to sitemap.
     */
    protected function addUrl(\SimpleXMLElement $xml, string $loc, string $lastmod, string $changefreq, string $priority): void
    {
        $url = $xml->addChild('url');
        $url->addChild('loc', htmlspecialchars($loc));
        $url->addChild('lastmod', $lastmod);
        $url->addChild('changefreq', $changefreq);
        $url->addChild('priority', $priority);
    }

    /**
     * Save XML to file.
     */
    protected function saveXml(\SimpleXMLElement $xml, string $filename): bool
    {
        $dom = new \DOMDocument('1.0', 'UTF-8');
        $dom->preserveWhiteSpace = false;
        $dom->formatOutput = true;
        $dom->loadXML($xml->asXML());

        return file_put_contents($this->basePath . '/' . $filename, $dom->saveXML()) !== false;
    }

    /**
     * Ping search engines to notify sitemap update.
     */
    protected function pingSearchEngines(string $sitemapUrl): void
    {
        $pingUrls = [
            'https://www.google.com/ping?sitemap=' . urlencode($sitemapUrl),
            'https://www.bing.com/ping?sitemap=' . urlencode($sitemapUrl),
        ];

        foreach ($pingUrls as $pingUrl) {
            try {
                @file_get_contents($pingUrl, false, stream_context_create([
                    'http' => [
                        'method' => 'GET',
                        'timeout' => 5,
                        'ignore_errors' => true,
                    ],
                ]));
            } catch (\Exception $e) {
                // Silently fail - ping is not critical
                Log::warning('Sitemap ping failed: ' . $pingUrl . ' - ' . $e->getMessage());
            }
        }
    }

    /**
     * Get main sitemap path.
     */
    public function getPath(): string
    {
        return $this->basePath . '/sitemap.xml';
    }

    /**
     * Check if main sitemap exists.
     */
    public function exists(): bool
    {
        return file_exists($this->getPath());
    }

    /**
     * Get sitemap info.
     */
    public function getInfo(): ?array
    {
        if (!$this->exists()) {
            return null;
        }

        return [
            'size' => filesize($this->getPath()),
            'modified' => filemtime($this->getPath()),
            'readable' => is_readable($this->getPath()),
        ];
    }

    /**
     * Get URLs from main sitemap (returns sitemap index entries).
     */
    public function getUrls(): array
    {
        if (!$this->exists()) {
            return [];
        }

        $urls = [];
        try {
            $xml = simplexml_load_file($this->getPath());
            if ($xml) {
                // Check if it's a sitemap index
                if (isset($xml->sitemap)) {
                    foreach ($xml->sitemap as $sitemap) {
                        $urls[] = [
                            'loc' => (string) $sitemap->loc,
                            'lastmod' => (string) ($sitemap->lastmod ?? ''),
                            'type' => 'sitemap',
                        ];
                    }
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
                }
            }
        } catch (\Exception $e) {
            // Sitemap parse error
        }

        return $urls;
    }

    /**
     * Get total URL count across all sitemaps.
     */
    public function getTotalUrlCount(): int
    {
        $count = 0;
        $sitemapFiles = ['sitemap-posts.xml', 'sitemap-categories.xml', 'sitemap-pages.xml'];

        foreach ($sitemapFiles as $file) {
            $path = $this->basePath . '/' . $file;
            if (file_exists($path)) {
                try {
                    $xml = simplexml_load_file($path);
                    if ($xml && isset($xml->url)) {
                        $count += count($xml->url);
                    }
                } catch (\Exception $e) {
                    // Skip on error
                }
            }
        }

        return $count;
    }

    /**
     * Delete all sitemap files.
     */
    public function delete(): bool
    {
        $files = ['sitemap.xml', 'sitemap-posts.xml', 'sitemap-categories.xml', 'sitemap-pages.xml'];
        $success = true;

        foreach ($files as $file) {
            $path = $this->basePath . '/' . $file;
            if (file_exists($path)) {
                $success = $success && unlink($path);
            }
        }

        return $success;
    }
}
