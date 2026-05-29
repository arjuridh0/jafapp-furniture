<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\Product;
use App\Models\ProductionLog;
use App\Models\User;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        // Get or create demo customer
        $customer = User::firstOrCreate(
            ['email' => 'customer@jafapp.com'],
            [
                'name' => 'Budi Santoso',
                'password' => bcrypt('customer123'),
                'role' => 'customer',
                'phone' => '081234567892',
                'address' => 'Jl. Merdeka No. 45, Jakarta Selatan',
                'is_active' => true,
                'is_guest' => false,
                'email_verified_at' => now(),
            ]
        );

        $guest = User::firstOrCreate(
            ['email' => 'guest@jafapp.com'],
            [
                'name' => 'Siti Rahayu',
                'password' => bcrypt('guest123'),
                'role' => 'customer',
                'phone' => '081234567893',
                'address' => 'Jl. Sudirman No. 12, Semarang',
                'is_active' => true,
                'is_guest' => true,
                'email_verified_at' => null,
            ]
        );

        $products = Product::where('is_active', true)->get();
        if ($products->isEmpty()) {
            return;
        }

        $statuses = [
            'pending_payment',
            'payment_confirmed',
            'order_received',
            'in_production',
            'finishing',
            'completed',
            'cancelled',
        ];

        $demoOrders = [
            [
                'user' => $customer,
                'status' => 'completed',
                'created_days_ago' => 25,
                'items_count' => 2,
                'payment_status' => 'paid',
            ],
            [
                'user' => $customer,
                'status' => 'in_production',
                'created_days_ago' => 10,
                'items_count' => 1,
                'payment_status' => 'paid',
            ],
            [
                'user' => $customer,
                'status' => 'pending_payment',
                'created_days_ago' => 2,
                'items_count' => 3,
                'payment_status' => 'pending',
            ],
            [
                'user' => $guest,
                'status' => 'payment_confirmed',
                'created_days_ago' => 5,
                'items_count' => 1,
                'payment_status' => 'paid',
            ],
            [
                'user' => $guest,
                'status' => 'cancelled',
                'created_days_ago' => 15,
                'items_count' => 1,
                'payment_status' => 'expired',
            ],
            [
                'user' => $customer,
                'status' => 'finishing',
                'created_days_ago' => 8,
                'items_count' => 2,
                'payment_status' => 'paid',
            ],
            [
                'user' => $customer,
                'status' => 'order_received',
                'created_days_ago' => 3,
                'items_count' => 1,
                'payment_status' => 'paid',
            ],
        ];

        foreach ($demoOrders as $i => $orderData) {
            $selectedProducts = $products->random(min($orderData['items_count'], $products->count()));
            $subtotal = 0;
            $items = [];

            foreach ($selectedProducts as $product) {
                $qty = rand(1, 2);
                $subtotal += $product->price * $qty;
                $items[] = [
                    'product_id' => $product->id,
                    'price' => $product->price,
                    'qty' => $qty,
                    'subtotal' => $product->price * $qty,
                ];
            }

            $shippingCost = [0, 150000, 250000, 350000][array_rand([0, 150000, 250000, 350000])];
            $totalAmount = $subtotal + $shippingCost;

            $order = Order::create([
                'user_id' => $orderData['user']->id,
                'order_number' => 'JAF-' . now()->subDays($orderData['created_days_ago'])->format('Ymd') . '-' . str_pad((string) ($i + 1), 4, '0', STR_PAD_LEFT),
                'guest_name' => $orderData['user']->name,
                'guest_email' => $orderData['user']->email,
                'guest_phone' => $orderData['user']->phone,
                'shipping_address' => $orderData['user']->address,
                'type' => 'regular',
                'status' => $orderData['status'],
                'subtotal' => $subtotal,
                'shipping_cost' => $shippingCost,
                'total_amount' => $totalAmount,
                'notes' => null,
                'created_at' => now()->subDays($orderData['created_days_ago']),
                'updated_at' => now()->subDays(max(0, $orderData['created_days_ago'] - 2)),
            ]);

            // Create order items
            foreach ($items as $item) {
                OrderItem::create(array_merge($item, ['order_id' => $order->id]));
            }

            // Create payment
            Payment::create([
                'order_id' => $order->id,
                'payment_type' => ['bank_transfer', 'gopay', 'qris'][array_rand(['bank_transfer', 'gopay', 'qris'])],
                'midtrans_transaction_id' => 'midtrans-demo-' . $order->order_number,
                'amount' => $totalAmount,
                'status' => $orderData['payment_status'],
                'paid_at' => $orderData['payment_status'] === 'paid' ? $order->created_at->addHours(2) : null,
                'snap_token' => 'demo-snap-' . $order->order_number,
            ]);

            // Create production logs for orders past order_received
            $productionSequence = Order::PRODUCTION_STATUS_SEQUENCE;
            $currentStatusIndex = array_search($orderData['status'], $productionSequence);

            if ($currentStatusIndex !== false) {
                for ($j = 0; $j <= $currentStatusIndex; $j++) {
                    ProductionLog::create([
                        'order_id' => $order->id,
                        'status' => $productionSequence[$j],
                        'notes' => 'Update status demo ke: ' . $productionSequence[$j],
                        'updated_by' => 1,
                        'created_at' => $order->created_at->addDays($j + 1),
                    ]);
                }
            }
        }
    }
}
