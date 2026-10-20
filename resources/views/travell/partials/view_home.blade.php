<!-- ================= VIEW 1: HOME (TRAVELOKA SKY BLUE SHUTTLE STYLE) ================= -->
<section id="viewHome" class="flex-1 flex flex-col">
    <!-- Top Brand Header & Greeting (Vibrant Sky Blue Gradient) -->
    <div class="bg-gradient-to-br from-sky-600 via-sky-500 to-sky-600 text-white px-5 pt-2 pb-7 rounded-b-[2rem] shadow-sm relative overflow-hidden">
        <div class="flex items-center justify-between mb-3.5">
            <div class="flex items-center gap-2.5">
                <div class="w-9 h-9 rounded-xl bg-white/20 backdrop-blur-md text-white flex items-center justify-center text-sm font-bold shadow-inner overflow-hidden border border-white/20">
                    <img src="{{ asset('images/travel/rivian_logo.jpg') }}" alt="Rivian Travel" class="w-full h-full object-cover" onerror="this.outerHTML='<i class=\'fas fa-car\'></i>'">
                </div>
                <div>
                    <h2 class="text-[11px] text-sky-100 font-medium leading-tight">Halo, Penumpang Setia 👋</h2>
                    <h1 class="text-sm font-extrabold text-white tracking-tight">{{ $brandName ?? 'Rivian Travel' }}</h1>
                </div>
            </div>
            <div class="flex items-center gap-2">
                <button type="button" onclick="switchView('viewHistory')" class="flex items-center gap-1 bg-white/20 backdrop-blur-md border border-white/20 px-2.5 py-1 rounded-full text-[10px] text-amber-200 font-bold whitespace-nowrap">
                    <i class="fas fa-crown text-[9px] text-amber-300"></i>
                    <span id="userPointsHeader">350 Poin</span>
                </button>
                <button type="button" onclick="switchView('viewHistory')" class="w-8 h-8 rounded-full bg-white/20 backdrop-blur-md flex items-center justify-center text-white text-xs relative">
                    <i class="far fa-bell"></i>
                    <span class="w-2 h-2 rounded-full bg-rose-400 absolute top-1.5 right-1.5 ring-2 ring-sky-600"></span>
                </button>
            </div>
        </div>

        <!-- Search Shuttle Card (Embedded in Header) -->
        <div class="bg-white rounded-2xl p-4 text-slate-800 shadow-xl border border-sky-100">
            <div class="flex items-center justify-between pb-2 mb-3 border-b border-slate-100">
                <span class="text-xs font-extrabold text-slate-900 flex items-center gap-1.5 whitespace-nowrap">
                    <i class="fas fa-car text-sky-500"></i>
                    <span>Shuttle Daihatsu Xenia</span>
                </span>
                <span class="text-[9px] bg-emerald-50 text-emerald-700 px-2 py-0.5 rounded-full font-bold whitespace-nowrap">
                    Door to Door Via Tol
                </span>
            </div>

            <!-- Origin & Destination Selector with Switch Button -->
            <div class="relative space-y-2 mb-3">
                <!-- Kota Asal -->
                <div class="bg-slate-50 border border-slate-200/90 rounded-xl px-3 py-2 flex items-center gap-2.5">
                    <i class="fas fa-circle-dot text-sky-500 text-xs shrink-0"></i>
                    <div class="flex-1 min-w-0">
                        <label class="block text-[9px] font-bold uppercase tracking-wider text-slate-400">Kota Asal (Jemput)</label>
                        <select id="homeOrigin" class="w-full bg-transparent text-xs font-bold text-slate-800 focus:outline-none cursor-pointer truncate">
                            <option value="ciamis" selected>Ciamis (Pool / Rumah)</option>
                            <option value="bandung">Bandung (Pasteur / Dipatiukur)</option>
                            <option value="tasikmalaya">Tasikmalaya</option>
                            <option value="kuningan">Kuningan</option>
                            <option value="jakarta">Jakarta (Jabodetabek)</option>
                        </select>
                    </div>
                </div>

                <!-- Switch Button -->
                <button type="button" onclick="swapOriginDestination()" title="Tukar Kota Asal & Tujuan" class="absolute right-4 top-1/2 -translate-y-1/2 w-7 h-7 rounded-full bg-sky-500 hover:bg-sky-600 text-white shadow-md flex items-center justify-center text-xs z-10 active:rotate-180 transition-transform cursor-pointer">
                    <i class="fa-solid fa-arrows-up-down"></i>
                </button>

                <!-- Kota Tujuan -->
                <div class="bg-slate-50 border border-slate-200/90 rounded-xl px-3 py-2 flex items-center gap-2.5">
                    <i class="fas fa-location-dot text-rose-500 text-xs shrink-0"></i>
                    <div class="flex-1 min-w-0">
                        <label class="block text-[9px] font-bold uppercase tracking-wider text-slate-400">Kota Tujuan (Antar)</label>
                        <select id="homeDestination" class="w-full bg-transparent text-xs font-bold text-slate-800 focus:outline-none cursor-pointer truncate">
                            <option value="bandung" selected>Bandung (Pasteur / Dipatiukur)</option>
                            <option value="ciamis">Ciamis (Pool / Alamat)</option>
                            <option value="jakarta">Jakarta (Jabodetabek)</option>
                            <option value="tasikmalaya">Tasikmalaya</option>
                            <option value="kuningan">Kuningan</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Date & Shift Row -->
            <div class="grid grid-cols-2 gap-2 mb-3.5">
                <div class="bg-slate-50 border border-slate-200/90 rounded-xl px-3 py-2 hover:border-sky-300 transition focus-within:ring-2 focus-within:ring-sky-500 focus-within:bg-white">
                    <label for="homeDate" class="block text-[9px] font-bold uppercase tracking-wider text-slate-400">Tanggal Pergi</label>
                    <div class="flex items-center gap-1.5 mt-0.5">
                        <i class="far fa-calendar-alt text-sky-500 text-xs shrink-0"></i>
                        <input type="date" id="homeDate" min="{{ date('Y-m-d') }}" value="{{ $selectedDate ?? date('Y-m-d') }}" class="w-full bg-transparent text-xs font-bold text-slate-800 focus:outline-none cursor-pointer p-0" onchange="handleDateChange(this.value)">
                    </div>
                </div>
                <div class="bg-slate-50 border border-slate-200/90 rounded-xl px-3 py-2 hover:border-sky-300 transition focus-within:ring-2 focus-within:ring-sky-500 focus-within:bg-white">
                    <label for="homeShift" class="block text-[9px] font-bold uppercase tracking-wider text-slate-400">Pilihan Jam / Shift</label>
                    <select id="homeShift" class="w-full bg-transparent text-xs font-bold text-slate-800 focus:outline-none cursor-pointer mt-0.5 truncate">
                        <option value="all">Semua Jam</option>
                        <option value="pagi">Pagi (06:00 / 09:00)</option>
                        <option value="siang">Siang (13:00 / 16:00)</option>
                        <option value="malam">Malam (19:30 WIB)</option>
                    </select>
                </div>
            </div>

            <!-- Search Button (Vibrant Sky Blue) -->
            <button type="button" onclick="executeScheduleSearch()" class="w-full py-3 rounded-xl bg-gradient-to-r from-sky-500 to-sky-600 hover:from-sky-600 hover:to-sky-700 active:scale-98 text-white font-bold text-xs shadow-md shadow-sky-500/20 transition-all flex items-center justify-center gap-2 whitespace-nowrap cursor-pointer">
                <i class="fas fa-search text-xs"></i>
                <span>Cari Jadwal Mobil & Kursi Kosong</span>
            </button>
        </div>
    </div>

    <!-- 4 Quick Grid Menus (Clean Traveloka Style) -->
    <div class="px-5 py-4">
        <div class="grid grid-cols-4 gap-2.5 text-center">
            <button type="button" onclick="executeScheduleSearch()" class="flex flex-col items-center group cursor-pointer">
                <div class="w-11 h-11 rounded-2xl bg-sky-100 text-sky-600 flex items-center justify-center text-base shadow-xs group-active:scale-95 transition">
                    <i class="fas fa-car-side"></i>
                </div>
                <span class="text-[10px] font-bold text-slate-700 mt-1.5 whitespace-nowrap">Shuttle Xenia</span>
            </button>

            <button type="button" onclick="openCharterView()" class="flex flex-col items-center group cursor-pointer">
                <div class="w-11 h-11 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center text-base shadow-xs group-active:scale-95 transition">
                    <i class="fas fa-crown"></i>
                </div>
                <span class="text-[10px] font-bold text-slate-700 mt-1.5 whitespace-nowrap">Sewa + Sopir</span>
            </button>

            <button type="button" onclick="openPackageView()" class="flex flex-col items-center group cursor-pointer">
                <div class="w-11 h-11 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-base shadow-xs group-active:scale-95 transition">
                    <i class="fas fa-box-open"></i>
                </div>
                <span class="text-[10px] font-bold text-slate-700 mt-1.5 whitespace-nowrap">Titip Paket</span>
            </button>

            <button type="button" onclick="switchView('viewHistory')" class="flex flex-col items-center group cursor-pointer">
                <div class="w-11 h-11 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center text-base shadow-xs group-active:scale-95 transition">
                    <i class="fas fa-receipt"></i>
                </div>
                <span class="text-[10px] font-bold text-slate-700 mt-1.5 whitespace-nowrap">Tiket Saya</span>
            </button>
        </div>
    </div>

    <!-- Promo & Benefits Highlights Banner -->
    <div class="px-5 mb-4">
        <div class="bg-gradient-to-r from-sky-500 via-sky-600 to-blue-600 rounded-2xl p-3.5 text-white shadow-sm flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl bg-white/20 backdrop-blur-sm flex items-center justify-center text-lg shrink-0">
                    <i class="fas fa-shield-halved"></i>
                </div>
                <div>
                    <span class="bg-white/25 text-[8px] font-extrabold uppercase px-2 py-0.5 rounded-full whitespace-nowrap">Pesan 4 Kursi</span>
                    <h4 class="text-xs font-bold mt-0.5 leading-tight">Pasti Langsung Berangkat!</h4>
                    <p class="text-[9px] text-sky-100">Khusus Anda tanpa menunggu penumpang lain</p>
                </div>
            </div>
            <i class="fas fa-chevron-right text-xs opacity-75 shrink-0"></i>
        </div>
    </div>

    <!-- Popular Routes Quick Access -->
    <div class="px-5 mb-6">
        <div class="flex items-center justify-between mb-2.5">
            <h3 class="text-xs font-bold text-slate-900">Rute Populer Hari Ini</h3>
            <button type="button" onclick="executeScheduleSearch()" class="text-[10px] font-bold text-sky-600 hover:text-sky-700 cursor-pointer">Lihat Semua</button>
        </div>
        <div class="space-y-2">
            <!-- Quick Card 1 -->
            <div onclick="quickSearchRoute('ciamis', 'bandung')" class="bg-white rounded-xl p-3 border border-slate-200/80 shadow-xs flex items-center justify-between cursor-pointer hover:border-sky-300 active:bg-sky-50/50 transition">
                <div class="flex items-center gap-2.5 min-w-0">
                    <div class="w-8 h-8 rounded-lg bg-sky-50 text-sky-600 flex items-center justify-center text-xs shrink-0">
                        <i class="fas fa-route"></i>
                    </div>
                    <div class="min-w-0">
                        <p class="text-xs font-bold text-slate-900 truncate">Ciamis ➔ Bandung (PP)</p>
                        <p class="text-[10px] text-slate-500 truncate">Daihatsu Xenia • 06:00, 09:00, 13:00, 19:30</p>
                    </div>
                </div>
                <div class="text-right shrink-0 pl-2">
                    <p class="text-xs font-extrabold text-sky-600">Rp 190.000</p>
                    <span class="text-[9px] text-emerald-600 font-bold bg-emerald-50 px-1.5 py-0.5 rounded whitespace-nowrap">Tersedia</span>
                </div>
            </div>

            <!-- Quick Card 2 -->
            <div onclick="quickSearchRoute('bandung', 'ciamis')" class="bg-white rounded-xl p-3 border border-slate-200/80 shadow-xs flex items-center justify-between cursor-pointer hover:border-sky-300 active:bg-sky-50/50 transition">
                <div class="flex items-center gap-2.5 min-w-0">
                    <div class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center text-xs shrink-0">
                        <i class="fas fa-route"></i>
                    </div>
                    <div class="min-w-0">
                        <p class="text-xs font-bold text-slate-900 truncate">Bandung ➔ Ciamis (PP)</p>
                        <p class="text-[10px] text-slate-500 truncate">Daihatsu Xenia • Door to Door via Tol</p>
                    </div>
                </div>
                <div class="text-right shrink-0 pl-2">
                    <p class="text-xs font-extrabold text-sky-600">Rp 190.000</p>
                    <span class="text-[9px] text-emerald-600 font-bold bg-emerald-50 px-1.5 py-0.5 rounded whitespace-nowrap">Tersedia</span>
                </div>
            </div>

            <!-- Quick Card 3 -->
            <div onclick="quickSearchRoute('ciamis', 'jakarta')" class="bg-white rounded-xl p-3 border border-slate-200/80 shadow-xs flex items-center justify-between cursor-pointer hover:border-sky-300 active:bg-sky-50/50 transition">
                <div class="flex items-center gap-2.5 min-w-0">
                    <div class="w-8 h-8 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center text-xs shrink-0">
                        <i class="fas fa-route"></i>
                    </div>
                    <div class="min-w-0">
                        <p class="text-xs font-bold text-slate-900 truncate">Ciamis ➔ Jakarta (PP)</p>
                        <p class="text-[10px] text-slate-500 truncate">Executive Xenia / Minibus • Malam</p>
                    </div>
                </div>
                <div class="text-right shrink-0 pl-2">
                    <p class="text-xs font-extrabold text-sky-600">Rp 220.000</p>
                    <span class="text-[9px] text-indigo-600 font-bold bg-indigo-50 px-1.5 py-0.5 rounded whitespace-nowrap">Via Tol</span>
                </div>
            </div>
        </div>
    </div>
</section>
