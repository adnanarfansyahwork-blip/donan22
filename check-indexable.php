<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Post;

echo "=== AUDIT INDEXABILITY POSTS ===\n\n";

$posts = Post::published()->orderBy('published_at', 'desc')->get(['id', 'title', 'slug', 'is_indexable', 'published_at', 'updated_at']);

echo "Total posts published: " . $posts->count() . "\n\n";

$indexable = 0;
$notIndexable = 0;

foreach ($posts as $post) {
    $status = $post->is_indexable ? '✓ INDEXABLE' : '✗ NOT INDEXABLE';
    if ($post->is_indexable) {
        $indexable++;
    } else {
        $notIndexable++;
    }
    
    echo sprintf(
        "ID: %2d | %s | %s\n     %s\n     Published: %s\n\n",
        $post->id,
        $status,
        substr($post->title, 0, 60),
        $post->slug,
        $post->published_at->format('Y-m-d H:i')
    );
}

echo "\n=== SUMMARY ===\n";
echo "Indexable: $indexable\n";
echo "Not Indexable: $notIndexable\n";
