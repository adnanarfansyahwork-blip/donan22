<?php

namespace App\Services;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Support\Facades\URL;

class SitemapService
{
    protected string $sitemapPath;

    public function __construct()
    {
        $this->sitemapPath = public_path('sitemap.xml');
    }

    public function generate(): bool
    {
        $xml = new \SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"/>');

        // Add homepage
        $this->addUrl($xml, url('/'), now()->toW3cString(), 'daily', '1.0');

        // Add posts
        $posts = Post::published()->latest('published_at')->get();
        foreach ($posts as $post) {
            $this->addUrl(
                $xml,
                route('posts.show', $post->slug),
                $post->updated_at->toW3cString(),
                'weekly',
                '0.8'
            );
        }

        // Add categories
        $categories = Category::active()->get();
        foreach ($categories as $category) {
            $this->addUrl(
                $xml,
                route('categories.show', $category->slug),
                $category->updated_at->toW3cString(),
                'weekly',
                '0.6'
            );
        }

        // Add static pages
        $staticPages = [
            ['url' => url('/about'), 'priority' => '0.5'],
            ['url' => url('/contact'), 'priority' => '0.5'],
            ['url' => url('/blog'), 'priority' => '0.7'],
        ];

        foreach ($staticPages as $page) {
            $this->addUrl($xml, $page['url'], now()->toW3cString(), 'monthly', $page['priority']);
        }

        // Save to file
        $dom = new \DOMDocument('1.0', 'UTF-8');
        $dom->preserveWhiteSpace = false;
        $dom->formatOutput = true;
        $dom->loadXML($xml->asXML());

        return file_put_contents($this->sitemapPath, $dom->saveXML()) !== false;
    }

    protected function addUrl(\SimpleXMLElement $xml, string $loc, string $lastmod, string $changefreq, string $priority): void
    {
        $url = $xml->addChild('url');
        $url->addChild('loc', htmlspecialchars($loc));
        $url->addChild('lastmod', $lastmod);
        $url->addChild('changefreq', $changefreq);
        $url->addChild('priority', $priority);
    }

    public function getPath(): string
    {
        return $this->sitemapPath;
    }

    public function exists(): bool
    {
        return file_exists($this->sitemapPath);
    }

    public function getInfo(): ?array
    {
        if (!$this->exists()) {
            return null;
        }

        return [
            'size' => filesize($this->sitemapPath),
            'modified' => filemtime($this->sitemapPath),
            'readable' => is_readable($this->sitemapPath),
        ];
    }

    public function getUrls(): array
    {
        if (!$this->exists()) {
            return [];
        }

        $urls = [];
        try {
            $xml = simplexml_load_file($this->sitemapPath);
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

        return $urls;
    }

    public function delete(): bool
    {
        if ($this->exists()) {
            return unlink($this->sitemapPath);
        }
        return false;
    }
}
