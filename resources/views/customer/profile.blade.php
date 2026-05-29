@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto px-4 py-12">
    <h1 class="text-2xl font-heading font-bold text-sand-900 mb-8">Profil Saya</h1>

    {{-- Account Info --}}
    <div class="bg-white border border-sand-200/50 rounded-sm p-6 mb-6">
        <h2 class="text-sm font-semibold text-sand-900 mb-4">Informasi Akun</h2>
        <div class="space-y-3">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 rounded-full bg-teak-100 flex items-center justify-center text-xl font-bold text-teak-700">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
                <div>
                    <p class="font-semibold text-sand-900">{{ auth()->user()->name }}</p>
                    <p class="text-sm text-sand-500">{{ auth()->user()->email }}</p>
                </div>
            </div>
            <div class="grid grid-cols-2 gap-4 pt-3 border-t border-sand-100 text-sm">
                <div>
                    <span class="text-sand-500">Telepon</span>
                    <p class="font-medium text-sand-900">{{ auth()->user()->phone ?? '—' }}</p>
                </div>
                <div>
                    <span class="text-sand-500">Member Sejak</span>
                    <p class="font-medium text-sand-900">{{ auth()->user()->created_at->format('d M Y') }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Change Password --}}
    <div class="bg-white border border-sand-200/50 rounded-sm p-6">
        <h2 class="text-sm font-semibold text-sand-900 mb-4">Ubah Password</h2>

        <form method="POST" action="{{ route('customer.update-password') }}" x-data="{ loading: false }" @submit="loading = true" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label for="current_password" class="block text-sm font-medium text-sand-700 mb-1">Password Saat Ini</label>
                <input type="password" id="current_password" name="current_password" required
                    class="w-full rounded-sm border border-sand-200 focus:border-teak-600 focus:ring-2 focus:ring-teak-600/10 px-4 py-3 text-sm bg-white transition-colors">
                @error('current_password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-sand-700 mb-1">Password Baru</label>
                <input type="password" id="password" name="password" required minlength="8"
                    class="w-full rounded-sm border border-sand-200 focus:border-teak-600 focus:ring-2 focus:ring-teak-600/10 px-4 py-3 text-sm bg-white transition-colors">
                @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-sand-700 mb-1">Konfirmasi Password Baru</label>
                <input type="password" id="password_confirmation" name="password_confirmation" required
                    class="w-full rounded-sm border border-sand-200 focus:border-teak-600 focus:ring-2 focus:ring-teak-600/10 px-4 py-3 text-sm bg-white transition-colors">
            </div>

            <button type="submit" :disabled="loading"
                class="inline-flex items-center gap-2 bg-sand-900 hover:bg-teak-700 text-white font-semibold py-3 px-6 rounded-sm text-sm transition-all duration-300 disabled:opacity-50">
                <svg x-show="loading" class="animate-spin h-4 w-4" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                </svg>
                <span x-text="loading ? 'Menyimpan...' : 'Ubah Password'"></span>
            </button>
        </form>
    </div>

    {{-- Quick Links --}}
    <div class="mt-6 flex flex-wrap gap-3">
        <a href="{{ route('customer.orders') }}" class="text-sm font-medium text-teak-700 hover:text-teak-600 transition-colors">Pesanan Saya →</a>
        <a href="{{ route('customer.custom-orders') }}" class="text-sm font-medium text-teak-700 hover:text-teak-600 transition-colors">Custom Order Saya →</a>
    </div>
</div>
@endsection
