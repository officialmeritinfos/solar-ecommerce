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
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();

            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->foreignId('product_variant_id')->nullable()->constrained()->onDelete('set null');

            $table->string('product_name'); // snapshot of product name at time of order
            $table->string('sku')->nullable();
            $table->string('brand')->nullable();

            $table->decimal('unit_price', 12, 2); // price per item
            $table->integer('quantity');
            $table->decimal('total', 12, 2); // unit_price * quantity

            $table->text('notes')->nullable(); // Optional notes (e.g., custom requests)

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
