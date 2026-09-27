<section id="lapangan" class="py-12 sm:py-16 bg-slate-950 text-white border-b border-slate-900 relative">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-end justify-between mb-8 gap-4">
            <div>
                <span class="text-emerald-400 font-semibold text-xs tracking-wider uppercase mb-1 block">
                    Ketersediaan Slot
                </span>
                <h2 class="text-xl sm:text-3xl font-bold text-white tracking-tight">
                    Jadwal Lapangan Real-Time
                </h2>
                <p class="text-xs sm:text-sm text-slate-400 mt-1">
                    Pilih olahraga dan cek ketersediaan slot jam bermain.
                </p>
            </div>

            <!-- Date Indicator -->
            <div class="flex items-center gap-2 bg-slate-900 border border-slate-800 px-3.5 py-2 rounded-xl text-xs">
                <span class="text-slate-400 text-[11px] font-medium">Tanggal:</span>
                <input type="date" id="courtsLiveDate" value="{{ date('Y-m-d') }}" min="{{ date('Y-m-d') }}" class="bg-transparent text-white font-semibold focus:outline-none cursor-pointer p-0 text-xs" onchange="handleLiveDateChange(this.value)">
            </div>
        </div>

        <!-- Sport Filter Buttons -->
        <div class="flex items-center gap-1.5 overflow-x-auto no-scrollbar pb-2 mb-6">
            <button type="button" onclick="filterCourtSport('all')" class="court-tab-btn px-3.5 py-1.5 rounded-lg text-xs font-semibold bg-emerald-500 text-slate-950 whitespace-nowrap transition cursor-pointer" data-sport="all">
                Semua
            </button>
            <button type="button" onclick="filterCourtSport('futsal')" class="court-tab-btn px-3.5 py-1.5 rounded-lg text-xs font-semibold bg-slate-900 text-slate-300 hover:text-white border border-slate-800 whitespace-nowrap transition cursor-pointer" data-sport="futsal">
                Futsal
            </button>
            <button type="button" onclick="filterCourtSport('badminton')" class="court-tab-btn px-3.5 py-1.5 rounded-lg text-xs font-semibold bg-slate-900 text-slate-300 hover:text-white border border-slate-800 whitespace-nowrap transition cursor-pointer" data-sport="badminton">
                Badminton
            </button>
            <button type="button" onclick="filterCourtSport('padel')" class="court-tab-btn px-3.5 py-1.5 rounded-lg text-xs font-semibold bg-slate-900 text-slate-300 hover:text-white border border-slate-800 whitespace-nowrap transition cursor-pointer" data-sport="padel">
                Padel Tennis
            </button>
            <button type="button" onclick="filterCourtSport('minisoccer')" class="court-tab-btn px-3.5 py-1.5 rounded-lg text-xs font-semibold bg-slate-900 text-slate-300 hover:text-white border border-slate-800 whitespace-nowrap transition cursor-pointer" data-sport="minisoccer">
                Mini Soccer
            </button>
            <button type="button" onclick="filterCourtSport('volly')" class="court-tab-btn px-3.5 py-1.5 rounded-lg text-xs font-semibold bg-slate-900 text-slate-300 hover:text-white border border-slate-800 whitespace-nowrap transition cursor-pointer" data-sport="volly">
                Bola Voli
            </button>
        </div>

        <!-- Court Cards Grid (Dynamic JS container) -->
        <div id="courtsDisplayGrid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
            <!-- Populated dynamically via JS -->
        </div>

    </div>
</section>
