@extends('admin.layouts.app')
@section('page-title', 'Tambah Produk')

@section('content')
<div class="max-w-3xl">
    <a href="{{ route('admin.products.index') }}" class="text-xs text-sand-500 hover:text-teak-700 mb-4 inline-flex items-center gap-1">
        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
        Kembali ke Daftar Produk
    </a>

    @if($errors->any())
    <div class="bg-red-50 border border-red-200 rounded-sm p-3 mb-5">
        @foreach($errors->all() as $error)<p class="text-xs text-red-700">{{ $error }}</p>@endforeach
    </div>
    @endif

    <form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data" class="bg-white border border-sand-200/60 rounded-md p-6 space-y-5">
        @csrf

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
            <div>
                <label class="block text-sm font-medium text-sand-700 mb-1">Nama Produk <span class="text-red-500">*</span></label>
                <input type="text" name="name" value="{{ old('name') }}" class="admin-input" required>
            </div>
            <div>
                <label class="block text-sm font-medium text-sand-700 mb-1">Kategori <span class="text-red-500">*</span></label>
                <select name="category_id" class="admin-input" required>
                    <option value="">Pilih Kategori</option>
                    @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
            <div>
                <label class="block text-sm font-medium text-sand-700 mb-1">Harga (Rp) <span class="text-red-500">*</span></label>
                <input type="number" name="price" value="{{ old('price') }}" class="admin-input" required min="0">
            </div>
            <div>
                <label class="block text-sm font-medium text-sand-700 mb-1">Stok <span class="text-red-500">*</span></label>
                <input type="number" name="stock" value="{{ old('stock', 1) }}" class="admin-input" required min="0">
            </div>
            <div>
                <label class="block text-sm font-medium text-sand-700 mb-1">Dimensi</label>
                <input type="text" name="dimensions" value="{{ old('dimensions') }}" class="admin-input" placeholder="P x L x T cm">
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-sand-700 mb-1">Deskripsi</label>
            <textarea name="description" rows="4" class="admin-input">{{ old('description') }}</textarea>
        </div>

        {{-- Image Upload --}}
        <div x-data="imageUpload()">
            <label class="block text-sm font-medium text-sand-700 mb-2">Foto Produk (maks. 5)</label>
            <div class="flex flex-wrap gap-3 mb-3" x-show="previews.length > 0">
                <template x-for="(src, idx) in previews" :key="idx">
                    <div class="relative w-20 h-20 rounded-sm overflow-hidden border border-sand-200">
                        <img :src="src" class="w-full h-full object-cover">
                        <button type="button" @click="removeImage(idx)" class="absolute top-0.5 right-0.5 w-5 h-5 bg-red-500 text-white rounded-full flex items-center justify-center text-xs">&times;</button>
                    </div>
                </template>
            </div>
            <label class="inline-flex items-center gap-2 cursor-pointer btn-admin btn-admin-secondary" x-show="previews.length < 5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                Pilih Foto
                <input type="file" name="images[]" multiple accept="image/*" class="hidden" @change="handleFiles($event)">
            </label>
            <p class="text-[11px] text-sand-400 mt-1">JPG, PNG, WebP. Maks. 2MB per file.</p>
        </div>

        <div class="flex items-center gap-2">
            <input type="checkbox" name="is_active" value="1" checked id="is_active" class="w-4 h-4 rounded border-sand-300">
            <label for="is_active" class="text-sm text-sand-700">Aktif (tampil di katalog)</label>
        </div>

        <div class="flex justify-end gap-2 pt-4 border-t border-sand-100">
            <a href="{{ route('admin.products.index') }}" class="btn-admin btn-admin-secondary">Batal</a>
            <button type="submit" class="btn-admin btn-admin-primary">Simpan Produk</button>
        </div>
    </form>
</div>

@push('scripts')
<script>
function imageUpload() {
    return {
        previews: [],
        files: [],
        handleFiles(e) {
            const newFiles = Array.from(e.target.files);
            const remaining = 5 - this.previews.length;
            newFiles.slice(0, remaining).forEach(file => {
                const reader = new FileReader();
                reader.onload = (ev) => this.previews.push(ev.target.result);
                reader.readAsDataURL(file);
            });
        },
        removeImage(idx) {
            this.previews.splice(idx, 1);
        }
    }
}
</script>
@endpush
@endsection
