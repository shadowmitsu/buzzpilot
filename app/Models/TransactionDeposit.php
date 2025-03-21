<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionDeposit extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'payment_channel_id',
        'session_id',
        'transaction_id',
        'reference_id',
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
        'terminal',
        'nns_code',
        'nmid',
        'note',
        'escrow',
        'status',
    ];

    public function paymentChannel()
    {
        return $this->hasOne(PaymentChannel::class, 'id', 'payment_channel_id');
    }
}
