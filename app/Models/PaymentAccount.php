<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentAccount extends Model
{
    use HasFactory;

    protected $fillable = [
        'payment_id',
        'account_number',
        'account_name',
        'is_active',
    ];

    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }
}
