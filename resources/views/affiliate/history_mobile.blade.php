<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Riwayat Dana - Mobile</title>
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

        /* Custom Pagination styles for mobile */
        .mobile-pagination nav div.hidden {
            display: flex !important;
        }

        .mobile-pagination p.text-sm {
            color: #94a3b8 !important;
        }

        .mobile-pagination svg {
            width: 1rem;
            height: 1rem;
        }

    </style>
</head>
<body class="pb-24 overflow-x-hidden min-h-screen flex flex-col relative">

    <!-- Background Decoration -->
    <div class="fixed top-0 left-0 w-full h-64 bg-blue-600/20 rounded-full blur-[100px] -translate-y-1/2 pointer-events-none z-0"></div>

    <div class="relative z-10 w-full max-w-md mx-auto flex flex-col min-h-screen px-4 pt-6">

        <!-- Header -->
        <div class="flex items-center gap-4 mb-8">
            <a href="{{ route('affiliate.dashboard') }}" class="w-10 h-10 rounded-full glass-panel flex items-center justify-center text-slate-300 hover:text-white transition-colors">
                <i class="fa-solid fa-arrow-left"></i>
            </a>
            <div>
                <p class="text-xs text-blue-400 font-medium tracking-wider uppercase">Transaksi</p>
                <h1 class="text-xl font-bold text-white">Riwayat Dana</h1>
            </div>
        </div>

        <!-- Tab Navigation (CSS only implementation) -->
        <div class="glass-panel p-1 rounded-xl flex mb-6 text-sm font-semibold" id="tabContainer">
            <button onclick="switchTab('masuk')" id="tabMasuk" class="flex-1 py-2.5 rounded-lg bg-blue-500/20 text-blue-400 border border-blue-500/30 transition-all text-center">
                Komisi Masuk
            </button>
            <button onclick="switchTab('keluar')" id="tabKeluar" class="flex-1 py-2.5 rounded-lg text-slate-400 transition-all text-center">
                Penarikan
            </button>
        </div>

        <!-- Tab Content: Komisi Masuk -->
        <div id="contentMasuk" class="block">
            <div class="glass-panel rounded-2xl p-2 mb-4">
                @forelse($commissions as $comm)
                <div class="flex items-center justify-between p-3 border-b border-white/5 last:border-0">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-emerald-500/10 flex items-center justify-center text-emerald-400 shadow-inner">
                            <i class="fa-solid fa-arrow-down"></i>
                        </div>
                        <div>
                            <p class="text-sm font-bold text-white max-w-[160px] truncate">{{ $comm->description ?? 'Komisi Project' }}</p>
                            <p class="text-[10px] text-slate-400">{{ $comm->created_at->format('d M, H:i') }}</p>
                        </div>
                    </div>
                    <div class="text-sm font-bold text-emerald-400 text-right">
                        +Rp {{ number_format($comm->amount, 0, ',', '.') }}
                    </div>
                </div>
                @empty
                <div class="p-8 text-center text-slate-400 text-sm flex flex-col items-center">
                    <div class="w-16 h-16 rounded-full bg-white/5 flex items-center justify-center text-2xl mb-3">
                        <i class="fa-solid fa-inbox text-slate-500"></i>
                    </div>
                    Belum ada riwayat komisi masuk.
                </div>
                @endforelse
            </div>

            @if($commissions->hasPages())
            <div class="mobile-pagination mt-4 px-2">
                {{ $commissions->links('pagination::tailwind') }}
            </div>
            @endif
        </div>

        <!-- Tab Content: Penarikan -->
        <div id="contentKeluar" class="hidden">
            <div class="glass-panel rounded-2xl p-2 mb-4">
                @forelse($withdrawals as $w)
                <div class="p-3 border-b border-white/5 last:border-0">
                    <div class="flex items-center justify-between mb-2">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-red-500/10 flex items-center justify-center text-red-400 shadow-inner">
                                <i class="fa-solid fa-arrow-up"></i>
                            </div>
                            <div>
                                <p class="text-sm font-bold text-white">Penarikan Saldo</p>
                                <p class="text-[10px] text-slate-400">{{ $w->created_at->format('d M, H:i') }}</p>
                            </div>
                        </div>
                        <div class="text-sm font-bold text-white">
                            -Rp {{ number_format($w->amount, 0, ',', '.') }}
                        </div>
                    </div>

                    <div class="flex items-center justify-between mt-3 pl-13 pr-1">
                        @if($w->status === 'Pending')
                        <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-medium bg-yellow-500/10 text-yellow-400 border border-yellow-500/20">
                            <i class="fa-solid fa-clock mr-1"></i> Menunggu Proses
                        </span>
                        @elseif($w->status === 'Completed')
                        <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-medium bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">
                            <i class="fa-solid fa-check mr-1"></i> Selesai
                        </span>
                        @else
                        <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-medium bg-red-500/10 text-red-400 border border-red-500/20">
                            <i class="fa-solid fa-xmark mr-1"></i> Ditolak
                        </span>
                        @endif

                        @if($w->proof_of_payment)
                        <a href="{{ asset('storage/' . $w->proof_of_payment) }}" target="_blank" class="text-[10px] text-blue-400 hover:text-blue-300 font-medium">
                            <i class="fa-solid fa-file-invoice mr-1"></i> Lihat Bukti
                        </a>
                        @endif
                    </div>
                </div>
                @empty
                <div class="p-8 text-center text-slate-400 text-sm flex flex-col items-center">
                    <div class="w-16 h-16 rounded-full bg-white/5 flex items-center justify-center text-2xl mb-3">
                        <i class="fa-solid fa-receipt text-slate-500"></i>
                    </div>
                    Belum ada riwayat penarikan.
                </div>
                @endforelse
            </div>

            @if($withdrawals->hasPages())
            <div class="mobile-pagination mt-4 px-2">
                {{ $withdrawals->links('pagination::tailwind') }}
            </div>
            @endif
        </div>

    </div>

    <!-- Bottom Navigation -->
    <div class="fixed bottom-0 left-0 w-full glass-panel border-t border-white/10 z-50">
        <div class="max-w-md mx-auto flex justify-between items-center px-6 py-3">
            <a href="{{ route('affiliate.dashboard') }}" class="flex flex-col items-center gap-1 text-slate-400 hover:text-blue-300 transition-colors">
                <i class="fa-solid fa-house text-xl"></i>
                <span class="text-[10px] font-medium">Beranda</span>
            </a>
            <a href="{{ route('affiliate.history') }}" class="flex flex-col items-center gap-1 text-blue-400">
                <i class="fa-solid fa-clock-rotate-left text-xl"></i>
                <span class="text-[10px] font-medium">Riwayat</span>
            </a>
            <form action="{{ route('affiliate.logout') }}" method="POST" class="flex flex-col items-center">
                @csrf
                <button type="submit" class="flex flex-col items-center gap-1 text-slate-400 hover:text-red-400 transition-colors">
                    <i class="fa-solid fa-arrow-right-from-bracket text-xl"></i>
                    <span class="text-[10px] font-medium">Keluar</span>
                </button>
            </form>
        </div>
    </div>

    <script>
        function switchTab(tab) {
            const btnMasuk = document.getElementById('tabMasuk');
            const btnKeluar = document.getElementById('tabKeluar');
            const contentMasuk = document.getElementById('contentMasuk');
            const contentKeluar = document.getElementById('contentKeluar');

            // Reset styles
            btnMasuk.className = 'flex-1 py-2.5 rounded-lg text-slate-400 transition-all text-center';
            btnKeluar.className = 'flex-1 py-2.5 rounded-lg text-slate-400 transition-all text-center';

            if (tab === 'masuk') {
                btnMasuk.className = 'flex-1 py-2.5 rounded-lg bg-blue-500/20 text-blue-400 border border-blue-500/30 transition-all text-center';
                contentMasuk.classList.remove('hidden');
                contentKeluar.classList.add('hidden');
            } else {
                btnKeluar.className = 'flex-1 py-2.5 rounded-lg bg-blue-500/20 text-blue-400 border border-blue-500/30 transition-all text-center';
                contentKeluar.classList.remove('hidden');
                contentMasuk.classList.add('hidden');
            }
        }

        // If there's a page query param for withdrawals, auto-switch to "Penarikan" tab
        window.addEventListener('DOMContentLoaded', () => {
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.has('tarik_page')) {
                switchTab('keluar');
            }
        });

    </script>
</body>
</html>
