<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover">
    <title>Rivian Travel - Shuttle Daihatsu Xenia Ciamis Bandung PP</title>
    <meta name="description" content="Aplikasi booking shuttle eksekutif Daihatsu Xenia Ciamis - Bandung PP door to door.">

    <!-- Laravel Vite Bundled Assets (Local Tailwind & JS, No CDN) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Dedicated Travel Mobile Design System -->
    <link rel="stylesheet" href="{{ asset('css/travell_mobile.css') }}">

    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Font Awesome 6 Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

    @php
    $brandName = 'Rivian Travel';
    $waNumber = '6281234567890';

    $dbSchedulesList = [];
    if (isset($schedules) && $schedules->isNotEmpty()) {
    foreach($schedules as $s) {
    $originName = $s->route->origin ?? 'Ciamis';
    $destName = $s->route->destination ?? 'Bandung';
    $timeObj = \Carbon\Carbon::parse($s->departure_time);
    $hour = (int) $timeObj->format('H');
    $shift = 'pagi';
    if ($hour >= 11 && $hour < 17) $shift='siang' ; elseif ($hour>= 17 || $hour < 5) $shift='malam' ; $bookedSeats=[]; try { $bookedSeats=$s->bookings()
            ->whereIn('payment_status', ['paid', 'unpaid'])
            ->with('details')
            ->get()
            ->flatMap(function($b) {
            return $b->details ? $b->details->where('item_type', 'seat')->pluck('seat_number') : [];
            })
            ->map(function($num) {
            preg_match('/\d+/', (string)$num, $m);
            return isset($m[0]) ? (int)$m[0] : null;
            })
            ->filter()
            ->unique()
            ->values()
            ->toArray();
            } catch (\Throwable $e) {
            $bookedSeats = [];
            }

            $price = (int)($s->route->base_price ?? 190000);
            $dateFormatted = is_string($s->departure_date) ? $s->departure_date : (optional($s->departure_date)->format('Y-m-d') ?? date('Y-m-d'));

            $dbSchedulesList[] = [
            'id' => $s->id,
            'origin' => $originName,
            'destination' => $destName,
            'fleet_name' => 'Daihatsu All New Xenia',
            'departure_time' => $timeObj->format('H:i') . ' WIB',
            'arrival_est' => $timeObj->copy()->addHours(3)->addMinutes(30)->format('H:i') . ' WIB',
            'price' => $price,
            'price_formatted' => 'Rp ' . number_format($price, 0, ',', '.'),
            'total_seats' => 5,
            'booked_seats' => $bookedSeats,
            'min_quota' => (int)($s->min_quota ?? 4),
            'shift' => $shift,
            'date' => $dateFormatted,
            ];
            }
            }

            if (empty($dbSchedulesList)) {
            $dbSchedulesList = [
            ['id' => 101, 'origin' => 'Ciamis', 'destination' => 'Bandung (Pasteur / Dipatiukur)', 'fleet_name' => 'Daihatsu All New Xenia', 'departure_time' => '06:00 WIB', 'arrival_est' => '09:30 WIB', 'price' => 190000, 'price_formatted' => 'Rp 190.000', 'total_seats' => 5, 'booked_seats' => [2], 'shift' => 'pagi'],
            ['id' => 102, 'origin' => 'Ciamis', 'destination' => 'Bandung (Pasteur / Dipatiukur)', 'fleet_name' => 'Daihatsu All New Xenia', 'departure_time' => '09:00 WIB', 'arrival_est' => '12:30 WIB', 'price' => 190000, 'price_formatted' => 'Rp 190.000', 'total_seats' => 5, 'booked_seats' => [], 'shift' => 'pagi'],
            ['id' => 103, 'origin' => 'Ciamis', 'destination' => 'Bandung (Pasteur / Dipatiukur)', 'fleet_name' => 'Daihatsu All New Xenia', 'departure_time' => '13:00 WIB', 'arrival_est' => '16:30 WIB', 'price' => 190000, 'price_formatted' => 'Rp 190.000', 'total_seats' => 5, 'booked_seats' => [1], 'shift' => 'siang'],
            ['id' => 104, 'origin' => 'Ciamis', 'destination' => 'Bandung (Pasteur / Dipatiukur)', 'fleet_name' => 'Daihatsu All New Xenia', 'departure_time' => '16:00 WIB', 'arrival_est' => '19:30 WIB', 'price' => 190000, 'price_formatted' => 'Rp 190.000', 'total_seats' => 5, 'booked_seats' => [3, 4], 'shift' => 'siang'],
            ['id' => 105, 'origin' => 'Ciamis', 'destination' => 'Bandung (Pasteur / Dipatiukur)', 'fleet_name' => 'Daihatsu All New Xenia', 'departure_time' => '19:30 WIB', 'arrival_est' => '23:00 WIB', 'price' => 190000, 'price_formatted' => 'Rp 190.000', 'total_seats' => 5, 'booked_seats' => [], 'shift' => 'malam'],
            ];
            }
            @endphp

            <!-- Mobile App Shell -->
            <div class="mobile-app-shell">

                <!-- Main Scrollable Container -->
                <div class="app-scroll-content" id="appViewport">
                    <!-- VIEW 1: HOME (MINIMALIST SHUTTLE BOOKING) -->
                    @include('travell.partials.view_home')

                    <!-- VIEW 6: OFFICIAL E-TICKET -->
                    @include('travell.partials.view_success_ticket')

                    <!-- VIEW 7: ORDER HISTORY (TIKET SAYA) -->
                    @include('travell.partials.view_history')
                </div>

                <!-- 3. QRIS Instant Popup Modal -->
                @include('travell.partials.view_payment')

                <!-- 4. Docked Mobile Bottom Navigation Bar (Matching Reference Image) -->
                <nav class="bottom-nav-bar">
                    <button type="button" onclick="switchView('viewHome')" id="navTabHome" class="nav-tab-link active">
                        <i class="fas fa-house"></i>
                        <span>Home</span>
                    </button>
                    <button type="button" onclick="switchView('viewHistory')" id="navTabTickets" class="nav-tab-link">
                        <i class="fas fa-receipt"></i>
                        <span>Tiket Saya</span>
                    </button>
                    <a href="https://wa.me/{{ $waNumber }}" target="_blank" class="nav-tab-link">
                        <i class="fab fa-whatsapp"></i>
                        <span>WhatsApp</span>
                    </a>
                    <button type="button" onclick="openCustomerAuthModal()" id="navTabAccount" class="nav-tab-link">
                        <i class="fas fa-user"></i>
                        <span>Akun</span>
                    </button>
                </nav>

            </div>

            <!-- Customer Auth Modal -->
            <div id="customerAuthModal" class="qris-modal-backdrop">
                <div class="qris-modal-card" style="text-align: left;">
                    <div class="qris-modal-header">
                        <strong style="font-size: 13px; color: #0f172a;">Akun & Poin Pelanggan</strong>
                        <button type="button" onclick="closeCustomerAuthModal()" class="qris-close-btn">&times;</button>
                    </div>

                    <form id="customerAuthForm" onsubmit="handleCustomerAuthSubmit(event)">
                        <div class="form-group">
                            <label class="form-label">Nomor WhatsApp Aktif *</label>
                            <div class="input-field-wrapper">
                                <i class="fab fa-whatsapp input-icon" style="color: var(--primary);"></i>
                                <input type="tel" id="authCustomerPhone" required placeholder="081234567890" class="form-input">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Nama Lengkap *</label>
                            <div class="input-field-wrapper">
                                <i class="far fa-user input-icon"></i>
                                <input type="text" id="authCustomerName" required placeholder="Contoh: Budi Santoso" class="form-input">
                            </div>
                        </div>

                        <div style="background-color: var(--primary-light); border: 1px solid var(--border-primary); border-radius: 12px; padding: 10px; font-size: 11px; color: var(--primary); margin-bottom: 12px;">
                            <i class="fas fa-gift"></i> Pelanggan baru otomatis mendapatkan <strong>+50 Poin Loyalti</strong>!
                        </div>

                        <button type="submit" id="btnSubmitAuthCustomer" class="btn-primary-cta" style="height: 42px; margin-top: 0;">
                            <span>Masuk Akun</span>
                            <i class="fas fa-arrow-right"></i>
                        </button>
                    </form>
                </div>
            </div>

            <!-- JS ENGINE LOGIC & STATE PERSISTENCE -->
            @include('travell.partials.scripts')

</body>
</html>
