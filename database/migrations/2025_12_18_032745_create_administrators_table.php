<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('administrators', function (Blueprint $table) {
            $table->id();
            $table->string('username', 50)->unique();
            $table->string('email', 100)->unique();
            $table->string('password_hash', 255);
            $table->string('full_name', 100)->nullable();
            $table->string('avatar', 255)->nullable();
            $table->enum('role', ['superadmin', 'super_admin', 'admin', 'moderator', 'editor'])->default('editor');
            $table->enum('status', ['active', 'inactive', 'suspended'])->default('active');
            $table->timestamp('last_login')->nullable();
            $table->tinyInteger('login_attempts')->default(0);
            $table->timestamp('locked_until')->nullable();
            $table->timestamps();
            $table->string('last_login_ip', 45)->nullable();
            $table->timestamp('last_login_at')->nullable();
            $table->unsignedInteger('failed_login_attempts')->default(0);
            $table->boolean('two_factor_enabled')->default(false);
            $table->string('two_factor_secret', 100)->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('administrators');
    }
};
