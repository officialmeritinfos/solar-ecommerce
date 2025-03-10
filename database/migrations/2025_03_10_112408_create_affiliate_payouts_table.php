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
        Schema::create('affiliate_payouts', function (Blueprint $table) {
            $table->id();

            // Link to affiliate user
            $table->foreignId('affiliate_id')
                ->constrained('users')
                ->onDelete('cascade');

            // Optional link to payout method used
            $table->foreignId('payout_method_id')
                ->nullable()
                ->constrained('affiliate_payout_methods')
                ->nullOnDelete();

            // Amount to be paid
            $table->decimal('amount', 12, 2)->default(0.00);

            // Currency (e.g. USD, NGN, BTC, USDT)
            $table->string('currency', 10)->default('USD');

            // Status of payout request
            $table->enum('status', ['pending', 'approved', 'rejected', 'paid'])->default('pending');

            // Optional fields for context
            $table->text('notes')->nullable();
            $table->timestamp('processed_at')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('affiliate_payouts');
    }
};
