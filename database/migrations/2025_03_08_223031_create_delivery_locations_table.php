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
        // Main Delivery Locations Table
        Schema::create('delivery_locations', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique(); // State/City Name
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Sub Locations Table
        Schema::create('delivery_sub_locations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('delivery_location_id')->constrained('delivery_locations')->onDelete('cascade');
            $table->string('name'); // Town or Neighborhood
            $table->decimal('delivery_price', 10, 2); // Delivery price in currency
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('delivery_sub_locations');
        Schema::dropIfExists('delivery_locations');
    }
};
