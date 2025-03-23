<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    // Relasi ke Message
    public function messages()
    {
        return $this->hasMany(TicketMessage::class);
    }

    // Relasi ke User (pembuat tiket)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
