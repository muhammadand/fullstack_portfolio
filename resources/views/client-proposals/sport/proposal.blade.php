<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Proposal Proyek Website & Sistem Booking Sports Center - {{ $client->brand_name }}</title>
    <meta name="description" content="Proposal pengajuan pengembangan sistem website booking lapangan olahraga (Futsal, Badminton, Padel, Mini Soccer, Voli), modul membership, dan platform komunitas mabar untuk {{ $client->brand_name }} oleh Scalify Intelligence.">

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        sport: {
                            50: '#f0fdf4'
                            , 100: '#dcfce7'
                            , 200: '#bbf7d0'
                            , 500: '#22c55e'
                            , 600: '#16a34a'
                            , 700: '#15803d'
                            , 800: '#166534'
                            , 900: '#14532d'
                            , dark: '#0f172a'
                            , navy: '#1e293b'
                            , emerald: '#10b981'
                        }
                    }
                    , fontFamily: {
                        sans: ['Plus Jakarta Sans', 'Inter', 'sans-serif']
                        , heading: ['Montserrat', 'Plus Jakarta Sans', 'sans-serif']
                    }
                }
            }
        }

    </script>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500;600;700;800;900&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body {
            background-color: #f1f5f9;
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: #334155;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        .font-heading {
            font-family: 'Montserrat', sans-serif;
        }

        .proposal-page {
            max-width: 210mm;
            min-height: 297mm;
            margin: 2rem auto;
            background: white;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
            padding: 3rem 4rem;
            position: relative;
        }

        @media print {
            @page {
                size: A4;
                margin: 15mm;
            }

            body {
                background-color: white;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

            .proposal-page {
                margin: 0;
                box-shadow: none;
                width: 100%;
                max-width: none;
                min-height: 0;
                padding: 0;
            }

            .no-print {
                display: none !important;
            }

            .page-break {
                page-break-before: always;
            }
        }

    </style>
</head>
<body class="antialiased">

    @php
    $cleanWa = preg_replace('/[^0-9]/', '', $client->wa_number ?? '6281234567890');
    if (str_starts_with($cleanWa, '0')) {
    $cleanWa = '62' . substr($cleanWa, 1);
    }
    $brandName = $client->brand_name ?? 'Sports Arena & Venue Center';
    @endphp

    <!-- Floating Action Button -->
    <div class="fixed bottom-8 right-8 no-print z-50 flex items-center gap-2">
        <a href="{{ route('demo.customer.sport', $client->slug) }}" target="_blank" class="bg-slate-900 hover:bg-slate-800 text-emerald-400 border border-emerald-500/30 px-5 py-3 rounded-full shadow-lg font-bold flex items-center gap-2 transition text-xs">
            <i class="fas fa-mobile-screen-button"></i>
            Lihat Demo Mobile App
        </a>
        <button onclick="window.print()" class="bg-emerald-600 hover:bg-emerald-700 text-white px-6 py-3 rounded-full shadow-lg font-bold flex items-center gap-2 transition text-xs">
            <i class="fas fa-file-pdf"></i>
            Simpan PDF / Cetak
        </button>
    </div>

    <!-- HALAMAN 1 -->
    <div class="proposal-page">
        <!-- Cover Header -->
        <div class="border-b-4 border-emerald-600 pb-8 mb-10 mt-6">
            <div class="flex justify-between items-end">
                <div>
                    <p class="text-emerald-600 font-bold tracking-widest text-xs mb-2 uppercase">Proposal Digitalisasi Venue Olahraga</p>
                    <h1 class="font-heading text-3xl sm:text-4xl font-extrabold text-slate-900 leading-tight">
                        Sistem Booking Lapangan,<br>Membership & Komunitas Mabar
                    </h1>
                </div>
                <div class="text-right">
                    <div class="w-14 h-14 rounded-2xl bg-emerald-600 flex items-center justify-center text-white text-2xl ml-auto mb-3 shadow-md">
                        <i class="fas fa-trophy"></i>
                    </div>
                    <p class="font-heading font-bold text-slate-900 text-lg">{{ $brandName }}</p>
                    <p class="text-sm text-slate-500">{{ date('d F Y') }}</p>
                </div>
            </div>
        </div>

        <div class="mb-10 flex justify-between text-sm">
            <div>
                <p class="text-slate-400 mb-1">Disiapkan untuk:</p>
                <p class="font-bold text-slate-900 text-base">{{ $client->client_name ?? $brandName }}</p>
                <p class="text-slate-600">Manajemen Pengelola Gelanggang & Lapangan Olahraga</p>
            </div>
            <div class="text-right">
                <p class="text-slate-400 mb-1">Disiapkan oleh:</p>
                <p class="font-bold text-slate-900 text-base">Scalify Intelligence</p>
                <p class="text-slate-600">Digital Solutions & Web Architecture</p>
            </div>
        </div>

        <!-- 1. Pendahuluan -->
        <div class="mb-9">
            <h2 class="font-heading text-xl font-bold text-slate-900 mb-3 flex items-center gap-2">
                <span class="text-emerald-600">01.</span> Pendahuluan & Latar Belakang
            </h2>
            <p class="text-slate-600 leading-relaxed text-sm text-justify mb-3">
                Dalam industri penyewaan lapangan olahraga modern (seperti <strong>Futsal, Badminton, Padel Tennis, Mini Soccer, dan Voli</strong>), kendala terbesar yang sering dihadapi pemilik venue adalah <strong>resiko double booking akibat pencatatan manual via WhatsApp</strong>, lambatnya konfirmasi ketersediaan jam kosong, serta kurangnya loyalitas pelanggan yang menyebabkan jam-jam non-peak (siang hari) sepi pemain.
            </p>
            <p class="text-slate-600 leading-relaxed text-sm text-justify">
                Proposal ini dirancang untuk menghadirkan solusi menyeluruh bagi <strong>{{ $brandName }}</strong> melalui ekosistem digital terintegrasi: Website resmi interaktif, sistem booking slot jam live, modul <em>Membership Reward</em> berulang (recurring revenue), serta <strong>Platform Komunitas & Mabar</strong> yang memungkinkan member membuat klub dan mencari lawan sparring sendiri di dalam sistem.
            </p>

            <div class="mt-5 bg-emerald-50 border border-emerald-200 rounded-xl p-4 flex flex-col md:flex-row md:items-center justify-between gap-3">
                <div>
                    <h3 class="font-bold text-emerald-900 text-sm mb-1 flex items-center gap-2">
                        <i class="fas fa-desktop text-emerald-600"></i> Preview Prototype Web & Mobile App Demo
                    </h3>
                    <p class="text-xs text-slate-600">Telah disiapkan simulasi pemesanan lapangan, slot picker, membership, dan modul buat komunitas khusus untuk {{ $brandName }}.</p>
                    <div class="hidden print:block text-xs font-medium text-emerald-600 break-all mt-1 underline">
                        {{ route('landing.dynamic', $client->slug) }}
                    </div>
                </div>
                <div class="flex items-center gap-2 no-print shrink-0">
                    <a href="{{ route('landing.dynamic', $client->slug) }}" target="_blank" class="bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded-full text-xs font-bold transition inline-flex items-center gap-1.5 shadow-sm">
                        Lihat Web <i class="fas fa-external-link-alt text-[9px]"></i>
                    </a>
                    <a href="{{ route('demo.customer.sport', $client->slug) }}" target="_blank" class="bg-slate-900 hover:bg-slate-800 text-emerald-400 px-4 py-2 rounded-full text-xs font-bold transition inline-flex items-center gap-1.5 shadow-sm">
                        Demo App <i class="fas fa-mobile-alt text-[9px]"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- 2. Objektif & Solusi Utama -->
        <div class="mb-8">
            <h2 class="font-heading text-xl font-bold text-slate-900 mb-3 flex items-center gap-2">
                <span class="text-emerald-600">02.</span> Objektif & Solusi Utama
            </h2>
            <ul class="space-y-2.5 text-sm text-slate-600">
                <li class="flex items-start gap-2.5">
                    <i class="fas fa-check-circle text-emerald-600 mt-1 shrink-0 text-sm"></i>
                    <span><strong>Live Slot Jam & Anti Double Booking:</strong> Pemain dapat langsung melihat slot jam yang masih kosong secara real-time dari pagi (06:00) hingga malam (24:00 WIB).</span>
                </li>
                <li class="flex items-start gap-2.5">
                    <i class="fas fa-check-circle text-emerald-600 mt-1 shrink-0 text-sm"></i>
                    <span><strong>Multi-Sport Court Selector:</strong> Mendukung ragam lapangan dalam satu platform (Futsal Vinyl/Interlock, Badminton BWF, Padel Glass, Mini Soccer 7v7, Voli).</span>
                </li>
                <li class="flex items-start gap-2.5">
                    <i class="fas fa-check-circle text-emerald-600 mt-1 shrink-0 text-sm"></i>
                    <span><strong>Sistem Membership & Loyalty Point:</strong> Tier Member (Silver, Gold, VIP) untuk menghasilkan pendapatan berulang (monthly revenue) dan meningkatkan retensi pemain.</span>
                </li>
                <li class="flex items-start gap-2.5">
                    <i class="fas fa-check-circle text-emerald-600 mt-1 shrink-0 text-sm"></i>
                    <span><strong>Modul Komunitas & Mabar Otomatis:</strong> Member berhak membuat klub/komunitas sendiri, membuka slot mabar publik ("Kurang 2 Orang"), dan cari lawan sparring antar tim.</span>
                </li>
            </ul>
        </div>
    </div>

    <!-- HALAMAN 2 -->
    <div class="proposal-page page-break">
        <div class="mb-8 mt-4">
            <h2 class="font-heading text-2xl font-bold text-slate-900 mb-2 flex items-center gap-2">
                <span class="text-emerald-600">03.</span> Pilihan Paket & Rincian Investasi
            </h2>
            <p class="text-xs text-slate-600 mb-5">Rincian spesifikasi paket sistem gelanggang olahraga digital untuk <strong>{{ $brandName }}</strong>:</p>

            <!-- Tabel Komparasi Paket Sport Center -->
            <div class="overflow-x-auto mb-6 rounded-xl border border-slate-200 bg-white shadow-xs">
                <table class="w-full text-left border-collapse text-[11px]">
                    <thead>
                        <tr class="border-b border-slate-200">
                            <th class="p-3 bg-slate-50 font-heading text-slate-900 font-bold w-[32%]">
                                <span class="text-[9px] uppercase tracking-wider block text-emerald-600 font-sans">Komparasi Layanan</span>
                                Fitur & Modul Sistem
                            </th>
                            <!-- Silver -->
                            <th class="p-2.5 text-center bg-slate-50/70 border-l border-slate-200 w-[17%]">
                                <span class="font-heading font-bold text-xs text-slate-900 block">Silver</span>
                                <span class="inline-block my-1 py-0.5 px-2 rounded-full border border-slate-300 bg-white text-[10px] font-bold text-slate-800">
                                    {{ \App\Models\ClientProposal::formatPackagePill($client->silver_price) }}
                                </span>
                                <span class="block text-[8px] text-slate-500">Perpanjangan {{ $client->silver_renewal }}</span>
                            </th>
                            <!-- Gold (Featured) -->
                            <th class="p-2.5 text-center bg-slate-900 text-white border-x-2 border-emerald-500 w-[17%] relative">
                                <span class="absolute -top-2.5 left-1/2 -translate-x-1/2 bg-amber-500 text-slate-950 text-[8px] font-black uppercase tracking-widest px-2 py-0.2 rounded-full shadow-xs">POPULER</span>
                                <span class="font-heading font-bold text-xs text-white block">Gold</span>
                                <span class="inline-block my-1 py-0.5 px-2 rounded-full border border-emerald-500 bg-slate-800 text-[10px] font-bold text-emerald-300">
                                    {{ \App\Models\ClientProposal::formatPackagePill($client->gold_price) }}
                                </span>
                                <span class="block text-[8px] text-emerald-200">Perpanjangan {{ $client->gold_renewal }}</span>
                            </th>
                            <!-- Diamond -->
                            <th class="p-2.5 text-center bg-slate-50/70 border-l border-slate-200 w-[17%]">
                                <span class="font-heading font-bold text-xs text-slate-900 block">Diamond</span>
                                <span class="inline-block my-1 py-0.5 px-2 rounded-full border border-slate-300 bg-white text-[10px] font-bold text-slate-800">
                                    {{ \App\Models\ClientProposal::formatPackagePill($client->diamond_price) }}
                                </span>
                                <span class="block text-[8px] text-slate-500">Perpanjangan {{ $client->diamond_renewal }}</span>
                            </th>
                            <!-- Platinum -->
                            <th class="p-2.5 text-center bg-slate-50/70 border-l border-slate-200 w-[17%]">
                                <span class="font-heading font-bold text-xs text-slate-900 block">Platinum</span>
                                <span class="inline-block my-1 py-0.5 px-2 rounded-full border border-slate-300 bg-white text-[10px] font-bold text-slate-800">
                                    {{ \App\Models\ClientProposal::formatPackagePill($client->platinum_price) }}
                                </span>
                                <span class="block text-[8px] text-slate-500">Perpanjangan {{ $client->platinum_renewal }}</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-slate-700">
                        <!-- GROUP 1: FITUR BOOKING & LAPANGAN -->
                        <tr class="bg-emerald-50/60">
                            <td colspan="5" class="py-1.5 px-3 font-bold uppercase tracking-wider text-[9px] text-emerald-950">
                                <i class="fas fa-calendar-check text-emerald-600 mr-1.5"></i> Modul Booking & Manajemen Lapangan
                            </td>
                        </tr>
                        <tr>
                            <td class="p-2 font-medium">Katalog Lapangan Multi-Sport</td>
                            <td class="p-2 text-center bg-slate-50/30 font-semibold text-slate-900">Hingga 4 Lapangan</td>
                            <td class="p-2 text-center bg-emerald-50/30 font-semibold text-slate-900">Hingga 8 Lapangan</td>
                            <td class="p-2 text-center bg-slate-50/30 font-semibold">Unlimited Lapangan</td>
                            <td class="p-2 text-center bg-slate-50/30 font-semibold">Multi-Branch / Multi-Venue</td>
                        </tr>
                        <tr>
                            <td class="p-2 font-medium">Sistem Live Time Slot (06:00 - 24:00)</td>
                            <td class="p-2 text-center bg-slate-50/30 text-emerald-600 font-bold"><i class="fas fa-check-circle text-xs"></i> Real-Time Slot Picker</td>
                            <td class="p-2 text-center bg-emerald-50/30 text-emerald-600 font-bold"><i class="fas fa-check-circle text-xs"></i> Real-Time Slot Picker</td>
                            <td class="p-2 text-center bg-slate-50/30 text-emerald-600 font-bold"><i class="fas fa-check-circle text-xs"></i> Auto-Lock Slot 10 Menit</td>
                            <td class="p-2 text-center bg-slate-50/30 text-emerald-600 font-bold"><i class="fas fa-check-circle text-xs"></i> Live Sync Semua Cabang</td>
                        </tr>
                        <tr>
                            <td class="p-2 font-medium">Tarif Dinamis (Peak Hour vs Non-Peak)</td>
                            <td class="p-2 text-center bg-slate-50/30 text-emerald-600 font-bold"><i class="fas fa-check-circle text-xs"></i> Tarif Siang / Malam</td>
                            <td class="p-2 text-center bg-emerald-50/30 text-emerald-600 font-bold"><i class="fas fa-check-circle text-xs"></i> Otomatis Siang/Malam</td>
                            <td class="p-2 text-center bg-slate-50/30 text-emerald-600 font-bold"><i class="fas fa-check-circle text-xs"></i> Custom Weekend / Holiday</td>
                            <td class="p-2 text-center bg-slate-50/30 text-emerald-600 font-bold"><i class="fas fa-check-circle text-xs"></i> Dynamic AI Surge Price</td>
                        </tr>
                        <tr>
                            <td class="p-2 font-medium">Add-on Peralatan (Wasit, Rompi, Raket, Air)</td>
                            <td class="p-2 text-center bg-slate-50/30 text-emerald-600 font-bold"><i class="fas fa-check-circle text-xs"></i> Pilihan Add-on Dasar</td>
                            <td class="p-2 text-center bg-emerald-50/30 text-emerald-600 font-bold"><i class="fas fa-check-circle text-xs"></i> Lengkap</td>
                            <td class="p-2 text-center bg-slate-50/30 text-emerald-600 font-bold"><i class="fas fa-check-circle text-xs"></i> Lengkap + Stock Tracker</td>
                            <td class="p-2 text-center bg-slate-50/30 text-emerald-600 font-bold"><i class="fas fa-check-circle text-xs"></i> Integrasi POS Kantin/Cafe</td>
                        </tr>

                        <!-- GROUP 2: MEMBERSHIP & KOMUNITAS MABAR -->
                        <tr class="bg-emerald-50/60">
                            <td colspan="5" class="py-1.5 px-3 font-bold uppercase tracking-wider text-[9px] text-emerald-950">
                                <i class="fas fa-users-rays text-emerald-600 mr-1.5"></i> Modul Membership, Komunitas & Mabar
                            </td>
                        </tr>
                        <tr>
                            <td class="p-2 font-medium">Sistem Membership Tier & Loyalty Poin</td>
                            <td class="p-2 text-center bg-slate-50/30 text-emerald-600 font-bold"><i class="fas fa-check-circle text-xs"></i> Modul Member & Diskon</td>
                            <td class="p-2 text-center bg-emerald-50/30 text-emerald-600 font-bold"><i class="fas fa-check-circle text-xs"></i> Silver, Gold, VIP</td>
                            <td class="p-2 text-center bg-slate-50/30 text-emerald-600 font-bold"><i class="fas fa-check-circle text-xs"></i> Kartu Member Digital QR</td>
                            <td class="p-2 text-center bg-slate-50/30 text-emerald-600 font-bold"><i class="fas fa-check-circle text-xs"></i> Recurring Auto-Debit</td>
                        </tr>
                        <tr>
                            <td class="p-2 font-medium">Fitur Buat Komunitas & Klub Sendiri</td>
                            <td class="p-2 text-center bg-slate-50/30 text-emerald-600 font-bold"><i class="fas fa-check-circle text-xs"></i> 1 Klub per Member</td>
                            <td class="p-2 text-center bg-emerald-50/30 text-emerald-600 font-bold"><i class="fas fa-check-circle text-xs"></i> Aktif untuk Member (3 Klub)</td>
                            <td class="p-2 text-center bg-slate-50/30 text-emerald-600 font-bold"><i class="fas fa-check-circle text-xs"></i> Unlimited Klub & Profil</td>
                            <td class="p-2 text-center bg-slate-50/30 text-emerald-600 font-bold"><i class="fas fa-check-circle text-xs"></i> Turnamen & Bracket Liga</td>
                        </tr>
                        <tr>
                            <td class="p-2 font-medium">Papan Mabar & Open Sparring Lawan Tanding</td>
                            <td class="p-2 text-center bg-slate-50/30 text-emerald-600 font-bold"><i class="fas fa-check-circle text-xs"></i> Papan Mabar Terbuka</td>
                            <td class="p-2 text-center bg-emerald-50/30 text-emerald-600 font-bold"><i class="fas fa-check-circle text-xs"></i> Papan Cari Lawan</td>
                            <td class="p-2 text-center bg-slate-50/30 text-emerald-600 font-bold"><i class="fas fa-check-circle text-xs"></i> Chat Tim & Notifikasi WA</td>
                            <td class="p-2 text-center bg-slate-50/30 text-emerald-600 font-bold"><i class="fas fa-check-circle text-xs"></i> Auto-Matchmaking Rating</td>
                        </tr>

                        <!-- GROUP 3: OPERASIONAL & TRANSAKSI -->
                        <tr class="bg-emerald-50/60">
                            <td colspan="5" class="py-1.5 px-3 font-bold uppercase tracking-wider text-[9px] text-emerald-950">
                                <i class="fas fa-wallet text-emerald-600 mr-1.5"></i> Pembayaran, Tiket & Operasional
                            </td>
                        </tr>
                        <tr>
                            <td class="p-2 font-medium">Payment Gateway Otomatis (QRIS & VA)</td>
                            <td class="p-2 text-center bg-slate-50/30 text-emerald-600 font-bold"><i class="fas fa-check-circle text-xs"></i> QRIS Instant Otomatis</td>
                            <td class="p-2 text-center bg-emerald-50/30 text-emerald-600 font-bold"><i class="fas fa-check-circle text-xs"></i> QRIS & VA Otomatis</td>
                            <td class="p-2 text-center bg-slate-50/30 text-emerald-600 font-bold"><i class="fas fa-check-circle text-xs"></i> Multi-Gateway Full</td>
                            <td class="p-2 text-center bg-slate-50/30 text-emerald-600 font-bold"><i class="fas fa-check-circle text-xs"></i> Split Bill / Patungan</td>
                        </tr>
                        <tr>
                            <td class="p-2 font-medium">E-Tiket & Barcode Scanner Check-In</td>
                            <td class="p-2 text-center bg-slate-50/30 text-emerald-600 font-bold"><i class="fas fa-check-circle text-xs"></i> E-Tiket Barcode Web/WA</td>
                            <td class="p-2 text-center bg-emerald-50/30 text-emerald-600 font-bold"><i class="fas fa-check-circle text-xs"></i> Barcode Digital</td>
                            <td class="p-2 text-center bg-slate-50/30 text-emerald-600 font-bold"><i class="fas fa-check-circle text-xs"></i> App Scanner Resepsionis</td>
                            <td class="p-2 text-center bg-slate-50/30 text-emerald-600 font-bold"><i class="fas fa-check-circle text-xs"></i> Turnstile Gate Terintegrasi</td>
                        </tr>
                        <tr>
                            <td class="p-2 font-medium">Panel Admin CMS & Laporan Omset Keuangan</td>
                            <td class="p-2 text-center bg-slate-50/30 text-emerald-600 font-bold"><i class="fas fa-check-circle text-xs"></i> Dashboard Booking Dasar</td>
                            <td class="p-2 text-center bg-emerald-50/30 text-emerald-600 font-bold"><i class="fas fa-check-circle text-xs"></i> Dashboard Praktis</td>
                            <td class="p-2 text-center bg-slate-50/30 text-emerald-600 font-bold"><i class="fas fa-check-circle text-xs"></i> Dashboard Omset + Export Excel</td>
                            <td class="p-2 text-center bg-slate-50/30 text-emerald-600 font-bold"><i class="fas fa-check-circle text-xs"></i> Multi-Outlet Financial ERP</td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr class="border-t-2 border-slate-300 bg-white">
                            <td class="p-2.5 font-bold text-slate-800">Aksi Pemesanan</td>
                            <td class="p-2 text-center bg-slate-50/50">
                                <a href="https://wa.me/{{ $cleanWa }}?text={{ urlencode('Halo Scalify, saya tertarik memesan Paket Silver Sistem Lapangan untuk ' . $brandName . '.') }}" target="_blank" class="inline-flex items-center justify-center gap-1 w-full py-1.5 px-1.5 rounded-lg bg-slate-800 hover:bg-slate-900 text-white text-[10px] font-bold shadow-xs transition no-print">
                                    <i class="fab fa-whatsapp text-emerald-400"></i> Pilih Silver
                                </a>
                            </td>
                            <td class="p-2 text-center bg-emerald-50/30">
                                <a href="https://wa.me/{{ $cleanWa }}?text={{ urlencode('Halo Scalify, saya tertarik memesan Paket Gold Sistem Lapangan & Komunitas untuk ' . $brandName . '.') }}" target="_blank" class="inline-flex items-center justify-center gap-1 w-full py-2 px-1.5 rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white text-[10px] font-extrabold shadow-md transition no-print">
                                    <i class="fab fa-whatsapp text-white"></i> Pilih Gold
                                </a>
                            </td>
                            <td class="p-2 text-center bg-slate-50/50">
                                <a href="https://wa.me/{{ $cleanWa }}?text={{ urlencode('Halo Scalify, saya tertarik memesan Paket Diamond untuk ' . $brandName . '.') }}" target="_blank" class="inline-flex items-center justify-center gap-1 w-full py-1.5 px-1.5 rounded-lg bg-slate-800 hover:bg-slate-900 text-white text-[10px] font-bold shadow-xs transition no-print">
                                    <i class="fab fa-whatsapp text-emerald-400"></i> Pilih Diamond
                                </a>
                            </td>
                            <td class="p-2 text-center bg-slate-50/50">
                                <a href="https://wa.me/{{ $cleanWa }}?text={{ urlencode('Halo Scalify, saya tertarik memesan Paket Platinum untuk ' . $brandName . '.') }}" target="_blank" class="inline-flex items-center justify-center gap-1 w-full py-1.5 px-1.5 rounded-lg bg-slate-800 hover:bg-slate-900 text-white text-[10px] font-bold shadow-xs transition no-print">
                                    <i class="fab fa-whatsapp text-emerald-400"></i> Pilih Platinum
                                </a>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <div class="bg-emerald-50 border-l-4 border-emerald-600 p-3 rounded-r-lg mb-6 text-xs text-slate-700 leading-relaxed">
                <strong>Catatan:</strong> Semua paket (mulai dari Silver) sudah mencakup sistem booking slot real-time, modul membership, integrasi payment gateway QRIS otomatis, e-tiket barcode, instalasi sistem, pelatihan admin venue, garansi teknis, dan domain/hosting cloud SSD 1 tahun.
            </div>
        </div>

        <div class="mt-6 border-t border-slate-200 pt-5 text-xs text-slate-600">
            <p class="mb-4">Demikian proposal penawaran sistem website booking lapangan dan modul komunitas ini kami ajukan. Kami siap membantu mengembangkan ekosistem digital terbaik untuk {{ $brandName }}.</p>
            <div class="flex justify-between items-end mt-6">
                <div class="text-center">
                    <p class="mb-12">Hormat Kami,</p>
                    <div class="border-b border-slate-400 w-40 mb-1 mx-auto"></div>
                    <p class="font-bold text-slate-900">M. Andi</p>
                    <p class="text-[10px] text-slate-500">Lead Tech & Solutions - Scalify</p>
                </div>
                <div class="text-center">
                    <p class="mb-12">Disetujui Oleh,</p>
                    <div class="border-b border-slate-400 w-40 mb-1 mx-auto"></div>
                    <p class="font-bold text-slate-900">.........................................</p>
                    <p class="text-[10px] text-slate-500">{{ $brandName }}</p>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
