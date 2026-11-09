{{-- Kartu saldo wallet partner + tombol isi saldo. Param: $walletBalance --}}
<div class="glass-panel rounded-2xl px-4 py-3 flex items-center justify-between gap-3">
    <div class="flex items-center gap-3 min-w-0">
        <div class="w-9 h-9 rounded-xl bg-emerald-500/10 flex items-center justify-center text-emerald-400 shrink-0"><i class="fa-solid fa-wallet"></i></div>
        <div class="min-w-0">
            <p class="text-[10px] text-slate-400">Saldo Wallet</p>
            <p class="text-sm font-bold text-white truncate" data-wallet-balance>Rp {{ number_format($walletBalance, 0, ',', '.') }}</p>
        </div>
    </div>
    <a href="{{ route('affiliate.dashboard', ['isi_saldo' => 1]) }}" class="shrink-0 px-3 py-2 rounded-xl bg-gradient-to-r from-emerald-500 to-teal-500 text-white text-[11px] font-bold active:scale-95">
        <i class="fa-solid fa-plus mr-1"></i>Isi Saldo
    </a>
</div>
