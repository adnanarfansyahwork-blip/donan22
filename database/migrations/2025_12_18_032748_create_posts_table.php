<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('post_type_id')->nullable()->constrained('post_types')->nullOnDelete();
            $table->foreignId('category_id')->nullable()->constrained('categories')->nullOnDelete();
            $table->string('post_type', 50)->default('software');
            $table->unsignedBigInteger('secondary_category_id')->nullable();
            $table->foreignId('author_id')->nullable()->constrained('administrators')->nullOnDelete();
            $table->string('title', 255);
            $table->string('slug', 255)->unique();
            $table->longText('content')->nullable();
            $table->string('featured_image', 255)->nullable();
            $table->text('excerpt')->nullable();
            $table->string('file_size', 20)->nullable();
            $table->string('version', 50)->nullable();
            $table->string('platform', 100)->nullable();
            $table->string('meta_title', 255)->nullable();
            $table->text('meta_description')->nullable();
            $table->string('meta_keywords', 500)->nullable();
            $table->string('focus_keyword', 100)->nullable();
            $table->tinyInteger('seo_score')->nullable();
            $table->enum('status', ['draft', 'published', 'private', 'scheduled'])->default('draft');
            $table->boolean('featured')->default(false);
            $table->boolean('allow_comments')->default(true);
            $table->unsignedInteger('views')->default(0);
            $table->timestamp('scheduled_at')->nullable();
            $table->datetime('published_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->unsignedBigInteger('deleted_by')->nullable();
            $table->text('delete_reason')->nullable();
            $table->timestamp('restored_at')->nullable();
            $table->unsignedBigInteger('restored_by')->nullable();
            $table->unsignedInteger('downloads')->default(0);
            $table->unsignedInteger('view_count')->default(0);
            $table->unsignedInteger('download_count')->default(0);
            $table->boolean('is_paraphrased')->default(false);
            $table->datetime('paraphrased_at')->nullable();
            $table->tinyInteger('paraphrase_percentage')->nullable();
            $table->unsignedInteger('paraphrase_count')->default(0);
            
            $table->index(['status', 'published_at']);
            $table->index('category_id');
            $table->index('post_type');
            $table->fullText(['title', 'content']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
