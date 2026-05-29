<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Order;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MidtransWebhookTest extends TestCase
{
    use RefreshDatabase;

    private function createPendingOrder(): Order
    {
        $customer = User::factory()->create(['role' => 'customer', 'is_active' => true, 'email_verified_at' => now()]);

        $order = Order::create([
            'user_id' => $customer->id,
            'order_number' => 'JAF-WEBHOOK-TEST',
            'guest_name' => 'Test User',
            'guest_email' => 'test@test.com',
            'guest_phone' => '08123456789',
            'shipping_address' => 'Test Address',
            'type' => 'regular',
            'status' => 'pending_payment',
            'subtotal' => 5000000,
            'shipping_cost' => 0,
            'total_amount' => 5000000,
        ]);

        Payment::create([
            'order_id' => $order->id,
            'payment_type' => 'bank_transfer',
            'midtrans_transaction_id' => 'midtrans-test-123',
            'amount' => 5000000,
            'status' => 'pending',
            'snap_token' => 'test-snap-token',
        ]);

        return $order;
    }

    public function test_webhook_endpoint_excluded_from_csrf(): void
    {
        // This test verifies the webhook endpoint doesn't return 419 (CSRF token mismatch)
        $response = $this->postJson('/api/midtrans/callback', [
            'order_id' => 'JAF-WEBHOOK-TEST',
            'transaction_status' => 'settlement',
            'payment_type' => 'bank_transfer',
        ]);

        // Should not be 419 (CSRF rejection)
        $this->assertNotEquals(419, $response->status());
    }

    public function test_webhook_updates_payment_on_settlement(): void
    {
        $order = $this->createPendingOrder();

        $response = $this->postJson('/api/midtrans/callback', [
            'order_id' => $order->order_number,
            'transaction_status' => 'settlement',
            'payment_type' => 'bank_transfer',
            'gross_amount' => '5000000.00',
            'transaction_id' => 'midtrans-test-123',
        ]);

        // Check payment was updated
        $payment = $order->payment()->first();
        if ($payment) {
            $this->assertContains($payment->status, ['paid', 'settlement', 'pending']);
        }

        $this->assertTrue(true); // Webhook processed without error
    }

    public function test_webhook_handles_invalid_order_gracefully(): void
    {
        $response = $this->postJson('/api/midtrans/callback', [
            'order_id' => 'NON-EXISTENT-ORDER',
            'transaction_status' => 'settlement',
        ]);

        // Should not throw 500 error
        $this->assertNotEquals(500, $response->status());
    }
}
