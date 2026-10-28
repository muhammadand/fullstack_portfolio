<!-- ================= VIEW 6: SUCCESS & LUXURY E-TICKET DETAIL ================= -->
<section id="viewSuccessTicket" class="space-y-4" style="display: none;">

    <!-- Top Action Bar -->
    <div class="flex items-center justify-between">
        <button type="button" onclick="switchView('viewHome')" class="glass-panel px-3 py-1.5 rounded-full text-xs font-bold text-slate-300 hover:text-white flex items-center gap-1.5 transition active:scale-95 cursor-pointer">
            <i class="fas fa-chevron-left text-[10px]"></i>
            <span>Beranda</span>
        </button>
        <span class="glass-panel px-3 py-1.5 rounded-full text-[10px] font-bold text-blue-300 border border-blue-500/30 flex items-center gap-1.5 shadow-sm">
            <i class="fas fa-shield-halved text-blue-400"></i>
            <span>E-Ticket Resmi</span>
        </span>
    </div>

    <!-- 1. Verification Notice Banner -->
    <div id="ticketHeaderStatusBlock" class="glass-panel rounded-2xl p-3.5 border border-amber-500/30 bg-amber-500/10 flex items-start gap-3">
        <div id="ticketHeaderIcon" class="w-8 h-8 rounded-full bg-amber-500/20 text-amber-400 flex items-center justify-center shrink-0 mt-0.5 text-xs">
            <i class="fas fa-clock"></i>
        </div>
        <div class="flex-1 min-w-0">
            <strong id="ticketHeaderTitle" class="text-xs font-extrabold text-amber-300 block">Proses Verifikasi Pembayaran</strong>
            <p id="ticketHeaderSub" class="text-[10px] text-amber-200/80 leading-relaxed mt-0.5">Admin sedang memverifikasi pembayaran Anda. Begitu diverifikasi, status otomatis aktif (PAID).</p>
        </div>
    </div>

    <!-- 2. Luxury Executive Boarding Pass Card (Dark Glassmorphism) -->
    <div class="glass-card rounded-3xl border border-white/15 overflow-hidden shadow-2xl relative" id="printableTicketArea">

        <!-- Header Stripe -->
        <div class="p-4 border-b border-white/10 flex items-center justify-between bg-white/[0.02]">
            <div class="flex items-center gap-2.5">
                <img src="{{ asset('images/travel/rivian_logo.jpg') }}" alt="Rivian Travel" class="w-9 h-9 rounded-xl object-cover border border-white/15 shrink-0">
                <div>
                    <div class="text-xs font-black text-white tracking-wider">RIVIAN TRAVEL</div>
                    <div class="text-[10px] text-slate-400">Shuttle Eksekutif Ciamis - Bandung</div>
                </div>
            </div>
            <span id="ticketStatusBadge" class="px-2.5 py-1 rounded-full text-[9px] font-black uppercase tracking-wider bg-amber-500/20 text-amber-300 border border-amber-500/30 flex items-center gap-1">
                <i class="fas fa-clock"></i> <span>VERIFIKASI PEMBAYARAN</span>
            </span>
        </div>

        <!-- Route & Schedule (Flight Path Style) -->
        <div class="p-4 flex items-center justify-between">
            <div class="flex-1">
                <div class="text-[9px] font-bold text-slate-400 uppercase tracking-wider">Keberangkatan</div>
                <div class="text-sm font-black text-white font-mono mt-0.5" id="ticketDepTime">06:00 WIB</div>
                <div class="text-[11px] font-bold text-blue-300 mt-0.5" id="ticketOrigin">Pool Ciamis Pusat</div>
            </div>

            <div class="px-3 flex flex-col items-center">
                <span class="text-[8px] font-bold text-blue-300 bg-blue-500/20 border border-blue-500/30 px-2 py-0.5 rounded-full mb-1">Via Tol</span>
                <div class="flex items-center gap-1 w-16 relative">
                    <div class="h-0.5 bg-blue-500/40 w-full"></div>
                    <i class="fas fa-van-shuttle text-blue-400 text-xs"></i>
                </div>
            </div>

            <div class="flex-1 text-right">
                <div class="text-[9px] font-bold text-slate-400 uppercase tracking-wider">Tiba (Estimasi)</div>
                <div class="text-sm font-black text-white font-mono mt-0.5" id="ticketArrTime">Est. 3.5 jam</div>
                <div class="text-[11px] font-bold text-blue-300 mt-0.5" id="ticketDestination">Pool Pasteur</div>
            </div>
        </div>

        <!-- Details Grid -->
        <div class="grid grid-cols-2 gap-3 px-4 pb-4">
            <div class="glass-panel rounded-xl p-2.5 border-white/5">
                <div class="text-[9px] font-bold text-slate-400 uppercase tracking-wider">Kode Booking</div>
                <div class="text-xs font-black text-blue-400 font-mono mt-0.5" id="ticketBookingCode">RVN-882910</div>
            </div>
            <div class="glass-panel rounded-xl p-2.5 border-white/5">
                <div class="text-[9px] font-bold text-slate-400 uppercase tracking-wider">Nama Pemesan</div>
                <div class="text-xs font-bold text-white truncate mt-0.5" id="ticketPassengerName">Budi Santoso</div>
            </div>
            <div class="glass-panel rounded-xl p-2.5 border-white/5">
                <div class="text-[9px] font-bold text-slate-400 uppercase tracking-wider">Tanggal Keberangkatan</div>
                <div class="text-xs font-bold text-white mt-0.5" id="ticketTravelDate">Hari Ini</div>
            </div>
            <div class="glass-panel rounded-xl p-2.5 border-white/5">
                <div class="text-[9px] font-bold text-slate-400 uppercase tracking-wider">Jumlah Kursi</div>
                <div class="text-xs font-bold text-white mt-0.5" id="ticketSeatsList">4 Kursi</div>
            </div>
        </div>

        <!-- Perforation Divider Line with Half-Circle Cutouts -->
        <div class="relative py-2 flex items-center">
            <div class="w-4 h-4 rounded-full bg-[#0B1120] -ml-2 border-r border-white/15"></div>
            <div class="flex-1 border-t border-dashed border-white/20 mx-2"></div>
            <div class="w-4 h-4 rounded-full bg-[#0B1120] -mr-2 border-l border-white/15"></div>
        </div>

        <!-- Bottom Section: Total & QR Code Scanner -->
        <div class="p-4 flex items-center justify-between bg-white/[0.02]">
            <div>
                <div class="text-[9px] font-bold text-slate-400 uppercase tracking-wider">Total Pembayaran (All In)</div>
                <div class="text-lg font-black text-white font-mono mt-0.5" id="ticketTotalPrice">Rp 760.000</div>
            </div>
            <div class="flex flex-col items-center">
                <div class="bg-white p-1 rounded-xl shadow-md border border-white/20">
                    <img id="ticketQrImage" src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=RVN-882910" alt="QR Code" class="w-16 h-16 object-contain">
                </div>
                <span class="text-[8px] text-slate-400 font-bold uppercase mt-1">Scan saat jemput</span>
            </div>
        </div>

    </div>

    <!-- 3. Action Buttons -->
    <div class="space-y-2 pt-1">
        <button type="button" onclick="checkCurrentTicketStatus()" id="btnRefreshTicketStatus" class="w-full h-11 rounded-xl glass-panel border border-white/15 hover:border-blue-500/50 text-white text-xs font-extrabold flex items-center justify-center gap-2 transition active:scale-[0.99] cursor-pointer">
            <i class="fas fa-arrows-rotate text-blue-400"></i>
            <span id="btnRefreshTicketStatusText">Cek / Perbarui Status Verifikasi</span>
        </button>

        <button type="button" onclick="shareTicketToWhatsApp()" class="w-full h-11 rounded-xl bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-500 hover:to-indigo-500 text-white text-xs font-extrabold shadow-lg shadow-blue-500/25 flex items-center justify-center gap-2 transition active:scale-[0.99] cursor-pointer">
            <i class="fab fa-whatsapp text-sm"></i>
            <span>Simpan Tiket ke WhatsApp</span>
        </button>
    </div>

</section>
