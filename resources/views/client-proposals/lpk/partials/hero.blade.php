<!-- Hero Section (Clean & Minimal Mobile-Optimized) -->
<section id="hero" class="relative bg-slate-900 text-white pt-10 pb-16 sm:pt-16 sm:pb-20 lg:pt-24 lg:pb-28 overflow-hidden">
    <!-- Subtle Gradient Backdrop -->
    <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_top,_var(--tw-gradient-stops))] from-slate-800 via-slate-900 to-slate-950 opacity-80 pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-center">
            
            <!-- Left Column: Copywriting -->
            <div class="lg:col-span-7 space-y-5 text-center lg:text-left">
                <!-- Status Badge -->
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-slate-800 border border-slate-700 text-slate-300 text-[11px] font-medium">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                    <span>Izin Disnaker & Akreditasi BNSP</span>
                </div>

                <!-- Main Title (Crisp Mobile Size) -->
                <h1 class="font-heading text-2xl sm:text-4xl lg:text-5xl font-extrabold tracking-tight text-white leading-snug">
                    Pelatihan Kerja & Karir Global
                </h1>

                <!-- Concise Subtitle -->
                <p class="text-slate-300 text-xs sm:text-sm leading-relaxed max-w-xl mx-auto lg:mx-0">
                    Sistem informasi pelatihan terpadu: modul e-learning, ujian CBT, presensi QR, dan sertifikasi resmi untuk kerja di Jepang, Korea, Jerman, dan maritim.
                </p>

                <!-- Search Input Bar -->
                <div class="max-w-lg mx-auto lg:mx-0">
                    <div class="flex gap-1.5 bg-slate-800/90 p-1.5 rounded-xl border border-slate-700/80">
                        <input type="text" id="heroSearchInput" placeholder="Cari program (Jepang, Welder...)" class="flex-1 px-3 py-2 bg-transparent text-white text-xs placeholder-slate-400 outline-none">
                        <button onclick="filterProgramsFromHero()" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold text-xs rounded-lg transition-colors shrink-0">
                            Cari
                        </button>
                    </div>
                </div>

                <!-- Feature Badges Minimal -->
                <div class="flex flex-wrap items-center justify-center lg:justify-start gap-x-4 gap-y-1.5 text-[11px] text-slate-400 pt-1">
                    <span>• Modul LMS</span>
                    <span>• Ujian CBT</span>
                    <span>• Presensi QR</span>
                    <span>• E-Sertifikat</span>
                </div>
            </div>

            <!-- Right Column: Minimal LMS Dashboard Preview -->
            <div class="lg:col-span-5">
                <div class="bg-slate-800/90 border border-slate-700 rounded-2xl p-5 sm:p-6 shadow-xl text-xs space-y-3.5">
                    
                    <!-- Header -->
                    <div class="flex items-center justify-between border-b border-slate-700 pb-3">
                        <div>
                            <span class="text-slate-400 text-[9px] block font-mono">PORTAL SISWA</span>
                            <h4 class="font-heading font-bold text-white text-xs sm:text-sm">Dashboard Calon Pekerja</h4>
                        </div>
                        <span class="px-2 py-0.5 rounded bg-emerald-500/20 text-emerald-300 font-medium text-[10px]">
                            Aktif
                        </span>
                    </div>

                    <!-- Progress -->
                    <div class="space-y-1">
                        <div class="flex justify-between text-slate-300 text-[10px] sm:text-[11px]">
                            <span>Progress Modul</span>
                            <span class="text-white font-semibold">6 dari 7 (85%)</span>
                        </div>
                        <div class="w-full h-1.5 bg-slate-700 rounded-full overflow-hidden">
                            <div class="h-full bg-blue-500 rounded-full" style="width: 85%"></div>
                        </div>
                    </div>

                    <!-- Stats Row -->
                    <div class="grid grid-cols-2 gap-2.5 pt-1 text-[11px]">
                        <div class="bg-slate-900/60 rounded-xl p-2.5 border border-slate-700/50">
                            <span class="text-slate-400 text-[9px] block">Presensi</span>
                            <span class="font-bold text-slate-200 mt-0.5 block">96.8% (31/32)</span>
                        </div>
                        <div class="bg-slate-900/60 rounded-xl p-2.5 border border-slate-700/50">
                            <span class="text-slate-400 text-[9px] block">Rata-rata CBT</span>
                            <span class="font-bold text-emerald-400 mt-0.5 block">94.2 (Grade A)</span>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="grid grid-cols-2 gap-2 pt-1">
                        <a href="#simulasi-ujian" class="py-2 rounded-lg bg-slate-700 hover:bg-slate-600 text-white font-medium text-center text-xs transition">
                            Simulasi CBT
                        </a>
                        <a href="#verifikasi-sertifikat" class="py-2 rounded-lg bg-blue-600 hover:bg-blue-700 text-white font-medium text-center text-xs transition">
                            Cek Sertifikat
                        </a>
                    </div>

                </div>
            </div>

        </div>

        <!-- Minimal Counter Strip -->
        <div class="mt-10 sm:mt-14 pt-6 border-t border-slate-800 grid grid-cols-2 md:grid-cols-4 gap-4 text-center">
            <div>
                <p class="font-heading text-xl sm:text-2xl font-bold text-white">1.850+</p>
                <p class="text-[11px] text-slate-400 mt-0.5">Alumni Terlatih</p>
            </div>
            <div>
                <p class="font-heading text-xl sm:text-2xl font-bold text-white">98.4%</p>
                <p class="text-[11px] text-slate-400 mt-0.5">Penyaluran Kerja</p>
            </div>
            <div>
                <p class="font-heading text-xl sm:text-2xl font-bold text-white">54+</p>
                <p class="text-[11px] text-slate-400 mt-0.5">Mitra Industri</p>
            </div>
            <div>
                <p class="font-heading text-xl sm:text-2xl font-bold text-white">18</p>
                <p class="text-[11px] text-slate-400 mt-0.5">Instruktur BNSP</p>
            </div>
        </div>

    </div>
</section>
