<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('category', ['Bank', 'E-Wallet', 'Other']);
            $table->text('description')->nullable();
            $table->bigInteger('min_deposit')->default(50000);
            $table->bigInteger('max_deposit')->default(10000000);
            $table->string('icon')->nullable();
            $table->boolean('status')->default(true);
            $table->timestamps();
        });
        
        DB::table('payments')->insert([
            ['name' => 'BRI', 'category' => 'Bank', 'description' => 'Bank Rakyat Indonesia', 'icon' => '/images/payment/bri.png'],
            ['name' => 'BCA', 'category' => 'Bank', 'description' => 'Bank Central Asia', 'icon' => '/images/payment/bca.png'],
            ['name' => 'BNI', 'category' => 'Bank', 'description' => 'Bank Negara Indonesia', 'icon' => '/images/payment/bni.png'],
            ['name' => 'Mandiri', 'category' => 'Bank', 'description' => 'Bank Mandiri', 'icon' => '/images/payment/mandiri.png'],
            ['name' => 'GoPay', 'category' => 'E-Wallet', 'description' => 'Go-Jek\'s Digital Wallet', 'icon' => '/images/payment/gopay.png'],
            ['name' => 'OVO', 'category' => 'E-Wallet', 'description' => 'Digital Wallet', 'icon' => '/images/payment/ovo.png'],
            ['name' => 'Dana', 'category' => 'E-Wallet', 'description' => 'Digital Wallet in Indonesia', 'icon' => '/images/payment/dana.png'],
            ['name' => 'ShopeePay', 'category' => 'E-Wallet', 'description' => 'Shopee Payment Service', 'icon' => '/images/payment/shopeepay.png'],
        ]);        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
