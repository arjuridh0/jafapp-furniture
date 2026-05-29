<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class CustomerController extends Controller
{
    /**
     * Show customer order history.
     */
    public function orders()
    {
        $orders = auth()->user()
            ->orders()
            ->with('payment')
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('customer.orders.index', compact('orders'));
    }

    /**
     * Show order detail.
     */
    public function orderDetail(string $orderNumber)
    {
        $order = auth()->user()
            ->orders()
            ->where('order_number', $orderNumber)
            ->with(['orderItems.product', 'payment', 'productionLogs'])
            ->firstOrFail();

        return view('customer.orders.show', compact('order'));
    }

    /**
     * Show customer's custom orders.
     */
    public function customOrders()
    {
        $customOrders = auth()->user()
            ->customOrders()
            ->with('order')
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('customer.custom-orders.index', compact('customOrders'));
    }

    /**
     * Show profile page with change password form.
     */
    public function profile()
    {
        return view('customer.profile');
    }

    /**
     * Update customer password.
     */
    public function updatePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => ['required'],
            'password' => ['required', 'confirmed', Password::min(8)],
        ], [
            'current_password.required' => 'Password saat ini wajib diisi.',
            'password.required' => 'Password baru wajib diisi.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'password.min' => 'Password minimal 8 karakter.',
        ]);

        if (!Hash::check($validated['current_password'], auth()->user()->password)) {
            return back()->withErrors(['current_password' => 'Password saat ini salah.']);
        }

        auth()->user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        return back()->with('success', 'Password berhasil diubah.');
    }
}
