<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class CheckoutService
{
    /**
     * Process checkout: resolve user, create order, clear cart.
     *
     * Guest Checkout Logic (5 conditions from PRD):
     * 1. Email baru → buat guest account
     * 2. Email lama, is_guest=true → pakai akun lama
     * 3. Email lama, is_active=true → redirect ke login (handled in controller)
     * 4. Email lama, is_guest=false, is_active=false → pakai akun lama (belum aktivasi)
     *
     * @return array{order: Order, user: User, is_new_guest: bool}
     */
    public function processCheckout(array $data, array $cart): array
    {
        return DB::transaction(function () use ($data, $cart) {
            $isNewGuest = false;
            $user = $this->resolveUser($data, $isNewGuest);

            // Auto-login if not logged in
            if (!Auth::check()) {
                Auth::login($user);
            }

            // Generate order number
            $orderNumber = $this->generateOrderNumber();

            // Calculate subtotal
            $subtotal = collect($cart)->sum(fn ($item) => $item['price'] * $item['qty']);

            // Create order
            $order = Order::create([
                'user_id' => $user->id,
                'order_number' => $orderNumber,
                'type' => Order::TYPE_REGULAR,
                'status' => Order::STATUS_PENDING_PAYMENT,
                'subtotal' => $subtotal,
                'shipping_cost' => 0,
                'total_amount' => $subtotal,
                'shipping_address' => $data['address'],
                'guest_name' => $data['name'],
                'guest_email' => $data['email'],
                'guest_phone' => $data['phone'],
                'notes' => $data['notes'] ?? null,
            ]);

            // Create order items
            foreach ($cart as $productId => $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $productId,
                    'qty' => $item['qty'],
                    'price' => $item['price'],
                    'subtotal' => $item['price'] * $item['qty'],
                ]);
            }

            // Create pending payment record
            Payment::create([
                'order_id' => $order->id,
                'amount' => $subtotal,
                'status' => 'pending',
            ]);

            // Clear cart
            session()->forget('cart');

            return [
                'order' => $order->load('orderItems.product', 'payment'),
                'user' => $user,
                'is_new_guest' => $isNewGuest,
            ];
        });
    }

    /**
     * Resolve or create user based on email (Guest Checkout Logic).
     */
    public function resolveUser(array $data, bool &$isNewGuest): User
    {
        // If already logged in, use current user
        if (Auth::check()) {
            $user = Auth::user();
            // Update profile data if needed
            $user->update([
                'phone' => $data['phone'] ?? $user->phone,
                'address' => $data['address'] ?? $user->address,
            ]);
            return $user;
        }

        $existingUser = User::where('email', $data['email'])->first();

        if (!$existingUser) {
            // Condition 1: New email → create guest account
            $tempPassword = Str::random(8);
            $activationToken = Str::random(64);

            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => $tempPassword,
                'role' => 'customer',
                'phone' => $data['phone'],
                'address' => $data['address'],
                'is_active' => false,
                'is_guest' => true,
                'activation_token' => $activationToken,
                'activation_token_expires_at' => now()->addDays(7),
            ]);

            $user->temp_password = $tempPassword; // Attach for email
            $isNewGuest = true;

            return $user;
        }

        if ($existingUser->is_guest) {
            // Condition 2: Existing guest → reuse account
            $existingUser->update([
                'name' => $data['name'],
                'phone' => $data['phone'],
                'address' => $data['address'],
            ]);
            return $existingUser;
        }

        // Condition 4: Existing, not guest, not active → reuse
        if (!$existingUser->is_active) {
            $existingUser->update([
                'phone' => $data['phone'],
                'address' => $data['address'],
            ]);
            return $existingUser;
        }

        // Condition 3: Active account → should have been caught in controller validation
        // This is a safety fallback
        return $existingUser;
    }

    /**
     * Generate order number: JAF-YYYYMMDD-XXXX (daily counter).
     */
    public function generateOrderNumber(): string
    {
        $today = now()->format('Ymd');
        $prefix = "JAF-{$today}-";

        $lastOrder = Order::where('order_number', 'like', "{$prefix}%")
            ->orderByDesc('order_number')
            ->first();

        if ($lastOrder) {
            $lastNumber = (int) substr($lastOrder->order_number, -4);
            $nextNumber = $lastNumber + 1;
        } else {
            $nextNumber = 1;
        }

        return $prefix . str_pad((string) $nextNumber, 4, '0', STR_PAD_LEFT);
    }

    /**
     * Check if email belongs to an active (non-guest) account.
     * Used by controller to redirect to login instead of checkout.
     */
    public function isActiveAccount(string $email): bool
    {
        $user = User::where('email', $email)->first();
        return $user && !$user->is_guest && $user->is_active;
    }
}
