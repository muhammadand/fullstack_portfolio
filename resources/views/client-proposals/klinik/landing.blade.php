<!DOCTYPE html>
<html lang="id" class="h-full bg-slate-900">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover">
    <title>{{ $client->brand_name ?? 'SIM Klinik Pratama' }} - Sistem Informasi Manajemen & Rekam Medis</title>

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        teal: {
                            50: '#f0fdfa',
                            100: '#ccfbf1',
                            200: '#99f6e4',
                            300: '#5eead4',
                            400: '#2dd4bf',
                            500: '#14b8a6',
                            600: '#0d9488',
                            700: '#0f766e',
                            800: '#115e59',
                            900: '#134e4a',
                            950: '#042f2e'
                        },
                        medical: {
                            50: '#f0f9ff',
                            100: '#e0f2fe',
                            500: '#0284c7',
                            600: '#0369a1',
                            700: '#075985',
                            800: '#0c4a6e',
                            900: '#082f49'
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
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            -webkit-tap-highlight-color: transparent;
            user-select: none;
            background-color: #0b1329;
        }

        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }
        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        /* Responsive Mobile Container Frame on Desktop */
        @media (min-width: 768px) {
            .mobile-frame {
                max-width: 430px;
                height: 890px;
                max-height: 96vh;
                border-radius: 40px;
                box-shadow: 0 25px 60px -15px rgba(0, 0, 0, 0.7), 0 0 0 10px #1e293b, 0 0 0 12px #334155;
                position: relative;
                overflow: hidden;
            }
        }

        /* Pulse badge subtle animation */
        @keyframes softPulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }
        .pulse-subtle {
            animation: softPulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }

        /* Print styles for digital patient card & invoice */
        @media print {
            body * {
                visibility: hidden;
            }
            #printableArea, #printableArea * {
                visibility: visible;
            }
            #printableArea {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
            }
        }
    </style>
</head>
<body class="h-full flex flex-col items-center justify-center text-slate-800 antialiased p-0 md:p-4">

    @php
    $cleanWa = preg_replace('/[^0-9]/', '', $client->wa_number ?? '6281234567890');
    if (str_starts_with($cleanWa, '0')) {
        $cleanWa = '62' . substr($cleanWa, 1);
    }
    $brandName = $client->brand_name ?? 'Klinik Pratama Medika Sehat';

    $jsonPath = resource_path('views/client-proposals/klinik/data.json');
    if (file_exists($jsonPath)) {
        $klinikDatabase = json_decode(file_get_contents($jsonPath), true);
    } else {
        $klinikDatabase = [];
    }
    @endphp

    <!-- Top Desktop Preview Helper Bar (Hidden on Mobile) -->
    <header class="w-full max-w-lg px-4 py-2 hidden md:flex items-center justify-between text-xs text-slate-400 mb-2">
        <div class="flex items-center gap-2">
            <span class="w-2 h-2 rounded-full bg-teal-400 pulse-subtle"></span>
            <span class="font-bold text-slate-200">Mobile SIM Klinik & Rekam Medis</span>
            <span class="text-slate-600">•</span>
            <span class="text-slate-400 text-[11px]">{{ $brandName }}</span>
        </div>
        <div class="flex items-center gap-2">
            <button onclick="resetDataToDefault()" title="Reset Dummy Data" class="text-slate-400 hover:text-white px-2 py-1 rounded bg-slate-800 border border-slate-700 text-[10px] transition">
                <i class="fas fa-rotate-right mr-1"></i> Reset Data
            </button>
            @if(isset($client->slug))
            <a href="{{ route('proposal.dynamic', $client->slug) }}" class="text-teal-400 hover:text-white px-2.5 py-1 rounded bg-slate-800 border border-teal-500/30 text-[10px] transition">
                Proposal
            </a>
            @endif
        </div>
    </header>

    <!-- Main Mobile Screen Container -->
    <main class="w-full h-full md:h-auto mobile-frame bg-slate-50 flex flex-col relative overflow-hidden text-slate-800 shadow-2xl">

        <!-- Mobile Status Bar (Realistic Notch / Clock) -->
        <div class="bg-teal-800 text-white px-5 pt-3 pb-2 flex items-center justify-between text-[11px] font-medium shrink-0 z-40 select-none">
            <span id="mobileClock" class="font-semibold tracking-wide">09:41</span>
            <div class="w-16 h-3 bg-black/25 rounded-full mx-auto hidden md:block"></div>
            <div class="flex items-center gap-1.5 text-[10px] opacity-90">
                <i class="fas fa-signal"></i>
                <i class="fas fa-wifi"></i>
                <i class="fas fa-battery-three-quarters"></i>
            </div>
        </div>

        <!-- Top App Header -->
        <div class="bg-teal-700 text-white px-4 pt-2 pb-2.5 shrink-0 shadow-sm z-30">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-2.5">
                    <div class="w-7 h-7 rounded-lg bg-teal-800/80 border border-teal-400/30 flex items-center justify-center text-teal-200 text-xs">
                        <i class="fas fa-hospital"></i>
                    </div>
                    <div>
                        <div class="text-[10px] text-teal-200 font-medium leading-tight">SIM Klinik & EMR</div>
                        <h1 class="text-xs font-bold text-white tracking-tight leading-none" id="headerTitle">{{ $brandName }}</h1>
                    </div>
                </div>

                <div class="flex items-center gap-1.5">
                    <!-- Quick Emergency / Queue Call Speaker Button -->
                    <button onclick="openDisplayAntreanModal()" class="px-2 py-1 rounded-md bg-teal-800 hover:bg-teal-900 border border-teal-500/40 text-[10px] font-medium text-teal-100 flex items-center gap-1 transition">
                        <i class="fas fa-tv text-[9px]"></i>
                        <span>Display Antrean</span>
                    </button>
                    <!-- Audio notification status toggle -->
                    <button id="btnAudioToggle" onclick="toggleAudioSpeech()" class="w-6 h-6 rounded-md bg-teal-800 hover:bg-teal-900 border border-teal-500/40 text-teal-200 flex items-center justify-center text-[10px] transition" title="Suara Panggilan">
                        <i id="audioIcon" class="fas fa-volume-high text-[10px]"></i>
                    </button>
                </div>
            </div>

            <!-- Horizontal Module Tabs Switcher (Quick Scrollable Bar) -->
            <div class="flex items-center gap-1.5 overflow-x-auto no-scrollbar pt-2 text-[11px] font-medium">
                <button onclick="switchModule('dashboard')" class="tab-btn px-2.5 py-1 rounded-full whitespace-nowrap bg-white text-teal-800 font-semibold shadow-xs" data-module="dashboard">Dashboard</button>
                <button onclick="switchModule('pasien')" class="tab-btn px-2.5 py-1 rounded-full whitespace-nowrap bg-teal-800/70 text-teal-100 hover:bg-teal-800" data-module="pasien">Pasien</button>
                <button onclick="switchModule('booking')" class="tab-btn px-2.5 py-1 rounded-full whitespace-nowrap bg-teal-800/70 text-teal-100 hover:bg-teal-800" data-module="booking">Booking</button>
                <button onclick="switchModule('antrean')" class="tab-btn px-2.5 py-1 rounded-full whitespace-nowrap bg-teal-800/70 text-teal-100 hover:bg-teal-800" data-module="antrean">Antrean</button>
                <button onclick="switchModule('periksa')" class="tab-btn px-2.5 py-1 rounded-full whitespace-nowrap bg-teal-800/70 text-teal-100 hover:bg-teal-800" data-module="periksa">Pemeriksaan</button>
                <button onclick="switchModule('resep')" class="tab-btn px-2.5 py-1 rounded-full whitespace-nowrap bg-teal-800/70 text-teal-100 hover:bg-teal-800" data-module="resep">Resep</button>
                <button onclick="switchModule('inventory')" class="tab-btn px-2.5 py-1 rounded-full whitespace-nowrap bg-teal-800/70 text-teal-100 hover:bg-teal-800" data-module="inventory">Inventory</button>
                <button onclick="switchModule('pembayaran')" class="tab-btn px-2.5 py-1 rounded-full whitespace-nowrap bg-teal-800/70 text-teal-100 hover:bg-teal-800" data-module="pembayaran">Pembayaran</button>
                <button onclick="switchModule('admin')" class="tab-btn px-2.5 py-1 rounded-full whitespace-nowrap bg-teal-800/70 text-teal-100 hover:bg-teal-800" data-module="admin">Admin & Staf</button>
            </div>
        </div>

        <!-- Notification Toast (Subtle on Top) -->
        <div id="toastNotification" class="hidden absolute top-24 inset-x-4 z-50 bg-slate-900/95 text-white text-[11px] px-3.5 py-2 rounded-xl shadow-lg border border-teal-500/30 flex items-center justify-between backdrop-blur-sm transition-all duration-300">
            <span id="toastMsg" class="font-medium">Pemberitahuan</span>
            <button onclick="hideToast()" class="text-slate-400 hover:text-white ml-2 text-xs">&times;</button>
        </div>

        <!-- ================= APP SCROLLABLE VIEWPORT ================= -->
        <div id="appViewport" class="flex-1 overflow-y-auto no-scrollbar bg-slate-100/70 pb-20 text-slate-800">

            <!-- ------------------------------------------------------------- -->
            <!-- 1. MODUL: DASHBOARD & ADMINISTRASI -->
            <!-- ------------------------------------------------------------- -->
            <section id="modDashboard" class="module-view p-3.5 space-y-3">
                <!-- Clinic Status Alert Pill -->
                <div class="bg-white rounded-xl p-3 border border-slate-200/80 shadow-xs flex items-center justify-between">
                    <div>
                        <div class="flex items-center gap-1.5">
                            <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                            <span class="text-[11px] font-bold text-slate-700">Pelayanan Aktif Hari Ini</span>
                        </div>
                        <p class="text-[10px] text-slate-500 mt-0.5" id="dashboardDateText">Sabtu, 03 Oktober 2026</p>
                    </div>
                    <span class="text-[10px] px-2 py-0.5 rounded-full bg-teal-50 text-teal-700 font-semibold border border-teal-200">
                        Poli Umum & Gigi Buka
                    </span>
                </div>

                <!-- 4 KPI Metrics Cards -->
                <div class="grid grid-cols-2 gap-2">
                    <div class="bg-white rounded-xl p-3 border border-slate-200/80 shadow-xs">
                        <div class="text-[10px] text-slate-500 font-medium">Pasien Terdaftar</div>
                        <div class="text-lg font-extrabold text-slate-800 mt-0.5" id="kpiPasienHariIni">42</div>
                        <div class="text-[9px] text-emerald-600 font-medium mt-1 flex items-center gap-1">
                            <span>+8 pasien baru hari ini</span>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl p-3 border border-slate-200/80 shadow-xs">
                        <div class="text-[10px] text-slate-500 font-medium">Antrean Menunggu</div>
                        <div class="text-lg font-extrabold text-teal-700 mt-0.5" id="kpiAntreanAktif">6</div>
                        <div class="text-[9px] text-slate-500 font-medium mt-1">
                            <span>Rata-rata tunggu: 14 mnt</span>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl p-3 border border-slate-200/80 shadow-xs">
                        <div class="text-[10px] text-slate-500 font-medium">Pendapatan Hari Ini</div>
                        <div class="text-xs font-bold text-slate-800 mt-1" id="kpiPendapatan">Rp 4.850.000</div>
                        <div class="text-[9px] text-slate-500 mt-1">29 transaksi selesai</div>
                    </div>

                    <div class="bg-white rounded-xl p-3 border border-slate-200/80 shadow-xs">
                        <div class="text-[10px] text-slate-500 font-medium">Stok Obat Kritis</div>
                        <div class="text-lg font-extrabold text-amber-600 mt-0.5" id="kpiStokKritis">3</div>
                        <div class="text-[9px] text-amber-600 font-medium mt-1">Perlu restock segera</div>
                    </div>
                </div>

                <!-- Active Waiting Rooms Status per Poli -->
                <div class="bg-white rounded-xl p-3 border border-slate-200/80 shadow-xs">
                    <div class="flex items-center justify-between mb-2">
                        <h2 class="text-xs font-bold text-slate-800">Antrean Berjalan per Poli</h2>
                        <button onclick="switchModule('antrean')" class="text-[10px] text-teal-700 font-medium">Lihat Semua</button>
                    </div>
                    <div class="space-y-2" id="dashboardPoliList">
                        <!-- Populated by JS -->
                    </div>
                </div>

                <!-- Quick Action Buttons -->
                <div class="grid grid-cols-4 gap-2 pt-1">
                    <button onclick="openModalRegistrasiPasien()" class="bg-white hover:bg-teal-50 border border-slate-200/80 rounded-xl p-2.5 text-center flex flex-col items-center justify-center transition shadow-xs">
                        <div class="w-8 h-8 rounded-lg bg-teal-100 text-teal-700 flex items-center justify-center text-xs mb-1">
                            <i class="fas fa-user-plus"></i>
                        </div>
                        <span class="text-[10px] font-semibold text-slate-700 leading-tight">+ Pasien</span>
                    </button>

                    <button onclick="openModalAmbilAntrean()" class="bg-white hover:bg-teal-50 border border-slate-200/80 rounded-xl p-2.5 text-center flex flex-col items-center justify-center transition shadow-xs">
                        <div class="w-8 h-8 rounded-lg bg-sky-100 text-sky-700 flex items-center justify-center text-xs mb-1">
                            <i class="fas fa-ticket"></i>
                        </div>
                        <span class="text-[10px] font-semibold text-slate-700 leading-tight">Ambil Antrean</span>
                    </button>

                    <button onclick="openModalPemeriksaanBaru()" class="bg-white hover:bg-teal-50 border border-slate-200/80 rounded-xl p-2.5 text-center flex flex-col items-center justify-center transition shadow-xs">
                        <div class="w-8 h-8 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center text-xs mb-1">
                            <i class="fas fa-stethoscope"></i>
                        </div>
                        <span class="text-[10px] font-semibold text-slate-700 leading-tight">Periksa</span>
                    </button>

                    <button onclick="openModalBuatResep()" class="bg-white hover:bg-teal-50 border border-slate-200/80 rounded-xl p-2.5 text-center flex flex-col items-center justify-center transition shadow-xs">
                        <div class="w-8 h-8 rounded-lg bg-purple-100 text-purple-700 flex items-center justify-center text-xs mb-1">
                            <i class="fas fa-prescription-bottle-medical"></i>
                        </div>
                        <span class="text-[10px] font-semibold text-slate-700 leading-tight">Resep Obat</span>
                    </button>
                </div>

                <!-- Recent Patient Visits Mini Feed -->
                <div class="bg-white rounded-xl p-3 border border-slate-200/80 shadow-xs">
                    <div class="flex items-center justify-between mb-2">
                        <h2 class="text-xs font-bold text-slate-800">Kunjungan Pasien Terbaru</h2>
                        <span class="text-[10px] text-slate-400">Hari ini</span>
                    </div>
                    <div class="divide-y divide-slate-100 text-[11px]" id="dashboardRecentVisits">
                        <!-- Populated by JS -->
                    </div>
                </div>
            </section>


            <!-- ------------------------------------------------------------- -->
            <!-- 2. MODUL: MANAJEMEN PASIEN -->
            <!-- ------------------------------------------------------------- -->
            <section id="modPasien" class="module-view p-3.5 space-y-3 hidden">
                <!-- Search & Filter Bar -->
                <div class="bg-white rounded-xl p-2.5 border border-slate-200/80 shadow-xs space-y-2">
                    <div class="relative">
                        <input type="text" id="searchPasienInput" oninput="filterPasienList()" placeholder="Cari nama pasien, No. RM, atau NIK..." class="w-full text-xs pl-8 pr-3 py-2 rounded-lg bg-slate-100 border border-slate-200 focus:outline-none focus:border-teal-500 focus:bg-white text-slate-800">
                        <div class="absolute left-2.5 top-2.5 text-slate-400 text-xs pointer-events-none">
                            <i class="fas fa-magnifying-glass"></i>
                        </div>
                    </div>
                    <div class="flex items-center justify-between text-[11px]">
                        <span class="text-slate-500 font-medium" id="patientCountLabel">4 Pasien Terdata</span>
                        <button onclick="openModalRegistrasiPasien()" class="px-2.5 py-1 rounded-md bg-teal-700 text-white font-semibold flex items-center gap-1 shadow-xs hover:bg-teal-800 transition">
                            <i class="fas fa-plus text-[10px]"></i>
                            <span>Daftar Pasien Baru</span>
                        </button>
                    </div>
                </div>

                <!-- List of Patients Cards -->
                <div class="space-y-2.5" id="patientListContainer">
                    <!-- Populated by JS -->
                </div>
            </section>


            <!-- ------------------------------------------------------------- -->
            <!-- 3. MODUL: BOOKING & APPOINTMENT -->
            <!-- ------------------------------------------------------------- -->
            <section id="modBooking" class="module-view p-3.5 space-y-3 hidden">
                <!-- Header with Action -->
                <div class="bg-white rounded-xl p-3 border border-slate-200/80 shadow-xs flex items-center justify-between">
                    <div>
                        <h2 class="text-xs font-bold text-slate-800">Jadwal & Janji Temu Dokter</h2>
                        <p class="text-[10px] text-slate-500">Booking pasien & reminder otomatis WhatsApp</p>
                    </div>
                    <button onclick="openModalBookingAppointment()" class="px-2.5 py-1 rounded-md bg-teal-700 text-white text-[11px] font-semibold flex items-center gap-1 hover:bg-teal-800 transition">
                        <i class="fas fa-calendar-plus text-[10px]"></i>
                        <span>Buat Janji</span>
                    </button>
                </div>

                <!-- Doctor Schedule Mini Switcher / Overview -->
                <div class="bg-white rounded-xl p-3 border border-slate-200/80 shadow-xs">
                    <div class="text-[11px] font-bold text-slate-800 mb-2">Jadwal Praktek Dokter</div>
                    <div class="space-y-2" id="doctorScheduleList">
                        <!-- Populated by JS -->
                    </div>
                </div>

                <!-- Upcoming Appointments List -->
                <div class="space-y-2">
                    <div class="flex items-center justify-between px-1">
                        <div class="text-xs font-bold text-slate-800">Daftar Janji Temu Pasien</div>
                        <span class="text-[10px] text-slate-500" id="appointmentCountLabel">4 Jadwal</span>
                    </div>
                    <div class="space-y-2.5" id="appointmentListContainer">
                        <!-- Populated by JS -->
                    </div>
                </div>
            </section>


            <!-- ------------------------------------------------------------- -->
            <!-- 4. MODUL: ANTREAN -->
            <!-- ------------------------------------------------------------- -->
            <section id="modAntrean" class="module-view p-3.5 space-y-3 hidden">
                <!-- Queue Active Caller Banner -->
                <div class="bg-gradient-to-br from-teal-800 to-slate-900 text-white rounded-xl p-3.5 shadow-sm">
                    <div class="flex items-center justify-between text-[11px] text-teal-200 mb-1">
                        <span>PANGGILAN AKTIF SEKARANG</span>
                        <span class="text-[10px] bg-teal-700/60 px-2 py-0.5 rounded border border-teal-500/30">Suara Audio Aktif</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <div>
                            <div class="text-3xl font-black text-white tracking-tight" id="activeCallingNumber">A-04</div>
                            <div class="text-xs text-teal-200 font-medium" id="activeCallingPoli">Poli Umum • Ruang 101</div>
                            <div class="text-[11px] text-white/90 mt-0.5" id="activeCallingPatient">Ananda Bagus Pratama</div>
                        </div>
                        <div class="text-right flex flex-col gap-1.5">
                            <button onclick="panggilUlangAntreanAktif()" class="px-3 py-1.5 rounded-lg bg-teal-500 hover:bg-teal-400 text-slate-950 font-bold text-xs flex items-center gap-1.5 shadow-xs transition">
                                <i class="fas fa-bullhorn text-[11px]"></i>
                                <span>Panggil Ulang</span>
                            </button>
                            <button onclick="selesaikanAntreanAktif()" class="px-3 py-1 rounded-lg bg-slate-800 hover:bg-slate-700 text-teal-200 text-[10px] border border-teal-500/30 transition">
                                Selesai / Ke Poli
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Action: Take Ticket / Filter Tabs -->
                <div class="bg-white rounded-xl p-3 border border-slate-200/80 shadow-xs space-y-2.5">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-bold text-slate-800">Antrean Hari Ini</span>
                        <button onclick="openModalAmbilAntrean()" class="px-2.5 py-1 rounded-md bg-teal-700 text-white text-[11px] font-semibold flex items-center gap-1">
                            <i class="fas fa-ticket text-[10px]"></i>
                            <span>Cetak Nomor Baru</span>
                        </button>
                    </div>

                    <!-- Filter Poli Tabs -->
                    <div class="flex items-center gap-1 overflow-x-auto no-scrollbar text-[11px]">
                        <button onclick="filterQueuePoli('all')" class="queue-tab px-2 py-0.5 rounded bg-teal-100 text-teal-800 font-semibold" data-poli="all">Semua</button>
                        <button onclick="filterQueuePoli('Poli Umum')" class="queue-tab px-2 py-0.5 rounded bg-slate-100 text-slate-600" data-poli="Poli Umum">Umum (A)</button>
                        <button onclick="filterQueuePoli('Poli Gigi & Mulut')" class="queue-tab px-2 py-0.5 rounded bg-slate-100 text-slate-600" data-poli="Poli Gigi & Mulut">Gigi (B)</button>
                        <button onclick="filterQueuePoli('Poli Spesialis Anak')" class="queue-tab px-2 py-0.5 rounded bg-slate-100 text-slate-600" data-poli="Poli Spesialis Anak">Anak (C)</button>
                        <button onclick="filterQueuePoli('Instalasi Farmasi')" class="queue-tab px-2 py-0.5 rounded bg-slate-100 text-slate-600" data-poli="Instalasi Farmasi">Farmasi (F)</button>
                    </div>
                </div>

                <!-- Queue List -->
                <div class="space-y-2" id="queueListContainer">
                    <!-- Populated by JS -->
                </div>
            </section>


            <!-- ------------------------------------------------------------- -->
            <!-- 5. MODUL: PEMERIKSAAN / REKAM MEDIS (EMR) -->
            <!-- ------------------------------------------------------------- -->
            <section id="modPeriksa" class="module-view p-3.5 space-y-3 hidden">
                <div class="bg-white rounded-xl p-3 border border-slate-200/80 shadow-xs flex items-center justify-between">
                    <div>
                        <h2 class="text-xs font-bold text-slate-800">Rekam Medis Elektronik (EMR)</h2>
                        <p class="text-[10px] text-slate-500">Anamnesis, TTV, ICD-10, Tindakan Medis</p>
                    </div>
                    <button onclick="openModalPemeriksaanBaru()" class="px-2.5 py-1 rounded-md bg-teal-700 text-white text-[11px] font-semibold flex items-center gap-1 hover:bg-teal-800 transition">
                        <i class="fas fa-notes-medical text-[10px]"></i>
                        <span>Input EMR</span>
                    </button>
                </div>

                <!-- Search Medical Records by RM -->
                <div class="bg-white rounded-xl p-2.5 border border-slate-200/80 shadow-xs">
                    <input type="text" id="searchEmrInput" oninput="filterEmrList()" placeholder="Filter riwayat periksa / diagnosis..." class="w-full text-xs px-3 py-1.5 rounded-lg bg-slate-100 border border-slate-200 focus:outline-none focus:border-teal-500 text-slate-800">
                </div>

                <!-- Medical Records Feed -->
                <div class="space-y-3" id="emrListContainer">
                    <!-- Populated by JS -->
                </div>
            </section>


            <!-- ------------------------------------------------------------- -->
            <!-- 6. MODUL: RESEP & FARMASI -->
            <!-- ------------------------------------------------------------- -->
            <section id="modResep" class="module-view p-3.5 space-y-3 hidden">
                <div class="bg-white rounded-xl p-3 border border-slate-200/80 shadow-xs flex items-center justify-between">
                    <div>
                        <h2 class="text-xs font-bold text-slate-800">Apotek & Resep Obat</h2>
                        <p class="text-[10px] text-slate-500">Peracikan, aturan pakai, & penyerahan obat</p>
                    </div>
                    <button onclick="openModalBuatResep()" class="px-2.5 py-1 rounded-md bg-teal-700 text-white text-[11px] font-semibold flex items-center gap-1 hover:bg-teal-800 transition">
                        <i class="fas fa-plus text-[10px]"></i>
                        <span>Buat Resep</span>
                    </button>
                </div>

                <!-- Prescriptions Feed -->
                <div class="space-y-2.5" id="prescriptionsContainer">
                    <!-- Populated by JS -->
                </div>
            </section>


            <!-- ------------------------------------------------------------- -->
            <!-- 7. MODUL: INVENTORY OBAT -->
            <!-- ------------------------------------------------------------- -->
            <section id="modInventory" class="module-view p-3.5 space-y-3 hidden">
                <!-- Summary Card -->
                <div class="bg-white rounded-xl p-3 border border-slate-200/80 shadow-xs flex items-center justify-between">
                    <div>
                        <div class="text-[10px] text-slate-500 font-medium">Total Jenis Obat Terdaftar</div>
                        <div class="text-base font-extrabold text-slate-800 mt-0.5" id="invTotalJenis">10 Item Obat</div>
                    </div>
                    <button onclick="openModalTambahObat()" class="px-2.5 py-1 rounded-md bg-teal-700 text-white text-[11px] font-semibold flex items-center gap-1 hover:bg-teal-800 transition">
                        <i class="fas fa-plus text-[10px]"></i>
                        <span>Restock / Tambah</span>
                    </button>
                </div>

                <!-- Search Inventory -->
                <div class="bg-white rounded-xl p-2.5 border border-slate-200/80 shadow-xs">
                    <input type="text" id="searchInventoryInput" oninput="filterInventoryList()" placeholder="Cari nama obat atau kode..." class="w-full text-xs px-3 py-1.5 rounded-lg bg-slate-100 border border-slate-200 focus:outline-none focus:border-teal-500 text-slate-800">
                </div>

                <!-- Medicine Cards List -->
                <div class="space-y-2" id="inventoryListContainer">
                    <!-- Populated by JS -->
                </div>
            </section>


            <!-- ------------------------------------------------------------- -->
            <!-- 8. MODUL: PEMBAYARAN & KASIR -->
            <!-- ------------------------------------------------------------- -->
            <section id="modPembayaran" class="module-view p-3.5 space-y-3 hidden">
                <!-- Daily Cashier Summary -->
                <div class="bg-white rounded-xl p-3 border border-slate-200/80 shadow-xs flex items-center justify-between">
                    <div>
                        <div class="text-[10px] text-slate-500 font-medium">Kasir & Penerimaan Harian</div>
                        <div class="text-sm font-bold text-slate-800" id="billingTotalOmset">Rp 4.850.000</div>
                    </div>
                    <button onclick="openModalBuatInvoiceManual()" class="px-2.5 py-1 rounded-md bg-teal-700 text-white text-[11px] font-semibold flex items-center gap-1 hover:bg-teal-800 transition">
                        <i class="fas fa-file-invoice-dollar text-[10px]"></i>
                        <span>Invoice Baru</span>
                    </button>
                </div>

                <!-- Invoices List -->
                <div class="space-y-2.5" id="invoiceListContainer">
                    <!-- Populated by JS -->
                </div>
            </section>


            <!-- ------------------------------------------------------------- -->
            <!-- 9. MODUL: ADMINISTRASI, USER & AUDIT LOG -->
            <!-- ------------------------------------------------------------- -->
            <section id="modAdmin" class="module-view p-3.5 space-y-3 hidden">
                <!-- Staff / User Management -->
                <div class="bg-white rounded-xl p-3 border border-slate-200/80 shadow-xs">
                    <div class="flex items-center justify-between mb-2">
                        <h2 class="text-xs font-bold text-slate-800">Manajemen Staf & Hak Akses</h2>
                        <span class="text-[10px] text-teal-700 font-semibold" id="staffCountLabel">6 User Aktif</span>
                    </div>
                    <div class="space-y-2" id="staffListContainer">
                        <!-- Populated by JS -->
                    </div>
                </div>

                <!-- System Audit Trail Log -->
                <div class="bg-white rounded-xl p-3 border border-slate-200/80 shadow-xs">
                    <div class="flex items-center justify-between mb-2">
                        <h2 class="text-xs font-bold text-slate-800">Audit Trail / Log Aktivitas</h2>
                        <span class="text-[10px] text-slate-400">Real-time</span>
                    </div>
                    <div class="divide-y divide-slate-100 text-[10px]" id="auditLogContainer">
                        <!-- Populated by JS -->
                    </div>
                </div>
            </section>

        </div>


        <!-- ================= BOTTOM NAVIGATION BAR ================= -->
        <nav class="absolute bottom-0 inset-x-0 bg-white border-t border-slate-200 px-2 py-1.5 z-40 flex items-center justify-around shadow-lg">
            <button onclick="switchModule('dashboard')" class="nav-btn flex flex-col items-center justify-center flex-1 py-1 text-teal-700 font-bold" data-target="dashboard">
                <i class="fas fa-chart-pie text-sm mb-0.5"></i>
                <span class="text-[10px] leading-none">Home</span>
            </button>

            <button onclick="switchModule('pasien')" class="nav-btn flex flex-col items-center justify-center flex-1 py-1 text-slate-500 hover:text-teal-700" data-target="pasien">
                <i class="fas fa-user-injured text-sm mb-0.5"></i>
                <span class="text-[10px] leading-none">Pasien</span>
            </button>

            <button onclick="switchModule('antrean')" class="nav-btn flex flex-col items-center justify-center flex-1 py-1 text-slate-500 hover:text-teal-700" data-target="antrean">
                <i class="fas fa-ticket text-sm mb-0.5"></i>
                <span class="text-[10px] leading-none">Antrean</span>
            </button>

            <button onclick="switchModule('periksa')" class="nav-btn flex flex-col items-center justify-center flex-1 py-1 text-slate-500 hover:text-teal-700" data-target="periksa">
                <i class="fas fa-stethoscope text-sm mb-0.5"></i>
                <span class="text-[10px] leading-none">EMR</span>
            </button>

            <button onclick="switchModule('resep')" class="nav-btn flex flex-col items-center justify-center flex-1 py-1 text-slate-500 hover:text-teal-700" data-target="resep">
                <i class="fas fa-pills text-sm mb-0.5"></i>
                <span class="text-[10px] leading-none">Farmasi</span>
            </button>

            <button onclick="switchModule('pembayaran')" class="nav-btn flex flex-col items-center justify-center flex-1 py-1 text-slate-500 hover:text-teal-700" data-target="pembayaran">
                <i class="fas fa-receipt text-sm mb-0.5"></i>
                <span class="text-[10px] leading-none">Kasir</span>
            </button>
        </nav>


        <!-- ================= MODALS & SLIDE-OVERS ================= -->

        <!-- 1. Modal: Registrasi Pasien Baru -->
        <div id="modalRegistrasiPasien" class="hidden fixed inset-0 z-50 bg-black/60 backdrop-blur-xs flex items-end sm:items-center justify-center p-0 sm:p-4">
            <div class="bg-white w-full max-w-sm rounded-t-2xl sm:rounded-2xl max-h-[90vh] overflow-y-auto no-scrollbar p-4 space-y-3 shadow-xl">
                <div class="flex items-center justify-between pb-2 border-b border-slate-100">
                    <div>
                        <h3 class="text-xs font-bold text-slate-800">Pendaftaran Pasien Baru</h3>
                        <p class="text-[10px] text-slate-500">Nomor RM akan di-generate otomatis</p>
                    </div>
                    <button onclick="closeModal('modalRegistrasiPasien')" class="text-slate-400 hover:text-slate-700 text-sm">&times;</button>
                </div>

                <form onsubmit="handleRegistrasiPasien(event)" class="space-y-2.5 text-xs text-slate-700">
                    <div>
                        <label class="block text-[10px] font-semibold text-slate-600 mb-0.5">Nomor Rekam Medis (Auto)</label>
                        <input type="text" id="regNoRm" readonly class="w-full px-2.5 py-1.5 rounded-lg bg-slate-100 font-bold text-teal-800 border border-slate-200">
                    </div>
                    <div>
                        <label class="block text-[10px] font-semibold text-slate-600 mb-0.5">Nama Lengkap Pasien *</label>
                        <input type="text" id="regNama" required placeholder="Contoh: Budi Santoso" class="w-full px-2.5 py-1.5 rounded-lg border border-slate-200 focus:outline-none focus:border-teal-500">
                    </div>
                    <div class="grid grid-cols-2 gap-2">
                        <div>
                            <label class="block text-[10px] font-semibold text-slate-600 mb-0.5">NIK (16 Digit) *</label>
                            <input type="text" id="regNik" maxlength="16" required placeholder="3174..." class="w-full px-2.5 py-1.5 rounded-lg border border-slate-200 focus:outline-none focus:border-teal-500">
                        </div>
                        <div>
                            <label class="block text-[10px] font-semibold text-slate-600 mb-0.5">Tanggal Lahir *</label>
                            <input type="date" id="regTglLahir" required class="w-full px-2.5 py-1.5 rounded-lg border border-slate-200 focus:outline-none focus:border-teal-500">
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-2">
                        <div>
                            <label class="block text-[10px] font-semibold text-slate-600 mb-0.5">Jenis Kelamin</label>
                            <select id="regGender" class="w-full px-2.5 py-1.5 rounded-lg border border-slate-200 focus:outline-none focus:border-teal-500 bg-white">
                                <option value="Laki-laki">Laki-laki</option>
                                <option value="Perempuan">Perempuan</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-[10px] font-semibold text-slate-600 mb-0.5">Gol. Darah</label>
                            <select id="regGolDarah" class="w-full px-2.5 py-1.5 rounded-lg border border-slate-200 focus:outline-none focus:border-teal-500 bg-white">
                                <option value="O+">O+</option>
                                <option value="A+">A+</option>
                                <option value="B+">B+</option>
                                <option value="AB+">AB+</option>
                                <option value="-">Tidak Tahu</option>
                            </select>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-2">
                        <div>
                            <label class="block text-[10px] font-semibold text-slate-600 mb-0.5">No. WhatsApp/HP *</label>
                            <input type="tel" id="regNoHp" required placeholder="0812..." class="w-full px-2.5 py-1.5 rounded-lg border border-slate-200 focus:outline-none focus:border-teal-500">
                        </div>
                        <div>
                            <label class="block text-[10px] font-semibold text-slate-600 mb-0.5">Jenis Penjamin</label>
                            <select id="regPenjamin" class="w-full px-2.5 py-1.5 rounded-lg border border-slate-200 focus:outline-none focus:border-teal-500 bg-white">
                                <option value="Umum / Mandiri">Umum / Mandiri</option>
                                <option value="BPJS Kesehatan">BPJS Kesehatan</option>
                                <option value="Asuransi Mandiri Inhealth">Asuransi Swasta</option>
                            </select>
                        </div>
                    </div>
                    <div>
                        <label class="block text-[10px] font-semibold text-slate-600 mb-0.5">Alamat Domisili</label>
                        <input type="text" id="regAlamat" placeholder="Jl. Raya..." class="w-full px-2.5 py-1.5 rounded-lg border border-slate-200 focus:outline-none focus:border-teal-500">
                    </div>
                    <div>
                        <label class="block text-[10px] font-semibold text-slate-600 mb-0.5">Riwayat Alergi Obat</label>
                        <input type="text" id="regAlergi" placeholder="Contoh: Alergi Penisilin / Tidak Ada" class="w-full px-2.5 py-1.5 rounded-lg border border-slate-200 focus:outline-none focus:border-teal-500">
                    </div>

                    <div class="pt-2 flex items-center gap-2">
                        <button type="button" onclick="closeModal('modalRegistrasiPasien')" class="w-1/3 py-2 rounded-lg bg-slate-100 font-semibold text-slate-600">Batal</button>
                        <button type="submit" class="w-2/3 py-2 rounded-lg bg-teal-700 text-white font-bold hover:bg-teal-800 transition">Simpan Pasien</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- 2. Modal: Kartu Pasien Digital (Virtual Member Card) -->
        <div id="modalKartuPasien" class="hidden fixed inset-0 z-50 bg-black/60 backdrop-blur-xs flex items-center justify-center p-4">
            <div class="bg-white w-full max-w-sm rounded-2xl overflow-hidden p-4 space-y-3 shadow-2xl" id="printableArea">
                <div class="flex items-center justify-between pb-2 border-b border-slate-100">
                    <span class="text-xs font-bold text-slate-800">Kartu Pasien Digital</span>
                    <button onclick="closeModal('modalKartuPasien')" class="text-slate-400 hover:text-slate-700 text-sm">&times;</button>
                </div>

                <!-- Digital Card Design -->
                <div class="bg-gradient-to-tr from-teal-800 via-teal-700 to-slate-900 text-white rounded-xl p-4 shadow-md relative overflow-hidden">
                    <div class="flex items-center justify-between mb-3">
                        <div class="flex items-center gap-2">
                            <div class="w-6 h-6 rounded bg-white/20 flex items-center justify-center text-xs text-white">
                                <i class="fas fa-hospital"></i>
                            </div>
                            <div>
                                <div class="text-[9px] uppercase tracking-wider text-teal-200">KARTU BEROBAT RESMI</div>
                                <div class="text-[11px] font-bold text-white">{{ $brandName }}</div>
                            </div>
                        </div>
                        <span class="text-[9px] px-2 py-0.5 rounded-full bg-emerald-400/20 text-emerald-300 font-bold border border-emerald-400/30" id="cardPenjamin">BPJS</span>
                    </div>

                    <div class="my-2">
                        <div class="text-[9px] text-teal-200">NOMOR REKAM MEDIS</div>
                        <div class="text-lg font-black tracking-wider text-white" id="cardNoRm">RM-2026-0182</div>
                    </div>

                    <div class="flex items-end justify-between mt-3 pt-2 border-t border-white/10 text-[10px]">
                        <div>
                            <div class="font-bold text-white text-xs" id="cardNama">Ananda Bagus Pratama</div>
                            <div class="text-teal-200 text-[9px]" id="cardNik">NIK: 3174051208940003</div>
                            <div class="text-teal-200 text-[9px]" id="cardTtl">12 Agu 1994 • Gol: O+</div>
                        </div>
                        <!-- Mini Barcode Visual Simulation -->
                        <div class="text-right">
                            <div class="bg-white p-1 rounded inline-block text-slate-900 text-[9px] font-mono font-bold tracking-tighter">
                                ||| | |||| | ||| ||
                            </div>
                            <div class="text-[8px] text-teal-300 mt-0.5">Scan di Loket</div>
                        </div>
                    </div>
                </div>

                <div class="flex items-center gap-2 pt-1 text-xs">
                    <button onclick="window.print()" class="flex-1 py-2 rounded-lg bg-teal-700 text-white font-bold flex items-center justify-center gap-1.5 hover:bg-teal-800 transition">
                        <i class="fas fa-print text-[11px]"></i>
                        <span>Cetak Kartu</span>
                    </button>
                    <button onclick="kirimKartuWa()" class="flex-1 py-2 rounded-lg bg-emerald-600 text-white font-bold flex items-center justify-center gap-1.5 hover:bg-emerald-700 transition">
                        <i class="fab fa-whatsapp text-[11px]"></i>
                        <span>Kirim ke WA</span>
                    </button>
                </div>
            </div>
        </div>

        <!-- 3. Modal: Ambil Tiket Antrean -->
        <div id="modalAmbilAntrean" class="hidden fixed inset-0 z-50 bg-black/60 backdrop-blur-xs flex items-end sm:items-center justify-center p-0 sm:p-4">
            <div class="bg-white w-full max-w-sm rounded-t-2xl sm:rounded-2xl p-4 space-y-3 shadow-xl">
                <div class="flex items-center justify-between pb-2 border-b border-slate-100">
                    <div>
                        <h3 class="text-xs font-bold text-slate-800">Ambil Nomor Antrean</h3>
                        <p class="text-[10px] text-slate-500">Pilih poli tujuan dan pasien</p>
                    </div>
                    <button onclick="closeModal('modalAmbilAntrean')" class="text-slate-400 hover:text-slate-700 text-sm">&times;</button>
                </div>

                <form onsubmit="handleAmbilAntrean(event)" class="space-y-2.5 text-xs text-slate-700">
                    <div>
                        <label class="block text-[10px] font-semibold text-slate-600 mb-0.5">Pilih Pasien Terdaftar *</label>
                        <select id="queuePasienSelect" required class="w-full px-2.5 py-1.5 rounded-lg border border-slate-200 focus:outline-none focus:border-teal-500 bg-white">
                            <!-- Populated by JS -->
                        </select>
                    </div>
                    <div>
                        <label class="block text-[10px] font-semibold text-slate-600 mb-0.5">Poli & Dokter Tujuan *</label>
                        <select id="queuePoliSelect" required class="w-full px-2.5 py-1.5 rounded-lg border border-slate-200 focus:outline-none focus:border-teal-500 bg-white">
                            <option value="Poli Umum|A|dr. Hendra Kusuma, Sp.PD">Poli Umum (dr. Hendra Kusuma, Sp.PD)</option>
                            <option value="Poli Gigi & Mulut|B|drg. Ahmad Fauzi">Poli Gigi & Mulut (drg. Ahmad Fauzi)</option>
                            <option value="Poli Spesialis Anak|C|dr. Siti Rahmawati, Sp.A">Poli Spesialis Anak (dr. Siti Rahmawati, Sp.A)</option>
                            <option value="Poli Kebidanan & KIA|D|dr. Maria Fransisca, Sp.OG">Poli Kebidanan (dr. Maria Fransisca, Sp.OG)</option>
                            <option value="Instalasi Farmasi|F|Apt. Nurul Hidayah">Instalasi Farmasi / Ambil Obat</option>
                        </select>
                    </div>

                    <div class="pt-2 flex items-center gap-2">
                        <button type="button" onclick="closeModal('modalAmbilAntrean')" class="w-1/3 py-2 rounded-lg bg-slate-100 font-semibold text-slate-600">Batal</button>
                        <button type="submit" class="w-2/3 py-2 rounded-lg bg-teal-700 text-white font-bold hover:bg-teal-800 transition">Cetak Tiket</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- 4. Modal: Booking / Appointment Baru -->
        <div id="modalBookingAppointment" class="hidden fixed inset-0 z-50 bg-black/60 backdrop-blur-xs flex items-end sm:items-center justify-center p-0 sm:p-4">
            <div class="bg-white w-full max-w-sm rounded-t-2xl sm:rounded-2xl max-h-[90vh] overflow-y-auto no-scrollbar p-4 space-y-3 shadow-xl">
                <div class="flex items-center justify-between pb-2 border-b border-slate-100">
                    <div>
                        <h3 class="text-xs font-bold text-slate-800">Booking Jadwal Dokter</h3>
                        <p class="text-[10px] text-slate-500">Buat janji temu pasien & reminder</p>
                    </div>
                    <button onclick="closeModal('modalBookingAppointment')" class="text-slate-400 hover:text-slate-700 text-sm">&times;</button>
                </div>

                <form onsubmit="handleBookingAppointment(event)" class="space-y-2.5 text-xs text-slate-700">
                    <div>
                        <label class="block text-[10px] font-semibold text-slate-600 mb-0.5">Pilih Pasien *</label>
                        <select id="bookPasienSelect" required class="w-full px-2.5 py-1.5 rounded-lg border border-slate-200 focus:outline-none focus:border-teal-500 bg-white">
                            <!-- Populated by JS -->
                        </select>
                    </div>
                    <div>
                        <label class="block text-[10px] font-semibold text-slate-600 mb-0.5">Dokter & Poli *</label>
                        <select id="bookDokterSelect" required class="w-full px-2.5 py-1.5 rounded-lg border border-slate-200 focus:outline-none focus:border-teal-500 bg-white">
                            <option value="dr. Hendra Kusuma, Sp.PD|Poli Umum">dr. Hendra Kusuma, Sp.PD (Poli Umum)</option>
                            <option value="drg. Ahmad Fauzi|Poli Gigi & Mulut">drg. Ahmad Fauzi (Poli Gigi)</option>
                            <option value="dr. Siti Rahmawati, Sp.A|Poli Spesialis Anak">dr. Siti Rahmawati, Sp.A (Poli Anak)</option>
                            <option value="dr. Maria Fransisca, Sp.OG|Poli Kebidanan">dr. Maria Fransisca, Sp.OG (Poli Kebidanan)</option>
                        </select>
                    </div>
                    <div class="grid grid-cols-2 gap-2">
                        <div>
                            <label class="block text-[10px] font-semibold text-slate-600 mb-0.5">Tanggal Janji *</label>
                            <input type="date" id="bookTanggal" required class="w-full px-2.5 py-1.5 rounded-lg border border-slate-200 focus:outline-none focus:border-teal-500">
                        </div>
                        <div>
                            <label class="block text-[10px] font-semibold text-slate-600 mb-0.5">Sesi Waktu *</label>
                            <select id="bookSesi" class="w-full px-2.5 py-1.5 rounded-lg border border-slate-200 focus:outline-none focus:border-teal-500 bg-white">
                                <option value="Sesi Pagi (09:00 - 11:30)">Pagi (09:00 - 11:30)</option>
                                <option value="Sesi Siang (13:00 - 15:30)">Siang (13:00 - 15:30)</option>
                                <option value="Sesi Sore (16:30 - 19:00)">Sore (16:30 - 19:00)</option>
                            </select>
                        </div>
                    </div>
                    <div>
                        <label class="block text-[10px] font-semibold text-slate-600 mb-0.5">Keluhan Awal</label>
                        <input type="text" id="bookKeluhan" placeholder="Keluhan utama..." class="w-full px-2.5 py-1.5 rounded-lg border border-slate-200 focus:outline-none focus:border-teal-500">
                    </div>

                    <div class="pt-2 flex items-center gap-2">
                        <button type="button" onclick="closeModal('modalBookingAppointment')" class="w-1/3 py-2 rounded-lg bg-slate-100 font-semibold text-slate-600">Batal</button>
                        <button type="submit" class="w-2/3 py-2 rounded-lg bg-teal-700 text-white font-bold hover:bg-teal-800 transition">Konfirmasi Booking</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- 5. Modal: Input Rekam Medis (EMR) -->
        <div id="modalPemeriksaan" class="hidden fixed inset-0 z-50 bg-black/60 backdrop-blur-xs flex items-end sm:items-center justify-center p-0 sm:p-4">
            <div class="bg-white w-full max-w-sm rounded-t-2xl sm:rounded-2xl max-h-[92vh] overflow-y-auto no-scrollbar p-4 space-y-3 shadow-xl">
                <div class="flex items-center justify-between pb-2 border-b border-slate-100">
                    <div>
                        <h3 class="text-xs font-bold text-slate-800">Input Pemeriksaan & EMR</h3>
                        <p class="text-[10px] text-slate-500">Tanda vital, ICD-10 & tindakan</p>
                    </div>
                    <button onclick="closeModal('modalPemeriksaan')" class="text-slate-400 hover:text-slate-700 text-sm">&times;</button>
                </div>

                <form onsubmit="handleSimpanPemeriksaan(event)" class="space-y-2.5 text-xs text-slate-700">
                    <div>
                        <label class="block text-[10px] font-semibold text-slate-600 mb-0.5">Pilih Pasien Diperiksa *</label>
                        <select id="emrPasienSelect" required class="w-full px-2.5 py-1.5 rounded-lg border border-slate-200 focus:outline-none focus:border-teal-500 bg-white">
                            <!-- Populated by JS -->
                        </select>
                    </div>

                    <!-- Tanda Vital Grid -->
                    <div class="bg-slate-50 p-2.5 rounded-xl border border-slate-200/80 space-y-2">
                        <span class="text-[10px] font-bold text-slate-700 block">Tanda-Tanda Vital (TTV)</span>
                        <div class="grid grid-cols-2 gap-2">
                            <div>
                                <label class="text-[9px] text-slate-500">Tekanan Darah</label>
                                <input type="text" id="emrTd" placeholder="120/80 mmHg" value="120/80 mmHg" class="w-full px-2 py-1 rounded border border-slate-200 text-xs">
                            </div>
                            <div>
                                <label class="text-[9px] text-slate-500">Suhu Tubuh</label>
                                <input type="text" id="emrSuhu" placeholder="36.5 °C" value="36.8 °C" class="w-full px-2 py-1 rounded border border-slate-200 text-xs">
                            </div>
                            <div>
                                <label class="text-[9px] text-slate-500">Denyut Nadi</label>
                                <input type="text" id="emrNadi" placeholder="80 bpm" value="82 bpm" class="w-full px-2 py-1 rounded border border-slate-200 text-xs">
                            </div>
                            <div>
                                <label class="text-[9px] text-slate-500">Laju Nafas</label>
                                <input type="text" id="emrNafas" placeholder="18 x/mnt" value="18 x/mnt" class="w-full px-2 py-1 rounded border border-slate-200 text-xs">
                            </div>
                            <div>
                                <label class="text-[9px] text-slate-500">Berat / Tinggi</label>
                                <input type="text" id="emrBbTb" placeholder="65 kg / 170 cm" value="65 kg / 168 cm" class="w-full px-2 py-1 rounded border border-slate-200 text-xs">
                            </div>
                            <div>
                                <label class="text-[9px] text-slate-500">SpO2 (Saturasi)</label>
                                <input type="text" id="emrSpo2" placeholder="98%" value="99%" class="w-full px-2 py-1 rounded border border-slate-200 text-xs">
                            </div>
                        </div>
                    </div>

                    <div>
                        <label class="block text-[10px] font-semibold text-slate-600 mb-0.5">Keluhan Utama (Anamnesis) *</label>
                        <textarea id="emrKeluhan" rows="2" required placeholder="Pasien mengeluhkan..." class="w-full px-2.5 py-1.5 rounded-lg border border-slate-200 focus:outline-none focus:border-teal-500"></textarea>
                    </div>

                    <div>
                        <label class="block text-[10px] font-semibold text-slate-600 mb-0.5">Pemeriksaan Fisik</label>
                        <input type="text" id="emrFisik" placeholder="Keadaan umum baik, konjungtiva anemis (-)..." class="w-full px-2.5 py-1.5 rounded-lg border border-slate-200 focus:outline-none focus:border-teal-500">
                    </div>

                    <div class="grid grid-cols-2 gap-2">
                        <div>
                            <label class="block text-[10px] font-semibold text-slate-600 mb-0.5">Kode ICD-10 *</label>
                            <select id="emrIcd10" class="w-full px-2.5 py-1.5 rounded-lg border border-slate-200 focus:outline-none focus:border-teal-500 bg-white">
                                <option value="J06.9|Acute Upper Respiratory Infection (ISPA)">J06.9 - ISPA</option>
                                <option value="I10|Essential Hypertension (Hipertensi Primer)">I10 - Hipertensi</option>
                                <option value="K29.7|Gastritis Unspecified">K29.7 - Gastritis / Maag</option>
                                <option value="E11.9|Type 2 Diabetes Mellitus">E11.9 - Diabetes Melitus</option>
                                <option value="K02.1|Caries of Dentine">K02.1 - Karies Gigi</option>
                                <option value="A09|Gastroenteritis Akut (Diare)">A09 - Diare / GEA</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-[10px] font-semibold text-slate-600 mb-0.5">Tindakan Medis</label>
                            <select id="emrTindakan" class="w-full px-2.5 py-1.5 rounded-lg border border-slate-200 focus:outline-none focus:border-teal-500 bg-white">
                                <option value="Pemeriksaan Rutin Dokter|80000">Pemeriksaan Dokter (Rp 80.000)</option>
                                <option value="Nebulizer Bronkodilator|65000">Nebulizer (Rp 65.000)</option>
                                <option value="Perawatan Luka / Ganti Perban|50000">Ganti Perban (Rp 50.000)</option>
                                <option value="Suntik Vitamin Neurotropik|75000">Suntik Vitamin (Rp 75.000)</option>
                                <option value="Tumpatan Sementara Gigi|150000">Tambal Gigi (Rp 150.000)</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block text-[10px] font-semibold text-slate-600 mb-0.5">Catatan & Edukasi Dokter</label>
                        <input type="text" id="emrCatatan" placeholder="Edukasi istirahat, hindari makanan dingin..." class="w-full px-2.5 py-1.5 rounded-lg border border-slate-200 focus:outline-none focus:border-teal-500">
                    </div>

                    <div class="pt-2 flex items-center gap-2">
                        <button type="button" onclick="closeModal('modalPemeriksaan')" class="w-1/3 py-2 rounded-lg bg-slate-100 font-semibold text-slate-600">Batal</button>
                        <button type="submit" class="w-2/3 py-2 rounded-lg bg-teal-700 text-white font-bold hover:bg-teal-800 transition">Simpan Rekam Medis</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- 6. Modal: Buat Resep Obat -->
        <div id="modalBuatResep" class="hidden fixed inset-0 z-50 bg-black/60 backdrop-blur-xs flex items-end sm:items-center justify-center p-0 sm:p-4">
            <div class="bg-white w-full max-w-sm rounded-t-2xl sm:rounded-2xl max-h-[90vh] overflow-y-auto no-scrollbar p-4 space-y-3 shadow-xl">
                <div class="flex items-center justify-between pb-2 border-b border-slate-100">
                    <div>
                        <h3 class="text-xs font-bold text-slate-800">Buat Resep Elektronik (e-Resep)</h3>
                        <p class="text-[10px] text-slate-500">Kirim langsung ke Instalasi Farmasi</p>
                    </div>
                    <button onclick="closeModal('modalBuatResep')" class="text-slate-400 hover:text-slate-700 text-sm">&times;</button>
                </div>

                <form onsubmit="handleSimpanResep(event)" class="space-y-2.5 text-xs text-slate-700">
                    <div>
                        <label class="block text-[10px] font-semibold text-slate-600 mb-0.5">Pasien Penerima Resep *</label>
                        <select id="resepPasienSelect" required class="w-full px-2.5 py-1.5 rounded-lg border border-slate-200 focus:outline-none focus:border-teal-500 bg-white">
                            <!-- Populated by JS -->
                        </select>
                    </div>
                    <div>
                        <label class="block text-[10px] font-semibold text-slate-600 mb-0.5">Pilih Obat (Dari Inventory) *</label>
                        <select id="resepObatSelect" required class="w-full px-2.5 py-1.5 rounded-lg border border-slate-200 focus:outline-none focus:border-teal-500 bg-white">
                            <!-- Populated by JS -->
                        </select>
                    </div>
                    <div class="grid grid-cols-2 gap-2">
                        <div>
                            <label class="block text-[10px] font-semibold text-slate-600 mb-0.5">Jumlah (Qty)</label>
                            <input type="number" id="resepQty" min="1" max="100" value="10" required class="w-full px-2.5 py-1.5 rounded-lg border border-slate-200 focus:outline-none focus:border-teal-500">
                        </div>
                        <div>
                            <label class="block text-[10px] font-semibold text-slate-600 mb-0.5">Dosis</label>
                            <input type="text" id="resepDosis" value="3 x 1 tablet" placeholder="3 x 1 tablet" required class="w-full px-2.5 py-1.5 rounded-lg border border-slate-200 focus:outline-none focus:border-teal-500">
                        </div>
                    </div>
                    <div>
                        <label class="block text-[10px] font-semibold text-slate-600 mb-0.5">Aturan Pakai *</label>
                        <select id="resepAturan" class="w-full px-2.5 py-1.5 rounded-lg border border-slate-200 focus:outline-none focus:border-teal-500 bg-white">
                            <option value="Sesudah makan (Bila demam / nyeri)">Sesudah makan (Bila demam / nyeri)</option>
                            <option value="Sesudah makan harus dihabiskan">Sesudah makan harus dihabiskan (Antibiotik)</option>
                            <option value="Sebelum makan (30 menit)">Sebelum makan (30 menit)</option>
                            <option value="Malam hari sebelum tidur">Malam hari sebelum tidur</option>
                        </select>
                    </div>

                    <div class="pt-2 flex items-center gap-2">
                        <button type="button" onclick="closeModal('modalBuatResep')" class="w-1/3 py-2 rounded-lg bg-slate-100 font-semibold text-slate-600">Batal</button>
                        <button type="submit" class="w-2/3 py-2 rounded-lg bg-teal-700 text-white font-bold hover:bg-teal-800 transition">Kirim ke Apotek</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- 7. Modal: Tambah Stok / Obat Baru -->
        <div id="modalTambahObat" class="hidden fixed inset-0 z-50 bg-black/60 backdrop-blur-xs flex items-end sm:items-center justify-center p-0 sm:p-4">
            <div class="bg-white w-full max-w-sm rounded-t-2xl sm:rounded-2xl p-4 space-y-3 shadow-xl">
                <div class="flex items-center justify-between pb-2 border-b border-slate-100">
                    <div>
                        <h3 class="text-xs font-bold text-slate-800">Restock / Tambah Obat</h3>
                        <p class="text-[10px] text-slate-500">Pencatatan batch obat masuk</p>
                    </div>
                    <button onclick="closeModal('modalTambahObat')" class="text-slate-400 hover:text-slate-700 text-sm">&times;</button>
                </div>

                <form onsubmit="handleTambahObat(event)" class="space-y-2.5 text-xs text-slate-700">
                    <div>
                        <label class="block text-[10px] font-semibold text-slate-600 mb-0.5">Nama Obat & Sediaan *</label>
                        <input type="text" id="invNama" required placeholder="Contoh: Salbutamol 2mg" class="w-full px-2.5 py-1.5 rounded-lg border border-slate-200">
                    </div>
                    <div class="grid grid-cols-2 gap-2">
                        <div>
                            <label class="block text-[10px] font-semibold text-slate-600 mb-0.5">Kategori</label>
                            <input type="text" id="invKategori" value="Bronkodilator" class="w-full px-2.5 py-1.5 rounded-lg border border-slate-200">
                        </div>
                        <div>
                            <label class="block text-[10px] font-semibold text-slate-600 mb-0.5">Satuan</label>
                            <input type="text" id="invSatuan" value="Strip (10 Tab)" class="w-full px-2.5 py-1.5 rounded-lg border border-slate-200">
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-2">
                        <div>
                            <label class="block text-[10px] font-semibold text-slate-600 mb-0.5">Jumlah Masuk</label>
                            <input type="number" id="invStok" min="1" value="50" required class="w-full px-2.5 py-1.5 rounded-lg border border-slate-200">
                        </div>
                        <div>
                            <label class="block text-[10px] font-semibold text-slate-600 mb-0.5">Batas Min Stok</label>
                            <input type="number" id="invMinStok" min="1" value="15" required class="w-full px-2.5 py-1.5 rounded-lg border border-slate-200">
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-2">
                        <div>
                            <label class="block text-[10px] font-semibold text-slate-600 mb-0.5">Harga Jual (Rp)</label>
                            <input type="number" id="invHargaJual" value="12000" required class="w-full px-2.5 py-1.5 rounded-lg border border-slate-200">
                        </div>
                        <div>
                            <label class="block text-[10px] font-semibold text-slate-600 mb-0.5">Expired Date</label>
                            <input type="date" id="invExpDate" value="2027-12-31" required class="w-full px-2.5 py-1.5 rounded-lg border border-slate-200">
                        </div>
                    </div>

                    <div class="pt-2 flex items-center gap-2">
                        <button type="button" onclick="closeModal('modalTambahObat')" class="w-1/3 py-2 rounded-lg bg-slate-100 font-semibold text-slate-600">Batal</button>
                        <button type="submit" class="w-2/3 py-2 rounded-lg bg-teal-700 text-white font-bold hover:bg-teal-800 transition">Simpan Stok</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- 8. Modal: Struk Kasir / Invoice Digital -->
        <div id="modalInvoiceDetail" class="hidden fixed inset-0 z-50 bg-black/60 backdrop-blur-xs flex items-center justify-center p-4">
            <div class="bg-white w-full max-w-sm rounded-2xl p-4 space-y-3 shadow-2xl">
                <div class="flex items-center justify-between pb-2 border-b border-slate-100">
                    <span class="text-xs font-bold text-slate-800">Kwitansi / Invoice Pembayaran</span>
                    <button onclick="closeModal('modalInvoiceDetail')" class="text-slate-400 hover:text-slate-700 text-sm">&times;</button>
                </div>

                <!-- Receipt Thermal Box -->
                <div class="bg-slate-50 border border-dashed border-slate-300 rounded-xl p-3 text-[11px] space-y-2 text-slate-700 font-mono">
                    <div class="text-center pb-2 border-b border-dashed border-slate-300">
                        <div class="font-bold text-xs text-slate-900">{{ $brandName }}</div>
                        <div class="text-[9px] text-slate-500">Pusat Layanan Medis Terpadu</div>
                        <div class="text-[9px] text-slate-500 mt-0.5" id="invTanggal">03/10/2026 10:15 WIB</div>
                    </div>

                    <div class="flex justify-between text-[10px]">
                        <span>No. Kwitansi:</span>
                        <span class="font-bold text-slate-800" id="invNomor">INV-2026-0429</span>
                    </div>
                    <div class="flex justify-between text-[10px]">
                        <span>Pasien:</span>
                        <span class="font-bold text-slate-800" id="invPasien">Siti Nurhaliza Putri</span>
                    </div>
                    <div class="flex justify-between text-[10px]">
                        <span>Penjamin:</span>
                        <span id="invPenjaminBadge">Umum / Mandiri</span>
                    </div>

                    <!-- Items list -->
                    <div class="border-t border-b border-dashed border-slate-300 py-1.5 space-y-1 text-[10px]" id="invItemsContainer">
                        <!-- Populated by JS -->
                    </div>

                    <div class="space-y-0.5 pt-1">
                        <div class="flex justify-between text-xs font-bold text-slate-900">
                            <span>TOTAL BAYAR:</span>
                            <span id="invTotalAmount">Rp 489.000</span>
                        </div>
                        <div class="flex justify-between text-[10px] text-emerald-700 font-semibold">
                            <span>Status:</span>
                            <span id="invStatusLabel">LUNAS</span>
                        </div>
                        <div class="flex justify-between text-[9px] text-slate-500">
                            <span>Metode:</span>
                            <span id="invMetodeLabel">QRIS Statis Bank BCA</span>
                        </div>
                    </div>

                    <div class="text-center pt-2 text-[9px] text-slate-400">
                        Terima kasih atas kepercayaan Anda.<br>Semoga lekas sembuh!
                    </div>
                </div>

                <div class="flex items-center gap-2 pt-1 text-xs">
                    <button onclick="window.print()" class="flex-1 py-2 rounded-lg bg-teal-700 text-white font-bold flex items-center justify-center gap-1.5 hover:bg-teal-800 transition">
                        <i class="fas fa-print text-[11px]"></i>
                        <span>Cetak Struk</span>
                    </button>
                    <button onclick="kirimInvoiceWa()" class="flex-1 py-2 rounded-lg bg-emerald-600 text-white font-bold flex items-center justify-center gap-1.5 hover:bg-emerald-700 transition">
                        <i class="fab fa-whatsapp text-[11px]"></i>
                        <span>Kirim WA</span>
                    </button>
                </div>
            </div>
        </div>

        <!-- 9. Modal: Display Monitor TV Antrean -->
        <div id="modalDisplayAntrean" class="hidden fixed inset-0 z-50 bg-slate-950/95 backdrop-blur-md flex flex-col p-4 text-white">
            <div class="flex items-center justify-between pb-3 border-b border-slate-800">
                <div class="flex items-center gap-2">
                    <span class="w-3 h-3 rounded-full bg-teal-400 pulse-subtle"></span>
                    <div>
                        <div class="text-[10px] uppercase tracking-widest text-teal-400 font-bold">Layar Monitor Antrean Poli</div>
                        <div class="text-xs font-bold text-white">{{ $brandName }}</div>
                    </div>
                </div>
                <button onclick="closeModal('modalDisplayAntrean')" class="text-slate-400 hover:text-white px-2 py-1 rounded bg-slate-800 text-xs">
                    Tutup Layar &times;
                </button>
            </div>

            <!-- Main TV Calling Card -->
            <div class="my-4 bg-gradient-to-r from-teal-900 to-slate-900 border border-teal-500/40 rounded-2xl p-6 text-center shadow-2xl relative overflow-hidden">
                <div class="text-xs text-teal-300 uppercase tracking-widest font-semibold">NOMOR ANTREAN DIPANGGIL</div>
                <div class="text-6xl font-black text-white tracking-wider my-3" id="displayBigNumber">A-04</div>
                <div class="text-lg font-bold text-teal-200" id="displayBigPoli">Poli Umum • Ruang 101</div>
                <div class="text-sm text-slate-300 mt-1" id="displayBigPatient">Ananda Bagus Pratama</div>
            </div>

            <!-- Poli Status Matrix -->
            <div class="flex-1 overflow-y-auto no-scrollbar space-y-2" id="displayPoliMatrix">
                <!-- Populated by JS -->
            </div>
        </div>

    </main>

    <!-- Global JSON database embedded -->
    <script>
        const INITIAL_KLINIK_DATABASE = @json($klinikDatabase);
        const CLINIC_NAME = "{{ $brandName }}";
        const CLINIC_WA = "{{ $cleanWa }}";
    </script>

    <!-- Complete Client-side Interactive Engine -->
    <script>
        // State storage using localStorage to persist changes
        let db = {};

        function initDatabase() {
            const saved = localStorage.getItem('sim_klinik_db_v1');
            if (saved) {
                try {
                    db = JSON.parse(saved);
                } catch(e) {
                    db = JSON.parse(JSON.stringify(INITIAL_KLINIK_DATABASE));
                }
            } else {
                db = JSON.parse(JSON.stringify(INITIAL_KLINIK_DATABASE));
                saveDatabase();
            }
        }

        function saveDatabase() {
            localStorage.setItem('sim_klinik_db_v1', JSON.stringify(db));
        }

        function resetDataToDefault() {
            if (confirm('Reset seluruh data demo ke kondisi awal JSON?')) {
                db = JSON.parse(JSON.stringify(INITIAL_KLINIK_DATABASE));
                saveDatabase();
                showToast('Database berhasil direset ke default!');
                renderAll();
            }
        }

        // Clock runner
        function updateClock() {
            const now = new Date();
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            const clockEl = document.getElementById('mobileClock');
            if (clockEl) clockEl.textContent = `${hours}:${minutes}`;
        }
        setInterval(updateClock, 1000);
        updateClock();

        // Audio Speech Synth for Queue Calling
        let audioSpeechEnabled = true;
        function toggleAudioSpeech() {
            audioSpeechEnabled = !audioSpeechEnabled;
            const icon = document.getElementById('audioIcon');
            if (audioSpeechEnabled) {
                icon.className = 'fas fa-volume-high text-[10px] text-teal-200';
                showToast('Suara pemanggilan antrean AKTIF');
            } else {
                icon.className = 'fas fa-volume-xmark text-[10px] text-rose-300';
                showToast('Suara pemanggilan antrean DIMATIKAN');
            }
        }

        function speakQueueAnnouncement(nomor, poli, ruang) {
            if (!audioSpeechEnabled) return;

            if ('speechSynthesis' in window) {
                // Cancel any ongoing speech
                window.speechSynthesis.cancel();

                // Format text e.g. "Nomor Antrean A 04, Silakan menuju Poli Umum Ruang 101"
                // Split letter & digits for clear Indonesian pronunciation
                const nomorSpelled = nomor.replace('-', ' ');
                const text = `Nomor antrean, ${nomorSpelled}. Silakan menuju, ${poli}.`;

                const utterance = new SpeechSynthesisUtterance(text);
                utterance.lang = 'id-ID';
                utterance.rate = 0.9;
                utterance.pitch = 1.0;

                window.speechSynthesis.speak(utterance);
            }
        }

        // Navigation Switcher
        function switchModule(targetId) {
            // Hide all module sections
            document.querySelectorAll('.module-view').forEach(el => el.classList.add('hidden'));

            // Show selected
            const map = {
                dashboard: 'modDashboard',
                pasien: 'modPasien',
                booking: 'modBooking',
                antrean: 'modAntrean',
                periksa: 'modPeriksa',
                resep: 'modResep',
                inventory: 'modInventory',
                pembayaran: 'modPembayaran',
                admin: 'modAdmin'
            };

            const selectedSec = document.getElementById(map[targetId]);
            if (selectedSec) {
                selectedSec.classList.remove('hidden');
            }

            // Update top tabs style
            document.querySelectorAll('.tab-btn').forEach(btn => {
                if (btn.getAttribute('data-module') === targetId) {
                    btn.className = 'tab-btn px-2.5 py-1 rounded-full whitespace-nowrap bg-white text-teal-800 font-semibold shadow-xs';
                } else {
                    btn.className = 'tab-btn px-2.5 py-1 rounded-full whitespace-nowrap bg-teal-800/70 text-teal-100 hover:bg-teal-800';
                }
            });

            // Update bottom nav style
            document.querySelectorAll('.nav-btn').forEach(btn => {
                if (btn.getAttribute('data-target') === targetId) {
                    btn.className = 'nav-btn flex flex-col items-center justify-center flex-1 py-1 text-teal-700 font-bold';
                } else {
                    btn.className = 'nav-btn flex flex-col items-center justify-center flex-1 py-1 text-slate-500 hover:text-teal-700';
                }
            });

            // Scroll app viewport to top
            const vp = document.getElementById('appViewport');
            if (vp) vp.scrollTop = 0;
        }

        // Toast Helper
        let toastTimer = null;
        function showToast(msg) {
            const toast = document.getElementById('toastNotification');
            const msgEl = document.getElementById('toastMsg');
            if (!toast || !msgEl) return;

            msgEl.textContent = msg;
            toast.classList.remove('hidden');

            if (toastTimer) clearTimeout(toastTimer);
            toastTimer = setTimeout(() => {
                hideToast();
            }, 3000);
        }

        function hideToast() {
            const toast = document.getElementById('toastNotification');
            if (toast) toast.classList.add('hidden');
        }

        // Modals management
        function openModal(id) {
            const el = document.getElementById(id);
            if (el) el.classList.remove('hidden');
        }

        function closeModal(id) {
            const el = document.getElementById(id);
            if (el) el.classList.add('hidden');
        }

        // Formatting Helpers
        function formatRupiah(num) {
            return 'Rp ' + Number(num || 0).toLocaleString('id-ID');
        }

        function generateNextRmNumber() {
            const nextCount = (db.patients ? db.patients.length : 0) + 186;
            return `RM-2026-0${nextCount}`;
        }

        // ================= RENDERING LOGIC =================
        function renderAll() {
            renderDashboard();
            renderPasien();
            renderBooking();
            renderAntrean();
            renderPeriksa();
            renderResep();
            renderInventory();
            renderPembayaran();
            renderAdmin();
            populateSelectOptions();
        }

        // 1. Render Dashboard
        function renderDashboard() {
            document.getElementById('kpiPasienHariIni').textContent = db.stats ? db.stats.total_patients_today : (db.patients?.length || 42);
            document.getElementById('kpiAntreanAktif').textContent = db.queues ? db.queues.filter(q => q.status === 'Menunggu' || q.status === 'Dipanggil').length : 6;
            document.getElementById('kpiPendapatan').textContent = formatRupiah(db.stats?.revenue_today || 4850000);
            document.getElementById('kpiStokKritis').textContent = db.inventory ? db.inventory.filter(i => i.stok <= i.min_stok).length : 3;

            // Render Poli list
            const poliContainer = document.getElementById('dashboardPoliList');
            if (poliContainer && db.poli) {
                poliContainer.innerHTML = db.poli.map(p => `
                    <div class="flex items-center justify-between p-2 rounded-lg bg-slate-50 border border-slate-100 text-xs">
                        <div class="flex items-center gap-2">
                            <span class="w-6 h-6 rounded bg-teal-100 text-teal-800 font-bold flex items-center justify-center text-[10px]">${p.code}</span>
                            <div>
                                <div class="font-semibold text-slate-800 text-[11px]">${p.name}</div>
                                <div class="text-[10px] text-slate-500">${p.doctor} • ${p.room}</div>
                            </div>
                        </div>
                        <div class="text-right">
                            <span class="text-[11px] font-bold text-teal-700 bg-teal-50 px-2 py-0.5 rounded border border-teal-200">No: ${p.active_queue}</span>
                            <div class="text-[9px] text-slate-400 mt-0.5">${p.waiting_count} antrean lagi</div>
                        </div>
                    </div>
                `).join('');
            }

            // Render Recent Visits Mini Feed
            const visitsContainer = document.getElementById('dashboardRecentVisits');
            if (visitsContainer && db.medical_records) {
                visitsContainer.innerHTML = db.medical_records.map(rec => `
                    <div class="py-2 flex items-center justify-between">
                        <div>
                            <div class="font-semibold text-slate-800">${rec.pasien_nama} <span class="text-[9px] text-teal-700 font-mono font-normal">(${rec.no_rm})</span></div>
                            <div class="text-[10px] text-slate-500">${rec.diagnosis.nama} (${rec.diagnosis.kode_icd10})</div>
                        </div>
                        <span class="px-2 py-0.5 rounded text-[9px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">Selesai</span>
                    </div>
                `).join('');
            }
        }

        // 2. Render Pasien
        function renderPasien(filteredList = null) {
            const list = filteredList || db.patients || [];
            const container = document.getElementById('patientListContainer');
            const countLabel = document.getElementById('patientCountLabel');

            if (countLabel) countLabel.textContent = `${list.length} Pasien Terdata`;

            if (container) {
                if (list.length === 0) {
                    container.innerHTML = `<div class="p-6 text-center text-xs text-slate-400 bg-white rounded-xl">Pasien tidak ditemukan.</div>`;
                    return;
                }

                container.innerHTML = list.map(p => `
                    <div class="bg-white rounded-xl p-3 border border-slate-200/80 shadow-xs space-y-2">
                        <div class="flex items-start justify-between">
                            <div>
                                <div class="flex items-center gap-1.5">
                                    <span class="font-bold text-slate-900 text-xs">${p.nama}</span>
                                    <span class="text-[9px] px-1.5 py-0.2 rounded bg-slate-100 text-slate-600 font-mono font-medium">${p.gender === 'Laki-laki' ? 'L' : 'P'}, ${p.umur}</span>
                                </div>
                                <div class="text-[10px] font-mono text-teal-700 font-bold mt-0.5">${p.no_rm} • NIK: ${p.nik}</div>
                            </div>
                            <span class="text-[9px] px-2 py-0.5 rounded-full font-semibold ${p.penjamin.includes('BPJS') ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-sky-50 text-sky-700 border border-sky-200'}">
                                ${p.penjamin}
                            </span>
                        </div>

                        <div class="bg-slate-50 p-2 rounded-lg text-[10px] text-slate-600 space-y-0.5">
                            <div><strong>Alamat:</strong> ${p.alamat || '-'}</div>
                            <div><strong>Alergi:</strong> <span class="${p.alergi && p.alergi !== 'Tidak Ada' ? 'text-rose-600 font-semibold' : 'text-slate-500'}">${p.alergi || 'Tidak Ada'}</span></div>
                            <div><strong>No. HP:</strong> ${p.no_hp} • <strong>Kunjungan:</strong> ${p.total_kunjungan || 1}x</div>
                        </div>

                        <div class="flex items-center justify-end gap-1.5 pt-1 text-[10px]">
                            <button onclick="lihatKartuDigital('${p.no_rm}')" class="px-2.5 py-1 rounded bg-teal-50 hover:bg-teal-100 text-teal-800 font-semibold border border-teal-200 flex items-center gap-1 transition">
                                <i class="fas fa-id-card text-[10px]"></i>
                                <span>Kartu Digital</span>
                            </button>
                            <button onclick="ambilAntreanUntukPasien('${p.id}')" class="px-2.5 py-1 rounded bg-teal-700 hover:bg-teal-800 text-white font-semibold flex items-center gap-1 transition">
                                <i class="fas fa-ticket text-[10px]"></i>
                                <span>Antrekan</span>
                            </button>
                        </div>
                    </div>
                `).join('');
            }
        }

        function filterPasienList() {
            const query = (document.getElementById('searchPasienInput')?.value || '').toLowerCase().trim();
            if (!query) {
                renderPasien();
                return;
            }
            const filtered = (db.patients || []).filter(p =>
                p.nama.toLowerCase().includes(query) ||
                p.no_rm.toLowerCase().includes(query) ||
                p.nik.includes(query) ||
                (p.no_hp && p.no_hp.includes(query))
            );
            renderPasien(filtered);
        }

        // 3. Render Booking
        function renderBooking() {
            // Render Doctor Schedules
            const schContainer = document.getElementById('doctorScheduleList');
            if (schContainer && db.doctors) {
                schContainer.innerHTML = db.doctors.map(d => `
                    <div class="flex items-center justify-between p-2 rounded-lg bg-slate-50 border border-slate-100 text-xs">
                        <div>
                            <div class="font-bold text-slate-800 text-[11px]">${d.name}</div>
                            <div class="text-[10px] text-teal-700 font-medium">${d.specialist} • ${d.room}</div>
                            <div class="text-[9px] text-slate-500">${d.schedule}</div>
                        </div>
                        <span class="text-[9px] font-bold px-2 py-0.5 rounded ${d.status === 'Praktek' ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-800'}">
                            ${d.status}
                        </span>
                    </div>
                `).join('');
            }

            // Render Appointment cards
            const apptContainer = document.getElementById('appointmentListContainer');
            const countLabel = document.getElementById('appointmentCountLabel');
            if (countLabel && db.appointments) countLabel.textContent = `${db.appointments.length} Jadwal`;

            if (apptContainer && db.appointments) {
                apptContainer.innerHTML = db.appointments.map(a => `
                    <div class="bg-white rounded-xl p-3 border border-slate-200/80 shadow-xs space-y-2">
                        <div class="flex items-start justify-between">
                            <div>
                                <div class="font-bold text-slate-900 text-xs">${a.pasien_nama}</div>
                                <div class="text-[10px] text-teal-700 font-medium">${a.dokter} (${a.poli})</div>
                            </div>
                            <span class="text-[9px] px-2 py-0.5 rounded font-bold ${a.status === 'Selesai' ? 'bg-slate-100 text-slate-600' : a.status === 'Dibatalkan' ? 'bg-rose-100 text-rose-700' : 'bg-emerald-100 text-emerald-800'}">
                                ${a.status}
                            </span>
                        </div>

                        <div class="bg-slate-50 p-2 rounded text-[10px] text-slate-600 space-y-0.5">
                            <div><strong>Waktu:</strong> ${a.tanggal} • ${a.sesi}</div>
                            <div><strong>Keluhan:</strong> ${a.keluhan || '-'}</div>
                            <div><strong>WhatsApp:</strong> ${a.no_hp}</div>
                        </div>

                        <div class="flex items-center justify-between pt-1 text-[10px]">
                            <button onclick="kirimReminderWa('${a.id}')" class="px-2.5 py-1 rounded bg-emerald-50 text-emerald-700 font-bold border border-emerald-200 flex items-center gap-1 hover:bg-emerald-100 transition">
                                <i class="fab fa-whatsapp text-[11px]"></i>
                                <span>Reminder WA</span>
                            </button>

                            <div class="flex items-center gap-1">
                                ${a.status !== 'Dibatalkan' && a.status !== 'Selesai' ? `
                                    <button onclick="rescheduleAppointment('${a.id}')" class="px-2 py-1 rounded bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold">Reschedule</button>
                                    <button onclick="cancelAppointment('${a.id}')" class="px-2 py-1 rounded bg-rose-50 hover:bg-rose-100 text-rose-700 font-semibold">Batalkan</button>
                                ` : ''}
                            </div>
                        </div>
                    </div>
                `).join('');
            }
        }

        // 4. Render Antrean
        let currentPoliFilter = 'all';
        function renderAntrean() {
            const container = document.getElementById('queueListContainer');
            let list = db.queues || [];

            if (currentPoliFilter !== 'all') {
                list = list.filter(q => q.poli === currentPoliFilter);
            }

            // Find currently active calling number
            const activeCall = (db.queues || []).find(q => q.status === 'Sedang Diperiksa' || q.status === 'Dipanggil') || list[0];
            if (activeCall) {
                document.getElementById('activeCallingNumber').textContent = activeCall.nomor;
                document.getElementById('activeCallingPoli').textContent = `${activeCall.poli} • ${activeCall.dokter}`;
                document.getElementById('activeCallingPatient').textContent = activeCall.pasien_nama;

                const bigNum = document.getElementById('displayBigNumber');
                if (bigNum) bigNum.textContent = activeCall.nomor;
                const bigPoli = document.getElementById('displayBigPoli');
                if (bigPoli) bigPoli.textContent = `${activeCall.poli} • ${activeCall.dokter}`;
                const bigPatient = document.getElementById('displayBigPatient');
                if (bigPatient) bigPatient.textContent = activeCall.pasien_nama;
            }

            if (container) {
                if (list.length === 0) {
                    container.innerHTML = `<div class="p-6 text-center text-xs text-slate-400 bg-white rounded-xl">Tidak ada antrean untuk poli ini.</div>`;
                    return;
                }

                container.innerHTML = list.map(q => `
                    <div class="bg-white rounded-xl p-3 border border-slate-200/80 shadow-xs flex items-center justify-between">
                        <div class="flex items-center gap-2.5">
                            <div class="w-10 h-10 rounded-xl bg-teal-800 text-white font-black text-sm flex items-center justify-center shadow-xs">
                                ${q.nomor}
                            </div>
                            <div>
                                <div class="font-bold text-slate-900 text-xs">${q.pasien_nama}</div>
                                <div class="text-[10px] text-teal-700 font-semibold">${q.poli}</div>
                                <div class="text-[9px] text-slate-400">Ambil: ${q.waktu_ambil} • ${q.penjamin}</div>
                            </div>
                        </div>

                        <div class="text-right flex flex-col items-end gap-1">
                            <span class="text-[9px] px-2 py-0.5 rounded font-bold ${
                                q.status === 'Sedang Diperiksa' ? 'bg-emerald-100 text-emerald-800' :
                                q.status === 'Dipanggil' ? 'bg-amber-100 text-amber-800 animate-pulse' :
                                q.status === 'Selesai' ? 'bg-slate-100 text-slate-600' : 'bg-sky-100 text-sky-800'
                            }">${q.status}</span>

                            <div class="flex items-center gap-1 mt-1">
                                <button onclick="panggilAntrean('${q.id}')" class="px-2 py-0.5 rounded bg-teal-50 hover:bg-teal-100 text-teal-800 font-bold text-[10px] border border-teal-200">
                                    <i class="fas fa-bullhorn text-[9px] mr-0.5"></i> Panggil
                                </button>
                                <button onclick="selesaikanStatusAntrean('${q.id}')" class="px-2 py-0.5 rounded bg-slate-100 hover:bg-slate-200 text-slate-700 font-medium text-[10px]">
                                    Selesai
                                </button>
                            </div>
                        </div>
                    </div>
                `).join('');
            }
        }

        function filterQueuePoli(poli) {
            currentPoliFilter = poli;
            document.querySelectorAll('.queue-tab').forEach(b => {
                if (b.getAttribute('data-poli') === poli) {
                    b.className = 'queue-tab px-2 py-0.5 rounded bg-teal-100 text-teal-800 font-semibold';
                } else {
                    b.className = 'queue-tab px-2 py-0.5 rounded bg-slate-100 text-slate-600';
                }
            });
            renderAntrean();
        }

        function panggilAntrean(queueId) {
            const q = (db.queues || []).find(item => item.id == queueId);
            if (!q) return;

            q.status = 'Dipanggil';
            q.waktu_panggil = new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' }) + ' WIB';
            saveDatabase();
            renderAntrean();

            // Announce voice speech
            speakQueueAnnouncement(q.nomor, q.poli);
            showToast(`Memanggil antrean ${q.nomor}: ${q.pasien_nama}`);
        }

        function panggilUlangAntreanAktif() {
            const num = document.getElementById('activeCallingNumber')?.textContent || 'A-04';
            const poli = document.getElementById('activeCallingPoli')?.textContent || 'Poli Umum';
            speakQueueAnnouncement(num, poli);
            showToast(`Panggilan ulang nomor ${num}`);
        }

        function selesaikanAntreanAktif() {
            const num = document.getElementById('activeCallingNumber')?.textContent || 'A-04';
            const q = (db.queues || []).find(item => item.nomor === num);
            if (q) {
                q.status = 'Selesai';
                saveDatabase();
                renderAntrean();
                showToast(`Antrean ${num} ditandai selesai.`);
            }
        }

        function selesaikanStatusAntrean(queueId) {
            const q = (db.queues || []).find(item => item.id == queueId);
            if (q) {
                q.status = 'Selesai';
                saveDatabase();
                renderAntrean();
                showToast(`Antrean ${q.nomor} selesai diperiksa.`);
            }
        }

        // 5. Render EMR / Pemeriksaan
        function renderPeriksa(filteredList = null) {
            const list = filteredList || db.medical_records || [];
            const container = document.getElementById('emrListContainer');

            if (container) {
                if (list.length === 0) {
                    container.innerHTML = `<div class="p-6 text-center text-xs text-slate-400 bg-white rounded-xl">Rekam medis tidak ditemukan.</div>`;
                    return;
                }

                container.innerHTML = list.map(rec => `
                    <div class="bg-white rounded-xl p-3.5 border border-slate-200/80 shadow-xs space-y-2">
                        <div class="flex items-start justify-between pb-1 border-b border-slate-100">
                            <div>
                                <div class="font-bold text-slate-900 text-xs">${rec.pasien_nama}</div>
                                <div class="text-[10px] font-mono text-teal-700 font-bold">${rec.no_rm} • ${rec.tanggal}</div>
                            </div>
                            <span class="text-[9px] px-2 py-0.5 rounded bg-teal-50 text-teal-800 font-semibold border border-teal-200">${rec.poli}</span>
                        </div>

                        <!-- Anamnesis & Fisik -->
                        <div class="text-[10px] text-slate-700 space-y-1">
                            <div><strong>Keluhan:</strong> ${rec.keluhan_utama}</div>
                            <div><strong>Pemeriksaan Fisik:</strong> ${rec.pemeriksaan_fisik || '-'}</div>
                        </div>

                        <!-- TTV Badges -->
                        <div class="bg-slate-50 p-2 rounded-lg grid grid-cols-3 gap-1 text-[9px] text-slate-600">
                            <div>TD: <span class="font-bold text-slate-800">${rec.ttv?.tekanan_darah || '-'}</span></div>
                            <div>Suhu: <span class="font-bold text-slate-800">${rec.ttv?.suhu || '-'}</span></div>
                            <div>Nadi: <span class="font-bold text-slate-800">${rec.ttv?.nadi || '-'}</span></div>
                            <div>Nafas: <span class="font-bold text-slate-800">${rec.ttv?.pernapasan || '-'}</span></div>
                            <div>BB/TB: <span class="font-bold text-slate-800">${rec.ttv?.berat_badan || '-'} / ${rec.ttv?.tinggi_badan || '-'}</span></div>
                            <div>SpO2: <span class="font-bold text-slate-800">${rec.ttv?.spo2 || '-'}</span></div>
                        </div>

                        <!-- Diagnosis ICD-10 & Tindakan -->
                        <div class="pt-1 flex items-center justify-between text-[10px]">
                            <div>
                                <span class="text-[9px] text-slate-400">Diagnosis Kerja:</span>
                                <div class="font-bold text-slate-800">${rec.diagnosis?.nama} <span class="text-teal-700">(${rec.diagnosis?.kode_icd10})</span></div>
                            </div>
                            <button onclick="bukaBuatResepUntukPasien('${rec.no_rm}', '${rec.pasien_nama}')" class="px-2.5 py-1 rounded bg-teal-700 hover:bg-teal-800 text-white font-semibold flex items-center gap-1 shadow-xs">
                                <i class="fas fa-pills text-[9px]"></i>
                                <span>Buat Resep</span>
                            </button>
                        </div>
                    </div>
                `).join('');
            }
        }

        function filterEmrList() {
            const query = (document.getElementById('searchEmrInput')?.value || '').toLowerCase().trim();
            if (!query) {
                renderPeriksa();
                return;
            }
            const filtered = (db.medical_records || []).filter(r =>
                r.pasien_nama.toLowerCase().includes(query) ||
                r.no_rm.toLowerCase().includes(query) ||
                r.diagnosis?.nama.toLowerCase().includes(query) ||
                r.diagnosis?.kode_icd10.toLowerCase().includes(query)
            );
            renderPeriksa(filtered);
        }

        // 6. Render Resep
        function renderResep() {
            const container = document.getElementById('prescriptionsContainer');
            if (container && db.prescriptions) {
                container.innerHTML = db.prescriptions.map(rx => `
                    <div class="bg-white rounded-xl p-3 border border-slate-200/80 shadow-xs space-y-2">
                        <div class="flex items-start justify-between pb-1 border-b border-slate-100">
                            <div>
                                <div class="font-bold text-slate-900 text-xs">${rx.pasien_nama}</div>
                                <div class="text-[10px] text-teal-700 font-mono font-medium">${rx.no_resep} • ${rx.no_rm}</div>
                            </div>
                            <span class="text-[9px] px-2 py-0.5 rounded font-bold ${
                                rx.status === 'Diserahkan' ? 'bg-slate-100 text-slate-600' :
                                rx.status === 'Siap Diserahkan' ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-800'
                            }">
                                ${rx.status}
                            </span>
                        </div>

                        <!-- Items list -->
                        <div class="bg-slate-50 p-2 rounded-lg space-y-1.5 text-[10px] text-slate-700">
                            ${rx.items.map(it => `
                                <div class="flex items-center justify-between border-b border-slate-200/50 pb-1">
                                    <div>
                                        <div class="font-semibold text-slate-900">${it.nama} (${it.qty} unit)</div>
                                        <div class="text-[9px] text-teal-700">${it.dosis} • ${it.aturan}</div>
                                    </div>
                                    <span class="font-mono text-slate-600 font-medium">${formatRupiah(it.harga || 0)}</span>
                                </div>
                            `).join('')}
                        </div>

                        <div class="flex items-center justify-between pt-1 text-[10px]">
                            <div class="text-slate-500 font-medium">Total: <strong class="text-slate-800">${formatRupiah(rx.total_obat || 0)}</strong></div>
                            ${rx.status !== 'Diserahkan' ? `
                                <button onclick="serahkanObatKePasien('${rx.id}')" class="px-2.5 py-1 rounded bg-emerald-600 hover:bg-emerald-700 text-white font-bold flex items-center gap-1 shadow-xs transition">
                                    <i class="fas fa-check text-[9px]"></i>
                                    <span>Serahkan Obat</span>
                                </button>
                            ` : `
                                <span class="text-[9px] text-slate-400">Obat Telah Diambil</span>
                            `}
                        </div>
                    </div>
                `).join('');
            }
        }

        function serahkanObatKePasien(rxId) {
            const rx = (db.prescriptions || []).find(r => r.id == rxId);
            if (!rx) return;

            rx.status = 'Diserahkan';

            // Deduct inventory items
            if (rx.items && db.inventory) {
                rx.items.forEach(it => {
                    const inv = db.inventory.find(i => i.nama.toLowerCase().includes(it.nama.toLowerCase().split(' ')[0]));
                    if (inv) {
                        inv.stok = Math.max(0, inv.stok - (it.qty || 1));
                    }
                });
            }

            // Log activity
            db.audit_logs = db.audit_logs || [];
            db.audit_logs.unshift({
                waktu: new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' }) + ' WIB',
                user: 'Apoteker',
                aksi: 'Penyerahan Obat Resep',
                detail: `Menyerahkan resep ${rx.no_resep} kepada ${rx.pasien_nama}`
            });

            saveDatabase();
            renderResep();
            renderInventory();
            renderDashboard();
            showToast(`Obat ${rx.no_resep} berhasil diserahkan ke ${rx.pasien_nama}. Stok diperbarui!`);
        }

        // 7. Render Inventory
        function renderInventory(filteredList = null) {
            const list = filteredList || db.inventory || [];
            const container = document.getElementById('inventoryListContainer');
            const totalLabel = document.getElementById('invTotalJenis');

            if (totalLabel && db.inventory) totalLabel.textContent = `${db.inventory.length} Item Obat`;

            if (container) {
                if (list.length === 0) {
                    container.innerHTML = `<div class="p-6 text-center text-xs text-slate-400 bg-white rounded-xl">Obat tidak ditemukan.</div>`;
                    return;
                }

                container.innerHTML = list.map(item => `
                    <div class="bg-white rounded-xl p-3 border border-slate-200/80 shadow-xs flex items-center justify-between">
                        <div>
                            <div class="flex items-center gap-1.5">
                                <span class="font-bold text-slate-900 text-xs">${item.nama}</span>
                                <span class="text-[9px] px-1.5 py-0.2 rounded font-mono ${
                                    item.stok <= item.min_stok ? 'bg-rose-100 text-rose-700 font-bold' : 'bg-slate-100 text-slate-600'
                                }">${item.satuan}</span>
                            </div>
                            <div class="text-[10px] text-teal-700 font-medium">${item.kode} • ${item.kategori}</div>
                            <div class="text-[9px] text-slate-400 mt-0.5">Exp: ${item.exp_date} • Jual: ${formatRupiah(item.harga_jual)}</div>
                        </div>

                        <div class="text-right">
                            <div class="text-sm font-extrabold ${item.stok <= item.min_stok ? 'text-rose-600' : 'text-slate-800'}">
                                ${item.stok} <span class="text-[9px] font-normal text-slate-500">tersisa</span>
                            </div>
                            <span class="text-[9px] font-semibold px-2 py-0.5 rounded ${
                                item.stok <= 10 ? 'bg-rose-100 text-rose-800' :
                                item.stok <= item.min_stok ? 'bg-amber-100 text-amber-800' : 'bg-emerald-100 text-emerald-800'
                            }">${item.stok <= item.min_stok ? 'Menipis' : 'Aman'}</span>
                        </div>
                    </div>
                `).join('');
            }
        }

        function filterInventoryList() {
            const query = (document.getElementById('searchInventoryInput')?.value || '').toLowerCase().trim();
            if (!query) {
                renderInventory();
                return;
            }
            const filtered = (db.inventory || []).filter(i =>
                i.nama.toLowerCase().includes(query) ||
                i.kode.toLowerCase().includes(query) ||
                i.kategori.toLowerCase().includes(query)
            );
            renderInventory(filtered);
        }

        // 8. Render Pembayaran
        function renderPembayaran() {
            const container = document.getElementById('invoiceListContainer');
            const totalOmsetEl = document.getElementById('billingTotalOmset');

            if (container && db.invoices) {
                const totalOmset = db.invoices.reduce((acc, inv) => acc + (inv.total_bayar || 0), 0);
                if (totalOmsetEl) totalOmsetEl.textContent = formatRupiah(totalOmset);

                container.innerHTML = db.invoices.map(inv => `
                    <div class="bg-white rounded-xl p-3 border border-slate-200/80 shadow-xs space-y-2">
                        <div class="flex items-start justify-between pb-1 border-b border-slate-100">
                            <div>
                                <div class="font-bold text-slate-900 text-xs">${inv.pasien_nama}</div>
                                <div class="text-[10px] text-teal-700 font-mono font-medium">${inv.no_invoice} • ${inv.tanggal}</div>
                            </div>
                            <span class="text-[9px] px-2 py-0.5 rounded font-bold ${
                                inv.status.includes('Lunas') ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-800'
                            }">
                                ${inv.status}
                            </span>
                        </div>

                        <!-- Items breakdown -->
                        <div class="bg-slate-50 p-2 rounded-lg text-[10px] text-slate-700 space-y-1">
                            ${inv.items.map(it => `
                                <div class="flex justify-between">
                                    <span>${it.deskripsi}</span>
                                    <span class="font-mono text-slate-600">${formatRupiah(it.biaya || 0)}</span>
                                </div>
                            `).join('')}
                        </div>

                        <div class="flex items-center justify-between pt-1 text-[11px]">
                            <div>
                                <span class="text-[9px] text-slate-400">Total Transaksi:</span>
                                <div class="font-bold text-slate-900">${formatRupiah(inv.total_bayar || 0)}</div>
                            </div>
                            <button onclick="lihatDetailInvoice('${inv.id}')" class="px-2.5 py-1 rounded bg-teal-50 hover:bg-teal-100 text-teal-800 font-semibold border border-teal-200 flex items-center gap-1 text-[10px]">
                                <i class="fas fa-receipt text-[9px]"></i>
                                <span>Lihat Kwitansi</span>
                            </button>
                        </div>
                    </div>
                `).join('');
            }
        }

        // 9. Render Admin & Staf
        function renderAdmin() {
            const staffContainer = document.getElementById('staffListContainer');
            const countLabel = document.getElementById('staffCountLabel');
            if (countLabel && db.users) countLabel.textContent = `${db.users.length} User Aktif`;

            if (staffContainer && db.users) {
                staffContainer.innerHTML = db.users.map(u => `
                    <div class="flex items-center justify-between p-2 rounded-lg bg-slate-50 border border-slate-100 text-xs">
                        <div>
                            <div class="font-bold text-slate-800 text-[11px]">${u.name}</div>
                            <div class="text-[10px] text-teal-700 font-medium">${u.role}</div>
                            <div class="text-[9px] text-slate-500">${u.permission}</div>
                        </div>
                        <span class="text-[9px] font-semibold px-2 py-0.5 rounded bg-emerald-100 text-emerald-800">
                            ${u.status}
                        </span>
                    </div>
                `).join('');
            }

            const auditContainer = document.getElementById('auditLogContainer');
            if (auditContainer && db.audit_logs) {
                auditContainer.innerHTML = db.audit_logs.map(log => `
                    <div class="py-1.5 flex items-start justify-between gap-2">
                        <div>
                            <div class="font-semibold text-slate-800">${log.aksi} <span class="text-[9px] text-slate-400 font-normal">oleh ${log.user}</span></div>
                            <div class="text-[9px] text-slate-500">${log.detail}</div>
                        </div>
                        <span class="text-[9px] text-slate-400 font-mono whitespace-nowrap">${log.waktu}</span>
                    </div>
                `).join('');
            }
        }

        // Populate dropdown select options across modals
        function populateSelectOptions() {
            const patients = db.patients || [];
            const inventory = db.inventory || [];

            // Patient options
            const patientOptionsHtml = patients.map(p => `
                <option value="${p.id}">${p.nama} (${p.no_rm}) - ${p.penjamin}</option>
            `).join('');

            const queueSel = document.getElementById('queuePasienSelect');
            if (queueSel) queueSel.innerHTML = patientOptionsHtml;

            const bookSel = document.getElementById('bookPasienSelect');
            if (bookSel) bookSel.innerHTML = patientOptionsHtml;

            const emrSel = document.getElementById('emrPasienSelect');
            if (emrSel) emrSel.innerHTML = patientOptionsHtml;

            const rxSel = document.getElementById('resepPasienSelect');
            if (rxSel) rxSel.innerHTML = patientOptionsHtml;

            // Medicine options
            const medOptionsHtml = inventory.map(i => `
                <option value="${i.id}|${i.nama}|${i.harga_jual}">${i.nama} (Stok: ${i.stok}) - ${formatRupiah(i.harga_jual)}</option>
            `).join('');

            const medSel = document.getElementById('resepObatSelect');
            if (medSel) medSel.innerHTML = medOptionsHtml;
        }

        // ================= ACTION HANDLERS =================

        // Registrasi Pasien
        function openModalRegistrasiPasien() {
            document.getElementById('regNoRm').value = generateNextRmNumber();
            openModal('modalRegistrasiPasien');
        }

        function handleRegistrasiPasien(e) {
            e.preventDefault();
            const noRm = document.getElementById('regNoRm').value;
            const nama = document.getElementById('regNama').value.trim();
            const nik = document.getElementById('regNik').value.trim();
            const tglLahir = document.getElementById('regTglLahir').value;
            const gender = document.getElementById('regGender').value;
            const golDarah = document.getElementById('regGolDarah').value;
            const noHp = document.getElementById('regNoHp').value.trim();
            const penjamin = document.getElementById('regPenjamin').value;
            const alamat = document.getElementById('regAlamat').value.trim();
            const alergi = document.getElementById('regAlergi').value.trim() || 'Tidak Ada';

            const newPatient = {
                id: (db.patients?.length || 0) + 1,
                no_rm: noRm,
                nama: nama,
                nik: nik,
                tgl_lahir: tglLahir,
                umur: '30 Th',
                gender: gender,
                gol_darah: golDarah,
                no_hp: noHp,
                alamat: alamat,
                pekerjaan: 'Swasta',
                penjamin: penjamin,
                alergi: alergi,
                total_kunjungan: 1,
                terakhir_periksa: new Date().toISOString().split('T')[0]
            };

            db.patients = db.patients || [];
            db.patients.unshift(newPatient);

            // Audit log
            db.audit_logs = db.audit_logs || [];
            db.audit_logs.unshift({
                waktu: new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' }) + ' WIB',
                user: 'Admisi / Kasir',
                aksi: 'Pendaftaran Pasien',
                detail: `Mendaftarkan pasien baru ${nama} (${noRm})`
            });

            saveDatabase();
            closeModal('modalRegistrasiPasien');
            renderAll();
            showToast(`Pasien ${nama} berhasil didaftarkan dengan ${noRm}!`);

            // Offer to view digital card
            lihatKartuDigital(noRm);
        }

        // Digital Card Viewer
        function lihatKartuDigital(noRm) {
            const p = (db.patients || []).find(item => item.no_rm === noRm) || db.patients?.[0];
            if (!p) return;

            document.getElementById('cardNoRm').textContent = p.no_rm;
            document.getElementById('cardNama').textContent = p.nama;
            document.getElementById('cardNik').textContent = `NIK: ${p.nik}`;
            document.getElementById('cardTtl').textContent = `${p.tgl_lahir} • Gol: ${p.gol_darah}`;
            document.getElementById('cardPenjamin').textContent = p.penjamin;

            openModal('modalKartuPasien');
        }

        function kirimKartuWa() {
            const noRm = document.getElementById('cardNoRm')?.textContent || '';
            const nama = document.getElementById('cardNama')?.textContent || '';
            const text = `Halo Bapak/Ibu ${nama},\nBerikut adalah data Kartu Pasien Digital Anda di ${CLINIC_NAME}:\nNo. Rekam Medis: ${noRm}\nSilakan tunjukkan kartu ini di loket saat berkunjung. Terima kasih!`;
            window.open(`https://wa.me/?text=${encodeURIComponent(text)}`, '_blank');
        }

        // Ambil Antrean
        function openModalAmbilAntrean() {
            populateSelectOptions();
            openModal('modalAmbilAntrean');
        }

        function ambilAntreanUntukPasien(pasienId) {
            openModal('modalAmbilAntrean');
            const sel = document.getElementById('queuePasienSelect');
            if (sel) sel.value = pasienId;
        }

        function handleAmbilAntrean(e) {
            e.preventDefault();
            const pasienId = document.getElementById('queuePasienSelect').value;
            const poliValue = document.getElementById('queuePoliSelect').value;
            const [poliName, poliCode, doctorName] = poliValue.split('|');

            const patient = (db.patients || []).find(p => p.id == pasienId);
            if (!patient) return;

            // Generate next queue number
            const existingForPoli = (db.queues || []).filter(q => q.poli_code === poliCode);
            const nextSeq = String(existingForPoli.length + 1).padStart(2, '0');
            const ticketNumber = `${poliCode}-${nextSeq}`;

            const newQueue = {
                id: (db.queues?.length || 0) + 1,
                nomor: ticketNumber,
                pasien_id: patient.id,
                pasien_nama: patient.nama,
                no_rm: patient.no_rm,
                poli: poliName,
                poli_code: poliCode,
                dokter: doctorName,
                status: 'Menunggu',
                waktu_ambil: new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' }) + ' WIB',
                waktu_panggil: '-',
                penjamin: patient.penjamin
            };

            db.queues = db.queues || [];
            db.queues.push(newQueue);

            saveDatabase();
            closeModal('modalAmbilAntrean');
            renderAntrean();
            renderDashboard();
            showToast(`Nomor antrean ${ticketNumber} untuk ${patient.nama} berhasil dicetak!`);
        }

        // Booking Appointment
        function openModalBookingAppointment() {
            populateSelectOptions();
            document.getElementById('bookTanggal').value = new Date().toISOString().split('T')[0];
            openModal('modalBookingAppointment');
        }

        function handleBookingAppointment(e) {
            e.preventDefault();
            const pasienId = document.getElementById('bookPasienSelect').value;
            const docVal = document.getElementById('bookDokterSelect').value;
            const [docName, poliName] = docVal.split('|');
            const tanggal = document.getElementById('bookTanggal').value;
            const sesi = document.getElementById('bookSesi').value;
            const keluhan = document.getElementById('bookKeluhan').value.trim() || 'Konsultasi rutin';

            const patient = (db.patients || []).find(p => p.id == pasienId);
            if (!patient) return;

            const newAppt = {
                id: (db.appointments?.length || 0) + 1,
                pasien_id: patient.id,
                pasien_nama: patient.nama,
                no_rm: patient.no_rm,
                no_hp: patient.no_hp,
                dokter: docName,
                poli: poliName,
                tanggal: tanggal,
                sesi: sesi,
                keluhan: keluhan,
                status: 'Terkonfirmasi',
                reminder_sent: false
            };

            db.appointments = db.appointments || [];
            db.appointments.unshift(newAppt);

            saveDatabase();
            closeModal('modalBookingAppointment');
            renderBooking();
            showToast(`Janji temu berhasil dijadwalkan untuk ${patient.nama}!`);
        }

        function kirimReminderWa(apptId) {
            const appt = (db.appointments || []).find(a => a.id == apptId);
            if (!appt) return;

            const cleanPhone = (appt.no_hp || '').replace(/[^0-9]/g, '');
            const waTarget = cleanPhone.startsWith('0') ? '62' + cleanPhone.substring(1) : cleanPhone;

            const msg = `Halo Bapak/Ibu ${appt.pasien_nama},\nKami mengingatkan jadwal kunjungan Anda di ${CLINIC_NAME}:\nDokter: ${appt.dokter} (${appt.poli})\nTanggal: ${appt.tanggal}\nSesi: ${appt.sesi}\nMohon hadir 15 menit sebelum sesi dimulai. Terima kasih.`;

            appt.reminder_sent = true;
            saveDatabase();
            renderBooking();

            window.open(`https://wa.me/${waTarget}?text=${encodeURIComponent(msg)}`, '_blank');
        }

        function rescheduleAppointment(apptId) {
            const appt = (db.appointments || []).find(a => a.id == apptId);
            if (!appt) return;

            const newDate = prompt('Masukkan tanggal baru (YYYY-MM-DD):', appt.tanggal);
            if (newDate) {
                appt.tanggal = newDate;
                appt.status = 'Rescheduled';
                saveDatabase();
                renderBooking();
                showToast(`Jadwal diubah menjadi ${newDate}.`);
            }
        }

        function cancelAppointment(apptId) {
            const appt = (db.appointments || []).find(a => a.id == apptId);
            if (!appt) return;

            if (confirm(`Yakin ingin membatalkan janji temu ${appt.pasien_nama}?`)) {
                appt.status = 'Dibatalkan';
                saveDatabase();
                renderBooking();
                showToast(`Janji temu ${appt.pasien_nama} telah dibatalkan.`);
            }
        }

        // Pemeriksaan (EMR)
        function openModalPemeriksaanBaru() {
            populateSelectOptions();
            openModal('modalPemeriksaan');
        }

        function handleSimpanPemeriksaan(e) {
            e.preventDefault();
            const pasienId = document.getElementById('emrPasienSelect').value;
            const patient = (db.patients || []).find(p => p.id == pasienId);
            if (!patient) return;

            const td = document.getElementById('emrTd').value;
            const suhu = document.getElementById('emrSuhu').value;
            const nadi = document.getElementById('emrNadi').value;
            const nafas = document.getElementById('emrNafas').value;
            const bbTb = document.getElementById('emrBbTb').value;
            const spo2 = document.getElementById('emrSpo2').value;
            const keluhan = document.getElementById('emrKeluhan').value;
            const fisik = document.getElementById('emrFisik').value;
            const [icdCode, icdName] = document.getElementById('emrIcd10').value.split('|');
            const [tindakanName, tindakanBiaya] = document.getElementById('emrTindakan').value.split('|');
            const catatan = document.getElementById('emrCatatan').value;

            const newRecord = {
                id: (db.medical_records?.length || 0) + 1,
                no_rm: patient.no_rm,
                pasien_nama: patient.nama,
                tanggal: new Date().toISOString().replace('T', ' ').substring(0, 16),
                dokter: 'dr. Hendra Kusuma, Sp.PD',
                poli: 'Poli Umum',
                keluhan_utama: keluhan,
                ttv: {
                    tekanan_darah: td,
                    suhu: suhu,
                    nadi: nadi,
                    pernapasan: nafas,
                    berat_badan: bbTb.split('/')[0]?.trim() || '65 kg',
                    tinggi_badan: bbTb.split('/')[1]?.trim() || '168 cm',
                    spo2: spo2
                },
                pemeriksaan_fisik: fisik,
                diagnosis: {
                    kode_icd10: icdCode,
                    nama: icdName
                },
                tindakan: [
                    { nama: tindakanName, biaya: Number(tindakanBiaya) }
                ],
                catatan_dokter: catatan,
                status_periksa: 'Selesai'
            };

            db.medical_records = db.medical_records || [];
            db.medical_records.unshift(newRecord);

            // Create pending invoice
            const newInvoice = {
                id: (db.invoices?.length || 0) + 1,
                no_invoice: `INV-2026-0${430 + db.invoices.length}`,
                tanggal: new Date().toISOString().replace('T', ' ').substring(0, 16),
                no_rm: patient.no_rm,
                pasien_nama: patient.nama,
                penjamin: patient.penjamin,
                items: [
                    { deskripsi: tindakanName, kategori: 'Tindakan', biaya: Number(tindakanBiaya) },
                    { deskripsi: 'Jasa Konsultasi Medis', kategori: 'Jasa Medis', biaya: 80000 }
                ],
                subtotal: Number(tindakanBiaya) + 80000,
                potongan_bpjs: patient.penjamin.includes('BPJS') ? Number(tindakanBiaya) + 80000 : 0,
                total_bayar: patient.penjamin.includes('BPJS') ? 0 : Number(tindakanBiaya) + 80000,
                status: patient.penjamin.includes('BPJS') ? 'Lunas (Klaim BPJS)' : 'Belum Bayar',
                metode: patient.penjamin.includes('BPJS') ? 'BPJS Kesehatan' : 'QRIS / Kasir',
                kasir: 'Rini Astuti'
            };

            db.invoices = db.invoices || [];
            db.invoices.unshift(newInvoice);

            saveDatabase();
            closeModal('modalPemeriksaan');
            renderAll();
            showToast(`Rekam medis & invoice untuk ${patient.nama} berhasil disimpan!`);
        }

        // Resep Handlers
        function openModalBuatResep() {
            populateSelectOptions();
            openModal('modalBuatResep');
        }

        function bukaBuatResepUntukPasien(noRm, nama) {
            openModalBuatResep();
            const p = (db.patients || []).find(item => item.no_rm === noRm);
            if (p) {
                const sel = document.getElementById('resepPasienSelect');
                if (sel) sel.value = p.id;
            }
        }

        function handleSimpanResep(e) {
            e.preventDefault();
            const pasienId = document.getElementById('resepPasienSelect').value;
            const patient = (db.patients || []).find(p => p.id == pasienId);
            if (!patient) return;

            const [obatId, obatNama, obatHarga] = document.getElementById('resepObatSelect').value.split('|');
            const qty = Number(document.getElementById('resepQty').value) || 10;
            const dosis = document.getElementById('resepDosis').value;
            const aturan = document.getElementById('resepAturan').value;
            const totalHarga = Number(obatHarga) * qty;

            const newRx = {
                id: (db.prescriptions?.length || 0) + 1,
                no_resep: `RXP-2026-00${93 + (db.prescriptions?.length || 0)}`,
                tanggal: new Date().toISOString().replace('T', ' ').substring(0, 16),
                no_rm: patient.no_rm,
                pasien_nama: patient.nama,
                dokter: 'dr. Hendra Kusuma, Sp.PD',
                items: [
                    { obat_id: Number(obatId), nama: obatNama, dosis: dosis, aturan: aturan, qty: qty, harga: totalHarga }
                ],
                total_obat: totalHarga,
                status: 'Siap Diserahkan',
                apoteker: 'Apt. Nurul Hidayah, S.Farm'
            };

            db.prescriptions = db.prescriptions || [];
            db.prescriptions.unshift(newRx);

            saveDatabase();
            closeModal('modalBuatResep');
            renderResep();
            showToast(`Resep elektronik ${newRx.no_resep} dikirim ke Farmasi!`);
        }

        // Inventory Tambah
        function openModalTambahObat() {
            openModal('modalTambahObat');
        }

        function handleTambahObat(e) {
            e.preventDefault();
            const nama = document.getElementById('invNama').value.trim();
            const kategori = document.getElementById('invKategori').value.trim();
            const satuan = document.getElementById('invSatuan').value.trim();
            const stok = Number(document.getElementById('invStok').value);
            const minStok = Number(document.getElementById('invMinStok').value);
            const hargaJual = Number(document.getElementById('invHargaJual').value);
            const expDate = document.getElementById('invExpDate').value;

            const newItem = {
                id: (db.inventory?.length || 0) + 1,
                kode: `OBT-0${11 + (db.inventory?.length || 0)}`,
                nama: nama,
                kategori: kategori,
                satuan: satuan,
                stok: stok,
                min_stok: minStok,
                exp_date: expDate,
                harga_beli: Math.round(hargaJual * 0.6),
                harga_jual: hargaJual,
                status: stok <= minStok ? 'Menipis' : 'Aman'
            };

            db.inventory = db.inventory || [];
            db.inventory.unshift(newItem);

            saveDatabase();
            closeModal('modalTambahObat');
            renderInventory();
            showToast(`Obat ${nama} (${stok} unit) berhasil ditambahkan!`);
        }

        // Kasir & Invoice View
        function lihatDetailInvoice(invId) {
            const inv = (db.invoices || []).find(i => i.id == invId);
            if (!inv) return;

            document.getElementById('invNomor').textContent = inv.no_invoice;
            document.getElementById('invPasien').textContent = inv.pasien_nama;
            document.getElementById('invTanggal').textContent = inv.tanggal;
            document.getElementById('invPenjaminBadge').textContent = inv.penjamin;
            document.getElementById('invTotalAmount').textContent = formatRupiah(inv.total_bayar || 0);
            document.getElementById('invStatusLabel').textContent = inv.status;
            document.getElementById('invMetodeLabel').textContent = inv.metode || 'QRIS / Tunai';

            const itemsCont = document.getElementById('invItemsContainer');
            if (itemsCont && inv.items) {
                itemsCont.innerHTML = inv.items.map(it => `
                    <div class="flex justify-between">
                        <span>${it.deskripsi}</span>
                        <span class="font-bold">${formatRupiah(it.biaya)}</span>
                    </div>
                `).join('');
            }

            openModal('modalInvoiceDetail');
        }

        function kirimInvoiceWa() {
            const noInv = document.getElementById('invNomor')?.textContent || '';
            const nama = document.getElementById('invPasien')?.textContent || '';
            const total = document.getElementById('invTotalAmount')?.textContent || '';
            const status = document.getElementById('invStatusLabel')?.textContent || '';

            const msg = `Halo Bapak/Ibu ${nama},\nBerikut adalah rincian kwitansi pembayaran Anda di ${CLINIC_NAME}:\nNo. Invoice: ${noInv}\nTotal: ${total}\nStatus: ${status}\nTerima kasih atas kunjungan Anda.`;
            window.open(`https://wa.me/?text=${encodeURIComponent(msg)}`, '_blank');
        }

        function openModalBuatInvoiceManual() {
            showToast('Pilih pasien pada menu Pemeriksaan/EMR untuk mencetak invoice.');
            switchModule('periksa');
        }

        // Display Monitor Antrean
        function openDisplayAntreanModal() {
            const matrix = document.getElementById('displayPoliMatrix');
            if (matrix && db.poli) {
                matrix.innerHTML = db.poli.map(p => `
                    <div class="flex items-center justify-between p-3 rounded-xl bg-slate-900 border border-slate-800 text-xs">
                        <div class="flex items-center gap-2">
                            <span class="w-7 h-7 rounded-lg bg-teal-500/20 text-teal-400 font-bold flex items-center justify-center text-xs">${p.code}</span>
                            <div>
                                <div class="font-bold text-white">${p.name}</div>
                                <div class="text-[10px] text-slate-400">${p.doctor}</div>
                            </div>
                        </div>
                        <div class="text-right">
                            <span class="text-sm font-black text-teal-300 font-mono">${p.active_queue}</span>
                            <div class="text-[9px] text-slate-500">${p.waiting_count} antrean</div>
                        </div>
                    </div>
                `).join('');
            }
            openModal('modalDisplayAntrean');
        }

        // Initial setup on DOM ready
        document.addEventListener('DOMContentLoaded', () => {
            initDatabase();
            renderAll();
        });
    </script>
</body>
</html>
