<!-- ================= VIEW 3: SEAT PICKER (MULTI-SEAT SELECTION: MIN 4 SEATS) ================= -->
<section id="viewSeatPicker" class="space-y-4" style="display: none;">
    <!-- Top Nav Bar -->
    <div class="flex items-center gap-3">
        <button type="button" onclick="switchView('viewHome')" class="w-8 h-8 rounded-full glass-panel flex items-center justify-center text-white text-xs shrink-0 active:scale-95 cursor-pointer border border-white/10">
            <i class="fas fa-arrow-left"></i>
        </button>
        <div class="flex-1 min-w-0">
            <h3 class="text-xs font-extrabold text-white">Pilih Kursi Penumpang</h3>
            <p class="text-[10px] text-blue-300 truncate" id="seatPickerSubtitle">Daihatsu All New Xenia • Ciamis ➔ Bandung</p>
        </div>
    </div>

    <!-- Min Quota Rule Notice Banner -->
    <div class="glass-panel rounded-2xl p-3 border border-amber-500/30 bg-amber-500/10 flex items-start gap-2.5">
        <div class="w-6 h-6 rounded-full bg-amber-500/20 text-amber-400 flex items-center justify-center text-[10px] shrink-0 mt-0.5">
            <i class="fas fa-users"></i>
        </div>
        <div class="flex-1 min-w-0">
            <h4 class="text-[11px] font-black text-amber-300">Aturan Booking: Minimal 4 Kursi</h4>
            <p class="text-[10px] text-amber-200/80 leading-relaxed mt-0.5">
                Layanan shuttle eksekutif door to door membutuhkan pemesanan <strong>minimal 4 kursi</strong> untuk kepastian jadwal berangkat.
            </p>
        </div>
    </div>

    <!-- Seat Legends -->
    <div class="glass-panel rounded-2xl p-3 border border-white/10 flex items-center justify-around text-[10px] font-bold text-slate-300">
        <span class="flex items-center gap-1.5"><span class="w-3.5 h-3.5 rounded-md bg-white/10 border border-white/20"></span> Kosong</span>
        <span class="flex items-center gap-1.5"><span class="w-3.5 h-3.5 rounded-md bg-rose-500/20 border border-rose-500/40 text-rose-300"></span> Terisi</span>
        <span class="flex items-center gap-1.5"><span class="w-3.5 h-3.5 rounded-md bg-blue-600 border border-blue-400 shadow-sm shadow-blue-500/50"></span> Dipilih</span>
    </div>

    <!-- Front / Driver Indicator -->
    <div class="text-center">
        <span class="inline-block px-3 py-1 rounded-full glass-panel text-slate-400 text-[9px] font-bold uppercase tracking-wider border border-white/10">
            <i class="fa-solid fa-id-badge mr-1 text-blue-400"></i> Bagian Depan Mobil
        </span>
    </div>

    <!-- Seat Layout Box (Daihatsu Xenia 5 Passenger Seats) -->
    <div class="glass-panel rounded-3xl p-4 border border-white/15 max-w-xs mx-auto shadow-2xl">
        <div id="interactiveSeatsGrid" class="space-y-3">
            <!-- Populated dynamically via JS -->
        </div>
    </div>

    <!-- Tip Notice -->
    <p class="text-[10px] text-center text-slate-400 leading-tight">
        <i class="fas fa-info-circle text-blue-400 mr-1"></i> Klik kursi untuk memilih atau membatalkan pilihan.
    </p>

    <!-- Bottom Floating Drawer for Selected Seats & Total -->
    <div class="glass-card rounded-2xl p-4 border border-white/15 shadow-2xl">
        <div class="flex items-center justify-between mb-3">
            <div class="min-w-0 flex-1 pr-2">
                <p class="text-[9px] text-slate-400 font-bold uppercase tracking-wider">Kursi Terpilih</p>
                <p class="text-xs font-bold text-white truncate" id="selectedSeatsLabel">Belum Ada Kursi</p>
            </div>
            <div class="text-right shrink-0">
                <p class="text-[9px] text-slate-400 font-bold uppercase tracking-wider">Total Biaya</p>
                <p class="text-sm font-black text-blue-400 font-mono" id="selectedSeatsTotalPrice">Rp 0</p>
            </div>
        </div>
        <button type="button" id="btnContinueToPassenger" onclick="proceedToPassengerForm()" disabled class="w-full h-11 rounded-xl bg-white/10 text-slate-500 font-bold text-xs transition flex items-center justify-center gap-2 cursor-not-allowed">
            <span id="btnContinueLabel">Pilih minimal 4 kursi (Kurang 4)</span>
            <i class="fas fa-arrow-right text-[10px]"></i>
        </button>
    </div>
</section>
