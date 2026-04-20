<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\AddToCartRequest;
use App\Http\Requests\Frontend\UpdateCartItemRequest;
use App\Models\Cart;
use App\Models\CartItem;
use App\Services\CartService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CartItemController extends Controller
{
    public function __construct(
        protected CartService $cartService,
    ) {
    }

    public function store(AddToCartRequest $request): RedirectResponse
    {
        $cart = $this->cartService->addItem(
            $request->user(),
            (int) $request->validated('product_id'),
            (int) $request->validated('quantity'),
        );

        return redirect()
            ->route('products.index')
            ->with('status', 'Produk berhasil ditambahkan ke cart. Total item sekarang: '.$cart->total_items.'.');
    }

    public function update(UpdateCartItemRequest $request, CartItem $cartItem): RedirectResponse
    {
        $cartItem = $this->resolveUserCartItem($request, $cartItem);

        $this->cartService->updateItemQuantity(
            $cartItem,
            (int) $request->validated('quantity'),
        );

        return redirect()
            ->route('cart.index')
            ->with('status', 'Quantity cart berhasil diperbarui.');
    }

    public function destroy(Request $request, CartItem $cartItem): RedirectResponse
    {
        $cartItem = $this->resolveUserCartItem($request, $cartItem);

        $this->cartService->removeItem($cartItem);

        return redirect()
            ->route('cart.index')
            ->with('status', 'Item berhasil dihapus dari cart.');
    }

    protected function resolveUserCartItem(Request $request, CartItem $cartItem): CartItem
    {
        $cartItem->loadMissing('cart');

        abort_unless(
            $cartItem->cart instanceof Cart
            && $cartItem->cart->user_id === $request->user()->id
            && $cartItem->cart->status === Cart::STATUS_ACTIVE,
            404
        );

        return $cartItem;
    }
}
