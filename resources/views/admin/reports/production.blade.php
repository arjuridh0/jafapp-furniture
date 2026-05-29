@extends('admin.layouts.app')
@section('page-title', 'Laporan Produksi')

@section('content')
{{-- Export --}}
<div class="flex justify-end gap-2 mb-6">
    <a href="{{ route('admin.reports.production.pdf', ['date_from' => $dateFrom, 'date_to' => $dateTo]) }}" class="btn-admin btn-admin-secondary text-xs">
        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
        PDF
    </a>
    <a href="{{ route('admin.reports.production.excel', ['date_from' => $dateFrom, 'date_to' => $dateTo]) }}" class="btn-admin btn-admin-secondary text-xs">
        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
        Excel
    </a>
</div>

{{-- Summary --}}
<div class="grid sm:grid-cols-2 gap-4 mb-6">
    <div class="kpi-card">
        <p class="text-xs text-sand-500 uppercase tracking-wider">Pesanan Selesai</p>
        <p class="text-2xl font-bold mt-1 text-forest-600">{{ $completedCount }}</p>
    </div>
    <div class="kpi-card">
        <p class="text-xs text-sand-500 uppercase tracking-wider">Sedang Diproses</p>
        <p class="text-2xl font-bold text-sand-900 mt-1">{{ $inProgressCount }}</p>
    </div>
</div>

{{-- Stage Breakdown --}}
<div class="bg-white border border-sand-200/60 rounded-md p-5 mb-6">
    <h3 class="text-sm font-semibold text-sand-900 mb-4">Breakdown Per Tahapan</h3>
    <div class="space-y-3">
        @php
            $stageLabels = [
                'order_received' => 'Pesanan Diterima',
                'material_preparation' => 'Persiapan Material',
                'in_production' => 'Sedang Diproduksi',
                'finishing' => 'Finishing',
                'quality_check' => 'Quality Check',
                'ready_to_ship' => 'Siap Kirim',
                'completed' => 'Selesai',
            ];
            $maxCount = max(1, $stageBreakdown->max() ?? 1);
        @endphp
        @foreach($stageLabels as $key => $label)
        @php $count = $stageBreakdown[$key] ?? 0; @endphp
        <div>
            <div class="flex justify-between text-xs mb-1">
                <span class="text-sand-700 font-medium">{{ $label }}</span>
                <span class="font-semibold text-sand-900">{{ $count }}</span>
            </div>
            <div class="w-full h-2 rounded-full bg-sand-100">
                <div class="h-2 rounded-full transition-all bg-teak-600" style="width: {{ ($count / $maxCount) * 100 }}%"></div></div>
            </div>
        </div>
        @endforeach
    </div>
</div>

{{-- Orders Table --}}
<div class="bg-white border border-sand-200/60 rounded-md overflow-hidden">
    <div class="overflow-x-auto">
        <table class="admin-table">
            <thead><tr><th>No. Pesanan</th><th>Pelanggan</th><th>Tipe</th><th>Status</th><th>Update</th><th>Tanggal</th></tr></thead>
            <tbody>
                @forelse($orders as $order)
                <tr>
                    <td><a href="{{ route('admin.orders.show', $order) }}" class="font-mono text-xs font-semibold hover:underline text-teak-600">{{ $order->order_number }}</a></td>
                    <td class="text-xs">{{ $order->guest_name }}</td>
                    <td><span class="badge {{ $order->type === 'custom' ? 'badge-custom' : 'badge-production' }}">{{ $order->type === 'custom' ? 'Custom' : 'Reguler' }}</span></td>
                    <td><span class="badge badge-production">{{ $order->status_label }}</span></td>
                    <td class="text-xs text-sand-500">{{ $order->productionLogs->count() }} update</td>
                    <td class="text-xs text-sand-500">{{ $order->created_at->format('d/m/Y') }}</td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center text-sand-400 py-8">Tidak ada data produksi.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($orders->hasPages())<div class="px-5 py-3 border-t border-sand-100">{{ $orders->links() }}</div>@endif
</div>
@endsection
