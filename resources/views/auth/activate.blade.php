@extends('layouts.app')

@section('content')
<div class="bg-teak-50 min-h-screen py-12 flex items-center justify-center">
    <div class="w-full max-w-md mx-auto px-4">

        <div class="text-center mb-8">
            <a href="{{ route('home') }}" class="inline-block">
                <span class="text-2xl font-heading font-bold text-teak-700 tracking-tight">JAF</span>
                <span class="text-2xl font-heading font-bold text-sand-900 tracking-tight">APP</span>
            </a>
        </div>

        <div class="bg-white rounded-sm shadow-xs border border-sand-200/50 p-6 sm:p-8 text-center">
            @if($success)
                <div class="w-16 h-16 mx-auto bg-forest-700/10 rounded-full flex items-center justify-center mb-5">
                    <svg class="w-8 h-8 text-forest-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                </div>
                <h1 class="text-xl font-heading font-semibold text-sand-900 mb-2">Aktivasi Berhasil!</h1>
                <p class="text-sm text-sand-600 mb-6">{{ $message }}</p>
                <a href="{{ route('home') }}" class="btn-primary inline-flex items-center gap-2 text-sm">
                    Mulai Belanja
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                </a>
            @else
                <div class="w-16 h-16 mx-auto bg-red-50 rounded-full flex items-center justify-center mb-5">
                    <svg class="w-8 h-8 text-red-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z"/></svg>
                </div>
                <h1 class="text-xl font-heading font-semibold text-sand-900 mb-2">Aktivasi Gagal</h1>
                <p class="text-sm text-sand-600 mb-6">{{ $message }}</p>
                <a href="{{ route('activation.resend-form') }}" class="btn-secondary inline-flex items-center gap-2 text-sm">
                    Kirim Ulang Email Aktivasi
                </a>
            @endif
        </div>
    </div>
</div>
@endsection
