<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\CheckoutRequest;
use App\Mail\GuestCredentialsMail;
use App\Mail\OrderConfirmationMail;
use App\Models\User;
use App\Services\CheckoutService;
use App\Services\MidtransService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class CheckoutController extends Controller
{
    public function __construct(
        private readonly CheckoutService $checkoutService,
        private readonly MidtransService $midtransService,
    ) {}

    /**
     * Show checkout form (from cart).
     */
    public function index()
    {
        $cart = session('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')
                ->with('error', 'Keranjang belanja Anda kosong.');
        }

        $subtotal = collect($cart)->sum(fn ($item) => $item['price'] * $item['qty']);
        $user = auth()->user();

        return view('public.checkout.index', compact('cart', 'subtotal', 'user'));
    }

    /**
     * Check if email belongs to active account (AJAX).
     */
    public function checkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $isActive = $this->checkoutService->isActiveAccount($request->email);

        return response()->json([
            'is_active' => $isActive,
            'message' => $isActive
                ? 'Email ini sudah terdaftar. Silakan login terlebih dahulu.'
                : null,
        ]);
    }

    /**
     * Process checkout form submission.
     */
    public function process(CheckoutRequest $request)
    {
        $cart = session('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')
                ->with('error', 'Keranjang belanja Anda kosong.');
        }

        // Check if active account — redirect to login
        if (!auth()->check() && $this->checkoutService->isActiveAccount($request->email)) {
            return redirect()->route('login')
                ->with('info', 'Silakan login terlebih dahulu dengan akun Anda.')
                ->withInput();
        }

        $result = $this->checkoutService->processCheckout(
            $request->validated(),
            $cart
        );

        $order = $result['order'];
        $user = $result['user'];
        $isNewGuest = $result['is_new_guest'];

        // Send order confirmation email
        try {
            Mail::to($order->guest_email)->queue(new OrderConfirmationMail($order));
        } catch (\Throwable) {
            // Don't block checkout if email fails
        }

        // Send guest credentials if new guest
        if ($isNewGuest && isset($user->temp_password)) {
            try {
                Mail::to($user->email)->queue(new GuestCredentialsMail($user, $user->temp_password));
            } catch (\Throwable) {
                // Don't block checkout if email fails
            }
        }

        return redirect()->route('checkout.confirmation', $order->order_number);
    }

    /**
     * Show order confirmation page with Midtrans Snap payment.
     */
    public function confirmation(string $orderNumber)
    {
        $order = auth()->user()->orders()
            ->where('order_number', $orderNumber)
            ->with(['orderItems.product', 'payment'])
            ->firstOrFail();

        $snapToken = null;
        $clientKey = config('midtrans.client_key');

        // Mock Snap Token directly to avoid API error
        if ($order->status === 'pending_payment') {
            $snapToken = 'MOCK-SNAP-TOKEN-' . $orderNumber;
        }

        return view('public.checkout.confirmation', compact('order', 'snapToken', 'clientKey'));
    }

    /**
     * Payment status page (redirect from Midtrans Snap).
     */
    public function paymentStatus(string $orderNumber)
    {
        $order = auth()->user()->orders()
            ->where('order_number', $orderNumber)
            ->with(['payment'])
            ->firstOrFail();

        return view('public.checkout.payment-status', compact('order'));
    }

    /**
     * Get Snap Token via AJAX (for retry payment).
     */
    public function getSnapToken(string $orderNumber)
    {
        $order = auth()->user()->orders()
            ->where('order_number', $orderNumber)
            ->where('status', 'pending_payment')
            ->firstOrFail();

        return response()->json(['snap_token' => 'MOCK-SNAP-TOKEN-' . $orderNumber]);
    }

    /**
     * Handle Mock Payment Submission.
     */
    public function mockPay(string $orderNumber)
    {
        $order = auth()->user()->orders()
            ->where('order_number', $orderNumber)
            ->where('status', 'pending_payment')
            ->firstOrFail();

        // Simulate Midtrans successful payment
        $payment = $order->payment()->firstOrCreate(
            ['order_id' => $order->id],
            [
                'amount' => $order->total_amount,
                'status' => 'pending'
            ]
        );

        $payment->update([
            'status' => 'paid',
            'paid_at' => now(),
            'payment_type' => 'mock_transfer',
            'midtrans_transaction_id' => 'mock-' . uniqid(),
        ]);

        $order->update(['status' => \App\Models\Order::STATUS_PAYMENT_CONFIRMED]);

        return redirect()->route('checkout.payment-status', $orderNumber)
            ->with('success', 'Simulasi Pembayaran Berhasil!');
    }
}
