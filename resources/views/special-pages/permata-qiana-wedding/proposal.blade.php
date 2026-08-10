<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Meta Tags untuk Preview Link (WhatsApp, Telegram, dsb) -->
    <title>Proposal Proyek Website - Permata Qiana Wedding</title>
    <meta name="description" content="Proposal pengajuan pengembangan sistem dan website custom untuk Permata Qiana Wedding oleh Scalify Intelligence.">

    <!-- Open Graph / Facebook / WhatsApp -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="Proposal Proyek Website - Permata Qiana Wedding">
    <meta property="og:description" content="Proposal pengajuan pengembangan sistem dan website custom untuk Permata Qiana Wedding oleh Scalify Intelligence.">
    <!-- Gambar yang akan muncul di link (Rekomendasi ukuran: 1200x630px) -->
    <meta property="og:image" content="{{ asset('images/agency-cover.jpg') }}">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ url()->current() }}">
    <meta property="twitter:title" content="Proposal Proyek Website - Permata Qiana Wedding">
    <meta property="twitter:description" content="Proposal pengajuan pengembangan sistem dan website custom untuk Permata Qiana Wedding oleh Scalify Intelligence.">
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
                    <p class="font-bold text-dark text-lg">Permata Qiana Wedding</p>
                    <p class="text-sm text-gray-500">{{ date('d F Y') }}</p>
                </div>
            </div>
        </div>

        <!-- Disiapkan oleh -->
        <div class="mb-12 flex justify-between text-sm">
            <div>
                <p class="text-gray-400 mb-1">Disiapkan untuk:</p>
                <p class="font-bold text-gray-800 text-base">Manajemen Permata Qiana Wedding</p>
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
                Proposal ini menjabarkan rencana pengembangan website <strong>Permata Qiana Wedding</strong>. Website ini akan dirancang dengan estetika mewah (luxury design), menonjolkan galeri dekorasi & makeup, merinci paket pernikahan yang ditawarkan, serta mengintegrasikan sistem kontak yang memudahkan calon klien untuk segera berkonsultasi.
            </p>

            <!-- Link Demo Draft Landing Page -->
            <div class="mt-6 bg-[#C59A6F]/10 border border-gold/30 rounded-lg p-5 flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <h3 class="font-bold text-gray-800 text-sm mb-1 flex items-center gap-2">
                        <i class="fas fa-desktop text-gold"></i> Preview Draft Landing Page
                    </h3>
                    <p class="text-[13px] text-gray-700">Sebagai gambaran dan referensi visual awal, kami telah menyiapkan kerangka desain (draft) landing page yang bisa Anda lihat langsung pada tautan berikut.</p>
                    <div class="hidden print:block text-[13px] font-medium text-blue-600 break-all mt-2 underline">
                        https://scalifyintellegence.my.id/landing/permata-qiana-wedding
                    </div>
                </div>
                <a href="https://scalifyintellegence.my.id/landing/permata-qiana-wedding" target="_blank" class="shrink-0 bg-dark hover:bg-gray-800 text-white px-5 py-2.5 rounded-full text-[13px] font-medium transition inline-flex items-center justify-center gap-2 no-print shadow-md">
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
                    <span><strong>Meningkatkan Kredibilitas:</strong> Menghadirkan citra Permata Qiana sebagai WO profesional & eksklusif.</span>
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

            <p class="text-sm text-gray-600 mb-6">Website akan dibangun menggunakan teknologi modern (Laravel/Tailwind CSS) yang menjamin kecepatan akses (fast loading) dan keamanan tingkat tinggi. Berikut adalah fitur-fitur utamanya:</p>

            <div class="grid grid-cols-2 gap-6 mb-6">
                <!-- Fitur Utama -->
                <div class="bg-gray-50 p-5 rounded-lg border border-gray-100">
                    <h3 class="font-bold text-gray-800 mb-3 text-sm">Halaman Publik (Front-End)</h3>
                    <ul class="space-y-2 text-[13px] text-gray-600">
                        <li><i class="fas fa-angle-right text-gold w-4"></i> <strong>Beranda (Home):</strong> Layout hero mewah, highlight layanan, dan CTA.</li>
                        <li><i class="fas fa-angle-right text-gold w-4"></i> <strong>Layanan & Galeri:</strong> Detail layanan dan album interaktif portofolio.</li>
                        <li><i class="fas fa-angle-right text-gold w-4"></i> <strong>Paket Wedding:</strong> Tabel harga/paket yang elegan & komprehensif.</li>
                        <li><i class="fas fa-angle-right text-gold w-4"></i> <strong>Kontak & Testimoni:</strong> Integrasi Form ke Email & WhatsApp langsung.</li>
                    </ul>
                </div>

                <!-- Fitur Admin -->
                <div class="bg-gray-50 p-5 rounded-lg border border-gray-100">
                    <h3 class="font-bold text-gray-800 mb-3 text-sm">Sistem Manajemen (CMS / Back-End)</h3>
                    <ul class="space-y-2 text-[13px] text-gray-600">
                        <li><i class="fas fa-angle-right text-gold w-4"></i> <strong>Dashboard Admin:</strong> Panel aman dengan sistem login.</li>
                        <li><i class="fas fa-angle-right text-gold w-4"></i> <strong>Kelola Web:</strong> Update galeri, paket, dan testimoni dengan mudah.</li>
                        <li><i class="fas fa-angle-right text-gold w-4"></i> <strong>SEO & Responsif:</strong> Optimasi mesin pencari dan ramah mobile/HP.</li>
                    </ul>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-6">
                <!-- Fitur Eksekutif Owner & Surveyor -->
                <div class="bg-gray-50 p-5 rounded-lg border border-gray-100 border-l-4 border-l-gold">
                    <h3 class="font-bold text-gray-800 mb-3 text-sm">Fitur Eksekutif (Owner & Tim Survey)</h3>
                    <ul class="space-y-2 text-[13px] text-gray-600">
                        <li><i class="fas fa-map-marked-alt text-gold w-4"></i> <strong>Sistem Survey Maps (API):</strong> Input titik lokasi acara, otomatis hitung jarak tempuh tim dari kantor/gudang untuk hitung ongkos logistik.</li>
                        <li><i class="fas fa-chart-line text-gold w-4"></i> <strong>Laporan & Analitik:</strong> Rekapitulasi jumlah klien, pendapatan, dan progres proyek.</li>
                        <li><i class="fas fa-boxes text-gold w-4"></i> <strong>Manajemen Jadwal:</strong> Pantau ketersediaan tim dan alat di tanggal tertentu (cegah bentrok).</li>
                    </ul>
                </div>

                <!-- Portal Klien & Nilai Tambah -->
                <div class="bg-gray-50 p-5 rounded-lg border border-gray-100 border-l-4 border-l-gold">
                    <h3 class="font-bold text-gray-800 mb-3 text-sm">Portal Klien & Nilai Tambah Ekstra</h3>
                    <ul class="space-y-2 text-[13px] text-gray-600">
                        <li><i class="fas fa-user-circle text-gold w-4"></i> <strong>Client Dashboard:</strong> Klien bisa login untuk pantau detail paket yang dipesan, tanggal acara, dan progress checklist persiapan.</li>
                        <li><i class="fas fa-envelope-open-text text-gold w-4"></i> <strong>Undangan Digital Terintegrasi:</strong> Layanan pembuatan undangan digital (add-on) langsung dari sistem untuk klien.</li>
                        <li><i class="fas fa-file-invoice text-gold w-4"></i> <strong>Manajemen Invoice:</strong> Sistem penagihan otomatis untuk pantau status DP & Pelunasan klien.</li>
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
                    <p class="text-[13px] text-gray-600 mt-1">Revisi final dari pihak Permata Qiana (jika ada), setup domain & hosting, website live ke internet, dan serah terima (training penggunaan CMS).</p>
                </div>
            </div>
        </div>
    </div>


    <!-- ==============================================
         HALAMAN 3: BIAYA & PENUTUP
         ============================================== -->
    <div class="proposal-page page-break">
        <!-- 5. Rincian Biaya -->
        <div class="mb-10 mt-6">
            <h2 class="font-serif text-2xl font-bold text-dark mb-6 flex items-center gap-2">
                <span class="text-gold">05.</span> Rincian Investasi / Biaya
            </h2>
            <p class="text-sm text-gray-600 mb-6">Investasi di bawah ini merupakan standar pengeluaran untuk pembuatan website Wedding Organizer yang profesional, eksklusif, dan dinamis.</p>

            <table class="w-full text-left text-sm mb-6 border-collapse">
                <thead>
                    <tr class="bg-gray-100 border-b-2 border-gray-300">
                        <th class="py-3 px-4 font-bold text-gray-800 w-2/3">Deskripsi Layanan</th>
                        <th class="py-3 px-4 font-bold text-gray-800 text-right w-1/3">Estimasi Biaya (IDR)</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="border-b border-gray-100">
                        <td class="py-4 px-4 text-gray-600">
                            <span class="font-bold text-gray-800 block">Pengembangan Sistem & Website Custom <span class="text-gold">(Special Offer)</span></span>
                            <span class="text-[12px]">Termasuk UI/UX mewah, Backend CMS, Portal Klien, Integrasi Maps API (Surveyor), Sistem Manajemen Jadwal, Invoice Otomatis & Fitur Undangan Digital.</span>
                        </td>
                        <td class="py-4 px-4 text-right font-medium text-gray-800 align-top">Rp 4.500.000</td>
                    </tr>
                    <tr class="border-b border-gray-100">
                        <td class="py-4 px-4 text-gray-600">
                            <span class="font-bold text-gray-800 block">Domain & Cloud Hosting Server (1 Tahun)</span>
                            <span class="text-[12px]">Domain (.com / .id), penyimpanan SSD Cloud berkecepatan tinggi, SSL Certificate (Keamanan HTTPS), dan setup server.</span>
                        </td>
                        <td class="py-4 px-4 text-right font-medium text-gray-800 align-top">Rp 1.200.000</td>
                    </tr>
                    <tr class="bg-gray-50 border-t-2 border-gray-300">
                        <td class="py-4 px-4 font-bold text-gray-800 text-right">TOTAL INVESTASI :</td>
                        <td class="py-4 px-4 text-right font-bold text-gold text-lg">Rp 5.700.000</td>
                    </tr>
                </tbody>
            </table>

            <!-- Catatan Fleksibilitas -->
            <div class="bg-[#C59A6F]/10 border-l-4 border-gold rounded-r-lg p-4 mt-8">
                <div class="flex items-start gap-3">
                    <i class="fas fa-handshake text-gold mt-1 text-lg"></i>
                    <div>
                        <h4 class="font-bold text-gray-800 text-sm mb-1">Terbuka untuk Diskusi (Negotiable)</h4>
                        <p class="text-[13px] text-gray-700 leading-relaxed">
                            Spesifikasi fitur dan estimasi biaya investasi di atas bersifat usulan awal dan <strong>sangat fleksibel</strong>. Kami sangat terbuka untuk berdiskusi lebih lanjut dan melakukan penyesuaian (customization) baik dari segi fitur maupun rincian harga akhir, agar benar-benar selaras dengan kebutuhan prioritas dan alokasi budget dari pihak Permata Qiana Wedding.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- 6. Syarat & Ketentuan -->
        <div class="mb-10">
            <h2 class="font-serif text-2xl font-bold text-dark mb-4 flex items-center gap-2">
                <span class="text-gold">06.</span> Syarat Ketentuan & Layanan Lanjutan
            </h2>
            <ul class="space-y-3 text-sm text-gray-600 list-disc pl-5">
                <li>Pembayaran <strong>Down Payment (DP) 50%</strong> (Rp 2.850.000) dilakukan sebelum proyek dimulai (Termin 1).</li>
                <li>Pembayaran <strong>Pelunasan 50%</strong> (Rp 2.850.000) dilakukan setelah sistem & website selesai, disetujui, dan siap online (Termin 2).</li>
                <li>Masa garansi dan <i>free maintenance</i> (perbaikan bug/error) berlaku gratis selama <strong>3 Bulan</strong> pertama sejak website live.</li>
                <li><strong>Biaya Perpanjangan (Tahun Ke-2 dst):</strong> Biaya wajib perpanjangan Server & Domain adalah Rp 1.200.000/tahun. Jika disertai Jasa Maintenance Rutin (backup berkala & update keamanan), total biayanya menjadi Rp 2.000.000/tahun (Opsional).</li>
                <li><strong>Penambahan Fitur Baru (Upgrade):</strong> Pembuatan fitur baru atau modifikasi sistem di luar kesepakatan proposal awal akan dikenakan biaya tambahan mulai dari <strong>Rp 300.000 - Rp 700.000</strong> per fitur, menyesuaikan tingkat kerumitan.</li>
            </ul>
        </div>

        <!-- 7. Penutup -->
        <div class="mt-16 border-t border-gray-200 pt-10 text-sm text-gray-600">
            <p class="mb-6 leading-relaxed">
                Demikian proposal penawaran pembuatan website ini kami sampaikan. Kami berharap dapat menjadi mitra digital yang solid bagi kesuksesan <strong>Permata Qiana Wedding</strong> ke depannya. Jika ada pertanyaan lebih lanjut terkait rincian teknis maupun biaya, kami siap untuk berdiskusi.
            </p>
            <p class="mb-12">Atas perhatian dan kerja samanya, kami ucapkan terima kasih.</p>

            <div class="flex justify-between items-end">
                <div class="text-center">
                    <p class="mb-20">Hormat Kami,</p>
                    <div class="border-b border-gray-400 w-48 mb-1 mx-auto"></div>
                    <p class="font-bold text-gray-800">M. Andi</p>
                    <p class="text-xs text-gray-500">Project Manager - Scalify Intelligence</p>
                </div>
                <div class="text-center">
                    <p class="mb-20">Disetujui Oleh,</p>
                    <div class="border-b border-gray-400 w-48 mb-1 mx-auto"></div>
                    <p class="font-bold text-gray-800">.........................................</p>
                    <p class="text-xs text-gray-500">Permata Qiana Wedding</p>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
