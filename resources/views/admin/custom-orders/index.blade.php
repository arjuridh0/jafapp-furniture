@extends('admin.layouts.app')
@section('page-title', 'Custom Order')

@section('content')
<div class="mb-6">
    <form method="GET" class="flex items-center gap-2">
        <select name="status" class="admin-input !w-auto text-xs">
            <option value="">Semua Status</option>
            <option value="submitted" {{ request('status') === 'submitted' ? 'selected' : '' }}>Diajukan</option>
            <option value="under_review" {{ request('status') === 'under_review' ? 'selected' : '' }}>Sedang Ditinjau</option>
            <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Disetujui</option>
            <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Ditolak</option>
        </select>
        <button type="submit" class="btn-admin btn-admin-secondary text-xs">Filter</button>
        @if(request('status'))<a href="{{ route('admin.custom-orders.index') }}" class="text-xs text-red-500">Reset</a>@endif
    </form>
</div>

<div class="bg-white border border-sand-200/60 rounded-md overflow-hidden">
    <div class="overflow-x-auto">
        <table class="admin-table">
            <thead><tr><th>ID</th><th>Pelanggan</th><th>Deskripsi</th><th>Status</th><th>Harga</th><th>Tanggal</th><th></th></tr></thead>
            <tbody>
                @forelse($customOrders as $co)
                <tr>
                    <td class="font-mono text-xs font-semibold">#{{ $co->id }}</td>
                    <td>
                        <p class="font-medium text-sand-900 text-xs">{{ $co->user?->name ?? '—' }}</p>
                        <p class="text-[11px] text-sand-400">{{ $co->user?->email }}</p>
                    </td>
                    <td class="text-xs max-w-48 truncate">{{ $co->description }}</td>
                    <td>
                        @php
                            $bc = match($co->status) {
                                'submitted' => 'badge-pending',
                                'under_review' => 'badge-production',
                                'approved','converted_to_order' => 'badge-completed',
                                'rejected' => 'badge-cancelled',
                                default => 'badge-pending',
                            };
                        @endphp
                        <span class="badge {{ $bc }}">{{ $co->status_label }}</span>
                    </td>
                    <td class="font-mono text-xs">{{ $co->agreed_price ? 'Rp ' . number_format($co->agreed_price, 0, ',', '.') : '—' }}</td>
                    <td class="text-xs text-sand-500">{{ $co->created_at->format('d/m/Y') }}</td>
                    <td><a href="{{ route('admin.custom-orders.show', $co) }}" class="text-xs font-medium hover:underline text-teak-600">Detail</a></td>
                </tr>
                @empty
                <tr><td colspan="7" class="text-center text-sand-400 py-8">Tidak ada custom order.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($customOrders->hasPages())<div class="px-5 py-3 border-t border-sand-100">{{ $customOrders->links() }}</div>@endif
</div>
@endsection
