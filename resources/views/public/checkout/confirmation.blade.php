@extends('layouts.app')

@section('content')
<div class="bg-teak-50 min-h-screen py-12">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Success Banner --}}
        <div class="bg-forest-700/5 border border-forest-600/20 rounded-sm p-5 mb-8 flex items-start gap-3">
            <div class="flex-shrink-0 w-10 h-10 bg-forest-700/10 rounded-full flex items-center justify-center">
                <svg class="w-5 h-5 text-forest-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
            </div>
            <div>
                <h2 class="text-base font-heading font-semibold text-sand-900">Pesanan Berhasil Dibuat!</h2>
                <p class="text-sm text-sand-600 mt-0.5">Nomor pesanan Anda: <strong class="text-teak-700 font-mono">{{ $order->order_number }}</strong></p>
            </div>
        </div>

        {{-- Order Details Card --}}
        <div class="bg-white rounded-sm shadow-xs border border-sand-200/50 overflow-hidden mb-6">
            <div class="p-6 sm:p-8">
                <h3 class="text-lg font-heading font-semibold text-sand-900 mb-5 pb-3 border-b border-sand-100">Detail Pesanan</h3>

                {{-- Items --}}
                <ul class="divide-y divide-sand-100 -my-3 mb-6">
                    @foreach($order->orderItems as $item)
                    <li class="flex py-3 gap-3">
                        <div class="flex-shrink-0 w-12 h-12 border border-sand-200/50 rounded-sm overflow-hidden bg-sand-100">
                            @if($item->product?->first_image)
                                <img src="{{ asset('storage/' . $item->product->first_image) }}" alt="{{ $item->product->name }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center"><span class="font-heading italic text-[9px] text-sand-300">JAF</span></div>
                            @endif
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-sand-900 truncate">{{ $item->product_name ?? $item->product?->name ?? 'Produk' }}</p>
                            <p class="text-xs text-sand-500">{{ $item->qty }}x @ Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                        </div>
                        <p class="text-sm font-semibold text-sand-800">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</p>
                    </li>
                    @endforeach
                </ul>

                {{-- Totals --}}
                <div class="border-t border-sand-200 pt-4 space-y-2">
                    <div class="flex justify-between text-sm">
                        <span class="text-sand-500">Subtotal</span>
                        <span class="text-sand-800">Rp {{ number_format($order->subtotal, 0, ',', '.') }}</span>
                    </div>
                    @if($order->shipping_cost > 0)
                    <div class="flex justify-between text-sm">
                        <span class="text-sand-500">Ongkos Kirim</span>
                        <span class="text-sand-800">Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}</span>
                    </div>
                    @else
                    <div class="flex justify-between text-sm">
                        <span class="text-sand-500">Ongkos Kirim</span>
                        <span class="text-xs text-sand-400 italic">Akan diinformasikan admin</span>
                    </div>
                    @endif
                    <div class="flex justify-between text-base font-bold pt-3 border-t border-sand-200">
                        <span class="text-sand-900">Total Pembayaran</span>
                        <span class="text-teak-700">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>

            {{-- Shipping Info --}}
            <div class="bg-sand-50/50 border-t border-sand-200/50 p-6 sm:p-8">
                <h4 class="text-sm font-semibold text-sand-800 mb-3">Informasi Pengiriman</h4>
                <div class="grid sm:grid-cols-2 gap-3 text-sm">
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
                </div>
                @if($order->notes)
                <div class="mt-3">
                    <p class="text-sand-500 text-xs mb-0.5">Catatan</p>
                    <p class="text-sand-900 text-sm">{{ $order->notes }}</p>
                </div>
                @endif
            </div>
        </div>

        {{-- Payment Section --}}
        @if($order->status === 'pending_payment')
        <div class="bg-white rounded-sm shadow-xs border border-sand-200/50 p-6 sm:p-8 mb-6">
            <h3 class="text-lg font-heading font-semibold text-sand-900 mb-3">Pembayaran</h3>
            <p class="text-sm text-sand-600 mb-6">Lanjutkan pembayaran untuk memproses pesanan Anda.</p>

            <form action="{{ route('checkout.mock-pay', $order->order_number) }}" method="POST">
                @csrf
                <button type="submit" id="pay-button" class="w-full btn-primary flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                    Simulasi Pembayaran (Mock Pay)
                </button>
            </form>
        </div>
        @endif

        {{-- Actions --}}
        <div class="flex flex-col sm:flex-row gap-3">
            <a href="{{ route('tracking.index') }}" class="btn-secondary text-center text-sm flex-1 flex items-center justify-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                Lacak Pesanan
            </a>
            <a href="{{ route('catalog.index') }}" class="btn-secondary text-center text-sm flex-1 flex items-center justify-center gap-2">
                Lanjut Belanja
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
            </a>
        </div>

    </div>
</div>


@endsection
