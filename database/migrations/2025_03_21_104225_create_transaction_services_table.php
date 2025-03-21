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
        Schema::create('transaction_services', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id');
            $table->bigInteger('primary_service_id');
            $table->bigInteger('digital_platform_id');
            $table->bigInteger('interaction_type_id');
            $table->bigInteger('trx_code');
            $table->string('name');
            $table->string('category');
            $table->string('type');
            $table->string('refill');
            $table->bigInteger('qty');
            $table->bigInteger('price');
            $table->bigInteger('total');
            $table->bigInteger('start_count')->default(0);
            $table->bigInteger('remains')->default(0);
            $table->text('target_link');
            $table->text('comments')->nullable();
            $table->enum('status', ['process', 'completed', 'canceled'])->default('process');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaction_services');
    }
};
