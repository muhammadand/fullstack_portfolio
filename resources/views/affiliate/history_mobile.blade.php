<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Riwayat Transaksi - Scalify Partner</title>
    <x-affiliate.pwa-meta />
    <link rel="preconnect" href="https://cdnjs.cloudflare.com" crossorigin>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            background-color: #0B1120;
            color: #ffffff;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            -webkit-tap-highlight-color: transparent;
        }

        .glass-card {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.05), rgba(15, 23, 42, 0.6));
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .glass-panel {
            background: rgba(255, 255, 255, 0.04);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.08);
        }

        /* Custom Pagination styles for mobile */
        .mobile-pagination nav div.hidden {
            display: flex !important;
        }

        .mobile-pagination p.text-sm {
            color: #94a3b8 !important;
            font-size: 0.75rem !important;
        }

        .mobile-pagination svg {
            width: 0.875rem;
            height: 0.875rem;
        }

        .hide-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .hide-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

    </style>
</head>
<body class="pb-24 overflow-x-hidden min-h-screen flex flex-col relative bg-[#0B1120]">

    <x-affiliate.page-loader />

    <!-- Ambient Glow Backgrounds -->
    <div class="fixed top-0 left-1/2 -translate-x-1/2 w-96 h-80 bg-blue-600/15 rounded-full blur-[120px] pointer-events-none z-0"></div>
    <div class="fixed bottom-0 right-0 w-80 h-80 bg-emerald-600/10 rounded-full blur-[100px] pointer-events-none z-0"></div>

    <div class="relative z-10 w-full max-w-md mx-auto flex flex-col min-h-screen px-4 pt-5">

        <!-- Top Header Bar -->
        <header class="flex items-center justify-between mb-4">
            <div class="flex items-center gap-3">
                <a href="{{ route('affiliate.dashboard') }}" class="w-9 h-9 rounded-xl glass-panel flex items-center justify-center text-slate-300 hover:text-white transition-colors active:scale-95" title="Kembali ke Dashboard">
                    <i class="fa-solid fa-arrow-left text-xs"></i>
                </a>
                <div>
                    <h1 class="text-base font-extrabold text-white tracking-tight flex items-center gap-1.5">
                        <i class="fa-solid fa-clock-rotate-left text-blue-400 text-sm"></i> Riwayat Transaksi
                    </h1>
                    <p class="text-[10px] text-slate-400 mt-0.5">Komisi Afiliasi & Mutasi Wallet</p>
                </div>
            </div>

            <a href="{{ route('affiliate.dashboard') }}" class="px-2.5 py-1.5 rounded-xl glass-panel text-[11px] font-bold text-slate-300 hover:text-white flex items-center gap-1 transition-colors active:scale-95">
                <i class="fa-solid fa-house text-[10px] text-blue-400"></i>
                <span>Beranda</span>
            </a>
        </header>

        <!-- Compact Financial Pocket Balances -->
        <div class="glass-card rounded-2xl p-3 mb-4 grid grid-cols-2 gap-2 border border-white/10 shadow-lg">
            <div class="pr-2 border-r border-white/10">
                <p class="text-[10px] font-semibold text-blue-300/80 flex items-center gap-1">
                    <i class="fa-solid fa-coins text-blue-400 text-[10px]"></i> Saldo Komisi
                </p>
                <div class="text-sm sm:text-base font-black text-white mt-0.5 truncate">
                    <span class="text-[10px] text-blue-400 font-bold mr-0.5">Rp</span>{{ number_format($affiliate->balance, 0, ',', '.') }}
                </div>
            </div>
            <div class="pl-2">
                <p class="text-[10px] font-semibold text-emerald-300/80 flex items-center gap-1">
                    <i class="fa-solid fa-wallet text-emerald-400 text-[10px]"></i> Saldo Wallet
                </p>
                <div class="text-sm sm:text-base font-black text-white mt-0.5 truncate">
                    <span class="text-[10px] text-emerald-400 font-bold mr-0.5">Rp</span>{{ number_format($wallet->balance, 0, ',', '.') }}
                </div>
            </div>
        </div>

        <!-- 1. Primary Pocket Switcher (Komisi Afiliasi vs Wallet) -->
        <div class="p-1 rounded-2xl bg-white/[0.03] border border-white/10 grid grid-cols-2 gap-1 mb-3 text-xs font-bold" id="pocketContainer">
            <button type="button" onclick="switchPocket('komisi')" id="btnPocketKomisi" class="py-2.5 rounded-xl transition-all duration-200 text-center flex items-center justify-center gap-1.5 bg-blue-500/20 text-blue-300 border border-blue-500/40 shadow-sm cursor-pointer">
                <i class="fa-solid fa-coins text-xs"></i>
                <span>Komisi Afiliasi</span>
            </button>
            <button type="button" onclick="switchPocket('wallet')" id="btnPocketWallet" class="py-2.5 rounded-xl transition-all duration-200 text-center flex items-center justify-center gap-1.5 text-slate-400 hover:text-slate-200 cursor-pointer">
                <i class="fa-solid fa-wallet text-xs"></i>
                <span>Wallet</span>
            </button>
        </div>

        <!-- 2A. Sub-Tabs Komisi (Masuk vs Tarik) -->
        <div id="subTabsKomisi" class="flex items-center gap-2 mb-4">
            <button type="button" onclick="switchSubTab('komisi_masuk')" id="btnTabKomisiMasuk" class="flex-1 py-2 px-3 rounded-xl text-xs font-bold transition-all text-center flex items-center justify-center gap-1.5 bg-emerald-500/15 text-emerald-300 border border-emerald-500/30">
                <i class="fa-solid fa-arrow-down text-[10px]"></i>
                <span>Komisi Masuk</span>
            </button>
            <button type="button" onclick="switchSubTab('penarikan')" id="btnTabPenarikan" class="flex-1 py-2 px-3 rounded-xl text-xs font-bold transition-all text-center flex items-center justify-center gap-1.5 bg-white/[0.03] text-slate-400 hover:text-white border border-white/5">
                <i class="fa-solid fa-arrow-up text-[10px]"></i>
                <span>Penarikan</span>
            </button>
        </div>

        <!-- 2B. Sub-Tabs Wallet (Masuk vs Keluar) -->
        <div id="subTabsWallet" class="hidden items-center gap-2 mb-4">
            <button type="button" onclick="switchSubTab('wallet_masuk')" id="btnTabWalletMasuk" class="flex-1 py-2 px-3 rounded-xl text-xs font-bold transition-all text-center flex items-center justify-center gap-1.5 bg-emerald-500/15 text-emerald-300 border border-emerald-500/30">
                <i class="fa-solid fa-qrcode text-[10px]"></i>
                <span>Dana Masuk (Top Up)</span>
            </button>
            <button type="button" onclick="switchSubTab('wallet_keluar')" id="btnTabWalletKeluar" class="flex-1 py-2 px-3 rounded-xl text-xs font-bold transition-all text-center flex items-center justify-center gap-1.5 bg-white/[0.03] text-slate-400 hover:text-white border border-white/5">
                <i class="fa-solid fa-cart-shopping text-[10px]"></i>
                <span>Dana Keluar (PPOB)</span>
            </button>
        </div>

        <!-- ========================================== -->
        <!-- CONTENT SECTION 1: KOMISI MASUK            -->
        <!-- ========================================== -->
        <div id="contentKomisiMasuk" class="block">
            <div class="space-y-2 mb-4">
                @forelse($commissions as $comm)
                <div class="p-3 rounded-2xl border border-white/10 bg-white/[0.03] hover:bg-white/[0.05] transition-colors flex items-center justify-between gap-3">
                    <div class="flex items-center gap-2.5 min-w-0 flex-1">
                        <div class="w-9 h-9 rounded-xl bg-emerald-500/15 text-emerald-400 border border-emerald-500/30 flex items-center justify-center shrink-0">
                            <i class="fa-solid fa-coins text-xs"></i>
                        </div>
                        <div class="min-w-0 flex-1">
                            <p class="text-xs font-bold text-white truncate" title="{{ $comm->description ?? 'Komisi Project' }}">
                                {{ $comm->description ?? 'Komisi Project' }}
                            </p>
                            <p class="text-[10px] text-slate-400 mt-0.5 whitespace-nowrap">
                                {{ $comm->created_at ? $comm->created_at->format('d M Y, H:i') : '-' }}
                            </p>
                        </div>
                    </div>
                    <div class="text-right shrink-0">
                        <p class="text-xs font-black text-emerald-400 tracking-tight whitespace-nowrap">
                            +Rp {{ number_format($comm->amount, 0, ',', '.') }}
                        </p>
                        <span class="inline-block text-[9px] font-bold text-emerald-400/80 bg-emerald-500/10 px-1.5 py-0.2 rounded mt-0.5">
                            Lunas
                        </span>
                    </div>
                </div>
                @empty
                <div class="p-8 text-center text-slate-400 text-xs flex flex-col items-center glass-panel rounded-2xl">
                    <div class="w-14 h-14 rounded-2xl bg-white/5 border border-white/5 flex items-center justify-center text-2xl mb-3 text-slate-500">
                        <i class="fa-solid fa-inbox"></i>
                    </div>
                    <h4 class="text-xs font-bold text-slate-200 mb-0.5">Belum Ada Komisi Masuk</h4>
                    <p class="text-[11px] text-slate-500 max-w-[220px]">Komisi dari leads dan closing website akan tercatat otomatis di sini.</p>
                </div>
                @endforelse
            </div>

            @if($commissions->hasPages())
            <div class="mobile-pagination mt-4 px-1">
                {{ $commissions->links('pagination::tailwind') }}
            </div>
            @endif
        </div>

        <!-- ========================================== -->
        <!-- CONTENT SECTION 2: PENARIKAN KOMISI        -->
        <!-- ========================================== -->
        <div id="contentPenarikan" class="hidden">
            <div class="space-y-2 mb-4">
                @forelse($withdrawals as $w)
                <div class="p-3 rounded-2xl border border-white/10 bg-white/[0.03] hover:bg-white/[0.05] transition-colors">
                    <div class="flex items-center justify-between gap-3 mb-2">
                        <div class="flex items-center gap-2.5 min-w-0 flex-1">
                            <div class="w-9 h-9 rounded-xl bg-rose-500/15 text-rose-400 border border-rose-500/30 flex items-center justify-center shrink-0">
                                <i class="fa-solid fa-arrow-up text-xs"></i>
                            </div>
                            <div class="min-w-0 flex-1">
                                <p class="text-xs font-bold text-white truncate">
                                    Penarikan Saldo
                                </p>
                                <p class="text-[10px] text-slate-400 mt-0.5 truncate">
                                    {{ $w->bank_info }}
                                </p>
                            </div>
                        </div>
                        <div class="text-right shrink-0">
                            <p class="text-xs font-black text-rose-400 tracking-tight whitespace-nowrap">
                                -Rp {{ number_format($w->amount, 0, ',', '.') }}
                            </p>
                            <p class="text-[10px] text-slate-400 mt-0.5 whitespace-nowrap">
                                {{ $w->created_at ? $w->created_at->format('d M, H:i') : '-' }}
                            </p>
                        </div>
                    </div>

                    <!-- Status & Proof Row -->
                    <div class="flex items-center justify-between pt-2 border-t border-white/5 text-[10px]">
                        <div>
                            @if(strtolower($w->status) === 'pending')
                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-lg bg-amber-500/15 text-amber-300 border border-amber-500/30 font-semibold">
                                <i class="fa-solid fa-clock text-[9px]"></i> Menunggu Proses
                            </span>
                            @elseif(strtolower($w->status) === 'completed')
                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-lg bg-emerald-500/15 text-emerald-300 border border-emerald-500/30 font-semibold">
                                <i class="fa-solid fa-circle-check text-[9px]"></i> Selesai Ditransfer
                            </span>
                            @else
                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-lg bg-rose-500/15 text-rose-300 border border-rose-500/30 font-semibold">
                                <i class="fa-solid fa-circle-xmark text-[9px]"></i> Ditolak
                            </span>
                            @endif
                        </div>

                        @if($w->proof_of_payment)
                        <a href="{{ asset('storage/' . $w->proof_of_payment) }}" target="_blank" class="text-blue-400 hover:text-blue-300 font-semibold flex items-center gap-1">
                            <i class="fa-solid fa-receipt text-[9px]"></i> Bukti Transfer
                        </a>
                        @endif
                    </div>
                </div>
                @empty
                <div class="p-8 text-center text-slate-400 text-xs flex flex-col items-center glass-panel rounded-2xl">
                    <div class="w-14 h-14 rounded-2xl bg-white/5 border border-white/5 flex items-center justify-center text-2xl mb-3 text-slate-500">
                        <i class="fa-solid fa-receipt"></i>
                    </div>
                    <h4 class="text-xs font-bold text-slate-200 mb-0.5">Belum Ada Penarikan</h4>
                    <p class="text-[11px] text-slate-500 max-w-[220px]">Riwayat pencairan komisi ke rekening bank Anda akan tampil di sini.</p>
                </div>
                @endforelse
            </div>

            @if($withdrawals->hasPages())
            <div class="mobile-pagination mt-4 px-1">
                {{ $withdrawals->links('pagination::tailwind') }}
            </div>
            @endif
        </div>

        <!-- ========================================== -->
        <!-- CONTENT SECTION 3: WALLET DANA MASUK       -->
        <!-- ========================================== -->
        <div id="contentWalletMasuk" class="hidden">
            <div class="space-y-2 mb-4">
                @forelse($walletMasuk as $m)
                <div class="p-3 rounded-2xl border border-white/10 bg-white/[0.03] hover:bg-white/[0.05] transition-colors flex items-center justify-between gap-3">
                    <div class="flex items-center gap-2.5 min-w-0 flex-1">
                        <div class="w-9 h-9 rounded-xl bg-emerald-500/15 text-emerald-400 border border-emerald-500/30 flex items-center justify-center shrink-0">
                            <i class="fa-solid fa-qrcode text-xs"></i>
                        </div>
                        <div class="min-w-0 flex-1">
                            <p class="text-xs font-bold text-white truncate leading-tight" title="{{ $m->description ?: $m->category }}">
                                {{ $m->description ?: $m->category }}
                            </p>
                            <div class="flex items-center gap-1.5 mt-1 text-[10px] text-slate-400 font-medium whitespace-nowrap overflow-hidden">
                                <span class="shrink-0">{{ $m->created_at ? $m->created_at->format('d M Y, H:i') : '-' }}</span>
                                <span class="text-slate-600 shrink-0">•</span>
                                <span class="font-mono text-[9px] text-slate-400 bg-white/5 px-1.5 py-0.5 rounded border border-white/5 truncate max-w-[85px]" title="{{ $m->mutation_no }}">
                                    #{{ substr($m->mutation_no, -6) }}
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="text-right shrink-0">
                        <p class="text-xs font-black text-emerald-400 tracking-tight whitespace-nowrap">
                            +Rp {{ number_format($m->amount, 0, ',', '.') }}
                        </p>
                        <p class="text-[10px] text-slate-400 font-medium mt-0.5 whitespace-nowrap">
                            Sisa: <span class="text-slate-300 font-semibold">Rp {{ number_format($m->balance_after, 0, ',', '.') }}</span>
                        </p>
                    </div>
                </div>
                @empty
                <div class="p-8 text-center text-slate-400 text-xs flex flex-col items-center glass-panel rounded-2xl">
                    <div class="w-14 h-14 rounded-2xl bg-white/5 border border-white/5 flex items-center justify-center text-2xl mb-3 text-slate-500">
                        <i class="fa-solid fa-wallet"></i>
                    </div>
                    <h4 class="text-xs font-bold text-slate-200 mb-0.5">Belum Ada Dana Wallet Masuk</h4>
                    <p class="text-[11px] text-slate-500 max-w-[220px] mb-3">Isi saldo wallet Anda secara instan menggunakan QRIS.</p>
                    <a href="{{ route('affiliate.dashboard') }}" class="px-3.5 py-2 bg-gradient-to-r from-emerald-500 to-teal-500 hover:from-emerald-400 hover:to-teal-400 text-white font-bold text-[11px] rounded-xl shadow-md shadow-emerald-500/25 transition-all inline-flex items-center gap-1.5 active:scale-95">
                        <i class="fa-solid fa-plus text-[10px]"></i> Top Up Saldo Sekarang
                    </a>
                </div>
                @endforelse
            </div>

            @if($walletMasuk->hasPages())
            <div class="mobile-pagination mt-4 px-1">
                {{ $walletMasuk->links('pagination::tailwind') }}
            </div>
            @endif
        </div>

        <!-- ========================================== -->
        <!-- CONTENT SECTION 4: WALLET DANA KELUAR      -->
        <!-- ========================================== -->
        <div id="contentWalletKeluar" class="hidden">
            <div class="space-y-2 mb-4">
                @forelse($walletKeluar as $m)
                <div class="p-3 rounded-2xl border border-white/10 bg-white/[0.03] hover:bg-white/[0.05] transition-colors flex items-center justify-between gap-3">
                    <div class="flex items-center gap-2.5 min-w-0 flex-1">
                        <div class="w-9 h-9 rounded-xl bg-cyan-500/15 text-cyan-400 border border-cyan-500/30 flex items-center justify-center shrink-0">
                            <i class="fa-solid fa-cart-shopping text-xs"></i>
                        </div>
                        <div class="min-w-0 flex-1">
                            <p class="text-xs font-bold text-white truncate leading-tight" title="{{ $m->description ?: $m->category }}">
                                {{ $m->description ?: $m->category }}
                            </p>
                            <div class="flex items-center gap-1.5 mt-1 text-[10px] text-slate-400 font-medium whitespace-nowrap overflow-hidden">
                                <span class="shrink-0">{{ $m->created_at ? $m->created_at->format('d M Y, H:i') : '-' }}</span>
                                <span class="text-slate-600 shrink-0">•</span>
                                <span class="font-mono text-[9px] text-slate-400 bg-white/5 px-1.5 py-0.5 rounded border border-white/5 truncate max-w-[85px]" title="{{ $m->mutation_no }}">
                                    #{{ substr($m->mutation_no, -6) }}
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="text-right shrink-0">
                        <p class="text-xs font-black text-rose-400 tracking-tight whitespace-nowrap">
                            -Rp {{ number_format($m->amount, 0, ',', '.') }}
                        </p>
                        <p class="text-[10px] text-slate-400 font-medium mt-0.5 whitespace-nowrap">
                            Sisa: <span class="text-slate-300 font-semibold">Rp {{ number_format($m->balance_after, 0, ',', '.') }}</span>
                        </p>
                    </div>
                </div>
                @empty
                <div class="p-8 text-center text-slate-400 text-xs flex flex-col items-center glass-panel rounded-2xl">
                    <div class="w-14 h-14 rounded-2xl bg-white/5 border border-white/5 flex items-center justify-center text-2xl mb-3 text-slate-500">
                        <i class="fa-solid fa-receipt"></i>
                    </div>
                    <h4 class="text-xs font-bold text-slate-200 mb-0.5">Belum Ada Transaksi PPOB</h4>
                    <p class="text-[11px] text-slate-500 max-w-[220px]">Pembelian produk digital dan transaksi PPOB akan tercatat otomatis di sini.</p>
                </div>
                @endforelse
            </div>

            @if($walletKeluar->hasPages())
            <div class="mobile-pagination mt-4 px-1">
                {{ $walletKeluar->links('pagination::tailwind') }}
            </div>
            @endif
        </div>

    </div>

    <!-- Fixed Bottom Navigation Bar -->
    <x-affiliate.bottom-nav />

    <!-- Script Tab Switching & Deep Linking -->
    <script>
        let currentPocket = 'komisi';
        let currentSubTab = 'komisi_masuk';

        function switchPocket(pocket) {
            currentPocket = pocket;
            const btnPocketKomisi = document.getElementById('btnPocketKomisi');
            const btnPocketWallet = document.getElementById('btnPocketWallet');
            const subTabsKomisi = document.getElementById('subTabsKomisi');
            const subTabsWallet = document.getElementById('subTabsWallet');

            if (pocket === 'komisi') {
                btnPocketKomisi.className = 'py-2.5 rounded-xl transition-all duration-200 text-center flex items-center justify-center gap-1.5 bg-blue-500/20 text-blue-300 border border-blue-500/40 shadow-sm cursor-pointer';
                btnPocketWallet.className = 'py-2.5 rounded-xl transition-all duration-200 text-center flex items-center justify-center gap-1.5 text-slate-400 hover:text-slate-200 cursor-pointer';

                subTabsKomisi.classList.remove('hidden');
                subTabsKomisi.classList.add('flex');
                subTabsWallet.classList.add('hidden');
                subTabsWallet.classList.remove('flex');

                switchSubTab('komisi_masuk');
            } else {
                btnPocketWallet.className = 'py-2.5 rounded-xl transition-all duration-200 text-center flex items-center justify-center gap-1.5 bg-emerald-500/20 text-emerald-300 border border-emerald-500/40 shadow-sm cursor-pointer';
                btnPocketKomisi.className = 'py-2.5 rounded-xl transition-all duration-200 text-center flex items-center justify-center gap-1.5 text-slate-400 hover:text-slate-200 cursor-pointer';

                subTabsWallet.classList.remove('hidden');
                subTabsWallet.classList.add('flex');
                subTabsKomisi.classList.add('hidden');
                subTabsKomisi.classList.remove('flex');

                switchSubTab('wallet_masuk');
            }
        }

        function switchSubTab(subTab) {
            currentSubTab = subTab;

            // Elements
            const contentKomisiMasuk = document.getElementById('contentKomisiMasuk');
            const contentPenarikan = document.getElementById('contentPenarikan');
            const contentWalletMasuk = document.getElementById('contentWalletMasuk');
            const contentWalletKeluar = document.getElementById('contentWalletKeluar');

            const btnTabKomisiMasuk = document.getElementById('btnTabKomisiMasuk');
            const btnTabPenarikan = document.getElementById('btnTabPenarikan');
            const btnTabWalletMasuk = document.getElementById('btnTabWalletMasuk');
            const btnTabWalletKeluar = document.getElementById('btnTabWalletKeluar');

            // Hide all contents
            contentKomisiMasuk.classList.add('hidden');
            contentPenarikan.classList.add('hidden');
            contentWalletMasuk.classList.add('hidden');
            contentWalletKeluar.classList.add('hidden');

            // Reset subtab button styles
            const defaultStyle = 'flex-1 py-2 px-3 rounded-xl text-xs font-bold transition-all text-center flex items-center justify-center gap-1.5 bg-white/[0.03] text-slate-400 hover:text-white border border-white/5 cursor-pointer';

            if (btnTabKomisiMasuk) btnTabKomisiMasuk.className = defaultStyle;
            if (btnTabPenarikan) btnTabPenarikan.className = defaultStyle;
            if (btnTabWalletMasuk) btnTabWalletMasuk.className = defaultStyle;
            if (btnTabWalletKeluar) btnTabWalletKeluar.className = defaultStyle;

            if (subTab === 'komisi_masuk') {
                contentKomisiMasuk.classList.remove('hidden');
                if (btnTabKomisiMasuk) btnTabKomisiMasuk.className = 'flex-1 py-2 px-3 rounded-xl text-xs font-bold transition-all text-center flex items-center justify-center gap-1.5 bg-emerald-500/15 text-emerald-300 border border-emerald-500/30 cursor-pointer';
            } else if (subTab === 'penarikan') {
                contentPenarikan.classList.remove('hidden');
                if (btnTabPenarikan) btnTabPenarikan.className = 'flex-1 py-2 px-3 rounded-xl text-xs font-bold transition-all text-center flex items-center justify-center gap-1.5 bg-rose-500/15 text-rose-300 border border-rose-500/30 cursor-pointer';
            } else if (subTab === 'wallet_masuk') {
                contentWalletMasuk.classList.remove('hidden');
                if (btnTabWalletMasuk) btnTabWalletMasuk.className = 'flex-1 py-2 px-3 rounded-xl text-xs font-bold transition-all text-center flex items-center justify-center gap-1.5 bg-emerald-500/15 text-emerald-300 border border-emerald-500/30 cursor-pointer';
            } else if (subTab === 'wallet_keluar') {
                contentWalletKeluar.classList.remove('hidden');
                if (btnTabWalletKeluar) btnTabWalletKeluar.className = 'flex-1 py-2 px-3 rounded-xl text-xs font-bold transition-all text-center flex items-center justify-center gap-1.5 bg-rose-500/15 text-rose-300 border border-rose-500/30 cursor-pointer';
            }
        }

        // Deep linking: switch pocket and sub-tab based on URL parameters or pagination
        window.addEventListener('DOMContentLoaded', () => {
            const params = new URLSearchParams(window.location.search);

            if (params.has('tarik_page') || params.get('tab') === 'penarikan') {
                switchPocket('komisi');
                switchSubTab('penarikan');
            } else if (params.has('wallet_masuk_page') || params.get('tab') === 'wallet_masuk' || params.get('tab') === 'wallet') {
                switchPocket('wallet');
                switchSubTab('wallet_masuk');
            } else if (params.has('wallet_keluar_page') || params.get('tab') === 'wallet_keluar') {
                switchPocket('wallet');
                switchSubTab('wallet_keluar');
            } else {
                switchPocket('komisi');
                switchSubTab('komisi_masuk');
            }
        });

    </script>
</body>
</html>
