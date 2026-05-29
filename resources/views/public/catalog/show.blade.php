@extends('layouts.app')

@section('content')
<div class="bg-teak-50 min-h-screen py-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Breadcrumb -->
        <nav class="flex mb-8 text-sm font-body" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="{{ route('home') }}" class="text-sand-500 hover:text-teak-700 transition">
                        Beranda
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="w-4 h-4 text-sand-300" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <a href="{{ route('catalog.index') }}" class="ml-1 md:ml-2 text-sand-500 hover:text-teak-700 transition">
                            Katalog
                        </a>
                    </div>
                </li>
                @if($product->category)
                <li>
                    <div class="flex items-center">
                        <svg class="w-4 h-4 text-sand-300" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <a href="{{ route('catalog.index', ['kategori' => $product->category->slug]) }}" class="ml-1 md:ml-2 text-sand-500 hover:text-teak-700 transition">
                            {{ $product->category->name }}
                        </a>
                    </div>
                </li>
                @endif
                <li aria-current="page">
                    <div class="flex items-center">
                        <svg class="w-4 h-4 text-sand-300" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="ml-1 md:ml-2 text-sand-400 truncate w-32 md:w-auto font-medium">{{ $product->name }}</span>
                    </div>
                </li>
            </ol>
        </nav>

        <div class="bg-white rounded-sm shadow-xs border border-sand-200/60 overflow-hidden">
            <div class="lg:grid lg:grid-cols-2 lg:gap-x-8">
                <!-- Product Image Gallery -->
                <div class="p-6 lg:p-8" x-data="{ activeImage: 0, images: {{ json_encode(is_array($product->images) && count($product->images) > 0 && $product->images[0] !== 'images/no-image.png' ? collect($product->images)->map(fn($img) => asset('storage/'.$img))->toArray() : []) }} }">
                    
                    <div class="aspect-w-4 aspect-h-3 rounded-sm overflow-hidden bg-sand-100 flex items-center justify-center relative">
                        <template x-if="images.length > 0">
                            <img :src="images[activeImage]" 
                                 alt="{{ $product->name }}" 
                                 style="view-transition-name: product-image-{{ $product->id }};"
                                 class="object-cover w-full h-full transition-all duration-500">
                        </template>
                        <template x-if="images.length === 0">
                            <!-- Premium Monogram Placeholder for Show page -->
                            <div class="w-full h-96 flex flex-col items-center justify-center bg-sand-100 text-sand-400 relative">
                                <div class="absolute inset-6 border border-dashed border-sand-300/60 rounded-xs flex items-center justify-center">
                                    <div class="text-center">
                                        <span class="font-heading italic text-5xl font-semibold text-sand-300 tracking-wider">JAF</span>
                                        <span class="block text-xs uppercase tracking-widest text-sand-400 mt-2 font-semibold font-body">Handcrafted Teak Furniture</span>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>
                    
                    <!-- Thumbnails -->
                    <template x-if="images.length > 1">
                        <div class="mt-4 grid grid-cols-4 gap-4">
                            <template x-for="(img, index) in images" :key="index">
                                <button @click="activeImage = index" :class="{'ring-2 ring-teak-700 ring-offset-2': activeImage === index}" class="relative h-24 bg-white rounded-sm flex items-center justify-center text-sm font-medium uppercase text-sand-900 cursor-pointer hover:bg-sand-50 focus:outline-none transition">
                                    <span class="absolute inset-0 rounded-sm overflow-hidden">
                                        <img :src="img" alt="" class="w-full h-full object-center object-cover">
                                    </span>
                                </button>
                            </template>
                        </div>
                    </template>
                </div>

                <!-- Product Info -->
                <div class="p-6 lg:p-8 lg:border-l border-sand-200/60 bg-sand-50/50">
                    <div class="mb-3">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-xs text-[10px] uppercase tracking-wider font-semibold bg-teak-100 text-teak-800">
                            {{ $product->category->name ?? 'Uncategorized' }}
                        </span>
                    </div>
                    
                    <h1 style="view-transition-name: product-title-{{ $product->id }};" class="text-3xl font-heading font-bold text-sand-900 tracking-tight sm:text-4xl mb-4 text-wrap-balance">
                        {{ $product->name }}
                    </h1>
                    
                    <p class="text-3xl font-bold text-teak-700 mb-6 font-body">
                        Rp {{ number_format($product->price, 0, ',', '.') }}
                    </p>
                    
                    <div class="prose prose-sm text-sand-600 mb-6 max-w-none font-body leading-relaxed text-wrap-pretty">
                        {!! nl2br(e($product->description)) !!}
                    </div>
                    
                    <div class="mb-8 p-5 bg-white rounded-sm border border-sand-200/50">
                        <h3 class="text-sm font-semibold text-sand-900 mb-3 font-heading">Spesifikasi & Dimensi</h3>
                        <ul class="text-xs text-sand-600 space-y-2 font-body">
                            <li><span class="font-semibold text-sand-800">Material:</span> Kayu Jati Perhutani (TPK)</li>
                            <li><span class="font-semibold text-sand-800">Finishing:</span> Natural Melamine (Customizable)</li>
                            <li><span class="font-semibold text-sand-800">Dimensi (P x L x T):</span> Hubungi admin untuk detail ukuran presisi atau custom ukuran.</li>
                        </ul>
                    </div>
                    
                    <div class="border-t border-sand-200/60 pt-6">
                        <form action="{{ route('cart.add') }}" method="POST" x-data="{ qty: 1 }">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            
                            <div class="flex items-center gap-4 mb-6">
                                <label for="qty" class="text-sm font-semibold text-sand-700 font-body">Jumlah</label>
                                <div class="flex items-center border border-sand-300 rounded-sm bg-white overflow-hidden">
                                    <button type="button" @click="if(qty > 1) qty--" class="px-4 py-2 text-sand-600 hover:bg-sand-100 transition-colors font-semibold select-none">-</button>
                                    <input type="number" name="qty" id="qty" x-model="qty" min="1" class="w-12 text-center border-0 focus:ring-0 p-2 text-sm font-semibold text-sand-800">
                                    <button type="button" @click="qty++" class="px-4 py-2 text-sand-600 hover:bg-sand-100 transition-colors font-semibold select-none">+</button>
                                </div>
                            </div>
                            
                            <div class="flex flex-col sm:flex-row gap-4 font-body">
                                <button type="submit" class="flex-grow btn-primary text-sm flex justify-center items-center gap-2 py-3.5 rounded-sm">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                    </svg>
                                    Tambah ke Keranjang
                                </button>
                                
                                <a href="https://wa.me/6281234567890?text=Halo%20Jati%20Akbar%20Furniture,%20saya%20tertarik%20dengan%20produk%20{{ urlencode($product->name) }}%20(Rp{{ number_format($product->price, 0, ',', '.') }})." 
                                   target="_blank" 
                                   class="sm:w-auto flex justify-center items-center px-6 py-3.5 border border-forest-700/60 text-forest-700 bg-transparent hover:bg-forest-700 hover:text-teak-50 font-semibold rounded-sm transition-all duration-300 ease-teak-smooth text-sm gap-2 shadow-xs">
                                    <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24">
                                        <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946C.06 5.348 5.397.01 12.008.01c3.202.001 6.212 1.246 8.477 3.514 2.266 2.268 3.507 5.28 3.505 8.484-.004 6.657-5.34 11.997-11.953 11.997-2.005-.001-3.973-.5-5.729-1.455L0 24zm6.305-1.654l.361.214a9.955 9.955 0 0 0 5.03 1.378h.004c5.985 0 10.856-4.87 10.86-10.86 0-2.898-1.129-5.622-3.18-7.673a10.902 10.902 0 0 0-7.683-3.181C5.908.2 1.037 5.07 1.033 11.06c-.001 2.051.536 4.053 1.554 5.824l.235.408-1.025 3.738 3.827-.998.373.214zM16.797 13.79c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51a12.8 12.8 0 0 0-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347"/>
                                    </svg>
                                    Tanya Admin (WhatsApp)
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Related Products -->
        @if($relatedProducts->count() > 0)
        <div class="mt-20">
            <h2 class="text-2xl font-heading font-bold text-sand-900 mb-8 text-wrap-balance">Produk Terkait</h2>
            <div class="grid gap-6 grid-cols-1 sm:grid-cols-2 lg:grid-cols-4">
                @foreach($relatedProducts as $related)
                    <x-product-card :product="$related" />
                @endforeach
            </div>
        </div>
        @endif
        
    </div>
</div>
@endsection
