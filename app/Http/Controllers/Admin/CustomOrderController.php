<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\CustomOrderApprovedMail;
use App\Mail\CustomOrderRejectedMail;
use App\Models\CustomOrder;
use App\Models\Order;
use App\Models\OrderItem;
use App\Services\CheckoutService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class CustomOrderController extends Controller
{
    public function index(Request $request): View
    {
        $query = CustomOrder::with('user')->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $customOrders = $query->paginate(15)->withQueryString();

        return view('admin.custom-orders.index', compact('customOrders'));
    }

    public function show(CustomOrder $customOrder): View
    {
        $customOrder->load(['user', 'order']);

        return view('admin.custom-orders.show', compact('customOrder'));
    }

    public function approve(Request $request, CustomOrder $customOrder): RedirectResponse
    {
        if ($customOrder->status !== CustomOrder::STATUS_SUBMITTED && $customOrder->status !== CustomOrder::STATUS_UNDER_REVIEW) {
            return redirect()->route('admin.custom-orders.show', $customOrder)
                ->with('error', 'Custom order sudah diproses sebelumnya.');
        }

        $validated = $request->validate([
            'agreed_price' => 'required|numeric|min:1000',
            'admin_notes'  => 'nullable|string|max:1000',
        ]);

        DB::transaction(function () use ($customOrder, $validated) {
            $checkoutService = app(CheckoutService::class);

            // Generate order number
            $orderNumber = $checkoutService->generateOrderNumber();

            // Create Order
            $order = Order::create([
                'user_id'          => $customOrder->user_id,
                'order_number'     => $orderNumber,
                'type'             => Order::TYPE_CUSTOM,
                'status'           => Order::STATUS_PENDING_PAYMENT,
                'subtotal'         => $validated['agreed_price'],
                'shipping_cost'    => 0,
                'total_amount'     => $validated['agreed_price'],
                'shipping_address' => $customOrder->user->address ?? '-',
                'guest_name'       => $customOrder->user->name,
                'guest_email'      => $customOrder->user->email,
                'guest_phone'      => $customOrder->user->phone ?? '-',
                'notes'            => 'Custom Order: ' . $customOrder->description,
            ]);

            // Create single order item
            OrderItem::create([
                'order_id'     => $order->id,
                'product_id'   => null,
                'product_name' => 'Custom Order: ' . mb_substr($customOrder->description, 0, 50),
                'qty'          => 1,
                'price'        => $validated['agreed_price'],
                'subtotal'     => $validated['agreed_price'],
            ]);

            // Update custom order
            $customOrder->update([
                'order_id'     => $order->id,
                'agreed_price' => $validated['agreed_price'],
                'admin_notes'  => $validated['admin_notes'] ?? null,
                'status'       => CustomOrder::STATUS_APPROVED,
            ]);
        });

        // Send email notification
        Mail::to($customOrder->user->email)
            ->queue(new CustomOrderApprovedMail($customOrder->fresh()));

        return redirect()->route('admin.custom-orders.show', $customOrder)
            ->with('success', 'Custom order disetujui. Pesanan baru telah dibuat dengan harga Rp ' . number_format($validated['agreed_price'], 0, ',', '.'));
    }

    public function reject(Request $request, CustomOrder $customOrder): RedirectResponse
    {
        if ($customOrder->status !== CustomOrder::STATUS_SUBMITTED && $customOrder->status !== CustomOrder::STATUS_UNDER_REVIEW) {
            return redirect()->route('admin.custom-orders.show', $customOrder)
                ->with('error', 'Custom order sudah diproses sebelumnya.');
        }

        $validated = $request->validate([
            'admin_notes' => 'required|string|max:1000',
        ]);

        $customOrder->update([
            'admin_notes' => $validated['admin_notes'],
            'status'      => CustomOrder::STATUS_REJECTED,
        ]);

        Mail::to($customOrder->user->email)
            ->queue(new CustomOrderRejectedMail($customOrder));

        return redirect()->route('admin.custom-orders.show', $customOrder)
            ->with('success', 'Custom order ditolak. Email notifikasi telah dikirim.');
    }
}
