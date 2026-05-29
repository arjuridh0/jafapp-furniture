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
        .order-box { background-color: #f5f0e8; border: 1px solid #e5e0d8; padding: 16px; border-radius: 4px; margin: 16px 0; }
        .order-box p { margin: 6px 0; font-size: 14px; }
        .btn { display: inline-block; background-color: #6B3A2A; color: #ffffff !important; text-decoration: none; padding: 12px 24px; border-radius: 4px; font-size: 14px; font-weight: 600; }
        .status-badge { display: inline-block; padding: 4px 8px; background-color: #fef3c7; color: #92400e; font-size: 12px; font-weight: bold; border-radius: 2px; text-transform: uppercase; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>JAFAPP Furniture</h1>
        </div>
        <div class="body">
            <h2>Pengajuan Custom Order Berhasil! 🎉</h2>
            <p>Halo {{ $customOrder->user->name }},</p>
            <p>Terima kasih telah mengajukan pesanan kustom di JAFAPP Furniture. Pengajuan Anda telah kami terima dengan nomor referensi:</p>

            <div class="order-box">
                <p><strong>Nomor Referensi:</strong> Custom Order #{{ $customOrder->id }}</p>
                <p><strong>Status:</strong> <span class="status-badge">{{ $customOrder->status_label }}</span></p>
                <p><strong>Tanggal Pengajuan:</strong> {{ $customOrder->created_at->format('d M Y') }}</p>
            </div>

            <h3>Rincian Kustomisasi Mebel:</h3>
            <div style="background-color: #fafaf7; border: 1px solid #e5e0d8; padding: 16px; border-radius: 4px; margin: 16px 0;">
                <p><strong>Deskripsi:</strong><br>{{ $customOrder->description }}</p>
                <p><strong>Ukuran / Dimensi:</strong> {{ $customOrder->dimensions }}</p>
                <p><strong>Jenis Kayu (Material):</strong> {{ ucfirst($customOrder->material) }}</p>
                <p><strong>Finishing:</strong> {{ ucfirst($customOrder->finishing) }}</p>
                @if($customOrder->color)
                    <p><strong>Warna:</strong> {{ $customOrder->color }}</p>
                @endif
            </div>

            @if($customOrder->user->is_guest && !$customOrder->user->email_verified_at)
            <div style="background-color: #fef3c7; border: 1px solid #fcd34d; padding: 12px 16px; border-radius: 4px; margin: 16px 0;">
                <p style="color: #92400e; font-size: 13px; margin: 0;">
                    ⚠️ Akun Anda telah dibuat secara otomatis. Mohon periksa email Anda yang lain untuk mendapatkan tautan aktivasi akun agar kami dapat memproses pesanan kustom ini.
                </p>
            </div>
            @endif

            <p>Tim pengrajin kami akan meninjau desain, bahan, serta dimensi mebel Anda untuk memberikan penawaran harga terbaik. Kami akan menghubungi Anda kembali dalam waktu 1-2 hari kerja.</p>
            
            <p>Anda dapat memantau status peninjauan dan menyetujui penawaran harga melalui tautan di bawah ini:</p>

            <div style="text-align: center; margin: 24px 0;">
                <a href="{{ route('customer.custom-orders') }}" class="btn">Pantau Status Custom Order</a>
            </div>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} JAFAPP Furniture. Semua hak dilindungi.</p>
            <p>Email ini dikirim secara otomatis. Jangan membalas email ini.</p>
        </div>
    </div>
</body>
</html>
