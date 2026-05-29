<!DOCTYPE html>
<html><head>
<meta charset="UTF-8">
<style>
    body { font-family: Arial, sans-serif; font-size: 11px; color: #333; }
    h1 { font-size: 18px; color: #6B3A2A; margin-bottom: 5px; }
    .meta { font-size: 10px; color: #666; margin-bottom: 15px; }
    .summary { margin-bottom: 15px; padding: 10px; background: #f5f0e8; border-radius: 4px; }
    .summary span { font-size: 14px; font-weight: bold; color: #6B3A2A; }
    table { width: 100%; border-collapse: collapse; margin-top: 10px; }
    th { background: #6B3A2A; color: #fff; padding: 6px 8px; text-align: left; font-size: 10px; text-transform: uppercase; }
    td { padding: 5px 8px; border-bottom: 1px solid #e5e0d8; font-size: 10px; }
    tr:nth-child(even) { background: #fafaf7; }
    .text-right { text-align: right; }
    .footer { margin-top: 20px; font-size: 9px; color: #999; text-align: center; border-top: 1px solid #e5e0d8; padding-top: 10px; }
</style>
</head><body>
    <h1>Laporan Penjualan — JAFAPP Furniture</h1>
    <p class="meta">Periode: {{ $dateFrom }} s/d {{ $dateTo }} &bull; Dicetak: {{ now()->format('d/m/Y H:i') }}</p>

    <div class="summary">
        Total Pendapatan: <span>Rp {{ number_format($totalRevenue, 0, ',', '.') }}</span> &bull;
        Jumlah Pesanan: <span>{{ $orders->count() }}</span>
    </div>

    <table>
        <thead><tr><th>No. Pesanan</th><th>Tanggal</th><th>Pelanggan</th><th>Tipe</th><th>Status</th><th>Metode</th><th class="text-right">Total</th></tr></thead>
        <tbody>
            @foreach($orders as $order)
            <tr>
                <td>{{ $order->order_number }}</td>
                <td>{{ $order->created_at->format('d/m/Y') }}</td>
                <td>{{ $order->guest_name }}</td>
                <td>{{ $order->type === 'custom' ? 'Custom' : 'Reguler' }}</td>
                <td>{{ $order->status_label }}</td>
                <td>{{ $order->payment?->payment_type ? ucfirst(str_replace('_',' ',$order->payment->payment_type)) : '—' }}</td>
                <td class="text-right">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">&copy; {{ date('Y') }} JAFAPP Furniture — Laporan ini digenerate secara otomatis</div>
</body></html>
