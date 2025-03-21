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
        Schema::create('transaction_top_ups', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('payment_channel_id')->constrained()->onDelete('cascade');
            $table->string('session_id');
            $table->string('transaction_id');
            $table->string('reference_id');
            $table->string('via');
            $table->string('channel');
            $table->string('payment_no');
            $table->string('qr_string')->default('-');
            $table->string('payment_name');
            $table->decimal('subtotal', 15, 2);
            $table->decimal('fee', 15, 2);
            $table->decimal('total', 15, 2);
            $table->string('fee_direction');
            $table->timestamp('expired');
            $table->string('qr_image')->default('-');
            $table->string('qr_template')->default('-');
            $table->string('status')->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaction_top_ups');
    }
};
