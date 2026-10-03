<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Proposal SIM Klinik & Rekam Medis Digital - {{ $client->brand_name }}</title>
    <meta name="description" content="Proposal pengajuan implementasi Sistem Informasi Manajemen Klinik (SIM Klinik), Rekam Medis Elektronik (EMR), Antrean Suara, dan Apotek Digital.">

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500;600;700;800&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body {
            background-color: #f1f5f9;
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: #334155;
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
            body { background-color: white; }
            .proposal-page {
                margin: 0;
                box-shadow: none;
                width: 100%;
                padding: 0;
            }
            .no-print { display: none !important; }
            .page-break { page-break-before: always; }
        }
    </style>
</head>
<body class="antialiased">

    @php
    $cleanWa = preg_replace('/[^0-9]/', '', $client->wa_number ?? '6281234567890');
    if (str_starts_with($cleanWa, '0')) {
        $cleanWa = '62' . substr($cleanWa, 1);
    }
    $brandName = $client->brand_name ?? 'Klinik Pratama Medika Sehat';
    @endphp

    <!-- Floating Action Button -->
    <div class="fixed bottom-8 right-8 no-print z-50 flex items-center gap-2">
        <a href="{{ route('demo.customer.klinik', $client->slug) }}" target="_blank" class="bg-teal-800 hover:bg-teal-900 text-teal-200 border border-teal-500/30 px-5 py-3 rounded-full shadow-lg font-bold flex items-center gap-2 transition text-xs">
            <i class="fas fa-mobile-screen-button"></i>
            Buka Aplikasi Mobile
        </a>
        <button onclick="window.print()" class="bg-teal-700 hover:bg-teal-800 text-white px-6 py-3 rounded-full shadow-lg font-bold flex items-center gap-2 transition text-xs">
            <i class="fas fa-file-pdf"></i>
            Simpan PDF / Cetak
        </button>
    </div>

    <!-- HALAMAN 1 -->
    <div class="proposal-page">
        <!-- Cover Header -->
        <div class="border-b-4 border-teal-700 pb-8 mb-10 mt-6">
            <div class="flex justify-between items-end">
                <div>
                    <p class="text-teal-700 font-bold tracking-widest text-xs mb-2 uppercase">Proposal SIM Klinik & Rekam Medis</p>
                    <h1 class="text-3xl sm:text-4xl font-extrabold text-slate-900 leading-tight font-serif">
                        Sistem Informasi Manajemen Klinik,<br>Rekam Medis & Antrean Digital
                    </h1>
                </div>
                <div class="text-right">
                    <div class="w-14 h-14 rounded-2xl bg-teal-700 flex items-center justify-center text-white text-2xl ml-auto mb-3 shadow-md">
                        <i class="fas fa-stethoscope"></i>
                    </div>
                    <p class="font-bold text-slate-900 text-lg">{{ $brandName }}</p>
                    <p class="text-sm text-slate-500">{{ date('d F Y') }}</p>
                </div>
            </div>
        </div>

        <div class="mb-10 flex justify-between text-sm">
            <div>
                <p class="text-slate-400 mb-1">Disiapkan untuk:</p>
                <p class="font-bold text-slate-900 text-base">{{ $client->client_name ?? $brandName }}</p>
                <p class="text-slate-600">Direktur & Manajemen Pelayanan Medis Klinik</p>
            </div>
            <div class="text-right">
                <p class="text-slate-400 mb-1">Disiapkan oleh:</p>
                <p class="font-bold text-slate-900 text-base">Scalify Intelligence</p>
                <p class="text-slate-600">Health-Tech & Digital Systems Architecture</p>
            </div>
        </div>

        <!-- 1. Pendahuluan -->
        <div class="mb-9">
            <h2 class="text-xl font-bold text-slate-900 mb-3 flex items-center gap-2">
                <span class="text-teal-700">01.</span> Latar Belakang & Kebutuhan SIM Klinik
            </h2>
            <p class="text-slate-600 leading-relaxed text-sm text-justify mb-3">
                Klinik modern memerlukan efisiensi alur operasional mulai dari <strong>pendaftaran pasien, panggilan antrean otomatis bersuara, rekam medis elektronik (EMR) berbasis ICD-10, peracikan e-resep farmasi, hingga kasir pembayaran</strong>. Sistem terintegrasi memastikan tidak ada rekam medis kertas yang tercecer, mempercepat waktu tunggu pasien, dan menjamin akurasi stok obat di apotek.
            </p>

            <div class="mt-5 bg-teal-50 border border-teal-200 rounded-xl p-4 flex flex-col md:flex-row md:items-center justify-between gap-3">
                <div>
                    <h3 class="font-bold text-teal-900 text-sm mb-1 flex items-center gap-2">
                        <i class="fas fa-mobile-screen-button text-teal-700"></i> Prototype Langsung SIM Klinik Mobile
                    </h3>
                    <p class="text-xs text-slate-600">Telah disiapkan sistem aplikasi mobile lengkap dengan 8 modul interaktif untuk {{ $brandName }}.</p>
                </div>
                <div class="flex items-center gap-2 no-print shrink-0">
                    <a href="{{ route('demo.customer.klinik', $client->slug) }}" target="_blank" class="bg-teal-700 hover:bg-teal-800 text-white px-4 py-2 rounded-full text-xs font-bold transition inline-flex items-center gap-1.5 shadow-sm">
                        Buka Aplikasi Demo <i class="fas fa-arrow-right text-[10px]"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- 2. Rincian 8 Modul Utama -->
        <div class="mb-8">
            <h2 class="text-xl font-bold text-slate-900 mb-3 flex items-center gap-2">
                <span class="text-teal-700">02.</span> Cakupan 8 Modul Lengkap
            </h2>
            <div class="grid grid-cols-2 gap-3 text-xs text-slate-600">
                <div class="p-3 rounded-lg bg-slate-50 border border-slate-200">
                    <strong class="text-slate-900 block mb-1">1. Manajemen Pasien:</strong>
                    Registrasi pasien, nomor RM otomatis, kartu pasien digital barcode/QR, pencarian data & riwayat diagnosis.
                </div>
                <div class="p-3 rounded-lg bg-slate-50 border border-slate-200">
                    <strong class="text-slate-900 block mb-1">2. Booking & Appointment:</strong>
                    Jadwal praktek dokter, booking sesi konsultasi, reschedule, pembatalan & reminder via WhatsApp.
                </div>
                <div class="p-3 rounded-lg bg-slate-50 border border-slate-200">
                    <strong class="text-slate-900 block mb-1">3. Antrean Multi-Poli:</strong>
                    Nomor tiket otomatis (A/B/C/D/F), panggil suara synthesizer, status antrean & mode display monitor TV.
                </div>
                <div class="p-3 rounded-lg bg-slate-50 border border-slate-200">
                    <strong class="text-slate-900 block mb-1">4. Rekam Medis (EMR):</strong>
                    Anamnesis keluhan, tanda vital (TTV), diagnosa standar ICD-10, tindakan medis & riwayat pemeriksaan.
                </div>
                <div class="p-3 rounded-lg bg-slate-50 border border-slate-200">
                    <strong class="text-slate-900 block mb-1">5. Resep & Farmasi:</strong>
                    e-Resep dokter, dosis & aturan pakai, status peracikan obat, dan pengeluaran obat pasien.
                </div>
                <div class="p-3 rounded-lg bg-slate-50 border border-slate-200">
                    <strong class="text-slate-900 block mb-1">6. Inventory Obat:</strong>
                    Stok real-time, obat masuk/keluar, expired date tracker, peringatan minimum stock & laporan apotek.
                </div>
                <div class="p-3 rounded-lg bg-slate-50 border border-slate-200">
                    <strong class="text-slate-900 block mb-1">7. Pembayaran & Kasir:</strong>
                    Biaya dokter, tindakan, obat farmasi, kwitansi struk kasir thermal, status pembayaran QRIS & BPJS.
                </div>
                <div class="p-3 rounded-lg bg-slate-50 border border-slate-200">
                    <strong class="text-slate-900 block mb-1">8. Dashboard & Administrasi:</strong>
                    KPI statistik harian, grafik kunjungan, laporan omset, manajemen hak akses staf dokter & audit trail.
                </div>
            </div>
        </div>
    </div>

    <!-- HALAMAN 2 -->
    <div class="proposal-page page-break">
        <div class="mb-8 mt-4">
            <h2 class="text-2xl font-bold text-slate-900 mb-2 flex items-center gap-2">
                <span class="text-teal-700">03.</span> Rincian Paket & Investasi
            </h2>
            <p class="text-xs text-slate-600 mb-5">Pilihan paket implementasi sistem SIM Klinik & Rekam Medis untuk <strong>{{ $brandName }}</strong>:</p>

            <div class="grid grid-cols-3 gap-4 mb-6">
                <!-- Silver -->
                <div class="border border-slate-200 rounded-xl p-4 bg-white shadow-xs">
                    <h3 class="font-bold text-slate-800 text-sm">Silver</h3>
                    <div class="text-lg font-black text-slate-900 my-1">
                        {{ \App\Models\ClientProposal::formatPackagePill($client->silver_price) }}
                    </div>
                    <p class="text-[10px] text-slate-500 mb-3">Perpanjangan {{ $client->silver_renewal }}</p>
                    <ul class="text-[11px] text-slate-600 space-y-1.5 border-t pt-2">
                        <li>✓ SIM Klinik Dasar</li>
                        <li>✓ Antrean Nomor Otomatis</li>
                        <li>✓ EMR Pasien Standard</li>
                        <li>✓ Hingga 3 Poli & Dokter</li>
                    </ul>
                </div>

                <!-- Gold (Featured) -->
                <div class="border-2 border-teal-600 rounded-xl p-4 bg-teal-50/50 shadow-md relative">
                    <span class="absolute -top-2.5 right-3 bg-teal-700 text-white text-[9px] font-bold px-2 py-0.5 rounded-full">POPULER</span>
                    <h3 class="font-bold text-teal-900 text-sm">Gold</h3>
                    <div class="text-lg font-black text-teal-900 my-1">
                        {{ \App\Models\ClientProposal::formatPackagePill($client->gold_price) }}
                    </div>
                    <p class="text-[10px] text-teal-700 mb-3">Perpanjangan {{ $client->gold_renewal }}</p>
                    <ul class="text-[11px] text-slate-700 space-y-1.5 border-t border-teal-200 pt-2 font-medium">
                        <li>✓ Full 8 Modul Lengkap</li>
                        <li>✓ Panggilan Suara Audio Suara</li>
                        <li>✓ e-Resep & Inventory Obat</li>
                        <li>✓ Reminder WhatsApp Otomatis</li>
                        <li>✓ Kartu Pasien Digital QR</li>
                    </ul>
                </div>

                <!-- Diamond -->
                <div class="border border-slate-200 rounded-xl p-4 bg-white shadow-xs">
                    <h3 class="font-bold text-slate-800 text-sm">Diamond</h3>
                    <div class="text-lg font-black text-slate-900 my-1">
                        {{ \App\Models\ClientProposal::formatPackagePill($client->diamond_price) }}
                    </div>
                    <p class="text-[10px] text-slate-500 mb-3">Perpanjangan {{ $client->diamond_renewal }}</p>
                    <ul class="text-[11px] text-slate-600 space-y-1.5 border-t pt-2">
                        <li>✓ Semua Fitur Gold</li>
                        <li>✓ Multi-Cabang / Poliklinik</li>
                        <li>✓ Integrasi Bridging SATUSEHAT</li>
                        <li>✓ Backup Otomatis Harian</li>
                    </ul>
                </div>
            </div>

            <div class="bg-teal-50 border-l-4 border-teal-700 p-3 rounded-r-lg mb-6 text-xs text-slate-700 leading-relaxed">
                <strong>Catatan:</strong> Seluruh paket sudah termasuk instalasi server cloud berkecepatan tinggi, backup data medis berkala, garansi maintenance 1 tahun, serta pelatihan staf administrasi, perawat, apoteker, dan dokter klinik.
            </div>
        </div>

        <div class="mt-6 border-t border-slate-200 pt-5 text-xs text-slate-600">
            <p class="mb-4">Demikian proposal penawaran Sistem Informasi Manajemen Klinik & Rekam Medis ini kami ajukan untuk {{ $brandName }}.</p>
            <div class="flex justify-between items-end mt-8">
                <div class="text-center">
                    <p class="mb-12">Hormat Kami,</p>
                    <div class="border-b border-slate-400 w-40 mb-1 mx-auto"></div>
                    <p class="font-bold text-slate-900">M. Andi</p>
                    <p class="text-[10px] text-slate-500">Lead Tech Solutions - Scalify</p>
                </div>
                <div class="text-center">
                    <p class="mb-12">Disetujui Oleh,</p>
                    <div class="border-b border-slate-400 w-40 mb-1 mx-auto"></div>
                    <p class="font-bold text-slate-900">{{ $client->client_name ?? $brandName }}</p>
                    <p class="text-[10px] text-slate-500">Manajemen Klinik</p>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
