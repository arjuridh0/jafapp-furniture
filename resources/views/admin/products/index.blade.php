@extends('admin.layouts.app')
@section('page-title', 'Manajemen Produk')

@section('content')
<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-6">
    <form method="GET" class="flex items-center gap-2 flex-wrap">
        <input type="text" name="search" value="{{ request('search') }}" class="admin-input !w-48 text-xs" placeholder="Cari produk...">
        <select name="status" class="admin-input !w-auto text-xs">
            <option value="">Semua Status</option>
            <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Aktif</option>
            <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Nonaktif</option>
        </select>
        <select name="category_id" class="admin-input !w-auto text-xs">
            <option value="">Semua Kategori</option>
            @foreach($categories as $cat)
            <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
            @endforeach
        </select>
        <button type="submit" class="btn-admin btn-admin-secondary text-xs">Filter</button>
    </form>
    <a href="{{ route('admin.products.create') }}" class="btn-admin btn-admin-primary">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
        Tambah Produk
    </a>
</div>

<div class="bg-white border border-sand-200/60 rounded-md overflow-hidden">
    <div class="overflow-x-auto">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Produk</th>
                    <th>Kategori</th>
                    <th class="text-right">Harga</th>
                    <th class="text-center">Stok</th>
                    <th class="text-center">Status</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                <tr>
                    <td>
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-sm overflow-hidden bg-sand-100 flex-shrink-0 border border-sand-200/50">
                                @if($product->first_image && $product->first_image !== 'images/no-image.png')
                                    <img src="{{ asset('storage/' . $product->first_image) }}" alt="" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-[8px] text-sand-300 font-heading italic">JAF</div>
                                @endif
                            </div>
                            <div>
                                <p class="font-medium text-sand-900 text-sm">{{ $product->name }}</p>
                                <p class="text-[11px] text-sand-400 font-mono">{{ $product->slug }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="text-xs">{{ $product->category?->name ?? '—' }}</td>
                    <td class="text-right font-mono text-xs font-semibold">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                    <td class="text-center text-xs">{{ $product->stock }}</td>
                    <td class="text-center">
                        <form method="POST" action="{{ route('admin.products.toggle-active', $product) }}" class="inline">
                            @csrf @method('PATCH')
                            <button type="submit" class="badge {{ $product->is_active ? 'badge-completed' : 'badge-cancelled' }} cursor-pointer hover:opacity-80 transition" title="Klik untuk toggle">
                                {{ $product->is_active ? 'Aktif' : 'Nonaktif' }}
                            </button>
                        </form>
                    </td>
                    <td class="text-right">
                        <a href="{{ route('admin.products.edit', $product) }}" class="text-xs font-medium hover:underline text-teak-600">Edit</a>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center text-sand-400 py-8">Belum ada produk.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($products->hasPages())
    <div class="px-5 py-3 border-t border-sand-100">{{ $products->links() }}</div>
    @endif
</div>
@endsection
