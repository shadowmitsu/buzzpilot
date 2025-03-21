<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OriginalService extends Model
{
    use HasFactory;

    protected $fillable = ['service_code','name', 'category','type', 'category_id', 'price', 'min', 'max', 'refill', 'status', 'note'];
}
