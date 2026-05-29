@extends('layouts.app')

@section('content')
<div class="bg-teak-50 min-h-screen py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Breadcrumb --}}
        <nav class="flex items-center text-xs font-body text-sand-500 mb-8 gap-1.5">
            <a href="{{ route('cart.index') }}" class="hover:text-teak-700 transition">Keranjang</a>
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
            <span class="text-sand-800 font-medium">Checkout</span>
        </nav>

        <h1 class="text-3xl font-heading font-bold text-sand-900 mb-8" style="text-wrap: balance;">Checkout</h1>

        <form action="{{ route('checkout.process') }}" method="POST" id="checkout-form" x-data="checkoutForm()" @submit="if(!emailWarning) loading = true">
            @csrf
            <div class="lg:grid lg:grid-cols-12 lg:gap-x-8">

                {{-- Checkout Form --}}
                <div class="lg:col-span-7">
                    <div class="bg-white rounded-sm shadow-xs border border-sand-200/50 p-6 sm:p-8">
                        <h2 class="text-lg font-heading font-semibold text-sand-900 mb-6 pb-3 border-b border-sand-100">
                            Informasi Pemesan
                        </h2>

                        {{-- Name --}}
                        <div class="mb-5">
                            <label for="checkout-name" class="block text-sm font-medium text-sand-700 mb-1.5">Nama Lengkap <span class="text-red-500">*</span></label>
                            <input type="text" name="name" id="checkout-name"
                                value="{{ old('name', $user?->name ?? '') }}"
                                class="input-premium" required
                                placeholder="Masukkan nama lengkap Anda">
                            @error('name') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>

                        {{-- Email --}}
                        <div class="mb-5">
                            <label for="checkout-email" class="block text-sm font-medium text-sand-700 mb-1.5">Email <span class="text-red-500">*</span></label>
                            <input type="email" name="email" id="checkout-email"
                                value="{{ old('email', $user?->email ?? '') }}"
                                class="input-premium" required
                                placeholder="email@contoh.com"
                                @if(!auth()->check()) @input.debounce.500ms="checkEmail()" @endif
                                {{ auth()->check() ? 'readonly' : '' }}>
                            @error('email') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                            <template x-if="emailWarning">
                                <p class="mt-1 text-xs text-amber-600 flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 2.495zM10 6a.75.75 0 01.75.75v3.5a.75.75 0 01-1.5 0v-3.5A.75.75 0 0110 6zm0 9a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"/></svg>
                                    <span x-text="emailWarning"></span>
                                </p>
                            </template>
                        </div>

                        {{-- Phone --}}
                        <div class="mb-5">
                            <label for="checkout-phone" class="block text-sm font-medium text-sand-700 mb-1.5">Nomor HP <span class="text-red-500">*</span></label>
                            <input type="tel" name="phone" id="checkout-phone"
                                value="{{ old('phone', $user?->phone ?? '') }}"
                                class="input-premium" required
                                placeholder="08xxxxxxxxxx">
                            @error('phone') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>

                        {{-- Address --}}
                        <div class="mb-5">
                            <label for="checkout-address" class="block text-sm font-medium text-sand-700 mb-1.5">Alamat Pengiriman <span class="text-red-500">*</span></label>
                            <textarea name="address" id="checkout-address" rows="3"
                                class="input-premium resize-none" required
                                placeholder="Jl. Contoh No. 123, Kota, Provinsi, Kode Pos">{{ old('address', $user?->address ?? '') }}</textarea>
                            @error('address') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>

                        {{-- Notes --}}
                        <div class="mb-2">
                            <label for="checkout-notes" class="block text-sm font-medium text-sand-700 mb-1.5">Catatan <span class="text-sand-400 text-xs font-normal">(opsional)</span></label>
                            <textarea name="notes" id="checkout-notes" rows="2"
                                class="input-premium resize-none"
                                placeholder="Catatan tambahan untuk pesanan Anda">{{ old('notes') }}</textarea>
                        </div>

                        @guest
                        <div class="mt-6 pt-5 border-t border-sand-100">
                            <p class="text-xs text-sand-500 leading-relaxed">
                                <svg class="w-3.5 h-3.5 inline-block mr-0.5 -mt-0.5 text-sand-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                Dengan melanjutkan, kami akan membuat akun otomatis untuk Anda. Detail akun akan dikirim ke email.
                            </p>
                        </div>
                        @endguest
                    </div>
                </div>

                {{-- Order Summary --}}
                <div class="lg:col-span-5 mt-8 lg:mt-0">
                    <div class="bg-white rounded-sm shadow-xs border border-sand-200/50 p-6 sm:p-8 sticky top-24">
                        <h2 class="text-lg font-heading font-semibold text-sand-900 mb-5 pb-3 border-b border-sand-100">
                            Ringkasan Pesanan
                        </h2>

                        <ul class="divide-y divide-sand-100 -my-3 mb-6">
                            @foreach($cart as $id => $item)
                            <li class="flex py-3 gap-3">
                                <div class="flex-shrink-0 w-14 h-14 border border-sand-200/50 rounded-sm overflow-hidden bg-sand-100">
                                    @if($item['image'] && $item['image'] !== 'images/no-image.png')
                                        <img src="{{ asset('storage/' . $item['image']) }}" alt="{{ $item['name'] }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center bg-sand-100">
                                            <span class="font-heading italic text-[10px] font-semibold text-sand-300">JAF</span>
                                        </div>
                                    @endif
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-sand-900 truncate">{{ $item['name'] }}</p>
                                    <p class="text-xs text-sand-500 mt-0.5">{{ $item['qty'] }}x @ Rp {{ number_format($item['price'], 0, ',', '.') }}</p>
                                </div>
                                <p class="text-sm font-semibold text-sand-800 whitespace-nowrap">
                                    Rp {{ number_format($item['price'] * $item['qty'], 0, ',', '.') }}
                                </p>
                            </li>
                            @endforeach
                        </ul>

                        <div class="border-t border-sand-200 pt-4 space-y-3">
                            <div class="flex justify-between text-sm">
                                <span class="text-sand-500">Subtotal ({{ count($cart) }} produk)</span>
                                <span class="font-medium text-sand-800">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-sand-500">Ongkos Kirim</span>
                                <span class="text-xs text-sand-400 italic">Dihitung setelah konfirmasi</span>
                            </div>
                            <div class="flex justify-between text-base font-bold pt-3 border-t border-sand-200">
                                <span class="text-sand-900">Total</span>
                                <span class="text-teak-700">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                            </div>
                        </div>

                        <button type="submit" class="w-full btn-primary mt-6 flex items-center justify-center gap-2 text-sm transition-all duration-300"
                            :disabled="emailWarning || loading" :class="{ 'opacity-50 cursor-not-allowed': emailWarning || loading }">
                            <svg x-show="loading" class="animate-spin h-4 w-4" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                            </svg>
                            <svg x-show="!loading" class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <span x-text="loading ? 'Memproses Pesanan...' : 'Buat Pesanan'"></span>
                        </button>

                        <p class="mt-4 text-center text-xs text-sand-400">
                            Anda akan diarahkan ke halaman pembayaran setelah pesanan dibuat.
                        </p>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
function checkoutForm() {
    return {
        emailWarning: null,
        loading: false,
        async checkEmail() {
            const email = document.getElementById('checkout-email').value;
            if (!email || !email.includes('@')) { this.emailWarning = null; return; }
            try {
                const res = await fetch('{{ route("checkout.check-email") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    },
                    body: JSON.stringify({ email }),
                });
                const data = await res.json();
                this.emailWarning = data.is_active ? data.message : null;
            } catch { this.emailWarning = null; }
        }
    }
}
</script>
@endpush
@endsection
