{{-- ══════════════════════════════════════════════════
     SECTION TEMPLATE & MODULAR ASSET SHOWCASE
══════════════════════════════════════════════════ --}}
<section id="showcase-section" class="py-14 sm:py-18 px-4 sm:px-6 lg:px-8 bg-[#090d29] border-b border-white/5 relative z-20" x-data="showcaseApp()">
    <div class="max-w-6xl mx-auto">

        {{-- Section Title --}}
        <div class="mb-10 text-left">
            <div class="text-cyan-400 font-extrabold text-[11px] sm:text-xs tracking-[0.2em] uppercase mb-1.5 flex items-center gap-1.5">
                <span class="w-1.5 h-1.5 rounded-full bg-cyan-400"></span>
                <span>PILIHAN FORMAT & ASSET MODULAR</span>
            </div>
            <h2 class="font-sans font-black text-2xl sm:text-3xl lg:text-4xl text-white tracking-tight mb-3">
                Format Standar HRD dengan Fleksibilitas Drag-and-Drop
            </h2>
            <p class="text-white/60 text-xs sm:text-sm leading-relaxed max-w-3xl font-normal">
                Gunakan format dasar rekomendasi recruiter, atur urutan posisi riwayat kerja dan pendidikan dengan mudah, serta aktifkan modul tambahan sesuai kebutuhan profil Anda.
            </p>
        </div>

        {{-- 1. Modular Asset Highlight --}}
        <div class="bg-brand-navy/60 backdrop-blur-xl border border-white/10 rounded-2xl p-6 sm:p-8 mb-10 shadow-card">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">

                {{-- Left: Description & 4 Mini Features --}}
                <div class="lg:col-span-6 space-y-4">
                    <h3 class="font-bold text-lg sm:text-xl text-white leading-snug">
                        Katalog Asset Lengkap: Bebas Diatur & Ditambahkan
                    </h3>
                    <p class="text-white/60 text-xs sm:text-sm leading-relaxed font-normal">
                        Selain struktur default 2-kolom, Anda dapat mengaktifkan modul pendukung karir seperti portofolio proyek, sertifikasi, organisasi, hingga bahasa asing.
                    </p>

                    <div class="grid grid-cols-2 gap-3 pt-2">
                        <div class="p-3 rounded-xl bg-white/5 border border-white/10">
                            <h4 class="text-xs font-bold text-white">Drag to Reorder</h4>
                            <p class="text-[11px] text-white/50 mt-0.5">Tukar posisi bagian CV dengan klik dan geser.</p>
                        </div>
                        <div class="p-3 rounded-xl bg-white/5 border border-white/10">
                            <h4 class="text-xs font-bold text-white">Asset Catalog</h4>
                            <p class="text-[11px] text-white/50 mt-0.5">10+ Modul kustom siap pakai.</p>
                        </div>
                        <div class="p-3 rounded-xl bg-white/5 border border-white/10">
                            <h4 class="text-xs font-bold text-white">Formula STAR Auto</h4>
                            <p class="text-[11px] text-white/50 mt-0.5">Diformulasikan secara terstruktur.</p>
                        </div>
                        <div class="p-3 rounded-xl bg-white/5 border border-white/10">
                            <h4 class="text-xs font-bold text-white">Presisi A4</h4>
                            <p class="text-[11px] text-white/50 mt-0.5">Pas 1 halaman tanpa margin error.</p>
                        </div>
                    </div>
                </div>

                {{-- Right: Asset Modules List --}}
                <div class="lg:col-span-6 bg-black/20 p-5 rounded-xl border border-white/10 space-y-3">
                    <div class="flex items-center justify-between pb-2 border-b border-white/10">
                        <span class="text-xs font-bold uppercase tracking-wider text-cyan-400">
                            Modul Komponen CV
                        </span>
                        <span class="text-[10px] px-2 py-0.5 rounded-full bg-cyan-500/10 text-cyan-300 border border-cyan-500/20">Siap Pakai</span>
                    </div>

                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-2">
                        <div class="p-2.5 rounded-lg bg-white/5 border border-white/10 text-white text-xs font-medium">
                            Profil & Summary
                        </div>
                        <div class="p-2.5 rounded-lg bg-white/5 border border-white/10 text-white text-xs font-medium">
                            Pendidikan Formal
                        </div>
                        <div class="p-2.5 rounded-lg bg-white/5 border border-white/10 text-white text-xs font-medium">
                            Pengalaman Kerja
                        </div>
                        <div class="p-2.5 rounded-lg bg-white/5 border border-white/10 text-white text-xs font-medium">
                            Magang / Prakerin
                        </div>
                        <div class="p-2.5 rounded-lg bg-white/5 border border-white/10 text-white/80 text-xs font-medium">
                            Portofolio Proyek
                        </div>
                        <div class="p-2.5 rounded-lg bg-white/5 border border-white/10 text-white/80 text-xs font-medium">
                            Organisasi & Relawan
                        </div>
                        <div class="p-2.5 rounded-lg bg-white/5 border border-white/10 text-white/80 text-xs font-medium">
                            Sertifikasi & Lisensi
                        </div>
                        <div class="p-2.5 rounded-lg bg-white/5 border border-white/10 text-white/80 text-xs font-medium">
                            Prestasi & Awards
                        </div>
                        <div class="p-2.5 rounded-lg bg-white/5 border border-white/10 text-white/80 text-xs font-medium">
                            Kemampuan Bahasa
                        </div>
                    </div>

                    <div class="pt-2">
                        <button type="button" @click="applyThemeAndScroll('cyan', 'default')" class="w-full py-2.5 rounded-full bg-btn-gradient text-white text-xs font-bold shadow-glow-blue hover:scale-[1.02] transition-all">
                            Buka Editor & Sesuaikan CV
                        </button>
                    </div>
                </div>

            </div>
        </div>

        {{-- 2. TEMPLATE CARDS GRID (With Visual A4 Mockup Thumbnails) --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-5 sm:gap-6">

            {{-- Template Card 1: Ocean Cyan --}}
            <div class="bg-brand-navy/60 backdrop-blur-xl border border-white/10 rounded-2xl p-5 shadow-card hover:border-brand-accent/40 hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between group">
                <div>
                    {{-- Visual A4 CV Thumbnail Mockup --}}
                    <div @click="applyThemeAndScroll('cyan', 'default')" class="cursor-pointer mb-4 relative rounded-xl overflow-hidden border border-white/15 bg-slate-950/60 p-3 flex justify-center group-hover:border-cyan-400/50 transition-colors">
                        <div class="w-full max-w-[200px] aspect-[1/1.3] bg-white rounded-lg shadow-lg overflow-hidden flex transform group-hover:scale-[1.03] transition-transform duration-300 text-[6px]">
                            {{-- Mini Left Sidebar (Ocean Cyan) --}}
                            <div class="w-[38%] bg-[#0284c7] p-2 flex flex-col items-center text-white shrink-0 space-y-1.5">
                                <div class="w-6 h-6 rounded-full bg-white/20 border border-white/40 flex items-center justify-center text-[8px]">
                                    <i class="fa-solid fa-user text-white"></i>
                                </div>
                                <div class="w-10 h-1 bg-white/60 rounded"></div>
                                <div class="w-8 h-0.5 bg-white/40 rounded"></div>
                                <div class="w-full space-y-1 pt-1 border-t border-white/20">
                                    <div class="w-full h-1 bg-white/40 rounded"></div>
                                    <div class="w-3/4 h-1 bg-white/40 rounded"></div>
                                    <div class="w-5/6 h-1 bg-white/40 rounded"></div>
                                </div>
                            </div>
                            {{-- Mini Right Content --}}
                            <div class="flex-1 p-2 space-y-1.5 bg-white">
                                <div class="w-16 h-1.5 bg-[#0284c7] rounded"></div>
                                <div class="w-10 h-1 bg-slate-400 rounded"></div>
                                <div class="w-full space-y-0.5 pt-1">
                                    <div class="w-full h-1 bg-slate-200 rounded"></div>
                                    <div class="w-full h-1 bg-slate-200 rounded"></div>
                                    <div class="w-4/5 h-1 bg-slate-200 rounded"></div>
                                </div>
                                <div class="w-12 h-1 bg-[#0284c7] rounded pt-0.5"></div>
                                <div class="w-full space-y-0.5">
                                    <div class="w-full h-1 bg-slate-200 rounded"></div>
                                    <div class="w-3/4 h-1 bg-slate-200 rounded"></div>
                                </div>
                            </div>
                        </div>
                        <div class="absolute inset-0 bg-cyan-500/0 group-hover:bg-cyan-500/5 transition-colors flex items-center justify-center">
                            <span class="opacity-0 group-hover:opacity-100 transition-opacity bg-brand-dark/90 text-cyan-300 text-[11px] font-bold px-3 py-1.5 rounded-full border border-cyan-400/40 shadow-lg">
                                Klik untuk Gunakan
                            </span>
                        </div>
                    </div>

                    <div class="flex items-center justify-between pb-2 border-b border-white/10 mb-2.5">
                        <div>
                            <span class="text-[10px] font-extrabold uppercase tracking-wider text-cyan-400">Paling Populer</span>
                            <h3 class="font-bold text-base text-white mt-0.5">Ocean Two-Tone Pro</h3>
                        </div>
                        <div class="w-5 h-5 rounded-full bg-[#0284c7] border-2 border-white/40"></div>
                    </div>
                    <p class="text-white/60 text-xs leading-relaxed font-normal mb-3">
                        Format 2-kolom dengan sidebar Cyan kontras. Sangat ideal untuk posisi Marketing, Sales, Project Manager, dan Fresh Graduate.
                    </p>
                </div>
                <button type="button" @click="applyThemeAndScroll('cyan', 'default')" class="w-full py-2.5 rounded-full bg-white/5 hover:bg-white/10 border border-white/15 text-white text-xs font-semibold transition">
                    Gunakan Format Ini
                </button>
            </div>

            {{-- Template Card 2: Executive Navy --}}
            <div class="bg-brand-navy/60 backdrop-blur-xl border border-white/10 rounded-2xl p-5 shadow-card hover:border-brand-accent/40 hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between group">
                <div>
                    {{-- Visual A4 CV Thumbnail Mockup --}}
                    <div @click="applyThemeAndScroll('navy', 'senior')" class="cursor-pointer mb-4 relative rounded-xl overflow-hidden border border-white/15 bg-slate-950/60 p-3 flex justify-center group-hover:border-indigo-400/50 transition-colors">
                        <div class="w-full max-w-[200px] aspect-[1/1.3] bg-white rounded-lg shadow-lg overflow-hidden flex transform group-hover:scale-[1.03] transition-transform duration-300 text-[6px]">
                            {{-- Mini Left Sidebar (Midnight Navy) --}}
                            <div class="w-[38%] bg-[#0f172a] p-2 flex flex-col items-center text-white shrink-0 space-y-1.5">
                                <div class="w-6 h-6 rounded-full bg-white/20 border border-white/40 flex items-center justify-center text-[8px]">
                                    <i class="fa-solid fa-user-tie text-white"></i>
                                </div>
                                <div class="w-10 h-1 bg-white/60 rounded"></div>
                                <div class="w-8 h-0.5 bg-white/40 rounded"></div>
                                <div class="w-full space-y-1 pt-1 border-t border-white/20">
                                    <div class="w-full h-1 bg-white/40 rounded"></div>
                                    <div class="w-3/4 h-1 bg-white/40 rounded"></div>
                                    <div class="w-5/6 h-1 bg-white/40 rounded"></div>
                                </div>
                            </div>
                            {{-- Mini Right Content --}}
                            <div class="flex-1 p-2 space-y-1.5 bg-white">
                                <div class="w-16 h-1.5 bg-[#0f172a] rounded"></div>
                                <div class="w-10 h-1 bg-slate-400 rounded"></div>
                                <div class="w-full space-y-0.5 pt-1">
                                    <div class="w-full h-1 bg-slate-200 rounded"></div>
                                    <div class="w-full h-1 bg-slate-200 rounded"></div>
                                    <div class="w-4/5 h-1 bg-slate-200 rounded"></div>
                                </div>
                                <div class="w-12 h-1 bg-[#0f172a] rounded pt-0.5"></div>
                                <div class="w-full space-y-0.5">
                                    <div class="w-full h-1 bg-slate-200 rounded"></div>
                                    <div class="w-3/4 h-1 bg-slate-200 rounded"></div>
                                </div>
                            </div>
                        </div>
                        <div class="absolute inset-0 bg-indigo-500/0 group-hover:bg-indigo-500/5 transition-colors flex items-center justify-center">
                            <span class="opacity-0 group-hover:opacity-100 transition-opacity bg-brand-dark/90 text-indigo-300 text-[11px] font-bold px-3 py-1.5 rounded-full border border-indigo-400/40 shadow-lg">
                                Klik untuk Gunakan
                            </span>
                        </div>
                    </div>

                    <div class="flex items-center justify-between pb-2 border-b border-white/10 mb-2.5">
                        <div>
                            <span class="text-[10px] font-extrabold uppercase tracking-wider text-indigo-400">Executive Look</span>
                            <h3 class="font-bold text-base text-white mt-0.5">Corporate Midnight Navy</h3>
                        </div>
                        <div class="w-5 h-5 rounded-full bg-[#0f172a] border-2 border-white/40"></div>
                    </div>
                    <p class="text-white/60 text-xs leading-relaxed font-normal mb-3">
                        Format formal dengan nuansa warna Deep Navy yang elegan dan berwibawa. Cocok untuk bidang Finance, HRD, Hukum, dan Manajerial.
                    </p>
                </div>
                <button type="button" @click="applyThemeAndScroll('navy', 'senior')" class="w-full py-2.5 rounded-full bg-white/5 hover:bg-white/10 border border-white/15 text-white text-xs font-semibold transition">
                    Gunakan Format Ini
                </button>
            </div>

            {{-- Template Card 3: Emerald Pro Tech --}}
            <div class="bg-brand-navy/60 backdrop-blur-xl border border-white/10 rounded-2xl p-5 shadow-card hover:border-brand-accent/40 hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between group">
                <div>
                    {{-- Visual A4 CV Thumbnail Mockup --}}
                    <div @click="applyThemeAndScroll('emerald', 'tech')" class="cursor-pointer mb-4 relative rounded-xl overflow-hidden border border-white/15 bg-slate-950/60 p-3 flex justify-center group-hover:border-emerald-400/50 transition-colors">
                        <div class="w-full max-w-[200px] aspect-[1/1.3] bg-white rounded-lg shadow-lg overflow-hidden flex transform group-hover:scale-[1.03] transition-transform duration-300 text-[6px]">
                            {{-- Mini Left Sidebar (Emerald Green) --}}
                            <div class="w-[38%] bg-[#047857] p-2 flex flex-col items-center text-white shrink-0 space-y-1.5">
                                <div class="w-6 h-6 rounded-full bg-white/20 border border-white/40 flex items-center justify-center text-[8px]">
                                    <i class="fa-solid fa-code text-white"></i>
                                </div>
                                <div class="w-10 h-1 bg-white/60 rounded"></div>
                                <div class="w-8 h-0.5 bg-white/40 rounded"></div>
                                <div class="w-full space-y-1 pt-1 border-t border-white/20">
                                    <div class="w-full h-1 bg-white/40 rounded"></div>
                                    <div class="w-3/4 h-1 bg-white/40 rounded"></div>
                                    <div class="w-5/6 h-1 bg-white/40 rounded"></div>
                                </div>
                            </div>
                            {{-- Mini Right Content --}}
                            <div class="flex-1 p-2 space-y-1.5 bg-white">
                                <div class="w-16 h-1.5 bg-[#047857] rounded"></div>
                                <div class="w-10 h-1 bg-slate-400 rounded"></div>
                                <div class="w-full space-y-0.5 pt-1">
                                    <div class="w-full h-1 bg-slate-200 rounded"></div>
                                    <div class="w-full h-1 bg-slate-200 rounded"></div>
                                    <div class="w-4/5 h-1 bg-slate-200 rounded"></div>
                                </div>
                                <div class="w-12 h-1 bg-[#047857] rounded pt-0.5"></div>
                                <div class="w-full space-y-0.5">
                                    <div class="w-full h-1 bg-slate-200 rounded"></div>
                                    <div class="w-3/4 h-1 bg-slate-200 rounded"></div>
                                </div>
                            </div>
                        </div>
                        <div class="absolute inset-0 bg-emerald-500/0 group-hover:bg-emerald-500/5 transition-colors flex items-center justify-center">
                            <span class="opacity-0 group-hover:opacity-100 transition-opacity bg-brand-dark/90 text-emerald-300 text-[11px] font-bold px-3 py-1.5 rounded-full border border-emerald-400/40 shadow-lg">
                                Klik untuk Gunakan
                            </span>
                        </div>
                    </div>

                    <div class="flex items-center justify-between pb-2 border-b border-white/10 mb-2.5">
                        <div>
                            <span class="text-[10px] font-extrabold uppercase tracking-wider text-emerald-400">Tech & Creative</span>
                            <h3 class="font-bold text-base text-white mt-0.5">Emerald Modern Tech</h3>
                        </div>
                        <div class="w-5 h-5 rounded-full bg-[#047857] border-2 border-white/40"></div>
                    </div>
                    <p class="text-white/60 text-xs leading-relaxed font-normal mb-3">
                        Nuansa hijau emerald modern. Sangat pas untuk Software Engineer, Data Scientist, UI/UX Designer, dan Arsitek Sistem.
                    </p>
                </div>
                <button type="button" @click="applyThemeAndScroll('emerald', 'tech')" class="w-full py-2.5 rounded-full bg-white/5 hover:bg-white/10 border border-white/15 text-white text-xs font-semibold transition">
                    Gunakan Format Ini
                </button>
            </div>

        </div>

    </div>

    {{-- Showcase Helper Script --}}
    <script>
        function showcaseApp() {
            return {
                applyThemeAndScroll(themeName, presetName) {
                    window.dispatchEvent(new CustomEvent('select-cv-theme', {
                        detail: {
                            theme: themeName
                            , preset: presetName
                        }
                    }));
                    const el = document.getElementById('ai-builder-section');
                    if (el) {
                        el.scrollIntoView({
                            behavior: 'smooth'
                        });
                    }
                }
            }
        }

    </script>
</section>
