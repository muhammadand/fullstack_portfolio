<!-- ================= VIEW 1: HOME (MOBILE-OPTIMIZED FULL-WIDTH LAYOUT) ================= -->
<section id="viewHome" class="space-y-5 pb-6">

    <!-- 1. Executive Top Header (Clean, Mobile First) -->
    <header class="flex justify-between items-center pt-1">
        <div class="flex items-center gap-3">
            <div class="w-11 h-11 rounded-2xl bg-gradient-to-tr from-blue-600 to-indigo-600 p-0.5 shadow-lg shadow-blue-500/25 flex items-center justify-center shrink-0 border border-white/15">
                <img src="{{ asset('images/travel/rivian_logo.jpg') }}" alt="{{ $brandName }}" class="w-full h-full object-cover rounded-[14px]">
            </div>
            <div>
                <div class="flex items-center gap-1.5">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                    <span class="text-[10px] text-blue-400 font-bold uppercase tracking-wider">Shuttle Eksekutif</span>
                </div>
                <h1 class="text-base font-black text-white tracking-tight leading-tight">{{ $brandName }}</h1>
            </div>
        </div>
        <div class="flex items-center gap-2">
            <span class="px-3 py-1 rounded-full text-[10px] font-extrabold text-blue-300 bg-blue-500/15 border border-blue-400/30 shadow-xs flex items-center gap-1.5">
                <i class="fas fa-route text-blue-400 text-[10px]"></i>
                <span>Via Tol</span>
            </span>
        </div>
    </header>

    <!-- 2. Route Hero Banner (Full-Width, Unboxed Mobile Aesthetic) -->
    <div class="glass-card rounded-2xl p-4 relative overflow-hidden border border-white/15 shadow-xl">
        <div class="relative z-10 flex items-center justify-between">
            <div class="space-y-1">
                <span class="inline-block bg-blue-500/20 text-blue-300 border border-blue-400/30 text-[9px] font-black uppercase px-2 py-0.5 rounded-full tracking-wider">
                    Door to Door Eksekutif
                </span>
                <h2 class="text-base font-black text-white tracking-tight">Ciamis ➔ Bandung PP</h2>
                <p class="text-[11px] text-slate-300 leading-snug">Daihatsu All New Xenia AC Dingin, jemput depan pintu & antar sampai tujuan.</p>
            </div>
            <div class="w-10 h-10 rounded-2xl bg-white/5 border border-white/10 flex items-center justify-center text-blue-400 text-lg shrink-0 ml-3">
                <i class="fas fa-van-shuttle"></i>
            </div>
        </div>
        <div class="absolute -right-8 -bottom-8 w-32 h-32 bg-blue-500/15 rounded-full blur-2xl pointer-events-none"></div>
    </div>

    <!-- 3. Form Booking Shuttle (Clean Direct Mobile Flow - No Boxed-In Cards) -->
    <form id="directBookingForm" onsubmit="handleDirectBookingSubmit(event)" class="space-y-4">

        <!-- Status Akun Pelanggan (Jika Logged In) -->
        <div id="customerLoggedInCard" class="glass-panel rounded-2xl p-3.5 border border-blue-500/30 bg-blue-950/20" style="display: none;">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-2.5">
                    <div class="w-8 h-8 rounded-xl bg-blue-500/20 text-blue-400 border border-blue-500/30 flex items-center justify-center text-xs">
                        <i class="fas fa-user-check"></i>
                    </div>
                    <div>
                        <div class="text-xs font-extrabold text-white" id="loggedInUserName">Pelanggan</div>
                        <div class="text-[10px] text-blue-300 font-mono" id="loggedInUserPhone">0812xxxx • 0 Poin</div>
                    </div>
                </div>
                <button type="button" onclick="switchCustomerAccount()" class="text-[10px] text-blue-400 hover:text-blue-300 font-bold underline cursor-pointer">Ganti Akun</button>
            </div>
        </div>

        <!-- Input Identitas Pemesan (Jika Belum Login) -->
        <div id="customerGuestFields" class="grid grid-cols-1 sm:grid-cols-2 gap-2.5">
            <div>
                <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">Nama Pemesan *</label>
                <div class="relative flex items-center">
                    <i class="far fa-user absolute left-3.5 text-slate-500 text-xs"></i>
                    <input type="text" id="bookingCustName" required placeholder="Contoh: Budi Santoso" class="w-full h-11 bg-white/5 border border-white/10 rounded-xl pl-9 pr-3 text-xs text-white placeholder-slate-500 focus:outline-none focus:border-blue-500 focus:bg-white/10 transition font-medium">
                </div>
            </div>

            <div>
                <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">WhatsApp Pemesan *</label>
                <div class="relative flex items-center">
                    <i class="fab fa-whatsapp absolute left-3.5 text-emerald-400 text-xs"></i>
                    <input type="tel" id="bookingCustPhone" required placeholder="081234567890" class="w-full h-11 bg-white/5 border border-white/10 rounded-xl pl-9 pr-3 text-xs text-white placeholder-slate-500 focus:outline-none focus:border-blue-500 focus:bg-white/10 transition font-mono font-medium">
                </div>
            </div>
        </div>

        <!-- 1. Titik Penjemputan (Asal) -->
        <div class="space-y-1.5">
            <div class="flex items-center justify-between">
                <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider flex items-center gap-1.5">
                    <span class="w-1.5 h-1.5 rounded-full bg-blue-400"></span>
                    <span>1. Titik Jemput (Asal) *</span>
                </label>
                <button type="button" id="btnDetectCurrentLocation" onclick="detectCurrentLocation('bookingCustPickup')" class="px-2.5 py-1 rounded-full bg-blue-500/15 border border-blue-500/30 text-blue-300 text-[10px] font-bold flex items-center gap-1 active:scale-95 transition cursor-pointer">
                    <i class="fas fa-crosshairs text-[9px]" id="detectLocationIcon"></i>
                    <span id="detectLocationText">GPS Lokasi Saya</span>
                </button>
            </div>

            <!-- Quick Chips Lokasi Jemput -->
            <div class="flex gap-1.5 overflow-x-auto hide-scrollbar py-0.5">
                <span class="glass-panel text-slate-300 hover:text-white px-3 py-1.5 rounded-xl text-[10px] font-semibold border-white/10 cursor-pointer whitespace-nowrap transition active:scale-95 flex items-center gap-1.5 shrink-0" onclick="applyQuickPickup('Pool Ciamis (Kantor Pusat) - Jl. Jenderal Sudirman No. 88, Ciamis (Depan Alun-Alun)')">
                    <i class="fas fa-building text-blue-400 text-[10px]"></i> Pool Ciamis
                </span>
                <span class="glass-panel text-slate-300 hover:text-white px-3 py-1.5 rounded-xl text-[10px] font-semibold border-white/10 cursor-pointer whitespace-nowrap transition active:scale-95 flex items-center gap-1.5 shrink-0" onclick="applyQuickPickup('Pool Pasteur Bandung - Jl. Dr. Djunjunan No. 135 (Dekat Gerbang Tol Pasteur)')">
                    <i class="fas fa-building text-blue-400 text-[10px]"></i> Pool Pasteur
                </span>
                <span class="glass-panel text-slate-300 hover:text-white px-3 py-1.5 rounded-xl text-[10px] font-semibold border-white/10 cursor-pointer whitespace-nowrap transition active:scale-95 flex items-center gap-1.5 shrink-0" onclick="applyQuickPickup('custom_ciamis')">
                    <i class="fas fa-house text-emerald-400 text-[10px]"></i> Rumah Ciamis
                </span>
                <span class="glass-panel text-slate-300 hover:text-white px-3 py-1.5 rounded-xl text-[10px] font-semibold border-white/10 cursor-pointer whitespace-nowrap transition active:scale-95 flex items-center gap-1.5 shrink-0" onclick="applyQuickPickup('custom_bandung')">
                    <i class="fas fa-house text-emerald-400 text-[10px]"></i> Rumah Bandung
                </span>
            </div>

            <textarea id="bookingCustPickup" required rows="2" placeholder="Tulis alamat penjemputan lengkap, nomor rumah, atau patokan..." class="w-full bg-white/5 border border-white/10 rounded-2xl p-3 text-xs text-white placeholder-slate-500 focus:outline-none focus:border-blue-500 focus:bg-white/10 transition leading-relaxed font-medium"></textarea>

            <div id="gpsStatusBadge" style="display: none;" class="p-2 rounded-xl bg-blue-500/15 border border-blue-500/30 text-[10px] font-bold text-blue-300 flex justify-between items-center">
                <span><i class="fas fa-satellite mr-1 text-blue-400"></i> <span id="gpsStatusText">Lokasi GPS Terdeteksi</span></span>
                <span id="gpsAccuracyText" class="font-mono"></span>
            </div>
        </div>

        <!-- 2. Titik Pengantaran (Tujuan) -->
        <div class="space-y-1.5">
            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider flex items-center gap-1.5">
                <span class="w-1.5 h-1.5 rounded-full bg-rose-400"></span>
                <span>2. Titik Antar (Tujuan) *</span>
            </label>

            <!-- Quick Chips Lokasi Antar -->
            <div class="flex gap-1.5 overflow-x-auto hide-scrollbar py-0.5">
                <span class="glass-panel text-slate-300 hover:text-white px-3 py-1.5 rounded-xl text-[10px] font-semibold border-white/10 cursor-pointer whitespace-nowrap transition active:scale-95 flex items-center gap-1.5 shrink-0" onclick="applyQuickDropoff('Pool Pasteur Bandung - Jl. Dr. Djunjunan No. 135 (Dekat Gerbang Tol Pasteur)')">
                    <i class="fas fa-building text-blue-400 text-[10px]"></i> Pool Pasteur
                </span>
                <span class="glass-panel text-slate-300 hover:text-white px-3 py-1.5 rounded-xl text-[10px] font-semibold border-white/10 cursor-pointer whitespace-nowrap transition active:scale-95 flex items-center gap-1.5 shrink-0" onclick="applyQuickDropoff('Pool Dipatiukur Bandung - Jl. Dipatiukur No. 45, Coblong (Dekat Kampus UNPAD)')">
                    <i class="fas fa-building text-blue-400 text-[10px]"></i> Dipatiukur
                </span>
                <span class="glass-panel text-slate-300 hover:text-white px-3 py-1.5 rounded-xl text-[10px] font-semibold border-white/10 cursor-pointer whitespace-nowrap transition active:scale-95 flex items-center gap-1.5 shrink-0" onclick="applyQuickDropoff('Pool Ciamis (Kantor Pusat) - Jl. Jenderal Sudirman No. 88, Ciamis (Depan Alun-Alun)')">
                    <i class="fas fa-building text-blue-400 text-[10px]"></i> Pool Ciamis
                </span>
                <span class="glass-panel text-slate-300 hover:text-white px-3 py-1.5 rounded-xl text-[10px] font-semibold border-white/10 cursor-pointer whitespace-nowrap transition active:scale-95 flex items-center gap-1.5 shrink-0" onclick="applyQuickDropoff('custom_bandung')">
                    <i class="fas fa-house text-emerald-400 text-[10px]"></i> Antar Bandung
                </span>
                <span class="glass-panel text-slate-300 hover:text-white px-3 py-1.5 rounded-xl text-[10px] font-semibold border-white/10 cursor-pointer whitespace-nowrap transition active:scale-95 flex items-center gap-1.5 shrink-0" onclick="applyQuickDropoff('custom_ciamis')">
                    <i class="fas fa-house text-emerald-400 text-[10px]"></i> Antar Ciamis
                </span>
            </div>

            <textarea id="bookingCustDropoff" required rows="2" placeholder="Tulis alamat tujuan pengantaran, hotel, kantor, atau rumah..." class="w-full bg-white/5 border border-white/10 rounded-2xl p-3 text-xs text-white placeholder-slate-500 focus:outline-none focus:border-blue-500 focus:bg-white/10 transition leading-relaxed font-medium"></textarea>
        </div>

        <!-- 3. Jadwal & Jam Berangkat -->
        <div class="space-y-2">
            <div class="flex items-center justify-between">
                <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider flex items-center gap-1.5">
                    <i class="far fa-calendar-alt text-blue-400"></i>
                    <span>3. Tanggal & Jam Berangkat</span>
                </label>
                <input type="date" id="bookingDate" min="{{ date('Y-m-d') }}" value="{{ date('Y-m-d') }}" class="bg-white/5 border border-white/15 rounded-xl px-2.5 py-1 text-[11px] font-bold text-white focus:outline-none focus:border-blue-500 cursor-pointer">
            </div>

            <!-- Jam Keberangkatan (Chips Grid) -->
            <div class="grid grid-cols-5 gap-1.5" id="timeSlotsContainer">
                <button type="button" onclick="selectBookingTime('06:00')" data-time="06:00" class="time-chip-btn active py-2.5 text-center rounded-xl font-extrabold text-xs transition border border-white/10 bg-blue-600 text-white cursor-pointer shadow-md shadow-blue-500/30">06:00</button>
                <button type="button" onclick="selectBookingTime('09:00')" data-time="09:00" class="time-chip-btn py-2.5 text-center rounded-xl font-bold text-xs transition border border-white/10 bg-white/5 text-slate-300 hover:text-white cursor-pointer">09:00</button>
                <button type="button" onclick="selectBookingTime('13:00')" data-time="13:00" class="time-chip-btn py-2.5 text-center rounded-xl font-bold text-xs transition border border-white/10 bg-white/5 text-slate-300 hover:text-white cursor-pointer">13:00</button>
                <button type="button" onclick="selectBookingTime('16:00')" data-time="16:00" class="time-chip-btn py-2.5 text-center rounded-xl font-bold text-xs transition border border-white/10 bg-white/5 text-slate-300 hover:text-white cursor-pointer">16:00</button>
                <button type="button" onclick="selectBookingTime('19:30')" data-time="19:30" class="time-chip-btn py-2.5 text-center rounded-xl font-bold text-xs transition border border-white/10 bg-white/5 text-slate-300 hover:text-white cursor-pointer">19:30</button>
            </div>
            <input type="hidden" id="bookingSelectedTime" value="06:00">
        </div>

        <!-- 4. Jumlah Kursi Stepper (Minimal 4 Kursi Rombongan) -->
        <div class="glass-panel rounded-2xl p-3.5 border border-white/10 flex items-center justify-between">
            <div>
                <div class="text-xs font-black text-white">Jumlah Kursi Shuttle</div>
                <div class="text-[10px] font-bold text-blue-400">Minimal 4 Kursi • Rp 190.000 / Kursi</div>
            </div>

            <div class="flex items-center bg-black/40 border border-white/15 rounded-xl p-1 gap-1">
                <button type="button" onclick="changeSeatQuantity(-1)" id="btnMinusSeat" class="w-8 h-8 rounded-lg bg-white/10 hover:bg-white/20 text-white font-black flex items-center justify-center text-sm transition cursor-pointer active:scale-95">-</button>
                <span id="seatQuantityDisplay" class="min-w-[58px] text-center text-xs font-black text-white font-mono">4 Kursi</span>
                <button type="button" onclick="changeSeatQuantity(1)" id="btnPlusSeat" class="w-8 h-8 rounded-lg bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-500 hover:to-indigo-500 text-white font-black flex items-center justify-center text-sm shadow-md transition cursor-pointer active:scale-95">+</button>
            </div>
        </div>

        <!-- 5. Checkout Card: Live Total Tagihan & Action CTA -->
        <div class="glass-card rounded-2xl p-4 border border-white/15 space-y-3 shadow-xl">
            <div class="flex items-center justify-between">
                <div>
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Total Tagihan (All-In):</span>
                    <span class="text-xl font-black text-white font-mono tracking-tight" id="directBookingTotalDisplay">Rp 760.000</span>
                </div>
                <span class="text-[10px] font-extrabold text-emerald-400 bg-emerald-500/15 border border-emerald-400/30 px-2.5 py-1 rounded-full">
                    <i class="fas fa-circle-check text-[9px] mr-1"></i> Termasuk Tol & BBM
                </span>
            </div>

            <!-- Tombol Booking & Bayar QRIS -->
            <button type="submit" id="btnSubmitDirectBooking" class="w-full h-12 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-500 hover:to-indigo-500 text-white font-extrabold text-xs rounded-xl shadow-lg shadow-blue-500/30 flex items-center justify-center gap-2 active:scale-[0.99] transition cursor-pointer">
                <i class="fas fa-qrcode text-sm"></i>
                <span>Booking Sekarang</span>
                <i class="fas fa-arrow-right text-[10px]"></i>
            </button>
        </div>
    </form>

    <!-- 4. Pool Resmi Rivian Travel (Clean Unboxed Grid) -->
    <div class="pt-2 space-y-2.5">
        <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-wider flex items-center gap-1.5 px-0.5">
            <i class="fas fa-map-location-dot text-blue-400"></i>
            <span>Lokasi Pool Resmi</span>
        </h4>
        <div class="space-y-2">
            <div class="glass-panel rounded-2xl p-3 border border-white/10 flex items-center justify-between">
                <div>
                    <strong class="text-xs text-white flex items-center gap-1.5">
                        <i class="fas fa-building text-blue-400 text-[10px]"></i>
                        <span>Pool Ciamis Pusat</span>
                    </strong>
                    <span class="text-[10px] text-slate-400 ml-4 block">Jl. Jend. Sudirman No. 88 (Alun-Alun Ciamis)</span>
                </div>
                <span class="text-[9px] font-bold text-blue-300 bg-blue-500/15 border border-blue-500/30 px-2.5 py-0.5 rounded-full shrink-0">Pusat</span>
            </div>
            <div class="glass-panel rounded-2xl p-3 border border-white/10 flex items-center justify-between">
                <div>
                    <strong class="text-xs text-white flex items-center gap-1.5">
                        <i class="fas fa-building text-blue-400 text-[10px]"></i>
                        <span>Pool Pasteur Bandung</span>
                    </strong>
                    <span class="text-[10px] text-slate-400 ml-4 block">Jl. Dr. Djunjunan No. 135 (Gerbang Tol Pasteur)</span>
                </div>
                <span class="text-[9px] font-bold text-blue-300 bg-blue-500/15 border border-blue-500/30 px-2.5 py-0.5 rounded-full shrink-0">Tol Pasteur</span>
            </div>
            <div class="glass-panel rounded-2xl p-3 border border-white/10 flex items-center justify-between">
                <div>
                    <strong class="text-xs text-white flex items-center gap-1.5">
                        <i class="fas fa-building text-blue-400 text-[10px]"></i>
                        <span>Pool Dipatiukur Bandung</span>
                    </strong>
                    <span class="text-[10px] text-slate-400 ml-4 block">Jl. Dipatiukur No. 45, Coblong (Dekat UNPAD)</span>
                </div>
                <span class="text-[9px] font-bold text-blue-300 bg-blue-500/15 border border-blue-500/30 px-2.5 py-0.5 rounded-full shrink-0">UNPAD</span>
            </div>
        </div>
    </div>

</section>
