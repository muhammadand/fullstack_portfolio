@props(['affiliate'])

@php
$wallet = $affiliate->getOrCreateWallet();
$recentMutations = $wallet->mutations()->take(2)->get();
@endphp

<div class="glass-card rounded-3xl p-5 mb-6 relative overflow-hidden border border-emerald-500/20 bg-gradient-to-br from-emerald-950/40 via-slate-900/60 to-slate-900/90 shadow-[0_8px_32px_0_rgba(16,185,129,0.15)]">
    <!-- Decorative glow in background -->
    <div class="absolute -right-10 -bottom-10 w-36 h-36 bg-emerald-500/10 rounded-full blur-2xl pointer-events-none"></div>
    <div class="absolute -left-10 -top-10 w-28 h-28 bg-teal-500/10 rounded-full blur-xl pointer-events-none"></div>

    <!-- Header Section -->
    <div class="flex items-center justify-between relative z-10 mb-2">
        <div class="flex items-center gap-2">
            <div class="w-8 h-8 rounded-xl bg-emerald-500/20 border border-emerald-500/30 flex items-center justify-center text-emerald-400">
                <i class="fa-solid fa-wallet text-sm"></i>
            </div>
            <div>
                <span class="text-xs font-semibold text-emerald-300 tracking-wide uppercase">Saldo Wallet</span>
                <span class="inline-flex items-center ml-1 px-1.5 py-0.5 rounded-full text-[9px] font-bold bg-emerald-500/20 text-emerald-300 border border-emerald-500/30">
                    {{ strtoupper($wallet->status) }}
                </span>
            </div>
        </div>
        <button type="button" onclick="openWalletMutationsModal()" class="text-[11px] text-emerald-400 hover:text-emerald-300 font-semibold flex items-center gap-1 transition-colors">
            Mutasi <i class="fa-solid fa-chevron-right text-[9px]"></i>
        </button>
    </div>

    <!-- Balance Section -->
    <div class="relative z-10 mb-4 mt-2">
        <div class="text-3xl font-extrabold text-white tracking-tight flex items-baseline">
            <span class="text-lg text-emerald-400/80 font-semibold mr-1.5">Rp</span>
            <span id="wallet-balance-display">{{ number_format($wallet->balance, 0, ',', '.') }}</span>
        </div>
        <p class="text-[11px] text-slate-400 mt-0.5">Saldo siap pakai untuk transaksi produk digital</p>
    </div>

    <!-- Action Buttons -->
    <div class="grid grid-cols-2 gap-3 relative z-10 mt-4 pt-3 border-t border-white/10">
        <button type="button" onclick="openWalletDepositModal()" class="py-2.5 px-3 bg-gradient-to-r from-emerald-500 to-teal-500 hover:from-emerald-600 hover:to-teal-600 text-white font-bold rounded-xl shadow-lg shadow-emerald-500/25 transition-all flex items-center justify-center gap-2 text-xs active:scale-[0.98]">
            <i class="fa-solid fa-circle-plus text-sm"></i>
            <span>Top Up Saldo</span>
        </button>
        <button type="button" onclick="openWalletMutationsModal()" class="py-2.5 px-3 glass-panel hover:bg-white/10 text-white font-semibold rounded-xl border border-white/10 transition-colors flex items-center justify-center gap-2 text-xs">
            <i class="fa-solid fa-clock-rotate-left text-emerald-400 text-sm"></i>
            <span>Riwayat Mutasi</span>
        </button>
    </div>

    <!-- Mini Recent Mutations Preview (If any) -->
    @if($recentMutations->isNotEmpty())
    <div class="relative z-10 mt-3 pt-3 border-t border-white/5 space-y-1.5">
        <p class="text-[10px] text-slate-400 font-medium uppercase tracking-wider">Aktivitas Terakhir</p>
        @foreach($recentMutations as $mut)
        <div class="flex items-center justify-between text-xs py-1">
            <div class="flex items-center gap-2 truncate pr-2">
                <span class="w-5 h-5 rounded-md flex items-center justify-center text-[10px] shrink-0 {{ $mut->type === 'CREDIT' ? 'bg-emerald-500/20 text-emerald-400' : 'bg-rose-500/20 text-rose-400' }}">
                    <i class="fa-solid {{ $mut->type === 'CREDIT' ? 'fa-arrow-down-left' : 'fa-arrow-up-right' }}"></i>
                </span>
                <span class="text-slate-300 truncate text-[11px]">{{ $mut->description ?? $mut->category }}</span>
            </div>
            <span class="font-bold shrink-0 text-[11px] {{ $mut->type === 'CREDIT' ? 'text-emerald-400' : 'text-rose-400' }}">
                {{ $mut->type === 'CREDIT' ? '+' : '-' }}Rp {{ number_format($mut->amount, 0, ',', '.') }}
            </span>
        </div>
        @endforeach
    </div>
    @endif
</div>
