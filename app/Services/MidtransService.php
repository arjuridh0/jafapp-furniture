<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Order;
use App\Models\Payment;
use Midtrans\Config;
use Midtrans\Snap;

class MidtransService
{
    public function __construct()
    {
        Config::$serverKey = config('midtrans.server_key');
        Config::$clientKey = config('midtrans.client_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized');
        Config::$is3ds = config('midtrans.is_3ds');
    }

    /**
     * Create Snap Token for an order.
     */
    public function createSnapToken(Order $order): string
    {
        $order->load(['orderItems.product', 'user']);

        $items = $order->orderItems->map(function ($item) {
            return [
                'id' => (string) $item->product_id,
                'price' => (int) $item->price,
                'quantity' => $item->qty,
                'name' => mb_substr($item->product->name ?? 'Produk', 0, 50),
            ];
        })->toArray();

        // Add shipping cost as item if > 0
        if ($order->shipping_cost > 0) {
            $items[] = [
                'id' => 'SHIPPING',
                'price' => (int) $order->shipping_cost,
                'quantity' => 1,
                'name' => 'Ongkos Kirim',
            ];
        }

        $params = [
            'transaction_details' => [
                'order_id' => $order->order_number,
                'gross_amount' => (int) $order->total_amount,
            ],
            'item_details' => $items,
            'customer_details' => [
                'first_name' => $order->guest_name ?? $order->user?->name ?? 'Pelanggan',
                'email' => $order->guest_email ?? $order->user?->email ?? '',
                'phone' => $order->guest_phone ?? $order->user?->phone ?? '',
                'shipping_address' => [
                    'address' => $order->shipping_address ?? '',
                ],
            ],
            'callbacks' => [
                'finish' => route('checkout.payment-status', $order->order_number),
            ],
        ];

        $snapToken = Snap::getSnapToken($params);

        // Save snap token to payment record
        $order->payment()->updateOrCreate(
            ['order_id' => $order->id],
            [
                'snap_token' => $snapToken,
                'amount' => $order->total_amount,
                'status' => 'pending',
            ]
        );

        return $snapToken;
    }

    /**
     * Verify webhook signature from Midtrans (SHA512).
     */
    public function verifySignature(array $notification): bool
    {
        $orderId = $notification['order_id'] ?? '';
        $statusCode = $notification['status_code'] ?? '';
        $grossAmount = $notification['gross_amount'] ?? '';
        $serverKey = config('midtrans.server_key');

        $expectedSignature = hash('sha512', $orderId . $statusCode . $grossAmount . $serverKey);

        return hash_equals($expectedSignature, $notification['signature_key'] ?? '');
    }

    /**
     * Process webhook notification — update payment + order status.
     */
    public function handleNotification(array $notification): void
    {
        $orderNumber = $notification['order_id'] ?? '';
        $transactionStatus = $notification['transaction_status'] ?? '';
        $paymentType = $notification['payment_type'] ?? '';
        $fraudStatus = $notification['fraud_status'] ?? 'accept';
        $transactionId = $notification['transaction_id'] ?? '';

        $order = Order::where('order_number', $orderNumber)->first();
        if (!$order) {
            return;
        }

        $payment = $order->payment;
        if (!$payment) {
            $payment = Payment::create([
                'order_id' => $order->id,
                'amount' => $order->total_amount,
                'status' => 'pending',
            ]);
        }

        // Update payment record
        $payment->update([
            'midtrans_transaction_id' => $transactionId,
            'payment_type' => $paymentType,
            'raw_response' => $notification,
        ]);

        // Map Midtrans status to our payment + order status
        if ($transactionStatus === 'capture') {
            if ($fraudStatus === 'accept') {
                $payment->update(['status' => 'paid', 'paid_at' => now()]);
                $order->update(['status' => Order::STATUS_PAYMENT_CONFIRMED]);
            } else {
                $payment->update(['status' => 'failed']);
                $order->update(['status' => Order::STATUS_CANCELLED]);
            }
        } elseif ($transactionStatus === 'settlement') {
            $payment->update(['status' => 'paid', 'paid_at' => now()]);
            $order->update(['status' => Order::STATUS_PAYMENT_CONFIRMED]);
        } elseif (in_array($transactionStatus, ['cancel', 'deny'])) {
            $payment->update(['status' => 'failed']);
        } elseif ($transactionStatus === 'expire') {
            $payment->update(['status' => 'expired']);
        } elseif ($transactionStatus === 'pending') {
            $payment->update(['status' => 'pending']);
        }
    }
}
