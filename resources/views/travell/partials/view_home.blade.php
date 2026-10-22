<!-- ================= VIEW 1: HOME (EXECUTIVE MOBILE SHUTTLE) ================= -->
<section id="viewHome">

    <!-- 1. Executive Top Header -->
    <div class="simple-top-header">
        <div class="brand-left">
            <div class="brand-logo-pill">
                <img src="{{ asset('images/travel/rivian_logo.jpg') }}" alt="Rivian Travel" class="brand-logo-img">
            </div>
            <div>
                <h1 class="brand-title">Rivian Travel</h1>
                <p class="brand-subtitle">Shuttle Eksekutif Ciamis - Bandung PP</p>
            </div>
        </div>
        <div class="brand-right">
            <span class="executive-route-badge"><i class="fas fa-route"></i> Via Tol Purbaleunyi</span>
        </div>
    </div>
    <!-- 3. Direct Booking Card (Focused, Simple & Elegant) -->
    <div class="booking-card" style="margin-top: 14px;">
        <div class="card-section-title">
            <span>Form Pemesanan Shuttle</span>
            <span class="badge"><i class="fas fa-circle-check"></i> Pasti Berangkat</span>
        </div>

        <form id="directBookingForm" onsubmit="handleDirectBookingSubmit(event)">

            <!-- Akun Pelanggan (Jika sudah login, sembunyikan nama & hp) -->
            <div id="customerLoggedInCard" class="auth-status-box" style="display: none;">
                <div class="auth-logged-in-row">
                    <div class="auth-user-info">
                        <div class="auth-avatar">
                            <i class="fas fa-user-check"></i>
                        </div>
                        <div class="auth-meta">
                            <div class="name" id="loggedInUserName">Pelanggan</div>
                            <div class="sub" id="loggedInUserPhone">0812xxxx • 0 Poin</div>
                        </div>
                    </div>
                    <button type="button" onclick="switchCustomerAccount()" class="auth-switch-btn">Ganti Akun</button>
                </div>
            </div>

            <!-- Jika BELUM login, input nama & no hp ditampilkan -->
            <div id="customerGuestFields">
                <div class="form-group">
                    <label class="form-label">Nama Lengkap Pemesan *</label>
                    <div class="input-field-wrapper">
                        <i class="far fa-user input-icon"></i>
                        <input type="text" id="bookingCustName" required placeholder="Contoh: Budi Santoso" class="form-input">
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Nomor WhatsApp Aktif *</label>
                    <div class="input-field-wrapper">
                        <i class="fab fa-whatsapp input-icon" style="color: var(--primary);"></i>
                        <input type="tel" id="bookingCustPhone" required placeholder="081234567890" class="form-input">
                    </div>
                </div>
            </div>

            <!-- Alamat Penjemputan (Asal) -->
            <div class="form-group">
                <div class="label-row">
                    <label class="form-label">Titik Jemput (Asal) *</label>
                    <button type="button" id="btnDetectCurrentLocation" onclick="detectCurrentLocation('bookingCustPickup')" class="btn-gps-detect">
                        <i class="fas fa-crosshairs" id="detectLocationIcon"></i>
                        <span id="detectLocationText">Lokasi Saya</span>
                    </button>
                </div>

                <!-- Quick Pool Chips -->
                <div class="quick-pool-chips">
                    <span class="pool-chip" onclick="applyQuickPickup('Pool Ciamis (Kantor Pusat) - Jl. Jenderal Sudirman No. 88, Ciamis (Depan Alun-Alun)')"><i class="fas fa-building"></i> Pool Ciamis</span>
                    <span class="pool-chip" onclick="applyQuickPickup('Pool Pasteur Bandung - Jl. Dr. Djunjunan No. 135 (Dekat Gerbang Tol Pasteur)')"><i class="fas fa-building"></i> Pool Pasteur</span>
                    <span class="pool-chip" onclick="applyQuickPickup('custom_ciamis')"><i class="fas fa-house"></i> Jemput Rumah Ciamis</span>
                    <span class="pool-chip" onclick="applyQuickPickup('custom_bandung')"><i class="fas fa-house"></i> Jemput Rumah Bandung</span>
                </div>

                <textarea id="bookingCustPickup" required rows="2" placeholder="Tulis alamat penjemputan lengkap, nomor rumah, atau patokan..." class="form-textarea"></textarea>

                <div id="gpsStatusBadge" style="display: none; margin-top: 6px; padding: 4px 8px; border-radius: 8px; background-color: var(--primary-light); border: 1px solid var(--border-primary); font-size: 10px; font-weight: 700; color: var(--primary); justify-content: space-between; align-items: center;">
                    <span><i class="fas fa-satellite"></i> <span id="gpsStatusText">Lokasi GPS Terdeteksi</span></span>
                    <span id="gpsAccuracyText" class="tabular-nums"></span>
                </div>
            </div>

            <!-- Alamat Pengantaran (Tujuan) -->
            <div class="form-group">
                <label class="form-label">Titik Pengantaran (Tujuan) *</label>

                <!-- Quick Pool Chips -->
                <div class="quick-pool-chips">
                    <span class="pool-chip" onclick="applyQuickDropoff('Pool Pasteur Bandung - Jl. Dr. Djunjunan No. 135 (Dekat Gerbang Tol Pasteur)')"><i class="fas fa-building"></i> Pool Pasteur</span>
                    <span class="pool-chip" onclick="applyQuickDropoff('Pool Dipatiukur Bandung - Jl. Dipatiukur No. 45, Coblong (Dekat Kampus UNPAD)')"><i class="fas fa-building"></i> Pool Dipatiukur</span>
                    <span class="pool-chip" onclick="applyQuickDropoff('Pool Ciamis (Kantor Pusat) - Jl. Jenderal Sudirman No. 88, Ciamis (Depan Alun-Alun)')"><i class="fas fa-building"></i> Pool Ciamis</span>
                    <span class="pool-chip" onclick="applyQuickDropoff('custom_bandung')"><i class="fas fa-house"></i> Antar Alamat Bandung</span>
                    <span class="pool-chip" onclick="applyQuickDropoff('custom_ciamis')"><i class="fas fa-house"></i> Antar Alamat Ciamis</span>
                </div>

                <textarea id="bookingCustDropoff" required rows="2" placeholder="Tulis alamat tujuan pengantaran, hotel, kantor, atau rumah..." class="form-textarea"></textarea>
            </div>

            <!-- Jadwal Keberangkatan -->
            <div class="form-group">
                <div class="label-row">
                    <label class="form-label">Tanggal Keberangkatan</label>
                    <input type="date" id="bookingDate" min="{{ date('Y-m-d') }}" value="{{ date('Y-m-d') }}" style="font-size: 11px; font-weight: 700; border: 1px solid var(--border-color); border-radius: 8px; padding: 2px 6px; font-family: inherit; color: var(--text-main); outline: none;">
                </div>

                <label class="form-label" style="font-size: 10px; color: #94a3b8; margin-top: 6px;">Pilih Jam Berangkat:</label>
                <div class="time-chips-grid" id="timeSlotsContainer">
                    <button type="button" onclick="selectBookingTime('06:00')" data-time="06:00" class="time-chip-btn active">06:00</button>
                    <button type="button" onclick="selectBookingTime('09:00')" data-time="09:00" class="time-chip-btn">09:00</button>
                    <button type="button" onclick="selectBookingTime('13:00')" data-time="13:00" class="time-chip-btn">13:00</button>
                    <button type="button" onclick="selectBookingTime('16:00')" data-time="16:00" class="time-chip-btn">16:00</button>
                    <button type="button" onclick="selectBookingTime('19:30')" data-time="19:30" class="time-chip-btn">19:30</button>
                </div>
                <input type="hidden" id="bookingSelectedTime" value="06:00">
            </div>

            <!-- Pesan Minimal 4 Kursi @ Rp 190.000 -->
            <div class="seat-stepper-box">
                <div class="stepper-info">
                    <div class="title">Jumlah Kursi Shuttle</div>
                    <div class="sub">Minimal 4 Kursi • Rp 190.000 / Kursi</div>
                </div>

                <div class="stepper-ctrl">
                    <button type="button" onclick="changeSeatQuantity(-1)" id="btnMinusSeat" class="stepper-btn">-</button>
                    <span id="seatQuantityDisplay" class="stepper-value">4 Kursi</span>
                    <button type="button" onclick="changeSeatQuantity(1)" id="btnPlusSeat" class="stepper-btn plus">+</button>
                </div>
            </div>

            <!-- Ringkasan Total Tagihan -->
            <div class="billing-summary-row">
                <span class="label">Total Tagihan (All In):</span>
                <span class="total" id="directBookingTotalDisplay">Rp 760.000</span>
            </div>

            <!-- Tombol Booking & Bayar QRIS -->
            <button type="submit" id="btnSubmitDirectBooking" class="btn-primary-cta">
                <i class="fas fa-qrcode"></i>
                <span>Booking sekarang</span>
                <i class="fas fa-arrow-right" style="font-size: 11px;"></i>
            </button>
        </form>
    </div>

    <!-- 4. Pool Resmi Rivian Travel (Clean Corporate Table) -->
    <div style="margin: 0 16px 24px 16px;">
        <h4 style="font-size: 11px; font-weight: 800; color: #64748b; margin-bottom: 8px; text-transform: uppercase; letter-spacing: 0.5px; display: flex; align-items: center; gap: 6px;">
            <i class="fas fa-map-location-dot" style="color: var(--primary);"></i>
            <span>Lokasi Pool Resmi</span>
        </h4>
        <div style="display: flex; flex-direction: column; gap: 6px;">
            <div style="background-color: #ffffff; border: 1px solid var(--border-color); border-radius: 12px; padding: 10px 12px; display: flex; align-items: center; justify-content: space-between;">
                <div>
                    <strong style="font-size: 11px; color: #0f172a; display: flex; align-items: center; gap: 6px;">
                        <i class="fas fa-building" style="color: var(--primary); font-size: 10px;"></i>
                        <span>Pool Ciamis Pusat</span>
                    </strong>
                    <span style="font-size: 10px; color: #64748b; margin-left: 16px; display: block;">Jl. Jend. Sudirman No. 88 (Alun-Alun Ciamis)</span>
                </div>
                <span style="font-size: 9px; font-weight: 700; color: var(--primary); background: var(--primary-light); border: 1px solid var(--border-primary); padding: 2px 7px; border-radius: 9999px;">Pusat</span>
            </div>
            <div style="background-color: #ffffff; border: 1px solid var(--border-color); border-radius: 12px; padding: 10px 12px; display: flex; align-items: center; justify-content: space-between;">
                <div>
                    <strong style="font-size: 11px; color: #0f172a; display: flex; align-items: center; gap: 6px;">
                        <i class="fas fa-building" style="color: var(--primary); font-size: 10px;"></i>
                        <span>Pool Pasteur Bandung</span>
                    </strong>
                    <span style="font-size: 10px; color: #64748b; margin-left: 16px; display: block;">Jl. Dr. Djunjunan No. 135 (Gerbang Tol Pasteur)</span>
                </div>
                <span style="font-size: 9px; font-weight: 700; color: var(--primary); background: var(--primary-light); border: 1px solid var(--border-primary); padding: 2px 7px; border-radius: 9999px;">Tol Pasteur</span>
            </div>
            <div style="background-color: #ffffff; border: 1px solid var(--border-color); border-radius: 12px; padding: 10px 12px; display: flex; align-items: center; justify-content: space-between;">
                <div>
                    <strong style="font-size: 11px; color: #0f172a; display: flex; align-items: center; gap: 6px;">
                        <i class="fas fa-building" style="color: var(--primary); font-size: 10px;"></i>
                        <span>Pool Dipatiukur Bandung</span>
                    </strong>
                    <span style="font-size: 10px; color: #64748b; margin-left: 16px; display: block;">Jl. Dipatiukur No. 45, Coblong (Dekat UNPAD)</span>
                </div>
                <span style="font-size: 9px; font-weight: 700; color: var(--primary); background: var(--primary-light); border: 1px solid var(--border-primary); padding: 2px 7px; border-radius: 9999px;">UNPAD</span>
            </div>
        </div>
    </div>

</section>
