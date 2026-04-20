<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\CheckoutRequest;
use App\Models\Order;
use App\Services\CheckoutService;
use App\Services\CustomerOrderService;
use App\Services\MidtransService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Throwable;

class CheckoutController extends Controller
{
    public function __construct(
        protected CheckoutService $checkoutService,
        protected CustomerOrderService $customerOrderService,
        protected MidtransService $midtransService,
    ) {}

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
                    'name' => 'Pengiriman Reguler',
                    'detail' => 'Estimasi 1-2 hari kerja',
                    'price_label' => 'Rp0',
                    'active' => true,
                ],
            ],
            'paymentMethod' => [
                'name' => 'Midtrans Snap Sandbox',
                'detail' => 'Order dibuat lebih dulu, lalu user menyelesaikan pembayaran di popup Snap Midtrans.',
            ],
        ]);
    }

    public function store(CheckoutRequest $request): RedirectResponse
    {
        $order = $this->checkoutService->placeOrder(
            $request->user(),
            $request->validated(),
        );

        try {
            $this->midtransService->createSnapPayment($order);
        } catch (Throwable $throwable) {
            report($throwable);
            Log::error('Failed to prepare Midtrans payment after checkout.', [
                'order_id' => $order->id,
                'order_number' => $order->order_number,
                'user_id' => $request->user()->id,
                'exception' => $throwable->getMessage(),
            ]);

            return redirect()
                ->route('checkout.success', $order)
                ->with('error', 'Order berhasil dibuat, tetapi sesi pembayaran Midtrans belum berhasil dipersiapkan. Kamu masih bisa menyiapkannya dari halaman order.');
        }

        return redirect()
            ->route('checkout.success', $order)
            ->with('status', 'Order berhasil dibuat, stok sudah direservasi, dan sesi pembayaran Midtrans sudah siap.');
    }

    public function success(Request $request, Order $order): View
    {
        abort_unless($order->user_id === $request->user()->id, 404);

        return view('frontend.orders.show', [
            'order' => $this->customerOrderService->getUserOrderById($request->user(), $order->id),
        ]);
    }
}
