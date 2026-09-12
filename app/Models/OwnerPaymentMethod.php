<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class OwnerPaymentMethod extends Model
{
    protected $fillable = [
        'owner_id',
        'bank_name',
        'account_number',
        'account_name',
        'type',
        'is_default',
        'is_active',
    ];

    protected $casts = [
        'is_default' => 'boolean',
        'is_active'  => 'boolean',
    ];

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class, 'payment_method_id');
    }

    /**
     * Label lengkap: "BCA — 1234567890 a/n John"
     */
    public function getLabelAttribute(): string
    {
        return "{$this->bank_name} — {$this->account_number} a/n {$this->account_name}";
    }
}
