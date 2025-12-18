<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CommentController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\AnalyticsController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\Admin\SitemapController;
use App\Http\Controllers\Admin\PostTypeController;
use App\Http\Controllers\Admin\UploadController;

// Guest routes (login) - No auth required
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');

// Protected routes - Require admin.auth middleware
Route::middleware('admin.auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

    // Posts CRUD
    Route::resource('posts', PostController::class);
    Route::post('posts/bulk-action', [PostController::class, 'bulkAction'])->name('posts.bulk-action');

    // Categories CRUD
    Route::resource('categories', CategoryController::class);

    // Tags
    Route::resource('tags', TagController::class)->except(['show', 'create', 'edit']);

    // Post Types
    Route::get('post-types', [PostTypeController::class, 'index'])->name('post-types.index');
    Route::post('post-types', [PostTypeController::class, 'store'])->name('post-types.store');
    Route::put('post-types/{postType}', [PostTypeController::class, 'update'])->name('post-types.update');
    Route::delete('post-types/{postType}', [PostTypeController::class, 'destroy'])->name('post-types.destroy');

    // Comments
    Route::get('comments', [CommentController::class, 'index'])->name('comments.index');
    Route::post('comments/{comment}/approve', [CommentController::class, 'approve'])->name('comments.approve');
    Route::post('comments/{comment}/reject', [CommentController::class, 'reject'])->name('comments.reject');
    Route::post('comments/{comment}/spam', [CommentController::class, 'spam'])->name('comments.spam');
    Route::delete('comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');

    // Users (Admin Management)
    Route::resource('users', UserController::class);
    Route::get('/profile', [UserController::class, 'profile'])->name('profile');
    Route::put('/profile', [UserController::class, 'updateProfile'])->name('profile.update');

    // Analytics
    Route::get('/analytics', [AnalyticsController::class, 'index'])->name('analytics');
    Route::get('/analytics/export', [AnalyticsController::class, 'export'])->name('analytics.export');

    // Sitemap & SEO
    Route::get('/sitemap', [SitemapController::class, 'index'])->name('sitemap.index');
    Route::post('/sitemap/generate', [SitemapController::class, 'generate'])->name('sitemap.generate');
    Route::get('/sitemap/preview', [SitemapController::class, 'preview'])->name('sitemap.preview');
    Route::put('/sitemap/robots', [SitemapController::class, 'updateRobots'])->name('sitemap.robots');
    Route::delete('/sitemap', [SitemapController::class, 'delete'])->name('sitemap.delete');

    // Upload
    Route::post('/upload/image', [UploadController::class, 'image'])->name('upload.image');

    // Settings
    Route::get('/settings', [SettingController::class, 'index'])->name('settings');
    Route::put('/settings', [SettingController::class, 'update'])->name('settings.update');
});