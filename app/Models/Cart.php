<?php

namespace App\Models;

use Database\Factories\CartFactory;
use Illuminate\Database\Eloquent\Attributes\Computed;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Cart extends Model
{
    /** @use HasFactory<CartFactory> */
    use HasFactory;

    public const STATUS_ACTIVE = 'active';

    public const STATUS_CONVERTED = 'converted';

    public const STATUS_ABANDONED = 'abandoned';

    protected $fillable = [
        'user_id',
        'status',
        'currency',
        'total_items',
        'subtotal',
        'converted_at',
        'expired_at',
    ];

    protected $appends = [
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'user_id' => 'integer',
            'total_items' => 'integer',
            'subtotal' => 'decimal:2',
            'converted_at' => 'datetime',
            'expired_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', self::STATUS_ACTIVE);
    }

    public function items(): HasMany
    {
        return $this->hasMany(CartItem::class);
    }

    public function order(): HasOne
    {
        return $this->hasOne(Order::class);
    }

    #[Computed]
    public function isActive(): bool
    {
        return $this->status === self::STATUS_ACTIVE;
    }

    public function getSubtotalLabelAttribute(): string
    {
        return 'Rp'.number_format((int) round((float) $this->subtotal), 0, ',', '.');
    }

    public function getTotalLabelAttribute(): string
    {
        return $this->subtotal_label;
    }
}
