<!-- ================= VIEW 3: SEAT PICKER (MULTI-SEAT SELECTION: MIN 4 SEATS) ================= -->
<section id="viewSeatPicker" class="flex-1 hidden flex-col bg-slate-50">
    <!-- Top Nav Bar (Sky Blue) -->
    <div class="bg-gradient-to-r from-sky-600 to-sky-500 text-white px-4 py-2.5 sticky top-0 z-30 flex items-center gap-2.5 shadow-sm">
        <button type="button" onclick="switchView('viewSchedules')" class="w-7 h-7 rounded-full bg-white/20 backdrop-blur-md flex items-center justify-center text-white text-xs shrink-0 active:scale-95 cursor-pointer">
            <i class="fas fa-arrow-left"></i>
        </button>
        <div class="flex-1 min-w-0">
            <h3 class="text-xs font-extrabold text-white">Pilih Kursi Penumpang</h3>
            <p class="text-[10px] text-sky-100 truncate" id="seatPickerSubtitle">Daihatsu All New Xenia • Ciamis ➔ Bandung</p>
        </div>
    </div>

    <div class="p-3.5 flex-1">
        <!-- Min Quota Rule Notice Banner -->
        <div class="bg-amber-50 border border-amber-200 rounded-2xl p-2.5 mb-3 flex items-start gap-2 shadow-xs">
            <div class="w-5 h-5 rounded-full bg-amber-500 text-white flex items-center justify-center text-[10px] shrink-0 mt-0.5">
                <i class="fas fa-users"></i>
            </div>
            <div class="flex-1 min-w-0">
                <h4 class="text-[11px] font-black text-amber-900">Aturan Booking: Minimal 4 Kursi</h4>
                <p class="text-[10px] text-amber-700 leading-tight mt-0.5">
                    Layanan shuttle eksekutif door to door membutuhkan pemesanan <strong>minimal 4 kursi</strong> untuk kepastian jadwal berangkat.
                </p>
            </div>
        </div>

        <!-- Seat Legends -->
        <div class="bg-white rounded-2xl p-2.5 border border-slate-200/80 mb-3 flex items-center justify-around text-[10px] font-bold text-slate-700 shadow-xs">
            <span class="flex items-center gap-1.5 whitespace-nowrap"><span class="w-3.5 h-3.5 rounded-md bg-white border border-slate-300"></span> Kosong</span>
            <span class="flex items-center gap-1.5 whitespace-nowrap"><span class="w-3.5 h-3.5 rounded-md bg-rose-50 border border-rose-200 text-rose-300"></span> Terisi</span>
            <span class="flex items-center gap-1.5 whitespace-nowrap"><span class="w-3.5 h-3.5 rounded-md bg-sky-500 border border-sky-600"></span> Dipilih</span>
        </div>

        <!-- Front / Driver Indicator -->
        <div class="text-center mb-2.5">
            <span class="inline-block px-3 py-0.5 rounded-full bg-slate-200 text-slate-600 text-[9px] font-bold uppercase tracking-wider whitespace-nowrap">
                <i class="fa-solid fa-id-badge mr-1 text-slate-500"></i> Bagian Depan Mobil
            </span>
        </div>

        <!-- Seat Layout Box (Daihatsu Xenia 5 Passenger Seats) -->
        <div class="bg-white rounded-2xl p-3.5 border border-slate-200/80 max-w-xs mx-auto shadow-xs">
            <div id="interactiveSeatsGrid" class="space-y-3">
                <!-- Populated dynamically via JS -->
            </div>
        </div>

        <!-- Tip Notice -->
        <p class="text-[10px] text-center text-slate-500 mt-3 leading-tight">
            <i class="fas fa-info-circle text-sky-600 mr-1"></i> Klik kursi untuk memilih atau membatalkan pilihan.
        </p>
    </div>

    <!-- Bottom Floating Drawer for Selected Seats & Total -->
    <div class="bg-white border-t border-slate-200 p-3.5 sticky bottom-0 z-30 shadow-[0_-4px_16px_rgba(0,0,0,0.06)]">
        <div class="flex items-center justify-between mb-2.5">
            <div class="min-w-0 flex-1 pr-2">
                <p class="text-[9px] text-slate-400 font-bold uppercase">Kursi Terpilih</p>
                <p class="text-xs font-bold text-slate-900 truncate" id="selectedSeatsLabel">Belum Ada Kursi</p>
            </div>
            <div class="text-right shrink-0">
                <p class="text-[9px] text-slate-400 font-bold uppercase">Total Biaya</p>
                <p class="text-sm font-black text-sky-600" id="selectedSeatsTotalPrice">Rp 0</p>
            </div>
        </div>
        <button type="button" id="btnContinueToPassenger" onclick="proceedToPassengerForm()" disabled class="w-full py-3 rounded-xl bg-slate-200 text-slate-400 font-bold text-xs transition flex items-center justify-center gap-2 whitespace-nowrap cursor-not-allowed">
            <span id="btnContinueLabel">Pilih minimal 4 kursi (Kurang 4)</span>
            <i class="fas fa-arrow-right text-[10px]"></i>
        </button>
    </div>
</section>
