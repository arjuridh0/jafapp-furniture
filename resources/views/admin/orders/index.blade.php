@extends('admin.layouts.app')
@section('page-title', 'Semua Pesanan')

@section('content')
<div class="mb-6">
    <form method="GET" class="flex items-center gap-2 flex-wrap">
        <select name="status" class="admin-input !w-auto text-xs">
            <option value="">Semua Status</option>
            @foreach(['pending_payment','payment_confirmed','order_received','material_preparation','in_production','finishing','quality_check','ready_to_ship','completed','cancelled'] as $s)
            <option value="{{ $s }}" {{ request('status') === $s ? 'selected' : '' }}>{{ \App\Models\Order::find(0)?->status_label ?? ucfirst(str_replace('_',' ',$s)) }}</option>
            @endforeach
        </select>
        <select name="type" class="admin-input !w-auto text-xs">
            <option value="">Semua Tipe</option>
            <option value="regular" {{ request('type') === 'regular' ? 'selected' : '' }}>Reguler</option>
            <option value="custom" {{ request('type') === 'custom' ? 'selected' : '' }}>Custom</option>
        </select>
        <input type="date" name="date_from" value="{{ request('date_from') }}" class="admin-input !w-auto text-xs">
        <input type="date" name="date_to" value="{{ request('date_to') }}" class="admin-input !w-auto text-xs">
        <button type="submit" class="btn-admin btn-admin-secondary text-xs">Filter</button>
        @if(request()->hasAny(['status','type','date_from','date_to']))
        <a href="{{ route('admin.orders.index') }}" class="text-xs text-red-500 hover:text-red-700">Reset</a>
        @endif
    </form>
</div>

<div class="bg-white border border-sand-200/60 rounded-md overflow-hidden">
    <div class="overflow-x-auto">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>No. Pesanan</th>
                    <th>Pelanggan</th>
                    <th>Tipe</th>
                    <th>Status</th>
                    <th>Pembayaran</th>
                    <th class="text-right">Total</th>
                    <th>Tanggal</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                <tr>
                    <td class="font-mono text-xs font-semibold text-teak-600">{{ $order->order_number }}</td>
                    <td>
                        <p class="font-medium text-sand-900 text-xs">{{ $order->guest_name }}</p>
                        <p class="text-[11px] text-sand-400">{{ $order->guest_email }}</p>
                    </td>
                    <td><span class="badge {{ $order->type === 'custom' ? 'badge-custom' : 'badge-production' }}">{{ $order->type === 'custom' ? 'Custom' : 'Reguler' }}</span></td>
                    <td>
                        @php
                            $bc = match(true) {
                                $order->status === 'pending_payment' => 'badge-pending',
                                in_array($order->status, ['payment_confirmed','order_received']) => 'badge-paid',
                                in_array($order->status, ['material_preparation','in_production','finishing','quality_check','ready_to_ship']) => 'badge-production',
                                $order->status === 'completed' => 'badge-completed',
                                $order->status === 'cancelled' => 'badge-cancelled',
                                default => 'badge-pending',
                            };
                        @endphp
                        <span class="badge {{ $bc }}">{{ $order->status_label }}</span>
                    </td>
                    <td>
                        @if($order->payment)
                        <span class="badge {{ $order->payment->isPaid() ? 'badge-completed' : ($order->payment->isPending() ? 'badge-pending' : 'badge-cancelled') }}">{{ $order->payment->status_label }}</span>
                        @else
                        <span class="text-xs text-sand-400">—</span>
                        @endif
                    </td>
                    <td class="text-right font-mono text-xs font-semibold">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                    <td class="text-xs text-sand-500">{{ $order->created_at->format('d/m/Y') }}</td>
                    <td><a href="{{ route('admin.orders.show', $order) }}" class="text-xs font-medium hover:underline text-teak-600">Detail</a></td>
                </tr>
                @empty
                <tr><td colspan="8" class="text-center text-sand-400 py-8">Tidak ada pesanan.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($orders->hasPages())<div class="px-5 py-3 border-t border-sand-100">{{ $orders->links() }}</div>@endif
</div>
@endsection
