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
        Schema::create('general_settings', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('support_email');
            $table->string('support_phone');
            $table->string('address');
            $table->string('logo')->nullable();
            $table->string('registration_number')->nullable();
            $table->string('favicon')->nullable();
            $table->boolean('oem_registration')->default(true);
            $table->boolean('engineer_registration')->default(true);
            $table->boolean('customer_registration')->default(true);
            $table->boolean('affiliate_registration')->default(true);
            $table->boolean('online_checkout')->default(true);
            $table->boolean('maintenance_mode')->default(false);
            $table->string('file_upload_max_size')->default(1024);
            $table->string('currency')->default('NGN');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('general_settings');
    }
};
