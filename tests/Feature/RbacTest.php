<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RbacTest extends TestCase
{
    use RefreshDatabase;

    private function createUser(string $role): User
    {
        return User::factory()->create([
            'role' => $role,
            'is_active' => true,
            'is_guest' => false,
            'email_verified_at' => now(),
        ]);
    }

    public function test_guest_cannot_access_admin_dashboard(): void
    {
        $response = $this->get('/admin/dashboard');
        $response->assertRedirect('/login');
    }

    public function test_customer_cannot_access_admin_dashboard(): void
    {
        $customer = $this->createUser('customer');
        $response = $this->actingAs($customer)->get('/admin/dashboard');
        $response->assertStatus(403);
    }

    public function test_admin_can_access_admin_dashboard(): void
    {
        $admin = $this->createUser('admin');
        $response = $this->actingAs($admin)->get('/admin/dashboard');
        $response->assertStatus(200);
    }

    public function test_superadmin_can_access_admin_dashboard(): void
    {
        $superadmin = $this->createUser('superadmin');
        $response = $this->actingAs($superadmin)->get('/admin/dashboard');
        $response->assertStatus(200);
    }

    public function test_admin_cannot_access_user_management(): void
    {
        $admin = $this->createUser('admin');
        $response = $this->actingAs($admin)->get('/admin/users');
        $response->assertStatus(403);
    }

    public function test_superadmin_can_access_user_management(): void
    {
        $superadmin = $this->createUser('superadmin');
        $response = $this->actingAs($superadmin)->get('/admin/users');
        $response->assertStatus(200);
    }

    public function test_customer_cannot_access_orders_admin(): void
    {
        $customer = $this->createUser('customer');
        $response = $this->actingAs($customer)->get('/admin/orders');
        $response->assertStatus(403);
    }

    public function test_admin_can_create_product(): void
    {
        $admin = $this->createUser('admin');
        $response = $this->actingAs($admin)->get('/admin/products/create');
        $response->assertStatus(200);
    }
}
