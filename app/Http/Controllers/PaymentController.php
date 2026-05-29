<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Services\MidtransService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    public function __construct(
        private readonly MidtransService $midtransService,
    ) {}

    /**
     * Handle Midtrans webhook callback.
     * Route: POST /api/midtrans/callback
     * CSRF excluded in bootstrap/app.php
     */
    public function handleCallback(Request $request)
    {
        $notification = $request->all();

        Log::info('Midtrans webhook received', [
            'order_id' => $notification['order_id'] ?? 'unknown',
            'transaction_status' => $notification['transaction_status'] ?? 'unknown',
        ]);

        // Verify signature
        if (!$this->midtransService->verifySignature($notification)) {
            Log::warning('Midtrans webhook signature verification failed', [
                'order_id' => $notification['order_id'] ?? 'unknown',
            ]);
            return response()->json(['message' => 'Invalid signature'], 403);
        }

        // Process notification
        try {
            $this->midtransService->handleNotification($notification);
            Log::info('Midtrans webhook processed successfully', [
                'order_id' => $notification['order_id'] ?? 'unknown',
            ]);
        } catch (\Throwable $e) {
            Log::error('Midtrans webhook processing failed', [
                'order_id' => $notification['order_id'] ?? 'unknown',
                'error' => $e->getMessage(),
            ]);
            return response()->json(['message' => 'Processing failed'], 500);
        }

        return response()->json(['message' => 'OK']);
    }
}
