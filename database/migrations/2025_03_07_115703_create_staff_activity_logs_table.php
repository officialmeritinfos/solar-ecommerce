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
        Schema::create('staff_activity_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Staff who performed the action
            $table->string('action'); // Action performed (e.g., 'Created Product', 'Updated Order')
            $table->text('description')->nullable(); // More details about the action
            $table->string('ip_address')->nullable(); // IP of the user
            $table->string('user_agent')->nullable(); // Browser or device details
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('staff_activity_logs');
    }
};
