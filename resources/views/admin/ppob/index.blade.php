@extends('layouts.admin.app')

@section('content')
<div x-data="ppobAdmin()">

    {{-- Page Header --}}
    <x-admin.page-header title="Integrasi Digiflazz (PPOB)" subtitle="Pantau saldo deposit akun, status koneksi API Digiflazz, dan kelola konfigurasi transaksi digital." />

    {{-- Sub-navigation Tabs --}}
    <div class="flex items-center gap-2 border-b border-slate-200 pb-3 mb-6 overflow-x-auto text-xs" style="scrollbar-width: none;">
        <a href="{{ route('admin.ppob.index') }}" class="inline-flex items-center gap-2 px-3.5 py-2 rounded-xl font-semibold bg-blue-600 text-white shadow-xs">
            <i class="fa-solid fa-wallet text-xs"></i>
            <span>Cek Saldo & Akun</span>
        </a>
        <div class="inline-flex items-center gap-2 px-3.5 py-2 rounded-xl font-medium text-slate-400 bg-slate-100 cursor-not-allowed opacity-80" title="Fitur dalam pengembangan">
            <i class="fa-solid fa-tags text-xs"></i>
            <span>Daftar Harga Produk</span>
            <span class="text-[9px] px-1.5 py-0.5 rounded bg-slate-200 text-slate-600 font-bold uppercase tracking-wider">Segera</span>
        </div>
        <div class="inline-flex items-center gap-2 px-3.5 py-2 rounded-xl font-medium text-slate-400 bg-slate-100 cursor-not-allowed opacity-80" title="Fitur dalam pengembangan">
            <i class="fa-solid fa-satellite-dish text-xs"></i>
            <span>Log Webhook</span>
            <span class="text-[9px] px-1.5 py-0.5 rounded bg-slate-200 text-slate-600 font-bold uppercase tracking-wider">Segera</span>
        </div>
    </div>

    {{-- Main Hero Saldo Card --}}
    <x-admin.card class="mb-6 overflow-hidden relative">
        <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-6">
            <div class="space-y-3">
                <div class="flex flex-wrap items-center gap-2.5">
                    <template x-if="isConnected">
                        <x-admin.badge color="green">
                            <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse mr-1"></span>
                            Server Digiflazz Terhubung (200 OK)
                        </x-admin.badge>
                    </template>
                    <template x-if="!isConnected">
                        <x-admin.badge color="yellow">
                            <span class="w-2 h-2 rounded-full bg-amber-500 mr-1"></span>
                            Koneksi Terputus / Perlu Cek
                        </x-admin.badge>
                    </template>

                    <span class="text-xs text-slate-400">
                        • Diperiksa: <span class="font-mono text-slate-600 font-medium" x-text="lastChecked">{{ date('H:i:s') }} WIB</span>
                    </span>
                </div>

                <div>
                    <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1 flex items-center gap-1.5">
                        <i class="fa-solid fa-wallet text-amber-500"></i> Sisa Saldo Deposit Aktif
                    </p>
                    <div class="flex items-baseline gap-2">
                        <span class="text-2xl lg:text-3xl font-bold text-slate-400">Rp</span>
                        <span class="text-4xl lg:text-5xl font-black text-slate-900 font-mono tracking-tight" x-text="formatRupiah(balance)">
                            {{ number_format($balance, 0, ',', '.') }}
                        </span>
                    </div>
                </div>

                <p class="text-xs text-slate-500 flex items-center gap-1.5 max-w-2xl">
                    <i class="fa-solid fa-circle-info text-blue-500 shrink-0"></i>
                    Saldo ini digunakan sebagai modal otomatis untuk memproses transaksi pulsa, paket data, token PLN, e-wallet, dan produk PPOB lainnya.
                </p>
            </div>

            {{-- Action Box inside Card --}}
            <div class="flex flex-col sm:flex-row lg:flex-col gap-2.5 w-full lg:w-auto shrink-0">
                <x-admin.button type="button" @click="refreshBalance()" ::disabled="isLoading" class="w-full justify-center">
                    <i class="fa-solid fa-arrows-rotate mr-1.5" :class="{ 'fa-spin': isLoading }"></i>
                    <span x-text="isLoading ? 'Memeriksa...' : 'Refresh Saldo'"></span>
                </x-admin.button>

                <div class="text-[11px] text-center text-slate-400 font-mono py-1 px-3 bg-slate-50 border border-slate-200/80 rounded-lg">
                    Endpoint: <span class="text-slate-700 font-semibold">POST /cek-saldo</span>
                </div>
            </div>
        </div>
    </x-admin.card>

    {{-- 3 Status Metric Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">

        {{-- Card 1: Akun Digiflazz --}}
        <div class="bg-white rounded-xl p-4 border border-slate-200/80 shadow-xs flex items-start gap-3.5">
            <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 border border-blue-100 flex items-center justify-center shrink-0 text-sm">
                <i class="fa-solid fa-user-shield"></i>
            </div>
            <div class="min-w-0 flex-1">
                <p class="text-xs font-medium text-slate-400 uppercase tracking-wider">Username API</p>
                <p class="text-sm font-bold text-slate-900 font-mono mt-0.5 truncate">{{ $username ?: '-' }}</p>
                <div class="mt-2">
                    <x-admin.badge color="blue">
                        <i class="fa-solid fa-circle-check text-[10px]"></i> Tervalidasi di Digiflazz
                    </x-admin.badge>
                </div>
            </div>
        </div>

        {{-- Card 2: Mode Environment + switch dev/prod --}}
        <div class="bg-white rounded-xl p-4 border shadow-xs flex items-start gap-3.5 {{ $isProduction ? 'border-emerald-300 ring-1 ring-emerald-200' : 'border-slate-200/80' }}">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center shrink-0 text-sm border {{ $isProduction ? 'bg-emerald-50 text-emerald-600 border-emerald-100' : 'bg-amber-50 text-amber-600 border-amber-100' }}">
                <i class="fa-solid {{ $isProduction ? 'fa-circle-play' : 'fa-flask' }}"></i>
            </div>
            <div class="min-w-0 flex-1">
                <p class="text-xs font-medium text-slate-400 uppercase tracking-wider">Mode Environment</p>
                <p class="text-sm font-bold mt-0.5 {{ $isProduction ? 'text-emerald-700' : 'text-amber-700' }}">{{ $isProduction ? 'Production Live' : 'Development / Sandbox' }}</p>

                <form method="POST" action="{{ route('admin.ppob.mode') }}" class="mt-2"
                      >
                    @csrf
                    <div class="grid grid-cols-2 w-full max-w-[220px] rounded-lg bg-slate-100 p-0.5 text-xs font-semibold" role="radiogroup" aria-label="Mode Digiflazz">
                        @foreach(['development' => ['Dev', 'fa-flask'], 'production' => ['Prod', 'fa-circle-play']] as $value => [$label, $icon])
                        @php $active = $mode === $value; @endphp
                        <button type="submit" name="mode" value="{{ $value }}" role="radio" aria-checked="{{ $active ? 'true' : 'false' }}"
                                @if($value === 'production') data-confirm-title="Pindah ke Production?" data-confirm="Semua transaksi akan dikirim sungguhan dan memotong saldo Digiflazz." data-confirm-button="Ya, pindah" data-confirm-danger @endif
                                @disabled($active || ! $keyReady[$value])
                                title="{{ $keyReady[$value] ? ucfirst($value) : 'API key mode ini belum diisi di .env' }}"
                                @class(['inline-flex items-center justify-center gap-1.5 px-2 py-1.5 rounded-md transition-colors',
                                        'bg-white shadow-xs ' . ($value === 'production' ? 'text-emerald-700' : 'text-amber-700') => $active,
                                        'text-slate-500 hover:text-slate-800' => ! $active && $keyReady[$value],
                                        'text-slate-300 cursor-not-allowed' => ! $active && ! $keyReady[$value]])>
                            <i class="fa-solid {{ $icon }} text-[10px]"></i> {{ $label }}
                        </button>
                        @endforeach
                    </div>
                </form>

                <p class="text-[11px] text-slate-400 mt-2 font-mono truncate">
                    Key: {{ $apiKey !== '' ? substr($apiKey, 0, 8) . '••••••••' : 'belum diisi' }}
                </p>
                @foreach($keyReady as $m => $ready)
                    @unless($ready)
                    <p class="text-[11px] text-amber-600 mt-1 break-words"><i class="fa-solid fa-triangle-exclamation"></i> Key {{ $m }} belum diisi: <code class="break-all">{{ $m === 'production' ? 'DIGIFLAZZ_PROD_API_KEY' : 'DIGIFLAZZ_DEV_API_KEY' }}</code></p>
                    @endunless
                @endforeach

                @if($modeLogs->isNotEmpty())
                <details class="mt-2 text-[11px] text-slate-500">
                    <summary class="cursor-pointer">Riwayat perubahan mode</summary>
                    <ul class="mt-1.5 space-y-1">
                        @foreach($modeLogs as $log)
                        <li>{{ $log->created_at->format('d M Y H:i') }} · {{ $log->old_value ?? 'default' }} → <span class="font-semibold">{{ $log->new_value }}</span> · {{ $log->user_email ?? 'system' }}</li>
                        @endforeach
                    </ul>
                </details>
                @endif
            </div>
        </div>

        {{-- Card 3: Status Webhook --}}
        <div class="bg-white rounded-xl p-4 border border-slate-200/80 shadow-xs flex items-start gap-3.5">
            <div class="w-10 h-10 rounded-xl bg-indigo-50 text-indigo-600 border border-indigo-100 flex items-center justify-center shrink-0 text-sm">
                <i class="fa-solid fa-satellite-dish"></i>
            </div>
            <div class="min-w-0 flex-1">
                <p class="text-xs font-medium text-slate-400 uppercase tracking-wider">Status Webhook</p>
                <div class="mt-1">
                    <code class="text-[11px] font-mono font-semibold text-indigo-700 bg-indigo-50 border border-indigo-200/80 px-2 py-0.5 rounded">
                        /api/digiflazz/webhook
                    </code>
                </div>
                <p class="text-[11px] text-slate-400 mt-2">
                    Secret: <span class="font-mono text-slate-700 font-medium">{{ $webhookSecret ? 'Terpasang (HMAC sha1)' : 'Belum diisi' }}</span>
                </p>
            </div>
        </div>

    </div>

    {{-- Live JSON Response Inspector Card --}}
    <x-admin.card title="Live JSON Response Inspector" icon="fa-solid fa-code" class="mb-6">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-4 mb-4 border-b border-slate-100 text-xs">
            <div class="flex items-center gap-2">
                <span class="text-slate-500">Endpoint:</span>
                <code class="font-mono font-semibold text-slate-800 bg-slate-100 px-2 py-0.5 rounded">POST /api/digiflazz/cek-saldo</code>
            </div>

            <div class="flex items-center gap-2">
                <button type="button" @click="copyJson()" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg font-medium transition cursor-pointer">
                    <i class="fa-regular fa-copy"></i>
                    <span x-text="copyFeedback ? 'Disalin!' : 'Salin JSON'"></span>
                </button>
                <button type="button" @click="showRaw = !showRaw" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg font-medium transition cursor-pointer">
                    <span x-text="showRaw ? 'Sembunyikan Raw JSON' : 'Lihat Raw JSON'"></span>
                    <i class="fa-solid" :class="showRaw ? 'fa-chevron-up' : 'fa-chevron-down'"></i>
                </button>
            </div>
        </div>

        {{-- Visual Summary Chips --}}
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 mb-4 text-xs">
            <div class="p-3 bg-slate-50 border border-slate-200/80 rounded-xl">
                <span class="text-slate-400 block mb-0.5">HTTP Status</span>
                <span class="font-bold text-slate-800 font-mono" x-text="rawResponse?.http_status ?? 200">200</span>
            </div>
            <div class="p-3 bg-slate-50 border border-slate-200/80 rounded-xl">
                <span class="text-slate-400 block mb-0.5">Status Success</span>
                <span class="font-bold font-mono" :class="rawResponse?.success ? 'text-emerald-600' : 'text-rose-600'" x-text="rawResponse?.success ? 'true' : 'false'">
                    {{ $balanceStatus ? 'true' : 'false' }}
                </span>
            </div>
            <div class="p-3 bg-slate-50 border border-slate-200/80 rounded-xl">
                <span class="text-slate-400 block mb-0.5">Request Cmd</span>
                <code class="font-bold text-slate-800 font-mono" x-text="rawResponse?.request_payload?.cmd ?? 'deposit'">deposit</code>
            </div>
            <div class="p-3 bg-slate-50 border border-slate-200/80 rounded-xl">
                <span class="text-slate-400 block mb-0.5">Deposit Amount</span>
                <span class="font-bold text-emerald-600 font-mono" x-text="'Rp ' + formatRupiah(rawResponse?.digiflazz_response?.data?.deposit ?? balance)">
                    Rp {{ number_format($balance, 0, ',', '.') }}
                </span>
            </div>
        </div>

        {{-- Preformatted Collapsible JSON Code Block --}}
        <div x-show="showRaw" x-collapse class="rounded-xl overflow-hidden border border-slate-800">
            <div class="bg-slate-900 p-4 font-mono text-xs text-emerald-400 overflow-x-auto leading-relaxed" style="scrollbar-width: thin;">
                <pre x-text="JSON.stringify(rawResponse, null, 2)"></pre>
            </div>
        </div>
    </x-admin.card>

    {{-- Panduan Deposit & Top Up Digiflazz --}}
    <x-admin.card title="Panduan Tambah Saldo (Deposit) Digiflazz" icon="fa-solid fa-circle-question">
        <p class="text-xs text-slate-500 -mt-2 mb-4">
            Untuk menambah saldo deposit Digiflazz secara resmi, silakan ikuti langkah-langkah berikut:
        </p>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 text-xs">
            <div class="p-3.5 bg-slate-50 rounded-xl border border-slate-200/70">
                <div class="w-6 h-6 rounded-lg bg-blue-100 text-blue-700 font-bold flex items-center justify-center mb-2">1</div>
                <h4 class="font-bold text-slate-800 mb-1">Login Member</h4>
                <p class="text-slate-500 leading-relaxed">Buka situs resmi <a href="https://member.digiflazz.com" target="_blank" class="text-blue-600 font-semibold underline">member.digiflazz.com</a> dan masuk menggunakan akun terdaftar.</p>
            </div>

            <div class="p-3.5 bg-slate-50 rounded-xl border border-slate-200/70">
                <div class="w-6 h-6 rounded-lg bg-blue-100 text-blue-700 font-bold flex items-center justify-center mb-2">2</div>
                <h4 class="font-bold text-slate-800 mb-1">Tiket Deposit</h4>
                <p class="text-slate-500 leading-relaxed">Pilih menu <b>Deposit</b> > <b>Tiket Tambah Saldo</b>, lalu pilih bank tujuan transfer (BCA, Mandiri, BRI).</p>
            </div>

            <div class="p-3.5 bg-slate-50 rounded-xl border border-slate-200/70">
                <div class="w-6 h-6 rounded-lg bg-blue-100 text-blue-700 font-bold flex items-center justify-center mb-2">3</div>
                <h4 class="font-bold text-slate-800 mb-1">Transfer Tepat</h4>
                <p class="text-slate-500 leading-relaxed">Transfer sesuai <b>nominal unik</b> yang tertera pada tiket agar saldo otomatis masuk tanpa konfirmasi manual.</p>
            </div>

            <div class="p-3.5 bg-slate-50 rounded-xl border border-slate-200/70">
                <div class="w-6 h-6 rounded-lg bg-blue-100 text-blue-700 font-bold flex items-center justify-center mb-2">4</div>
                <h4 class="font-bold text-slate-800 mb-1">Refresh Panel</h4>
                <p class="text-slate-500 leading-relaxed">Setelah transfer berhasil, klik tombol <b>Refresh Saldo</b> di atas untuk menyinkronkan data terbaru.</p>
            </div>
        </div>
    </x-admin.card>

</div>

<script>
    function ppobAdmin() {
        return {
            balance: {{ (int) $balance }},
            isLoading: false,
            isConnected: {{ $balanceStatus ? 'true' : 'false' }},
            isSuccess: {{ $balanceStatus ? 'true' : 'false' }},
            lastChecked: '{{ date("H:i:s") }} WIB',
            showRaw: false,
            copyFeedback: false,
            rawResponse: @json($balanceData),

            formatRupiah(number) {
                return new Intl.NumberFormat('id-ID').format(number || 0);
            },

            copyJson() {
                const text = JSON.stringify(this.rawResponse, null, 2);
                navigator.clipboard.writeText(text).then(() => {
                    this.copyFeedback = true;
                    setTimeout(() => { this.copyFeedback = false; }, 2500);
                });
            },

            async refreshBalance() {
                this.isLoading = true;

                try {
                    const response = await fetch('/api/digiflazz/cek-saldo', {
                        headers: {
                            'Accept': 'application/json',
                        }
                    });

                    const data = await response.json();
                    this.rawResponse = data;

                    if (response.ok && data.success) {
                        this.balance = data.digiflazz_response?.data?.deposit ?? 0;
                        this.isConnected = true;
                        this.isSuccess = true;
                        this.lastChecked = new Date().toLocaleTimeString('id-ID') + ' WIB';
                        toast('success', 'Saldo berhasil diperbarui dari Digiflazz.');
                    } else {
                        this.isConnected = false;
                        this.isSuccess = false;
                        toast('error', data.digiflazz_response?.data?.message || data.message || 'Gagal mengambil saldo dari Digiflazz.');
                    }
                } catch (error) {
                    this.isConnected = false;
                    this.isSuccess = false;
                    toast('error', 'Koneksi ke Digiflazz gagal: ' + error.message);
                } finally {
                    this.isLoading = false;
                }
            }
        };
    }
</script>
@endsection
