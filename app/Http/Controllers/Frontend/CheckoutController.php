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
    public const PREPARED_CHECKOUT_SESSION_KEY = 'checkout.prepared_items';

    public function __construct(
        protected CheckoutService $checkoutService,
        protected CustomerOrderService $customerOrderService,
        protected MidtransService $midtransService,
    ) {}

    public function prepare(Request $request): RedirectResponse
    {
        $cart = $this->checkoutService->getActiveCart($request->user());

        if ($cart->items->isEmpty()) {
            return redirect()
                ->route('cart.index')
                ->with('status', 'Cart masih kosong. Tambahkan produk sebelum checkout.');
        }

        $request->session()->put(
            self::PREPARED_CHECKOUT_SESSION_KEY,
            $this->checkoutService->makePreparedCheckoutSnapshot($cart)
        );

        return redirect()->route('checkout.index');
    }

    public function index(Request $request): RedirectResponse|View
    {
        $checkout = $this->checkoutService->getCheckoutCart(
            $request->user(),
            $this->getPreparedCheckoutItems($request),
        );
        $cart = $checkout['cart'];

        if ($cart->items->isEmpty()) {
            $this->forgetPreparedCheckout($request);

            return redirect()
                ->route('cart.index')
                ->with('status', 'Produk di checkout baru diperbarui setelah kamu klik Lanjut ke Checkout dari halaman keranjang.');
        }

        if ($checkout['is_stale']) {
            $this->forgetPreparedCheckout($request);

            return redirect()
                ->route('cart.index')
                ->with('status', 'Isi keranjang berubah. Klik Lanjut ke Checkout lagi untuk memperbarui checkout.');
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
            $this->getPreparedCheckoutItems($request),
        );

        $this->forgetPreparedCheckout($request);

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

    protected function getPreparedCheckoutItems(Request $request): array
    {
        $preparedItems = $request->session()->get(self::PREPARED_CHECKOUT_SESSION_KEY, []);

        return is_array($preparedItems) ? $preparedItems : [];
    }

    protected function forgetPreparedCheckout(Request $request): void
    {
        $request->session()->forget(self::PREPARED_CHECKOUT_SESSION_KEY);
    }
}
