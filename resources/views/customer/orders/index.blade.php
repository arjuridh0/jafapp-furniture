@extends('layouts.app')

@section('content')
<div class="bg-teak-50 min-h-screen py-12">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

        <h1 class="text-3xl font-heading font-bold text-sand-900 mb-2" style="text-wrap: balance;">Riwayat Pesanan</h1>
        <p class="text-sm text-sand-500 mb-8">Daftar semua pesanan Anda</p>

        @if($orders->count() > 0)
            <div class="space-y-4">
                @foreach($orders as $order)
                <a href="{{ route('customer.orders.show', $order->order_number) }}"
                    class="block bg-white rounded-sm shadow-xs border border-sand-200/50 p-5 sm:p-6 hover:border-teak-700/30 hover:shadow-md transition-all duration-300 ease-teak-smooth group">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center gap-3 mb-2">
                                <span class="font-mono text-sm font-semibold text-teak-700">{{ $order->order_number }}</span>
                                <x-status-badge :status="$order->status" />
                            </div>
                            <p class="text-xs text-sand-500">
                                {{ $order->created_at->translatedFormat('d F Y, H:i') }} WIB
                            </p>
                        </div>
                        <div class="flex items-center gap-4">
                            <div class="text-right">
                                <p class="text-xs text-sand-500">Total</p>
                                <p class="text-base font-bold text-sand-900">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</p>
                            </div>
                            <svg class="w-5 h-5 text-sand-400 group-hover:text-teak-700 transition-colors flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                        </div>
                    </div>

                    {{-- Payment status --}}
                    @if($order->payment)
                    <div class="mt-3 pt-3 border-t border-sand-100 flex items-center gap-2">
                        @if($order->payment->isPaid())
                            <span class="inline-flex items-center gap-1 text-xs text-forest-600">
                                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                                Pembayaran Lunas
                            </span>
                        @elseif($order->payment->isPending())
                            <span class="inline-flex items-center gap-1 text-xs text-amber-600">
                                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/></svg>
                                Menunggu Pembayaran
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1 text-xs text-red-500">
                                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/></svg>
                                {{ $order->payment->status_label }}
                            </span>
                        @endif
                    </div>
                    @endif
                </a>
                @endforeach
            </div>

            <div class="mt-8">
                {{ $orders->links() }}
            </div>
        @else
            <div class="bg-white rounded-sm border border-sand-200/50 p-16 text-center shadow-xs">
                <div class="mx-auto h-16 w-16 text-sand-300 mb-5 bg-sand-50 rounded-full flex items-center justify-center border border-sand-100">
                    <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                </div>
                <h2 class="text-xl font-heading font-bold text-sand-900 mb-2">Belum ada pesanan</h2>
                <p class="text-sm text-sand-500 mb-6">Mulai belanja untuk melihat riwayat pesanan Anda.</p>
                <a href="{{ route('catalog.index') }}" class="btn-primary inline-flex items-center gap-2 text-sm">
                    Mulai Belanja
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
