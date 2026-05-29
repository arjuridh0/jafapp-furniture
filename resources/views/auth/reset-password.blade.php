@extends('layouts.app')

@section('content')
<div class="bg-teak-50 min-h-screen py-12 flex items-center justify-center">
    <div class="w-full max-w-md mx-auto px-4">
        <div class="text-center mb-8">
            <a href="{{ route('home') }}" class="inline-block">
                <span class="text-2xl font-heading font-bold text-teak-700 tracking-tight">JAF</span>
                <span class="text-2xl font-heading font-bold text-sand-900 tracking-tight">APP</span>
            </a>
            <h1 class="text-xl font-heading font-semibold text-sand-900 mt-4">Reset Password</h1>
            <p class="text-sm text-sand-500 mt-1">Buat password baru untuk akun Anda</p>
        </div>

        <div class="bg-white rounded-sm shadow-xs border border-sand-200/50 p-6 sm:p-8">
            @if($errors->any())
                <div class="bg-red-50 border border-red-200 rounded-sm p-3 mb-5">
                    @foreach($errors->all() as $error)
                        <p class="text-xs text-red-700">{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('password.update') }}">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">

                <div class="mb-5">
                    <label for="reset-email" class="block text-sm font-medium text-sand-700 mb-1.5">Email</label>
                    <input type="email" name="email" id="reset-email"
                        value="{{ old('email', $email) }}"
                        class="input-premium" required readonly>
                </div>

                <div class="mb-5">
                    <label for="reset-password" class="block text-sm font-medium text-sand-700 mb-1.5">Password Baru</label>
                    <input type="password" name="password" id="reset-password"
                        class="input-premium" required placeholder="Minimal 8 karakter" minlength="8">
                </div>

                <div class="mb-6">
                    <label for="reset-password-confirm" class="block text-sm font-medium text-sand-700 mb-1.5">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" id="reset-password-confirm"
                        class="input-premium" required placeholder="Ulangi password baru">
                </div>

                <button type="submit" class="w-full btn-primary text-sm">Reset Password</button>
            </form>
        </div>
    </div>
</div>
@endsection
