<!-- ================= VIEW 4: PASSENGER FORM & ADDRESS (TAILWIND GLASS) ================= -->
<section id="viewPassengerForm" class="flex-1 hidden flex-col space-y-4 pb-20">

    <!-- Top Nav Bar -->
    <div class="glass-panel rounded-2xl p-3 border border-white/10 flex items-center gap-3 shadow-lg">
        <button type="button" onclick="switchView('viewSeatPicker')" class="w-8 h-8 rounded-xl glass-panel flex items-center justify-center text-slate-300 hover:text-white text-xs shrink-0 active:scale-95 transition cursor-pointer">
            <i class="fas fa-arrow-left"></i>
        </button>
        <div class="flex-1 min-w-0">
            <h3 class="text-xs font-black text-white truncate">Data Penumpang & Alamat</h3>
            <p class="text-[10px] text-slate-400 truncate">Layanan Door to Door Langsung ke Rumah</p>
        </div>
    </div>

    <!-- Order Summary Box -->
    <div class="glass-card rounded-2xl p-3.5 border border-white/15 space-y-2 shadow-lg">
        <div class="flex items-center justify-between pb-2 border-b border-white/10">
            <span class="text-xs font-black text-white truncate" id="formSummaryRoute">Ciamis ➔ Bandung</span>
            <span class="text-[10px] font-extrabold text-blue-300 bg-blue-500/20 border border-blue-400/30 px-2.5 py-0.5 rounded-full whitespace-nowrap shrink-0" id="formSummarySeatsBadge">1 Kursi (K-01)</span>
        </div>
        <p class="text-[10px] text-slate-400 flex items-center gap-2 truncate" id="formSummaryFleet">
            <i class="fas fa-car text-blue-400 shrink-0"></i>
            <span>Daihatsu All New Xenia (06:00 WIB)</span>
        </p>
    </div>

    <!-- Input Form -->
    <form id="mobileBookingForm" onsubmit="proceedToPayment(event)" class="space-y-4">

        <!-- Kontak Pemesan -->
        <div class="glass-panel rounded-2xl p-4 border border-white/10 space-y-3 shadow-lg">
            <h4 class="text-xs font-extrabold text-white border-b border-white/10 pb-2">Kontak Pemesan</h4>

            <div>
                <label class="block text-[10px] font-bold text-slate-400 mb-1.5 uppercase tracking-wider">Nama Lengkap Penumpang *</label>
                <div class="relative flex items-center">
                    <i class="far fa-user absolute left-3.5 text-slate-500 text-xs"></i>
                    <input type="text" id="custName" required placeholder="Contoh: Andi Pratama" value="" class="w-full h-10 bg-black/30 border border-white/10 rounded-xl pl-9 pr-3 text-xs text-white placeholder-slate-500 font-semibold focus:outline-none focus:border-blue-500 transition">
                </div>
            </div>

            <div>
                <label class="block text-[10px] font-bold text-slate-400 mb-1.5 uppercase tracking-wider">Nomor WhatsApp Aktif *</label>
                <div class="relative flex items-center">
                    <i class="fab fa-whatsapp absolute left-3.5 text-emerald-400 text-xs"></i>
                    <input type="tel" id="custPhone" required placeholder="0812xxxxxxxx" value="" class="w-full h-10 bg-black/30 border border-white/10 rounded-xl pl-9 pr-3 text-xs text-white placeholder-slate-500 font-mono font-semibold focus:outline-none focus:border-blue-500 transition">
                </div>
            </div>
        </div>

        <!-- Titik Antar Jemput (Pilihan Pool Resmi vs Antar-Jemput Rumah) -->
        <div class="glass-panel rounded-2xl p-4 border border-white/10 space-y-4 shadow-lg">
            <div class="border-b border-white/10 pb-2.5 flex items-center justify-between">
                <div>
                    <h4 class="text-xs font-extrabold text-white">Titik Jemput & Pengantaran</h4>
                    <p class="text-[10px] text-slate-400">Pilih naik di Pool kami atau jemput langsung ke rumah</p>
                </div>
                <span class="text-[9px] font-bold text-blue-300 bg-blue-500/20 border border-blue-400/30 px-2 py-0.5 rounded-full shrink-0">
                    <i class="fas fa-location-dot text-blue-400 mr-0.5"></i> Pool & Door-to-Door
                </span>
            </div>

            <!-- 1. Penjemputan (Asal) -->
            <div class="space-y-2">
                <div class="flex items-center justify-between">
                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider">1. Titik Penjemputan (Naik Dari Mana?) *</label>
                    <button type="button" onclick="detectCurrentLocation('custPickup')" class="text-[10px] font-bold text-blue-400 hover:text-blue-300 inline-flex items-center gap-1 cursor-pointer transition">
                        <i class="fas fa-location-crosshairs text-[10px]"></i>
                        <span>Gunakan GPS</span>
                    </button>
                </div>

                <div class="grid grid-cols-2 gap-1.5 glass-panel p-1 rounded-xl border border-white/10">
                    <button type="button" id="btnPickupTypePool" onclick="setPickupType('pool')" class="py-2 px-3 rounded-xl text-xs font-bold transition flex items-center justify-center gap-1.5 bg-blue-600 text-white shadow-md shadow-blue-500/25 cursor-pointer">
                        <i class="fas fa-building text-[10px]"></i>
                        <span>Naik di Pool</span>
                    </button>
                    <button type="button" id="btnPickupTypeDoor" onclick="setPickupType('door')" class="py-2 px-3 rounded-xl text-xs font-bold transition flex items-center justify-center gap-1.5 text-slate-400 hover:text-white cursor-pointer">
                        <i class="fas fa-house-user text-[10px]"></i>
                        <span>Jemput di Rumah</span>
                    </button>
                </div>

                <!-- Dropdown Pilihan Pool Jemput -->
                <div id="pickupPoolSelectContainer" class="mt-2">
                    <select id="pickupPoolSelect" onchange="syncPickupAddress()" class="w-full h-10 bg-slate-900 border border-white/15 rounded-xl px-3 text-xs text-white font-medium focus:outline-none focus:border-blue-500 cursor-pointer">
                        <option value="Pool Ciamis (Kantor Pusat) - Jl. Jenderal Sudirman No. 88, Ciamis (Depan Alun-Alun)">Pool Ciamis (Kantor Pusat - Jl. Jend. Sudirman No. 88)</option>
                        <option value="Pool Pasteur Bandung - Jl. Dr. Djunjunan No. 135 (Dekat Gerbang Tol Pasteur)">Pool Pasteur Bandung (Jl. Dr. Djunjunan No. 135)</option>
                        <option value="Pool Dipatiukur Bandung - Jl. Dipatiukur No. 45, Coblong (Dekat Kampus UNPAD)">Pool Dipatiukur Bandung (Jl. Dipatiukur No. 45)</option>
                    </select>
                </div>

                <!-- Input Detail Alamat Rumah / Titik Khusus -->
                <div id="pickupCustomAddressContainer" class="space-y-1 mt-2">
                    <textarea id="custPickup" required rows="2" placeholder="Tuliskan nama jalan, nomor rumah, gang, atau patokan penjemputan..." class="w-full bg-black/30 border border-white/10 rounded-xl p-3 text-xs text-white placeholder-slate-500 font-medium focus:outline-none focus:border-blue-500 transition"></textarea>
                </div>
            </div>

            <!-- 2. Pengantaran (Tujuan) -->
            <div class="space-y-2 pt-3 border-t border-white/10">
                <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider">2. Titik Pengantaran (Turun Di Mana?) *</label>

                <div class="grid grid-cols-2 gap-1.5 glass-panel p-1 rounded-xl border border-white/10">
                    <button type="button" id="btnDropoffTypePool" onclick="setDropoffType('pool')" class="py-2 px-3 rounded-xl text-xs font-bold transition flex items-center justify-center gap-1.5 bg-rose-600 text-white shadow-md shadow-rose-500/25 cursor-pointer">
                        <i class="fas fa-building text-[10px]"></i>
                        <span>Turun di Pool</span>
                    </button>
                    <button type="button" id="btnDropoffTypeDoor" onclick="setDropoffType('door')" class="py-2 px-3 rounded-xl text-xs font-bold transition flex items-center justify-center gap-1.5 text-slate-400 hover:text-white cursor-pointer">
                        <i class="fas fa-map-location-dot text-[10px]"></i>
                        <span>Diantar ke Alamat</span>
                    </button>
                </div>

                <!-- Dropdown Pilihan Pool Antar -->
                <div id="dropoffPoolSelectContainer" class="mt-2">
                    <select id="dropoffPoolSelect" onchange="syncDropoffAddress()" class="w-full h-10 bg-slate-900 border border-white/15 rounded-xl px-3 text-xs text-white font-medium focus:outline-none focus:border-blue-500 cursor-pointer">
                        <option value="Pool Pasteur Bandung - Jl. Dr. Djunjunan No. 135 (Dekat Gerbang Tol Pasteur)">Pool Pasteur Bandung (Jl. Dr. Djunjunan No. 135)</option>
                        <option value="Pool Dipatiukur Bandung - Jl. Dipatiukur No. 45, Coblong (Dekat Kampus UNPAD)">Pool Dipatiukur Bandung (Jl. Dipatiukur No. 45)</option>
                        <option value="Pool Ciamis (Kantor Pusat) - Jl. Jenderal Sudirman No. 88, Ciamis (Depan Alun-Alun)">Pool Ciamis (Kantor Pusat - Jl. Jend. Sudirman No. 88)</option>
                    </select>
                </div>

                <!-- Input Detail Alamat Tujuan / Khusus -->
                <div id="dropoffCustomAddressContainer" class="space-y-1 mt-2">
                    <textarea id="custDropoff" required rows="2" placeholder="Tuliskan alamat lengkap tujuan, nama kantor, hotel, atau rumah pengantaran..." class="w-full bg-black/30 border border-white/10 rounded-xl p-3 text-xs text-white placeholder-slate-500 font-medium focus:outline-none focus:border-blue-500 transition"></textarea>
                </div>
            </div>
        </div>

        <button type="submit" id="btnSubmitMobileBooking" class="w-full h-12 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-500 hover:to-indigo-500 text-white font-extrabold text-xs rounded-xl shadow-lg shadow-blue-500/25 flex items-center justify-center gap-2 active:scale-[0.99] transition cursor-pointer">
            <span>Lanjut ke Pembayaran QRIS</span>
            <i class="fas fa-qrcode text-xs"></i>
        </button>
    </form>
</section>
