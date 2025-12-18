<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('comments', function (Blueprint $table) {
            $table->foreignId('post_id')->nullable()->after('id')->constrained()->onDelete('cascade');
            $table->string('name', 100)->nullable()->after('post_id');
            $table->string('email', 150)->nullable()->after('name');
            $table->text('content')->nullable()->after('email');
            $table->string('status', 20)->default('pending')->after('content');
            $table->string('ip_address', 45)->nullable()->after('status');
            $table->text('user_agent')->nullable()->after('ip_address');
        });
    }

    public function down(): void
    {
        Schema::table('comments', function (Blueprint $table) {
            $table->dropForeign(['post_id']);
            $table->dropColumn(['post_id', 'name', 'email', 'content', 'status', 'ip_address', 'user_agent']);
        });
    }
};
