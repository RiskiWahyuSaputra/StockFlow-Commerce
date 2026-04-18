<?php

namespace App\Services;

use App\Models\InventoryLog;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AdminProductService
{
    public function __construct(
        protected InventoryService $inventoryService,
    ) {}

    public function create(array $payload, ?User $actor = null): Product
    {
        return DB::transaction(function () use ($payload, $actor): Product {
            $targetStock = (int) $payload['stock'];

            $product = Product::create($this->extractProductAttributes($payload, 0));

            $this->syncImages(
                $product,
                $payload['images'] ?? [],
                [],
                null,
            );

            if ($targetStock > 0) {
                $this->inventoryService->changeStock($product->id, $targetStock, InventoryLog::TYPE_INITIAL, [
                    'user' => $actor,
                    'note' => 'Stok awal produk saat dibuat dari admin panel.',
                    'reference_type' => 'product',
                    'reference_id' => $product->id,
                    'metadata' => [
                        'source' => 'admin_product_create',
                    ],
                ]);
            }

            return $product->fresh(['category', 'images', 'primaryImage']);
        });
    }

    public function update(Product $product, array $payload, ?User $actor = null): Product
    {
        return DB::transaction(function () use ($product, $payload, $actor): Product {
            $currentStock = (int) $product->stock;
            $targetStock = (int) $payload['stock'];

            $product->fill($this->extractProductAttributes($payload, $currentStock));
            $product->save();

            $this->syncImages(
                $product,
                $payload['images'] ?? [],
                array_map('intval', $payload['delete_image_ids'] ?? []),
                isset($payload['primary_image_id']) ? (int) $payload['primary_image_id'] : null,
            );

            if ($targetStock !== $currentStock) {
                $this->inventoryService->syncStock(
                    $product->id,
                    $targetStock,
                    $actor,
                    'Perubahan stok dari form edit produk admin.',
                );
            }

            return $product->fresh(['category', 'images', 'primaryImage']);
        });
    }

    public function delete(Product $product): void
    {
        $product->delete();
    }

    protected function extractProductAttributes(array $payload, int $stock): array
    {
        $attributes = Arr::only($payload, [
            'category_id',
            'name',
            'slug',
            'sku',
            'short_description',
            'description',
            'price',
            'low_stock_threshold',
            'weight',
            'status',
            'published_at',
        ]);

        $attributes['stock'] = $stock;
        $attributes['track_stock'] = (bool) ($payload['track_stock'] ?? false);
        $attributes['is_featured'] = (bool) ($payload['is_featured'] ?? false);

        if ($attributes['status'] === Product::STATUS_ACTIVE && blank($attributes['published_at'] ?? null)) {
            $attributes['published_at'] = now();
        }

        if (($attributes['status'] ?? null) !== Product::STATUS_ACTIVE) {
            $attributes['published_at'] = $attributes['published_at'] ?? null;
        }

        return $attributes;
    }

    protected function syncImages(Product $product, array $newImages, array $deleteImageIds, ?int $primaryImageId): void
    {
        $product->load('images');

        if ($deleteImageIds !== []) {
            $imagesToDelete = $product->images()->whereKey($deleteImageIds)->get();

            foreach ($imagesToDelete as $image) {
                if (! str_starts_with($image->path, 'http://') && ! str_starts_with($image->path, 'https://')) {
                    Storage::disk('public')->delete($image->path);
                }

                $image->delete();
            }
        }

        $sortOrder = (int) ($product->images()->max('sort_order') ?? 0);
        $createdImageIds = [];

        /** @var UploadedFile $image */
        foreach ($newImages as $image) {
            $sortOrder++;

            $created = $product->images()->create([
                'path' => $image->store('products', 'public'),
                'alt_text' => $product->name,
                'sort_order' => $sortOrder,
                'is_primary' => false,
            ]);

            $createdImageIds[] = $created->id;
        }

        $remainingImages = $product->images()->get();
        $resolvedPrimaryId = $primaryImageId;

        if ($resolvedPrimaryId !== null && ! $remainingImages->contains('id', $resolvedPrimaryId)) {
            $resolvedPrimaryId = null;
        }

        if ($resolvedPrimaryId === null) {
            $resolvedPrimaryId = $remainingImages->firstWhere('is_primary', true)?->id
                ?? ($createdImageIds[0] ?? $remainingImages->first()?->id);
        }

        if ($resolvedPrimaryId !== null) {
            $product->images()->update([
                'is_primary' => false,
            ]);

            $product->images()->whereKey($resolvedPrimaryId)->update([
                'is_primary' => true,
            ]);
        }
    }
}
