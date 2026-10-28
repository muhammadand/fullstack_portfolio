<!-- ================= VIEW 5: QRIS PAYMENT MODAL POPUP (TAILWIND GLASS) ================= -->
<div id="qrisModalBackdrop" class="qris-modal-backdrop fixed inset-0 bg-black/85 backdrop-blur-md z-50 items-end sm:items-center justify-center p-0 sm:p-4 transition-opacity" style="display: none;">
    <div class="w-full sm:max-w-sm glass-card rounded-t-3xl sm:rounded-3xl border border-white/20 p-5 space-y-3.5 shadow-2xl relative text-center">

        <!-- Header -->
        <div class="flex items-center justify-between pb-2 border-b border-white/10">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-blue-500/20 border border-blue-400/30 text-blue-300 text-[10px] font-extrabold uppercase tracking-wider">
                <i class="fas fa-qrcode"></i> QRIS GPN Otomatis
            </span>
            <button type="button" onclick="closeQrisModal()" class="w-7 h-7 rounded-full glass-panel flex items-center justify-center text-slate-400 hover:text-white text-sm transition cursor-pointer">&times;</button>
        </div>

        <div>
            <p class="text-[9px] text-slate-400 font-bold uppercase tracking-wider" id="qrisMerchantNmid">NMID: ID1021058777975</p>
            <h4 class="text-xs font-extrabold text-white mt-0.5" id="qrisMerchantName">RIVIAN TRAVEL / ANSHOP CIAMIS</h4>
        </div>

        <!-- Total Tagihan -->
        <div class="glass-panel rounded-2xl p-3 border border-white/10">
            <p class="text-[9px] text-slate-400 font-bold uppercase tracking-wider">Total Pembayaran</p>
            <div class="text-2xl font-black text-white tracking-tight mt-0.5" id="qrisTotalAmount">Rp 760.000</div>
            <p class="text-[10px] text-slate-400 mt-1">
                Kode Booking: <strong id="paymentBookingCode" class="text-blue-400 font-mono">RVN-882910</strong>
            </p>
        </div>

        <!-- Real QR Code Image Container (High-contrast pure white card for easy scanning) -->
        <div class="bg-white p-3 rounded-2xl mx-auto w-44 h-44 flex items-center justify-center shadow-lg border-2 border-white/30">
            <img id="qrisQrImage" src="https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=00020101021226570011ID.DANA.WWW" alt="QRIS Dinamis" class="w-full h-full object-contain">
        </div>

        <!-- Timer -->
        <div class="text-[11px] text-slate-300 font-bold flex items-center justify-center gap-1.5">
            <i class="far fa-clock text-blue-400"></i>
            <span>Selesaikan dalam: <strong id="qrisCountdown" class="tabular-nums text-white font-black text-xs">29:59</strong></span>
        </div>

        <p class="text-[9px] text-slate-400 leading-tight">
            Mendukung BCA, Mandiri, BRI, BNI, GoPay, OVO, DANA & ShopeePay
        </p>

        <!-- Button: Saya Sudah Bayar (Konfirmasi) -->
        <button type="button" id="btnConfirmPaid" onclick="confirmPaymentSuccess()" class="w-full h-11 bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-400 hover:to-teal-500 text-white font-extrabold text-xs rounded-xl shadow-lg shadow-emerald-500/25 flex items-center justify-center gap-2 active:scale-[0.99] transition cursor-pointer">
            <i class="fas fa-check-circle"></i>
            <span id="btnConfirmPaidText">Saya Sudah Bayar (Konfirmasi)</span>
        </button>
    </div>
</div>
