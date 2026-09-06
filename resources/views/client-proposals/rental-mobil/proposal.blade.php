<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Proposal Proyek Website - {{ $client->brand_name }}</title>
    <meta name="description" content="Proposal pengajuan pengembangan sistem dan website custom untuk {{ $client->brand_name }} oleh Scalify Intelligence.">

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            blue: '#1E40AF'
                            , dark: '#0F172A'
                            , light: '#F8FAFC'
                            , accent: '#F59E0B'
                        , }
                    }
                }
            }
        }

    </script>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500;600;700;800&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body {
            background-color: #f1f5f9;
            font-family: 'Inter', sans-serif;
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

    <!-- Floating Action Button -->
    <div class="fixed bottom-8 right-8 no-print z-50">
        <button onclick="window.print()" class="bg-brand-blue hover:bg-blue-800 text-white px-6 py-3 rounded-full shadow-lg font-medium flex items-center gap-2 transition">
            <i class="fas fa-file-pdf"></i>
            Simpan sebagai PDF
        </button>
    </div>

    <!-- HALAMAN 1 -->
    <div class="proposal-page">
        <!-- Cover Header -->
        <div class="border-b-4 border-brand-blue pb-8 mb-10 mt-10">
            <div class="flex justify-between items-end">
                <div>
                    <p class="text-brand-blue font-bold tracking-widest text-xs mb-2 uppercase">Proposal Proyek Digitalisasi</p>
                    <h1 class="font-heading text-4xl font-extrabold text-brand-dark leading-tight">Pengembangan Website<br>Company Profile & Katalog Armada</h1>
                </div>
                <div class="text-right">
                    <div class="w-14 h-14 rounded-2xl bg-brand-blue flex items-center justify-center text-white text-2xl ml-auto mb-3 shadow-md"><i class="fas fa-car"></i></div>
                    <p class="font-bold text-brand-dark text-lg">{{ $client->brand_name }}</p>
                    <p class="text-sm text-slate-500">{{ date('d F Y') }}</p>
                </div>
            </div>
        </div>

        <div class="mb-12 flex justify-between text-sm">
            <div>
                <p class="text-slate-400 mb-1">Disiapkan untuk:</p>
                <p class="font-bold text-brand-dark text-base">{{ $client->client_name ?? $client->brand_name }}</p>
                <p class="text-slate-600">Rent Car & Transport Services</p>
            </div>
            <div class="text-right">
                <p class="text-slate-400 mb-1">Disiapkan oleh:</p>
                <p class="font-bold text-brand-dark text-base">Scalify Intelligence</p>
                <p class="text-slate-600">Web Development Agency</p>
            </div>
        </div>

        <!-- 1. Pendahuluan -->
        <div class="mb-10">
            <h2 class="font-heading text-2xl font-bold text-brand-dark mb-4 flex items-center gap-2">
                <span class="text-brand-blue">01.</span> Latar Belakang
            </h2>
            <p class="text-slate-600 leading-relaxed text-sm text-justify mb-4">
                Di era digital, calon penyewa mobil lebih sering mencari informasi dan membandingkan harga melalui internet (Google) sebelum memutuskan untuk melakukan penyewaan. Tanpa representasi digital yang profesional, bisnis rental mobil berisiko kehilangan banyak calon pelanggan potensial.
            </p>
            <p class="text-slate-600 leading-relaxed text-sm text-justify">
                Proposal ini ditujukan untuk merancang website bagi <strong>{{ $client->brand_name }}</strong>. Website akan berfungsi sebagai kantor cabang virtual 24 jam yang menampilkan seluruh katalog armada, daftar harga transparan, syarat ketentuan, dan tombol integrasi langsung untuk *booking* via WhatsApp.
            </p>

            <div class="mt-6 bg-blue-50 border border-blue-200 rounded-xl p-5 flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <h3 class="font-bold text-brand-dark text-sm mb-1 flex items-center gap-2">
                        <i class="fas fa-desktop text-brand-blue"></i> Preview Desain Website (Mockup)
                    </h3>
                    <p class="text-[13px] text-slate-700">Kami telah menyusun kerangka desain khusus untuk {{ $client->brand_name }}. Anda dapat melihat pratinjaunya pada tautan berikut.</p>
                    <div class="hidden print:block text-[13px] font-medium text-brand-blue break-all mt-2 underline">
                        {{ route("landing.dynamic", $client->slug) }}
                    </div>
                </div>
                <a href="{{ route("landing.dynamic", $client->slug) }}" target="_blank" class="shrink-0 bg-brand-blue hover:bg-blue-800 text-white px-5 py-2.5 rounded-lg text-[13px] font-semibold transition inline-flex items-center justify-center gap-2 no-print shadow-md">
                    Lihat Demo Web <i class="fas fa-external-link-alt text-[10px]"></i>
                </a>
            </div>
        </div>

        <!-- 2. Tujuan & Objektif -->
        <div class="mb-10">
            <h2 class="font-heading text-2xl font-bold text-brand-dark mb-4 flex items-center gap-2">
                <span class="text-brand-blue">02.</span> Manfaat Utama
            </h2>
            <ul class="space-y-4 text-sm text-slate-600">
                <li class="flex items-start gap-3">
                    <div class="w-6 h-6 rounded-full bg-blue-100 text-brand-blue flex items-center justify-center shrink-0 mt-0.5"><i class="fas fa-check text-[10px]"></i></div>
                    <div>
                        <strong class="text-brand-dark">Katalog Armada Online (CMS):</strong>
                        <p class="mt-1">Dapat mengelola daftar mobil, mengupdate harga sewa (dengan/tanpa supir), serta menampilkan spesifikasi mobil dengan mudah.</p>
                    </div>
                </li>
                <li class="flex items-start gap-3">
                    <div class="w-6 h-6 rounded-full bg-blue-100 text-brand-blue flex items-center justify-center shrink-0 mt-0.5"><i class="fas fa-check text-[10px]"></i></div>
                    <div>
                        <strong class="text-brand-dark">Meningkatkan Kepercayaan Pelanggan (Trust):</strong>
                        <p class="mt-1">Website yang profesional dan responsif memberikan kesan kredibel, aman, dan terpercaya bagi calon penyewa luar kota maupun turis.</p>
                    </div>
                </li>
                <li class="flex items-start gap-3">
                    <div class="w-6 h-6 rounded-full bg-blue-100 text-brand-blue flex items-center justify-center shrink-0 mt-0.5"><i class="fas fa-check text-[10px]"></i></div>
                    <div>
                        <strong class="text-brand-dark">Digitalisasi Operasional:</strong>
                        <p class="mt-1">Meminimalisir kesalahan catat manual (double booking) dan kehilangan berkas dengan sistem manajemen terpadu (Satu Pintu).</p>
                    </div>
                </li>
            </ul>
        </div>
    </div>

    <!-- HALAMAN 2 -->
    <div class="proposal-page page-break">

        <!-- 3. Fitur Utama -->
        <div class="mb-10 mt-6">
            <h2 class="font-heading text-2xl font-bold text-brand-dark mb-6 flex items-center gap-2">
                <span class="text-brand-blue">03.</span> Fitur Utama Sistem
            </h2>

            <div class="grid grid-cols-1 gap-6">
                <!-- Fitur Pelanggan -->
                <div class="border border-slate-200 rounded-xl p-5 bg-white shadow-sm">
                    <h3 class="font-bold text-brand-blue mb-3 border-b border-slate-100 pb-2"><i class="fas fa-mobile-alt mr-2"></i>Sisi Pelanggan (Front-End)</h3>
                    <ul class="space-y-2 text-sm text-slate-600">
                        <li><strong class="text-brand-dark">Pencarian & Live Calendar:</strong> Pelanggan dapat melihat mobil mana yang "Tersedia" atau "Full Booked" secara real-time pada tanggal yang mereka inginkan.</li>
                        <li><strong class="text-brand-dark">Sistem e-KYC Aman:</strong> Formulir pemesanan terintegrasi dengan fitur unggah KTP/SIM secara digital yang wajib diisi untuk keamanan penyewaan lepas kunci.</li>
                        <li><strong class="text-brand-dark">Payment Gateway:</strong> Pembayaran DP (Down Payment) atau Lunas yang terintegrasi otomatis via QRIS atau Virtual Account.</li>
                    </ul>
                </div>

                <!-- Fitur Admin -->
                <div class="border border-slate-200 rounded-xl p-5 bg-white shadow-sm">
                    <h3 class="font-bold text-brand-blue mb-3 border-b border-slate-100 pb-2"><i class="fas fa-laptop-code mr-2"></i>Sisi Admin & Operasional (Back-End)</h3>
                    <ul class="space-y-2 text-sm text-slate-600">
                        <li><strong class="text-brand-dark">Dashboard Utilisasi Armada:</strong> Memantau secara live berapa persen armada yang sedang disewa, nganggur, atau butuh servis (Ganti Oli/Rem).</li>
                        <li><strong class="text-brand-dark">Inspeksi Digital (Check-in/Check-out):</strong> Form digital (tanpa kertas) untuk mencatat kondisi bensin & goresan awal mobil, dilengkapi fitur Tanda Tangan Elektronik pelanggan.</li>
                        <li><strong class="text-brand-dark">Pencegahan Double Booking:</strong> Sistem secara otomatis akan mengunci ketersediaan mobil jika sudah ada penyewa lain di tanggal yang sama.</li>
                    </ul>
                </div>
            </div>
        </div>

    </div>

    <!-- HALAMAN 3 -->
    <div class="proposal-page page-break">
        <div class="mb-8 mt-4">
            <h2 class="font-heading text-2xl font-bold text-brand-dark mb-2 flex items-center gap-2">
                <span class="text-brand-blue">04.</span> Pilihan Paket & Rincian Investasi
            </h2>
            <p class="text-sm text-slate-600 mb-6">Investasi pembuatan website Company Profile & Sistem Manajemen Rental Mobil untuk <strong>{{ $client->brand_name }}</strong>:</p>

            @php
            $cleanWa = preg_replace('/[^0-9]/', '', $client->wa_number ?? '6281234567890');
            if (str_starts_with($cleanWa, '0')) {
            $cleanWa = '62' . substr($cleanWa, 1);
            }
            @endphp

            <!-- Tabel Perbandingan Paket & Fitur Rental Mobil -->
            <div class="overflow-x-auto mb-6 rounded-xl border border-blue-200 bg-white shadow-xs">
                <table class="w-full text-left border-collapse text-[11px]">
                    <thead>
                        <tr class="border-b border-blue-200">
                            <th class="p-3.5 bg-brand-dark text-white font-heading font-bold w-[32%]">
                                <span class="text-[10px] uppercase tracking-wider block text-amber-400 font-sans">Komparasi Spesifikasi</span>
                                Paket Sistem Rental & Fitur
                            </th>
                            <!-- Silver -->
                            <th class="p-3 text-center bg-slate-50 border-l border-slate-200 w-[17%]">
                                <span class="font-heading font-bold text-sm text-brand-dark block">Silver</span>
                                <span class="inline-block my-1 py-0.5 px-2 rounded-full border border-blue-200 bg-white text-[10px] font-bold text-brand-blue">
                                    {{ \App\Models\ClientProposal::formatPackagePill($client->silver_price) }}
                                </span>
                                <span class="block text-[9px] text-slate-500">Perpanjangan {{ $client->silver_renewal }}</span>
                            </th>
                            <!-- Gold (Featured) -->
                            <th class="p-3 text-center bg-brand-blue text-white border-x-2 border-blue-400 w-[17%] relative">
                                <span class="absolute -top-2.5 left-1/2 -translate-x-1/2 bg-amber-400 text-slate-900 text-[8px] font-black uppercase tracking-widest px-2 py-0.2 rounded-full shadow-xs">POPULER</span>
                                <span class="font-heading font-bold text-sm text-white block">Gold</span>
                                <span class="inline-block my-1 py-0.5 px-2 rounded-full border border-white/60 bg-blue-900/60 text-[10px] font-bold text-white">
                                    {{ \App\Models\ClientProposal::formatPackagePill($client->gold_price) }}
                                </span>
                                <span class="block text-[9px] text-blue-100">Perpanjangan {{ $client->gold_renewal }}</span>
                            </th>
                            <!-- Diamond -->
                            <th class="p-3 text-center bg-slate-50 border-l border-slate-200 w-[17%]">
                                <span class="font-heading font-bold text-sm text-brand-dark block">Diamond</span>
                                <span class="inline-block my-1 py-0.5 px-2 rounded-full border border-blue-200 bg-white text-[10px] font-bold text-brand-blue">
                                    {{ \App\Models\ClientProposal::formatPackagePill($client->diamond_price) }}
                                </span>
                                <span class="block text-[9px] text-slate-500">Perpanjangan {{ $client->diamond_renewal }}</span>
                            </th>
                            <!-- Platinum -->
                            <th class="p-3 text-center bg-slate-50 border-l border-slate-200 w-[17%]">
                                <span class="font-heading font-bold text-sm text-brand-dark block">Platinum</span>
                                <span class="inline-block my-1 py-0.5 px-2 rounded-full border border-blue-200 bg-white text-[10px] font-bold text-brand-blue">
                                    {{ \App\Models\ClientProposal::formatPackagePill($client->platinum_price) }}
                                </span>
                                <span class="block text-[9px] text-slate-500">Perpanjangan {{ $client->platinum_renewal }}</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 text-slate-700">
                        <!-- GROUP 1: KATALOG & TAMPILAN ARMADA -->
                        <tr class="bg-blue-50/70">
                            <td colspan="5" class="py-1.5 px-3.5 font-bold uppercase tracking-wider text-[10px] text-brand-blue">
                                <i class="fas fa-car text-brand-blue mr-1.5"></i> Katalog Armada & Tampilan Website
                            </td>
                        </tr>
                        <tr>
                            <td class="p-2.5 font-medium">Tipe Desain Website & Showcase</td>
                            <td class="p-2.5 text-center bg-slate-50/40">Landing Page Showcase</td>
                            <td class="p-2.5 text-center bg-blue-50/20 font-semibold text-brand-dark">Company Profile + CMS</td>
                            <td class="p-2.5 text-center bg-slate-50/40 font-semibold">Portal Booking Terpadu</td>
                            <td class="p-2.5 text-center bg-slate-50/40 font-semibold">Fleet Management System</td>
                        </tr>
                        <tr>
                            <td class="p-2.5 font-medium">Kelola Armada (Lepas Kunci & All-in Supir)</td>
                            <td class="p-2.5 text-center bg-slate-50/40">Daftar Statis</td>
                            <td class="p-2.5 text-center bg-blue-50/20 font-semibold text-brand-dark"><i class="fas fa-check-circle text-brand-blue text-sm"></i> CMS Mandiri</td>
                            <td class="p-2.5 text-center bg-slate-50/40 font-semibold"><i class="fas fa-check-circle text-brand-blue text-sm"></i> CMS Mandiri</td>
                            <td class="p-2.5 text-center bg-slate-50/40 font-semibold"><i class="fas fa-check-circle text-brand-blue text-sm"></i> Multi-Kategori CMS</td>
                        </tr>
                        <tr>
                            <td class="p-2.5 font-medium">Filter Kategori (City Car, MPV, SUV, Luxury)</td>
                            <td class="p-2.5 text-center bg-slate-50/40">Sederhana</td>
                            <td class="p-2.5 text-center bg-blue-50/20 text-brand-blue font-semibold"><i class="fas fa-check-circle text-sm"></i> Lengkap</td>
                            <td class="p-2.5 text-center bg-slate-50/40 text-brand-blue font-semibold"><i class="fas fa-check-circle text-sm"></i> Lengkap</td>
                            <td class="p-2.5 text-center bg-slate-50/40 text-brand-blue font-semibold"><i class="fas fa-check-circle text-sm"></i> Lengkap + Spesifikasi</td>
                        </tr>

                        <!-- GROUP 2: BOOKING & OPERASIONAL BISNIS RENTAL -->
                        <tr class="bg-blue-50/70">
                            <td colspan="5" class="py-1.5 px-3.5 font-bold uppercase tracking-wider text-[10px] text-brand-blue">
                                <i class="fas fa-tasks text-brand-blue mr-1.5"></i> Sistem Pemesanan & Operasional Rental
                            </td>
                        </tr>
                        <tr>
                            <td class="p-2.5 font-medium">Formulir Booking Online & Lokasi Jemput</td>
                            <td class="p-2.5 text-center bg-slate-50/40">WhatsApp Cepat</td>
                            <td class="p-2.5 text-center bg-blue-50/20 font-semibold text-brand-dark"><i class="fas fa-check-circle text-brand-blue text-sm"></i> Form Terstruktur</td>
                            <td class="p-2.5 text-center bg-slate-50/40 font-semibold"><i class="fas fa-check-circle text-brand-blue text-sm"></i> Form Otomatis</td>
                            <td class="p-2.5 text-center bg-slate-50/40 font-semibold"><i class="fas fa-check-circle text-brand-blue text-sm"></i> Form Otomatis</td>
                        </tr>
                        <tr>
                            <td class="p-2.5 font-medium">Live Calendar Ketersediaan (Anti Double-Booking)</td>
                            <td class="p-2.5 text-center bg-slate-50/40 text-slate-300 font-bold">—</td>
                            <td class="p-2.5 text-center bg-blue-50/20 text-slate-300 font-bold">—</td>
                            <td class="p-2.5 text-center bg-slate-50/40 text-brand-blue font-bold"><i class="fas fa-check-circle text-sm"></i> Real-time Calendar</td>
                            <td class="p-2.5 text-center bg-slate-50/40 text-brand-blue font-bold"><i class="fas fa-check-circle text-sm"></i> Real-time Calendar</td>
                        </tr>
                        <tr>
                            <td class="p-2.5 font-medium">Form e-KYC Digital Aman (Unggah KTP & SIM)</td>
                            <td class="p-2.5 text-center bg-slate-50/40 text-slate-300 font-bold">—</td>
                            <td class="p-2.5 text-center bg-blue-50/20 text-slate-300 font-bold">—</td>
                            <td class="p-2.5 text-center bg-slate-50/40 text-brand-blue font-bold"><i class="fas fa-check-circle text-sm"></i> e-KYC Jaminan</td>
                            <td class="p-2.5 text-center bg-slate-50/40 text-brand-blue font-bold"><i class="fas fa-check-circle text-sm"></i> e-KYC + Verifikasi</td>
                        </tr>
                        <tr>
                            <td class="p-2.5 font-medium">Payment Gateway Otomatis (DP via QRIS & VA Bank)</td>
                            <td class="p-2.5 text-center bg-slate-50/40 text-slate-300 font-bold">—</td>
                            <td class="p-2.5 text-center bg-blue-50/20 text-slate-300 font-bold">—</td>
                            <td class="p-2.5 text-center bg-slate-50/40 text-brand-blue font-bold"><i class="fas fa-check-circle text-sm"></i> QRIS & VA Otomatis</td>
                            <td class="p-2.5 text-center bg-slate-50/40 text-brand-blue font-bold"><i class="fas fa-check-circle text-sm"></i> Multi-Payment Otomatis</td>
                        </tr>
                        <tr>
                            <td class="p-2.5 font-medium">Dashboard Utilisasi Armada (Disewa/Standby/Servis)</td>
                            <td class="p-2.5 text-center bg-slate-50/40 text-slate-300 font-bold">—</td>
                            <td class="p-2.5 text-center bg-blue-50/20 text-slate-300 font-bold">—</td>
                            <td class="p-2.5 text-center bg-slate-50/40 text-slate-300 font-bold">—</td>
                            <td class="p-2.5 text-center bg-slate-50/40 text-brand-blue font-bold"><i class="fas fa-check-circle text-sm"></i> Live Fleet Monitor</td>
                        </tr>
                        <tr>
                            <td class="p-2.5 font-medium">Inspeksi Digital (Check-in/out Bensin + e-Sign)</td>
                            <td class="p-2.5 text-center bg-slate-50/40 text-slate-300 font-bold">—</td>
                            <td class="p-2.5 text-center bg-blue-50/20 text-slate-300 font-bold">—</td>
                            <td class="p-2.5 text-center bg-slate-50/40 text-slate-300 font-bold">—</td>
                            <td class="p-2.5 text-center bg-slate-50/40 text-brand-blue font-bold"><i class="fas fa-check-circle text-sm"></i> Paperless + TTD Digital</td>
                        </tr>
                        <tr>
                            <td class="p-2.5 font-medium">Jadwal Supir & Reminder Otomatis Servis/Pajak</td>
                            <td class="p-2.5 text-center bg-slate-50/40 text-slate-300 font-bold">—</td>
                            <td class="p-2.5 text-center bg-blue-50/20 text-slate-300 font-bold">—</td>
                            <td class="p-2.5 text-center bg-slate-50/40 text-slate-300 font-bold">—</td>
                            <td class="p-2.5 text-center bg-slate-50/40 text-brand-blue font-bold"><i class="fas fa-check-circle text-sm"></i> Modul Supir & Servis</td>
                        </tr>

                        <!-- GROUP 3: SERVER & GARANSI -->
                        <tr class="bg-blue-50/70">
                            <td colspan="5" class="py-1.5 px-3.5 font-bold uppercase tracking-wider text-[10px] text-brand-blue">
                                <i class="fas fa-shield-alt text-brand-blue mr-1.5"></i> Infrastruktur Server & Garansi
                            </td>
                        </tr>
                        <tr>
                            <td class="p-2.5 font-medium">Domain Kustom (.com / .id) & Cloud SSD Server</td>
                            <td class="p-2.5 text-center bg-slate-50/40">1 Tahun</td>
                            <td class="p-2.5 text-center bg-blue-50/20 font-semibold text-brand-dark">1 Tahun Cloud SSD</td>
                            <td class="p-2.5 text-center bg-slate-50/40 font-semibold">1 Tahun High-Speed SSD</td>
                            <td class="p-2.5 text-center bg-slate-50/40 font-semibold text-brand-dark">Dedicated Cloud Server</td>
                        </tr>
                        <tr>
                            <td class="p-2.5 font-medium">Garansi & Pendampingan Teknis</td>
                            <td class="p-2.5 text-center bg-slate-50/40">1 Bulan</td>
                            <td class="p-2.5 text-center bg-blue-50/20 font-semibold text-brand-dark">3 Bulan</td>
                            <td class="p-2.5 text-center bg-slate-50/40 font-semibold">6 Bulan Prioritas</td>
                            <td class="p-2.5 text-center bg-slate-50/40 font-bold text-brand-dark">1 Tahun Penuh (VIP)</td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr class="border-t-2 border-blue-300 bg-white">
                            <td class="p-3 font-bold text-brand-dark">Aksi Pemesanan</td>
                            <td class="p-2.5 text-center bg-slate-50/50">
                                <a href="https://wa.me/{{ $cleanWa }}?text={{ urlencode('Halo Scalify, saya tertarik memesan Paket Silver untuk ' . $client->brand_name . '. Mohon info detailnya.') }}" target="_blank" class="inline-flex items-center justify-center gap-1 w-full py-1.5 px-2 rounded-lg bg-brand-blue hover:bg-blue-800 text-white text-[10px] font-bold shadow-xs transition no-print">
                                    <i class="fab fa-whatsapp text-green-400"></i> Pilih Silver
                                </a>
                            </td>
                            <td class="p-2.5 text-center bg-blue-50/20">
                                <a href="https://wa.me/{{ $cleanWa }}?text={{ urlencode('Halo Scalify, saya tertarik memesan Paket Gold untuk ' . $client->brand_name . '. Mohon info detailnya.') }}" target="_blank" class="inline-flex items-center justify-center gap-1 w-full py-2 px-2 rounded-lg bg-amber-400 hover:bg-amber-300 text-slate-950 text-[11px] font-extrabold shadow-md transition no-print">
                                    <i class="fab fa-whatsapp text-slate-950"></i> Pilih Gold
                                </a>
                            </td>
                            <td class="p-2.5 text-center bg-slate-50/50">
                                <a href="https://wa.me/{{ $cleanWa }}?text={{ urlencode('Halo Scalify, saya tertarik memesan Paket Diamond untuk ' . $client->brand_name . '. Mohon info detailnya.') }}" target="_blank" class="inline-flex items-center justify-center gap-1 w-full py-1.5 px-2 rounded-lg bg-brand-blue hover:bg-blue-800 text-white text-[10px] font-bold shadow-xs transition no-print">
                                    <i class="fab fa-whatsapp text-green-400"></i> Pilih Diamond
                                </a>
                            </td>
                            <td class="p-2.5 text-center bg-slate-50/50">
                                <a href="https://wa.me/{{ $cleanWa }}?text={{ urlencode('Halo Scalify, saya tertarik memesan Paket Platinum untuk ' . $client->brand_name . '. Mohon info detailnya.') }}" target="_blank" class="inline-flex items-center justify-center gap-1 w-full py-1.5 px-2 rounded-lg bg-brand-blue hover:bg-blue-800 text-white text-[10px] font-bold shadow-xs transition no-print">
                                    <i class="fab fa-whatsapp text-green-400"></i> Pilih Platinum
                                </a>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <div class="bg-blue-50 border-l-4 border-brand-blue p-3.5 rounded-r-lg mb-6">
                <p class="text-[12px] text-slate-700 leading-relaxed">
                    <strong>Fleksibilitas:</strong> Rincian fitur dan harga di atas bersifat usulan awal. Kami sangat terbuka untuk berdiskusi lebih lanjut dan melakukan penyesuaian (customization) baik dari segi fitur maupun skema pembayaran sesuai alokasi budget perusahaan.
                </p>
            </div>
        </div>

        <div class="mt-8 border-t border-slate-200 pt-6 text-xs text-slate-600">
            <p class="mb-4">Demikian proposal penawaran pembuatan website ini kami sampaikan. Atas perhatian dan kerja samanya, kami ucapkan terima kasih.</p>
            <div class="flex justify-between items-end mt-8">
                <div class="text-center">
                    <p class="mb-14">Hormat Kami,</p>
                    <div class="border-b border-slate-400 w-44 mb-1 mx-auto"></div>
                    <p class="font-bold text-brand-dark">M. Andi</p>
                    <p class="text-[11px] text-slate-500">Project Manager - Scalify</p>
                </div>
                <div class="text-center">
                    <p class="mb-14">Disetujui Oleh,</p>
                    <div class="border-b border-slate-400 w-44 mb-1 mx-auto"></div>
                    <p class="font-bold text-brand-dark">.........................................</p>
                    <p class="text-[11px] text-slate-500">{{ $client->brand_name }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Detail Paket Rental Mobil -->
    <div id="packageModal" class="fixed inset-0 bg-black/60 z-50 hidden items-center justify-center p-4 backdrop-blur-xs no-print">
        <div class="bg-white rounded-2xl max-w-lg w-full p-6 shadow-2xl relative animate-fade-in border border-slate-100">
            <button onclick="closePackageModal()" class="absolute top-4 right-4 w-8 h-8 rounded-full bg-slate-100 text-slate-500 hover:text-slate-800 hover:bg-slate-200 flex items-center justify-center transition">
                <i class="fas fa-times"></i>
            </button>

            <div class="flex items-center gap-3 mb-4">
                <div id="modalIcon" class="w-10 h-10 rounded-2xl bg-blue-100 text-brand-blue flex items-center justify-center text-lg">
                    <i class="fas fa-award"></i>
                </div>
                <div>
                    <h3 id="modalTitle" class="text-lg font-bold text-slate-800 font-heading">Detail Paket</h3>
                    <p id="modalPrice" class="text-xs font-bold text-brand-blue"></p>
                </div>
            </div>

            <p id="modalDesc" class="text-xs text-slate-600 mb-4 bg-slate-50 p-3 rounded-lg border border-slate-100"></p>

            <div class="mb-6">
                <h4 class="text-xs font-bold uppercase tracking-wider text-slate-700 mb-2.5">Fasilitas & Fitur Termasuk:</h4>
                <ul id="modalFeatures" class="space-y-2 text-xs text-slate-600">
                    <!-- Dynamic List -->
                </ul>
            </div>

            <div class="flex gap-3 pt-3 border-t border-slate-100">
                <button type="button" onclick="closePackageModal()" class="flex-1 py-2 px-4 rounded-xl border border-slate-200 text-slate-600 hover:bg-slate-50 text-xs font-semibold transition">
                    Tutup
                </button>
                <a id="modalWaBtn" href="#" target="_blank" class="flex-1 py-2 px-4 rounded-xl bg-brand-blue hover:bg-blue-800 text-white text-xs font-bold flex items-center justify-center gap-1.5 shadow transition">
                    <i class="fab fa-whatsapp text-sm text-green-400"></i> Pilih Paket Ini
                </a>
            </div>
        </div>
    </div>

    <script>
        const packageDetails = {
            silver: {
                title: 'Paket Silver'
                , price: '{{ \App\Models\ClientProposal::formatPackagePill($client->silver_price) }} (Perpanjangan {{ $client->silver_renewal }})'
                , desc: 'Landing page profil rental mobil responsif untuk menampilkan daftar armada dan memudahkan pelanggan booking via WhatsApp.'
                , features: [
                    'Website Landing Page Rental Mobil Modern (One-Page Showcase)'
                    , 'Katalog Armada Statis (Foto, Transmisi, Kursi & Tarif Sewa)'
                    , 'Profil Perusahaan, Legalitas, Syarat & Ketentuan Sewa'
                    , 'Tombol Cepat Booking via WhatsApp'
                    , 'Domain Kustom (.com / .id) + Cloud Server 1 Tahun'
                    , 'Garansi Teknis 1 Bulan'
                ]
            }
            , gold: {
                title: 'Paket Gold (Paling Populer)'
                , price: '{{ \App\Models\ClientProposal::formatPackagePill($client->gold_price) }} (Perpanjangan {{ $client->gold_renewal }})'
                , desc: 'Website company profile dengan sistem manajemen armada mandiri (CMS) untuk update ketersediaan dan harga sewa lepas kunci / supir kapan saja.'
                , features: [
                    'Website Company Profile + Panel Admin CMS Kelola Armada'
                    , 'Kelola Mobil: Tambah/Edit Mobil, Foto, Tarif Lepas Kunci & All-In Supir'
                    , 'Formulir Booking Online Terstruktur (Pilihan Tanggal & Lokasi Antar/Jemput)'
                    , 'Filter Armada Berdasarkan Tipe (City Car, MPV, SUV, Luxury Car)'
                    , 'Integrasi WhatsApp Notifikasi Otomatis ke Admin Rental'
                    , 'Domain Kustom + Cloud Server SSD Cepat 1 Tahun + SSL'
                    , 'Garansi & Support 3 Bulan'
                ]
            }
            , diamond: {
                title: 'Paket Diamond'
                , price: '{{ \App\Models\ClientProposal::formatPackagePill($client->diamond_price) }} (Perpanjangan {{ $client->diamond_renewal }})'
                , desc: 'Dilengkapi Live Calendar Ketersediaan Mobil (Anti Double-Booking), formulir e-KYC digital unggah KTP/SIM, dan Payment Gateway DP otomatis.'
                , features: [
                    'Semua Fasilitas Unggulan Paket Gold'
                    , 'Live Calendar Ketersediaan Armada Real-Time (Mencegah Double Booking)'
                    , 'Formulir e-KYC Digital Aman (Unggah KTP, SIM & Dokumen Jaminan)'
                    , 'Payment Gateway Otomatis (Pembayaran DP / Lunas via QRIS & VA Bank)'
                    , 'Sistem Cetak Surat Perjanjian Sewa / Invoice Digital Otomatis PDF'
                    , 'Garansi & Maintenance Prioritas 6 Bulan'
                ]
            }
            , platinum: {
                title: 'Paket Platinum (Sistem Manajemen Armada Penuh)'
                , price: '{{ \App\Models\ClientProposal::formatPackagePill($client->platinum_price) }} (Perpanjangan {{ $client->platinum_renewal }})'
                , desc: 'Sistem operasional rental mobil terlengkap: Dashboard utilisasi armada, form inspeksi digital (Check-in/Check-out + Tanda Tangan Digital), dan jadwal driver.'
                , features: [
                    'Semua Fasilitas Lengkap Paket Diamond'
                    , 'Dashboard Utilisasi Armada (Monitoring Mobil Disewa, Standby & Servis)'
                    , 'Inspeksi Digital (Check-in/Check-out Bensin & Goresan + e-Sign Pelanggan)'
                    , 'Modul Manajemen Penugasan Supir (Driver Scheduling)'
                    , 'Pengingat Otomatis Servis Rutin, Ganti Oli, & Pajak Kendaraan'
                    , 'Desain 100% Kustom Mewah sesuai Identitas Brand Rental'
                    , 'Dedicated Cloud Server Performa Tinggi & VIP Support 1 Tahun'
                ]
            }
        };

        function openPackageModal(type) {
            const data = packageDetails[type];
            if (!data) return;

            document.getElementById('modalTitle').textContent = data.title;
            document.getElementById('modalPrice').textContent = data.price;
            document.getElementById('modalDesc').textContent = data.desc;

            const list = document.getElementById('modalFeatures');
            list.innerHTML = '';
            data.features.forEach(feat => {
                const li = document.createElement('li');
                li.className = 'flex items-start gap-2';
                li.innerHTML = '<i class="fas fa-check-circle text-brand-blue mt-0.5 shrink-0"></i> <span>' + feat + '</span>';
                list.appendChild(li);
            });

            const waText = encodeURIComponent('Halo Scalify, saya ingin berkonsultasi mengenai ' + data.title + ' untuk {{ $client->brand_name }}. Mohon info selengkapnya.');
            document.getElementById('modalWaBtn').href = 'https://wa.me/{{ $cleanWa }}?text=' + waText;

            const modal = document.getElementById('packageModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closePackageModal() {
            const modal = document.getElementById('packageModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        window.onclick = function(event) {
            const modal = document.getElementById('packageModal');
            if (event.target === modal) {
                closePackageModal();
            }
        };

    </script>

</body>
</html>
