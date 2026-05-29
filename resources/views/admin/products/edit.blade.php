@extends('admin.layouts.app')
@section('page-title', 'Edit Produk')

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

    <form method="POST" action="{{ route('admin.products.update', $product) }}" enctype="multipart/form-data" class="bg-white border border-sand-200/60 rounded-md p-6 space-y-5">
        @csrf @method('PUT')

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
            <div>
                <label class="block text-sm font-medium text-sand-700 mb-1">Nama Produk <span class="text-red-500">*</span></label>
                <input type="text" name="name" value="{{ old('name', $product->name) }}" class="admin-input" required>
            </div>
            <div>
                <label class="block text-sm font-medium text-sand-700 mb-1">Kategori <span class="text-red-500">*</span></label>
                <select name="category_id" class="admin-input" required>
                    @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ old('category_id', $product->category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
            <div>
                <label class="block text-sm font-medium text-sand-700 mb-1">Harga (Rp) <span class="text-red-500">*</span></label>
                <input type="number" name="price" value="{{ old('price', $product->price) }}" class="admin-input" required min="0">
            </div>
            <div>
                <label class="block text-sm font-medium text-sand-700 mb-1">Stok <span class="text-red-500">*</span></label>
                <input type="number" name="stock" value="{{ old('stock', $product->stock) }}" class="admin-input" required min="0">
            </div>
            <div>
                <label class="block text-sm font-medium text-sand-700 mb-1">Dimensi</label>
                <input type="text" name="dimensions" value="{{ old('dimensions', $product->dimensions) }}" class="admin-input" placeholder="P x L x T cm">
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-sand-700 mb-1">Deskripsi</label>
            <textarea name="description" rows="4" class="admin-input">{{ old('description', $product->description) }}</textarea>
        </div>

        {{-- Existing Images --}}
        @if($product->images && count($product->images) > 0)
        <div>
            <label class="block text-sm font-medium text-sand-700 mb-2">Foto Saat Ini</label>
            <div class="flex flex-wrap gap-3">
                @foreach($product->images as $img)
                <div class="relative w-20 h-20 rounded-sm overflow-hidden border border-sand-200" x-data="{ remove: false }">
                    <img src="{{ asset('storage/' . $img) }}" class="w-full h-full object-cover" :class="{ 'opacity-30': remove }">
                    <label class="absolute top-0.5 right-0.5 w-5 h-5 bg-red-500 text-white rounded-full flex items-center justify-center text-xs cursor-pointer" :class="{ 'bg-green-500': remove }">
                        <input type="checkbox" name="remove_images[]" value="{{ $img }}" class="hidden" x-model="remove">
                        <span x-text="remove ? '↺' : '×'"></span>
                    </label>
                </div>
                @endforeach
            </div>
            <p class="text-[11px] text-sand-400 mt-1">Klik × untuk menandai foto yang akan dihapus.</p>
        </div>
        @endif

        {{-- New Images Upload --}}
        <div>
            <label class="block text-sm font-medium text-sand-700 mb-2">Tambah Foto Baru</label>
            <input type="file" name="images[]" multiple accept="image/*" class="admin-input text-xs">
            <p class="text-[11px] text-sand-400 mt-1">Total foto maks. 5. JPG, PNG, WebP. Maks. 2MB per file.</p>
        </div>

        <div class="flex items-center gap-2">
            <input type="checkbox" name="is_active" value="1" {{ old('is_active', $product->is_active) ? 'checked' : '' }} id="is_active" class="w-4 h-4 rounded border-sand-300">
            <label for="is_active" class="text-sm text-sand-700">Aktif (tampil di katalog)</label>
        </div>

        <div class="flex justify-end gap-2 pt-4 border-t border-sand-100">
            <a href="{{ route('admin.products.index') }}" class="btn-admin btn-admin-secondary">Batal</a>
            <button type="submit" class="btn-admin btn-admin-primary">Perbarui Produk</button>
        </div>
    </form>
</div>
@endsection
