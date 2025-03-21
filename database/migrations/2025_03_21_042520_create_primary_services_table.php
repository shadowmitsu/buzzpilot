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
        Schema::create('primary_services', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('original_service_id');
            $table->bigInteger('digital_platform_id');
            $table->bigInteger('interaction_type_id');
            $table->string('name');
            $table->string('category');
            $table->bigInteger('old_price');
            $table->bigInteger('price');
            $table->integer('min')->default(100);
            $table->integer('max')->default(1000000);
            $table->enum('type', ['hemat', 'sultan'])->default('hemat');
            $table->boolean('status')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('primary_services');
    }
};
