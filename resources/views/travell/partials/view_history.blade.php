<!-- ================= VIEW 7: MY BOOKINGS / ORDER HISTORY (TAILWIND GLASS) ================= -->
<section id="viewHistory" class="flex-1 hidden flex-col space-y-4 pb-20">

    <!-- Top Action Bar -->
    <div class="flex items-center justify-between pt-1">
        <button type="button" onclick="switchView('viewHome')" class="inline-flex items-center gap-2 px-3 py-1.5 rounded-xl glass-panel text-slate-300 hover:text-white text-xs font-semibold transition active:scale-95 cursor-pointer">
            <i class="fas fa-chevron-left text-[11px]"></i>
            <span>Beranda</span>
        </button>
        <button type="button" onclick="refreshHistory()" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl glass-panel text-blue-400 hover:text-blue-300 text-xs font-semibold transition active:scale-95 cursor-pointer">
            <i class="fas fa-arrows-rotate text-[11px]"></i>
            <span>Sinkron Data</span>
        </button>
    </div>

    <!-- 1. Customer Logged In Card (Shown when logged in) -->
    <div id="historyCustomerLoggedInBar" class="glass-card rounded-2xl p-3.5 border border-white/15" style="display: none;">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-blue-500/20 border border-blue-500/30 text-blue-400 flex items-center justify-center text-sm shrink-0">
                    <i class="fas fa-user-check"></i>
                </div>
                <div>
                    <strong class="text-xs font-extrabold text-white block" id="historyCustName">Akun Pelanggan</strong>
                    <span class="text-[10px] text-slate-400" id="historyCustPhone">0812xxxx • 0 Poin</span>
                </div>
            </div>
            <button type="button" onclick="switchCustomerAccount()" class="px-2.5 py-1 rounded-lg glass-panel hover:bg-white/10 text-[10px] font-bold text-blue-300 border border-blue-400/30 cursor-pointer active:scale-95 transition">
                Ganti Akun
            </button>
        </div>
    </div>

    <!-- 2. Guest Phone Lookup Card (Shown when not logged in) -->
    <div id="historyGuestSearchCard" class="glass-panel rounded-2xl p-3.5 border border-white/10 space-y-3" style="display: none;">
        <div class="flex items-center gap-2.5">
            <div class="w-8 h-8 rounded-xl bg-emerald-500/20 border border-emerald-500/30 text-emerald-400 flex items-center justify-center text-sm shrink-0">
                <i class="fab fa-whatsapp"></i>
            </div>
            <div>
                <strong class="text-xs font-bold text-white block">Cari Riwayat Tiket</strong>
                <span class="text-[10px] text-slate-400">Masukkan nomor WhatsApp saat pemesanan</span>
            </div>
        </div>

        <form onsubmit="handleSearchPhoneTickets(event)" class="flex gap-2">
            <div class="relative flex-1">
                <input type="tel" id="lookupPhoneInput" placeholder="Contoh: 081234567890" class="w-full h-10 bg-black/30 border border-white/10 rounded-xl px-3 text-xs text-white placeholder-slate-500 focus:outline-none focus:border-blue-500 font-mono transition">
            </div>
            <button type="submit" id="btnLookupTickets" class="h-10 px-4 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-500 hover:to-indigo-500 text-white font-extrabold text-xs rounded-xl shadow-lg shadow-blue-500/25 flex items-center gap-1.5 shrink-0 active:scale-95 transition cursor-pointer">
                <i class="fas fa-magnifying-glass text-[10px]"></i>
                <span>Cari</span>
            </button>
        </form>
        <div id="lookupPhoneBadge" class="text-[10px] text-slate-400"></div>
    </div>

    <!-- 3. Unauthenticated State Card (Prompt when not logged in and no phone) -->
    <div id="historyAuthRequiredCard" class="glass-panel rounded-3xl p-6 border border-white/10 text-center space-y-3 my-2" style="display: none;">
        <div class="w-14 h-14 rounded-2xl bg-blue-500/20 border border-blue-500/30 text-blue-400 flex items-center justify-center text-2xl mx-auto shadow-inner">
            <i class="fab fa-whatsapp"></i>
        </div>
        <h4 class="text-sm font-extrabold text-white">Masukkan Nomor HP Kamu</h4>
        <p class="text-[11px] text-slate-400 max-w-xs mx-auto leading-relaxed">
            Kamu belum memasukkan nomor HP / belum masuk akun. Masukkan nomor WhatsApp kamu untuk melihat riwayat pesanan tiket shuttle.
        </p>
        <button type="button" onclick="openHistoryPhoneModal()" class="inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-500 hover:to-indigo-500 text-white font-extrabold text-xs rounded-xl shadow-lg shadow-blue-500/30 transition active:scale-95 cursor-pointer">
            <i class="fab fa-whatsapp text-sm"></i>
            <span>Masukkan Nomor HP</span>
        </button>
    </div>

    <!-- Filter Tabs (Segmented Control matching Scalify Partner) -->
    <div class="flex items-center justify-between gap-2">
        <div class="glass-panel p-1 rounded-xl flex gap-1 border border-white/10 flex-1">
            <button type="button" onclick="filterHistoryTabs('all')" id="tabFilterAll" class="history-tab-btn flex-1 py-1.5 text-center text-[11px] font-bold rounded-lg transition text-white bg-blue-600 shadow-md">
                Semua
            </button>
            <button type="button" onclick="filterHistoryTabs('pending')" id="tabFilterPending" class="history-tab-btn flex-1 py-1.5 text-center text-[11px] font-bold rounded-lg transition text-slate-400 hover:text-white">
                Verifikasi
            </button>
            <button type="button" onclick="filterHistoryTabs('confirmed')" id="tabFilterConfirmed" class="history-tab-btn flex-1 py-1.5 text-center text-[11px] font-bold rounded-lg transition text-slate-400 hover:text-white">
                Lunas
            </button>
        </div>
        <span id="ticketCountBadge" class="text-[10px] font-bold px-2.5 py-1.5 rounded-xl glass-panel text-blue-300 border border-blue-400/20 whitespace-nowrap">0 Tiket</span>
    </div>

    <!-- Container for Dynamic Order Tickets (Injected via renderHistoryList()) -->
    <div id="orderHistoryContainer" class="space-y-3"></div>

    <!-- Loading State -->
    <div id="historyLoadingSpinner" class="text-center py-10" style="display: none;">
        <i class="fas fa-circle-notch fa-spin text-blue-400 text-2xl"></i>
        <p class="text-xs text-slate-400 mt-2 font-medium">Mengambil data tiket...</p>
    </div>

    <!-- Empty State -->
    <div id="emptyHistoryAlert" class="glass-panel rounded-3xl p-8 border border-white/10 text-center space-y-3" style="display: none;">
        <div class="w-14 h-14 rounded-2xl bg-white/5 border border-white/10 text-slate-400 flex items-center justify-center text-2xl mx-auto">
            <i class="fas fa-receipt"></i>
        </div>
        <h4 class="text-sm font-extrabold text-white">Belum Ada Tiket</h4>
        <p class="text-xs text-slate-400 max-w-xs mx-auto leading-relaxed">Belum ditemukan pesanan tiket untuk nomor ini. Silakan pesan tiket shuttle sekarang.</p>
        <button type="button" onclick="switchView('viewHome')" class="inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-500 hover:to-indigo-500 text-white font-extrabold text-xs rounded-xl shadow-lg shadow-blue-500/25 transition active:scale-95 cursor-pointer">
            <i class="fas fa-van-shuttle text-xs"></i>
            <span>Pesan Tiket Shuttle</span>
        </button>
    </div>

    <!-- Modal Popup: Masukkan Nomor HP (Dark Glassmorphic) -->
    <div id="historyPhonePromptModal" class="qris-modal-backdrop fixed inset-0 bg-black/80 backdrop-blur-md z-50 items-end sm:items-center justify-center p-0 sm:p-4 transition-opacity" style="display: none;">
        <div class="w-full sm:max-w-sm glass-card rounded-t-3xl sm:rounded-3xl border border-white/20 p-5 space-y-4 shadow-2xl relative text-left">
            <div class="flex items-center justify-between pb-3 border-b border-white/10">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl bg-emerald-500/20 border border-emerald-500/30 text-emerald-400 flex items-center justify-center text-sm shrink-0">
                        <i class="fab fa-whatsapp"></i>
                    </div>
                    <div>
                        <strong class="text-xs font-extrabold text-white block">Nomor WhatsApp Kamu</strong>
                        <span class="text-[10px] text-slate-400">Untuk melihat riwayat tiket & pesanan</span>
                    </div>
                </div>
                <button type="button" onclick="closeHistoryPhoneModal()" class="w-7 h-7 rounded-full glass-panel flex items-center justify-center text-slate-400 hover:text-white text-sm transition cursor-pointer">&times;</button>
            </div>

            <form id="historyPhonePromptForm" onsubmit="handleHistoryPhoneSubmit(event)" class="space-y-3">
                <div>
                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">
                        Nomor WhatsApp / HP Aktif <span class="text-rose-400">*</span>
                    </label>
                    <div class="relative flex items-center">
                        <i class="fab fa-whatsapp absolute left-3.5 text-emerald-400 text-xs"></i>
                        <input type="tel" id="historyModalPhoneInput" required placeholder="Contoh: 081234567890" class="w-full h-10 bg-black/30 border border-white/10 rounded-xl pl-9 pr-3 text-xs text-white placeholder-slate-500 focus:outline-none focus:border-blue-500 font-mono transition">
                    </div>
                    <span class="text-[10px] text-slate-500 mt-1 block">
                        Masukkan nomor WhatsApp yang Anda gunakan saat pemesanan.
                    </span>
                </div>

                <div class="glass-panel rounded-xl p-2.5 border border-blue-500/30 bg-blue-500/10 text-[10px] text-blue-300 flex items-center gap-2">
                    <i class="fas fa-ticket text-blue-400 text-xs shrink-0"></i>
                    <span>Riwayat e-tiket Anda akan otomatis dimuat & tersinkron.</span>
                </div>

                <button type="submit" id="btnSubmitHistoryPhone" class="w-full h-11 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-500 hover:to-indigo-500 text-white font-extrabold text-xs rounded-xl shadow-lg shadow-blue-500/25 flex items-center justify-center gap-2 active:scale-[0.99] transition cursor-pointer">
                    <span>Lihat Tiket Saya</span>
                    <i class="fas fa-arrow-right text-[10px]"></i>
                </button>
            </form>
        </div>
    </div>

</section>
