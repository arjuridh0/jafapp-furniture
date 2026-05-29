@extends('layouts.app')

@section('content')
<div class="bg-teak-50 min-h-screen py-12 flex items-center justify-center">
    <div class="w-full max-w-md mx-auto px-4">

        <div class="text-center mb-8">
            <a href="{{ route('home') }}" class="inline-block">
                <span class="text-2xl font-heading font-bold text-teak-700 tracking-tight">JAF</span>
                <span class="text-2xl font-heading font-bold text-sand-900 tracking-tight">APP</span>
            </a>
            <h1 class="text-xl font-heading font-semibold text-sand-900 mt-4">Aktivasi Akun</h1>
            <p class="text-sm text-sand-500 mt-1">Buat password baru untuk mengaktifkan akun Anda</p>
        </div>

        <div class="bg-white rounded-sm shadow-xs border border-sand-200/50 p-6 sm:p-8">

            @if($errors->any())
                <div class="bg-red-50 border border-red-200 rounded-sm p-3 mb-5">
                    @foreach($errors->all() as $error)
                        <p class="text-xs text-red-700">{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <div class="bg-sand-50 border border-sand-200/50 rounded-sm p-3 mb-5">
                <p class="text-xs text-sand-600">
                    <span class="font-medium text-sand-800">Email:</span> {{ $user->email }}
                </p>
            </div>

            <form method="POST" action="{{ route('activation.set-password.submit', $token) }}">
                @csrf

                <div class="mb-5">
                    <label for="set-password" class="block text-sm font-medium text-sand-700 mb-1.5">Password Baru</label>
                    <input type="password" name="password" id="set-password"
                        class="input-premium" required
                        placeholder="Minimal 8 karakter" minlength="8">
                </div>

                <div class="mb-6">
                    <label for="set-password-confirm" class="block text-sm font-medium text-sand-700 mb-1.5">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" id="set-password-confirm"
                        class="input-premium" required
                        placeholder="Ulangi password baru">
                </div>

                <button type="submit" class="w-full btn-primary flex items-center justify-center gap-2 text-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                    Aktivasi & Set Password
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
