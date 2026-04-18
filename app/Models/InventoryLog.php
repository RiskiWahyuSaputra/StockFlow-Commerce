<?php

namespace App\Models;

use Database\Factories\InventoryLogFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InventoryLog extends Model
{
    /** @use HasFactory<InventoryLogFactory> */
    use HasFactory;

    public const TYPE_INITIAL = 'initial';

    public const TYPE_RESTOCK = 'restock';

    public const TYPE_ADJUSTMENT = 'adjustment';

    public const TYPE_RESERVED = 'reserved';

    public const TYPE_RELEASED = 'released';

    public const TYPE_DEDUCTED = 'deducted';

    public const TYPE_RETURNED = 'returned';

    protected $fillable = [
        'product_id',
        'user_id',
        'order_id',
        'type',
        'quantity_before',
        'quantity_change',
        'quantity_changed',
        'quantity_after',
        'reference',
        'reference_type',
        'reference_id',
        'notes',
        'note',
        'metadata',
    ];

    protected function casts(): array
    {
        return [
            'product_id' => 'integer',
            'user_id' => 'integer',
            'order_id' => 'integer',
            'quantity_before' => 'integer',
            'quantity_change' => 'integer',
            'quantity_changed' => 'integer',
            'quantity_after' => 'integer',
            'reference_id' => 'integer',
            'metadata' => 'array',
        ];
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function getQuantityChangedLabelAttribute(): string
    {
        $value = $this->quantity_changed ?? $this->quantity_change ?? 0;

        return $value > 0 ? '+'.$value : (string) $value;
    }

    public function getDisplayNoteAttribute(): ?string
    {
        return $this->note ?? $this->notes;
    }
}
