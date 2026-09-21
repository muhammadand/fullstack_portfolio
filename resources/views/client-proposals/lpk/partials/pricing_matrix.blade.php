<!-- Pricing Packages Matrix Section (Mobile Optimized & Desktop Table) -->
<section id="paket-sistem-lpk" class="py-16 sm:py-20 bg-white relative">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Section Header -->
        <div class="text-center max-w-xl mx-auto mb-10 sm:mb-12">
            <h2 class="font-heading text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
                Pilihan Paket Sistem
            </h2>
            <p class="mt-2 text-slate-600 text-xs sm:text-sm">
                Investasi sistem website dan LMS terpadu untuk efisiensi operasional {{ $brandName }}.
            </p>
        </div>

        <!-- 1. MOBILE VIEW: Interactive Package Selector Tabs (Visible on Mobile) -->
        <div class="block lg:hidden max-w-md mx-auto mb-8">
            
            <!-- Mobile Tab Buttons -->
            <div class="grid grid-cols-4 gap-1 p-1 bg-slate-100 rounded-xl mb-5 text-center text-xs font-semibold">
                <button onclick="showMobilePlan('silver', this)" class="plan-tab-btn py-2 rounded-lg text-slate-600 hover:text-slate-900 transition">
                    Silver
                </button>
                <button onclick="showMobilePlan('gold', this)" class="plan-tab-btn active py-2 rounded-lg bg-slate-900 text-white shadow-xs transition">
                    Gold ⭐
                </button>
                <button onclick="showMobilePlan('diamond', this)" class="plan-tab-btn py-2 rounded-lg text-slate-600 hover:text-slate-900 transition">
                    Diamond
                </button>
                <button onclick="showMobilePlan('platinum', this)" class="plan-tab-btn py-2 rounded-lg text-slate-600 hover:text-slate-900 transition">
                    Platinum
                </button>
            </div>

            <!-- Mobile Card 1: Silver -->
            <div id="mobileCardSilver" class="mobile-plan-card hidden bg-white rounded-2xl p-6 border border-slate-200 shadow-sm space-y-4">
                <div class="border-b border-slate-100 pb-3">
                    <span class="font-heading font-bold text-lg text-slate-900 block">Paket Silver</span>
                    <span class="font-heading font-extrabold text-2xl text-blue-600 block mt-1">
                        {{ \App\Models\ClientProposal::formatPackagePill($client->silver_price) }}
                    </span>
                    <span class="text-[11px] text-slate-500">Perpanjangan {{ $client->silver_renewal }}</span>
                </div>
                <ul class="space-y-2 text-xs text-slate-600">
                    <li class="flex items-center gap-2"><span>✓</span> Website Profil & 3 Program</li>
                    <li class="flex items-center gap-2"><span>✓</span> Form Pendaftaran WhatsApp</li>
                    <li class="flex items-center gap-2"><span>✓</span> Domain (.com) & Cloud SSD 1 Tahun</li>
                    <li class="flex items-center gap-2"><span>✓</span> Garansi Teknis 1 Bulan</li>
                </ul>
                <a href="https://wa.me/{{ $cleanWa }}?text={{ urlencode('Halo Scalify, saya tertarik memesan Paket Silver untuk ' . $brandName) }}" target="_blank" class="block w-full py-2.5 rounded-xl bg-slate-900 hover:bg-slate-800 text-white font-semibold text-xs text-center transition">
                    Pilih Paket Silver
                </a>
            </div>

            <!-- Mobile Card 2: Gold (Populer - Default) -->
            <div id="mobileCardGold" class="mobile-plan-card bg-slate-900 text-white rounded-2xl p-6 border border-slate-800 shadow-md space-y-4 relative">
                <span class="absolute -top-3 right-5 bg-amber-400 text-slate-950 font-extrabold text-[10px] px-2.5 py-0.5 rounded-full uppercase tracking-wider">
                    Paling Populer
                </span>
                <div class="border-b border-slate-800 pb-3">
                    <span class="font-heading font-bold text-lg text-white block">Paket Gold</span>
                    <span class="font-heading font-extrabold text-2xl text-amber-300 block mt-1">
                        {{ \App\Models\ClientProposal::formatPackagePill($client->gold_price) }}
                    </span>
                    <span class="text-[11px] text-slate-400">Perpanjangan {{ $client->gold_renewal }}</span>
                </div>
                <ul class="space-y-2 text-xs text-slate-200">
                    <li class="flex items-center gap-2 text-amber-300 font-medium"><span>✓</span> Modul E-Learning & Silabus (10 Program)</li>
                    <li class="flex items-center gap-2 text-amber-300 font-medium"><span>✓</span> Simulasi Ujian CBT & Scoring Instan</li>
                    <li class="flex items-center gap-2 text-amber-300 font-medium"><span>✓</span> Presensi Absensi QR Code Siswa</li>
                    <li class="flex items-center gap-2 text-amber-300 font-medium"><span>✓</span> E-Sertifikat Digital & Verifikasi QR</li>
                    <li class="flex items-center gap-2 text-slate-300"><span>✓</span> Multi-Step Form Pendaftaran Calon Pekerja</li>
                    <li class="flex items-center gap-2 text-slate-300"><span>✓</span> Domain & High-Speed Cloud SSD 1 Tahun</li>
                    <li class="flex items-center gap-2 text-slate-300"><span>✓</span> Garansi & Maintenance 3 Bulan</li>
                </ul>
                <a href="https://wa.me/{{ $cleanWa }}?text={{ urlencode('Halo Scalify, saya tertarik memesan Paket Gold untuk ' . $brandName) }}" target="_blank" class="block w-full py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-semibold text-xs text-center transition">
                    Pilih Paket Gold
                </a>
            </div>

            <!-- Mobile Card 3: Diamond -->
            <div id="mobileCardDiamond" class="mobile-plan-card hidden bg-white rounded-2xl p-6 border border-slate-200 shadow-sm space-y-4">
                <div class="border-b border-slate-100 pb-3">
                    <span class="font-heading font-bold text-lg text-slate-900 block">Paket Diamond</span>
                    <span class="font-heading font-extrabold text-2xl text-blue-600 block mt-1">
                        {{ \App\Models\ClientProposal::formatPackagePill($client->diamond_price) }}
                    </span>
                    <span class="text-[11px] text-slate-500">Perpanjangan {{ $client->diamond_renewal }}</span>
                </div>
                <ul class="space-y-2 text-xs text-slate-600">
                    <li class="flex items-center gap-2"><span>✓</span> Semua Fitur Paket Gold</li>
                    <li class="flex items-center gap-2"><span>✓</span> Unlimited Program Pelatihan & Video</li>
                    <li class="flex items-center gap-2"><span>✓</span> Presensi QR + Validasi GPS Geolocation</li>
                    <li class="flex items-center gap-2"><span>✓</span> CBT Acak Soal + Anti-Cheat Tab Detector</li>
                    <li class="flex items-center gap-2"><span>✓</span> Cetak Rapor & E-Sertifikat PDF</li>
                    <li class="flex items-center gap-2"><span>✓</span> Maintenance Prioritas 6 Bulan</li>
                </ul>
                <a href="https://wa.me/{{ $cleanWa }}?text={{ urlencode('Halo Scalify, saya tertarik memesan Paket Diamond untuk ' . $brandName) }}" target="_blank" class="block w-full py-2.5 rounded-xl bg-slate-900 hover:bg-slate-800 text-white font-semibold text-xs text-center transition">
                    Pilih Paket Diamond
                </a>
            </div>

            <!-- Mobile Card 4: Platinum -->
            <div id="mobileCardPlatinum" class="mobile-plan-card hidden bg-white rounded-2xl p-6 border border-slate-200 shadow-sm space-y-4">
                <div class="border-b border-slate-100 pb-3">
                    <span class="font-heading font-bold text-lg text-slate-900 block">Paket Platinum</span>
                    <span class="font-heading font-extrabold text-2xl text-blue-600 block mt-1">
                        {{ \App\Models\ClientProposal::formatPackagePill($client->platinum_price) }}
                    </span>
                    <span class="text-[11px] text-slate-500">Perpanjangan {{ $client->platinum_renewal }}</span>
                </div>
                <ul class="space-y-2 text-xs text-slate-600">
                    <li class="flex items-center gap-2"><span>✓</span> Sistem Informasi Terpadu Enterprise</li>
                    <li class="flex items-center gap-2"><span>✓</span> Manajemen Multi Cabang LPK</li>
                    <li class="flex items-center gap-2"><span>✓</span> Export Rekap Absensi Disnaker Excel</li>
                    <li class="flex items-center gap-2"><span>✓</span> Dedicated Server & Custom Features</li>
                    <li class="flex items-center gap-2"><span>✓</span> VIP Support & Garansi 1 Tahun Penuh</li>
                </ul>
                <a href="https://wa.me/{{ $cleanWa }}?text={{ urlencode('Halo Scalify, saya tertarik memesan Paket Platinum untuk ' . $brandName) }}" target="_blank" class="block w-full py-2.5 rounded-xl bg-slate-900 hover:bg-slate-800 text-white font-semibold text-xs text-center transition">
                    Pilih Paket Platinum
                </a>
            </div>

        </div>

        <!-- 2. DESKTOP VIEW: Full Comparison Table (Visible on Desktop/Tablet) -->
        <div class="hidden lg:block overflow-x-auto rounded-2xl border border-slate-200 bg-white shadow-xs mb-6">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="border-b border-slate-200">
                        <th class="p-4 bg-slate-50 font-heading text-slate-900 font-bold w-[32%]">
                            Fitur & Modul
                        </th>
                        
                        <!-- Silver -->
                        <th class="p-3.5 text-center bg-slate-50/70 border-l border-slate-200 w-[17%]">
                            <span class="font-bold text-sm text-slate-900 block">Silver</span>
                            <span class="inline-block my-1 py-0.5 px-2 rounded-md bg-white border border-slate-200 text-[10px] font-bold text-slate-800">
                                {{ \App\Models\ClientProposal::formatPackagePill($client->silver_price) }}
                            </span>
                            <span class="block text-[9px] text-slate-500">{{ $client->silver_renewal }}</span>
                        </th>

                        <!-- Gold (Featured) -->
                        <th class="p-3.5 text-center bg-slate-900 text-white border-x-2 border-slate-900 w-[17%]">
                            <span class="font-bold text-sm text-white block">Gold</span>
                            <span class="inline-block my-1 py-0.5 px-2 rounded-md bg-slate-800 text-[10px] font-bold text-amber-300">
                                {{ \App\Models\ClientProposal::formatPackagePill($client->gold_price) }}
                            </span>
                            <span class="block text-[9px] text-slate-300">{{ $client->gold_renewal }}</span>
                        </th>

                        <!-- Diamond -->
                        <th class="p-3.5 text-center bg-slate-50/70 border-l border-slate-200 w-[17%]">
                            <span class="font-bold text-sm text-slate-900 block">Diamond</span>
                            <span class="inline-block my-1 py-0.5 px-2 rounded-md bg-white border border-slate-200 text-[10px] font-bold text-slate-800">
                                {{ \App\Models\ClientProposal::formatPackagePill($client->diamond_price) }}
                            </span>
                            <span class="block text-[9px] text-slate-500">{{ $client->diamond_renewal }}</span>
                        </th>

                        <!-- Platinum -->
                        <th class="p-3.5 text-center bg-slate-50/70 border-l border-slate-200 w-[17%]">
                            <span class="font-bold text-sm text-slate-900 block">Platinum</span>
                            <span class="inline-block my-1 py-0.5 px-2 rounded-md bg-white border border-slate-200 text-[10px] font-bold text-slate-800">
                                {{ \App\Models\ClientProposal::formatPackagePill($client->platinum_price) }}
                            </span>
                            <span class="block text-[9px] text-slate-500">{{ $client->platinum_renewal }}</span>
                        </th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-100 text-slate-600 text-xs">
                    <tr>
                        <td class="p-3 font-medium text-slate-800">Website Profil & Katalog Program</td>
                        <td class="p-3 text-center bg-slate-50/30">Hingga 3 Program</td>
                        <td class="p-3 text-center bg-slate-900/5 font-semibold text-slate-900">Hingga 10 Program</td>
                        <td class="p-3 text-center bg-slate-50/30 font-semibold">Unlimited</td>
                        <td class="p-3 text-center bg-slate-50/30 font-semibold">Multi Cabang</td>
                    </tr>
                    <tr>
                        <td class="p-3 font-medium text-slate-800">Form Pendaftaran Calon Pekerja</td>
                        <td class="p-3 text-center bg-slate-50/30">Form WhatsApp</td>
                        <td class="p-3 text-center bg-slate-900/5 text-slate-900 font-semibold">Multi-Step Form</td>
                        <td class="p-3 text-center bg-slate-50/30">Form + Upload CV</td>
                        <td class="p-3 text-center bg-slate-50/30">Database CRM</td>
                    </tr>
                    <tr>
                        <td class="p-3 font-medium text-slate-800">LMS Modul Pembelajaran (PDF & Video)</td>
                        <td class="p-3 text-center bg-slate-50/30 text-slate-300">—</td>
                        <td class="p-3 text-center bg-slate-900/5 text-blue-600 font-bold">Tersedia</td>
                        <td class="p-3 text-center bg-slate-50/30 text-blue-600 font-bold">Lengkap + Video</td>
                        <td class="p-3 text-center bg-slate-50/30 text-blue-600 font-bold">Enterprise</td>
                    </tr>
                    <tr>
                        <td class="p-3 font-medium text-slate-800">Simulasi Ujian Online (CBT) & Scoring</td>
                        <td class="p-3 text-center bg-slate-50/30 text-slate-300">—</td>
                        <td class="p-3 text-center bg-slate-900/5 text-blue-600 font-bold">Tersedia</td>
                        <td class="p-3 text-center bg-slate-50/30 text-blue-600 font-bold">Acak Soal + Timer</td>
                        <td class="p-3 text-center bg-slate-50/30 text-blue-600 font-bold">Multi Kategori</td>
                    </tr>
                    <tr>
                        <td class="p-3 font-medium text-slate-800">Presensi & Absensi Siswa Digital (QR)</td>
                        <td class="p-3 text-center bg-slate-50/30 text-slate-300">—</td>
                        <td class="p-3 text-center bg-slate-900/5 text-blue-600 font-bold">Presensi QR</td>
                        <td class="p-3 text-center bg-slate-50/30 text-blue-600 font-bold">QR + GPS</td>
                        <td class="p-3 text-center bg-slate-50/30 text-blue-600 font-bold">Export Excel</td>
                    </tr>
                    <tr>
                        <td class="p-3 font-medium text-slate-800">E-Sertifikat Digital & Verifikasi QR</td>
                        <td class="p-3 text-center bg-slate-50/30 text-slate-300">—</td>
                        <td class="p-3 text-center bg-slate-900/5 text-blue-600 font-bold">Cek QR Publik</td>
                        <td class="p-3 text-center bg-slate-50/30 text-blue-600 font-bold">E-Sertifikat PDF</td>
                        <td class="p-3 text-center bg-slate-50/30 text-blue-600 font-bold">Auto Serial No.</td>
                    </tr>
                    <tr>
                        <td class="p-3 font-medium text-slate-800">Domain & Cloud Hosting</td>
                        <td class="p-3 text-center bg-slate-50/30">1 Tahun SSD</td>
                        <td class="p-3 text-center bg-slate-900/5 font-semibold text-slate-900">1 Tahun Cloud</td>
                        <td class="p-3 text-center bg-slate-50/30 font-semibold">1 Tahun NVMe</td>
                        <td class="p-3 text-center bg-slate-50/30 font-semibold">Dedicated</td>
                    </tr>
                    <tr>
                        <td class="p-3 font-medium text-slate-800">Garansi & Maintenance Teknis</td>
                        <td class="p-3 text-center bg-slate-50/30">1 Bulan</td>
                        <td class="p-3 text-center bg-slate-900/5 font-semibold text-slate-900">3 Bulan</td>
                        <td class="p-3 text-center bg-slate-50/30 font-semibold">6 Bulan</td>
                        <td class="p-3 text-center bg-slate-50/30 font-semibold">1 Tahun</td>
                    </tr>
                </tbody>

                <tfoot>
                    <tr class="border-t border-slate-200 bg-slate-50/50">
                        <td class="p-3 font-semibold text-slate-700">Pilih Paket</td>
                        <td class="p-2.5 text-center">
                            <a href="https://wa.me/{{ $cleanWa }}?text={{ urlencode('Halo Scalify, saya tertarik dengan Paket Silver untuk ' . $brandName) }}" target="_blank" class="block w-full py-1.5 rounded-lg bg-slate-800 text-white text-[11px] font-semibold hover:bg-slate-900 transition">
                                Pilih Silver
                            </a>
                        </td>
                        <td class="p-2.5 text-center bg-slate-900/5">
                            <a href="https://wa.me/{{ $cleanWa }}?text={{ urlencode('Halo Scalify, saya tertarik dengan Paket Gold untuk ' . $brandName) }}" target="_blank" class="block w-full py-1.5 rounded-lg bg-slate-900 text-white text-[11px] font-semibold hover:bg-slate-800 transition">
                                Pilih Gold
                            </a>
                        </td>
                        <td class="p-2.5 text-center">
                            <a href="https://wa.me/{{ $cleanWa }}?text={{ urlencode('Halo Scalify, saya tertarik dengan Paket Diamond untuk ' . $brandName) }}" target="_blank" class="block w-full py-1.5 rounded-lg bg-slate-800 text-white text-[11px] font-semibold hover:bg-slate-900 transition">
                                Pilih Diamond
                            </a>
                        </td>
                        <td class="p-2.5 text-center">
                            <a href="https://wa.me/{{ $cleanWa }}?text={{ urlencode('Halo Scalify, saya tertarik dengan Paket Platinum untuk ' . $brandName) }}" target="_blank" class="block w-full py-1.5 rounded-lg bg-slate-800 text-white text-[11px] font-semibold hover:bg-slate-900 transition">
                                Pilih Platinum
                            </a>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>

    </div>
</section>
