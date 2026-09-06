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
                            coffee: '#4A3B32'
                            , caramel: '#C3976A'
                            , cream: '#FAEDCD'
                            , latte: '#E6D5C3'
                            , dark: '#1C1917'
                        }
                    }
                }
            }
        }

    </script>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;600;700&family=Outfit:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body {
            background-color: #f3f4f6;
            font-family: 'Outfit', sans-serif;
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
        <button onclick="window.print()" class="bg-brand-coffee hover:bg-brand-dark text-white px-6 py-3 rounded-full shadow-lg font-medium flex items-center gap-2 transition">
            <i class="fas fa-file-pdf"></i>
            Simpan sebagai PDF
        </button>
    </div>

    <!-- HALAMAN 1 -->
    <div class="proposal-page">
        <!-- Cover Header -->
        <div class="border-b-2 border-brand-caramel pb-8 mb-10 mt-10">
            <div class="flex justify-between items-end">
                <div>
                    <p class="text-brand-caramel font-semibold tracking-widest text-sm mb-2 uppercase">Proposal Proyek</p>
                    <h1 class="font-serif text-4xl font-bold text-brand-coffee leading-tight">Pengembangan Website<br>Company Profile & Digital Menu</h1>
                </div>
                <div class="text-right">
                    <div class="w-12 h-12 rounded-full border-2 border-brand-caramel flex items-center justify-center text-brand-caramel font-serif text-2xl ml-auto mb-2"><i class="fas fa-coffee text-xl"></i></div>
                    <p class="font-bold text-brand-coffee text-lg">{{ $client->brand_name }}</p>
                    <p class="text-sm text-gray-500">{{ date('d F Y') }}</p>
                </div>
            </div>
        </div>

        <div class="mb-12 flex justify-between text-sm">
            <div>
                <p class="text-gray-400 mb-1">Disiapkan untuk:</p>
                <p class="font-bold text-brand-coffee text-base">{{ $client->client_name ?? $client->brand_name }}</p>
                <p class="text-gray-600">FnB & Cafe Business</p>
            </div>
            <div class="text-right">
                <p class="text-gray-400 mb-1">Disiapkan oleh:</p>
                <p class="font-bold text-brand-coffee text-base">Scalify Intelligence</p>
                <p class="text-gray-600">Web Development Agency</p>
            </div>
        </div>

        <!-- 1. Pendahuluan -->
        <div class="mb-10">
            <h2 class="font-serif text-2xl font-bold text-brand-coffee mb-4 flex items-center gap-2">
                <span class="text-brand-caramel">01.</span> Pendahuluan
            </h2>
            <p class="text-gray-600 leading-relaxed text-sm text-justify mb-4">
                Dalam industri Food & Beverage yang kompetitif, kualitas produk yang baik saja tidak cukup. Pelanggan era modern cenderung mencari referensi tempat nongkrong atau makan melalui pencarian digital. Website kafe yang interaktif dan estetik akan sangat membantu meningkatkan *awareness*, memberikan kemudahan reservasi, dan menampilkan katalog menu yang menggugah selera sebelum pelanggan melangkah masuk ke pintu Anda.
            </p>
            <p class="text-gray-600 leading-relaxed text-sm text-justify">
                Proposal ini ditujukan untuk membangun ekosistem digital <strong>{{ $client->brand_name }}</strong>. Website akan dirancang dengan menonjolkan visual makanan & minuman, suasana interior (ambiance), dan integrasi kemudahan akses lokasi serta kontak.
            </p>

            <div class="mt-6 bg-brand-cream/40 border border-brand-caramel/30 rounded-xl p-5 flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <h3 class="font-bold text-brand-coffee text-sm mb-1 flex items-center gap-2">
                        <i class="fas fa-desktop text-brand-caramel"></i> Preview Draft Landing Page
                    </h3>
                    <p class="text-[13px] text-gray-700">Kami telah menyusun kerangka desain (mockup) khusus untuk {{ $client->brand_name }}. Anda dapat melihatnya pada tautan di bawah ini.</p>
                    <div class="hidden print:block text-[13px] font-medium text-blue-600 break-all mt-2 underline">
                        {{ route("landing.dynamic", $client->slug) }}
                    </div>
                </div>
                <a href="{{ route("landing.dynamic", $client->slug) }}" target="_blank" class="shrink-0 bg-brand-coffee hover:bg-brand-dark text-brand-cream px-5 py-2.5 rounded-full text-[13px] font-medium transition inline-flex items-center justify-center gap-2 no-print shadow-md">
                    Lihat Demo Web <i class="fas fa-external-link-alt text-[10px]"></i>
                </a>
            </div>
        </div>

        <!-- 2. Tujuan & Objektif -->
        <div class="mb-10">
            <h2 class="font-serif text-2xl font-bold text-brand-coffee mb-4 flex items-center gap-2">
                <span class="text-brand-caramel">02.</span> Objektif Proyek
            </h2>
            <ul class="space-y-3 text-sm text-gray-600">
                <li class="flex items-start gap-3">
                    <i class="fas fa-check text-brand-caramel mt-1"></i>
                    <span><strong>Branding & Image:</strong> Menampilkan identitas visual {{ $client->brand_name }} sebagai kedai kopi yang modern & berkelas.</span>
                </li>
                <li class="flex items-start gap-3">
                    <i class="fas fa-check text-brand-caramel mt-1"></i>
                    <span><strong>Digital Menu Berbasis QR:</strong> Mengurangi biaya cetak menu dengan menyediakan menu digital interaktif yang mudah diupdate (CMS).</span>
                </li>
                <li class="flex items-start gap-3">
                    <i class="fas fa-check text-brand-caramel mt-1"></i>
                    <span><strong>Reservasi & Pesan Antar:</strong> Terintegrasi dengan form reservasi meja atau pesanan melalui WhatsApp langsung.</span>
                </li>
            </ul>
        </div>
    </div>


    <!-- HALAMAN 2 -->
    <div class="proposal-page page-break">
        <div class="mb-8 mt-4">
            <h2 class="font-serif text-2xl font-bold text-brand-coffee mb-2 flex items-center gap-2">
                <span class="text-brand-caramel">03.</span> Pilihan Paket & Rincian Investasi
            </h2>
            <p class="text-sm text-gray-600 mb-6">Investasi pembuatan ekosistem digital untuk <strong>{{ $client->brand_name }}</strong> dengan berbagai opsi paket fleksibel:</p>

            @php
            $cleanWa = preg_replace('/[^0-9]/', '', $client->wa_number ?? '6281234567890');
            if (str_starts_with($cleanWa, '0')) {
            $cleanWa = '62' . substr($cleanWa, 1);
            }
            @endphp

            <!-- Tabel Perbandingan Paket & Fitur Cafe -->
            <div class="overflow-x-auto mb-6 rounded-xl border border-brand-caramel/30 bg-white shadow-xs">
                <table class="w-full text-left border-collapse text-[11px]">
                    <thead>
                        <tr class="border-b border-brand-caramel/30">
                            <th class="p-3.5 bg-brand-cream/40 font-serif text-brand-coffee font-bold w-[32%]">
                                <span class="text-[10px] uppercase tracking-wider block text-brand-caramel font-sans">Komparasi Layanan</span>
                                Paket & Spesifikasi Fitur
                            </th>
                            <!-- Silver -->
                            <th class="p-3 text-center bg-slate-50/70 border-l border-brand-caramel/20 w-[17%]">
                                <span class="font-serif font-bold text-sm text-brand-coffee block">Silver</span>
                                <span class="inline-block my-1 py-0.5 px-2 rounded-full border border-brand-caramel/50 bg-white text-[10px] font-bold text-brand-coffee">
                                    {{ \App\Models\ClientProposal::formatPackagePill($client->silver_price) }}
                                </span>
                                <span class="block text-[9px] text-stone-500">Perpanjangan {{ $client->silver_renewal }}</span>
                            </th>
                            <!-- Gold (Featured) -->
                            <th class="p-3 text-center bg-brand-coffee text-white border-x-2 border-brand-caramel w-[17%] relative">
                                <span class="absolute -top-2.5 left-1/2 -translate-x-1/2 bg-brand-caramel text-white text-[8px] font-black uppercase tracking-widest px-2 py-0.2 rounded-full shadow-xs">POPULER</span>
                                <span class="font-serif font-bold text-sm text-brand-cream block">Gold</span>
                                <span class="inline-block my-1 py-0.5 px-2 rounded-full border border-brand-caramel bg-brand-caramel/30 text-[10px] font-bold text-brand-cream">
                                    {{ \App\Models\ClientProposal::formatPackagePill($client->gold_price) }}
                                </span>
                                <span class="block text-[9px] text-brand-latte/80">Perpanjangan {{ $client->gold_renewal }}</span>
                            </th>
                            <!-- Diamond -->
                            <th class="p-3 text-center bg-slate-50/70 border-l border-brand-caramel/20 w-[17%]">
                                <span class="font-serif font-bold text-sm text-brand-coffee block">Diamond</span>
                                <span class="inline-block my-1 py-0.5 px-2 rounded-full border border-brand-caramel/50 bg-white text-[10px] font-bold text-brand-coffee">
                                    {{ \App\Models\ClientProposal::formatPackagePill($client->diamond_price) }}
                                </span>
                                <span class="block text-[9px] text-stone-500">Perpanjangan {{ $client->diamond_renewal }}</span>
                            </th>
                            <!-- Platinum -->
                            <th class="p-3 text-center bg-slate-50/70 border-l border-brand-caramel/20 w-[17%]">
                                <span class="font-serif font-bold text-sm text-brand-coffee block">Platinum</span>
                                <span class="inline-block my-1 py-0.5 px-2 rounded-full border border-brand-caramel/50 bg-white text-[10px] font-bold text-brand-coffee">
                                    {{ \App\Models\ClientProposal::formatPackagePill($client->platinum_price) }}
                                </span>
                                <span class="block text-[9px] text-stone-500">Perpanjangan {{ $client->platinum_renewal }}</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-brand-caramel/15 text-stone-700">
                        <!-- GROUP 1: TAMPILAN & DIGITAL MENU -->
                        <tr class="bg-brand-cream/30">
                            <td colspan="5" class="py-1.5 px-3.5 font-bold uppercase tracking-wider text-[10px] text-brand-coffee">
                                <i class="fas fa-utensils text-brand-caramel mr-1.5"></i> Desain Visual & Digital Menu
                            </td>
                        </tr>
                        <tr>
                            <td class="p-2.5 font-medium">Tipe Desain & Halaman Website</td>
                            <td class="p-2.5 text-center bg-slate-50/30">One-Page Showcase</td>
                            <td class="p-2.5 text-center bg-brand-cream/15 font-semibold text-brand-coffee">Multi-Page Ambiance</td>
                            <td class="p-2.5 text-center bg-slate-50/30 font-semibold">Multi-Page + Catalog</td>
                            <td class="p-2.5 text-center bg-slate-50/30 font-semibold">Custom Luxury Multi-Outlet</td>
                        </tr>
                        <tr>
                            <td class="p-2.5 font-medium">Sistem Tampilan Menu FnB</td>
                            <td class="p-2.5 text-center bg-slate-50/30">Menu Statis Gambar</td>
                            <td class="p-2.5 text-center bg-brand-cream/15 font-semibold text-brand-coffee">Digital Menu Interaktif (CMS)</td>
                            <td class="p-2.5 text-center bg-slate-50/30 font-semibold">Menu Interaktif + Badge Favorit</td>
                            <td class="p-2.5 text-center bg-slate-50/30 font-semibold">Menu Multi-Kategori Dinamis</td>
                        </tr>
                        <tr>
                            <td class="p-2.5 font-medium">QR Code Stand Meja (Scan Menu)</td>
                            <td class="p-2.5 text-center bg-slate-50/30 text-stone-300 font-bold">—</td>
                            <td class="p-2.5 text-center bg-brand-cream/15 text-brand-caramel font-bold"><i class="fas fa-check-circle text-sm"></i></td>
                            <td class="p-2.5 text-center bg-slate-50/30 text-brand-caramel font-bold"><i class="fas fa-check-circle text-sm"></i></td>
                            <td class="p-2.5 text-center bg-slate-50/30 text-brand-caramel font-bold"><i class="fas fa-check-circle text-sm"></i> Unlimited Meja</td>
                        </tr>
                        <tr>
                            <td class="p-2.5 font-medium">Galeri Suasana Tempat (Interior & Ambiance)</td>
                            <td class="p-2.5 text-center bg-slate-50/30">Foto Pilihan</td>
                            <td class="p-2.5 text-center bg-brand-cream/15 text-brand-coffee font-semibold">Galeri Interaktif HD</td>
                            <td class="p-2.5 text-center bg-slate-50/30 font-semibold">Galeri Interaktif HD</td>
                            <td class="p-2.5 text-center bg-slate-50/30 font-semibold">Virtual Tour / Full HD</td>
                        </tr>

                        <!-- GROUP 2: ORDER & OPERASIONAL BISNIS -->
                        <tr class="bg-brand-cream/30">
                            <td colspan="5" class="py-1.5 px-3.5 font-bold uppercase tracking-wider text-[10px] text-brand-coffee">
                                <i class="fas fa-cash-register text-brand-caramel mr-1.5"></i> Pemesanan & Manajemen Operasional
                            </td>
                        </tr>
                        <tr>
                            <td class="p-2.5 font-medium">Panel Admin CMS (Ganti Harga & Foto Mandiri)</td>
                            <td class="p-2.5 text-center bg-slate-50/30 text-stone-300 font-bold">—</td>
                            <td class="p-2.5 text-center bg-brand-cream/15 text-brand-caramel font-bold"><i class="fas fa-check-circle text-sm"></i> CMS Praktis</td>
                            <td class="p-2.5 text-center bg-slate-50/30 text-brand-caramel font-bold"><i class="fas fa-check-circle text-sm"></i> CMS Lengkap</td>
                            <td class="p-2.5 text-center bg-slate-50/30 text-brand-caramel font-bold"><i class="fas fa-check-circle text-sm"></i> CMS Enterprise</td>
                        </tr>
                        <tr>
                            <td class="p-2.5 font-medium">Reservasi Meja & Booking Event</td>
                            <td class="p-2.5 text-center bg-slate-50/30">WhatsApp Direct</td>
                            <td class="p-2.5 text-center bg-brand-cream/15 text-brand-coffee font-semibold">Formulir Reservasi Web</td>
                            <td class="p-2.5 text-center bg-slate-50/30 font-semibold">Formulir Reservasi Web</td>
                            <td class="p-2.5 text-center bg-slate-50/30 font-semibold">Kalender Reservasi Meja</td>
                        </tr>
                        <tr>
                            <td class="p-2.5 font-medium">Sistem Pesan Mandiri (Self-Ordering / Takeaway)</td>
                            <td class="p-2.5 text-center bg-slate-50/30 text-stone-300 font-bold">—</td>
                            <td class="p-2.5 text-center bg-brand-cream/15 text-stone-300 font-bold">—</td>
                            <td class="p-2.5 text-center bg-slate-50/30 text-brand-caramel font-bold"><i class="fas fa-check-circle text-sm"></i> Dine-in & Takeaway</td>
                            <td class="p-2.5 text-center bg-slate-50/30 text-brand-caramel font-bold"><i class="fas fa-check-circle text-sm"></i> Dine-in, Takeaway & Delivery</td>
                        </tr>
                        <tr>
                            <td class="p-2.5 font-medium">Payment Gateway Otomatis (QRIS & E-Wallet)</td>
                            <td class="p-2.5 text-center bg-slate-50/30 text-stone-300 font-bold">—</td>
                            <td class="p-2.5 text-center bg-brand-cream/15 text-stone-300 font-bold">—</td>
                            <td class="p-2.5 text-center bg-slate-50/30 text-brand-caramel font-bold"><i class="fas fa-check-circle text-sm"></i> QRIS Otomatis</td>
                            <td class="p-2.5 text-center bg-slate-50/30 text-brand-caramel font-bold"><i class="fas fa-check-circle text-sm"></i> Multi-Channel Payment</td>
                        </tr>
                        <tr>
                            <td class="p-2.5 font-medium">Dukungan Multi-Outlet / Multi-Cabang</td>
                            <td class="p-2.5 text-center bg-slate-50/30">1 Outlet</td>
                            <td class="p-2.5 text-center bg-brand-cream/15 text-brand-coffee">1 Outlet</td>
                            <td class="p-2.5 text-center bg-slate-50/30">1 Outlet</td>
                            <td class="p-2.5 text-center bg-slate-50/30 text-brand-caramel font-bold"><i class="fas fa-check-circle text-sm"></i> Multi-Cabang Terpusat</td>
                        </tr>
                        <tr>
                            <td class="p-2.5 font-medium">Program Loyalitas / Poin Reward Pelanggan</td>
                            <td class="p-2.5 text-center bg-slate-50/30 text-stone-300 font-bold">—</td>
                            <td class="p-2.5 text-center bg-brand-cream/15 text-stone-300 font-bold">—</td>
                            <td class="p-2.5 text-center bg-slate-50/30 text-stone-300 font-bold">—</td>
                            <td class="p-2.5 text-center bg-slate-50/30 text-brand-caramel font-bold"><i class="fas fa-check-circle text-sm"></i> Member Poin Reward</td>
                        </tr>

                        <!-- GROUP 3: SERVER & GARANSI -->
                        <tr class="bg-brand-cream/30">
                            <td colspan="5" class="py-1.5 px-3.5 font-bold uppercase tracking-wider text-[10px] text-brand-coffee">
                                <i class="fas fa-server text-brand-caramel mr-1.5"></i> Infrastruktur, Domain & Support
                            </td>
                        </tr>
                        <tr>
                            <td class="p-2.5 font-medium">Domain Kustom (.com / .id) & Cloud Hosting</td>
                            <td class="p-2.5 text-center bg-slate-50/30">1 Tahun</td>
                            <td class="p-2.5 text-center bg-brand-cream/15 font-semibold text-brand-coffee">1 Tahun Cloud SSD</td>
                            <td class="p-2.5 text-center bg-slate-50/30 font-semibold">1 Tahun High-Speed SSD</td>
                            <td class="p-2.5 text-center bg-slate-50/30 font-semibold text-brand-coffee">Dedicated Cloud Server</td>
                        </tr>
                        <tr>
                            <td class="p-2.5 font-medium">Garansi & Layanan Maintenance Teknis</td>
                            <td class="p-2.5 text-center bg-slate-50/30">1 Bulan</td>
                            <td class="p-2.5 text-center bg-brand-cream/15 font-semibold text-brand-coffee">3 Bulan</td>
                            <td class="p-2.5 text-center bg-slate-50/30 font-semibold">6 Bulan Prioritas</td>
                            <td class="p-2.5 text-center bg-slate-50/30 font-bold text-brand-coffee">1 Tahun Penuh (VIP)</td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr class="border-t-2 border-brand-caramel/40 bg-white">
                            <td class="p-3 font-bold text-stone-800">Aksi Pemesanan</td>
                            <td class="p-2.5 text-center bg-slate-50/50">
                                <a href="https://wa.me/{{ $cleanWa }}?text={{ urlencode('Halo Scalify, saya tertarik memesan Paket Silver untuk ' . $client->brand_name . '. Mohon info detailnya.') }}" target="_blank" class="inline-flex items-center justify-center gap-1 w-full py-1.5 px-2 rounded-lg bg-brand-coffee hover:bg-brand-dark text-brand-cream text-[10px] font-bold shadow-xs transition no-print">
                                    <i class="fab fa-whatsapp text-green-400"></i> Pilih Silver
                                </a>
                            </td>
                            <td class="p-2.5 text-center bg-brand-cream/20">
                                <a href="https://wa.me/{{ $cleanWa }}?text={{ urlencode('Halo Scalify, saya tertarik memesan Paket Gold untuk ' . $client->brand_name . '. Mohon info detailnya.') }}" target="_blank" class="inline-flex items-center justify-center gap-1 w-full py-2 px-2 rounded-lg bg-brand-caramel hover:bg-[#b08358] text-white text-[11px] font-extrabold shadow-md transition no-print">
                                    <i class="fab fa-whatsapp text-white"></i> Pilih Gold
                                </a>
                            </td>
                            <td class="p-2.5 text-center bg-slate-50/50">
                                <a href="https://wa.me/{{ $cleanWa }}?text={{ urlencode('Halo Scalify, saya tertarik memesan Paket Diamond untuk ' . $client->brand_name . '. Mohon info detailnya.') }}" target="_blank" class="inline-flex items-center justify-center gap-1 w-full py-1.5 px-2 rounded-lg bg-brand-coffee hover:bg-brand-dark text-brand-cream text-[10px] font-bold shadow-xs transition no-print">
                                    <i class="fab fa-whatsapp text-green-400"></i> Pilih Diamond
                                </a>
                            </td>
                            <td class="p-2.5 text-center bg-slate-50/50">
                                <a href="https://wa.me/{{ $cleanWa }}?text={{ urlencode('Halo Scalify, saya tertarik memesan Paket Platinum untuk ' . $client->brand_name . '. Mohon info detailnya.') }}" target="_blank" class="inline-flex items-center justify-center gap-1 w-full py-1.5 px-2 rounded-lg bg-brand-coffee hover:bg-brand-dark text-brand-cream text-[10px] font-bold shadow-xs transition no-print">
                                    <i class="fab fa-whatsapp text-green-400"></i> Pilih Platinum
                                </a>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <div class="bg-brand-cream/40 border-l-4 border-brand-caramel p-3.5 rounded-r-lg mb-6">
                <p class="text-[12px] text-gray-700 leading-relaxed">
                    <strong>Catatan:</strong> Seluruh paket di atas bersifat fleksibel. Kami sangat terbuka untuk berdiskusi lebih lanjut dan melakukan penyesuaian (customization) baik dari segi alur fitur maupun opsi termin pembayaran.
                </p>
            </div>
        </div>

        <div class="mt-8 border-t border-gray-200 pt-6 text-xs text-gray-600">
            <p class="mb-4">Demikian proposal penawaran pembuatan website ini kami sampaikan. Atas perhatian dan kerja samanya, kami ucapkan terima kasih.</p>
            <div class="flex justify-between items-end mt-8">
                <div class="text-center">
                    <p class="mb-14">Hormat Kami,</p>
                    <div class="border-b border-gray-400 w-44 mb-1 mx-auto"></div>
                    <p class="font-bold text-brand-coffee">M. Andi</p>
                    <p class="text-[11px] text-gray-500">Project Manager - Scalify</p>
                </div>
                <div class="text-center">
                    <p class="mb-14">Disetujui Oleh,</p>
                    <div class="border-b border-gray-400 w-44 mb-1 mx-auto"></div>
                    <p class="font-bold text-brand-coffee">.........................................</p>
                    <p class="text-[11px] text-gray-500">{{ $client->brand_name }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Detail Paket Cafe -->
    <div id="packageModal" class="fixed inset-0 bg-black/60 z-50 hidden items-center justify-center p-4 backdrop-blur-xs no-print">
        <div class="bg-white rounded-2xl max-w-lg w-full p-6 shadow-2xl relative animate-fade-in border border-brand-caramel/20">
            <button onclick="closePackageModal()" class="absolute top-4 right-4 w-8 h-8 rounded-full bg-stone-100 text-stone-500 hover:text-stone-800 hover:bg-stone-200 flex items-center justify-center transition">
                <i class="fas fa-times"></i>
            </button>

            <div class="flex items-center gap-3 mb-4">
                <div id="modalIcon" class="w-10 h-10 rounded-full bg-brand-cream text-brand-coffee flex items-center justify-center text-lg">
                    <i class="fas fa-award"></i>
                </div>
                <div>
                    <h3 id="modalTitle" class="text-lg font-bold text-brand-coffee font-serif">Detail Paket</h3>
                    <p id="modalPrice" class="text-xs font-bold text-brand-caramel"></p>
                </div>
            </div>

            <p id="modalDesc" class="text-xs text-stone-600 mb-4 bg-brand-cream/30 p-3 rounded-lg border border-brand-caramel/20"></p>

            <div class="mb-6">
                <h4 class="text-xs font-bold uppercase tracking-wider text-brand-coffee mb-2.5">Fasilitas & Fitur Termasuk:</h4>
                <ul id="modalFeatures" class="space-y-2 text-xs text-stone-600">
                    <!-- Dynamic List -->
                </ul>
            </div>

            <div class="flex gap-3 pt-3 border-t border-brand-cream">
                <button type="button" onclick="closePackageModal()" class="flex-1 py-2 px-4 rounded-xl border border-stone-200 text-stone-600 hover:bg-stone-50 text-xs font-semibold transition">
                    Tutup
                </button>
                <a id="modalWaBtn" href="#" target="_blank" class="flex-1 py-2 px-4 rounded-xl bg-brand-coffee hover:bg-brand-dark text-brand-cream text-xs font-bold flex items-center justify-center gap-1.5 shadow transition">
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
                , desc: 'Paket starter untuk memperkenalkan brand cafe secara online dengan tampilan simpel, estetik, dan navigasi praktis.'
                , features: [
                    'Website Landing Page Cafe Modern & Responsif (One-Page)'
                    , 'Daftar Menu Makanan & Minuman Pilihan (Statis)'
                    , 'Informasi Jam Operasional, Lokasi & Integrasi Google Maps Direct'
                    , 'Tombol Direct Reservasi & Order via WhatsApp'
                    , 'Domain Kustom (.com / .id) + Cloud Server 1 Tahun'
                    , 'Garansi Teknis 1 Bulan'
                ]
            }
            , gold: {
                title: 'Paket Gold (Paling Populer)'
                , price: '{{ \App\Models\ClientProposal::formatPackagePill($client->gold_price) }} (Perpanjangan {{ $client->gold_renewal }})'
                , desc: 'Website company profile dengan sistem Menu Digital QR Dinamis (CMS) yang dapat diubah dan diperbarui kapan saja secara mandiri.'
                , features: [
                    'Website Company Profile & Digital Menu Interaktif'
                    , 'QR Code Stand Meja (Pengunjung scan langsung di meja untuk melihat menu)'
                    , 'Panel Admin Mandiri (Tambah/Edit Menu, Kategori, Foto & Harga Tanpa Koding)'
                    , 'Galeri Suasana Tempat (Ambiance & Interior Cafe)'
                    , 'Formulir Reservasi Meja Otomatis Terhubung ke WhatsApp Kasir'
                    , 'Domain Kustom + Cloud Server SSD Cepat 1 Tahun + SSL'
                    , 'Garansi & Support Teknis 3 Bulan'
                ]
            }
            , diamond: {
                title: 'Paket Diamond'
                , price: '{{ \App\Models\ClientProposal::formatPackagePill($client->diamond_price) }} (Perpanjangan {{ $client->diamond_renewal }})'
                , desc: 'Solusi pemesanan mandiri (Self-Ordering / Takeaway) online langsung dari smartphone pelanggan dilengkapi fitur voucher promo.'
                , features: [
                    'Semua Fasilitas Unggulan Paket Gold'
                    , 'Sistem Order Online Mandiri (Takeaway / Dine-In via Website)'
                    , 'Integrasi Payment Gateway Otomatis (QRIS & E-Wallet)'
                    , 'Fitur Kupon Diskon, Promo Khusus & Badging Best Seller'
                    , 'Optimasi SEO Google Maps & Local Food Search'
                    , 'Garansi & Maintenance Prioritas 6 Bulan'
                ]
            }
            , platinum: {
                title: 'Paket Platinum (Multi-Outlet & Loyalty)'
                , price: '{{ \App\Models\ClientProposal::formatPackagePill($client->platinum_price) }} (Perpanjangan {{ $client->platinum_renewal }})'
                , desc: 'Ekosistem terlengkap untuk bisnis cafe skala menengah-besar dengan manajemen multi-cabang dan program loyalitas pelanggan.'
                , features: [
                    'Semua Fasilitas Lengkap Paket Diamond'
                    , 'Dukungan Multi-Outlet / Multi-Cabang dalam 1 Sistem Terpusat'
                    , 'Laporan Penjualan Digital & Analisis Menu Paling Laku'
                    , 'Program Loyalitas Member / Poin Reward Pelanggan Cafe'
                    , 'Desain 100% Kustom Mewah sesuai Konsep Interior & Brand Cafe'
                    , 'Dedicated Cloud Server Performa Tinggi'
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
                li.innerHTML = '<i class="fas fa-check-circle text-brand-caramel mt-0.5 shrink-0"></i> <span>' + feat + '</span>';
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
