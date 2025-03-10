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
        Schema::create('affiliate_payout_methods', function (Blueprint $table) {
            $table->id();

            // Link to affiliate user
            $table->foreignId('user_id')
                ->constrained('users')
                ->onDelete('cascade');

            // Payout type: bank, paypal, crypto, etc.
            $table->string('method'); // e.g., 'bank', 'paypal', 'btc'

            // Payout details as JSON (structured per method)
            $table->json('details');

            // Whether this method is the default
            $table->boolean('is_default')->default(false);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('affiliate_payout_methods');
    }
};
