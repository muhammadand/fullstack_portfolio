@extends('layouts.app')

@section('title', 'Portfolio')

@section('content')
    @if ($featuredPortfolio)
        <section class="relative z-20 w-full overflow-hidden">

            {{-- HERO LINK --}}
            <a href="{{ route('portfolio.read', $featuredPortfolio->slug) }}"
                class="block relative w-full h-[420px] overflow-hidden group">

                {{-- BG BASE (Midnight Blue) --}}
                <div class="absolute inset-0 bg-[#0b1120]"></div>

                {{-- RADIAL GLOW ACCENTS --}}
                <div class="absolute inset-0 pointer-events-none">
                    <div class="absolute top-[10%] left-[55%] w-80 h-80 rounded-full bg-blue-900/30 blur-[80px]"></div>
                    <div class="absolute bottom-[15%] left-[20%] w-56 h-56 rounded-full bg-indigo-900/25 blur-[60px]"></div>
                    <div class="absolute top-[50%] right-[10%] w-40 h-40 rounded-full bg-sky-900/20 blur-[50px]"></div>
                </div>

                {{-- THUMBNAIL IMAGE --}}
                @if ($featuredPortfolio->thumbnail_image)
                    <img src="{{ asset('storage/' . $featuredPortfolio->thumbnail_image) }}"
                        alt="{{ $featuredPortfolio->title }}"
                        class="absolute inset-0 w-full h-full object-cover opacity-[0.18] group-hover:opacity-[0.25] group-hover:scale-105 transition-all duration-700 ease-out">
                @endif

                {{-- SUBTLE DOT/GRID OVERLAY --}}
                <div class="absolute inset-0 opacity-[0.025]"
                    style="background-image: linear-gradient(to right, #a0b4d0 1px, transparent 1px), linear-gradient(to bottom, #a0b4d0 1px, transparent 1px); background-size: 48px 48px;">
                </div>

                {{-- BOTTOM GRADIENT FADE --}}
                <div class="absolute inset-0 bg-gradient-to-t from-[#060a13]/98 via-[#0b1120]/55 to-transparent"></div>

                {{-- TOP-RIGHT META TAGS --}}
                <div class="absolute top-5 right-5 flex flex-col items-end gap-2 z-10">
                    <div
                        class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-white/[0.05] border border-white/[0.08] text-white/40 text-[11px] backdrop-blur-sm">
                        <i class="fas fa-calendar-alt text-blue-400/60 text-[10px]"></i>
                        {{ \Carbon\Carbon::parse($featuredPortfolio->created_at)->format('Y') }}
                    </div>

                </div>

                {{-- MAIN CONTENT (Bottom-left) --}}
                <div class="absolute inset-0 flex items-end z-10">
                    <div class="w-full max-w-[1400px] mx-auto px-6 sm:px-8 lg:px-10 pb-9 lg:pb-12">
                        <div class="max-w-2xl">

                            {{-- BADGE ROW --}}
                            <div class="flex items-center gap-3 mb-4 flex-wrap">

                                {{-- Featured Badge --}}
                                <div
                                    class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-900/30 border border-blue-500/20 text-blue-300/70 text-[10px] font-medium tracking-[0.15em] uppercase backdrop-blur-sm">
                                    <span class="w-1.5 h-1.5 rounded-full bg-blue-400 animate-pulse"></span>
                                    Featured project
                                </div>

                                @php
                                    $techs = is_array($featuredPortfolio->technologies)
                                        ? $featuredPortfolio->technologies
                                        : explode(',', $featuredPortfolio->technologies ?? '');
                                    $firstTech = !empty($techs) ? trim($techs[0]) : null;
                                @endphp

                                @if ($firstTech)
                                    <span class="text-sky-400/80 text-[11px] font-medium uppercase tracking-widest">
                                        {{ $firstTech }}
                                    </span>
                                @endif

                            </div>

                            {{-- TITLE --}}
                            <h1
                                class="font-semibold text-[30px] sm:text-[34px] lg:text-[38px] leading-[1.15] tracking-tight text-white/95 mb-3">
                                {{ $featuredPortfolio->title }}
                            </h1>

                            {{-- SHORT DESCRIPTION --}}
                            <p class="text-sm text-white/45 leading-relaxed font-light mb-6 max-w-lg">
                                {{ \Illuminate\Support\Str::limit($featuredPortfolio->short_description, 160) }}
                            </p>

                            {{-- ACTION BUTTONS --}}
                            <div class="flex items-center gap-4 flex-wrap">

                                <div
                                    class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full bg-blue-500 hover:bg-blue-400 text-white text-sm font-medium transition-colors duration-300 cursor-pointer">
                                    Explore project
                                    <i
                                        class="fas fa-arrow-right text-xs group-hover:translate-x-1 transition-transform duration-300"></i>
                                </div>

                                <div class="hidden sm:flex items-center gap-1.5 text-white/30 text-xs">
                                    <i class="fas fa-eye text-blue-400/70 text-xs"></i>
                                    {{ number_format($featuredPortfolio->view_count ?? 0) }} views
                                </div>

                            </div>

                        </div>
                    </div>
                </div>

            </a>

            {{-- MARQUEE STRIP --}}
            <div class="relative bg-[#080d19] border-t border-white/[0.05] py-3 overflow-hidden">

                {{-- LEFT FADE --}}
                <div
                    class="absolute left-0 top-0 bottom-0 w-16 bg-gradient-to-r from-[#080d19] to-transparent z-10 pointer-events-none">
                </div>
                {{-- RIGHT FADE --}}
                <div
                    class="absolute right-0 top-0 bottom-0 w-16 bg-gradient-to-l from-[#080d19] to-transparent z-10 pointer-events-none">
                </div>

                {{-- MARQUEE TRACK --}}
                <div class="flex w-max gap-3" style="animation: marquee 28s linear infinite;">

                    @php
                        $chips = [
                            ['icon' => 'fa-robot', 'label' => 'AI Chatbot Automation'],
                            ['icon' => 'fa-network-wired', 'label' => 'Marketplace Integration'],
                            ['icon' => 'fa-credit-card', 'label' => 'Payment Gateway'],
                            ['icon' => 'fa-chart-line', 'label' => 'Machine Learning'],
                            ['icon' => 'fa-plug', 'label' => 'REST API'],
                            ['icon' => 'fa-database', 'label' => 'Database Design'],
                            ['icon' => 'fa-shield-alt', 'label' => 'Auth & Security'],
                            ['icon' => 'fa-code-branch', 'label' => 'Version Control'],
                            ['icon' => 'fa-cloud', 'label' => 'Cloud Deployment'],
                        ];
                    @endphp

                    {{-- GROUP 1 --}}
                    @foreach ($chips as $chip)
                        <div
                            class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full border border-blue-800/40 bg-blue-900/10 text-white/40 text-xs font-light whitespace-nowrap">
                            <i class="fas {{ $chip['icon'] }} text-blue-400/60 text-[11px]"></i>
                            {{ $chip['label'] }}
                        </div>
                    @endforeach

                    {{-- GROUP 2 (seamless duplicate) --}}
                    @foreach ($chips as $chip)
                        <div
                            class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full border border-blue-800/40 bg-blue-900/10 text-white/40 text-xs font-light whitespace-nowrap">
                            <i class="fas {{ $chip['icon'] }} text-blue-400/60 text-[11px]"></i>
                            {{ $chip['label'] }}
                        </div>
                    @endforeach

                </div>
            </div>

        </section>

        {{-- INLINE STYLE: Marquee animation (define once, ideally in app.css) --}}
        <style>
            @keyframes marquee {
                0% {
                    transform: translateX(0);
                }

                100% {
                    transform: translateX(-50%);
                }
            }
        </style>
    @endif



    <section id="portfolio" class="relative bg-white pb-10">

        <!-- Background Decoration -->
        <div class="absolute top-0 left-0 w-full h-full overflow-hidden pointer-events-none">
            <div class="absolute top-40 left-[-120px] w-72 h-72 bg-brand-accent/5 rounded-full blur-3xl"></div>
            <div class="absolute bottom-0 right-[-120px] w-80 h-80 bg-brand-blue/5 rounded-full blur-3xl"></div>
        </div>

        <div class="relative z-10 max-w-[1450px] mx-auto px-3 sm:px-4 lg:px-5">

            <!-- Section Heading -->
            <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-4 mb-10">

                <div>
                    <span
                        class="inline-flex items-center gap-2 text-brand-blue text-sm font-semibold mb-3 uppercase tracking-wider">

                        <span class="w-8 h-[2px] bg-brand-blue"></span>
                        Portfolio
                    </span>

                    <h2 class="text-3xl sm:text-4xl font-display font-bold text-brand-dark">
                        Selected Projects
                    </h2>
                </div>

                <p class="max-w-md text-sm text-slate-500 leading-relaxed">
                    Koleksi project modern yang dirancang dengan fokus pada performa,
                    pengalaman pengguna, dan estetika premium.
                </p>
            </div>

            <!-- DIUBAH -->
            <!-- sebelumnya gap-8 -->
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">

                <!-- LEFT -->
                <div class="lg:col-span-3">

                    <!-- DIUBAH -->
                    <!-- sebelumnya gap-6 -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                        @forelse($portfolios as $portfolio)
                            <!-- DIUBAH -->
                            <!-- rounded diperkecil -->
                            <div
                                class="group bg-white border border-slate-200/80 rounded-xl overflow-hidden shadow-sm hover:shadow-card transition-all duration-500 hover:-translate-y-2">

                                <!-- IMAGE -->
                                <!-- sebelumnya h-60 -->
                                <div class="relative overflow-hidden h-52">

                                    <a href="{{ route('portfolio.read', $portfolio->slug) }}">

                                        <img src="{{ asset('storage/' . $portfolio->thumbnail_image) }}"
                                            alt="{{ $portfolio->title }}"
                                            class="w-full h-full object-cover transition duration-700 group-hover:scale-110">

                                        <!-- Overlay -->
                                        <div
                                            class="absolute inset-0 bg-gradient-to-t from-brand-dark/90 via-brand-dark/20 to-transparent">
                                        </div>

                                        @php
                                            $techs = is_array($portfolio->technologies)
                                                ? $portfolio->technologies
                                                : explode(',', $portfolio->technologies);

                                            $firstTech = !empty($techs) ? trim($techs[0]) : '';
                                        @endphp

                                        @if ($firstTech)
                                            <div class="absolute top-4 left-4">
                                                <span
                                                    class="px-3 py-1 rounded-full bg-white/10 backdrop-blur-md border border-white/10 text-white text-[10px] uppercase tracking-wider font-semibold">
                                                    {{ $firstTech }}
                                                </span>
                                            </div>
                                        @endif

                                        <div class="absolute bottom-0 left-0 right-0 p-4">
                                            <h3
                                                class="text-lg font-bold text-white font-display mb-2 group-hover:text-brand-accent transition">
                                                {{ $portfolio->title }}
                                            </h3>

                                            <p class="text-sm text-white/70 leading-relaxed line-clamp-2">
                                                {{ \Illuminate\Support\Str::limit($portfolio->short_description, 100) }}
                                            </p>

                                        </div>
                                    </a>
                                </div>

                                <div class="px-4 py-3 flex items-center justify-between">

                                    <span class="text-xs text-slate-400">
                                        Digital Project
                                    </span>

                                    <a href="{{ route('portfolio.read', $portfolio->slug) }}"
                                        class="inline-flex items-center gap-2 text-sm font-semibold text-brand-blue hover:gap-3 transition-all">

                                        View Details
                                        <i class="fas fa-arrow-right text-xs"></i>
                                    </a>
                                </div>
                            </div>

                        @empty

                            <div class="col-span-2 text-center py-20">

                                <div
                                    class="w-20 h-20 rounded-full bg-slate-100 flex items-center justify-center mx-auto mb-5">
                                    <i class="fas fa-folder-open text-3xl text-slate-400"></i>
                                </div>

                                <h3 class="text-2xl font-display font-bold text-slate-700 mb-2">
                                    No Projects Yet
                                </h3>

                                <p class="text-slate-500 text-sm">
                                    Upcoming portfolio projects will appear here.
                                </p>
                            </div>
                        @endforelse

                    </div>

                    <!-- Pagination -->
                    @if ($portfolios->hasPages())
                        <div class="mt-12">
                            {{ $portfolios->links() }}
                        </div>
                    @endif

                </div>

                <!-- SIDEBAR -->
                <div class="lg:col-span-1">

                    <div class="sticky top-24 space-y-5">

                        <!-- Popular -->
                        <div class="bg-white border border-slate-200 rounded-xl p-5 shadow-sm">

                            <div class="flex items-center gap-3 mb-5">

                                <div
                                    class="w-10 h-10 rounded-2xl bg-brand-dark flex items-center justify-center shadow-glow-sm">
                                    <i class="fas fa-fire text-white text-sm"></i>
                                </div>

                                <div>
                                    <h3 class="text-lg font-display font-bold text-brand-dark">
                                        Popular Projects
                                    </h3>

                                    <p class="text-xs text-slate-400">
                                        Most viewed portfolio
                                    </p>
                                </div>
                            </div>

                            @if ($popularPortfolios->isNotEmpty())

                                <div class="space-y-3">

                                    @foreach ($popularPortfolios as $popular)
                                        <a href="{{ route('portfolio.read', $popular->slug) }}"
                                            class="group flex gap-3 p-3 rounded-2xl border border-slate-100 hover:border-brand-accent/20 hover:bg-slate-50 transition-all duration-300">

                                            <div class="w-16 h-16 rounded-xl overflow-hidden flex-shrink-0">

                                                <img src="{{ asset('storage/' . $popular->thumbnail_image) }}"
                                                    alt="{{ $popular->title }}"
                                                    class="w-full h-full object-cover transition duration-500 group-hover:scale-110">

                                            </div>

                                            <div class="flex-1 min-w-0">

                                                <h4
                                                    class="text-sm font-semibold text-slate-800 line-clamp-2 group-hover:text-brand-blue transition">
                                                    {{ $popular->title }}
                                                </h4>

                                                <div class="flex items-center gap-1 mt-2 text-xs text-slate-500">

                                                    <i class="fas fa-eye text-brand-blue"></i>

                                                    <span>
                                                        {{ $popular->view_count }} views
                                                    </span>
                                                </div>
                                            </div>
                                        </a>
                                    @endforeach

                                </div>
                            @else
                                <div class="text-center py-8">

                                    <i class="fas fa-chart-line text-4xl text-slate-300 mb-3"></i>

                                    <p class="text-sm text-slate-500">
                                        No popular projects yet
                                    </p>
                                </div>

                            @endif
                        </div>

                        <!-- Stats -->
                        <div
                            class="bg-gradient-to-br from-brand-dark to-brand-navy rounded-xl p-6 text-white shadow-card overflow-hidden relative">

                            <div class="absolute top-0 right-0 w-32 h-32 bg-brand-accent/10 rounded-full blur-3xl">
                            </div>

                            <div class="relative z-10">

                                <h3 class="text-lg font-display font-bold mb-5">
                                    Quick Stats
                                </h3>

                                <div class="space-y-4">

                                    <div class="flex items-center justify-between">
                                        <span class="text-sm text-white/60">
                                            Total Projects
                                        </span>

                                        <span class="text-2xl font-bold">
                                            {{ $portfolios->total() }}
                                        </span>
                                    </div>

                                    <div class="flex items-center justify-between">
                                        <span class="text-sm text-white/60">
                                            This Page
                                        </span>

                                        <span class="text-2xl font-bold text-brand-accent">
                                            {{ $portfolios->count() }}
                                        </span>
                                    </div>

                                    @if ($portfolios->total() > 0)
                                        <div class="pt-4 border-t border-white/10">

                                            <div class="flex items-center gap-2 text-xs text-white/50">

                                                <i class="fas fa-info-circle text-brand-accent"></i>

                                                <span>
                                                    Showing
                                                    {{ $portfolios->firstItem() }}
                                                    -
                                                    {{ $portfolios->lastItem() }}
                                                </span>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- CTA -->
                        <div class="relative overflow-hidden rounded-xl bg-white border border-slate-200 p-6 shadow-sm">

                            <div class="absolute -top-10 -right-10 w-32 h-32 bg-brand-blue/10 rounded-full blur-3xl">
                            </div>

                            <div class="relative z-10">

                                <div class="w-12 h-12 rounded-2xl bg-brand-dark flex items-center justify-center mb-4">

                                    <i class="fas fa-briefcase text-white"></i>
                                </div>

                                <h3 class="text-xl font-display font-bold text-brand-dark mb-2">
                                    Have a Project?
                                </h3>

                                <p class="text-sm text-slate-500 leading-relaxed mb-5">
                                    Mari bangun sistem digital modern untuk bisnis Anda bersama tim kami.
                                </p>

                                <a href="#contact"
                                    class="inline-flex items-center gap-2 px-5 py-3 rounded-full bg-brand-dark text-white text-sm font-semibold hover:bg-brand-blue transition-all duration-300">

                                    Get Started
                                </a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
