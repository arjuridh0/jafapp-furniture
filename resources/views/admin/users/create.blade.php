@extends('admin.layouts.app')

@section('page-title', 'Tambah Admin Baru')

@section('content')
<div class="max-w-xl">
    <a href="{{ route('admin.users.index') }}" class="inline-flex items-center gap-1 text-xs text-sand-500 hover:text-teak-700 mb-4 transition-colors">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
        Kembali ke Daftar User
    </a>

    <div class="bg-white border border-sand-200/60 rounded-md p-6">
        <h3 class="text-sm font-semibold text-sand-900 mb-5">Informasi Admin Baru</h3>

        <form method="POST" action="{{ route('admin.users.store') }}" class="space-y-4">
            @csrf

            <div>
                <label class="block text-xs font-medium text-sand-700 mb-1">Nama Lengkap</label>
                <input type="text" name="name" value="{{ old('name') }}" class="admin-input w-full" required>
                @error('name') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-xs font-medium text-sand-700 mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" class="admin-input w-full" required>
                @error('email') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-medium text-sand-700 mb-1">Password</label>
                    <input type="password" name="password" class="admin-input w-full" required>
                    @error('password') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-xs font-medium text-sand-700 mb-1">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" class="admin-input w-full" required>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-medium text-sand-700 mb-1">Role</label>
                    <select name="role" class="admin-input w-full" required>
                        <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="superadmin" {{ old('role') === 'superadmin' ? 'selected' : '' }}>Super Admin</option>
                    </select>
                    @error('role') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-xs font-medium text-sand-700 mb-1">Telepon <span class="text-sand-400">(opsional)</span></label>
                    <input type="text" name="phone" value="{{ old('phone') }}" class="admin-input w-full" placeholder="08xxx">
                </div>
            </div>

            <div class="flex items-center gap-3 pt-3">
                <button type="submit" class="btn-admin btn-admin-primary">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                    Simpan Admin
                </button>
                <a href="{{ route('admin.users.index') }}" class="btn-admin btn-admin-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
