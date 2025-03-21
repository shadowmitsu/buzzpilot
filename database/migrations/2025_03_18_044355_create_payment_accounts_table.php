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
        Schema::create('payment_accounts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('payment_id'); // Reference to the payment method
            $table->string('account_number'); // Account number (bank account number or e-wallet ID)
            $table->string('account_name'); // Account holder's name
            $table->boolean('is_active')->default(true); // Active/inactive status
            $table->timestamps();
            $table->foreign('payment_id')->references('id')->on('payments')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_accounts');
    }
};
