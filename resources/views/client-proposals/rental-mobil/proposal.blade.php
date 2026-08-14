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
        <div class="mb-10 mt-6">
            <h2 class="font-heading text-2xl font-bold text-brand-dark mb-6 flex items-center gap-2">
                <span class="text-brand-blue">04.</span> Rincian Investasi
            </h2>
            <p class="text-sm text-slate-600 mb-6">Investasi pembuatan website Company Profile & Katalog Armada Rental Mobil.</p>

            <table class="w-full text-left text-sm mb-6 border-collapse">
                <thead>
                    <tr class="bg-slate-100 border-b-2 border-slate-300">
                        <th class="py-3 px-4 font-bold text-brand-dark w-2/3">Deskripsi Layanan</th>
                        <th class="py-3 px-4 font-bold text-brand-dark text-right w-1/3">Estimasi Biaya (IDR)</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="border-b border-slate-100">
                        <td class="py-4 px-4 text-slate-600">
                            <span class="font-bold text-brand-dark block">Pengembangan Website & Sistem Katalog (CMS)</span>
                            <span class="text-[12px] mt-1 block">Termasuk desain UI/UX eksklusif, Panel Admin Kelola Armada/Harga, Integrasi WhatsApp, Profil Perusahaan, Syarat & Ketentuan, SEO Basic.</span>
                        </td>
                        <td class="py-4 px-4 text-right font-medium text-brand-dark align-top">Rp {{ number_format($client->project_price, 0, ",", ".") }}</td>
                    </tr>
                    <tr class="border-b border-slate-100">
                        <td class="py-4 px-4 text-slate-600">
                            <span class="font-bold text-brand-dark block">Infrastruktur Domain & Hosting Server (Fleksibel)</span>
                            <span class="text-[12px] mt-1 block">Terdapat opsi yang dapat dinegosiasikan sesuai dengan skala traffic dan jumlah pengguna sistem:</span>
                            <ul class="list-disc list-inside text-[11px] mt-1 space-y-0.5 text-slate-500 ml-1">
                                <li><strong>Opsi Hemat:</strong> Website di-hosting (dititipkan) di server berkecepatan tinggi milik kami. Anda hanya perlu menanggung biaya langganan nama Domain (contoh: <em>.com / .co.id</em>) per tahun.</li>
                                <li><strong>Opsi Mandiri:</strong> Pengadaan Cloud Hosting/VPS mandiri 100% atas nama Anda (direkomendasikan jika traffic / data transaksi harian sudah sangat tinggi).</li>
                            </ul>
                        </td>
                        <td class="py-4 px-4 text-right font-medium text-brand-dark align-top">Mulai dari<br>Rp {{ number_format($client->domain_price, 0, ",", ".") }}</td>
                    </tr>
                    <tr class="bg-blue-50 border-t-2 border-brand-blue">
                        <td class="py-4 px-4 font-bold text-brand-dark text-right">TOTAL INVESTASI :</td>
                        <td class="py-4 px-4 text-right font-bold text-brand-blue text-lg">Rp {{ number_format($client->project_price + $client->domain_price, 0, ",", ".") }}</td>
                    </tr>
                </tbody>
            </table>

            <div class="bg-blue-50 border-l-4 border-brand-blue p-4 mt-8">
                <p class="text-[13px] text-slate-700 leading-relaxed">
                    Spesifikasi fitur dan estimasi biaya di atas bersifat fleksibel. Kami sangat terbuka untuk berdiskusi lebih lanjut dan melakukan penyesuaian (customization) baik dari segi fitur maupun rincian harga akhir sesuai dengan budget dan kebutuhan perusahaan.
                </p>
            </div>
        </div>

        <div class="mt-16 border-t border-slate-200 pt-10 text-sm text-slate-600">
            <p class="mb-12">Demikian proposal penawaran pembuatan website ini kami sampaikan. Atas perhatian dan kerja samanya, kami ucapkan terima kasih.</p>
            <div class="flex justify-between items-end">
                <div class="text-center">
                    <p class="mb-20">Hormat Kami,</p>
                    <div class="border-b border-slate-400 w-48 mb-1 mx-auto"></div>
                    <p class="font-bold text-brand-dark">M. Andi</p>
                    <p class="text-xs text-slate-500">Project Manager - Scalify</p>
                </div>
                <div class="text-center">
                    <p class="mb-20">Disetujui Oleh,</p>
                    <div class="border-b border-slate-400 w-48 mb-1 mx-auto"></div>
                    <p class="font-bold text-brand-dark">.........................................</p>
                    <p class="text-xs text-slate-500">{{ $client->brand_name }}</p>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
