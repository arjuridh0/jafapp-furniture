<?php

declare(strict_types=1);

namespace App\Exports;

use App\Models\Order;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;

class ProductionReportExport implements FromCollection, WithHeadings, WithMapping, WithTitle, ShouldAutoSize
{
    public function __construct(
        private string $dateFrom,
        private string $dateTo,
    ) {}

    public function collection()
    {
        return Order::with('productionLogs')
            ->whereIn('status', array_merge(Order::PRODUCTION_STATUS_SEQUENCE, ['completed']))
            ->latest()
            ->get();
    }

    public function headings(): array
    {
        return [
            'No. Pesanan',
            'Pelanggan',
            'Tipe',
            'Status Saat Ini',
            'Tanggal Order',
            'Update Terakhir',
            'Jumlah Update',
        ];
    }

    public function map($order): array
    {
        $lastLog = $order->productionLogs->last();

        return [
            $order->order_number,
            $order->guest_name,
            $order->type === 'custom' ? 'Custom' : 'Reguler',
            $order->status_label,
            $order->created_at->format('d/m/Y'),
            $lastLog?->created_at?->format('d/m/Y H:i') ?? '-',
            $order->productionLogs->count(),
        ];
    }

    public function title(): string
    {
        return 'Laporan Produksi';
    }
}
