<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Review Cards - Partner Hub</title>
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
            background: linear-gradient(135deg, rgba(37, 99, 235, 0.12), rgba(15, 23, 42, 0.6));
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
            border: 1px solid rgba(59, 130, 246, 0.2);
        }

    </style>
</head>
<body class="pb-24 overflow-x-hidden min-h-screen flex flex-col relative" x-data="{ buyModal: false, activateModal: false, isActivating: false, selectedQty: 1, selectedCost: 10000, activeCard: null }">

    <!-- Subtle Background Glow -->
    <div class="fixed top-0 left-0 w-full h-56 bg-blue-600/10 rounded-full blur-[100px] -translate-y-1/2 pointer-events-none z-0"></div>

    <div class="relative z-10 w-full max-w-md mx-auto flex flex-col min-h-screen px-4 pt-5">

        <!-- Header -->
        <div class="flex items-center justify-between gap-3 mb-5">
            <div class="flex items-center gap-3">
                <a href="{{ route('affiliate.dashboard') }}" class="w-10 h-10 rounded-xl glass-panel flex items-center justify-center text-slate-300 hover:text-white transition-colors active:scale-95">
                    <i class="fa-solid fa-arrow-left text-sm"></i>
                </a>
                <div>
                    <h1 class="text-base font-bold text-white leading-tight">Review Cards</h1>
                    <p class="text-xs text-slate-400">Smart QR Google Review</p>
                </div>
            </div>

            <!-- Saldo Komisi -->
            <div class="glass-panel px-3 py-1.5 rounded-xl text-right">
                <div class="text-[10px] text-slate-400 font-medium">Saldo Komisi</div>
                <div class="text-xs font-semibold text-emerald-400">Rp {{ number_format($affiliate->balance, 0, ',', '.') }}</div>
            </div>
        </div>

        <!-- Flash Messages -->
        @if(session('success'))
        <div class="p-3 rounded-xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-300 text-xs flex items-center gap-2 mb-4">
            <i class="fa-solid fa-circle-check text-emerald-400 text-sm"></i>
            <span>{{ session('success') }}</span>
        </div>
        @endif

        @if(session('error'))
        <div class="p-3 rounded-xl bg-red-500/10 border border-red-500/20 text-red-300 text-xs flex items-center gap-2 mb-4">
            <i class="fa-solid fa-circle-exclamation text-red-400 text-sm"></i>
            <span>{{ session('error') }}</span>
        </div>
        @endif

        <!-- Pesanan QRIS Pending / Menunggu Verifikasi Admin -->
        @if(!empty($pendingOrders))
        @foreach($pendingOrders as $order)
        <div class="glass-card rounded-2xl p-4 mb-4 border-amber-500/30 bg-amber-500/5">
            <div class="flex items-start justify-between gap-3">
                <div class="flex items-start gap-2.5">
                    <div class="w-8 h-8 rounded-lg bg-amber-500/20 text-amber-400 flex items-center justify-center shrink-0 mt-0.5">
                        <i class="fa-solid fa-clock-rotate-left text-xs"></i>
                    </div>
                    <div>
                        <div class="flex items-center gap-2">
                            <span class="font-semibold text-xs text-white">Pesanan #{{ $order['order_id'] ?? '' }}</span>
                            <span class="text-[10px] px-2 py-0.5 rounded-full bg-amber-500/20 text-amber-300 font-medium">
                                Diproses
                            </span>
                        </div>
                        <p class="text-[11px] text-slate-300 mt-0.5">
                            {{ $order['quantity'] ?? 1 }} Unit Kartu &bull; Total: <b class="text-emerald-400 font-mono">Rp {{ number_format($order['total_amount'] ?? 0, 0, ',', '.') }}</b>
                        </p>
                        <p class="text-[10px] text-slate-400 mt-1">
                            Menunggu verifikasi admin. Stok kartu akan aktif otomatis begitu disetujui.
                        </p>
                    </div>
                </div>
                <a href="{{ route('affiliate.review_cards.pay', $order['order_id']) }}" class="py-1.5 px-3 rounded-lg bg-blue-600 hover:bg-blue-500 text-white text-xs font-medium shrink-0 transition-colors">
                    Lihat QRIS
                </a>
            </div>
        </div>
        @endforeach
        @endif

        <!-- Informasi Reseller -->
        <div class="glass-card rounded-2xl p-4 mb-5">
            <h2 class="text-xs font-semibold text-white mb-1">Peluang Penjualan Standee QR</h2>
            <p class="text-xs text-slate-300 leading-relaxed">
                Beli kuota kartu seharga <span class="text-white font-medium">Rp 10.000</span> per unit. Anda dapat mengunduh file desain siap cetak, mencetaknya di percetakan lokal (akrilik/stiker), lalu menjualnya ke kafe atau toko lokal seharga <span class="text-emerald-400 font-medium">Rp 50.000 - Rp 100.000</span>.
            </p>
        </div>

        <!-- Section 1: Paket Kuota QR -->
        <div class="mb-6">
            <div class="flex items-center justify-between mb-3 px-0.5">
                <h3 class="text-xs font-semibold text-slate-300 uppercase tracking-wider">Beli Kuota QR</h3>
                <span class="text-[11px] text-slate-400">Potong Saldo</span>
            </div>

            <div class="grid grid-cols-3 gap-2">
                <!-- 1 Unit -->
                <button type="button" @click="selectedQty = 1; selectedCost = 10000; buyModal = true;" class="glass-panel p-3 rounded-xl text-center transition-all active:scale-95 hover:border-slate-500">
                    <div class="text-[11px] text-slate-400">1 Unit</div>
                    <div class="text-sm font-bold text-white my-1">Rp 10.000</div>
                    <div class="w-full py-1 rounded-lg bg-white/5 text-slate-200 text-xs font-medium hover:bg-blue-600 hover:text-white transition-colors">
                        Pilih
                    </div>
                </button>

                <!-- 5 Unit -->
                <button type="button" @click="selectedQty = 5; selectedCost = 45000; buyModal = true;" class="glass-panel p-3 rounded-xl text-center border-blue-500/40 bg-blue-500/5 transition-all active:scale-95 relative">
                    <div class="text-[11px] text-blue-300 font-medium">5 Unit</div>
                    <div class="text-sm font-bold text-emerald-400 my-1">Rp 45.000</div>
                    <div class="w-full py-1 rounded-lg bg-blue-600 text-white text-xs font-medium hover:bg-blue-500 transition-colors">
                        Pilih
                    </div>
                </button>

                <!-- 10 Unit -->
                <button type="button" @click="selectedQty = 10; selectedCost = 80000; buyModal = true;" class="glass-panel p-3 rounded-xl text-center transition-all active:scale-95 hover:border-slate-500">
                    <div class="text-[11px] text-slate-400">10 Unit</div>
                    <div class="text-sm font-bold text-white my-1">Rp 80.000</div>
                    <div class="w-full py-1 rounded-lg bg-white/5 text-slate-200 text-xs font-medium hover:bg-blue-600 hover:text-white transition-colors">
                        Pilih
                    </div>
                </button>
            </div>
        </div>

        <!-- Section 2: Ringkasan Status -->
        <div class="grid grid-cols-3 gap-2 mb-6">
            <div class="glass-panel p-3 rounded-xl text-center">
                <div class="text-[10px] text-slate-400 font-medium uppercase">Total Kartu</div>
                <div class="text-base font-bold text-white mt-0.5">{{ number_format($stats->total_cards ?? 0) }}</div>
            </div>
            <div class="glass-panel p-3 rounded-xl text-center">
                <div class="text-[10px] text-amber-400 font-medium uppercase">Siap Jual</div>
                <div class="text-base font-bold text-amber-400 mt-0.5">{{ number_format($stats->ready_cards ?? 0) }}</div>
            </div>
            <div class="glass-panel p-3 rounded-xl text-center">
                <div class="text-[10px] text-emerald-400 font-medium uppercase">Terjual</div>
                <div class="text-base font-bold text-emerald-400 mt-0.5">{{ number_format($stats->active_cards ?? 0) }}</div>
            </div>
        </div>

        <!-- Section 3: Daftar Kartu Saya -->
        <div class="mb-8">
            <div class="flex items-center justify-between mb-3 px-0.5">
                <h3 class="text-xs font-semibold text-slate-300 uppercase tracking-wider">
                    Daftar Kartu ({{ number_format($stats->total_cards ?? 0) }})
                </h3>

                <!-- Filter Status -->
                <div class="flex items-center gap-1 text-xs">
                    <a href="{{ route('affiliate.review_cards.index') }}" class="px-2 py-0.5 rounded-lg {{ !request('filter') ? 'bg-blue-600 text-white font-medium' : 'text-slate-400 hover:text-white' }}">Semua</a>
                    <a href="{{ route('affiliate.review_cards.index', ['filter' => 'ready']) }}" class="px-2 py-0.5 rounded-lg {{ request('filter') === 'ready' ? 'bg-amber-500/20 text-amber-300 font-medium' : 'text-slate-400 hover:text-white' }}">Stok</a>
                    <a href="{{ route('affiliate.review_cards.index', ['filter' => 'active']) }}" class="px-2 py-0.5 rounded-lg {{ request('filter') === 'active' ? 'bg-emerald-500/20 text-emerald-300 font-medium' : 'text-slate-400 hover:text-white' }}">Terjual</a>
                </div>
            </div>

            <!-- List Cards Loop -->
            <div class="space-y-3">
                @forelse($myCards as $card)
                <div class="glass-panel p-3.5 rounded-2xl transition-all hover:border-slate-600">

                    <div class="flex items-start justify-between gap-2 mb-2">
                        <div>
                            <!-- Serial & PIN -->
                            <div class="font-medium text-xs text-white flex items-center gap-2">
                                <span>{{ $card->serial_number }}</span>
                                <span class="text-[11px] text-slate-400 bg-white/5 px-1.5 py-0.5 rounded">
                                    PIN: <span class="text-slate-200">{{ $card->activation_code }}</span>
                                </span>
                            </div>

                            <!-- Nama Tempat Usaha -->
                            @if($card->business_name)
                            <div class="text-xs font-semibold text-emerald-400 mt-1">
                                {{ $card->business_name }}
                            </div>
                            @else
                            <div class="text-[11px] text-slate-400 mt-0.5">
                                Belum dihubungkan ke toko
                            </div>
                            @endif
                        </div>

                        <!-- Status Badge -->
                        @if($card->status === 'active')
                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md text-[10px] font-medium bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">
                            <i class="fa-solid fa-lock text-[9px]"></i>
                            Terjual
                        </span>
                        @else
                        <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[10px] font-medium bg-amber-500/10 text-amber-400 border border-amber-500/20">
                            Siap Jual
                        </span>
                        @endif
                    </div>

                    <!-- Meta Info: Scan counter & Scan URL -->
                    <div class="flex items-center justify-between text-[11px] text-slate-400 py-1.5 border-t border-white/5 my-1.5">
                        <div class="flex items-center gap-1.5 text-blue-400">
                            <span>/r/{{ $card->slug }}</span>
                            <button type="button" onclick="navigator.clipboard.writeText('{{ url('/r/' . $card->slug) }}'); alert('Tautan berhasil disalin!');" class="text-slate-400 hover:text-white" title="Salin Link">
                                <i class="fa-regular fa-copy text-xs"></i>
                            </button>
                        </div>
                        <div class="text-[11px] text-slate-300">
                            Total Scan: <span class="text-white font-medium">{{ number_format($card->total_scans) }}</span>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="grid grid-cols-2 gap-2 pt-1">
                        <!-- Cetak Template Card -->
                        <a href="{{ route('affiliate.review_cards.print', $card->id) }}" class="py-2 px-3 rounded-lg bg-blue-600/15 hover:bg-blue-600/25 text-blue-300 font-medium text-xs flex items-center justify-center gap-1.5 transition-colors border border-blue-500/20">
                            <i class="fa-solid fa-file-arrow-down text-xs"></i>
                            <span>Desain Cetak</span>
                        </a>

                        <!-- Bantu Aktivasi Toko Klien / Terkunci jika sudah Terjual -->
                        @if($card->status !== 'active')
                        <button type="button" @click="activeCard = {{ json_encode($card) }}; activateModal = true;" class="py-2 px-3 rounded-lg bg-emerald-600 hover:bg-emerald-500 text-white font-medium text-xs flex items-center justify-center gap-1.5 transition-colors">
                            <i class="fa-solid fa-check text-xs"></i>
                            <span>Aktivasi Toko</span>
                        </button>
                        @else
                        <div class="py-2 px-3 rounded-lg bg-slate-800/60 text-slate-400 text-xs flex items-center justify-center gap-1.5 border border-white/5 cursor-not-allowed select-none" title="Kartu sudah terjual dan terkunci permanen">
                            <i class="fa-solid fa-lock text-[11px] text-slate-500"></i>
                            <span>Terkunci (Terjual)</span>
                        </div>
                        @endif
                    </div>

                </div>
                @empty
                <div class="glass-panel rounded-2xl p-6 text-center">
                    <p class="text-xs text-white font-medium mb-1">Belum Ada Kartu</p>
                    <p class="text-[11px] text-slate-400 leading-relaxed mb-4">
                        Beli kuota kartu QR di atas untuk memulai penawaran ke pemilik bisnis atau kafe di sekitar Anda.
                    </p>
                    <button type="button" @click="selectedQty = 1; selectedCost = 10000; buyModal = true;" class="py-2 px-4 bg-blue-600 hover:bg-blue-500 text-white text-xs font-medium rounded-lg">
                        Beli 1 Unit (Rp 10.000)
                    </button>
                </div>
                @endforelse
            </div>

            <!-- Pagination Controls -->
            @if($myCards->hasPages())
            <div class="mt-5 glass-panel p-2.5 rounded-xl flex items-center justify-between text-xs text-slate-300">
                <div class="text-[11px] text-slate-400 pl-1">
                    Hal <span class="font-semibold text-white">{{ $myCards->currentPage() }}</span> dari <span class="font-semibold text-white">{{ $myCards->lastPage() }}</span>
                </div>

                <div class="flex items-center gap-1.5">
                    {{-- Previous Page Link --}}
                    @if($myCards->onFirstPage())
                    <span class="w-8 h-8 rounded-lg bg-white/5 text-slate-500 flex items-center justify-center cursor-not-allowed">
                        <i class="fa-solid fa-chevron-left text-[10px]"></i>
                    </span>
                    @else
                    <a href="{{ $myCards->previousPageUrl() }}" class="w-8 h-8 rounded-lg bg-white/10 text-white hover:bg-blue-600 flex items-center justify-center transition-colors">
                        <i class="fa-solid fa-chevron-left text-[10px]"></i>
                    </a>
                    @endif

                    {{-- Current Page Pill --}}
                    <span class="px-2.5 h-8 rounded-lg bg-blue-600 text-white font-semibold flex items-center justify-center text-xs">
                        {{ $myCards->currentPage() }}
                    </span>

                    {{-- Next Page Link --}}
                    @if($myCards->hasMorePages())
                    <a href="{{ $myCards->nextPageUrl() }}" class="w-8 h-8 rounded-lg bg-white/10 text-white hover:bg-blue-600 flex items-center justify-center transition-colors">
                        <i class="fa-solid fa-chevron-right text-[10px]"></i>
                    </a>
                    @else
                    <span class="w-8 h-8 rounded-lg bg-white/5 text-slate-500 flex items-center justify-center cursor-not-allowed">
                        <i class="fa-solid fa-chevron-right text-[10px]"></i>
                    </span>
                    @endif
                </div>
            </div>
            @endif
        </div>

    </div>

    <!-- Modal Konfirmasi Beli Kuota QR -->
    <div x-show="buyModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4" style="background-color: rgba(11, 17, 32, 0.85); backdrop-filter: blur(8px);">
        <div @click.away="buyModal = false" class="bg-slate-900 border border-slate-700 rounded-2xl max-w-sm w-full p-5 shadow-2xl relative">

            <h3 class="font-semibold text-sm text-white mb-1">
                Beli Kuota Kartu QR
            </h3>
            <p class="text-xs text-slate-400 mb-4">
                Pembayaran otomatis via QRIS Dinamis. Stok kartu akan langsung aktif di akun Anda setelah diverifikasi admin.
            </p>

            <div class="bg-slate-800/80 rounded-xl p-3 border border-slate-700 text-xs space-y-2 mb-4">
                <div class="flex justify-between">
                    <span class="text-slate-400">Jumlah Unit</span>
                    <span class="font-medium text-white" x-text="selectedQty + ' Unit Kartu'"></span>
                </div>
                <div class="flex justify-between border-t border-slate-700/60 pt-2">
                    <span class="text-slate-400">Total Harga</span>
                    <span class="font-semibold text-emerald-400" x-text="'Rp ' + Number(selectedCost).toLocaleString('id-ID')"></span>
                </div>
                <div class="flex justify-between border-t border-slate-700/60 pt-2">
                    <span class="text-slate-400">Metode Pembayaran</span>
                    <span class="text-blue-400 font-medium flex items-center gap-1">
                        <i class="fa-solid fa-qrcode text-[10px]"></i> QRIS Dinamis (DANA/Bank)
                    </span>
                </div>
            </div>

            <form action="{{ route('affiliate.review_cards.buy') }}" method="POST">
                @csrf
                <input type="hidden" name="quantity" :value="selectedQty">

                <div class="flex items-center gap-2">
                    <button type="button" @click="buyModal = false" class="flex-1 py-2.5 bg-slate-800 hover:bg-slate-700 text-slate-300 font-medium text-xs rounded-lg">
                        Batal
                    </button>
                    <button type="submit" class="flex-1 py-2.5 bg-blue-600 hover:bg-blue-500 text-white font-medium text-xs rounded-lg shadow-md shadow-blue-600/30">
                        Lanjut ke QRIS
                    </button>
                </div>
            </form>

        </div>
    </div>

    <!-- Modal Aktivasi Toko Klien -->
    <div x-show="activateModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4" style="background-color: rgba(11, 17, 32, 0.85); backdrop-filter: blur(8px);">
        <div @click.away="activateModal = false" class="bg-slate-900 border border-slate-700 rounded-2xl max-w-sm w-full p-5 shadow-2xl relative">

            <div class="flex items-center justify-between pb-3 border-b border-slate-800 mb-3">
                <div>
                    <h3 class="font-semibold text-sm text-white">Hubungkan Kartu ke Toko</h3>
                    <p class="text-[11px] text-slate-400" x-text="'Nomor Seri: ' + (activeCard ? activeCard.serial_number : '')"></p>
                </div>
                <button type="button" @click="activateModal = false" class="text-slate-400 hover:text-white">
                    <i class="fa-solid fa-xmark text-sm"></i>
                </button>
            </div>

            <form :action="'{{ url('/partner/review-cards') }}/' + (activeCard ? activeCard.id : '') + '/activate-for-client'" method="POST" class="space-y-3 text-xs" @submit="isActivating = true">
                @csrf

                <div>
                    <label class="block font-medium text-slate-300 mb-1">Nama Tempat Usaha</label>
                    <input type="text" name="business_name" :value="activeCard ? activeCard.business_name : ''" required placeholder="Contoh: Kopi Titik Koma" class="w-full px-3 py-2 bg-slate-800 border border-slate-700 rounded-lg text-white text-xs focus:ring-1 focus:ring-blue-500 outline-none">
                </div>

                <div>
                    <label class="block font-medium text-slate-300 mb-1">Link Google Maps / Review Toko</label>
                    <input type="url" name="google_review_url" :value="activeCard ? activeCard.google_review_url : ''" required placeholder="Contoh: https://maps.app.goo.gl/... atau link Google Maps toko" class="w-full px-3 py-2 bg-slate-800 border border-slate-700 rounded-lg text-white text-xs focus:ring-1 focus:ring-blue-500 outline-none">
                    <p class="text-[10px] text-slate-400 mt-1 flex items-start gap-1.5 leading-relaxed">
                        <i class="fa-brands fa-google text-blue-400 mt-0.5 flex-shrink-0"></i>
                        <span>Cukup masukkan link share dari Google Maps toko klien. Sistem akan otomatis mengubahnya menjadi link review langsung (Google Place ID).</span>
                    </p>
                </div>

                <div>
                    <label class="block font-medium text-slate-400 mb-1">Nomor WhatsApp Klien (Opsional)</label>
                    <input type="text" name="owner_phone" placeholder="08xxxxxxxxxx" class="w-full px-3 py-2 bg-slate-800 border border-slate-700 rounded-lg text-white text-xs focus:ring-1 focus:ring-blue-500 outline-none">
                </div>

                <div class="pt-2">
                    <button type="submit" :disabled="isActivating" class="w-full py-2.5 bg-blue-600 hover:bg-blue-500 disabled:opacity-50 text-white font-medium text-xs rounded-lg flex items-center justify-center gap-2 transition">
                        <template x-if="isActivating">
                            <i class="fa-solid fa-circle-notch fa-spin"></i>
                        </template>
                        <span x-text="isActivating ? 'Memproses Google Place ID...' : 'Simpan & Aktifkan'"></span>
                    </button>
                </div>
            </form>

        </div>
    </div>

</body>
</html>
