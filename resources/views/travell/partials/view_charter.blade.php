<!-- ================= VIEW 8: PRIVATE CHARTER (SEWA MOBIL + SOPIR: KONDANGAN / LIBURAN) ================= -->
<section id="viewCharter" class="flex-1 hidden flex-col space-y-4 pb-20">

    <!-- Top Nav Bar -->
    <div class="glass-panel rounded-2xl p-3 border border-white/10 flex items-center gap-3 shadow-lg">
        <button type="button" onclick="switchView('viewHome')" class="w-8 h-8 rounded-xl glass-panel flex items-center justify-center text-slate-300 hover:text-white text-xs shrink-0 active:scale-95 transition cursor-pointer">
            <i class="fas fa-arrow-left"></i>
        </button>
        <div class="flex-1 min-w-0">
            <h3 class="text-xs font-black text-white truncate">Sewa Mobil + Sopir (Charter)</h3>
            <p class="text-[10px] text-slate-400 truncate">1 Mobil Full Rombongan Keluarga Door to Door</p>
        </div>
    </div>

    <form id="charterBookingForm" onsubmit="proceedCharterBooking(event)" class="space-y-4">

        <!-- 1. Pilihan Keperluan / Paket Charter -->
        <div class="glass-panel rounded-2xl p-4 border border-white/10 space-y-3 shadow-lg">
            <div class="flex items-center justify-between pb-2 border-b border-white/10">
                <span class="text-xs font-extrabold text-white">1. Pilih Keperluan Sewa</span>
                <span class="text-[9px] text-blue-300 font-bold bg-blue-500/20 border border-blue-400/30 px-2 py-0.5 rounded-full">All-In Sopir & BBM</span>
            </div>

            <div class="grid grid-cols-2 gap-2.5">
                <label class="charter-purpose-card p-3 rounded-xl border border-blue-500 bg-blue-500/15 cursor-pointer flex flex-col justify-between transition">
                    <div class="flex items-center gap-2 mb-1.5">
                        <input type="radio" name="charterPurpose" value="kondangan" checked onchange="updateCharterTotal()" class="text-blue-600 focus:ring-blue-500">
                        <span class="text-xs font-bold text-white">Kondangan / Acara</span>
                    </div>
                    <p class="text-[10px] text-slate-400 leading-tight">PP hari yang sama / 12 Jam. Cocok untuk hajatan keluarga.</p>
                    <span class="text-[10px] font-bold text-blue-400 mt-2">Tarif Hemat PP</span>
                </label>

                <label class="charter-purpose-card p-3 rounded-xl border border-white/10 glass-panel cursor-pointer hover:border-blue-400/50 flex flex-col justify-between transition">
                    <div class="flex items-center gap-2 mb-1.5">
                        <input type="radio" name="charterPurpose" value="liburan" onchange="updateCharterTotal()" class="text-blue-600 focus:ring-blue-500">
                        <span class="text-xs font-bold text-white">Liburan / Wisata</span>
                    </div>
                    <p class="text-[10px] text-slate-400 leading-tight">Full day 24 Jam. Wisata Pangandaran, Bandung, luar kota.</p>
                    <span class="text-[10px] font-bold text-emerald-400 mt-2">Fleksibel Rute</span>
                </label>
            </div>
        </div>

        <!-- 2. Pilihan Tipe Armada -->
        <div class="glass-panel rounded-2xl p-4 border border-white/10 space-y-3 shadow-lg">
            <div class="flex items-center justify-between pb-2 border-b border-white/10">
                <span class="text-xs font-extrabold text-white">2. Pilih Tipe Armada</span>
                <span class="text-[9px] text-slate-400 font-semibold">AC Dingin & Bersih</span>
            </div>

            <div class="space-y-2">
                <!-- Option 1: Daihatsu Xenia -->
                <label class="charter-fleet-card flex items-center justify-between p-3 rounded-xl border border-blue-500 bg-blue-500/15 cursor-pointer transition">
                    <div class="flex items-center gap-3 min-w-0">
                        <input type="radio" name="charterFleet" value="xenia_all_new" checked onchange="updateCharterTotal()" class="text-blue-600 focus:ring-blue-500">
                        <div class="min-w-0">
                            <p class="text-xs font-extrabold text-white truncate">Daihatsu All New Xenia (6 Seat)</p>
                            <p class="text-[10px] text-slate-400 truncate">Eksekutif AC Double Blower • Lincah Masuk Gang</p>
                        </div>
                    </div>
                    <span class="text-xs font-black text-blue-400 shrink-0 font-mono" id="rateDisplay_xenia">Rp 750.000<span class="text-[9px] font-normal text-slate-500">/hari</span></span>
                </label>

                <!-- Option 2: Toyota Avanza -->
                <label class="charter-fleet-card flex items-center justify-between p-3 rounded-xl border border-white/10 glass-panel cursor-pointer hover:border-blue-400/50 transition">
                    <div class="flex items-center gap-3 min-w-0">
                        <input type="radio" name="charterFleet" value="avanza_veloz" onchange="updateCharterTotal()" class="text-blue-600 focus:ring-blue-500">
                        <div class="min-w-0">
                            <p class="text-xs font-extrabold text-white truncate">Toyota Avanza / Veloz (6 Seat)</p>
                            <p class="text-[10px] text-slate-400 truncate">Hemat & Fleksibel untuk Rombongan Kecil</p>
                        </div>
                    </div>
                    <span class="text-xs font-black text-blue-400 shrink-0 font-mono" id="rateDisplay_avanza">Rp 700.000<span class="text-[9px] font-normal text-slate-500">/hari</span></span>
                </label>

                <!-- Option 3: Toyota Innova Zenix -->
                <label class="charter-fleet-card flex items-center justify-between p-3 rounded-xl border border-white/10 glass-panel cursor-pointer hover:border-blue-400/50 transition">
                    <div class="flex items-center gap-3 min-w-0">
                        <input type="radio" name="charterFleet" value="innova_zenix" onchange="updateCharterTotal()" class="text-blue-600 focus:ring-blue-500">
                        <div class="min-w-0">
                            <p class="text-xs font-extrabold text-white truncate">Toyota Innova Zenix VIP (7 Seat)</p>
                            <p class="text-[10px] text-slate-400 truncate">Family VIP • Suspensi Sangat Empuk & Nyaman</p>
                        </div>
                    </div>
                    <span class="text-xs font-black text-blue-400 shrink-0 font-mono" id="rateDisplay_zenix">Rp 1.000.000<span class="text-[9px] font-normal text-slate-500">/hari</span></span>
                </label>

                <!-- Option 4: Toyota HiAce Premio -->
                <label class="charter-fleet-card flex items-center justify-between p-3 rounded-xl border border-white/10 glass-panel cursor-pointer hover:border-blue-400/50 transition">
                    <div class="flex items-center gap-3 min-w-0">
                        <input type="radio" name="charterFleet" value="hiace_premio" onchange="updateCharterTotal()" class="text-blue-600 focus:ring-blue-500">
                        <div class="min-w-0">
                            <p class="text-xs font-extrabold text-white truncate">Toyota HiAce Premio Luxury (14 Seat)</p>
                            <p class="text-[10px] text-slate-400 truncate">Ruang Luas & Nyaman • Rombongan Besar</p>
                        </div>
                    </div>
                    <span class="text-xs font-black text-blue-400 shrink-0 font-mono" id="rateDisplay_hiace">Rp 1.350.000<span class="text-[9px] font-normal text-slate-500">/hari</span></span>
                </label>
            </div>
        </div>

        <!-- 3. Rute & Durasi Sewa -->
        <div class="glass-panel rounded-2xl p-4 border border-white/10 space-y-3 shadow-lg">
            <h4 class="text-xs font-extrabold text-white border-b border-white/10 pb-2">3. Rute & Waktu Pemakaian</h4>

            <div class="grid grid-cols-2 gap-2.5">
                <div>
                    <label class="block text-[9px] font-bold uppercase tracking-wider text-slate-400 mb-1">Kota Penjemputan</label>
                    <select id="charterOrigin" class="w-full h-10 bg-slate-900 border border-white/15 rounded-xl px-2.5 text-xs font-bold text-white focus:outline-none focus:border-blue-500 cursor-pointer">
                        <option value="Ciamis" selected>Ciamis</option>
                        <option value="Bandung">Bandung</option>
                        <option value="Tasikmalaya">Tasikmalaya</option>
                        <option value="Banjar">Banjar</option>
                        <option value="Pangandaran">Pangandaran</option>
                    </select>
                </div>
                <div>
                    <label class="block text-[9px] font-bold uppercase tracking-wider text-slate-400 mb-1">Kota Tujuan / Acara</label>
                    <select id="charterDestination" class="w-full h-10 bg-slate-900 border border-white/15 rounded-xl px-2.5 text-xs font-bold text-white focus:outline-none focus:border-blue-500 cursor-pointer">
                        <option value="Bandung" selected>Bandung / Lembang</option>
                        <option value="Pangandaran">Pantai Pangandaran</option>
                        <option value="Garut">Garut / Cipanas</option>
                        <option value="Jakarta">Jakarta / Jabodetabek</option>
                        <option value="Ciamis">Area Ciamis Sekitarnya</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-2.5">
                <div>
                    <label for="charterDate" class="block text-[9px] font-bold uppercase tracking-wider text-slate-400 mb-1">Tanggal Mulai</label>
                    <input type="date" id="charterDate" min="{{ date('Y-m-d') }}" value="{{ date('Y-m-d') }}" class="w-full h-10 bg-black/30 border border-white/10 rounded-xl px-2.5 text-xs font-bold text-white focus:outline-none focus:border-blue-500 cursor-pointer">
                </div>
                <div>
                    <label class="block text-[9px] font-bold uppercase tracking-wider text-slate-400 mb-1">Durasi Sewa</label>
                    <select id="charterDuration" onchange="updateCharterTotal()" class="w-full h-10 bg-slate-900 border border-white/15 rounded-xl px-2.5 text-xs font-bold text-white focus:outline-none focus:border-blue-500 cursor-pointer">
                        <option value="1" selected>1 Hari (PP / Full Day)</option>
                        <option value="2">2 Hari</option>
                        <option value="3">3 Hari</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- 4. Form Kontak & Alamat -->
        <div class="glass-panel rounded-2xl p-4 border border-white/10 space-y-3 shadow-lg">
            <h4 class="text-xs font-extrabold text-white border-b border-white/10 pb-2">4. Kontak & Lokasi Jemput</h4>

            <div>
                <label class="block text-[10px] font-bold text-slate-400 mb-1.5 uppercase tracking-wider">Nama Pemesan / Penanggung Jawab *</label>
                <div class="relative flex items-center">
                    <i class="far fa-user absolute left-3.5 text-slate-500 text-xs"></i>
                    <input type="text" id="charterName" required placeholder="Nama Lengkap Anda" value="" class="w-full h-10 bg-black/30 border border-white/10 rounded-xl pl-9 pr-3 text-xs text-white placeholder-slate-500 font-semibold focus:outline-none focus:border-blue-500 transition">
                </div>
            </div>

            <div>
                <label class="block text-[10px] font-bold text-slate-400 mb-1.5 uppercase tracking-wider">Nomor WhatsApp Aktif *</label>
                <div class="relative flex items-center">
                    <i class="fab fa-whatsapp absolute left-3.5 text-emerald-400 text-xs"></i>
                    <input type="tel" id="charterPhone" required placeholder="0812xxxxxxxx" value="" class="w-full h-10 bg-black/30 border border-white/10 rounded-xl pl-9 pr-3 text-xs text-white placeholder-slate-500 font-mono font-semibold focus:outline-none focus:border-blue-500 transition">
                </div>
            </div>

            <div>
                <label class="block text-[10px] font-bold text-slate-400 mb-1.5 uppercase tracking-wider">Alamat Lengkap Titik Kumpul / Penjemputan *</label>
                <textarea id="charterPickup" required rows="2" placeholder="Nama gang, jalan, patokan rumah penjemputan..." class="w-full bg-black/30 border border-white/10 rounded-xl p-3 text-xs text-white placeholder-slate-500 font-medium focus:outline-none focus:border-blue-500 transition"></textarea>
            </div>
        </div>

        <!-- Total & Action Button -->
        <div class="glass-card rounded-2xl p-4 border border-white/15 shadow-xl space-y-3">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-[9px] text-slate-400 font-bold uppercase tracking-wider">Total Biaya Sewa Unit</p>
                    <p class="text-xl font-black text-white tracking-tight" id="charterTotalPriceDisplay">Rp 750.000</p>
                </div>
                <span class="text-[10px] text-emerald-300 bg-emerald-500/20 border border-emerald-400/30 px-3 py-1 rounded-full font-bold">Include Driver & BBM</span>
            </div>
            <button type="submit" id="btnSubmitCharter" class="w-full h-12 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-500 hover:to-indigo-500 text-white font-extrabold text-xs rounded-xl shadow-lg shadow-blue-500/25 flex items-center justify-center gap-2 active:scale-[0.99] transition cursor-pointer">
                <span>Booking Sekarang</span>
                <i class="fas fa-arrow-right text-[10px]"></i>
            </button>
        </div>
    </form>
</section>
