<!-- ================= VIEW 5: QRIS PAYMENT SCREEN (SCALIFY PAY DYNAMIC QRIS) ================= -->
<section id="viewPayment" class="flex-1 hidden flex-col bg-slate-50">
    <!-- Top Nav Bar (Sky Blue) -->
    <div class="bg-gradient-to-r from-sky-600 to-sky-500 text-white px-4 py-2.5 sticky top-0 z-30 flex items-center gap-2.5 shadow-sm">
        <button type="button" onclick="switchView('viewPassengerForm')" class="w-7 h-7 rounded-full bg-white/20 backdrop-blur-md flex items-center justify-center text-white text-xs shrink-0 active:scale-95 cursor-pointer">
            <i class="fas fa-arrow-left"></i>
        </button>
        <div class="flex-1 min-w-0">
            <h3 class="text-xs font-extrabold text-white">Pembayaran QRIS Otomatis</h3>
            <p class="text-[10px] text-sky-100 truncate">Scan dengan Semua Aplikasi M-Banking & E-Wallet</p>
        </div>
    </div>

    <div class="p-3.5 flex-1 flex flex-col items-center justify-center text-center">

        <!-- QRIS Card Box -->
        <div class="bg-white text-slate-900 rounded-3xl p-4 max-w-xs w-full shadow-lg border border-slate-200/80">
            <div class="flex items-center justify-between pb-2.5 mb-2.5 border-b border-slate-100">
                <span class="text-[11px] font-extrabold tracking-wider text-slate-900">QRIS GPN</span>
                <span class="text-[9px] font-bold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded whitespace-nowrap">VERIFIKASI OTOMATIS</span>
            </div>

            <!-- Merchant Name -->
            <p class="text-[9px] text-slate-400 uppercase font-bold" id="qrisMerchantNmid">NMID: ID1021058777975</p>
            <h4 class="text-xs font-black text-slate-900 mt-0.5 truncate" id="qrisMerchantName">SCALIFY / ANSHOP CIAMIS</h4>

            <!-- Total Payment Amount with Unique Code -->
            <div class="bg-sky-50 rounded-xl p-2.5 my-2.5 border border-sky-100">
                <p class="text-[9px] text-slate-500 font-bold uppercase">Total Tagihan (Termasuk Kode Unik)</p>
                <p class="text-lg font-black text-sky-600" id="qrisTotalAmount">Rp 760.191</p>
                <p class="text-[9px] text-slate-500 mt-0.5 truncate" id="qrisDetailText">Kode Booking: <strong id="paymentBookingCode">TRV-20261020-0001</strong></p>
            </div>

            <!-- Real QR Code Image Container -->
            <div class="relative w-52 h-52 mx-auto p-2 bg-white rounded-2xl border-2 border-slate-900 flex items-center justify-center shadow-inner overflow-hidden">
                <img id="qrisQrImage" src="https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=00020101021226570011ID.DANA.WWW" alt="QRIS Dinamis" class="w-full h-full object-contain">
                <div id="qrisLoadingSpinner" class="hidden absolute inset-0 bg-white/90 flex flex-col items-center justify-center text-xs font-bold text-sky-600 gap-2">
                    <i class="fas fa-circle-notch fa-spin text-2xl text-sky-500"></i>
                    <span>Membuat QRIS...</span>
                </div>
            </div>

            <!-- Timer Simulation -->
            <div class="flex items-center justify-center gap-1.5 mt-2.5 text-[10px] text-slate-500 font-bold">
                <i class="far fa-clock text-amber-500"></i>
                <span>Batas Bayar: <strong id="qrisCountdown" class="text-slate-900">29:59</strong></span>
            </div>

            <!-- Supported Apps -->
            <p class="text-[8px] text-slate-400 mt-1.5">BCA, Mandiri, BRI, BNI, GoPay, OVO, Dana, ShopeePay</p>
        </div>

        <!-- Action Buttons -->
        <div class="mt-3.5 w-full max-w-xs space-y-2">
            <button type="button" onclick="simulateQrisPayment()" class="w-full py-3 rounded-xl bg-emerald-500 hover:bg-emerald-600 active:scale-95 text-white font-extrabold text-xs shadow-md shadow-emerald-500/20 transition flex items-center justify-center gap-2 whitespace-nowrap cursor-pointer">
                <i class="fas fa-check-circle"></i>
                <span>Simulasi Pembayaran Berhasil</span>
            </button>

            <button type="button" onclick="shareTicketWhatsApp()" class="w-full py-2.5 rounded-xl bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs transition flex items-center justify-center gap-2 whitespace-nowrap cursor-pointer">
                <i class="fab fa-whatsapp text-emerald-400"></i>
                <span>Bantuan / Konfirmasi WhatsApp CS</span>
            </button>
        </div>
    </div>
</section>
