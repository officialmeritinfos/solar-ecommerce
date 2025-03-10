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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            // Buyer
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');

            // Optional coupon used
            $table->foreignId('coupon_id')->nullable()->constrained()->onDelete('set null');

            // Unique order reference
            $table->string('order_reference')->unique();

            // Billing & Shipping
            $table->string('billing_name');
            $table->string('billing_email');
            $table->string('billing_phone')->nullable();
            $table->text('billing_address')->nullable();

            $table->string('shipping_name')->nullable();
            $table->string('shipping_email')->nullable();
            $table->string('shipping_phone')->nullable();
            $table->text('shipping_address')->nullable();

            // Optional delivery link to a delivery sub-location
            $table->foreignId('delivery_sub_location_id')->nullable()->constrained()->onDelete('set null');
            $table->decimal('delivery_fee', 10, 2)->nullable();

            // Order financials
            $table->decimal('subtotal', 12, 2);         // total without discount/shipping
            $table->decimal('discount', 12, 2)->default(0); // from coupon
            $table->decimal('tax', 12, 2)->default(0);
            $table->decimal('total', 12, 2);            // grand total

            // Payment info
            $table->enum('payment_method', ['card', 'bank_transfer', 'wallet', 'cash_on_delivery'])->nullable();
            $table->enum('payment_status', ['pending', 'paid', 'failed', 'refunded'])->default('pending');
            $table->timestamp('paid_at')->nullable();

            // Fulfillment & order status
            $table->enum('status', ['pending', 'processing', 'shipped', 'delivered', 'cancelled'])->default('pending');
            $table->timestamp('shipped_at')->nullable();
            $table->timestamp('delivered_at')->nullable();

            // Tracking
            $table->string('ip_address')->nullable();
            $table->text('user_agent')->nullable();
            $table->string('notes')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
