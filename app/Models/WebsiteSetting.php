<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WebsiteSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'web_name',
        'web_description',
        'web_logo',
        'web_favicon',
        'irvan_url',
        'irvan_app_id',
        'irvan_app_key'
    ];
}
