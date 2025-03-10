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
        Schema::table('orders', function (Blueprint $table) {
            // Add affiliate_id (nullable, user must be marked as affiliate)
            $table->foreignId('affiliate_id')
                ->nullable()
                ->after('user_id')
                ->constrained('users')
                ->nullOnDelete();

            // Add affiliate_earning_id (nullable, links to affiliate_earnings table)
            $table->foreignId('affiliate_earning_id')
                ->nullable()
                ->after('affiliate_id')
                ->constrained('affiliate_earnings')
                ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign(['affiliate_id']);
            $table->dropColumn('affiliate_id');

            $table->dropForeign(['affiliate_earning_id']);
            $table->dropColumn('affiliate_earning_id');
        });
    }
};
