<div class="relative z-10 w-full max-w-md mx-auto flex flex-col min-h-screen px-4 pt-5 pb-20">
    @php
        $summary = $this->summary;
        $available = $this->availableBalance;
        $hasBank = $summary['bank_info'] !== '';
        $canWithdraw = $hasBank && $available >= $minAmount;
        $isWallet = $source === 'wallet';
    @endphp

    <!-- Top Navigation Bar -->
    <header class="flex items-center justify-between mb-5">
        <div class="flex items-center gap-3">
            <a href="{{ route('affiliate.dashboard') }}" class="w-9 h-9 rounded-xl glass-panel flex items-center justify-center text-slate-300 hover:text-white transition-colors active:scale-95" title="Kembali ke Beranda">
                <i class="fa-solid fa-arrow-left text-xs"></i>
            </a>
            <div>
                <h1 class="text-base font-extrabold text-white tracking-tight flex items-center gap-1.5">
                    <i class="fa-solid fa-money-bill-transfer text-blue-400 text-sm"></i> Tarik Dana
                </h1>
                <p class="text-[10px] text-slate-400 mt-0.5">Cairkan saldo ke rekening bank Anda</p>
            </div>
        </div>

        <a href="{{ route('affiliate.history') }}" class="px-2.5 py-1.5 rounded-xl glass-panel text-[11px] font-bold text-slate-300 hover:text-white flex items-center gap-1 transition-colors active:scale-95">
            <i class="fa-solid fa-clock-rotate-left text-[10px] text-blue-400"></i>
            <span>Riwayat</span>
        </a>
    </header>

    <!-- Success Banner -->
    @if($submitted)
    <div class="mb-4 p-4 rounded-2xl border border-emerald-500/30 bg-emerald-500/10">
        <div class="flex items-start gap-3">
            <div class="w-9 h-9 rounded-xl bg-emerald-500/20 text-emerald-300 flex items-center justify-center shrink-0">
                <i class="fa-solid fa-circle-check"></i>
            </div>
            <div class="min-w-0 flex-1">
                <p class="text-xs font-bold text-emerald-200">Pengajuan Berhasil Dikirim</p>
                <p class="text-[11px] text-emerald-100/80 mt-0.5 leading-relaxed">
                    Penarikan {{ $submitted['source_label'] }} <b>Rp {{ number_format($submitted['amount'], 0, ',', '.') }}</b>
                    akan ditransfer paling lambat <b>{{ $submitted['eta'] }} WIB</b>.
                </p>
                <a href="{{ route('affiliate.history.detail', ['type' => 'withdrawal', 'id' => $submitted['id']]) }}" class="inline-flex items-center gap-1 mt-2 text-[11px] font-bold text-emerald-300 hover:text-emerald-200">
                    Lihat Detail WD-{{ $submitted['id'] }} <i class="fa-solid fa-arrow-right text-[9px]"></i>
                </a>
            </div>
            <button type="button" wire:click="$set('submitted', null)" class="text-emerald-300/70 hover:text-emerald-200 text-xs" title="Tutup">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
    </div>
    @endif

    <!-- Step 1: Pilih Sumber Dana -->
    <p class="text-[11px] font-semibold text-slate-300 mb-2">1. Pilih Sumber Dana</p>
    <div class="grid grid-cols-2 gap-2.5 mb-5">
        <button type="button" wire:click="selectSource('commission')"
            class="text-left p-3.5 rounded-2xl border transition-all active:scale-[0.98] {{ !$isWallet ? 'border-blue-500/60 bg-blue-500/10 shadow-lg shadow-blue-500/10' : 'border-white/10 bg-white/[0.03] hover:bg-white/[0.06]' }}">
            <div class="flex items-center justify-between mb-2">
                <span class="w-7 h-7 rounded-lg bg-blue-500/20 text-blue-400 flex items-center justify-center text-xs">
                    <i class="fa-solid fa-coins"></i>
                </span>
                <i class="fa-solid {{ !$isWallet ? 'fa-circle-dot text-blue-400' : 'fa-circle text-slate-600' }} text-xs"></i>
            </div>
            <p class="text-[10px] text-slate-400 font-medium">Saldo Komisi</p>
            <p class="text-sm font-black text-white tracking-tight truncate">Rp {{ number_format($summary['commission_balance'], 0, ',', '.') }}</p>
        </button>

        <button type="button" wire:click="selectSource('wallet')"
            class="text-left p-3.5 rounded-2xl border transition-all active:scale-[0.98] {{ $isWallet ? 'border-emerald-500/60 bg-emerald-500/10 shadow-lg shadow-emerald-500/10' : 'border-white/10 bg-white/[0.03] hover:bg-white/[0.06]' }}">
            <div class="flex items-center justify-between mb-2">
                <span class="w-7 h-7 rounded-lg bg-emerald-500/20 text-emerald-400 flex items-center justify-center text-xs">
                    <i class="fa-solid fa-wallet"></i>
                </span>
                <i class="fa-solid {{ $isWallet ? 'fa-circle-dot text-emerald-400' : 'fa-circle text-slate-600' }} text-xs"></i>
            </div>
            <p class="text-[10px] text-slate-400 font-medium">Saldo Wallet</p>
            <p class="text-sm font-black text-white tracking-tight truncate">Rp {{ number_format($summary['wallet_balance'], 0, ',', '.') }}</p>
        </button>
    </div>

    <form wire:submit="submit">
        <!-- Step 2: Nominal -->
        <p class="text-[11px] font-semibold text-slate-300 mb-2">2. Jumlah Penarikan</p>
        <div class="glass-panel rounded-2xl p-4 mb-5">
            <div class="flex items-center gap-2 border-b border-white/10 pb-2 focus-within:border-blue-500 transition-colors"
                x-data="{
                    raw: $wire.entangle('amount'),
                    get display() { return this.raw ? Number(this.raw).toLocaleString('id-ID') : ''; },
                }">
                <span class="text-sm font-bold text-slate-400">Rp</span>
                <input type="text" inputmode="numeric" autocomplete="off"
                    :value="display"
                    x-on:input="raw = $event.target.value.replace(/\D/g, '').replace(/^0+/, '').slice(0, 12); $event.target.value = display"
                    @disabled(!$canWithdraw)
                    class="w-full bg-transparent text-white font-black text-xl tracking-tight focus:outline-none placeholder:text-slate-600 disabled:opacity-50"
                    placeholder="0">
            </div>

            @error('amount')
            <p class="text-[11px] text-rose-400 font-semibold mt-2 flex items-center gap-1">
                <i class="fa-solid fa-circle-exclamation text-[10px]"></i> {{ $message }}
            </p>
            @enderror

            <div class="flex justify-between text-[10px] text-slate-400 mt-2">
                <span>Min: Rp {{ number_format($minAmount, 0, ',', '.') }}</span>
                <span class="{{ $isWallet ? 'text-emerald-400' : 'text-blue-400' }}">Tersedia: Rp {{ number_format($available, 0, ',', '.') }}</span>
            </div>

            @if($canWithdraw)
            <div class="grid grid-cols-4 gap-1.5 mt-3">
                @foreach([50000 => '50rb', 100000 => '100rb', 250000 => '250rb'] as $value => $label)
                <button type="button" wire:click="setAmount({{ $value }})" @disabled($value > $available)
                    class="py-1.5 rounded-lg border border-white/10 bg-white/5 text-[10px] font-bold text-slate-200 hover:bg-white/10 transition-colors active:scale-95 disabled:opacity-30 disabled:pointer-events-none">
                    {{ $label }}
                </button>
                @endforeach
                <button type="button" wire:click="setMaxAmount"
                    class="py-1.5 rounded-lg border text-[10px] font-bold transition-colors active:scale-95 {{ $isWallet ? 'border-emerald-500/40 bg-emerald-500/10 text-emerald-300' : 'border-blue-500/40 bg-blue-500/10 text-blue-300' }}">
                    Semua
                </button>
            </div>
            @elseif($hasBank)
            <p class="mt-3 text-[11px] text-amber-300/90 bg-amber-500/10 border border-amber-500/20 rounded-xl px-3 py-2">
                <i class="fa-solid fa-triangle-exclamation mr-1"></i>
                Saldo {{ $isWallet ? 'wallet' : 'komisi' }} belum mencapai minimal penarikan Rp {{ number_format($minAmount, 0, ',', '.') }}.
            </p>
            @endif
        </div>

        <!-- Step 3: Rekening Tujuan -->
        <p class="text-[11px] font-semibold text-slate-300 mb-2">3. Rekening Tujuan</p>
        @if($hasBank)
        <div class="p-3.5 rounded-2xl border border-white/10 bg-white/[0.03] mb-5 flex items-start gap-3">
            <span class="w-8 h-8 rounded-lg bg-white/5 border border-white/10 text-slate-300 flex items-center justify-center text-xs shrink-0">
                <i class="fa-solid fa-building-columns"></i>
            </span>
            <div class="min-w-0 flex-1">
                <p class="text-xs font-bold text-white whitespace-pre-line break-words">{{ $summary['bank_info'] }}</p>
                <a href="{{ route('affiliate.profile') }}" class="text-[10px] text-blue-400 hover:text-blue-300 font-semibold mt-1 inline-block">Ubah rekening</a>
            </div>
        </div>
        @else
        <div class="p-3.5 rounded-2xl border border-rose-500/30 bg-rose-500/10 mb-5">
            <p class="text-xs font-bold text-rose-200 mb-0.5">Rekening belum diisi</p>
            <p class="text-[11px] text-rose-100/80 mb-2">Lengkapi rekening pencairan agar dana bisa ditransfer.</p>
            <a href="{{ route('affiliate.profile') }}" class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg bg-rose-500/20 text-rose-200 text-[11px] font-bold hover:bg-rose-500/30">
                Isi Rekening <i class="fa-solid fa-arrow-right text-[9px]"></i>
            </a>
        </div>
        @endif

        <!-- Info Proses -->
        <div class="mb-5 p-3.5 rounded-2xl border border-blue-500/20 bg-blue-500/[0.07] text-[11px] text-slate-300 leading-relaxed">
            <p class="font-bold text-blue-300 mb-1 flex items-center gap-1.5"><i class="fa-solid fa-circle-info"></i> Ketentuan Penarikan</p>
            <ul class="list-disc pl-4 space-y-0.5">
                <li>Diproses maksimal <b class="text-white">3x24 jam</b> setelah pengajuan.</li>
                <li>Saldo langsung dipotong saat pengajuan dan ditransfer ke rekening di atas.</li>
                <li>Status berubah menjadi <b class="text-emerald-300">Berhasil</b> setelah admin selesai transfer.</li>
            </ul>
        </div>

        <button type="submit" @disabled(!$canWithdraw) wire:loading.attr="disabled" wire:target="submit"
            class="w-full py-3 text-white font-bold text-xs rounded-xl shadow-lg transition-all flex items-center justify-center gap-1.5 active:scale-[0.98] disabled:opacity-40 disabled:pointer-events-none {{ $isWallet ? 'bg-emerald-500 hover:bg-emerald-600 shadow-emerald-500/25' : 'bg-blue-500 hover:bg-blue-600 shadow-blue-500/25' }}">
            <span wire:loading.remove wire:target="submit"><i class="fa-solid fa-paper-plane text-xs mr-1"></i> Ajukan Penarikan</span>
            <span wire:loading wire:target="submit"><i class="fa-solid fa-spinner fa-spin text-xs mr-1"></i> Memproses...</span>
        </button>
    </form>

    <!-- Pengajuan Terakhir -->
    <div class="mt-7">
        <div class="flex items-center justify-between mb-2">
            <p class="text-[11px] font-semibold text-slate-300">Pengajuan Terakhir</p>
            <a href="{{ route('affiliate.history') }}" class="text-[10px] text-slate-400 hover:text-white">Lihat semua</a>
        </div>

        <div class="space-y-2">
            @forelse($this->recentWithdrawals as $w)
            <a href="{{ route('affiliate.history.detail', ['type' => 'withdrawal', 'id' => $w['id']]) }}" wire:key="wd-{{ $w['id'] }}"
                class="p-3 rounded-2xl border border-white/10 bg-white/[0.03] hover:bg-white/[0.06] transition-all flex items-center justify-between gap-3">
                <div class="min-w-0">
                    <p class="text-xs font-bold text-white truncate">Penarikan {{ $w['source_label'] }}</p>
                    <p class="text-[10px] text-slate-400 mt-0.5">
                        @if($w['status'] === 'pending')
                        Estimasi selesai {{ $w['eta'] }}
                        @elseif($w['status'] === 'completed')
                        Ditransfer {{ $w['processed_at'] ?? $w['date'] }}
                        @else
                        {{ $w['date'] }}
                        @endif
                    </p>
                </div>
                <div class="text-right shrink-0">
                    <p class="text-xs font-black text-rose-400 whitespace-nowrap">-Rp {{ number_format($w['amount'], 0, ',', '.') }}</p>
                    @if($w['status'] === 'pending')
                    <span class="inline-block mt-1 px-1.5 py-0.5 rounded-md bg-amber-500/15 text-amber-300 border border-amber-500/30 text-[9px] font-semibold">Diproses</span>
                    @elseif($w['status'] === 'completed')
                    <span class="inline-block mt-1 px-1.5 py-0.5 rounded-md bg-emerald-500/15 text-emerald-300 border border-emerald-500/30 text-[9px] font-semibold">Berhasil</span>
                    @else
                    <span class="inline-block mt-1 px-1.5 py-0.5 rounded-md bg-rose-500/15 text-rose-300 border border-rose-500/30 text-[9px] font-semibold">Ditolak</span>
                    @endif
                </div>
            </a>
            @empty
            <div class="p-6 text-center text-[11px] text-slate-500 glass-panel rounded-2xl">
                Belum ada pengajuan penarikan.
            </div>
            @endforelse
        </div>
    </div>
</div>
