<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Proposal Proyek Website Travel & Shuttle - {{ $client->brand_name }}</title>
    <meta name="description" content="Proposal pengajuan pengembangan sistem website booking travel dan manajemen armada untuk {{ $client->brand_name }} oleh Scalify Intelligence.">

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
                            , 500: '#0ea5e9'
                            , 600: '#0284c7'
                            , 700: '#0369a1'
                            , 800: '#075985'
                            , 900: '#0c4a6e'
                            , dark: '#0f172a'
                            , navy: '#1e293b'
                            , accent: '#f59e0b'
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
    $brandName = $client->brand_name ?? 'Travel & Shuttle Service';
    @endphp

    <!-- Floating Action Button -->
    <div class="fixed bottom-8 right-8 no-print z-50">
        <button onclick="window.print()" class="bg-travel-700 hover:bg-travel-800 text-white px-6 py-3 rounded-full shadow-lg font-bold flex items-center gap-2 transition">
            <i class="fas fa-file-pdf"></i>
            Simpan sebagai PDF
        </button>
    </div>

    <!-- HALAMAN 1 -->
    <div class="proposal-page">
        <!-- Cover Header -->
        <div class="border-b-4 border-travel-600 pb-8 mb-10 mt-10">
            <div class="flex justify-between items-end">
                <div>
                    <p class="text-travel-600 font-bold tracking-widest text-xs mb-2 uppercase">Proposal Proyek Digitalisasi</p>
                    <h1 class="font-heading text-4xl font-extrabold text-slate-900 leading-tight">
                        Pengembangan Website Travel,<br>Jadwal Rute & Booking Kursi
                    </h1>
                </div>
                <div class="text-right">
                    <div class="w-14 h-14 rounded-2xl bg-travel-600 flex items-center justify-center text-white text-2xl ml-auto mb-3 shadow-md">
                        <i class="fas fa-van-shuttle"></i>
                    </div>
                    <p class="font-heading font-bold text-slate-900 text-lg">{{ $brandName }}</p>
                    <p class="text-sm text-slate-500">{{ date('d F Y') }}</p>
                </div>
            </div>
        </div>

        <div class="mb-12 flex justify-between text-sm">
            <div>
                <p class="text-slate-400 mb-1">Disiapkan untuk:</p>
                <p class="font-bold text-slate-900 text-base">{{ $client->client_name ?? $brandName }}</p>
                <p class="text-slate-600">Travel, Shuttle & Transport Agency</p>
            </div>
            <div class="text-right">
                <p class="text-slate-400 mb-1">Disiapkan oleh:</p>
                <p class="font-bold text-slate-900 text-base">Scalify Intelligence</p>
                <p class="text-slate-600">Digital Solutions & Web Agency</p>
            </div>
        </div>

        <!-- 1. Pendahuluan -->
        <div class="mb-10">
            <h2 class="font-heading text-2xl font-bold text-slate-900 mb-4 flex items-center gap-2">
                <span class="text-travel-600">01.</span> Pendahuluan & Latar Belakang
            </h2>
            <p class="text-slate-600 leading-relaxed text-sm text-justify mb-4">
                Dalam industri transportasi travel dan shuttle antar kota, calon penumpang modern sangat membutuhkan kepastian informasi sebelum melakukan perjalanan: <strong>jam keberangkatan yang akurat, kejelasan rute, fasilitas yang didapatkan (seperti gratis snack & paket makan), serta status ketersediaan kursi secara real-time</strong>.
            </p>
            <p class="text-slate-600 leading-relaxed text-sm text-justify">
                Dengan memiliki 10+ armada yang beroperasi di berbagai rute (seperti Ciamis - Jakarta, Kuningan - Bandung, dll.), ketiadaan website resmi seringkali mengakibatkan penumpukan tanya-jawab berulang di WhatsApp admin, hilangnya calon pelanggan yang ingin memesan di luar jam kerja, dan minimnya transparansi kursi kosong. Proposal ini dirancang untuk membangun sistem website travel modern dan interaktif bagi <strong>{{ $brandName }}</strong>.
            </p>

            <div class="mt-6 bg-travel-50 border border-travel-200 rounded-xl p-5 flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <h3 class="font-bold text-travel-900 text-sm mb-1 flex items-center gap-2">
                        <i class="fas fa-desktop text-travel-600"></i> Preview Draft Website Travel & Booking Kursi
                    </h3>
                    <p class="text-[13px] text-slate-600">Kami telah menyusun kerangka visual dan sistem pemilih kursi interaktif khusus untuk {{ $brandName }}.</p>
                    <div class="hidden print:block text-[13px] font-medium text-travel-600 break-all mt-2 underline">
                        {{ route('landing.dynamic', $client->slug) }}
                    </div>
                </div>
                <a href="{{ route('landing.dynamic', $client->slug) }}" target="_blank" class="shrink-0 bg-travel-600 hover:bg-travel-700 text-white px-5 py-2.5 rounded-full text-[13px] font-bold transition inline-flex items-center justify-center gap-2 no-print shadow-md">
                    Lihat Demo Web <i class="fas fa-external-link-alt text-[10px]"></i>
                </a>
            </div>
        </div>

        <!-- 2. Tujuan & Objektif Proyek -->
        <div class="mb-10">
            <h2 class="font-heading text-2xl font-bold text-slate-900 mb-4 flex items-center gap-2">
                <span class="text-travel-600">02.</span> Objektif & Solusi Utama
            </h2>
            <ul class="space-y-3 text-sm text-slate-600">
                <li class="flex items-start gap-3">
                    <i class="fas fa-check-circle text-travel-600 mt-1"></i>
                    <span><strong>Transparansi Jadwal & Sisa Kursi Real-Time:</strong> Calon penumpang dapat langsung melihat jam keberangkatan dan apakah kursi sudah penuh atau masih tersedia (misal: "Tersisa 3 Kursi").</span>
                </li>
                <li class="flex items-start gap-3">
                    <i class="fas fa-check-circle text-travel-600 mt-1"></i>
                    <span><strong>Visual Seat Picker (Pilih Nomor Kursi):</strong> Memudahkan penumpang memilih posisi kursi favorit mereka (depan, tengah, belakang) secara visual.</span>
                </li>
                <li class="flex items-start gap-3">
                    <i class="fas fa-check-circle text-travel-600 mt-1"></i>
                    <span><strong>Showcase Fasilitas (Snack & Paket Makan):</strong> Menampilkan secara jelas layanan inklusif (Gratis Snack, Air Mineral, Paket Makan di Rest Area, USB Charger, Full AC) untuk meningkatkan daya saing tiket.</span>
                </li>
                <li class="flex items-start gap-3">
                    <i class="fas fa-check-circle text-travel-600 mt-1"></i>
                    <span><strong>Manajemen 10+ Armada & Titik Antar Jemput:</strong> Memudahkan promosi rute, sewa charter 1 mobil, serta pengiriman paket kilat logistik (Same-Day Delivery).</span>
                </li>
            </ul>
        </div>
    </div>

    <!-- HALAMAN 2 -->
    <div class="proposal-page page-break">
        <div class="mb-8 mt-4">
            <h2 class="font-heading text-2xl font-bold text-slate-900 mb-2 flex items-center gap-2">
                <span class="text-travel-600">03.</span> Pilihan Paket & Rincian Investasi
            </h2>
            <p class="text-sm text-slate-600 mb-6">Investasi pembuatan website sistem travel & armada untuk <strong>{{ $brandName }}</strong>:</p>

            <!-- Tabel Komparasi Paket Travel -->
            <div class="overflow-x-auto mb-6 rounded-xl border border-slate-200 bg-white shadow-xs">
                <table class="w-full text-left border-collapse text-[11px]">
                    <thead>
                        <tr class="border-b border-slate-200">
                            <th class="p-3.5 bg-slate-50 font-heading text-slate-900 font-bold w-[32%]">
                                <span class="text-[10px] uppercase tracking-wider block text-travel-600 font-sans">Komparasi Layanan</span>
                                Paket & Spesifikasi Fitur
                            </th>
                            <!-- Silver -->
                            <th class="p-3 text-center bg-slate-50/70 border-l border-slate-200 w-[17%]">
                                <span class="font-heading font-bold text-sm text-slate-900 block">Silver</span>
                                <span class="inline-block my-1 py-0.5 px-2 rounded-full border border-slate-300 bg-white text-[10px] font-bold text-slate-800">
                                    {{ \App\Models\ClientProposal::formatPackagePill($client->silver_price) }}
                                </span>
                                <span class="block text-[9px] text-slate-500">Perpanjangan {{ $client->silver_renewal }}</span>
                            </th>
                            <!-- Gold (Featured) -->
                            <th class="p-3 text-center bg-travel-900 text-white border-x-2 border-travel-600 w-[17%] relative">
                                <span class="absolute -top-2.5 left-1/2 -translate-x-1/2 bg-amber-500 text-slate-900 text-[8px] font-black uppercase tracking-widest px-2 py-0.2 rounded-full shadow-xs">POPULER</span>
                                <span class="font-heading font-bold text-sm text-white block">Gold</span>
                                <span class="inline-block my-1 py-0.5 px-2 rounded-full border border-travel-500 bg-travel-800 text-[10px] font-bold text-travel-100">
                                    {{ \App\Models\ClientProposal::formatPackagePill($client->gold_price) }}
                                </span>
                                <span class="block text-[9px] text-travel-200">Perpanjangan {{ $client->gold_renewal }}</span>
                            </th>
                            <!-- Diamond -->
                            <th class="p-3 text-center bg-slate-50/70 border-l border-slate-200 w-[17%]">
                                <span class="font-heading font-bold text-sm text-slate-900 block">Diamond</span>
                                <span class="inline-block my-1 py-0.5 px-2 rounded-full border border-slate-300 bg-white text-[10px] font-bold text-slate-800">
                                    {{ \App\Models\ClientProposal::formatPackagePill($client->diamond_price) }}
                                </span>
                                <span class="block text-[9px] text-slate-500">Perpanjangan {{ $client->diamond_renewal }}</span>
                            </th>
                            <!-- Platinum -->
                            <th class="p-3 text-center bg-slate-50/70 border-l border-slate-200 w-[17%]">
                                <span class="font-heading font-bold text-sm text-slate-900 block">Platinum</span>
                                <span class="inline-block my-1 py-0.5 px-2 rounded-full border border-slate-300 bg-white text-[10px] font-bold text-slate-800">
                                    {{ \App\Models\ClientProposal::formatPackagePill($client->platinum_price) }}
                                </span>
                                <span class="block text-[9px] text-slate-500">Perpanjangan {{ $client->platinum_renewal }}</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-slate-700">
                        <!-- GROUP 1: FITUR JADWAL & BOOKING KURSI -->
                        <tr class="bg-travel-50/60">
                            <td colspan="5" class="py-1.5 px-3.5 font-bold uppercase tracking-wider text-[10px] text-travel-900">
                                <i class="fas fa-calendar-alt text-travel-600 mr-1.5"></i> Jadwal, Rute & Booking Kursi
                            </td>
                        </tr>
                        <tr>
                            <td class="p-2.5 font-medium">Tampilan Jadwal & Rute Keberangkatan</td>
                            <td class="p-2.5 text-center bg-slate-50/30">Tabel Statis</td>
                            <td class="p-2.5 text-center bg-travel-50/30 font-semibold text-slate-900">Interaktif & Filter Rute</td>
                            <td class="p-2.5 text-center bg-slate-50/30 font-semibold">Live Real-Time Tracker</td>
                            <td class="p-2.5 text-center bg-slate-50/30 font-semibold">Multi-Pool & Multi-Rute</td>
                        </tr>
                        <tr>
                            <td class="p-2.5 font-medium">Status Ketersediaan Kursi (Live Seat Tracker)</td>
                            <td class="p-2.5 text-center bg-slate-50/30 text-slate-300 font-bold">—</td>
                            <td class="p-2.5 text-center bg-travel-50/30 text-travel-600 font-bold"><i class="fas fa-check-circle text-sm"></i> Bar Indikator Kursi</td>
                            <td class="p-2.5 text-center bg-slate-50/30 text-travel-600 font-bold"><i class="fas fa-check-circle text-sm"></i> Otomatis Berkurang</td>
                            <td class="p-2.5 text-center bg-slate-50/30 text-travel-600 font-bold"><i class="fas fa-check-circle text-sm"></i> Real-time Seat Sync</td>
                        </tr>
                        <tr>
                            <td class="p-2.5 font-medium">Denah Pemilihan Kursi Interaktif (Visual Seat Selector)</td>
                            <td class="p-2.5 text-center bg-slate-50/30 text-slate-300 font-bold">—</td>
                            <td class="p-2.5 text-center bg-travel-50/30 text-travel-600 font-bold"><i class="fas fa-check-circle text-sm"></i> Denah Mobil</td>
                            <td class="p-2.5 text-center bg-slate-50/30 text-travel-600 font-bold"><i class="fas fa-check-circle text-sm"></i> Denah Multi-Armada</td>
                            <td class="p-2.5 text-center bg-slate-50/30 text-travel-600 font-bold"><i class="fas fa-check-circle text-sm"></i> Full Custom Layout</td>
                        </tr>
                        <tr>
                            <td class="p-2.5 font-medium">Katalog 10+ Armada (Spesifikasi & Fasilitas)</td>
                            <td class="p-2.5 text-center bg-slate-50/30">Foto Statis</td>
                            <td class="p-2.5 text-center bg-travel-50/30 text-slate-900 font-semibold">10 Armada Interaktif</td>
                            <td class="p-2.5 text-center bg-slate-50/30 font-semibold">Unlimited Armada</td>
                            <td class="p-2.5 text-center bg-slate-50/30 font-semibold">Unlimited + Live Status</td>
                        </tr>
                        <tr>
                            <td class="p-2.5 font-medium">Rincian Paket Fasilitas (Snack, Makan 1x/2x, Tol)</td>
                            <td class="p-2.5 text-center bg-slate-50/30 text-slate-300 font-bold">—</td>
                            <td class="p-2.5 text-center bg-travel-50/30 text-travel-600 font-bold"><i class="fas fa-check-circle text-sm"></i> Lengkap</td>
                            <td class="p-2.5 text-center bg-slate-50/30 text-travel-600 font-bold"><i class="fas fa-check-circle text-sm"></i> Lengkap + Add-on</td>
                            <td class="p-2.5 text-center bg-slate-50/30 text-travel-600 font-bold"><i class="fas fa-check-circle text-sm"></i> Custom Menu Pilihan</td>
                        </tr>

                        <!-- GROUP 2: OPERASIONAL & TRANSAKSI -->
                        <tr class="bg-travel-50/60">
                            <td colspan="5" class="py-1.5 px-3.5 font-bold uppercase tracking-wider text-[10px] text-travel-900">
                                <i class="fas fa-cogs text-travel-600 mr-1.5"></i> Operasional, Admin & Pembayaran
                            </td>
                        </tr>
                        <tr>
                            <td class="p-2.5 font-medium">Panel Admin CMS (Update Jadwal, Kursi & Tarif)</td>
                            <td class="p-2.5 text-center bg-slate-50/30 text-slate-300 font-bold">—</td>
                            <td class="p-2.5 text-center bg-travel-50/30 text-travel-600 font-bold"><i class="fas fa-check-circle text-sm"></i> CMS Praktis</td>
                            <td class="p-2.5 text-center bg-slate-50/30 text-travel-600 font-bold"><i class="fas fa-check-circle text-sm"></i> CMS Lengkap</td>
                            <td class="p-2.5 text-center bg-slate-50/30 text-travel-600 font-bold"><i class="fas fa-check-circle text-sm"></i> CMS Enterprise</td>
                        </tr>
                        <tr>
                            <td class="p-2.5 font-medium">Sistem Pemesanan Door to Door</td>
                            <td class="p-2.5 text-center bg-slate-50/30">WhatsApp Manual</td>
                            <td class="p-2.5 text-center bg-travel-50/30 text-travel-600 font-bold"><i class="fas fa-check-circle text-sm"></i> Form Otomatis WA</td>
                            <td class="p-2.5 text-center bg-slate-50/30 text-travel-600 font-bold"><i class="fas fa-check-circle text-sm"></i> Form + E-Tiket PDF</td>
                            <td class="p-2.5 text-center bg-slate-50/30 text-travel-600 font-bold"><i class="fas fa-check-circle text-sm"></i> Full Booking System</td>
                        </tr>
                        <tr>
                            <td class="p-2.5 font-medium">Payment Gateway Otomatis (QRIS, VA, E-Wallet)</td>
                            <td class="p-2.5 text-center bg-slate-50/30 text-slate-300 font-bold">—</td>
                            <td class="p-2.5 text-center bg-travel-50/30 text-slate-300 font-bold">—</td>
                            <td class="p-2.5 text-center bg-slate-50/30 text-travel-600 font-bold"><i class="fas fa-check-circle text-sm"></i> QRIS & VA</td>
                            <td class="p-2.5 text-center bg-slate-50/30 text-travel-600 font-bold"><i class="fas fa-check-circle text-sm"></i> Multi-Gateway</td>
                        </tr>
                        <tr>
                            <td class="p-2.5 font-medium">Modul Pengiriman Paket Kilat (Same-Day Cargo)</td>
                            <td class="p-2.5 text-center bg-slate-50/30 text-slate-300 font-bold">—</td>
                            <td class="p-2.5 text-center bg-travel-50/30 text-slate-300 font-bold">—</td>
                            <td class="p-2.5 text-center bg-slate-50/30 text-travel-600 font-bold"><i class="fas fa-check-circle text-sm"></i> Form Resi Paket</td>
                            <td class="p-2.5 text-center bg-slate-50/30 text-travel-600 font-bold"><i class="fas fa-check-circle text-sm"></i> Live Tracking Resi</td>
                        </tr>
                        <tr>
                            <td class="p-2.5 font-medium">Manajemen Multi-Pool & Cabang Terintegrasi</td>
                            <td class="p-2.5 text-center bg-slate-50/30">1 Pool</td>
                            <td class="p-2.5 text-center bg-travel-50/30 text-slate-900">1-2 Pool</td>
                            <td class="p-2.5 text-center bg-slate-50/30">Hingga 5 Pool</td>
                            <td class="p-2.5 text-center bg-slate-50/30 text-travel-600 font-bold"><i class="fas fa-check-circle text-sm"></i> Unlimited Cabang</td>
                        </tr>

                        <!-- GROUP 3: SERVER & GARANSI -->
                        <tr class="bg-travel-50/60">
                            <td colspan="5" class="py-1.5 px-3.5 font-bold uppercase tracking-wider text-[10px] text-travel-900">
                                <i class="fas fa-server text-travel-600 mr-1.5"></i> Infrastruktur Server & Support
                            </td>
                        </tr>
                        <tr>
                            <td class="p-2.5 font-medium">Domain Kustom (.com / .id) & Cloud Hosting</td>
                            <td class="p-2.5 text-center bg-slate-50/30">1 Tahun</td>
                            <td class="p-2.5 text-center bg-travel-50/30 font-semibold text-slate-900">1 Tahun Cloud SSD</td>
                            <td class="p-2.5 text-center bg-slate-50/30 font-semibold">1 Tahun High-Speed SSD</td>
                            <td class="p-2.5 text-center bg-slate-50/30 font-semibold text-slate-900">Dedicated Cloud Server</td>
                        </tr>
                        <tr>
                            <td class="p-2.5 font-medium">Garansi & Layanan Maintenance Teknis</td>
                            <td class="p-2.5 text-center bg-slate-50/30">1 Bulan</td>
                            <td class="p-2.5 text-center bg-travel-50/30 font-semibold text-slate-900">3 Bulan Prioritas</td>
                            <td class="p-2.5 text-center bg-slate-50/30 font-semibold">6 Bulan Prioritas</td>
                            <td class="p-2.5 text-center bg-slate-50/30 font-bold text-slate-900">1 Tahun VIP Support</td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr class="border-t-2 border-slate-300 bg-white">
                            <td class="p-3 font-bold text-slate-800">Aksi Pemesanan</td>
                            <td class="p-2.5 text-center bg-slate-50/50">
                                <a href="https://wa.me/{{ $cleanWa }}?text={{ urlencode('Halo Scalify, saya tertarik memesan Paket Silver untuk ' . $brandName . '. Mohon info detailnya.') }}" target="_blank" class="inline-flex items-center justify-center gap-1 w-full py-1.5 px-2 rounded-lg bg-slate-800 hover:bg-slate-900 text-white text-[10px] font-bold shadow-xs transition no-print">
                                    <i class="fab fa-whatsapp text-green-400"></i> Pilih Silver
                                </a>
                            </td>
                            <td class="p-2.5 text-center bg-travel-50/30">
                                <a href="https://wa.me/{{ $cleanWa }}?text={{ urlencode('Halo Scalify, saya tertarik memesan Paket Gold untuk ' . $brandName . '. Mohon info detailnya.') }}" target="_blank" class="inline-flex items-center justify-center gap-1 w-full py-2 px-2 rounded-lg bg-travel-600 hover:bg-travel-700 text-white text-[11px] font-extrabold shadow-md transition no-print">
                                    <i class="fab fa-whatsapp text-white"></i> Pilih Gold
                                </a>
                            </td>
                            <td class="p-2.5 text-center bg-slate-50/50">
                                <a href="https://wa.me/{{ $cleanWa }}?text={{ urlencode('Halo Scalify, saya tertarik memesan Paket Diamond untuk ' . $brandName . '. Mohon info detailnya.') }}" target="_blank" class="inline-flex items-center justify-center gap-1 w-full py-1.5 px-2 rounded-lg bg-slate-800 hover:bg-slate-900 text-white text-[10px] font-bold shadow-xs transition no-print">
                                    <i class="fab fa-whatsapp text-green-400"></i> Pilih Diamond
                                </a>
                            </td>
                            <td class="p-2.5 text-center bg-slate-50/50">
                                <a href="https://wa.me/{{ $cleanWa }}?text={{ urlencode('Halo Scalify, saya tertarik memesan Paket Platinum untuk ' . $brandName . '. Mohon info detailnya.') }}" target="_blank" class="inline-flex items-center justify-center gap-1 w-full py-1.5 px-2 rounded-lg bg-slate-800 hover:bg-slate-900 text-white text-[10px] font-bold shadow-xs transition no-print">
                                    <i class="fab fa-whatsapp text-green-400"></i> Pilih Platinum
                                </a>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <div class="bg-travel-50 border-l-4 border-travel-600 p-3.5 rounded-r-lg mb-6">
                <p class="text-[12px] text-slate-700 leading-relaxed">
                    <strong>Catatan:</strong> Seluruh paket di atas dapat disesuaikan (customized) mengikuti model operasional, jumlah armada aktif, serta termin pembayaran bertahap (Down Payment + Pelunasan).
                </p>
            </div>
        </div>

        <div class="mt-8 border-t border-slate-200 pt-6 text-xs text-slate-600">
            <p class="mb-4">Demikian proposal penawaran sistem dan website travel ini kami sampaikan. Kami siap membantu mengembangkan ekosistem digital terbaik untuk {{ $brandName }}.</p>
            <div class="flex justify-between items-end mt-8">
                <div class="text-center">
                    <p class="mb-14">Hormat Kami,</p>
                    <div class="border-b border-slate-400 w-44 mb-1 mx-auto"></div>
                    <p class="font-bold text-slate-900">M. Andi</p>
                    <p class="text-[11px] text-slate-500">Project Manager - Scalify</p>
                </div>
                <div class="text-center">
                    <p class="mb-14">Disetujui Oleh,</p>
                    <div class="border-b border-slate-400 w-44 mb-1 mx-auto"></div>
                    <p class="font-bold text-slate-900">.........................................</p>
                    <p class="text-[11px] text-slate-500">{{ $brandName }}</p>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
