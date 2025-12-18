<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('software_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('post_id')->constrained()->onDelete('cascade');
            $table->string('version')->nullable();
            $table->string('developer')->nullable();
            $table->string('developer_url')->nullable();
            $table->string('license_type')->nullable();
            $table->decimal('price', 10, 2)->nullable();
            $table->string('currency', 10)->default('USD');
            $table->string('file_size')->nullable();
            $table->text('os_requirements')->nullable();
            $table->text('min_requirements')->nullable();
            $table->json('languages')->nullable();
            $table->string('platform')->nullable();
            $table->string('architecture')->nullable();
            $table->string('official_website')->nullable();
            $table->string('changelog_url')->nullable();
            $table->text('system_requirements')->nullable();
            $table->text('whats_new')->nullable();
            $table->json('screenshots')->nullable();
            $table->date('release_date')->nullable();
            $table->date('last_updated')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('software_details');
    }
};
