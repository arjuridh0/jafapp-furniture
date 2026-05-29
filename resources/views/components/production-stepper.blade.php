@props(['currentStatus', 'productionLogs'])

@php
    $sequence = \App\Models\Order::PRODUCTION_STATUS_SEQUENCE;
    $currentIndex = array_search($currentStatus, $sequence);
    if ($currentIndex === false && $currentStatus === 'completed') {
        $currentIndex = count($sequence) - 1;
    } elseif ($currentIndex === false) {
        $currentIndex = -1; // If not started or cancelled
    }
    
    $logsByStatus = collect($productionLogs)->keyBy('status');
    
    $labels = [
        'order_received' => 'Pesanan Diterima',
        'material_preparation' => 'Persiapan Material',
        'in_production' => 'Proses Produksi',
        'finishing' => 'Finishing',
        'quality_check' => 'Quality Check',
        'ready_to_ship' => 'Siap Kirim',
        'completed' => 'Selesai',
    ];
@endphp

<div class="relative">
    <div class="absolute inset-0 left-6 ml-px h-full w-0.5 bg-sand-200" aria-hidden="true"></div>
    <ul role="list" class="space-y-8">
        @foreach($sequence as $index => $stepStatus)
            @php
                $isCompleted = $index < $currentIndex || ($index === $currentIndex && $stepStatus === 'completed');
                $isActive = $index === $currentIndex && $stepStatus !== 'completed';
                $log = $logsByStatus->get($stepStatus);
            @endphp
            <li class="relative">
                <div class="flex items-start">
                    <div class="relative flex items-center justify-center flex-shrink-0 w-12 h-12">
                        @if($isCompleted)
                            <span class="flex items-center justify-center w-10 h-10 rounded-full bg-forest-700 ring-8 ring-white z-10">
                                <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                            </span>
                        @elseif($isActive)
                            <span class="flex items-center justify-center w-10 h-10 rounded-full bg-teak-700 ring-8 ring-white z-10 animate-pulse">
                                <span class="w-3 h-3 bg-white rounded-full"></span>
                            </span>
                        @else
                            <span class="flex items-center justify-center w-10 h-10 rounded-full bg-sand-200 ring-8 ring-white z-10">
                            </span>
                        @endif
                    </div>
                    <div class="ml-4 min-w-0 flex-1 pt-1.5">
                        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center">
                            <h4 class="text-base font-semibold {{ $isCompleted || $isActive ? 'text-sand-900' : 'text-sand-400' }}">
                                {{ $labels[$stepStatus] ?? ucfirst(str_replace('_', ' ', $stepStatus)) }}
                            </h4>
                            @if($log && $log->created_at)
                                <p class="text-sm text-sand-500 mt-1 sm:mt-0">
                                    {{ $log->created_at->format('d M Y, H:i') }}
                                </p>
                            @endif
                        </div>
                        
                        @if($log && $log->notes)
                            <div class="mt-2 text-sm text-sand-600 bg-sand-50 rounded-md p-3 border border-sand-100">
                                {{ $log->notes }}
                            </div>
                        @endif
                        
                        @if($log && $log->photo)
                            <div class="mt-3">
                                <img src="{{ asset('storage/' . $log->photo) }}" alt="Progress {{ $labels[$stepStatus] }}" class="h-32 w-auto object-cover rounded-md border border-sand-200">
                            </div>
                        @endif
                    </div>
                </div>
            </li>
        @endforeach
    </ul>
</div>
