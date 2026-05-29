@extends('admin.layouts.app')
@section('page-title', 'Detail Custom Order #' . $customOrder->id)

@section('content')
<a href="{{ route('admin.custom-orders.index') }}" class="text-xs text-sand-500 hover:text-teak-700 mb-4 inline-flex items-center gap-1">
    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
    Kembali
</a>

<div class="grid lg:grid-cols-3 gap-6">
    {{-- Left: Specifications --}}
    <div class="lg:col-span-2 space-y-6">
        <div class="bg-white border border-sand-200/60 rounded-md p-5">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-base font-semibold text-sand-900">Spesifikasi Custom Order</h3>
                @php
                    $bc = match($customOrder->status) {
                        'submitted' => 'badge-pending', 'under_review' => 'badge-production',
                        'approved','converted_to_order' => 'badge-completed', 'rejected' => 'badge-cancelled',
                        default => 'badge-pending',
                    };
                @endphp
                <span class="badge {{ $bc }}">{{ $customOrder->status_label }}</span>
            </div>
            <div class="grid sm:grid-cols-2 gap-4 text-sm">
                <div class="sm:col-span-2"><p class="text-xs text-sand-500">Deskripsi</p><p class="text-sand-900">{{ $customOrder->description }}</p></div>
                @if($customOrder->dimensions)<div><p class="text-xs text-sand-500">Ukuran</p><p class="text-sand-900">{{ $customOrder->dimensions }}</p></div>@endif
                @if($customOrder->material)<div><p class="text-xs text-sand-500">Material</p><p class="text-sand-900">{{ $customOrder->material }}</p></div>@endif
                @if($customOrder->finishing)<div><p class="text-xs text-sand-500">Finishing</p><p class="text-sand-900">{{ $customOrder->finishing }}</p></div>@endif
                @if($customOrder->color)<div><p class="text-xs text-sand-500">Warna</p><p class="text-sand-900">{{ $customOrder->color }}</p></div>@endif
            </div>
        </div>

        {{-- Reference Images --}}
        @if($customOrder->ref_images && count($customOrder->ref_images) > 0)
        <div class="bg-white border border-sand-200/60 rounded-md p-5">
            <h3 class="text-sm font-semibold text-sand-900 mb-3">Lampiran Referensi</h3>
            <div class="flex flex-wrap gap-3">
                @foreach($customOrder->ref_images as $img)
                <a href="{{ asset('storage/' . $img) }}" target="_blank" class="w-24 h-24 rounded-sm overflow-hidden border border-sand-200 hover:ring-2 hover:ring-teak-700/50 transition">
                    <img src="{{ asset('storage/' . $img) }}" class="w-full h-full object-cover">
                </a>
                @endforeach
            </div>
        </div>
        @endif

        {{-- Admin Notes --}}
        @if($customOrder->admin_notes)
        <div class="bg-white border border-sand-200/60 rounded-md p-5">
            <h3 class="text-sm font-semibold text-sand-900 mb-2">Catatan Admin</h3>
            <p class="text-sm text-sand-700">{{ $customOrder->admin_notes }}</p>
        </div>
        @endif
    </div>

    {{-- Right: Customer + Actions --}}
    <div class="space-y-6">
        {{-- Customer Info --}}
        <div class="bg-white border border-sand-200/60 rounded-md p-5">
            <h3 class="text-sm font-semibold text-sand-900 mb-3">Pelanggan</h3>
            <div class="text-sm space-y-2">
                <div><p class="text-xs text-sand-500">Nama</p><p class="text-sand-900 font-medium">{{ $customOrder->user?->name }}</p></div>
                <div><p class="text-xs text-sand-500">Email</p><p class="text-sand-900">{{ $customOrder->user?->email }}</p></div>
                <div><p class="text-xs text-sand-500">Tanggal Pengajuan</p><p class="text-sand-900">{{ $customOrder->created_at->translatedFormat('d F Y, H:i') }}</p></div>
            </div>
        </div>

        {{-- Linked Order --}}
        @if($customOrder->order)
        <div class="bg-white border border-sand-200/60 rounded-md p-5">
            <h3 class="text-sm font-semibold text-sand-900 mb-3">Pesanan Terkait</h3>
            <a href="{{ route('admin.orders.show', $customOrder->order) }}" class="font-mono text-sm font-semibold hover:underline text-teak-600">
                {{ $customOrder->order->order_number }}
            </a>
            <p class="text-xs text-sand-500 mt-1">Harga: Rp {{ number_format($customOrder->agreed_price, 0, ',', '.') }}</p>
        </div>
        @endif

        {{-- Action Forms --}}
        @if(in_array($customOrder->status, ['submitted', 'under_review']))
        <div class="bg-white border border-sand-200/60 rounded-md p-5">
            <h3 class="text-sm font-semibold text-sand-900 mb-3">Aksi</h3>

            {{-- Approve --}}
            <form method="POST" action="{{ route('admin.custom-orders.approve', $customOrder) }}" class="mb-4 pb-4 border-b border-sand-100" onsubmit="return confirm('Yakin menyetujui custom order ini?')">
                @csrf
                <div class="mb-3">
                    <label class="block text-xs font-medium text-sand-700 mb-1">Harga yang Disepakati (Rp) <span class="text-red-500">*</span></label>
                    <input type="number" name="agreed_price" class="admin-input" required min="1000" placeholder="contoh: 5000000">
                </div>
                <div class="mb-3">
                    <label class="block text-xs font-medium text-sand-700 mb-1">Catatan untuk Pelanggan</label>
                    <textarea name="admin_notes" rows="2" class="admin-input text-xs" placeholder="Detail material, estimasi waktu, dll."></textarea>
                </div>
                <button type="submit" class="btn-admin btn-admin-success w-full text-xs justify-center">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                    Setujui & Buat Pesanan
                </button>
            </form>

            {{-- Reject --}}
            <form method="POST" action="{{ route('admin.custom-orders.reject', $customOrder) }}" onsubmit="return confirm('Yakin menolak custom order ini?')">
                @csrf
                <div class="mb-3">
                    <label class="block text-xs font-medium text-sand-700 mb-1">Alasan Penolakan <span class="text-red-500">*</span></label>
                    <textarea name="admin_notes" rows="2" class="admin-input text-xs" required placeholder="Jelaskan alasan penolakan..."></textarea>
                </div>
                <button type="submit" class="btn-admin btn-admin-danger w-full text-xs justify-center">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                    Tolak Custom Order
                </button>
            </form>
        </div>
        @endif
    </div>
</div>
@endsection
