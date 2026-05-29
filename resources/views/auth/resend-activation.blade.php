@extends('layouts.app')

@section('content')
<div class="bg-teak-50 min-h-screen py-12 flex items-center justify-center">
    <div class="w-full max-w-md mx-auto px-4">
        <div class="text-center mb-8">
            <a href="{{ route('home') }}" class="inline-block">
                <span class="text-2xl font-heading font-bold text-teak-700 tracking-tight">JAF</span>
                <span class="text-2xl font-heading font-bold text-sand-900 tracking-tight">APP</span>
            </a>
            <h1 class="text-xl font-heading font-semibold text-sand-900 mt-4">Kirim Ulang Email Aktivasi</h1>
            <p class="text-sm text-sand-500 mt-1">Masukkan email Anda untuk menerima link aktivasi baru</p>
        </div>

        <div class="bg-white rounded-sm shadow-xs border border-sand-200/50 p-6 sm:p-8">
            <form method="POST" action="{{ route('activation.resend') }}">
                @csrf
                <div class="mb-6">
                    <label for="resend-email" class="block text-sm font-medium text-sand-700 mb-1.5">Email</label>
                    <input type="email" name="email" id="resend-email"
                        value="{{ old('email') }}"
                        class="input-premium" required autofocus
                        placeholder="email@contoh.com">
                </div>

                <button type="submit" class="w-full btn-primary text-sm">Kirim Email Aktivasi</button>
            </form>
        </div>

        <div class="mt-6 text-center">
            <a href="{{ route('login') }}" class="text-xs text-teak-700 hover:text-teak-600 font-medium transition">
                &larr; Kembali ke halaman login
            </a>
        </div>
    </div>
</div>
@endsection
