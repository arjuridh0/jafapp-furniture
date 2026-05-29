@extends('layouts.app')

@section('content')
<div class="bg-teak-50 min-h-screen py-12">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 text-center">

        @php
            $paymentStatus = $order->payment?->status ?? 'pending';
            $isPaid = $paymentStatus === 'paid';
            $isPending = $paymentStatus === 'pending';
            $isFailed = in_array($paymentStatus, ['failed', 'expired']);
        @endphp

        {{-- Status Icon --}}
        <div class="mb-6">
            @if($isPaid)
                <div class="w-20 h-20 mx-auto bg-forest-700/10 rounded-full flex items-center justify-center">
                    <svg class="w-10 h-10 text-forest-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                </div>
            @elseif($isPending)
                <div class="w-20 h-20 mx-auto bg-amber-50 rounded-full flex items-center justify-center">
                    <svg class="w-10 h-10 text-amber-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
            @else
                <div class="w-20 h-20 mx-auto bg-red-50 rounded-full flex items-center justify-center">
                    <svg class="w-10 h-10 text-red-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                </div>
            @endif
        </div>

        {{-- Status Message --}}
        <h1 class="text-2xl font-heading font-bold text-sand-900 mb-2" style="text-wrap: balance;">
            @if($isPaid)
                Pembayaran Berhasil!
            @elseif($isPending)
                Menunggu Pembayaran
            @else
                Pembayaran Gagal
            @endif
        </h1>

        <p class="text-sm text-sand-600 mb-8 max-w-md mx-auto leading-relaxed">
            @if($isPaid)
                Terima kasih! Pembayaran Anda telah dikonfirmasi. Pesanan sedang diproses.
            @elseif($isPending)
                Pesanan Anda sedang menunggu pembayaran. Selesaikan pembayaran sebelum batas waktu berakhir.
            @else
                Pembayaran Anda gagal atau kedaluwarsa. Silakan coba lagi atau hubungi admin.
            @endif
        </p>

        {{-- Order Info Card --}}
        <div class="bg-white rounded-sm shadow-xs border border-sand-200/50 p-6 mb-8 text-left">
            <div class="grid grid-cols-2 gap-4 text-sm">
                <div>
                    <p class="text-sand-500 text-xs mb-0.5">Nomor Pesanan</p>
                    <p class="font-mono font-semibold text-teak-700">{{ $order->order_number }}</p>
                </div>
                <div>
                    <p class="text-sand-500 text-xs mb-0.5">Status</p>
                    <x-status-badge :status="$order->status" />
                </div>
                <div>
                    <p class="text-sand-500 text-xs mb-0.5">Total Pembayaran</p>
                    <p class="font-semibold text-sand-900">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</p>
                </div>
                <div>
                    <p class="text-sand-500 text-xs mb-0.5">Status Pembayaran</p>
                    <p class="font-semibold text-sand-900">{{ $order->payment?->status_label ?? 'Menunggu' }}</p>
                </div>
            </div>
        </div>

        {{-- Retry Payment (if pending) --}}
        @if($isPending)
        <div class="mb-6">
            <a href="{{ route('checkout.confirmation', $order->order_number) }}" class="btn-primary inline-flex items-center gap-2 text-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                Lanjutkan Pembayaran
            </a>
        </div>
        @endif

        {{-- Actions --}}
        <div class="flex flex-col sm:flex-row gap-3 justify-center">
            <a href="{{ route('tracking.index') }}" class="btn-secondary text-sm flex items-center justify-center gap-2">
                Lacak Pesanan
            </a>
            <a href="{{ route('catalog.index') }}" class="btn-secondary text-sm flex items-center justify-center gap-2">
                Kembali ke Katalog
            </a>
        </div>

    </div>
</div>
@endsection
