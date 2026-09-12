<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * @property HasMany $products
 * @property HasMany $transactions
 * @property HasMany $categories
 * @property HasMany $ownerPaymentMethods
 * @property HasMany $subscriptions
 * @property HasMany $logs
 * @property \Illuminate\Database\Eloquent\Relations\BelongsTo $owner
 * @property \Illuminate\Database\Eloquent\Relations\HasOne $ownerSetting
 */
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'store_uuid',
        'app_name',
        'subscription_active',
        'subscription_expires_at',
        'has_storefront',
        'subscription_status',
        'subscription_valid_until',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'subscription_active' => 'boolean',
            'has_storefront' => 'boolean',
        ];
    }

    public function categories(): HasMany
    {
        return $this->hasMany(Category::class, 'owner_id');
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'owner_id');
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class, 'owner_id');
    }

    public function ownerPaymentMethods(): HasMany
    {
        return $this->hasMany(OwnerPaymentMethod::class, 'owner_id');
    }

    public function activePaymentMethods(): HasMany
    {
        return $this->hasMany(OwnerPaymentMethod::class, 'owner_id')->where('is_active', true)->orderByDesc('is_default');
    }

    public function ownerSetting()
    {
        return $this->hasOne(OwnerSetting::class, 'owner_id');
    }

    public function subscriptions(): HasMany
    {
        return $this->hasMany(Subscription::class, 'owner_id');
    }

    public function logs(): HasMany
    {
        return $this->hasMany(Log::class, 'user_id');
    }
}
