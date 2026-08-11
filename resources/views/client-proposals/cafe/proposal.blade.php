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
        <div class="mb-10 mt-6">
            <h2 class="font-serif text-2xl font-bold text-brand-coffee mb-6 flex items-center gap-2">
                <span class="text-brand-caramel">03.</span> Rincian Investasi / Biaya
            </h2>
            <p class="text-sm text-gray-600 mb-6">Investasi pembuatan website FnB/Cafe dengan fitur Content Management System (CMS) untuk update menu mandiri.</p>

            <table class="w-full text-left text-sm mb-6 border-collapse">
                <thead>
                    <tr class="bg-gray-100 border-b-2 border-gray-300">
                        <th class="py-3 px-4 font-bold text-brand-coffee w-2/3">Deskripsi Layanan</th>
                        <th class="py-3 px-4 font-bold text-brand-coffee text-right w-1/3">Estimasi Biaya (IDR)</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="border-b border-gray-100">
                        <td class="py-4 px-4 text-gray-600">
                            <span class="font-bold text-brand-coffee block">Pengembangan Website Cafe & Digital Menu</span>
                            <span class="text-[12px]">Termasuk desain UI/UX, Backend CMS (Kelola Menu & Harga), Galeri Tempat, Integrasi Google Maps, dan SEO Basic.</span>
                        </td>
                        <td class="py-4 px-4 text-right font-medium text-brand-coffee align-top">Rp {{ number_format($client->project_price, 0, ",", ".") }}</td>
                    </tr>
                    <tr class="border-b border-gray-100">
                        <td class="py-4 px-4 text-gray-600">
                            <span class="font-bold text-brand-coffee block">Domain & Cloud Hosting Server (1 Tahun)</span>
                            <span class="text-[12px]">Domain kustom, Cloud Hosting stabil, dan setup SSL Certificate (HTTPS).</span>
                        </td>
                        <td class="py-4 px-4 text-right font-medium text-brand-coffee align-top">Rp {{ number_format($client->domain_price, 0, ",", ".") }}</td>
                    </tr>
                    <tr class="bg-gray-50 border-t-2 border-gray-300">
                        <td class="py-4 px-4 font-bold text-brand-coffee text-right">TOTAL INVESTASI :</td>
                        <td class="py-4 px-4 text-right font-bold text-brand-caramel text-lg">Rp {{ number_format($client->project_price + $client->domain_price, 0, ",", ".") }}</td>
                    </tr>
                </tbody>
            </table>

            <div class="bg-brand-cream/40 border-l-4 border-brand-caramel p-4 mt-8">
                <p class="text-[13px] text-gray-700 leading-relaxed">
                    Spesifikasi fitur dan estimasi biaya di atas bersifat fleksibel. Kami sangat terbuka untuk berdiskusi lebih lanjut dan melakukan penyesuaian (customization) baik dari segi fitur maupun rincian harga akhir.
                </p>
            </div>
        </div>

        <div class="mt-16 border-t border-gray-200 pt-10 text-sm text-gray-600">
            <p class="mb-12">Demikian proposal penawaran pembuatan website ini kami sampaikan. Atas perhatian dan kerja samanya, kami ucapkan terima kasih.</p>
            <div class="flex justify-between items-end">
                <div class="text-center">
                    <p class="mb-20">Hormat Kami,</p>
                    <div class="border-b border-gray-400 w-48 mb-1 mx-auto"></div>
                    <p class="font-bold text-brand-coffee">M. Andi</p>
                    <p class="text-xs text-gray-500">Project Manager - Scalify</p>
                </div>
                <div class="text-center">
                    <p class="mb-20">Disetujui Oleh,</p>
                    <div class="border-b border-gray-400 w-48 mb-1 mx-auto"></div>
                    <p class="font-bold text-brand-coffee">.........................................</p>
                    <p class="text-xs text-gray-500">{{ $client->brand_name }}</p>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
