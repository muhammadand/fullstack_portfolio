<!DOCTYPE html>
<html lang="id" class="h-full bg-slate-950">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Sports Arena App Demo - {{ $client->brand_name ?? 'Apex Arena' }}</title>

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        sport: {
                            50: '#ecfdf5'
                            , 100: '#d1fae5'
                            , 200: '#a7f3d0'
                            , 300: '#6ee7b7'
                            , 400: '#34d399'
                            , 500: '#10b981'
                            , 600: '#059669'
                            , 700: '#047857'
                            , 800: '#065f46'
                            , 900: '#064e3b'
                            , dark: '#022c22'
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
    $brandName = $client->brand_name ?? 'Apex Arena';

    $jsonPath = resource_path('views/client-proposals/sport/data.json');
    if (file_exists($jsonPath)) {
    $sportDatabase = json_decode(file_get_contents($jsonPath), true);
    } else {
    $sportDatabase = [];
    }
    @endphp

    <!-- Top Banner for Desktop Preview -->
    <header class="w-full max-w-4xl px-4 py-2 hidden md:flex items-center justify-between text-xs text-slate-400 mb-2">
        <div class="flex items-center gap-2">
            <span class="w-2.5 h-2.5 rounded-full bg-emerald-400 animate-pulse"></span>
            <span class="font-bold text-white uppercase tracking-wider">Live Customer Mobile App Demo</span>
            <span class="text-slate-600">•</span>
            <span>Venue Booking, Membership & Community Hub</span>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('landing.dynamic', $client->slug) }}" class="text-slate-300 hover:text-white flex items-center gap-1.5 font-medium bg-slate-800/90 px-3 py-1.5 rounded-full border border-slate-700 transition">
                <i class="fas fa-arrow-left text-[10px]"></i>
                <span>Kembali ke Landing Page</span>
            </a>
            @if(isset($client->slug))
            <a href="{{ route('proposal.dynamic', $client->slug) }}" class="text-emerald-400 hover:text-white flex items-center gap-1.5 font-medium bg-slate-800/90 px-3 py-1.5 rounded-full border border-slate-700 transition">
                <i class="fas fa-file-invoice text-[10px]"></i>
                <span>Proposal Proyek</span>
            </a>
            @endif
        </div>
    </header>

    <!-- Main Mobile Device Screen -->
    <main class="w-full h-full sm:h-auto mobile-device-wrapper bg-slate-950 flex flex-col relative overflow-hidden">

        <!-- Mobile Status Bar (Emerald/Dark Theme) -->
        <div class="bg-gradient-to-r from-emerald-800 via-teal-800 to-slate-900 text-white px-6 pt-3 pb-2 flex items-center justify-between text-[11px] font-semibold shrink-0 z-40 select-none">
            <span id="statusBarClock" class="font-bold">09:41</span>
            <!-- Dynamic Island / Notch -->
            <div class="w-20 h-3.5 bg-slate-950/40 rounded-full mx-auto hidden sm:block"></div>
            <div class="flex items-center gap-1.5 text-[10px]">
                <i class="fas fa-signal"></i>
                <i class="fas fa-wifi"></i>
                <i class="fas fa-battery-full text-xs"></i>
            </div>
        </div>

        <!-- APP CONTAINER (SCROLLABLE VIEWPORT) -->
        <div id="appViewport" class="flex-1 overflow-y-auto no-scrollbar relative bg-slate-950 flex flex-col pb-20 text-slate-100">

            <!-- ================= VIEW 1: HOME ================= -->
            <section id="viewHome" class="flex-1 flex flex-col">
                <!-- Top User Header & Membership Badge -->
                <div class="bg-gradient-to-br from-emerald-700 via-teal-800 to-slate-900 text-white px-5 pt-2 pb-6 rounded-b-[2rem] shadow-xl relative overflow-hidden">
                    <div class="flex items-center justify-between mb-3.5">
                        <div class="flex items-center gap-2.5">
                            <div class="w-9 h-9 rounded-xl bg-emerald-400 text-slate-950 flex items-center justify-center text-sm font-black shadow-inner">
                                <i class="fas fa-trophy"></i>
                            </div>
                            <div>
                                <h2 class="text-[11px] text-emerald-200 font-medium leading-tight">Halo, Andi Pratama 👋</h2>
                                <h1 class="text-sm font-extrabold text-white tracking-tight">{{ $brandName }}</h1>
                            </div>
                        </div>
                        <div class="flex items-center gap-2">
                            <button type="button" onclick="switchView('viewMembership')" class="flex items-center gap-1 bg-amber-400/20 border border-amber-300/30 px-2.5 py-1 rounded-full text-[10px] text-amber-300 font-bold whitespace-nowrap">
                                <i class="fas fa-crown text-[9px]"></i>
                                <span>Gold Athlete</span>
                            </button>
                            <button type="button" onclick="switchView('viewHistory')" class="w-8 h-8 rounded-full bg-white/10 backdrop-blur-md flex items-center justify-center text-white text-xs relative">
                                <i class="far fa-bell"></i>
                                <span class="w-2 h-2 rounded-full bg-emerald-400 absolute top-1.5 right-1.5 ring-2 ring-emerald-800"></span>
                            </button>
                        </div>
                    </div>

                    <!-- Digital Member Benefit Card (Interactive) -->
                    <div class="bg-slate-900/90 rounded-2xl p-3.5 border border-emerald-500/30 text-slate-100 shadow-xl backdrop-blur-md">
                        <div class="flex items-center justify-between pb-2 mb-2.5 border-b border-slate-800">
                            <div class="flex items-center gap-1.5">
                                <i class="fas fa-id-card text-emerald-400 text-xs"></i>
                                <span class="text-xs font-bold text-white">Kartu Member Aktif</span>
                            </div>
                            <span class="text-[9px] bg-emerald-500/20 text-emerald-400 border border-emerald-500/30 px-2 py-0.5 rounded-full font-bold">
                                Diskon 12% All Court
                            </span>
                        </div>

                        <div class="grid grid-cols-2 gap-2 text-xs">
                            <div class="bg-slate-950 p-2 rounded-xl border border-slate-800">
                                <span class="text-[9px] text-slate-400 block font-semibold">Poin Loyalty Reward</span>
                                <span class="text-sm font-black text-amber-400">420 Poin</span>
                            </div>
                            <div class="bg-slate-950 p-2 rounded-xl border border-slate-800">
                                <span class="text-[9px] text-slate-400 block font-semibold">Hak Buat Komunitas</span>
                                <span class="text-sm font-black text-emerald-400">Aktif (3 Klub)</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 4 Quick Action Menus -->
                <div class="px-5 py-4">
                    <div class="grid grid-cols-4 gap-2 text-center">
                        <button type="button" onclick="openBookingSport('futsal')" class="flex flex-col items-center group">
                            <div class="w-11 h-11 rounded-2xl bg-emerald-500/20 text-emerald-400 border border-emerald-500/30 flex items-center justify-center text-base shadow-xs group-active:scale-95 transition">
                                <i class="fas fa-calendar-check"></i>
                            </div>
                            <span class="text-[10px] font-bold text-slate-300 mt-1.5 whitespace-nowrap">Booking</span>
                        </button>

                        <button type="button" onclick="switchView('viewCommunity')" class="flex flex-col items-center group">
                            <div class="w-11 h-11 rounded-2xl bg-teal-500/20 text-teal-400 border border-teal-500/30 flex items-center justify-center text-base shadow-xs group-active:scale-95 transition">
                                <i class="fas fa-users-rays"></i>
                            </div>
                            <span class="text-[10px] font-bold text-slate-300 mt-1.5 whitespace-nowrap">Komunitas</span>
                        </button>

                        <button type="button" onclick="openCreateCommunityModal()" class="flex flex-col items-center group">
                            <div class="w-11 h-11 rounded-2xl bg-amber-500/20 text-amber-400 border border-amber-500/30 flex items-center justify-center text-base shadow-xs group-active:scale-95 transition">
                                <i class="fas fa-plus-circle"></i>
                            </div>
                            <span class="text-[10px] font-bold text-slate-300 mt-1.5 whitespace-nowrap">Bikin Klub</span>
                        </button>

                        <button type="button" onclick="switchView('viewHistory')" class="flex flex-col items-center group">
                            <div class="w-11 h-11 rounded-2xl bg-indigo-500/20 text-indigo-400 border border-indigo-500/30 flex items-center justify-center text-base shadow-xs group-active:scale-95 transition">
                                <i class="fas fa-receipt"></i>
                            </div>
                            <span class="text-[10px] font-bold text-slate-300 mt-1.5 whitespace-nowrap">Tiket Saya</span>
                        </button>
                    </div>
                </div>

                <!-- Sport Category Horizontal Selector -->
                <div class="px-5 mb-4">
                    <div class="flex items-center justify-between mb-2">
                        <h3 class="text-xs font-bold text-white">Pilih Cabang Olahraga</h3>
                        <span class="text-[10px] text-emerald-400 font-semibold">5 Cabang Tersedia</span>
                    </div>

                    <div class="grid grid-cols-5 gap-1.5 text-center">
                        <button type="button" onclick="openBookingSport('futsal')" class="p-2 rounded-xl bg-slate-900 border border-slate-800 hover:border-emerald-500/50 transition">
                            <i class="fas fa-futbol text-emerald-400 text-sm block mb-1"></i>
                            <span class="text-[9px] font-bold text-slate-200 block truncate">Futsal</span>
                        </button>
                        <button type="button" onclick="openBookingSport('badminton')" class="p-2 rounded-xl bg-slate-900 border border-slate-800 hover:border-emerald-500/50 transition">
                            <i class="fas fa-feather text-emerald-400 text-sm block mb-1"></i>
                            <span class="text-[9px] font-bold text-slate-200 block truncate">Badminton</span>
                        </button>
                        <button type="button" onclick="openBookingSport('padel')" class="p-2 rounded-xl bg-slate-900 border border-slate-800 hover:border-emerald-500/50 transition">
                            <i class="fas fa-table-tennis-paddle-ball text-emerald-400 text-sm block mb-1"></i>
                            <span class="text-[9px] font-bold text-slate-200 block truncate">Padel</span>
                        </button>
                        <button type="button" onclick="openBookingSport('minisoccer')" class="p-2 rounded-xl bg-slate-900 border border-slate-800 hover:border-emerald-500/50 transition">
                            <i class="fas fa-futbol text-emerald-400 text-sm block mb-1"></i>
                            <span class="text-[9px] font-bold text-slate-200 block truncate">Mini Soccer</span>
                        </button>
                        <button type="button" onclick="openBookingSport('volly')" class="p-2 rounded-xl bg-slate-900 border border-slate-800 hover:border-emerald-500/50 transition">
                            <i class="fas fa-volleyball text-emerald-400 text-sm block mb-1"></i>
                            <span class="text-[9px] font-bold text-slate-200 block truncate">Voli</span>
                        </button>
                    </div>
                </div>

                <!-- Community / Mabar Live Callout Banner -->
                <div class="px-5 mb-4">
                    <div onclick="switchView('viewCommunity')" class="bg-gradient-to-r from-emerald-900 via-teal-900 to-slate-900 border border-emerald-500/40 rounded-2xl p-3.5 shadow-md flex items-center justify-between cursor-pointer hover:border-emerald-400 transition">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-xl bg-emerald-500/20 border border-emerald-500/30 flex items-center justify-center text-emerald-300 text-base shrink-0">
                                <i class="fas fa-bolt animate-pulse"></i>
                            </div>
                            <div>
                                <span class="bg-emerald-400 text-slate-950 text-[8px] font-black uppercase px-2 py-0.5 rounded-full">OPEN MABAR HARI INI</span>
                                <h4 class="text-xs font-bold text-white mt-0.5 leading-tight">Mabar Padel Ganda & Sparring Futsal</h4>
                                <p class="text-[9px] text-emerald-200">Klik untuk gabung atau cari pemain tambahan</p>
                            </div>
                        </div>
                        <i class="fas fa-chevron-right text-xs text-emerald-400 shrink-0"></i>
                    </div>
                </div>

                <!-- Popular Courts Quick Selection -->
                <div class="px-5 mb-6">
                    <div class="flex items-center justify-between mb-2.5">
                        <h3 class="text-xs font-bold text-white">Lapangan Terfavorit</h3>
                        <button type="button" onclick="switchView('viewBooking')" class="text-[10px] font-bold text-emerald-400">Lihat Semua</button>
                    </div>

                    <div class="space-y-2.5">
                        <!-- Court 1 -->
                        <div onclick="selectCourtToBook('FUT-01')" class="bg-slate-900 rounded-2xl p-3 border border-slate-800 hover:border-emerald-500/40 transition flex items-center justify-between cursor-pointer">
                            <div class="flex items-center gap-2.5 min-w-0">
                                <div class="w-9 h-9 rounded-xl bg-emerald-500/20 text-emerald-400 flex items-center justify-center text-xs shrink-0">
                                    <i class="fas fa-futbol"></i>
                                </div>
                                <div class="min-w-0">
                                    <p class="text-xs font-bold text-white truncate">Lapangan 1 (Vinyl Pro)</p>
                                    <p class="text-[10px] text-slate-400 truncate">Futsal • Lantai Vinyl 8mm Empuk</p>
                                </div>
                            </div>
                            <div class="text-right shrink-0 pl-2">
                                <p class="text-xs font-black text-emerald-400">Rp 120.000<span class="text-[8px] font-normal text-slate-400">/jam</span></p>
                                <span class="text-[8px] text-emerald-300 bg-emerald-500/10 px-1.5 py-0.5 rounded font-bold">Slot Ready</span>
                            </div>
                        </div>

                        <!-- Court 2 -->
                        <div onclick="selectCourtToBook('PDL-01')" class="bg-slate-900 rounded-2xl p-3 border border-slate-800 hover:border-emerald-500/40 transition flex items-center justify-between cursor-pointer">
                            <div class="flex items-center gap-2.5 min-w-0">
                                <div class="w-9 h-9 rounded-xl bg-teal-500/20 text-teal-400 flex items-center justify-center text-xs shrink-0">
                                    <i class="fas fa-table-tennis-paddle-ball"></i>
                                </div>
                                <div class="min-w-0">
                                    <p class="text-xs font-bold text-white truncate">Padel Arena 1 (Panoramic)</p>
                                    <p class="text-[10px] text-slate-400 truncate">Padel Tennis • Tempered Glass 12mm</p>
                                </div>
                            </div>
                            <div class="text-right shrink-0 pl-2">
                                <p class="text-xs font-black text-emerald-400">Rp 200.000<span class="text-[8px] font-normal text-slate-400">/jam</span></p>
                                <span class="text-[8px] text-amber-300 bg-amber-500/10 px-1.5 py-0.5 rounded font-bold">Trending</span>
                            </div>
                        </div>

                        <!-- Court 3 -->
                        <div onclick="selectCourtToBook('BDM-01')" class="bg-slate-900 rounded-2xl p-3 border border-slate-800 hover:border-emerald-500/40 transition flex items-center justify-between cursor-pointer">
                            <div class="flex items-center gap-2.5 min-w-0">
                                <div class="w-9 h-9 rounded-xl bg-cyan-500/20 text-cyan-400 flex items-center justify-center text-xs shrink-0">
                                    <i class="fas fa-feather"></i>
                                </div>
                                <div class="min-w-0">
                                    <p class="text-xs font-bold text-white truncate">Court 1 (BWF Pro 1)</p>
                                    <p class="text-[10px] text-slate-400 truncate">Badminton • Karpet Standar BWF</p>
                                </div>
                            </div>
                            <div class="text-right shrink-0 pl-2">
                                <p class="text-xs font-black text-emerald-400">Rp 50.000<span class="text-[8px] font-normal text-slate-400">/jam</span></p>
                                <span class="text-[8px] text-emerald-300 bg-emerald-500/10 px-1.5 py-0.5 rounded font-bold">Slot Ready</span>
                            </div>
                        </div>
                    </div>
                </div>
            </section>


            <!-- ================= VIEW 2: BOOKING COURT & SLOT PICKER ================= -->
            <section id="viewBooking" class="flex-1 hidden flex-col bg-slate-950">
                <!-- Top Nav Bar -->
                <div class="bg-gradient-to-r from-emerald-800 to-teal-800 text-white px-4 py-2.5 sticky top-0 z-30 flex items-center gap-2.5 shadow-md">
                    <button type="button" onclick="switchView('viewHome')" class="w-7 h-7 rounded-full bg-white/20 backdrop-blur-md flex items-center justify-center text-white text-xs shrink-0 active:scale-95">
                        <i class="fas fa-arrow-left"></i>
                    </button>
                    <div class="flex-1 min-w-0">
                        <h3 class="text-xs font-extrabold text-white">Booking Lapangan</h3>
                        <p class="text-[10px] text-emerald-200 truncate" id="bookingPageSubtitle">Pilih Lapangan & Slot Jam</p>
                    </div>
                </div>

                <!-- Date & Sport Category Filters -->
                <div class="p-3.5 space-y-3 flex-1">

                    <!-- Date Selector -->
                    <div class="bg-slate-900 border border-slate-800 rounded-2xl p-2.5 flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <i class="far fa-calendar-alt text-emerald-400 text-sm"></i>
                            <div>
                                <span class="text-[8px] uppercase tracking-wider text-slate-400 block font-bold">Tanggal Main</span>
                                <input type="date" id="demoBookingDate" value="{{ date('Y-m-d') }}" min="{{ date('Y-m-d') }}" class="bg-transparent text-xs font-bold text-white focus:outline-none cursor-pointer p-0" onchange="handleDemoDateChange(this.value)">
                            </div>
                        </div>
                        <span class="text-[10px] font-bold text-emerald-400 bg-emerald-500/10 px-2 py-0.5 rounded-full border border-emerald-500/20" id="formattedDemoDateBadge">
                            Hari Ini
                        </span>
                    </div>

                    <!-- Sport Tabs -->
                    <div class="flex items-center gap-1.5 overflow-x-auto no-scrollbar pb-1">
                        <button type="button" onclick="changeDemoSportTab('futsal')" class="demo-sport-btn px-3 py-1.5 rounded-xl text-[10px] font-bold bg-emerald-500 text-slate-950 whitespace-nowrap" data-sport="futsal">Futsal</button>
                        <button type="button" onclick="changeDemoSportTab('badminton')" class="demo-sport-btn px-3 py-1.5 rounded-xl text-[10px] font-bold bg-slate-900 text-slate-300 border border-slate-800 whitespace-nowrap" data-sport="badminton">Badminton</button>
                        <button type="button" onclick="changeDemoSportTab('padel')" class="demo-sport-btn px-3 py-1.5 rounded-xl text-[10px] font-bold bg-slate-900 text-slate-300 border border-slate-800 whitespace-nowrap" data-sport="padel">Padel</button>
                        <button type="button" onclick="changeDemoSportTab('minisoccer')" class="demo-sport-btn px-3 py-1.5 rounded-xl text-[10px] font-bold bg-slate-900 text-slate-300 border border-slate-800 whitespace-nowrap" data-sport="minisoccer">Mini Soccer</button>
                        <button type="button" onclick="changeDemoSportTab('volly')" class="demo-sport-btn px-3 py-1.5 rounded-xl text-[10px] font-bold bg-slate-900 text-slate-300 border border-slate-800 whitespace-nowrap" data-sport="volly">Voli</button>
                    </div>

                    <!-- Court Choice Dropdown / Radio -->
                    <div class="bg-slate-900 border border-slate-800 rounded-2xl p-3">
                        <label class="block text-[9px] font-extrabold uppercase text-slate-400 mb-1.5">Pilih Lapangan</label>
                        <div id="demoCourtsContainer" class="space-y-1.5">
                            <!-- Populated dynamically via JS -->
                        </div>
                    </div>

                    <!-- Interactive Slot Grid -->
                    <div class="bg-slate-900 border border-slate-800 rounded-2xl p-3">
                        <div class="flex items-center justify-between pb-2 mb-2 border-b border-slate-800">
                            <span class="text-[10px] font-extrabold uppercase text-white">Pilih Slot Jam</span>
                            <span class="text-[9px] text-slate-400">Bisa pilih > 1 slot</span>
                        </div>

                        <!-- Legends -->
                        <div class="flex items-center justify-around text-[9px] text-slate-400 mb-2.5 pb-2 border-b border-slate-800/60">
                            <span class="flex items-center gap-1"><span class="w-2.5 h-2.5 rounded bg-slate-800 border border-slate-700"></span> Kosong</span>
                            <span class="flex items-center gap-1"><span class="w-2.5 h-2.5 rounded bg-slate-950 border border-rose-900 text-rose-500"></span> Terisi</span>
                            <span class="flex items-center gap-1"><span class="w-2.5 h-2.5 rounded bg-emerald-500"></span> Dipilih</span>
                        </div>

                        <div id="demoTimeSlotsGrid" class="grid grid-cols-2 gap-2 max-h-52 overflow-y-auto no-scrollbar p-0.5">
                            <!-- Populated dynamically via JS -->
                        </div>
                    </div>

                    <!-- Add-ons Selector -->
                    <div class="bg-slate-900 border border-slate-800 rounded-2xl p-3 space-y-2">
                        <span class="text-[10px] font-extrabold uppercase text-slate-300 block">Add-on & Sewa Peralatan (Opsional)</span>

                        <label class="flex items-center justify-between p-2 rounded-xl bg-slate-950 border border-slate-800 text-xs cursor-pointer">
                            <span class="flex items-center gap-2">
                                <input type="checkbox" id="demoAddonWasit" onchange="updateDemoPriceCalculation()" class="text-emerald-500 rounded">
                                <span class="text-[11px] text-slate-200">Wasit Berlisensi (+50k/jam)</span>
                            </span>
                        </label>
                        <label class="flex items-center justify-between p-2 rounded-xl bg-slate-950 border border-slate-800 text-xs cursor-pointer">
                            <span class="flex items-center gap-2">
                                <input type="checkbox" id="demoAddonRompi" onchange="updateDemoPriceCalculation()" class="text-emerald-500 rounded">
                                <span class="text-[11px] text-slate-200">1 Set Rompi Tim (+25k)</span>
                            </span>
                        </label>
                        <label class="flex items-center justify-between p-2 rounded-xl bg-slate-950 border border-slate-800 text-xs cursor-pointer">
                            <span class="flex items-center gap-2">
                                <input type="checkbox" id="demoAddonAir" onchange="updateDemoPriceCalculation()" class="text-emerald-500 rounded">
                                <span class="text-[11px] text-slate-200">1 Dus Air Mineral 330ml (+35k)</span>
                            </span>
                        </label>
                    </div>

                </div>

                <!-- Bottom Floating Total & Next Button -->
                <div class="bg-slate-900 border-t border-slate-800 p-3.5 sticky bottom-0 z-30 shadow-[0_-4px_16px_rgba(0,0,0,0.4)]">
                    <div class="flex items-center justify-between mb-2">
                        <div>
                            <span class="text-[8px] font-bold text-slate-400 uppercase block">Total Bayar (Diskon Member 12%)</span>
                            <span class="text-base font-black text-emerald-400" id="demoSlotGrandTotal">Rp 0</span>
                        </div>
                        <span class="text-[9px] font-bold text-emerald-300 bg-emerald-500/10 px-2 py-0.5 rounded-full" id="demoSlotCountBadge">
                            0 Slot Jam
                        </span>
                    </div>

                    <button type="button" id="btnContinueToOrderForm" onclick="proceedToOrderForm()" disabled class="w-full py-3 rounded-xl bg-slate-800 text-slate-500 font-bold text-xs transition flex items-center justify-center gap-2">
                        <span>Lanjut Isi Data Tim & Pemesan</span>
                        <i class="fas fa-arrow-right text-[10px]"></i>
                    </button>
                </div>
            </section>


            <!-- ================= VIEW 3: ORDER FORM ================= -->
            <section id="viewOrderForm" class="flex-1 hidden flex-col bg-slate-950">
                <!-- Top Nav Bar -->
                <div class="bg-gradient-to-r from-emerald-800 to-teal-800 text-white px-4 py-2.5 sticky top-0 z-30 flex items-center gap-2.5 shadow-md">
                    <button type="button" onclick="switchView('viewBooking')" class="w-7 h-7 rounded-full bg-white/20 backdrop-blur-md flex items-center justify-center text-white text-xs shrink-0 active:scale-95">
                        <i class="fas fa-arrow-left"></i>
                    </button>
                    <div class="flex-1 min-w-0">
                        <h3 class="text-xs font-extrabold text-white">Data Tim & Pemesan</h3>
                        <p class="text-[10px] text-emerald-200 truncate">Konfirmasi Jadwal & Pembayaran</p>
                    </div>
                </div>

                <div class="p-3.5 space-y-3 flex-1">
                    <!-- Summary Box -->
                    <div class="bg-slate-900 border border-slate-800 rounded-2xl p-3.5 space-y-2">
                        <div class="flex items-center justify-between pb-2 border-b border-slate-800">
                            <span class="text-xs font-black text-white" id="orderSummaryCourtName">Lapangan 1 (Vinyl Pro)</span>
                            <span class="text-[9px] font-bold text-emerald-400 bg-emerald-500/20 px-2 py-0.5 rounded-full" id="orderSummarySportBadge">FUTSAL</span>
                        </div>
                        <div class="space-y-1 text-[11px] text-slate-300">
                            <p><i class="far fa-calendar-alt text-emerald-400 mr-1.5"></i> <span id="orderSummaryDate">Hari Ini</span></p>
                            <p><i class="far fa-clock text-emerald-400 mr-1.5"></i> <span id="orderSummarySlots">19:00 - 20:00 WIB</span></p>
                            <p><i class="fas fa-tag text-emerald-400 mr-1.5"></i> <span id="orderSummaryAddons">Tanpa Add-on</span></p>
                        </div>
                    </div>

                    <!-- Input Form -->
                    <form id="demoBookingForm" onsubmit="proceedToQRISPayment(event)" class="space-y-3">
                        <div class="bg-slate-900 rounded-2xl p-3.5 border border-slate-800 space-y-2.5">
                            <div>
                                <label class="block text-[9px] font-bold text-slate-400 mb-1 uppercase">Nama Penanggung Jawab</label>
                                <input type="text" id="demoCustName" required placeholder="Contoh: Andi Pratama" value="Andi Pratama" class="w-full h-9 bg-slate-950 border border-slate-800 rounded-xl px-3 text-xs text-white font-semibold focus:ring-2 focus:ring-emerald-500 focus:outline-none">
                            </div>

                            <div>
                                <label class="block text-[9px] font-bold text-slate-400 mb-1 uppercase">Nama Tim / Klub (Opsional)</label>
                                <input type="text" id="demoCustTeam" placeholder="Contoh: Garuda FC" value="Garuda Futsal Squad" class="w-full h-9 bg-slate-950 border border-slate-800 rounded-xl px-3 text-xs text-white font-semibold focus:ring-2 focus:ring-emerald-500 focus:outline-none">
                            </div>

                            <div>
                                <label class="block text-[9px] font-bold text-slate-400 mb-1 uppercase">Nomor WhatsApp Aktif</label>
                                <input type="tel" id="demoCustPhone" required placeholder="0812xxxxxxxx" value="081234567890" class="w-full h-9 bg-slate-950 border border-slate-800 rounded-xl px-3 text-xs text-white font-semibold focus:ring-2 focus:ring-emerald-500 focus:outline-none">
                            </div>
                        </div>

                        <!-- Price Breakdown -->
                        <div class="bg-slate-900 rounded-2xl p-3.5 border border-slate-800 space-y-1.5 text-xs">
                            <div class="flex items-center justify-between text-slate-400">
                                <span>Subtotal Lapangan</span>
                                <span id="breakdownCourtSubtotal" class="font-bold text-slate-200">Rp 0</span>
                            </div>
                            <div class="flex items-center justify-between text-slate-400">
                                <span>Add-on & Sewa Alat</span>
                                <span id="breakdownAddonSubtotal" class="font-bold text-slate-200">Rp 0</span>
                            </div>
                            <div class="flex items-center justify-between text-emerald-400">
                                <span>Diskon Member Gold (12%)</span>
                                <span id="breakdownDiscount" class="font-bold">-Rp 0</span>
                            </div>
                            <div class="pt-2 border-t border-slate-800 flex items-center justify-between text-sm font-black text-white">
                                <span>Total Pembayaran</span>
                                <span id="breakdownGrandTotal" class="text-emerald-400">Rp 0</span>
                            </div>
                        </div>

                        <button type="submit" class="w-full py-3 rounded-xl bg-gradient-to-r from-emerald-500 to-teal-400 hover:from-emerald-400 hover:to-teal-300 text-slate-950 font-black text-xs shadow-lg shadow-emerald-500/20 transition flex items-center justify-center gap-2">
                            <span>Lanjut Pembayaran QRIS</span>
                            <i class="fas fa-qrcode"></i>
                        </button>
                    </form>
                </div>
            </section>


            <!-- ================= VIEW 4: QRIS PAYMENT ================= -->
            <section id="viewPayment" class="flex-1 hidden flex-col bg-slate-950">
                <!-- Top Nav Bar -->
                <div class="bg-gradient-to-r from-emerald-800 to-teal-800 text-white px-4 py-2.5 sticky top-0 z-30 flex items-center gap-2.5 shadow-md">
                    <button type="button" onclick="switchView('viewOrderForm')" class="w-7 h-7 rounded-full bg-white/20 backdrop-blur-md flex items-center justify-center text-white text-xs shrink-0 active:scale-95">
                        <i class="fas fa-arrow-left"></i>
                    </button>
                    <div class="flex-1 min-w-0">
                        <h3 class="text-xs font-extrabold text-white">Pembayaran QRIS Instant</h3>
                        <p class="text-[10px] text-emerald-200 truncate">Verifikasi Otomatis Tanpa Biaya Admin</p>
                    </div>
                </div>

                <div class="p-3.5 flex-1 flex flex-col items-center justify-center text-center">
                    <!-- QRIS Card -->
                    <div class="bg-white text-slate-950 rounded-3xl p-4 max-w-xs w-full shadow-2xl border border-slate-200">
                        <div class="flex items-center justify-between pb-2 mb-2 border-b border-slate-100">
                            <span class="text-[11px] font-black tracking-wider text-slate-900">QRIS GPN</span>
                            <span class="text-[9px] font-bold text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded">AUTO-VERIFIED</span>
                        </div>

                        <p class="text-[9px] text-slate-400 uppercase font-bold">NMID: ID102988392110</p>
                        <h4 class="text-xs font-black text-slate-900 mt-0.5 truncate">{{ strtoupper($brandName) }} SPORT</h4>

                        <!-- Total Payment Amount -->
                        <div class="bg-emerald-50 rounded-xl p-2.5 my-2.5 border border-emerald-100">
                            <p class="text-[9px] text-slate-500 font-bold uppercase">Total Tagihan Booking</p>
                            <p class="text-base font-black text-emerald-700" id="qrisDisplayGrandTotal">Rp 120.000</p>
                            <p class="text-[9px] text-slate-600 mt-0.5 truncate" id="qrisDisplaySubtitle">Lapangan 1 (Vinyl Pro) • 1 Jam</p>
                        </div>

                        <!-- Realistic QR Pattern -->
                        <div class="relative w-44 h-44 mx-auto p-2 bg-white rounded-2xl border-2 border-slate-900 flex items-center justify-center shadow-inner">
                            <svg class="w-full h-full" viewBox="0 0 100 100" fill="currentColor">
                                <rect x="5" y="5" width="25" height="25" fill="#0f172a" rx="2"></rect>
                                <rect x="10" y="10" width="15" height="15" fill="#ffffff" rx="1"></rect>
                                <rect x="13" y="13" width="9" height="9" fill="#0f172a" rx="1"></rect>

                                <rect x="70" y="5" width="25" height="25" fill="#0f172a" rx="2"></rect>
                                <rect x="75" y="10" width="15" height="15" fill="#ffffff" rx="1"></rect>
                                <rect x="78" y="13" width="9" height="9" fill="#0f172a" rx="1"></rect>

                                <rect x="5" y="70" width="25" height="25" fill="#0f172a" rx="2"></rect>
                                <rect x="10" y="75" width="15" height="15" fill="#ffffff" rx="1"></rect>
                                <rect x="13" y="78" width="9" height="9" fill="#0f172a" rx="1"></rect>

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

                                <circle cx="50" cy="50" r="10" fill="#10b981"></circle>
                                <path d="M46 50 L49 53 L55 47" stroke="#ffffff" stroke-width="2" fill="none"></path>
                            </svg>
                        </div>

                        <!-- Timer Simulation -->
                        <div class="flex items-center justify-center gap-1.5 mt-2.5 text-[10px] text-slate-500 font-bold">
                            <i class="far fa-clock text-amber-500"></i>
                            <span>Batas Bayar: <strong class="text-slate-900">14:59</strong></span>
                        </div>
                    </div>

                    <!-- Instant Simulation Button -->
                    <button type="button" onclick="simulatePaymentSuccess()" class="mt-3.5 w-full max-w-xs py-3 rounded-xl bg-emerald-500 hover:bg-emerald-400 text-slate-950 font-black text-xs shadow-lg shadow-emerald-500/20 transition active:scale-95 flex items-center justify-center gap-2">
                        <i class="fas fa-bolt"></i>
                        <span>Simulasi Bayar Berhasil (Instant)</span>
                    </button>
                </div>
            </section>


            <!-- ================= VIEW 5: E-TICKET & QR PASS ================= -->
            <section id="viewTicket" class="flex-1 hidden flex-col bg-slate-950">
                <!-- Top Nav Bar -->
                <div class="bg-gradient-to-r from-emerald-800 to-teal-800 text-white px-4 py-2.5 flex items-center justify-between shadow-md">
                    <span class="text-xs font-bold flex items-center gap-1.5">
                        <i class="fas fa-check-circle text-emerald-300"></i> E-Ticket Booking Aktif
                    </span>
                    <button type="button" onclick="switchView('viewHome')" class="text-[10px] bg-white/20 hover:bg-white/30 px-2.5 py-1 rounded-full text-white font-bold">
                        Ke Beranda
                    </button>
                </div>

                <div class="p-3.5 space-y-3 flex-1">
                    <!-- Ticket Card -->
                    <div class="bg-white text-slate-950 rounded-3xl p-4 border border-slate-200 shadow-xl relative overflow-hidden">

                        <!-- Header -->
                        <div class="flex items-center justify-between pb-2 mb-2 border-b border-slate-100">
                            <div>
                                <span class="text-[8px] font-bold uppercase text-slate-400">Kode Booking</span>
                                <h4 class="text-xs font-black text-slate-900 tracking-wider" id="ticketBookingCode">SPT-982103</h4>
                            </div>
                            <span class="px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-800 text-[9px] font-extrabold">
                                LUNAS • CHECK-IN READY
                            </span>
                        </div>

                        <!-- Court & Sport Name -->
                        <div class="py-1">
                            <span class="text-[9px] font-bold text-emerald-600 uppercase" id="ticketSportBadge">FUTSAL ARENA</span>
                            <h3 class="text-sm font-black text-slate-900" id="ticketCourtName">Lapangan 1 (Vinyl Pro)</h3>
                        </div>

                        <!-- Detail Grid -->
                        <div class="grid grid-cols-2 gap-2 bg-slate-50 p-2.5 rounded-2xl my-2 text-[10px] border border-slate-100">
                            <div>
                                <p class="text-[8px] text-slate-400 font-bold uppercase">Tanggal Main</p>
                                <p class="font-bold text-slate-900 truncate" id="ticketPlayDate">Hari Ini</p>
                            </div>
                            <div>
                                <p class="text-[8px] text-slate-400 font-bold uppercase">Slot Jam</p>
                                <p class="font-black text-emerald-700 truncate" id="ticketPlaySlots">19:00 - 20:00 WIB</p>
                            </div>
                            <div>
                                <p class="text-[8px] text-slate-400 font-bold uppercase">Penanggung Jawab</p>
                                <p class="font-bold text-slate-900 truncate" id="ticketLeadName">Andi Pratama</p>
                            </div>
                            <div>
                                <p class="text-[8px] text-slate-400 font-bold uppercase">Tim / Klub</p>
                                <p class="font-bold text-slate-800 truncate" id="ticketTeamName">Garuda FC</p>
                            </div>
                            <div class="col-span-2 pt-1 border-t border-slate-200/60 flex items-center justify-between">
                                <span class="text-[8px] text-slate-400 font-bold uppercase">Total Pembayaran</span>
                                <span class="font-black text-xs text-emerald-700" id="ticketTotalPriceDisplay">Rp 120.000</span>
                            </div>
                        </div>

                        <!-- Barcode Simulation -->
                        <div class="text-center pt-2 border-t border-dashed border-slate-200">
                            <div class="font-mono text-base tracking-widest text-slate-900 font-bold">
                                ||||||| | ||||| ||| ||||||| | ||
                            </div>
                            <p class="text-[8px] text-slate-400 mt-0.5">Tunjukkan barcode ini ke petugas resepsionis saat check-in</p>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="space-y-2">
                        <button type="button" onclick="shareTicketToWhatsApp()" class="w-full py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white font-bold text-xs shadow-md transition flex items-center justify-center gap-2">
                            <i class="fab fa-whatsapp text-sm"></i>
                            <span>Bagikan E-Tiket ke Grup WhatsApp</span>
                        </button>
                        <button type="button" onclick="switchView('viewHistory')" class="w-full py-2.5 rounded-xl bg-slate-900 hover:bg-slate-800 text-emerald-400 border border-slate-800 font-bold text-xs transition flex items-center justify-center gap-2">
                            <i class="fas fa-receipt"></i>
                            <span>Buka Riwayat Tiket Saya</span>
                        </button>
                    </div>
                </div>
            </section>


            <!-- ================= VIEW 6: COMMUNITY & MABAR HUB (CRUCIAL FEATURE) ================= -->
            <section id="viewCommunity" class="flex-1 hidden flex-col bg-slate-950">
                <!-- Top Nav Bar -->
                <div class="bg-gradient-to-r from-emerald-800 to-teal-800 text-white px-4 py-2.5 sticky top-0 z-30 flex items-center justify-between shadow-md">
                    <div class="flex items-center gap-2.5">
                        <button type="button" onclick="switchView('viewHome')" class="w-7 h-7 rounded-full bg-white/20 backdrop-blur-md flex items-center justify-center text-white text-xs shrink-0 active:scale-95">
                            <i class="fas fa-arrow-left"></i>
                        </button>
                        <div>
                            <h3 class="text-xs font-extrabold text-white">Komunitas & Mabar Hub</h3>
                            <p class="text-[10px] text-emerald-200">Klub Olahraga & Papan Sparring</p>
                        </div>
                    </div>
                    <button type="button" onclick="openCreateCommunityModal()" class="text-[9px] font-bold text-slate-950 bg-emerald-400 hover:bg-emerald-300 px-2.5 py-1 rounded-full flex items-center gap-1 shadow-sm">
                        <i class="fas fa-plus"></i>
                        <span>Bikin Klub</span>
                    </button>
                </div>

                <div class="p-3.5 space-y-3.5 flex-1">

                    <!-- Community / Mabar Tabs -->
                    <div class="flex items-center gap-2">
                        <button type="button" onclick="switchCommunityTab('clubs')" id="tabClubsBtn" class="flex-1 py-1.5 rounded-xl text-xs font-bold bg-emerald-500 text-slate-950 text-center transition">
                            Daftar Komunitas
                        </button>
                        <button type="button" onclick="switchCommunityTab('mabar')" id="tabMabarBtn" class="flex-1 py-1.5 rounded-xl text-xs font-bold bg-slate-900 text-slate-400 border border-slate-800 text-center transition">
                            Papan Mabar & Sparring
                        </button>
                    </div>

                    <!-- TAB 1: CLUBS CONTAINER -->
                    <div id="communityClubsSection" class="space-y-2.5">
                        <!-- Populated dynamically via JS -->
                    </div>

                    <!-- TAB 2: OPEN MABAR CONTAINER -->
                    <div id="communityMabarSection" class="hidden space-y-2.5">
                        <div class="flex items-center justify-between pb-1">
                            <span class="text-[10px] font-bold text-slate-400">Papan Mabar Terbuka</span>
                            <button type="button" onclick="openCreateMabarModal()" class="text-[10px] text-amber-400 font-bold hover:underline">
                                + Buka Slot Mabar
                            </button>
                        </div>
                        <div id="mabarListContainer" class="space-y-2.5">
                            <!-- Populated dynamically via JS -->
                        </div>
                    </div>

                </div>
            </section>


            <!-- ================= VIEW 7: MEMBERSHIP HUB ================= -->
            <section id="viewMembership" class="flex-1 hidden flex-col bg-slate-950">
                <!-- Top Nav Bar -->
                <div class="bg-gradient-to-r from-emerald-800 to-teal-800 text-white px-4 py-2.5 sticky top-0 z-30 flex items-center gap-2.5 shadow-md">
                    <button type="button" onclick="switchView('viewHome')" class="w-7 h-7 rounded-full bg-white/20 backdrop-blur-md flex items-center justify-center text-white text-xs shrink-0 active:scale-95">
                        <i class="fas fa-arrow-left"></i>
                    </button>
                    <div class="flex-1 min-w-0">
                        <h3 class="text-xs font-extrabold text-white">Kartu & Membership Hub</h3>
                        <p class="text-[10px] text-emerald-200 truncate">Status Langganan & Keuntungan Member</p>
                    </div>
                </div>

                <div class="p-3.5 space-y-3 flex-1">
                    <!-- Digital Card (Gold VIP) -->
                    <div class="bg-gradient-to-br from-amber-600 via-amber-700 to-slate-900 rounded-3xl p-4 text-white shadow-2xl border border-amber-400/40 relative overflow-hidden">
                        <div class="flex items-center justify-between pb-3 mb-4 border-b border-amber-500/30">
                            <div>
                                <span class="text-[8px] font-bold uppercase tracking-widest text-amber-200">OFFICIAL MEMBER CARD</span>
                                <h4 class="text-sm font-black text-white">{{ strtoupper($brandName) }} ARENA</h4>
                            </div>
                            <span class="px-2.5 py-1 rounded-full bg-amber-400 text-slate-950 text-[9px] font-black uppercase">
                                GOLD ATHLETE
                            </span>
                        </div>

                        <div class="mb-4">
                            <p class="text-[9px] text-amber-200 uppercase font-semibold">Nama Pemilik</p>
                            <h3 class="text-base font-black text-white">Andi Pratama</h3>
                            <p class="text-[10px] font-mono text-amber-100">MEM-ID: 2026-GLD-88219</p>
                        </div>

                        <div class="flex items-center justify-between pt-2 border-t border-amber-500/30 text-xs">
                            <div>
                                <span class="text-[8px] text-amber-200 block uppercase">Diskon Sewa</span>
                                <span class="font-black text-white">12% All Court</span>
                            </div>
                            <div class="text-right">
                                <span class="text-[8px] text-amber-200 block uppercase">Bikin Komunitas</span>
                                <span class="font-black text-white">Aktif (3 Klub)</span>
                            </div>
                        </div>
                    </div>

                    <!-- Member Perks Detail -->
                    <div class="bg-slate-900 border border-slate-800 rounded-2xl p-3.5 space-y-2 text-xs">
                        <h4 class="font-bold text-white border-b border-slate-800 pb-1.5 flex items-center gap-1.5">
                            <i class="fas fa-gift text-emerald-400"></i>
                            <span>Benefit Status Gold Athlete Anda</span>
                        </h4>
                        <ul class="space-y-2 text-slate-300 text-[11px]">
                            <li class="flex items-start gap-2">
                                <i class="fas fa-check text-emerald-400 mt-0.5"></i>
                                <span>Diskon otomatis 12% pada setiap transaksi sewa lapangan.</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <i class="fas fa-check text-emerald-400 mt-0.5"></i>
                                <span>Bebas membuat & mengelola hingga 3 Komunitas / Klub Mabar.</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <i class="fas fa-check text-emerald-400 mt-0.5"></i>
                                <span>Prioritas booking slot jam malam prime-time (19:00 - 22:00 WIB).</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <i class="fas fa-check text-emerald-400 mt-0.5"></i>
                                <span>Poin reward 2x lipat setiap jam bermain.</span>
                            </li>
                        </ul>
                    </div>

                    <!-- Upgrade to Diamond VIP -->
                    <div class="bg-slate-900 border border-emerald-500/30 rounded-2xl p-3.5 flex items-center justify-between">
                        <div>
                            <span class="text-[9px] font-bold text-emerald-400 uppercase">Upgrade Tingkat VIP</span>
                            <h5 class="text-xs font-black text-white">Diamond VIP Club</h5>
                            <p class="text-[10px] text-slate-400">Diskon 20% + Gratis Alat + Unlimited Komunitas</p>
                        </div>
                        <a href="https://wa.me/{{ $cleanWa }}?text={{ urlencode('Halo ' . $brandName . ', saya ingin upgrade Membership ke Diamond VIP.') }}" target="_blank" class="px-3 py-1.5 rounded-xl bg-emerald-500 hover:bg-emerald-400 text-slate-950 font-black text-[10px] whitespace-nowrap">
                            Upgrade VIP
                        </a>
                    </div>
                </div>
            </section>


            <!-- ================= VIEW 8: ORDER HISTORY ================= -->
            <section id="viewHistory" class="flex-1 hidden flex-col bg-slate-950">
                <!-- Top Nav Bar -->
                <div class="bg-gradient-to-r from-emerald-800 to-teal-800 text-white px-4 py-2.5 sticky top-0 z-30 flex items-center justify-between shadow-md">
                    <div class="flex items-center gap-2.5">
                        <button type="button" onclick="switchView('viewHome')" class="w-7 h-7 rounded-full bg-white/20 backdrop-blur-md flex items-center justify-center text-white text-xs shrink-0 active:scale-95">
                            <i class="fas fa-arrow-left"></i>
                        </button>
                        <div>
                            <h3 class="text-xs font-extrabold text-white">Riwayat Tiket Booking</h3>
                            <p class="text-[10px] text-emerald-200">Daftar E-Ticket Lapangan Saya</p>
                        </div>
                    </div>
                    <button type="button" onclick="resetSportOrdersDemo()" class="text-[9px] font-bold text-white bg-white/20 px-2 py-1 rounded-full">
                        Reset Demo
                    </button>
                </div>

                <div class="p-3.5 flex-1">
                    <div id="demoHistoryContainer" class="space-y-2.5">
                        <!-- Populated dynamically via JS -->
                    </div>

                    <div id="emptyHistoryBox" class="hidden text-center py-12 bg-slate-900 rounded-2xl border border-dashed border-slate-800 p-5">
                        <i class="fas fa-ticket-simple text-3xl text-slate-600 mb-2"></i>
                        <h4 class="text-xs font-bold text-white">Belum Ada Tiket Booking</h4>
                        <p class="text-[10px] text-slate-400 mt-0.5">Silakan lakukan simulasi sewa lapangan di menu booking.</p>
                        <button type="button" onclick="switchView('viewBooking')" class="mt-3 px-4 py-2 rounded-xl bg-emerald-500 text-slate-950 text-xs font-black">
                            Cari Jadwal Lapangan
                        </button>
                    </div>
                </div>
            </section>

        </div>

        <!-- ================= CREATE COMMUNITY MODAL (POPUP) ================= -->
        <div id="createCommunityModal" class="fixed inset-0 z-50 bg-slate-950/80 backdrop-blur-md hidden items-center justify-center p-4">
            <div class="bg-slate-900 border border-slate-800 rounded-3xl max-w-xs w-full p-4 text-white shadow-2xl relative" onclick="event.stopPropagation()">
                <div class="flex items-center justify-between pb-2 mb-3 border-b border-slate-800">
                    <h4 class="text-xs font-black text-white flex items-center gap-1.5">
                        <i class="fas fa-plus-circle text-emerald-400"></i> Buat Komunitas / Klub Baru
                    </h4>
                    <button type="button" onclick="closeCreateCommunityModal()" class="text-slate-400 hover:text-white text-xs">
                        <i class="fas fa-times"></i>
                    </button>
                </div>

                <form id="createClubForm" onsubmit="saveNewCommunity(event)" class="space-y-2.5 text-xs">
                    <div>
                        <label class="block text-[8px] font-bold text-slate-400 uppercase mb-0.5">Nama Klub / Komunitas</label>
                        <input type="text" id="newClubName" required placeholder="Contoh: Bandung Padel Warriors" class="w-full h-8 bg-slate-950 border border-slate-800 rounded-lg px-2 text-xs text-white focus:outline-none focus:border-emerald-500">
                    </div>

                    <div class="grid grid-cols-2 gap-2">
                        <div>
                            <label class="block text-[8px] font-bold text-slate-400 uppercase mb-0.5">Cabang Olahraga</label>
                            <select id="newClubSport" class="w-full h-8 bg-slate-950 border border-slate-800 rounded-lg px-2 text-xs text-white focus:outline-none">
                                <option value="futsal">Futsal</option>
                                <option value="badminton">Badminton</option>
                                <option value="padel" selected>Padel Tennis</option>
                                <option value="minisoccer">Mini Soccer</option>
                                <option value="volly">Bola Voli</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-[8px] font-bold text-slate-400 uppercase mb-0.5">Tingkat Kemampuan</label>
                            <select id="newClubLevel" class="w-full h-8 bg-slate-950 border border-slate-800 rounded-lg px-2 text-xs text-white focus:outline-none">
                                <option value="All Level Fun">All Level Fun</option>
                                <option value="Beginner / Newbie">Beginner / Newbie</option>
                                <option value="Intermediate">Intermediate</option>
                                <option value="Semi-Pro / Advanced">Semi-Pro</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block text-[8px] font-bold text-slate-400 uppercase mb-0.5">Jadwal Rutin Mabar</label>
                        <input type="text" id="newClubSchedule" required placeholder="Contoh: Setiap Sabtu (17:00 WIB)" value="Setiap Sabtu Sore (16:00 WIB)" class="w-full h-8 bg-slate-950 border border-slate-800 rounded-lg px-2 text-xs text-white focus:outline-none focus:border-emerald-500">
                    </div>

                    <div>
                        <label class="block text-[8px] font-bold text-slate-400 uppercase mb-0.5">Deskripsi Singkat Klub</label>
                        <textarea id="newClubDesc" rows="2" placeholder="Komunitas fun match santai & latihan bareng..." class="w-full bg-slate-950 border border-slate-800 rounded-lg p-2 text-xs text-white focus:outline-none focus:border-emerald-500">Komunitas terbuka untuk silaturahmi & mabar rutin mingguan.</textarea>
                    </div>

                    <button type="submit" class="w-full py-2.5 rounded-xl bg-emerald-500 hover:bg-emerald-400 text-slate-950 font-black text-xs shadow-md transition">
                        Simpan & Publikasikan Komunitas
                    </button>
                </form>
            </div>
        </div>

        <!-- ================= CREATE MABAR SLOT MODAL (POPUP) ================= -->
        <div id="createMabarModal" class="fixed inset-0 z-50 bg-slate-950/80 backdrop-blur-md hidden items-center justify-center p-4">
            <div class="bg-slate-900 border border-slate-800 rounded-3xl max-w-xs w-full p-4 text-white shadow-2xl relative" onclick="event.stopPropagation()">
                <div class="flex items-center justify-between pb-2 mb-3 border-b border-slate-800">
                    <h4 class="text-xs font-black text-white flex items-center gap-1.5">
                        <i class="fas fa-bullhorn text-amber-400"></i> Buka Slot Mabar / Sparring
                    </h4>
                    <button type="button" onclick="closeCreateMabarModal()" class="text-slate-400 hover:text-white text-xs">
                        <i class="fas fa-times"></i>
                    </button>
                </div>

                <form id="createMabarForm" onsubmit="saveNewMabarSlot(event)" class="space-y-2.5 text-xs">
                    <div>
                        <label class="block text-[8px] font-bold text-slate-400 uppercase mb-0.5">Judul Sesi Mabar / Sparring</label>
                        <input type="text" id="mabarTitle" required placeholder="Contoh: Mabar Badminton Ganda (Butuh 2 Orang)" class="w-full h-8 bg-slate-950 border border-slate-800 rounded-lg px-2 text-xs text-white focus:outline-none focus:border-amber-400">
                    </div>

                    <div class="grid grid-cols-2 gap-2">
                        <div>
                            <label class="block text-[8px] font-bold text-slate-400 uppercase mb-0.5">Cabang Olahraga</label>
                            <select id="mabarSportSelect" class="w-full h-8 bg-slate-950 border border-slate-800 rounded-lg px-2 text-xs text-white focus:outline-none">
                                <option value="badminton">Badminton</option>
                                <option value="futsal">Futsal</option>
                                <option value="padel">Padel Tennis</option>
                                <option value="minisoccer">Mini Soccer</option>
                                <option value="volly">Bola Voli</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-[8px] font-bold text-slate-400 uppercase mb-0.5">Slot Pemain Dibutuhkan</label>
                            <input type="text" id="mabarSlotsNeeded" required placeholder="Contoh: 2 Orang" value="2 Orang" class="w-full h-8 bg-slate-950 border border-slate-800 rounded-lg px-2 text-xs text-white focus:outline-none focus:border-amber-400">
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-2">
                        <div>
                            <label class="block text-[8px] font-bold text-slate-400 uppercase mb-0.5">Hari / Tanggal</label>
                            <input type="text" id="mabarDateText" required placeholder="Contoh: Besok Malam" value="Besok Malam" class="w-full h-8 bg-slate-950 border border-slate-800 rounded-lg px-2 text-xs text-white focus:outline-none focus:border-amber-400">
                        </div>
                        <div>
                            <label class="block text-[8px] font-bold text-slate-400 uppercase mb-0.5">Jam Main</label>
                            <input type="text" id="mabarTimeText" required placeholder="19:00 - 21:00 WIB" value="19:00 - 21:00 WIB" class="w-full h-8 bg-slate-950 border border-slate-800 rounded-lg px-2 text-xs text-white focus:outline-none focus:border-amber-400">
                        </div>
                    </div>

                    <div>
                        <label class="block text-[8px] font-bold text-slate-400 uppercase mb-0.5">Patungan Biaya per Orang / Tim</label>
                        <input type="text" id="mabarCostText" required placeholder="Contoh: Rp 35.000 / orang" value="Rp 35.000 / orang" class="w-full h-8 bg-slate-950 border border-slate-800 rounded-lg px-2 text-xs text-white focus:outline-none focus:border-amber-400">
                    </div>

                    <button type="submit" class="w-full py-2.5 rounded-xl bg-amber-400 hover:bg-amber-300 text-slate-950 font-black text-xs shadow-md transition">
                        Posting Slot Mabar ke Komunitas
                    </button>
                </form>
            </div>
        </div>

        <!-- ================= APP BOTTOM NAVIGATION BAR ================= -->
        <nav class="bg-slate-900 border-t border-slate-800 px-6 py-2 flex items-center justify-between absolute bottom-0 inset-x-0 z-40 text-slate-400">
            <button type="button" onclick="switchView('viewHome')" class="nav-tab-btn flex flex-col items-center gap-0.5 text-emerald-400" id="tabNavHome">
                <i class="fas fa-house text-sm"></i>
                <span class="text-[9px] font-bold">Beranda</span>
            </button>

            <button type="button" onclick="switchView('viewBooking')" class="nav-tab-btn flex flex-col items-center gap-0.5 hover:text-emerald-400" id="tabNavBooking">
                <i class="fas fa-calendar-check text-sm"></i>
                <span class="text-[9px] font-bold">Booking</span>
            </button>

            <button type="button" onclick="switchView('viewCommunity')" class="nav-tab-btn flex flex-col items-center gap-0.5 hover:text-emerald-400" id="tabNavCommunity">
                <i class="fas fa-users-rays text-sm"></i>
                <span class="text-[9px] font-bold">Komunitas</span>
            </button>

            <button type="button" onclick="switchView('viewHistory')" class="nav-tab-btn flex flex-col items-center gap-0.5 hover:text-emerald-400" id="tabNavHistory">
                <i class="fas fa-receipt text-sm"></i>
                <span class="text-[9px] font-bold">Tiket</span>
            </button>

            <a href="https://wa.me/{{ $cleanWa }}?text={{ urlencode('Halo CS ' . $brandName . ', saya ingin tanya jadwal sewa lapangan.') }}" target="_blank" class="nav-tab-btn flex flex-col items-center gap-0.5 hover:text-emerald-400">
                <i class="fab fa-whatsapp text-sm text-emerald-400"></i>
                <span class="text-[9px] font-bold text-emerald-400">Bantuan</span>
            </a>
        </nav>

    </main>

    <!-- JS Engine for Sports Arena Demo -->
    <script>
        const DB = @json($sportDatabase);
        const BRAND_NAME = "{{ $brandName }}";
        const WA_PHONE = "{{ $cleanWa }}";

        // Global State
        let state = {
            activeView: 'viewHome'
            , selectedSport: 'futsal'
            , selectedCourtId: 'FUT-01'
            , selectedDate: new Date().toISOString().split('T')[0]
            , selectedSlots: []
            , currentOrder: null
        };

        document.addEventListener('DOMContentLoaded', () => {
            initClock();
            initDatePicker();
            renderDemoCourts();
            renderDemoSlots();
            renderCommunityList();
            renderMabarList();
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

        function initDatePicker() {
            const dateInput = document.getElementById('demoBookingDate');
            if (dateInput) {
                const today = new Date().toISOString().split('T')[0];
                dateInput.min = today;
                if (!dateInput.value) dateInput.value = today;
                state.selectedDate = dateInput.value;
            }
        }

        function handleDemoDateChange(val) {
            state.selectedDate = val;
            const badge = document.getElementById('formattedDemoDateBadge');
            if (badge) {
                const today = new Date().toISOString().split('T')[0];
                badge.textContent = (val === today) ? 'Hari Ini' : val;
            }
            renderDemoSlots();
        }

        // View Switcher Engine
        function switchView(viewId) {
            const views = ['viewHome', 'viewBooking', 'viewOrderForm', 'viewPayment', 'viewTicket', 'viewHistory', 'viewMembership', 'viewCommunity'];
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

            // Update bottom navigation bar highlights
            const tabHome = document.getElementById('tabNavHome');
            const tabBooking = document.getElementById('tabNavBooking');
            const tabCommunity = document.getElementById('tabNavCommunity');
            const tabHistory = document.getElementById('tabNavHistory');

            if (tabHome && tabBooking && tabCommunity && tabHistory) {
                tabHome.className = `nav-tab-btn flex flex-col items-center gap-0.5 ${viewId === 'viewHome' ? 'text-emerald-400' : 'text-slate-400'}`;
                tabBooking.className = `nav-tab-btn flex flex-col items-center gap-0.5 ${viewId === 'viewBooking' || viewId === 'viewOrderForm' ? 'text-emerald-400' : 'text-slate-400'}`;
                tabCommunity.className = `nav-tab-btn flex flex-col items-center gap-0.5 ${viewId === 'viewCommunity' ? 'text-emerald-400' : 'text-slate-400'}`;
                tabHistory.className = `nav-tab-btn flex flex-col items-center gap-0.5 ${viewId === 'viewHistory' || viewId === 'viewTicket' ? 'text-emerald-400' : 'text-slate-400'}`;
            }

            state.activeView = viewId;
            const viewport = document.getElementById('appViewport');
            if (viewport) viewport.scrollTop = 0;
        }

        // 1. Sport Tab Switching in Booking View
        function openBookingSport(sportId) {
            state.selectedSport = sportId;
            changeDemoSportTab(sportId);
            switchView('viewBooking');
        }

        function changeDemoSportTab(sportId) {
            state.selectedSport = sportId;
            state.selectedSlots = [];

            const buttons = document.querySelectorAll('.demo-sport-btn');
            buttons.forEach(btn => {
                if (btn.dataset.sport === sportId) {
                    btn.className = 'demo-sport-btn px-3 py-1.5 rounded-xl text-[10px] font-bold bg-emerald-500 text-slate-950 whitespace-nowrap shadow-sm';
                } else {
                    btn.className = 'demo-sport-btn px-3 py-1.5 rounded-xl text-[10px] font-bold bg-slate-900 text-slate-300 border border-slate-800 whitespace-nowrap';
                }
            });

            // Select first court of this sport
            const sportObj = DB.sports.find(s => s.id === sportId) || DB.sports[0];
            if (sportObj && sportObj.courts.length > 0) {
                state.selectedCourtId = sportObj.courts[0].id;
            }

            renderDemoCourts();
            renderDemoSlots();
        }

        function selectCourtToBook(courtId) {
            let foundSport = null;
            DB.sports.forEach(s => {
                if (s.courts.some(c => c.id === courtId)) {
                    foundSport = s.id;
                }
            });

            if (foundSport) {
                state.selectedSport = foundSport;
                state.selectedCourtId = courtId;
                changeDemoSportTab(foundSport);
                renderDemoCourts();
                switchView('viewBooking');
            }
        }

        function renderDemoCourts() {
            const container = document.getElementById('demoCourtsContainer');
            if (!container || !DB.sports) return;
            container.innerHTML = '';

            const sport = DB.sports.find(s => s.id === state.selectedSport) || DB.sports[0];

            sport.courts.forEach(court => {
                const isSelected = (court.id === state.selectedCourtId);
                const label = document.createElement('label');
                label.className = `flex items-center justify-between p-2.5 rounded-xl border cursor-pointer transition ${
                    isSelected ? 'border-emerald-500 bg-emerald-500/10' : 'border-slate-800 bg-slate-950 hover:border-slate-700'
                }`;

                label.innerHTML = `
                    <div class="flex items-center gap-2 min-w-0">
                        <input type="radio" name="courtRadio" value="${court.id}" ${isSelected ? 'checked' : ''} onchange="onCourtRadioChange('${court.id}')" class="text-emerald-500">
                        <div class="min-w-0">
                            <p class="text-xs font-bold text-white truncate">${court.name}</p>
                            <p class="text-[9px] text-slate-400 truncate">${court.type}</p>
                        </div>
                    </div>
                    <div class="text-right shrink-0">
                        <p class="text-xs font-black text-emerald-400">Rp ${court.price_regular.toLocaleString('id-ID')}<span class="text-[8px] font-normal text-slate-400">/jam</span></p>
                    </div>
                `;
                container.appendChild(label);
            });
        }

        function onCourtRadioChange(courtId) {
            state.selectedCourtId = courtId;
            state.selectedSlots = [];
            renderDemoCourts();
            renderDemoSlots();
        }

        // 2. Render Interactive Time Slots Grid
        function renderDemoSlots() {
            const grid = document.getElementById('demoTimeSlotsGrid');
            if (!grid || !DB.time_slots) return;
            grid.innerHTML = '';

            state.selectedSlots = [];

            const sport = DB.sports.find(s => s.id === state.selectedSport) || DB.sports[0];
            const court = sport.courts.find(c => c.id === state.selectedCourtId) || sport.courts[0];

            DB.time_slots.forEach((slot, idx) => {
                // Mock booked slots (indices 2, 7, 13)
                const isBooked = [2, 7, 13].includes(idx);
                const slotPrice = slot.is_peak ? court.price_peak : court.price_regular;

                const btn = document.createElement('button');
                btn.type = 'button';
                btn.dataset.time = slot.time;
                btn.dataset.price = slotPrice;

                if (isBooked) {
                    btn.className = 'p-2 rounded-xl bg-slate-950 text-slate-600 text-[10px] font-bold border border-slate-900 cursor-not-allowed flex items-center justify-between';
                    btn.disabled = true;
                    btn.innerHTML = `<span>${slot.time}</span><span class="text-[8px] text-rose-500 font-semibold">Terisi</span>`;
                } else {
                    btn.className = 'slot-btn p-2 rounded-xl bg-slate-950 text-slate-300 hover:border-emerald-500 text-[10px] font-bold border border-slate-800 flex items-center justify-between transition cursor-pointer';
                    btn.innerHTML = `<span>${slot.time}</span><span class="text-[8px] ${slot.is_peak ? 'text-amber-400 font-bold' : 'text-emerald-400 font-semibold'}">Rp ${(slotPrice/1000)}k</span>`;
                    btn.onclick = () => toggleDemoSlot(btn, slot, slotPrice);
                }
                grid.appendChild(btn);
            });

            updateDemoPriceCalculation();
        }

        function toggleDemoSlot(btn, slot, price) {
            const index = state.selectedSlots.findIndex(s => s.time === slot.time);
            if (index > -1) {
                state.selectedSlots.splice(index, 1);
                btn.className = 'slot-btn p-2 rounded-xl bg-slate-950 text-slate-300 hover:border-emerald-500 text-[10px] font-bold border border-slate-800 flex items-center justify-between transition cursor-pointer';
            } else {
                if (state.selectedSlots.length >= 3) {
                    alert('Maksimal booking 3 jam per transaksi demo.');
                    return;
                }
                state.selectedSlots.push({
                    time: slot.time
                    , is_peak: slot.is_peak
                    , price: price
                });
                btn.className = 'slot-btn p-2 rounded-xl bg-emerald-500 text-slate-950 text-[10px] font-black border-2 border-emerald-400 flex items-center justify-between transition cursor-pointer shadow-md';
            }

            updateDemoPriceCalculation();
        }

        function updateDemoPriceCalculation() {
            let courtTotal = 0;
            state.selectedSlots.forEach(s => {
                courtTotal += s.price;
            });

            let addonTotal = 0;
            const wasit = document.getElementById('demoAddonWasit')?.checked;
            const rompi = document.getElementById('demoAddonRompi')?.checked;
            const air = document.getElementById('demoAddonAir')?.checked;

            if (wasit) addonTotal += 50000 * (state.selectedSlots.length || 1);
            if (rompi) addonTotal += 25000;
            if (air) addonTotal += 35000;

            // 12% Gold Member Discount on Court
            const discountAmount = Math.round(courtTotal * 0.12);
            const grandTotal = Math.max(0, (courtTotal - discountAmount) + addonTotal);

            const totalDisplay = document.getElementById('demoSlotGrandTotal');
            const countBadge = document.getElementById('demoSlotCountBadge');
            const continueBtn = document.getElementById('btnContinueToOrderForm');

            if (totalDisplay) totalDisplay.textContent = `Rp ${grandTotal.toLocaleString('id-ID')}`;
            if (countBadge) countBadge.textContent = `${state.selectedSlots.length} Slot Jam`;

            if (continueBtn) {
                if (state.selectedSlots.length === 0) {
                    continueBtn.disabled = true;
                    continueBtn.className = 'w-full py-3 rounded-xl bg-slate-800 text-slate-500 font-bold text-xs cursor-not-allowed flex items-center justify-center gap-2';
                } else {
                    continueBtn.disabled = false;
                    continueBtn.className = 'w-full py-3 rounded-xl bg-gradient-to-r from-emerald-500 to-teal-400 hover:from-emerald-400 hover:to-teal-300 active:scale-98 text-slate-950 font-black text-xs shadow-lg shadow-emerald-500/20 transition flex items-center justify-center gap-2 cursor-pointer';
                }
            }
        }

        // 3. Proceed to Order Form
        function proceedToOrderForm() {
            if (state.selectedSlots.length === 0) return;

            const sport = DB.sports.find(s => s.id === state.selectedSport) || DB.sports[0];
            const court = sport.courts.find(c => c.id === state.selectedCourtId) || sport.courts[0];

            let courtTotal = 0;
            state.selectedSlots.forEach(s => courtTotal += s.price);

            let addonTotal = 0;
            let addonsArr = [];
            if (document.getElementById('demoAddonWasit')?.checked) {
                addonTotal += 50000 * state.selectedSlots.length;
                addonsArr.push('Wasit Berlisensi');
            }
            if (document.getElementById('demoAddonRompi')?.checked) {
                addonTotal += 25000;
                addonsArr.push('1 Set Rompi');
            }
            if (document.getElementById('demoAddonAir')?.checked) {
                addonTotal += 35000;
                addonsArr.push('1 Dus Air Mineral');
            }

            const discount = Math.round(courtTotal * 0.12);
            const grandTotal = (courtTotal - discount) + addonTotal;

            const slotsText = state.selectedSlots.map(s => s.time).join(', ');

            document.getElementById('orderSummaryCourtName').textContent = court.name;
            document.getElementById('orderSummarySportBadge').textContent = sport.name.toUpperCase();
            document.getElementById('orderSummaryDate').textContent = state.selectedDate;
            document.getElementById('orderSummarySlots').textContent = `${state.selectedSlots.length} Jam: ${slotsText}`;
            document.getElementById('orderSummaryAddons').textContent = addonsArr.length > 0 ? addonsArr.join(', ') : 'Tanpa Add-on';

            document.getElementById('breakdownCourtSubtotal').textContent = `Rp ${courtTotal.toLocaleString('id-ID')}`;
            document.getElementById('breakdownAddonSubtotal').textContent = `Rp ${addonTotal.toLocaleString('id-ID')}`;
            document.getElementById('breakdownDiscount').textContent = `-Rp ${discount.toLocaleString('id-ID')}`;
            document.getElementById('breakdownGrandTotal').textContent = `Rp ${grandTotal.toLocaleString('id-ID')}`;

            switchView('viewOrderForm');
        }

        // 4. Proceed to QRIS Payment
        function proceedToQRISPayment(e) {
            e.preventDefault();

            const name = document.getElementById('demoCustName').value.trim();
            const team = document.getElementById('demoCustTeam').value.trim() || '-';
            const phone = document.getElementById('demoCustPhone').value.trim();

            const sport = DB.sports.find(s => s.id === state.selectedSport) || DB.sports[0];
            const court = sport.courts.find(c => c.id === state.selectedCourtId) || sport.courts[0];

            let courtTotal = 0;
            state.selectedSlots.forEach(s => courtTotal += s.price);

            let addonTotal = 0;
            let addonsArr = [];
            if (document.getElementById('demoAddonWasit')?.checked) {
                addonTotal += 50000 * state.selectedSlots.length;
                addonsArr.push('Wasit');
            }
            if (document.getElementById('demoAddonRompi')?.checked) {
                addonTotal += 25000;
                addonsArr.push('Rompi');
            }
            if (document.getElementById('demoAddonAir')?.checked) {
                addonTotal += 35000;
                addonsArr.push('Air Mineral');
            }

            const discount = Math.round(courtTotal * 0.12);
            const grandTotal = (courtTotal - discount) + addonTotal;
            const slotsText = state.selectedSlots.map(s => s.time).join(', ');
            const bookingCode = 'SPT-' + Math.floor(100000 + Math.random() * 900000);

            state.currentOrder = {
                id: 'ORD-SPT-' + Date.now()
                , bookingCode: bookingCode
                , sportName: sport.name
                , courtName: court.name
                , courtType: court.type
                , leadName: name
                , teamName: team
                , phone: phone
                , playDate: state.selectedDate
                , slotsText: slotsText
                , slotCount: state.selectedSlots.length
                , addons: addonsArr.join(', ') || 'Tanpa Add-on'
                , totalAmount: grandTotal
                , totalFormatted: `Rp ${grandTotal.toLocaleString('id-ID')}`
                , createdAt: new Date().toLocaleDateString('id-ID')
            };

            document.getElementById('qrisDisplayGrandTotal').textContent = state.currentOrder.totalFormatted;
            document.getElementById('qrisDisplaySubtitle').textContent = `${court.name} • ${state.currentOrder.slotCount} Jam • ${state.selectedDate}`;

            switchView('viewPayment');
        }

        // 5. Payment Success Simulation & Save Order
        function simulatePaymentSuccess() {
            if (!state.currentOrder) return;

            saveOrderToHistory(state.currentOrder);
            const order = state.currentOrder;

            document.getElementById('ticketBookingCode').textContent = order.bookingCode;
            document.getElementById('ticketSportBadge').textContent = order.sportName.toUpperCase() + ' ARENA';
            document.getElementById('ticketCourtName').textContent = order.courtName;
            document.getElementById('ticketPlayDate').textContent = order.playDate;
            document.getElementById('ticketPlaySlots').textContent = order.slotsText;
            document.getElementById('ticketLeadName').textContent = order.leadName;
            document.getElementById('ticketTeamName').textContent = order.teamName;
            document.getElementById('ticketTotalPriceDisplay').textContent = order.totalFormatted;

            switchView('viewTicket');
            loadOrderHistory();
        }

        // 6. Order History Persistence Engine
        function saveOrderToHistory(order) {
            let history = JSON.parse(localStorage.getItem('apex_sport_orders') || '[]');
            history.unshift(order);
            localStorage.setItem('apex_sport_orders', JSON.stringify(history));
        }

        function loadOrderHistory() {
            const container = document.getElementById('demoHistoryContainer');
            const emptyBox = document.getElementById('emptyHistoryBox');
            if (!container) return;

            let history = JSON.parse(localStorage.getItem('apex_sport_orders') || '[]');
            container.innerHTML = '';

            if (history.length === 0) {
                if (emptyBox) emptyBox.classList.remove('hidden');
                return;
            } else {
                if (emptyBox) emptyBox.classList.add('hidden');
            }

            history.forEach(order => {
                const card = document.createElement('div');
                card.className = 'bg-slate-900 rounded-2xl p-3.5 border border-slate-800 shadow-xs';
                card.innerHTML = `
                    <div class="flex items-center justify-between pb-2 mb-2 border-b border-slate-800">
                        <span class="text-[10px] font-black text-white">${order.bookingCode}</span>
                        <span class="text-[9px] font-bold text-emerald-400 bg-emerald-500/10 px-2 py-0.5 rounded-full">LUNAS</span>
                    </div>
                    <div class="flex items-center justify-between text-xs font-bold text-slate-100">
                        <span class="truncate">${order.courtName} (${order.sportName})</span>
                        <span class="text-emerald-400 font-black">${order.totalFormatted}</span>
                    </div>
                    <p class="text-[10px] text-slate-400 mt-1">
                        <i class="far fa-calendar-alt text-emerald-400 mr-1"></i> ${order.playDate} • ${order.slotsText}
                    </p>
                    <div class="flex items-center justify-between pt-2 mt-2 border-t border-slate-800 text-[10px]">
                        <span class="text-slate-500">${order.createdAt}</span>
                        <button type="button" onclick="viewHistoryTicketDetail('${order.bookingCode}')" class="font-bold text-emerald-400 hover:underline cursor-pointer">
                            Buka E-Ticket ➔
                        </button>
                    </div>
                `;
                container.appendChild(card);
            });
        }

        function viewHistoryTicketDetail(code) {
            let history = JSON.parse(localStorage.getItem('apex_sport_orders') || '[]');
            const order = history.find(o => o.bookingCode === code);
            if (!order) return;

            state.currentOrder = order;
            document.getElementById('ticketBookingCode').textContent = order.bookingCode;
            document.getElementById('ticketSportBadge').textContent = order.sportName.toUpperCase() + ' ARENA';
            document.getElementById('ticketCourtName').textContent = order.courtName;
            document.getElementById('ticketPlayDate').textContent = order.playDate;
            document.getElementById('ticketPlaySlots').textContent = order.slotsText;
            document.getElementById('ticketLeadName').textContent = order.leadName;
            document.getElementById('ticketTeamName').textContent = order.teamName;
            document.getElementById('ticketTotalPriceDisplay').textContent = order.totalFormatted;

            switchView('viewTicket');
        }

        function setDefaultSampleIfEmpty() {
            let history = JSON.parse(localStorage.getItem('apex_sport_orders') || '[]');
            if (history.length === 0) {
                const sample = {
                    id: 'ORD-SAMPLE-1'
                    , bookingCode: 'SPT-882190'
                    , sportName: 'Futsal'
                    , courtName: 'Lapangan 1 (Vinyl Pro)'
                    , courtType: 'Vinyl 8mm'
                    , leadName: 'Andi Pratama'
                    , teamName: 'Garuda Futsal Squad'
                    , phone: '081234567890'
                    , playDate: 'Hari Ini'
                    , slotsText: '19:00 - 20:00 WIB'
                    , slotCount: 1
                    , addons: '1 Set Rompi'
                    , totalAmount: 130600
                    , totalFormatted: 'Rp 130.600'
                    , createdAt: 'Hari ini'
                };
                saveOrderToHistory(sample);
                loadOrderHistory();
            }
        }

        function resetSportOrdersDemo() {
            if (confirm('Reset semua data riwayat tiket demo?')) {
                localStorage.removeItem('apex_sport_orders');
                loadOrderHistory();
            }
        }

        function shareTicketToWhatsApp() {
            if (!state.currentOrder) return;
            const o = state.currentOrder;
            const msg = `*E-TICKET RESMI BOOKING LAPANGAN - ${BRAND_NAME.toUpperCase()}*
----------------------------------------
*Kode Booking:* ${o.bookingCode}
*Status:* LUNAS (Siap Main)

*Detail Reservasi:*
• *Cabang Olahraga:* ${o.sportName}
• *Lapangan:* ${o.courtName}
• *Tanggal Main:* ${o.playDate}
• *Slot Jam:* ${o.slotsText}
• *Penanggung Jawab:* ${o.leadName} (${o.phone})
• *Nama Tim:* ${o.teamName}
• *Add-on:* ${o.addons}
• *Total Biaya:* ${o.totalFormatted}

*Lokasi Arena:*
Jl. Boulevard Sport Arena No. 88 (Fasilitas Shower Air Panas & Parkir Luas).
----------------------------------------
_Tunjukkan pesan ini atau barcode di resepsionis saat kedatangan._`;

            const url = `https://wa.me/${WA_PHONE}?text=${encodeURIComponent(msg)}`;
            window.open(url, '_blank');
        }

        // ================= COMMUNITY & MABAR ENGINE =================
        function switchCommunityTab(tab) {
            const clubsSec = document.getElementById('communityClubsSection');
            const mabarSec = document.getElementById('communityMabarSection');
            const clubsBtn = document.getElementById('tabClubsBtn');
            const mabarBtn = document.getElementById('tabMabarBtn');

            if (tab === 'clubs') {
                if (clubsSec) clubsSec.classList.remove('hidden');
                if (mabarSec) mabarSec.classList.add('hidden');
                if (clubsBtn) clubsBtn.className = 'flex-1 py-1.5 rounded-xl text-xs font-bold bg-emerald-500 text-slate-950 text-center transition';
                if (mabarBtn) mabarBtn.className = 'flex-1 py-1.5 rounded-xl text-xs font-bold bg-slate-900 text-slate-400 border border-slate-800 text-center transition';
            } else {
                if (clubsSec) clubsSec.classList.add('hidden');
                if (mabarSec) mabarSec.classList.remove('hidden');
                if (clubsBtn) clubsBtn.className = 'flex-1 py-1.5 rounded-xl text-xs font-bold bg-slate-900 text-slate-400 border border-slate-800 text-center transition';
                if (mabarBtn) mabarBtn.className = 'flex-1 py-1.5 rounded-xl text-xs font-bold bg-emerald-500 text-slate-950 text-center transition';
            }
        }

        function renderCommunityList() {
            const container = document.getElementById('communityClubsSection');
            if (!container) return;

            let localClubs = JSON.parse(localStorage.getItem('apex_user_clubs') || '[]');
            let initialClubs = DB.initial_communities || [];
            let allClubs = [...localClubs, ...initialClubs];

            container.innerHTML = '';

            allClubs.forEach(club => {
                const item = document.createElement('div');
                item.className = 'bg-slate-900 rounded-2xl p-3.5 border border-slate-800 space-y-2';
                item.innerHTML = `
                    <div class="flex items-start justify-between gap-2">
                        <div class="flex items-center gap-2.5 min-w-0">
                            <div class="w-9 h-9 rounded-xl bg-emerald-500/20 text-emerald-400 border border-emerald-500/30 flex items-center justify-center text-sm shrink-0">
                                <i class="fas ${club.icon || 'fa-users'}"></i>
                            </div>
                            <div class="min-w-0">
                                <h4 class="text-xs font-black text-white truncate">${club.name}</h4>
                                <span class="text-[9px] text-emerald-400 font-semibold">${club.sport_name || club.sport} • ${club.level || 'All Level'}</span>
                            </div>
                        </div>
                        <span class="text-[9px] bg-slate-950 text-slate-400 border border-slate-800 px-2 py-0.5 rounded-full whitespace-nowrap">
                            ${club.members_count || 1} Member
                        </span>
                    </div>

                    <p class="text-[10px] text-slate-400 leading-tight line-clamp-2">
                        ${club.description}
                    </p>

                    <div class="flex items-center justify-between pt-2 border-t border-slate-800 text-[10px]">
                        <span class="text-slate-400"><i class="far fa-clock text-emerald-400 mr-1"></i> ${club.schedule}</span>
                        <button type="button" onclick="joinClubViaWA('${club.name}')" class="font-bold text-emerald-400 hover:underline">
                            Gabung Klub ➔
                        </button>
                    </div>
                `;
                container.appendChild(item);
            });
        }

        function renderMabarList() {
            const container = document.getElementById('mabarListContainer');
            if (!container) return;

            let localMabar = JSON.parse(localStorage.getItem('apex_user_mabar') || '[]');
            let initialMabar = DB.initial_mabar_open || [];
            let allMabar = [...localMabar, ...initialMabar];

            container.innerHTML = '';

            allMabar.forEach(m => {
                const item = document.createElement('div');
                item.className = 'bg-slate-900 rounded-2xl p-3 border border-slate-800 space-y-1.5';
                item.innerHTML = `
                    <div class="flex items-center justify-between">
                        <span class="text-[9px] font-extrabold uppercase text-amber-400">${m.sport_name || m.sport}</span>
                        <span class="text-[9px] font-bold text-emerald-300 bg-emerald-500/10 px-2 py-0.5 rounded">Butuh ${m.slots_needed}</span>
                    </div>
                    <h5 class="text-xs font-bold text-white leading-tight">${m.title}</h5>
                    <div class="text-[10px] text-slate-400 space-y-0.5">
                        <p><i class="far fa-clock mr-1"></i> ${m.date} • ${m.time}</p>
                        <p><i class="fas fa-coins mr-1"></i> Patungan: <strong class="text-slate-200">${m.cost_per_person}</strong></p>
                    </div>
                    <button type="button" onclick="joinMabarViaWA('${m.title}', '${m.date}')" class="w-full mt-1 py-1.5 rounded-xl bg-slate-950 hover:bg-emerald-500 hover:text-slate-950 text-emerald-400 font-bold text-[10px] transition border border-slate-800">
                        Join Slot Mabar Ini
                    </button>
                `;
                container.appendChild(item);
            });
        }

        // Modal Controllers for Creating Community
        function openCreateCommunityModal() {
            const modal = document.getElementById('createCommunityModal');
            if (modal) {
                modal.classList.remove('hidden');
                modal.classList.add('flex');
            }
        }

        function closeCreateCommunityModal() {
            const modal = document.getElementById('createCommunityModal');
            if (modal) {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }
        }

        function saveNewCommunity(e) {
            e.preventDefault();
            const name = document.getElementById('newClubName').value.trim();
            const sport = document.getElementById('newClubSport').value;
            const level = document.getElementById('newClubLevel').value;
            const schedule = document.getElementById('newClubSchedule').value.trim();
            const desc = document.getElementById('newClubDesc').value.trim();

            let icon = 'fa-users';
            let sportName = 'Sport';
            if (sport === 'futsal') {
                icon = 'fa-futbol';
                sportName = 'Futsal';
            } else if (sport === 'badminton') {
                icon = 'fa-feather';
                sportName = 'Badminton';
            } else if (sport === 'padel') {
                icon = 'fa-table-tennis-paddle-ball';
                sportName = 'Padel Tennis';
            } else if (sport === 'minisoccer') {
                icon = 'fa-futbol';
                sportName = 'Mini Soccer';
            } else if (sport === 'volly') {
                icon = 'fa-volleyball';
                sportName = 'Bola Voli';
            }

            const newClub = {
                id: 'COM-USR-' + Date.now()
                , name: name
                , sport: sport
                , sport_name: sportName
                , icon: icon
                , badge: 'Member Club'
                , creator_name: 'Andi Pratama (Gold Member)'
                , members_count: 1
                , schedule: schedule
                , description: desc
                , level: level
            };

            let localClubs = JSON.parse(localStorage.getItem('apex_user_clubs') || '[]');
            localClubs.unshift(newClub);
            localStorage.setItem('apex_user_clubs', JSON.stringify(localClubs));

            alert(`Selamat! Komunitas "${name}" berhasil dibuat oleh status Gold Member Anda!`);
            closeCreateCommunityModal();
            renderCommunityList();
            switchCommunityTab('clubs');
            switchView('viewCommunity');
        }

        // Modal Controllers for Creating Mabar Slot
        function openCreateMabarModal() {
            const modal = document.getElementById('createMabarModal');
            if (modal) {
                modal.classList.remove('hidden');
                modal.classList.add('flex');
            }
        }

        function closeCreateMabarModal() {
            const modal = document.getElementById('createMabarModal');
            if (modal) {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }
        }

        function saveNewMabarSlot(e) {
            e.preventDefault();
            const title = document.getElementById('mabarTitle').value.trim();
            const sport = document.getElementById('mabarSportSelect').value;
            const slots = document.getElementById('mabarSlotsNeeded').value.trim();
            const date = document.getElementById('mabarDateText').value.trim();
            const time = document.getElementById('mabarTimeText').value.trim();
            const cost = document.getElementById('mabarCostText').value.trim();

            let sportName = 'Sport';
            if (sport === 'futsal') sportName = 'Futsal';
            else if (sport === 'badminton') sportName = 'Badminton';
            else if (sport === 'padel') sportName = 'Padel Tennis';
            else if (sport === 'minisoccer') sportName = 'Mini Soccer';
            else if (sport === 'volly') sportName = 'Bola Voli';

            const newMabar = {
                id: 'MBR-USR-' + Date.now()
                , title: title
                , sport: sport
                , sport_name: sportName
                , slots_needed: slots
                , date: date
                , time: time
                , cost_per_person: cost
                , host: 'Andi Pratama'
            };

            let localMabar = JSON.parse(localStorage.getItem('apex_user_mabar') || '[]');
            localMabar.unshift(newMabar);
            localStorage.setItem('apex_user_mabar', JSON.stringify(localMabar));

            alert('Slot mabar berhasil diposting ke papan komunitas!');
            closeCreateMabarModal();
            renderMabarList();
            switchCommunityTab('mabar');
        }

        function joinClubViaWA(clubName) {
            const msg = `Halo CS ${BRAND_NAME}, saya ingin bergabung dengan Komunitas Olahraga "${clubName}". Mohon info grup WhatsApp-nya.`;
            window.open(`https://wa.me/${WA_PHONE}?text=${encodeURIComponent(msg)}`, '_blank');
        }

        function joinMabarViaWA(title, date) {
            const msg = `Halo CS ${BRAND_NAME}, saya ingin ikut mabar "${title}" (${date}). Masih ada slot kosong?`;
            window.open(`https://wa.me/${WA_PHONE}?text=${encodeURIComponent(msg)}`, '_blank');
        }

    </script>
</body>
</html>
