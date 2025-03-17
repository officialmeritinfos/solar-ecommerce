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
        Schema::create('products', function (Blueprint $table) {
            $table->id();

            // Core product data
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('sku')->nullable();
            $table->string('barcode')->nullable();
            $table->enum('type', ['physical', 'digital', 'service'])->default('physical');
            $table->text('short_description')->nullable();
            $table->longText('description')->nullable();
            $table->mediumText('specifications')->nullable();

            $table->string('featuredImage')->nullable();

            $table->foreignId('product_category_id')->nullable();
            $table->foreign('product_category_id')->references('id')->on('product_categories')->onDelete('set null');



            // Pricing
            $table->decimal('price', 12, 2)->default(0.00);
            $table->decimal('sale_price', 12, 2)->nullable();
            $table->timestamp('sale_start_date')->nullable();
            $table->timestamp('sale_end_date')->nullable();

            // Inventory & shipping
            $table->boolean('track_inventory')->default(true);
            $table->integer('quantity')->nullable();
            $table->integer('low_stock_threshold')->nullable();
            $table->boolean('requires_shipping')->default(true);
            $table->decimal('weight', 10, 2)->nullable();
            $table->decimal('length', 10, 2)->nullable();
            $table->decimal('width', 10, 2)->nullable();
            $table->decimal('height', 10, 2)->nullable();

            // Digital product
            $table->string('digital_file_path')->nullable();

            // Visibility & status
            $table->enum('status', ['draft', 'active', 'inactive', 'archived'])->default('draft');
            $table->boolean('featured')->default(false);
            $table->boolean('visible')->default(true);

            // SEO
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();

            // Optional brand (no foreign key)
            $table->string('brand')->nullable();

            $table->string('dimension')->default('cm');


            // Tags (JSON stringified array)
            $table->json('tags')->nullable();

            // Variants & specs
            $table->boolean('is_variable')->default(false); // whether to expect variants

            // Creator/vendor
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');

            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('product_variants', function (Blueprint $table) {
            $table->id();

            $table->foreignId('product_id')->constrained()->onDelete('cascade');

            $table->string('name'); // e.g., "Red - Large", or "64GB"
            $table->string('sku')->nullable();
            $table->decimal('price', 12, 2)->nullable(); // if set, overrides product price
            $table->integer('quantity')->nullable(); // optional variant inventory
            $table->json('attributes')->nullable(); // { "color": "red", "size": "L" }

            $table->timestamps();
        });

        Schema::create('product_specifications', function (Blueprint $table) {
            $table->id();

            $table->foreignId('product_id')->constrained()->onDelete('cascade');

            $table->string('label'); // e.g., "Battery Life"
            $table->string('value'); // e.g., "10 hours"

            $table->timestamps();
        });

        Schema::create('product_checkout_specifications', function (Blueprint $table) {
            $table->id();

            $table->foreignId('product_id')->constrained()->onDelete('cascade');

            $table->string('label'); // e.g., "Text Engraving", "Gift Wrap"
            $table->decimal('price', 12, 2)->default(0.00); // Additional cost if selected
            $table->boolean('is_required')->default(false); // Whether it's mandatory
            $table->boolean('active')->default(true); // You can soft-disable specs if needed

            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
        Schema::dropIfExists('product_variants');
        Schema::dropIfExists('product_specifications');
        Schema::dropIfExists('product_checkout_specifications');
    }
};
