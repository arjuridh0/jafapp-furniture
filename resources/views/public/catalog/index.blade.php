@extends('layouts.app')

@section('content')
<div class="bg-teak-50 min-h-screen py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="flex flex-col md:flex-row md:items-end justify-between mb-10 gap-4">
            <div>
                <h1 class="text-3xl font-heading font-bold text-sand-900 leading-tight">Katalog Produk</h1>
                <p class="mt-2 text-sm text-sand-500 font-body">Temukan mebel jati impian Anda di sini.</p>
            </div>
            
            <div class="w-full md:w-auto">
                <form action="{{ route('catalog.index') }}" method="GET" class="flex gap-2">
                    @if(request('kategori'))
                        <input type="hidden" name="kategori" value="{{ request('kategori') }}">
                    @endif
                    <div class="relative w-full md:w-64">
                        <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari produk..." class="input-premium pl-10 pr-4">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-4 w-4 text-sand-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                    </div>
                    <button type="submit" class="btn-primary py-2.5 px-6 rounded-sm text-sm">Cari</button>
                </form>
            </div>
        </div>

        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Sidebar / Filter Kategori -->
            <div class="w-full lg:w-1/4">
                <div class="bg-white rounded-sm p-6 border border-sand-200/50 shadow-xs sticky top-24">
                    <h3 class="font-heading font-semibold text-lg text-sand-900 mb-5 pb-2 border-b border-sand-100">Kategori</h3>
                    <ul class="space-y-1">
                        <li>
                            <a href="{{ route('catalog.index') }}" class="block px-4 py-2.5 rounded-sm transition duration-300 {{ !request('kategori') ? 'bg-teak-700 text-teak-50 font-medium' : 'text-sand-700 hover:bg-sand-100 hover:text-teak-900' }}">
                                Semua Produk
                            </a>
                        </li>
                        @foreach($categories as $category)
                        <li>
                            <a href="{{ route('catalog.index', ['kategori' => $category->slug]) }}" class="block px-4 py-2.5 rounded-sm flex justify-between items-center transition duration-300 {{ request('kategori') === $category->slug ? 'bg-teak-700 text-teak-50 font-medium' : 'text-sand-700 hover:bg-sand-100 hover:text-teak-900' }}">
                                <span>{{ $category->name }}</span>
                                <span class="py-0.5 px-2 rounded-full text-xs transition duration-300 {{ request('kategori') === $category->slug ? 'bg-teak-600 text-teak-50' : 'bg-sand-200/60 text-sand-700' }}">{{ $category->products()->count() }}</span>
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <!-- Product Grid -->
            <div class="w-full lg:w-3/4">
                @if(request('q') || request('kategori'))
                    <div class="mb-5 text-sm text-sand-500 flex items-center gap-1 font-body">
                        Menampilkan hasil untuk: 
                        @if(request('q')) <span class="font-semibold text-sand-900">"{{ request('q') }}"</span> @endif
                        @if(request('q') && request('kategori')) di kategori @endif
                        @if(request('kategori'))
                            @php $cat = $categories->firstWhere('slug', request('kategori')); @endphp
                            <span class="font-semibold text-sand-900">{{ $cat ? $cat->name : request('kategori') }}</span>
                        @endif
                        <a href="{{ route('catalog.index') }}" class="ml-2 text-red-500 hover:underline font-medium">(Hapus Filter)</a>
                    </div>
                @endif

                <div class="grid gap-6 grid-cols-1 sm:grid-cols-2 xl:grid-cols-3">
                    @forelse($products as $product)
                        <x-product-card :product="$product" />
                    @empty
                        <div class="col-span-full bg-white rounded-sm p-16 text-center border border-sand-200/50 shadow-xs">
                            <svg class="mx-auto h-12 w-12 text-sand-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <h3 class="mt-3 text-base font-semibold text-sand-950 font-heading">Tidak ada produk</h3>
                            <p class="mt-2 text-sm text-sand-500 font-body max-w-sm mx-auto leading-relaxed">
                                Maaf, kami tidak dapat menemukan produk yang sesuai dengan pencarian Anda.
                            </p>
                            <div class="mt-6">
                                <a href="{{ route('catalog.index') }}" class="btn-primary rounded-sm text-sm">
                                    Lihat Semua Produk
                                </a>
                            </div>
                        </div>
                    @endforelse
                </div>

                <!-- Pagination -->
                <div class="mt-12 font-body">
                    {{ $products->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
