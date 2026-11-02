@extends('layouts.admin.app')

@section('content')
<div class="px-4 lg:px-6 py-6 lg:py-8" x-data="ppobAdmin()">

    <!-- Header & Breadcrumbs -->
    <div class="mb-8 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <div class="flex items-center gap-2 text-xs font-semibold uppercase tracking-wider text-slate-400 mb-1">
                <span>Admin Panel</span>
                <i class="fa-solid fa-chevron-right text-[10px]"></i>
                <span class="text-blue-600">PPOB & Integrasi Digiflazz</span>
            </div>
            <h1 class="text-2xl font-bold text-slate-800 flex items-center gap-2.5">
                <span class="w-9 h-9 rounded-xl bg-gradient-to-br from-amber-500 to-orange-600 flex items-center justify-center text-white shadow-sm shadow-amber-500/20">
                    <i class="fa-solid fa-bolt text-sm"></i>
                </span>
                PPOB & Saldo Digiflazz
            </h1>
            <p class="text-slate-500 text-sm mt-1">Pantau sisa deposit akun, status server API Digiflazz, dan kelola konfigurasi transaksi digital.</p>
        </div>

        <div class="flex items-center gap-2.5 w-full sm:w-auto">
            <button @click="refreshBalance()" :disabled="isLoading" class="inline-flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 active:bg-blue-800 text-white px-4 py-2.5 rounded-xl shadow-sm text-sm font-semibold transition-all w-full sm:w-auto disabled:opacity-60 cursor-pointer">
                <i class="fa-solid fa-arrows-rotate" :class="{ 'fa-spin': isLoading }"></i>
                <span x-text="isLoading ? 'Memeriksa...' : 'Refresh Saldo'"></span>
            </button>
        </div>
    </div>

    <!-- Alert / Status Banner -->
    <template x-if="statusMessage">
        <div class="p-4 rounded-xl mb-6 text-sm flex items-center gap-3 border shadow-sm transition-all" :class="isSuccess ? 'bg-emerald-50 border-emerald-200 text-emerald-800' : 'bg-rose-50 border-rose-200 text-rose-800'">
            <i class="fa-solid text-base" :class="isSuccess ? 'fa-circle-check text-emerald-500' : 'fa-circle-exclamation text-rose-500'"></i>
            <span class="flex-1 font-medium" x-text="statusMessage"></span>
            <button @click="statusMessage = ''" class="text-slate-400 hover:text-slate-600 cursor-pointer">
                <i class="fa-solid fa-xmark text-sm"></i>
            </button>
        </div>
    </template>

    <!-- Main Hero Saldo Card -->
    <div class="relative overflow-hidden rounded-2xl p-6 lg:p-8 mb-8 text-white shadow-xl" style="background: linear-gradient(135deg, #0F172A 0%, #1E293B 50%, #0F172A 100%); border: 1px solid rgba(255, 255, 255, 0.08);">

        <!-- Ambient Glow -->
        <div class="absolute -top-24 -right-24 w-72 h-72 bg-blue-600/20 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-24 -left-24 w-72 h-72 bg-amber-500/15 rounded-full blur-3xl pointer-events-none"></div>

        <div class="relative z-10 flex flex-col lg:flex-row justify-between items-start lg:items-center gap-6">
            <div>
                <div class="flex items-center gap-2.5 mb-3">
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold tracking-wide" :class="isConnected ? 'bg-emerald-500/20 text-emerald-300 border border-emerald-500/30' : 'bg-rose-500/20 text-rose-300 border border-rose-500/30'">
                        <span class="w-2 h-2 rounded-full animate-pulse" :class="isConnected ? 'bg-emerald-400' : 'bg-rose-400'"></span>
                        <span x-text="isConnected ? 'Server Digiflazz Terhubung (200 OK)' : 'Koneksi Terputus / Perlu Cek'"></span>
                    </span>
                    <span class="text-xs text-slate-400">
                        • Diperiksa: <span class="text-slate-200 font-mono" x-text="lastChecked"></span>
                    </span>
                </div>

                <p class="text-sm font-medium text-slate-400 uppercase tracking-wider mb-1">
                    <i class="fa-solid fa-wallet text-amber-400 mr-1.5"></i> Sisa Saldo Deposit Aktif
                </p>

                <div class="flex items-baseline gap-2">
                    <span class="text-2xl lg:text-3xl font-bold text-slate-300">Rp</span>
                    <span class="text-4xl lg:text-5xl font-black tracking-tight text-white font-mono" x-text="formatRupiah(balance)">
                        {{ number_format($balance, 0, ',', '.') }}
                    </span>
                </div>

                <p class="text-xs text-slate-400 mt-2 flex items-center gap-1.5">
                    <i class="fa-solid fa-circle-info text-blue-400"></i>
                    Saldo ini digunakan sebagai modal otomatis untuk memproses transaksi pulsa, data, PLN, dan topup lainnya.
                </p>
            </div>

            <!-- Action buttons inside Card -->
            <div class="flex flex-col sm:flex-row lg:flex-col gap-3 w-full lg:w-auto">
                <button @click="refreshBalance()" :disabled="isLoading" class="inline-flex items-center justify-center gap-2 px-5 py-3 rounded-xl bg-white/10 hover:bg-white/20 active:bg-white/25 border border-white/15 text-white text-sm font-semibold transition-all backdrop-blur-md cursor-pointer disabled:opacity-50 shadow-sm">
                    <i class="fa-solid fa-arrows-rotate" :class="{ 'fa-spin': isLoading }"></i>
                    <span x-text="isLoading ? 'Memuat Saldo...' : 'Refresh Saldo Live'"></span>
                </button>
                <div class="text-[11px] text-center text-slate-400 font-mono">
                    Endpoint: <span class="text-slate-300">/api/digiflazz/cek-saldo</span>
                </div>
            </div>
        </div>
    </div>

    <!-- 3 Status Grid Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-8">

        <!-- Card 1: Akun Digiflazz -->
        <div class="bg-white rounded-xl p-5 border border-slate-200 shadow-sm flex items-start gap-4">
            <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center flex-shrink-0 text-lg">
                <i class="fa-solid fa-user-shield"></i>
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Username API</p>
                <p class="text-base font-bold text-slate-800 font-mono mt-0.5 truncate">{{ $username ?: '-' }}</p>
                <div class="mt-2 flex items-center gap-1.5 text-xs text-emerald-600 font-medium">
                    <i class="fa-solid fa-circle-check text-[11px]"></i>
                    <span>Tervalidasi di Digiflazz</span>
                </div>
            </div>
        </div>

        <!-- Card 2: Environment API -->
        <div class="bg-white rounded-xl p-5 border border-slate-200 shadow-sm flex items-start gap-4">
            <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center flex-shrink-0 text-lg">
                <i class="fa-solid fa-sliders"></i>
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Mode Environment</p>
                <div class="mt-1 flex items-center gap-2">
                    @if($isProduction)
                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800">
                        <i class="fa-solid fa-circle-play text-[10px]"></i> Production Live
                    </span>
                    @else
                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-bold bg-amber-100 text-amber-800">
                        <i class="fa-solid fa-flask text-[10px]"></i> Development / Sandbox
                    </span>
                    @endif
                </div>
                <p class="text-[11px] text-slate-500 mt-2 font-mono truncate">
                    Key: {{ substr($apiKey, 0, 8) }}••••••••
                </p>
            </div>
        </div>

        <!-- Card 3: Status Webhook -->
        <div class="bg-white rounded-xl p-5 border border-slate-200 shadow-sm flex items-start gap-4">
            <div class="w-12 h-12 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center flex-shrink-0 text-lg">
                <i class="fa-solid fa-satellite-dish"></i>
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Status Webhook</p>
                <div class="mt-1 flex items-center gap-2">
                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-bold bg-indigo-100 text-indigo-800">
                        <i class="fa-solid fa-link text-[10px]"></i> /api/digiflazz/webhook
                    </span>
                </div>
                <p class="text-[11px] text-slate-500 mt-2">
                    Secret: <span class="font-mono text-slate-700 font-semibold">{{ $webhookSecret ? 'Terpasang (HMAC sha1)' : 'Belum diisi' }}</span>
                </p>
            </div>
        </div>

    </div>

    <!-- Real-time API Response Monitor (Developer Inspector) -->
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden mb-8">
        <div class="px-5 py-4 border-b border-slate-100 flex items-center justify-between">
            <div class="flex items-center gap-2.5">
                <i class="fa-solid fa-code text-slate-500"></i>
                <h3 class="text-sm font-bold text-slate-800">Live JSON Response Inspector</h3>
                <span class="text-xs px-2 py-0.5 rounded bg-slate-100 text-slate-600 font-mono">GET /api/digiflazz/cek-saldo</span>
            </div>
            <button @click="showRaw = !showRaw" class="text-xs font-semibold text-blue-600 hover:text-blue-800 flex items-center gap-1 cursor-pointer">
                <span x-text="showRaw ? 'Sembunyikan Raw JSON' : 'Lihat Raw JSON'"></span>
                <i class="fa-solid" :class="showRaw ? 'fa-chevron-up' : 'fa-chevron-down'"></i>
            </button>
        </div>

        <div x-show="showRaw" x-collapse class="p-5 bg-slate-900 font-mono text-xs text-slate-200 overflow-x-auto" style="scrollbar-width: thin;">
            <pre class="leading-relaxed" x-text="JSON.stringify(rawResponse, null, 2)"></pre>
        </div>
    </div>

</div>

<script>
    function ppobAdmin() {
        return {
            balance: {
                {
                    (int) $balance
                }
            }
            , isLoading: false
            , isConnected: {
                {
                    $balanceStatus ? 'true' : 'false'
                }
            }
            , isSuccess: true
            , statusMessage: ''
            , lastChecked: '{{ date("H:i:s") }} WIB'
            , showRaw: false
            , rawResponse: @json($balanceData),

            formatRupiah(number) {
                return new Intl.NumberFormat('id-ID').format(number || 0);
            },

            async refreshBalance() {
                this.isLoading = true;
                this.statusMessage = '';

                try {
                    const response = await fetch('/api/digiflazz/cek-saldo', {
                        headers: {
                            'Accept': 'application/json'
                        , }
                    });

                    const data = await response.json();
                    this.rawResponse = data;

                    if (response.ok && data.success) {
                        this.balance = data.digiflazz_response ? .data ? .deposit ? ? 0;
                        this.isConnected = true;
                        this.isSuccess = true;
                        this.lastChecked = new Date().toLocaleTimeString('id-ID') + ' WIB';
                        this.statusMessage = 'Saldo berhasil diperbarui langsung dari server Digiflazz!';
                    } else {
                        this.isConnected = false;
                        this.isSuccess = false;
                        this.statusMessage = data.digiflazz_response ? .data ? .message || data.message || 'Gagal mengambil saldo dari Digiflazz.';
                    }
                } catch (error) {
                    this.isConnected = false;
                    this.isSuccess = false;
                    this.statusMessage = 'Terjadi kesalahan koneksi saat memanggil /api/digiflazz/cek-saldo: ' + error.message;
                } finally {
                    this.isLoading = false;
                }
            }
        };
    }

</script>
@endsection
