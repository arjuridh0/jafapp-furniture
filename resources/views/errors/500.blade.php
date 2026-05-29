<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>500 — Terjadi Kesalahan | Jati Akbar</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">
    <script>tailwind.config = { theme: { extend: { fontFamily: { heading: ['Playfair Display', 'serif'], body: ['Inter', 'sans-serif'] }, colors: { teak: { 50: '#F5F0E8', 700: '#6B3A2A' }, sand: { 400: '#9CA3AF', 500: '#6B7280', 900: '#1A1A1A' } } } } }</script>
</head>
<body class="min-h-screen flex flex-col items-center justify-center bg-teak-50 font-body px-4">
    <div class="text-center max-w-md">
        <a href="/" class="inline-block mb-10">
            <span class="font-heading font-bold text-2xl text-sand-900">Jati</span>
            <span class="font-heading font-bold text-2xl text-teak-700">Akbar</span>
        </a>
        <p class="text-[120px] sm:text-[160px] font-heading font-bold text-teak-700/10 leading-none select-none">500</p>
        <h1 class="text-2xl font-heading font-bold text-sand-900 -mt-6">Terjadi Kesalahan</h1>
        <p class="mt-3 text-sand-500 text-sm leading-relaxed">Maaf, terjadi kesalahan pada server kami. Tim teknis sudah diberitahu dan sedang menangani masalah ini.</p>
        <div class="mt-8 flex flex-wrap items-center justify-center gap-3">
            <button onclick="window.location.reload()" class="inline-flex items-center gap-2 bg-teak-700 text-white font-semibold py-3 px-6 rounded-sm text-sm hover:bg-teak-700/90 transition-colors cursor-pointer">
                ↻ Coba Lagi
            </button>
            <a href="/" class="inline-flex items-center gap-2 border border-teak-700/20 text-teak-700 font-semibold py-3 px-6 rounded-sm text-sm hover:bg-teak-700/5 transition-colors">
                Ke Beranda
            </a>
        </div>
    </div>
</body>
</html>
