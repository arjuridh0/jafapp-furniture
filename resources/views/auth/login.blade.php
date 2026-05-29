@extends('layouts.app')

@section('content')
<div class="bg-teak-50 min-h-screen py-12 flex items-center justify-center">
    <div class="w-full max-w-md mx-auto px-4">

        <div class="text-center mb-8">
            <a href="{{ route('home') }}" class="inline-block">
                <span class="text-2xl font-heading font-bold text-teak-700 tracking-tight">JAF</span>
                <span class="text-2xl font-heading font-bold text-sand-900 tracking-tight">APP</span>
            </a>
            <h1 class="text-xl font-heading font-semibold text-sand-900 mt-4">Masuk ke Akun Anda</h1>
            <p class="text-sm text-sand-500 mt-1">Selamat datang kembali</p>
        </div>

        <div class="bg-white rounded-sm shadow-xs border border-sand-200/50 p-6 sm:p-8">
            @if($errors->any())
                <div class="bg-red-50 border border-red-200 rounded-sm p-3 mb-5">
                    @foreach($errors->all() as $error)
                        <p class="text-xs text-red-700">{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('login.attempt') }}">
                @csrf

                <div class="mb-5">
                    <label for="login-email" class="block text-sm font-medium text-sand-700 mb-1.5">Email</label>
                    <input type="email" name="email" id="login-email"
                        value="{{ old('email') }}"
                        class="input-premium" required autofocus
                        placeholder="email@contoh.com">
                </div>

                <div class="mb-5">
                    <label for="login-password" class="block text-sm font-medium text-sand-700 mb-1.5">Password</label>
                    <input type="password" name="password" id="login-password"
                        class="input-premium" required
                        placeholder="Masukkan password Anda">
                </div>

                <div class="flex items-center justify-between mb-6">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="remember"
                            class="w-4 h-4 rounded border-sand-300 text-teak-700 focus:ring-teak-500/30">
                        <span class="text-xs text-sand-600">Ingat saya</span>
                    </label>
                    <a href="{{ route('password.request') }}" class="text-xs text-teak-700 hover:text-teak-600 font-medium transition">
                        Lupa password?
                    </a>
                </div>

                <button type="submit" class="w-full btn-primary flex items-center justify-center gap-2 text-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/></svg>
                    Masuk
                </button>
            </form>
        </div>

        <div class="mt-6 text-center">
            <p class="text-xs text-sand-500">
                Belum punya akun? Akun akan dibuat otomatis saat checkout.
            </p>
            <p class="text-xs text-sand-500 mt-2">
                <a href="{{ route('activation.resend-form') }}" class="text-teak-700 hover:text-teak-600 font-medium transition">
                    Kirim ulang email aktivasi
                </a>
            </p>
        </div>
    </div>
</div>
@endsection
