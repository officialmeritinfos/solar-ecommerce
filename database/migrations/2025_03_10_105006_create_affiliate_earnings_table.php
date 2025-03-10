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
        Schema::create('affiliate_earnings', function (Blueprint $table) {
            $table->id();

            // The user who is the affiliate (uses the users table)
            $table->foreignId('affiliate_id')->constrained('users')->onDelete('cascade');

            // The referred customer (also from users table)
            $table->foreignId('referred_user_id')->nullable()->constrained('users')->nullOnDelete();

            // The order associated with the earning
            $table->foreignId('order_id')->constrained()->onDelete('cascade');

            // Earnings breakdown
            $table->decimal('amount', 12, 2)->default(0.00);
            $table->decimal('commission_rate', 5, 2)->nullable(); // in percentage, e.g., 10.00%

            // Status of the earning
            $table->enum('status', ['pending', 'approved', 'paid', 'cancelled'])->default('pending');

            // Optional note or description
            $table->text('note')->nullable();

            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('affiliate_earnings');
    }
};
