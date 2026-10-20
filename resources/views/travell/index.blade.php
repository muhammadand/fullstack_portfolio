<!DOCTYPE html>
<html lang="id" class="h-full bg-slate-950">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover">
    <title>Rivian Travel - Shuttle Daihatsu Xenia Ciamis Bandung PP & Sewa Mobil</title>
    <meta name="description" content="Aplikasi booking shuttle eksekutif Daihatsu Xenia Ciamis - Bandung PP door to door dan sewa mobil + sopir.">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        travel: {
                            50: '#f0f9ff',
                            100: '#e0f2fe',
                            200: '#bae6fd',
                            300: '#7dd3fc',
                            400: '#38bdf8',
                            500: '#0ea5e9',
                            600: '#0284c7',
                            700: '#0369a1',
                            800: '#075985',
                            900: '#0c4a6e',
                            dark: '#082f49'
                        }
                    },
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'system-ui', '-apple-system', 'sans-serif']
                    }
                }
            }
        }
    </script>

    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Font Awesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            -webkit-tap-highlight-color: transparent;
            user-select: none;
        }

        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        /* Mobile Device Frame for Desktop Preview */
        @media (min-width: 768px) {
            .mobile-device-wrapper {
                max-width: 412px;
                height: 860px;
                max-height: 94vh;
                border-radius: 44px;
                box-shadow: 0 25px 60px -15px rgba(0, 0, 0, 0.7), 0 0 0 10px #0f172a, 0 0 0 12px #334155;
                position: relative;
                overflow: hidden;
            }
        }
    </style>
</head>
<body class="h-full bg-slate-950 flex flex-col items-center justify-center text-slate-900 antialiased p-0 sm:p-4">

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
                if ($hour >= 11 && $hour < 17) $shift = 'siang';
                elseif ($hour >= 17 || $hour < 5) $shift = 'malam';

                $bookedSeats = [];
                try {
                    $bookedSeats = $s->bookings()
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
                ['id' => 201, 'origin' => 'Bandung', 'destination' => 'Ciamis (Pool / Alamat Rumah)', 'fleet_name' => 'Daihatsu All New Xenia', 'departure_time' => '06:30 WIB', 'arrival_est' => '10:00 WIB', 'price' => 190000, 'price_formatted' => 'Rp 190.000', 'total_seats' => 5, 'booked_seats' => [1], 'shift' => 'pagi'],
                ['id' => 202, 'origin' => 'Bandung', 'destination' => 'Ciamis (Pool / Alamat Rumah)', 'fleet_name' => 'Daihatsu All New Xenia', 'departure_time' => '10:00 WIB', 'arrival_est' => '13:30 WIB', 'price' => 190000, 'price_formatted' => 'Rp 190.000', 'total_seats' => 5, 'booked_seats' => [], 'shift' => 'pagi'],
                ['id' => 203, 'origin' => 'Bandung', 'destination' => 'Ciamis (Pool / Alamat Rumah)', 'fleet_name' => 'Daihatsu All New Xenia', 'departure_time' => '14:00 WIB', 'arrival_est' => '17:30 WIB', 'price' => 190000, 'price_formatted' => 'Rp 190.000', 'total_seats' => 5, 'booked_seats' => [2, 5], 'shift' => 'siang'],
                ['id' => 204, 'origin' => 'Bandung', 'destination' => 'Ciamis (Pool / Alamat Rumah)', 'fleet_name' => 'Daihatsu All New Xenia', 'departure_time' => '19:30 WIB', 'arrival_est' => '23:00 WIB', 'price' => 190000, 'price_formatted' => 'Rp 190.000', 'total_seats' => 5, 'booked_seats' => [], 'shift' => 'malam'],
            ];
        }
    @endphp

    <!-- Top Banner on Desktop (Indicator) -->
    <header class="w-full max-w-md px-4 py-2 hidden md:flex items-center justify-between text-xs text-slate-400 mb-2">
        <div class="flex items-center gap-2">
            <span class="w-2.5 h-2.5 rounded-full bg-sky-400 animate-pulse"></span>
            <span class="font-bold text-white uppercase tracking-wider">Rivian Travel Mobile App</span>
        </div>
        <a href="https://wa.me/{{ $waNumber }}?text={{ urlencode('Halo Rivian Travel, saya ingin informasi travel Daihatsu Xenia Ciamis Bandung.') }}" target="_blank" class="text-sky-400 hover:text-white flex items-center gap-1.5 font-medium bg-slate-800/90 px-3 py-1.5 rounded-full border border-slate-700 transition">
            <i class="fab fa-whatsapp text-emerald-400"></i>
            <span>CS WhatsApp</span>
        </a>
    </header>

    <!-- Main Mobile Device Screen Container -->
    <main class="w-full h-full sm:h-auto mobile-device-wrapper bg-slate-50 flex flex-col relative overflow-hidden">

        <!-- Mobile Status Bar (Clock, Signal, Battery) -->
        @include('travell.partials.status_bar')

        <!-- APP CONTAINER (SCROLLABLE VIEWPORT) -->
        <div id="appViewport" class="flex-1 overflow-y-auto no-scrollbar relative bg-slate-50 flex flex-col pb-20">

            <!-- VIEW 1: HOME (TRAVELOKA STYLE SHUTTLE BOOKING) -->
            @include('travell.partials.view_home')

            <!-- VIEW 2: SCHEDULE LIST -->
            @include('travell.partials.view_schedules')

            <!-- VIEW 3: SEAT PICKER (DAIHATSU XENIA LAYOUT) -->
            @include('travell.partials.view_seat_picker')

            <!-- VIEW 4: PASSENGER FORM & DOOR-TO-DOOR ADDRESS -->
            @include('travell.partials.view_passenger_form')

            <!-- VIEW 5: QRIS INSTANT PAYMENT SCREEN -->
            @include('travell.partials.view_payment')

            <!-- VIEW 6: OFFICIAL E-TICKET & BOARDING BARCODE -->
            @include('travell.partials.view_success_ticket')

            <!-- VIEW 7: ORDER HISTORY (TIKET SAYA) -->
            @include('travell.partials.view_history')

            <!-- VIEW 8: PRIVATE CHARTER (SEWA MOBIL + SOPIR) -->
            @include('travell.partials.view_charter')

            <!-- VIEW 9: TITIP PAKET KILAT (SAME-DAY CARGO) -->
            @include('travell.partials.view_package')

        </div>

        <!-- APP BOTTOM NAVIGATION BAR (TRAVELOKA STYLE) -->
        @include('travell.partials.bottom_nav')

    </main>

    <!-- JS ENGINE LOGIC & STATE PERSISTENCE -->
    @include('travell.partials.scripts')

</body>
</html>
