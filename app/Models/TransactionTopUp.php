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
        'session_id',
        'transaction_id',
        'reference_id',
        'va',
        'via',
        'channel',
        'payment_no',
        'qr_string',
        'payment_name',
        'subtotal',
        'fee',
        'total',
        'fee_direction',
        'expired',
        'qr_image',
        'qr_template',
        'status',
        'paid_status'
    ];

    public function paymentChannel()
    {
        return $this->hasOne(PaymentChannel::class, 'id', 'payment_channel_id');
    }
    
}
