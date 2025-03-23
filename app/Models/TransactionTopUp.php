<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionTopUp extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'payment_channel_id',
        'reference',          // Reference dari Tripay
        'merchant_ref',       // Merchant reference
        'payment_method',     // Metode pembayaran (misal: BRIVA)
        'payment_name',       // Nama metode pembayaran (misal: BRI Virtual Account)
        'customer_name',      // Nama pelanggan
        'customer_email',     // Email pelanggan
        'customer_phone',     // Nomor telepon pelanggan
        'callback_url',       // URL untuk callback
        'return_url',         // URL pengembalian
        'amount',             // Jumlah pembayaran
        'fee_merchant',       // Biaya untuk merchant
        'fee_customer',       // Biaya untuk customer
        'total_fee',          // Total biaya
        'amount_received',    // Jumlah yang diterima setelah potongan biaya
        'pay_code',           // Kode pembayaran (misal: Virtual Account)
        'pay_url',            // URL pembayaran jika ada
        'checkout_url',       // URL untuk proses checkout
        'status',             // Status pembayaran (misal: UNPAID, PAID)
        'expired_time',       // Waktu kadaluarsa pembayaran
    ];

    public function paymentChannel()
    {
        return $this->hasOne(PaymentChannel::class, 'id', 'payment_channel_id');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
    
}
