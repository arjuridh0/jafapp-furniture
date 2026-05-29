<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Order;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductionStatusTest extends TestCase
{
    use RefreshDatabase;

    private function createOrderWithStatus(string $status): Order
    {
        $admin = User::factory()->create(['role' => 'admin', 'is_active' => true, 'email_verified_at' => now()]);
        $customer = User::factory()->create(['role' => 'customer', 'is_active' => true, 'email_verified_at' => now()]);

        return Order::create([
            'user_id' => $customer->id,
            'order_number' => 'JAF-TEST-' . uniqid(),
            'guest_name' => $customer->name,
            'guest_email' => $customer->email,
            'guest_phone' => '08123456789',
            'shipping_address' => 'Test Address',
            'type' => 'regular',
            'status' => $status,
            'subtotal' => 5000000,
            'shipping_cost' => 150000,
            'total_amount' => 5150000,
        ]);
    }

    public function test_production_status_sequence_is_defined(): void
    {
        $sequence = Order::PRODUCTION_STATUS_SEQUENCE;

        $this->assertIsArray($sequence);
        $this->assertContains('order_received', $sequence);
        $this->assertContains('in_production', $sequence);
        $this->assertContains('completed', $sequence);
    }

    public function test_status_label_returns_readable_string(): void
    {
        $order = $this->createOrderWithStatus('in_production');

        $this->assertNotEmpty($order->status_label);
        $this->assertIsString($order->status_label);
    }

    public function test_admin_can_update_production_status(): void
    {
        $admin = User::factory()->create(['role' => 'admin', 'is_active' => true, 'email_verified_at' => now()]);
        $order = $this->createOrderWithStatus('order_received');

        $response = $this->actingAs($admin)->post("/admin/orders/{$order->id}/update-production", [
            'status' => 'material_preparation',
            'notes' => 'Material sedang disiapkan',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('orders', [
            'id' => $order->id,
            'status' => 'material_preparation',
        ]);
    }

    public function test_customer_cannot_update_production_status(): void
    {
        $customer = User::factory()->create(['role' => 'customer', 'is_active' => true, 'email_verified_at' => now()]);
        $order = $this->createOrderWithStatus('order_received');

        $response = $this->actingAs($customer)->post("/admin/orders/{$order->id}/update-production", [
            'status' => 'material_preparation',
        ]);

        $response->assertStatus(403);
    }
}
