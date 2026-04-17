<?php

namespace App\Models;

use Database\Factories\ProductFactory;
use Illuminate\Database\Eloquent\Attributes\Computed;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Product extends Model
{
    /** @use HasFactory<ProductFactory> */
    use HasFactory, SoftDeletes;

    public const STATUS_DRAFT = 'draft';

    public const STATUS_ACTIVE = 'active';

    public const STATUS_INACTIVE = 'inactive';

    public const STATUS_ARCHIVED = 'archived';

    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'sku',
        'short_description',
        'description',
        'price',
        'stock',
        'low_stock_threshold',
        'weight',
        'track_stock',
        'is_featured',
        'status',
        'published_at',
    ];

    protected $appends = [
        'is_in_stock',
        'primary_image_path',
    ];

    protected function casts(): array
    {
        return [
            'category_id' => 'integer',
            'price' => 'decimal:2',
            'stock' => 'integer',
            'low_stock_threshold' => 'integer',
            'weight' => 'integer',
            'track_stock' => 'boolean',
            'is_featured' => 'boolean',
            'published_at' => 'datetime',
        ];
    }

    protected static function booted(): void
    {
        static::saving(function (Product $product): void {
            if (blank($product->slug) && filled($product->name)) {
                $product->slug = Str::slug($product->name);
            }

            if (filled($product->sku)) {
                $product->sku = Str::upper($product->sku);
            }
        });
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', self::STATUS_ACTIVE);
    }

    public function scopeSearchByName(Builder $query, ?string $search): Builder
    {
        if (blank($search)) {
            return $query;
        }

        return $query->where('name', 'like', '%'.trim($search).'%');
    }

    public function scopeInCategorySlug(Builder $query, ?string $categorySlug): Builder
    {
        if (blank($categorySlug)) {
            return $query;
        }

        return $query->whereHas('category', function (Builder $categoryQuery) use ($categorySlug): void {
            $categoryQuery->where('slug', $categorySlug);
        });
    }

    public function scopeApplyCatalogSort(Builder $query, ?string $sort): Builder
    {
        return match ($sort) {
            'lowest_price' => $query->orderBy('price')->orderByDesc('published_at')->orderByDesc('id'),
            'highest_price' => $query->orderByDesc('price')->orderByDesc('published_at')->orderByDesc('id'),
            default => $query->orderByDesc('published_at')->orderByDesc('id'),
        };
    }

    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class)->orderBy('sort_order');
    }

    public function primaryImage(): HasOne
    {
        return $this->hasOne(ProductImage::class)->where('is_primary', true);
    }

    public function cartItems(): HasMany
    {
        return $this->hasMany(CartItem::class);
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function inventoryLogs(): HasMany
    {
        return $this->hasMany(InventoryLog::class);
    }

    #[Computed]
    public function isInStock(): bool
    {
        return $this->stock > 0;
    }

    public function getPriceLabelAttribute(): string
    {
        return 'Rp'.number_format((int) round((float) $this->price), 0, ',', '.');
    }

    public function getSummaryAttribute(): string
    {
        return $this->short_description ?: Str::limit(strip_tags((string) $this->description), 120);
    }

    public function getPrimaryCategoryNameAttribute(): string
    {
        return $this->category?->name ?? 'Uncategorized';
    }

    public function getStockLabelAttribute(): string
    {
        return $this->is_in_stock ? $this->stock.' tersedia' : 'Stok habis';
    }

    public function getStockBadgeLabelAttribute(): string
    {
        return $this->is_in_stock ? 'Stok '.$this->stock : 'Sold Out';
    }

    #[Computed]
    public function primaryImagePath(): ?string
    {
        if ($this->relationLoaded('primaryImage')) {
            return $this->primaryImage?->path;
        }

        return $this->primaryImage()->value('path');
    }
}
