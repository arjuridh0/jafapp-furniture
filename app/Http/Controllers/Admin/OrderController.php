<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\ProductionLog;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function index(Request $request): View
    {
        $query = Order::with(['user', 'payment'])->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $orders = $query->paginate(20)->withQueryString();

        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order): View
    {
        $order->load(['user', 'orderItems.product', 'payment', 'productionLogs.admin', 'customOrder']);

        $nextStatus = $order->getNextProductionStatus();

        return view('admin.orders.show', compact('order', 'nextStatus'));
    }

    public function updateShipping(Request $request, Order $order): RedirectResponse
    {
        $validated = $request->validate([
            'shipping_cost' => 'required|numeric|min:0',
        ]);

        $shippingCost = (float) $validated['shipping_cost'];
        $totalAmount = (float) $order->subtotal + $shippingCost;

        $order->update([
            'shipping_cost' => $shippingCost,
            'total_amount'  => $totalAmount,
        ]);

        return redirect()->route('admin.orders.show', $order)
            ->with('success', 'Ongkos kirim berhasil diperbarui. Total: Rp ' . number_format($totalAmount, 0, ',', '.'));
    }

    public function updateProduction(Request $request, Order $order): RedirectResponse
    {
        $validated = $request->validate([
            'status' => 'required|string',
            'notes'  => 'nullable|string|max:500',
            'photo'  => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        // Validate transition
        if (!ProductionLog::isValidTransition($order->status, $validated['status'])) {
            return redirect()->route('admin.orders.show', $order)
                ->with('error', 'Transisi status tidak valid. Status harus berurutan dan tidak boleh rollback.');
        }

        // Upload photo if provided
        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('production', 'public');
        }

        // Create production log
        ProductionLog::create([
            'order_id'   => $order->id,
            'status'     => $validated['status'],
            'notes'      => $validated['notes'] ?? null,
            'photo'      => $photoPath,
            'updated_by' => Auth::id(),
            'created_at' => now(),
        ]);

        // Update order status
        $order->update(['status' => $validated['status']]);

        return redirect()->route('admin.orders.show', $order)
            ->with('success', 'Status produksi berhasil diperbarui ke: ' . $order->status_label);
    }
}
