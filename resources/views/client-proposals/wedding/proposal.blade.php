<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Meta Tags untuk Preview Link (WhatsApp, Telegram, dsb) -->
    <title>Proposal Proyek Website - {{ $client->brand_name }}</title>
    <meta name="description" content="Proposal pengajuan pengembangan sistem dan website custom untuk {{ $client->brand_name }} oleh Scalify Intelligence.">

    <!-- Open Graph / Facebook / WhatsApp -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="Proposal Proyek Website - {{ $client->brand_name }}">
    <meta property="og:description" content="Proposal pengajuan pengembangan sistem dan website custom untuk {{ $client->brand_name }} oleh Scalify Intelligence.">
    <!-- Gambar yang akan muncul di link (Rekomendasi ukuran: 1200x630px) -->
    <meta property="og:image" content="{{ asset('images/agency-cover.jpg') }}">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ url()->current() }}">
    <meta property="twitter:title" content="Proposal Proyek Website - {{ $client->brand_name }}">
    <meta property="twitter:description" content="Proposal pengajuan pengembangan sistem dan website custom untuk {{ $client->brand_name }} oleh Scalify Intelligence.">
    <meta property="twitter:image" content="{{ asset('images/agency-cover.jpg') }}">

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        gold: '#C59A6F'
                        , dark: '#1a1a1a'
                    }
                }
            }
        }

    </script>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;600;700&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body {
            background-color: #f3f4f6;
            font-family: 'Inter', sans-serif;
            color: #374151;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        .font-serif {
            font-family: 'Playfair Display', serif;
        }

        /* A4 styling for Web View */
        .proposal-page {
            max-width: 210mm;
            min-height: 297mm;
            margin: 2rem auto;
            background: white;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
            padding: 3rem 4rem;
            position: relative;
        }

        /* Print Settings for PDF Generation */
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
        <button onclick="window.print()" class="bg-dark hover:bg-gray-800 text-white px-6 py-3 rounded-full shadow-lg font-medium flex items-center gap-2 transition">
            <i class="fas fa-file-pdf"></i>
            Simpan sebagai PDF
        </button>
    </div>

    <!-- ==============================================
         HALAMAN 1: COVER & PENDAHULUAN
         ============================================== -->
    <div class="proposal-page">
        <!-- Cover Header -->
        <div class="border-b-2 border-gold pb-8 mb-10 mt-10">
            <div class="flex justify-between items-end">
                <div>
                    <p class="text-gold font-semibold tracking-widest text-sm mb-2 uppercase">Proposal Proyek</p>
                    <h1 class="font-serif text-4xl font-bold text-dark leading-tight">Pengembangan Website<br>Company Profile & Katalog</h1>
                </div>
                <div class="text-right">
                    <div class="w-12 h-12 rounded-full border-2 border-gold flex items-center justify-center text-gold font-serif text-2xl ml-auto mb-2">P</div>
                    <p class="font-bold text-dark text-lg">{{ $client->brand_name }}</p>
                    <p class="text-sm text-gray-500">{{ date('d F Y') }}</p>
                </div>
            </div>
        </div>

        <!-- Disiapkan oleh -->
        <div class="mb-12 flex justify-between text-sm">
            <div>
                <p class="text-gray-400 mb-1">Disiapkan untuk:</p>
                <p class="font-bold text-gray-800 text-base">{{ $client->client_name ?? $client->brand_name }}</p>
                <p class="text-gray-600">Jakarta, Indonesia</p>
            </div>
            <div class="text-right">
                <p class="text-gray-400 mb-1">Disiapkan oleh:</p>
                <p class="font-bold text-gray-800 text-base">Scalify Intelligence</p>
                <p class="text-gray-600">Web Development Agency</p>
            </div>
        </div>

        <!-- 1. Pendahuluan -->
        <div class="mb-10">
            <h2 class="font-serif text-2xl font-bold text-dark mb-4 flex items-center gap-2">
                <span class="text-gold">01.</span> Pendahuluan
            </h2>
            <p class="text-gray-600 leading-relaxed text-sm text-justify mb-4">
                Dalam era digital saat ini, kehadiran online yang profesional sangatlah krusial bagi industri pernikahan (Wedding Organizer). Calon pengantin modern melakukan riset mendalam melalui internet sebelum memutuskan vendor pernikahan mereka. Website yang elegan, informatif, dan responsif tidak hanya berfungsi sebagai brosur digital, melainkan juga sebagai alat utama untuk membangun kepercayaan (trust) dan menampilkan portofolio kualitas layanan.
            </p>
            <p class="text-gray-600 leading-relaxed text-sm text-justify">
                Proposal ini menjabarkan rencana pengembangan website <strong>{{ $client->brand_name }}</strong>. Website ini akan dirancang dengan estetika mewah (luxury design), menonjolkan galeri dekorasi & makeup, merinci paket pernikahan yang ditawarkan, serta mengintegrasikan sistem kontak yang memudahkan calon klien untuk segera berkonsultasi.
            </p>

            <!-- Link Demo Draft Landing Page -->
            <div class="mt-6 bg-[#C59A6F]/10 border border-gold/30 rounded-lg p-5 flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <h3 class="font-bold text-gray-800 text-sm mb-1 flex items-center gap-2">
                        <i class="fas fa-desktop text-gold"></i> Preview Draft Landing Page
                    </h3>
                    <p class="text-[13px] text-gray-700">Sebagai gambaran dan referensi visual awal, kami telah menyiapkan kerangka desain (draft) landing page yang bisa Anda lihat langsung pada tautan berikut.</p>
                    <div class="hidden print:block text-[13px] font-medium text-blue-600 break-all mt-2 underline">
                        {{ route("landing.dynamic", $client->slug) }}
                    </div>
                </div>
                <a href="{{ route("landing.dynamic", $client->slug) }}" target="_blank" class="shrink-0 bg-dark hover:bg-gray-800 text-white px-5 py-2.5 rounded-full text-[13px] font-medium transition inline-flex items-center justify-center gap-2 no-print shadow-md">
                    Lihat Demo Web <i class="fas fa-external-link-alt text-[10px]"></i>
                </a>
            </div>
        </div>

        <!-- 2. Tujuan & Objektif -->
        <div class="mb-10">
            <h2 class="font-serif text-2xl font-bold text-dark mb-4 flex items-center gap-2">
                <span class="text-gold">02.</span> Objektif Proyek
            </h2>
            <ul class="space-y-3 text-sm text-gray-600">
                <li class="flex items-start gap-3">
                    <i class="fas fa-check text-gold mt-1"></i>
                    <span><strong>Meningkatkan Kredibilitas:</strong> Menghadirkan citra {{ $client->brand_name }} sebagai WO profesional & eksklusif.</span>
                </li>
                <li class="flex items-start gap-3">
                    <i class="fas fa-check text-gold mt-1"></i>
                    <span><strong>Showcase Portofolio:</strong> Memudahkan calon klien melihat hasil dekorasi, riasan, dan dokumentasi secara rapi & beresolusi tinggi.</span>
                </li>
                <li class="flex items-start gap-3">
                    <i class="fas fa-check text-gold mt-1"></i>
                    <span><strong>Informasi Paket Terstruktur:</strong> Calon klien dapat membandingkan paket layanan dengan transparan.</span>
                </li>
                <li class="flex items-start gap-3">
                    <i class="fas fa-check text-gold mt-1"></i>
                    <span><strong>Lead Generation:</strong> Mempermudah konversi pengunjung menjadi klien lewat tombol integrasi WhatsApp (Call to Action).</span>
                </li>
            </ul>
        </div>
    </div>


    <!-- ==============================================
         HALAMAN 2: FITUR & TIMELINE
         ============================================== -->
    <div class="proposal-page page-break">
        <!-- 3. Ruang Lingkup & Fitur -->
        <div class="mb-10 mt-6">
            <h2 class="font-serif text-2xl font-bold text-dark mb-6 flex items-center gap-2">
                <span class="text-gold">03.</span> Ruang Lingkup & Fitur Website
            </h2>

            <p class="text-sm text-gray-600 mb-6">Website ini akan dirancang agar tidak hanya tampil memukau secara visual, tetapi juga sangat cepat saat diakses dan aman dari kendala gangguan. Berikut adalah ringkasan fitur-fitur unggulan yang akan Anda dapatkan:</p>

            <div class="grid grid-cols-2 gap-6 mb-6">
                <!-- Fitur Utama -->
                <div class="bg-gray-50 p-5 rounded-lg border border-gray-100">
                    <h3 class="font-bold text-gray-800 mb-3 text-sm">Tampilan Utama untuk Calon Klien</h3>
                    <ul class="space-y-2 text-[13px] text-gray-600">
                        <li><i class="fas fa-angle-right text-gold w-4"></i> <strong>Halaman Awal Memikat:</strong> Desain layar pertama yang mewah untuk meyakinkan klien sejak detik pertama.</li>
                        <li><i class="fas fa-angle-right text-gold w-4"></i> <strong>Buku Portofolio:</strong> Album foto panggung, dekorasi, dan riasan yang tertata rapi selayaknya majalah pernikahan.</li>
                        <li><i class="fas fa-angle-right text-gold w-4"></i> <strong>Daftar Paket Jelas:</strong> Rincian harga dan layanan paket yang disusun agar mudah dipahami calon pengantin.</li>
                        <li><i class="fas fa-angle-right text-gold w-4"></i> <strong>Tombol Langsung WhatsApp:</strong> Memudahkan pengunjung untuk langsung chat atau konsultasi dengan tim Anda.</li>
                    </ul>
                </div>

                <!-- Fitur Admin -->
                <div class="bg-gray-50 p-5 rounded-lg border border-gray-100">
                    <h3 class="font-bold text-gray-800 mb-3 text-sm">Ruang Kerja Pengelola (Admin)</h3>
                    <ul class="space-y-2 text-[13px] text-gray-600">
                        <li><i class="fas fa-angle-right text-gold w-4"></i> <strong>Akses Khusus & Aman:</strong> Ruang kerja digital yang hanya bisa dibuka dengan password oleh staf internal Anda.</li>
                        <li><i class="fas fa-angle-right text-gold w-4"></i> <strong>Update Mandiri Tanpa Ribet:</strong> Anda bebas mengganti foto, mengubah harga, atau menambah ulasan baru semudah bermain sosial media (tanpa perlu paham coding).</li>
                        <li><i class="fas fa-angle-right text-gold w-4"></i> <strong>Tampil Rapi di Layar HP:</strong> Tampilan web akan menyesuaikan secara otomatis saat dibuka lewat handphone calon klien.</li>
                    </ul>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-6">
                <!-- Fitur Eksekutif Owner & Surveyor -->
                <div class="bg-gray-50 p-5 rounded-lg border border-gray-100 border-l-4 border-l-gold">
                    <h3 class="font-bold text-gray-800 mb-3 text-sm">Fitur Khusus Pemilik & Tim Lapangan</h3>
                    <ul class="space-y-2 text-[13px] text-gray-600">
                        <li><i class="fas fa-map-marked-alt text-gold w-4"></i> <strong>Hitung Jarak Lokasi Acara:</strong> Cukup masukkan alamat venue acara, sistem akan otomatis menghitung jarak dari gudang untuk mempermudah penentuan ongkos angkut barang.</li>
                        <li><i class="fas fa-chart-line text-gold w-4"></i> <strong>Laporan Keuangan Ringkas:</strong> Pantau tren jumlah klien, pendapatan proyek, dan status penyelesaian acara dari satu layar.</li>
                        <li><i class="fas fa-boxes text-gold w-4"></i> <strong>Kalender Pintar Anti Bentrok:</strong> Anda bisa melihat ketersediaan tim (siapa yang tugas) dan alat/dekor mana yang sedang dipakai di tanggal tertentu.</li>
                    </ul>
                </div>

                <!-- Portal Klien & Nilai Tambah -->
                <div class="bg-gray-50 p-5 rounded-lg border border-gray-100 border-l-4 border-l-gold">
                    <h3 class="font-bold text-gray-800 mb-3 text-sm">Area Khusus Klien & Layanan Ekstra</h3>
                    <ul class="space-y-2 text-[13px] text-gray-600">
                        <li><i class="fas fa-user-circle text-gold w-4"></i> <strong>Halaman Pantau Klien:</strong> Calon pengantin bisa "masuk" ke akun khusus mereka untuk mengecek ulang paket yang dipesan dan melihat sejauh mana persiapannya.</li>
                        <li><i class="fas fa-envelope-open-text text-gold w-4"></i> <strong>Bonus Undangan Online:</strong> Sebagai bonus, Anda bisa membuatkan undangan digital canggih untuk klien langsung dari sistem ini secara cepat.</li>
                        <li><i class="fas fa-file-invoice text-gold w-4"></i> <strong>Sistem Tagihan Pintar:</strong> Mencatat dengan rapi klien mana yang baru bayar DP (Down Payment) dan mana yang sudah lunas.</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- 4. Timeline Pengerjaan -->
        <div class="mb-10">
            <h2 class="font-serif text-2xl font-bold text-dark mb-6 flex items-center gap-2">
                <span class="text-gold">04.</span> Estimasi Waktu Pengerjaan (Timeline)
            </h2>
            <p class="text-sm text-gray-600 mb-6">Total waktu pengerjaan diperkirakan memakan waktu <strong>1 hingga 2 Bulan (4 - 8 Minggu)</strong>, dengan rincian tahapan sebagai berikut:</p>

            <div class="relative border-l-2 border-gold/30 ml-3 space-y-6">
                <!-- Fase 1 -->
                <div class="relative pl-6">
                    <div class="absolute w-4 h-4 bg-gold rounded-full -left-[9px] top-1 border-4 border-white"></div>
                    <h4 class="font-bold text-gray-800 text-sm">Fase 1: Riset & Desain UI/UX <span class="text-gold font-normal ml-2">(Minggu 1 - 2)</span></h4>
                    <p class="text-[13px] text-gray-600 mt-1">Pengumpulan aset (foto, logo, teks profil), riset kompetitor, pembuatan wireframe, dan persetujuan desain visual (mockup) halaman utama.</p>
                </div>
                <!-- Fase 2 -->
                <div class="relative pl-6">
                    <div class="absolute w-4 h-4 bg-gold rounded-full -left-[9px] top-1 border-4 border-white"></div>
                    <h4 class="font-bold text-gray-800 text-sm">Fase 2: Web Development & CMS <span class="text-gold font-normal ml-2">(Minggu 3 - 5)</span></h4>
                    <p class="text-[13px] text-gray-600 mt-1">Menerjemahkan desain menjadi kode (HTML/Tailwind), membangun sistem database, backend (Laravel), dan integrasi panel admin (CMS).</p>
                </div>
                <!-- Fase 3 -->
                <div class="relative pl-6">
                    <div class="absolute w-4 h-4 bg-gold rounded-full -left-[9px] top-1 border-4 border-white"></div>
                    <h4 class="font-bold text-gray-800 text-sm">Fase 3: Input Konten & Quality Assurance <span class="text-gold font-normal ml-2">(Minggu 6 - 7)</span></h4>
                    <p class="text-[13px] text-gray-600 mt-1">Memasukkan seluruh foto portofolio, detail paket, pengecekan bugs, uji coba form, optimasi gambar (WebP), dan uji responsivitas di berbagai perangkat.</p>
                </div>
                <!-- Fase 4 -->
                <div class="relative pl-6">
                    <div class="absolute w-4 h-4 bg-gold rounded-full -left-[9px] top-1 border-4 border-white"></div>
                    <h4 class="font-bold text-gray-800 text-sm">Fase 4: Finalisasi & Deployment <span class="text-gold font-normal ml-2">(Minggu 8)</span></h4>
                    <p class="text-[13px] text-gray-600 mt-1">Revisi final dari pihak {{ $client->brand_name }} (jika ada), setup domain & hosting, website live ke internet, dan serah terima (training penggunaan CMS).</p>
                </div>
            </div>
        </div>
    </div>


    <!-- ==============================================
         HALAMAN 3: BIAYA & PENUTUP
         ============================================== -->
    <!-- ==============================================
         HALAMAN 3: BIAYA & PENUTUP
         ============================================== -->
    <div class="proposal-page page-break">
        <!-- 5. Pilihan Paket & Investasi -->
        <div class="mb-8 mt-2">
            <h2 class="font-serif text-2xl font-bold text-dark mb-2 flex items-center gap-2">
                <span class="text-gold">05.</span> Pilihan Paket & Rincian Investasi
            </h2>
            <p class="text-sm text-gray-600 mb-6">Kami menyediakan beberapa pilihan paket fleksibel yang dapat disesuaikan dengan skala dan kebutuhan digitalisasi <strong>{{ $client->brand_name }}</strong>:</p>

            @php
            $cleanWa = preg_replace('/[^0-9]/', '', $client->wa_number ?? '6281234567890');
            if (str_starts_with($cleanWa, '0')) {
            $cleanWa = '62' . substr($cleanWa, 1);
            }
            @endphp

            <!-- Tabel Perbandingan Paket & Fitur Wedding Organizer -->
            <div class="overflow-x-auto mb-6 rounded-xl border border-gold/40 bg-white shadow-xs">
                <table class="w-full text-left border-collapse text-[11px]">
                    <thead>
                        <tr class="border-b border-gold/30">
                            <th class="p-3.5 bg-dark text-gold font-serif font-bold w-[32%]">
                                <span class="text-[10px] uppercase tracking-widest block text-gray-400 font-sans">Komparasi Layanan</span>
                                Paket Wedding Organizer & Fitur
                            </th>
                            <!-- Silver -->
                            <th class="p-3 text-center bg-[#faf8f5] border-l border-gold/20 w-[17%]">
                                <span class="font-serif font-bold text-sm text-dark block">Silver</span>
                                <span class="inline-block my-1 py-0.5 px-2 rounded-full border border-gold/50 bg-white text-[10px] font-bold text-dark">
                                    {{ \App\Models\ClientProposal::formatPackagePill($client->silver_price) }}
                                </span>
                                <span class="block text-[9px] text-gray-500">Perpanjangan {{ $client->silver_renewal }}</span>
                            </th>
                            <!-- Gold (Featured) -->
                            <th class="p-3 text-center bg-[#2a2421] text-white border-x-2 border-gold w-[17%] relative">
                                <span class="absolute -top-2.5 left-1/2 -translate-x-1/2 bg-gold text-dark text-[8px] font-black uppercase tracking-widest px-2 py-0.2 rounded-full shadow-xs">POPULER</span>
                                <span class="font-serif font-bold text-sm text-gold block">Gold</span>
                                <span class="inline-block my-1 py-0.5 px-2 rounded-full border border-gold bg-black/40 text-[10px] font-bold text-gold">
                                    {{ \App\Models\ClientProposal::formatPackagePill($client->gold_price) }}
                                </span>
                                <span class="block text-[9px] text-[#c5b5aa]">Perpanjangan {{ $client->gold_renewal }}</span>
                            </th>
                            <!-- Diamond -->
                            <th class="p-3 text-center bg-[#faf8f5] border-l border-gold/20 w-[17%]">
                                <span class="font-serif font-bold text-sm text-dark block">Diamond</span>
                                <span class="inline-block my-1 py-0.5 px-2 rounded-full border border-gold/50 bg-white text-[10px] font-bold text-dark">
                                    {{ \App\Models\ClientProposal::formatPackagePill($client->diamond_price) }}
                                </span>
                                <span class="block text-[9px] text-gray-500">Perpanjangan {{ $client->diamond_renewal }}</span>
                            </th>
                            <!-- Platinum -->
                            <th class="p-3 text-center bg-[#faf8f5] border-l border-gold/20 w-[17%]">
                                <span class="font-serif font-bold text-sm text-dark block">Platinum</span>
                                <span class="inline-block my-1 py-0.5 px-2 rounded-full border border-gold/50 bg-white text-[10px] font-bold text-dark">
                                    {{ \App\Models\ClientProposal::formatPackagePill($client->platinum_price) }}
                                </span>
                                <span class="block text-[9px] text-gray-500">Perpanjangan {{ $client->platinum_renewal }}</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gold/15 text-gray-700">
                        <!-- GROUP 1: PORTOFOLIO & SHOWCASE PERNIKAHAN -->
                        <tr class="bg-gold/10">
                            <td colspan="5" class="py-1.5 px-3.5 font-bold uppercase tracking-wider text-[10px] text-dark">
                                <i class="fas fa-heart text-gold mr-1.5"></i> Desain Visual & Portofolio Wedding
                            </td>
                        </tr>
                        <tr>
                            <td class="p-2.5 font-medium">Tipe Desain & Presentasi Visual</td>
                            <td class="p-2.5 text-center bg-[#faf8f5]/40">One-Page Portofolio</td>
                            <td class="p-2.5 text-center bg-gold/10 font-semibold text-dark">Multi-Page Luxury + CMS</td>
                            <td class="p-2.5 text-center bg-[#faf8f5]/40 font-semibold">Portal Wedding Management</td>
                            <td class="p-2.5 text-center bg-[#faf8f5]/40 font-semibold">Enterprise Multi-Vendor WO</td>
                        </tr>
                        <tr>
                            <td class="p-2.5 font-medium">Galeri Portofolio Dokumentasi & Dekorasi</td>
                            <td class="p-2.5 text-center bg-[#faf8f5]/40">Galeri Pilihan</td>
                            <td class="p-2.5 text-center bg-gold/10 font-semibold text-dark"><i class="fas fa-check-circle text-gold text-sm"></i> Per Kategori (Dekor, MUA)</td>
                            <td class="p-2.5 text-center bg-[#faf8f5]/40 font-semibold"><i class="fas fa-check-circle text-gold text-sm"></i> Album Eksklusif HD</td>
                            <td class="p-2.5 text-center bg-[#faf8f5]/40 font-semibold"><i class="fas fa-check-circle text-gold text-sm"></i> Unlimited Album HD</td>
                        </tr>
                        <tr>
                            <td class="p-2.5 font-medium">Katalog Rincian Paket Pernikahan (CMS Update)</td>
                            <td class="p-2.5 text-center bg-[#faf8f5]/40">Daftar Statis</td>
                            <td class="p-2.5 text-center bg-gold/10 text-dark font-semibold"><i class="fas fa-check-circle text-gold text-sm"></i> CMS Mandiri</td>
                            <td class="p-2.5 text-center bg-[#faf8f5]/40 text-dark font-semibold"><i class="fas fa-check-circle text-gold text-sm"></i> CMS Mandiri</td>
                            <td class="p-2.5 text-center bg-[#faf8f5]/40 text-dark font-semibold"><i class="fas fa-check-circle text-gold text-sm"></i> Kustom Paket Builder</td>
                        </tr>
                        <tr>
                            <td class="p-2.5 font-medium">Form Konsultasi & Cek Ketersediaan Tanggal</td>
                            <td class="p-2.5 text-center bg-[#faf8f5]/40">WhatsApp Direct</td>
                            <td class="p-2.5 text-center bg-gold/10 text-dark font-semibold"><i class="fas fa-check-circle text-gold text-sm"></i> Form Tanggal Acara</td>
                            <td class="p-2.5 text-center bg-[#faf8f5]/40 text-dark font-semibold"><i class="fas fa-check-circle text-gold text-sm"></i> Form Tanggal Acara</td>
                            <td class="p-2.5 text-center bg-[#faf8f5]/40 text-dark font-semibold"><i class="fas fa-check-circle text-gold text-sm"></i> Form Tanggal Acara</td>
                        </tr>

                        <!-- GROUP 2: FITUR KHUSUS PENGANTIN & OPERASIONAL WO -->
                        <tr class="bg-gold/10">
                            <td colspan="5" class="py-1.5 px-3.5 font-bold uppercase tracking-wider text-[10px] text-dark">
                                <i class="fas fa-ring text-gold mr-1.5"></i> Fitur Calon Pengantin & Manajemen WO
                            </td>
                        </tr>
                        <tr>
                            <td class="p-2.5 font-medium">Bonus Undangan Digital Online untuk Klien WO</td>
                            <td class="p-2.5 text-center bg-[#faf8f5]/40 text-gray-300 font-bold">—</td>
                            <td class="p-2.5 text-center bg-gold/10 text-dark font-semibold"><i class="fas fa-check-circle text-gold text-sm"></i> Bonus Template</td>
                            <td class="p-2.5 text-center bg-[#faf8f5]/40 text-dark font-semibold"><i class="fas fa-check-circle text-gold text-sm"></i> Unlimited + QR Check-in</td>
                            <td class="p-2.5 text-center bg-[#faf8f5]/40 text-dark font-semibold"><i class="fas fa-check-circle text-gold text-sm"></i> Unlimited + Buku Tamu QR</td>
                        </tr>
                        <tr>
                            <td class="p-2.5 font-medium">Portal Khusus Klien (Dashboard Pantau Progres Acara)</td>
                            <td class="p-2.5 text-center bg-[#faf8f5]/40 text-gray-300 font-bold">—</td>
                            <td class="p-2.5 text-center bg-gold/10 text-gray-300 font-bold">—</td>
                            <td class="p-2.5 text-center bg-[#faf8f5]/40 font-semibold text-dark"><i class="fas fa-check-circle text-gold text-sm"></i> Client Dashboard</td>
                            <td class="p-2.5 text-center bg-[#faf8f5]/40 font-semibold text-dark"><i class="fas fa-check-circle text-gold text-sm"></i> Client Dashboard VIP</td>
                        </tr>
                        <tr>
                            <td class="p-2.5 font-medium">Kalkulator Jarak Venue Google Maps (Hitung Logistik)</td>
                            <td class="p-2.5 text-center bg-[#faf8f5]/40 text-gray-300 font-bold">—</td>
                            <td class="p-2.5 text-center bg-gold/10 text-gray-300 font-bold">—</td>
                            <td class="p-2.5 text-center bg-[#faf8f5]/40 font-semibold text-dark"><i class="fas fa-check-circle text-gold text-sm"></i> Surveyor Maps Auto</td>
                            <td class="p-2.5 text-center bg-[#faf8f5]/40 font-semibold text-dark"><i class="fas fa-check-circle text-gold text-sm"></i> Surveyor Maps Auto</td>
                        </tr>
                        <tr>
                            <td class="p-2.5 font-medium">Kalender Pintar Anti-Bentrok Tim Crew & Alat Dekor</td>
                            <td class="p-2.5 text-center bg-[#faf8f5]/40 text-gray-300 font-bold">—</td>
                            <td class="p-2.5 text-center bg-gold/10 text-gray-300 font-bold">—</td>
                            <td class="p-2.5 text-center bg-[#faf8f5]/40 font-semibold text-dark"><i class="fas fa-check-circle text-gold text-sm"></i> Kalender Jadwal WO</td>
                            <td class="p-2.5 text-center bg-[#faf8f5]/40 font-semibold text-dark"><i class="fas fa-check-circle text-gold text-sm"></i> Kalender Jadwal WO</td>
                        </tr>
                        <tr>
                            <td class="p-2.5 font-medium">Sistem Pencatatan Pembayaran Tagihan (DP / Lunas)</td>
                            <td class="p-2.5 text-center bg-[#faf8f5]/40 text-gray-300 font-bold">—</td>
                            <td class="p-2.5 text-center bg-gold/10 text-gray-300 font-bold">—</td>
                            <td class="p-2.5 text-center bg-[#faf8f5]/40 font-semibold text-dark"><i class="fas fa-check-circle text-gold text-sm"></i> Catat Invoice Digital</td>
                            <td class="p-2.5 text-center bg-[#faf8f5]/40 font-semibold text-dark"><i class="fas fa-check-circle text-gold text-sm"></i> Auto-Invoice & Kwitansi PDF</td>
                        </tr>
                        <tr>
                            <td class="p-2.5 font-medium">Sistem Manajemen Multi-Vendor & Crew Lapangan</td>
                            <td class="p-2.5 text-center bg-[#faf8f5]/40 text-gray-300 font-bold">—</td>
                            <td class="p-2.5 text-center bg-gold/10 text-gray-300 font-bold">—</td>
                            <td class="p-2.5 text-center bg-[#faf8f5]/40 text-gray-300 font-bold">—</td>
                            <td class="p-2.5 text-center bg-[#faf8f5]/40 font-bold text-dark"><i class="fas fa-check-circle text-gold text-sm"></i> Vendor & Crew Manager</td>
                        </tr>

                        <!-- GROUP 3: SERVER & GARANSI -->
                        <tr class="bg-gold/10">
                            <td colspan="5" class="py-1.5 px-3.5 font-bold uppercase tracking-wider text-[10px] text-dark">
                                <i class="fas fa-shield-alt text-gold mr-1.5"></i> Infrastruktur Server & Layanan Garansi
                            </td>
                        </tr>
                        <tr>
                            <td class="p-2.5 font-medium">Domain Kustom (.com / .id) & Cloud Hosting SSD</td>
                            <td class="p-2.5 text-center bg-[#faf8f5]/40">1 Tahun</td>
                            <td class="p-2.5 text-center bg-gold/10 font-semibold text-dark">1 Tahun Cloud SSD</td>
                            <td class="p-2.5 text-center bg-[#faf8f5]/40 font-semibold">1 Tahun High-Speed SSD</td>
                            <td class="p-2.5 text-center bg-[#faf8f5]/40 font-semibold text-dark">Dedicated Cloud Server</td>
                        </tr>
                        <tr>
                            <td class="p-2.5 font-medium">Garansi Teknis & Pemeliharaan Sistem</td>
                            <td class="p-2.5 text-center bg-[#faf8f5]/40">1 Bulan</td>
                            <td class="p-2.5 text-center bg-gold/10 font-semibold text-dark">3 Bulan</td>
                            <td class="p-2.5 text-center bg-[#faf8f5]/40 font-semibold">6 Bulan Prioritas</td>
                            <td class="p-2.5 text-center bg-[#faf8f5]/40 font-bold text-dark">1 Tahun Penuh (VIP)</td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr class="border-t-2 border-gold/40 bg-white">
                            <td class="p-3 font-bold text-dark">Aksi Pemesanan</td>
                            <td class="p-2.5 text-center bg-[#faf8f5]/50">
                                <a href="https://wa.me/{{ $cleanWa }}?text={{ urlencode('Halo Scalify, saya tertarik memesan Paket Silver untuk ' . $client->brand_name . '. Mohon info detailnya.') }}" target="_blank" class="inline-flex items-center justify-center gap-1 w-full py-1.5 px-2 rounded-lg bg-dark hover:bg-gray-800 text-gold text-[10px] font-bold shadow-xs transition no-print border border-gold/30">
                                    <i class="fab fa-whatsapp text-green-400"></i> Pilih Silver
                                </a>
                            </td>
                            <td class="p-2.5 text-center bg-gold/15">
                                <a href="https://wa.me/{{ $cleanWa }}?text={{ urlencode('Halo Scalify, saya tertarik memesan Paket Gold untuk ' . $client->brand_name . '. Mohon info detailnya.') }}" target="_blank" class="inline-flex items-center justify-center gap-1 w-full py-2 px-2 rounded-lg bg-gold hover:bg-[#b0885e] text-dark text-[11px] font-extrabold shadow-md transition no-print">
                                    <i class="fab fa-whatsapp text-dark"></i> Pilih Gold
                                </a>
                            </td>
                            <td class="p-2.5 text-center bg-[#faf8f5]/50">
                                <a href="https://wa.me/{{ $cleanWa }}?text={{ urlencode('Halo Scalify, saya tertarik memesan Paket Diamond untuk ' . $client->brand_name . '. Mohon info detailnya.') }}" target="_blank" class="inline-flex items-center justify-center gap-1 w-full py-1.5 px-2 rounded-lg bg-dark hover:bg-gray-800 text-gold text-[10px] font-bold shadow-xs transition no-print border border-gold/30">
                                    <i class="fab fa-whatsapp text-green-400"></i> Pilih Diamond
                                </a>
                            </td>
                            <td class="p-2.5 text-center bg-[#faf8f5]/50">
                                <a href="https://wa.me/{{ $cleanWa }}?text={{ urlencode('Halo Scalify, saya tertarik memesan Paket Platinum untuk ' . $client->brand_name . '. Mohon info detailnya.') }}" target="_blank" class="inline-flex items-center justify-center gap-1 w-full py-1.5 px-2 rounded-lg bg-dark hover:bg-gray-800 text-gold text-[10px] font-bold shadow-xs transition no-print border border-gold/30">
                                    <i class="fab fa-whatsapp text-green-400"></i> Pilih Platinum
                                </a>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <!-- Catatan Fleksibilitas -->
            <div class="bg-[#C59A6F]/10 border-l-4 border-gold rounded-r-lg p-3.5 mb-6">
                <div class="flex items-start gap-3">
                    <i class="fas fa-handshake text-gold mt-1 text-base"></i>
                    <div>
                        <h4 class="font-bold text-gray-800 text-xs mb-0.5">Penyesuaian Fleksibel (Negotiable)</h4>
                        <p class="text-[12px] text-gray-700 leading-relaxed">
                            Spesifikasi fitur dan rincian harga di atas bersifat usulan standar. Kami sangat terbuka untuk berdiskusi lebih lanjut dan melakukan kustomisasi fitur maupun penyesuaian termin pembayaran agar selaras dengan target budget <strong>{{ $client->brand_name }}</strong>.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- 6. Syarat & Ketentuan -->
        <div class="mb-8">
            <h2 class="font-serif text-2xl font-bold text-dark mb-3 flex items-center gap-2">
                <span class="text-gold">06.</span> Syarat Ketentuan & Layanan Lanjutan
            </h2>
            <ul class="space-y-2 text-xs text-gray-600 list-disc pl-5">
                <li>Pembayaran <strong>Down Payment (DP) 50%</strong> dilakukan sebelum tahap pengembangan sistem dimulai (Termin 1).</li>
                <li>Pembayaran <strong>Pelunasan 50%</strong> dilakukan setelah sistem & website selesai, diverifikasi, dan siap online (Termin 2).</li>
                <li>Masa garansi dan <i>free maintenance</i> (perbaikan bug/error) berlaku gratis selama <strong>3 Bulan</strong> pertama sejak website live.</li>
                <li><strong>Biaya Perpanjangan (Tahun Ke-2 dst):</strong> Sudah mencakup perpanjangan Nama Domain resmi, Cloud Hosting Server kecepatan tinggi, dan sertifikat keamanan SSL HTTPS.</li>
            </ul>
        </div>

        <!-- 7. Penutup -->
        <div class="mt-8 border-t border-gray-200 pt-6 text-xs text-gray-600">
            <p class="mb-4 leading-relaxed">
                Demikian proposal penawaran pembuatan website ini kami sampaikan. Kami berharap dapat menjadi mitra digital yang solid bagi kesuksesan <strong>{{ $client->brand_name }}</strong> ke depannya.
            </p>

            <div class="flex justify-between items-end mt-8">
                <div class="text-center">
                    <p class="mb-14">Hormat Kami,</p>
                    <div class="border-b border-gray-400 w-44 mb-1 mx-auto"></div>
                    <p class="font-bold text-gray-800">M. Andi</p>
                    <p class="text-[11px] text-gray-500">Project Manager - Scalify</p>
                </div>
                <div class="text-center">
                    <p class="mb-14">Disetujui Oleh,</p>
                    <div class="border-b border-gray-400 w-44 mb-1 mx-auto"></div>
                    <p class="font-bold text-gray-800">.........................................</p>
                    <p class="text-[11px] text-gray-500">{{ $client->brand_name }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Detail Paket -->
    <div id="packageModal" class="fixed inset-0 bg-black/60 z-50 hidden items-center justify-center p-4 backdrop-blur-xs no-print">
        <div class="bg-white rounded-2xl max-w-lg w-full p-6 shadow-2xl relative animate-fade-in border border-gold/30">
            <button onclick="closePackageModal()" class="absolute top-4 right-4 w-8 h-8 rounded-full bg-slate-100 text-slate-500 hover:text-slate-800 hover:bg-slate-200 flex items-center justify-center transition">
                <i class="fas fa-times"></i>
            </button>

            <div class="flex items-center gap-3 mb-4">
                <div id="modalIcon" class="w-10 h-10 rounded-full bg-gold/20 border border-gold/50 text-gold flex items-center justify-center text-lg">
                    <i class="fas fa-award"></i>
                </div>
                <div>
                    <h3 id="modalTitle" class="text-lg font-bold text-dark font-serif">Detail Paket</h3>
                    <p id="modalPrice" class="text-xs font-bold text-gold"></p>
                </div>
            </div>

            <p id="modalDesc" class="text-xs text-gray-600 mb-4 bg-[#faf8f5] p-3 rounded-lg border border-gold/20"></p>

            <div class="mb-6">
                <h4 class="text-xs font-bold uppercase tracking-wider text-dark mb-2.5">Fasilitas & Fitur Termasuk:</h4>
                <ul id="modalFeatures" class="space-y-2 text-xs text-gray-600">
                    <!-- Dynamic List -->
                </ul>
            </div>

            <div class="flex gap-3 pt-3 border-t border-gray-100">
                <button type="button" onclick="closePackageModal()" class="flex-1 py-2 px-4 rounded-xl border border-slate-200 text-slate-600 hover:bg-slate-50 text-xs font-semibold transition">
                    Tutup
                </button>
                <a id="modalWaBtn" href="#" target="_blank" class="flex-1 py-2 px-4 rounded-xl bg-dark hover:bg-gray-800 text-gold text-xs font-bold flex items-center justify-center gap-1.5 shadow transition border border-gold/40">
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
                , desc: 'Paket starter yang ideal untuk membangun kehadiran digital resmi Wedding Organizer dengan budget hemat dan proses cepat.'
                , features: [
                    'Website Portofolio & Brosur Digital Modern (One-Page)'
                    , 'Galeri Foto Dokumentasi & Dekorasi Pilihan'
                    , 'Daftar Paket Pernikahan Standar'
                    , 'Tombol Direct Konsultasi WhatsApp Cepat'
                    , 'Domain Kustom (.com / .id) & Cloud Server 1 Tahun'
                    , 'Garansi & Pemeliharaan Awal 1 Bulan'
                ]
            }
            , gold: {
                title: 'Paket Gold (Paling Diminati)'
                , price: '{{ \App\Models\ClientProposal::formatPackagePill($client->gold_price) }} (Perpanjangan {{ $client->gold_renewal }})'
                , desc: 'Paket lengkap dengan CMS interaktif untuk menampilkan portofolio eksklusif dan memberikan nilai tambah langsung ke calon pengantin.'
                , features: [
                    'Website Multi-Page Luxury Design & Dynamic CMS'
                    , 'Panel Admin Mandiri (Ubah Foto, Paket & Harga Kapan Saja)'
                    , 'Galeri Portofolio Resolusi Tinggi per Kategori (Dekorasi, MUA, Catering, dll)'
                    , 'Katalog Paket Interaktif & Price Calculator'
                    , 'Form Konsultasi & Cek Ketersediaan Tanggal Acara'
                    , 'Bonus Generator Undangan Digital Online untuk Klien WO'
                    , 'Domain Kustom + High-Speed SSD Cloud Server 1 Tahun + SSL'
                    , 'Garansi & Support Teknis 3 Bulan'
                ]
            }
            , diamond: {
                title: 'Paket Diamond'
                , price: '{{ \App\Models\ClientProposal::formatPackagePill($client->diamond_price) }} (Perpanjangan {{ $client->diamond_renewal }})'
                , desc: 'Dirancang untuk Wedding Organizer profesional yang membutuhkan otomasi manajemen survei, jadwal acara, dan portal khusus pengantin.'
                , features: [
                    'Semua Fasilitas Unggulan Paket Gold'
                    , 'Portal Khusus Klien (Client Dashboard Pantau Progres Persiapan Acara)'
                    , 'Kalkulator Jarak Venue Otomatis Terintegrasi Google Maps API (Surveyor)'
                    , 'Kalender Pintar Jadwal Acara Anti-Bentrok Tim & Alat Dekor'
                    , 'Generator Undangan Digital Unlimited + Buku Tamu QR Code Check-in'
                    , 'Sistem Pencatatan Pembayaran Tagihan (DP / Lunas) Otomatis'
                    , 'SEO Local Optimization agar mudah ditemukan di pencarian Google'
                    , 'Garansi & Prioritas Support 6 Bulan'
                ]
            }
            , platinum: {
                title: 'Paket Platinum (Enterprise Custom)'
                , price: '{{ \App\Models\ClientProposal::formatPackagePill($client->platinum_price) }} (Perpanjangan {{ $client->platinum_renewal }})'
                , desc: 'Solusi all-in-one terlengkap untuk agensi wedding skala besar dengan kebutuhan multi-vendor, e-invoicing dan automasi penuh.'
                , features: [
                    'Semua Fasilitas Lengkap Paket Diamond'
                    , 'Sistem Manajemen Multi-Vendor & Crew Organizer Lapangan'
                    , 'Payment Gateway Otomatis (QRIS, VA Bank & E-Wallet)'
                    , 'Sistem Auto-Invoice & Kwitansi Resmi Otomatis PDF'
                    , 'Dashboard Keuangan, Grafik Pendapatan & Analitik Penjualan'
                    , 'Desain 100% Kustom Eksklusif sesuai Identitas Brand Anda'
                    , 'Server Cloud Dedicated Performa Ekstra Cepat'
                    , 'VIP Dedicated Support & Garansi Penuh 1 Tahun'
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
                li.innerHTML = '<i class="fas fa-check-circle text-gold mt-0.5 shrink-0"></i> <span>' + feat + '</span>';
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
