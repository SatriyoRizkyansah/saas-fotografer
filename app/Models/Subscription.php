<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Subscription extends Model
{
    protected $fillable = [
        'owner_id',
        'plan_name',
        'plan_price',
        'start_date',
        'end_date',
        'is_active',
    ];

    protected $casts = [
        'plan_price' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeCurrent($query)
    {
        return $query->whereDate('start_date', '<=', now())
                     ->whereDate('end_date', '>=', now());
    }
}
