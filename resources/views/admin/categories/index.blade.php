@extends('admin.layouts.app')
@section('page-title', 'Manajemen Kategori')

@section('content')
<div class="flex items-center justify-between mb-6">
    <p class="text-sm text-sand-500">{{ $categories->count() }} kategori</p>
    <button onclick="document.getElementById('modal-add').classList.remove('hidden')" class="btn-admin btn-admin-primary">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
        Tambah Kategori
    </button>
</div>

<div class="bg-white border border-sand-200/60 rounded-md overflow-hidden">
    <table class="admin-table">
        <thead><tr><th>Nama</th><th>Slug</th><th class="text-center">Jumlah Produk</th><th></th></tr></thead>
        <tbody>
            @forelse($categories as $category)
            <tr>
                <td class="font-semibold text-sand-900">{{ $category->name }}</td>
                <td class="font-mono text-xs text-sand-500">{{ $category->slug }}</td>
                <td class="text-center">
                    <span class="badge badge-production">{{ $category->products_count }}</span>
                </td>
                <td class="text-right space-x-2">
                    <button onclick="openEdit({{ $category->id }}, '{{ addslashes($category->name) }}')" class="text-xs font-medium hover:underline text-teak-600">Edit</button>
                    @if($category->products_count === 0)
                    <form method="POST" action="{{ route('admin.categories.destroy', $category) }}" class="inline" onsubmit="return confirm('Hapus kategori ini?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="text-xs font-medium text-red-500 hover:underline">Hapus</button>
                    </form>
                    @endif
                </td>
            </tr>
            @empty
            <tr><td colspan="4" class="text-center text-sand-400 py-8">Belum ada kategori.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- Modal Add --}}
<div id="modal-add" class="hidden fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-md w-full max-w-md p-6">
        <h3 class="text-base font-semibold text-sand-900 mb-4">Tambah Kategori</h3>
        <form method="POST" action="{{ route('admin.categories.store') }}">
            @csrf
            <div class="mb-4">
                <label class="block text-sm font-medium text-sand-700 mb-1">Nama Kategori</label>
                <input type="text" name="name" class="admin-input" required placeholder="contoh: Kursi">
            </div>
            <div class="flex justify-end gap-2">
                <button type="button" onclick="document.getElementById('modal-add').classList.add('hidden')" class="btn-admin btn-admin-secondary">Batal</button>
                <button type="submit" class="btn-admin btn-admin-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>

{{-- Modal Edit --}}
<div id="modal-edit" class="hidden fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-md w-full max-w-md p-6">
        <h3 class="text-base font-semibold text-sand-900 mb-4">Edit Kategori</h3>
        <form id="form-edit" method="POST">
            @csrf @method('PUT')
            <div class="mb-4">
                <label class="block text-sm font-medium text-sand-700 mb-1">Nama Kategori</label>
                <input type="text" name="name" id="edit-name" class="admin-input" required>
            </div>
            <div class="flex justify-end gap-2">
                <button type="button" onclick="document.getElementById('modal-edit').classList.add('hidden')" class="btn-admin btn-admin-secondary">Batal</button>
                <button type="submit" class="btn-admin btn-admin-primary">Perbarui</button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
function openEdit(id, name) {
    document.getElementById('edit-name').value = name;
    document.getElementById('form-edit').action = `/admin/categories/${id}`;
    document.getElementById('modal-edit').classList.remove('hidden');
}
</script>
@endpush
@endsection
