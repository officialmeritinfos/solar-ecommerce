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
        Schema::create('coupon_usages', function (Blueprint $table) {
            $table->id();

            // Which coupon was used
            $table->foreignId('coupon_id')->constrained()->onDelete('cascade');

            // Which user used it
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');

            // Optional order reference if used during checkout
            $table->foreignId('order_id')->nullable()->constrained()->onDelete('set null');

            // Amount discounted in this usage
            $table->decimal('discount_applied', 12, 2)->default(0);

            // IP address for tracking
            $table->string('ip_address')->nullable();

            // User Agent / Device Info
            $table->text('user_agent')->nullable();

            // Timestamp of use
            $table->timestamp('used_at')->useCurrent();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coupon_usages');
    }
};
