<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\SearchController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;

/*
|--------------------------------------------------------------------------
| System Routes (for production maintenance)
|--------------------------------------------------------------------------
*/

// Clear all caches (use with secret key for security)
Route::get('/clear-cache/{key}', function ($key) {
    if ($key !== 'donan22-secret-2024') {
        abort(404);
    }

    Artisan::call('config:clear');
    Artisan::call('cache:clear');
    Artisan::call('route:clear');
    Artisan::call('view:clear');

    return response()->json([
        'success' => true,
        'message' => 'All caches cleared successfully!',
        'cleared' => ['config', 'cache', 'route', 'view']
    ]);
})->name('system.clear-cache');

// Debug: Check image paths (hapus setelah fix)
Route::get('/debug-images/{key}', function ($key) {
    if ($key !== 'donan22-secret-2024') {
        abort(404);
    }

    $posts = \App\Models\Post::select('id', 'title', 'featured_image')->take(10)->get();
    $result = [];
    foreach ($posts as $post) {
        $result[] = [
            'id' => $post->id,
            'title' => $post->title,
            'db_value' => $post->featured_image,
            'generated_url' => $post->featured_image_url,
            'file_exists' => $post->featured_image
                ? file_exists(public_path('storage/' . $post->featured_image))
                : null,
        ];
    }

    return response()->json([
        'upload_path_config' => config('filesystems.disks.public.root'),
        'posts' => $result
    ]);
});

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

// Home
Route::get('/', [HomeController::class, 'index'])->name('home');

// Search
Route::get('/search', [SearchController::class, 'index'])->name('search');
Route::get('/api/search', [SearchController::class, 'live'])->name('search.live');

// Categories
Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
Route::get('/category/{slug}', [CategoryController::class, 'show'])->name('categories.show');

// Post Types
Route::get('/software', [PostController::class, 'software'])->name('software.index');
Route::get('/mobile-apps', [PostController::class, 'mobileApps'])->name('mobile-apps.index');
Route::get('/tutorials', [PostController::class, 'tutorials'])->name('tutorials.index');

// Posts
Route::get('/post/{slug}', [PostController::class, 'show'])->name('posts.show');
Route::post('/post/{post}/comment', [PostController::class, 'storeComment'])->name('posts.comment');

// Download Routes
Route::get('/download/{post}/{link}', [PostController::class, 'download'])->name('posts.download');
Route::get('/go/{post}/{linkIndex}', [PostController::class, 'goDownload'])->name('go.download');

// Comments (public)
Route::post('/comments', [PostController::class, 'storeCommentPublic'])->name('comments.store');

// Static pages
Route::view('/about', 'pages.about')->name('about');
Route::view('/contact', 'pages.contact')->name('contact');
Route::view('/privacy-policy', 'pages.privacy')->name('privacy');
Route::view('/terms-of-service', 'pages.terms')->name('terms');

/*
|--------------------------------------------------------------------------
| Auth Routes
|--------------------------------------------------------------------------
*/
require __DIR__.'/auth.php';