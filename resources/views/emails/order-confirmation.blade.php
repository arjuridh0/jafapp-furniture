<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body { margin: 0; padding: 0; font-family: 'Inter', Arial, sans-serif; background-color: #f5f0e8; color: #1a1a1a; }
        .container { max-width: 600px; margin: 0 auto; background-color: #ffffff; }
        .header { background-color: #6B3A2A; padding: 24px; text-align: center; }
        .header h1 { color: #f5f0e8; font-size: 24px; margin: 0; font-family: 'Playfair Display', Georgia, serif; }
        .body { padding: 32px 24px; }
        .footer { background-color: #fafaf7; border-top: 1px solid #e5e0d8; padding: 20px 24px; text-align: center; font-size: 12px; color: #6b7280; }
        h2 { font-family: 'Playfair Display', Georgia, serif; font-size: 18px; color: #1a1a1a; margin: 0 0 16px; }
        p { font-size: 14px; line-height: 1.6; color: #374151; margin: 0 0 12px; }
        .order-number { background-color: #f5f0e8; border: 1px solid #e5e0d8; padding: 12px 16px; border-radius: 4px; text-align: center; margin: 16px 0; }
        .order-number span { font-family: monospace; font-weight: bold; font-size: 18px; color: #6B3A2A; }
        table { width: 100%; border-collapse: collapse; margin: 16px 0; }
        th { text-align: left; font-size: 12px; color: #6b7280; padding: 8px 0; border-bottom: 1px solid #e5e0d8; text-transform: uppercase; letter-spacing: 0.05em; }
        td { padding: 10px 0; font-size: 14px; border-bottom: 1px solid #f3f4f6; }
        .total-row td { font-weight: bold; border-top: 2px solid #e5e0d8; border-bottom: none; padding-top: 12px; }
        .btn { display: inline-block; background-color: #6B3A2A; color: #ffffff !important; text-decoration: none; padding: 12px 24px; border-radius: 4px; font-size: 14px; font-weight: 600; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>JAFAPP Furniture</h1>
        </div>
        <div class="body">
            <h2>Konfirmasi Pesanan</h2>
            <p>Halo {{ $order->guest_name }},</p>
            <p>Terima kasih atas pesanan Anda! Berikut detail pesanan Anda:</p>

            <div class="order-number">
                <p style="font-size: 12px; color: #6b7280; margin-bottom: 4px;">Nomor Pesanan</p>
                <span>{{ $order->order_number }}</span>
            </div>

            <table>
                <thead>
                    <tr>
                        <th>Produk</th>
                        <th style="text-align: center;">Qty</th>
                        <th style="text-align: right;">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->orderItems as $item)
                    <tr>
                        <td>{{ $item->product?->name ?? 'Produk' }}</td>
                        <td style="text-align: center;">{{ $item->qty }}</td>
                        <td style="text-align: right;">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                    <tr class="total-row">
                        <td colspan="2">Total</td>
                        <td style="text-align: right; color: #6B3A2A;">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                    </tr>
                </tbody>
            </table>

            <p><strong>Alamat Pengiriman:</strong><br>{{ $order->shipping_address }}</p>

            @if($order->notes)
            <p><strong>Catatan:</strong><br>{{ $order->notes }}</p>
            @endif

            <p style="margin-top: 24px;">Silakan selesaikan pembayaran untuk memproses pesanan Anda.</p>

            <div style="text-align: center; margin: 24px 0;">
                <a href="{{ route('tracking.index') }}" class="btn">Lacak Pesanan</a>
            </div>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} JAFAPP Furniture. Semua hak dilindungi.</p>
            <p>Email ini dikirim secara otomatis. Jangan membalas email ini.</p>
        </div>
    </div>
</body>
</html>
