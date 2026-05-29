<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class TrackingController extends Controller
{
    public function index()
    {
        return view('public.tracking.index');
    }

    public function show(Request $request)
    {
        $request->validate([
            'order_number' => 'required|string',
        ]);

        $order = Order::with(['productionLogs' => function ($query) {
            $query->orderBy('created_at', 'asc');
        }])->where('order_number', $request->order_number)->first();

        if (!$order) {
            return redirect()->route('tracking.index')
                ->with('error', 'Nomor pesanan tidak ditemukan. Periksa kembali nomor pesanan Anda.');
        }

        return view('public.tracking.index', compact('order'));
    }
}
