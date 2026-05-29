<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <style>
        body { margin: 0; padding: 0; font-family: 'Inter', Arial, sans-serif; background-color: #f5f0e8; }
        .container { max-width: 600px; margin: 0 auto; background: #fff; }
        .header { background: #6B3A2A; padding: 24px; text-align: center; }
        .header h1 { color: #f5f0e8; font-size: 24px; margin: 0; }
        .body { padding: 32px 24px; }
        .footer { background: #fafaf7; border-top: 1px solid #e5e0d8; padding: 20px 24px; text-align: center; font-size: 12px; color: #6b7280; }
        h2 { font-size: 18px; color: #1a1a1a; margin: 0 0 16px; }
        p { font-size: 14px; line-height: 1.6; color: #374151; margin: 0 0 12px; }
        .price-box { background: #f5f0e8; border: 1px solid #e5e0d8; padding: 16px; border-radius: 4px; text-align: center; margin: 16px 0; }
        .price-box .price { font-size: 24px; font-weight: bold; color: #6B3A2A; }
        .btn { display: inline-block; background: #6B3A2A; color: #fff !important; text-decoration: none; padding: 12px 24px; border-radius: 4px; font-size: 14px; font-weight: 600; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header"><h1>JAFAPP Furniture</h1></div>
        <div class="body">
            <h2>Custom Order Anda Disetujui! 🎉</h2>
            <p>Halo {{ $customOrder->user->name }},</p>
            <p>Custom order Anda telah disetujui oleh tim kami. Berikut detailnya:</p>

            <div style="background: #f9fafb; border: 1px solid #e5e7eb; padding: 12px 16px; border-radius: 4px; margin: 16px 0;">
                <p style="margin: 4px 0;"><strong>Deskripsi:</strong> {{ $customOrder->description }}</p>
                @if($customOrder->dimensions)<p style="margin: 4px 0;"><strong>Ukuran:</strong> {{ $customOrder->dimensions }}</p>@endif
                @if($customOrder->material)<p style="margin: 4px 0;"><strong>Material:</strong> {{ $customOrder->material }}</p>@endif
                @if($customOrder->finishing)<p style="margin: 4px 0;"><strong>Finishing:</strong> {{ $customOrder->finishing }}</p>@endif
            </div>

            <div class="price-box">
                <p style="font-size: 12px; color: #6b7280; margin-bottom: 4px;">Harga yang Disepakati</p>
                <span class="price">Rp {{ number_format($customOrder->agreed_price, 0, ',', '.') }}</span>
            </div>

            @if($customOrder->admin_notes)
            <p><strong>Catatan dari Admin:</strong><br>{{ $customOrder->admin_notes }}</p>
            @endif

            <p>Silakan lakukan pembayaran untuk memulai proses produksi.</p>

            <div style="text-align: center; margin: 24px 0;">
                <a href="{{ route('customer.orders') }}" class="btn">Lihat Pesanan Saya</a>
            </div>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} JAFAPP Furniture. Semua hak dilindungi.</p>
        </div>
    </div>
</body>
</html>
