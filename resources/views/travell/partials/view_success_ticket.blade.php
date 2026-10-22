<!-- ================= VIEW 6: SUCCESS & E-TICKET DETAIL ================= -->
<section id="viewSuccessTicket" class="ticket-section-container" style="display: none;">

    <!-- Top Action Bar with Safe Area -->
    <div class="ticket-top-nav">
        <button type="button" onclick="switchView('viewHome')" class="history-back-btn">
            <i class="fas fa-chevron-left"></i>
            <span>Beranda</span>
        </button>
        <span class="executive-route-badge">
            <i class="fas fa-shield-halved"></i> E-Ticket Resmi
        </span>
    </div>

    <!-- 1. Verification Notice Banner -->
    <div id="ticketHeaderStatusBlock" class="ticket-verify-banner">
        <div id="ticketHeaderIcon" class="ticket-verify-icon">
            <i class="fas fa-clock"></i>
        </div>
        <div class="ticket-verify-text">
            <strong id="ticketHeaderTitle">Proses Verifikasi Pembayaran</strong>
            <p id="ticketHeaderSub">Admin sedang memverifikasi pembayaran Anda. Begitu diverifikasi, status otomatis aktif (PAID).</p>
        </div>
    </div>

    <!-- 2. Luxury Executive Boarding Pass Card -->
    <div class="executive-ticket-card" id="printableTicketArea">
        
        <!-- Header Stripe -->
        <div class="ticket-card-header">
            <div class="ticket-brand-row">
                <img src="{{ asset('images/travel/rivian_logo.jpg') }}" alt="Rivian Travel" class="ticket-brand-logo">
                <div>
                    <div class="ticket-brand-title">RIVIAN TRAVEL</div>
                    <div class="ticket-brand-sub">Shuttle Eksekutif Ciamis - Bandung</div>
                </div>
            </div>
            <span id="ticketStatusBadge" class="status-badge pending">
                <i class="fas fa-clock"></i> VERIFIKASI PEMBAYARAN
            </span>
        </div>

        <!-- Route & Schedule (Flight Path Style) -->
        <div class="ticket-flight-path">
            <div class="ticket-station">
                <div class="ticket-station-label">Keberangkatan</div>
                <div class="ticket-station-time" id="ticketDepTime">06:00 WIB</div>
                <div class="ticket-station-city" id="ticketOrigin">Pool Ciamis Pusat</div>
            </div>

            <div class="ticket-path-middle">
                <span class="ticket-path-badge">Via Tol</span>
                <div class="ticket-path-line"></div>
                <i class="fas fa-van-shuttle" style="color: var(--primary); font-size: 13px;"></i>
            </div>

            <div class="ticket-station right">
                <div class="ticket-station-label">Tiba (Estimasi)</div>
                <div class="ticket-station-time" id="ticketArrTime">Est. 3.5 jam</div>
                <div class="ticket-station-city" id="ticketDestination">Pool Pasteur</div>
            </div>
        </div>

        <!-- Details Grid -->
        <div class="ticket-details-grid">
            <div class="ticket-detail-item">
                <div class="label">Kode Booking</div>
                <div class="value code" id="ticketBookingCode">RVN-882910</div>
            </div>
            <div class="ticket-detail-item">
                <div class="label">Nama Pemesan</div>
                <div class="value" id="ticketPassengerName">Budi Santoso</div>
            </div>
            <div class="ticket-detail-item">
                <div class="label">Tanggal Keberangkatan</div>
                <div class="value" id="ticketTravelDate">Hari Ini</div>
            </div>
            <div class="ticket-detail-item">
                <div class="label">Jumlah Kursi</div>
                <div class="value" id="ticketSeatsList">4 Kursi</div>
            </div>
        </div>

        <!-- Perforation Divider Line with Half-Circle Cutouts -->
        <div class="ticket-perforation-divider">
            <div class="ticket-notch left"></div>
            <div class="ticket-perforation-line"></div>
            <div class="ticket-notch right"></div>
        </div>

        <!-- Bottom Section: Total & QR Code Scanner -->
        <div class="ticket-tear-section">
            <div class="ticket-price-box">
                <div class="label">Total Pembayaran (All In)</div>
                <div class="total" id="ticketTotalPrice">Rp 760.000</div>
            </div>
            <div class="ticket-qr-block">
                <img id="ticketQrImage" src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=RVN-882910" alt="QR Code">
                <span>Scan saat jemput</span>
            </div>
        </div>

    </div>

    <!-- 3. Action Buttons -->
    <div class="ticket-actions-group">
        <button type="button" onclick="checkCurrentTicketStatus()" id="btnRefreshTicketStatus" class="btn-ticket-action status">
            <i class="fas fa-arrows-rotate"></i>
            <span id="btnRefreshTicketStatusText">Cek / Perbarui Status Verifikasi</span>
        </button>

        <button type="button" onclick="shareTicketToWhatsApp()" class="btn-ticket-action whatsapp">
            <i class="fab fa-whatsapp"></i>
            <span>Simpan Tiket ke WhatsApp</span>
        </button>
    </div>

</section>

