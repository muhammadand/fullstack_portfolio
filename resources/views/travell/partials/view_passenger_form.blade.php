<!-- ================= VIEW 4: PASSENGER FORM & ADDRESS ================= -->
<section id="viewPassengerForm" class="flex-1 hidden flex-col bg-slate-50">
    <!-- Top Nav Bar (Sky Blue) -->
    <div class="bg-gradient-to-r from-sky-600 to-sky-500 text-white px-4 py-2.5 sticky top-0 z-30 flex items-center gap-2.5 shadow-sm">
        <button type="button" onclick="switchView('viewSeatPicker')" class="w-7 h-7 rounded-full bg-white/20 backdrop-blur-md flex items-center justify-center text-white text-xs shrink-0 active:scale-95 cursor-pointer">
            <i class="fas fa-arrow-left"></i>
        </button>
        <div class="flex-1 min-w-0">
            <h3 class="text-xs font-extrabold text-white">Data Penumpang & Alamat</h3>
            <p class="text-[10px] text-sky-100 truncate">Layanan Door to Door Langsung ke Rumah</p>
        </div>
    </div>

    <div class="p-3.5 space-y-3 flex-1">
        <!-- Order Summary Box -->
        <div class="bg-sky-50 border border-sky-200/80 rounded-2xl p-3 text-slate-800 shadow-xs">
            <div class="flex items-center justify-between pb-1.5 mb-1.5 border-b border-sky-200/60">
                <span class="text-xs font-extrabold text-slate-900 truncate" id="formSummaryRoute">Ciamis ➔ Bandung</span>
                <span class="text-[9px] font-bold text-sky-700 bg-sky-200/70 px-2 py-0.5 rounded-full whitespace-nowrap shrink-0" id="formSummarySeatsBadge">1 Kursi (K-01)</span>
            </div>
            <p class="text-[10px] text-slate-600 flex items-center gap-1.5 truncate" id="formSummaryFleet">
                <i class="fas fa-car text-sky-600 shrink-0"></i> <span>Daihatsu All New Xenia (06:00 WIB)</span>
            </p>
        </div>

        <!-- Input Form -->
        <form id="mobileBookingForm" onsubmit="proceedToPayment(event)" class="space-y-3">
            <div class="bg-white rounded-2xl p-3.5 border border-slate-200/80 space-y-2.5 shadow-xs">
                <h4 class="text-xs font-extrabold text-slate-900 border-b border-slate-100 pb-1.5">Kontak Pemesan</h4>

                <div>
                    <label class="block text-[9px] font-bold text-slate-500 mb-1 uppercase">Nama Lengkap Penumpang *</label>
                    <input type="text" id="custName" required placeholder="Contoh: Andi Pratama" value="" class="w-full h-9 bg-slate-50 border border-slate-200 rounded-xl px-3 text-xs text-slate-900 font-semibold focus:ring-2 focus:ring-sky-500 focus:bg-white focus:outline-none">
                </div>

                <div>
                    <label class="block text-[9px] font-bold text-slate-500 mb-1 uppercase">Nomor WhatsApp Aktif *</label>
                    <input type="tel" id="custPhone" required placeholder="0812xxxxxxxx" value="" class="w-full h-9 bg-slate-50 border border-slate-200 rounded-xl px-3 text-xs text-slate-900 font-semibold focus:ring-2 focus:ring-sky-500 focus:bg-white focus:outline-none">
                </div>
            </div>

            <!-- Titik Antar Jemput (Pilihan Pool Resmi vs Antar-Jemput Rumah) -->
            <div class="bg-white rounded-2xl p-3.5 border border-slate-200/80 space-y-3.5 shadow-xs">
                <div class="border-b border-slate-100 pb-2 flex items-center justify-between">
                    <div>
                        <h4 class="text-xs font-extrabold text-slate-900">Titik Jemput & Pengantaran</h4>
                        <p class="text-[10px] text-slate-400">Pilih naik di Pool kami atau jemput langsung ke rumah</p>
                    </div>
                    <span class="text-[9px] font-bold text-sky-700 bg-sky-50 border border-sky-100 px-2 py-0.5 rounded-full">
                        <i class="fas fa-location-dot text-sky-500 mr-0.5"></i> Pool & Door-to-Door
                    </span>
                </div>

                <!-- 1. Penjemputan (Asal) -->
                <div class="space-y-1.5">
                    <div class="flex items-center justify-between">
                        <label class="block text-[9px] font-bold text-slate-500 uppercase">1. Titik Penjemputan (Naik Dari Mana?) *</label>
                        <button type="button" onclick="detectCurrentLocation('custPickup')" class="text-[9px] font-bold text-sky-600 hover:text-sky-700 inline-flex items-center gap-1 cursor-pointer">
                            <i class="fas fa-location-crosshairs"></i>
                            <span>Gunakan Lokasi Saat Ini</span>
                        </button>
                    </div>
                    <div class="grid grid-cols-2 gap-1.5 bg-slate-100 p-1 rounded-xl">
                        <button type="button" id="btnPickupTypePool" onclick="setPickupType('pool')" class="py-1.5 px-2 rounded-lg text-[10px] font-bold transition flex items-center justify-center gap-1.5 bg-white text-sky-700 shadow-xs cursor-pointer">
                            <i class="fas fa-building text-[10px]"></i>
                            <span>Naik di Pool</span>
                        </button>
                        <button type="button" id="btnPickupTypeDoor" onclick="setPickupType('door')" class="py-1.5 px-2 rounded-lg text-[10px] font-bold transition flex items-center justify-center gap-1.5 text-slate-600 hover:text-slate-900 cursor-pointer">
                            <i class="fas fa-house-user text-[10px]"></i>
                            <span>Jemput di Rumah</span>
                        </button>
                    </div>

                    <!-- Dropdown Pilihan Pool Jemput -->
                    <div id="pickupPoolSelectContainer" class="mt-1.5">
                        <select id="pickupPoolSelect" onchange="syncPickupAddress()" class="w-full h-9 bg-slate-50 border border-slate-200 rounded-xl px-2.5 text-xs text-slate-900 font-semibold focus:ring-2 focus:ring-sky-500 focus:bg-white focus:outline-none cursor-pointer">
                            <option value="Pool Ciamis (Kantor Pusat) - Jl. Jenderal Sudirman No. 88, Ciamis (Depan Alun-Alun)">Pool Ciamis (Kantor Pusat - Jl. Jend. Sudirman No. 88)</option>
                            <option value="Pool Pasteur Bandung - Jl. Dr. Djunjunan No. 135 (Dekat Gerbang Tol Pasteur)">Pool Pasteur Bandung (Jl. Dr. Djunjunan No. 135)</option>
                            <option value="Pool Dipatiukur Bandung - Jl. Dipatiukur No. 45, Coblong (Dekat Kampus UNPAD)">Pool Dipatiukur Bandung (Jl. Dipatiukur No. 45)</option>
                        </select>
                    </div>

                    <!-- Input Detail Alamat Rumah / Titik Khusus -->
                    <div id="pickupCustomAddressContainer" class="space-y-1">
                        <textarea id="custPickup" required rows="2" placeholder="Tuliskan nama jalan, nomor rumah, gang, atau patokan penjemputan..." class="w-full bg-slate-50 border border-slate-200 rounded-xl p-2.5 text-xs text-slate-900 font-medium focus:ring-2 focus:ring-sky-500 focus:bg-white focus:outline-none"></textarea>
                    </div>
                </div>

                <!-- 2. Pengantaran (Tujuan) -->
                <div class="space-y-1.5 pt-2 border-t border-slate-100">
                    <label class="block text-[9px] font-bold text-slate-500 uppercase">2. Titik Pengantaran (Turun Di Mana?) *</label>
                    <div class="grid grid-cols-2 gap-1.5 bg-slate-100 p-1 rounded-xl">
                        <button type="button" id="btnDropoffTypePool" onclick="setDropoffType('pool')" class="py-1.5 px-2 rounded-lg text-[10px] font-bold transition flex items-center justify-center gap-1.5 bg-white text-rose-700 shadow-xs cursor-pointer">
                            <i class="fas fa-building text-[10px]"></i>
                            <span>Turun di Pool</span>
                        </button>
                        <button type="button" id="btnDropoffTypeDoor" onclick="setDropoffType('door')" class="py-1.5 px-2 rounded-lg text-[10px] font-bold transition flex items-center justify-center gap-1.5 text-slate-600 hover:text-slate-900 cursor-pointer">
                            <i class="fas fa-map-location-dot text-[10px]"></i>
                            <span>Diantar ke Alamat</span>
                        </button>
                    </div>

                    <!-- Dropdown Pilihan Pool Antar -->
                    <div id="dropoffPoolSelectContainer" class="mt-1.5">
                        <select id="dropoffPoolSelect" onchange="syncDropoffAddress()" class="w-full h-9 bg-slate-50 border border-slate-200 rounded-xl px-2.5 text-xs text-slate-900 font-semibold focus:ring-2 focus:ring-sky-500 focus:bg-white focus:outline-none cursor-pointer">
                            <option value="Pool Pasteur Bandung - Jl. Dr. Djunjunan No. 135 (Dekat Gerbang Tol Pasteur)">Pool Pasteur Bandung (Jl. Dr. Djunjunan No. 135)</option>
                            <option value="Pool Dipatiukur Bandung - Jl. Dipatiukur No. 45, Coblong (Dekat Kampus UNPAD)">Pool Dipatiukur Bandung (Jl. Dipatiukur No. 45)</option>
                            <option value="Pool Ciamis (Kantor Pusat) - Jl. Jenderal Sudirman No. 88, Ciamis (Depan Alun-Alun)">Pool Ciamis (Kantor Pusat - Jl. Jend. Sudirman No. 88)</option>
                        </select>
                    </div>

                    <!-- Input Detail Alamat Tujuan / Khusus -->
                    <div id="dropoffCustomAddressContainer" class="space-y-1">
                        <textarea id="custDropoff" required rows="2" placeholder="Tuliskan alamat lengkap tujuan, nama kantor, hotel, atau rumah pengantaran..." class="w-full bg-slate-50 border border-slate-200 rounded-xl p-2.5 text-xs text-slate-900 font-medium focus:ring-2 focus:ring-sky-500 focus:bg-white focus:outline-none"></textarea>
                    </div>
                </div>
            </div>

            <button type="submit" id="btnSubmitMobileBooking" class="w-full py-3 rounded-xl bg-gradient-to-r from-sky-500 to-sky-600 hover:from-sky-600 hover:to-sky-700 text-white font-bold text-xs shadow-md shadow-sky-500/20 transition flex items-center justify-center gap-2 whitespace-nowrap cursor-pointer">
                <span>Lanjut ke Pembayaran QRIS</span>
                <i class="fas fa-qrcode"></i>
            </button>
        </form>
    </div>
</section>
