<?php

declare(strict_types=1);

namespace App\Exports;

use App\Models\Order;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;

class SalesReportExport implements FromCollection, WithHeadings, WithMapping, WithTitle, ShouldAutoSize
{
    public function __construct(
        private string $dateFrom,
        private string $dateTo,
    ) {}

    public function collection()
    {
        return Order::with('payment')
            ->whereDate('created_at', '>=', $this->dateFrom)
            ->whereDate('created_at', '<=', $this->dateTo)
            ->where('status', '!=', Order::STATUS_CANCELLED)
            ->latest()
            ->get();
    }

    public function headings(): array
    {
        return [
            'No. Pesanan',
            'Tanggal',
            'Pelanggan',
            'Email',
            'Tipe',
            'Status',
            'Metode Bayar',
            'Subtotal',
            'Ongkir',
            'Total',
            'Status Pembayaran',
        ];
    }

    public function map($order): array
    {
        return [
            $order->order_number,
            $order->created_at->format('d/m/Y H:i'),
            $order->guest_name,
            $order->guest_email,
            $order->type === 'custom' ? 'Custom' : 'Reguler',
            $order->status_label,
            $order->payment?->payment_type ?? '-',
            $order->subtotal,
            $order->shipping_cost,
            $order->total_amount,
            $order->payment?->status_label ?? '-',
        ];
    }

    public function title(): string
    {
        return 'Laporan Penjualan';
    }
}
