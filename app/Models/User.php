<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'username', 'email', 'full_name', 'whatsapp_number', 'password', 'role', 'verification_token'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function userBalance() 
    {
        return $this->hasOne(UserBalance::class, 'user_id', 'id');
    }

    public function userTransactionService()
    {
        return $this->hasMany(TransactionService::class, 'user_id', 'id');
    }
}
