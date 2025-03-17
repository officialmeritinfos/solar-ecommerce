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
        Schema::create('product_photos', function (Blueprint $table) {
            $table->id();

            // Foreign key to products
            $table->foreignId('product_id')
                ->constrained()
                ->onDelete('cascade');

            // Path to image stored in public/products or storage path
            $table->string('path');

            // Optional title/alt for SEO or admin clarity
            $table->string('alt_text')->nullable();

            // If this image is set as the primary display image (useful in galleries)
            $table->boolean('is_primary')->default(false);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_photos');
    }
};
