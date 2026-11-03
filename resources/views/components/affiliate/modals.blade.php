@props(['affiliate'])

<!-- Notification Modal (Mobile Friendly - Consistent Midnight Blue Theme) -->
<div id="notificationModal" class="fixed inset-0 z-[60] flex flex-col justify-end bg-slate-900/80 backdrop-blur-sm opacity-0 pointer-events-none transition-opacity duration-300">
    <div class="bg-[#0B1120] border-t border-white/10 w-full rounded-t-3xl transform translate-y-full transition-transform duration-300 flex flex-col max-h-[85vh]" id="notificationModalContent">
        <div class="p-5 pb-2.5 border-b border-white/10 shrink-0">
            <div class="w-12 h-1.5 bg-slate-700/80 rounded-full mx-auto mb-4"></div>
            <div class="flex justify-between items-center mb-1">
                <h3 class="text-sm font-bold text-white flex items-center gap-1.5">
                    <i class="fa-solid fa-bell text-blue-400"></i> Notifikasi
                </h3>
                <button type="button" onclick="closeNotificationModal()" class="w-7 h-7 rounded-full bg-white/5 border border-white/10 flex items-center justify-center text-slate-400 hover:text-white transition-colors active:scale-95">
                    <i class="fa-solid fa-xmark text-xs"></i>
                </button>
            </div>
            @if($affiliate->notifications->count() > 0)
            <div class="flex justify-end mb-1">
                <form action="{{ route('affiliate.notifications.clear') }}" method="POST">
                    @csrf
                    <button type="submit" class="text-[10px] text-slate-400 hover:text-red-400 transition-colors">
                        <i class="fa-solid fa-trash-can mr-1"></i> Bersihkan Semua
                    </button>
                </form>
            </div>
            @endif
        </div>

        <div class="p-5 overflow-y-auto hide-scrollbar flex-1 space-y-3">
            @forelse($affiliate->notifications as $notification)
            <div class="relative">
                <div class="p-3 rounded-2xl border border-white/10 bg-white/[0.03] {{ empty($notification->read_at) ? 'border-blue-500/40 bg-blue-500/5' : '' }}">
                    <div class="flex items-start gap-2.5">
                        <div class="w-8 h-8 rounded-xl shrink-0 flex items-center justify-center text-xs 
                            {{ $notification->data['type'] === 'success' ? 'bg-emerald-500/10 text-emerald-400' : '' }}
                            {{ $notification->data['type'] === 'info' ? 'bg-blue-500/10 text-blue-400' : '' }}
                            {{ $notification->data['type'] === 'warning' ? 'bg-yellow-500/10 text-yellow-400' : '' }}
                        ">
                            @if($notification->data['type'] === 'success')
                            <i class="fa-solid fa-check"></i>
                            @elseif($notification->data['type'] === 'warning')
                            <i class="fa-solid fa-exclamation"></i>
                            @else
                            <i class="fa-solid fa-bell"></i>
                            @endif
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex justify-between items-start mb-0.5 gap-2">
                                <h4 class="text-xs font-bold text-white truncate">{{ $notification->data['title'] ?? 'Pemberitahuan' }}</h4>
                                <span class="text-[9px] text-slate-400 shrink-0 whitespace-nowrap">{{ $notification->created_at->diffForHumans() }}</span>
                            </div>
                            <p class="text-[11px] text-slate-300 leading-relaxed">{{ $notification->data['message'] ?? '' }}</p>

                            @if(empty($notification->read_at))
                            <div class="mt-2 flex justify-end">
                                <form action="{{ route('affiliate.notifications.read', $notification->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="text-[9px] px-2.5 py-1 bg-blue-500/20 text-blue-300 hover:bg-blue-500/30 rounded-lg transition-colors font-semibold">
                                        Tandai Dibaca
                                    </button>
                                </form>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="text-center py-8">
                <div class="w-12 h-12 bg-white/5 rounded-2xl flex items-center justify-center text-xl mx-auto mb-2 text-slate-500">
                    <i class="fa-regular fa-bell-slash"></i>
                </div>
                <h4 class="text-xs font-bold text-white mb-1">Belum ada notifikasi</h4>
                <p class="text-[11px] text-slate-400 max-w-[200px] mx-auto">Pemberitahuan seputar komisi dan penarikan akan muncul di sini.</p>
            </div>
            @endforelse
        </div>
    </div>
</div>

<!-- Share Modal (QR Code - Consistent Midnight Blue Theme) -->
<div id="shareModal" class="fixed inset-0 z-[60] flex flex-col justify-end bg-slate-900/80 backdrop-blur-sm opacity-0 pointer-events-none transition-opacity duration-300">
    <div class="bg-[#0B1120] border-t border-white/10 w-full rounded-t-3xl transform translate-y-full transition-transform duration-300" id="shareModalContent">
        <div class="p-5">
            <div class="w-12 h-1.5 bg-slate-700/80 rounded-full mx-auto mb-4"></div>
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-sm font-bold text-white flex items-center gap-1.5">
                    <i class="fa-solid fa-share-nodes text-indigo-400"></i> Bagikan Link Afiliasi
                </h3>
                <button type="button" onclick="closeShareModal()" class="w-7 h-7 rounded-full bg-white/5 border border-white/10 flex items-center justify-center text-slate-400 hover:text-white transition-colors active:scale-95">
                    <i class="fa-solid fa-xmark text-xs"></i>
                </button>
            </div>

            <div class="flex flex-col items-center mb-4">
                <div class="bg-white p-2.5 rounded-2xl mb-3 shadow-xl inline-block">
                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=180x180&data={{ urlencode(url('/sobat-scalify?ref=' . $affiliate->affiliate_code)) }}" alt="QR Code" class="w-32 h-32 rounded-lg object-contain">
                </div>
                <p class="text-[11px] text-slate-300 text-center px-4 leading-relaxed">
                    Prospek bisa langsung <b>Scan QR Code</b> ini untuk membuka website dengan kode afiliasi Anda.
                </p>
            </div>

            <div class="p-2.5 rounded-2xl border border-white/10 bg-white/[0.03] flex items-center justify-between gap-2.5">
                <div class="truncate flex-1 text-xs font-mono text-blue-300 pl-1">
                    {{ url('/sobat-scalify?ref=' . $affiliate->affiliate_code) }}
                </div>
                <button type="button" onclick="copyLink()" class="w-8 h-8 rounded-xl bg-blue-500 hover:bg-blue-600 shadow-md shadow-blue-500/25 text-white flex items-center justify-center shrink-0 transition-colors active:scale-95" title="Salin Link">
                    <i class="fa-solid fa-copy text-xs"></i>
                </button>
            </div>
        </div>
    </div>
</div>

@php
$modalWallet = $affiliate->getOrCreateWallet();
$modalMutations = $modalWallet->mutations()->take(30)->get();
@endphp

<!-- Wallet Deposit (Top Up) Modal - Interactive Chips & Midnight Blue Theme -->
<div id="walletDepositModal" class="fixed inset-0 z-[60] flex flex-col justify-end bg-slate-900/80 backdrop-blur-sm opacity-0 pointer-events-none transition-opacity duration-300">
    <div class="bg-[#0B1120] border-t border-white/10 w-full rounded-t-3xl transform translate-y-full transition-transform duration-300 max-h-[90vh] overflow-y-auto" id="walletDepositModalContent">
        <div class="p-5">
            <div class="w-12 h-1.5 bg-slate-700/80 rounded-full mx-auto mb-4"></div>
            <div class="flex justify-between items-center mb-4">
                <div>
                    <h3 class="text-sm font-bold text-white flex items-center gap-1.5">
                        <i class="fa-solid fa-qrcode text-emerald-400"></i> Isi Saldo via QRIS
                    </h3>
                    <p class="text-[10px] text-slate-400 mt-0.5">Saldo saat ini: <b class="text-emerald-400">Rp {{ number_format($modalWallet->balance, 0, ',', '.') }}</b></p>
                </div>
                <button type="button" onclick="closeWalletDepositModal()" class="w-7 h-7 rounded-full bg-white/5 border border-white/10 flex items-center justify-center text-slate-400 hover:text-white transition-colors active:scale-95">
                    <i class="fa-solid fa-xmark text-xs"></i>
                </button>
            </div>

            <form id="topUpDepositForm" action="{{ route('affiliate.wallet.deposit') }}" method="POST" onsubmit="handleTopUpSubmit(event, this)">
                @csrf

                <!-- Quick Amount Chips (Interactive Active State + Hover) -->
                <div class="mb-3.5">
                    <label class="block text-[11px] font-semibold text-slate-300 mb-1.5">Pilih Nominal Top Up:</label>
                    <div class="grid grid-cols-3 gap-2" id="deposit_chips_container">
                        <button type="button" data-amount="50000" onclick="setDepositAmount(50000, this)" class="deposit-chip py-2 px-1.5 rounded-xl border border-emerald-500 bg-emerald-500/20 text-emerald-300 ring-1 ring-emerald-500/50 shadow-[0_0_12px_rgba(16,185,129,0.25)] text-xs font-extrabold transition-all duration-150 text-center active:scale-95 cursor-pointer">
                            50.000
                        </button>
                        <button type="button" data-amount="100000" onclick="setDepositAmount(100000, this)" class="deposit-chip py-2 px-1.5 rounded-xl border border-white/10 glass-panel hover:border-emerald-500/40 hover:bg-emerald-500/10 text-xs font-bold text-slate-200 transition-all duration-150 text-center active:scale-95 cursor-pointer">
                            100.000
                        </button>
                        <button type="button" data-amount="200000" onclick="setDepositAmount(200000, this)" class="deposit-chip py-2 px-1.5 rounded-xl border border-white/10 glass-panel hover:border-emerald-500/40 hover:bg-emerald-500/10 text-xs font-bold text-slate-200 transition-all duration-150 text-center active:scale-95 cursor-pointer">
                            200.000
                        </button>
                        <button type="button" data-amount="300000" onclick="setDepositAmount(300000, this)" class="deposit-chip py-2 px-1.5 rounded-xl border border-white/10 glass-panel hover:border-emerald-500/40 hover:bg-emerald-500/10 text-xs font-bold text-slate-200 transition-all duration-150 text-center active:scale-95 cursor-pointer">
                            300.000
                        </button>
                        <button type="button" data-amount="500000" onclick="setDepositAmount(500000, this)" class="deposit-chip py-2 px-1.5 rounded-xl border border-white/10 glass-panel hover:border-emerald-500/40 hover:bg-emerald-500/10 text-xs font-bold text-slate-200 transition-all duration-150 text-center active:scale-95 cursor-pointer">
                            500.000
                        </button>
                        <button type="button" data-amount="1000000" onclick="setDepositAmount(1000000, this)" class="deposit-chip py-2 px-1.5 rounded-xl border border-white/10 glass-panel hover:border-emerald-500/40 hover:bg-emerald-500/10 text-xs font-bold text-slate-200 transition-all duration-150 text-center active:scale-95 cursor-pointer">
                            1.000.000
                        </button>
                    </div>
                </div>

                <!-- Custom Nominal Input -->
                <div class="mb-3.5">
                    <label class="block text-[11px] font-semibold text-slate-300 mb-1.5">Atau Masukkan Nominal Sendiri:</label>
                    <div class="relative">
                        <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-xs font-bold text-emerald-400">Rp</span>
                        <input type="number" id="deposit_amount_input" name="amount" min="50000" step="1000" value="50000" required oninput="calculateDepositLive()" class="w-full bg-slate-900/60 border border-white/10 text-white font-black text-sm rounded-xl py-2.5 pl-10 pr-3.5 focus:outline-none focus:border-emerald-500 transition-colors" placeholder="Min. 50000">
                    </div>
                    <p class="text-[10px] text-slate-400 mt-1">Minimal pengisian saldo: <b class="text-white">Rp 50.000</b></p>
                </div>

                <!-- Payment Method Select (QRIS) -->
                <div class="mb-3.5">
                    <label class="block text-[11px] font-semibold text-slate-300 mb-1.5">Metode Pembayaran:</label>
                    <div class="p-3 rounded-xl border border-emerald-500/40 bg-emerald-500/10 flex items-center justify-between">
                        <div class="flex items-center gap-2.5">
                            <div class="w-8 h-8 rounded-lg bg-emerald-500/20 text-emerald-400 flex items-center justify-center font-bold text-xs">
                                <i class="fa-solid fa-qrcode"></i>
                            </div>
                            <div>
                                <p class="text-xs font-extrabold text-white flex items-center gap-1.5">
                                    QRIS
                                </p>
                                <p class="text-[9px] text-slate-400 mt-0.5">BCA, BRI, Mandiri, BNI, DANA, GoPay, OVO, ShopeePay</p>
                            </div>
                        </div>
                        <input type="radio" name="payment_method" value="qris" checked class="text-emerald-500 focus:ring-0">
                    </div>
                </div>

                <!-- Live Fee & Total Breakdown Box -->
                <div class="mb-4 p-3 rounded-2xl border border-white/10 bg-white/[0.03] space-y-1 text-[11px]">
                    <div class="flex justify-between text-slate-300">
                        <span>Saldo Masuk ke Wallet:</span>
                        <span class="font-bold text-white" id="live_deposit_amount">Rp 50.000</span>
                    </div>
                    <div class="flex justify-between text-slate-400">
                        <span>Biaya Layanan QRIS (2%):</span>
                        <span class="font-medium text-slate-300" id="live_deposit_fee">Rp 1.000</span>
                    </div>
                    <div class="flex justify-between pt-1.5 border-t border-white/10 text-white font-extrabold text-xs">
                        <span>Total Pembayaran QRIS:</span>
                        <span class="text-emerald-400" id="live_deposit_total">Rp 51.000</span>
                    </div>
                </div>

                <!-- Catatan Opsional -->
                <div class="mb-4">
                    <input type="text" name="notes" placeholder="Catatan transaksi (opsional)" class="w-full bg-slate-900/60 border border-white/10 text-white text-[11px] rounded-xl py-2 px-3 focus:outline-none focus:border-emerald-500 placeholder:text-slate-500">
                </div>

                <!-- Tombol Bayar Sekarang (Ultra Satisfying Hover & Tactile Press) -->
                <button type="submit" id="btnSubmitTopUp" class="group relative w-full py-3 px-4 bg-gradient-to-r from-emerald-500 via-teal-500 to-emerald-600 hover:from-emerald-400 hover:via-teal-400 hover:to-emerald-500 text-white font-extrabold rounded-2xl shadow-lg shadow-emerald-500/25 hover:shadow-emerald-500/40 hover:shadow-xl hover:scale-[1.01] transition-all duration-200 flex items-center justify-center gap-2 text-xs active:scale-[0.97] active:brightness-95 cursor-pointer overflow-hidden border border-emerald-400/30">
                    <!-- Top Edge Reflection Sheen -->
                    <div class="absolute inset-x-0 top-0 h-[1px] bg-gradient-to-r from-transparent via-white/50 to-transparent"></div>
                    <!-- Hover Dynamic Light Sweep -->
                    <div class="absolute inset-0 -translate-x-full group-hover:translate-x-full duration-1000 bg-gradient-to-r from-transparent via-white/20 to-transparent transition-transform ease-out pointer-events-none"></div>

                    <i class="fa-solid fa-qrcode text-xs transition-transform duration-200 group-hover:scale-110 group-active:scale-95" id="btnSubmitTopUpIcon"></i>
                    <span id="btnSubmitTopUpText" class="tracking-wide text-xs">Bayar Sekarang</span>
                </button>
            </form>
        </div>
    </div>
</div>

<!-- Wallet Mutations History Modal - Consistent Midnight Blue Theme -->
<div id="walletMutationsModal" class="fixed inset-0 z-[60] flex flex-col justify-end bg-slate-900/80 backdrop-blur-sm opacity-0 pointer-events-none transition-opacity duration-300">
    <div class="bg-[#0B1120] border-t border-white/10 w-full rounded-t-3xl transform translate-y-full transition-transform duration-300 flex flex-col max-h-[85vh]" id="walletMutationsModalContent">
        <div class="p-5 pb-3 border-b border-white/10 shrink-0">
            <div class="w-12 h-1.5 bg-slate-700/80 rounded-full mx-auto mb-3.5"></div>
            <div class="flex justify-between items-center">
                <div>
                    <h3 class="text-sm font-bold text-white flex items-center gap-1.5">
                        <i class="fa-solid fa-clock-rotate-left text-emerald-400"></i> Mutasi Saldo Wallet
                    </h3>
                    <p class="text-[10px] text-slate-400 mt-0.5">Total Saldo: <b class="text-emerald-400">Rp {{ number_format($modalWallet->balance, 0, ',', '.') }}</b></p>
                </div>
                <button type="button" onclick="closeWalletMutationsModal()" class="w-7 h-7 rounded-full bg-white/5 border border-white/10 flex items-center justify-center text-slate-400 hover:text-white transition-colors active:scale-95">
                    <i class="fa-solid fa-xmark text-xs"></i>
                </button>
            </div>
        </div>

        <div class="p-4 overflow-y-auto space-y-2.5 flex-1 hide-scrollbar">
            @forelse($modalMutations as $mutation)
            <div class="p-3 rounded-2xl border border-white/10 bg-white/[0.03] hover:bg-white/[0.06] transition-colors flex items-center justify-between gap-3">
                <!-- Left: Type Icon & Transaction Info -->
                <div class="flex items-center gap-2.5 min-w-0 flex-1">
                    <div class="w-9 h-9 rounded-xl flex items-center justify-center shrink-0 {{ $mutation->type === 'CREDIT' ? 'bg-emerald-500/15 text-emerald-400 border border-emerald-500/30' : 'bg-rose-500/15 text-rose-400 border border-rose-500/30' }}">
                        <i class="fa-solid {{ $mutation->type === 'CREDIT' ? 'fa-arrow-down' : 'fa-arrow-up' }} text-xs"></i>
                    </div>
                    <div class="min-w-0 flex-1">
                        <p class="text-xs font-bold text-white truncate leading-tight" title="{{ $mutation->description ?: $mutation->category }}">
                            {{ $mutation->description ?: $mutation->category }}
                        </p>
                        <div class="flex items-center gap-1.5 mt-1 text-[10px] text-slate-400 font-medium whitespace-nowrap overflow-hidden">
                            <span class="shrink-0">{{ $mutation->created_at ? $mutation->created_at->format('d M Y, H:i') : '-' }}</span>
                            <span class="text-slate-600 shrink-0">•</span>
                            <span class="font-mono text-[9px] text-slate-400 bg-white/5 px-1.5 py-0.5 rounded border border-white/5 truncate max-w-[85px]" title="{{ $mutation->mutation_no }}">
                                #{{ substr($mutation->mutation_no, -6) }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Right: Amount & Running Balance -->
                <div class="text-right shrink-0">
                    <p class="text-xs font-black tracking-tight {{ $mutation->type === 'CREDIT' ? 'text-emerald-400' : 'text-rose-400' }}">
                        {{ $mutation->type === 'CREDIT' ? '+' : '-' }}Rp {{ number_format($mutation->amount, 0, ',', '.') }}
                    </p>
                    <p class="text-[10px] text-slate-400 font-medium mt-0.5 whitespace-nowrap">
                        Sisa: <span class="text-slate-300 font-semibold">Rp {{ number_format($mutation->balance_after, 0, ',', '.') }}</span>
                    </p>
                </div>
            </div>
            @empty
            <div class="text-center py-8">
                <div class="w-12 h-12 bg-white/5 rounded-2xl flex items-center justify-center text-slate-500 text-xl mx-auto mb-2 border border-white/5">
                    <i class="fa-solid fa-receipt"></i>
                </div>
                <p class="text-xs font-bold text-slate-300">Belum Ada Mutasi</p>
                <p class="text-[11px] text-slate-500 mt-0.5 max-w-[200px] mx-auto">Riwayat saldo wallet Anda akan tercatat di sini.</p>
                <button type="button" onclick="closeWalletMutationsModal(); openWalletDepositModal();" class="mt-3 px-3.5 py-1.5 bg-emerald-500/20 hover:bg-emerald-500/30 text-emerald-400 border border-emerald-500/30 text-[11px] font-bold rounded-xl transition-colors inline-flex items-center gap-1.5 active:scale-95">
                    <i class="fa-solid fa-plus text-[10px]"></i> Top Up Sekarang
                </button>
            </div>
            @endforelse
        </div>
    </div>
</div>
