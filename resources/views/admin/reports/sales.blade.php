@extends('admin.layouts.app')
@section('page-title', 'Laporan Penjualan')

@section('content')
{{-- Filters --}}
<div class="bg-white border border-sand-200/60 rounded-md p-5 mb-6">
    <form method="GET" class="flex flex-wrap items-end gap-3">
        <div>
            <label class="block text-xs font-medium text-sand-700 mb-1">Dari Tanggal</label>
            <input type="date" name="date_from" value="{{ $dateFrom }}" class="admin-input text-xs">
        </div>
        <div>
            <label class="block text-xs font-medium text-sand-700 mb-1">Sampai Tanggal</label>
            <input type="date" name="date_to" value="{{ $dateTo }}" class="admin-input text-xs">
        </div>
        <button type="submit" class="btn-admin btn-admin-primary text-xs">Tampilkan</button>
        <div class="flex gap-2 ml-auto">
            <a href="{{ route('admin.reports.sales.pdf', ['date_from' => $dateFrom, 'date_to' => $dateTo]) }}" class="btn-admin btn-admin-secondary text-xs">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                PDF
            </a>
            <a href="{{ route('admin.reports.sales.excel', ['date_from' => $dateFrom, 'date_to' => $dateTo]) }}" class="btn-admin btn-admin-secondary text-xs">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                Excel
            </a>
        </div>
    </form>
</div>

{{-- Summary Cards --}}
<div class="grid sm:grid-cols-3 gap-4 mb-6">
    <div class="kpi-card">
        <p class="text-xs text-sand-500 uppercase tracking-wider">Total Pesanan</p>
        <p class="text-2xl font-bold text-sand-900 mt-1">{{ $totalOrders }}</p>
    </div>
    <div class="kpi-card">
        <p class="text-xs text-sand-500 uppercase tracking-wider">Total Pendapatan</p>
        <p class="text-2xl font-bold mt-1 text-teak-600">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
    </div>
    <div class="kpi-card">
        <p class="text-xs text-sand-500 uppercase tracking-wider mb-2">Metode Pembayaran</p>
        @forelse($paymentBreakdown as $pb)
        <div class="flex justify-between text-xs mb-1">
            <span class="text-sand-600">{{ ucfirst(str_replace('_',' ',$pb->payment_type ?? 'Lainnya')) }}</span>
            <span class="font-semibold">{{ $pb->count }}x — Rp {{ number_format($pb->total, 0, ',', '.') }}</span>
        </div>
        @empty
        <p class="text-xs text-sand-400">Belum ada data.</p>
        @endforelse
    </div>
</div>

{{-- Orders Table --}}
<div class="bg-white border border-sand-200/60 rounded-md overflow-hidden">
    <div class="overflow-x-auto">
        <table class="admin-table">
            <thead><tr><th>No. Pesanan</th><th>Pelanggan</th><th>Tipe</th><th>Status</th><th>Metode</th><th class="text-right">Total</th><th>Tanggal</th></tr></thead>
            <tbody>
                @forelse($orders as $order)
                <tr>
                    <td class="font-mono text-xs font-semibold text-teak-600">{{ $order->order_number }}</td>
                    <td class="text-xs">{{ $order->guest_name }}</td>
                    <td><span class="badge {{ $order->type === 'custom' ? 'badge-custom' : 'badge-production' }}">{{ $order->type === 'custom' ? 'Custom' : 'Reguler' }}</span></td>
                    <td><span class="badge badge-production">{{ $order->status_label }}</span></td>
                    <td class="text-xs">{{ $order->payment?->payment_type ? ucfirst(str_replace('_',' ',$order->payment->payment_type)) : '—' }}</td>
                    <td class="text-right font-mono text-xs font-semibold">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                    <td class="text-xs text-sand-500">{{ $order->created_at->format('d/m/Y') }}</td>
                </tr>
                @empty
                <tr><td colspan="7" class="text-center text-sand-400 py-8">Tidak ada data.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($orders->hasPages())<div class="px-5 py-3 border-t border-sand-100">{{ $orders->links() }}</div>@endif
</div>
@endsection
