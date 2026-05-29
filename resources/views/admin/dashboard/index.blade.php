@extends('admin.layouts.app')

@section('page-title', 'Dashboard')

@section('content')
{{-- Super Admin Extras --}}
@if(isset($superAdminData))
<div class="mb-8">
    <div class="flex items-center gap-2 mb-4">
        <svg class="w-5 h-5 text-teak-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
        <h2 class="text-base font-bold text-sand-900 uppercase tracking-wide">Ringkasan Super Admin</h2>
    </div>
    
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="kpi-card !bg-teak-50 !border-teak-100">
            <p class="text-xs font-medium text-teak-700 uppercase tracking-wider">Total Pelanggan</p>
            <div class="flex items-end justify-between mt-1">
                <p class="text-2xl font-bold text-sand-900">{{ $superAdminData['totalCustomers'] }}</p>
                <span class="text-xs font-semibold text-forest-600 bg-forest-50 px-1.5 py-0.5 rounded-sm">+{{ $superAdminData['newUsersThisMonth'] }} bln ini</span>
            </div>
        </div>
        <div class="kpi-card !bg-teak-50 !border-teak-100">
            <p class="text-xs font-medium text-teak-700 uppercase tracking-wider">Total Admin</p>
            <p class="text-2xl font-bold text-sand-900 mt-1">{{ $superAdminData['totalAdmins'] }}</p>
        </div>
        <div class="kpi-card !bg-sand-50 !border-sand-200">
            <p class="text-xs font-medium text-sand-600 uppercase tracking-wider">Custom Order (Pending)</p>
            <p class="text-2xl font-bold text-sand-900 mt-1">{{ $superAdminData['pendingCustomOrders'] }}</p>
        </div>
        <div class="kpi-card !bg-sand-50 !border-sand-200">
            <p class="text-xs font-medium text-sand-600 uppercase tracking-wider">Total Custom Order</p>
            <p class="text-2xl font-bold text-sand-900 mt-1">{{ $superAdminData['totalCustomOrders'] }}</p>
        </div>
    </div>
</div>
@endif

{{-- KPI Cards --}}
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
    <div class="kpi-card">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs font-medium text-sand-500 uppercase tracking-wider">Pesanan Hari Ini</p>
                <p class="text-2xl font-bold text-sand-900 mt-1">{{ $todayOrders }}</p>
            </div>
            <div class="w-10 h-10 rounded-lg flex items-center justify-center badge-production">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
            </div>
        </div>
    </div>

    <div class="kpi-card">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs font-medium text-sand-500 uppercase tracking-wider">Pendapatan Bulan Ini</p>
                <p class="text-2xl font-bold text-sand-900 mt-1">Rp {{ number_format($monthRevenue, 0, ',', '.') }}</p>
            </div>
            <div class="w-10 h-10 rounded-lg flex items-center justify-center badge-completed">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
        </div>
    </div>

    <div class="kpi-card">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs font-medium text-sand-500 uppercase tracking-wider">Menunggu Pembayaran</p>
                <p class="text-2xl font-bold text-sand-900 mt-1">{{ $pendingOrders }}</p>
            </div>
            <div class="w-10 h-10 rounded-lg flex items-center justify-center badge-pending">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
        </div>
    </div>

    <div class="kpi-card">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs font-medium text-sand-500 uppercase tracking-wider">Produksi Berjalan</p>
                <p class="text-2xl font-bold text-sand-900 mt-1">{{ $activeProduction }}</p>
            </div>
            <div class="w-10 h-10 rounded-lg flex items-center justify-center bg-teak-100">
                <svg class="w-5 h-5 text-teak-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/></svg>
            </div>
        </div>
    </div>
</div>

{{-- Charts Section --}}
<div class="grid grid-cols-1 {{ isset($superAdminData) ? 'lg:grid-cols-3' : '' }} gap-6 mb-8">
    <div class="{{ isset($superAdminData) ? 'lg:col-span-2' : '' }} bg-white border border-sand-200/60 rounded-md p-5 flex flex-col">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-sm font-semibold text-sand-900">Tren Pesanan & Pendapatan (30 Hari)</h3>
            @if(isset($superAdminData))
            <div class="flex items-center gap-3 text-[10px] uppercase font-bold tracking-wider">
                <span class="flex items-center gap-1.5 text-sand-500"><span class="w-2.5 h-2.5 rounded-full bg-sand-300"></span> Pesanan</span>
                <span class="flex items-center gap-1.5 text-teak-700"><span class="w-2.5 h-2.5 rounded-full bg-teak-600"></span> Pendapatan</span>
            </div>
            @endif
        </div>
        <div class="relative flex-1 min-h-[250px]">
            <canvas id="mainChart"></canvas>
        </div>
    </div>
    
    @if(isset($superAdminData))
    <div class="bg-white border border-sand-200/60 rounded-md p-5 flex flex-col">
        <h3 class="text-sm font-semibold text-sand-900 mb-4">Distribusi Status Pesanan</h3>
        <div class="relative flex-1 min-h-[250px] flex items-center justify-center">
            @if(empty($superAdminData['statusDistribution']))
                <p class="text-xs text-sand-400">Belum ada data pesanan.</p>
            @else
                <canvas id="pieChart"></canvas>
            @endif
        </div>
    </div>
    @endif
</div>

{{-- Recent Orders Table --}}
<div class="bg-white border border-sand-200/60 rounded-md overflow-hidden">
    <div class="px-5 py-4 border-b border-sand-100 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <h3 class="text-sm font-semibold text-sand-900">Pesanan Terbaru</h3>
        <form method="GET" action="{{ route('admin.dashboard') }}" class="flex items-center gap-2 flex-wrap">
            <select name="status" class="admin-input !w-auto text-xs !py-1.5">
                <option value="">Semua Status</option>
                <option value="pending_payment" {{ request('status') == 'pending_payment' ? 'selected' : '' }}>Menunggu Pembayaran</option>
                <option value="payment_confirmed" {{ request('status') == 'payment_confirmed' ? 'selected' : '' }}>Pembayaran Dikonfirmasi</option>
                <option value="order_received" {{ request('status') == 'order_received' ? 'selected' : '' }}>Pesanan Diterima</option>
                <option value="in_production" {{ request('status') == 'in_production' ? 'selected' : '' }}>Sedang Diproduksi</option>
                <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Selesai</option>
                <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
            </select>
            <input type="date" name="date_from" value="{{ request('date_from') }}" class="admin-input !w-auto text-xs !py-1.5" placeholder="Dari">
            <input type="date" name="date_to" value="{{ request('date_to') }}" class="admin-input !w-auto text-xs !py-1.5" placeholder="Sampai">
            <button type="submit" class="btn-admin btn-admin-secondary text-xs !py-1.5">Filter</button>
            @if(request()->hasAny(['status', 'date_from', 'date_to']))
                <a href="{{ route('admin.dashboard') }}" class="text-xs text-red-500 hover:text-red-700">Reset</a>
            @endif
        </form>
    </div>

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
                        <div>
                            <p class="font-medium text-sand-900 text-xs">{{ $order->guest_name }}</p>
                            <p class="text-[11px] text-sand-400">{{ $order->guest_email }}</p>
                        </div>
                    </td>
                    <td>
                        <span class="badge {{ $order->type === 'custom' ? 'badge-custom' : 'badge-production' }}">
                            {{ $order->type === 'custom' ? 'Custom' : 'Reguler' }}
                        </span>
                    </td>
                    <td>
                        @php
                            $badgeClass = match(true) {
                                in_array($order->status, ['pending_payment']) => 'badge-pending',
                                in_array($order->status, ['payment_confirmed', 'order_received']) => 'badge-paid',
                                in_array($order->status, ['material_preparation', 'in_production', 'finishing', 'quality_check', 'ready_to_ship']) => 'badge-production',
                                $order->status === 'completed' => 'badge-completed',
                                $order->status === 'cancelled' => 'badge-cancelled',
                                default => 'badge-pending',
                            };
                        @endphp
                        <span class="badge {{ $badgeClass }}">{{ $order->status_label }}</span>
                    </td>
                    <td>
                        @if($order->payment)
                            <span class="badge {{ $order->payment->isPaid() ? 'badge-completed' : ($order->payment->isPending() ? 'badge-pending' : 'badge-cancelled') }}">
                                {{ $order->payment->status_label }}
                            </span>
                        @else
                            <span class="text-xs text-sand-400">—</span>
                        @endif
                    </td>
                    <td class="text-right font-mono text-xs font-semibold">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                    <td class="text-xs text-sand-500">{{ $order->created_at->format('d/m/Y') }}</td>
                    <td>
                        <a href="{{ route('admin.orders.show', $order) }}" class="text-xs font-medium hover:underline text-teak-600">Detail</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center text-sand-400 py-8">Belum ada pesanan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($orders->hasPages())
    <div class="px-5 py-3 border-t border-sand-100">
        {{ $orders->links() }}
    </div>
    @endif
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // ─── Main Chart (Orders & Revenue) ──────────────────────────────────
    const ctxMain = document.getElementById('mainChart').getContext('2d');
    const orderData = @json($chart);
    const labels = Object.keys(orderData).map(d => {
        const date = new Date(d);
        return date.toLocaleDateString('id-ID', { day: 'numeric', month: 'short' });
    });
    
    const datasets = [{
        label: 'Pesanan',
        data: Object.values(orderData),
        borderColor: 'oklch(0.65 0 80)', // sand-400
        backgroundColor: 'oklch(0.65 0 80 / 0.1)',
        borderWidth: 2,
        fill: true,
        tension: 0.3,
        pointBackgroundColor: 'oklch(0.65 0 80)',
        pointRadius: 2,
        pointHoverRadius: 5,
        yAxisID: 'y'
    }];

    @if(isset($superAdminData))
    const revenueData = @json($superAdminData['revenueChart']);
    datasets.push({
        label: 'Pendapatan (Rp)',
        data: Object.values(revenueData),
        borderColor: 'oklch(0.55 0.12 55)', // teak-600
        backgroundColor: 'oklch(0.55 0.12 55 / 0.1)',
        borderWidth: 2,
        fill: true,
        tension: 0.3,
        pointBackgroundColor: 'oklch(0.55 0.12 55)',
        pointRadius: 2,
        pointHoverRadius: 5,
        yAxisID: 'y1'
    });
    @endif

    new Chart(ctxMain, {
        type: 'line',
        data: { labels, datasets },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { 
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            let label = context.dataset.label || '';
                            if (label) {
                                label += ': ';
                            }
                            if (context.datasetIndex === 1) {
                                label += new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(context.raw);
                            } else {
                                label += context.raw;
                            }
                            return label;
                        }
                    }
                }
            },
            scales: {
                y: { 
                    type: 'linear',
                    display: true,
                    position: 'left',
                    beginAtZero: true, 
                    ticks: { stepSize: 1, font: { size: 10 } }, 
                    grid: { color: 'oklch(0.95 0 0)', drawBorder: false } 
                },
                @if(isset($superAdminData))
                y1: {
                    type: 'linear',
                    display: true,
                    position: 'right',
                    beginAtZero: true,
                    grid: { drawOnChartArea: false },
                    ticks: {
                        font: { size: 10 },
                        callback: function(value) {
                            if (value >= 1000000) return (value / 1000000).toFixed(1) + 'Jt';
                            if (value >= 1000) return (value / 1000).toFixed(0) + 'K';
                            return value;
                        }
                    }
                },
                @endif
                x: { ticks: { font: { size: 10 }, maxTicksLimit: 10 }, grid: { display: false } }
            }
        }
    });

    // ─── Pie Chart (Status Distribution) ────────────────────────────────
    @if(isset($superAdminData) && !empty($superAdminData['statusDistribution']))
    const ctxPie = document.getElementById('pieChart');
    if (ctxPie) {
        const distData = @json($superAdminData['statusDistribution']);
        const pieColors = {
            'Menunggu Bayar': 'oklch(0.85 0.15 70)', // amber-300
            'Dibayar': 'oklch(0.7 0.15 155)', // emerald-400
            'Produksi': 'oklch(0.55 0.15 250)', // blue-500
            'Selesai': 'oklch(0.5 0.15 155)', // forest-600
            'Batal': 'oklch(0.55 0.2 25)', // red-600
            'Lainnya': 'oklch(0.7 0 80)' // sand-400
        };
        
        new Chart(ctxPie.getContext('2d'), {
            type: 'doughnut',
            data: {
                labels: Object.keys(distData),
                datasets: [{
                    data: Object.values(distData),
                    backgroundColor: Object.keys(distData).map(k => pieColors[k] || pieColors['Lainnya']),
                    borderWidth: 0,
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '70%',
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: { boxWidth: 10, usePointStyle: true, font: { size: 11 } }
                    }
                }
            }
        });
    }
    @endif
});
</script>
@endpush
