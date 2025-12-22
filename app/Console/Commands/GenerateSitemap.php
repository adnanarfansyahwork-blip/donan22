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
        $this->info('Generating sitemap...');

        try {
            $success = $sitemapService->generate();
            
            if ($success) {
                $urls = $sitemapService->getUrls();
                $this->info('Sitemap generated successfully!');
                $this->info('Total URLs: ' . count($urls));
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
