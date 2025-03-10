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
        Schema::create('product_categories', function (Blueprint $table) {
            $table->id();

            // Optional parent ID for subcategories
            $table->foreignId('parent_id')->nullable()->constrained('product_categories')->onDelete('cascade');

            $table->string('name');                  // Category Name
            $table->string('slug')->unique();        // SEO-friendly URL slug
            $table->text('description')->nullable(); // Optional description

            $table->string('image')->nullable();     // Optional category image path

            $table->boolean('is_active')->default(true); // Can be used to toggle visibility

            $table->timestamps();
            $table->softDeletes();                   // Allows restoring deleted categories
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_categories');
    }
};
