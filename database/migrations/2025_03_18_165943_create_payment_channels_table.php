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
        Schema::create('payment_channels', function (Blueprint $table) {
            $table->id();
            $table->string('group');
            $table->string('code');
            $table->string('name');
            $table->string('type');
            $table->decimal('fee_merchant_flat', 10, 2)->default(0);
            $table->decimal('fee_merchant_percent', 5, 2)->default(0);
            $table->decimal('fee_customer_flat', 10, 2)->default(0);
            $table->decimal('fee_customer_percent', 5, 2)->default(0);
            $table->decimal('total_fee_flat', 10, 2)->default(0);
            $table->decimal('total_fee_percent', 5, 2)->default(0);
            $table->decimal('minimum_fee', 10, 2)->nullable();
            $table->decimal('maximum_fee', 10, 2)->nullable();
            $table->decimal('minimum_amount', 15, 2);
            $table->decimal('maximum_amount', 15, 2);
            $table->string('icon_url');
            $table->boolean('active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_channels');
    }
};
