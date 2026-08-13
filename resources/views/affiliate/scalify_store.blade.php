<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Scalify Store - Coming Soon</title>
    <x-affiliate.pwa-meta />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            background-color: #0B1120;
            color: #ffffff;
            font-family: 'Inter', sans-serif;
            -webkit-tap-highlight-color: transparent;
        }

        .glass-panel {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

    </style>
</head>
<body class="pb-10 overflow-x-hidden min-h-screen relative flex flex-col">
    <!-- Header -->
    <div class="fixed top-0 left-0 w-full z-50 glass-panel border-b border-white/10 px-5 py-4 flex items-center gap-4">
        <a href="{{ route('affiliate.streak') }}" class="w-10 h-10 rounded-full bg-slate-800/80 flex items-center justify-center text-slate-300 hover:text-white transition-colors">
            <i class="fa-solid fa-arrow-left"></i>
        </a>
        <h1 class="text-lg font-bold text-white">Scalify Store</h1>
    </div>

    <div class="pt-24 px-5 pb-6 flex-1 flex flex-col items-center justify-center">

        <div class="w-24 h-24 rounded-full bg-blue-500/20 flex items-center justify-center mb-6 relative">
            <div class="absolute inset-0 rounded-full bg-blue-500/20 animate-ping opacity-75"></div>
            <i class="fa-solid fa-store text-blue-400 text-4xl relative z-10"></i>
        </div>

        <h2 class="text-2xl font-bold text-white mb-2 text-center">Coming Soon!</h2>
        <p class="text-sm text-slate-400 text-center leading-relaxed mb-8 max-w-xs">
            Kami sedang menyiapkan berbagai hadiah menarik untuk Anda. Tukarkan Poin Api Streak Anda dengan hadiah-hadiah eksklusif di sini nantinya!
        </p>

        <div class="glass-panel p-5 rounded-2xl border-blue-500/20 bg-blue-500/5 w-full max-w-sm">
            <h4 class="text-xs font-bold text-blue-400 mb-4 text-center uppercase tracking-wider">Bocoran Hadiah Mendatang</h4>
            <div class="space-y-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-slate-800 flex items-center justify-center shrink-0 border border-emerald-500/20 shadow-[0_0_10px_rgba(16,185,129,0.2)]">
                        <i class="fa-solid fa-wallet text-emerald-400 text-sm"></i>
                    </div>
                    <div class="flex-1">
                        <span class="text-xs text-slate-200 font-bold block mb-0.5">Saldo E-Wallet</span>
                        <span class="text-[10px] text-slate-400">DANA, GoPay, OVO (Mulai 10.000 Poin)</span>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-slate-800 flex items-center justify-center shrink-0 border border-orange-500/20 shadow-[0_0_10px_rgba(249,115,22,0.2)]">
                        <i class="fa-solid fa-burger text-orange-400 text-sm"></i>
                    </div>
                    <div class="flex-1">
                        <span class="text-xs text-slate-200 font-bold block mb-0.5">Voucher Makanan</span>
                        <span class="text-[10px] text-slate-400">GoFood, GrabFood & Resto Pilihan</span>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-slate-800 flex items-center justify-center shrink-0 border border-purple-500/20 shadow-[0_0_10px_rgba(168,85,247,0.2)]">
                        <i class="fa-solid fa-shirt text-purple-400 text-sm"></i>
                    </div>
                    <div class="flex-1">
                        <span class="text-xs text-slate-200 font-bold block mb-0.5">Fashion & Merchandise</span>
                        <span class="text-[10px] text-slate-400">T-Shirt Eksklusif, Kemeja & Pakaian Wanita</span>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-slate-800 flex items-center justify-center shrink-0 border border-pink-500/20 shadow-[0_0_10px_rgba(236,72,153,0.2)]">
                        <i class="fa-solid fa-ticket text-pink-400 text-sm"></i>
                    </div>
                    <div class="flex-1">
                        <span class="text-xs text-slate-200 font-bold block mb-0.5">Diskon Spesial</span>
                        <span class="text-[10px] text-slate-400">Voucher Diskon Layanan Scalify</span>
                    </div>
                </div>
            </div>
        </div>

    </div>
</body>
</html>
