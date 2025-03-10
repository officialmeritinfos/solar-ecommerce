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
        Schema::create('order_item_specifications', function (Blueprint $table) {
            $table->id();

            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->foreignId('order_item_id')->constrained()->onDelete('cascade');
            $table->unsignedBigInteger('product_checkout_specification_id')->nullable();
            $table->foreign('product_checkout_specification_id', 'ois_pcsi_fk')
                ->references('id')
                ->on('product_checkout_specifications')
                ->onDelete('set null');

            $table->string('title'); // E.g., "Frame Color"
            $table->string('value'); // E.g., "Black"
            $table->decimal('price', 12, 2)->default(0.00); // Extra cost if any

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_item_specifications');
    }
};
