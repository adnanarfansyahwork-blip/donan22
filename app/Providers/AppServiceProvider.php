<?php

namespace App\Providers;

use App\Models\Administrator;
use App\Models\Post;
use App\Models\Category;
use App\Observers\PostObserver;
use App\Observers\CategoryObserver;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Force HTTPS in production only (not in local development)
        if (config('app.env') === 'production' && env('FORCE_HTTPS', false)) {
            URL::forceScheme('https');
        }

        // Register observers for auto-regenerating sitemap
        Post::observe(PostObserver::class);
        Category::observe(CategoryObserver::class);

        // Bind 'user' route parameter to Administrator model for admin routes
        Route::bind('user', function (string $value) {
            return Administrator::findOrFail($value);
        });
    }
}
