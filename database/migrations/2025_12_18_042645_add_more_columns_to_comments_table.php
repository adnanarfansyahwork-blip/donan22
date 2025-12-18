<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('comments', function (Blueprint $table) {
            if (!Schema::hasColumn('comments', 'parent_id')) {
                $table->foreignId('parent_id')->nullable()->after('post_id');
            }
            if (!Schema::hasColumn('comments', 'user_id')) {
                $table->foreignId('user_id')->nullable()->after('parent_id');
            }
            if (!Schema::hasColumn('comments', 'guest_name')) {
                $table->string('guest_name', 100)->nullable()->after('user_id');
            }
            if (!Schema::hasColumn('comments', 'guest_email')) {
                $table->string('guest_email', 255)->nullable()->after('guest_name');
            }
            if (!Schema::hasColumn('comments', 'deleted_at')) {
                $table->softDeletes();
            }
        });
    }

    public function down(): void
    {
        Schema::table('comments', function (Blueprint $table) {
            $table->dropColumn(['parent_id', 'user_id', 'guest_name', 'guest_email', 'deleted_at']);
        });
    }
};
