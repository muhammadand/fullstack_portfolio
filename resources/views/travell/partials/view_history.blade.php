<!-- ================= VIEW 7: MY BOOKINGS / ORDER HISTORY ================= -->
<section id="viewHistory" class="history-container" style="display: none;">

    <!-- Top Action Bar -->
    <div class="history-top-bar">
        <button type="button" onclick="switchView('viewHome')" class="history-back-btn">
            <i class="fas fa-chevron-left"></i>
            <span>Beranda</span>
        </button>
        <button type="button" onclick="refreshHistory()" class="history-sync-btn">
            <i class="fas fa-arrows-rotate"></i>
            <span>Sinkron Data</span>
        </button>
    </div>

    <!-- 1. Customer Logged In Card (Get by Customer ID) -->
    <div id="historyCustomerLoggedInBar" class="history-search-card" style="display: none; padding: 12px 14px;">
        <div style="display: flex; align-items: center; justify-content: space-between;">
            <div style="display: flex; align-items: center; gap: 10px;">
                <div style="width: 36px; height: 36px; border-radius: 50%; background-color: var(--primary-light); color: var(--primary); border: 1px solid var(--border-primary); display: flex; align-items: center; justify-content: center; font-size: 15px; flex-shrink: 0;">
                    <i class="fas fa-user-check"></i>
                </div>
                <div>
                    <strong style="font-size: 12px; color: #0f172a; display: block;" id="historyCustName">Akun Pelanggan</strong>
                    <span style="font-size: 10px; color: #64748b;" id="historyCustPhone">0812xxxx • 0 Poin</span>
                </div>
            </div>
            <button type="button" onclick="switchCustomerAccount()" class="auth-switch-btn" style="border: 1px solid var(--border-primary); background: var(--primary-light); padding: 4px 10px; border-radius: 8px; font-weight: 700; cursor: pointer;">
                Ganti Akun
            </button>
        </div>
    </div>

    <!-- 2. Guest Phone Lookup Card (Shown ONLY when not logged in) -->
    <div id="historyGuestSearchCard" class="history-search-card" style="display: none;">
        <div class="history-search-title-row">
            <div class="history-search-icon">
                <i class="fab fa-whatsapp"></i>
            </div>
            <div class="history-search-info">
                <strong>Cari Riwayat Tiket</strong>
                <span>Masukkan nomor WhatsApp saat pemesanan</span>
            </div>
        </div>

        <form onsubmit="handleSearchPhoneTickets(event)" class="history-search-form">
            <input type="tel" id="lookupPhoneInput" placeholder="Contoh: 081234567890" class="history-search-input">
            <button type="submit" id="btnLookupTickets" class="history-search-submit">
                <i class="fas fa-magnifying-glass"></i>
                <span>Cari</span>
            </button>
        </form>
        <div id="lookupPhoneBadge" style="font-size: 10px; color: #64748b; margin-top: 6px;"></div>
    </div>

    <!-- 3. Unauthenticated State Card (Shown when not logged in and no phone entered) -->
    <div id="historyAuthRequiredCard" class="history-empty-box" style="display: none; padding: 26px 18px; background: #ffffff; border-radius: 18px; border: 1px solid var(--border-primary, #e2e8f0); margin: 10px 0; box-shadow: 0 4px 16px rgba(15, 23, 42, 0.04); text-align: center;">
        <div class="history-empty-icon" style="background: rgba(37, 99, 235, 0.1); color: var(--primary, #005ce6); width: 60px; height: 60px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 14px; font-size: 26px;">
            <i class="fab fa-whatsapp"></i>
        </div>
        <h4 class="history-empty-title" style="font-size: 15px; font-weight: 700; color: #0f172a; margin-bottom: 6px;">Masukkan Nomor HP Kamu</h4>
        <p class="history-empty-desc" style="font-size: 12px; color: #64748b; max-width: 300px; margin: 0 auto 16px; line-height: 1.5;">
            Kamu belum memasukkan nomor HP / belum masuk akun. Masukkan nomor WhatsApp kamu untuk melihat riwayat pesanan tiket shuttle.
        </p>
        <button type="button" onclick="openHistoryPhoneModal()" class="btn-primary-cta" style="width: auto; padding: 10px 22px; height: 42px; border-radius: 12px; font-size: 12.5px; font-weight: 700; margin: 0 auto; display: inline-flex; align-items: center; gap: 8px;">
            <i class="fab fa-whatsapp"></i>
            <span>Masukkan Nomor HP</span>
        </button>
    </div>

    <!-- Filter Tabs (Segmented Control) -->
    <div class="history-filter-bar">
        <div class="history-tabs-group">
            <button type="button" onclick="filterHistoryTabs('all')" id="tabFilterAll" class="history-tab-btn active">
                Semua
            </button>
            <button type="button" onclick="filterHistoryTabs('pending')" id="tabFilterPending" class="history-tab-btn">
                Verifikasi
            </button>
            <button type="button" onclick="filterHistoryTabs('confirmed')" id="tabFilterConfirmed" class="history-tab-btn">
                Lunas (PAID)
            </button>
        </div>
        <span id="ticketCountBadge" class="history-counter-badge">0 Tiket</span>
    </div>

    <!-- Container for Dynamic Order Tickets -->
    <div id="orderHistoryContainer" style="display: flex; flex-direction: column; gap: 10px;">
        <!-- Injected via renderHistoryList() -->
    </div>

    <!-- Loading State -->
    <div id="historyLoadingSpinner" style="display: none; text-align: center; padding: 36px 0; color: #005ce6;">
        <i class="fas fa-circle-notch fa-spin" style="font-size: 22px;"></i>
        <p style="font-size: 11px; color: #64748b; margin-top: 8px; font-weight: 600;">Mengambil data tiket...</p>
    </div>

    <!-- Empty State -->
    <div id="emptyHistoryAlert" class="history-empty-box" style="display: none;">
        <div class="history-empty-icon">
            <i class="fas fa-receipt"></i>
        </div>
        <h4 class="history-empty-title">Belum Ada Tiket</h4>
        <p class="history-empty-desc">Belum ditemukan pesanan tiket untuk nomor ini. Silakan pesan tiket shuttle sekarang.</p>
        <button type="button" onclick="switchView('viewHome')" class="history-empty-cta">
            <i class="fas fa-van-shuttle"></i>
            <span>Pesan Tiket Shuttle</span>
        </button>
    </div>

    <!-- Modal Popup: Masukkan Nomor HP (Muncul otomatis jika belum login saat ke Riwayat Tiket) -->
    <div id="historyPhonePromptModal" class="qris-modal-backdrop">
        <div class="qris-modal-card" style="text-align: left; max-width: 360px;">
            <div class="qris-modal-header" style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 14px;">
                <div style="display: flex; align-items: center; gap: 10px;">
                    <div style="width: 38px; height: 38px; border-radius: 12px; background: rgba(37, 99, 235, 0.1); color: var(--primary, #005ce6); display: flex; align-items: center; justify-content: center; font-size: 18px; flex-shrink: 0;">
                        <i class="fab fa-whatsapp"></i>
                    </div>
                    <div>
                        <strong style="font-size: 14px; color: #0f172a; display: block;">Masukkan Nomor HP Kamu</strong>
                        <span style="font-size: 11px; color: #64748b;">Untuk melihat riwayat tiket & pesanan</span>
                    </div>
                </div>
                <button type="button" onclick="closeHistoryPhoneModal()" class="qris-close-btn">&times;</button>
            </div>

            <form id="historyPhonePromptForm" onsubmit="handleHistoryPhoneSubmit(event)">
                <div class="form-group" style="margin-bottom: 14px;">
                    <label class="form-label" style="font-size: 12px; font-weight: 600; color: #334155; margin-bottom: 6px; display: block;">
                        Nomor WhatsApp / HP Aktif <span style="color: #ef4444;">*</span>
                    </label>
                    <div class="input-field-wrapper" style="position: relative;">
                        <i class="fab fa-whatsapp input-icon" style="position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: #22c55e; font-size: 16px;"></i>
                        <input type="tel" id="historyModalPhoneInput" required placeholder="Contoh: 081234567890" class="form-input" style="padding-left: 42px; font-size: 14px; font-weight: 600;">
                    </div>
                    <span style="font-size: 10.5px; color: #94a3b8; margin-top: 5px; display: block;">
                        Masukkan nomor WhatsApp yang Anda gunakan saat pemesanan.
                    </span>
                </div>

                <div style="background-color: var(--primary-light, rgba(37, 99, 235, 0.08)); border: 1px solid var(--border-primary, rgba(37, 99, 235, 0.2)); border-radius: 10px; padding: 10px 12px; font-size: 11px; color: var(--primary, #005ce6); margin-bottom: 14px; display: flex; align-items: center; gap: 8px;">
                    <i class="fas fa-ticket"></i>
                    <span>Riwayat e-tiket Anda akan otomatis dimuat & tersinkron.</span>
                </div>

                <button type="submit" id="btnSubmitHistoryPhone" class="btn-primary-cta" style="width: 100%; height: 42px; margin: 0; display: flex; align-items: center; justify-content: center; gap: 8px; font-size: 13px; font-weight: 700; border-radius: 12px;">
                    <span>Lihat Tiket Saya</span>
                    <i class="fas fa-arrow-right"></i>
                </button>
            </form>
        </div>
    </div>

</section>

