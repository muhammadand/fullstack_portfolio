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
                    <p class="text-brand-gold font-bold tracking-widest text-xs mb-2 uppercase">Proposal Kemitraan Digital • Luxury Fragrance</p>
                    <h1 class="font-serif text-4xl font-extrabold text-brand-dark leading-tight">Pengembangan E-Commerce Parfum,<br>VIP Membership & Omnichannel POS</h1>
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
                Kami di Scalify Intelligence hadir untuk membangun <strong>"Rumah Digital" eksklusif</strong> untuk <strong>{{ $client->brand_name }}</strong>. Bukan sekadar website biasa, melainkan sebuah ekosistem cerdas yang menggabungkan toko online mewah (dengan visualisasi notes aroma & sampler), klub VIP Membership pemicu *repeat order*, aplikasi kasir (POS) toko fisik/<em>bazaar</em>, dan portal reseller—semua terintegrasi dalam satu pintu yang sangat praktis.
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
        <div class="mb-8 mt-4">
            <h2 class="font-serif text-2xl font-bold text-brand-dark mb-4 flex items-center gap-2">
                <span class="text-brand-gold">III.</span> Fitur Unggulan yang Anda Dapatkan
            </h2>
            <p class="text-sm text-slate-600 mb-6">Seluruh modul dirancang khusus untuk meningkatkan prestise merek parfum, retensi pembeli, dan efisiensi operasional harian Anda.</p>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Frontend & Scent Experience -->
                <div class="border-l-4 border-brand-gold rounded-r-xl p-4 bg-white shadow-sm border-y border-r border-slate-200">
                    <h3 class="font-bold text-brand-dark mb-2 border-b border-slate-100 pb-1.5 font-serif text-base"><i class="fas fa-store text-brand-gold mr-2"></i>1. Luxury Web Store & Scent Notes</h3>
                    <ul class="space-y-1.5 text-xs text-slate-600">
                        <li><strong class="text-brand-dark">Visualisasi Aroma (Notes):</strong> Penjelasan <em>Top, Heart, & Base notes</em> interaktif agar pembeli yakin memesan.</li>
                        <li><strong class="text-brand-dark">Discovery Set & Bundling:</strong> Paket sampler aroma & bundling kustom untuk menaikkan nilai transaksi (AOV).</li>
                        <li><strong class="text-brand-dark">Payment Gateway Otomatis:</strong> QRIS, Virtual Account (BCA, Mandiri, BRI, dll), dan E-Wallet tanpa perlu cek mutasi manual.</li>
                    </ul>
                </div>

                <!-- Membership & Loyalty Club -->
                <div class="border-l-4 border-brand-gold rounded-r-xl p-4 bg-white shadow-sm border-y border-r border-slate-200">
                    <h3 class="font-bold text-brand-dark mb-2 border-b border-slate-100 pb-1.5 font-serif text-base"><i class="fas fa-crown text-brand-gold mr-2"></i>2. VIP Membership & Loyalty Club</h3>
                    <ul class="space-y-1.5 text-xs text-slate-600">
                        <li><strong class="text-brand-dark">Tiering Level Member:</strong> Tingkatan member (Silver, Gold, Platinum) dengan privilege diskon eksklusif.</li>
                        <li><strong class="text-brand-dark">Sistem Poin & Cashback:</strong> Poin reward tiap transaksi yang bisa ditukar voucher, memicu <em>repeat order</em> rutin.</li>
                        <li><strong class="text-brand-dark">Dedicated Member Area:</strong> Dasbor akun pembeli untuk cek riwayat belanja, status tier, dan klaim hadiah.</li>
                    </ul>
                </div>

                <!-- POS & Offline Retail -->
                <div class="border-l-4 border-brand-dark rounded-r-xl p-4 bg-white shadow-sm border-y border-r border-slate-200">
                    <h3 class="font-bold text-brand-dark mb-2 border-b border-slate-100 pb-1.5 font-serif text-base"><i class="fas fa-cash-register text-gray-700 mr-2"></i>3. Omnichannel Cloud POS (Kasir)</h3>
                    <ul class="space-y-1.5 text-xs text-slate-600">
                        <li><strong class="text-brand-dark">Aplikasi Kasir Toko & Bazaar:</strong> Tampilan kasir cepat untuk SPG/kasir di outlet fisik, pop-up store, atau event pameran.</li>
                        <li><strong class="text-brand-dark">Sinkronisasi Stok Real-Time:</strong> Penjualan di kasir langsung memotong stok website seketika, mencegah <em>overselling</em>.</li>
                        <li><strong class="text-brand-dark">Struk & Barcode Scanner:</strong> Cetak struk belanja thermal dan integrasi scan barcode produk.</li>
                    </ul>
                </div>

                <!-- B2B Reseller & Support -->
                <div class="border-l-4 border-gray-400 rounded-r-xl p-4 bg-white shadow-sm border-y border-r border-slate-200">
                    <h3 class="font-bold text-brand-dark mb-2 border-b border-slate-100 pb-1.5 font-serif text-base"><i class="fas fa-users-cog text-gray-700 mr-2"></i>4. B2B Reseller & Pendampingan</h3>
                    <ul class="space-y-1.5 text-xs text-slate-600">
                        <li><strong class="text-brand-dark">Portal Khusus Reseller/Mitra:</strong> Diskon grosir otomatis saat agen login, tanpa admin repot hitung manual.</li>
                        <li><strong class="text-brand-dark">Training Langsung:</strong> Pelatihan staf kasir & admin hingga lancar mengoperasikan seluruh fitur.</li>
                        <li><strong class="text-brand-dark">Garansi & Support Teknis:</strong> Tim teknis Scalify siap mendampingi kelancaran operasional sistem Anda.</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- HALAMAN 3 -->
    <div class="proposal-page page-break">
        <div class="mb-8 mt-4">
            <h2 class="font-serif text-2xl font-bold text-brand-dark mb-4 flex items-center gap-2">
                <span class="text-brand-gold">IV.</span> Rincian Investasi
            </h2>
            <p class="text-sm text-slate-600 mb-6">Investasi terpadu pengembangan ekosistem digital E-Commerce, Membership, dan Omnichannel POS.</p>

            <table class="w-full text-left text-sm mb-6 border-collapse">
                <thead>
                    <tr class="bg-[#0a0a0a] text-brand-gold border-b-2 border-brand-gold">
                        <th class="py-3 px-4 font-bold w-2/3 uppercase tracking-wider text-xs">Layanan & Rincian Fasilitas</th>
                        <th class="py-3 px-4 font-bold text-right w-1/3 uppercase tracking-wider text-xs">Biaya (IDR)</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="border-b border-slate-200">
                        <td class="py-4 px-4 text-slate-600">
                            <span class="font-bold text-brand-dark block text-base mb-1.5">Paket Ekosistem Digital Parfum (All-in-One)</span>
                            <ul class="text-[12px] space-y-1 text-slate-600 list-disc list-inside mb-2">
                                <li><strong>Website Toko Online Mewah:</strong> Visual Scent Notes interaktif, Discovery Set Sampler, dan Cart & Checkout Otomatis.</li>
                                <li><strong>Aplikasi Kasir (POS) Cloud:</strong> Kasir toko/bazaar terintegrasi stok <em>real-time</em> dengan website.</li>
                                <li><strong>Sistem VIP Membership & Loyalty:</strong> Poin reward, tier level diskon (Bronze/Silver/Gold), dan area member.</li>
                                <li><strong>Sistem B2B Reseller & Agen:</strong> Login khusus mitra dengan potongan harga grosir otomatis.</li>
                                <li><strong>Payment Gateway & Cetak Resi:</strong> Terima QRIS, VA Bank, E-Wallet, dan cetak label resi kurir kilat.</li>
                                <li><strong>Dasbor Admin & Analisis Stok:</strong> Pengelolaan produk, analitik best-seller aroma, dan 100% kepemilikan database pembeli.</li>
                            </ul>
                            <strong class="text-green-600 font-bold text-[12px] inline-flex items-center gap-1.5 bg-green-50 px-2.5 py-1 rounded border border-green-200">
                                <i class="fas fa-check-circle"></i> Lisensi Seumur Hidup (Lifetime) • 100% Hak Milik Anda • Tanpa Biaya Bulanan
                            </strong>
                        </td>
                        <td class="py-4 px-4 text-right font-bold text-brand-dark align-top text-base whitespace-nowrap">Rp {{ number_format($client->project_price, 0, ",", ".") }}</td>
                    </tr>
                    <tr class="border-b border-slate-200">
                        <td class="py-4 px-4 text-slate-600">
                            <span class="font-bold text-brand-dark block text-base mb-1">Infrastruktur Server Cloud & Domain Resmi (.com)</span>
                            <span class="text-[12px] block text-justify leading-relaxed">Penyediaan Domain resmi Brand (www.brandanda.com), sertifikat keamanan SSL, dan Cloud Hosting berkecepatan tinggi berkapasitas besar (Berlaku 1 Tahun Pertama).</span>
                        </td>
                        <td class="py-4 px-4 text-right font-medium text-brand-dark align-top text-base whitespace-nowrap">Rp {{ number_format($client->domain_price, 0, ",", ".") }}</td>
                    </tr>
                    <tr class="bg-brand-gold/10 border-t-2 border-brand-gold">
                        <td class="py-4 px-4 font-bold text-brand-dark text-right uppercase tracking-widest text-xs">Total Nilai Investasi (Hanya Bayar Sekali) :</td>
                        <td class="py-4 px-4 text-right font-black text-brand-dark text-xl whitespace-nowrap">Rp {{ number_format($client->project_price + $client->domain_price, 0, ",", ".") }}</td>
                    </tr>
                </tbody>
            </table>

            <div class="bg-amber-50/80 border border-amber-200/80 p-4 mt-6 rounded-lg flex gap-3.5 items-start">
                <i class="fas fa-chart-line text-amber-600 mt-1 text-lg shrink-0"></i>
                <p class="text-[12px] text-slate-700 leading-relaxed">
                    <strong>Investasi Mesin Pertumbuhan Bisnis:</strong> Melalui sistem membership dan toko online mandiri, <em>repeat order</em> pelanggan wewangian Anda akan terjaga secara otomatis tanpa tergerus potongan komisi <em>marketplace</em> (6-10%). Biaya investasi ini akan tertutupi <em>(Return on Investment / ROI)</em> dalam waktu yang relatif singkat.
                </p>
            </div>
        </div>

        <div class="mt-12 border-t border-slate-200 pt-8 text-sm text-slate-600">
            <p class="mb-10">Demikian proposal penawaran ini kami sampaikan sebagai langkah strategis digitalisasi dan akselerasi bisnis {{ $client->brand_name }}. Atas waktu dan kepercayaannya, kami ucapkan terima kasih.</p>
            <div class="flex justify-between items-end">
                <div class="text-center">
                    <p class="mb-16">Hormat Kami,</p>
                    <div class="border-b border-slate-400 w-48 mb-1 mx-auto"></div>
                    <p class="font-bold text-brand-dark font-serif">M. Andi</p>
                    <p class="text-xs text-slate-500">Project Manager - Scalify</p>
                </div>
                <div class="text-center">
                    <p class="mb-16">Disetujui Oleh,</p>
                    <div class="border-b border-slate-400 w-48 mb-1 mx-auto"></div>
                    <p class="font-bold text-brand-dark font-serif">.........................................</p>
                    <p class="text-xs text-slate-500">{{ $client->brand_name }}</p>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
