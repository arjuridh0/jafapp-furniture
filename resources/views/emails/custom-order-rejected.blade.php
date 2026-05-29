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
        .reason-box { background: #fef2f2; border: 1px solid #fecaca; padding: 16px; border-radius: 4px; margin: 16px 0; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header"><h1>JAFAPP Furniture</h1></div>
        <div class="body">
            <h2>Pembaruan Custom Order</h2>
            <p>Halo {{ $customOrder->user->name }},</p>
            <p>Mohon maaf, custom order Anda tidak dapat kami proses saat ini.</p>

            <div style="background: #f9fafb; border: 1px solid #e5e7eb; padding: 12px 16px; border-radius: 4px; margin: 16px 0;">
                <p style="margin: 4px 0;"><strong>Deskripsi:</strong> {{ $customOrder->description }}</p>
            </div>

            <div class="reason-box">
                <p style="font-size: 13px; color: #991b1b; margin: 0;"><strong>Alasan:</strong><br>{{ $customOrder->admin_notes }}</p>
            </div>

            <p>Jika Anda memiliki pertanyaan atau ingin mengajukan custom order baru dengan spesifikasi berbeda, silakan hubungi kami.</p>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} JAFAPP Furniture. Semua hak dilindungi.</p>
        </div>
    </div>
</body>
</html>
