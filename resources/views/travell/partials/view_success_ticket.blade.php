<!-- ================= VIEW 6: SUCCESS & E-TICKET DETAIL ================= -->
<section id="viewSuccessTicket" class="flex-1 hidden flex-col bg-slate-50">
    <!-- Top Nav Bar (Sky Blue) -->
    <div class="bg-gradient-to-r from-sky-600 to-sky-500 text-white px-4 py-2.5 flex items-center justify-between shadow-sm">
        <span class="text-xs font-bold flex items-center gap-1.5">
            <i class="fas fa-check-circle text-emerald-300"></i> E-Ticket Resmi
        </span>
        <button type="button" onclick="switchView('viewHome')" class="text-[10px] bg-white/20 hover:bg-white/30 px-2.5 py-1 rounded-full text-white font-bold whitespace-nowrap cursor-pointer">
            Ke Beranda
        </button>
    </div>

    <div class="p-3.5 space-y-3.5 flex-1">
        <!-- Success Header -->
        <div class="text-center py-1">
            <div class="w-10 h-10 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center text-lg mx-auto mb-1.5 shadow-xs animate-bounce">
                <i class="fas fa-check"></i>
            </div>
            <h3 class="text-xs font-extrabold text-slate-900">Pembayaran Berhasil!</h3>
            <p class="text-[10px] text-slate-500 mt-0.5 leading-tight">Tiket shuttle Anda aktif dan tersimpan di sistem.</p>
        </div>

        <!-- Luxury E-Ticket Card -->
        <div class="bg-white rounded-3xl p-4 border border-slate-200/90 shadow-md relative overflow-hidden" id="printableTicketArea">

            <!-- Ticket Header -->
            <div class="flex items-center justify-between pb-2.5 mb-2.5 border-b border-slate-100">
                <div>
                    <span class="text-[8px] font-bold uppercase tracking-wider text-slate-400">Kode Booking</span>
                    <h4 class="text-xs font-black text-slate-900 tracking-wider" id="ticketBookingCode">TRV-882910</h4>
                </div>
                <span class="px-2 py-0.5 rounded-full bg-emerald-50 border border-emerald-200 text-emerald-700 text-[9px] font-extrabold whitespace-nowrap">
                    LUNAS • AKTIF
                </span>
            </div>

            <!-- Route & Schedule -->
            <div class="flex items-center justify-between py-1.5">
                <div class="text-left">
                    <p class="text-[9px] text-slate-400 font-bold uppercase">Keberangkatan</p>
                    <p class="text-sm font-black text-slate-900" id="ticketDepTime">06:00 WIB</p>
                    <p class="text-[11px] font-bold text-slate-700 truncate" id="ticketOrigin">Ciamis</p>
                </div>
                <div class="px-2 text-center shrink-0">
                    <i class="fas fa-car text-sky-500 text-xs"></i>
                    <div class="w-12 h-[1.5px] bg-slate-200 my-1"></div>
                    <span class="text-[8px] text-slate-400 font-medium">Via Tol</span>
                </div>
                <div class="text-right">
                    <p class="text-[9px] text-slate-400 font-bold uppercase">Estimasi Tiba</p>
                    <p class="text-sm font-black text-slate-900" id="ticketArrTime">09:30 WIB</p>
                    <p class="text-[11px] font-bold text-slate-700 truncate" id="ticketDestination">Bandung</p>
                </div>
            </div>

            <!-- Detail Grid -->
            <div class="grid grid-cols-2 gap-2 bg-slate-50 p-2.5 rounded-2xl my-2.5 text-[10px] border border-slate-100">
                <div>
                    <p class="text-[8px] text-slate-400 font-bold uppercase">Penumpang</p>
                    <p class="font-bold text-slate-900 truncate" id="ticketPassengerName">Andi Pratama</p>
                </div>
                <div>
                    <p class="text-[8px] text-slate-400 font-bold uppercase">Nomor Kursi</p>
                    <p class="font-black text-sky-600 truncate" id="ticketSeatsList">K-01</p>
                </div>
                <div>
                    <p class="text-[8px] text-slate-400 font-bold uppercase">Tanggal Berangkat</p>
                    <p class="font-bold text-slate-800 truncate" id="ticketTravelDate">Hari Ini</p>
                </div>
                <div>
                    <p class="text-[8px] text-slate-400 font-bold uppercase">Armada Shuttle</p>
                    <p class="font-bold text-slate-800 truncate" id="ticketFleetName">Daihatsu All New Xenia</p>
                </div>
                <div class="col-span-2 pt-1 border-t border-slate-200/60 flex items-center justify-between">
                    <span class="text-[8px] text-slate-400 font-bold uppercase">Total Pembayaran</span>
                    <span class="font-black text-xs text-emerald-700" id="ticketTotalPrice">Rp 190.000</span>
                </div>
            </div>

            <!-- Inclusions Voucher Notice -->
            <div class="bg-sky-50 rounded-xl p-2 text-[9px] text-sky-900 font-medium border border-sky-100 mb-2.5 flex items-center gap-1.5 leading-tight">
                <i class="fas fa-route text-sky-600 text-xs shrink-0"></i>
                <span>Layanan <strong>Door to Door</strong>: Sopir akan menghubungi via WhatsApp sebelum penjemputan.</span>
            </div>

            <!-- Barcode Simulation for Driver Boarding Scan -->
            <div class="text-center pt-1.5 border-t border-dashed border-slate-200">
                <div class="font-mono text-base tracking-widest text-slate-800 font-bold py-0.5">
                    ||||||| | ||||| ||| ||||||| | ||
                </div>
                <p class="text-[8px] text-slate-400">Tunjukkan barcode ini ke driver saat penjemputan</p>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="space-y-2">
            <button type="button" onclick="shareTicketToWhatsApp()" class="w-full py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs shadow-xs transition flex items-center justify-center gap-2 whitespace-nowrap cursor-pointer">
                <i class="fab fa-whatsapp text-sm"></i>
                <span>Kirim Detail Tiket ke WhatsApp</span>
            </button>
            <button type="button" onclick="switchView('viewHistory')" class="w-full py-2.5 rounded-xl bg-sky-500 hover:bg-sky-600 text-white font-bold text-xs transition flex items-center justify-center gap-2 whitespace-nowrap cursor-pointer">
                <i class="fas fa-receipt"></i>
                <span>Buka Riwayat Pesanan Saya</span>
            </button>
        </div>
    </div>
</section>
