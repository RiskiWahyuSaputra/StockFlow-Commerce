<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class CheckoutService
{
    public function __construct(
        protected CartService $cartService,
        protected InventoryService $inventoryService,
    ) {}

    public function getCheckoutCart(User $user, array $preparedItems = []): array
    {
        $cart = $this->cartService->getActiveCart($user);

        return $this->buildPreparedCheckoutCart($cart, $preparedItems);
    }

    public function getActiveCart(User $user): Cart
    {
        return $this->cartService->getActiveCart($user);
    }

    public function makePreparedCheckoutSnapshot(Cart $cart): array
    {
        return $cart->items
            ->map(fn (CartItem $item): array => [
                'cart_item_id' => $item->id,
                'quantity' => $item->quantity,
            ])
            ->values()
            ->all();
    }

    public function placeOrder(User $user, array $payload, array $preparedItems): Order
    {
        $normalizedPreparedItems = $this->normalizePreparedItems($preparedItems);

        return DB::transaction(function () use ($user, $payload, $normalizedPreparedItems): Order {
            $cart = Cart::query()
                ->where('user_id', $user->id)
                ->active()
                ->lockForUpdate()
                ->first();

            if (! $cart) {
                throw ValidationException::withMessages([
                    'cart' => 'Cart aktif tidak ditemukan.',
                ]);
            }

            $cart->load([
                'items.product' => fn ($query) => $query->withTrashed(),
            ]);

            $checkoutItems = $this->resolvePreparedCheckoutItems($cart, $normalizedPreparedItems);

            $this->ensureCartIsReady($checkoutItems);

            $products = Product::query()
                ->select(['id', 'name', 'slug', 'sku', 'price', 'stock', 'status'])
                ->active()
                ->whereIn('id', $checkoutItems->pluck('product_id'))
                ->orderBy('id')
                ->lockForUpdate()
                ->get()
                ->keyBy('id');

            if ($products->count() !== $checkoutItems->count()) {
                throw ValidationException::withMessages([
                    'cart' => 'Ada produk di cart yang sudah tidak tersedia untuk checkout.',
                ]);
            }

            $subtotal = 0;

            foreach ($checkoutItems as $item) {
                $product = $products->get($item->product_id);

                if (! $product) {
                    throw ValidationException::withMessages([
                        'cart' => 'Ada produk di cart yang sudah tidak tersedia untuk checkout.',
                    ]);
                }

                if ($item->quantity > $product->stock) {
                    throw ValidationException::withMessages([
                        'cart' => 'Stok untuk '.$product->name.' tinggal '.$product->stock.' item. Mohon update cart terlebih dahulu.',
                    ]);
                }

                $lineTotal = $item->quantity * (float) $product->price;
                $subtotal += $lineTotal;
            }

            $order = Order::create([
                'user_id' => $user->id,
                'cart_id' => $cart->id,
                'order_status' => Order::STATUS_PENDING,
                'payment_status' => Order::PAYMENT_UNPAID,
                'currency' => 'IDR',
                'subtotal' => $subtotal,
                'shipping_cost' => 0,
                'tax_amount' => 0,
                'discount_amount' => 0,
                'grand_total' => $subtotal,
                'customer_name' => $user->name,
                'customer_email' => $user->email,
                'customer_phone' => $payload['phone'],
                'shipping_recipient_name' => $payload['recipient_name'],
                'shipping_phone' => $payload['phone'],
                'shipping_address_line1' => $payload['address'],
                'shipping_address_line2' => null,
                'shipping_city' => $payload['city'],
                'shipping_state' => null,
                'shipping_postal_code' => $payload['postal_code'],
                'shipping_country' => 'ID',
                'shipping_notes' => $payload['note'] ?? null,
                'notes' => null,
                'placed_at' => now(),
            ]);

            $order->items()->createMany(
                $checkoutItems->map(function ($item) use ($products): array {
                    $product = $products->get($item->product_id);

                    return [
                        'product_id' => $product->id,
                        'product_name' => $product->name,
                        'product_slug' => $product->slug,
                        'sku' => $product->sku,
                        'quantity' => $item->quantity,
                        'unit_price' => $product->price,
                        'discount_amount' => 0,
                        'total_price' => $item->quantity * (float) $product->price,
                    ];
                })->all()
            );

            $this->inventoryService->reserveOrderStock($order, $checkoutItems, $user);

            $remainingItems = $cart->items->keyBy('id');

            foreach ($normalizedPreparedItems as $preparedItem) {
                /** @var CartItem|null $sourceItem */
                $sourceItem = $remainingItems->get($preparedItem['cart_item_id']);

                if (! $sourceItem) {
                    continue;
                }

                $remainingQuantity = $sourceItem->quantity - $preparedItem['quantity'];

                if ($remainingQuantity > 0) {
                    $sourceItem->update([
                        'quantity' => $remainingQuantity,
                        'subtotal' => $remainingQuantity * (float) $sourceItem->unit_price,
                    ]);

                    continue;
                }

                $sourceItem->delete();
            }

            $this->cartService->refreshCart($cart);

            return $order->load('items');
        });
    }

    protected function ensureCartIsReady(EloquentCollection $checkoutItems): void
    {
        if ($checkoutItems->isEmpty()) {
            throw ValidationException::withMessages([
                'cart' => 'Checkout belum disiapkan. Klik Lanjut ke Checkout dari halaman keranjang.',
            ]);
        }
    }

    protected function buildPreparedCheckoutCart(Cart $cart, array $preparedItems): array
    {
        $normalizedPreparedItems = $this->normalizePreparedItems($preparedItems);
        $preparedItemMap = collect($normalizedPreparedItems)->keyBy('cart_item_id');
        $checkoutItems = [];
        $isStale = false;

        foreach ($cart->items as $item) {
            $preparedItem = $preparedItemMap->get($item->id);

            if (! $preparedItem) {
                continue;
            }

            if ($item->quantity < $preparedItem['quantity']) {
                $isStale = true;

                continue;
            }

            $checkoutItem = clone $item;
            $checkoutItem->quantity = $preparedItem['quantity'];
            $checkoutItem->subtotal = $preparedItem['quantity'] * (float) $item->unit_price;
            $checkoutItem->setRelation('product', $item->product);

            $checkoutItems[] = $checkoutItem;
        }

        if (count($checkoutItems) !== count($normalizedPreparedItems)) {
            $isStale = true;
        }

        $checkoutCart = clone $cart;
        $checkoutCart->setRelation('items', new EloquentCollection($checkoutItems));
        $checkoutCart->total_items = (int) collect($checkoutItems)->sum('quantity');
        $checkoutCart->subtotal = (float) collect($checkoutItems)->sum('subtotal');

        return [
            'cart' => $checkoutCart,
            'is_stale' => $isStale,
        ];
    }

    protected function resolvePreparedCheckoutItems(Cart $cart, array $preparedItems): EloquentCollection
    {
        $preparedItemMap = collect($preparedItems)->keyBy('cart_item_id');
        $checkoutItems = [];

        foreach ($cart->items as $item) {
            $preparedItem = $preparedItemMap->get($item->id);

            if (! $preparedItem) {
                continue;
            }

            if ($preparedItem['quantity'] < 1 || $item->quantity < $preparedItem['quantity']) {
                throw ValidationException::withMessages([
                    'cart' => 'Isi keranjang berubah setelah checkout disiapkan. Klik Lanjut ke Checkout lagi dari halaman keranjang.',
                ]);
            }

            $checkoutItem = clone $item;
            $checkoutItem->quantity = $preparedItem['quantity'];
            $checkoutItem->subtotal = $preparedItem['quantity'] * (float) $item->unit_price;
            $checkoutItem->setRelation('product', $item->product);

            $checkoutItems[] = $checkoutItem;
        }

        if (count($checkoutItems) !== count($preparedItems)) {
            throw ValidationException::withMessages([
                'cart' => 'Isi keranjang berubah setelah checkout disiapkan. Klik Lanjut ke Checkout lagi dari halaman keranjang.',
            ]);
        }

        return new EloquentCollection($checkoutItems);
    }

    protected function normalizePreparedItems(array $preparedItems): array
    {
        return collect($preparedItems)
            ->map(function ($preparedItem): ?array {
                $cartItemId = (int) data_get($preparedItem, 'cart_item_id');
                $quantity = (int) data_get($preparedItem, 'quantity');

                if ($cartItemId < 1 || $quantity < 1) {
                    return null;
                }

                return [
                    'cart_item_id' => $cartItemId,
                    'quantity' => $quantity,
                ];
            })
            ->filter()
            ->values()
            ->all();
    }
}
