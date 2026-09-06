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
                <p class="font-bold text-brand-dark text-base uppercase font-serif tracking-wider">{{ $client->brand_name }}</p>
                @if(!empty($client->client_name) && strtolower($client->client_name) !== strtolower($client->brand_name))
                <p class="text-xs text-slate-500 font-medium">PIC: {{ $client->client_name }}</p>
                @endif
                <p class="text-slate-600 text-xs mt-0.5">Luxury Fragrance Brand</p>
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
            <h2 class="font-serif text-2xl font-bold text-brand-dark mb-2 flex items-center gap-2">
                <span class="text-brand-gold">IV.</span> Pilihan Paket & Rincian Investasi
            </h2>
            <p class="text-sm text-slate-600 mb-6">Investasi terpadu pengembangan ekosistem digital untuk <strong>{{ $client->brand_name }}</strong> dengan berbagai opsi paket fleksibel:</p>

            @php
            $cleanWa = preg_replace('/[^0-9]/', '', $client->wa_number ?? '6281234567890');
            if (str_starts_with($cleanWa, '0')) {
            $cleanWa = '62' . substr($cleanWa, 1);
            }
            @endphp

            <!-- Tabel Perbandingan Paket & Fitur Parfum -->
            <div class="overflow-x-auto mb-6 rounded-xl border border-stone-300 bg-white shadow-xs">
                <table class="w-full text-left border-collapse text-[11px]">
                    <thead>
                        <tr class="border-b border-stone-200">
                            <th class="p-3.5 bg-stone-900 text-brand-gold font-serif font-bold w-[32%]">
                                <span class="text-[10px] uppercase tracking-widest block text-stone-400 font-sans">Spesifikasi Layanan</span>
                                Paket E-Commerce & Fitur
                            </th>
                            <!-- Silver -->
                            <th class="p-3 text-center bg-stone-50 border-l border-stone-200 w-[17%]">
                                <span class="font-serif font-bold text-sm text-stone-900 block uppercase tracking-wider">Silver</span>
                                <span class="inline-block my-1 py-0.5 px-2 rounded-full border border-stone-300 bg-white text-[10px] font-bold text-stone-900">
                                    {{ \App\Models\ClientProposal::formatPackagePill($client->silver_price) }}
                                </span>
                                <span class="block text-[9px] text-stone-500">Perpanjangan {{ $client->silver_renewal }}</span>
                            </th>
                            <!-- Gold (Featured) -->
                            <th class="p-3 text-center bg-stone-900 text-white border-x-2 border-brand-gold w-[17%] relative">
                                <span class="absolute -top-2.5 left-1/2 -translate-x-1/2 bg-brand-gold text-black text-[8px] font-black uppercase tracking-widest px-2 py-0.2 rounded-full shadow-xs">POPULER</span>
                                <span class="font-serif font-bold text-sm text-brand-gold block uppercase tracking-wider">Gold</span>
                                <span class="inline-block my-1 py-0.5 px-2 rounded-full border border-brand-gold bg-stone-800 text-[10px] font-bold text-brand-gold">
                                    {{ \App\Models\ClientProposal::formatPackagePill($client->gold_price) }}
                                </span>
                                <span class="block text-[9px] text-stone-400">Perpanjangan {{ $client->gold_renewal }}</span>
                            </th>
                            <!-- Diamond -->
                            <th class="p-3 text-center bg-stone-50 border-l border-stone-200 w-[17%]">
                                <span class="font-serif font-bold text-sm text-stone-900 block uppercase tracking-wider">Diamond</span>
                                <span class="inline-block my-1 py-0.5 px-2 rounded-full border border-stone-300 bg-white text-[10px] font-bold text-stone-900">
                                    {{ \App\Models\ClientProposal::formatPackagePill($client->diamond_price) }}
                                </span>
                                <span class="block text-[9px] text-stone-500">Perpanjangan {{ $client->diamond_renewal }}</span>
                            </th>
                            <!-- Platinum -->
                            <th class="p-3 text-center bg-stone-50 border-l border-stone-200 w-[17%]">
                                <span class="font-serif font-bold text-sm text-stone-900 block uppercase tracking-wider">Platinum</span>
                                <span class="inline-block my-1 py-0.5 px-2 rounded-full border border-stone-300 bg-white text-[10px] font-bold text-stone-900">
                                    {{ \App\Models\ClientProposal::formatPackagePill($client->platinum_price) }}
                                </span>
                                <span class="block text-[9px] text-stone-500">Perpanjangan {{ $client->platinum_renewal }}</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-stone-200 text-stone-700">
                        <!-- GROUP 1: E-COMMERCE & SCENT EXPERIENCE -->
                        <tr class="bg-amber-50/60">
                            <td colspan="5" class="py-1.5 px-3.5 font-bold uppercase tracking-wider text-[10px] text-stone-900">
                                <i class="fas fa-spray-can text-amber-600 mr-1.5"></i> Pengalaman Toko Online & Visualisasi Aroma
                            </td>
                        </tr>
                        <tr>
                            <td class="p-2.5 font-medium">Tipe Toko Online & Identitas Brand</td>
                            <td class="p-2.5 text-center bg-stone-50/40">Luxury Showcase (One-Page)</td>
                            <td class="p-2.5 text-center bg-amber-50/20 font-semibold text-stone-900">Full E-Commerce Web Store</td>
                            <td class="p-2.5 text-center bg-stone-50/40 font-semibold">E-Commerce + Member Area</td>
                            <td class="p-2.5 text-center bg-stone-50/40 font-semibold">Omnichannel Web + Cloud POS</td>
                        </tr>
                        <tr>
                            <td class="p-2.5 font-medium">Visualisasi Aroma (Top, Heart, Base Notes)</td>
                            <td class="p-2.5 text-center bg-stone-50/40">Karakter Dasar</td>
                            <td class="p-2.5 text-center bg-amber-50/20 font-semibold text-stone-900"><i class="fas fa-check-circle text-amber-600 text-sm"></i> Visual Interaktif</td>
                            <td class="p-2.5 text-center bg-stone-50/40 font-semibold"><i class="fas fa-check-circle text-amber-600 text-sm"></i> Visual Interaktif</td>
                            <td class="p-2.5 text-center bg-stone-50/40 font-semibold"><i class="fas fa-check-circle text-amber-600 text-sm"></i> Full Scent Experience</td>
                        </tr>
                        <tr>
                            <td class="p-2.5 font-medium">Discovery Set / Sampler & Bundling Package</td>
                            <td class="p-2.5 text-center bg-stone-50/40 text-stone-300 font-bold">—</td>
                            <td class="p-2.5 text-center bg-amber-50/20 text-amber-700 font-semibold"><i class="fas fa-check-circle text-sm"></i> Bundling Builder</td>
                            <td class="p-2.5 text-center bg-stone-50/40 text-amber-700 font-semibold"><i class="fas fa-check-circle text-sm"></i> Sampler & Bundling</td>
                            <td class="p-2.5 text-center bg-stone-50/40 text-amber-700 font-semibold"><i class="fas fa-check-circle text-sm"></i> Kustom Sampler Unlimited</td>
                        </tr>
                        <tr>
                            <td class="p-2.5 font-medium">100% Bebas Biaya Potongan Admin Marketplace</td>
                            <td class="p-2.5 text-center bg-stone-50/40 text-amber-700 font-bold"><i class="fas fa-check text-xs"></i></td>
                            <td class="p-2.5 text-center bg-amber-50/20 text-amber-700 font-bold"><i class="fas fa-check text-xs"></i></td>
                            <td class="p-2.5 text-center bg-stone-50/40 text-amber-700 font-bold"><i class="fas fa-check text-xs"></i></td>
                            <td class="p-2.5 text-center bg-stone-50/40 text-amber-700 font-bold"><i class="fas fa-check text-xs"></i></td>
                        </tr>

                        <!-- GROUP 2: MEMBERSHIP & SISTEM OMNICHANNEL -->
                        <tr class="bg-amber-50/60">
                            <td colspan="5" class="py-1.5 px-3.5 font-bold uppercase tracking-wider text-[10px] text-stone-900">
                                <i class="fas fa-crown text-amber-600 mr-1.5"></i> VIP Membership & Omnichannel Kasir Toko
                            </td>
                        </tr>
                        <tr>
                            <td class="p-2.5 font-medium">Payment Gateway Otomatis (QRIS, VA Bank & E-Wallet)</td>
                            <td class="p-2.5 text-center bg-stone-50/40">Transfer Manual WA</td>
                            <td class="p-2.5 text-center bg-amber-50/20 font-semibold text-stone-900"><i class="fas fa-check-circle text-amber-600 text-sm"></i> Otomatis</td>
                            <td class="p-2.5 text-center bg-stone-50/40 font-semibold"><i class="fas fa-check-circle text-amber-600 text-sm"></i> Otomatis</td>
                            <td class="p-2.5 text-center bg-stone-50/40 font-semibold"><i class="fas fa-check-circle text-amber-600 text-sm"></i> Otomatis</td>
                        </tr>
                        <tr>
                            <td class="p-2.5 font-medium">VIP Membership & Tiering Diskon (Silver/Gold/VIP)</td>
                            <td class="p-2.5 text-center bg-stone-50/40 text-stone-300 font-bold">—</td>
                            <td class="p-2.5 text-center bg-amber-50/20 text-stone-300 font-bold">—</td>
                            <td class="p-2.5 text-center bg-stone-50/40 text-amber-700 font-semibold"><i class="fas fa-check-circle text-sm"></i> Tiering Member</td>
                            <td class="p-2.5 text-center bg-stone-50/40 text-amber-700 font-semibold"><i class="fas fa-check-circle text-sm"></i> Tiering Member</td>
                        </tr>
                        <tr>
                            <td class="p-2.5 font-medium">Sistem Poin Reward & Cashback Repeat Order</td>
                            <td class="p-2.5 text-center bg-stone-50/40 text-stone-300 font-bold">—</td>
                            <td class="p-2.5 text-center bg-amber-50/20 text-stone-300 font-bold">—</td>
                            <td class="p-2.5 text-center bg-stone-50/40 text-amber-700 font-semibold"><i class="fas fa-check-circle text-sm"></i> Poin Otomatis</td>
                            <td class="p-2.5 text-center bg-stone-50/40 text-amber-700 font-semibold"><i class="fas fa-check-circle text-sm"></i> Poin Otomatis</td>
                        </tr>
                        <tr>
                            <td class="p-2.5 font-medium">Aplikasi Kasir (Cloud POS) Toko / Event Bazaar</td>
                            <td class="p-2.5 text-center bg-stone-50/40 text-stone-300 font-bold">—</td>
                            <td class="p-2.5 text-center bg-amber-50/20 text-stone-300 font-bold">—</td>
                            <td class="p-2.5 text-center bg-stone-50/40 text-stone-300 font-bold">—</td>
                            <td class="p-2.5 text-center bg-stone-50/40 text-amber-700 font-bold"><i class="fas fa-check-circle text-sm"></i> POS Kasir Real-time</td>
                        </tr>
                        <tr>
                            <td class="p-2.5 font-medium">Sinkronisasi Stok Real-Time (Anti-Overselling)</td>
                            <td class="p-2.5 text-center bg-stone-50/40">Stok Web</td>
                            <td class="p-2.5 text-center bg-amber-50/20 text-stone-900 font-semibold">Stok Web Mandiri</td>
                            <td class="p-2.5 text-center bg-stone-50/40 font-semibold">Stok Web Mandiri</td>
                            <td class="p-2.5 text-center bg-stone-50/40 text-amber-700 font-bold"><i class="fas fa-check-circle text-sm"></i> Sinkron Kasir & Web</td>
                        </tr>
                        <tr>
                            <td class="p-2.5 font-medium">Portal Khusus Reseller & Agen B2B (Diskon Grosir)</td>
                            <td class="p-2.5 text-center bg-stone-50/40 text-stone-300 font-bold">—</td>
                            <td class="p-2.5 text-center bg-amber-50/20 text-stone-300 font-bold">—</td>
                            <td class="p-2.5 text-center bg-stone-50/40 text-stone-300 font-bold">—</td>
                            <td class="p-2.5 text-center bg-stone-50/40 text-amber-700 font-bold"><i class="fas fa-check-circle text-sm"></i> Portal Reseller B2B</td>
                        </tr>

                        <!-- GROUP 3: SERVER & GARANSI -->
                        <tr class="bg-amber-50/60">
                            <td colspan="5" class="py-1.5 px-3.5 font-bold uppercase tracking-wider text-[10px] text-stone-900">
                                <i class="fas fa-shield-alt text-amber-600 mr-1.5"></i> Infrastruktur Server, Domain & Garansi
                            </td>
                        </tr>
                        <tr>
                            <td class="p-2.5 font-medium">Domain Kustom (.com) & Cloud SSD Hosting</td>
                            <td class="p-2.5 text-center bg-stone-50/40">1 Tahun</td>
                            <td class="p-2.5 text-center bg-amber-50/20 font-semibold text-stone-900">1 Tahun Cloud SSD</td>
                            <td class="p-2.5 text-center bg-stone-50/40 font-semibold">1 Tahun High-Speed SSD</td>
                            <td class="p-2.5 text-center bg-stone-50/40 font-semibold text-stone-900">Dedicated Cloud Server</td>
                        </tr>
                        <tr>
                            <td class="p-2.5 font-medium">Garansi & Pendampingan Operasional</td>
                            <td class="p-2.5 text-center bg-stone-50/40">1 Bulan</td>
                            <td class="p-2.5 text-center bg-amber-50/20 font-semibold text-stone-900">3 Bulan</td>
                            <td class="p-2.5 text-center bg-stone-50/40 font-semibold">6 Bulan Prioritas</td>
                            <td class="p-2.5 text-center bg-stone-50/40 font-bold text-stone-900">1 Tahun Penuh (VIP)</td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr class="border-t-2 border-stone-300 bg-white">
                            <td class="p-3 font-bold text-stone-900">Aksi Pemesanan</td>
                            <td class="p-2.5 text-center bg-stone-50/50">
                                <a href="https://wa.me/{{ $cleanWa }}?text={{ urlencode('Halo Scalify, saya tertarik memesan Paket Silver untuk ' . $client->brand_name . '. Mohon info detailnya.') }}" target="_blank" class="inline-flex items-center justify-center gap-1 w-full py-1.5 px-2 rounded-lg bg-stone-900 hover:bg-black text-brand-gold text-[10px] font-bold shadow-xs transition no-print border border-brand-gold/30">
                                    <i class="fab fa-whatsapp text-green-400"></i> Pilih Silver
                                </a>
                            </td>
                            <td class="p-2.5 text-center bg-amber-50/20">
                                <a href="https://wa.me/{{ $cleanWa }}?text={{ urlencode('Halo Scalify, saya tertarik memesan Paket Gold untuk ' . $client->brand_name . '. Mohon info detailnya.') }}" target="_blank" class="inline-flex items-center justify-center gap-1 w-full py-2 px-2 rounded-lg bg-brand-gold hover:bg-yellow-500 text-black text-[11px] font-extrabold shadow-md transition no-print">
                                    <i class="fab fa-whatsapp text-black"></i> Pilih Gold
                                </a>
                            </td>
                            <td class="p-2.5 text-center bg-stone-50/50">
                                <a href="https://wa.me/{{ $cleanWa }}?text={{ urlencode('Halo Scalify, saya tertarik memesan Paket Diamond untuk ' . $client->brand_name . '. Mohon info detailnya.') }}" target="_blank" class="inline-flex items-center justify-center gap-1 w-full py-1.5 px-2 rounded-lg bg-stone-900 hover:bg-black text-brand-gold text-[10px] font-bold shadow-xs transition no-print border border-brand-gold/30">
                                    <i class="fab fa-whatsapp text-green-400"></i> Pilih Diamond
                                </a>
                            </td>
                            <td class="p-2.5 text-center bg-stone-50/50">
                                <a href="https://wa.me/{{ $cleanWa }}?text={{ urlencode('Halo Scalify, saya tertarik memesan Paket Platinum untuk ' . $client->brand_name . '. Mohon info detailnya.') }}" target="_blank" class="inline-flex items-center justify-center gap-1 w-full py-1.5 px-2 rounded-lg bg-stone-900 hover:bg-black text-brand-gold text-[10px] font-bold shadow-xs transition no-print border border-brand-gold/30">
                                    <i class="fab fa-whatsapp text-green-400"></i> Pilih Platinum
                                </a>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <div class="bg-amber-50/80 border border-amber-200/80 p-3.5 mt-4 rounded-lg flex gap-3.5 items-start">
                <i class="fas fa-chart-line text-amber-600 mt-1 text-base shrink-0"></i>
                <p class="text-[12px] text-slate-700 leading-relaxed">
                    <strong>Investasi Mesin Pertumbuhan Bisnis:</strong> Melalui toko online eksklusif dan sistem membership mandiri, <em>repeat order</em> pelanggan Anda terjaga tanpa potongan komisi marketplace (6-10%). Biaya investasi akan tertutupi <em>(Return on Investment / ROI)</em> dalam waktu singkat.
                </p>
            </div>
        </div>

        <div class="mt-8 border-t border-slate-200 pt-6 text-xs text-slate-600">
            <p class="mb-4">Demikian proposal penawaran ini kami sampaikan sebagai langkah strategis akselerasi bisnis {{ $client->brand_name }}. Atas waktu dan kepercayaannya, kami ucapkan terima kasih.</p>
            <div class="flex justify-between items-end mt-8">
                <div class="text-center">
                    <p class="mb-14">Hormat Kami,</p>
                    <div class="border-b border-slate-400 w-44 mb-1 mx-auto"></div>
                    <p class="font-bold text-brand-dark font-serif">M. Andi</p>
                    <p class="text-[11px] text-slate-500">Project Manager - Scalify</p>
                </div>
                <div class="text-center">
                    <p class="mb-14">Disetujui Oleh,</p>
                    <div class="border-b border-slate-400 w-44 mb-1 mx-auto"></div>
                    <p class="font-bold text-brand-dark font-serif">.........................................</p>
                    <p class="text-[11px] text-slate-500">{{ $client->brand_name }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Detail Paket Parfum -->
    <div id="packageModal" class="fixed inset-0 bg-black/60 z-50 hidden items-center justify-center p-4 backdrop-blur-xs no-print">
        <div class="bg-white rounded-2xl max-w-lg w-full p-6 shadow-2xl relative animate-fade-in border border-brand-gold/30">
            <button onclick="closePackageModal()" class="absolute top-4 right-4 w-8 h-8 rounded-full bg-slate-100 text-slate-500 hover:text-slate-800 hover:bg-slate-200 flex items-center justify-center transition">
                <i class="fas fa-times"></i>
            </button>

            <div class="flex items-center gap-3 mb-4">
                <div id="modalIcon" class="w-10 h-10 rounded-full bg-stone-900 border border-brand-gold text-brand-gold flex items-center justify-center text-lg">
                    <i class="fas fa-award"></i>
                </div>
                <div>
                    <h3 id="modalTitle" class="text-lg font-bold text-slate-800 font-serif">Detail Paket</h3>
                    <p id="modalPrice" class="text-xs font-bold text-amber-700"></p>
                </div>
            </div>

            <p id="modalDesc" class="text-xs text-slate-600 mb-4 bg-amber-50/50 p-3 rounded-lg border border-amber-200/50"></p>

            <div class="mb-6">
                <h4 class="text-xs font-bold uppercase tracking-wider text-slate-800 mb-2.5">Fasilitas & Fitur Termasuk:</h4>
                <ul id="modalFeatures" class="space-y-2 text-xs text-slate-600">
                    <!-- Dynamic List -->
                </ul>
            </div>

            <div class="flex gap-3 pt-3 border-t border-slate-100">
                <button type="button" onclick="closePackageModal()" class="flex-1 py-2 px-4 rounded-xl border border-slate-200 text-slate-600 hover:bg-slate-50 text-xs font-semibold transition">
                    Tutup
                </button>
                <a id="modalWaBtn" href="#" target="_blank" class="flex-1 py-2 px-4 rounded-xl bg-stone-900 hover:bg-black text-brand-gold text-xs font-bold flex items-center justify-center gap-1.5 shadow transition border border-brand-gold/30">
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
                , desc: 'Landing page eksklusif untuk memperkenalkan koleksi parfum brand Anda dengan direct order praktis ke WhatsApp.'
                , features: [
                    'Website Landing Page Luxury Fragrance (One-Page Showcase)'
                    , 'Katalog Produk Parfum & Visual Karakter Aroma Sederhana'
                    , 'Direct Checkout Terhubung ke WhatsApp CS'
                    , 'Domain Kustom (.com) + High-Speed Hosting 1 Tahun'
                    , 'Garansi Teknis 1 Bulan'
                ]
            }
            , gold: {
                title: 'Paket Gold (Paling Direkomendasikan)'
                , price: '{{ \App\Models\ClientProposal::formatPackagePill($client->gold_price) }} (Perpanjangan {{ $client->gold_renewal }})'
                , desc: 'Website E-Commerce parfum mandiri dengan visual Scent Notes interaktif, keranjang belanja otomatis, dan payment gateway bebas biaya admin per transaksi.'
                , features: [
                    'Luxury E-Commerce Web Store Lengkap (Multi-Page)'
                    , 'Visualisasi Aroma (Top, Heart, Base Notes) Interaktif'
                    , 'Discovery Set / Sampler Pack & Bundling Builder (Naikkan AOV)'
                    , 'Payment Gateway Otomatis (QRIS, VA Bank & E-Wallet)'
                    , 'Panel Admin Kelola Produk, Stok, & 100% Kepemilikan Database Pelanggan'
                    , 'Domain .com + Cloud Server SSD Cepat 1 Tahun + SSL'
                    , 'Garansi & Support 3 Bulan'
                ]
            }
            , diamond: {
                title: 'Paket Diamond'
                , price: '{{ \App\Models\ClientProposal::formatPackagePill($client->diamond_price) }} (Perpanjangan {{ $client->diamond_renewal }})'
                , desc: 'Dilengkapi sistem VIP Membership dan Poin Loyalitas untuk mengunci repeat order pembeli wewangian Anda secara otomatis.'
                , features: [
                    'Semua Fasilitas Unggulan Paket Gold'
                    , 'Sistem VIP Membership & Tiering Diskon (Silver, Gold, Platinum)'
                    , 'Sistem Poin Reward & Cashback Otomatis Pemicu Repeat Order'
                    , 'Dedicated Member Area (Dasbor Riwayat Belanja & Voucher Pribadi)'
                    , 'Cetak Resi Pengiriman Kilat & Integrasi Cek Ongkir Otomatis'
                    , 'Garansi & Maintenance Prioritas 6 Bulan'
                ]
            }
            , platinum: {
                title: 'Paket Platinum (Omnichannel POS & Reseller)'
                , price: '{{ \App\Models\ClientProposal::formatPackagePill($client->platinum_price) }} (Perpanjangan {{ $client->platinum_renewal }})'
                , desc: 'Ekosistem terlengkap menggabungkan E-Commerce Web, Aplikasi Kasir (POS) Toko/Bazaar (Stok Sinkron), dan Portal Reseller B2B.'
                , features: [
                    'Semua Fasilitas Lengkap Paket Diamond'
                    , 'Aplikasi Kasir (Cloud POS) untuk SPG di Toko Fisik, Pop-up Booth & Bazaar'
                    , 'Sinkronisasi Stok Real-Time Antara Kasir Toko & Website (Anti-Overselling)'
                    , 'Portal Khusus Agen & Reseller B2B (Diskon Grosir Otomatis saat Login)'
                    , 'Desain 100% Custom Ultra-Luxury Menyesuaikan Identitas Brand'
                    , 'Dedicated Cloud Server Berkapasitas Ekstra'
                    , 'Dedicated VIP Support Penuh 1 Tahun'
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
                li.innerHTML = '<i class="fas fa-check-circle text-amber-600 mt-0.5 shrink-0"></i> <span>' + feat + '</span>';
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
