<!-- ================= VIEW 2: SCHEDULE LIST (TAILWIND GLASS) ================= -->
<section id="viewSchedules" class="flex-1 hidden flex-col space-y-4 pb-20">
    <!-- Top Nav Bar -->
    <div class="glass-panel rounded-2xl p-3 border border-white/10 flex items-center gap-3 shadow-lg">
        <button type="button" onclick="switchView('viewHome')" class="w-8 h-8 rounded-xl glass-panel flex items-center justify-center text-slate-300 hover:text-white text-xs shrink-0 active:scale-95 transition cursor-pointer">
            <i class="fas fa-arrow-left"></i>
        </button>
        <div class="flex-1 min-w-0">
            <h3 class="text-xs font-black text-white truncate" id="schedulesRouteTitle">
                Ciamis ➔ Bandung
            </h3>
            <p class="text-[10px] text-slate-400 truncate" id="schedulesSubtitle">Hari Ini • Shuttle Xenia</p>
        </div>
        <button type="button" onclick="switchView('viewHome')" class="text-[10px] font-bold glass-panel hover:bg-white/10 text-blue-300 px-3 py-1.5 rounded-xl border border-blue-400/30 whitespace-nowrap shrink-0 transition cursor-pointer">
            Ubah Rute
        </button>
    </div>

    <!-- Shift Filters: COMPACT, HORIZONTAL SCROLL CHIPS -->
    <div class="glass-panel rounded-xl p-1.5 border border-white/10 flex items-center gap-1.5 overflow-x-auto hide-scrollbar">
        <button type="button" onclick="filterScheduleShift('all')" class="shift-btn px-3 py-1.5 rounded-lg text-[10px] font-extrabold bg-blue-600 text-white shadow-md shadow-blue-500/25 whitespace-nowrap shrink-0 transition cursor-pointer" data-shift="all">Semua</button>
        <button type="button" onclick="filterScheduleShift('pagi')" class="shift-btn px-3 py-1.5 rounded-lg text-[10px] font-bold text-slate-400 hover:text-white hover:bg-white/5 whitespace-nowrap shrink-0 transition cursor-pointer" data-shift="pagi">Pagi (06:00 / 09:00)</button>
        <button type="button" onclick="filterScheduleShift('siang')" class="shift-btn px-3 py-1.5 rounded-lg text-[10px] font-bold text-slate-400 hover:text-white hover:bg-white/5 whitespace-nowrap shrink-0 transition cursor-pointer" data-shift="siang">Siang (13:00 / 16:00)</button>
        <button type="button" onclick="filterScheduleShift('malam')" class="shift-btn px-3 py-1.5 rounded-lg text-[10px] font-bold text-slate-400 hover:text-white hover:bg-white/5 whitespace-nowrap shrink-0 transition cursor-pointer" data-shift="malam">Malam (19:30)</button>
    </div>

    <!-- Schedules List Container -->
    <div class="space-y-3" id="schedulesListContainer">
        <!-- Populated dynamically via JS -->
    </div>
</section>
