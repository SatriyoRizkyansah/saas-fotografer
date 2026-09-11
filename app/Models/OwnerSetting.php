<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OwnerSetting extends Model
{
    protected $fillable = [
        'owner_id',
        'store_name',
        'store_description',
        'store_logo',
        'store_cover_image',
        'brand_color',
        'social_links',
        'is_published',
    ];

    protected $casts = [
        'social_links' => 'json',
        'is_published' => 'boolean',
    ];

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id');
    }
}
