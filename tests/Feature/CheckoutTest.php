<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CheckoutTest extends TestCase
{
    use RefreshDatabase;

    private function seedProduct(): Product
    {
        $category = Category::create(['name' => 'Test Category']);
        return Product::create([
            'category_id' => $category->id,
            'name' => 'Meja Jati Test',
            'slug' => 'meja-jati-test',
            'description' => 'Meja jati testing.',
            'price' => 5000000,
            'stock' => 10,
            'images' => ['images/no-image.png'],
            'is_active' => true,
        ]);
    }

    public function test_can_add_product_to_cart(): void
    {
        $product = $this->seedProduct();

        $response = $this->post('/keranjang/tambah', [
            'product_id' => $product->id,
            'qty' => 1,
        ]);

        $response->assertRedirect();
        $this->assertEquals(1, collect(session('cart'))->sum('qty'));
    }

    public function test_can_update_cart_quantity(): void
    {
        $product = $this->seedProduct();

        // Add to cart first
        $this->post('/keranjang/tambah', [
            'product_id' => $product->id,
            'qty' => 1,
        ]);

        // Update quantity
        $response = $this->patch('/keranjang/update', [
            'product_id' => $product->id,
            'qty' => 3,
        ]);

        $response->assertRedirect();
        $this->assertEquals(3, collect(session('cart'))->sum('qty'));
    }

    public function test_can_remove_from_cart(): void
    {
        $product = $this->seedProduct();

        $this->post('/keranjang/tambah', [
            'product_id' => $product->id,
            'qty' => 1,
        ]);

        $response = $this->delete('/keranjang/hapus', [
            'product_id' => $product->id,
        ]);

        $response->assertRedirect();
        $this->assertEmpty(session('cart'));
    }

    public function test_checkout_page_requires_cart_items(): void
    {
        $response = $this->get('/checkout');
        // Should redirect back or show empty cart message
        $response->assertStatus(302);
    }

    public function test_checkout_process_creates_order(): void
    {
        $product = $this->seedProduct();

        // Add to cart
        $this->withSession([
            'cart' => [
                $product->id => [
                    'product_id' => $product->id,
                    'name' => $product->name,
                    'price' => $product->price,
                    'qty' => 1,
                    'image' => 'images/no-image.png',
                ],
            ],
        ]);

        $response = $this->post('/checkout/process', [
            'name' => 'Test Customer',
            'email' => 'test@example.com',
            'phone' => '081234567890',
            'address' => 'Jl. Test No. 1',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('orders', [
            'guest_email' => 'test@example.com',
        ]);
    }
}
