<!-- Hero Section: Modern Executive Shuttle -->
<section class="relative pt-8 pb-12 sm:pt-14 sm:pb-20 overflow-hidden bg-gradient-to-b from-slate-100/80 via-white to-slate-50 border-b border-slate-200/60">
    <!-- Subtle Background Accents -->
    <div class="absolute top-0 right-1/3 w-96 h-96 bg-sky-200/30 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute top-1/2 left-0 w-80 h-80 bg-amber-100/30 rounded-full blur-3xl pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">

        <!-- Hero Top Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-center mb-10 sm:mb-14">

            <!-- Left Content -->
            <div class="lg:col-span-7 text-left">
                <!-- Eyebrow Badge -->
                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-slate-900 text-white text-xs font-semibold mb-5 shadow-xs">
                    <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
                    <span>Executive Shuttle & Minibus Antar Kota</span>
                </div>

                <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold tracking-tight text-slate-900 leading-[1.18] mb-5">
                    Perjalanan Antar Kota Nyaman, <br class="hidden sm:inline">
                    <span class="text-travel-700">Tepat Waktu & Door to Door.</span>
                </h1>

                <p class="text-slate-600 text-sm sm:text-base md:text-lg mb-6 max-w-2xl leading-relaxed">
                    Armada <strong>Toyota HiAce & Isuzu Elf Long</strong> eksekutif dengan penjemputan langsung dari depan rumah, live update kuota kursi, serta <strong>Gratis Paket Makan & Snack di Rest Area</strong>.
                </p>

                <!-- Interactive App Demo Callout -->
                @if(isset($client->slug))
                <div class="mb-6 flex flex-wrap items-center gap-3">
                    <a href="{{ route('demo.customer.travel', $client->slug) }}" class="inline-flex items-center gap-2.5 px-4 py-2.5 rounded-xl bg-travel-700 hover:bg-travel-800 text-white font-bold text-xs shadow-md shadow-sky-950/10 active:scale-95 transition-all">
                        <i class="fas fa-mobile-screen-button text-sm"></i>
                        <span>Buka Demo Customer App (Mobile)</span>
                        <i class="fas fa-arrow-right text-[10px] opacity-75"></i>
                    </a>
                    <span class="text-xs text-slate-500 font-medium">
                        ✨ Fitur: Denah Kursi, Multi-Seat, QRIS & Riwayat Tiket
                    </span>
                </div>
                @endif

                <!-- Value Highlights (Horizontal Clean Row) -->
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 pt-2">
                    <div class="flex items-center gap-3 p-3 rounded-2xl bg-white border border-slate-200/80 shadow-xs">
                        <div class="w-9 h-9 rounded-xl bg-sky-50 text-travel-700 flex items-center justify-center shrink-0 text-sm font-bold">
                            <i class="fas fa-chair"></i>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-slate-900 leading-tight">Pilih Kursi Sendiri</p>
                            <p class="text-[11px] text-slate-500">Denah kuota live</p>
                        </div>
                    </div>

                    <div class="flex items-center gap-3 p-3 rounded-2xl bg-white border border-slate-200/80 shadow-xs">
                        <div class="w-9 h-9 rounded-xl bg-amber-50 text-amber-700 flex items-center justify-center shrink-0 text-sm font-bold">
                            <i class="fas fa-utensils"></i>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-slate-900 leading-tight">Makan & Snack</p>
                            <p class="text-[11px] text-slate-500">Prasmanan rest area</p>
                        </div>
                    </div>

                    <div class="flex items-center gap-3 p-3 rounded-2xl bg-white border border-slate-200/80 shadow-xs">
                        <div class="w-9 h-9 rounded-xl bg-emerald-50 text-emerald-700 flex items-center justify-center shrink-0 text-sm font-bold">
                            <i class="fas fa-home"></i>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-slate-900 leading-tight">Door to Door</p>
                            <p class="text-[11px] text-slate-500">Antar jemput alamat</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Visual Showcase -->
            <div class="lg:col-span-5">
                <div class="relative rounded-3xl overflow-hidden border border-slate-200 shadow-xl bg-slate-900">
                    <img src="/images/travel/minibus_hero.jpg" alt="Toyota HiAce & Minibus Shuttle Executive" class="w-full h-64 sm:h-80 lg:h-96 object-cover object-center transform hover:scale-102 transition-transform duration-500">

                    <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-transparent to-transparent"></div>

                    <!-- Clean Bottom Floating Pill -->
                    <div class="absolute bottom-4 inset-x-4 p-3.5 rounded-2xl bg-slate-900/90 backdrop-blur-md border border-white/10 text-white flex items-center justify-between">
                        <div>
                            <p class="text-[10px] uppercase font-bold text-slate-400 tracking-wider">Armada Unggulan</p>
                            <p class="text-xs sm:text-sm font-bold text-white">Toyota HiAce Premio & Isuzu Elf Long</p>
                        </div>
                        <span class="px-2.5 py-1 rounded-lg bg-emerald-500/20 text-emerald-300 border border-emerald-400/30 text-[10px] font-bold">
                            AC Ducting • Full Audio
                        </span>
                    </div>
                </div>
            </div>

        </div>

        <!-- Integrated Search & Booking Widget (Clean & High Usability) -->
        <div class="bg-white rounded-3xl p-5 sm:p-7 shadow-lg border border-slate-200/80">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 mb-5 pb-4 border-b border-slate-100">
                <div>
                    <h3 class="font-bold text-base sm:text-lg text-slate-900 flex items-center gap-2">
                        <i class="fas fa-search-location text-travel-700"></i>
                        <span>Cari Jadwal Shuttle & Ketersediaan Kursi</span>
                    </h3>
                    <p class="text-xs text-slate-500 mt-0.5">Pilih rute asal dan tujuan untuk mengecek jam keberangkatan & sisa kuota kursi</p>
                </div>
                <div class="flex items-center gap-2 text-xs font-semibold text-slate-600 bg-slate-100 px-3 py-1 rounded-full w-fit">
                    <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                    <span>Sistem Jadwal Real-Time</span>
                </div>
            </div>

            <form id="searchScheduleForm" onsubmit="handleScheduleSearch(event)" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3.5">
                <!-- Kota Asal -->
                <div>
                    <label class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                        Kota Asal (Jemput)
                    </label>
                    <div class="relative">
                        <select id="searchOrigin" class="w-full h-12 bg-slate-50 border border-slate-200 rounded-xl px-4 text-xs sm:text-sm text-slate-800 font-semibold focus:ring-2 focus:ring-travel-700 focus:border-travel-700 focus:bg-white focus:outline-none transition appearance-none cursor-pointer">
                            <option value="all">Semua Kota Asal</option>
                            <option value="ciamis">Ciamis</option>
                            <option value="kuningan">Kuningan</option>
                            <option value="tasikmalaya">Tasikmalaya</option>
                            <option value="bandung">Bandung</option>
                            <option value="jakarta">Jakarta (Jabodetabek)</option>
                        </select>
                        <i class="fas fa-chevron-down absolute right-3.5 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none text-xs"></i>
                    </div>
                </div>

                <!-- Kota Tujuan -->
                <div>
                    <label class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                        Kota Tujuan (Antar)
                    </label>
                    <div class="relative">
                        <select id="searchDestination" class="w-full h-12 bg-slate-50 border border-slate-200 rounded-xl px-4 text-xs sm:text-sm text-slate-800 font-semibold focus:ring-2 focus:ring-travel-700 focus:border-travel-700 focus:bg-white focus:outline-none transition appearance-none cursor-pointer">
                            <option value="all">Semua Kota Tujuan</option>
                            <option value="jakarta">Jakarta (Jabodetabek / Bandara)</option>
                            <option value="bandung">Bandung (Pasteur / Dipatiukur)</option>
                            <option value="ciamis">Ciamis / Banjar</option>
                            <option value="kuningan">Kuningan / Cirebon</option>
                            <option value="tasikmalaya">Tasikmalaya</option>
                        </select>
                        <i class="fas fa-chevron-down absolute right-3.5 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none text-xs"></i>
                    </div>
                </div>

                <!-- Waktu Keberangkatan -->
                <div>
                    <label class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                        Waktu / Shift
                    </label>
                    <div class="relative">
                        <select id="searchTime" class="w-full h-12 bg-slate-50 border border-slate-200 rounded-xl px-4 text-xs sm:text-sm text-slate-800 font-semibold focus:ring-2 focus:ring-travel-700 focus:border-travel-700 focus:bg-white focus:outline-none transition appearance-none cursor-pointer">
                            <option value="all">Semua Waktu (Pagi - Malam)</option>
                            <option value="pagi">Pagi (06.00 - 09.00)</option>
                            <option value="siang">Siang (12.00 - 14.00)</option>
                            <option value="malam">Malam (19.00 - 21.30)</option>
                        </select>
                        <i class="fas fa-chevron-down absolute right-3.5 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none text-xs"></i>
                    </div>
                </div>

                <!-- Button Search -->
                <div class="flex items-end">
                    <button type="submit" class="w-full h-12 bg-travel-700 hover:bg-travel-800 text-white font-bold text-xs sm:text-sm rounded-xl shadow-md transition-all active:scale-95 flex items-center justify-center gap-2">
                        <i class="fas fa-search"></i>
                        <span>Cari Kuota Kursi</span>
                    </button>
                </div>
            </form>
        </div>

    </div>
</section>
