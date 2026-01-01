<?php

namespace App\Console\Commands;

use App\Services\SitemapService;
use Illuminate\Console\Command;

class GenerateSitemap extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sitemap:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate sitemap.xml for the website';

    /**
     * Execute the console command.
     */
    public function handle(SitemapService $sitemapService): int
    {
        $this->info('Generating sitemaps...');

        try {
            $success = $sitemapService->generate();
            
            if ($success) {
                $totalUrls = $sitemapService->getTotalUrlCount();
                $this->info('Sitemaps generated successfully!');
                $this->info('');
                $this->info('Generated files:');
                $this->info('  - sitemap.xml (index)');
                $this->info('  - sitemap-posts.xml');
                $this->info('  - sitemap-categories.xml');
                $this->info('  - sitemap-pages.xml');
                $this->info('');
                $this->info('Total URLs: ' . $totalUrls);
                $this->info('Path: ' . $sitemapService->getPath());
                return Command::SUCCESS;
            } else {
                $this->error('Failed to generate sitemap.');
                return Command::FAILURE;
            }
        } catch (\Exception $e) {
            $this->error('Error: ' . $e->getMessage());
            return Command::FAILURE;
        }
    }
}
