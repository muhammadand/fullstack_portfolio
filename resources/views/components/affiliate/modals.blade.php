@props(['affiliate'])

<!-- Withdraw Modal (Mobile Friendly) -->
<div id="withdrawModal" class="fixed inset-0 z-[60] flex flex-col justify-end bg-slate-900/80 backdrop-blur-sm opacity-0 pointer-events-none transition-opacity duration-300">
    <div class="bg-[#1e293b] border-t border-white/10 w-full rounded-t-3xl transform translate-y-full transition-transform duration-300" id="withdrawModalContent">
        <div class="p-6">
            <div class="w-12 h-1.5 bg-slate-600 rounded-full mx-auto mb-6"></div>
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-xl font-bold text-white">Tarik Komisi</h3>
                <button type="button" onclick="closeWithdrawModal()" class="w-8 h-8 rounded-full glass-panel flex items-center justify-center text-slate-400 hover:text-white">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            @if($affiliate->balance < 50000) <div class="text-center py-6">
                <div class="w-16 h-16 bg-red-500/20 text-red-400 rounded-full flex items-center justify-center text-3xl mx-auto mb-4">
                    <i class="fa-solid fa-circle-xmark"></i>
                </div>
                <h4 class="text-lg font-bold text-white mb-2">Saldo Belum Cukup</h4>
                <p class="text-sm text-slate-400 mb-6">Saldo Anda <b>Rp {{ number_format($affiliate->balance, 0, ',', '.') }}</b>. Minimal penarikan Rp 50.000.</p>
                <button type="button" onclick="closeWithdrawModal()" class="w-full py-3.5 glass-panel text-white font-bold rounded-xl">
                    Tutup
                </button>
        </div>
        @else
        <form action="{{ route('affiliate.withdraw') }}" method="POST">
            @csrf
            <div class="mb-5">
                <label class="block text-sm font-medium text-slate-300 mb-2">Jumlah Penarikan (Rp)</label>
                <input type="number" name="amount" min="50000" max="{{ $affiliate->balance }}" required class="w-full bg-slate-900/50 border border-white/10 text-white font-bold rounded-xl py-3.5 px-4 focus:outline-none focus:border-blue-500 transition-colors" placeholder="Contoh: 100000">
                <p class="text-[11px] text-slate-400 mt-2 flex justify-between">
                    <span>Min: Rp 50.000</span>
                    <span class="text-blue-400">Max: Rp {{ number_format($affiliate->balance, 0, ',', '.') }}</span>
                </p>
            </div>

            <div class="mb-6 p-4 glass-panel rounded-xl">
                <p class="text-xs text-slate-400 font-medium mb-1">Rekening Pencairan:</p>
                <p class="text-sm font-bold text-white">{{ $affiliate->bank_info }}</p>
            </div>

            <button type="submit" class="w-full py-3.5 bg-blue-500 hover:bg-blue-600 text-white font-bold rounded-xl shadow-lg shadow-blue-500/30 transition-all">
                Konfirmasi Penarikan
            </button>
        </form>
        @endif
    </div>
</div>
</div>

<!-- Notification Modal (Mobile Friendly) -->
<div id="notificationModal" class="fixed inset-0 z-[60] flex flex-col justify-end bg-slate-900/80 backdrop-blur-sm opacity-0 pointer-events-none transition-opacity duration-300">
    <div class="bg-[#1e293b] border-t border-white/10 w-full rounded-t-3xl transform translate-y-full transition-transform duration-300 flex flex-col max-h-[85vh]" id="notificationModalContent">
        <div class="p-6 pb-2 border-b border-white/10 shrink-0">
            <div class="w-12 h-1.5 bg-slate-600 rounded-full mx-auto mb-6"></div>
            <div class="flex justify-between items-center mb-2">
                <h3 class="text-xl font-bold text-white">Notifikasi</h3>
                <button type="button" onclick="closeNotificationModal()" class="w-8 h-8 rounded-full glass-panel flex items-center justify-center text-slate-400 hover:text-white">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            @if($affiliate->notifications->count() > 0)
            <div class="flex justify-end mb-2">
                <form action="{{ route('affiliate.notifications.clear') }}" method="POST">
                    @csrf
                    <button type="submit" class="text-xs text-slate-400 hover:text-red-400 transition-colors">
                        <i class="fa-solid fa-trash-can mr-1"></i> Bersihkan Semua
                    </button>
                </form>
            </div>
            @endif
        </div>

        <div class="p-6 overflow-y-auto hide-scrollbar flex-1">
            @forelse($affiliate->notifications as $notification)
            <div class="mb-4 relative">
                <div class="glass-panel p-4 rounded-2xl {{ empty($notification->read_at) ? 'border-blue-500/50 bg-blue-500/5' : '' }}">
                    <div class="flex items-start gap-3">
                        <div class="w-10 h-10 rounded-full shrink-0 flex items-center justify-center 
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
                        <div class="flex-1">
                            <div class="flex justify-between items-start mb-1">
                                <h4 class="text-sm font-bold text-white">{{ $notification->data['title'] ?? 'Pemberitahuan' }}</h4>
                                <span class="text-[10px] text-slate-400">{{ $notification->created_at->diffForHumans() }}</span>
                            </div>
                            <p class="text-xs text-slate-300 leading-relaxed">{{ $notification->data['message'] ?? '' }}</p>

                            @if(empty($notification->read_at))
                            <div class="mt-3 flex justify-end">
                                <form action="{{ route('affiliate.notifications.read', $notification->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="text-[11px] px-3 py-1.5 bg-blue-500/20 text-blue-400 hover:bg-blue-500/30 rounded-lg transition-colors font-medium">
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
            <div class="text-center py-10">
                <div class="w-20 h-20 bg-slate-800 rounded-full flex items-center justify-center text-4xl mx-auto mb-4 text-slate-500">
                    <i class="fa-regular fa-bell-slash"></i>
                </div>
                <h4 class="text-lg font-bold text-white mb-2">Belum ada notifikasi</h4>
                <p class="text-sm text-slate-400">Pemberitahuan seputar komisi dan penarikan akan muncul di sini.</p>
            </div>
            @endforelse
        </div>
    </div>
</div>

<!-- Share Modal (QR Code) -->
<div id="shareModal" class="fixed inset-0 z-[60] flex flex-col justify-end bg-slate-900/80 backdrop-blur-sm opacity-0 pointer-events-none transition-opacity duration-300">
    <div class="bg-[#1e293b] border-t border-white/10 w-full rounded-t-3xl transform translate-y-full transition-transform duration-300" id="shareModalContent">
        <div class="p-6">
            <div class="w-12 h-1.5 bg-slate-600 rounded-full mx-auto mb-6"></div>
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-xl font-bold text-white">Bagikan Link Anda</h3>
                <button type="button" onclick="closeShareModal()" class="w-8 h-8 rounded-full glass-panel flex items-center justify-center text-slate-400 hover:text-white">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            <div class="flex flex-col items-center mb-6">
                <div class="bg-white p-3 rounded-2xl mb-4 shadow-xl">
                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data={{ urlencode(url('/sobat-scalify?ref=' . $affiliate->affiliate_code)) }}" alt="QR Code" class="w-40 h-40 rounded-lg">
                </div>
                <p class="text-xs text-slate-400 text-center px-4 leading-relaxed">
                    Prospek bisa langsung <b>Scan QR Code</b> ini untuk membuka website dengan kode afiliasi Anda.
                </p>
            </div>

            <div class="glass-panel p-3.5 rounded-xl flex items-center justify-between gap-3 mb-2">
                <div class="truncate flex-1 text-sm font-medium text-blue-300">
                    {{ url('/sobat-scalify?ref=' . $affiliate->affiliate_code) }}
                </div>
                <button onclick="copyLink()" class="w-10 h-10 rounded-xl bg-blue-500 hover:bg-blue-600 shadow-lg shadow-blue-500/30 text-white flex items-center justify-center shrink-0 transition-colors">
                    <i class="fa-solid fa-copy"></i>
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Guide Modal (Cara Kerja) -->
<div id="guideModal" class="fixed inset-0 z-[60] flex flex-col justify-end bg-slate-900/80 backdrop-blur-sm opacity-0 pointer-events-none transition-opacity duration-300">
    <div class="bg-[#1e293b] border-t border-white/10 w-full rounded-t-3xl transform translate-y-full transition-transform duration-300 flex flex-col max-h-[85vh]" id="guideModalContent">
        <div class="p-6 pb-4 border-b border-white/10 shrink-0">
            <div class="w-12 h-1.5 bg-slate-600 rounded-full mx-auto mb-6"></div>
            <div class="flex justify-between items-center">
                <h3 class="text-xl font-bold text-white"><i class="fa-solid fa-book-open text-orange-400 mr-2"></i>Cara Kerja Partner</h3>
                <button type="button" onclick="closeGuideModal()" class="w-8 h-8 rounded-full glass-panel flex items-center justify-center text-slate-400 hover:text-white">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
        </div>

        <div class="p-6 overflow-y-auto hide-scrollbar flex-1 space-y-6">

            <p class="text-sm text-slate-300 leading-relaxed mb-2">Sebagai partner, ada dua cara mudah untuk mendapatkan klien dan komisi:</p>

            <div class="space-y-4">
                <!-- Cara 1 -->
                <div class="glass-panel p-4 rounded-2xl border-blue-500/20 bg-blue-500/5 relative overflow-hidden">
                    <div class="absolute -right-4 -top-4 w-16 h-16 bg-blue-500/10 rounded-full blur-xl"></div>
                    <div class="flex items-center gap-3 mb-3 relative z-10">
                        <div class="w-8 h-8 rounded-full bg-blue-500/20 text-blue-400 flex items-center justify-center font-bold shrink-0">
                            <i class="fa-solid fa-link"></i>
                        </div>
                        <h4 class="text-sm font-bold text-white">Cara 1: Bagikan Link Afiliasi</h4>
                    </div>
                    <p class="text-xs text-slate-400 leading-relaxed relative z-10">
                        Sebarkan <b>Link Website</b> atau <b>Akses Login</b> Anda ke calon klien atau di sosial media. Ketika mereka membuka link tersebut dan bertransaksi, komisi otomatis masuk ke akun Anda.
                    </p>
                </div>

                <!-- Cara 2 -->
                <div class="glass-panel p-4 rounded-2xl border-emerald-500/20 bg-emerald-500/5 relative overflow-hidden">
                    <div class="absolute -right-4 -top-4 w-16 h-16 bg-emerald-500/10 rounded-full blur-xl"></div>
                    <div class="flex items-center gap-3 mb-3 relative z-10">
                        <div class="w-8 h-8 rounded-full bg-emerald-500/20 text-emerald-400 flex items-center justify-center font-bold shrink-0">
                            <i class="fa-solid fa-wand-magic-sparkles"></i>
                        </div>
                        <h4 class="text-sm font-bold text-white">Cara 2: Buat Proposal Instan</h4>
                    </div>
                    <p class="text-xs text-slate-400 leading-relaxed relative z-10">
                        Masuk ke menu <b>Katalog Proposal</b>, pilih kategori bisnis klien (misal: Cafe, Barbershop), lalu masukkan Nama Bisnis & No. HP mereka.
                    </p>
                    <div class="mt-3 p-3 bg-slate-900/50 rounded-xl relative z-10">
                        <p class="text-[11px] text-emerald-300 leading-relaxed">
                            <i class="fa-solid fa-bolt text-yellow-400 mr-1"></i>
                            Otomatis terbuat <b>Landing Page Web</b> & proposal rincian biaya yang bisa langsung Anda berikan ke klien sebagai daya tarik utama!
                        </p>
                    </div>
                </div>
            </div>

            <div class="w-full h-px bg-white/10 my-4"></div>

            <div class="flex gap-4">
                <div class="w-10 h-10 rounded-full bg-yellow-500/20 text-yellow-400 flex items-center justify-center shrink-0 font-bold">
                    <i class="fa-solid fa-money-bill-wave"></i>
                </div>
                <div>
                    <h4 class="text-sm font-bold text-white mb-1">Cairkan Komisi</h4>
                    <p class="text-xs text-slate-400 leading-relaxed">
                        Dapatkan <b>10% komisi</b> atau <b>Rp 200.000 - Rp 500.000 per klien</b> dari setiap project yang *deal*. Anda bisa menarik Saldo Komisi ke rekening bank (minimal Rp 50.000).
                    </p>
                </div>
            </div>

            <div class="mt-4 p-4 glass-panel rounded-2xl bg-indigo-500/10 border-indigo-500/20">
                <p class="text-xs text-indigo-200 text-center leading-relaxed">
                    <i class="fa-solid fa-lightbulb text-yellow-300 mr-1"></i>
                    <b>Tips:</b> Fitur proposal instan memiliki peluang *closing* jauh lebih tinggi karena klien bisa melihat hasil kerjanya secara langsung!
                </p>
            </div>

            <button type="button" onclick="closeGuideModal()" class="w-full py-3.5 bg-white/10 hover:bg-white/20 text-white font-bold rounded-xl transition-colors mt-2">
                Mengerti
            </button>
        </div>
    </div>
</div>
