@props(['affiliate'])

@php
$wallet = $affiliate->getOrCreateWallet();
@endphp

<!-- UNIFIED DUAL-FINANCE HUB CARD (KOMISI & WALLET PPOB) -->
<div class="glass-card rounded-3xl p-4 mb-4 relative overflow-hidden border border-white/10 shadow-xl bg-gradient-to-br from-slate-900/90 via-[#0E172A]/90 to-slate-900/95">
    <!-- Ambient Glow Circles -->
    <div class="absolute -left-10 -top-10 w-32 h-32 bg-blue-500/10 rounded-full blur-2xl pointer-events-none"></div>
    <div class="absolute -right-10 -bottom-10 w-32 h-32 bg-emerald-500/10 rounded-full blur-2xl pointer-events-none"></div>

    <!-- Header Card -->
    <div class="flex items-center justify-between pb-3 mb-3 border-b border-white/10 relative z-10">
        <div class="flex items-center gap-2">
            <span class="w-6 h-6 rounded-lg bg-blue-500/20 text-blue-400 flex items-center justify-center text-xs">
                <i class="fa-solid fa-vault"></i>
            </span>
            <span class="text-xs font-bold text-white tracking-wide">Keuangan & Saldo Partner</span>
        </div>
        <button type="button" onclick="openWalletMutationsModal()" class="text-[10px] text-slate-400 hover:text-white flex items-center gap-1 transition-colors">
            <span>Riwayat</span>
            <i class="fa-solid fa-chevron-right text-[8px]"></i>
        </button>
    </div>

    <div class="grid grid-cols-2 gap-3 relative z-10">

        <div class="flex flex-col justify-between pr-2 border-r border-white/10">
            <div>
                <p class="text-[11px] text-blue-200/70 font-semibold flex items-center gap-1.5 mb-0.5">
                    <i class="fa-solid fa-coins text-blue-400 text-xs"></i>
                    <span>Saldo Komisi</span>
                </p>
                <div class="text-xl sm:text-2xl font-black text-white tracking-tight my-1 truncate">
                    <span class="text-xs text-blue-300/80 font-bold mr-0.5">Rp</span>{{ number_format($affiliate->balance, 0, ',', '.') }}
                </div>
            </div>

            <!-- Action Buttons Komisi -->
            <div class="grid grid-cols-2 gap-1.5 mt-2">
                @if($affiliate->balance < 50000) <button type="button" onclick="alert('Maaf, saldo komisi Anda minimal Rp 50.000 untuk dapat melakukan penarikan.')" class="py-2 px-1.5 bg-white/5 hover:bg-white/10 text-slate-300 text-[10px] font-bold rounded-xl transition-all flex items-center justify-center gap-1 text-center" title="Minimal Rp 50.000">
                    <i class="fa-solid fa-money-bill-transfer text-xs"></i>
                    <span>Tarik</span>
                    </button>
                    @else
                    <button type="button" onclick="openWithdrawModal()" class="py-2 px-1.5 bg-blue-500 hover:bg-blue-600 text-white text-[10px] font-bold rounded-xl shadow-md shadow-blue-500/25 transition-all flex items-center justify-center gap-1 text-center active:scale-95">
                        <i class="fa-solid fa-money-bill-transfer text-xs"></i>
                        <span>Tarik</span>
                    </button>
                    @endif

                    <button type="button" onclick="copyLink()" class="py-2 px-1.5 glass-panel hover:bg-white/10 text-white text-[10px] font-semibold rounded-xl border border-white/10 transition-all flex items-center justify-center gap-1 text-center active:scale-95">
                        <i class="fa-solid fa-link text-blue-300 text-xs"></i>
                        <span>Salin</span>
                    </button>
            </div>
        </div>
        <div class="flex flex-col justify-between pl-1">
            <div>
                <div class="flex items-center justify-between mb-0.5">
                    <p class="text-[11px] text-emerald-200/70 font-semibold flex items-center gap-1.5">
                        <i class="fa-solid fa-wallet text-emerald-400 text-xs"></i>
                        <span>Saldo Wallet</span>
                    </p>
                    <span class="text-[8px] bg-emerald-500/20 text-emerald-300 font-extrabold px-1.5 py-0.2 rounded-full border border-emerald-500/30">
                        ACTIVE
                    </span>
                </div>
                <div class="text-xl sm:text-2xl font-black text-white tracking-tight my-1 truncate">
                    <span class="text-xs text-emerald-400/90 font-bold mr-0.5">Rp</span>{{ number_format($wallet->balance, 0, ',', '.') }}
                </div>
            </div>
            <div class="grid grid-cols-2 gap-1.5 mt-2">
                <button type="button" onclick="openWalletDepositModal()" class="py-2 px-1.5 bg-gradient-to-r from-emerald-500 to-teal-500 hover:from-emerald-400 hover:to-teal-400 text-white text-[10px] font-bold rounded-xl shadow-md shadow-emerald-500/25 transition-all flex items-center justify-center gap-1 text-center active:scale-95">
                    <i class="fa-solid fa-circle-plus text-xs"></i>
                    <span>Top Up</span>
                </button>

                <button type="button" onclick="openWalletMutationsModal()" class="py-2 px-1.5 glass-panel hover:bg-white/10 text-white text-[10px] font-semibold rounded-xl border border-white/10 transition-all flex items-center justify-center gap-1 text-center active:scale-95">
                    <i class="fa-solid fa-clock-rotate-left text-emerald-400 text-xs"></i>
                    <span>Mutasi</span>
                </button>
            </div>
        </div>

    </div>
</div>
