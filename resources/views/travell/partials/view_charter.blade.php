<!-- ================= VIEW 8: PRIVATE CHARTER (SEWA MOBIL + SOPIR: KONDANGAN / LIBURAN) ================= -->
<section id="viewCharter" class="flex-1 hidden flex-col bg-slate-50">
    <!-- Top Nav Bar (Sky Blue) -->
    <div class="bg-gradient-to-r from-sky-600 to-sky-500 text-white px-4 py-2.5 sticky top-0 z-30 flex items-center gap-2.5 shadow-sm">
        <button type="button" onclick="switchView('viewHome')" class="w-7 h-7 rounded-full bg-white/20 backdrop-blur-md flex items-center justify-center text-white text-xs shrink-0 active:scale-95 cursor-pointer">
            <i class="fas fa-arrow-left"></i>
        </button>
        <div class="flex-1 min-w-0">
            <h3 class="text-xs font-extrabold text-white">Sewa Mobil + Sopir (Charter)</h3>
            <p class="text-[10px] text-sky-100 truncate">1 Mobil Full Rombongan Keluarga Door to Door</p>
        </div>
    </div>

    <div class="p-3.5 space-y-3 flex-1">
        <form id="charterBookingForm" onsubmit="proceedCharterBooking(event)" class="space-y-3">

            <!-- 1. Pilihan Keperluan / Paket Charter -->
            <div class="bg-white rounded-2xl p-3.5 border border-slate-200/80 shadow-xs">
                <h4 class="text-xs font-extrabold text-slate-900 border-b border-slate-100 pb-2 mb-2 flex items-center justify-between">
                    <span>1. Pilih Keperluan Sewa</span>
                    <span class="text-[9px] text-sky-600 font-bold bg-sky-50 px-2 py-0.5 rounded-full">All-In Sopir & BBM</span>
                </h4>

                <div class="grid grid-cols-2 gap-2">
                    <label class="charter-purpose-card p-2.5 rounded-xl border-2 border-sky-500 bg-sky-50/60 cursor-pointer flex flex-col justify-between transition">
                        <div class="flex items-center gap-2 mb-1">
                            <input type="radio" name="charterPurpose" value="kondangan" checked onchange="updateCharterTotal()" class="text-sky-600 focus:ring-sky-500">
                            <span class="text-xs font-bold text-slate-900">Kondangan / Acara</span>
                        </div>
                        <p class="text-[9px] text-slate-500 leading-tight">PP hari yang sama / 12 Jam. Cocok untuk hajatan & keluarga.</p>
                        <span class="text-[9px] font-bold text-sky-600 mt-1">Tarif Hemat PP</span>
                    </label>

                    <label class="charter-purpose-card p-2.5 rounded-xl border border-slate-200 bg-white cursor-pointer hover:border-sky-300 flex flex-col justify-between transition">
                        <div class="flex items-center gap-2 mb-1">
                            <input type="radio" name="charterPurpose" value="liburan" onchange="updateCharterTotal()" class="text-sky-600 focus:ring-sky-500">
                            <span class="text-xs font-bold text-slate-900">Liburan / Wisata</span>
                        </div>
                        <p class="text-[9px] text-slate-500 leading-tight">Full day 24 Jam. Wisata Pangandaran, Bandung, luar kota.</p>
                        <span class="text-[9px] font-bold text-emerald-600 mt-1">Fleksibel Rute</span>
                    </label>
                </div>
            </div>

            <!-- 2. Pilihan Tipe Armada -->
            <div class="bg-white rounded-2xl p-3.5 border border-slate-200/80 shadow-xs">
                <h4 class="text-xs font-extrabold text-slate-900 border-b border-slate-100 pb-2 mb-2.5 flex items-center justify-between">
                    <span>2. Pilih Tipe Armada</span>
                    <span class="text-[9px] text-slate-400 font-semibold">AC Dingin & Bersih</span>
                </h4>

                <div class="space-y-2">
                    <!-- Option 1: Daihatsu Xenia (Primary Armada) -->
                    <label class="charter-fleet-card flex items-center justify-between p-2.5 rounded-xl border-2 border-sky-500 bg-sky-50/50 cursor-pointer transition">
                        <div class="flex items-center gap-2.5 min-w-0">
                            <input type="radio" name="charterFleet" value="xenia_all_new" checked onchange="updateCharterTotal()" class="text-sky-600 focus:ring-sky-500">
                            <div class="min-w-0">
                                <p class="text-xs font-extrabold text-slate-900 truncate">Daihatsu All New Xenia (6 Seat)</p>
                                <p class="text-[9px] text-slate-500 truncate">Eksekutif AC Double Blower • Lincah Masuk Gang</p>
                            </div>
                        </div>
                        <span class="text-xs font-black text-sky-600 shrink-0" id="rateDisplay_xenia">Rp 750.000<span class="text-[8px] font-normal text-slate-400">/hari</span></span>
                    </label>

                    <!-- Option 2: Toyota Avanza -->
                    <label class="charter-fleet-card flex items-center justify-between p-2.5 rounded-xl border border-slate-200 bg-white cursor-pointer hover:border-sky-300 transition">
                        <div class="flex items-center gap-2.5 min-w-0">
                            <input type="radio" name="charterFleet" value="avanza_veloz" onchange="updateCharterTotal()" class="text-sky-600 focus:ring-sky-500">
                            <div class="min-w-0">
                                <p class="text-xs font-extrabold text-slate-900 truncate">Toyota Avanza / Veloz (6 Seat)</p>
                                <p class="text-[9px] text-slate-500 truncate">Hemat & Fleksibel untuk Rombongan Kecil</p>
                            </div>
                        </div>
                        <span class="text-xs font-black text-sky-600 shrink-0" id="rateDisplay_avanza">Rp 700.000<span class="text-[8px] font-normal text-slate-400">/hari</span></span>
                    </label>

                    <!-- Option 3: Toyota Innova Zenix -->
                    <label class="charter-fleet-card flex items-center justify-between p-2.5 rounded-xl border border-slate-200 bg-white cursor-pointer hover:border-sky-300 transition">
                        <div class="flex items-center gap-2.5 min-w-0">
                            <input type="radio" name="charterFleet" value="innova_zenix" onchange="updateCharterTotal()" class="text-sky-600 focus:ring-sky-500">
                            <div class="min-w-0">
                                <p class="text-xs font-extrabold text-slate-900 truncate">Toyota Innova Zenix VIP (7 Seat)</p>
                                <p class="text-[9px] text-slate-500 truncate">Family VIP • Suspensi Sangat Empuk & Nyaman</p>
                            </div>
                        </div>
                        <span class="text-xs font-black text-sky-600 shrink-0" id="rateDisplay_zenix">Rp 1.000.000<span class="text-[8px] font-normal text-slate-400">/hari</span></span>
                    </label>

                    <!-- Option 4: Toyota HiAce Premio -->
                    <label class="charter-fleet-card flex items-center justify-between p-2.5 rounded-xl border border-slate-200 bg-white cursor-pointer hover:border-sky-300 transition">
                        <div class="flex items-center gap-2.5 min-w-0">
                            <input type="radio" name="charterFleet" value="hiace_premio" onchange="updateCharterTotal()" class="text-sky-600 focus:ring-sky-500">
                            <div class="min-w-0">
                                <p class="text-xs font-extrabold text-slate-900 truncate">Toyota HiAce Premio Luxury (14 Seat)</p>
                                <p class="text-[9px] text-slate-500 truncate">Ruang Luas & Nyaman • Rombongan Besar</p>
                            </div>
                        </div>
                        <span class="text-xs font-black text-sky-600 shrink-0" id="rateDisplay_hiace">Rp 1.350.000<span class="text-[8px] font-normal text-slate-400">/hari</span></span>
                    </label>
                </div>
            </div>

            <!-- 3. Rute & Durasi Sewa -->
            <div class="bg-white rounded-2xl p-3.5 border border-slate-200/80 space-y-2.5 shadow-xs">
                <h4 class="text-xs font-extrabold text-slate-900 border-b border-slate-100 pb-1.5">3. Rute & Waktu Pemakaian</h4>

                <div class="grid grid-cols-2 gap-2">
                    <div class="bg-slate-50 border border-slate-200/90 rounded-xl px-2.5 py-1.5">
                        <label class="block text-[8px] font-bold uppercase tracking-wider text-slate-400">Kota Penjemputan</label>
                        <select id="charterOrigin" class="w-full bg-transparent text-xs font-bold text-slate-800 focus:outline-none cursor-pointer">
                            <option value="Ciamis" selected>Ciamis</option>
                            <option value="Bandung">Bandung</option>
                            <option value="Tasikmalaya">Tasikmalaya</option>
                            <option value="Banjar">Banjar</option>
                            <option value="Pangandaran">Pangandaran</option>
                        </select>
                    </div>
                    <div class="bg-slate-50 border border-slate-200/90 rounded-xl px-2.5 py-1.5">
                        <label class="block text-[8px] font-bold uppercase tracking-wider text-slate-400">Kota Tujuan / Acara</label>
                        <select id="charterDestination" class="w-full bg-transparent text-xs font-bold text-slate-800 focus:outline-none cursor-pointer">
                            <option value="Bandung" selected>Bandung / Lembang</option>
                            <option value="Pangandaran">Pantai Pangandaran</option>
                            <option value="Garut">Garut / Cipanas</option>
                            <option value="Jakarta">Jakarta / Jabodetabek</option>
                            <option value="Ciamis">Area Ciamis Sekitarnya</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-2">
                    <div class="bg-slate-50 border border-slate-200/90 rounded-xl px-2.5 py-1.5">
                        <label for="charterDate" class="block text-[8px] font-bold uppercase tracking-wider text-slate-400">Tanggal Mulai</label>
                        <input type="date" id="charterDate" min="{{ date('Y-m-d') }}" value="{{ date('Y-m-d') }}" class="w-full bg-transparent text-xs font-bold text-slate-800 focus:outline-none cursor-pointer">
                    </div>
                    <div class="bg-slate-50 border border-slate-200/90 rounded-xl px-2.5 py-1.5">
                        <label class="block text-[8px] font-bold uppercase tracking-wider text-slate-400">Durasi Sewa</label>
                        <select id="charterDuration" onchange="updateCharterTotal()" class="w-full bg-transparent text-xs font-bold text-slate-800 focus:outline-none cursor-pointer">
                            <option value="1" selected>1 Hari (PP / Full Day)</option>
                            <option value="2">2 Hari</option>
                            <option value="3">3 Hari</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- 4. Form Kontak & Alamat -->
            <div class="bg-white rounded-2xl p-3.5 border border-slate-200/80 space-y-2.5 shadow-xs">
                <h4 class="text-xs font-extrabold text-slate-900 border-b border-slate-100 pb-1.5">4. Kontak & Lokasi Jemput</h4>

                <div>
                    <label class="block text-[9px] font-bold text-slate-500 mb-1 uppercase">Nama Pemesan / Penanggung Jawab *</label>
                    <input type="text" id="charterName" required placeholder="Nama Lengkap Anda" value="" class="w-full h-9 bg-slate-50 border border-slate-200 rounded-xl px-3 text-xs text-slate-900 font-semibold focus:ring-2 focus:ring-sky-500 focus:bg-white focus:outline-none">
                </div>

                <div>
                    <label class="block text-[9px] font-bold text-slate-500 mb-1 uppercase">Nomor WhatsApp Aktif *</label>
                    <input type="tel" id="charterPhone" required placeholder="0812xxxxxxxx" value="" class="w-full h-9 bg-slate-50 border border-slate-200 rounded-xl px-3 text-xs text-slate-900 font-semibold focus:ring-2 focus:ring-sky-500 focus:bg-white focus:outline-none">
                </div>

                <div>
                    <label class="block text-[9px] font-bold text-slate-500 mb-1 uppercase">Alamat Lengkap Titik Kumpul / Penjemputan</label>
                    <textarea id="charterPickup" required rows="2" placeholder="Nama gang, jalan, patokan rumah penjemputan..." class="w-full bg-slate-50 border border-slate-200 rounded-xl p-2 text-xs text-slate-900 font-medium focus:ring-2 focus:ring-sky-500 focus:bg-white focus:outline-none"></textarea>
                </div>
            </div>

            <!-- Total & Action Button -->
            <div class="bg-white border border-slate-200 rounded-2xl p-3.5 shadow-sm space-y-2.5">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-[9px] text-slate-400 font-bold uppercase">Total Biaya Sewa Unit</p>
                        <p class="text-base font-black text-sky-600" id="charterTotalPriceDisplay">Rp 750.000</p>
                    </div>
                    <span class="text-[9px] text-emerald-700 bg-emerald-50 px-2.5 py-1 rounded-full font-bold">Include Driver & BBM</span>
                </div>
                <button type="submit" id="btnSubmitCharter" class="w-full py-3 rounded-xl bg-gradient-to-r from-sky-500 to-sky-600 hover:from-sky-600 hover:to-sky-700 text-white font-bold text-xs shadow-md shadow-sky-500/20 transition flex items-center justify-center gap-2 whitespace-nowrap cursor-pointer">
                    <span>Booking sekarang</span>
                    <i class="fas fa-arrow-right text-[10px]"></i>
                </button>
            </div>
        </form>
    </div>
</section>
