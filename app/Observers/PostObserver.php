<?php

namespace App\Observers;

use App\Models\Post;
use App\Services\SitemapService;
use Illuminate\Support\Facades\Log;

class PostObserver
{
    /**
     * Handle the Post "created" event.
     */
    public function created(Post $post): void
    {
        $this->regenerateSitemap();
    }

    /**
     * Handle the Post "updated" event.
     */
    public function updated(Post $post): void
    {
        $this->regenerateSitemap();
    }

    /**
     * Handle the Post "deleted" event.
     */
    public function deleted(Post $post): void
    {
        $this->regenerateSitemap();
    }

    /**
     * Handle the Post "restored" event.
     */
    public function restored(Post $post): void
    {
        $this->regenerateSitemap();
    }

    /**
     * Regenerate sitemap in background
     */
    protected function regenerateSitemap(): void
    {
        try {
            $sitemapService = app(SitemapService::class);
            $sitemapService->generate();
        } catch (\Exception $e) {
            Log::error('Failed to regenerate sitemap: ' . $e->getMessage());
        }
    }
}
