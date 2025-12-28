<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('subscribers', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique();
            $table->string('name')->nullable();
            $table->enum('status', ['pending', 'active', 'unsubscribed'])->default('active');
            $table->string('token')->nullable()->unique(); // For unsubscribe link
            $table->timestamp('subscribed_at')->nullable();
            $table->timestamp('unsubscribed_at')->nullable();
            $table->string('ip_address')->nullable();
            $table->string('user_agent')->nullable();
            $table->timestamps();

            $table->index('status');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscribers');
    }
};
