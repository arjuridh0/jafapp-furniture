@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-12">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
        <div>
            <h1 class="text-2xl font-heading font-bold text-sand-900">Custom Order Saya</h1>
            <p class="mt-1 text-sm text-sand-500">Riwayat pesanan custom yang Anda ajukan</p>
        </div>
        <a href="{{ route('custom-order.create') }}" class="inline-flex items-center gap-2 bg-teak-700 hover:bg-teak-600 text-white font-semibold py-2.5 px-5 rounded-sm text-sm transition-all duration-300">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
            Buat Custom Order Baru
        </a>
    </div>

    <div class="space-y-4">
        @forelse($customOrders as $co)
        <div class="bg-white border border-sand-200/50 rounded-sm p-5 hover:shadow-sm transition-shadow duration-300">
            <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-3">
                <div class="flex-1 min-w-0">
                    <div class="flex items-center gap-2 mb-2">
                        @php
                            $statusBadge = match($co->status) {
                                'submitted' => 'bg-amber-100 text-amber-800',
                                'under_review' => 'bg-blue-100 text-blue-800',
                                'approved' => 'bg-green-100 text-green-800',
                                'rejected' => 'bg-red-100 text-red-800',
                                'converted_to_order' => 'bg-teal-100 text-teal-800',
                                default => 'bg-sand-100 text-sand-800',
                            };
                        @endphp
                        <span class="inline-flex items-center px-2 py-0.5 rounded-sm text-[10px] font-bold uppercase tracking-wider {{ $statusBadge }}">
                            {{ $co->status_label }}
                        </span>
                        <span class="text-xs text-sand-400">{{ $co->created_at->format('d M Y') }}</span>
                    </div>
                    <p class="text-sm text-sand-800 line-clamp-2">{{ $co->description }}</p>
                    <div class="flex flex-wrap gap-3 mt-2 text-xs text-sand-500">
                        <span>📐 {{ $co->dimensions }}</span>
                        <span>🪵 {{ ucfirst($co->material) }}</span>
                        <span>✨ {{ ucfirst($co->finishing) }}</span>
                    </div>
                </div>
                <div class="text-right shrink-0">
                    @if($co->agreed_price)
                        <p class="text-xs text-sand-500">Harga Disepakati</p>
                        <p class="text-lg font-bold text-teak-700">Rp {{ number_format($co->agreed_price, 0, ',', '.') }}</p>
                    @endif
                </div>
            </div>

            @if($co->admin_notes)
            <div class="mt-3 pt-3 border-t border-sand-100">
                <p class="text-xs text-sand-500 font-medium mb-1">Catatan Admin:</p>
                <p class="text-sm text-sand-700">{{ $co->admin_notes }}</p>
            </div>
            @endif
        </div>
        @empty
        <div class="text-center py-16">
            <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-sand-100 flex items-center justify-center">
                <svg class="w-8 h-8 text-sand-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
            </div>
            <p class="text-sand-500 mb-3">Belum ada custom order.</p>
            <a href="{{ route('custom-order.create') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-teak-700 hover:text-teak-600">
                Buat Custom Order Pertama →
            </a>
        </div>
        @endforelse
    </div>

    @if($customOrders->hasPages())
    <div class="mt-8">
        {{ $customOrders->links() }}
    </div>
    @endif
</div>
@endsection
