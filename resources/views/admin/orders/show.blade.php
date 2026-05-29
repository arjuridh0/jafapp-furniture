@extends('admin.layouts.app')
@section('page-title', 'Detail Pesanan ' . $order->order_number)

@section('content')
<a href="{{ route('admin.orders.index') }}" class="text-xs text-sand-500 hover:text-teak-700 mb-4 inline-flex items-center gap-1">
    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
    Kembali ke Daftar Pesanan
</a>

<div class="grid lg:grid-cols-3 gap-6">
    {{-- Left: Items + Production --}}
    <div class="lg:col-span-2 space-y-6">
        {{-- Order Info --}}
        <div class="bg-white border border-sand-200/60 rounded-md p-5">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-base font-semibold text-sand-900">{{ $order->order_number }}</h3>
                @php
                    $bc = match(true) {
                        $order->status === 'pending_payment' => 'badge-pending',
                        $order->status === 'completed' => 'badge-completed',
                        $order->status === 'cancelled' => 'badge-cancelled',
                        default => 'badge-production',
                    };
                @endphp
                <span class="badge {{ $bc }}">{{ $order->status_label }}</span>
            </div>
            <div class="grid sm:grid-cols-2 gap-4 text-sm">
                <div>
                    <p class="text-xs text-sand-500">Pelanggan</p>
                    <p class="font-medium text-sand-900">{{ $order->guest_name }}</p>
                    <p class="text-xs text-sand-500 mt-0.5">{{ $order->guest_email }} &bull; {{ $order->guest_phone }}</p>
                </div>
                <div>
                    <p class="text-xs text-sand-500">Alamat Pengiriman</p>
                    <p class="text-sand-900">{{ $order->shipping_address }}</p>
                </div>
                @if($order->notes)
                <div class="sm:col-span-2">
                    <p class="text-xs text-sand-500">Catatan</p>
                    <p class="text-sand-900">{{ $order->notes }}</p>
                </div>
                @endif
            </div>
        </div>

        {{-- Items --}}
        <div class="bg-white border border-sand-200/60 rounded-md overflow-hidden">
            <div class="p-5 border-b border-sand-100"><h3 class="text-sm font-semibold text-sand-900">Produk Dipesan</h3></div>
            <table class="admin-table">
                <thead><tr><th>Produk</th><th class="text-center">Qty</th><th class="text-right">Harga</th><th class="text-right">Subtotal</th></tr></thead>
                <tbody>
                    @foreach($order->orderItems as $item)
                    <tr>
                        <td class="text-sm">{{ $item->product?->name ?? 'Custom Order' }}</td>
                        <td class="text-center">{{ $item->qty }}</td>
                        <td class="text-right font-mono text-xs">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                        <td class="text-right font-mono text-xs font-semibold">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Production Timeline --}}
        @if($order->isInProduction() || $order->status === 'completed')
        <div class="bg-white border border-sand-200/60 rounded-md p-5">
            <h3 class="text-sm font-semibold text-sand-900 mb-4">Riwayat Produksi</h3>
            @if($order->productionLogs->count() > 0)
            <div class="space-y-4">
                @foreach($order->productionLogs->sortByDesc('created_at') as $log)
                <div class="flex gap-3 pb-4 border-b border-sand-100 last:border-0 last:pb-0">
                    @if($log->photo)
                    <div class="w-12 h-12 rounded-sm overflow-hidden border border-sand-200 flex-shrink-0">
                        <img src="{{ asset('storage/' . $log->photo) }}" class="w-full h-full object-cover">
                    </div>
                    @endif
                    <div>
                        <span class="badge badge-production text-[10px]">{{ $log->status_label }}</span>
                        <p class="text-xs text-sand-500 mt-1">{{ $log->created_at ? $log->created_at->translatedFormat('d M Y, H:i') : '-' }} — oleh {{ $log->admin?->name ?? 'System' }}</p>
                        @if($log->notes)<p class="text-xs text-sand-700 mt-0.5">{{ $log->notes }}</p>@endif
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <p class="text-xs text-sand-400">Belum ada update produksi.</p>
            @endif

            {{-- Update Production Form --}}
            @if($nextStatus)
            <div class="mt-5 pt-5 border-t border-sand-200">
                <h4 class="text-sm font-medium text-sand-900 mb-3">Update Status Produksi</h4>
                <form method="POST" action="{{ route('admin.orders.update-production', $order) }}" enctype="multipart/form-data" class="space-y-3">
                    @csrf
                    <div class="flex items-center gap-2">
                        <span class="text-xs text-sand-500">Status berikutnya:</span>
                        <span class="badge badge-production font-semibold">{{ \App\Models\Order::find(0)?->status_label ?? ucfirst(str_replace('_',' ',$nextStatus)) }}</span>
                        <input type="hidden" name="status" value="{{ $nextStatus }}">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-sand-700 mb-1">Catatan (opsional)</label>
                        <textarea name="notes" rows="2" class="admin-input text-xs" placeholder="Catatan progress..."></textarea>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-sand-700 mb-1">Foto Progress (opsional)</label>
                        <input type="file" name="photo" accept="image/*" class="admin-input text-xs">
                    </div>
                    <button type="submit" class="btn-admin btn-admin-success text-xs" onclick="return confirm('Yakin update status ke {{ ucfirst(str_replace('_',' ',$nextStatus)) }}?')">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                        Update ke {{ ucfirst(str_replace('_', ' ', $nextStatus)) }}
                    </button>
                </form>
            </div>
            @endif
        </div>
        @endif
    </div>

    {{-- Right: Payment + Shipping Cost --}}
    <div class="space-y-6">
        {{-- Payment Summary --}}
        <div class="bg-white border border-sand-200/60 rounded-md p-5">
            <h3 class="text-sm font-semibold text-sand-900 mb-4">Ringkasan Pembayaran</h3>
            <div class="space-y-2 text-sm">
                <div class="flex justify-between"><span class="text-sand-500">Subtotal</span><span>Rp {{ number_format($order->subtotal, 0, ',', '.') }}</span></div>
                <div class="flex justify-between"><span class="text-sand-500">Ongkir</span><span>Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}</span></div>
                <div class="flex justify-between pt-2 border-t font-bold"><span>Total</span><span class="text-teak-600">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span></div>
            </div>
            @if($order->payment)
            <div class="mt-3 pt-3 border-t border-sand-100 text-sm">
                <div class="flex justify-between"><span class="text-sand-500">Status</span><span class="font-medium">{{ $order->payment->status_label }}</span></div>
                @if($order->payment->payment_type)
                <div class="flex justify-between mt-1"><span class="text-sand-500">Metode</span><span>{{ ucfirst(str_replace('_',' ',$order->payment->payment_type)) }}</span></div>
                @endif
                @if($order->payment->paid_at)
                <div class="flex justify-between mt-1"><span class="text-sand-500">Tanggal Bayar</span><span>{{ $order->payment->paid_at->format('d/m/Y H:i') }}</span></div>
                @endif
            </div>
            @endif
        </div>

        {{-- Edit Shipping Cost --}}
        <div class="bg-white border border-sand-200/60 rounded-md p-5">
            <h3 class="text-sm font-semibold text-sand-900 mb-3">Edit Ongkos Kirim</h3>
            <form method="POST" action="{{ route('admin.orders.update-shipping', $order) }}">
                @csrf
                <div class="mb-3">
                    <label class="block text-xs font-medium text-sand-700 mb-1">Ongkos Kirim (Rp)</label>
                    <input type="number" name="shipping_cost" value="{{ (int) $order->shipping_cost }}" class="admin-input" min="0" required>
                </div>
                <button type="submit" class="btn-admin btn-admin-primary w-full text-xs justify-center">
                    Perbarui Ongkir
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
