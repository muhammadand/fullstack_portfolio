<!-- Multi-Step Web Booking, QRIS Payment & Transaction History Modal -->
<div id="bookingModal" class="fixed inset-0 z-50 bg-slate-950/80 backdrop-blur-sm hidden items-center justify-center p-4 overflow-y-auto">
    <div class="bg-slate-900 border border-slate-800 rounded-2xl max-w-md w-full p-5 text-white shadow-2xl relative my-6" onclick="event.stopPropagation()">

        <!-- Modal Close Button -->
        <button type="button" onclick="closeBookingModal()" class="w-7 h-7 rounded-lg bg-slate-800 hover:bg-slate-700 text-slate-400 hover:text-white flex items-center justify-center text-xs absolute top-4 right-4 transition cursor-pointer z-10">
            <i class="fas fa-times"></i>
        </button>

        <!-- ================= STEP 1: FORM PEMILIHAN JADWAL & DATA PEMESAN ================= -->
        <div id="modalStepForm">
            <!-- Modal Header -->
            <div class="pb-3 mb-3.5 border-b border-slate-800">
                <span class="text-emerald-400 text-[10px] font-semibold uppercase tracking-wider block" id="modalSportTag">FUTSAL</span>
                <h3 class="text-base font-bold text-white" id="modalCourtTitle">Lapangan 1 (Vinyl Pro)</h3>
                <p class="text-xs text-slate-400" id="modalCourtType">Vinyl Import 8mm • Standar BWF / FIFA</p>
            </div>

            <form id="landingBookingForm" onsubmit="proceedModalToPayment(event)" class="space-y-3 text-xs">
                <!-- 1. Tanggal Booking -->
                <div>
                    <label class="block text-[10px] font-semibold text-slate-400 mb-1">Tanggal Main</label>
                    <input type="date" id="modalBookingDate" value="{{ date('Y-m-d') }}" min="{{ date('Y-m-d') }}" class="w-full bg-slate-950 border border-slate-800 rounded-lg px-2.5 py-1.5 text-xs font-semibold text-white focus:outline-none focus:border-emerald-500 cursor-pointer" onchange="updateModalSlots()">
                </div>

                <!-- 2. Pilih Slot Jam -->
                <div>
                    <div class="flex items-center justify-between mb-1">
                        <label class="block text-[10px] font-semibold text-slate-400">
                            Pilih Slot Jam (Bisa pilih &gt; 1 jam)
                        </label>
                        <span class="text-[9px] text-emerald-400 font-medium" id="modalSelectedSlotCount">0 slot dipilih</span>
                    </div>
                    <div id="modalSlotsContainer" class="grid grid-cols-3 gap-1.5 max-h-36 overflow-y-auto no-scrollbar p-0.5">
                        <!-- Populated dynamically via JS -->
                    </div>
                </div>

                <!-- 3. Add-ons Pilihan -->
                <div>
                    <label class="block text-[10px] font-semibold text-slate-400 mb-1">Add-on Peralatan (Opsional)</label>
                    <div class="space-y-1">
                        <label class="flex items-center justify-between p-1.5 rounded-lg bg-slate-950 border border-slate-800 text-[11px] cursor-pointer">
                            <span class="flex items-center gap-1.5">
                                <input type="checkbox" id="addonWasit" onchange="calculateModalTotal()" class="text-emerald-500 rounded">
                                <span>Wasit Berlisensi (+Rp 50.000/jam)</span>
                            </span>
                        </label>
                        <label class="flex items-center justify-between p-1.5 rounded-lg bg-slate-950 border border-slate-800 text-[11px] cursor-pointer">
                            <span class="flex items-center gap-1.5">
                                <input type="checkbox" id="addonRompi" onchange="calculateModalTotal()" class="text-emerald-500 rounded">
                                <span>1 Set Rompi Tim (+Rp 25.000)</span>
                            </span>
                        </label>
                        <label class="flex items-center justify-between p-1.5 rounded-lg bg-slate-950 border border-slate-800 text-[11px] cursor-pointer">
                            <span class="flex items-center gap-1.5">
                                <input type="checkbox" id="addonAir" onchange="calculateModalTotal()" class="text-emerald-500 rounded">
                                <span>1 Dus Air Mineral 330ml (+Rp 35.000)</span>
                            </span>
                        </label>
                    </div>
                </div>

                <!-- 4. Data Pemesan -->
                <div class="space-y-2 pt-1 border-t border-slate-800">
                    <div class="grid grid-cols-2 gap-2">
                        <div>
                            <label class="block text-[10px] font-semibold text-slate-400 mb-0.5">Nama Pemesan</label>
                            <input type="text" id="modalCustomerName" required placeholder="Contoh: Andi Pratama" value="Andi Pratama" class="w-full bg-slate-950 border border-slate-800 rounded-lg px-2 py-1.5 text-xs text-white focus:outline-none focus:border-emerald-500">
                        </div>
                        <div>
                            <label class="block text-[10px] font-semibold text-slate-400 mb-0.5">Nama Tim / Klub</label>
                            <input type="text" id="modalCustomerTeam" placeholder="Contoh: FC Garuda" value="Garuda Futsal Squad" class="w-full bg-slate-950 border border-slate-800 rounded-lg px-2 py-1.5 text-xs text-white focus:outline-none focus:border-emerald-500">
                        </div>
                    </div>
                    <div>
                        <label class="block text-[10px] font-semibold text-slate-400 mb-0.5">Nomor WhatsApp</label>
                        <input type="tel" id="modalCustomerPhone" required placeholder="0812xxxx" value="081234567890" class="w-full bg-slate-950 border border-slate-800 rounded-lg px-2 py-1.5 text-xs text-white focus:outline-none focus:border-emerald-500">
                    </div>
                </div>

                <!-- Total Price & Action -->
                <div class="bg-slate-950 border border-slate-800 rounded-xl p-2.5 flex items-center justify-between mt-2">
                    <div>
                        <span class="text-[9px] text-slate-400 block uppercase font-medium">Total Tagihan</span>
                        <span class="text-sm font-bold text-emerald-400" id="modalTotalPriceDisplay">Rp 0</span>
                    </div>
                    <button type="submit" id="btnSubmitModalBooking" disabled class="px-4 py-2 rounded-lg bg-slate-800 text-slate-500 font-bold text-xs transition cursor-not-allowed flex items-center gap-1.5 shadow-sm">
                        <span>Lanjut ke Bayar QRIS</span>
                        <i class="fas fa-arrow-right text-[10px]"></i>
                    </button>
                </div>
            </form>
        </div>


        <!-- ================= STEP 2: SIMULASI PEMBAYARAN QRIS ================= -->
        <div id="modalStepPayment" class="hidden text-center">
            <div class="pb-2.5 mb-3 border-b border-slate-800 text-left">
                <span class="text-emerald-400 text-[10px] font-semibold uppercase tracking-wider block">Pembayaran Digital</span>
                <h3 class="text-sm font-bold text-white">Scan QRIS Instant</h3>
            </div>

            <!-- QRIS Card Box -->
            <div class="bg-white text-slate-950 rounded-2xl p-3.5 max-w-xs mx-auto shadow-lg border border-slate-200 text-center">
                <div class="flex items-center justify-between pb-1.5 mb-1.5 border-b border-slate-100">
                    <span class="text-[10px] font-black tracking-wider text-slate-900">QRIS GPN</span>
                    <span class="text-[8px] font-bold text-emerald-700 bg-emerald-50 px-1.5 py-0.2 rounded">VERIFIKASI OTOMATIS</span>
                </div>

                <p class="text-[8px] text-slate-400 uppercase font-bold">NMID: ID102988392110</p>
                <h4 class="text-xs font-black text-slate-900 mt-0.5 truncate">{{ strtoupper($brandName) }} SPORT</h4>

                <!-- Tagihan Box -->
                <div class="bg-emerald-50 rounded-lg p-2 my-2 border border-emerald-100">
                    <p class="text-[8px] text-slate-500 font-bold uppercase">Total Tagihan Booking</p>
                    <p class="text-sm font-black text-emerald-700" id="modalQRISTotalAmount">Rp 120.000</p>
                    <p class="text-[8px] text-slate-600 mt-0.5 truncate" id="modalQRISSubtitle">Lapangan 1 • 1 Jam</p>
                </div>

                <!-- Realistic QR SVG -->
                <div class="relative w-36 h-36 mx-auto p-1.5 bg-white rounded-xl border border-slate-900 flex items-center justify-center">
                    <svg class="w-full h-full" viewBox="0 0 100 100" fill="currentColor">
                        <rect x="5" y="5" width="25" height="25" fill="#0f172a" rx="2"></rect>
                        <rect x="10" y="10" width="15" height="15" fill="#ffffff" rx="1"></rect>
                        <rect x="13" y="13" width="9" height="9" fill="#0f172a" rx="1"></rect>

                        <rect x="70" y="5" width="25" height="25" fill="#0f172a" rx="2"></rect>
                        <rect x="75" y="10" width="15" height="15" fill="#ffffff" rx="1"></rect>
                        <rect x="78" y="13" width="9" height="9" fill="#0f172a" rx="1"></rect>

                        <rect x="5" y="70" width="25" height="25" fill="#0f172a" rx="2"></rect>
                        <rect x="10" y="75" width="15" height="15" fill="#ffffff" rx="1"></rect>
                        <rect x="13" y="78" width="9" height="9" fill="#0f172a" rx="1"></rect>

                        <rect x="36" y="8" width="8" height="8" fill="#0f172a"></rect>
                        <rect x="50" y="12" width="6" height="6" fill="#0f172a"></rect>
                        <rect x="36" y="24" width="6" height="6" fill="#0f172a"></rect>
                        <rect x="46" y="32" width="10" height="10" fill="#0f172a"></rect>
                        <rect x="12" y="38" width="8" height="8" fill="#0f172a"></rect>
                        <rect x="26" y="44" width="8" height="8" fill="#0f172a"></rect>
                        <rect x="68" y="38" width="6" height="6" fill="#0f172a"></rect>
                        <rect x="80" y="44" width="8" height="8" fill="#0f172a"></rect>
                        <rect x="38" y="52" width="8" height="8" fill="#0f172a"></rect>
                        <rect x="54" y="52" width="6" height="6" fill="#0f172a"></rect>
                        <rect x="72" y="58" width="8" height="8" fill="#0f172a"></rect>
                        <rect x="38" y="72" width="8" height="8" fill="#0f172a"></rect>
                        <rect x="54" y="76" width="10" height="10" fill="#0f172a"></rect>
                        <rect x="74" y="74" width="8" height="8" fill="#0f172a"></rect>

                        <circle cx="50" cy="50" r="9" fill="#10b981"></circle>
                        <path d="M46 50 L49 53 L54 47" stroke="#ffffff" stroke-width="2" fill="none"></path>
                    </svg>
                </div>

                <p class="text-[8px] text-slate-400 mt-2">BCA, Mandiri, BRI, BNI, GoPay, OVO, Dana, ShopeePay</p>
            </div>

            <!-- Instant Action Simulation Buttons -->
            <div class="space-y-2 mt-3.5 max-w-xs mx-auto">
                <button type="button" onclick="simulateModalPaymentSuccess()" class="w-full py-2.5 rounded-xl bg-emerald-500 hover:bg-emerald-400 text-slate-950 font-bold text-xs shadow-md transition active:scale-95 flex items-center justify-center gap-1.5 cursor-pointer">
                    <i class="fas fa-bolt"></i>
                    <span>Simulasi Bayar Berhasil (Instant)</span>
                </button>
                <button type="button" onclick="returnModalToForm()" class="w-full py-1.5 text-[11px] text-slate-400 hover:text-white font-medium">
                    ← Kembali Ubah Jadwal
                </button>
            </div>
        </div>


        <!-- ================= STEP 3: E-TICKET TERBIT ================= -->
        <div id="modalStepTicket" class="hidden">
            <div class="pb-2.5 mb-3 border-b border-slate-800 flex items-center justify-between">
                <div>
                    <span class="text-emerald-400 text-[10px] font-semibold uppercase tracking-wider block">Pembayaran Berhasil</span>
                    <h3 class="text-sm font-bold text-white">E-Ticket Booking Resmi</h3>
                </div>
                <span class="text-[9px] font-bold text-emerald-300 bg-emerald-500/10 px-2 py-0.5 rounded">LUNAS</span>
            </div>

            <!-- Printable Ticket Card -->
            <div class="bg-white text-slate-950 rounded-2xl p-4 border border-slate-200 shadow-lg text-xs space-y-2.5">
                <div class="flex items-center justify-between pb-2 border-b border-slate-100">
                    <div>
                        <span class="text-[8px] font-bold uppercase text-slate-400">Kode Booking</span>
                        <h4 class="text-xs font-black text-slate-900 tracking-wider" id="modalTicketCode">SPT-992102</h4>
                    </div>
                    <span class="px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-800 text-[8px] font-extrabold">
                        SIAP MAIN
                    </span>
                </div>

                <div>
                    <span class="text-[9px] font-bold text-emerald-600 uppercase" id="modalTicketSportBadge">FUTSAL ARENA</span>
                    <h3 class="text-sm font-black text-slate-900" id="modalTicketCourtName">Lapangan 1 (Vinyl Pro)</h3>
                </div>

                <div class="grid grid-cols-2 gap-2 bg-slate-50 p-2.5 rounded-xl text-[10px] border border-slate-100">
                    <div>
                        <p class="text-[8px] text-slate-400 uppercase font-semibold">Tanggal</p>
                        <p class="font-bold text-slate-900 truncate" id="modalTicketDate">Hari Ini</p>
                    </div>
                    <div>
                        <p class="text-[8px] text-slate-400 uppercase font-semibold">Slot Jam</p>
                        <p class="font-black text-emerald-700 truncate" id="modalTicketSlots">19:00 - 20:00 WIB</p>
                    </div>
                    <div>
                        <p class="text-[8px] text-slate-400 uppercase font-semibold">Pemesan</p>
                        <p class="font-bold text-slate-900 truncate" id="modalTicketLead">Andi Pratama</p>
                    </div>
                    <div>
                        <p class="text-[8px] text-slate-400 uppercase font-semibold">Tim</p>
                        <p class="font-bold text-slate-800 truncate" id="modalTicketTeam">Garuda FC</p>
                    </div>
                    <div class="col-span-2 pt-1 border-t border-slate-200 flex items-center justify-between">
                        <span class="text-[8px] text-slate-400 uppercase font-semibold">Total Biaya</span>
                        <span class="font-bold text-xs text-emerald-700" id="modalTicketPrice">Rp 120.000</span>
                    </div>
                </div>

                <!-- Barcode -->
                <div class="text-center pt-1.5 border-t border-dashed border-slate-200">
                    <div class="font-mono text-base tracking-widest text-slate-900 font-bold">
                        ||||||| | ||||| ||| ||||||| | ||
                    </div>
                    <p class="text-[8px] text-slate-400">Scan barcode ini di meja resepsionis gelanggang</p>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="space-y-2 mt-3.5">
                <button type="button" onclick="shareModalTicketToWhatsApp()" class="w-full py-2.5 rounded-xl bg-emerald-500 hover:bg-emerald-400 text-slate-950 font-bold text-xs shadow-sm transition flex items-center justify-center gap-1.5 cursor-pointer">
                    <i class="fab fa-whatsapp"></i>
                    <span>Kirim E-Tiket ke WhatsApp Tim</span>
                </button>
                <button type="button" onclick="openHistoryModal()" class="w-full py-2 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-200 font-semibold text-xs transition flex items-center justify-center gap-1.5 cursor-pointer">
                    <i class="fas fa-receipt text-emerald-400"></i>
                    <span>Lihat Semua Riwayat Tiket Saya</span>
                </button>
            </div>
        </div>


        <!-- ================= STEP 4: RIWAYAT TRANSAKSI TIKET ================= -->
        <div id="modalStepHistory" class="hidden">
            <div class="pb-2.5 mb-3 border-b border-slate-800 flex items-center justify-between">
                <div>
                    <span class="text-emerald-400 text-[10px] font-semibold uppercase tracking-wider block">Database Transaksi</span>
                    <h3 class="text-sm font-bold text-white">Riwayat Tiket Booking Saya</h3>
                </div>
                <button type="button" onclick="resetWebSportOrders()" class="text-[9px] text-slate-400 hover:text-white bg-slate-800 px-2 py-0.5 rounded cursor-pointer">
                    Reset Demo
                </button>
            </div>

            <!-- List Container -->
            <div id="modalHistoryList" class="space-y-2 max-h-64 overflow-y-auto no-scrollbar p-0.5">
                <!-- Populated dynamically via JS -->
            </div>

            <div id="modalEmptyHistory" class="hidden text-center py-8 bg-slate-950 rounded-xl border border-dashed border-slate-800 p-4">
                <i class="fas fa-ticket-simple text-2xl text-slate-600 mb-1.5"></i>
                <h5 class="text-xs font-bold text-white">Belum Ada Riwayat Tiket</h5>
                <p class="text-[10px] text-slate-400 mt-0.5">Silakan lakukan simulasi booking lapangan.</p>
            </div>

            <div class="pt-3 mt-3 border-t border-slate-800">
                <button type="button" onclick="closeBookingModal()" class="w-full py-2 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-200 font-semibold text-xs transition cursor-pointer">
                    Tutup Riwayat
                </button>
            </div>
        </div>

    </div>
</div>
