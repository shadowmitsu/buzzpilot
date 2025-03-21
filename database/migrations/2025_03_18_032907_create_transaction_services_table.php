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
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('user_id');
            $table->string('trx_id');
            $table->string('name');
            $table->string('type');
            $table->integer('price');
            $table->boolean('refill');
            $table->string('qty');
            $table->string('subtotal');
            $table->string('amount_before');
            $table->string('remaining_amount');
            $table->enum('status', ['pending', 'process', 'canceled', 'success'])->default('pending');
            $table->string('link_target')->nullable();
            $table->text('comment')->nullable();
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
