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
        .credentials { background-color: #f5f0e8; border: 1px solid #e5e0d8; padding: 16px; border-radius: 4px; margin: 16px 0; }
        .credentials p { margin: 4px 0; }
        .btn { display: inline-block; background-color: #6B3A2A; color: #ffffff !important; text-decoration: none; padding: 12px 24px; border-radius: 4px; font-size: 14px; font-weight: 600; }
        .warning { background-color: #fef3c7; border: 1px solid #fcd34d; padding: 12px 16px; border-radius: 4px; margin: 16px 0; }
        .warning p { color: #92400e; font-size: 13px; margin: 0; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>JAFAPP Furniture</h1>
        </div>
        <div class="body">
            <h2>Akun Anda Telah Dibuat</h2>
            <p>Halo {{ $user->name }},</p>
            <p>Kami telah membuat akun untuk Anda secara otomatis saat checkout. Berikut detail akun Anda:</p>

            <div class="credentials">
                <p><strong>Email:</strong> {{ $user->email }}</p>
                <p><strong>Password Sementara:</strong> {{ $tempPassword }}</p>
            </div>

            <div class="warning">
                <p>⚠️ Segera aktivasi akun dan ubah password Anda untuk keamanan.</p>
            </div>

            <p>Klik tombol di bawah untuk mengaktifkan akun dan membuat password baru:</p>

            <div style="text-align: center; margin: 24px 0;">
                <a href="{{ $activationUrl }}" class="btn">Aktivasi Akun</a>
            </div>

            <p style="font-size: 12px; color: #6b7280;">Link aktivasi berlaku selama 7 hari.</p>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} JAFAPP Furniture. Semua hak dilindungi.</p>
            <p>Email ini dikirim secara otomatis. Jangan membalas email ini.</p>
        </div>
    </div>
</body>
</html>
