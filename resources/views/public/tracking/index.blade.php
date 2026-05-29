@extends('layouts.app')

@section('content')
<div class="bg-teak-50 min-h-screen py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="text-center mb-10">
            <h1 class="text-3xl font-heading font-bold text-sand-900 leading-tight">Lacak Pesanan Anda</h1>
            <p class="mt-4 text-sm text-sand-500 font-body">Masukkan nomor pesanan untuk melihat status terkini dari pesanan Anda.</p>
        </div>

        <div class="bg-white rounded-sm border border-sand-200/50 shadow-xs p-6 md:p-8 mb-8">
            <form action="{{ route('tracking.show') }}" method="POST" class="flex flex-col sm:flex-row gap-4">
                @csrf
                <div class="flex-grow">
                    <label for="order_number" class="sr-only">Nomor Pesanan</label>
                    <input type="text" name="order_number" id="order_number" value="{{ request('order_number') }}" placeholder="Contoh: ORD-202605-0001" required class="input-premium py-3">
                </div>
                <button type="submit" class="btn-primary py-3 px-8 whitespace-nowrap rounded-sm">
                    Lacak Sekarang
                </button>
            </form>
            @error('order_number')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        @if(isset($order))
            <div class="bg-white rounded-sm border border-sand-200/60 overflow-hidden shadow-xs">
                <div class="border-b border-sand-200/60 bg-sand-50/50 p-6 flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div>
                        <h2 class="text-xl font-heading font-semibold text-sand-900">Pesanan: {{ $order->order_number }}</h2>
                        <p class="text-xs text-sand-500 mt-1 font-body">Tanggal Pesan: {{ $order->created_at->format('d F Y') }}</p>
                    </div>
                    <div>
                        <x-status-badge :status="$order->status" />
                    </div>
                </div>
                
                <div class="p-6 md:p-8">
                    <!-- Order Items -->
                    <div class="mb-8 border border-sand-200/40 rounded-sm p-4 bg-sand-50/30">
                        <h3 class="font-heading font-semibold text-sand-900 mb-4 border-b border-sand-200/60 pb-2">Detail Produk</h3>
                        <ul class="space-y-4">
                            @foreach($order->orderItems as $item)
                            <li class="flex items-start gap-4">
                                <div class="w-16 h-16 bg-sand-100 rounded-sm overflow-hidden flex-shrink-0 border border-sand-200/40">
                                    @if($item->product && is_array($item->product->images) && count($item->product->images) > 0 && $item->product->images[0] !== 'images/no-image.png')
                                        <img src="{{ asset('storage/' . $item->product->images[0]) }}" alt="{{ $item->product_name }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center bg-sand-100 text-sand-400 relative">
                                            <div class="absolute inset-2 border border-dashed border-sand-300/60 rounded-xs flex items-center justify-center">
                                                <span class="font-heading italic text-xs font-semibold text-sand-300">JAF</span>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                <div>
                                    <h4 class="font-heading font-semibold text-sand-900 text-sm">{{ $item->product_name ?? $item->product?->name ?? 'Produk' }}</h4>
                                    <p class="text-xs text-sand-500 mt-1 font-body">{{ $item->qty }} x Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                                </div>
                            </li>
                            @endforeach
                        </ul>
                    </div>

                    <h3 class="font-heading font-semibold text-sand-900 text-lg mb-6">Status Produksi & Pengiriman</h3>
                    
                    <x-production-stepper :currentStatus="$order->status" :productionLogs="$order->productionLogs" />
                    
                </div>
            </div>
        @endif

    </div>
</div>
@endsection
