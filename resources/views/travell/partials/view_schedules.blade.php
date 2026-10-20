<!-- ================= VIEW 2: SCHEDULE LIST (SKY BLUE THEMED) ================= -->
<section id="viewSchedules" class="flex-1 hidden flex-col">
    <!-- Top Nav Bar (Clean Sky Blue Gradient) -->
    <div class="bg-gradient-to-r from-sky-600 to-sky-500 text-white px-4 py-2.5 sticky top-0 z-30 flex items-center gap-2.5 shadow-sm">
        <button type="button" onclick="switchView('viewHome')" class="w-7 h-7 rounded-full bg-white/20 backdrop-blur-md flex items-center justify-center text-white text-xs shrink-0 active:scale-95 cursor-pointer">
            <i class="fas fa-arrow-left"></i>
        </button>
        <div class="flex-1 min-w-0">
            <h3 class="text-xs font-extrabold text-white truncate" id="schedulesRouteTitle">
                Ciamis ➔ Bandung
            </h3>
            <p class="text-[10px] text-sky-100 truncate" id="schedulesSubtitle">Hari Ini • Shuttle Xenia</p>
        </div>
        <button type="button" onclick="switchView('viewHome')" class="text-[10px] font-bold bg-white/20 hover:bg-white/30 text-white px-2.5 py-1 rounded-full whitespace-nowrap shrink-0 cursor-pointer">
            Ubah Rute
        </button>
    </div>

    <!-- Shift Filters: COMPACT, SINGLE-LINE & NO WRAPPING -->
    <div class="px-3 py-2 bg-white border-b border-slate-100 flex items-center gap-1.5 overflow-x-auto no-scrollbar">
        <button type="button" onclick="filterScheduleShift('all')" class="shift-btn px-3 py-1.5 rounded-full text-[11px] font-bold bg-sky-500 text-white shadow-xs whitespace-nowrap shrink-0 transition cursor-pointer" data-shift="all">Semua</button>
        <button type="button" onclick="filterScheduleShift('pagi')" class="shift-btn px-3 py-1.5 rounded-full text-[11px] font-bold bg-slate-100 text-slate-700 hover:bg-sky-50 hover:text-sky-700 whitespace-nowrap shrink-0 transition cursor-pointer" data-shift="pagi">Pagi (06:00 / 09:00)</button>
        <button type="button" onclick="filterScheduleShift('siang')" class="shift-btn px-3 py-1.5 rounded-full text-[11px] font-bold bg-slate-100 text-slate-700 hover:bg-sky-50 hover:text-sky-700 whitespace-nowrap shrink-0 transition cursor-pointer" data-shift="siang">Siang (13:00 / 16:00)</button>
        <button type="button" onclick="filterScheduleShift('malam')" class="shift-btn px-3 py-1.5 rounded-full text-[11px] font-bold bg-slate-100 text-slate-700 hover:bg-sky-50 hover:text-sky-700 whitespace-nowrap shrink-0 transition cursor-pointer" data-shift="malam">Malam (19:30)</button>
    </div>

    <!-- Schedules List Container -->
    <div class="p-3.5 space-y-3" id="schedulesListContainer">
        <!-- Populated dynamically via JS -->
    </div>
</section>
