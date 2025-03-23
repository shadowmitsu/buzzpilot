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
            $table->string('reference')->unique();
            $table->string('merchant_ref');
            $table->string('payment_selection_type')->nullable(); // Bisa static/dynamic
            $table->string('payment_method'); // Contoh: BRIVA
            $table->string('payment_name'); // Contoh: BRI Virtual Account
            $table->string('customer_name');
            $table->string('customer_email');
            $table->string('customer_phone');
            $table->string('callback_url')->nullable();
            $table->string('return_url')->nullable();
            $table->decimal('amount', 15, 2); // Jumlah nominal transaksi
            $table->decimal('fee_merchant', 15, 2)->default(0); // Biaya merchant
            $table->decimal('fee_customer', 15, 2)->default(0); // Biaya customer
            $table->decimal('total_fee', 15, 2)->default(0);
            $table->decimal('amount_received', 15, 2);
            $table->string('pay_code');
            $table->string('pay_url')->nullable();
            $table->string('checkout_url');
            $table->string('status'); // Contoh status: UNPAID, PAID, EXPIRED
            $table->timestamp('expired_time');
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
