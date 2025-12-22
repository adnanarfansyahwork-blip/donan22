<?php

namespace App\Observers;

use App\Models\Category;
use App\Services\SitemapService;
use Illuminate\Support\Facades\Log;

class CategoryObserver
{
    /**
     * Handle the Category "created" event.
     */
    public function created(Category $category): void
    {
        $this->regenerateSitemap();
    }

    /**
     * Handle the Category "updated" event.
     */
    public function updated(Category $category): void
    {
        $this->regenerateSitemap();
    }

    /**
     * Handle the Category "deleted" event.
     */
    public function deleted(Category $category): void
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
