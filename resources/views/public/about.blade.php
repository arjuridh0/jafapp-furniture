@extends('layouts.app')

@section('content')
<div class="bg-teak-50 min-h-screen py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="text-center mb-16">
            <h1 class="text-4xl font-heading font-extrabold text-sand-900 sm:text-5xl">Tentang Kami</h1>
            <p class="mt-4 max-w-2xl text-xl text-sand-500 mx-auto">Dedikasi kami untuk menghadirkan kualitas terbaik ke dalam rumah Anda.</p>
        </div>

        <div class="bg-white rounded-sm shadow-xs border border-sand-200 overflow-hidden mb-16">
            <div class="lg:grid lg:grid-cols-2">
                <div class="p-8 lg:p-12 flex flex-col justify-center">
                    <h2 class="text-3xl font-heading font-bold text-sand-900 mb-6">Cerita Jati Akbar</h2>
                    <div class="prose prose-lg text-sand-600">
                        <p class="mb-4">
                            Jati Akbar Furniture berawal dari kecintaan terhadap keindahan dan ketahanan kayu jati. Terletak di jantung kota Jepara, pusat ukiran dan mebel Indonesia, kami mewarisi tradisi pengerjaan kayu yang telah diturunkan dari generasi ke generasi.
                        </p>
                        <p class="mb-4">
                            Kami percaya bahwa setiap potong kayu memiliki cerita, dan tugas kami adalah menceritakannya melalui mebel yang indah, fungsional, dan tahan lama. Setiap produk yang keluar dari workshop kami dikerjakan dengan ketelitian tingkat tinggi oleh pengrajin berpengalaman.
                        </p>
                        <p>
                            Visi kami adalah menjadi pilihan utama keluarga Indonesia dalam mengisi dan memperindah ruang hunian mereka dengan produk berkualitas yang dapat diwariskan.
                        </p>
                    </div>
                </div>
                <div class="bg-sand-200 flex items-center justify-center min-h-[300px] lg:min-h-full">
                    <div class="text-teak-700 opacity-50 flex flex-col items-center justify-center w-full h-full p-12">
                        <div class="border border-dashed border-teak-700/20 w-full h-full min-h-[250px] flex flex-col items-center justify-center rounded-sm">
                            <span class="font-heading italic text-4xl font-semibold text-teak-800/20 tracking-wider">JAF</span>
                            <span class="text-xs uppercase tracking-widest text-teak-800/40 mt-2 font-semibold font-body">Workshop & Showroom</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-16">
            <div class="bg-white p-8 rounded-sm shadow-xs border border-sand-200">
                <h3 class="text-2xl font-heading font-bold text-sand-900 mb-6 flex items-center gap-2">
                    <svg class="w-6 h-6 text-teak-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    Lokasi Kami
                </h3>
                <p class="text-sand-600 mb-6">
                    Kunjungi workshop dan showroom kami untuk melihat langsung proses produksi dan kualitas mebel kami.
                </p>
                <address class="not-italic text-sand-800 space-y-2 mb-6 border-l-4 border-teak-700 pl-4">
                    <strong>Jati Akbar Furniture</strong><br>
                    Jl. Contoh Alamat No. 123<br>
                    Kecamatan Tahunan, Kabupaten Jepara<br>
                    Jawa Tengah, Indonesia 59427
                </address>

                <div class="w-full h-64 bg-sand-100 rounded-sm overflow-hidden flex items-center justify-center border border-sand-200">
                    <!-- TEMPAT_MAPS -->
                    <span class="text-sand-400 font-medium text-sm">Google Maps akan tampil di sini</span>
                    <!-- Akhir TEMPAT_MAPS -->
                </div>
            </div>
            
            <div class="bg-white p-8 rounded-sm shadow-xs border border-sand-200">
                <h3 class="text-2xl font-heading font-bold text-sand-900 mb-6 flex items-center gap-2">
                    <svg class="w-6 h-6 text-teak-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    Hubungi Kami
                </h3>
                <p class="text-sand-600 mb-8">
                    Punya pertanyaan tentang produk kami? Atau ingin konsultasi untuk custom mebel? Jangan ragu untuk menghubungi kami.
                </p>
                
                <div class="space-y-6">
                    <a href="https://wa.me/6281234567890" target="_blank" class="flex items-center gap-4 p-4 rounded-sm border border-sand-200 hover:border-forest-600 hover:shadow-xs transition group">
                        <div class="bg-forest-600/10 p-3 rounded-full group-hover:bg-forest-600 transition">
                            <svg class="w-6 h-6 text-forest-600 group-hover:text-white transition" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51a12.8 12.8 0 00-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/></svg>
                        </div>
                        <div>
                            <h4 class="font-bold text-sand-900">WhatsApp</h4>
                            <p class="text-sm text-sand-500">+62 812 3456 7890</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        
        <div class="mb-16">
            <div class="text-center mb-10">
                <h2 class="text-3xl font-heading font-bold text-sand-900">Portofolio Kami</h2>
                <p class="mt-4 text-sand-600">Beberapa hasil karya mebel jati custom yang telah kami produksi untuk pelanggan kami.</p>
            </div>
            
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                @for ($i = 1; $i <= 8; $i++)
                <div class="aspect-w-1 aspect-h-1 rounded-sm overflow-hidden bg-sand-100 group relative">
                    <div class="w-full h-full min-h-[200px] flex items-center justify-center bg-sand-200 text-sand-400 group-hover:scale-110 transition-transform duration-500">
                        <div class="text-center">
                            <span class="font-heading italic text-2xl font-semibold text-sand-300 tracking-wider">JAF</span>
                            <span class="block text-[10px] uppercase tracking-widest text-sand-400 mt-1">Portofolio #{{ $i }}</span>
                        </div>
                    </div>
                    <div class="absolute inset-0 bg-black/0 group-hover:bg-black/40 transition-all duration-300 flex items-end">
                        <div class="p-4 opacity-0 group-hover:opacity-100 transition-opacity duration-300 w-full text-white">
                            <p class="text-sm font-semibold truncate">Proyek Custom #{{ $i }}</p>
                        </div>
                    </div>
                </div>
                @endfor
            </div>
        </div>
        
    </div>
</div>
@endsection
