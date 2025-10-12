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
        Schema::create('user_activity_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('session_id')->nullable()->constrained('user_sessions')->onDelete('cascade');
            $table->string('activity_type')->default('page_visit'); // page_visit, login, logout, action
            $table->string('page_name')->nullable();
            $table->string('url')->nullable();
            $table->string('method')->default('GET'); // GET, POST, PUT, DELETE
            $table->text('description')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->timestamps();
            
            // Indexes untuk performa
            $table->index(['user_id', 'created_at']);
            $table->index('activity_type');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_activity_logs');
    }
};