<!-- Section: Jadwal Keberangkatan & Kuota Kursi Real-Time -->
<section id="jadwal" class="py-16 sm:py-24 bg-slate-50/60">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-8 sm:mb-10">
            <div>
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-slate-200/80 text-slate-700 text-xs font-semibold mb-2.5">
                    <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                    Jadwal Terupdate Hari Ini
                </span>
                <h2 class="text-2xl sm:text-4xl font-extrabold text-slate-900 tracking-tight">
                    Jadwal Keberangkatan & Kuota Kursi
                </h2>
                <p class="text-xs sm:text-sm text-slate-600 mt-1.5 max-w-xl">
                    Transparansi sisa kuota kursi real-time. Pilih jadwal dan amankan bangku favorit Anda tanpa antre.
                </p>
            </div>

            <!-- Dynamic Route Filter Tabs from JSON (Scrollable on Mobile) -->
            <div class="overflow-x-auto no-scrollbar -mx-4 px-4 sm:mx-0 sm:px-0">
                <div class="flex items-center gap-2 min-w-max pb-1" id="dynamicRouteFilters">
                    <!-- Populated dynamically via JS -->
                </div>
            </div>
        </div>

        <!-- Dynamic Schedule Cards Container -->
        <div id="dynamicScheduleContainer" class="space-y-4">
            <!-- Populated dynamically via JS from TRAVEL_DATABASE.schedules -->
        </div>

        <!-- Empty State Alert -->
        <div id="noScheduleAlert" class="hidden text-center py-12 px-4 bg-white rounded-3xl border border-dashed border-slate-300">
            <div class="w-12 h-12 mx-auto rounded-full bg-slate-100 flex items-center justify-center text-slate-400 mb-3 text-lg">
                <i class="fas fa-search"></i>
            </div>
            <h4 class="font-bold text-base text-slate-800">Tidak Ada Jadwal yang Sesuai</h4>
            <p class="text-xs text-slate-500 max-w-md mx-auto mt-1">
                Jadwal reguler untuk rute atau waktu tersebut saat ini belum terdaftar. Anda bisa request jadwal khusus atau charter private 1 unit armada via WhatsApp.
            </p>
            <div class="flex items-center justify-center gap-3 mt-4">
                <button type="button" onclick="renderSchedules('all')" class="px-4 py-2.5 rounded-xl bg-slate-900 text-white font-bold text-xs hover:bg-travel-700 transition">
                    Lihat Semua Jadwal
                </button>
            </div>
        </div>

    </div>
</section>
