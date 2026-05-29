@extends('layouts.app')

@section('content')
<div class="bg-teak-50 min-h-screen py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <h1 class="text-3xl font-heading font-bold text-sand-900 mb-8 leading-tight">Keranjang Belanja</h1>

        @if(count($cart) > 0)
            <div class="lg:grid lg:grid-cols-12 lg:gap-x-8">
                <!-- Cart Items -->
                <div class="lg:col-span-8">
                    <div class="bg-white rounded-sm shadow-xs border border-sand-200/50 overflow-hidden">
                        <ul role="list" class="divide-y divide-sand-200/60">
                            @foreach($cart as $id => $details)
                                <li class="flex py-6 px-4 sm:px-6 font-body">
                                    <div class="flex-shrink-0 w-24 h-24 border border-sand-200/50 rounded-sm overflow-hidden bg-sand-100">
                                        @if($details['image'] && $details['image'] !== 'images/no-image.png')
                                            <img src="{{ asset('storage/' . $details['image']) }}" alt="{{ $details['name'] }}" class="w-full h-full object-center object-cover">
                                        @else
                                            <!-- Monogram mini placeholder -->
                                            <div class="w-full h-full flex items-center justify-center bg-sand-100 text-sand-400 relative">
                                                <div class="absolute inset-2 border border-dashed border-sand-300/60 rounded-xs flex items-center justify-center">
                                                    <span class="font-heading italic text-sm font-semibold text-sand-300">JAF</span>
                                                </div>
                                            </div>
                                        @endif
                                    </div>

                                    <div class="ml-4 flex-1 flex flex-col justify-between">
                                        <div>
                                            <div class="flex justify-between text-base font-semibold text-sand-900">
                                                <h3 class="line-clamp-2 font-heading"><a href="#" class="hover:text-teak-700 transition">{{ $details['name'] }}</a></h3>
                                                <p class="ml-4 whitespace-nowrap">Rp {{ number_format($details['price'] * $details['qty'], 0, ',', '.') }}</p>
                                            </div>
                                            <p class="mt-1 text-xs text-sand-500">Rp {{ number_format($details['price'], 0, ',', '.') }} / item</p>
                                        </div>
                                        
                                        <div class="flex items-center justify-between text-sm mt-4">
                                            <form action="{{ route('cart.update') }}" method="POST" class="flex items-center gap-2">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="product_id" value="{{ $id }}">
                                                <label for="qty-{{ $id }}" class="sr-only">Quantity</label>
                                                <div class="flex items-center border border-sand-300 rounded-sm bg-white overflow-hidden">
                                                    <button type="button" @click="let input = document.getElementById('qty-{{ $id }}'); if(input.value > 1) { input.value--; input.form.submit(); }" class="px-2.5 py-1 text-sand-600 hover:bg-sand-100 transition-colors font-semibold select-none">-</button>
                                                    <input type="number" name="qty" id="qty-{{ $id }}" value="{{ $details['qty'] }}" min="1" class="w-10 text-center border-0 focus:ring-0 p-1 text-xs font-semibold text-sand-800" onchange="this.form.submit()">
                                                    <button type="button" @click="let input = document.getElementById('qty-{{ $id }}'); input.value++; input.form.submit();" class="px-2.5 py-1 text-sand-600 hover:bg-sand-100 transition-colors font-semibold select-none">+</button>
                                                </div>
                                            </form>

                                            <form action="{{ route('cart.remove') }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <input type="hidden" name="product_id" value="{{ $id }}">
                                                <button type="submit" class="font-medium text-red-600 hover:text-red-500 flex items-center gap-1 transition">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                    Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="lg:col-span-4 mt-8 lg:mt-0 font-body">
                    <div class="bg-white rounded-sm shadow-xs border border-sand-200/50 p-6 sticky top-24">
                        <h2 class="text-lg font-heading font-semibold text-sand-900 mb-5 pb-2 border-b border-sand-100">Ringkasan Belanja</h2>
                        
                        @php
                            $total = 0;
                            foreach($cart as $details) {
                                $total += $details['price'] * $details['qty'];
                            }
                        @endphp
                        
                        <div class="flow-root">
                            <dl class="-my-4 text-sm divide-y divide-sand-200/60">
                                <div class="py-4 flex items-center justify-between">
                                    <dt class="text-sand-500">Total Harga</dt>
                                    <dd class="font-semibold text-sand-900">Rp {{ number_format($total, 0, ',', '.') }}</dd>
                                </div>
                                <div class="py-4 flex items-center justify-between">
                                    <dt class="text-base font-bold text-sand-900">Total Pembayaran</dt>
                                    <dd class="text-base font-bold text-teak-700">Rp {{ number_format($total, 0, ',', '.') }}</dd>
                                </div>
                            </dl>
                        </div>

                        <div class="mt-8">
                            <a href="{{ route('checkout.index') }}" class="w-full btn-primary flex items-center justify-center gap-2 text-center rounded-sm text-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                Lanjut ke Checkout
                            </a>
                        </div>
                        
                        <div class="mt-6 text-center text-xs">
                            <p class="text-sand-500">
                                atau
                                <a href="{{ route('catalog.index') }}" class="font-semibold text-teak-700 hover:text-teak-600 transition">
                                    Lanjut Belanja<span aria-hidden="true"> &rarr;</span>
                                </a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="bg-white rounded-sm border border-sand-200/50 p-16 text-center shadow-xs">
                <div class="mx-auto h-20 w-20 text-sand-300 mb-6 bg-sand-50 rounded-full flex items-center justify-center border border-sand-100">
                    <svg class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
                <h2 class="text-2xl font-heading font-bold text-sand-900 mb-3">Keranjang belanja Anda kosong</h2>
                <p class="text-sm text-sand-500 mb-8 max-w-sm mx-auto leading-relaxed">Sepertinya Anda belum menambahkan produk apapun ke keranjang.</p>
                <a href="{{ route('catalog.index') }}" class="btn-primary inline-flex items-center gap-2 rounded-sm text-sm">
                    Mulai Belanja
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </a>
            </div>
        @endif
        
    </div>
</div>
@endsection
