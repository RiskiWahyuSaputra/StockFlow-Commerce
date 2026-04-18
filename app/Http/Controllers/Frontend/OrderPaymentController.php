<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\CustomerOrderService;
use App\Services\MidtransService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Throwable;

class OrderPaymentController extends Controller
{
    public function __construct(
        protected MidtransService $midtransService,
        protected CustomerOrderService $customerOrderService,
    ) {}

    public function store(Request $request, string $orderNumber): RedirectResponse
    {
        $order = $this->resolveUserOrder($request, $orderNumber);

        try {
            $this->midtransService->createSnapPayment($order);
        } catch (Throwable $throwable) {
            report($throwable);
            Log::error('Failed to re-prepare Midtrans payment from customer order page.', [
                'order_id' => $order->id,
                'order_number' => $order->order_number,
                'user_id' => $request->user()->id,
                'exception' => $throwable->getMessage(),
            ]);

            return redirect()
                ->route('orders.show', $order->order_number)
                ->with('error', 'Sesi pembayaran Midtrans belum berhasil dipersiapkan. Silakan coba lagi.');
        }

        return redirect()
            ->route('orders.show', $order->order_number)
            ->with('status', 'Sesi pembayaran Midtrans berhasil dipersiapkan.');
    }

    protected function resolveUserOrder(Request $request, string $orderNumber): Order
    {
        return $this->customerOrderService->getUserOrderByNumber($request->user(), $orderNumber);
    }
}
