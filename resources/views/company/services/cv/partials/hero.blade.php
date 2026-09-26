{{-- ══════════════════════════════════════════════════
     HERO SECTION CV SERVICE — High-Converting, Premium Design
══════════════════════════════════════════════════ --}}
<section class="relative pt-14 pb-20 sm:pt-20 sm:pb-28 px-4 sm:px-6 lg:px-8 overflow-hidden bg-[#080c27]">

    {{-- Layered Ambient Glow --}}
    <div class="absolute inset-0 pointer-events-none" style="background: radial-gradient(ellipse 80% 60% at 50% -10%, rgba(59,130,246,0.18) 0%, transparent 70%);"></div>
    <div class="absolute top-0 right-0 w-[500px] h-[500px] rounded-full pointer-events-none" style="background: radial-gradient(circle, rgba(6,182,212,0.12) 0%, transparent 65%); transform: translate(20%, -30%);"></div>
    <div class="absolute bottom-0 left-0 w-[400px] h-[400px] rounded-full pointer-events-none" style="background: radial-gradient(circle, rgba(99,102,241,0.08) 0%, transparent 65%); transform: translate(-30%, 30%);"></div>

    {{-- Subtle dot grid --}}
    <div class="absolute inset-0 opacity-[0.028] pointer-events-none" style="background-image: radial-gradient(#ffffff 1px, transparent 1px); background-size: 28px 28px;"></div>

    <div class="relative z-10 max-w-6xl mx-auto">

        {{-- === TOP SOCIAL PROOF BAR === --}}
        <div class="flex flex-wrap items-center gap-x-6 gap-y-2.5 mb-8">
            {{-- User Avatars --}}
            <div class="flex items-center gap-2.5">
                <div class="flex -space-x-2.5">
                    @php
                    $avatars = [
                    'https://i.pravatar.cc/40?img=47',
                    'https://i.pravatar.cc/40?img=12',
                    'https://i.pravatar.cc/40?img=32',
                    'https://i.pravatar.cc/40?img=25',
                    'https://i.pravatar.cc/40?img=8',
                    ];
                    @endphp
                    @foreach($avatars as $av)
                    <img src="{{ $av }}" alt="pengguna" loading="lazy" class="w-8 h-8 rounded-full border-2 object-cover" style="border-color: #080c27;">
                    @endforeach
                    <div class="w-8 h-8 rounded-full border-2 flex items-center justify-center text-[9px] font-black text-white" style="border-color: #080c27; background: linear-gradient(135deg, #2563eb, #06b6d4);">
                        +{{ $totalReviews > 5 ? $totalReviews - 5 : '50' }}
                    </div>
                </div>
                <div>
                    <div class="flex items-center gap-0.5 mb-0.5">
                        @for($i = 1; $i <= 5; $i++) <svg class="w-3 h-3 {{ $i <= round($averageRating) ? 'text-amber-400' : 'text-white/20' }}" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" /></svg>
                            @endfor
                    </div>
                    <p class="text-white/55 text-[11px] leading-none">
                        <span class="text-white font-bold">{{ $averageRating }}/5</span>
                        dari <span class="text-white font-semibold">{{ $totalReviews > 0 ? $totalReviews : '200' }}+</span> pengguna
                    </p>
                </div>
            </div>

            <div class="h-4 w-px bg-white/10 hidden sm:block"></div>

            {{-- Trust Badges --}}
            <div class="flex items-center gap-1.5 text-emerald-400">
                <svg class="w-3.5 h-3.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                <span class="text-[11px] font-semibold text-white/70">Gratis selamanya untuk akses mandiri</span>
            </div>

            <div class="flex items-center gap-1.5">
                <svg class="w-3.5 h-3.5 text-cyan-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                <span class="text-[11px] font-semibold text-white/70">AI Gemini — selesai dalam 60 detik</span>
            </div>
        </div>

        {{-- === MAIN CONTENT GRID === --}}
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-16 items-center">

            {{-- LEFT: Copy --}}
            <div class="lg:col-span-7">

                {{-- Eyebrow --}}
                <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full border mb-5 text-[11px] font-bold tracking-wider uppercase" style="background: rgba(6,182,212,0.08); border-color: rgba(6,182,212,0.25); color: #67e8f9;">
                    <span class="w-1.5 h-1.5 rounded-full bg-cyan-400 animate-pulse"></span>
                    AI CV Builder · Standar HRD & ATS
                </div>

                {{-- Headline --}}
                <h1 class="font-black text-[32px] sm:text-[42px] lg:text-[48px] text-white leading-[1.12] tracking-[-0.03em] mb-5">
                    CV Biasa Saja?<br>
                    <span class="relative inline-block">
                        <span class="bg-gradient-to-r from-cyan-300 via-blue-400 to-indigo-400 bg-clip-text text-transparent">HRD Lewati Anda</span>
                        {{-- Underline decoration --}}
                        <svg class="absolute -bottom-2 left-0 w-full" height="6" viewBox="0 0 300 6" preserveAspectRatio="none" fill="none">
                            <path d="M0 4 Q75 0 150 3 Q225 6 300 2" stroke="url(#heroUnderline)" stroke-width="2.5" stroke-linecap="round" />
                            <defs>
                                <linearGradient id="heroUnderline" x1="0" y1="0" x2="1" y2="0">
                                    <stop offset="0%" stop-color="#22d3ee" />
                                    <stop offset="100%" stop-color="#818cf8" />
                                </linearGradient>
                            </defs>
                        </svg>
                    </span>
                    <br>dalam <span class="text-white">7 Detik</span>
                </h1>

                {{-- Subheadline --}}
                <p class="text-white/60 text-sm sm:text-[15px] max-w-xl leading-relaxed mb-8">
                    Formulasikan riwayat karir Anda ke dalam CV 2-kolom berstandar internasional menggunakan
                    <strong class="text-white/90 font-semibold">formula STAR/XYZ</strong>,
                    layout bebas error margin, dan ekspor
                    <strong class="text-white/90 font-semibold">PDF A4 presisi</strong> — semuanya dibantu AI dalam hitungan menit.
                </p>

                {{-- Feature Checklist --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5 mb-9">
                    @php
                    $features = [
                    ['icon' => '✓', 'color' => 'text-emerald-400', 'text' => 'ATS Score 98% — Lolos Filter Robot HR'],
                    ['icon' => '✓', 'color' => 'text-emerald-400', 'text' => 'AI Isi Otomatis dari Ceritamu'],
                    ['icon' => '✓', 'color' => 'text-emerald-400', 'text' => 'Format 2-Kolom Standar FAANG & BUMN'],
                    ['icon' => '✓', 'color' => 'text-emerald-400', 'text' => 'Print PDF A4 Presisi — Siap Kirim'],
                    ['icon' => '✓', 'color' => 'text-emerald-400', 'text' => 'Drag & Drop Susun Urutan Section'],
                    ['icon' => '✓', 'color' => 'text-emerald-400', 'text' => 'Konsultasi Real-Time dengan Scalify AI'],
                    ];
                    @endphp
                    @foreach($features as $feat)
                    <div class="flex items-start gap-2.5">
                        <span class="mt-0.5 w-4 h-4 rounded-full flex items-center justify-center text-[10px] font-black bg-emerald-500/15 text-emerald-400 flex-shrink-0">{{ $feat['icon'] }}</span>
                        <span class="text-white/70 text-xs sm:text-[13px] leading-tight">{{ $feat['text'] }}</span>
                    </div>
                    @endforeach
                </div>

                {{-- CTAs --}}
                <div class="flex flex-wrap items-center gap-3">
                    <a href="#ai-builder-section" class="group inline-flex items-center gap-3 text-white text-sm font-black px-7 py-4 rounded-2xl shadow-lg hover:scale-[1.03] hover:-translate-y-0.5 transition-all duration-200" style="background: linear-gradient(135deg, #2563eb 0%, #06b6d4 100%); box-shadow: 0 0 32px rgba(37,99,235,0.4), 0 4px 20px rgba(0,0,0,0.3);">
                        <span>Buat CV Gratis Sekarang</span>
                        <span class="w-6 h-6 rounded-xl bg-white/20 flex items-center justify-center group-hover:translate-x-0.5 transition-transform text-xs">→</span>
                    </a>
                    <a href="#showcase-section" class="inline-flex items-center gap-2 text-white/80 hover:text-white text-sm font-semibold px-5 py-4 rounded-2xl border border-white/10 hover:border-white/25 hover:bg-white/5 transition-all">
                        <svg class="w-4 h-4 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                        Lihat Contoh CV
                    </a>
                </div>

                {{-- Urgency / FOMO nudge --}}
                <div class="flex items-center gap-2 mt-5">
                    <span class="relative flex h-2 w-2">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-400"></span>
                    </span>
                    <p class="text-white/40 text-[11px]">
                        <span class="text-white/70 font-semibold">{{ $totalReviews > 10 ? $totalReviews . ' pengguna' : 'Ratusan pengguna' }}</span>
                        sudah mencetak CV hari ini — mulai sekarang sebelum posisi incaran terisi!
                    </p>
                </div>

            </div>

            {{-- RIGHT: CV Preview Card (Visual teaser) --}}
            <div class="lg:col-span-5 hidden lg:block">
                <div class="relative">

                    {{-- Floating badge top-left --}}
                    <div class="absolute -top-4 -left-4 z-20 flex items-center gap-2 px-3.5 py-2 rounded-2xl shadow-xl text-xs font-bold text-white" style="background: linear-gradient(135deg, #059669, #10b981); box-shadow: 0 8px 24px rgba(16,185,129,0.35);">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        ATS Score: 98%
                    </div>

                    {{-- Floating badge bottom-right --}}
                    <div class="absolute -bottom-4 -right-4 z-20 px-3.5 py-2 rounded-2xl shadow-xl text-xs font-bold text-white" style="background: linear-gradient(135deg, #2563eb, #6366f1); box-shadow: 0 8px 24px rgba(99,102,241,0.35);">
                        ✨ Powered by Gemini AI
                    </div>

                    {{-- CV Preview mockup --}}
                    <div class="rounded-2xl overflow-hidden shadow-2xl border border-white/10 relative" style="box-shadow: 0 24px 80px rgba(0,0,0,0.5), 0 0 0 1px rgba(255,255,255,0.06);">

                        {{-- Browser chrome --}}
                        <div class="flex items-center gap-1.5 px-4 py-2.5" style="background: rgba(255,255,255,0.05); border-bottom: 1px solid rgba(255,255,255,0.06);">
                            <div class="w-2.5 h-2.5 rounded-full bg-red-400/70"></div>
                            <div class="w-2.5 h-2.5 rounded-full bg-amber-400/70"></div>
                            <div class="w-2.5 h-2.5 rounded-full bg-emerald-400/70"></div>
                            <div class="flex-1 mx-3 h-5 rounded-md flex items-center px-2.5" style="background: rgba(255,255,255,0.06);">
                                <span class="text-[9px] text-white/30 font-mono">scalifyintellegence.my.id/layanan/template-cv</span>
                            </div>
                        </div>

                        {{-- Mini CV preview --}}
                        <div class="grid grid-cols-5 min-h-[340px]" style="background: #ffffff;">
                            {{-- Left sidebar (colored) --}}
                            <div class="col-span-2 p-4 flex flex-col gap-3" style="background: #1e3a8a;">
                                {{-- Avatar placeholder --}}
                                <div class="w-16 h-16 rounded-full mx-auto border-2 border-white/30 flex items-center justify-center text-2xl" style="background: rgba(255,255,255,0.15);">
                                    👤
                                </div>
                                {{-- Name --}}
                                <div class="text-center">
                                    <div class="h-2 rounded-full bg-white/80 mb-1.5 mx-2"></div>
                                    <div class="h-1.5 rounded-full bg-white/40 mx-4"></div>
                                </div>
                                {{-- Divider --}}
                                <div class="h-px bg-white/20 mx-2"></div>
                                {{-- Contact --}}
                                <div class="space-y-1.5">
                                    @for($i=0; $i<4; $i++) <div class="flex items-center gap-1.5">
                                        <div class="w-3 h-3 rounded-sm bg-cyan-400/60 flex-shrink-0"></div>
                                        <div class="h-1.5 rounded-full bg-white/30 flex-1"></div>
                                </div>
                                @endfor
                            </div>
                            {{-- Skills --}}
                            <div class="h-px bg-white/20 mx-2"></div>
                            <div class="space-y-2">
                                <div class="h-1.5 w-10 rounded bg-cyan-400/70"></div>
                                @for($i=0; $i<3; $i++) <div>
                                    <div class="h-1.5 rounded-full bg-white/30 mb-1" style="width: {{ [85,72,90][$i] }}%"></div>
                                    <div class="h-1 rounded-full bg-white/15 overflow-hidden">
                                        <div class="h-full rounded-full bg-cyan-400/70" style="width: {{ [85,72,90][$i] }}%"></div>
                                    </div>
                            </div>
                            @endfor
                        </div>
                    </div>

                    {{-- Right content --}}
                    <div class="col-span-3 p-4 flex flex-col gap-3">
                        {{-- Profile --}}
                        <div>
                            <div class="h-1.5 w-16 rounded bg-blue-800/60 mb-2"></div>
                            <div class="space-y-1">
                                <div class="h-1.5 rounded bg-slate-200 w-full"></div>
                                <div class="h-1.5 rounded bg-slate-200 w-5/6"></div>
                                <div class="h-1.5 rounded bg-slate-200 w-4/5"></div>
                            </div>
                        </div>
                        {{-- Experience --}}
                        <div class="h-px bg-slate-100"></div>
                        <div>
                            <div class="h-1.5 w-20 rounded bg-blue-800/60 mb-2"></div>
                            <div class="space-y-2">
                                @for($i=0; $i<2; $i++) <div>
                                    <div class="h-1.5 rounded bg-slate-300 w-3/4 mb-1"></div>
                                    <div class="h-1 rounded bg-slate-200 w-full mb-0.5"></div>
                                    <div class="h-1 rounded bg-slate-200 w-5/6"></div>
                            </div>
                            @endfor
                        </div>
                    </div>
                    {{-- Education --}}
                    <div class="h-px bg-slate-100"></div>
                    <div>
                        <div class="h-1.5 w-16 rounded bg-blue-800/60 mb-2"></div>
                        <div class="h-1.5 rounded bg-slate-300 w-3/4 mb-1"></div>
                        <div class="h-1 rounded bg-slate-200 w-1/2"></div>
                    </div>

                    {{-- AI generating animation --}}
                    <div class="mt-auto flex items-center gap-2 py-2 px-3 rounded-xl" style="background: rgba(37,99,235,0.06); border: 1px solid rgba(37,99,235,0.12);">
                        <div class="flex gap-0.5 items-center">
                            <span class="w-1.5 h-1.5 rounded-full bg-blue-500 animate-bounce" style="animation-delay:0s"></span>
                            <span class="w-1.5 h-1.5 rounded-full bg-blue-500 animate-bounce" style="animation-delay:0.15s"></span>
                            <span class="w-1.5 h-1.5 rounded-full bg-blue-500 animate-bounce" style="animation-delay:0.3s"></span>
                        </div>
                        <span class="text-[9px] text-blue-700 font-semibold">Scalify AI sedang menulis CV Anda...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

    </div>

    {{-- ===== STATS BAR ===== --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-5 sm:gap-8 pt-10 mt-12 border-t border-white/8">
        @php
        $stats = [
        ['val' => '98', 'suffix' => '%', 'label' => 'Lolos ATS & Standar HRD', 'color' => 'text-cyan-400'],
        ['val' => '3.8', 'suffix' => 'x', 'label' => 'Lebih Banyak Dipanggil Interview', 'color' => 'text-blue-400'],
        ['val' => '< 3', 'suffix'=> ' mnt', 'label' => 'Waktu Buat CV Lengkap dengan AI', 'color' => 'text-indigo-400'],
            ['val' => 'Rp 0', 'suffix' => '', 'label' => 'Akses Builder Mandiri Selamanya', 'color' => 'text-emerald-400'],
            ];
            @endphp
            @foreach($stats as $stat)
            <div class="group">
                <div class="font-black text-2xl sm:text-3xl lg:text-[36px] text-white tracking-tight mb-1 flex items-baseline gap-1 leading-none">
                    <span>{{ $stat['val'] }}</span>
                    <span class="{{ $stat['color'] }} text-lg font-extrabold">{{ $stat['suffix'] }}</span>
                </div>
                <div class="text-white/45 text-[11px] sm:text-xs font-normal leading-snug">{{ $stat['label'] }}</div>
            </div>
            @endforeach
    </div>

    </div>
</section>
