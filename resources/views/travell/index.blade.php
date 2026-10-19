<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Rivian Travel - Shuttle Daihatsu Xenia Ciamis Bandung PP & Sewa Mobil</title>
    <meta name="description" content="Rivian Travel melayani shuttle eksekutif armada Daihatsu Xenia Ciamis - Bandung PP door to door dan sewa mobil + sopir. Cepat lewat tol, nyaman, full AC, dan aman.">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        travel: {
                            50: '#f0f7ff'
                            , 100: '#e0effe'
                            , 200: '#bae0fd'
                            , 300: '#7dd3fc'
                            , 400: '#38bdf8'
                            , 500: '#0ea5e9'
                            , 600: '#0284c7'
                            , 700: '#0369a1'
                            , 800: '#075985'
                            , 900: '#0c4a6e'
                            , 950: '#082f49'
                            , dark: '#0a1120'
                            , navy: '#0f172a'
                        , }
                    }
                    , fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'system-ui', '-apple-system', 'sans-serif']
                    , }
                }
            }
        }

    </script>

    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400;1,600&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- QRCode JS Library for Dynamic QRIS rendering -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #fafbfc;
            color: #0f172a;
            overflow-x: hidden;
            -webkit-tap-highlight-color: transparent;
        }

        .glass-panel {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(226, 232, 240, 0.9);
        }

        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

    </style>
</head>
<body class="antialiased selection:bg-travel-700 selection:text-white pb-20 md:pb-0 text-slate-800">

    @php
    $waNumber = '6281234567890';
    $brandName = 'Rivian Travel';
    @endphp

    <!-- Top Compact Notification Bar -->
    <div class="bg-slate-950 text-slate-300 text-xs py-2 px-4 border-b border-slate-800/80">
        <div class="max-w-7xl mx-auto flex flex-col sm:flex-row justify-between items-center gap-1.5 sm:gap-2">
            <div class="flex items-center gap-2 text-[11px] text-slate-300">
                <span class="inline-flex items-center gap-1.5 text-emerald-400 font-semibold">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                    Armada Daihatsu Xenia Nyaman
                </span>
                <span class="text-slate-600">•</span>
                <span class="hidden sm:inline">Ciamis ⇄ Bandung Door to Door Via Tol</span>
                <span class="text-slate-600">•</span>
                <span class="text-sky-300 font-medium">Rp 190.000 / Kursi</span>
            </div>
            <div class="flex items-center gap-4 text-[11px]">
                <span class="text-slate-400 hidden sm:inline">Pool Ciamis: (0265) 771234</span>
                <a href="https://wa.me/{{ $waNumber }}?text={{ urlencode('Halo Rivian Travel, saya ingin informasi jadwal travel Daihatsu Xenia Ciamis Bandung.') }}" target="_blank" class="text-slate-200 hover:text-white transition font-medium">
                    <span>CS WhatsApp: +{{ $waNumber }}</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Main Navigation Header -->
    <header class="sticky top-0 z-40 bg-white/95 backdrop-blur-md border-b border-slate-200/80 shadow-xs">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16 sm:h-20">

                <!-- Brand Logo (With Generated Logo Image) -->
                <a href="{{ route('travell.index') }}" class="flex items-center gap-3">
                    <img src="{{ asset('images/travel/rivian_logo.jpg') }}" alt="Rivian Travel" class="w-10 h-10 rounded-xl object-contain shadow-xs border border-slate-100">
                    <div>
                        <span class="font-extrabold text-lg sm:text-xl text-slate-900 tracking-tight block leading-tight">
                            Rivian<span class="text-travel-700">Travel</span>
                        </span>
                        <span class="text-[10px] font-semibold tracking-wider text-slate-400 uppercase block">
                            Ciamis ⇄ Bandung Shuttle
                        </span>
                    </div>
                </a>

                <!-- Desktop Clean Menu (Minimalis: Hanya 2 Menu Utama) -->
                <nav class="hidden md:flex items-center gap-8 text-sm font-semibold text-slate-600">
                    <a href="#jadwal" class="hover:text-travel-700 transition">Jadwal Keberangkatan</a>
                    <a href="#charter" class="hover:text-travel-700 transition">Sewa Mobil (Charter)</a>
                </nav>

                <!-- Action Button -->
                <div class="flex items-center gap-3">
                    <a href="#booking-cepat" class="hidden sm:inline-flex items-center justify-center px-4 py-2 rounded-xl bg-slate-900 hover:bg-slate-800 text-white text-xs font-bold transition shadow-xs">
                        Pesan Kursi
                    </a>
                    <a href="https://wa.me/{{ $waNumber }}?text={{ urlencode('Halo Rivian Travel, saya ingin booking tiket travel Ciamis Bandung.') }}" target="_blank" class="inline-flex items-center justify-center px-4 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold transition shadow-xs">
                        WhatsApp CS
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- HERO SECTION WITH INSTANT DIRECT BOOKING CARD -->
    <section class="relative pt-6 pb-12 sm:pt-12 sm:pb-16 overflow-hidden bg-gradient-to-b from-slate-100/70 via-white to-slate-50 border-b border-slate-200/60" id="booking-cepat">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-10 items-start">

                <!-- Left Content: Value Proposition -->
                <div class="lg:col-span-6 pt-2">
                    <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-slate-900 text-white text-xs font-semibold mb-4 shadow-xs">
                        <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
                        <span>Shuttle Resmi Ciamis ⇄ Bandung PP</span>
                    </div>

                    <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold tracking-tight text-slate-900 leading-[1.18] mb-4">
                        Perjalanan Ciamis – Bandung Lebih Cepat & Door to Door.
                    </h1>

                    <p class="text-slate-600 text-sm sm:text-base mb-6 leading-relaxed">
                        Armada utama <strong>Daihatsu All New Xenia</strong> eksekutif ber-AC dingin dan suspensi nyaman. Penjemputan langsung di depan pintu rumah Anda di Ciamis dan diantar sampai alamat tujuan di Bandung via Tol.
                    </p>

                    <!-- Key Benefits Grid -->
                    <div class="grid grid-cols-2 gap-3 mb-6">
                        <div class="p-3.5 rounded-2xl bg-white border border-slate-200/80 shadow-xs">
                            <span class="text-xs text-slate-400 uppercase font-bold tracking-wider block">Tarif All-In</span>
                            <span class="text-lg font-black text-slate-900 block mt-0.5">Rp 190.000</span>
                            <span class="text-[11px] text-slate-500">Sudah Termasuk Tol</span>
                        </div>

                        <div class="p-3.5 rounded-2xl bg-white border border-slate-200/80 shadow-xs">
                            <span class="text-xs text-slate-400 uppercase font-bold tracking-wider block">Armada Utama</span>
                            <span class="text-lg font-black text-slate-900 block mt-0.5">Daihatsu Xenia</span>
                            <span class="text-[11px] text-slate-500">Maks. 5 Penumpang</span>
                        </div>

                        <div class="p-3.5 rounded-2xl bg-white border border-slate-200/80 shadow-xs">
                            <span class="text-xs text-slate-400 uppercase font-bold tracking-wider block">Layanan Antar</span>
                            <span class="text-lg font-black text-slate-900 block mt-0.5">Door to Door</span>
                            <span class="text-[11px] text-slate-500">Jemput di Alamat Rumah</span>
                        </div>

                        <div class="p-3.5 rounded-2xl bg-white border border-slate-200/80 shadow-xs">
                            <span class="text-xs text-slate-400 uppercase font-bold tracking-wider block">Jadwal Harian</span>
                            <span class="text-lg font-black text-slate-900 block mt-0.5">5x Sehari</span>
                            <span class="text-[11px] text-slate-500">Pagi, Siang & Malam</span>
                        </div>
                    </div>

                    <!-- Callout 4 Kursi Langsung Berangkat -->
                    <div class="p-3.5 rounded-2xl bg-emerald-50 border border-emerald-200/80 mb-6 flex items-start gap-3">
                        <span class="w-2 h-2 rounded-full bg-emerald-500 mt-1.5 shrink-0"></span>
                        <div class="text-xs">
                            <strong class="text-slate-900 font-bold block">Pesan 4 Kursi Sekaligus? Pasti Langsung Berangkat!</strong>
                            <span class="text-slate-600 leading-relaxed block mt-0.5">
                                Untuk keluarga atau Anda yang buru-buru, pesan 4 kursi (Rp 760.000) dan armada Daihatsu Xenia kami langsung jemput khusus untuk Anda tanpa menunggu penumpang lain.
                            </span>
                        </div>
                    </div>

                    <div class="flex items-center gap-3 text-xs text-slate-500 font-medium">
                        <span class="inline-block w-2 h-2 rounded-full bg-emerald-500"></span>
                        <span>Konfirmasi instan ke WhatsApp CS • Pembayaran Transfer atau Tunai</span>
                    </div>
                </div>

                <!-- Right Side: FORM BOOKING CEPAT (DIRECT INSTANT BOOKING) -->
                <div class="lg:col-span-6">
                    <div class="bg-white rounded-3xl p-5 sm:p-7 shadow-xl border border-slate-200">
                        <div class="flex items-center justify-between border-b border-slate-100 pb-3 mb-4">
                            <div>
                                <span class="text-[10px] font-bold text-travel-700 uppercase tracking-wider block">PESAN TIKET ONLINE</span>
                                <h2 class="text-lg font-extrabold text-slate-900">Form Booking Cepat Kursi Xenia</h2>
                            </div>
                            <span class="px-2.5 py-1 rounded-md bg-emerald-50 text-emerald-700 text-xs font-bold">
                                Rp 190.000 / Kursi
                            </span>
                        </div>

                        <form id="heroBookingForm" onsubmit="submitHeroBooking(event)" class="space-y-3.5">
                            @csrf
                            <input type="hidden" name="booking_type" value="reguler">

                            <!-- Rute Selector (Radio Buttons Modern) -->
                            <div>
                                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Pilih Rute Perjalanan</label>
                                <div class="grid grid-cols-2 gap-2">
                                    <label class="cursor-pointer border border-slate-200 rounded-xl p-2.5 flex items-center justify-between hover:border-slate-400 transition has-[:checked]:border-slate-900 has-[:checked]:bg-slate-900 has-[:checked]:text-white">
                                        <input type="radio" name="hero_route" value="1" checked class="hidden" onchange="updateHeroRoute(1)">
                                        <div>
                                            <span class="text-xs font-bold block">Ciamis &rarr; Bandung</span>
                                            <span class="text-[10px] opacity-75">Pool / Jemput Rumah</span>
                                        </div>
                                    </label>

                                    <label class="cursor-pointer border border-slate-200 rounded-xl p-2.5 flex items-center justify-between hover:border-slate-400 transition has-[:checked]:border-slate-900 has-[:checked]:bg-slate-900 has-[:checked]:text-white">
                                        <input type="radio" name="hero_route" value="2" class="hidden" onchange="updateHeroRoute(2)">
                                        <div>
                                            <span class="text-xs font-bold block">Bandung &rarr; Ciamis</span>
                                            <span class="text-[10px] opacity-75">Pool / Jemput Rumah</span>
                                        </div>
                                    </label>
                                </div>
                            </div>

                            <!-- Tanggal & Jam Berangkat -->
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                <div>
                                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Tanggal Berangkat</label>
                                    <input type="date" name="hero_date" id="heroDate" value="{{ date('Y-m-d') }}" min="{{ date('Y-m-d') }}" required class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold focus:outline-none focus:ring-2 focus:ring-slate-900">
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Pilihan Jam Berangkat</label>
                                    <select name="hero_time" id="heroTime" required class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold focus:outline-none focus:ring-2 focus:ring-slate-900">
                                        <option value="06:00:00">06:00 WIB (Pagi)</option>
                                        <option value="09:00:00">09:00 WIB (Pagi)</option>
                                        <option value="13:00:00">13:00 WIB (Siang)</option>
                                        <option value="16:00:00">16:00 WIB (Sore)</option>
                                        <option value="19:30:00">19:30 WIB (Malam)</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Data Penumpang -->
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                <div>
                                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Nama Pemesan *</label>
                                    <input type="text" name="name" id="heroName" required placeholder="Nama lengkap Anda" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold focus:outline-none focus:ring-2 focus:ring-slate-900">
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Nomor WhatsApp *</label>
                                    <input type="tel" name="phone" id="heroPhone" required placeholder="08xxxxxxxxxx" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold focus:outline-none focus:ring-2 focus:ring-slate-900">
                                </div>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                <div>
                                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Jumlah Kursi</label>
                                    <select name="total_passengers" id="heroPassengers" onchange="recalcHeroTotal()" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold focus:outline-none focus:ring-2 focus:ring-slate-900">
                                        <option value="1">1 Kursi (Rp 190.000)</option>
                                        <option value="2">2 Kursi (Rp 380.000)</option>
                                        <option value="3">3 Kursi (Rp 570.000)</option>
                                        <option value="4" selected>★ 4 Kursi (Rp 760.000) - PASTI LANGSUNG JALAN</option>
                                        <option value="5">★ 5 Kursi (Rp 950.000) - FULL 1 XENIA</option>
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Titik Jemput (Alamat)</label>
                                    <input type="text" name="pickup_address" id="heroPickup" placeholder="Alamat rumah / pool penjemputan" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold focus:outline-none focus:ring-2 focus:ring-slate-900">
                                </div>
                            </div>

                            <!-- Dynamic Quota Status Badge -->
                            <div id="heroQuotaBadge" class="p-2.5 rounded-xl bg-emerald-50 border border-emerald-200 text-[11px] text-emerald-900 font-semibold flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full bg-emerald-500 shrink-0"></span>
                                <span id="heroQuotaText">Pasti Langsung Berangkat! Khusus rombongan/Anda sendiri tanpa menunggu penumpang lain.</span>
                            </div>

                            <!-- Summary & Submit -->
                            <div class="bg-slate-50 p-3 rounded-xl border border-slate-200 flex items-center justify-between">
                                <div>
                                    <span class="text-[10px] text-slate-400 font-bold uppercase block">Total Pembayaran</span>
                                    <span id="heroTotalDisplay" class="text-base font-black text-slate-900">Rp 760.000</span>
                                </div>
                                <span class="text-[10px] text-slate-500 font-medium">Bisa bayar tunai / transfer</span>
                            </div>

                            <button type="submit" id="btnHeroSubmit" class="w-full py-3 rounded-xl bg-slate-900 hover:bg-slate-800 text-white font-extrabold text-xs sm:text-sm transition active:scale-95 shadow-md">
                                Pesan Kursi Sekarang (Konfirmasi Instan)
                            </button>
                        </form>
                    </div>
                </div>

            </div>

        </div>
    </section>

    <!-- SCHEDULE LIST SECTION -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-14 sm:py-18" id="jadwal">
        <div class="flex flex-col md:flex-row md:items-end justify-between mb-8 gap-4 border-b border-slate-200 pb-5">
            <div>
                <span class="text-travel-700 font-bold text-xs uppercase tracking-widest block mb-1">JADWAL PERJALANAN</span>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900">
                    Jadwal Keberangkatan {{ $selectedOrigin }} &rarr; {{ $selectedDestination }}
                </h2>
                <p class="text-xs sm:text-sm text-slate-500 mt-1">
                    Tanggal: <strong class="text-slate-800">{{ \Carbon\Carbon::parse($selectedDate)->translatedFormat('l, d F Y') }}</strong>
                </p>
            </div>

            <!-- Quick Date Tabs -->
            <div class="flex items-center gap-2 overflow-x-auto no-scrollbar pb-1">
                @for ($i = 0; $i < 4; $i++) @php $targetDate=\Carbon\Carbon::today()->addDays($i);
                    $formattedDate = $targetDate->toDateString();
                    $isActive = ($selectedDate === $formattedDate);
                    @endphp
                    <a href="{{ route('travell.index', ['origin' => $selectedOrigin, 'destination' => $selectedDestination, 'date' => $formattedDate]) }}#jadwal" class="px-3.5 py-2 rounded-xl text-xs font-bold transition whitespace-nowrap {{ $isActive ? 'bg-slate-900 text-white shadow-xs' : 'bg-white border border-slate-200 text-slate-600 hover:bg-slate-50' }}">
                        {{ $i === 0 ? 'Hari Ini' : ($i === 1 ? 'Besok' : $targetDate->translatedFormat('d M')) }}
                    </a>
                    @endfor
            </div>
        </div>

        @if($schedules->isEmpty())
        <div class="bg-white rounded-3xl p-10 text-center border border-slate-200 max-w-md mx-auto shadow-xs">
            <h3 class="text-base font-bold text-slate-800 mb-1">Jadwal Belum Tersedia di Tanggal Ini</h3>
            <p class="text-xs text-slate-500 mb-5">Silakan pilih tanggal lain atau hubungi CS kami untuk jadwal tambahan / sewa mobil.</p>
            <a href="https://wa.me/{{ $waNumber }}?text={{ urlencode('Halo Rivian Travel, saya ingin tanya ketersediaan jadwal travel Ciamis Bandung untuk tanggal ' . $selectedDate) }}" target="_blank" class="inline-flex items-center px-4 py-2 rounded-xl bg-emerald-600 text-white font-bold text-xs hover:bg-emerald-700 transition">
                Hubungi CS via WhatsApp
            </a>
        </div>
        @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
            @foreach($schedules as $sched)
            <div class="bg-white rounded-2xl border border-slate-200 p-5 flex flex-col justify-between hover:border-slate-300 hover:shadow-md transition">
                <div>
                    <!-- Header Row -->
                    <div class="flex items-center justify-between mb-4">
                        <span class="px-2.5 py-1 rounded-md text-[11px] font-bold uppercase tracking-wider bg-slate-100 text-slate-700">
                            Daihatsu Xenia
                        </span>

                        <span class="text-[11px] font-semibold text-emerald-600 flex items-center gap-1">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                            <span>Tersedia</span>
                        </span>
                    </div>

                    <!-- Jam & Tarif -->
                    <div class="flex items-baseline justify-between mb-4">
                        <div>
                            <span class="text-[10px] uppercase font-bold text-slate-400 block tracking-wider">Jam Berangkat</span>
                            <span class="text-2xl font-black text-slate-900">
                                {{ \Carbon\Carbon::parse($sched->departure_time)->format('H:i') }} <span class="text-xs font-bold text-slate-400">WIB</span>
                            </span>
                        </div>
                        <div class="text-right">
                            <span class="text-[10px] uppercase font-bold text-slate-400 block tracking-wider">Tarif Kursi</span>
                            <span class="text-lg font-black text-slate-900">
                                Rp {{ number_format($sched->route->base_price ?? 190000, 0, ',', '.') }}
                            </span>
                        </div>
                    </div>

                    <!-- Route Visual Box -->
                    <div class="bg-slate-50 rounded-xl p-3 border border-slate-100 mb-4 text-xs font-semibold text-slate-700">
                        <div class="flex items-center justify-between">
                            <span>Asal: <strong>{{ $sched->route->origin ?? 'Ciamis' }}</strong></span>
                            <span class="text-slate-400">&rarr;</span>
                            <span>Tujuan: <strong>{{ $sched->route->destination ?? 'Bandung' }}</strong></span>
                        </div>
                    </div>

                    <!-- Information Points -->
                    <div class="space-y-1.5 text-xs text-slate-500 mb-6">
                        <p class="flex items-center justify-between">
                            <span>Jalur</span>
                            <span class="font-semibold text-slate-800">Lewat Tol Cepat</span>
                        </p>
                        <p class="flex items-center justify-between">
                            <span>Antar Jemput</span>
                            <span class="font-semibold text-slate-800">Door to Door</span>
                        </p>
                        <p class="flex items-center justify-between">
                            <span>Kenyamanan</span>
                            <span class="font-semibold text-slate-800">Full AC & Musik</span>
                        </p>
                    </div>
                </div>

                <!-- Action Button -->
                <button type="button" onclick="openBookingModal('reguler', {{ $sched->id }}, '{{ $sched->route->origin ?? 'Ciamis' }}', '{{ $sched->route->destination ?? 'Bandung' }}', '{{ \Carbon\Carbon::parse($sched->departure_time)->format('H:i') }} WIB', {{ $sched->route->base_price ?? 190000 }}, '{{ $sched->departure_date }}')" class="w-full py-2.5 rounded-xl bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs transition active:scale-95 shadow-xs">
                    Pesan Kursi Ini
                </button>
            </div>
            @endforeach
        </div>
        @endif
    </section>

    <!-- SECTION SEWA MOBIL XENIA & SOPIR (CHARTER WISATA) -->
    <section class="bg-slate-900 text-white py-16 sm:py-20 px-4" id="charter">
        <div class="max-w-7xl mx-auto">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-center">
                <div class="lg:col-span-6">
                    <span class="text-sky-400 font-bold text-xs uppercase tracking-widest block mb-2">SEWA MOBIL XENIA + SOPIR</span>
                    <h2 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold tracking-tight mb-4 leading-tight">
                        Sewa 1 Mobil Daihatsu Xenia Seharian ke Pantai atau Bandung
                    </h2>
                    <p class="text-slate-300 text-sm leading-relaxed mb-6">
                        Privasi penuh untuk rombongan keluarga 1 mobil utuh tanpa dicampur penumpang lain. Sopir profesional siap mengantar liburan ke Pantai Pangandaran, Pantai Batu Karas, tour Bandung, atau drop off bandara.
                    </p>

                    <div class="space-y-3 mb-8 text-xs sm:text-sm text-slate-200">
                        <div class="flex items-center justify-between p-3 rounded-xl bg-white/5 border border-white/10">
                            <span>Kapasitas Rombongan</span>
                            <span class="font-bold text-white">4 - 6 Orang Nyaman</span>
                        </div>
                        <div class="flex items-center justify-between p-3 rounded-xl bg-white/5 border border-white/10">
                            <span>Paket Lengkap All-In</span>
                            <span class="font-bold text-white">Mobil Xenia + Jasa Sopir</span>
                        </div>
                        <div class="flex items-center justify-between p-3 rounded-xl bg-white/5 border border-white/10">
                            <span>Waktu & Tujuan Fleksibel</span>
                            <span class="font-bold text-white">Sesuai Agenda Liburan Anda</span>
                        </div>
                    </div>

                    <button type="button" onclick="openBookingModal('charter', null, 'Ciamis/Bandung', 'Wisata Pantai / Bandung', 'Fleksibel', 850000, '{{ date('Y-m-d') }}')" class="w-full sm:w-auto px-6 py-3 rounded-xl bg-white text-slate-900 font-extrabold text-xs sm:text-sm hover:bg-slate-100 transition shadow-sm active:scale-95">
                        Booking Sewa Mobil Xenia + Sopir
                    </button>
                </div>

                <div class="lg:col-span-6 grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="bg-white/5 rounded-2xl p-5 border border-white/10">
                        <span class="text-[10px] font-bold text-sky-400 uppercase tracking-wider block mb-1">PAKET PANTAI</span>
                        <h3 class="text-base font-bold text-white mb-2">Pangandaran & Batu Karas</h3>
                        <p class="text-xs text-slate-400 mb-4">PP dari Ciamis atau Bandung untuk liburan akhir pekan keluarga.</p>
                        <span class="text-base font-extrabold text-white block">Mulai Rp 850.000 / Hari</span>
                    </div>

                    <div class="bg-white/5 rounded-2xl p-5 border border-white/10">
                        <span class="text-[10px] font-bold text-sky-400 uppercase tracking-wider block mb-1">PAKET KOTA</span>
                        <h3 class="text-base font-bold text-white mb-2">City Tour Bandung</h3>
                        <p class="text-xs text-slate-400 mb-4">Wisata belanja, kuliner, Lembang, dan Ciwidey bebas lelah nyetir.</p>
                        <span class="text-base font-extrabold text-white block">Mulai Rp 850.000 / Hari</span>
                    </div>

                    <div class="bg-white/5 rounded-2xl p-5 border border-white/10">
                        <span class="text-[10px] font-bold text-sky-400 uppercase tracking-wider block mb-1">DROP BANDARA</span>
                        <h3 class="text-base font-bold text-white mb-2">Bandara Kertajati / Soetta</h3>
                        <p class="text-xs text-slate-400 mb-4">Pengantaran tepat waktu langsung ke terminal keberangkatan.</p>
                        <span class="text-base font-extrabold text-white block">Tarif Khusus Tol</span>
                    </div>

                    <div class="bg-white/5 rounded-2xl p-5 border border-white/10 flex flex-col justify-between">
                        <div>
                            <span class="text-[10px] font-bold text-sky-400 uppercase tracking-wider block mb-1">KONSULTASI</span>
                            <h3 class="text-base font-bold text-white mb-2">Rute Luar Kota Lainnya</h3>
                            <p class="text-xs text-slate-400 mb-3">Sewa beberapa hari untuk kebutuhan acara keluarga atau dinas.</p>
                        </div>
                        <a href="https://wa.me/{{ $waNumber }}?text={{ urlencode('Halo Rivian Travel, saya ingin konsultasi sewa mobil Xenia + sopir untuk rute khusus.') }}" target="_blank" class="text-xs text-sky-300 hover:text-white font-bold transition">
                            Chat Admin CS &rarr;
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ARMADA SECTION (DAIHATSU XENIA) -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 sm:py-20" id="armada">
        <div class="max-w-2xl mx-auto text-center mb-12">
            <span class="text-travel-700 font-bold text-xs uppercase tracking-widest block mb-1">STANDAR ARMADA</span>
            <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900">Armada Daihatsu Xenia Rivian Travel</h2>
            <p class="text-xs sm:text-sm text-slate-500 mt-2">Kabin wangi, AC dingin terawat, serta lincah menjangkau alamat penjemputan hingga gang perumahan.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-xs">
                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block mb-1">Shuttle Reguler</span>
                <h3 class="text-lg font-bold text-slate-900 mb-2">Daihatsu All New Xenia</h3>
                <p class="text-xs text-slate-500 mb-4 leading-relaxed">Kapasitas maksimal 5 penumpang per mobil agar tetap leluasa dan tidak berdesakan selama perjalanan lewat tol.</p>
                <div class="pt-4 border-t border-slate-100 flex items-center justify-between text-xs font-semibold text-slate-700">
                    <span>Layanan</span>
                    <span class="text-slate-900 font-bold">Door to Door Ciamis - Bandung</span>
                </div>
            </div>

            <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-xs">
                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block mb-1">Charter Wisata</span>
                <h3 class="text-lg font-bold text-slate-900 mb-2">Daihatsu Xenia Family</h3>
                <p class="text-xs text-slate-500 mb-4 leading-relaxed">Disewakan khusus untuk rombongan keluarga berlibur ke Pantai Pangandaran, Batu Karas, atau keliling Bandung.</p>
                <div class="pt-4 border-t border-slate-100 flex items-center justify-between text-xs font-semibold text-slate-700">
                    <span>Paket</span>
                    <span class="text-slate-900 font-bold">All-In Mobil + Sopir</span>
                </div>
            </div>

            <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-xs">
                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block mb-1">Standar Kebersihan</span>
                <h3 class="text-lg font-bold text-slate-900 mb-2">Unit Bersih & Terawat</h3>
                <p class="text-xs text-slate-500 mb-4 leading-relaxed">Dicuci bersih sebelum setiap perjalanan, kabin wangi bebas bau rokok, dan servis rutin bengkel resmi.</p>
                <div class="pt-4 border-t border-slate-100 flex items-center justify-between text-xs font-semibold text-slate-700">
                    <span>Kenyamanan</span>
                    <span class="text-slate-900 font-bold">Full AC Double Blower</span>
                </div>
            </div>
        </div>
    </section>

    <!-- KEUNGGULAN SECTION (CLEAN & PROFESSIONAL) -->
    <section class="bg-slate-100/60 py-16 sm:py-20 border-y border-slate-200/60" id="keunggulan">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-2xl mx-auto text-center mb-12">
                <span class="text-travel-700 font-bold text-xs uppercase tracking-widest block mb-1">KEUNGGULAN KAMI</span>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900">Standar Pelayanan Rivian Travel</h2>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-xs">
                    <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block mb-1">01 / Penjemputan</span>
                    <h3 class="text-base font-bold text-slate-900 mb-2">Door to Door Praktis</h3>
                    <p class="text-xs text-slate-500 leading-relaxed">Dijemput langsung di alamat rumah Ciamis dan diantar hingga tujuan akhir di Bandung tanpa repot naik turun angkot.</p>
                </div>

                <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-xs">
                    <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block mb-1">02 / Waktu</span>
                    <h3 class="text-base font-bold text-slate-900 mb-2">Jalur Tol Cepat</h3>
                    <p class="text-xs text-slate-500 leading-relaxed">Melalui rute jalan tol untuk memangkas waktu tempuh dan menghindari titik kemacetan jalur biasa.</p>
                </div>

                <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-xs">
                    <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block mb-1">03 / Pengemudi</span>
                    <h3 class="text-base font-bold text-slate-900 mb-2">Sopir Berpengalaman</h3>
                    <p class="text-xs text-slate-500 leading-relaxed">Pengemudi terlatih yang mengutamakan keselamatan, sopan santun, serta hafal jalur Ciamis – Bandung.</p>
                </div>

                <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-xs">
                    <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block mb-1">04 / Kepastian</span>
                    <h3 class="text-base font-bold text-slate-900 mb-2">Tarif Transparan</h3>
                    <p class="text-xs text-slate-500 leading-relaxed">Harga tiket Rp 190.000 pasti sudah termasuk tol dan jasa antar jemput wilayah dalam kota.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- POOL & CONTACT SECTION -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 sm:py-20" id="kontak">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-center">
            <div class="lg:col-span-7">
                <span class="text-travel-700 font-bold text-xs uppercase tracking-widest block mb-1">TITIK LAYANAN</span>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 mb-4">Lokasi Pool & Titik Keberangkatan</h2>
                <p class="text-xs sm:text-sm text-slate-600 mb-6 leading-relaxed">
                    Selain antar jemput alamat, penumpang juga dapat berangkat dari pool resmi dengan ruang tunggu ber-AC.
                </p>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs">
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block mb-1">KANTOR & POOL CIAMIS</span>
                        <h3 class="font-bold text-sm text-slate-900">Pool Pusat Ciamis</h3>
                        <p class="text-xs text-slate-500 mt-1">Jl. Jenderal Sudirman No. 88, Ciamis (Dekat Alun-Alun Ciamis)</p>
                        <span class="text-xs font-semibold text-slate-800 block mt-2">Telepon: (0265) 771234</span>
                    </div>

                    <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs">
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block mb-1">POOL BANDUNG</span>
                        <h3 class="font-bold text-sm text-slate-900">Pool Dipatiukur Bandung</h3>
                        <p class="text-xs text-slate-500 mt-1">Jl. Dipatiukur No. 45, Coblong, Kota Bandung (Dekat Unpad / Dago)</p>
                        <span class="text-xs font-semibold text-slate-800 block mt-2">Telepon: (022) 2509876</span>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-5 bg-slate-900 text-white rounded-3xl p-6 sm:p-8">
                <span class="text-xs font-bold text-sky-400 uppercase tracking-wider block mb-2">BANTUAN PELANGGAN</span>
                <h3 class="text-xl font-bold mb-2">Informasi & Reservasi WhatsApp</h3>
                <p class="text-xs text-slate-300 mb-6 leading-relaxed">
                    Petugas operasional siap melayani pemesanan tiket, pertanyaan seputar rute, dan koordinasi penjemputan.
                </p>

                <a href="https://wa.me/{{ $waNumber }}?text={{ urlencode('Halo Rivian Travel, saya ingin pesan tiket travel Ciamis Bandung.') }}" target="_blank" class="block text-center py-3 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white font-bold text-xs sm:text-sm transition shadow-xs">
                    Hubungi WhatsApp (+{{ $waNumber }})
                </a>
            </div>
        </div>
    </section>

    <!-- FOOTER -->
    <footer class="bg-slate-950 text-slate-400 py-10 px-4 border-t border-slate-900 text-xs">
        <div class="max-w-7xl mx-auto flex flex-col md:flex-row items-center justify-between gap-4">
            <div>
                <span class="font-bold text-white text-sm">Rivian Travel</span>
                <span class="text-slate-500 ml-2">• Shuttle Daihatsu Xenia Ciamis - Bandung</span>
            </div>

            <p class="text-slate-500 text-center md:text-left">
                &copy; {{ date('Y') }} Rivian Travel. All rights reserved.
            </p>

            <div class="flex items-center gap-4 text-slate-400">
                <a href="#booking-cepat" class="hover:text-white transition">Booking Cepat</a>
                <a href="#jadwal" class="hover:text-white transition">Jadwal</a>
                <a href="#charter" class="hover:text-white transition">Sewa Xenia</a>
                <a href="#kontak" class="hover:text-white transition">Kontak</a>
            </div>
        </div>
    </footer>

    <!-- STICKY MOBILE ACTION BAR -->
    <div class="fixed bottom-0 inset-x-0 bg-white/95 backdrop-blur-md border-t border-slate-200 py-2.5 px-4 z-40 md:hidden flex items-center gap-3 shadow-lg">
        <a href="#booking-cepat" class="flex-1 py-2.5 rounded-xl bg-slate-900 text-white text-xs font-bold text-center transition active:scale-95 shadow-xs">
            Pesan Kursi (Rp 190rb)
        </a>
        <a href="https://wa.me/{{ $waNumber }}?text={{ urlencode('Halo Rivian Travel, saya ingin informasi tiket travel Ciamis Bandung.') }}" target="_blank" class="flex-1 py-2.5 rounded-xl bg-emerald-600 text-white text-xs font-bold text-center transition active:scale-95 shadow-xs">
            Chat WhatsApp
        </a>
    </div>

    <!-- BOOKING MODAL (FOR DETAILED / SCHEDULE CLICKS) -->
    <div id="bookingModal" class="fixed inset-0 z-50 hidden bg-slate-900/60 backdrop-blur-xs flex items-center justify-center p-4 overflow-y-auto">
        <div class="bg-white rounded-3xl max-w-lg w-full p-6 sm:p-7 shadow-2xl relative my-8 animate-in fade-in zoom-in-95 duration-150">
            <button type="button" onclick="closeBookingModal()" class="absolute top-5 right-5 text-slate-400 hover:text-slate-600 text-sm font-bold">
                ✕ Tutup
            </button>

            <div class="mb-5">
                <span id="modalTypeBadge" class="inline-block px-2.5 py-0.5 rounded-md text-[10px] font-bold uppercase bg-slate-100 text-slate-700 mb-1.5">Reguler Shuttle</span>
                <h3 id="modalTitle" class="text-lg sm:text-xl font-bold text-slate-900">Form Pemesanan Tiket</h3>
                <p id="modalSubtitle" class="text-xs text-slate-500 mt-0.5">Ciamis &rarr; Bandung</p>
            </div>

            <form id="bookingForm" onsubmit="submitBooking(event)" class="space-y-3.5 text-xs font-medium text-slate-700">
                @csrf
                <input type="hidden" name="booking_type" id="inputBookingType" value="reguler">
                <input type="hidden" name="schedule_id" id="inputScheduleId" value="">

                <div>
                    <label class="block font-bold text-slate-800 mb-1">Nama Pemesan / Penumpang *</label>
                    <input type="text" name="name" required placeholder="Nama lengkap" class="w-full px-3.5 py-2 rounded-xl border border-slate-200 bg-slate-50 focus:outline-none focus:ring-2 focus:ring-travel-600 text-xs font-semibold">
                </div>

                <div>
                    <label class="block font-bold text-slate-800 mb-1">Nomor WhatsApp Aktif *</label>
                    <input type="tel" name="phone" required placeholder="08xxxxxxxxxx" class="w-full px-3.5 py-2 rounded-xl border border-slate-200 bg-slate-50 focus:outline-none focus:ring-2 focus:ring-travel-600 text-xs font-semibold">
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block font-bold text-slate-800 mb-1">Jumlah Orang / Kursi</label>
                        <select name="total_passengers" id="inputPassengers" onchange="recalculatePrice()" class="w-full px-3.5 py-2 rounded-xl border border-slate-200 bg-slate-50 focus:outline-none focus:ring-2 focus:ring-travel-600 text-xs font-semibold">
                            <option value="1">1 Orang</option>
                            <option value="2">2 Orang</option>
                            <option value="3">3 Orang</option>
                            <option value="4" selected>4 Orang (Pasti Langsung Berangkat)</option>
                            <option value="5">5 Orang (Full 1 Xenia)</option>
                        </select>
                        <p id="modalQuotaNote" class="text-[10px] text-emerald-600 font-medium mt-1">Pasti langsung berangkat tanpa menunggu penumpang lain.</p>
                    </div>

                    <div id="charterDaysField" class="hidden">
                        <label class="block font-bold text-slate-800 mb-1">Durasi Sewa (Hari)</label>
                        <select name="duration_days" id="inputDurationDays" onchange="recalculatePrice()" class="w-full px-3.5 py-2 rounded-xl border border-slate-200 bg-slate-50 focus:outline-none focus:ring-2 focus:ring-travel-600 text-xs font-semibold">
                            <option value="1">1 Hari Penuh</option>
                            <option value="2">2 Hari</option>
                            <option value="3">3 Hari</option>
                        </select>
                    </div>
                </div>

                <div id="charterDateField" class="hidden">
                    <label class="block font-bold text-slate-800 mb-1">Tanggal Mulai Sewa</label>
                    <input type="date" name="charter_date" min="{{ date('Y-m-d') }}" value="{{ date('Y-m-d') }}" class="w-full px-3.5 py-2 rounded-xl border border-slate-200 bg-slate-50 focus:outline-none focus:ring-2 focus:ring-travel-600 text-xs font-semibold">
                </div>

                <div>
                    <label class="block font-bold text-slate-800 mb-1">Alamat Penjemputan</label>
                    <input type="text" name="pickup_address" placeholder="Contoh: Jl. Sudirman No 12, atau Pool Ciamis" class="w-full px-3.5 py-2 rounded-xl border border-slate-200 bg-slate-50 focus:outline-none focus:ring-2 focus:ring-travel-600 text-xs font-semibold">
                </div>

                <div>
                    <label class="block font-bold text-slate-800 mb-1">Alamat Pengantaran</label>
                    <input type="text" name="dropoff_address" placeholder="Contoh: Dipatiukur, Pasteur, atau Alamat Rumah di Bandung" class="w-full px-3.5 py-2 rounded-xl border border-slate-200 bg-slate-50 focus:outline-none focus:ring-2 focus:ring-travel-600 text-xs font-semibold">
                </div>

                <div id="charterNoteField" class="hidden">
                    <label class="block font-bold text-slate-800 mb-1">Catatan Tujuan / Wisata</label>
                    <textarea name="destination_note" rows="2" placeholder="Contoh: Wisata Pantai Pangandaran seharian" class="w-full px-3.5 py-2 rounded-xl border border-slate-200 bg-slate-50 focus:outline-none focus:ring-2 focus:ring-travel-600 text-xs font-semibold"></textarea>
                </div>

                <!-- Price Summary Box -->
                <div class="bg-slate-50 rounded-2xl p-4 border border-slate-200 flex items-center justify-between">
                    <div>
                        <span class="text-slate-500 text-[11px] block">Estimasi Total:</span>
                        <span id="displayTotalPrice" class="text-lg font-black text-slate-900">Rp 190.000</span>
                    </div>
                    <span class="text-[10px] text-slate-400">Bayar via Transfer / Tunai</span>
                </div>

                <button type="submit" id="btnSubmitBooking" class="w-full py-3 rounded-xl bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs sm:text-sm transition active:scale-95 shadow-xs">
                    Konfirmasi Pemesanan
                </button>
            </form>
        </div>
    </div>

    <!-- PAYMENT MODAL (FORM PEMBAYARAN & DYNAMIC QRIS) -->
    <div id="paymentModal" class="fixed inset-0 z-50 hidden bg-slate-950/80 backdrop-blur-sm flex items-center justify-center p-3 sm:p-4 overflow-y-auto">
        <div class="bg-white rounded-3xl max-w-lg w-full p-5 sm:p-7 shadow-2xl relative my-6 border border-slate-200">
            <!-- Close Button -->
            <button type="button" onclick="closePaymentModal()" class="absolute top-4 right-4 text-slate-400 hover:text-slate-600 w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center text-xs font-bold transition">
                ✕
            </button>

            <!-- Status Header -->
            <div class="text-center mb-5">
                <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-amber-50 text-amber-700 text-[11px] font-bold border border-amber-200 mb-2">
                    <span class="w-2 h-2 rounded-full bg-amber-500 animate-pulse"></span>
                    <span>Menunggu Pembayaran</span>
                </div>
                <h3 class="text-xl font-extrabold text-slate-900 tracking-tight">Form Pembayaran Tiket</h3>
                <p class="text-xs text-slate-500 mt-0.5">Selesaikan pembayaran untuk konfirmasi kursi & jadwal Anda</p>
            </div>

            <!-- Booking Code & Amount Card -->
            <div class="bg-gradient-to-br from-slate-900 to-slate-800 text-white rounded-2xl p-4 mb-4 shadow-sm">
                <div class="flex items-center justify-between border-b border-slate-700/80 pb-2.5 mb-2.5">
                    <div>
                        <span class="text-[10px] text-slate-400 font-semibold uppercase tracking-wider block">Kode Booking</span>
                        <div class="flex items-center gap-2">
                            <span id="payBookingCode" class="text-base font-black text-amber-400 font-mono tracking-wider">TRV-XXXXXXXX</span>
                            <button type="button" onclick="copyBookingCode()" class="text-[10px] bg-white/10 hover:bg-white/20 px-2 py-0.5 rounded text-slate-200 transition">
                                Salin
                            </button>
                        </div>
                    </div>
                    <div class="text-right">
                        <span class="text-[10px] text-slate-400 font-semibold uppercase tracking-wider block">Total Tagihan</span>
                        <span id="payTotalAmount" class="text-lg font-black text-emerald-400">Rp 0</span>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-2 text-[11px] text-slate-300">
                    <div>
                        <span class="text-slate-400 text-[10px] block">Pemesan:</span>
                        <strong id="payCustomerName" class="text-white font-medium">-</strong>
                    </div>
                    <div>
                        <span class="text-slate-400 text-[10px] block">Rombongan / Kursi:</span>
                        <strong id="payPassengerCount" class="text-white font-medium">-</strong>
                    </div>
                </div>
            </div>

            <!-- QRIS Dynamic Section -->
            <div class="bg-slate-50 rounded-2xl p-4 border border-slate-200 mb-4 text-center">
                <div class="flex items-center justify-between mb-3 px-1">
                    <span class="text-xs font-bold text-slate-800 flex items-center gap-1.5">
                        <span class="w-2 h-2 rounded-full bg-rose-500"></span>
                        QRIS Dinamis (GPN)
                    </span>
                    <span class="text-[10px] text-slate-500 font-medium">
                        Batas Waktu: <strong id="payCountdown" class="text-rose-600 font-mono font-bold">15:00</strong>
                    </span>
                </div>

                <!-- QR Container Box -->
                <div class="bg-white p-3.5 rounded-2xl border border-slate-200/90 inline-block shadow-inner mb-3">
                    <div id="qrisContainer" class="flex flex-col items-center justify-center min-w-[210px] min-h-[210px]">
                        <!-- Dynamic QR rendered here via JS -->
                        <div id="qrisSpinner" class="text-slate-400 text-xs py-10 flex flex-col items-center gap-2">
                            <span class="w-5 h-5 border-2 border-slate-300 border-t-slate-800 rounded-full animate-spin"></span>
                            <span>Memproses QRIS Dinamis...</span>
                        </div>
                    </div>
                </div>

                <!-- QR Notice / Status Helper -->
                <div id="qrisNoticeBox" class="text-[11px] text-slate-600 leading-relaxed px-2">
                    Scan kode QRIS di atas menggunakan <strong>BCA Mobile, Mandiri Livin, BRImo, Dana, GoPay, OVO, ShopeePay</strong>, atau bank apa saja.
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="space-y-2">
                <button type="button" id="btnPayWhatsApp" onclick="confirmPaymentWhatsApp()" class="w-full py-3 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs sm:text-sm flex items-center justify-center gap-2 transition active:scale-95 shadow-xs">
                    <span>Konfirmasi Pembayaran ke CS WhatsApp</span>
                </button>

                <div class="grid grid-cols-2 gap-2">
                    <button type="button" onclick="checkPaymentStatusBtn()" id="btnCheckStatus" class="py-2.5 rounded-xl bg-slate-900 hover:bg-slate-800 text-white font-semibold text-xs transition">
                        Cek Status Lunas
                    </button>
                    <button type="button" onclick="closePaymentModal()" class="py-2.5 rounded-xl border border-slate-200 hover:bg-slate-100 text-slate-700 font-semibold text-xs transition">
                        Tutup
                    </button>
                </div>
            </div>

            <p class="text-[10px] text-center text-slate-400 mt-3">
                Pembayaran Anda diproses aman & instan oleh sistem Rivian Travel.
            </p>
        </div>
    </div>

    <!-- SCRIPT LOGIC -->
    <script>
        let currentUnitPrice = 190000;
        let currentBookingType = 'reguler';
        let currentHeroRoute = 1; // 1 = Ciamis -> Bandung, 2 = Bandung -> Ciamis
        let activeBookingData = null;
        let countdownInterval = null;

        function updateHeroRoute(val) {
            currentHeroRoute = val;
        }

        function recalcHeroTotal() {
            const qty = parseInt(document.getElementById('heroPassengers').value) || 1;
            const total = 190000 * qty;
            document.getElementById('heroTotalDisplay').textContent = 'Rp ' + total.toLocaleString('id-ID');

            const badge = document.getElementById('heroQuotaBadge');
            const text = document.getElementById('heroQuotaText');

            if (qty >= 4) {
                badge.className = 'p-2.5 rounded-xl bg-emerald-50 border border-emerald-200 text-[11px] text-emerald-900 font-semibold flex items-center gap-2';
                text.textContent = 'Pasti Langsung Berangkat! Khusus rombongan/Anda sendiri tanpa menunggu penumpang lain.';
            } else {
                badge.className = 'p-2.5 rounded-xl bg-amber-50 border border-amber-200 text-[11px] text-amber-900 font-medium flex items-center gap-2';
                text.textContent = `Pemesanan ${qty} kursi akan digabung dengan penumpang lain (minimal 4 orang untuk jadwal jalan), atau pilih 4 kursi agar armada langsung diberangkatkan.`;
            }
        }

        async function submitHeroBooking(event) {
            event.preventDefault();
            const btn = document.getElementById('btnHeroSubmit');
            btn.disabled = true;
            btn.textContent = 'Memproses Booking & QRIS...';

            const name = document.getElementById('heroName').value;
            const phone = document.getElementById('heroPhone').value;
            const date = document.getElementById('heroDate').value;
            const time = document.getElementById('heroTime').value;
            const qty = document.getElementById('heroPassengers').value;
            const pickup = document.getElementById('heroPickup').value || '-';

            const routeText = currentHeroRoute == 1 ? 'Ciamis ke Bandung' : 'Bandung ke Ciamis';

            const formData = new FormData();
            formData.append('_token', '{{ csrf_token() }}');
            formData.append('booking_type', 'reguler');
            formData.append('name', name);
            formData.append('phone', phone);
            formData.append('total_passengers', qty);
            formData.append('pickup_address', pickup);
            formData.append('notes', 'Booking via Quick Form: ' + routeText + ' | ' + date + ' ' + time);

            try {
                const response = await fetch('{{ route("travell.book") }}', {
                    method: 'POST'
                    , headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                        , 'Accept': 'application/json'
                    }
                    , body: formData
                });

                const result = await response.json();

                if (result.success) {
                    const bookingData = result.data;
                    bookingData.routeText = routeText;
                    bookingData.travelDate = date;
                    bookingData.travelTime = time;
                    openPaymentModal(bookingData);
                } else {
                    alert('Gagal memproses pemesanan: ' + (result.message || 'Silakan coba lagi.'));
                }
            } catch (error) {
                alert('Terjadi kendala jaringan. Silakan hubungi CS melalui WhatsApp.');
            } finally {
                btn.disabled = false;
                btn.textContent = 'Pesan Kursi Sekarang (Konfirmasi Instan)';
            }
        }

        function openBookingModal(type, scheduleId, origin, destination, time, price, date) {
            currentBookingType = type;
            currentUnitPrice = price || 190000;

            document.getElementById('inputBookingType').value = type;
            document.getElementById('inputScheduleId').value = scheduleId || '';

            const badge = document.getElementById('modalTypeBadge');
            const title = document.getElementById('modalTitle');
            const subtitle = document.getElementById('modalSubtitle');
            const charterDays = document.getElementById('charterDaysField');
            const charterDate = document.getElementById('charterDateField');
            const charterNote = document.getElementById('charterNoteField');

            if (type === 'charter') {
                badge.textContent = 'Sewa Xenia + Sopir';
                title.textContent = 'Sewa Mobil Xenia + Sopir (Charter)';
                subtitle.textContent = 'Paket All-In Armada & Jasa Sopir';
                charterDays.classList.remove('hidden');
                charterDate.classList.remove('hidden');
                charterNote.classList.remove('hidden');
            } else {
                badge.textContent = 'Shuttle Xenia';
                title.textContent = 'Pesan Tiket: ' + origin + ' \u2192 ' + destination;
                subtitle.textContent = 'Jadwal: ' + time + ' (' + date + ')';
                charterDays.classList.add('hidden');
                charterDate.classList.add('hidden');
                charterNote.classList.add('hidden');
            }

            recalculatePrice();
            document.getElementById('bookingModal').classList.remove('hidden');
        }

        function closeBookingModal() {
            document.getElementById('bookingModal').classList.add('hidden');
        }

        function recalculatePrice() {
            let total = 0;
            const quotaNote = document.getElementById('modalQuotaNote');
            if (currentBookingType === 'reguler') {
                const qty = parseInt(document.getElementById('inputPassengers').value) || 1;
                total = currentUnitPrice * qty;
                if (quotaNote) {
                    if (qty >= 4) {
                        quotaNote.className = 'text-[10px] text-emerald-600 font-semibold mt-1';
                        quotaNote.textContent = 'Pasti langsung berangkat tanpa menunggu penumpang lain.';
                    } else {
                        quotaNote.className = 'text-[10px] text-amber-600 font-normal mt-1';
                        quotaNote.textContent = 'Menunggu kuota minimal 4 orang, atau pesan 4 kursi agar langsung jalan.';
                    }
                }
            } else {
                const days = parseInt(document.getElementById('inputDurationDays').value) || 1;
                total = currentUnitPrice * days;
                if (quotaNote) {
                    quotaNote.textContent = '';
                }
            }

            document.getElementById('displayTotalPrice').textContent = 'Rp ' + total.toLocaleString('id-ID');
        }

        async function submitBooking(event) {
            event.preventDefault();
            const btn = document.getElementById('btnSubmitBooking');
            btn.disabled = true;
            btn.textContent = 'Memproses Pemesanan & QRIS...';

            const form = document.getElementById('bookingForm');
            const formData = new FormData(form);

            try {
                const response = await fetch('{{ route("travell.book") }}', {
                    method: 'POST'
                    , headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                        , 'Accept': 'application/json'
                    }
                    , body: formData
                });

                const result = await response.json();

                if (result.success) {
                    closeBookingModal();
                    const bookingData = result.data;
                    bookingData.routeText = 'Shuttle Ciamis - Bandung';
                    openPaymentModal(bookingData);
                } else {
                    alert('Gagal memproses pemesanan: ' + (result.message || 'Silakan coba lagi.'));
                }
            } catch (error) {
                alert('Terjadi kendala jaringan. Silakan hubungi CS melalui WhatsApp.');
            } finally {
                btn.disabled = false;
                btn.textContent = 'Konfirmasi Pemesanan';
            }
        }

        /* =================== PAYMENT MODAL & QRIS HANDLERS =================== */

        function openPaymentModal(data) {
            activeBookingData = data;

            document.getElementById('payBookingCode').textContent = data.booking_code || 'TRV-XXXXXX';
            document.getElementById('payTotalAmount').textContent = data.formatted_amount || ('Rp ' + (data.total_amount || 0).toLocaleString('id-ID'));
            document.getElementById('payCustomerName').textContent = data.customer_name || '-';

            const passCount = data.total_passengers || 1;
            document.getElementById('payPassengerCount').textContent = passCount + ' Kursi' + (passCount >= 4 ? ' (Pasti Langsung Berangkat)' : '');

            // Render Dynamic QRIS or Fallback
            renderQris(data);

            // Start 15-Minute Countdown Timer
            startPaymentCountdown(15 * 60);

            // Display Modal
            document.getElementById('paymentModal').classList.remove('hidden');
        }

        function closePaymentModal() {
            if (countdownInterval) clearInterval(countdownInterval);
            document.getElementById('paymentModal').classList.add('hidden');
        }

        function copyBookingCode() {
            const code = document.getElementById('payBookingCode').textContent;
            navigator.clipboard.writeText(code).then(() => {
                alert('Kode booking disalin: ' + code);
            }).catch(() => {
                prompt('Salin kode booking ini:', code);
            });
        }

        function renderQris(data) {
            const container = document.getElementById('qrisContainer');
            const noticeBox = document.getElementById('qrisNoticeBox');
            container.innerHTML = '';

            const qris = data.qris || {};

            // 1. Success from Gateway
            if (qris.success && qris.data) {
                const qrData = qris.data;
                const qrImage = qrData.qr_image || qrData.image_url || qrData.qr_url || qrData.invoice_url;
                const qrString = qrData.qr_string || qrData.qr_content || qrData.qr_code || qrData.raw_qr;

                if (qrImage) {
                    container.innerHTML = `<img src="${qrImage}" alt="QRIS Dinamis" class="w-48 h-48 object-contain rounded-xl" />`;
                } else if (qrString) {
                    renderQrString(container, qrString);
                } else {
                    renderFallbackQr(container, data.booking_code, data.total_amount);
                }

                noticeBox.innerHTML = `Scan QRIS dinamis di atas sebesar <strong>${data.formatted_amount}</strong>. Pembayaran akan terverifikasi otomatis.`;
                return;
            }

            // 2. Pending API Key in .env
            if (qris.status === 'pending_config') {
                renderFallbackQr(container, data.booking_code, data.total_amount);
                noticeBox.innerHTML = `
                    <div class="text-left bg-amber-50 p-2.5 rounded-xl border border-amber-200 text-amber-900 mb-1">
                        <strong class="block text-[11px] font-bold">ℹ️ Gateway QRIS Aktif (Menunggu API Key)</strong>
                        <span class="block text-[10px] mt-0.5">
                            Kunci API dapat disimpan di <code>.env</code> dengan variabel <code>SCALIFY_QRIS_API_KEY</code>.
                        </span>
                    </div>
                    Scan QR simulasi di atas atau transfer manual / konfirmasi ke CS WhatsApp.
                `;
                return;
            }

            // 3. API Error or Other Fallback
            renderFallbackQr(container, data.booking_code, data.total_amount);
            noticeBox.innerHTML = `QRIS dinamis siap diproses. Anda juga dapat konfirmasi pembayaran langsung ke WhatsApp CS kami.`;
        }

        function renderQrString(container, qrString) {
            if (typeof QRCode !== 'undefined') {
                new QRCode(container, {
                    text: qrString
                    , width: 200
                    , height: 200
                    , colorDark: '#0f172a'
                    , colorLight: '#ffffff'
                    , correctLevel: QRCode.CorrectLevel.M
                });
            } else {
                container.innerHTML = `<img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=${encodeURIComponent(qrString)}" alt="QRIS Dinamis" class="w-48 h-48 object-contain rounded-xl" />`;
            }
        }

        function renderFallbackQr(container, bookingCode, amount) {
            const simulatedPayload = `00020101021226500014ID.DANA.WWW01189360091800000000000208${bookingCode}520454995303360540${amount || 190000}5802ID5913RIVIAN TRAVEL6006CIAMIS6304`;
            renderQrString(container, simulatedPayload);
        }

        function startPaymentCountdown(durationSeconds) {
            if (countdownInterval) clearInterval(countdownInterval);
            let timer = durationSeconds;
            const display = document.getElementById('payCountdown');

            function updateTimer() {
                const minutes = Math.floor(timer / 60);
                const seconds = timer % 60;
                display.textContent = `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
                if (--timer < 0) {
                    clearInterval(countdownInterval);
                    display.textContent = 'Kedaluwarsa';
                    display.className = 'text-red-700 font-mono font-bold';
                }
            }

            updateTimer();
            countdownInterval = setInterval(updateTimer, 1000);
        }

        function confirmPaymentWhatsApp() {
            if (!activeBookingData) return;
            const code = activeBookingData.booking_code || '-';
            const name = activeBookingData.customer_name || '-';
            const amount = activeBookingData.formatted_amount || 'Rp ' + (activeBookingData.total_amount || 0).toLocaleString('id-ID');
            const route = activeBookingData.routeText || 'Ciamis - Bandung';
            const passCount = activeBookingData.total_passengers || 1;

            const text = `Halo Rivian Travel, saya sudah melakukan pemesanan dan ingin konfirmasi pembayaran.\n\n` +
                `*Kode Booking:* ${code}\n` +
                `*Nama:* ${name}\n` +
                `*Rute:* ${route}\n` +
                `*Jumlah:* ${passCount} Kursi\n` +
                `*Total Tagihan:* ${amount}\n` +
                `*Metode:* QRIS Dinamis\n\n` +
                `Mohon diverifikasi pembayaran saya. Terima kasih!`;

            window.open('https://wa.me/{{ $waNumber }}?text=' + encodeURIComponent(text), '_blank');
        }

        async function checkPaymentStatusBtn() {
            if (!activeBookingData || !activeBookingData.booking_code) return;
            const btn = document.getElementById('btnCheckStatus');
            btn.disabled = true;
            btn.textContent = 'Memeriksa...';

            try {
                const response = await fetch('/travell/status/' + encodeURIComponent(activeBookingData.booking_code), {
                    headers: {
                        'Accept': 'application/json'
                    }
                });
                const result = await response.json();

                if (result.success && result.payment_status === 'paid') {
                    alert('Pembayaran BERHASIL terverifikasi! Tiket Anda telah lunas.');
                    closePaymentModal();
                } else {
                    alert('Status: Menunggu Pembayaran.\n\nJika sudah melakukan scan/transfer, mohon tunggu verifikasi 1-2 menit atau klik tombol WhatsApp untuk konfirmasi instan.');
                }
            } catch (e) {
                alert('Belum dapat memeriksa status otomatis. Silakan konfirmasi via WhatsApp.');
            } finally {
                btn.disabled = false;
                btn.textContent = 'Cek Status Lunas';
            }
        }

    </script>
</body>
</html>
