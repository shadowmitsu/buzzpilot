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
        Schema::create('original_services', function (Blueprint $table) {
            $table->id();
            $table->string('service_code');
            $table->string('category');
            $table->string('name');
            $table->string('type');
            $table->integer('price');
            $table->integer('min');
            $table->integer('max');
            $table->boolean('refill');
            $table->boolean('status');
            $table->text('note')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('original_services');
    }
};
