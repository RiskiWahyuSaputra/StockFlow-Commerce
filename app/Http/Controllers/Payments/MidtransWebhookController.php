<?php

namespace App\Http\Controllers\Payments;

use App\Http\Controllers\Controller;
use App\Services\MidtransService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Throwable;

class MidtransWebhookController extends Controller
{
    public function __construct(
        protected MidtransService $midtransService,
    ) {}

    public function __invoke(Request $request): JsonResponse
    {
        try {
            $payment = $this->midtransService->handleNotification($request->all());
        } catch (ValidationException $exception) {
            Log::warning('Midtrans webhook validation failed.', [
                'errors' => $exception->errors(),
                'payload' => $request->except(['signature_key']),
            ]);

            return response()->json([
                'received' => false,
                'message' => 'Invalid Midtrans notification payload.',
            ], 422);
        } catch (Throwable $throwable) {
            report($throwable);
            Log::error('Midtrans webhook processing failed.', [
                'payload' => $request->except(['signature_key']),
                'exception' => $throwable->getMessage(),
            ]);

            return response()->json([
                'received' => false,
                'message' => 'Webhook could not be processed.',
            ], 500);
        }

        return response()->json([
            'received' => true,
            'payment_id' => $payment->id,
            'payment_status' => $payment->status,
        ]);
    }
}
