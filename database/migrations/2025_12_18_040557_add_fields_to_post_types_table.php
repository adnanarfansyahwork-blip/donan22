<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('post_types', function (Blueprint $table) {
            $table->string('name', 100)->after('id');
            $table->string('slug', 100)->unique()->after('name');
            $table->text('description')->nullable()->after('slug');
            $table->string('icon', 50)->nullable()->after('description');
            $table->boolean('is_active')->default(true)->after('icon');
        });
    }

    public function down(): void
    {
        Schema::table('post_types', function (Blueprint $table) {
            $table->dropColumn(['name', 'slug', 'description', 'icon', 'is_active']);
        });
    }
};
