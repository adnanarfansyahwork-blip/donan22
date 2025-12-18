<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('page_views', function (Blueprint $table) {
            $table->unsignedBigInteger('post_id')->nullable()->after('id');
            $table->string('ip_address', 45)->nullable()->after('post_id');
            $table->text('user_agent')->nullable()->after('ip_address');
            $table->text('referer')->nullable()->after('user_agent');
            $table->string('device_type', 20)->default('desktop')->after('referer');
            $table->string('session_id', 100)->nullable()->after('device_type');

            $table->index('post_id');
            $table->index('ip_address');
        });
    }

    public function down(): void
    {
        Schema::table('page_views', function (Blueprint $table) {
            $table->dropIndex(['post_id']);
            $table->dropIndex(['ip_address']);
            $table->dropColumn(['post_id', 'ip_address', 'user_agent', 'referer', 'device_type', 'session_id']);
        });
    }
};
