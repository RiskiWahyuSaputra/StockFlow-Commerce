<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\CheckoutRequest;
use App\Models\Order;
use App\Services\CheckoutService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CheckoutController extends Controller
{
    public function __construct(
        protected CheckoutService $checkoutService,
    ) {
    }

    public function index(Request $request): RedirectResponse|View
    {
        $cart = $this->checkoutService->getCheckoutCart($request->user());

        if ($cart->items->isEmpty()) {
            return redirect()
                ->route('cart.index')
                ->with('status', 'Cart masih kosong. Tambahkan produk sebelum checkout.');
        }

        return view('frontend.checkout.index', [
            'cart' => $cart,
            'shippingMethods' => [
                [
                    'name' => 'Regular Delivery',
                    'detail' => 'Estimasi 1-2 hari kerja',
                    'price_label' => 'Rp0',
                    'active' => true,
                ],
            ],
            'paymentMethod' => [
                'name' => 'Midtrans Preview',
                'detail' => 'Order akan dibuat dulu, integrasi payment gateway menyusul di tahap berikutnya.',
            ],
        ]);
    }

    public function store(CheckoutRequest $request): RedirectResponse
    {
        $order = $this->checkoutService->placeOrder(
            $request->user(),
            $request->validated(),
        );

        return redirect()
            ->route('checkout.success', $order)
            ->with('status', 'Order berhasil dibuat dan stok sudah direservasi.');
    }

    public function success(Request $request, Order $order): View
    {
        abort_unless($order->user_id === $request->user()->id, 404);

        return view('frontend.checkout.success', [
            'order' => $order->load('items'),
        ]);
    }
}
