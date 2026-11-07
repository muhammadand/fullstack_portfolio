<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pulsa - Harga Partner</title>
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
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        /* State aktif ditulis di sini karena .glass-panel (unlayered) menimpa utility border/bg Tailwind. */
        .glass-panel.is-active { background: rgba(255, 255, 255, 0.12); border-color: rgba(255, 255, 255, 0.3); }
        .glass-panel.is-selected { background: rgba(16, 185, 129, 0.12); border-color: rgba(52, 211, 153, 0.7); }

        .hide-scrollbar::-webkit-scrollbar { display: none; }
        .hide-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
        [x-cloak] { display: none !important; }
    </style>
    <script>
        // State halaman: operator aktif, deteksi operator dari nomor HP, toast, dan sheet konfirmasi bayar.
        function pulsaPage(prefixMap, firstSlug, balance, oldPhone) {
            return {
                active: firstSlug,
                phone: oldPhone || '',
                balance: balance,
                sheet: null,
                submitting: false,
                detected: null,
                selected: null,
                toast: '',
                toastTimer: null,
                onPhoneInput() {
                    let digits = this.phone.replace(/\D/g, '');
                    if (digits.startsWith('62')) digits = '0' + digits.slice(2);
                    if (digits.startsWith('8')) digits = '0' + digits;
                    this.phone = digits.slice(0, 13);

                    this.detected = null;
                    if (this.phone.length < 4) return;
                    const prefix = this.phone.slice(0, 4);
                    for (const [slug, prefixes] of Object.entries(prefixMap)) {
                        if (prefixes.includes(prefix)) {
                            this.detected = slug;
                            this.active = slug;
                            return;
                        }
                    }
                    this.detected = false;
                },
                init() {
                    if (this.phone) this.onPhoneInput();
                },
                pick(product) {
                    this.selected = product.id;
                    this.sheet = product;
                },
                closeSheet() {
                    if (!this.submitting) this.sheet = null;
                },
                get phoneValid() {
                    return /^08\d{8,11}$/.test(this.phone);
                },
                // Nomor harus sesuai operator produk (operator tanpa daftar prefix dilewati).
                get phoneMatches() {
                    if (!this.sheet) return false;
                    const prefixes = prefixMap[this.sheet.opSlug] || [];
                    return prefixes.length === 0 || prefixes.includes(this.phone.slice(0, 4));
                },
                get insufficient() {
                    return this.sheet && this.balance < this.sheet.price;
                },
                rupiah(v) {
                    return 'Rp ' + Math.round(v).toLocaleString('id-ID');
                },
                showToast(message) {
                    this.toast = message;
                    clearTimeout(this.toastTimer);
                    this.toastTimer = setTimeout(() => this.toast = '', 2500);
                },
            };
        }
    </script>
</head>
<body class="pb-28 overflow-x-hidden min-h-screen relative"
      x-data="pulsaPage(@js(collect($operators)->mapWithKeys(fn ($op) => [$op['slug'] => $op['prefixes']])), @js($operators[0]['slug'] ?? null), @js($walletBalance), @js(old('customer_no', '')))">
    <x-affiliate.page-loader />

    <!-- Ambient Glow Background -->
    <div class="fixed top-0 left-0 w-full h-64 bg-emerald-600/10 rounded-full blur-[110px] -translate-y-1/2 pointer-events-none z-0"></div>

    <!-- Toast -->
    <div x-cloak role="status" aria-live="polite" :class="toast ? 'opacity-100 translate-y-0' : 'opacity-0 -translate-y-2 pointer-events-none'"
         class="transition-all duration-300 fixed top-5 left-1/2 -translate-x-1/2 z-[80] px-4 py-2.5 rounded-full bg-slate-800 border border-blue-500/30 text-white text-xs font-medium shadow-2xl flex items-center gap-2 max-w-[90vw]">
        <i class="fa-solid fa-hourglass-half text-blue-400"></i>
        <span x-text="toast" class="truncate"></span>
    </div>

    <div class="relative z-10 w-full max-w-md mx-auto">

        <!-- Header -->
        <div class="flex items-center justify-between gap-3 px-4 pt-5 mb-4">
            <div class="flex items-center gap-3">
                <a href="{{ route('affiliate.menu') }}" wire:navigate class="w-10 h-10 rounded-xl glass-panel flex items-center justify-center text-slate-300 hover:text-white transition-colors active:scale-95" title="Kembali ke Semua Menu">
                    <i class="fa-solid fa-arrow-left text-sm"></i>
                </a>
                <div>
                    <h1 class="text-base font-bold text-white leading-tight">Pulsa</h1>
                    <p class="text-xs text-slate-400">Daftar harga khusus partner</p>
                </div>
            </div>
            <span class="glass-panel px-2.5 py-1 rounded-full text-[10px] font-semibold text-emerald-300 border-emerald-500/30 whitespace-nowrap">
                <i class="fa-solid fa-crown text-[9px] mr-1"></i>{{ $level['name'] }}
            </span>
        </div>

        <!-- Saldo Wallet -->
        <div class="px-4 mb-4">
            <div class="glass-panel rounded-2xl px-4 py-3 flex items-center justify-between gap-3">
                <div class="flex items-center gap-3 min-w-0">
                    <div class="w-9 h-9 rounded-xl bg-emerald-500/10 flex items-center justify-center text-emerald-400 shrink-0">
                        <i class="fa-solid fa-wallet"></i>
                    </div>
                    <div class="min-w-0">
                        <p class="text-[10px] text-slate-400">Saldo Wallet</p>
                        <p class="text-sm font-bold text-white truncate" data-wallet-balance>Rp {{ number_format($walletBalance, 0, ',', '.') }}</p>
                    </div>
                </div>
                <a href="{{ route('affiliate.dashboard', ['isi_saldo' => 1]) }}" class="shrink-0 px-3 py-2 rounded-xl bg-gradient-to-r from-emerald-500 to-teal-500 text-white text-[11px] font-bold active:scale-95 transition-transform">
                    <i class="fa-solid fa-plus mr-1"></i>Isi Saldo
                </a>
            </div>
        </div>

        @if(session('error') || $errors->any())
            <div class="px-4 mb-4" role="alert">
                <div class="flex items-start gap-2 text-xs text-red-200 bg-red-500/10 border border-red-500/30 rounded-xl px-3 py-2.5">
                    <i class="fa-solid fa-circle-exclamation text-red-400 mt-0.5"></i>
                    <span>{{ session('error') ?? $errors->first() }}</span>
                </div>
            </div>
        @endif

        @if(empty($operators))
            <!-- Empty State -->
            <div class="px-4">
                <div class="glass-panel rounded-3xl p-6 text-center">
                    <div class="w-14 h-14 mx-auto rounded-2xl bg-green-500/10 flex items-center justify-center text-green-400 text-2xl mb-3">
                        <i class="fa-solid fa-mobile-screen-button"></i>
                    </div>
                    <h2 class="text-sm font-bold text-white mb-1">Produk pulsa belum tersedia</h2>
                    <p class="text-xs text-slate-400 leading-relaxed">Daftar harga sedang disiapkan admin. Coba cek lagi nanti ya.</p>
                </div>
            </div>
        @else
            <!-- Cek Operator dari Nomor -->
            <div class="px-4 mb-4">
                <label for="phone" class="block text-[11px] font-semibold text-slate-400 mb-1.5 pl-1">Cek operator dari nomor HP</label>
                <div class="glass-panel rounded-2xl flex items-center gap-3 px-4 py-3 focus-within:border-emerald-500/50 transition-colors">
                    <i class="fa-solid fa-mobile-screen-button text-slate-400"></i>
                    <input id="phone" type="tel" inputmode="numeric" autocomplete="tel" placeholder="Contoh: 0812 3456 7890"
                           x-model="phone" @input="onPhoneInput()"
                           class="flex-1 min-w-0 bg-transparent text-sm text-white placeholder-slate-500 outline-none">
                    <button type="button" x-show="phone" x-cloak @click="phone = ''; detected = null" class="text-slate-500 hover:text-white" aria-label="Hapus nomor">
                        <i class="fa-solid fa-circle-xmark"></i>
                    </button>
                </div>
                <p class="text-[11px] mt-1.5 pl-1 min-h-[1rem]">
                    @foreach($operators as $op)
                        <span x-show="detected === @js($op['slug'])" x-cloak class="text-emerald-400"><i class="fa-solid fa-circle-check mr-1"></i>Operator: {{ $op['name'] }}</span>
                    @endforeach
                    <span x-show="detected === false" x-cloak class="text-amber-400"><i class="fa-solid fa-circle-info mr-1"></i>Operator tidak dikenali, pilih manual di bawah.</span>
                </p>
            </div>

            <!-- Pilihan Operator (sticky) -->
            <div class="sticky top-0 z-20 bg-[#0B1120]/90 backdrop-blur-md py-2 mb-3">
                <div class="flex gap-2 overflow-x-auto hide-scrollbar px-4">
                    @foreach($operators as $op)
                        <button type="button" @click="active = @js($op['slug'])"
                                :class="active === @js($op['slug']) ? 'is-active text-white' : 'text-slate-400'"
                                class="shrink-0 flex items-center gap-2 pl-1.5 pr-3 py-1.5 rounded-full glass-panel text-xs font-semibold transition-colors active:scale-95">
                            @if($op['image'])
                                <img src="{{ asset('storage/' . $op['image']) }}" alt="" class="w-6 h-6 rounded-full object-cover bg-white" loading="lazy">
                            @else
                                <span class="w-6 h-6 rounded-full bg-slate-800 flex items-center justify-center text-[10px] font-bold {{ $op['color'] }}">{{ mb_strtoupper(mb_substr($op['name'], 0, 1)) }}</span>
                            @endif
                            {{ $op['name'] }}
                        </button>
                    @endforeach
                </div>
            </div>

            <!-- Info Harga -->
            <div class="px-4 mb-3">
                <div class="flex items-start gap-2 text-[11px] text-slate-400 bg-emerald-500/5 border border-emerald-500/20 rounded-xl px-3 py-2">
                    <i class="fa-solid fa-circle-info text-emerald-400 mt-0.5"></i>
                    <span><span class="text-emerald-300 font-semibold">Harga Partner</span> adalah modal kamu. <span class="text-slate-300">Harga normal</span> = harga yang dibayar customer langsung.</span>
                </div>
            </div>

            <!-- Daftar Produk per Operator -->
            @foreach($operators as $op)
                <div x-show="active === @js($op['slug'])" @if(!$loop->first) x-cloak @endif class="px-4" data-operator="{{ $op['slug'] }}">
                    <div class="grid grid-cols-2 gap-3">
                        @foreach($op['products'] as $product)
                            @if($product['available'])
                                <button type="button" @click="pick(@js(['id' => $product['id'], 'name' => $product['name'], 'price' => $product['price'], 'opName' => $op['name'], 'opSlug' => $op['slug']]))"
                                        :class="selected === {{ $product['id'] }} ? 'is-selected' : ''"
                                        class="glass-panel rounded-2xl p-3 text-left transition-all active:scale-[0.97]" data-product-id="{{ $product['id'] }}">
                                    <span class="block text-[10px] text-slate-400 font-medium">Pulsa</span>
                                    <span class="block text-base font-bold text-white leading-tight mb-2 break-words">{{ $product['name'] }}</span>
                                    <span class="block text-[10px] text-emerald-300/80">Harga Partner</span>
                                    <span class="block text-sm font-bold text-emerald-400">Rp {{ number_format($product['price'], 0, ',', '.') }}</span>
                                    @if($product['profit'] > 0)
                                        <span class="block mt-2 pt-2 border-t border-white/5 text-[10px] text-slate-400">Normal Rp {{ number_format($product['retail_price'], 0, ',', '.') }}</span>
                                        <span class="inline-block mt-1 text-[10px] text-amber-300 font-semibold bg-amber-500/10 rounded-full px-1.5 py-0.5 whitespace-nowrap">Untung Rp {{ number_format($product['profit'], 0, ',', '.') }}</span>
                                    @endif
                                </button>
                            @else
                                <div class="glass-panel rounded-2xl p-3 opacity-50 relative" aria-disabled="true" data-product-id="{{ $product['id'] }}">
                                    <span class="absolute top-2 right-2 text-[9px] font-semibold bg-slate-700 text-slate-200 rounded-full px-1.5 py-0.5">Gangguan</span>
                                    <span class="block text-[10px] text-slate-400 font-medium">Pulsa</span>
                                    <span class="block text-base font-bold text-white leading-tight mb-2 break-words">{{ $product['name'] }}</span>
                                    <span class="block text-[10px] text-slate-400">Sementara tidak tersedia</span>
                                    <span class="block text-sm font-bold text-slate-400">Rp {{ number_format($product['price'], 0, ',', '.') }}</span>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            @endforeach
        @endif
    </div>

    <!-- Sheet Konfirmasi Pembayaran (Saldo Wallet) -->
    <div x-show="sheet" x-cloak class="fixed inset-0 z-[70] flex flex-col justify-end" role="dialog" aria-modal="true" aria-labelledby="sheetTitle">
        <div class="absolute inset-0 bg-slate-950/70" @click="closeSheet()"></div>
        <form method="POST" action="{{ route('affiliate.ppob.pulsa.order') }}" @submit="submitting = true"
              class="relative w-full max-w-md mx-auto bg-[#0B1120] border-t border-white/10 rounded-t-3xl p-5 pb-8">
            @csrf
            <input type="hidden" name="product_id" :value="sheet?.id">
            <input type="hidden" name="idempotency_key" value="{{ $idempotencyKey }}">

            <div class="w-12 h-1.5 bg-slate-700/80 rounded-full mx-auto mb-4"></div>
            <div class="flex items-center justify-between mb-4">
                <h2 id="sheetTitle" class="text-base font-bold text-white">Konfirmasi Pembelian</h2>
                <button type="button" @click="closeSheet()" class="w-8 h-8 rounded-full bg-slate-800 text-slate-400 hover:text-white" aria-label="Tutup">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            <label for="sheetPhone" class="block text-[11px] font-semibold text-slate-400 mb-1.5 pl-1">Nomor HP tujuan</label>
            <div class="glass-panel rounded-2xl flex items-center gap-3 px-4 py-3 mb-1.5 focus-within:border-emerald-500/50">
                <i class="fa-solid fa-mobile-screen-button text-slate-400"></i>
                <input id="sheetPhone" name="customer_no" type="tel" inputmode="numeric" autocomplete="tel" required placeholder="08xxxxxxxxxx"
                       x-model="phone" @input="onPhoneInput()" class="flex-1 min-w-0 bg-transparent text-sm text-white placeholder-slate-500 outline-none">
            </div>
            <p class="text-[11px] pl-1 mb-4 min-h-[1rem]">
                <span x-show="phone && !phoneValid" class="text-amber-400">Format nomor 08xxxxxxxxxx (10-13 digit).</span>
                <span x-show="phoneValid && !phoneMatches" class="text-amber-400">Nomor ini bukan <span x-text="sheet?.opName"></span>.</span>
            </p>

            <div class="glass-panel rounded-2xl p-4 space-y-2.5 text-xs mb-4">
                <div class="flex justify-between gap-3"><span class="text-slate-400">Produk</span><span class="text-white font-semibold text-right" x-text="sheet ? `Pulsa ${sheet.opName} ${sheet.name}` : ''"></span></div>
                <div class="flex justify-between gap-3"><span class="text-slate-400">Harga Partner</span><span class="text-emerald-400 font-bold" x-text="sheet ? rupiah(sheet.price) : ''"></span></div>
                <div class="flex justify-between gap-3 pt-2.5 border-t border-white/5"><span class="text-slate-400">Saldo Wallet</span><span class="text-white" x-text="rupiah(balance)"></span></div>
                <div class="flex justify-between gap-3"><span class="text-slate-400" x-text="insufficient ? 'Saldo Kurang' : 'Sisa Saldo'"></span><span :class="insufficient ? 'text-red-400' : 'text-white'" class="font-semibold" x-text="sheet ? rupiah(Math.abs(balance - sheet.price)) : ''"></span></div>
            </div>

            <template x-if="insufficient">
                <a href="{{ route('affiliate.dashboard', ['isi_saldo' => 1]) }}" class="block w-full text-center py-3.5 rounded-2xl bg-gradient-to-r from-emerald-500 to-teal-500 text-white text-sm font-bold active:scale-[0.98]">
                    <i class="fa-solid fa-wallet mr-1.5"></i>Saldo kurang, Isi Saldo
                </a>
            </template>
            <template x-if="!insufficient">
                <button type="submit" :disabled="submitting || !phoneValid || !phoneMatches"
                        class="w-full py-3.5 rounded-2xl bg-gradient-to-r from-emerald-500 to-teal-500 text-white text-sm font-bold active:scale-[0.98] disabled:opacity-40 disabled:cursor-not-allowed">
                    <span x-show="!submitting"><i class="fa-solid fa-lock mr-1.5"></i>Bayar dengan Saldo</span>
                    <span x-show="submitting"><i class="fa-solid fa-spinner fa-spin mr-1.5"></i>Memproses...</span>
                </button>
            </template>
            <p class="text-[10px] text-slate-500 text-center mt-3">Saldo otomatis dikembalikan bila transaksi gagal.</p>
        </form>
    </div>

    <x-affiliate.bottom-nav />
</body>
</html>
