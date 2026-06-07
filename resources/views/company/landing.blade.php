@extends('layouts.app')
@section('content')
<section class="relative min-h-screen flex flex-col items-center justify-center pt-16 overflow-hidden">
    <div class="absolute inset-0 bg-hero-gradient pointer-events-none"></div>
    <div class="absolute inset-0 bg-blue-glow opacity-40 pointer-events-none" style="top:10%"></div>

    <div class="absolute top-24 right-8 md:right-24 animate-float-slow opacity-80">
        <div class="w-16 h-16 md:w-24 md:h-24 relative">
            <div class="absolute inset-0 bg-btn-gradient rounded-full opacity-30 blur-xl"></div>
            <svg viewBox="0 0 80 80" class="w-full h-full drop-shadow-lg" fill="none">
                <circle cx="40" cy="40" r="38" fill="#3B82F6" opacity="0.1" />
                <path d="M40 12 C52 20 58 30 54 44 L46 48 L44 56 L36 56 L34 48 L26 44 C22 30 28 20 40 12Z" fill="#3B82F6" opacity="0.9" />
                <circle cx="40" cy="32" r="5" fill="white" opacity="0.8" />
                <path d="M54 44 L62 52 L56 50 Z" fill="#60A5FA" opacity="0.7" />
                <path d="M26 44 L18 52 L24 50 Z" fill="#60A5FA" opacity="0.7" />
                <path d="M36 56 L34 66 L40 60 L46 66 L44 56 Z" fill="#FCD34D" opacity="0.8" />
            </svg>
        </div>
    </div>

    <div class="relative z-10 w-full max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col items-center mt-10">
        <div class="mb-6 flex items-center gap-2 bg-white/10 border border-white/15 rounded-full px-4 py-1.5 text-sm backdrop-blur-sm">
            <svg class="w-3.5 h-3.5 text-brand-accent" fill="currentColor" viewBox="0 0 20 20">
                <path d="M2 10a8 8 0 018-8v8h8a8 8 0 11-16 0z" />
                <path d="M12 2.252A8.014 8.014 0 0117.748 8H12V2.252z" />
            </svg>
            <span class="text-white/80">Solusi Teknologi untuk <span class="text-brand-accent font-semibold">Perusahaan
                    dan UMKM
                    Indonesia</span></span>
        </div>

        <h2 class="font-display text-[2rem] leading-tight sm:text-5xl md:text-6xl lg:text-[45px] font-semibold text-center sm:leading-[1.15] tracking-[0.02em] mb-6 sm:mb-8 drop-shadow-xl">
            Automasi Cerdas,<br />
            <span class="relative">
                Tingkatkan Efisiensi dan Performa Bisnis.
            </span>
        </h2>

        <p class="text-white/60 text-center max-w-2xl text-xs sm:text-base md:text-lg leading-relaxed mb-8 sm:mb-10 px-2">
            Kami mengintegrasikan kecerdasan buatan, sains data, dan automasi ke dalam sistem operasional Anda.
            Skalakan bisnis tanpa batas, biarkan algoritma yang bekerja.
        </p>

        <a href="https://wa.me/6285221694067" target="_blank" class="group flex items-center gap-2 sm:gap-3 bg-btn-gradient text-white text-xs sm:text-sm font-semibold px-6 sm:px-7 py-3 sm:py-3.5 rounded-full shadow-glow-blue hover:scale-105 transition-all">
            Konsultasi via WhatsApp
            <span class="w-6 h-6 sm:w-7 sm:h-7 bg-white/20 rounded-full flex items-center justify-center group-hover:translate-x-1 transition-transform">→</span>
        </a>

        <div class="relative w-full max-w-4xl mt-10 sm:mt-14 flex flex-col md:flex-row items-center justify-center gap-6 md:gap-0 pb-10 scale-90 sm:scale-100 origin-top">

            {{-- Left Card: Operational Automation --}}
            <div class="animate-float md:absolute md:left-0 md:-translate-x-4 md:top-10 w-56 bg-gradient-to-br from-white/10 to-white/[0.03] border border-white/10 rounded-2xl p-4 shadow-card backdrop-blur-md z-20">
                <div class="flex items-center gap-2 mb-3">
                    <div class="w-7 h-7 rounded-lg bg-brand-accent/15 border border-brand-accent/20 flex items-center justify-center flex-shrink-0">
                        <i class="fa-solid fa-gear text-brand-accent" style="font-size:11px;"></i>
                    </div>
                    <div>
                        <p class="text-white/70 text-[10px] font-semibold leading-tight">Otomatisasi</p>
                        <p class="text-white/40 text-[9px] leading-tight">CRM & WhatsApp</p>
                    </div>
                </div>
                <div class="flex items-end gap-2 mb-4">
                    <span class="font-display text-3xl font-bold text-white tracking-tight">24/7</span>
                    <span class="inline-flex items-center gap-1 text-[10px] bg-emerald-500/15 text-emerald-400 border border-emerald-400/25 rounded-full px-2 py-0.5 mb-1.5 font-medium">
                        <i class="fa-solid fa-arrow-trend-up" style="font-size:8px;"></i> Aktif
                    </span>
                </div>
                <div class="space-y-1.5 border-t border-white/5 pt-3">
                    <div class="h-7 bg-white/5 rounded-full border border-white/5 flex items-center px-2.5 gap-2">
                        <i class="fa-solid fa-user-check text-brand-accent/70" style="font-size:8px;"></i>
                        <div class="text-[10px] text-white/70">Auto-Follow Up Leads</div>
                    </div>
                    <div class="h-7 bg-white/5 rounded-full border border-white/5 flex items-center px-2.5 gap-2 w-4/5">
                        <i class="fa-solid fa-rotate text-emerald-400/70" style="font-size:8px;"></i>
                        <div class="text-[10px] text-white/70">Sinkronisasi Data POS</div>
                    </div>
                </div>
            </div>

            {{-- Center Card: AI Agent --}}
            <div class="relative w-64 sm:w-72 bg-gradient-to-b from-white/[0.13] to-white/[0.04] border border-white/20 rounded-[2rem] p-6 shadow-card backdrop-blur-xl z-30 animate-float-slow">
                {{-- Subtle inner glow --}}
                <div class="absolute inset-0 rounded-[2rem] bg-gradient-to-br from-brand-accent/5 to-transparent pointer-events-none"></div>

                <div class="text-center mb-5">
                    <span class="inline-flex items-center gap-1.5 bg-brand-accent/15 text-brand-accent border border-brand-accent/25 text-[9px] font-bold px-2.5 py-1 rounded-full mb-3 tracking-wider">
                        <i class="fa-solid fa-microchip" style="font-size:8px;"></i> SCALIFY AI AGENT
                    </span>
                    <p class="font-display text-xl font-bold leading-tight mt-1 text-white">Asisten AI Respon<br />Pelanggan Otomatis</p>
                </div>

                <div class="flex items-center gap-4 mb-5 bg-black/20 rounded-2xl p-3 border border-white/5">
                    <div class="relative w-14 h-14 flex-shrink-0">
                        <svg class="w-full h-full -rotate-90" viewBox="0 0 48 48">
                            <circle cx="24" cy="24" r="20" fill="none" stroke="rgba(255,255,255,0.08)" stroke-width="4" />
                            <circle cx="24" cy="24" r="20" fill="none" stroke="#60A5FA" stroke-width="4" stroke-dasharray="125.6" stroke-dashoffset="10" stroke-linecap="round" />
                        </svg>
                        <span class="absolute inset-0 flex items-center justify-center font-bold text-sm text-white">98%</span>
                    </div>
                    <p class="text-white/65 text-xs leading-snug">Akurasi AI menjawab <strong class="text-brand-accent font-semibold">SOP & FAQ</strong> bisnis Anda secara real-time</p>
                </div>

                <div class="w-full bg-black/25 rounded-xl p-3 border border-white/5">
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-[10px] text-white/45 font-medium tracking-wide uppercase">Alur Kerja AI</span>
                        <span class="flex h-2 w-2 relative">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                        </span>
                    </div>
                    <div class="space-y-2">
                        <div class="flex items-center gap-2.5">
                            <div class="w-6 h-6 rounded-lg bg-blue-500/15 border border-blue-400/15 flex items-center justify-center flex-shrink-0">
                                <i class="fa-solid fa-comment-dots text-blue-400" style="font-size:9px;"></i>
                            </div>
                            <div class="flex-1 text-[11px] text-white/75 truncate">Membaca Pesan Masuk...</div>
                        </div>
                        <div class="flex items-center gap-2.5">
                            <div class="w-6 h-6 rounded-lg bg-indigo-500/15 border border-indigo-400/15 flex items-center justify-center flex-shrink-0">
                                <i class="fa-solid fa-brain text-indigo-400" style="font-size:9px;"></i>
                            </div>
                            <div class="flex-1 text-[11px] text-white/75 truncate">Menganalisis Database SOP...</div>
                        </div>
                        <div class="flex items-center gap-2.5">
                            <div class="w-6 h-6 rounded-lg bg-purple-500/15 border border-purple-400/15 flex items-center justify-center flex-shrink-0">
                                <i class="fa-solid fa-paper-plane text-purple-400" style="font-size:9px;"></i>
                            </div>
                            <div class="flex-1 text-[11px] text-white/75 truncate">Membalas Chat Otomatis...</div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Right Card: Cost Efficiency --}}
            <div class="animate-float md:absolute md:right-0 md:translate-x-4 md:top-14 w-56 bg-gradient-to-br from-white/10 to-white/[0.03] border border-white/10 rounded-2xl p-4 shadow-card backdrop-blur-md z-20" style="animation-delay: 2s;">
                <div class="flex items-center gap-2 mb-3">
                    <div class="w-6 h-6 rounded-full bg-emerald-500/15 border border-emerald-400/20 flex items-center justify-center flex-shrink-0">
                        <i class="fa-solid fa-check text-emerald-400" style="font-size:9px;"></i>
                    </div>
                    <p class="text-[10px] text-white/55 font-medium">Prediksi Stok & Tren</p>
                </div>
                <p class="font-display text-xl font-bold leading-tight mb-1 text-white">Efisiensi Biaya<br /><span class="text-brand-accent">Hingga 40%</span></p>

                <div class="mt-4 h-14 w-full flex items-end gap-1.5 pt-2 border-t border-white/5">
                    <div class="w-1/6 bg-white/10 rounded-t h-1/3 hover:bg-white/20 transition-colors duration-200"></div>
                    <div class="w-1/6 bg-white/10 rounded-t h-1/2 hover:bg-white/20 transition-colors duration-200"></div>
                    <div class="w-1/6 bg-white/10 rounded-t h-2/3 hover:bg-white/20 transition-colors duration-200"></div>
                    <div class="w-1/6 bg-brand-blue/50 rounded-t h-3/4 hover:bg-brand-blue/70 transition-colors duration-200"></div>
                    <div class="w-1/6 bg-brand-accent/80 rounded-t h-4/5 hover:bg-brand-accent transition-colors duration-200"></div>
                    <div class="w-1/6 bg-brand-accent rounded-t h-full relative">
                        <div class="absolute -top-1.5 -right-1 w-3 h-3 bg-white rounded-full shadow-[0_0_12px_rgba(96,165,250,0.9)] z-10"></div>
                        <div class="absolute -top-1.5 -right-1 w-3 h-3 bg-white rounded-full animate-ping opacity-60"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="absolute bottom-0 left-0 right-0 h-24 bg-gradient-to-t from-brand-dark/0 via-brand-dark/50 to-brand-dark pointer-events-none">
    </div>
</section>

<!-- Tech Stack Marquee -->
<section class="py-8 bg-white border-b border-slate-100 overflow-hidden relative z-20">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 mb-6">
        <h3 class="text-center text-xs font-bold text-slate-400 uppercase tracking-widest">Tech Stack &
            Infrastruktur</h3>
    </div>

    <!-- Gradient Masks for smooth fade -->
    <div class="absolute inset-y-0 left-0 w-16 sm:w-32 bg-gradient-to-r from-white to-transparent z-10 pointer-events-none mt-12">
    </div>
    <div class="absolute inset-y-0 right-0 w-16 sm:w-32 bg-gradient-to-l from-white to-transparent z-10 pointer-events-none mt-12">
    </div>

    <div class="flex w-max animate-infinite-scroll hover:[animation-play-state:paused]">
        <!-- Group 1 -->
        <div class="flex gap-12 sm:gap-16 items-center px-6 sm:px-8">
            <!-- Laravel -->
            <div class="flex items-center gap-3 text-slate-400 hover:text-[#FF2D20] transition-colors duration-300 cursor-default grayscale hover:grayscale-0">
                <i class="fa-brands fa-laravel text-3xl"></i>
                <span class="font-display font-bold text-lg">Laravel</span>
            </div>
            <!-- MySQL -->
            <div class="flex items-center gap-3 text-slate-400 hover:text-[#4479A1] transition-colors duration-300 cursor-default grayscale hover:grayscale-0">
                <i class="fa-solid fa-database text-2xl"></i>
                <span class="font-display font-bold text-lg">MySQL</span>
            </div>
            <!-- Node.js -->
            <div class="flex items-center gap-3 text-slate-400 hover:text-[#339933] transition-colors duration-300 cursor-default grayscale hover:grayscale-0">
                <i class="fa-brands fa-node-js text-3xl"></i>
                <span class="font-display font-bold text-lg">Node.js</span>
            </div>
            <!-- Python -->
            <div class="flex items-center gap-3 text-slate-400 hover:text-[#3776AB] transition-colors duration-300 cursor-default grayscale hover:grayscale-0">
                <i class="fa-brands fa-python text-3xl"></i>
                <span class="font-display font-bold text-lg">Python</span>
            </div>
            <!-- PostgreSQL -->
            <div class="flex items-center gap-3 text-slate-400 hover:text-[#336791] transition-colors duration-300 cursor-default grayscale hover:grayscale-0">
                <i class="fa-solid fa-database text-2xl"></i>
                <span class="font-display font-bold text-lg">PostgreSQL</span>
            </div>
            <!-- Flowise -->
            <div class="flex items-center gap-3 text-slate-400 hover:text-brand-accent transition-colors duration-300 cursor-default grayscale hover:grayscale-0">
                <i class="fa-solid fa-robot text-2xl"></i>
                <span class="font-display font-bold text-lg">Flowise</span>
            </div>
            <!-- Redis -->
            <div class="flex items-center gap-3 text-slate-400 hover:text-[#DC382D] transition-colors duration-300 cursor-default grayscale hover:grayscale-0">
                <i class="fa-solid fa-server text-2xl"></i>
                <span class="font-display font-bold text-lg">Redis</span>
            </div>
            <!-- VPS -->
            <div class="flex items-center gap-3 text-slate-400 hover:text-slate-700 transition-colors duration-300 cursor-default grayscale hover:grayscale-0">
                <i class="fa-solid fa-cloud text-2xl"></i>
                <span class="font-display font-bold text-lg">VPS Server</span>
            </div>
            <!-- Docker -->
            <div class="flex items-center gap-3 text-slate-400 hover:text-[#2496ED] transition-colors duration-300 cursor-default grayscale hover:grayscale-0">
                <i class="fa-brands fa-docker text-3xl"></i>
                <span class="font-display font-bold text-lg">Docker</span>
            </div>
        </div>

        <!-- Group 2 (Duplicate for seamless loop) -->
        <div class="flex gap-12 sm:gap-16 items-center px-6 sm:px-8">
            <div class="flex items-center gap-3 text-slate-400 hover:text-[#FF2D20] transition-colors duration-300 cursor-default grayscale hover:grayscale-0">
                <i class="fa-brands fa-laravel text-3xl"></i>
                <span class="font-display font-bold text-lg">Laravel</span>
            </div>
            <div class="flex items-center gap-3 text-slate-400 hover:text-[#4479A1] transition-colors duration-300 cursor-default grayscale hover:grayscale-0">
                <i class="fa-solid fa-database text-2xl"></i>
                <span class="font-display font-bold text-lg">MySQL</span>
            </div>
            <div class="flex items-center gap-3 text-slate-400 hover:text-[#339933] transition-colors duration-300 cursor-default grayscale hover:grayscale-0">
                <i class="fa-brands fa-node-js text-3xl"></i>
                <span class="font-display font-bold text-lg">Node.js</span>
            </div>
            <div class="flex items-center gap-3 text-slate-400 hover:text-[#3776AB] transition-colors duration-300 cursor-default grayscale hover:grayscale-0">
                <i class="fa-brands fa-python text-3xl"></i>
                <span class="font-display font-bold text-lg">Python</span>
            </div>
            <div class="flex items-center gap-3 text-slate-400 hover:text-[#336791] transition-colors duration-300 cursor-default grayscale hover:grayscale-0">
                <i class="fa-solid fa-database text-2xl"></i>
                <span class="font-display font-bold text-lg">PostgreSQL</span>
            </div>
            <div class="flex items-center gap-3 text-slate-400 hover:text-brand-accent transition-colors duration-300 cursor-default grayscale hover:grayscale-0">
                <i class="fa-solid fa-robot text-2xl"></i>
                <span class="font-display font-bold text-lg">Flowise</span>
            </div>
            <div class="flex items-center gap-3 text-slate-400 hover:text-[#DC382D] transition-colors duration-300 cursor-default grayscale hover:grayscale-0">
                <i class="fa-solid fa-server text-2xl"></i>
                <span class="font-display font-bold text-lg">Redis</span>
            </div>
            <div class="flex items-center gap-3 text-slate-400 hover:text-slate-700 transition-colors duration-300 cursor-default grayscale hover:grayscale-0">
                <i class="fa-solid fa-cloud text-2xl"></i>
                <span class="font-display font-bold text-lg">VPS Server</span>
            </div>
            <div class="flex items-center gap-3 text-slate-400 hover:text-[#2496ED] transition-colors duration-300 cursor-default grayscale hover:grayscale-0">
                <i class="fa-brands fa-docker text-3xl"></i>
                <span class="font-display font-bold text-lg">Docker</span>
            </div>
        </div>
    </div>

    <style>
        @keyframes infinite-scroll {
            0% {
                transform: translateX(0);
            }

            100% {
                transform: translateX(-50%);
            }
        }

        .animate-infinite-scroll {
            animation: infinite-scroll 25s linear infinite;
        }

    </style>
</section>


<section id="services" class="bg-[#f8fafc] text-slate-800 py-16 px-4 sm:px-6 lg:px-8 relative z-20">
    <div class="max-w-6xl mx-auto flex flex-col lg:flex-row gap-12 lg:gap-16 items-center lg:items-start">

        <!-- Bagian Kiri (Teks) -->
        <div class="lg:w-[40%] flex flex-col items-center lg:items-start text-center lg:text-left lg:sticky lg:top-32 mb-8 lg:mb-0">
            <div class="inline-flex items-center justify-center px-4 py-1.5 rounded-full border border-slate-200 text-slate-800 mb-4 sm:mb-6 bg-white shadow-sm">
                <span class="font-bold text-[10px] tracking-widest uppercase">SERVICES</span>
            </div>
            <h2 class="font-display text-3xl sm:text-4xl lg:text-[2.25rem] font-semibold text-slate-900 mb-3 sm:mb-4 leading-[1.15] tracking-tight">
                Solusi Cerdas Untuk Bisnis Anda
            </h2>
            <p class="text-slate-500 leading-relaxed text-sm sm:text-base mb-6 sm:mb-8 max-w-lg">
                Mulai dari pembuatan sistem kustom hingga implementasi kecerdasan buatan, kami menghadirkan
                ekosistem digital yang berjalan secara otomatis.
            </p>
            <a href="https://wa.me/6285221694067" target="_blank" class="bg-btn-gradient shadow-glow-sm hover:shadow-glow-blue text-white text-sm font-semibold px-6 py-3 rounded-full hover:-translate-y-1 transition-all duration-300 flex items-center gap-2">
                Get Started <i class="fa-solid fa-arrow-right text-xs"></i>
            </a>
        </div>

        <!-- Bagian Kanan (Kartu) -->
        <div class="lg:w-[60%] grid grid-cols-1 sm:grid-cols-2 gap-5 w-full">
            <!-- Kartu 1 -->
            <div class="bg-btn-gradient text-white rounded-[1.5rem] p-6 sm:p-7 shadow-glow-sm hover:shadow-glow-blue hover:-translate-y-1.5 transition-all duration-300 h-full flex flex-col group border border-white/10">
                <div class="w-12 h-12 bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                    <i class="fa-solid fa-location-dot text-white text-xl"></i>
                </div>
                <h3 class="font-display font-semibold text-lg mb-3">Strategi & Konsultasi</h3>
                <p class="text-blue-100/90 text-[13px] sm:text-sm leading-relaxed">
                    Perencanaan arsitektur digital dan strategi implementasi teknologi yang selaras dengan tujuan
                    bisnis Anda.
                </p>
            </div>

            <!-- Kartu 2 -->
            <div class="bg-white border border-slate-100 text-slate-800 rounded-[1.5rem] p-6 sm:p-7 shadow-[0_4px_20px_rgb(0,0,0,0.03)] hover:shadow-[0_8px_30px_rgb(0,0,0,0.06)] hover:-translate-y-1.5 transition-all duration-300 h-full flex flex-col group">
                <div class="w-12 h-12 bg-btn-gradient rounded-full flex items-center justify-center mb-6 shadow-glow-sm group-hover:scale-110 transition-transform duration-300">
                    <i class="fa-solid fa-briefcase text-white text-lg"></i>
                </div>
                <h3 class="font-display font-semibold text-lg mb-3 text-slate-900">Rekayasa Infrastruktur</h3>
                <p class="text-slate-500 text-[13px] sm:text-sm leading-relaxed">
                    Pembuatan web, landing page premium, dan pengembangan API yang kokoh, cepat, serta aman.
                </p>
            </div>

            <!-- Kartu 3 -->
            <div class="bg-white border border-slate-100 text-slate-800 rounded-[1.5rem] p-6 sm:p-7 shadow-[0_4px_20px_rgb(0,0,0,0.03)] hover:shadow-[0_8px_30px_rgb(0,0,0,0.06)] hover:-translate-y-1.5 transition-all duration-300 h-full flex flex-col group">
                <div class="w-12 h-12 bg-btn-gradient rounded-full flex items-center justify-center mb-6 shadow-glow-sm group-hover:scale-110 transition-transform duration-300">
                    <i class="fa-solid fa-bolt text-white text-lg"></i>
                </div>
                <h3 class="font-display font-semibold text-lg mb-3 text-slate-900">Automasi Alur Kerja</h3>
                <p class="text-slate-500 text-[13px] sm:text-sm leading-relaxed">
                    Integrasi agen chatbot cerdas 24/7 dan sistem operasional otomatis untuk efisiensi bisnis.
                </p>
            </div>

            <!-- Kartu 4 -->
            <div class="bg-white border border-slate-100 text-slate-800 rounded-[1.5rem] p-6 sm:p-7 shadow-[0_4px_20px_rgb(0,0,0,0.03)] hover:shadow-[0_8px_30px_rgb(0,0,0,0.06)] hover:-translate-y-1.5 transition-all duration-300 h-full flex flex-col group">
                <div class="w-12 h-12 bg-btn-gradient rounded-full flex items-center justify-center mb-6 shadow-glow-sm group-hover:scale-110 transition-transform duration-300">
                    <i class="fa-solid fa-chart-simple text-white text-lg"></i>
                </div>
                <h3 class="font-display font-semibold text-lg mb-3 text-slate-900">Analisis & Prediksi</h3>
                <p class="text-slate-500 text-[13px] sm:text-sm leading-relaxed">
                    Penerapan sains data, segmentasi pasar otomatis, dan prediksi tren masa depan.
                </p>
            </div>
        </div>
    </div>
</section>

<section id="portofolio" class="bg-[#f8fafc] py-24 px-4 sm:px-6 lg:px-8 border-t border-slate-100 overflow-hidden" x-data="{}">
    <div class="max-w-6xl mx-auto">
        <!-- Header -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-12 gap-6">
            <div class="max-w-xl">
                <h2 class="font-display text-3xl sm:text-4xl font-semibold text-slate-900 leading-[1.15] tracking-tight mb-2">
                    Katalog Portofolio &<br>
                    <span class="text-brand-blue">Implementasi Sistem</span>
                </h2>
            </div>
            <div class="max-w-xs text-slate-500 text-sm leading-relaxed pb-1 md:text-right">
                Kumpulan video implementasi teknologi dan automasi bisnis yang telah kami selesaikan.
            </div>
        </div>

        <!-- Slider Wrapper -->
        <div class="relative w-full group">
            <!-- Carousel Container -->
            <div x-ref="slider" class="flex gap-5 sm:gap-6 overflow-x-auto snap-x snap-mandatory pb-8 pt-4 -mx-4 px-4 sm:-mx-6 sm:px-6 lg:mx-0 lg:px-0" style="scrollbar-width: none; -ms-overflow-style: none;">

                <!-- Card 1 -->
                <div class="shrink-0 w-[280px] sm:w-[360px] snap-center group/card">
                    <div class="relative w-full rounded-[1.5rem] overflow-hidden bg-black shadow-md transition-all duration-300 group-hover/card:shadow-xl group-hover/card:shadow-slate-300 group-hover/card:-translate-y-1 border border-slate-200">
                        <div style="padding-top: 56.25%;"></div>
                        <iframe class="absolute top-0 left-0 w-full h-full" src="https://www.youtube.com/embed/iUJWNHxI2RU" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                    </div>
                </div>

                <!-- Card 2 -->
                <div class="shrink-0 w-[280px] sm:w-[360px] snap-center group/card">
                    <div class="relative w-full rounded-[1.5rem] overflow-hidden bg-black shadow-md transition-all duration-300 group-hover/card:shadow-xl group-hover/card:shadow-slate-300 group-hover/card:-translate-y-1 border border-slate-200">
                        <div style="padding-top: 56.25%;"></div>
                        <iframe class="absolute top-0 left-0 w-full h-full" src="https://www.youtube.com/embed/-bkn_ignjD4" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                    </div>
                </div>

                <!-- Card 3 -->
                <div class="shrink-0 w-[280px] sm:w-[360px] snap-center group/card">
                    <div class="relative w-full rounded-[1.5rem] overflow-hidden bg-black shadow-md transition-all duration-300 group-hover/card:shadow-xl group-hover/card:shadow-slate-300 group-hover/card:-translate-y-1 border border-slate-200">
                        <div style="padding-top: 56.25%;"></div>
                        <iframe class="absolute top-0 left-0 w-full h-full" src="https://www.youtube.com/embed/kMWZS8c5Xuo" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                    </div>
                </div>

                <!-- Card 4 -->
                <div class="shrink-0 w-[280px] sm:w-[360px] snap-center group/card">
                    <div class="relative w-full rounded-[1.5rem] overflow-hidden bg-black shadow-md transition-all duration-300 group-hover/card:shadow-xl group-hover/card:shadow-slate-300 group-hover/card:-translate-y-1 border border-slate-200">
                        <div style="padding-top: 56.25%;"></div>
                        <iframe class="absolute top-0 left-0 w-full h-full" src="https://www.youtube.com/embed/tO4PwTDOLX8" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                    </div>
                </div>

                <!-- Card 5 -->
                <div class="shrink-0 w-[280px] sm:w-[360px] snap-center group/card">
                    <div class="relative w-full rounded-[1.5rem] overflow-hidden bg-black shadow-md transition-all duration-300 group-hover/card:shadow-xl group-hover/card:shadow-slate-300 group-hover/card:-translate-y-1 border border-slate-200">
                        <div style="padding-top: 56.25%;"></div>
                        <iframe class="absolute top-0 left-0 w-full h-full" src="https://www.youtube.com/embed/mG9gcUFLMeM" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                    </div>
                </div>

                <!-- Card 6 -->
                <div class="shrink-0 w-[280px] sm:w-[360px] snap-center group/card">
                    <div class="relative w-full rounded-[1.5rem] overflow-hidden bg-black shadow-md transition-all duration-300 group-hover/card:shadow-xl group-hover/card:shadow-slate-300 group-hover/card:-translate-y-1 border border-slate-200">
                        <div style="padding-top: 56.25%;"></div>
                        <iframe class="absolute top-0 left-0 w-full h-full" src="https://www.youtube.com/embed/9vuxrTVfRNo" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                    </div>
                </div>

            </div>

            <!-- Bottom Controls -->
            <div class="flex items-center justify-between mt-2">
                <a href="https://www.youtube.com/" target="_blank" class="bg-btn-gradient text-white font-medium px-6 py-3 rounded-full shadow-glow-sm hover:shadow-glow-blue hover:-translate-y-1 transition-all duration-300 text-sm flex items-center gap-2">
                    Buka YouTube <i class="fa-solid fa-arrow-up-right-from-square text-xs"></i>
                </a>

                <div class="flex items-center gap-3">
                    <button @click="$refs.slider.scrollBy({left: -360, behavior: 'smooth'})" class="w-12 h-12 rounded-full bg-white border border-slate-200 flex items-center justify-center text-slate-600 hover:bg-slate-50 hover:text-brand-blue transition-colors shadow-sm">
                        <i class="fa-solid fa-chevron-left"></i>
                    </button>
                    <button @click="$refs.slider.scrollBy({left: 360, behavior: 'smooth'})" class="w-12 h-12 rounded-full bg-white border border-slate-200 flex items-center justify-center text-slate-600 hover:bg-slate-50 hover:text-brand-blue transition-colors shadow-sm">
                        <i class="fa-solid fa-chevron-right"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <style>
        #portofolio .overflow-x-auto::-webkit-scrollbar {
            display: none;
        }

    </style>
</section>
<section id="ownerprofile" class="bg-brand-dark py-20 px-4 sm:px-6 lg:px-8 relative overflow-hidden border-t border-white/5">
    <!-- Background Decor -->
    <div class="absolute top-0 right-0 w-1/2 h-full bg-blue-glow opacity-20 pointer-events-none"></div>
    <div class="absolute bottom-[-10%] left-[-10%] w-[40%] h-[40%] rounded-full bg-brand-indigo/20 blur-[120px] pointer-events-none"></div>

    <div class="max-w-6xl mx-auto relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-20 items-center">

            {{-- Kiri: Teks & Spesialisasi --}}
            <div class="flex flex-col text-left order-2 lg:order-1">
                {{-- Badge Founder --}}
                <div class="inline-flex items-center gap-2 bg-brand-accent/10 border border-brand-accent/20 rounded-full px-4 py-1.5 mb-6 w-max">
                    <span class="w-2 h-2 rounded-full bg-brand-accent animate-pulse"></span>
                    <span class="text-brand-accent text-xs font-semibold tracking-wider uppercase">Founder & Lead Engineer</span>
                </div>

                {{-- Headline --}}
                <h2 class="font-display text-4xl sm:text-4xl md:text-4xl font-semi-bold text-white mb-6 leading-tight">
                    Mengubah Web Konvensional Menjadi <span class="text-transparent bg-clip-text bg-gradient-to-r from-brand-accent to-brand-indigo">Sistem Cerdas</span>
                </h2>

                {{-- Deskripsi personal founder --}}
                <p class="text-white/70 mb-8 text-xs sm:text-sm leading-relaxed">
                    Berlatar belakang pendidikan Sistem Informasi dan berpengalaman matang dalam arsitektur backend, saya fokus memimpin pengembangan sistem digital enterprise. Dengan rekam jejak menangani integrasi sistem berskala nasional hingga otomasi masa depan, saya siap membantu mentransformasi bisnis Anda lewat teknologi yang kokoh, cerdas, dan scalable.
                </p>

                {{-- Riwayat Keahlian / Track Record Founder --}}
                <div class="space-y-6 mb-10">
                    {{-- Poin 1: Pengalaman Kementerian (Simkopdes) --}}
                    <div class="flex items-start gap-4 p-5 rounded-2xl bg-white/5 border border-white/10 hover:border-brand-accent/30 hover:bg-white/10 transition-all duration-300">
                        <div class="w-12 h-12 rounded-xl bg-blue-500/20 flex items-center justify-center flex-shrink-0 border border-blue-500/30 shadow-[0_0_15px_rgba(59,130,246,0.3)]">
                            <i class="fa-solid fa-server text-brand-accent text-xl"></i>
                        </div>
                        <div>
                            <h4 class="text-white font-bold text-sm mb-1.5">Pengembangan Sistem Skala Nasional</h4>
                            <p class="text-white/60 text-xs leading-relaxed">Dipercaya sebagai backend engineer yang menghandle proyek strategis nasional, termasuk pengembangan <span class="text-white/80 font-medium">Simkopdes</span> di <span class="text-white/80 font-medium">Kementerian Koperasi dan UKM</span>. Ahli dalam merancang arsitektur aplikasi yang andal untuk volume data besar dan birokrasi yang kompleks.</p>
                        </div>
                    </div>


                    <div class="flex items-start gap-4 p-5 rounded-2xl bg-white/5 border border-white/10 hover:border-brand-accent/30 hover:bg-white/10 transition-all duration-300">
                        <div class="w-12 h-12 rounded-xl bg-blue-500/20 flex items-center justify-center flex-shrink-0 border border-blue-500/30 shadow-[0_0_15px_rgba(59,130,246,0.3)]">
                            <i class="fa-solid fa-robot text-brand-accent text-xl"></i>
                        </div>
                        <div>
                            <h4 class="text-white font-bold text-sm mb-1.5">Spesialisasi AI Agent & Integrasi Multi-Platform</h4>
                            <p class="text-white/60 text-xs leading-relaxed">Melalui pengalaman di <span class="text-white/80 font-medium">Global Komunika</span>, saya mendalami perancangan agen pintar (AI Agent) untuk otomatisasi alur kerja serta membangun integrasi API multi-platform yang menjamin kelancaran komunikasi data antar ekosistem digital.</p>
                        </div>
                    </div>
                </div>

                <div>
                    <a href="https://wa.me/6285221694067" target="_blank" class="inline-flex items-center gap-3 bg-btn-gradient text-white font-semibold px-8 py-4 rounded-full shadow-glow-blue hover:scale-105 transition-all duration-300 text-sm group">
                        Mulai Otomatisasi Sekarang
                        <span class="w-7 h-7 bg-white/20 rounded-full flex items-center justify-center group-hover:bg-white/30 transition-colors">
                            <i class="fa-solid fa-arrow-right text-xs"></i>
                        </span>
                    </a>
                </div>
            </div>

            <div class="relative flex items-center justify-center lg:justify-end order-1 lg:order-2">
                {{-- Ornamen dekorasi di belakang foto --}}
                <div class="absolute inset-0 bg-gradient-to-br from-brand-accent/20 to-brand-indigo/30 rounded-[2rem] transform rotate-3 scale-105 blur-md hidden md:block"></div>
                <div class="absolute inset-0 border border-brand-accent/20 rounded-[2rem] transform -rotate-2 hidden md:block"></div>

                {{-- Wadah gambar --}}
                <div class="relative w-full max-w-sm lg:max-w-md aspect-[4/5] rounded-[2rem] overflow-hidden border border-white/10 shadow-2xl bg-brand-navy">
                    <div class="absolute inset-0 bg-gradient-to-t from-[#0A0E2A] via-[#0A0E2A]/20 to-transparent z-10"></div>

                    {{-- Anda bisa upload foto owner ke folder public/images dengan nama founder.png --}}
                    <img src="{{ asset('images/founder.png') }}" alt="Founder Scalify" class="w-full h-full object-cover object-top relative z-0">

                    {{-- Badge nama di atas gambar --}}
                    <div class="absolute bottom-6 left-6 right-6 z-20 p-4 rounded-xl border border-white/20 shadow-xl" style="background: rgba(255, 255, 255, 0.05); backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px);">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-white font-bold text-lg tracking-wide">Muhammad Andi</h3>
                                <p class="text-brand-accent text-xs font-medium mt-0.5">Founder & System Architect</p>
                            </div>
                            <a href="https://www.linkedin.com/in/muhammad-andi-mubarok" target="_blank" class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center border border-white/20 hover:bg-white/20 transition-colors">
                                <i class="fa-brands fa-linkedin-in text-white text-sm"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<section id="layanan" class="bg-brand-dark py-16 sm:py-20 px-4 sm:px-6 lg:px-8 border-t border-white/5">
    <div class="max-w-6xl mx-auto">
        <div class="flex justify-center mb-4 sm:mb-6">
            <span class="border border-white/20 text-white/60 text-[10px] sm:text-xs font-medium rounded-full px-4 py-1.5">Pricing
                & Services</span>
        </div>
        <h2 class="font-display text-3xl sm:text-4xl md:text-5xl font-semibold text-center text-white mb-4 sm:mb-6 leading-tight tracking-wide">
            Paket Layanan
            Ekspansi Digital</h2>
        <p class="text-white/60 text-center max-w-xl mx-auto text-xs sm:text-sm mb-10 sm:mb-14 px-2">Pilih solusi
            cerdas yang paling sesuai
            dengan skala dan kebutuhan automasi bisnis Anda saat ini.</p>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white/5 border border-white/10 rounded-2xl p-6 flex flex-col h-full">
                <h3 class="font-bold text-lg text-white mb-2">1. Digital Presence</h3>
                <p class="text-white/50 text-xs mb-6 h-8">Fondasi digital profesional untuk UMKM modern.</p>
                <ul class="text-sm text-white/70 space-y-3 mb-8 flex-1">
                    <li class="flex items-center gap-2"><span class="text-brand-accent">✓</span> Landing Page Elegan
                    </li>
                    <li class="flex items-center gap-2"><span class="text-brand-accent">✓</span> Company Profile
                        Website</li>
                    <li class="flex items-center gap-2"><span class="text-brand-accent">✓</span> Desain Responsif &
                        Cepat</li>
                </ul>
                <a href="https://wa.me/6285221694067?text=Halo%20Scalify,%20saya%20tertarik%20dengan%20Paket%20Digital%20Presence" target="_blank" class="w-full py-3 rounded-xl border border-white/20 text-center text-sm font-semibold hover:bg-white/10 transition-colors">Pilih
                    Paket</a>
            </div>

            <div class="relative bg-gradient-to-br from-blue-600/20 to-indigo-700/20 border border-brand-accent/50 rounded-2xl p-6 flex flex-col h-full transform md:-translate-y-4 shadow-glow-sm">
                <div class="absolute top-0 right-0 bg-brand-accent text-brand-dark text-[10px] font-bold px-3 py-1 rounded-bl-lg rounded-tr-xl">
                    POPULER</div>
                <h3 class="font-bold text-lg text-white mb-2">2. Smart Automation</h3>
                <p class="text-white/50 text-xs mb-6 h-8">Sistem operasional dengan fitur automasi mutakhir.</p>
                <ul class="text-sm text-white/70 space-y-3 mb-8 flex-1">
                    <li class="flex items-center gap-2"><span class="text-brand-accent">✓</span> Semua Fitur Paket 1
                    </li>
                    <li class="flex items-center gap-2"><span class="text-brand-accent">✓</span> Web/Aplikasi Bisnis
                        Kustom</li>
                    <li class="flex items-center gap-2"><span class="text-brand-accent">✓</span> Integrasi Chatbot
                        AI (Flowise)</li>
                    <li class="flex items-center gap-2"><span class="text-brand-accent">✓</span> Sistem Automasi
                        Order/Kasir</li>
                </ul>
                <a href="https://wa.me/6285221694067?text=Halo%20Scalify,%20saya%20tertarik%20dengan%20Paket%20Smart%20Automation" target="_blank" class="w-full py-3 rounded-xl bg-btn-gradient text-white text-center text-sm font-semibold hover:shadow-glow-blue transition-all">Pilih
                    Paket</a>
            </div>

            <div class="bg-white/5 border border-white/10 rounded-2xl p-6 flex flex-col h-full">
                <h3 class="font-bold text-lg text-white mb-2">3. Intelligence & Data</h3>
                <p class="text-white/50 text-xs mb-6 h-8">Solusi korporat dengan penerapan algoritma prediktif.</p>
                <ul class="text-sm text-white/70 space-y-3 mb-8 flex-1">
                    <li class="flex items-center gap-2"><span class="text-brand-accent">✓</span> Semua Fitur Paket 2
                    </li>
                    <li class="flex items-center gap-2"><span class="text-brand-accent">✓</span> Segmentasi Pasar
                        (K-Means)</li>
                    <li class="flex items-center gap-2"><span class="text-brand-accent">✓</span> Prediksi Bisnis
                        (Metode C45)</li>
                    <li class="flex items-center gap-2"><span class="text-brand-accent">✓</span> Arsitektur Data
                        Terpusat</li>
                </ul>
                <a href="https://wa.me/6285221694067?text=Halo%20Scalify,%20saya%20tertarik%20dengan%20Paket%20Intelligence%20%26%20Data" target="_blank" class="w-full py-3 rounded-xl border border-white/20 text-center text-sm font-semibold hover:bg-white/10 transition-colors">Konsultasi
                    Khusus</a>
            </div>
        </div>
    </div>
</section>



<section class="bg-[#0c1033] py-16 sm:py-20 px-4 sm:px-6 lg:px-8 text-center relative overflow-hidden border-t border-white/5">
    <div class="absolute inset-0 bg-blue-glow opacity-30 pointer-events-none"></div>
    <div class="relative z-10 max-w-2xl mx-auto">
        <h2 class="font-display text-3xl sm:text-4xl md:text-5xl font-semibold mb-4 sm:mb-6 leading-tight tracking-wide">
            Siap
            Mengeskalasi Bisnis Anda?</h2>
        <p class="text-white/60 mb-8 text-xs sm:text-sm leading-relaxed px-2">Mari diskusikan bagaimana kecerdasan
            buatan dan automasi dapat
            menghemat waktu, tenaga, dan melipatgandakan keuntungan UMKM Anda.</p>
        <a href="https://wa.me/6285221694067" target="_blank" class="inline-flex items-center gap-2 sm:gap-3 bg-btn-gradient text-white font-semibold px-6 sm:px-8 py-3 sm:py-4 rounded-full shadow-glow-blue hover:scale-105 transition-all text-xs sm:text-sm">
            Hubungi Kami Sekarang
            <span class="w-6 h-6 sm:w-7 sm:h-7 bg-white/20 rounded-full flex items-center justify-center">→</span>
        </a>
    </div>
</section>

@endsection
