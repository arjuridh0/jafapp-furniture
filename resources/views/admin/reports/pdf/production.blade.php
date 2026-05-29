<!DOCTYPE html>
<html><head>
<meta charset="UTF-8">
<style>
    body { font-family: Arial, sans-serif; font-size: 11px; color: #333; }
    h1 { font-size: 18px; color: #6B3A2A; margin-bottom: 5px; }
    .meta { font-size: 10px; color: #666; margin-bottom: 15px; }
    table { width: 100%; border-collapse: collapse; margin-top: 10px; }
    th { background: #6B3A2A; color: #fff; padding: 6px 8px; text-align: left; font-size: 10px; text-transform: uppercase; }
    td { padding: 5px 8px; border-bottom: 1px solid #e5e0d8; font-size: 10px; }
    tr:nth-child(even) { background: #fafaf7; }
    .footer { margin-top: 20px; font-size: 9px; color: #999; text-align: center; border-top: 1px solid #e5e0d8; padding-top: 10px; }
</style>
</head><body>
    <h1>Laporan Produksi — JAFAPP Furniture</h1>
    <p class="meta">Periode: {{ $dateFrom }} s/d {{ $dateTo }} &bull; Dicetak: {{ now()->format('d/m/Y H:i') }}</p>

    <table>
        <thead><tr><th>No. Pesanan</th><th>Pelanggan</th><th>Tipe</th><th>Status Saat Ini</th><th>Tanggal Order</th><th>Jumlah Update</th></tr></thead>
        <tbody>
            @foreach($orders as $order)
            <tr>
                <td>{{ $order->order_number }}</td>
                <td>{{ $order->guest_name }}</td>
                <td>{{ $order->type === 'custom' ? 'Custom' : 'Reguler' }}</td>
                <td>{{ $order->status_label }}</td>
                <td>{{ $order->created_at->format('d/m/Y') }}</td>
                <td>{{ $order->productionLogs->count() }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">&copy; {{ date('Y') }} JAFAPP Furniture — Laporan ini digenerate secara otomatis</div>
</body></html>
