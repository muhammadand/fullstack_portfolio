<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proposal Proyek E-Commerce Parfum - {{ $client->brand_name }}</title>
    <meta name="description" content="Proposal pengajuan pengembangan sistem Omnichannel & E-Commerce untuk {{ $client->brand_name }} oleh Scalify Intelligence.">

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            gold: '#D4AF37'
                            , dark: '#0a0a0a'
                            , light: '#F8FAFC'
                            , gray: '#334155'
                        }
                    }
                }
            }
        }

    </script>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
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
        .font-serif {
            font-family: 'Playfair Display', serif;
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
        <button onclick="window.print()" class="bg-brand-gold hover:bg-yellow-600 text-black px-6 py-3 rounded-full shadow-lg font-bold uppercase tracking-wider flex items-center gap-2 transition text-sm">
            <i class="fas fa-file-pdf"></i>
            Simpan sebagai PDF
        </button>
    </div>

    <!-- HALAMAN 1 -->
    <div class="proposal-page">
        <!-- Cover Header -->
        <div class="border-b-4 border-brand-gold pb-8 mb-10 mt-10">
            <div class="flex justify-between items-end">
                <div>
                    <p class="text-brand-gold font-bold tracking-widest text-xs mb-2 uppercase">Proposal Kemitraan Digital</p>
                    <h1 class="font-serif text-4xl font-extrabold text-brand-dark leading-tight">Pengembangan E-Commerce &<br>Sistem Omnichannel POS</h1>
                </div>
                <div class="text-right">
                    <div class="w-14 h-14 rounded-full border-2 border-brand-gold bg-brand-dark flex items-center justify-center text-brand-gold text-2xl ml-auto mb-3 shadow-md"><i class="fas fa-spray-can"></i></div>
                    <p class="font-bold text-brand-dark text-lg font-serif tracking-widest uppercase">{{ $client->brand_name }}</p>
                    <p class="text-sm text-slate-500">{{ date('d F Y') }}</p>
                </div>
            </div>
        </div>

        <div class="mb-12 flex justify-between text-sm">
            <div>
                <p class="text-slate-400 mb-1">Disiapkan untuk:</p>
                <p class="font-bold text-brand-dark text-base">{{ $client->client_name ?? $client->brand_name }}</p>
                <p class="text-slate-600">Luxury Fragrance Brand</p>
            </div>
            <div class="text-right">
                <p class="text-slate-400 mb-1">Disiapkan oleh:</p>
                <p class="font-bold text-brand-dark text-base">Scalify Intelligence</p>
                <p class="text-slate-600">Digital Agency & Software House</p>
            </div>
        </div>

        <!-- 1. Pendahuluan -->
        <div class="mb-10">
            <h2 class="font-serif text-2xl font-bold text-brand-dark mb-4 flex items-center gap-2">
                <span class="text-brand-gold">I.</span> Peluang & Tantangan Bisnis Parfum
            </h2>
            <p class="text-slate-600 leading-relaxed text-sm text-justify mb-4">
                Membangun <em>brand</em> parfum lokal saat ini memiliki potensi keuntungan yang luar biasa, namun kompetisinya sangat ketat. Bergantung sepenuhnya pada <em>marketplace</em> (seperti Shopee atau Tokopedia) perlahan akan menggerus margin keuntungan Anda karena <strong>biaya admin yang terus naik</strong> (kini bisa mencapai 6-10%). Selain itu, berjualan berdampingan dengan ribuan kompetitor di <em>marketplace</em> membuat <em>brand</em> Anda sulit membangun citra yang eksklusif dan mewah (Premium).
            </p>
            <p class="text-slate-600 leading-relaxed text-sm text-justify">
                Kami di Scalify Intelligence hadir untuk membangun <strong>"Rumah Digital" eksklusif</strong> untuk <strong>{{ $client->brand_name }}</strong>. Bukan sekadar website biasa, melainkan sebuah sistem cerdas yang menggabungkan toko online mewah, aplikasi kasir (POS) untuk toko fisik/<em>bazaar</em>, dan manajemen <em>reseller</em>—semua dalam satu pintu yang sangat mudah digunakan, bahkan oleh staf yang tidak mengerti IT sekalipun.
            </p>

            <div class="mt-6 bg-[#0a0a0a] border border-brand-gold/50 rounded-xl p-5 flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <h3 class="font-bold text-brand-gold text-sm mb-1 flex items-center gap-2">
                        <i class="fas fa-gem"></i> Coba Langsung Simulasi Sistemnya
                    </h3>
                    <p class="text-[13px] text-gray-400">Kami telah membuatkan demo interaktif khusus untuk {{ $client->brand_name }} agar Anda bisa merasakan langsung kecanggihan sistem ini.</p>
                    <div class="hidden print:block text-[13px] font-medium text-brand-gold break-all mt-2 underline">
                        {{ route("landing.dynamic", $client->slug) }}
                    </div>
                </div>
                <a href="{{ route("landing.dynamic", $client->slug) }}" target="_blank" class="shrink-0 bg-brand-gold hover:bg-white text-black px-5 py-2.5 rounded text-[12px] font-bold uppercase tracking-wider transition inline-flex items-center justify-center gap-2 no-print shadow-md">
                    Buka Web Demo <i class="fas fa-external-link-alt text-[10px]"></i>
                </a>
            </div>
        </div>

        <!-- 2. Solusi & Strategi -->
        <div class="mb-10">
            <h2 class="font-serif text-2xl font-bold text-brand-dark mb-4 flex items-center gap-2">
                <span class="text-brand-gold">II.</span> Mengapa Sistem Ini Akan Melejitkan Omzet Anda?
            </h2>
            <ul class="space-y-5 text-sm text-slate-600">
                <li class="flex items-start gap-3">
                    <div class="w-6 h-6 rounded-full bg-brand-gold/20 text-brand-gold flex items-center justify-center shrink-0 mt-0.5"><i class="fas fa-percent text-[10px]"></i></div>
                    <div>
                        <strong class="text-brand-dark">100% Keuntungan Milik Anda (Bebas Potongan Admin)</strong>
                        <p class="mt-1">Tidak ada lagi potongan biaya admin per transaksi seperti di <em>marketplace</em>. Seluruh pendapatan langsung masuk ke rekening Anda. Anda juga memegang kendali penuh atas <em>database</em> (nomor HP & email) pembeli Anda untuk keperluan promo di masa depan.</p>
                    </div>
                </li>
                <li class="flex items-start gap-3">
                    <div class="w-6 h-6 rounded-full bg-brand-gold/20 text-brand-gold flex items-center justify-center shrink-0 mt-0.5"><i class="fas fa-sync text-[10px]"></i></div>
                    <div>
                        <strong class="text-brand-dark">Satu Stok untuk Toko Online & Offline (Anti Stok Bocor)</strong>
                        <p class="mt-1">Pernah kewalahan sinkronisasi stok saat ikut <em>Bazaar</em>? Dengan sistem kami, barang yang terjual di kasir fisik akan otomatis memotong stok yang ada di website secara <em>real-time</em>. Tidak ada lagi kejadian <em>overselling</em> (barang habis tapi masih bisa dibeli orang di web).</p>
                    </div>
                </li>
                <li class="flex items-start gap-3">
                    <div class="w-6 h-6 rounded-full bg-brand-gold/20 text-brand-gold flex items-center justify-center shrink-0 mt-0.5"><i class="fas fa-users text-[10px]"></i></div>
                    <div>
                        <strong class="text-brand-dark">Pasukan Reseller yang Berjalan Otomatis (Auto-Pilot)</strong>
                        <p class="mt-1">Buka peluang <em>B2B</em>. Agen dan <em>Reseller</em> bisa <em>login</em> dan memesan barang sendiri. Sistem akan mengenali tingkat mereka (misal: Agen VIP) dan otomatis memberikan potongan harga grosir, tanpa admin Anda harus repot menghitung manual via WhatsApp.</p>
                    </div>
                </li>
            </ul>
        </div>
    </div>

    <!-- HALAMAN 2 -->
    <div class="proposal-page page-break">

        <!-- 3. Arsitektur Sistem -->
        <div class="mb-10 mt-6">
            <h2 class="font-serif text-2xl font-bold text-brand-dark mb-6 flex items-center gap-2">
                <span class="text-brand-gold">III.</span> Fitur Unggulan yang Anda Dapatkan
            </h2>

            <div class="grid grid-cols-1 gap-6">
                <!-- Frontend -->
                <div class="border-l-4 border-brand-gold rounded-r-xl p-5 bg-white shadow-sm border-y border-r border-slate-200">
                    <h3 class="font-bold text-brand-dark mb-3 border-b border-slate-100 pb-2 font-serif text-lg"><i class="fas fa-store text-brand-gold mr-2"></i>1. Website Toko Online Mewah</h3>
                    <ul class="space-y-2 text-sm text-slate-600">
                        <li><strong class="text-brand-dark">Desain Kelas Dunia:</strong> Estetika visual elegan yang seketika mengangkat derajat dan prestise merek parfum Anda.</li>
                        <li><strong class="text-brand-dark">Visualisasi Aroma (Notes):</strong> Penjelasan <em>Top, Heart, dan Base notes</em> yang disajikan secara interaktif agar pelanggan tergiur meski belum mencium wanginya.</li>
                        <li><strong class="text-brand-dark">Pembayaran Otomatis (Payment Gateway):</strong> Terima pembayaran via QRIS, Virtual Account (BCA, Mandiri, dll), dan e-Wallet. Orderan otomatis terkonfirmasi tanpa perlu minta pembeli kirim bukti transfer.</li>
                    </ul>
                </div>

                <!-- Backend -->
                <div class="border-l-4 border-brand-dark rounded-r-xl p-5 bg-white shadow-sm border-y border-r border-slate-200">
                    <h3 class="font-bold text-brand-dark mb-3 border-b border-slate-100 pb-2 font-serif text-lg"><i class="fas fa-desktop text-gray-500 mr-2"></i>2. Aplikasi Kasir & Dashboard Operasional</h3>
                    <ul class="space-y-2 text-sm text-slate-600">
                        <li><strong class="text-brand-dark">Aplikasi Kasir Toko (POS):</strong> Khusus untuk SPG/Kasir di toko atau pameran. Mendukung <em>scan barcode</em> dan cetak struk.</li>
                        <li><strong class="text-brand-dark">Manajemen Pesanan 1-Klik:</strong> Cetak label resi pengiriman kurir (J&T, SiCepat, dll) massal dengan sekali klik. Nomor resi otomatis dikirim ke email/WhatsApp pelanggan.</li>
                        <li><strong class="text-brand-dark">Analitik Penjualan Cerdas:</strong> Grafik laporan untuk mengetahui aroma mana yang paling laris (<em>Best Seller</em>) bulan ini.</li>
                    </ul>
                </div>

                <!-- Reseller -->
                <div class="border-l-4 border-gray-400 rounded-r-xl p-5 bg-white shadow-sm border-y border-r border-slate-200">
                    <h3 class="font-bold text-brand-dark mb-3 border-b border-slate-100 pb-2 font-serif text-lg"><i class="fas fa-headset text-gray-500 mr-2"></i>3. Pendampingan & Garansi Bebas Repot</h3>
                    <ul class="space-y-2 text-sm text-slate-600">
                        <li><strong class="text-brand-dark">Sangat Mudah Digunakan:</strong> Sistem kami rancang agar mudah dipahami oleh siapapun. Anda tidak perlu paham bahasa pemograman (<em>coding</em>).</li>
                        <li><strong class="text-brand-dark">Pelatihan (Training) Eksklusif:</strong> Kami akan mengajari Anda dan staf Anda secara langsung sampai benar-benar mahir menggunakan sistem ini.</li>
                        <li><strong class="text-brand-dark">Dukungan Teknis (Support):</strong> Biarkan kami yang mengurus segala kerumitan <em>server</em> dan sistem. Anda cukup fokus meracik parfum dan berjualan.</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- HALAMAN 3 -->
    <div class="proposal-page page-break">
        <div class="mb-10 mt-6">
            <h2 class="font-serif text-2xl font-bold text-brand-dark mb-6 flex items-center gap-2">
                <span class="text-brand-gold">IV.</span> Rincian Investasi
            </h2>
            <p class="text-sm text-slate-600 mb-6">Penawaran pengembangan platform E-Commerce dan sistem Omnichannel.</p>

            <table class="w-full text-left text-sm mb-6 border-collapse">
                <thead>
                    <tr class="bg-[#0a0a0a] text-brand-gold border-b-2 border-brand-gold">
                        <th class="py-3 px-4 font-bold w-2/3 uppercase tracking-wider text-xs">Layanan & Fasilitas</th>
                        <th class="py-3 px-4 font-bold text-right w-1/3 uppercase tracking-wider text-xs">Biaya (IDR)</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="border-b border-slate-200">
                        <td class="py-4 px-4 text-slate-600">
                            <span class="font-bold text-brand-dark block text-base mb-1">Paket Sistem E-Commerce & Kasir (All-in-One)</span>
                            <span class="text-[12px] block text-justify leading-relaxed">Pembuatan Toko Online Mewah, Aplikasi Kasir (POS) Toko Fisik, Sistem Diskon Reseller Otomatis, dan Dasbor Admin Lengkap. <br><strong class="text-green-600 font-bold mt-1 inline-block"><i class="fas fa-check-circle"></i> Lisensi seumur hidup (Bukan langganan bulanan). 100% Hak Milik Anda.</strong></span>
                        </td>
                        <td class="py-4 px-4 text-right font-bold text-brand-dark align-top text-base">Rp {{ number_format($client->project_price, 0, ",", ".") }}</td>
                    </tr>
                    <tr class="border-b border-slate-200">
                        <td class="py-4 px-4 text-slate-600">
                            <span class="font-bold text-brand-dark block text-base mb-1">Infrastruktur Server Cloud & Domain (.com)</span>
                            <span class="text-[12px] block text-justify leading-relaxed">Biaya sewa nama web resmi (www.brandanda.com) dan mesin server Cloud super cepat agar pelanggan nyaman berbelanja (Berlaku untuk 1 Tahun Pertama).</span>
                        </td>
                        <td class="py-4 px-4 text-right font-medium text-brand-dark align-top text-base">Rp {{ number_format($client->domain_price, 0, ",", ".") }}</td>
                    </tr>
                    <tr class="bg-brand-gold/10 border-t-2 border-brand-gold">
                        <td class="py-4 px-4 font-bold text-brand-dark text-right uppercase tracking-widest text-xs">Total Nilai Investasi (Hanya Bayar Sekali) :</td>
                        <td class="py-4 px-4 text-right font-black text-brand-dark text-xl">Rp {{ number_format($client->project_price + $client->domain_price, 0, ",", ".") }}</td>
                    </tr>
                </tbody>
            </table>

            <div class="bg-blue-50 border border-blue-200 p-4 mt-8 rounded flex gap-4 items-start">
                <i class="fas fa-lightbulb text-blue-500 mt-1 text-xl"></i>
                <p class="text-[13px] text-slate-700 leading-relaxed">
                    <strong>Anggap ini sebagai investasi mesin penghasil uang Anda.</strong> Dengan mengalihkan penjualan dari <em>marketplace</em> (yang memotong untung Anda hingga 10% setiap transaksi) ke *website* sendiri, biaya investasi pembuatan sistem ini akan tertutupi <em>(Balik Modal / ROI)</em> dalam waktu yang sangat singkat!
                </p>
            </div>
        </div>

        <div class="mt-16 border-t border-slate-200 pt-10 text-sm text-slate-600">
            <p class="mb-12">Demikian proposal ini kami sampaikan sebagai langkah awal digitalisasi bisnis wewangian Anda. Atas waktu dan kepercayaannya, kami ucapkan terima kasih.</p>
            <div class="flex justify-between items-end">
                <div class="text-center">
                    <p class="mb-20">Hormat Kami,</p>
                    <div class="border-b border-slate-400 w-48 mb-1 mx-auto"></div>
                    <p class="font-bold text-brand-dark font-serif">M. Andi</p>
                    <p class="text-xs text-slate-500">Project Manager - Scalify</p>
                </div>
                <div class="text-center">
                    <p class="mb-20">Disetujui Oleh,</p>
                    <div class="border-b border-slate-400 w-48 mb-1 mx-auto"></div>
                    <p class="font-bold text-brand-dark font-serif">.........................................</p>
                    <p class="text-xs text-slate-500">{{ $client->brand_name }}</p>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
