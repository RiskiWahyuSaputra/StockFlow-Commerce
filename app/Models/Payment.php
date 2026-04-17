<?php

namespace App\Models;

use Database\Factories\PaymentFactory;
use Illuminate\Database\Eloquent\Attributes\Computed;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    /** @use HasFactory<PaymentFactory> */
    use HasFactory;

    public const STATUS_PENDING = 'pending';

    public const STATUS_PAID = 'paid';

    public const STATUS_FAILED = 'failed';

    public const STATUS_EXPIRED = 'expired';

    public const STATUS_CANCELLED = 'cancelled';

    public const STATUS_REFUNDED = 'refunded';

    protected $fillable = [
        'order_id',
        'provider',
        'method',
        'payment_type',
        'status',
        'amount',
        'gross_amount',
        'currency',
        'external_id',
        'transaction_id',
        'transaction_status',
        'fraud_status',
        'status_code',
        'signature_key',
        'snap_token',
        'snap_redirect_url',
        'transaction_time',
        'paid_at',
        'expired_at',
        'failure_code',
        'failure_message',
        'payload',
    ];

    protected $appends = [
        'is_successful',
    ];

    protected function casts(): array
    {
        return [
            'order_id' => 'integer',
            'amount' => 'decimal:2',
            'gross_amount' => 'decimal:2',
            'transaction_time' => 'datetime',
            'paid_at' => 'datetime',
            'expired_at' => 'datetime',
            'payload' => 'array',
        ];
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    #[Computed]
    public function isSuccessful(): bool
    {
        return $this->status === self::STATUS_PAID;
    }

    public function getAmountLabelAttribute(): string
    {
        return 'Rp'.number_format((int) round((float) $this->amount), 0, ',', '.');
    }

    public function getGrossAmountLabelAttribute(): string
    {
        $amount = $this->gross_amount ?? $this->amount;

        return 'Rp'.number_format((int) round((float) $amount), 0, ',', '.');
    }
}
