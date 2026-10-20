<!-- ================= VIEW 7: MY BOOKINGS / ORDER HISTORY ================= -->
<section id="viewHistory" class="flex-1 hidden flex-col bg-slate-50">
    <!-- Top Nav Bar (Sky Blue) -->
    <div class="bg-gradient-to-r from-sky-600 to-sky-500 text-white px-4 py-2.5 sticky top-0 z-30 flex items-center justify-between shadow-sm">
        <div class="flex items-center gap-2.5">
            <button type="button" onclick="switchView('viewHome')" class="w-7 h-7 rounded-full bg-white/20 backdrop-blur-md flex items-center justify-center text-white text-xs shrink-0 active:scale-95 cursor-pointer">
                <i class="fas fa-arrow-left"></i>
            </button>
            <div>
                <h3 class="text-xs font-extrabold text-white">Riwayat Pesanan Tiket</h3>
                <p class="text-[10px] text-sky-100">Daftar E-Ticket Shuttle & Sewa Mobil</p>
            </div>
        </div>
        <button type="button" onclick="clearHistoryDemo()" class="text-[9px] font-bold text-white bg-white/20 hover:bg-white/30 px-2 py-1 rounded-full whitespace-nowrap cursor-pointer">
            Reset Demo
        </button>
    </div>

    <!-- History Filter Tabs -->
    <div class="p-3.5 flex-1">
        <div class="flex items-center gap-2 mb-3">
            <span class="px-3 py-1 rounded-full text-[11px] font-bold bg-sky-500 text-white shadow-xs whitespace-nowrap">Semua Tiket</span>
            <span class="px-3 py-1 rounded-full text-[11px] font-semibold bg-white text-slate-600 border border-slate-200 whitespace-nowrap">Aktif</span>
        </div>

        <!-- History Cards Container -->
        <div id="orderHistoryContainer" class="space-y-2.5">
            <!-- Populated dynamically via JS from localStorage -->
        </div>

        <!-- Empty State for History -->
        <div id="emptyHistoryAlert" class="hidden text-center py-10 bg-white rounded-2xl border border-dashed border-slate-200 p-5">
            <div class="w-10 h-10 rounded-full bg-sky-50 text-sky-500 flex items-center justify-center text-base mx-auto mb-2">
                <i class="fas fa-ticket-alt"></i>
            </div>
            <h4 class="text-xs font-bold text-slate-800">Belum Ada Riwayat Tiket</h4>
            <p class="text-[10px] text-slate-500 mt-0.5">Silakan lakukan pemesanan tiket shuttle, sewa mobil, atau titip paket di beranda.</p>
            <button type="button" onclick="switchView('viewHome')" class="mt-3 px-4 py-2 rounded-xl bg-sky-500 text-white text-xs font-bold cursor-pointer">
                Cari Jadwal Shuttle
            </button>
        </div>
    </div>
</section>
