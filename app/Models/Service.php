<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = ['service_code','name', 'type', 'category_id', 'price', 'min', 'max', 'refill', 'status', 'note'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
