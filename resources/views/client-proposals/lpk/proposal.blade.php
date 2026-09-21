<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Proposal Proyek Website & LMS LPK - {{ $client->brand_name }}</title>
    <meta name="description" content="Proposal penawaran pengembangan website profil, sistem LMS modul, ujian CBT online, absensi QR, e-sertifikat terverifikasi, dan pendaftaran calon pekerja untuk {{ $client->brand_name }} oleh Scalify Intelligence.">

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        lpk: {
                            50: '#eff6ff',
                            100: '#dbeafe',
                            200: '#bfdbfe',
                            500: '#3b82f6',
                            600: '#2563eb',
                            700: '#1d4ed8',
                            800: '#1e40af',
                            900: '#1e3a8a',
                            dark: '#0f172a',
                            navy: '#0f172a',
                            accent: '#f59e0b',
                            emerald: '#10b981'
                        }
                    },
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'Inter', 'sans-serif'],
                        heading: ['Montserrat', 'Plus Jakarta Sans', 'sans-serif']
                    }
                }
            }
        }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500;600;700;800;900&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body {
            background-color: #f1f5f9;
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: #334155;
        }

        h1, h2, h3, h4, h5, .font-heading {
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

    @php
        $cleanWa = preg_replace('/[^0-9]/', '', $client->wa_number ?? '6281234567890');
        if (str_starts_with($cleanWa, '0')) {
            $cleanWa = '62' . substr($cleanWa, 1);
        }
        $brandName = $client->brand_name ?? 'LPK Lembaga Pelatihan Kerja';
    @endphp

    <!-- Floating Action Button for PDF Print -->
    <div class="fixed bottom-8 right-8 no-print z-50">
        <button onclick="window.print()" class="bg-blue-700 hover:bg-blue-800 text-white px-6 py-3 rounded-full shadow-lg font-bold flex items-center gap-2 transition">
            <i class="fas fa-file-pdf"></i>
            Simpan sebagai PDF
        </button>
    </div>

    <!-- HALAMAN 1 -->
    <div class="proposal-page">
        <!-- Cover Header -->
        <div class="border-b-4 border-blue-600 pb-8 mb-10 mt-6">
            <div class="flex justify-between items-end">
                <div>
                    <p class="text-blue-600 font-bold tracking-widest text-xs mb-2 uppercase">Proposal Proyek Digitalisasi Pendidikan & Pelatihan</p>
                    <h1 class="font-heading text-3xl font-extrabold text-slate-900 leading-tight">
                        Pengembangan Sistem Website LPK,<br>LMS E-Learning, Ujian CBT & Sertifikasi
                    </h1>
                </div>
                <div class="text-right">
                    <div class="w-14 h-14 rounded-2xl bg-blue-600 flex items-center justify-center text-white text-2xl ml-auto mb-3 shadow-md">
                        <i class="fas fa-graduation-cap"></i>
                    </div>
                    <p class="font-heading font-bold text-slate-900 text-lg">{{ $brandName }}</p>
                    <p class="text-sm text-slate-500">{{ date('d F Y') }}</p>
                </div>
            </div>
        </div>

        <div class="mb-10 flex justify-between text-sm">
            <div>
                <p class="text-slate-400 mb-1">Disiapkan untuk:</p>
                <p class="font-bold text-slate-900 text-base">{{ $client->client_name ?? $brandName }}</p>
                <p class="text-slate-600">Lembaga Pelatihan Kerja & Penyaluran Tenaga Kerja</p>
            </div>
            <div class="text-right">
                <p class="text-slate-400 mb-1">Disiapkan oleh:</p>
                <p class="font-bold text-slate-900 text-base">Scalify Intelligence</p>
                <p class="text-slate-600">Digital Solutions & Educational Tech Agency</p>
            </div>
        </div>

        <!-- 1. Pendahuluan & Latar Belakang -->
        <div class="mb-9">
            <h2 class="font-heading text-xl font-bold text-slate-900 mb-3 flex items-center gap-2">
                <span class="text-blue-600">01.</span> Pendahuluan & Latar Belakang
            </h2>
            <p class="text-slate-600 leading-relaxed text-xs text-justify mb-3">
                Dalam era globalisasi tenaga kerja saat ini, Lembaga Pelatihan Kerja (LPK) menghadapi tantangan operasional dan akreditasi yang semakin tinggi. Calon peserta pelatihan, orang tua siswa, serta <em>Accepting Organization (AO)</em> mitra di Jepang, Korea, Jerman, maupun industri maritim/kapal pesiar membutuhkan kepastian mutu: <strong>kurikulum berbasis kompetensi yang transparan, modul e-learning yang rapi, evaluasi pretest/posttest terukur, absensi kehadiran siswa yang disiplin, serta e-sertifikat yang dapat diverifikasi secara instan</strong>.
            </p>
            <p class="text-slate-600 leading-relaxed text-xs text-justify">
                Pengelolaan pelatihan secara manual sering kali menimbulkan kendala: rekap absensi yang tercecer untuk laporan Disnaker, lamanya koreksi ujian kertas, serta kesulitan calon sponsor memvalidasi keaslian sertifikat lulusan. Proposal ini dirancang untuk membangun ekosistem digital terintegrasi bagi <strong>{{ $brandName }}</strong>.
            </p>

            <div class="mt-5 bg-blue-50 border border-blue-200 rounded-xl p-4 flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <h3 class="font-bold text-blue-900 text-xs mb-1 flex items-center gap-2">
                        <i class="fas fa-desktop text-blue-600"></i> Preview Draft Website & Demo Sistem LPK
                    </h3>
                    <p class="text-[12px] text-slate-600">Kami telah menyusun kerangka visual, modul LMS, dan simulasi ujian CBT khusus untuk {{ $brandName }}.</p>
                    <div class="hidden print:block text-[12px] font-medium text-blue-600 break-all mt-1.5 underline">
                        {{ route('landing.dynamic', $client->slug) }}
                    </div>
                </div>
                <a href="{{ route('landing.dynamic', $client->slug) }}" target="_blank" class="shrink-0 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-full text-xs font-bold transition inline-flex items-center justify-center gap-1.5 no-print shadow-md">
                    Lihat Demo Web <i class="fas fa-external-link-alt text-[10px]"></i>
                </a>
            </div>
        </div>

        <!-- 2. Objektif & Solusi Utama Sistem -->
        <div class="mb-6">
            <h2 class="font-heading text-xl font-bold text-slate-900 mb-3 flex items-center gap-2">
                <span class="text-blue-600">02.</span> Objektif & Solusi Utama Sistem LPK
            </h2>
            <ul class="space-y-2.5 text-xs text-slate-600">
                <li class="flex items-start gap-2.5">
                    <i class="fas fa-check-circle text-blue-600 mt-0.5 shrink-0"></i>
                    <span><strong>Modul E-Learning & Silabus Terstruktur:</strong> Materi pembelajaran (E-book PDF, video, audio percakapan) tersusun rapi per bab dengan panduan jam pelajaran (JP) sesuai standar BNSP.</span>
                </li>
                <li class="flex items-start gap-2.5">
                    <i class="fas fa-check-circle text-blue-600 mt-0.5 shrink-0"></i>
                    <span><strong>Simulasi Ujian Online (Pretest, Posttest & CBT):</strong> Pengacakan bank soal, pembatasan durasi ujian, anti-cheat, dan penilaian skor otomatis instan untuk mengukur kesiapan kerja siswa.</span>
                </li>
                <li class="flex items-start gap-2.5">
                    <i class="fas fa-check-circle text-blue-600 mt-0.5 shrink-0"></i>
                    <span><strong>Presensi & Absensi Digital Siswa (QR Code & GPS):</strong> Pencatatan kehadiran harian siswa secara cepat dan otomatis diexport ke laporan bulanan format Excel untuk Disnaker / Sponsor.</span>
                </li>
                <li class="flex items-start gap-2.5">
                    <i class="fas fa-check-circle text-blue-600 mt-0.5 shrink-0"></i>
                    <span><strong>E-Sertifikat Terverifikasi QR Code:</strong> Mengamankan kredibilitas LPK dengan halaman validasi publik sertifikat untuk mengecek keaslian kompetensi lulusan oleh user luar negeri.</span>
                </li>
                <li class="flex items-start gap-2.5">
                    <i class="fas fa-check-circle text-blue-600 mt-0.5 shrink-0"></i>
                    <span><strong>Pendaftaran Calon Pekerja Online:</strong> Formulir registrasi terintegrasi WhatsApp untuk menjaring pendaftaran calon tenaga kerja dari berbagai daerah 24/7.</span>
                </li>
            </ul>
        </div>
    </div>

    <!-- HALAMAN 2 -->
    <div class="proposal-page page-break">
        <div class="mb-6 mt-4">
            <h2 class="font-heading text-xl font-bold text-slate-900 mb-2 flex items-center gap-2">
                <span class="text-blue-600">03.</span> Pilihan Paket & Rincian Investasi
            </h2>
            <p class="text-xs text-slate-600 mb-5">Rincian komparasi paket implementasi sistem website & LMS LPK untuk <strong>{{ $brandName }}</strong>:</p>

            <!-- Tabel Komparasi Paket LPK -->
            <div class="overflow-x-auto mb-5 rounded-xl border border-slate-200 bg-white shadow-xs">
                <table class="w-full text-left border-collapse text-[10px]">
                    <thead>
                        <tr class="border-b border-slate-200">
                            <th class="p-3 bg-slate-50 font-heading text-slate-900 font-bold w-[32%]">
                                <span class="text-[9px] uppercase tracking-wider block text-blue-600 font-sans">Komparasi Layanan</span>
                                Paket & Spesifikasi Fitur
                            </th>
                            <!-- Silver -->
                            <th class="p-2.5 text-center bg-slate-50/70 border-l border-slate-200 w-[17%]">
                                <span class="font-heading font-bold text-xs text-slate-900 block">Silver</span>
                                <span class="inline-block my-1 py-0.5 px-2 rounded-full border border-slate-300 bg-white text-[9px] font-bold text-slate-800">
                                    {{ \App\Models\ClientProposal::formatPackagePill($client->silver_price) }}
                                </span>
                                <span class="block text-[8px] text-slate-500">Perpanjangan {{ $client->silver_renewal }}</span>
                            </th>
                            <!-- Gold (Featured) -->
                            <th class="p-2.5 text-center bg-slate-900 text-white border-x-2 border-blue-600 w-[17%] relative">
                                <span class="absolute -top-2.5 left-1/2 -translate-x-1/2 bg-amber-500 text-slate-900 text-[7.5px] font-black uppercase tracking-widest px-2 py-0.2 rounded-full shadow-xs">POPULER</span>
                                <span class="font-heading font-bold text-xs text-white block">Gold</span>
                                <span class="inline-block my-1 py-0.5 px-2 rounded-full border border-blue-500 bg-blue-950 text-[9px] font-bold text-blue-100">
                                    {{ \App\Models\ClientProposal::formatPackagePill($client->gold_price) }}
                                </span>
                                <span class="block text-[8px] text-blue-200">Perpanjangan {{ $client->gold_renewal }}</span>
                            </th>
                            <!-- Diamond -->
                            <th class="p-2.5 text-center bg-slate-50/70 border-l border-slate-200 w-[17%]">
                                <span class="font-heading font-bold text-xs text-slate-900 block">Diamond</span>
                                <span class="inline-block my-1 py-0.5 px-2 rounded-full border border-slate-300 bg-white text-[9px] font-bold text-slate-800">
                                    {{ \App\Models\ClientProposal::formatPackagePill($client->diamond_price) }}
                                </span>
                                <span class="block text-[8px] text-slate-500">Perpanjangan {{ $client->diamond_renewal }}</span>
                            </th>
                            <!-- Platinum -->
                            <th class="p-2.5 text-center bg-slate-50/70 border-l border-slate-200 w-[17%]">
                                <span class="font-heading font-bold text-xs text-slate-900 block">Platinum</span>
                                <span class="inline-block my-1 py-0.5 px-2 rounded-full border border-slate-300 bg-white text-[9px] font-bold text-slate-800">
                                    {{ \App\Models\ClientProposal::formatPackagePill($client->platinum_price) }}
                                </span>
                                <span class="block text-[8px] text-slate-500">Perpanjangan {{ $client->platinum_renewal }}</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-slate-700">
                        <!-- GROUP 1: WEBSITE PROFIL & KATALOG -->
                        <tr class="bg-blue-50/60">
                            <td colspan="5" class="py-1 px-3 font-bold uppercase tracking-wider text-[9.5px] text-blue-900">
                                <i class="fas fa-globe text-blue-600 mr-1"></i> Profil Lembaga & Pendaftaran Online
                            </td>
                        </tr>
                        <tr>
                            <td class="p-2 font-medium">Halaman Profil LPK & Akreditasi Disnaker</td>
                            <td class="p-2 text-center bg-slate-50/30 text-emerald-600 font-bold"><i class="fas fa-check"></i></td>
                            <td class="p-2 text-center bg-blue-50/30 text-emerald-600 font-bold"><i class="fas fa-check"></i></td>
                            <td class="p-2 text-center bg-slate-50/30 text-emerald-600 font-bold"><i class="fas fa-check"></i></td>
                            <td class="p-2 text-center bg-slate-50/30 text-emerald-600 font-bold"><i class="fas fa-check"></i> Custom Desain</td>
                        </tr>
                        <tr>
                            <td class="p-2 font-medium">Katalog Program Pelatihan Kerja & Modul</td>
                            <td class="p-2 text-center bg-slate-50/30">Hingga 3 Program</td>
                            <td class="p-2 text-center bg-blue-50/30 font-semibold text-slate-900">Hingga 10 Program</td>
                            <td class="p-2 text-center bg-slate-50/30 font-semibold">Unlimited Program</td>
                            <td class="p-2 text-center bg-slate-50/30 font-semibold">Multi Cabang LPK</td>
                        </tr>
                        <tr>
                            <td class="p-2 font-medium">Form Pendaftaran Calon Pekerja (WhatsApp Auto-Sync)</td>
                            <td class="p-2 text-center bg-slate-50/30 text-emerald-600 font-bold"><i class="fas fa-check"></i> Form Dasar</td>
                            <td class="p-2 text-center bg-blue-50/30 text-emerald-600 font-bold"><i class="fas fa-check"></i> Multi-Step Form</td>
                            <td class="p-2 text-center bg-slate-50/30 text-emerald-600 font-bold"><i class="fas fa-check"></i> Form + Upload CV</td>
                            <td class="p-2 text-center bg-slate-50/30 text-emerald-600 font-bold"><i class="fas fa-check"></i> Full CRM Siswa</td>
                        </tr>

                        <!-- GROUP 2: LMS & CBT UJIAN -->
                        <tr class="bg-blue-50/60">
                            <td colspan="5" class="py-1 px-3 font-bold uppercase tracking-wider text-[9.5px] text-blue-900">
                                <i class="fas fa-laptop-file text-blue-600 mr-1"></i> LMS Modul E-Learning & Ujian Online CBT
                            </td>
                        </tr>
                        <tr>
                            <td class="p-2 font-medium">Modul E-Learning (Materi E-book & Video)</td>
                            <td class="p-2 text-center bg-slate-50/30 text-slate-300 font-bold">—</td>
                            <td class="p-2 text-center bg-blue-50/30 text-blue-600 font-bold"><i class="fas fa-check"></i> Lengkap</td>
                            <td class="p-2 text-center bg-slate-50/30 text-blue-600 font-bold"><i class="fas fa-check"></i> Lengkap + Video</td>
                            <td class="p-2 text-center bg-slate-50/30 text-blue-600 font-bold"><i class="fas fa-check"></i> Enterprise LMS</td>
                        </tr>
                        <tr>
                            <td class="p-2 font-medium">Simulasi Pretest, Posttest & CBT Tryout</td>
                            <td class="p-2 text-center bg-slate-50/30 text-slate-300 font-bold">—</td>
                            <td class="p-2 text-center bg-blue-50/30 text-blue-600 font-bold"><i class="fas fa-check"></i> Bank Soal CBT</td>
                            <td class="p-2 text-center bg-slate-50/30 text-blue-600 font-bold"><i class="fas fa-check"></i> Acak Soal + Timer</td>
                            <td class="p-2 text-center bg-slate-50/30 text-blue-600 font-bold"><i class="fas fa-check"></i> Multi-Kategori Ujian</td>
                        </tr>
                        <tr>
                            <td class="p-2 font-medium">Sistem Penilaian & Rapor Kompetensi Siswa</td>
                            <td class="p-2 text-center bg-slate-50/30 text-slate-300 font-bold">—</td>
                            <td class="p-2 text-center bg-blue-50/30 font-semibold text-slate-900">Skor Instan</td>
                            <td class="p-2 text-center bg-slate-50/30 font-semibold">Rapor PDF Otomatis</td>
                            <td class="p-2 text-center bg-slate-50/30 font-semibold">Transkrip Nilai BNSP</td>
                        </tr>

                        <!-- GROUP 3: PRESENSI & E-SERTIFIKAT -->
                        <tr class="bg-blue-50/60">
                            <td colspan="5" class="py-1 px-3 font-bold uppercase tracking-wider text-[9.5px] text-blue-900">
                                <i class="fas fa-id-card-clip text-blue-600 mr-1"></i> Presensi Absensi, E-Sertifikat & Instruktur
                            </td>
                        </tr>
                        <tr>
                            <td class="p-2 font-medium">Sistem Presensi & Absensi Siswa (QR Code & GPS)</td>
                            <td class="p-2 text-center bg-slate-50/30 text-slate-300 font-bold">—</td>
                            <td class="p-2 text-center bg-blue-50/30 text-blue-600 font-bold"><i class="fas fa-check"></i> Presensi QR</td>
                            <td class="p-2 text-center bg-slate-50/30 text-blue-600 font-bold"><i class="fas fa-check"></i> QR + GPS Location</td>
                            <td class="p-2 text-center bg-slate-50/30 text-blue-600 font-bold"><i class="fas fa-check"></i> Rekap Disnaker Excel</td>
                        </tr>
                        <tr>
                            <td class="p-2 font-medium">E-Sertifikat Digital & QR Code Verification</td>
                            <td class="p-2 text-center bg-slate-50/30 text-slate-300 font-bold">—</td>
                            <td class="p-2 text-center bg-blue-50/30 text-blue-600 font-bold"><i class="fas fa-check"></i> Cek QR Publik</td>
                            <td class="p-2 text-center bg-slate-50/30 text-blue-600 font-bold"><i class="fas fa-check"></i> E-Sertifikat PDF</td>
                            <td class="p-2 text-center bg-slate-50/30 text-blue-600 font-bold"><i class="fas fa-check"></i> Auto Serial Generator</td>
                        </tr>

                        <!-- GROUP 4: SERVER & GARANSI -->
                        <tr class="bg-blue-50/60">
                            <td colspan="5" class="py-1 px-3 font-bold uppercase tracking-wider text-[9.5px] text-blue-900">
                                <i class="fas fa-server text-blue-600 mr-1"></i> Infrastruktur Server & Support
                            </td>
                        </tr>
                        <tr>
                            <td class="p-2 font-medium">Domain Kustom (.com / .sch.id / .id) & Cloud Hosting</td>
                            <td class="p-2 text-center bg-slate-50/30">1 Tahun SSD</td>
                            <td class="p-2 text-center bg-blue-50/30 font-semibold text-slate-900">1 Tahun Cloud SSD</td>
                            <td class="p-2 text-center bg-slate-50/30 font-semibold">1 Tahun NVMe Fast</td>
                            <td class="p-2 text-center bg-slate-50/30 font-bold text-slate-900">Dedicated Cloud Server</td>
                        </tr>
                        <tr>
                            <td class="p-2 font-medium">Garansi & Layanan Maintenance Teknis</td>
                            <td class="p-2 text-center bg-slate-50/30">1 Bulan</td>
                            <td class="p-2 text-center bg-blue-50/30 font-semibold text-slate-900">3 Bulan Prioritas</td>
                            <td class="p-2 text-center bg-slate-50/30 font-semibold">6 Bulan Prioritas</td>
                            <td class="p-2 text-center bg-slate-50/30 font-bold text-slate-900">1 Tahun VIP Full Support</td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr class="border-t-2 border-slate-300 bg-white">
                            <td class="p-2.5 font-bold text-slate-800">Aksi Pemesanan</td>
                            <td class="p-2 text-center bg-slate-50/50">
                                <a href="https://wa.me/{{ $cleanWa }}?text={{ urlencode('Halo Scalify, saya tertarik memesan Paket Silver untuk ' . $brandName . '. Mohon info detailnya.') }}" target="_blank" class="inline-flex items-center justify-center gap-1 w-full py-1.5 px-2 rounded-lg bg-slate-800 hover:bg-slate-900 text-white text-[9.5px] font-bold shadow-xs transition no-print">
                                    <i class="fab fa-whatsapp text-emerald-400"></i> Pilih Silver
                                </a>
                            </td>
                            <td class="p-2 text-center bg-blue-50/30">
                                <a href="https://wa.me/{{ $cleanWa }}?text={{ urlencode('Halo Scalify, saya tertarik memesan Paket Gold untuk ' . $brandName . '. Mohon info detailnya.') }}" target="_blank" class="inline-flex items-center justify-center gap-1 w-full py-1.5 px-2 rounded-lg bg-blue-600 hover:bg-blue-700 text-white text-[10px] font-extrabold shadow-md transition no-print">
                                    <i class="fab fa-whatsapp text-white"></i> Pilih Gold
                                </a>
                            </td>
                            <td class="p-2 text-center bg-slate-50/50">
                                <a href="https://wa.me/{{ $cleanWa }}?text={{ urlencode('Halo Scalify, saya tertarik memesan Paket Diamond untuk ' . $brandName . '. Mohon info detailnya.') }}" target="_blank" class="inline-flex items-center justify-center gap-1 w-full py-1.5 px-2 rounded-lg bg-slate-800 hover:bg-slate-900 text-white text-[9.5px] font-bold shadow-xs transition no-print">
                                    <i class="fab fa-whatsapp text-emerald-400"></i> Pilih Diamond
                                </a>
                            </td>
                            <td class="p-2 text-center bg-slate-50/50">
                                <a href="https://wa.me/{{ $cleanWa }}?text={{ urlencode('Halo Scalify, saya tertarik memesan Paket Platinum untuk ' . $brandName . '. Mohon info detailnya.') }}" target="_blank" class="inline-flex items-center justify-center gap-1 w-full py-1.5 px-2 rounded-lg bg-slate-800 hover:bg-slate-900 text-white text-[9.5px] font-bold shadow-xs transition no-print">
                                    <i class="fab fa-whatsapp text-emerald-400"></i> Pilih Platinum
                                </a>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <div class="bg-blue-50 border-l-4 border-blue-600 p-3 rounded-r-lg mb-5">
                <p class="text-[11px] text-slate-700 leading-relaxed">
                    <strong>Catatan:</strong> Seluruh paket di atas dapat disesuaikan (custom) mengikuti jumlah jurusan aktif, integrasi sistem absensi mesin fingerprint, serta termin pembayaran bertahap (Down Payment + Pelunasan pasca uji fungsi sistem).
                </p>
            </div>
        </div>

        <div class="mt-6 border-t border-slate-200 pt-5 text-xs text-slate-600">
            <p class="mb-3 text-[11px]">Demikian proposal penawaran sistem dan website LPK ini kami sampaikan. Kami siap membantu mempercepat digitalisasi dan kredibilitas kelulusan peserta pelatihan bagi {{ $brandName }}.</p>
            <div class="flex justify-between items-end mt-6">
                <div class="text-center">
                    <p class="mb-12">Hormat Kami,</p>
                    <div class="border-b border-slate-400 w-40 mb-1 mx-auto"></div>
                    <p class="font-bold text-slate-900">M. Andi</p>
                    <p class="text-[10px] text-slate-500">Project Manager - Scalify</p>
                </div>
                <div class="text-center">
                    <p class="mb-12">Disetujui Oleh,</p>
                    <div class="border-b border-slate-400 w-40 mb-1 mx-auto"></div>
                    <p class="font-bold text-slate-900">.........................................</p>
                    <p class="text-[10px] text-slate-500">{{ $brandName }}</p>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
