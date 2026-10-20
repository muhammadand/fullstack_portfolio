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
                    <input type="text" id="custName" required placeholder="Contoh: Andi Pratama" value="Andi Pratama" class="w-full h-9 bg-slate-50 border border-slate-200 rounded-xl px-3 text-xs text-slate-900 font-semibold focus:ring-2 focus:ring-sky-500 focus:bg-white focus:outline-none">
                </div>

                <div>
                    <label class="block text-[9px] font-bold text-slate-500 mb-1 uppercase">Nomor WhatsApp Aktif *</label>
                    <input type="tel" id="custPhone" required placeholder="0812xxxxxxxx" value="081234567890" class="w-full h-9 bg-slate-50 border border-slate-200 rounded-xl px-3 text-xs text-slate-900 font-semibold focus:ring-2 focus:ring-sky-500 focus:bg-white focus:outline-none">
                </div>
            </div>

            <div class="bg-white rounded-2xl p-3.5 border border-slate-200/80 space-y-2.5 shadow-xs">
                <h4 class="text-xs font-extrabold text-slate-900 border-b border-slate-100 pb-1.5">Titik Antar Jemput (Door to Door)</h4>

                <div>
                    <label class="block text-[9px] font-bold text-slate-500 mb-1 uppercase">Alamat Penjemputan di Rumah / Pool</label>
                    <textarea id="custPickup" required rows="2" placeholder="Jl. Sudirman No. 12, atau Pool Ciamis..." class="w-full bg-slate-50 border border-slate-200 rounded-xl p-2 text-xs text-slate-900 font-medium focus:ring-2 focus:ring-sky-500 focus:bg-white focus:outline-none">Jl. Jenderal Sudirman No. 88, Ciamis</textarea>
                </div>

                <div>
                    <label class="block text-[9px] font-bold text-slate-500 mb-1 uppercase">Alamat Pengantaran Tujuan</label>
                    <textarea id="custDropoff" required rows="2" placeholder="Jl. Dipatiukur, Pasteur, atau Alamat Rumah di Bandung..." class="w-full bg-slate-50 border border-slate-200 rounded-xl p-2 text-xs text-slate-900 font-medium focus:ring-2 focus:ring-sky-500 focus:bg-white focus:outline-none">Jl. Dipatiukur No. 45, Coblong, Kota Bandung</textarea>
                </div>
            </div>

            <button type="submit" id="btnSubmitMobileBooking" class="w-full py-3 rounded-xl bg-gradient-to-r from-sky-500 to-sky-600 hover:from-sky-600 hover:to-sky-700 text-white font-bold text-xs shadow-md shadow-sky-500/20 transition flex items-center justify-center gap-2 whitespace-nowrap cursor-pointer">
                <span>Lanjut ke Pembayaran QRIS</span>
                <i class="fas fa-qrcode"></i>
            </button>
        </form>
    </div>
</section>
