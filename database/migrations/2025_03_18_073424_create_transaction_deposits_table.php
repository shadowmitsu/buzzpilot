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
        Schema::create('transaction_deposits', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id'); // ID user yang melakukan deposit
            $table->bigInteger('payment_channel_id'); // ID channel pembayaran (QRIS, MPM, dsb.)
            $table->string('session_id'); // Session ID dari transaksi
            $table->bigInteger('transaction_id'); // ID transaksi dari sistem pembayaran
            $table->string('reference_id'); // Reference ID untuk pelacakan
            $table->string('via'); // Metode pembayaran (e.g. QRIS)
            $table->string('channel'); // Channel pembayaran (e.g. MPM)
            $table->string('payment_no'); // Nomor pembayaran atau QR code
            $table->text('qr_string'); // QR String dari pembayaran
            $table->string('payment_name'); // Nama metode pembayaran (e.g. iPaymu)
            $table->bigInteger('subtotal'); // Subtotal dari transaksi
            $table->bigInteger('fee'); // Biaya transaksi
            $table->bigInteger('total'); // Total transaksi
            $table->enum('fee_direction', ['BUYER', 'SELLER']); // Arah biaya (Buyer atau Seller)
            $table->timestamp('expired'); // Waktu kadaluarsa pembayaran
            $table->string('qr_image')->nullable(); // Link ke gambar QR Code
            $table->string('qr_template')->nullable(); // Link ke template QR Code
            $table->string('terminal')->nullable(); // Terminal ID
            $table->string('nns_code')->nullable(); // NNS Code, bisa kosong
            $table->string('nmid')->nullable(); // NMID, bisa kosong
            $table->text('note')->nullable(); // Catatan transaksi, bisa kosong
            $table->boolean('escrow')->default(false); // Apakah transaksi menggunakan escrow
            $table->enum('status', ['pending', 'process', 'approved', 'rejected', 'canceled']); // Status transaksi
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaction_deposits');
    }
};
