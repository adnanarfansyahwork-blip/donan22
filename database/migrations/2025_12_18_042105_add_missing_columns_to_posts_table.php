<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            // Add columns used by original model if not exists
            if (!Schema::hasColumn('posts', 'is_featured')) {
                $table->boolean('is_featured')->default(false)->after('featured');
            }
            if (!Schema::hasColumn('posts', 'is_trending')) {
                $table->boolean('is_trending')->default(false)->after('is_featured');
            }
            if (!Schema::hasColumn('posts', 'user_id')) {
                $table->foreignId('user_id')->nullable()->after('author_id')->constrained()->nullOnDelete();
            }
            if (!Schema::hasColumn('posts', 'views_count')) {
                $table->unsignedInteger('views_count')->default(0)->after('view_count');
            }
            if (!Schema::hasColumn('posts', 'downloads_count')) {
                $table->unsignedInteger('downloads_count')->default(0)->after('download_count');
            }
            if (!Schema::hasColumn('posts', 'comments_count')) {
                $table->unsignedInteger('comments_count')->default(0)->after('downloads_count');
            }
            if (!Schema::hasColumn('posts', 'featured_image_alt')) {
                $table->string('featured_image_alt')->nullable()->after('featured_image');
            }
            if (!Schema::hasColumn('posts', 'canonical_url')) {
                $table->string('canonical_url')->nullable()->after('meta_keywords');
            }
            if (!Schema::hasColumn('posts', 'is_indexable')) {
                $table->boolean('is_indexable')->default(true)->after('canonical_url');
            }
            if (!Schema::hasColumn('posts', 'show_toc')) {
                $table->boolean('show_toc')->default(false)->after('allow_comments');
            }
        });
    }

    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropColumn(['is_featured', 'is_trending', 'user_id', 'views_count', 'downloads_count', 'comments_count', 'featured_image_alt', 'canonical_url', 'is_indexable', 'show_toc']);
        });
    }
};
