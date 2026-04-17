<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\MidtransService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Throwable;

class OrderPaymentController extends Controller
{
    public function __construct(
        protected MidtransService $midtransService,
    ) {}

    public function store(Request $request, Order $order): RedirectResponse
    {
        abort_unless($order->user_id === $request->user()->id, 404);

        try {
            $this->midtransService->createSnapPayment($order);
        } catch (Throwable $throwable) {
            report($throwable);

            return redirect()
                ->route('checkout.success', $order)
                ->withErrors([
                    'payment' => 'Order berhasil dibuat, tetapi sesi pembayaran Midtrans belum berhasil dipersiapkan. Silakan coba lagi.',
                ]);
        }

        return redirect()
            ->route('checkout.success', $order)
            ->with('status', 'Sesi pembayaran Midtrans berhasil dipersiapkan.');
    }
}
