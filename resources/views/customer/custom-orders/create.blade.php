@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto px-4 py-12">
    <div class="mb-8">
        <span class="inline-block text-xs font-bold text-teak-600 uppercase tracking-widest mb-2">Custom Order</span>
        <h1 class="text-3xl font-heading font-bold text-sand-900 tracking-tight">Buat Pesanan Custom</h1>
        <p class="mt-2 text-sand-500 text-sm">Jelaskan mebel impian Anda — tim kami akan meninjau dan menghubungi Anda dalam 1-2 hari kerja.</p>
    </div>

    <form method="POST" action="{{ route('custom-order.store') }}" enctype="multipart/form-data"
          x-data="{ loading: false, previews: [] }" @submit="loading = true"
          class="space-y-6">
        @csrf

        <div class="bg-white border border-sand-200/50 rounded-sm p-6 space-y-5">
            @guest
            <div class="border-b border-sand-200 pb-5 mb-5 space-y-5">
                <h2 class="text-lg font-bold text-sand-900">Data Pemesan</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label for="name" class="block text-sm font-medium text-sand-800 mb-1.5">Nama Lengkap <span class="text-red-500">*</span></label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}" required
                            class="w-full rounded-sm border border-sand-200 focus:border-teak-600 focus:ring-2 focus:ring-teak-600/10 px-4 py-3 text-sm bg-white transition-colors">
                        @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="email" class="block text-sm font-medium text-sand-800 mb-1.5">Email <span class="text-red-500">*</span></label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required
                            class="w-full rounded-sm border border-sand-200 focus:border-teak-600 focus:ring-2 focus:ring-teak-600/10 px-4 py-3 text-sm bg-white transition-colors">
                        @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="phone" class="block text-sm font-medium text-sand-800 mb-1.5">No. WhatsApp <span class="text-red-500">*</span></label>
                        <input type="tel" id="phone" name="phone" value="{{ old('phone') }}" required
                            class="w-full rounded-sm border border-sand-200 focus:border-teak-600 focus:ring-2 focus:ring-teak-600/10 px-4 py-3 text-sm bg-white transition-colors">
                        @error('phone') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div class="sm:col-span-2">
                        <label for="address" class="block text-sm font-medium text-sand-800 mb-1.5">Alamat Lengkap <span class="text-red-500">*</span></label>
                        <textarea id="address" name="address" rows="2" required
                            class="w-full rounded-sm border border-sand-200 focus:border-teak-600 focus:ring-2 focus:ring-teak-600/10 px-4 py-3 text-sm bg-white transition-colors">{{ old('address') }}</textarea>
                        @error('address') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>
            @endguest

            <h2 class="text-lg font-bold text-sand-900 mb-4">Detail Pesanan</h2>

            {{-- Deskripsi --}}
            <div>
                <label for="description" class="block text-sm font-medium text-sand-800 mb-1.5">Deskripsi Mebel <span class="text-red-500">*</span></label>
                <textarea id="description" name="description" rows="5" required minlength="20"
                    class="w-full rounded-sm border border-sand-200 focus:border-teak-600 focus:ring-2 focus:ring-teak-600/10 px-4 py-3 text-sm bg-white transition-colors"
                    placeholder="Jelaskan detail mebel yang Anda inginkan: jenis (kursi, meja, lemari), gaya desain, jumlah, dll.">{{ old('description') }}</textarea>
                @error('description') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Dimensi --}}
            <div>
                <label for="dimensions" class="block text-sm font-medium text-sand-800 mb-1.5">Ukuran / Dimensi <span class="text-red-500">*</span></label>
                <input type="text" id="dimensions" name="dimensions" value="{{ old('dimensions') }}" required
                    class="w-full rounded-sm border border-sand-200 focus:border-teak-600 focus:ring-2 focus:ring-teak-600/10 px-4 py-3 text-sm bg-white transition-colors"
                    placeholder="Contoh: Panjang 200cm x Lebar 100cm x Tinggi 75cm">
                @error('dimensions') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                {{-- Material --}}
                <div>
                    <label for="material" class="block text-sm font-medium text-sand-800 mb-1.5">Jenis Kayu <span class="text-red-500">*</span></label>
                    <select id="material" name="material" required
                        class="w-full rounded-sm border border-sand-200 focus:border-teak-600 focus:ring-2 focus:ring-teak-600/10 px-4 py-3 text-sm bg-white transition-colors">
                        <option value="">Pilih jenis kayu...</option>
                        <option value="jati" {{ old('material') === 'jati' ? 'selected' : '' }}>Jati (Teak)</option>
                        <option value="mahoni" {{ old('material') === 'mahoni' ? 'selected' : '' }}>Mahoni</option>
                        <option value="merbau" {{ old('material') === 'merbau' ? 'selected' : '' }}>Merbau</option>
                        <option value="trembesi" {{ old('material') === 'trembesi' ? 'selected' : '' }}>Trembesi</option>
                        <option value="sonokeling" {{ old('material') === 'sonokeling' ? 'selected' : '' }}>Sonokeling</option>
                    </select>
                    @error('material') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Finishing --}}
                <div>
                    <label for="finishing" class="block text-sm font-medium text-sand-800 mb-1.5">Finishing <span class="text-red-500">*</span></label>
                    <select id="finishing" name="finishing" required
                        class="w-full rounded-sm border border-sand-200 focus:border-teak-600 focus:ring-2 focus:ring-teak-600/10 px-4 py-3 text-sm bg-white transition-colors">
                        <option value="">Pilih finishing...</option>
                        <option value="natural" {{ old('finishing') === 'natural' ? 'selected' : '' }}>Natural</option>
                        <option value="glossy" {{ old('finishing') === 'glossy' ? 'selected' : '' }}>Glossy</option>
                        <option value="doff" {{ old('finishing') === 'doff' ? 'selected' : '' }}>Doff (Matte)</option>
                        <option value="rustic" {{ old('finishing') === 'rustic' ? 'selected' : '' }}>Rustic</option>
                        <option value="whitewash" {{ old('finishing') === 'whitewash' ? 'selected' : '' }}>Whitewash</option>
                    </select>
                    @error('finishing') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            {{-- Warna --}}
            <div>
                <label for="color" class="block text-sm font-medium text-sand-800 mb-1.5">Warna <span class="text-sand-400 text-xs">(opsional)</span></label>
                <input type="text" id="color" name="color" value="{{ old('color') }}"
                    class="w-full rounded-sm border border-sand-200 focus:border-teak-600 focus:ring-2 focus:ring-teak-600/10 px-4 py-3 text-sm bg-white transition-colors"
                    placeholder="Contoh: Coklat tua, Natural, Walnut, dll.">
                @error('color') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Image Upload --}}
            <div>
                <label class="block text-sm font-medium text-sand-800 mb-1.5">Gambar Referensi <span class="text-sand-400 text-xs">(maks. 3 gambar, 2MB/gambar)</span></label>
                <input type="file" name="ref_images[]" multiple accept="image/jpeg,image/png,image/webp"
                    class="w-full text-sm text-sand-600 file:mr-4 file:py-2 file:px-4 file:rounded-sm file:border-0 file:text-xs file:font-semibold file:bg-teak-50 file:text-teak-700 hover:file:bg-teak-100 file:cursor-pointer file:transition-colors"
                    @change="previews = []; for(let f of $event.target.files) { if(previews.length < 3) { const r = new FileReader(); r.onload = e => previews.push(e.target.result); r.readAsDataURL(f); } }">
                @error('ref_images') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                @error('ref_images.*') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror

                {{-- Image Previews --}}
                <div class="flex gap-3 mt-3" x-show="previews.length > 0">
                    <template x-for="(src, i) in previews" :key="i">
                        <div class="w-20 h-20 rounded-sm border border-sand-200 overflow-hidden bg-sand-50">
                            <img :src="src" class="w-full h-full object-cover">
                        </div>
                    </template>
                </div>
            </div>
        </div>

        {{-- Submit --}}
        <div class="flex items-center gap-4">
            <button type="submit" :disabled="loading"
                class="inline-flex items-center gap-2 bg-teak-700 hover:bg-teak-600 text-white font-semibold py-3 px-8 rounded-sm transition-all duration-300 disabled:opacity-50 disabled:cursor-not-allowed">
                <svg x-show="loading" class="animate-spin h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                </svg>
                <span x-text="loading ? 'Mengirim...' : 'Kirim Custom Order'"></span>
            </button>
            <a href="{{ route('home') }}" class="text-sm text-sand-500 hover:text-teak-700 transition-colors">Batal</a>
        </div>
    </form>
</div>
@endsection
