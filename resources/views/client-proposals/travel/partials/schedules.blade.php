<!-- Section: Jadwal Keberangkatan & Kuota Kursi Real-Time (Core Feature with Dynamic JSON) -->
<section id="jadwal" class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-10">
            <div>
                <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-sky-50 text-travel-800 text-xs font-bold mb-3 border border-sky-200">
                    <i class="fas fa-calendar-check text-travel-600"></i> Sistem Kuota Kursi Live
                </div>
                <h2 class="font-heading text-2xl sm:text-4xl font-black text-slate-900 tracking-tight">
                    Jadwal Minibus & Ketersediaan Kursi
                </h2>
                <p class="text-sm sm:text-base text-slate-600 mt-2">
                    Pilih rute di bawah ini untuk melihat jam keberangkatan, tipe armada HiAce / Elf, dan sisa kursi kosong.
                </p>
            </div>

            <!-- Dynamic Route Filter Tabs from JSON -->
            <div class="flex flex-wrap gap-2" id="dynamicRouteFilters">
                <!-- Populated dynamically via JS -->
            </div>
        </div>

        <!-- Dynamic Schedule Cards Container -->
        <div id="dynamicScheduleContainer" class="space-y-4">
            <!-- Populated dynamically via JS from TRAVEL_DATABASE.schedules -->
        </div>

        <!-- Empty State Alert -->
        <div id="noScheduleAlert" class="hidden text-center py-12 bg-slate-50 rounded-2xl border border-dashed border-slate-300">
            <i class="fas fa-calendar-xmark text-4xl text-slate-400 mb-3"></i>
            <h4 class="font-heading font-bold text-base text-slate-800">Tidak Ada Jadwal yang Cocok</h4>
            <p class="text-xs text-slate-500 max-w-md mx-auto mt-1">
                Jadwal untuk rute atau waktu tersebut belum tersedia di sistem reguler. Anda dapat memesan layanan Private Charter 1 Mobil Elf langsung melalui WhatsApp kami.
            </p>
            <button type="button" onclick="renderSchedules('all')" class="mt-4 px-4 py-2 rounded-xl bg-travel-600 text-white font-bold text-xs">
                Tampilkan Semua Jadwal
            </button>
        </div>

    </div>
</section>
