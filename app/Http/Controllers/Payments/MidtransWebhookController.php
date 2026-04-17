<?php

namespace App\Http\Controllers\Payments;

use App\Http\Controllers\Controller;
use App\Services\MidtransService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MidtransWebhookController extends Controller
{
    public function __construct(
        protected MidtransService $midtransService,
    ) {}

    public function __invoke(Request $request): JsonResponse
    {
        $payment = $this->midtransService->handleNotification($request->all());

        return response()->json([
            'received' => true,
            'payment_id' => $payment->id,
            'payment_status' => $payment->status,
        ]);
    }
}
