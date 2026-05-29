@props(['status'])

@php
    $colorClass = match ($status) {
        'pending_payment' => 'bg-amber-100 text-amber-800 border-amber-200',
        'order_received', 'material_preparation', 'in_production', 'finishing', 'quality_check' => 'bg-indigo-100 text-indigo-800 border-indigo-200',
        'ready_to_ship' => 'bg-cyan-100 text-cyan-800 border-cyan-200',
        'completed' => 'bg-forest-700 text-white border-forest-700',
        'cancelled' => 'bg-red-100 text-red-800 border-red-200',
        default => 'bg-sand-100 text-sand-800 border-sand-200',
    };
    
    $label = match ($status) {
        'pending_payment' => 'Menunggu Pembayaran',
        'payment_confirmed' => 'Pembayaran Dikonfirmasi',
        'order_received' => 'Pesanan Diterima',
        'material_preparation' => 'Persiapan Material',
        'in_production' => 'Sedang Diproduksi',
        'finishing' => 'Finishing',
        'quality_check' => 'Quality Check',
        'ready_to_ship' => 'Siap Kirim',
        'completed' => 'Selesai',
        'cancelled' => 'Dibatalkan',
        default => ucfirst(str_replace('_', ' ', $status)),
    };
@endphp

<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium border {{ $colorClass }}">
    {{ $label }}
</span>
