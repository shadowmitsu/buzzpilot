<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrimaryService extends Model
{
    use HasFactory;

    public function digitalPlatform()
    {
        return $this->hasOne(DigitalPlatform::class, 'id', 'digital_platform_id');
    }

    public function interactionType()
    {
        return $this->hasOne(InteractionType::class, 'id', 'interaction_type_id');
    }

    public function originalService()
    {
        return $this->hasOne(OriginalService::class, 'id', 'original_service_id');
    }
}
