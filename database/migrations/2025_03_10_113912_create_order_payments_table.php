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
        Schema::create('order_payments', function (Blueprint $table) {
            $table->id();

            $table->foreignId('order_id')->constrained('orders')->onDelete('cascade');
            $table->string('payment_reference')->unique();
            $table->decimal('amount', 12, 2)->default(0.00);
            $table->string('currency', 10)->default('NGN');

            $table->string('payment_method'); // e.g. card, bank_transfer, crypto, USSD
            $table->string('payment_gateway')->nullable(); // e.g. Paystack, Flutterwave, Stripe

            $table->string('status')->default('pending'); // pending, successful, failed, refunded

            $table->json('meta')->nullable(); // Any additional data or gateway response

            $table->timestamp('paid_at')->nullable(); // Time payment was completed

            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_payments');
    }
};
