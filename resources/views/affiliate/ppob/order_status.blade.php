<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @if($order->status === \App\Models\Order::STATUS_PROCESSING)
        {{-- Muat ulang otomatis sampai hasil dari supplier masuk. --}}
        <meta http-equiv="refresh" content="5">
    @endif
    <title>Order {{ $order->order_no }} - Partner Hub</title>
    <link rel="preconnect" href="https://cdnjs.cloudflare.com" crossorigin>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <x-affiliate.pwa-meta />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            background-color: #0B1120;
            color: #ffffff;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
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
<body class="pb-28 overflow-x-hidden min-h-screen relative">
    <div class="relative z-10 w-full max-w-md mx-auto px-4 pt-5">

        <!-- Header -->
        <div class="flex items-center gap-3 mb-5">
            <a href="{{ route('affiliate.ppob.pulsa') }}" class="w-10 h-10 rounded-xl glass-panel flex items-center justify-center text-slate-300 hover:text-white transition-colors active:scale-95" title="Kembali">
                <i class="fa-solid fa-arrow-left text-sm"></i>
            </a>
            <div class="min-w-0">
                <h1 class="text-base font-bold text-white leading-tight">Status Pesanan</h1>
                <p class="text-xs text-slate-400 font-mono truncate">{{ $order->order_no }}</p>
            </div>
        </div>

        <!-- Kartu Status -->
        <div class="glass-panel rounded-3xl p-6 text-center mb-4" data-order-status="{{ $order->status }}">
            @if($order->status === \App\Models\Order::STATUS_SUCCESS)
                <div class="w-16 h-16 mx-auto rounded-full bg-emerald-500/15 flex items-center justify-center text-emerald-400 text-3xl mb-3"><i class="fa-solid fa-circle-check"></i></div>
                <h2 class="text-lg font-bold text-white">{{ $order->sourceLabel() }} Berhasil</h2>
                <p class="text-xs text-slate-400 mt-1">Pulsa sudah masuk ke nomor tujuan.</p>
            @elseif($order->status === \App\Models\Order::STATUS_FAILED)
                <div class="w-16 h-16 mx-auto rounded-full bg-red-500/15 flex items-center justify-center text-red-400 text-3xl mb-3"><i class="fa-solid fa-circle-xmark"></i></div>
                <h2 class="text-lg font-bold text-white">{{ $order->sourceLabel() }} Gagal</h2>
                @if($order->refunded_at)
                    <p class="text-xs text-emerald-300 mt-1"><i class="fa-solid fa-rotate-left mr-1"></i>Saldo Rp {{ number_format($order->total_amount, 0, ',', '.') }} sudah dikembalikan ke wallet.</p>
                @else
                    <p class="text-xs text-amber-300 mt-1">Saldo sedang diproses untuk dikembalikan. Hubungi admin bila belum masuk.</p>
                @endif
            @else
                <div class="w-16 h-16 mx-auto rounded-full bg-blue-500/15 flex items-center justify-center text-blue-400 text-3xl mb-3"><i class="fa-solid fa-spinner fa-spin"></i></div>
                <h2 class="text-lg font-bold text-white">Sedang Diproses</h2>
                <p class="text-xs text-slate-400 mt-1">Biasanya selesai dalam beberapa detik. Halaman ini akan diperbarui otomatis.</p>
            @endif
        </div>

        <!-- Detail -->
        <div class="glass-panel rounded-2xl p-4 space-y-2.5 text-xs mb-4">
            <div class="flex justify-between gap-3"><span class="text-slate-400">Produk</span><span class="text-white font-semibold text-right">{{ $order->product_name }}</span></div>
            <div class="flex justify-between gap-3"><span class="text-slate-400">Nomor Tujuan</span><span class="text-white font-mono">{{ $order->customer_no }}</span></div>
            <div class="flex justify-between gap-3"><span class="text-slate-400">Metode Bayar</span><span class="text-white">Saldo Wallet</span></div>
            <div class="flex justify-between gap-3"><span class="text-slate-400">Waktu</span><span class="text-white">{{ $order->created_at->timezone('Asia/Jakarta')->format('d M Y, H:i') }} WIB</span></div>
            @if($order->sn)
                <div class="flex justify-between gap-3"><span class="text-slate-400">SN / Ref</span><span class="text-white font-mono break-all text-right">{{ $order->sn }}</span></div>
            @endif
            <div class="flex justify-between gap-3 pt-2.5 border-t border-white/5"><span class="text-slate-300 font-semibold">Total</span><span class="text-emerald-400 font-bold">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span></div>
        </div>

        <!-- Riwayat -->
        @if($events->isNotEmpty())
            <div class="glass-panel rounded-2xl p-4 mb-5">
                <h3 class="text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-3">Riwayat</h3>
                <ol class="space-y-3">
                    @foreach($events as $event)
                        <li class="flex gap-3 text-xs" data-event="{{ $event->event }}">
                            <span class="mt-1 w-2 h-2 rounded-full shrink-0 {{ $event->event === 'wallet.refunded' ? 'bg-emerald-400' : ($event->status_to === 'failed' ? 'bg-red-400' : 'bg-blue-400') }}"></span>
                            <div class="flex-1 min-w-0">
                                <p class="text-slate-200">
                                    @switch($event->event)
                                        @case('order.created') Pesanan dibuat @break
                                        @case('wallet.debited') Saldo dipotong Rp {{ number_format($event->amount, 0, ',', '.') }} @break
                                        @case('provider.sent') Dikirim ke supplier @break
                                        @case('provider.result') {{ $event->status_to === 'success' ? 'Berhasil dikirim' : ($event->status_to === 'failed' ? 'Gagal dari supplier' : 'Menunggu supplier') }} @break
                                        @case('wallet.refunded') Saldo dikembalikan Rp {{ number_format($event->amount, 0, ',', '.') }} @break
                                    @endswitch
                                </p>
                                <p class="text-[10px] text-slate-500">{{ $event->created_at->timezone('Asia/Jakarta')->format('d M Y, H:i:s') }}</p>
                            </div>
                        </li>
                    @endforeach
                </ol>
            </div>
        @endif

        <div class="grid grid-cols-2 gap-3">
            <a href="{{ route('affiliate.dashboard') }}" class="py-3 rounded-2xl glass-panel text-center text-sm font-semibold text-slate-200 active:scale-[0.98]">Beranda</a>
            <a href="{{ route('affiliate.ppob.pulsa') }}" class="py-3 rounded-2xl bg-gradient-to-r from-emerald-500 to-teal-500 text-center text-sm font-bold text-white active:scale-[0.98]">Beli Lagi</a>
        </div>
    </div>

    <x-affiliate.bottom-nav />
</body>
</html>
