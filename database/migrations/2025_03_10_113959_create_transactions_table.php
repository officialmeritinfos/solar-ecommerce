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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();

            $table->uuid('transaction_reference')->unique(); // For tracing any type of transaction
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');

            $table->string('type'); // order_payment, affiliate_payout, registration, admin_fee, refund
            $table->decimal('amount', 12, 2);
            $table->string('currency', 10)->default('NGN');

            $table->string('status')->default('pending'); // pending, success, failed

            $table->nullableMorphs('source');
            // source_type: App\Models\OrderPayment / AffiliatePayout etc.
            // source_id: ID of that source

            $table->json('meta')->nullable(); // Gateway info or notes

            $table->timestamp('processed_at')->nullable();

            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
