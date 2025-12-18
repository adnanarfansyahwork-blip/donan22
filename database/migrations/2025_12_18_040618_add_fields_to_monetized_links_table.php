<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('monetized_links', function (Blueprint $table) {
            $table->unsignedBigInteger('post_id')->after('id');
            $table->string('label', 100)->default('Download')->after('post_id');
            $table->text('original_url')->after('label');
            $table->text('monetized_url')->nullable()->after('original_url');
            $table->string('file_size', 50)->nullable()->after('monetized_url');
            $table->integer('click_count')->default(0)->after('file_size');
            $table->boolean('is_active')->default(true)->after('click_count');

            $table->foreign('post_id')->references('id')->on('posts')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('monetized_links', function (Blueprint $table) {
            $table->dropForeign(['post_id']);
            $table->dropColumn(['post_id', 'label', 'original_url', 'monetized_url', 'file_size', 'click_count', 'is_active']);
        });
    }
};
