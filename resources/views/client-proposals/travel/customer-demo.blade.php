<!DOCTYPE html>
<html lang="id" class="h-full bg-slate-950">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Customer App Demo - {{ $client->brand_name ?? 'SkyKey Travel' }}</title>

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        travel: {
                            50: '#f0f9ff'
                            , 100: '#e0f2fe'
                            , 200: '#bae6fd'
                            , 300: '#7dd3fc'
                            , 400: '#38bdf8'
                            , 500: '#0ea5e9'
                            , 600: '#0284c7'
                            , 700: '#0369a1'
                            , 800: '#075985'
                            , 900: '#0c4a6e'
                            , dark: '#082f49'
                        }
                    }
                    , fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif']
                    }
                }
            }
        }

    </script>

    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
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

        /* Mobile Frame Styling on Desktop */
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
    $cleanWa = preg_replace('/[^0-9]/', '', $client->wa_number ?? '6281234567890');
    if (str_starts_with($cleanWa, '0')) {
    $cleanWa = '62' . substr($cleanWa, 1);
    }
    $brandName = $client->brand_name ?? 'SkyKey Travel';

    $jsonPath = resource_path('views/client-proposals/travel/data.json');
    if (file_exists($jsonPath)) {
    $travelDatabase = json_decode(file_get_contents($jsonPath), true);
    } else {
    $travelDatabase = [];
    }
    @endphp

    <!-- Top Banner: Demo Mode Indicator & Back to Landing -->
    <header class="w-full max-w-4xl px-4 py-2 hidden md:flex items-center justify-between text-xs text-slate-400 mb-2">
        <div class="flex items-center gap-2">
            <span class="w-2.5 h-2.5 rounded-full bg-sky-400 animate-pulse"></span>
            <span class="font-bold text-white uppercase tracking-wider">Live Demo Customer Mobile Web App</span>
            <span class="text-slate-600">•</span>
            <span>Simulasi Booking Shuttle & QRIS Theme: Sky Blue</span>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('landing.dynamic', $client->slug) }}" class="text-slate-300 hover:text-white flex items-center gap-1.5 font-medium bg-slate-800/90 px-3 py-1.5 rounded-full border border-slate-700 transition">
                <i class="fas fa-arrow-left text-[10px]"></i>
                <span>Kembali ke Landing Page</span>
            </a>
            @if(isset($client->slug))
            <a href="{{ route('proposal.dynamic', $client->slug) }}" class="text-sky-400 hover:text-white flex items-center gap-1.5 font-medium bg-slate-800/90 px-3 py-1.5 rounded-full border border-slate-700 transition">
                <i class="fas fa-file-invoice text-[10px]"></i>
                <span>Proposal Proyek</span>
            </a>
            @endif
        </div>
    </header>

    <!-- Main Mobile Device Screen -->
    <main class="w-full h-full sm:h-auto mobile-device-wrapper bg-slate-50 flex flex-col relative overflow-hidden">

        <!-- Mobile Status Bar (Harmonious Sky Blue Header Bar) -->
        <div class="bg-gradient-to-r from-sky-600 to-sky-500 text-white px-6 pt-3 pb-2 flex items-center justify-between text-[11px] font-semibold shrink-0 z-40 select-none">
            <span id="statusBarClock" class="font-bold">09:41</span>
            <!-- Simulated Dynamic Island / Notch -->
            <div class="w-20 h-3.5 bg-sky-800/40 rounded-full mx-auto hidden sm:block"></div>
            <div class="flex items-center gap-1.5 text-[10px]">
                <i class="fas fa-signal"></i>
                <i class="fas fa-wifi"></i>
                <i class="fas fa-battery-full text-xs"></i>
            </div>
        </div>

        <!-- APP CONTAINER (SCROLLABLE VIEWPORT) -->
        <div id="appViewport" class="flex-1 overflow-y-auto no-scrollbar relative bg-slate-50 flex flex-col pb-20">

            <!-- ================= VIEW 1: HOME (TRAVELOKA SKY BLUE SHUTTLE STYLE) ================= -->
            <section id="viewHome" class="flex-1 flex flex-col">
                <!-- Top Brand Header & Greeting (Vibrant Sky Blue Gradient) -->
                <div class="bg-gradient-to-br from-sky-600 via-sky-500 to-sky-600 text-white px-5 pt-2 pb-7 rounded-b-[2rem] shadow-sm relative overflow-hidden">
                    <div class="flex items-center justify-between mb-3.5">
                        <div class="flex items-center gap-2.5">
                            <div class="w-9 h-9 rounded-xl bg-white/20 backdrop-blur-md text-white flex items-center justify-center text-sm font-bold shadow-inner">
                                <i class="fas fa-van-shuttle"></i>
                            </div>
                            <div>
                                <h2 class="text-[11px] text-sky-100 font-medium leading-tight">Halo, Andi Pratama 👋</h2>
                                <h1 class="text-sm font-extrabold text-white tracking-tight">{{ $brandName }}</h1>
                            </div>
                        </div>
                        <div class="flex items-center gap-2">
                            <button type="button" onclick="switchView('viewHistory')" class="flex items-center gap-1 bg-white/20 backdrop-blur-md border border-white/20 px-2.5 py-1 rounded-full text-[10px] text-amber-200 font-bold whitespace-nowrap">
                                <i class="fas fa-crown text-[9px] text-amber-300"></i>
                                <span id="userPointsHeader">350 Poin</span>
                            </button>
                            <button type="button" onclick="switchView('viewHistory')" class="w-8 h-8 rounded-full bg-white/20 backdrop-blur-md flex items-center justify-center text-white text-xs relative">
                                <i class="far fa-bell"></i>
                                <span class="w-2 h-2 rounded-full bg-rose-400 absolute top-1.5 right-1.5 ring-2 ring-sky-600"></span>
                            </button>
                        </div>
                    </div>

                    <!-- Search Shuttle Card (Embedded in Header) -->
                    <div class="bg-white rounded-2xl p-4 text-slate-800 shadow-xl border border-sky-100">
                        <div class="flex items-center justify-between pb-2 mb-3 border-b border-slate-100">
                            <span class="text-xs font-extrabold text-slate-900 flex items-center gap-1.5 whitespace-nowrap">
                                <i class="fas fa-van-shuttle text-sky-500"></i>
                                <span>Booking Shuttle Travel</span>
                            </span>
                            <span class="text-[9px] bg-emerald-50 text-emerald-700 px-2 py-0.5 rounded-full font-bold whitespace-nowrap">
                                Door to Door
                            </span>
                        </div>

                        <!-- Origin & Destination Selector with Switch Button -->
                        <div class="relative space-y-2 mb-3">
                            <!-- Kota Asal -->
                            <div class="bg-slate-50 border border-slate-200/90 rounded-xl px-3 py-2 flex items-center gap-2.5">
                                <i class="fas fa-circle-dot text-sky-500 text-xs shrink-0"></i>
                                <div class="flex-1 min-w-0">
                                    <label class="block text-[9px] font-bold uppercase tracking-wider text-slate-400">Kota Asal (Jemput)</label>
                                    <select id="homeOrigin" class="w-full bg-transparent text-xs font-bold text-slate-800 focus:outline-none cursor-pointer truncate">
                                        <option value="ciamis" selected>Ciamis (Pool / Rumah)</option>
                                        <option value="kuningan">Kuningan</option>
                                        <option value="tasikmalaya">Tasikmalaya</option>
                                        <option value="bandung">Bandung</option>
                                        <option value="jakarta">Jakarta (Jabodetabek)</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Switch Button -->
                            <button type="button" onclick="swapOriginDestination()" class="absolute right-4 top-1/2 -translate-y-1/2 w-7 h-7 rounded-full bg-sky-500 hover:bg-sky-600 text-white shadow-md flex items-center justify-center text-[10px] z-10 active:rotate-180 transition-transform">
                                <i class="fas fa-arrow-down-up"></i>
                            </button>

                            <!-- Kota Tujuan -->
                            <div class="bg-slate-50 border border-slate-200/90 rounded-xl px-3 py-2 flex items-center gap-2.5">
                                <i class="fas fa-location-dot text-rose-500 text-xs shrink-0"></i>
                                <div class="flex-1 min-w-0">
                                    <label class="block text-[9px] font-bold uppercase tracking-wider text-slate-400">Kota Tujuan (Antar)</label>
                                    <select id="homeDestination" class="w-full bg-transparent text-xs font-bold text-slate-800 focus:outline-none cursor-pointer truncate">
                                        <option value="jakarta" selected>Jakarta (Jabodetabek / Bandara)</option>
                                        <option value="bandung">Bandung (Pasteur / Dipatiukur)</option>
                                        <option value="ciamis">Ciamis</option>
                                        <option value="kuningan">Kuningan</option>
                                        <option value="tasikmalaya">Tasikmalaya</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Date & Shift Row -->
                        <div class="grid grid-cols-2 gap-2 mb-3.5">
                            <div class="bg-slate-50 border border-slate-200/90 rounded-xl px-3 py-2 hover:border-sky-300 transition focus-within:ring-2 focus-within:ring-sky-500 focus-within:bg-white">
                                <label for="homeDate" class="block text-[9px] font-bold uppercase tracking-wider text-slate-400">Tanggal Pergi</label>
                                <div class="flex items-center gap-1.5 mt-0.5">
                                    <i class="far fa-calendar-alt text-sky-500 text-xs shrink-0"></i>
                                    <input type="date" id="homeDate" min="{{ date('Y-m-d') }}" value="{{ date('Y-m-d') }}" class="w-full bg-transparent text-xs font-bold text-slate-800 focus:outline-none cursor-pointer p-0" onchange="handleDateChange(this.value)">
                                </div>
                            </div>
                            <div class="bg-slate-50 border border-slate-200/90 rounded-xl px-3 py-2 hover:border-sky-300 transition focus-within:ring-2 focus-within:ring-sky-500 focus-within:bg-white">
                                <label for="homeShift" class="block text-[9px] font-bold uppercase tracking-wider text-slate-400">Pilihan Shift</label>
                                <select id="homeShift" class="w-full bg-transparent text-xs font-bold text-slate-800 focus:outline-none cursor-pointer mt-0.5 truncate">
                                    <option value="all">Semua Shift</option>
                                    <option value="pagi">Pagi (06:00 - 09:00)</option>
                                    <option value="siang">Siang (12:00 - 14:00)</option>
                                    <option value="malam">Malam (19:00 - 21:30)</option>
                                </select>
                            </div>
                        </div>

                        <!-- Search Button (Vibrant Sky Blue) -->
                        <button type="button" onclick="executeScheduleSearch()" class="w-full py-3 rounded-xl bg-gradient-to-r from-sky-500 to-sky-600 hover:from-sky-600 hover:to-sky-700 active:scale-98 text-white font-bold text-xs shadow-md shadow-sky-500/20 transition-all flex items-center justify-center gap-2 whitespace-nowrap">
                            <i class="fas fa-search text-xs"></i>
                            <span>Cari Jadwal Mobil & Kursi Kosong</span>
                        </button>
                    </div>
                </div>

                <!-- 4 Quick Grid Menus (Clean Traveloka Style) -->
                <div class="px-5 py-4">
                    <div class="grid grid-cols-4 gap-2.5 text-center">
                        <button type="button" onclick="executeScheduleSearch()" class="flex flex-col items-center group">
                            <div class="w-11 h-11 rounded-2xl bg-sky-100 text-sky-600 flex items-center justify-center text-base shadow-xs group-active:scale-95 transition">
                                <i class="fas fa-van-shuttle"></i>
                            </div>
                            <span class="text-[10px] font-bold text-slate-700 mt-1.5 whitespace-nowrap">Shuttle Reguler</span>
                        </button>

                        <button type="button" onclick="openCharterView()" class="flex flex-col items-center group">
                            <div class="w-11 h-11 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center text-base shadow-xs group-active:scale-95 transition">
                                <i class="fas fa-crown"></i>
                            </div>
                            <span class="text-[10px] font-bold text-slate-700 mt-1.5 whitespace-nowrap">Private Charter</span>
                        </button>

                        <button type="button" onclick="openPackageView()" class="flex flex-col items-center group">
                            <div class="w-11 h-11 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-base shadow-xs group-active:scale-95 transition">
                                <i class="fas fa-box-open"></i>
                            </div>
                            <span class="text-[10px] font-bold text-slate-700 mt-1.5 whitespace-nowrap">Titip Paket</span>
                        </button>

                        <button type="button" onclick="switchView('viewHistory')" class="flex flex-col items-center group">
                            <div class="w-11 h-11 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center text-base shadow-xs group-active:scale-95 transition">
                                <i class="fas fa-receipt"></i>
                            </div>
                            <span class="text-[10px] font-bold text-slate-700 mt-1.5 whitespace-nowrap">Tiket Saya</span>
                        </button>
                    </div>
                </div>

                <!-- Promo & Benefits Highlights Banner -->
                <div class="px-5 mb-4">
                    <div class="bg-gradient-to-r from-sky-500 via-sky-600 to-blue-600 rounded-2xl p-3.5 text-white shadow-sm flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-xl bg-white/20 backdrop-blur-sm flex items-center justify-center text-lg shrink-0">
                                <i class="fas fa-utensils"></i>
                            </div>
                            <div>
                                <span class="bg-white/25 text-[8px] font-extrabold uppercase px-2 py-0.5 rounded-full whitespace-nowrap">Gratis Paket Makan</span>
                                <h4 class="text-xs font-bold mt-0.5 leading-tight">Prasmanan Rest Area Tol</h4>
                                <p class="text-[9px] text-sky-100">Termasuk di setiap pemesanan tiket shuttle</p>
                            </div>
                        </div>
                        <i class="fas fa-chevron-right text-xs opacity-75 shrink-0"></i>
                    </div>
                </div>

                <!-- Popular Routes Quick Access -->
                <div class="px-5 mb-6">
                    <div class="flex items-center justify-between mb-2.5">
                        <h3 class="text-xs font-bold text-slate-900">Rute Populer Hari Ini</h3>
                        <button type="button" onclick="executeScheduleSearch()" class="text-[10px] font-bold text-sky-600 hover:text-sky-700">Lihat Semua</button>
                    </div>
                    <div class="space-y-2">
                        <!-- Quick Card 1 -->
                        <div onclick="quickSearchRoute('ciamis', 'jakarta')" class="bg-white rounded-xl p-3 border border-slate-200/80 shadow-xs flex items-center justify-between cursor-pointer hover:border-sky-300 active:bg-sky-50/50 transition">
                            <div class="flex items-center gap-2.5 min-w-0">
                                <div class="w-8 h-8 rounded-lg bg-sky-50 text-sky-600 flex items-center justify-center text-xs shrink-0">
                                    <i class="fas fa-route"></i>
                                </div>
                                <div class="min-w-0">
                                    <p class="text-xs font-bold text-slate-900 truncate">Ciamis ➔ Jakarta (PP)</p>
                                    <p class="text-[10px] text-slate-500 truncate">Isuzu Elf Long • 07:00 & 19:00 WIB</p>
                                </div>
                            </div>
                            <div class="text-right shrink-0 pl-2">
                                <p class="text-xs font-extrabold text-sky-600">Rp 220.000</p>
                                <span class="text-[9px] text-emerald-600 font-bold bg-emerald-50 px-1.5 py-0.5 rounded whitespace-nowrap">Sisa 4 Kursi</span>
                            </div>
                        </div>

                        <!-- Quick Card 2 -->
                        <div onclick="quickSearchRoute('kuningan', 'bandung')" class="bg-white rounded-xl p-3 border border-slate-200/80 shadow-xs flex items-center justify-between cursor-pointer hover:border-sky-300 active:bg-sky-50/50 transition">
                            <div class="flex items-center gap-2.5 min-w-0">
                                <div class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center text-xs shrink-0">
                                    <i class="fas fa-route"></i>
                                </div>
                                <div class="min-w-0">
                                    <p class="text-xs font-bold text-slate-900 truncate">Kuningan ➔ Bandung (PP)</p>
                                    <p class="text-[10px] text-slate-500 truncate">HiAce Premio Luxury • 06:30 WIB</p>
                                </div>
                            </div>
                            <div class="text-right shrink-0 pl-2">
                                <p class="text-xs font-extrabold text-sky-600">Rp 150.000</p>
                                <span class="text-[9px] text-amber-700 font-bold bg-amber-50 px-1.5 py-0.5 rounded whitespace-nowrap">Sisa 2 Kursi</span>
                            </div>
                        </div>
                    </div>
                </div>
            </section>


            <!-- ================= VIEW 2: SCHEDULE LIST (SKY BLUE THEMED) ================= -->
            <section id="viewSchedules" class="flex-1 hidden flex-col">
                <!-- Top Nav Bar (Clean Sky Blue Gradient) -->
                <div class="bg-gradient-to-r from-sky-600 to-sky-500 text-white px-4 py-2.5 sticky top-0 z-30 flex items-center gap-2.5 shadow-sm">
                    <button type="button" onclick="switchView('viewHome')" class="w-7 h-7 rounded-full bg-white/20 backdrop-blur-md flex items-center justify-center text-white text-xs shrink-0 active:scale-95">
                        <i class="fas fa-arrow-left"></i>
                    </button>
                    <div class="flex-1 min-w-0">
                        <h3 class="text-xs font-extrabold text-white truncate" id="schedulesRouteTitle">
                            Ciamis ➔ Jakarta
                        </h3>
                        <p class="text-[10px] text-sky-100 truncate" id="schedulesSubtitle">Hari Ini • 1 Penumpang</p>
                    </div>
                    <button type="button" onclick="switchView('viewHome')" class="text-[10px] font-bold bg-white/20 hover:bg-white/30 text-white px-2.5 py-1 rounded-full whitespace-nowrap shrink-0">
                        Ubah Rute
                    </button>
                </div>

                <!-- Shift Filters: COMPACT, SINGLE-LINE & NO WRAPPING -->
                <div class="px-3 py-2 bg-white border-b border-slate-100 flex items-center gap-1.5 overflow-x-auto no-scrollbar">
                    <button type="button" onclick="filterScheduleShift('all')" class="shift-btn px-3 py-1.5 rounded-full text-[11px] font-bold bg-sky-500 text-white shadow-xs whitespace-nowrap shrink-0 transition" data-shift="all">Semua</button>
                    <button type="button" onclick="filterScheduleShift('pagi')" class="shift-btn px-3 py-1.5 rounded-full text-[11px] font-bold bg-slate-100 text-slate-700 hover:bg-sky-50 hover:text-sky-700 whitespace-nowrap shrink-0 transition" data-shift="pagi">Pagi (06.00)</button>
                    <button type="button" onclick="filterScheduleShift('siang')" class="shift-btn px-3 py-1.5 rounded-full text-[11px] font-bold bg-slate-100 text-slate-700 hover:bg-sky-50 hover:text-sky-700 whitespace-nowrap shrink-0 transition" data-shift="siang">Siang (12.00)</button>
                    <button type="button" onclick="filterScheduleShift('malam')" class="shift-btn px-3 py-1.5 rounded-full text-[11px] font-bold bg-slate-100 text-slate-700 hover:bg-sky-50 hover:text-sky-700 whitespace-nowrap shrink-0 transition" data-shift="malam">Malam (19.00)</button>
                </div>

                <!-- Schedules List Container -->
                <div class="p-3.5 space-y-3" id="schedulesListContainer">
                    <!-- Populated dynamically via JS -->
                </div>
            </section>


            <!-- ================= VIEW 3: SEAT PICKER (MULTI-SEAT SELECTION) ================= -->
            <section id="viewSeatPicker" class="flex-1 hidden flex-col bg-slate-50">
                <!-- Top Nav Bar (Sky Blue) -->
                <div class="bg-gradient-to-r from-sky-600 to-sky-500 text-white px-4 py-2.5 sticky top-0 z-30 flex items-center gap-2.5 shadow-sm">
                    <button type="button" onclick="switchView('viewSchedules')" class="w-7 h-7 rounded-full bg-white/20 backdrop-blur-md flex items-center justify-center text-white text-xs shrink-0 active:scale-95">
                        <i class="fas fa-arrow-left"></i>
                    </button>
                    <div class="flex-1 min-w-0">
                        <h3 class="text-xs font-extrabold text-white">Pilih Nomor Kursi</h3>
                        <p class="text-[10px] text-sky-100 truncate" id="seatPickerSubtitle">Isuzu Elf Long • Ciamis ➔ Jakarta</p>
                    </div>
                </div>

                <div class="p-3.5 flex-1">
                    <!-- Seat Legends -->
                    <div class="bg-white rounded-2xl p-2.5 border border-slate-200/80 mb-3 flex items-center justify-around text-[10px] font-bold text-slate-700 shadow-xs">
                        <span class="flex items-center gap-1.5 whitespace-nowrap"><span class="w-3.5 h-3.5 rounded-md bg-emerald-100 border border-emerald-400"></span> Kosong</span>
                        <span class="flex items-center gap-1.5 whitespace-nowrap"><span class="w-3.5 h-3.5 rounded-md bg-slate-200 border border-slate-300"></span> Terisi</span>
                        <span class="flex items-center gap-1.5 whitespace-nowrap"><span class="w-3.5 h-3.5 rounded-md bg-sky-500 border border-sky-600"></span> Dipilih</span>
                    </div>

                    <!-- Front / Driver Indicator -->
                    <div class="text-center mb-2.5">
                        <span class="inline-block px-3 py-0.5 rounded-full bg-slate-200 text-slate-600 text-[9px] font-bold uppercase tracking-wider whitespace-nowrap">
                            <i class="fas fa-steering-wheel mr-1"></i> Bagian Depan Mobil
                        </span>
                    </div>

                    <!-- Seat Layout Box -->
                    <div class="bg-white rounded-2xl p-3.5 border border-slate-200/80 max-w-xs mx-auto shadow-xs">
                        <div id="interactiveSeatsGrid" class="grid grid-cols-4 gap-2">
                            <!-- Populated dynamically via JS -->
                        </div>
                    </div>

                    <!-- Tip Notice -->
                    <p class="text-[10px] text-center text-slate-500 mt-3 leading-tight">
                        <i class="fas fa-info-circle text-sky-600 mr-1"></i> Anda dapat memilih <strong>lebih dari 1 kursi</strong> sekaligus.
                    </p>
                </div>

                <!-- Bottom Floating Drawer for Selected Seats & Total -->
                <div class="bg-white border-t border-slate-200 p-3.5 sticky bottom-0 z-30 shadow-[0_-4px_16px_rgba(0,0,0,0.06)]">
                    <div class="flex items-center justify-between mb-2.5">
                        <div class="min-w-0 flex-1 pr-2">
                            <p class="text-[9px] text-slate-400 font-bold uppercase">Kursi Terpilih</p>
                            <p class="text-xs font-bold text-slate-900 truncate" id="selectedSeatsLabel">Belum Ada Kursi</p>
                        </div>
                        <div class="text-right shrink-0">
                            <p class="text-[9px] text-slate-400 font-bold uppercase">Total Biaya</p>
                            <p class="text-sm font-black text-sky-600" id="selectedSeatsTotalPrice">Rp 0</p>
                        </div>
                    </div>
                    <button type="button" id="btnContinueToPassenger" onclick="proceedToPassengerForm()" disabled class="w-full py-3 rounded-xl bg-slate-200 text-slate-400 font-bold text-xs transition flex items-center justify-center gap-2 whitespace-nowrap">
                        <span>Lanjut Isi Data Penumpang</span>
                        <i class="fas fa-arrow-right text-[10px]"></i>
                    </button>
                </div>
            </section>


            <!-- ================= VIEW 4: PASSENGER FORM & ADDRESS ================= -->
            <section id="viewPassengerForm" class="flex-1 hidden flex-col bg-slate-50">
                <!-- Top Nav Bar (Sky Blue) -->
                <div class="bg-gradient-to-r from-sky-600 to-sky-500 text-white px-4 py-2.5 sticky top-0 z-30 flex items-center gap-2.5 shadow-sm">
                    <button type="button" onclick="switchView('viewSeatPicker')" class="w-7 h-7 rounded-full bg-white/20 backdrop-blur-md flex items-center justify-center text-white text-xs shrink-0 active:scale-95">
                        <i class="fas fa-arrow-left"></i>
                    </button>
                    <div class="flex-1 min-w-0">
                        <h3 class="text-xs font-extrabold text-white">Data Penumpang & Alamat</h3>
                        <p class="text-[10px] text-sky-100 truncate">Layanan Door to Door Langsung ke Rumah</p>
                    </div>
                </div>

                <div class="p-3.5 space-y-3 flex-1">
                    <!-- Order Summary Box -->
                    <div class="bg-sky-50 border border-sky-200/80 rounded-2xl p-3 text-slate-800 shadow-xs">
                        <div class="flex items-center justify-between pb-1.5 mb-1.5 border-b border-sky-200/60">
                            <span class="text-xs font-extrabold text-slate-900 truncate" id="formSummaryRoute">Ciamis ➔ Jakarta</span>
                            <span class="text-[9px] font-bold text-sky-700 bg-sky-200/70 px-2 py-0.5 rounded-full whitespace-nowrap shrink-0" id="formSummarySeatsBadge">2 Kursi (K-01, K-02)</span>
                        </div>
                        <p class="text-[10px] text-slate-600 flex items-center gap-1.5 truncate" id="formSummaryFleet">
                            <i class="fas fa-van-shuttle text-sky-600 shrink-0"></i> <span>Isuzu Elf Giga Long (07:00 WIB)</span>
                        </p>
                    </div>

                    <!-- Input Form -->
                    <form id="mobileBookingForm" onsubmit="proceedToPayment(event)" class="space-y-3">
                        <div class="bg-white rounded-2xl p-3.5 border border-slate-200/80 space-y-2.5 shadow-xs">
                            <h4 class="text-xs font-extrabold text-slate-900 border-b border-slate-100 pb-1.5">Kontak Pemesan</h4>

                            <div>
                                <label class="block text-[9px] font-bold text-slate-500 mb-1 uppercase">Nama Lengkap Penumpang</label>
                                <input type="text" id="custName" required placeholder="Contoh: Andi Pratama" value="Andi Pratama" class="w-full h-9 bg-slate-50 border border-slate-200 rounded-xl px-3 text-xs text-slate-900 font-semibold focus:ring-2 focus:ring-sky-500 focus:bg-white focus:outline-none">
                            </div>

                            <div>
                                <label class="block text-[9px] font-bold text-slate-500 mb-1 uppercase">Nomor WhatsApp Aktif</label>
                                <input type="tel" id="custPhone" required placeholder="0812xxxxxxxx" value="081234567890" class="w-full h-9 bg-slate-50 border border-slate-200 rounded-xl px-3 text-xs text-slate-900 font-semibold focus:ring-2 focus:ring-sky-500 focus:bg-white focus:outline-none">
                            </div>
                        </div>

                        <div class="bg-white rounded-2xl p-3.5 border border-slate-200/80 space-y-2.5 shadow-xs">
                            <h4 class="text-xs font-extrabold text-slate-900 border-b border-slate-100 pb-1.5">Titik Antar Jemput (Door to Door)</h4>

                            <div>
                                <label class="block text-[9px] font-bold text-slate-500 mb-1 uppercase">Alamat Penjemputan di Rumah / Kos</label>
                                <textarea id="custPickup" required rows="2" placeholder="Jl. Raya Ciamis No. 12, Kel. Sindangrasa..." class="w-full bg-slate-50 border border-slate-200 rounded-xl p-2 text-xs text-slate-900 font-medium focus:ring-2 focus:ring-sky-500 focus:bg-white focus:outline-none">Jl. RE Martadinata No. 45, Ciamis</textarea>
                            </div>

                            <div>
                                <label class="block text-[9px] font-bold text-slate-500 mb-1 uppercase">Alamat Pengantaran Tujuan</label>
                                <textarea id="custDropoff" required rows="2" placeholder="Jl. Sudirman Kav 10, Jakarta Pusat..." class="w-full bg-slate-50 border border-slate-200 rounded-xl p-2 text-xs text-slate-900 font-medium focus:ring-2 focus:ring-sky-500 focus:bg-white focus:outline-none">Jl. Tebet Raya No. 18, Jakarta Selatan</textarea>
                            </div>
                        </div>

                        <button type="submit" class="w-full py-3 rounded-xl bg-gradient-to-r from-sky-500 to-sky-600 hover:from-sky-600 hover:to-sky-700 text-white font-bold text-xs shadow-md shadow-sky-500/20 transition flex items-center justify-center gap-2 whitespace-nowrap">
                            <span>Lanjut ke Pembayaran QRIS</span>
                            <i class="fas fa-qrcode"></i>
                        </button>
                    </form>
                </div>
            </section>


            <!-- ================= VIEW 5: QRIS PAYMENT SCREEN (SKY BLUE ACCENTS) ================= -->
            <section id="viewPayment" class="flex-1 hidden flex-col bg-slate-50">
                <!-- Top Nav Bar (Sky Blue) -->
                <div class="bg-gradient-to-r from-sky-600 to-sky-500 text-white px-4 py-2.5 sticky top-0 z-30 flex items-center gap-2.5 shadow-sm">
                    <button type="button" onclick="switchView('viewPassengerForm')" class="w-7 h-7 rounded-full bg-white/20 backdrop-blur-md flex items-center justify-center text-white text-xs shrink-0 active:scale-95">
                        <i class="fas fa-arrow-left"></i>
                    </button>
                    <div class="flex-1 min-w-0">
                        <h3 class="text-xs font-extrabold text-white">Pembayaran QRIS Instant</h3>
                        <p class="text-[10px] text-sky-100 truncate">Scan & Bayar Bebas Biaya Admin</p>
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
                        <p class="text-[9px] text-slate-400 uppercase font-bold">NMID: ID102026998812</p>
                        <h4 class="text-xs font-black text-slate-900 mt-0.5 truncate">{{ strtoupper($brandName) }} SHUTTLE</h4>

                        <!-- Total Payment Amount -->
                        <div class="bg-sky-50 rounded-xl p-2.5 my-2.5 border border-sky-100">
                            <p class="text-[9px] text-slate-500 font-bold uppercase">Total Tagihan Tiket</p>
                            <p class="text-base font-black text-sky-600" id="qrisTotalAmount">Rp 440.000</p>
                            <p class="text-[9px] text-slate-500 mt-0.5 truncate" id="qrisDetailText">2 Kursi (K-01, K-02) • Ciamis ➔ Jakarta</p>
                        </div>

                        <!-- Realistic QR Code Graphic -->
                        <div class="relative w-44 h-44 mx-auto p-2 bg-white rounded-2xl border-2 border-slate-900 flex items-center justify-center shadow-inner">
                            <svg class="w-full h-full" viewBox="0 0 100 100" fill="currentColor">
                                <!-- Simulated QR Matrix -->
                                <rect x="5" y="5" width="25" height="25" fill="#0f172a" rx="2"></rect>
                                <rect x="10" y="10" width="15" height="15" fill="#ffffff" rx="1"></rect>
                                <rect x="13" y="13" width="9" height="9" fill="#0f172a" rx="1"></rect>

                                <rect x="70" y="5" width="25" height="25" fill="#0f172a" rx="2"></rect>
                                <rect x="75" y="10" width="15" height="15" fill="#ffffff" rx="1"></rect>
                                <rect x="78" y="13" width="9" height="9" fill="#0f172a" rx="1"></rect>

                                <rect x="5" y="70" width="25" height="25" fill="#0f172a" rx="2"></rect>
                                <rect x="10" y="75" width="15" height="15" fill="#ffffff" rx="1"></rect>
                                <rect x="13" y="78" width="9" height="9" fill="#0f172a" rx="1"></rect>

                                <!-- QR Data Pattern -->
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

                                <!-- Center Badge -->
                                <circle cx="50" cy="50" r="10" fill="#0284c7"></circle>
                                <path d="M46 50 L49 53 L55 47" stroke="#ffffff" stroke-width="2" fill="none"></path>
                            </svg>
                        </div>

                        <!-- Timer Simulation -->
                        <div class="flex items-center justify-center gap-1.5 mt-2.5 text-[10px] text-slate-500 font-bold">
                            <i class="far fa-clock text-amber-500"></i>
                            <span>Batas Bayar: <strong id="qrisCountdown" class="text-slate-900">14:58</strong></span>
                        </div>

                        <!-- Supported Apps -->
                        <p class="text-[8px] text-slate-400 mt-1.5">BCA, Mandiri, BRI, BNI, GoPay, OVO, Dana, ShopeePay</p>
                    </div>

                    <!-- Instant Simulation Button -->
                    <button type="button" onclick="simulatePaymentSuccess()" class="mt-3.5 w-full max-w-xs py-3 rounded-xl bg-emerald-500 hover:bg-emerald-600 text-white font-extrabold text-xs shadow-md shadow-emerald-500/20 transition active:scale-95 flex items-center justify-center gap-2 whitespace-nowrap">
                        <i class="fas fa-bolt"></i>
                        <span>Simulasi Bayar Berhasil (Instant)</span>
                    </button>
                </div>
            </section>


            <!-- ================= VIEW 6: SUCCESS & E-TICKET DETAIL ================= -->
            <section id="viewSuccessTicket" class="flex-1 hidden flex-col bg-slate-50">
                <!-- Top Nav Bar (Sky Blue) -->
                <div class="bg-gradient-to-r from-sky-600 to-sky-500 text-white px-4 py-2.5 flex items-center justify-between shadow-sm">
                    <span class="text-xs font-bold flex items-center gap-1.5">
                        <i class="fas fa-check-circle text-emerald-300"></i> E-Ticket Resmi
                    </span>
                    <button type="button" onclick="switchView('viewHome')" class="text-[10px] bg-white/20 hover:bg-white/30 px-2.5 py-1 rounded-full text-white font-bold whitespace-nowrap">
                        Ke Beranda
                    </button>
                </div>

                <div class="p-3.5 space-y-3.5 flex-1">
                    <!-- Success Header -->
                    <div class="text-center py-1">
                        <div class="w-10 h-10 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center text-lg mx-auto mb-1.5 shadow-xs animate-bounce">
                            <i class="fas fa-check"></i>
                        </div>
                        <h3 class="text-xs font-extrabold text-slate-900">Pembayaran Berhasil!</h3>
                        <p class="text-[10px] text-slate-500 mt-0.5 leading-tight">Tiket shuttle Anda aktif dan tersimpan di sistem.</p>
                    </div>

                    <!-- Luxury E-Ticket Card -->
                    <div class="bg-white rounded-3xl p-4 border border-slate-200/90 shadow-md relative overflow-hidden" id="printableTicketArea">

                        <!-- Ticket Header -->
                        <div class="flex items-center justify-between pb-2.5 mb-2.5 border-b border-slate-100">
                            <div>
                                <span class="text-[8px] font-bold uppercase tracking-wider text-slate-400">Kode Booking</span>
                                <h4 class="text-xs font-black text-slate-900 tracking-wider" id="ticketBookingCode">SKY-882910</h4>
                            </div>
                            <span class="px-2 py-0.5 rounded-full bg-emerald-50 border border-emerald-200 text-emerald-700 text-[9px] font-extrabold whitespace-nowrap">
                                LUNAS • AKTIF
                            </span>
                        </div>

                        <!-- Route & Schedule -->
                        <div class="flex items-center justify-between py-1.5">
                            <div class="text-left">
                                <p class="text-[9px] text-slate-400 font-bold uppercase">Keberangkatan</p>
                                <p class="text-sm font-black text-slate-900" id="ticketDepTime">07:00 WIB</p>
                                <p class="text-[11px] font-bold text-slate-700 truncate" id="ticketOrigin">Ciamis</p>
                            </div>
                            <div class="px-2 text-center shrink-0">
                                <i class="fas fa-van-shuttle text-sky-500 text-xs"></i>
                                <div class="w-12 h-[1.5px] bg-slate-200 my-1"></div>
                                <span class="text-[8px] text-slate-400 font-medium">Via Tol</span>
                            </div>
                            <div class="text-right">
                                <p class="text-[9px] text-slate-400 font-bold uppercase">Estimasi Tiba</p>
                                <p class="text-sm font-black text-slate-900" id="ticketArrTime">13:30 WIB</p>
                                <p class="text-[11px] font-bold text-slate-700 truncate" id="ticketDestination">Jakarta</p>
                            </div>
                        </div>

                        <!-- Detail Grid -->
                        <div class="grid grid-cols-2 gap-2 bg-slate-50 p-2.5 rounded-2xl my-2.5 text-[10px] border border-slate-100">
                            <div>
                                <p class="text-[8px] text-slate-400 font-bold uppercase">Penumpang</p>
                                <p class="font-bold text-slate-900 truncate" id="ticketPassengerName">Andi Pratama</p>
                            </div>
                            <div>
                                <p class="text-[8px] text-slate-400 font-bold uppercase">Nomor Kursi</p>
                                <p class="font-black text-sky-600 truncate" id="ticketSeatsList">K-01, K-02</p>
                            </div>
                            <div>
                                <p class="text-[8px] text-slate-400 font-bold uppercase">Tanggal Berangkat</p>
                                <p class="font-bold text-slate-800 truncate" id="ticketTravelDate">Hari Ini</p>
                            </div>
                            <div>
                                <p class="text-[8px] text-slate-400 font-bold uppercase">Armada Shuttle</p>
                                <p class="font-bold text-slate-800 truncate" id="ticketFleetName">Isuzu Elf Giga Long</p>
                            </div>
                            <div class="col-span-2 pt-1 border-t border-slate-200/60 flex items-center justify-between">
                                <span class="text-[8px] text-slate-400 font-bold uppercase">Total Pembayaran</span>
                                <span class="font-black text-xs text-emerald-700" id="ticketTotalPrice">Rp 440.000</span>
                            </div>
                        </div>

                        <!-- Inclusions Voucher Notice -->
                        <div class="bg-sky-50 rounded-xl p-2 text-[9px] text-sky-900 font-medium border border-sky-100 mb-2.5 flex items-center gap-1.5 leading-tight">
                            <i class="fas fa-utensils text-sky-600 text-xs shrink-0"></i>
                            <span>Tunjukkan tiket ini untuk klaim <strong>Gratis Paket Makan Rest Area Tol</strong>.</span>
                        </div>

                        <!-- Barcode Simulation for Driver Boarding Scan -->
                        <div class="text-center pt-1.5 border-t border-dashed border-slate-200">
                            <div class="font-mono text-base tracking-widest text-slate-800 font-bold py-0.5">
                                ||||||| | ||||| ||| ||||||| | ||
                            </div>
                            <p class="text-[8px] text-slate-400">Tunjukkan barcode ini ke driver saat penjemputan</p>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="space-y-2">
                        <button type="button" onclick="shareTicketToWhatsApp()" class="w-full py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs shadow-xs transition flex items-center justify-center gap-2 whitespace-nowrap">
                            <i class="fab fa-whatsapp text-sm"></i>
                            <span>Kirim Detail Tiket ke WhatsApp</span>
                        </button>
                        <button type="button" onclick="switchView('viewHistory')" class="w-full py-2.5 rounded-xl bg-sky-500 hover:bg-sky-600 text-white font-bold text-xs transition flex items-center justify-center gap-2 whitespace-nowrap">
                            <i class="fas fa-receipt"></i>
                            <span>Buka Riwayat Pesanan Saya</span>
                        </button>
                    </div>
                </div>
            </section>


            <!-- ================= VIEW 7: MY BOOKINGS / ORDER HISTORY ================= -->
            <section id="viewHistory" class="flex-1 hidden flex-col bg-slate-50">
                <!-- Top Nav Bar (Sky Blue) -->
                <div class="bg-gradient-to-r from-sky-600 to-sky-500 text-white px-4 py-2.5 sticky top-0 z-30 flex items-center justify-between shadow-sm">
                    <div class="flex items-center gap-2.5">
                        <button type="button" onclick="switchView('viewHome')" class="w-7 h-7 rounded-full bg-white/20 backdrop-blur-md flex items-center justify-center text-white text-xs shrink-0 active:scale-95">
                            <i class="fas fa-arrow-left"></i>
                        </button>
                        <div>
                            <h3 class="text-xs font-extrabold text-white">Riwayat Pesanan Tiket</h3>
                            <p class="text-[10px] text-sky-100">Daftar E-Ticket Shuttle & Minibus</p>
                        </div>
                    </div>
                    <button type="button" onclick="clearHistoryDemo()" class="text-[9px] font-bold text-white bg-white/20 hover:bg-white/30 px-2 py-1 rounded-full whitespace-nowrap">
                        Reset Demo
                    </button>
                </div>

                <!-- History Filter Tabs -->
                <div class="p-3.5 flex-1">
                    <div class="flex items-center gap-2 mb-3">
                        <span class="px-3 py-1 rounded-full text-[11px] font-bold bg-sky-500 text-white shadow-xs whitespace-nowrap">Semua Tiket</span>
                        <span class="px-3 py-1 rounded-full text-[11px] font-semibold bg-white text-slate-600 border border-slate-200 whitespace-nowrap">Aktif</span>
                    </div>

                    <!-- History Cards Container -->
                    <div id="orderHistoryContainer" class="space-y-2.5">
                        <!-- Populated dynamically via JS from localStorage -->
                    </div>

                    <!-- Empty State for History -->
                    <div id="emptyHistoryAlert" class="hidden text-center py-10 bg-white rounded-2xl border border-dashed border-slate-200 p-5">
                        <div class="w-10 h-10 rounded-full bg-sky-50 text-sky-500 flex items-center justify-center text-base mx-auto mb-2">
                            <i class="fas fa-ticket-alt"></i>
                        </div>
                        <h4 class="text-xs font-bold text-slate-800">Belum Ada Riwayat Tiket</h4>
                        <p class="text-[10px] text-slate-500 mt-0.5">Silakan lakukan simulasi pemesanan shuttle, private charter, atau kirim paket di beranda.</p>
                        <button type="button" onclick="switchView('viewHome')" class="mt-3 px-4 py-2 rounded-xl bg-sky-500 text-white text-xs font-bold">
                            Cari Jadwal Shuttle
                        </button>
                    </div>
                </div>
            </section>


            <!-- ================= VIEW 8: PRIVATE CHARTER (SEWA 1 MOBIL) ================= -->
            <section id="viewCharter" class="flex-1 hidden flex-col bg-slate-50">
                <!-- Top Nav Bar (Sky Blue) -->
                <div class="bg-gradient-to-r from-sky-600 to-sky-500 text-white px-4 py-2.5 sticky top-0 z-30 flex items-center gap-2.5 shadow-sm">
                    <button type="button" onclick="switchView('viewHome')" class="w-7 h-7 rounded-full bg-white/20 backdrop-blur-md flex items-center justify-center text-white text-xs shrink-0 active:scale-95">
                        <i class="fas fa-arrow-left"></i>
                    </button>
                    <div class="flex-1 min-w-0">
                        <h3 class="text-xs font-extrabold text-white">Private Charter Minibus</h3>
                        <p class="text-[10px] text-sky-100 truncate">Sewa 1 Unit Mobil Full Rombongan Door to Door</p>
                    </div>
                </div>

                <div class="p-3.5 space-y-3 flex-1">
                    <form id="charterBookingForm" onsubmit="proceedCharterBooking(event)" class="space-y-3">
                        
                        <!-- 1. Pilihan Armada Charter -->
                        <div class="bg-white rounded-2xl p-3.5 border border-slate-200/80 shadow-xs">
                            <h4 class="text-xs font-extrabold text-slate-900 border-b border-slate-100 pb-2 mb-2.5 flex items-center justify-between">
                                <span>1. Pilih Tipe Armada</span>
                                <span class="text-[9px] text-sky-600 font-bold bg-sky-50 px-2 py-0.5 rounded-full">All-In Driver & BBM</span>
                            </h4>
                            
                            <div class="space-y-2">
                                <!-- Option 1: Elf Long -->
                                <label class="charter-fleet-card flex items-center justify-between p-2.5 rounded-xl border-2 border-sky-500 bg-sky-50/50 cursor-pointer transition">
                                    <div class="flex items-center gap-2.5 min-w-0">
                                        <input type="radio" name="charterFleet" value="elf_long" checked onchange="updateCharterTotal()" class="text-sky-600 focus:ring-sky-500">
                                        <div class="min-w-0">
                                            <p class="text-xs font-extrabold text-slate-900 truncate">Isuzu Elf Giga Long (19 Seat)</p>
                                            <p class="text-[9px] text-slate-500 truncate">Executive AC Double Blower • Audio Karaoke</p>
                                        </div>
                                    </div>
                                    <span class="text-xs font-black text-sky-600 shrink-0">Rp 1.600.000<span class="text-[8px] font-normal text-slate-400">/hari</span></span>
                                </label>

                                <!-- Option 2: HiAce Premio -->
                                <label class="charter-fleet-card flex items-center justify-between p-2.5 rounded-xl border border-slate-200 bg-white cursor-pointer hover:border-sky-300 transition">
                                    <div class="flex items-center gap-2.5 min-w-0">
                                        <input type="radio" name="charterFleet" value="hiace_premio" onchange="updateCharterTotal()" class="text-sky-600 focus:ring-sky-500">
                                        <div class="min-w-0">
                                            <p class="text-xs font-extrabold text-slate-900 truncate">Toyota HiAce Premio Luxury (14 Seat)</p>
                                            <p class="text-[9px] text-slate-500 truncate">Captain Seats • Reclining • Suspensi Nyaman</p>
                                        </div>
                                    </div>
                                    <span class="text-xs font-black text-sky-600 shrink-0">Rp 1.850.000<span class="text-[8px] font-normal text-slate-400">/hari</span></span>
                                </label>

                                <!-- Option 3: Innova Zenix -->
                                <label class="charter-fleet-card flex items-center justify-between p-2.5 rounded-xl border border-slate-200 bg-white cursor-pointer hover:border-sky-300 transition">
                                    <div class="flex items-center gap-2.5 min-w-0">
                                        <input type="radio" name="charterFleet" value="innova_zenix" onchange="updateCharterTotal()" class="text-sky-600 focus:ring-sky-500">
                                        <div class="min-w-0">
                                            <p class="text-xs font-extrabold text-slate-900 truncate">Toyota Innova Zenix VIP (7 Seat)</p>
                                            <p class="text-[9px] text-slate-500 truncate">Family VIP • Premium Comfort</p>
                                        </div>
                                    </div>
                                    <span class="text-xs font-black text-sky-600 shrink-0">Rp 1.100.000<span class="text-[8px] font-normal text-slate-400">/hari</span></span>
                                </label>

                                <!-- Option 4: Avanza -->
                                <label class="charter-fleet-card flex items-center justify-between p-2.5 rounded-xl border border-slate-200 bg-white cursor-pointer hover:border-sky-300 transition">
                                    <div class="flex items-center gap-2.5 min-w-0">
                                        <input type="radio" name="charterFleet" value="avanza_veloz" onchange="updateCharterTotal()" class="text-sky-600 focus:ring-sky-500">
                                        <div class="min-w-0">
                                            <p class="text-xs font-extrabold text-slate-900 truncate">Toyota Avanza / Veloz (6 Seat)</p>
                                            <p class="text-[9px] text-slate-500 truncate">Hemat & Fleksibel untuk Rombongan Kecil</p>
                                        </div>
                                    </div>
                                    <span class="text-xs font-black text-sky-600 shrink-0">Rp 750.000<span class="text-[8px] font-normal text-slate-400">/hari</span></span>
                                </label>
                            </div>
                        </div>

                        <!-- 2. Rute & Durasi Sewa -->
                        <div class="bg-white rounded-2xl p-3.5 border border-slate-200/80 space-y-2.5 shadow-xs">
                            <h4 class="text-xs font-extrabold text-slate-900 border-b border-slate-100 pb-1.5">2. Rute & Waktu Pemakaian</h4>
                            
                            <div class="grid grid-cols-2 gap-2">
                                <div class="bg-slate-50 border border-slate-200/90 rounded-xl px-2.5 py-1.5">
                                    <label class="block text-[8px] font-bold uppercase tracking-wider text-slate-400">Kota Asal</label>
                                    <select id="charterOrigin" class="w-full bg-transparent text-xs font-bold text-slate-800 focus:outline-none cursor-pointer">
                                        <option value="Ciamis" selected>Ciamis</option>
                                        <option value="Tasikmalaya">Tasikmalaya</option>
                                        <option value="Kuningan">Kuningan</option>
                                        <option value="Bandung">Bandung</option>
                                        <option value="Jakarta">Jakarta</option>
                                    </select>
                                </div>
                                <div class="bg-slate-50 border border-slate-200/90 rounded-xl px-2.5 py-1.5">
                                    <label class="block text-[8px] font-bold uppercase tracking-wider text-slate-400">Kota Tujuan</label>
                                    <select id="charterDestination" class="w-full bg-transparent text-xs font-bold text-slate-800 focus:outline-none cursor-pointer">
                                        <option value="Jakarta" selected>Jakarta / Bandara</option>
                                        <option value="Bandung">Bandung</option>
                                        <option value="Yogyakarta">Yogyakarta</option>
                                        <option value="Pangandaran">Pangandaran</option>
                                        <option value="Cirebon">Cirebon</option>
                                    </select>
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-2">
                                <div class="bg-slate-50 border border-slate-200/90 rounded-xl px-2.5 py-1.5">
                                    <label for="charterDate" class="block text-[8px] font-bold uppercase tracking-wider text-slate-400">Tanggal Mulai</label>
                                    <input type="date" id="charterDate" min="{{ date('Y-m-d') }}" value="{{ date('Y-m-d') }}" class="w-full bg-transparent text-xs font-bold text-slate-800 focus:outline-none cursor-pointer" onchange="validateCharterDate(this.value)">
                                </div>
                                <div class="bg-slate-50 border border-slate-200/90 rounded-xl px-2.5 py-1.5">
                                    <label class="block text-[8px] font-bold uppercase tracking-wider text-slate-400">Paket Durasi</label>
                                    <select id="charterDuration" onchange="updateCharterTotal()" class="w-full bg-transparent text-xs font-bold text-slate-800 focus:outline-none cursor-pointer">
                                        <option value="1" selected>1 Hari (Drop / PP)</option>
                                        <option value="2">2 Hari 1 Malam</option>
                                        <option value="3">3 Hari 2 Malam</option>
                                        <option value="4">4 Hari 3 Malam</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- 3. Form Kontak & Alamat -->
                        <div class="bg-white rounded-2xl p-3.5 border border-slate-200/80 space-y-2.5 shadow-xs">
                            <h4 class="text-xs font-extrabold text-slate-900 border-b border-slate-100 pb-1.5">3. Data Kontak & Lokasi Jemput</h4>
                            
                            <div>
                                <label class="block text-[9px] font-bold text-slate-500 mb-1 uppercase">Nama Pemesan</label>
                                <input type="text" id="charterName" required placeholder="Nama Lengkap Penanggung Jawab" value="Andi Pratama" class="w-full h-9 bg-slate-50 border border-slate-200 rounded-xl px-3 text-xs text-slate-900 font-semibold focus:ring-2 focus:ring-sky-500 focus:bg-white focus:outline-none">
                            </div>

                            <div>
                                <label class="block text-[9px] font-bold text-slate-500 mb-1 uppercase">Nomor WhatsApp</label>
                                <input type="tel" id="charterPhone" required placeholder="0812xxxxxxxx" value="081234567890" class="w-full h-9 bg-slate-50 border border-slate-200 rounded-xl px-3 text-xs text-slate-900 font-semibold focus:ring-2 focus:ring-sky-500 focus:bg-white focus:outline-none">
                            </div>

                            <div>
                                <label class="block text-[9px] font-bold text-slate-500 mb-1 uppercase">Titik Alamat Penjemputan</label>
                                <textarea id="charterPickup" required rows="2" placeholder="Alamat rumah / titik kumpul rombongan..." class="w-full bg-slate-50 border border-slate-200 rounded-xl p-2 text-xs text-slate-900 font-medium focus:ring-2 focus:ring-sky-500 focus:bg-white focus:outline-none">Jl. RE Martadinata No. 45, Ciamis</textarea>
                            </div>
                        </div>

                        <!-- Total & Action Button -->
                        <div class="bg-white border border-slate-200 rounded-2xl p-3.5 shadow-sm space-y-2.5">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-[9px] text-slate-400 font-bold uppercase">Estimasi Biaya Charter</p>
                                    <p class="text-base font-black text-sky-600" id="charterTotalPriceDisplay">Rp 1.600.000</p>
                                </div>
                                <span class="text-[9px] text-emerald-700 bg-emerald-50 px-2.5 py-1 rounded-full font-bold">Termasuk Driver & BBM</span>
                            </div>
                            <button type="submit" class="w-full py-3 rounded-xl bg-gradient-to-r from-sky-500 to-sky-600 hover:from-sky-600 hover:to-sky-700 text-white font-bold text-xs shadow-md shadow-sky-500/20 transition flex items-center justify-center gap-2 whitespace-nowrap">
                                <span>Booking Charter & Lanjut Bayar</span>
                                <i class="fas fa-arrow-right text-[10px]"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </section>


            <!-- ================= VIEW 9: TITIP PAKET KILAT (SAME-DAY CARGO) ================= -->
            <section id="viewPackage" class="flex-1 hidden flex-col bg-slate-50">
                <!-- Top Nav Bar (Sky Blue) -->
                <div class="bg-gradient-to-r from-sky-600 to-sky-500 text-white px-4 py-2.5 sticky top-0 z-30 flex items-center gap-2.5 shadow-sm">
                    <button type="button" onclick="switchView('viewHome')" class="w-7 h-7 rounded-full bg-white/20 backdrop-blur-md flex items-center justify-center text-white text-xs shrink-0 active:scale-95">
                        <i class="fas fa-arrow-left"></i>
                    </button>
                    <div class="flex-1 min-w-0">
                        <h3 class="text-xs font-extrabold text-white">Titip Paket Kilat (Same-Day)</h3>
                        <p class="text-[10px] text-sky-100 truncate">Kirim Pagi Sampai Siang • Door to Door</p>
                    </div>
                </div>

                <div class="p-3.5 space-y-3 flex-1">
                    <form id="packageBookingForm" onsubmit="proceedPackageBooking(event)" class="space-y-3">
                        
                        <!-- 1. Kategori Ukuran Paket -->
                        <div class="bg-white rounded-2xl p-3.5 border border-slate-200/80 shadow-xs">
                            <h4 class="text-xs font-extrabold text-slate-900 border-b border-slate-100 pb-2 mb-2.5 flex items-center justify-between">
                                <span>1. Kategori & Jenis Paket</span>
                                <span class="text-[9px] text-emerald-600 font-bold bg-emerald-50 px-2 py-0.5 rounded-full">Garansi Cepat & Aman</span>
                            </h4>

                            <div class="grid grid-cols-2 gap-2">
                                <!-- Category 1: Dokumen -->
                                <label class="package-cat-card p-2.5 rounded-xl border-2 border-sky-500 bg-sky-50/50 cursor-pointer transition flex flex-col justify-between">
                                    <div class="flex items-center gap-1.5 mb-1">
                                        <input type="radio" name="packageCategory" value="dokumen" checked onchange="updatePackageTotal()" class="text-sky-600 focus:ring-sky-500">
                                        <i class="fas fa-file-shield text-sky-600 text-xs"></i>
                                    </div>
                                    <p class="text-[11px] font-bold text-slate-900">Dokumen / Surat</p>
                                    <p class="text-[9px] text-slate-500">Berat &lt; 1 Kg</p>
                                    <p class="text-xs font-black text-sky-600 mt-1">Rp 35.000</p>
                                </label>

                                <!-- Category 2: Reguler -->
                                <label class="package-cat-card p-2.5 rounded-xl border border-slate-200 bg-white cursor-pointer hover:border-sky-300 transition flex flex-col justify-between">
                                    <div class="flex items-center gap-1.5 mb-1">
                                        <input type="radio" name="packageCategory" value="reguler" onchange="updatePackageTotal()" class="text-sky-600 focus:ring-sky-500">
                                        <i class="fas fa-box text-emerald-600 text-xs"></i>
                                    </div>
                                    <p class="text-[11px] font-bold text-slate-900">Paket Standar</p>
                                    <p class="text-[9px] text-slate-500">Dus 1 - 5 Kg</p>
                                    <p class="text-xs font-black text-sky-600 mt-1">Rp 65.000</p>
                                </label>

                                <!-- Category 3: Makanan Khas -->
                                <label class="package-cat-card p-2.5 rounded-xl border border-slate-200 bg-white cursor-pointer hover:border-sky-300 transition flex flex-col justify-between">
                                    <div class="flex items-center gap-1.5 mb-1">
                                        <input type="radio" name="packageCategory" value="makanan" onchange="updatePackageTotal()" class="text-sky-600 focus:ring-sky-500">
                                        <i class="fas fa-bowl-food text-amber-600 text-xs"></i>
                                    </div>
                                    <p class="text-[11px] font-bold text-slate-900">Makanan / Box</p>
                                    <p class="text-[9px] text-slate-500">Same-day Fresh</p>
                                    <p class="text-xs font-black text-sky-600 mt-1">Rp 85.000</p>
                                </label>

                                <!-- Category 4: Kargo Besar -->
                                <label class="package-cat-card p-2.5 rounded-xl border border-slate-200 bg-white cursor-pointer hover:border-sky-300 transition flex flex-col justify-between">
                                    <div class="flex items-center gap-1.5 mb-1">
                                        <input type="radio" name="packageCategory" value="kargo" onchange="updatePackageTotal()" class="text-sky-600 focus:ring-sky-500">
                                        <i class="fas fa-boxes-stacked text-indigo-600 text-xs"></i>
                                    </div>
                                    <p class="text-[11px] font-bold text-slate-900">Kargo Jumbo</p>
                                    <p class="text-[9px] text-slate-500">Berat 5 - 15 Kg</p>
                                    <p class="text-xs font-black text-sky-600 mt-1">Rp 120.000</p>
                                </label>
                            </div>
                        </div>

                        <!-- 2. Rute & Tanggal Kirim -->
                        <div class="bg-white rounded-2xl p-3.5 border border-slate-200/80 space-y-2.5 shadow-xs">
                            <h4 class="text-xs font-extrabold text-slate-900 border-b border-slate-100 pb-1.5">2. Rute Pengiriman Paket</h4>
                            
                            <div class="grid grid-cols-2 gap-2">
                                <div class="bg-slate-50 border border-slate-200/90 rounded-xl px-2.5 py-1.5">
                                    <label class="block text-[8px] font-bold uppercase tracking-wider text-slate-400">Kota Asal (Jemput)</label>
                                    <select id="pkgOrigin" class="w-full bg-transparent text-xs font-bold text-slate-800 focus:outline-none cursor-pointer">
                                        <option value="Ciamis" selected>Ciamis</option>
                                        <option value="Tasikmalaya">Tasikmalaya</option>
                                        <option value="Kuningan">Kuningan</option>
                                        <option value="Bandung">Bandung</option>
                                        <option value="Jakarta">Jakarta</option>
                                    </select>
                                </div>
                                <div class="bg-slate-50 border border-slate-200/90 rounded-xl px-2.5 py-1.5">
                                    <label class="block text-[8px] font-bold uppercase tracking-wider text-slate-400">Kota Tujuan (Antar)</label>
                                    <select id="pkgDestination" class="w-full bg-transparent text-xs font-bold text-slate-800 focus:outline-none cursor-pointer">
                                        <option value="Jakarta" selected>Jakarta</option>
                                        <option value="Bandung">Bandung</option>
                                        <option value="Ciamis">Ciamis</option>
                                        <option value="Tasikmalaya">Tasikmalaya</option>
                                        <option value="Kuningan">Kuningan</option>
                                    </select>
                                </div>
                            </div>

                            <div class="bg-slate-50 border border-slate-200/90 rounded-xl px-2.5 py-1.5">
                                <label for="pkgDate" class="block text-[8px] font-bold uppercase tracking-wider text-slate-400">Tanggal Pengiriman</label>
                                <input type="date" id="pkgDate" min="{{ date('Y-m-d') }}" value="{{ date('Y-m-d') }}" class="w-full bg-transparent text-xs font-bold text-slate-800 focus:outline-none cursor-pointer" onchange="validatePackageDate(this.value)">
                            </div>
                        </div>

                        <!-- 3. Data Pengirim & Penerima -->
                        <div class="bg-white rounded-2xl p-3.5 border border-slate-200/80 space-y-2.5 shadow-xs">
                            <h4 class="text-xs font-extrabold text-slate-900 border-b border-slate-100 pb-1.5">3. Data Pengirim & Penerima</h4>
                            
                            <div class="grid grid-cols-2 gap-2">
                                <div>
                                    <label class="block text-[8px] font-bold text-slate-500 mb-0.5 uppercase">Nama Pengirim</label>
                                    <input type="text" id="pkgSenderName" required placeholder="Nama Anda" value="Andi Pratama" class="w-full h-8 bg-slate-50 border border-slate-200 rounded-lg px-2 text-xs text-slate-900 font-semibold focus:ring-1 focus:ring-sky-500 focus:bg-white focus:outline-none">
                                </div>
                                <div>
                                    <label class="block text-[8px] font-bold text-slate-500 mb-0.5 uppercase">WA Pengirim</label>
                                    <input type="tel" id="pkgSenderPhone" required placeholder="0812xxxx" value="081234567890" class="w-full h-8 bg-slate-50 border border-slate-200 rounded-lg px-2 text-xs text-slate-900 font-semibold focus:ring-1 focus:ring-sky-500 focus:bg-white focus:outline-none">
                                </div>
                            </div>

                            <div>
                                <label class="block text-[8px] font-bold text-slate-500 mb-0.5 uppercase">Alamat Pengambilan Paket (Door Pickup)</label>
                                <input type="text" id="pkgPickupAddress" required placeholder="Alamat lengkap penjemputan paket..." value="Jl. RE Martadinata No. 45, Ciamis" class="w-full h-8 bg-slate-50 border border-slate-200 rounded-lg px-2 text-xs text-slate-900 font-medium focus:ring-1 focus:ring-sky-500 focus:bg-white focus:outline-none">
                            </div>

                            <div class="grid grid-cols-2 gap-2 pt-1 border-t border-slate-100">
                                <div>
                                    <label class="block text-[8px] font-bold text-slate-500 mb-0.5 uppercase">Nama Penerima</label>
                                    <input type="text" id="pkgRecipientName" required placeholder="Nama Penerima" value="Budi Santoso" class="w-full h-8 bg-slate-50 border border-slate-200 rounded-lg px-2 text-xs text-slate-900 font-semibold focus:ring-1 focus:ring-sky-500 focus:bg-white focus:outline-none">
                                </div>
                                <div>
                                    <label class="block text-[8px] font-bold text-slate-500 mb-0.5 uppercase">WA Penerima</label>
                                    <input type="tel" id="pkgRecipientPhone" required placeholder="0813xxxx" value="081398765432" class="w-full h-8 bg-slate-50 border border-slate-200 rounded-lg px-2 text-xs text-slate-900 font-semibold focus:ring-1 focus:ring-sky-500 focus:bg-white focus:outline-none">
                                </div>
                            </div>

                            <div>
                                <label class="block text-[8px] font-bold text-slate-500 mb-0.5 uppercase">Alamat Pengantaran Tujuan (Door Delivery)</label>
                                <input type="text" id="pkgDropoffAddress" required placeholder="Alamat lengkap penerima..." value="Jl. Gatot Subroto No. 88, Jakarta Selatan" class="w-full h-8 bg-slate-50 border border-slate-200 rounded-lg px-2 text-xs text-slate-900 font-medium focus:ring-1 focus:ring-sky-500 focus:bg-white focus:outline-none">
                            </div>
                        </div>

                        <!-- Total & Action Button -->
                        <div class="bg-white border border-slate-200 rounded-2xl p-3.5 shadow-sm space-y-2.5">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-[9px] text-slate-400 font-bold uppercase">Ongkir Same-Day Delivery</p>
                                    <p class="text-base font-black text-sky-600" id="pkgTotalPriceDisplay">Rp 35.000</p>
                                </div>
                                <span class="text-[9px] text-emerald-700 bg-emerald-50 px-2.5 py-1 rounded-full font-bold">Door to Door Express</span>
                            </div>
                            <button type="submit" class="w-full py-3 rounded-xl bg-gradient-to-r from-sky-500 to-sky-600 hover:from-sky-600 hover:to-sky-700 text-white font-bold text-xs shadow-md shadow-sky-500/20 transition flex items-center justify-center gap-2 whitespace-nowrap">
                                <span>Bayar Ongkir QRIS & Terbitkan Resi</span>
                                <i class="fas fa-qrcode"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </section>

        </div>

        <!-- ================= APP BOTTOM NAVIGATION BAR (TRAVELOKA STYLE) ================= -->
        <nav class="bg-white border-t border-slate-200 px-6 py-2 flex items-center justify-between absolute bottom-0 inset-x-0 z-40 text-slate-400">
            <button type="button" onclick="switchView('viewHome')" class="nav-tab-btn flex flex-col items-center gap-0.5 text-sky-500" id="tabNavHome">
                <i class="fas fa-house text-sm"></i>
                <span class="text-[9px] font-bold">Beranda</span>
            </button>

            <button type="button" onclick="executeScheduleSearch()" class="nav-tab-btn flex flex-col items-center gap-0.5 hover:text-sky-500" id="tabNavSchedules">
                <i class="fas fa-van-shuttle text-sm"></i>
                <span class="text-[9px] font-bold">Jadwal</span>
            </button>

            <button type="button" onclick="switchView('viewHistory')" class="nav-tab-btn flex flex-col items-center gap-0.5 hover:text-sky-500" id="tabNavHistory">
                <i class="fas fa-receipt text-sm"></i>
                <span class="text-[9px] font-bold">Pesanan</span>
            </button>

            <a href="https://wa.me/{{ $cleanWa }}?text={{ urlencode('Halo CS ' . $brandName . ', saya ingin tanya jadwal travel shuttle.') }}" target="_blank" class="nav-tab-btn flex flex-col items-center gap-0.5 hover:text-emerald-600">
                <i class="fab fa-whatsapp text-sm text-emerald-600"></i>
                <span class="text-[9px] font-bold text-emerald-600">Bantuan</span>
            </a>
        </nav>

    </main>

    <!-- JS Engine for Multi-Seat, QRIS Simulation & Order History Persistence -->
    <script>
        const DB = @json($travelDatabase);
        const BRAND_NAME = "{{ $brandName }}";
        const WA_PHONE = "{{ $cleanWa }}";

        // Global State
        let state = {
            activeView: 'viewHome'
            , searchOrigin: 'ciamis'
            , searchDestination: 'jakarta'
            , searchShift: 'all'
            , searchDate: new Date().toISOString().split('T')[0]
            , selectedSchedule: null
            , selectedSeats: [], // Multi-seat array e.g. [1, 2]
            currentOrder: null
        };

        // Initialize App
        document.addEventListener('DOMContentLoaded', () => {
            initClock();
            initDatePicker();
            loadOrderHistory();
            setDefaultSampleIfEmpty();
        });

        function initClock() {
            const now = new Date();
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            const clockEl = document.getElementById('statusBarClock');
            if (clockEl) clockEl.textContent = `${hours}:${minutes}`;
        }

        function getTodayDateString() {
            const d = new Date();
            const year = d.getFullYear();
            const month = String(d.getMonth() + 1).padStart(2, '0');
            const day = String(d.getDate()).padStart(2, '0');
            return `${year}-${month}-${day}`;
        }

        function initDatePicker() {
            const dateInput = document.getElementById('homeDate');
            if (dateInput) {
                const today = getTodayDateString();
                dateInput.min = today;
                if (!dateInput.value || dateInput.value < today) {
                    dateInput.value = today;
                }
                state.searchDate = dateInput.value;
            }
        }

        function handleDateChange(val) {
            const today = getTodayDateString();
            if (!val || val < today) {
                alert('Tanggal keberangkatan tidak boleh sebelum hari ini.');
                val = today;
                const dateInput = document.getElementById('homeDate');
                if (dateInput) dateInput.value = today;
            }
            state.searchDate = val;
        }

        function formatIndoDate(dateStr) {
            if (!dateStr) return 'Hari Ini';
            try {
                const parts = dateStr.split('-');
                if (parts.length === 3) {
                    const dateObj = new Date(parts[0], parts[1] - 1, parts[2]);
                    const today = new Date();
                    today.setHours(0, 0, 0, 0);
                    const compareDate = new Date(parts[0], parts[1] - 1, parts[2]);
                    compareDate.setHours(0, 0, 0, 0);

                    const days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
                    const months = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];

                    const dayName = days[dateObj.getDay()];
                    const dayNum = dateObj.getDate();
                    const monthName = months[dateObj.getMonth()];
                    const year = dateObj.getFullYear();

                    if (compareDate.getTime() === today.getTime()) {
                        return `Hari Ini (${dayNum} ${monthName})`;
                    }
                    return `${dayName}, ${dayNum} ${monthName} ${year}`;
                }
            } catch (e) {
                console.error(e);
            }
            return dateStr;
        }

        // View Switcher Engine
        function switchView(viewId) {
            const views = ['viewHome', 'viewSchedules', 'viewSeatPicker', 'viewPassengerForm', 'viewPayment', 'viewSuccessTicket', 'viewHistory', 'viewCharter', 'viewPackage'];
            views.forEach(id => {
                const el = document.getElementById(id);
                if (el) {
                    if (id === viewId) {
                        el.classList.remove('hidden');
                        el.classList.add('flex');
                    } else {
                        el.classList.add('hidden');
                        el.classList.remove('flex');
                    }
                }
            });

            // Update bottom nav highlights (Sky Blue theme)
            const tabHome = document.getElementById('tabNavHome');
            const tabSchedules = document.getElementById('tabNavSchedules');
            const tabHistory = document.getElementById('tabNavHistory');

            if (tabHome && tabSchedules && tabHistory) {
                tabHome.className = `nav-tab-btn flex flex-col items-center gap-0.5 ${viewId === 'viewHome' ? 'text-sky-500' : 'text-slate-400'}`;
                tabSchedules.className = `nav-tab-btn flex flex-col items-center gap-0.5 ${viewId === 'viewSchedules' || viewId === 'viewSeatPicker' ? 'text-sky-500' : 'text-slate-400'}`;
                tabHistory.className = `nav-tab-btn flex flex-col items-center gap-0.5 ${viewId === 'viewHistory' || viewId === 'viewSuccessTicket' ? 'text-sky-500' : 'text-slate-400'}`;
            }

            state.activeView = viewId;
            const viewport = document.getElementById('appViewport');
            if (viewport) viewport.scrollTop = 0;
        }

        function swapOriginDestination() {
            const orig = document.getElementById('homeOrigin');
            const dest = document.getElementById('homeDestination');
            if (orig && dest) {
                const temp = orig.value;
                orig.value = dest.value;
                dest.value = temp;
            }
        }

        function quickSearchRoute(orig, dest) {
            const origSelect = document.getElementById('homeOrigin');
            const destSelect = document.getElementById('homeDestination');
            if (origSelect) origSelect.value = orig;
            if (destSelect) destSelect.value = dest;
            executeScheduleSearch();
        }

        // 1. Execute Search & Render Schedule Cards
        function executeScheduleSearch() {
            state.searchOrigin = document.getElementById('homeOrigin').value;
            state.searchDestination = document.getElementById('homeDestination').value;
            state.searchShift = document.getElementById('homeShift').value;

            const today = getTodayDateString();
            const dateInput = document.getElementById('homeDate');
            if (dateInput) {
                if (!dateInput.value || dateInput.value < today) {
                    dateInput.value = today;
                }
                state.searchDate = dateInput.value;
            }

            document.getElementById('schedulesRouteTitle').textContent = `${capitalize(state.searchOrigin)} ➔ ${capitalize(state.searchDestination)}`;
            document.getElementById('schedulesSubtitle').textContent = `${formatIndoDate(state.searchDate)} • 1 Penumpang`;

            filterScheduleShift(state.searchShift);
            switchView('viewSchedules');
        }

        function filterScheduleShift(shift) {
            const buttons = document.querySelectorAll('.shift-btn');
            buttons.forEach(btn => {
                if (btn.dataset.shift === shift) {
                    btn.className = 'shift-btn px-3 py-1.5 rounded-full text-[11px] font-bold bg-sky-500 text-white shadow-xs whitespace-nowrap shrink-0 transition';
                } else {
                    btn.className = 'shift-btn px-3 py-1.5 rounded-full text-[11px] font-bold bg-slate-100 text-slate-700 hover:bg-sky-50 hover:text-sky-700 whitespace-nowrap shrink-0 transition';
                }
            });
            renderSchedulesList(shift);
        }

        function renderSchedulesList(shiftFilter = 'all') {
            const container = document.getElementById('schedulesListContainer');
            if (!container || !DB.schedules) return;
            container.innerHTML = '';

            let filtered = DB.schedules.filter(item => {
                const matchOrigin = (state.searchOrigin === 'all' || item.origin.toLowerCase().includes(state.searchOrigin));
                const matchDest = (state.searchDestination === 'all' || item.destination.toLowerCase().includes(state.searchDestination));
                const matchShift = (shiftFilter === 'all' || item.shift === shiftFilter);
                return matchOrigin && matchDest && matchShift;
            });

            if (filtered.length === 0) {
                filtered = DB.schedules;
            }

            filtered.forEach(schedule => {
                const bookedCount = schedule.booked_seats.length;
                const remainingSeats = schedule.total_seats - bookedCount;

                let shiftText = schedule.shift.toUpperCase();
                if (schedule.shift === 'pagi') shiftText = 'SHIFT PAGI';
                else if (schedule.shift === 'siang') shiftText = 'SHIFT SIANG';
                else if (schedule.shift === 'malam') shiftText = 'SHIFT MALAM';

                const card = document.createElement('div');
                card.className = 'bg-white rounded-2xl p-3.5 border border-slate-200/90 shadow-xs hover:border-sky-300 transition';
                card.innerHTML = `
                    <div class="flex items-center justify-between pb-2 mb-2 border-b border-slate-100">
                        <div class="flex items-center gap-1.5 min-w-0">
                            <span class="px-2 py-0.5 rounded bg-sky-50 text-sky-700 text-[9px] font-extrabold uppercase whitespace-nowrap shrink-0">
                                ${shiftText}
                            </span>
                            <span class="text-[11px] font-bold text-slate-700 truncate">${schedule.fleet_name}</span>
                        </div>
                        <span class="text-[10px] font-bold ${remainingSeats <= 2 ? 'text-rose-600 bg-rose-50' : 'text-emerald-700 bg-emerald-50'} px-2 py-0.5 rounded-full whitespace-nowrap shrink-0">
                            Sisa ${remainingSeats} Kursi
                        </span>
                    </div>

                    <div class="flex items-center justify-between my-2">
                        <div class="text-left">
                            <p class="text-base font-black text-slate-900 tracking-tight leading-none">${schedule.departure_time.split(' ')[0]}</p>
                            <p class="text-[10px] font-bold text-slate-500 mt-0.5">${schedule.origin}</p>
                        </div>
                        <div class="text-center px-2 shrink-0">
                            <div class="w-16 h-[1.5px] bg-slate-200 relative my-1">
                                <i class="fas fa-arrow-right absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 text-sky-500 text-[8px] bg-white px-1"></i>
                            </div>
                            <span class="text-[8px] text-slate-400 font-medium whitespace-nowrap">Tol Cisumdawu</span>
                        </div>
                        <div class="text-right">
                            <p class="text-base font-black text-slate-900 tracking-tight leading-none">${schedule.arrival_est.split(' ')[0]}</p>
                            <p class="text-[10px] font-bold text-slate-500 mt-0.5">${schedule.destination.split(' ')[0]}</p>
                        </div>
                    </div>

                    <div class="flex flex-wrap gap-1 my-2">
                        <span class="px-2 py-0.5 rounded bg-slate-100 text-slate-600 text-[9px] font-medium whitespace-nowrap">Gratis Makan Rest Area</span>
                        <span class="px-2 py-0.5 rounded bg-slate-100 text-slate-600 text-[9px] font-medium whitespace-nowrap">Snack & Minum</span>
                        <span class="px-2 py-0.5 rounded bg-slate-100 text-slate-600 text-[9px] font-medium whitespace-nowrap">USB Charger</span>
                    </div>

                    <div class="flex items-center justify-between pt-2.5 border-t border-slate-100 mt-2">
                        <div>
                            <p class="text-[8px] text-slate-400 font-bold uppercase tracking-wider">Harga per Kursi</p>
                            <p class="text-sm font-black text-sky-600 whitespace-nowrap">${schedule.price_formatted}</p>
                        </div>
                        <button type="button" onclick="openSeatPicker(${schedule.id})" class="px-3.5 py-1.5 rounded-xl bg-sky-500 hover:bg-sky-600 active:scale-95 text-white font-bold text-xs shadow-xs transition flex items-center gap-1.5 whitespace-nowrap cursor-pointer">
                            <i class="fas fa-chair text-xs"></i>
                            <span>Pilih Kursi</span>
                        </button>
                    </div>
                `;
                container.appendChild(card);
            });
        }

        // 2. Open Seat Picker & Generate Interactive Multi-Seat Layout
        function openSeatPicker(scheduleId) {
            const schedule = DB.schedules.find(s => s.id === scheduleId) || DB.schedules[0];
            state.selectedSchedule = schedule;
            state.selectedSeats = [];

            document.getElementById('seatPickerSubtitle').textContent = `${schedule.fleet_name} • ${schedule.origin} ➔ ${schedule.destination.split(' ')[0]} (${schedule.departure_time})`;

            renderInteractiveSeats(schedule);
            updateSelectedSeatsUI();
            switchView('viewSeatPicker');
        }

        function renderInteractiveSeats(schedule) {
            const grid = document.getElementById('interactiveSeatsGrid');
            if (!grid) return;
            grid.innerHTML = '';

            // Row 1: Driver + Seat 1
            const driverBox = document.createElement('div');
            driverBox.className = 'col-span-2 p-2 rounded-xl bg-slate-100 text-slate-400 font-bold text-center text-[10px] flex items-center justify-center gap-1 border border-slate-200';
            driverBox.innerHTML = '<i class="fas fa-steering-wheel"></i> <span>Driver</span>';
            grid.appendChild(driverBox);

            const seat1Booked = schedule.booked_seats.includes(1);
            const seat1 = document.createElement('button');
            seat1.type = 'button';
            seat1.className = `col-span-2 p-2 rounded-xl font-bold text-xs flex items-center justify-center gap-1 transition cursor-pointer ${
                seat1Booked ? 'bg-slate-200 text-slate-400 cursor-not-allowed border border-slate-300' : 'bg-emerald-50 text-emerald-800 border border-emerald-300 hover:bg-emerald-100'
            }`;
            seat1.innerHTML = seat1Booked ? 'K-01 (Terisi)' : '<i class="fas fa-chair text-xs"></i> K-01';
            if (!seat1Booked) {
                seat1.onclick = () => toggleSeatSelection(1, seat1);
            }
            grid.appendChild(seat1);

            // Remaining Seats
            for (let i = 2; i <= schedule.total_seats; i++) {
                const isBooked = schedule.booked_seats.includes(i);
                const seatBtn = document.createElement('button');
                seatBtn.type = 'button';
                seatBtn.dataset.seat = i;
                seatBtn.className = `p-2 rounded-xl font-bold text-xs flex items-center justify-center gap-1 transition cursor-pointer ${
                    isBooked ? 'bg-slate-200 text-slate-400 cursor-not-allowed border border-slate-300' : 'bg-emerald-50 text-emerald-800 border border-emerald-300 hover:bg-emerald-100'
                }`;
                seatBtn.innerHTML = isBooked ? `K-${i < 10 ? '0'+i : i}` : `<i class="fas fa-chair text-xs"></i> K-${i < 10 ? '0'+i : i}`;

                if (!isBooked) {
                    seatBtn.onclick = () => toggleSeatSelection(i, seatBtn);
                }
                grid.appendChild(seatBtn);
            }
        }

        // Toggle Multi-Seat Selection
        function toggleSeatSelection(seatNum, buttonEl) {
            const index = state.selectedSeats.indexOf(seatNum);
            if (index > -1) {
                state.selectedSeats.splice(index, 1);
                buttonEl.className = 'p-2 rounded-xl font-bold text-xs flex items-center justify-center gap-1 bg-emerald-50 text-emerald-800 border border-emerald-300 hover:bg-emerald-100 transition cursor-pointer';
            } else {
                if (state.selectedSeats.length >= 4) {
                    alert('Maksimal pemilihan 4 kursi per transaksi demo.');
                    return;
                }
                state.selectedSeats.push(seatNum);
                buttonEl.className = 'p-2 rounded-xl font-bold text-xs flex items-center justify-center gap-1 bg-sky-500 text-white border-2 border-sky-600 shadow-sm transition cursor-pointer';
            }

            state.selectedSeats.sort((a, b) => a - b);
            updateSelectedSeatsUI();
        }

        function updateSelectedSeatsUI() {
            const label = document.getElementById('selectedSeatsLabel');
            const totalEl = document.getElementById('selectedSeatsTotalPrice');
            const btnContinue = document.getElementById('btnContinueToPassenger');

            if (state.selectedSeats.length === 0) {
                label.textContent = 'Belum Ada Kursi';
                totalEl.textContent = 'Rp 0';
                btnContinue.disabled = true;
                btnContinue.className = 'w-full py-3 rounded-xl bg-slate-200 text-slate-400 font-bold text-xs cursor-not-allowed flex items-center justify-center gap-2 whitespace-nowrap';
            } else {
                const formattedSeats = state.selectedSeats.map(s => `K-${s < 10 ? '0'+s : s}`).join(', ');
                const unitPrice = state.selectedSchedule ? state.selectedSchedule.price : 220000;
                const total = unitPrice * state.selectedSeats.length;

                label.textContent = `${state.selectedSeats.length} Kursi: ${formattedSeats}`;
                totalEl.textContent = `Rp ${total.toLocaleString('id-ID')}`;
                btnContinue.disabled = false;
                btnContinue.className = 'w-full py-3 rounded-xl bg-gradient-to-r from-sky-500 to-sky-600 hover:from-sky-600 hover:to-sky-700 active:scale-98 text-white font-bold text-xs shadow-md shadow-sky-500/20 transition flex items-center justify-center gap-2 cursor-pointer whitespace-nowrap';
            }
        }

        // 3. Proceed to Passenger Form
        function proceedToPassengerForm() {
            if (state.selectedSeats.length === 0) return;

            const schedule = state.selectedSchedule;
            const formattedSeats = state.selectedSeats.map(s => `K-${s < 10 ? '0'+s : s}`).join(', ');

            document.getElementById('formSummaryRoute').textContent = `${schedule.origin} ➔ ${schedule.destination}`;
            document.getElementById('formSummarySeatsBadge').textContent = `${state.selectedSeats.length} Kursi (${formattedSeats})`;
            document.getElementById('formSummaryFleet').innerHTML = `<i class="fas fa-van-shuttle text-sky-500 shrink-0"></i> <span>${schedule.fleet_name} (${formatIndoDate(state.searchDate)} • ${schedule.departure_time})</span>`;

            switchView('viewPassengerForm');
        }

        // 4. Proceed to Payment Screen (Shuttle)
        function proceedToPayment(e) {
            e.preventDefault();

            const name = document.getElementById('custName').value.trim();
            const phone = document.getElementById('custPhone').value.trim();
            const pickup = document.getElementById('custPickup').value.trim();
            const dropoff = document.getElementById('custDropoff').value.trim();

            const unitPrice = state.selectedSchedule.price;
            const total = unitPrice * state.selectedSeats.length;
            const formattedSeats = state.selectedSeats.map(s => `K-${s < 10 ? '0'+s : s}`).join(', ');

            // Build Order Object
            const bookingCode = 'SKY-' + Math.floor(100000 + Math.random() * 900000);
            state.currentOrder = {
                id: 'ORD-' + Date.now()
                , orderType: 'SHUTTLE'
                , bookingCode: bookingCode
                , passengerName: name
                , phone: phone
                , pickupAddress: pickup
                , dropoffAddress: dropoff
                , route: `${state.selectedSchedule.origin} ➔ ${state.selectedSchedule.destination.split(' ')[0]}`
                , origin: state.selectedSchedule.origin
                , destination: state.selectedSchedule.destination.split(' ')[0]
                , departureDate: formatIndoDate(state.searchDate)
                , departureTime: state.selectedSchedule.departure_time
                , arrivalEst: state.selectedSchedule.arrival_est
                , fleetName: state.selectedSchedule.fleet_name
                , seats: formattedSeats
                , seatCount: state.selectedSeats.length
                , totalAmount: total
                , totalFormatted: `Rp ${total.toLocaleString('id-ID')}`
                , createdAt: new Date().toLocaleString('id-ID')
            };

            document.getElementById('qrisTotalAmount').textContent = state.currentOrder.totalFormatted;
            document.getElementById('qrisDetailText').textContent = `${state.currentOrder.seatCount} Kursi (${formattedSeats}) • ${state.currentOrder.departureDate}`;

            switchView('viewPayment');
        }

        // ================= PRIVATE CHARTER CONTROLLERS =================
        const CHARTER_RATES = {
            'elf_long': { name: 'Isuzu Elf Giga Long (19 Seat)', price: 1600000, desc: 'Executive AC • Audio Karaoke' },
            'hiace_premio': { name: 'Toyota HiAce Premio Luxury (14 Seat)', price: 1850000, desc: 'Captain Seats • Luxury Comfort' },
            'innova_zenix': { name: 'Toyota Innova Zenix VIP (7 Seat)', price: 1100000, desc: 'Family VIP • Premium Comfort' },
            'avanza_veloz': { name: 'Toyota Avanza / Veloz (6 Seat)', price: 750000, desc: 'Hemat & Fleksibel Rombongan Kecil' }
        };

        function openCharterView() {
            const today = getTodayDateString();
            const dateInput = document.getElementById('charterDate');
            if (dateInput) {
                dateInput.min = today;
                if (!dateInput.value || dateInput.value < today) {
                    dateInput.value = today;
                }
            }
            updateCharterTotal();
            switchView('viewCharter');
        }

        function validateCharterDate(val) {
            const today = getTodayDateString();
            const dateInput = document.getElementById('charterDate');
            if (val < today) {
                alert('Tanggal sewa charter tidak boleh memilih tanggal lampau.');
                if (dateInput) dateInput.value = today;
                return false;
            }
            return true;
        }

        function updateCharterTotal() {
            const selectedFleet = document.querySelector('input[name="charterFleet"]:checked')?.value || 'elf_long';
            const durationEl = document.getElementById('charterDuration');
            const duration = parseInt(durationEl ? durationEl.value : 1, 10);
            
            // Visual radio highlight update
            const fleetCards = document.querySelectorAll('.charter-fleet-card');
            fleetCards.forEach(card => {
                const radio = card.querySelector('input[name="charterFleet"]');
                if (radio && radio.checked) {
                    card.className = 'charter-fleet-card flex items-center justify-between p-2.5 rounded-xl border-2 border-sky-500 bg-sky-50/60 cursor-pointer transition';
                } else {
                    card.className = 'charter-fleet-card flex items-center justify-between p-2.5 rounded-xl border border-slate-200 bg-white cursor-pointer hover:border-sky-300 transition';
                }
            });

            const fleetInfo = CHARTER_RATES[selectedFleet] || CHARTER_RATES['elf_long'];
            const total = fleetInfo.price * duration;
            const displayEl = document.getElementById('charterTotalPriceDisplay');
            if (displayEl) {
                displayEl.textContent = `Rp ${total.toLocaleString('id-ID')}`;
            }
        }

        function proceedCharterBooking(e) {
            e.preventDefault();

            const selectedFleet = document.querySelector('input[name="charterFleet"]:checked')?.value || 'elf_long';
            const fleetInfo = CHARTER_RATES[selectedFleet] || CHARTER_RATES['elf_long'];
            const durationEl = document.getElementById('charterDuration');
            const duration = parseInt(durationEl ? durationEl.value : 1, 10);

            const orig = document.getElementById('charterOrigin')?.value || 'Ciamis';
            const dest = document.getElementById('charterDestination')?.value || 'Jakarta';
            const dateVal = document.getElementById('charterDate')?.value || getTodayDateString();
            const name = document.getElementById('charterName')?.value.trim() || 'Pelanggan Charter';
            const phone = document.getElementById('charterPhone')?.value.trim() || '081234567890';
            const pickup = document.getElementById('charterPickup')?.value.trim() || 'Alamat Rombongan';

            const total = fleetInfo.price * duration;
            const bookingCode = 'CHR-' + Math.floor(100000 + Math.random() * 900000);

            state.currentOrder = {
                id: 'ORD-CHR-' + Date.now()
                , orderType: 'CHARTER'
                , bookingCode: bookingCode
                , passengerName: name
                , phone: phone
                , pickupAddress: pickup
                , dropoffAddress: `Kota Tujuan: ${dest}`
                , route: `${orig} ➔ ${dest} (Private 1 Unit)`
                , origin: orig
                , destination: dest
                , departureDate: formatIndoDate(dateVal)
                , departureTime: '06:00 WIB (Fleksibel)'
                , arrivalEst: 'Sesuai Rute Rombongan'
                , fleetName: fleetInfo.name
                , seats: `Full Unit (${duration} Hari)`
                , seatCount: duration
                , durationText: `${duration} Hari Pemakaian`
                , totalAmount: total
                , totalFormatted: `Rp ${total.toLocaleString('id-ID')}`
                , createdAt: new Date().toLocaleString('id-ID')
            };

            document.getElementById('qrisTotalAmount').textContent = state.currentOrder.totalFormatted;
            document.getElementById('qrisDetailText').textContent = `${fleetInfo.name} • ${duration} Hari • ${state.currentOrder.departureDate}`;

            switchView('viewPayment');
        }


        // ================= TITIP PAKET KILAT CONTROLLERS =================
        const PACKAGE_RATES = {
            'dokumen': { name: 'Dokumen / Surat (< 1 Kg)', price: 35000, badge: 'Dokumen' },
            'reguler': { name: 'Paket Standar (Dus 1-5 Kg)', price: 65000, badge: 'Standar Dus' },
            'makanan': { name: 'Makanan Khas / Frozen Box (Same-Day)', price: 85000, badge: 'Same-day Fresh' },
            'kargo': { name: 'Kargo Jumbo (5-15 Kg)', price: 120000, badge: 'Kargo Jumbo' }
        };

        function openPackageView() {
            const today = getTodayDateString();
            const dateInput = document.getElementById('pkgDate');
            if (dateInput) {
                dateInput.min = today;
                if (!dateInput.value || dateInput.value < today) {
                    dateInput.value = today;
                }
            }
            updatePackageTotal();
            switchView('viewPackage');
        }

        function validatePackageDate(val) {
            const today = getTodayDateString();
            const dateInput = document.getElementById('pkgDate');
            if (val < today) {
                alert('Tanggal pengiriman paket tidak boleh memilih tanggal lampau.');
                if (dateInput) dateInput.value = today;
                return false;
            }
            return true;
        }

        function updatePackageTotal() {
            const selectedCat = document.querySelector('input[name="packageCategory"]:checked')?.value || 'dokumen';
            
            // Visual radio highlight update
            const catCards = document.querySelectorAll('.package-cat-card');
            catCards.forEach(card => {
                const radio = card.querySelector('input[name="packageCategory"]');
                if (radio && radio.checked) {
                    card.className = 'package-cat-card p-2.5 rounded-xl border-2 border-sky-500 bg-sky-50/60 cursor-pointer transition flex flex-col justify-between';
                } else {
                    card.className = 'package-cat-card p-2.5 rounded-xl border border-slate-200 bg-white cursor-pointer hover:border-sky-300 transition flex flex-col justify-between';
                }
            });

            const catInfo = PACKAGE_RATES[selectedCat] || PACKAGE_RATES['dokumen'];
            const displayEl = document.getElementById('pkgTotalPriceDisplay');
            if (displayEl) {
                displayEl.textContent = `Rp ${catInfo.price.toLocaleString('id-ID')}`;
            }
        }

        function proceedPackageBooking(e) {
            e.preventDefault();

            const selectedCat = document.querySelector('input[name="packageCategory"]:checked')?.value || 'dokumen';
            const catInfo = PACKAGE_RATES[selectedCat] || PACKAGE_RATES['dokumen'];

            const orig = document.getElementById('pkgOrigin')?.value || 'Ciamis';
            const dest = document.getElementById('pkgDestination')?.value || 'Jakarta';
            const dateVal = document.getElementById('pkgDate')?.value || getTodayDateString();
            const senderName = document.getElementById('pkgSenderName')?.value.trim() || 'Pengirim';
            const senderPhone = document.getElementById('pkgSenderPhone')?.value.trim() || '0812xxxx';
            const pickup = document.getElementById('pkgPickupAddress')?.value.trim() || 'Alamat Pickup';
            const recipientName = document.getElementById('pkgRecipientName')?.value.trim() || 'Penerima';
            const recipientPhone = document.getElementById('pkgRecipientPhone')?.value.trim() || '0813xxxx';
            const dropoff = document.getElementById('pkgDropoffAddress')?.value.trim() || 'Alamat Penerima';

            const total = catInfo.price;
            const resiCode = 'RESI-SKY-' + Math.floor(100000 + Math.random() * 900000);

            state.currentOrder = {
                id: 'ORD-PKG-' + Date.now()
                , orderType: 'PACKAGE'
                , bookingCode: resiCode
                , passengerName: `${senderName} ➔ ${recipientName}`
                , senderName: senderName
                , senderPhone: senderPhone
                , recipientName: recipientName
                , recipientPhone: recipientPhone
                , phone: senderPhone
                , pickupAddress: pickup
                , dropoffAddress: dropoff
                , route: `Kirim Paket: ${orig} ➔ ${dest}`
                , origin: orig
                , destination: dest
                , departureDate: formatIndoDate(dateVal)
                , departureTime: 'Pagi (07:00 WIB)'
                , arrivalEst: 'Sore (14:00 WIB)'
                , fleetName: `Same-Day Shuttle (${catInfo.badge})`
                , seats: catInfo.badge
                , seatCount: 1
                , categoryTitle: catInfo.name
                , totalAmount: total
                , totalFormatted: `Rp ${total.toLocaleString('id-ID')}`
                , createdAt: new Date().toLocaleString('id-ID')
            };

            document.getElementById('qrisTotalAmount').textContent = state.currentOrder.totalFormatted;
            document.getElementById('qrisDetailText').textContent = `${catInfo.name} • ${orig} ➔ ${dest} • ${state.currentOrder.departureDate}`;

            switchView('viewPayment');
        }


        // 5. Simulate Payment Success & Save to LocalStorage
        function simulatePaymentSuccess() {
            if (!state.currentOrder) return;

            // Save to LocalStorage
            saveOrderToHistory(state.currentOrder);

            const order = state.currentOrder;

            // Populate E-Ticket Area
            document.getElementById('ticketBookingCode').textContent = order.bookingCode;
            document.getElementById('ticketDepTime').textContent = order.departureTime;
            document.getElementById('ticketArrTime').textContent = order.arrivalEst;
            document.getElementById('ticketOrigin').textContent = order.origin;
            document.getElementById('ticketDestination').textContent = order.destination;
            document.getElementById('ticketPassengerName').textContent = order.passengerName;
            document.getElementById('ticketSeatsList').textContent = order.seats;
            document.getElementById('ticketTravelDate').textContent = order.departureDate || 'Hari Ini';
            document.getElementById('ticketFleetName').textContent = order.fleetName;
            document.getElementById('ticketTotalPrice').textContent = order.totalFormatted;

            // Switch to Success Ticket Screen
            switchView('viewSuccessTicket');
            loadOrderHistory();
        }

        // 6. Order History Persistence Engine
        function saveOrderToHistory(order) {
            let history = JSON.parse(localStorage.getItem('skykey_travel_orders') || '[]');
            history.unshift(order);
            localStorage.setItem('skykey_travel_orders', JSON.stringify(history));
        }

        function loadOrderHistory() {
            const container = document.getElementById('orderHistoryContainer');
            const emptyAlert = document.getElementById('emptyHistoryAlert');
            if (!container) return;

            let history = JSON.parse(localStorage.getItem('skykey_travel_orders') || '[]');
            container.innerHTML = '';

            if (history.length === 0) {
                if (emptyAlert) emptyAlert.classList.remove('hidden');
                return;
            } else {
                if (emptyAlert) emptyAlert.classList.add('hidden');
            }

            history.forEach(order => {
                const item = document.createElement('div');
                item.className = 'bg-white rounded-2xl p-3.5 border border-slate-200/80 shadow-xs';

                let badgeType = `<span class="text-[9px] font-bold text-sky-700 bg-sky-50 px-2 py-0.5 rounded-full whitespace-nowrap"><i class="fas fa-van-shuttle mr-1"></i>SHUTTLE</span>`;
                if (order.orderType === 'CHARTER') {
                    badgeType = `<span class="text-[9px] font-bold text-amber-700 bg-amber-50 px-2 py-0.5 rounded-full whitespace-nowrap"><i class="fas fa-crown mr-1"></i>CHARTER</span>`;
                } else if (order.orderType === 'PACKAGE') {
                    badgeType = `<span class="text-[9px] font-bold text-indigo-700 bg-indigo-50 px-2 py-0.5 rounded-full whitespace-nowrap"><i class="fas fa-box-open mr-1"></i>PAKET KILAT</span>`;
                }

                item.innerHTML = `
                    <div class="flex items-center justify-between pb-2 mb-2 border-b border-slate-100">
                        <div class="flex items-center gap-1.5 min-w-0">
                            <span class="text-[10px] font-black text-slate-900">${order.bookingCode}</span>
                            ${badgeType}
                        </div>
                        <span class="text-[9px] font-bold text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded-full whitespace-nowrap">LUNAS</span>
                    </div>
                    <div class="flex items-center justify-between text-xs font-bold text-slate-800">
                        <span class="truncate pr-2">${order.route}</span>
                        <span class="text-sky-600 font-black whitespace-nowrap">${order.totalFormatted}</span>
                    </div>
                    <p class="text-[10px] text-slate-500 mt-1 truncate">
                        <i class="far fa-calendar-alt text-sky-500 mr-1"></i> ${order.departureDate || 'Hari ini'} • ${order.departureTime} • Detail: <strong class="text-slate-700">${order.seats}</strong>
                    </p>
                    <div class="flex items-center justify-between pt-2 mt-2 border-t border-slate-100 text-[10px]">
                        <span class="text-slate-400">${order.createdAt ? order.createdAt.split(',')[0] : 'Hari ini'}</span>
                        <button type="button" onclick="viewHistoryTicketDetail('${order.bookingCode}')" class="font-bold text-sky-600 hover:underline whitespace-nowrap cursor-pointer">
                            Lihat E-Ticket / Resi ➔
                        </button>
                    </div>
                `;
                container.appendChild(item);
            });
        }

        function viewHistoryTicketDetail(bookingCode) {
            let history = JSON.parse(localStorage.getItem('skykey_travel_orders') || '[]');
            const order = history.find(o => o.bookingCode === bookingCode);
            if (!order) return;

            state.currentOrder = order;
            document.getElementById('ticketBookingCode').textContent = order.bookingCode;
            document.getElementById('ticketDepTime').textContent = order.departureTime;
            document.getElementById('ticketArrTime').textContent = order.arrivalEst;
            document.getElementById('ticketOrigin').textContent = order.origin;
            document.getElementById('ticketDestination').textContent = order.destination;
            document.getElementById('ticketPassengerName').textContent = order.passengerName;
            document.getElementById('ticketSeatsList').textContent = order.seats;
            document.getElementById('ticketTravelDate').textContent = order.departureDate || 'Hari Ini';
            document.getElementById('ticketFleetName').textContent = order.fleetName;
            document.getElementById('ticketTotalPrice').textContent = order.totalFormatted;

            switchView('viewSuccessTicket');
        }

        function setDefaultSampleIfEmpty() {
            let history = JSON.parse(localStorage.getItem('skykey_travel_orders') || '[]');
            if (history.length === 0) {
                const sampleOrder = {
                    id: 'ORD-SAMPLE-1'
                    , orderType: 'SHUTTLE'
                    , bookingCode: 'SKY-782910'
                    , passengerName: 'Andi Pratama'
                    , phone: '081234567890'
                    , pickupAddress: 'Jl. RE Martadinata No. 45, Ciamis'
                    , dropoffAddress: 'Jl. Tebet Raya No. 18, Jakarta Selatan'
                    , route: 'Ciamis ➔ Jakarta'
                    , origin: 'Ciamis'
                    , destination: 'Jakarta'
                    , departureDate: 'Hari Ini'
                    , departureTime: '07:00 WIB'
                    , arrivalEst: '13:30 WIB'
                    , fleetName: 'Isuzu Elf Giga Long Executive'
                    , seats: 'K-01, K-02'
                    , seatCount: 2
                    , totalAmount: 440000
                    , totalFormatted: 'Rp 440.000'
                    , createdAt: 'Hari ini'
                };
                saveOrderToHistory(sampleOrder);
                loadOrderHistory();
            }
        }

        function clearHistoryDemo() {
            if (confirm('Reset semua riwayat order demo?')) {
                localStorage.removeItem('skykey_travel_orders');
                loadOrderHistory();
            }
        }

        function shareTicketToWhatsApp() {
            if (!state.currentOrder) return;
            const order = state.currentOrder;
            let msg = '';

            if (order.orderType === 'CHARTER') {
                msg = `*VOUCHER BOOKING PRIVATE CHARTER - ${BRAND_NAME.toUpperCase()}*
----------------------------------------
*Kode Booking:* ${order.bookingCode}
*Status:* LUNAS (Siap Jalan)

*Detail Sewa Armada:*
• *Armada:* ${order.fleetName}
• *Rute:* ${order.route}
• *Tanggal Pemakaian:* ${order.departureDate || 'Hari Ini'}
• *Durasi Sewa:* ${order.durationText || order.seats}
• *Penanggung Jawab:* ${order.passengerName} (${order.phone})
• *Total Biaya:* ${order.totalFormatted}

*Alamat Penjemputan Rombongan:*
${order.pickupAddress}

*Tujuan:*
${order.dropoffAddress}

*Fasilitas:* Driver Berpengalaman + BBM + Full Unit AC & Multimedia.
----------------------------------------
_Terima kasih telah mempercayakan perjalanan Anda kepada ${BRAND_NAME}._`;
            } else if (order.orderType === 'PACKAGE') {
                msg = `*RESI PENGIRIMAN PAKET KILAT - ${BRAND_NAME.toUpperCase()}*
----------------------------------------
*Nomor Resi:* ${order.bookingCode}
*Status:* LUNAS (Dalam Proses Penjemputan)

*Detail Pengiriman:*
• *Kategori Paket:* ${order.categoryTitle || order.seats}
• *Rute:* ${order.origin} ➔ ${order.destination}
• *Tanggal Kirim:* ${order.departureDate || 'Hari Ini'}
• *Pengirim:* ${order.senderName || order.passengerName} (${order.senderPhone || order.phone})
• *Penerima:* ${order.recipientName || '-'} (${order.recipientPhone || '-'})
• *Total Ongkir:* ${order.totalFormatted}

*Alamat Pengambilan (Door Pickup):*
${order.pickupAddress}

*Alamat Tujuan (Door Delivery):*
${order.dropoffAddress}

*Layanan:* Same-Day Delivery Garansi Cepat & Aman.
----------------------------------------
_Terima kasih telah menggunakan jasa ekspedisi kilat ${BRAND_NAME}._`;
            } else {
                msg = `*E-TICKET RESMI - ${BRAND_NAME.toUpperCase()} SHUTTLE*
----------------------------------------
*Kode Booking:* ${order.bookingCode}
*Status:* LUNAS (Siap Dijemput)

*Detail Perjalanan:*
• *Rute:* ${order.route}
• *Tanggal Keberangkatan:* ${order.departureDate || 'Hari Ini'}
• *Jam Berangkat:* ${order.departureTime}
• *Armada:* ${order.fleetName}
• *Nomor Kursi:* ${order.seats}
• *Nama Penumpang:* ${order.passengerName}
• *Total Tarif:* ${order.totalFormatted}

*Alamat Penjemputan (Door to Door):*
${order.pickupAddress}

*Alamat Tujuan:*
${order.dropoffAddress}

*Fasilitas:* Gratis Paket Makan Rest Area Tol & Snack Box.
----------------------------------------
_Terima kasih telah bepergian bersama ${BRAND_NAME}._`;
            }

            const url = `https://wa.me/${WA_PHONE}?text=${encodeURIComponent(msg)}`;
            window.open(url, '_blank');
        }

        function capitalize(str) {
            return str.charAt(0).toUpperCase() + str.slice(1);
        }

    </script>
</body>
</html>
