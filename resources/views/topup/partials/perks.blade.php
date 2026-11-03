<section class="bg-brand-dark px-4 sm:px-6 lg:px-8 pb-12 sm:pb-16">
    <div class="max-w-6xl mx-auto grid grid-cols-1 sm:grid-cols-3 gap-3">
        @foreach([
            ['fa-bolt', 'text-amber-400 bg-amber-500/10', 'Proses Instan', 'Pesanan diproses otomatis, tanpa menunggu admin.'],
            ['fa-qrcode', 'text-cyan-400 bg-cyan-500/10', 'Bayar via QRIS', 'Satu QR untuk semua e-wallet dan m-banking.'],
            ['fa-shield-halved', 'text-emerald-400 bg-emerald-500/10', 'Aman & Terpercaya', 'Harga transparan, riwayat transaksi tercatat.'],
        ] as [$icon, $color, $title, $desc])
        <div class="flex items-start gap-3 p-4 rounded-2xl bg-white/[0.04] border border-white/10 backdrop-blur-md">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center shrink-0 {{ $color }}">
                <i class="fa-solid {{ $icon }}"></i>
            </div>
            <div>
                <h3 class="text-sm font-bold text-white">{{ $title }}</h3>
                <p class="text-xs text-white/55 mt-0.5 leading-relaxed">{{ $desc }}</p>
            </div>
        </div>
        @endforeach
    </div>
</section>
