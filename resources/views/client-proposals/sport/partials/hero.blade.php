<section class="relative bg-slate-950 text-white pt-10 sm:pt-14 pb-16 sm:pb-20 border-b border-slate-900 overflow-hidden">
    <!-- Subtle Ambient Glow -->
    <div class="absolute top-0 left-1/2 -translate-x-1/2 w-[500px] h-[250px] bg-emerald-500/10 rounded-full blur-3xl pointer-events-none"></div>

    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        
        <!-- Header Text Block -->
        <div class="text-center max-w-3xl mx-auto mb-8 sm:mb-10">
            <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-slate-900 border border-slate-800 text-emerald-400 text-[11px] font-medium mb-4">
                <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                <span>Futsal • Badminton • Padel • Mini Soccer • Voli</span>
            </div>

            <h1 class="text-2xl sm:text-4xl lg:text-5xl font-bold tracking-tight text-white leading-tight mb-3 sm:mb-4">
                Sewa Lapangan Olahraga & <br class="hidden sm:inline">
                <span class="text-emerald-400">Komunitas Main Bareng</span>
            </h1>

            <p class="text-xs sm:text-sm text-slate-400 max-w-xl mx-auto leading-relaxed">
                Pusat arena olahraga dengan sistem pemesanan jadwal real-time, benefit membership, dan ruang komunitas untuk sparring antar tim.
            </p>
        </div>

        <!-- Sleek Quick Booking Search Box -->
        <div class="max-w-3xl mx-auto bg-slate-900/80 border border-slate-800 rounded-2xl p-4 sm:p-5 backdrop-blur-md mb-10 shadow-lg">
            <div class="flex items-center justify-between pb-3 mb-3.5 border-b border-slate-800/80 text-xs">
                <span class="font-semibold text-slate-200">Cek Ketersediaan Lapangan</span>
                <span class="text-[11px] text-emerald-400 font-medium bg-emerald-500/10 px-2 py-0.5 rounded border border-emerald-500/20">
                    Buka 06:00 - 24:00 WIB
                </span>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 mb-4">
                <!-- 1. Cabang Olahraga -->
                <div class="bg-slate-950 border border-slate-800/90 rounded-xl px-3 py-2">
                    <label class="block text-[10px] font-semibold text-slate-400 mb-0.5">Cabang Olahraga</label>
                    <select id="heroSportSelect" class="w-full bg-transparent text-xs font-semibold text-white focus:outline-none cursor-pointer">
                        <option value="all" class="bg-slate-900 text-white">Semua Olahraga</option>
                        <option value="futsal" class="bg-slate-900 text-white" selected>Futsal (Vinyl & Interlock)</option>
                        <option value="badminton" class="bg-slate-900 text-white">Badminton (Standar BWF)</option>
                        <option value="padel" class="bg-slate-900 text-white">Padel Tennis (Panoramic)</option>
                        <option value="minisoccer" class="bg-slate-900 text-white">Mini Soccer (7v7 FIFA)</option>
                        <option value="volly" class="bg-slate-900 text-white">Bola Voli (Interlock)</option>
                    </select>
                </div>

                <!-- 2. Tanggal Main -->
                <div class="bg-slate-950 border border-slate-800/90 rounded-xl px-3 py-2">
                    <label class="block text-[10px] font-semibold text-slate-400 mb-0.5">Tanggal Main</label>
                    <input type="date" id="heroBookingDate" value="{{ date('Y-m-d') }}" min="{{ date('Y-m-d') }}" class="w-full bg-transparent text-xs font-semibold text-white focus:outline-none cursor-pointer p-0">
                </div>

                <!-- 3. Pilihan Jam / Shift -->
                <div class="bg-slate-950 border border-slate-800/90 rounded-xl px-3 py-2">
                    <label class="block text-[10px] font-semibold text-slate-400 mb-0.5">Sesi Waktu</label>
                    <select id="heroShiftSelect" class="w-full bg-transparent text-xs font-semibold text-white focus:outline-none cursor-pointer">
                        <option value="all" class="bg-slate-900 text-white">Semua Waktu</option>
                        <option value="pagi" class="bg-slate-900 text-white">Pagi (06:00 - 11:00)</option>
                        <option value="siang" class="bg-slate-900 text-white">Siang (11:00 - 18:00)</option>
                        <option value="malam" class="bg-slate-900 text-white" selected>Malam (18:00 - 24:00)</option>
                    </select>
                </div>
            </div>

            <!-- Action Search Button -->
            <div class="flex flex-col sm:flex-row items-center gap-2.5">
                <button type="button" onclick="executeHeroSearch()" class="w-full sm:flex-1 py-2.5 px-4 rounded-xl bg-emerald-500 hover:bg-emerald-400 text-slate-950 font-bold text-xs transition active:scale-98 flex items-center justify-center gap-1.5 cursor-pointer shadow-sm">
                    <i class="fas fa-search text-[11px]"></i>
                    <span>Cari Lapangan Kosong</span>
                </button>
                @if(isset($client->slug))
                <a href="{{ route('demo.customer.sport', $client->slug) }}" class="w-full sm:w-auto py-2.5 px-4 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-300 font-semibold text-xs transition flex items-center justify-center gap-1.5">
                    <i class="fas fa-mobile-screen-button text-[11px]"></i>
                    <span>Demo Mobile App</span>
                </a>
                @endif
            </div>
        </div>

        <!-- Metric Numbers -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-3 max-w-3xl mx-auto">
            <div class="bg-slate-900/50 border border-slate-800/60 rounded-xl p-3 text-center">
                <p class="text-xl sm:text-2xl font-bold text-white">10+</p>
                <p class="text-[11px] text-slate-400 mt-0.5">Lapangan Standar</p>
            </div>
            <div class="bg-slate-900/50 border border-slate-800/60 rounded-xl p-3 text-center">
                <p class="text-xl sm:text-2xl font-bold text-emerald-400">500+</p>
                <p class="text-[11px] text-slate-400 mt-0.5">Member Aktif</p>
            </div>
            <div class="bg-slate-900/50 border border-slate-800/60 rounded-xl p-3 text-center">
                <p class="text-xl sm:text-2xl font-bold text-teal-400">25+</p>
                <p class="text-[11px] text-slate-400 mt-0.5">Klub Komunitas</p>
            </div>
            <div class="bg-slate-900/50 border border-slate-800/60 rounded-xl p-3 text-center">
                <p class="text-xl sm:text-2xl font-bold text-white">100%</p>
                <p class="text-[11px] text-slate-400 mt-0.5">Real-Time Slot</p>
            </div>
        </div>

    </div>
</section>
