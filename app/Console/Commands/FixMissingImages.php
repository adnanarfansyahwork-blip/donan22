<?php

namespace App\Console\Commands;

use App\Models\Post;
use Illuminate\Console\Command;

class FixMissingImages extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'posts:fix-missing-images {--dry-run : Just show what would be fixed}';

    /**
     * The console command description.
     */
    protected $description = 'Fix posts with missing featured images by setting them to NULL';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $dryRun = $this->option('dry-run');
        
        $this->info('Checking for posts with missing images...');
        
        $posts = Post::whereNotNull('featured_image')
            ->where('featured_image', '!=', '')
            ->get();
        
        $fixed = 0;
        $uploadPath = base_path('uploads/posts');
        
        foreach ($posts as $post) {
            // Skip if it's a URL
            if (str_starts_with($post->featured_image, 'http')) {
                continue;
            }
            
            // Check if file exists
            $filename = str_starts_with($post->featured_image, 'posts/')
                ? substr($post->featured_image, 6)
                : $post->featured_image;
            
            $filePath = $uploadPath . '/' . $filename;
            
            if (!file_exists($filePath)) {
                $this->line("Missing: Post #{$post->id} - {$post->title}");
                $this->line("  File: {$filename}");
                
                if (!$dryRun) {
                    $post->update(['featured_image' => null]);
                    $this->info("  → Fixed (set to NULL)");
                }
                
                $fixed++;
            }
        }
        
        $this->newLine();
        
        if ($fixed === 0) {
            $this->info('✓ All posts have valid images!');
        } elseif ($dryRun) {
            $this->warn("Found {$fixed} posts with missing images. Run without --dry-run to fix.");
        } else {
            $this->info("✓ Fixed {$fixed} posts with missing images.");
        }
        
        return Command::SUCCESS;
    }
}
