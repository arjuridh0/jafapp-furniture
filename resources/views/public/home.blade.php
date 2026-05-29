@extends('layouts.app')

@section('content')
{{-- ═══════════════════════════════════════════════════════════
    HERO SECTION — Full-width dramatic hero with gradient overlay
═══════════════════════════════════════════════════════════ --}}
<section class="relative min-h-[85vh] flex items-center overflow-hidden bg-sand-900">
    {{-- Gradient Overlay --}}
    <div class="absolute inset-0 bg-gradient-to-r from-sand-900/95 via-sand-900/70 to-sand-900/30 z-10"></div>
    
    {{-- Background Pattern (wood grain texture via CSS) --}}
    <div class="absolute inset-0 opacity-[0.04]" style="background-image: url('data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 width=%22100%22 height=%22100%22><defs><pattern id=%22p%22 width=%2220%22 height=%2220%22 patternUnits=%22userSpaceOnUse%22><path d=%22M0 10 Q5 8 10 10 Q15 12 20 10%22 fill=%22none%22 stroke=%22white%22 stroke-width=%220.5%22/></pattern></defs><rect width=%22100%22 height=%22100%22 fill=%22url(%23p)%22/></svg>'); background-size: 200px 200px;"></div>

    {{-- Decorative Elements --}}
    <div class="absolute top-20 right-[10%] w-72 h-72 rounded-full bg-teak-700/10 blur-3xl z-0"></div>
    <div class="absolute bottom-10 right-[30%] w-96 h-96 rounded-full bg-teak-600/5 blur-3xl z-0"></div>

    <div class="relative z-20 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full py-20">
        <div class="max-w-2xl">
            {{-- Badge --}}
            <div class="hero-badge-animate inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-teak-700/20 border border-teak-600/30 backdrop-blur-sm mb-8">
                <span class="w-2 h-2 rounded-full bg-teak-500 animate-pulse"></span>
                <span class="text-xs font-semibold text-teak-200 uppercase tracking-widest">Handcrafted in Jepara</span>
            </div>
            
            {{-- Heading --}}
            <h1 class="hero-title-animate text-5xl sm:text-6xl lg:text-7xl font-heading font-bold text-white leading-[1.1] tracking-tight text-wrap-balance">
                Karya Tangan
                <span class="block text-teak-500">Bermakna Abadi</span>
            </h1>
            
            <p class="hero-text-animate mt-6 text-lg sm:text-xl text-sand-300 max-w-lg leading-relaxed font-body text-wrap-pretty">
                Setiap mebel jati dari Jati Akbar adalah perpaduan tradisi pengrajin Jepara dan desain modern — dibuat untuk menjadi warisan keluarga Anda.
            </p>
            
            {{-- CTA Buttons --}}
            <div class="hero-cta-animate mt-10 flex flex-wrap gap-4">
                <a href="{{ route('catalog.index') }}" class="group inline-flex items-center gap-3 bg-teak-700 hover:bg-teak-600 text-white font-semibold py-4 px-8 rounded-sm transition-all duration-300 ease-teak-smooth hover:shadow-lg hover:shadow-teak-900/20 hover:-translate-y-0.5 active:translate-y-0">
                    Jelajahi Katalog
                    <svg class="w-4 h-4 transition-transform duration-300 group-hover:translate-x-1" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                </a>
                <a href="{{ route('about') }}" class="inline-flex items-center gap-2 border border-sand-400/30 text-sand-200 hover:text-white hover:border-sand-300/60 font-semibold py-4 px-8 rounded-sm transition-all duration-300 ease-teak-smooth hover:bg-white/5 backdrop-blur-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/><path stroke-linecap="round" stroke-linejoin="round" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    Cerita Kami
                </a>
            </div>

            {{-- Trust Indicators --}}
            <div class="hero-trust-animate mt-14 flex flex-wrap gap-8 items-center">
                <div class="flex items-center gap-2">
                    <div class="w-10 h-10 rounded-full bg-teak-700/20 flex items-center justify-center">
                        <svg class="w-5 h-5 text-teak-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-white">Jati Perhutani</p>
                        <p class="text-xs text-sand-400">100% Legal & Bersertifikat</p>
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    <div class="w-10 h-10 rounded-full bg-teak-700/20 flex items-center justify-center">
                        <svg class="w-5 h-5 text-teak-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-white">Garansi 5 Tahun</p>
                        <p class="text-xs text-sand-400">Konstruksi & Finishing</p>
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    <div class="w-10 h-10 rounded-full bg-teak-700/20 flex items-center justify-center">
                        <svg class="w-5 h-5 text-teak-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-white">Bayar Fleksibel</p>
                        <p class="text-xs text-sand-400">Transfer & E-Wallet</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Bottom gradient fade to next section --}}
    <div class="absolute bottom-0 left-0 right-0 h-24 bg-gradient-to-t from-teak-50 to-transparent z-20"></div>
</section>

{{-- ═══════════════════════════════════════════════════════════
    FEATURED PRODUCTS — With premium section design
═══════════════════════════════════════════════════════════ --}}
<section class="py-24 bg-teak-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-4 mb-14">
            <div>
                <span class="inline-block text-xs font-bold text-teak-600 uppercase tracking-widest mb-3">Koleksi Pilihan</span>
                <h2 class="text-4xl font-bold text-sand-900 font-heading tracking-tight text-wrap-balance">Produk Terlaris Kami</h2>
                <p class="mt-3 text-sand-500 font-body max-w-lg text-wrap-pretty">Mebel-mebel yang paling dicari oleh pelanggan kami — setiap produk dikerjakan dengan standar tertinggi.</p>
            </div>
            <a href="{{ route('catalog.index') }}" class="group inline-flex items-center gap-2 text-sm font-semibold text-teak-700 hover:text-teak-600 transition-colors duration-300 whitespace-nowrap">
                Lihat Semua
                <svg class="w-4 h-4 transition-transform duration-300 group-hover:translate-x-1" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
            </a>
        </div>

        <div class="grid gap-8 grid-cols-1 sm:grid-cols-2 lg:grid-cols-3">
            @forelse($featuredProducts as $product)
                <x-product-card :product="$product" />
            @empty
                <div class="col-span-full text-center py-16">
                    <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-sand-200 flex items-center justify-center">
                        <svg class="w-8 h-8 text-sand-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                    </div>
                    <p class="text-sand-500 font-body">Belum ada produk yang tersedia.</p>
                </div>
            @endforelse
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════════════
    WHY US — Value Propositions
═══════════════════════════════════════════════════════════ --}}
<section class="py-24 bg-white border-t border-sand-200/50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-2xl mx-auto mb-16">
            <span class="inline-block text-xs font-bold text-teak-600 uppercase tracking-widest mb-3">Kenapa Kami</span>
            <h2 class="text-4xl font-heading font-bold text-sand-900 tracking-tight text-wrap-balance">Dibuat Berbeda, Bertahan Selamanya</h2>
        </div>
        <div class="grid gap-8 md:grid-cols-3">
            <div class="group text-center p-8 rounded-sm border border-sand-200/50 bg-sand-50/50 hover:bg-white hover:shadow-[0_12px_40px_-8px_rgba(61,31,22,0.08)] hover:border-teak-700/20 transition-all duration-500 ease-teak-smooth">
                <div class="w-14 h-14 mx-auto mb-5 rounded-full bg-teak-100 flex items-center justify-center group-hover:bg-teak-700 transition-colors duration-500">
                    <svg class="w-6 h-6 text-teak-700 group-hover:text-white transition-colors duration-500" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09zM18.259 8.715L18 9.75l-.259-1.035a3.375 3.375 0 00-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 002.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 002.455 2.456L21.75 6l-1.036.259a3.375 3.375 0 00-2.455 2.456z"/></svg>
                </div>
                <h3 class="text-lg font-heading font-bold text-sand-900 mb-2">100% Handcrafted</h3>
                <p class="text-sm text-sand-500 font-body leading-relaxed">Setiap sambungan, ukiran, dan finishing dikerjakan tangan oleh pengrajin berpengalaman lebih dari 20 tahun.</p>
            </div>
            <div class="group text-center p-8 rounded-sm border border-sand-200/50 bg-sand-50/50 hover:bg-white hover:shadow-[0_12px_40px_-8px_rgba(61,31,22,0.08)] hover:border-teak-700/20 transition-all duration-500 ease-teak-smooth">
                <div class="w-14 h-14 mx-auto mb-5 rounded-full bg-teak-100 flex items-center justify-center group-hover:bg-teak-700 transition-colors duration-500">
                    <svg class="w-6 h-6 text-teak-700 group-hover:text-white transition-colors duration-500" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z"/></svg>
                </div>
                <h3 class="text-lg font-heading font-bold text-sand-900 mb-2">Custom Sesuai Impian</h3>
                <p class="text-sm text-sand-500 font-body leading-relaxed">Konsultasikan desain impian Anda — kami wujudkan dengan ukuran, bahan, dan finishing yang tepat.</p>
            </div>
            <div class="group text-center p-8 rounded-sm border border-sand-200/50 bg-sand-50/50 hover:bg-white hover:shadow-[0_12px_40px_-8px_rgba(61,31,22,0.08)] hover:border-teak-700/20 transition-all duration-500 ease-teak-smooth">
                <div class="w-14 h-14 mx-auto mb-5 rounded-full bg-teak-100 flex items-center justify-center group-hover:bg-teak-700 transition-colors duration-500">
                    <svg class="w-6 h-6 text-teak-700 group-hover:text-white transition-colors duration-500" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 01-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 00-3.213-9.193 2.056 2.056 0 00-1.58-.86H14.25M16.5 18.75h-2.25m0-11.177v-.958c0-.568-.422-1.048-.987-1.106a48.554 48.554 0 00-10.026 0 1.106 1.106 0 00-.987 1.106v7.635m12-6.677v6.677m0 4.5v-4.5m0 0h-12"/></svg>
                </div>
                <h3 class="text-lg font-heading font-bold text-sand-900 mb-2">Pengiriman Aman</h3>
                <p class="text-sm text-sand-500 font-body leading-relaxed">Packing kayu khusus dan asuransi pengiriman ke seluruh Indonesia, mebel sampai tanpa cacat.</p>
            </div>
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════════════
    CTA BANNER — Closing CTA
═══════════════════════════════════════════════════════════ --}}
<section class="relative py-20 bg-sand-900 overflow-hidden">
    <div class="absolute inset-0 opacity-[0.03]" style="background-image: url('data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 width=%22100%22 height=%22100%22><defs><pattern id=%22p%22 width=%2220%22 height=%2220%22 patternUnits=%22userSpaceOnUse%22><path d=%22M0 10 Q5 8 10 10 Q15 12 20 10%22 fill=%22none%22 stroke=%22white%22 stroke-width=%220.5%22/></pattern></defs><rect width=%22100%22 height=%22100%22 fill=%22url(%23p)%22/></svg>'); background-size: 200px 200px;"></div>
    <div class="absolute top-0 left-1/4 w-96 h-96 rounded-full bg-teak-700/10 blur-3xl"></div>
    
    <div class="relative max-w-4xl mx-auto px-4 text-center">
        <h2 class="text-3xl sm:text-4xl font-heading font-bold text-white tracking-tight text-wrap-balance">Punya Desain Mebel Impian?</h2>
        <p class="mt-4 text-lg text-sand-300 max-w-2xl mx-auto text-wrap-pretty">Kirimkan gambar, ukuran, dan deskripsi mebel yang Anda inginkan — tim kami akan menghubungi Anda dalam 24 jam.</p>
        <div class="mt-8 flex flex-wrap justify-center gap-4">
            <a href="https://wa.me/6281234567890" target="_blank" class="group inline-flex items-center gap-3 bg-forest-700 hover:bg-forest-600 text-white font-semibold py-4 px-8 rounded-sm transition-all duration-300 hover:shadow-lg hover:-translate-y-0.5">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51a12.8 12.8 0 00-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347"/></svg>
                Konsultasi via WhatsApp
            </a>
            <a href="{{ route('catalog.index') }}" class="inline-flex items-center gap-2 border border-sand-400/30 text-sand-200 hover:text-white hover:border-sand-300/60 font-semibold py-4 px-8 rounded-sm transition-all duration-300 hover:bg-white/5">
                Lihat Katalog
            </a>
        </div>
    </div>
</section>
@endsection
