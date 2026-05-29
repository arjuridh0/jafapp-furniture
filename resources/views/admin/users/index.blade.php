@extends('admin.layouts.app')

@section('page-title', 'Manajemen User')

@section('content')
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-6">
    <div>
        <h2 class="text-lg font-heading font-bold text-sand-900">Semua Pengguna</h2>
        <p class="text-xs text-sand-500 mt-0.5">Kelola akun pelanggan dan admin</p>
    </div>
    <a href="{{ route('admin.users.create') }}" class="btn-admin btn-admin-primary">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
        Tambah Admin
    </a>
</div>

{{-- Filters --}}
<div class="bg-white border border-sand-200/60 rounded-md p-4 mb-6">
    <form method="GET" action="{{ route('admin.users.index') }}" class="flex flex-wrap items-end gap-3">
        <div class="flex-1 min-w-[180px]">
            <label class="text-xs text-sand-500 mb-1 block">Cari</label>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Nama atau email..." class="admin-input w-full">
        </div>
        <div>
            <label class="text-xs text-sand-500 mb-1 block">Role</label>
            <select name="role" class="admin-input">
                <option value="">Semua Role</option>
                <option value="customer" {{ request('role') == 'customer' ? 'selected' : '' }}>Customer</option>
                <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="superadmin" {{ request('role') == 'superadmin' ? 'selected' : '' }}>Super Admin</option>
            </select>
        </div>
        <div>
            <label class="text-xs text-sand-500 mb-1 block">Status</label>
            <select name="status" class="admin-input">
                <option value="">Semua</option>
                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Aktif</option>
                <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Nonaktif</option>
            </select>
        </div>
        <button type="submit" class="btn-admin btn-admin-secondary">Filter</button>
        @if(request()->hasAny(['search', 'role', 'status']))
            <a href="{{ route('admin.users.index') }}" class="text-xs text-red-500 hover:text-red-700">Reset</a>
        @endif
    </form>
</div>

{{-- Users Table --}}
<div class="bg-white border border-sand-200/60 rounded-md overflow-hidden">
    <div class="overflow-x-auto">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Pengguna</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th>Terdaftar</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                <tr>
                    <td>
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-teak-100 flex items-center justify-center text-xs font-bold text-teak-700 shrink-0">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                            <div>
                                <p class="text-xs font-semibold text-sand-900">{{ $user->name }}</p>
                                <p class="text-[11px] text-sand-400">{{ $user->email }}</p>
                            </div>
                        </div>
                    </td>
                    <td>
                        @php
                            $roleBadge = match($user->role) {
                                'superadmin' => 'badge-completed',
                                'admin' => 'badge-production',
                                default => 'badge-pending',
                            };
                        @endphp
                        <span class="badge {{ $roleBadge }}">{{ ucfirst($user->role) }}</span>
                    </td>
                    <td>
                        <span class="badge {{ $user->is_active ? 'badge-completed' : 'badge-cancelled' }}">
                            {{ $user->is_active ? 'Aktif' : 'Nonaktif' }}
                        </span>
                    </td>
                    <td class="text-xs text-sand-500">{{ $user->created_at->format('d/m/Y') }}</td>
                    <td>
                        @if($user->id !== auth()->id())
                        <div class="flex items-center gap-2">
                            {{-- Toggle Active --}}
                            <form method="POST" action="{{ route('admin.users.toggle-active', $user) }}" class="inline">
                                @csrf @method('PATCH')
                                <button type="submit" class="text-xs font-medium hover:underline {{ $user->is_active ? 'text-red-500 hover:text-red-700' : 'text-forest-600 hover:text-forest-700' }}"
                                    onclick="return confirm('{{ $user->is_active ? 'Nonaktifkan' : 'Aktifkan' }} akun {{ $user->name }}?')">
                                    {{ $user->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                                </button>
                            </form>

                            {{-- Change Role --}}
                            <form method="POST" action="{{ route('admin.users.update-role', $user) }}" class="inline">
                                @csrf @method('PATCH')
                                <select name="role" onchange="if(confirm('Ubah role {{ $user->name }}?')) this.form.submit()" class="admin-input !py-1 !text-[11px] !w-auto">
                                    <option value="customer" {{ $user->role === 'customer' ? 'selected' : '' }}>Customer</option>
                                    <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                                    <option value="superadmin" {{ $user->role === 'superadmin' ? 'selected' : '' }}>Super Admin</option>
                                </select>
                            </form>
                        </div>
                        @else
                            <span class="text-xs text-sand-400 italic">Anda</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center text-sand-400 py-8">Belum ada pengguna.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($users->hasPages())
    <div class="px-5 py-3 border-t border-sand-100">
        {{ $users->links() }}
    </div>
    @endif
</div>
@endsection
