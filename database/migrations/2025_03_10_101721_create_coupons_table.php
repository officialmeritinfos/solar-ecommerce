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
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();

            // Unique coupon code
            $table->string('code')->unique();

            // Discount type: fixed amount or percentage
            $table->enum('discount_type', ['fixed', 'percent'])->default('fixed');

            // Discount value (e.g. 20 or 10%)
            $table->decimal('discount_value', 12, 2)->default(0);

            // Optional max discount amount for percentage coupons
            $table->decimal('max_discount', 12, 2)->nullable();

            // Minimum order total to apply this coupon
            $table->decimal('min_order_amount', 12, 2)->nullable();

            // Total number of times this coupon can be used
            $table->unsignedInteger('usage_limit')->nullable();

            // Limit per user (if any)
            $table->unsignedInteger('usage_limit_per_user')->nullable();

            // Whether the coupon is for a specific user
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');

            // Whether the coupon is applicable to specific products
            $table->boolean('is_product_specific')->default(false);

            // Whether multiple coupons can be used together
            $table->boolean('is_stackable')->default(false);

            // Start and end date
            $table->timestamp('start_date')->nullable();
            $table->timestamp('end_date')->nullable();

            // Status of the coupon
            $table->boolean('is_active')->default(true);

            // Optional note or description
            $table->text('description')->nullable();

            $table->timestamps();
        });

        Schema::create('coupon_product', function (Blueprint $table) {
            $table->id();

            $table->foreignId('coupon_id')->constrained()->onDelete('cascade');
            $table->foreignId('product_id')->constrained()->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coupons');
    }
};
