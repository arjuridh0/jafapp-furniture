@extends('layouts.app')

@section('content')
<div class="bg-teak-50 min-h-screen py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Breadcrumb --}}
        <nav class="flex items-center text-xs font-body text-sand-500 mb-8 gap-1.5">
            <a href="{{ route('customer.orders') }}" class="hover:text-teak-700 transition">Riwayat Pesanan</a>
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
            <span class="text-sand-800 font-medium">{{ $order->order_number }}</span>
        </nav>

        {{-- Header --}}
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
            <div>
                <h1 class="text-2xl font-heading font-bold text-sand-900">Pesanan {{ $order->order_number }}</h1>
                <p class="text-sm text-sand-500 mt-1">{{ $order->created_at->translatedFormat('d F Y, H:i') }} WIB</p>
            </div>
            <x-status-badge :status="$order->status" />
        </div>

        <div class="grid lg:grid-cols-3 gap-6">
            {{-- Left Column: Items + Production --}}
            <div class="lg:col-span-2 space-y-6">
                {{-- Order Items --}}
                <div class="bg-white rounded-sm shadow-xs border border-sand-200/50 overflow-hidden">
                    <div class="p-5 sm:p-6 border-b border-sand-100">
                        <h3 class="text-base font-heading font-semibold text-sand-900">Produk Dipesan</h3>
                    </div>
                    <ul class="divide-y divide-sand-100">
                        @foreach($order->orderItems as $item)
                        <li class="flex p-5 sm:p-6 gap-4">
                            <div class="flex-shrink-0 w-16 h-16 border border-sand-200/50 rounded-sm overflow-hidden bg-sand-100">
                                @if($item->product?->first_image)
                                    <img src="{{ asset('storage/' . $item->product->first_image) }}" alt="{{ $item->product->name }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center"><span class="font-heading italic text-[10px] text-sand-300">JAF</span></div>
                                @endif
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-sand-900">{{ $item->product_name ?? $item->product?->name ?? 'Produk' }}</p>
                                <p class="text-xs text-sand-500 mt-0.5">{{ $item->qty }}x @ Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                            </div>
                            <p class="text-sm font-semibold text-sand-800 whitespace-nowrap">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</p>
                        </li>
                        @endforeach
                    </ul>
                </div>

                {{-- Production Timeline --}}
                @if($order->isInProduction() || $order->status === 'completed')
                <div class="bg-white rounded-sm shadow-xs border border-sand-200/50 p-5 sm:p-6">
                    <h3 class="text-base font-heading font-semibold text-sand-900 mb-5">Progres Produksi</h3>
                    <x-production-stepper :order="$order" />
                </div>
                @endif
            </div>

            {{-- Right Column: Summary + Shipping --}}
            <div class="space-y-6">
                {{-- Payment Summary --}}
                <div class="bg-white rounded-sm shadow-xs border border-sand-200/50 p-5 sm:p-6">
                    <h3 class="text-base font-heading font-semibold text-sand-900 mb-4">Ringkasan Pembayaran</h3>
                    <div class="space-y-2.5 text-sm">
                        <div class="flex justify-between">
                            <span class="text-sand-500">Subtotal</span>
                            <span class="text-sand-800">Rp {{ number_format($order->subtotal, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sand-500">Ongkos Kirim</span>
                            <span class="text-sand-800">
                                @if($order->shipping_cost > 0)
                                    Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}
                                @else
                                    <span class="text-xs text-sand-400 italic">Belum ditentukan</span>
                                @endif
                            </span>
                        </div>
                        <div class="flex justify-between pt-2.5 border-t border-sand-200 font-bold">
                            <span class="text-sand-900">Total</span>
                            <span class="text-teak-700">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    @if($order->payment)
                    <div class="mt-4 pt-4 border-t border-sand-100">
                        <div class="flex justify-between text-sm">
                            <span class="text-sand-500">Status Pembayaran</span>
                            <span class="font-medium">{{ $order->payment->status_label }}</span>
                        </div>
                        @if($order->payment->payment_type)
                        <div class="flex justify-between text-sm mt-1">
                            <span class="text-sand-500">Metode</span>
                            <span class="text-sand-800">{{ ucfirst(str_replace('_', ' ', $order->payment->payment_type)) }}</span>
                        </div>
                        @endif
                    </div>
                    @endif

                    {{-- Retry payment button --}}
                    @if($order->status === 'pending_payment')
                    <div class="mt-4">
                        <a href="{{ route('checkout.confirmation', $order->order_number) }}" class="w-full btn-primary flex items-center justify-center gap-2 text-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                            Bayar Sekarang
                        </a>
                    </div>
                    @endif
                </div>

                {{-- Shipping Info --}}
                <div class="bg-white rounded-sm shadow-xs border border-sand-200/50 p-5 sm:p-6">
                    <h3 class="text-base font-heading font-semibold text-sand-900 mb-4">Informasi Pengiriman</h3>
                    <div class="space-y-3 text-sm">
                        <div>
                            <p class="text-sand-500 text-xs mb-0.5">Nama</p>
                            <p class="text-sand-900">{{ $order->guest_name }}</p>
                        </div>
                        <div>
                            <p class="text-sand-500 text-xs mb-0.5">Email</p>
                            <p class="text-sand-900">{{ $order->guest_email }}</p>
                        </div>
                        <div>
                            <p class="text-sand-500 text-xs mb-0.5">No. HP</p>
                            <p class="text-sand-900">{{ $order->guest_phone }}</p>
                        </div>
                        <div>
                            <p class="text-sand-500 text-xs mb-0.5">Alamat</p>
                            <p class="text-sand-900">{{ $order->shipping_address }}</p>
                        </div>
                        @if($order->notes)
                        <div>
                            <p class="text-sand-500 text-xs mb-0.5">Catatan</p>
                            <p class="text-sand-900">{{ $order->notes }}</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
