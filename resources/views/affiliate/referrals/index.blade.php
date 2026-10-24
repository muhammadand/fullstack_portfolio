<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Program Referral Reseller - Partner Hub</title>
    <link rel="preconnect" href="https://cdnjs.cloudflare.com" crossorigin>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <x-affiliate.pwa-meta />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        body {
            background-color: #0B1120;
            color: #ffffff;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            -webkit-tap-highlight-color: transparent;
        }

        .glass-panel {
            background: rgba(255, 255, 255, 0.04);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.08);
        }

        .glass-card {
            background: linear-gradient(135deg, rgba(99, 102, 241, 0.15), rgba(15, 23, 42, 0.7));
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
            border: 1px solid rgba(99, 102, 241, 0.3);
        }
    </style>
</head>
<body class="pb-24 overflow-x-hidden min-h-screen flex flex-col relative" x-data="{ activeTab: 'logs', copyToast: false, toastMsg: '' }">

    <!-- Ambient Glow Background -->
    <div class="fixed top-0 left-0 w-full h-64 bg-indigo-600/15 rounded-full blur-[110px] -translate-y-1/2 pointer-events-none z-0"></div>
    <div class="fixed bottom-0 right-0 w-72 h-72 bg-blue-600/10 rounded-full blur-[120px] translate-y-1/3 pointer-events-none z-0"></div>

    <!-- Toast Notification -->
    <div x-show="copyToast" x-cloak
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 -translate-y-2"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-2"
         class="fixed top-5 left-1/2 -translate-x-1/2 z-50 px-4 py-2 bg-emerald-500 text-slate-950 font-semibold text-xs rounded-full shadow-lg shadow-emerald-500/20 flex items-center gap-2">
        <i class="fa-solid fa-circle-check"></i>
        <span x-text="toastMsg"></span>
    </div>

    <div class="relative z-10 w-full max-w-md mx-auto flex flex-col min-h-screen px-4 pt-5">

        <!-- Header -->
        <div class="flex items-center justify-between gap-3 mb-5">
            <div class="flex items-center gap-3">
                <a href="{{ route('affiliate.review_cards.index') }}" class="w-10 h-10 rounded-xl glass-panel flex items-center justify-center text-slate-300 hover:text-white transition-colors active:scale-95" title="Kembali ke Review Cards">
                    <i class="fa-solid fa-arrow-left text-sm"></i>
                </a>
                <div>
                    <h1 class="text-base font-bold text-white leading-tight">Program Referral</h1>
                    <p class="text-xs text-indigo-300">Komisi Jaringan Reseller 3 Tingkat</p>
                </div>
            </div>

            <!-- Saldo Komisi -->
            <a href="{{ route('affiliate.history') }}" class="glass-panel px-3 py-1.5 rounded-xl text-right hover:border-slate-500 transition-colors" title="Lihat Riwayat & Tarik Saldo">
                <div class="text-[10px] text-slate-400 font-medium">Saldo Saya</div>
                <div class="text-xs font-semibold text-emerald-400">Rp {{ number_format($affiliate->balance, 0, ',', '.') }}</div>
            </a>
        </div>

        <!-- Banner Komisi & Ringkasan -->
        <div class="glass-card rounded-2xl p-4.5 mb-5 relative overflow-hidden">
            <div class="absolute -right-6 -bottom-6 w-28 h-28 bg-indigo-500/10 rounded-full blur-2xl pointer-events-none"></div>

            <div class="flex items-center justify-between mb-2">
                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[10px] font-semibold bg-indigo-500/20 text-indigo-300 border border-indigo-500/30">
                    <i class="fa-solid fa-network-wired text-[9px]"></i>
                    Passive Income Partner
                </span>
                <span class="text-[11px] text-slate-400">3 Generasi</span>
            </div>

            <h2 class="text-sm font-bold text-white mb-1.5">
                Ajak Teman Reseller, Cuan Otomatis Tiap Kartu Terjual
            </h2>
            <p class="text-[11px] text-slate-300 leading-relaxed mb-4">
                Dapatkan bonus komisi setiap kali tim Anda membeli kuota kartu review. Tanpa memotong jatah keuntungan mereka!
            </p>

            <!-- Skema 3 Tingkat Mini Grid -->
            <div class="grid grid-cols-3 gap-2 bg-slate-900/60 p-2.5 rounded-xl border border-white/5 text-center">
                <div class="p-1.5">
                    <div class="text-[10px] text-indigo-300 font-medium">Tier 1 (Teman)</div>
                    <div class="text-xs font-bold text-emerald-400 mt-0.5">Rp 500</div>
                    <div class="text-[9px] text-slate-400">per kartu</div>
                </div>
                <div class="p-1.5 border-x border-white/10">
                    <div class="text-[10px] text-blue-300 font-medium">Tier 2</div>
                    <div class="text-xs font-bold text-emerald-400 mt-0.5">Rp 250</div>
                    <div class="text-[9px] text-slate-400">per kartu</div>
                </div>
                <div class="p-1.5">
                    <div class="text-[10px] text-teal-300 font-medium">Tier 3</div>
                    <div class="text-xs font-bold text-emerald-400 mt-0.5">Rp 125</div>
                    <div class="text-[9px] text-slate-400">per kartu</div>
                </div>
            </div>

            <!-- Total Didapat dari Referral -->
            <div class="flex items-center justify-between pt-3 mt-3 border-t border-white/10 text-xs">
                <span class="text-slate-300 text-[11px]">Total Didapat dari Referral:</span>
                <span class="font-bold text-emerald-400 text-sm">
                    +Rp {{ number_format($network['total_earned'], 0, ',', '.') }}
                </span>
            </div>
        </div>

        <!-- Box Link Undangan & Kode Referral -->
        <div class="glass-panel rounded-2xl p-4 mb-5">
            <h3 class="text-xs font-semibold text-white mb-2 flex items-center gap-1.5">
                <i class="fa-solid fa-link text-indigo-400"></i>
                Link Undangan Pendaftaran Anda
            </h3>

            <!-- Link Field & Button -->
            <div class="flex items-center gap-2 mb-3">
                <div class="flex-1 bg-slate-900/80 border border-slate-700/80 rounded-xl px-3 py-2 text-xs font-mono text-slate-300 truncate">
                    {{ $affiliate->referral_url }}
                </div>
                <button type="button"
                        @click="navigator.clipboard.writeText('{{ $affiliate->referral_url }}'); toastMsg = 'Tautan referral disalin!'; copyToast = true; setTimeout(() => copyToast = false, 2000);"
                        class="px-3.5 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-500 text-white text-xs font-semibold transition active:scale-95 shrink-0 flex items-center gap-1.5 shadow-md shadow-indigo-600/20">
                    <i class="fa-regular fa-copy"></i>
                    <span>Salin</span>
                </button>
            </div>

            <!-- Kode Referral & Tombol WA -->
            <div class="flex items-center gap-2 pt-2 border-t border-white/5">
                <div class="flex-1 text-[11px] text-slate-400">
                    Kode Referral: <b class="text-white font-mono tracking-wider ml-1">{{ $affiliate->affiliate_code }}</b>
                </div>

                @php
                    $waText = urlencode("Halo! Yuk gabung jadi partner reseller Smart Review Card bareng aku. Peluang cuan jual standee akrilik Google Review ke kafe & toko lokal dengan margin tinggi. Daftar gratis di sini: " . $affiliate->referral_url);
                @endphp
                <a href="https://api.whatsapp.com/send?text={{ $waText }}" target="_blank"
                   class="py-1.5 px-3 rounded-lg bg-emerald-600/20 hover:bg-emerald-600 text-emerald-300 hover:text-white text-[11px] font-medium transition flex items-center gap-1.5 border border-emerald-500/30">
                    <i class="fa-brands fa-whatsapp text-xs"></i>
                    <span>Bagikan ke WA</span>
                </a>
            </div>
        </div>

        <!-- Breakdown Jaringan (3 Tier Counts) -->
        <div class="grid grid-cols-3 gap-2 mb-5">
            <div class="glass-panel p-3 rounded-xl text-center">
                <div class="text-[10px] text-indigo-300 font-medium uppercase">Tier 1</div>
                <div class="text-base font-bold text-white mt-0.5">{{ $network['counts']['tier_1'] }} <span class="text-[10px] font-normal text-slate-400">Orang</span></div>
                <div class="text-[10px] text-emerald-400 mt-1 font-mono">+{{ number_format($network['earned_by_tier'][1], 0, ',', '.') }}</div>
            </div>
            <div class="glass-panel p-3 rounded-xl text-center">
                <div class="text-[10px] text-blue-300 font-medium uppercase">Tier 2</div>
                <div class="text-base font-bold text-white mt-0.5">{{ $network['counts']['tier_2'] }} <span class="text-[10px] font-normal text-slate-400">Orang</span></div>
                <div class="text-[10px] text-emerald-400 mt-1 font-mono">+{{ number_format($network['earned_by_tier'][2], 0, ',', '.') }}</div>
            </div>
            <div class="glass-panel p-3 rounded-xl text-center">
                <div class="text-[10px] text-teal-300 font-medium uppercase">Tier 3</div>
                <div class="text-base font-bold text-white mt-0.5">{{ $network['counts']['tier_3'] }} <span class="text-[10px] font-normal text-slate-400">Orang</span></div>
                <div class="text-[10px] text-emerald-400 mt-1 font-mono">+{{ number_format($network['earned_by_tier'][3], 0, ',', '.') }}</div>
            </div>
        </div>

        <!-- Tab Navigasi: Riwayat Log vs Anggota Tim -->
        <div class="flex items-center gap-2 mb-4 p-1 bg-slate-900/60 rounded-xl border border-white/5">
            <button type="button" @click="activeTab = 'logs'"
                    :class="activeTab === 'logs' ? 'bg-indigo-600 text-white font-semibold' : 'text-slate-400 hover:text-white'"
                    class="flex-1 py-2 text-xs rounded-lg transition-all flex items-center justify-center gap-1.5">
                <i class="fa-solid fa-list-check text-[11px]"></i>
                <span>Riwayat Log Komisi</span>
            </button>
            <button type="button" @click="activeTab = 'members'"
                    :class="activeTab === 'members' ? 'bg-indigo-600 text-white font-semibold' : 'text-slate-400 hover:text-white'"
                    class="flex-1 py-2 text-xs rounded-lg transition-all flex items-center justify-center gap-1.5">
                <i class="fa-solid fa-users text-[11px]"></i>
                <span>Daftar Tim ({{ $network['counts']['total'] }})</span>
            </button>
        </div>

        <!-- Tab 1: Riwayat Log Komisi Referral -->
        <div x-show="activeTab === 'logs'" class="space-y-3 mb-8">
            <div class="flex items-center justify-between text-xs px-1">
                <span class="text-slate-400 text-[11px]">Audit Pendapatan Referral</span>
                @if(request('level'))
                <a href="{{ route('affiliate.referrals.index') }}" class="text-indigo-400 hover:underline text-[11px]">Reset Filter</a>
                @endif
            </div>

            @forelse($referralLogs as $log)
            <div class="glass-panel p-3.5 rounded-2xl transition hover:border-slate-600">
                <div class="flex items-start justify-between gap-3 mb-2">
                    <div class="flex items-start gap-2.5">
                        <div class="w-8 h-8 rounded-lg bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 flex items-center justify-center shrink-0 mt-0.5">
                            <i class="fa-solid fa-arrow-down-left text-xs"></i>
                        </div>
                        <div>
                            <div class="flex items-center gap-1.5">
                                <span class="font-bold text-xs text-white">
                                    {{ $log->downline->name ?? 'Partner #' . $log->downline_id }}
                                </span>
                                <span class="px-1.5 py-0.2 rounded text-[9px] font-semibold {{ $log->level == 1 ? 'bg-indigo-500/20 text-indigo-300' : ($log->level == 2 ? 'bg-blue-500/20 text-blue-300' : 'bg-teal-500/20 text-teal-300') }}">
                                    Tier {{ $log->level }}
                                </span>
                            </div>
                            <p class="text-[11px] text-slate-400 mt-0.5">
                                Beli {{ $log->card_quantity }} Unit Kartu &bull; @ Rp {{ number_format($log->rate_per_unit, 0, ',', '.') }}
                            </p>
                        </div>
                    </div>

                    <div class="text-right">
                        <div class="text-xs font-bold text-emerald-400 font-mono">
                            +Rp {{ number_format($log->total_amount, 0, ',', '.') }}
                        </div>
                        <span class="text-[9px] text-slate-500">Order #{{ $log->order_id }}</span>
                    </div>
                </div>

                <div class="pt-2 border-t border-white/5 flex items-center justify-between text-[10px] text-slate-500">
                    <span>Otomatis Ditambahkan ke Saldo</span>
                    <span>{{ $log->created_at->format('d M Y, H:i') }} WIB</span>
                </div>
            </div>
            @empty
            <div class="glass-panel rounded-2xl p-6 text-center">
                <div class="w-12 h-12 mx-auto rounded-xl bg-white/5 flex items-center justify-center text-slate-500 text-lg mb-2">
                    <i class="fa-solid fa-clock-rotate-left"></i>
                </div>
                <p class="text-xs font-medium text-white mb-1">Belum Ada Komisi Referral</p>
                <p class="text-[11px] text-slate-400 leading-relaxed mb-3">
                    Bagikan link pendaftaran Anda ke rekan reseller. Begitu mereka membeli kuota kartu, bonus Anda otomatis masuk ke sini!
                </p>
                <button type="button" @click="navigator.clipboard.writeText('{{ $affiliate->referral_url }}'); toastMsg = 'Tautan referral disalin!'; copyToast = true; setTimeout(() => copyToast = false, 2000);"
                        class="py-2 px-4 rounded-xl bg-indigo-600 hover:bg-indigo-500 text-white text-xs font-semibold">
                    Salin Link Undangan
                </button>
            </div>
            @endforelse

            <!-- Pagination -->
            @if($referralLogs->hasPages())
            <div class="pt-2">
                {{ $referralLogs->links('pagination::tailwind') }}
            </div>
            @endif
        </div>

        <!-- Tab 2: Anggota Tim Berdasarkan Tier -->
        <div x-show="activeTab === 'members'" class="space-y-4 mb-8">
            <!-- Tier 1 -->
            <div>
                <div class="flex items-center justify-between mb-2 px-1">
                    <h4 class="text-xs font-bold text-indigo-300 uppercase tracking-wider flex items-center gap-1.5">
                        <i class="fa-solid fa-user-group text-[10px]"></i>
                        Tier 1 (Downline Langsung) - {{ $network['tier1']->count() }}
                    </h4>
                    <span class="text-[10px] text-slate-400">Bonus Rp 500/kartu</span>
                </div>
                <div class="space-y-2">
                    @forelse($network['tier1'] as $user)
                    <div class="glass-panel p-2.5 rounded-xl flex items-center justify-between">
                        <div class="flex items-center gap-2.5">
                            <div class="w-8 h-8 rounded-full bg-indigo-500/20 border border-indigo-500/30 flex items-center justify-center font-bold text-xs text-indigo-300">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                            <div>
                                <div class="text-xs font-semibold text-white">{{ $user->name }}</div>
                                <div class="text-[10px] text-slate-400">Gabung: {{ $user->created_at->format('d M Y') }}</div>
                            </div>
                        </div>
                        <span class="px-2 py-0.5 rounded-md text-[10px] font-medium bg-emerald-500/10 text-emerald-400">
                            Aktif
                        </span>
                    </div>
                    @empty
                    <div class="p-3 text-center text-[11px] text-slate-400 glass-panel rounded-xl">
                        Belum ada partner di Tier 1. Ajak teman Anda menggunakan link di atas!
                    </div>
                    @endforelse
                </div>
            </div>

            <!-- Tier 2 -->
            <div>
                <div class="flex items-center justify-between mb-2 px-1">
                    <h4 class="text-xs font-bold text-blue-300 uppercase tracking-wider flex items-center gap-1.5">
                        <i class="fa-solid fa-sitemap text-[10px]"></i>
                        Tier 2 (Downline dari Tier 1) - {{ $network['tier2']->count() }}
                    </h4>
                    <span class="text-[10px] text-slate-400">Bonus Rp 250/kartu</span>
                </div>
                <div class="space-y-2">
                    @forelse($network['tier2'] as $user)
                    <div class="glass-panel p-2.5 rounded-xl flex items-center justify-between">
                        <div class="flex items-center gap-2.5">
                            <div class="w-8 h-8 rounded-full bg-blue-500/20 border border-blue-500/30 flex items-center justify-center font-bold text-xs text-blue-300">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                            <div>
                                <div class="text-xs font-semibold text-white">{{ $user->name }}</div>
                                <div class="text-[10px] text-slate-400">Gabung: {{ $user->created_at->format('d M Y') }}</div>
                            </div>
                        </div>
                        <span class="px-2 py-0.5 rounded-md text-[10px] font-medium bg-blue-500/10 text-blue-400">
                            Tier 2
                        </span>
                    </div>
                    @empty
                    <div class="p-3 text-center text-[11px] text-slate-400 glass-panel rounded-xl">
                        Belum ada downline di Tier 2.
                    </div>
                    @endforelse
                </div>
            </div>

            <!-- Tier 3 -->
            <div>
                <div class="flex items-center justify-between mb-2 px-1">
                    <h4 class="text-xs font-bold text-teal-300 uppercase tracking-wider flex items-center gap-1.5">
                        <i class="fa-solid fa-diagram-project text-[10px]"></i>
                        Tier 3 (Generasi Ketiga) - {{ $network['tier3']->count() }}
                    </h4>
                    <span class="text-[10px] text-slate-400">Bonus Rp 125/kartu</span>
                </div>
                <div class="space-y-2">
                    @forelse($network['tier3'] as $user)
                    <div class="glass-panel p-2.5 rounded-xl flex items-center justify-between">
                        <div class="flex items-center gap-2.5">
                            <div class="w-8 h-8 rounded-full bg-teal-500/20 border border-teal-500/30 flex items-center justify-center font-bold text-xs text-teal-300">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                            <div>
                                <div class="text-xs font-semibold text-white">{{ $user->name }}</div>
                                <div class="text-[10px] text-slate-400">Gabung: {{ $user->created_at->format('d M Y') }}</div>
                            </div>
                        </div>
                        <span class="px-2 py-0.5 rounded-md text-[10px] font-medium bg-teal-500/10 text-teal-400">
                            Tier 3
                        </span>
                    </div>
                    @empty
                    <div class="p-3 text-center text-[11px] text-slate-400 glass-panel rounded-xl">
                        Belum ada downline di Tier 3.
                    </div>
                    @endforelse
                </div>
            </div>
        </div>

    </div>

</body>
</html>
