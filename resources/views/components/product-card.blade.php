@props(['product'])

<div class="card-animate group flex flex-col h-full bg-white border border-sand-200/40 rounded-sm overflow-hidden relative hover:shadow-[0_20px_50px_-12px_rgba(61,31,22,0.1)] transition-all duration-500 ease-teak-smooth">
    {{-- Image Container --}}
    <div class="relative w-full h-56 sm:h-64 bg-sand-100 overflow-hidden">
        @if(is_array($product->images) && count($product->images) > 0 && $product->images[0] !== 'images/no-image.png')
            <img src="{{ asset('storage/' . $product->images[0]) }}" 
                 alt="{{ $product->name }}" 
                 style="view-transition-name: product-image-{{ $product->id }};"
                 class="w-full h-full object-cover transition-transform duration-700 ease-teak-smooth group-hover:scale-110">
        @else
            {{-- Premium Monogram Placeholder --}}
            <div class="w-full h-full flex flex-col items-center justify-center bg-gradient-to-br from-sand-100 to-sand-200 text-sand-400 relative">
                <div class="absolute inset-4 border border-dashed border-sand-300/60 rounded-sm flex items-center justify-center">
                    <div class="text-center">
                        <span class="font-heading italic text-3xl font-semibold text-sand-300 tracking-wider">JAF</span>
                        <span class="block text-[10px] uppercase tracking-widest text-sand-400 mt-1 font-semibold">Handcrafted Teak</span>
                    </div>
                </div>
            </div>
        @endif
        
        {{-- Glassmorphism Category Badge --}}
        <div class="absolute top-3 left-3 z-10">
            <span class="inline-flex items-center px-2.5 py-1 rounded-sm text-[10px] uppercase tracking-wider font-bold bg-white/80 backdrop-blur-md text-sand-800 border border-white/50 shadow-sm">
                {{ $product->category->name ?? 'Uncategorized' }}
            </span>
        </div>

        {{-- Quick Action Overlay --}}
        <div class="absolute inset-0 bg-gradient-to-t from-sand-900/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500 flex items-end justify-center pb-4">
            <a href="{{ route('catalog.show', $product->slug) }}" 
               class="inline-flex items-center gap-2 bg-white/90 backdrop-blur-sm text-sand-900 text-xs font-semibold px-5 py-2.5 rounded-sm translate-y-4 group-hover:translate-y-0 transition-all duration-500 ease-teak-smooth hover:bg-white shadow-md">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                Lihat Detail
            </a>
        </div>
    </div>
    
    {{-- Content --}}
    <div class="p-5 flex flex-col flex-grow">
        <h3 class="text-base font-heading font-semibold text-sand-900 mb-1 line-clamp-2 group-hover:text-teak-700 transition-colors duration-300">
            <a href="{{ route('catalog.show', $product->slug) }}" 
               style="view-transition-name: product-title-{{ $product->id }};"
               class="block">
                {{ $product->name }}
            </a>
        </h3>
        
        <p class="text-lg font-bold text-teak-700 mb-4 font-body">
            Rp {{ number_format($product->price, 0, ',', '.') }}
        </p>
        
        {{-- Add to Cart --}}
        <div class="mt-auto">
            <form action="{{ route('cart.add') }}" method="POST">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <input type="hidden" name="qty" value="1">
                <button type="submit" class="w-full group/btn bg-sand-900 hover:bg-teak-700 text-white py-3 text-xs font-semibold flex justify-center items-center gap-2 rounded-sm transition-all duration-300 ease-teak-smooth hover:shadow-md cursor-pointer">
                    <svg class="w-4 h-4 transition-transform duration-300 group-hover/btn:-translate-y-0.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                    Tambah ke Keranjang
                </button>
            </form>
        </div>
    </div>
</div>
