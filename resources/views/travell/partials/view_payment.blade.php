<!-- ================= VIEW 5: QRIS PAYMENT MODAL POPUP ================= -->
<div id="qrisModalBackdrop" class="qris-modal-backdrop">
    <div class="qris-modal-card">
        <div class="qris-modal-header">
            <span class="qris-badge-gpn">
                <i class="fas fa-qrcode"></i> QRIS GPN OTOMATIS
            </span>
            <button type="button" onclick="closeQrisModal()" class="qris-close-btn">&times;</button>
        </div>

        <p style="font-size: 10px; color: #94a3b8; text-transform: uppercase; font-weight: 700;" id="qrisMerchantNmid">NMID: ID1021058777975</p>
        <h4 style="font-size: 13px; font-weight: 800; color: #0f172a; margin-top: 2px;" id="qrisMerchantName">RIVIAN TRAVEL / ANSHOP CIAMIS</h4>

        <!-- Total Tagihan -->
        <div class="qris-total-box">
            <p style="font-size: 10px; color: #64748b; font-weight: 700; text-transform: uppercase;">Total Pembayaran</p>
            <div class="amount" id="qrisTotalAmount">Rp 760.000</div>
            <p style="font-size: 10px; color: #64748b; margin-top: 2px;">Kode Booking: <strong id="paymentBookingCode" style="color: #0f172a;">RVN-882910</strong></p>
        </div>

        <!-- Real QR Code Image Container -->
        <div class="qris-qr-box">
            <img id="qrisQrImage" src="https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=00020101021226570011ID.DANA.WWW" alt="QRIS Dinamis">
        </div>

        <!-- Timer -->
        <div style="font-size: 11px; color: #64748b; font-weight: 700; margin-bottom: 14px;">
            <i class="far fa-clock" style="color: var(--primary);"></i> Selesaikan: <strong id="qrisCountdown" class="tabular-nums" style="color: #0f172a;">29:59</strong>
        </div>

        <p style="font-size: 10px; color: #94a3b8; margin-bottom: 12px;">
            Mendukung BCA, Mandiri, BRI, BNI, GoPay, OVO, DANA & ShopeePay
        </p>

        <!-- Button: Saya Sudah Bayar (Konfirmasi) -->
        <button type="button" id="btnConfirmPaid" onclick="confirmPaymentSuccess()" class="btn-confirm-paid">
            <i class="fas fa-check-circle"></i>
            <span id="btnConfirmPaidText">Saya Sudah Bayar (Konfirmasi)</span>
        </button>
    </div>
</div>
