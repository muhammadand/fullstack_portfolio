{{-- <head> bersama halaman produk digital partner (tema gelap, glass panel). Param: $title --}}
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>{{ $title }} - Harga Partner</title>
<link rel="preconnect" href="https://cdnjs.cloudflare.com" crossorigin>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
<x-affiliate.pwa-meta />
@vite(['resources/css/app.css', 'resources/js/app.js'])
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
<style>
    body { background-color: #0B1120; color: #fff; font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif; -webkit-tap-highlight-color: transparent; }
    .glass-panel { background: rgba(255,255,255,0.05); backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px); border: 1px solid rgba(255,255,255,0.1); }
    .glass-panel.is-selected { background: rgba(16,185,129,0.12); border-color: rgba(52,211,153,0.7); }
    [x-cloak] { display: none !important; }
</style>
