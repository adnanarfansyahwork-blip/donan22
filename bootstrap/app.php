<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Route;

$app = Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        then: function () {
            Route::middleware(['web'])
                ->prefix('admin')
                ->name('admin.')
                ->group(base_path('routes/admin.php'));
        },
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // CLOUDFLARE: Trust proxy - MUST be first middleware
        $middleware->prepend(\App\Http\Middleware\TrustCloudflare::class);
        
        // Global middleware - redirect www to non-www for SEO
        $middleware->prepend(\App\Http\Middleware\RedirectWwwToNonWww::class);
        
        $middleware->alias([
            'admin.auth' => \App\Http\Middleware\AdminAuth::class,
            'admin.role' => \App\Http\Middleware\RoleMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();

// Set public path - use the public directory
$app->usePublicPath($app->basePath('public'));

return $app;
