<footer class="bg-sand-900 text-white">
    {{-- Main Footer --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-16 pb-12">
        <div class="grid grid-cols-1 md:grid-cols-12 gap-12">
            {{-- Brand Column --}}
            <div class="md:col-span-4">
                <div class="flex items-center gap-1.5 mb-5">
                    <span class="font-heading font-bold text-2xl text-white tracking-tight">Jati</span>
                    <span class="font-heading font-bold text-2xl text-teak-500 tracking-tight">Akbar</span>
                </div>
                <p class="text-sand-400 text-sm leading-relaxed mb-6 max-w-xs">
                    Pusat mebel dan furniture jati berkualitas tinggi dari Jepara. Melayani pemesanan reguler maupun custom sesuai keinginan Anda.
                </p>
                <div class="flex items-center gap-3">
                    <a href="https://wa.me/6281234567890" target="_blank" class="w-9 h-9 rounded-full bg-white/10 flex items-center justify-center hover:bg-forest-600 transition-all duration-300 group">
                        <svg class="w-4 h-4 text-sand-400 group-hover:text-white transition-colors" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51a12.8 12.8 0 00-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347"/></svg>
                    </a>
                    <a href="#" class="w-9 h-9 rounded-full bg-white/10 flex items-center justify-center hover:bg-teak-600 transition-all duration-300 group">
                        <svg class="w-4 h-4 text-sand-400 group-hover:text-white transition-colors" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>
                    </a>
                </div>
            </div>
            
            {{-- Quick Links --}}
            <div class="md:col-span-2">
                <h4 class="text-xs font-bold uppercase tracking-widest text-sand-300 mb-5">Navigasi</h4>
                <ul class="space-y-3 text-sm">
                    <li><a href="{{ route('home') }}" class="text-sand-400 hover:text-teak-500 transition-colors duration-300">Beranda</a></li>
                    <li><a href="{{ route('catalog.index') }}" class="text-sand-400 hover:text-teak-500 transition-colors duration-300">Katalog Produk</a></li>
                    <li><a href="#" class="text-sand-400 hover:text-teak-500 transition-colors duration-300">Custom Order</a></li>
                    <li><a href="{{ route('tracking.index') }}" class="text-sand-400 hover:text-teak-500 transition-colors duration-300">Lacak Pesanan</a></li>
                    <li><a href="{{ route('about') }}" class="text-sand-400 hover:text-teak-500 transition-colors duration-300">Tentang Kami</a></li>
                </ul>
            </div>

            {{-- Contact --}}
            <div class="md:col-span-3">
                <h4 class="text-xs font-bold uppercase tracking-widest text-sand-300 mb-5">Kontak</h4>
                <ul class="space-y-4 text-sm">
                    <li class="flex items-start gap-3">
                        <svg class="h-4 w-4 text-teak-600 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                        </svg>
                        <span class="text-sand-400">Jl. Contoh Alamat No. 123, Jepara, Jawa Tengah</span>
                    </li>
                    <li class="flex items-center gap-3">
                        <svg class="h-4 w-4 text-teak-600 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z" />
                        </svg>
                        <span class="text-sand-400">+62 812 3456 7890</span>
                    </li>
                    <li class="flex items-center gap-3">
                        <svg class="h-4 w-4 text-teak-600 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
                        </svg>
                        <span class="text-sand-400">info@jatiakbar.com</span>
                    </li>
                </ul>
            </div>

            {{-- Business Hours --}}
            <div class="md:col-span-3">
                <h4 class="text-xs font-bold uppercase tracking-widest text-sand-300 mb-5">Jam Operasional</h4>
                <ul class="space-y-3 text-sm text-sand-400">
                    <li class="flex justify-between">
                        <span>Senin — Jumat</span>
                        <span class="font-medium text-sand-300">08:00 — 17:00</span>
                    </li>
                    <li class="flex justify-between">
                        <span>Sabtu</span>
                        <span class="font-medium text-sand-300">08:00 — 15:00</span>
                    </li>
                    <li class="flex justify-between">
                        <span>Minggu</span>
                        <span class="font-medium text-red-400">Tutup</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    {{-- Bottom Bar --}}
    <div class="border-t border-white/10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-5 flex flex-col sm:flex-row items-center justify-between gap-3">
            <p class="text-xs text-sand-500">&copy; {{ date('Y') }} Jati Akbar Furniture. Hak cipta dilindungi.</p>
            <p class="text-xs text-sand-500">Handcrafted with ❤️ in Jepara, Indonesia</p>
        </div>
    </div>
</footer>
