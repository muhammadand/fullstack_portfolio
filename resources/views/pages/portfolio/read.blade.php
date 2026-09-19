@extends('layouts.app')

@section('meta_tags')
<title>{{ $portfolio->title }} — Portofolio & Studi Kasus Scalify Intelligence</title>
<meta name="title" content="{{ $portfolio->title }} — Portofolio & Studi Kasus Scalify Intelligence" />
<meta name="description" content="{{ $portfolio->short_description ?? Str::limit(strip_tags($portfolio->full_description), 150) }}" />

@if($portfolio->technologies)
@php
$techs = is_array($portfolio->technologies) ? implode(', ', $portfolio->technologies) : $portfolio->technologies;
@endphp
<meta name="keywords" content="{{ $techs }}, portofolio website, jasa website laravel, web app saas, automasi ai, scalify intelligence" />
@endif

<meta name="author" content="Scalify Intelligence" />
<meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1" />
<link rel="canonical" href="{{ url()->current() }}" />

{{-- Open Graph / Facebook --}}
<meta property="og:type" content="article" />
<meta property="og:url" content="{{ url()->current() }}" />
<meta property="og:title" content="{{ $portfolio->title }} — Portofolio Scalify Intelligence" />
<meta property="og:description" content="{{ $portfolio->short_description ?? Str::limit(strip_tags($portfolio->full_description), 150) }}" />
<meta property="og:image" content="{{ $portfolio->featured_image ? asset('storage/' . $portfolio->featured_image) : ($portfolio->thumbnail_image ? asset('storage/' . $portfolio->thumbnail_image) : asset('og-image.png')) }}" />
<meta property="og:site_name" content="Scalify Intelligence" />
<meta property="og:locale" content="id_ID" />

{{-- Twitter --}}
<meta name="twitter:card" content="summary_large_image" />
<meta name="twitter:url" content="{{ url()->current() }}" />
<meta name="twitter:title" content="{{ $portfolio->title }}" />
<meta name="twitter:description" content="{{ $portfolio->short_description ?? Str::limit(strip_tags($portfolio->full_description), 150) }}" />
<meta name="twitter:image" content="{{ $portfolio->featured_image ? asset('storage/' . $portfolio->featured_image) : ($portfolio->thumbnail_image ? asset('storage/' . $portfolio->thumbnail_image) : asset('og-image.png')) }}" />

{{-- Schema.org JSON-LD Structured Data for CreativeWork / Case Study --}}
@php
$schema = [
'@context' => 'https://schema.org',
'@type' => 'CreativeWork',
'headline' => $portfolio->title,
'name' => $portfolio->title,
'description' => $portfolio->short_description ?? Str::limit(strip_tags($portfolio->full_description), 150),
'image' => $portfolio->featured_image ? asset('storage/' . $portfolio->featured_image) : ($portfolio->thumbnail_image ? asset('storage/' . $portfolio->thumbnail_image) : asset('og-image.png')),
'datePublished' => $portfolio->created_at ? $portfolio->created_at->toIso8601String() : null,
'dateModified' => $portfolio->updated_at ? $portfolio->updated_at->toIso8601String() : null,
'author' => [
'@type' => 'Organization',
'name' => 'Scalify Intelligence',
'url' => 'https://scalifyintellegence.my.id',
],
'publisher' => [
'@type' => 'Organization',
'name' => 'Scalify Intelligence',
'logo' => [
'@type' => 'ImageObject',
'url' => asset('scalify.png'),
],
],
'mainEntityOfPage' => [
'@type' => 'WebPage',
'@id' => url()->current(),
],
];
@endphp
<script type="application/ld+json">
    {
        !!json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) !!
    }

</script>
@endsection

@section('content')
<div class="min-h-screen bg-brand-dark text-white relative overflow-hidden selection:bg-cyan-500/30 selection:text-cyan-200">

    {{-- Ambient Midnight Glow & Lattice Dot Background Grid --}}
    <div class="absolute inset-0 bg-hero-gradient pointer-events-none"></div>
    <div class="absolute top-0 right-0 w-[600px] h-[600px] bg-brand-blue/15 rounded-full blur-[150px] pointer-events-none"></div>
    <div class="absolute top-96 left-0 w-[500px] h-[500px] bg-brand-indigo/15 rounded-full blur-[140px] pointer-events-none"></div>
    <div class="absolute inset-0 opacity-[0.035] pointer-events-none" style="background-image: radial-gradient(#ffffff 1px, transparent 1px); background-size: 28px 28px;"></div>

    {{-- ══════════════════════════════════════════════════
         HERO SECTION: CASE STUDY HEADER & SHOWCASE
    ══════════════════════════════════════════════════ --}}
    <section class="relative pt-10 pb-12 sm:pt-16 sm:pb-16 px-4 sm:px-6 lg:px-8 border-b border-white/5 overflow-hidden">

        {{-- Subtle Ambient Glow Behind Header --}}
        <div class="absolute top-1/3 left-1/2 -translate-x-1/2 -translate-y-1/2 w-3/4 h-64 bg-cyan-500/10 rounded-full blur-3xl pointer-events-none"></div>

        <div class="max-w-6xl mx-auto relative z-10">

            {{-- Navigation Bar: Breadcrumb + Status Pill --}}
            <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
                <nav aria-label="Breadcrumb" class="flex items-center gap-2 text-xs text-white/50 flex-wrap">
                    <a href="{{ route('index.company.profile') }}" class="hover:text-cyan-300 transition-colors flex items-center gap-1.5">
                        <i class="fa-solid fa-house text-[10px]"></i>
                        <span>Home</span>
                    </a>
                    <span class="text-white/20">/</span>
                    <a href="{{ route('landing.portfolio') }}" class="hover:text-cyan-300 transition-colors">Portofolio</a>
                    <span class="text-white/20">/</span>
                    <span class="text-white/90 font-medium truncate max-w-xs sm:max-w-md">{{ $portfolio->title }}</span>
                </nav>

                {{-- Status Pill --}}
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-500/10 border border-emerald-500/25 text-emerald-400 text-[11px] font-semibold tracking-wide">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                    <span>Live Production Ready</span>
                </div>
            </div>

            {{-- Category & Tech Badges Row --}}
            @php
            $techList = is_array($portfolio->technologies)
            ? $portfolio->technologies
            : (is_string($portfolio->technologies) ? explode(',', $portfolio->technologies) : []);
            @endphp
            <div class="flex items-center gap-2 mb-4 flex-wrap">
                @if ($portfolio->category)
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-cyan-500/15 border border-cyan-500/30 text-cyan-300 text-[11px] font-bold tracking-wider uppercase shadow-sm">
                    <i class="fa-solid fa-layer-group text-[10px]"></i>
                    {{ $portfolio->category->name }}
                </span>
                @endif
                @foreach (array_slice($techList, 0, 5) as $tech)
                <span class="px-3 py-1 rounded-full bg-white/5 border border-white/10 text-white/80 text-[11px] font-medium backdrop-blur-md">
                    {{ trim($tech) }}
                </span>
                @endforeach
            </div>

            {{-- Main Title --}}
            <h1 class="font-sans font-black text-3xl sm:text-4xl lg:text-[44px] text-white leading-[1.18] tracking-[-0.03em] max-w-4xl mb-4">
                {{ $portfolio->title }}
            </h1>

            {{-- Short Description / Lead Summary --}}
            @if ($portfolio->short_description)
            <p class="text-white/70 text-sm sm:text-base md:text-[17px] leading-relaxed max-w-3xl font-normal mb-8">
                {{ $portfolio->short_description }}
            </p>
            @endif

            {{-- 4-Column Bento Metadata Stats Grid --}}
            <div class="grid grid-cols-2 md:grid-cols-4 gap-3 sm:gap-4 mb-8">
                {{-- Item 1: Client --}}
                <div class="bg-white/[0.04] backdrop-blur-md border border-white/10 rounded-2xl p-4 flex items-center gap-3.5 hover:border-cyan-500/30 transition-colors">
                    <div class="w-10 h-10 rounded-xl bg-cyan-500/15 border border-cyan-500/25 flex items-center justify-center shrink-0 text-cyan-400">
                        <i class="fa-solid fa-building text-sm"></i>
                    </div>
                    <div class="min-w-0">
                        <div class="text-[10px] text-white/45 uppercase font-bold tracking-wider">Klien / Partner</div>
                        <div class="text-xs sm:text-[13px] font-bold text-white truncate mt-0.5">
                            {{ $portfolio->client_name ?: 'Scalify Enterprise' }}
                        </div>
                    </div>
                </div>

                {{-- Item 2: Category / Scope --}}
                <div class="bg-white/[0.04] backdrop-blur-md border border-white/10 rounded-2xl p-4 flex items-center gap-3.5 hover:border-cyan-500/30 transition-colors">
                    <div class="w-10 h-10 rounded-xl bg-blue-500/15 border border-blue-500/25 flex items-center justify-center shrink-0 text-blue-400">
                        <i class="fa-solid fa-cubes text-sm"></i>
                    </div>
                    <div class="min-w-0">
                        <div class="text-[10px] text-white/45 uppercase font-bold tracking-wider">Tipe Sistem</div>
                        <div class="text-xs sm:text-[13px] font-bold text-white truncate mt-0.5">
                            {{ $portfolio->project_type ?: ($portfolio->category->name ?? 'Digital Solution') }}
                        </div>
                    </div>
                </div>

                {{-- Item 3: Timeline / Year --}}
                <div class="bg-white/[0.04] backdrop-blur-md border border-white/10 rounded-2xl p-4 flex items-center gap-3.5 hover:border-cyan-500/30 transition-colors">
                    <div class="w-10 h-10 rounded-xl bg-indigo-500/15 border border-indigo-500/25 flex items-center justify-center shrink-0 text-indigo-400">
                        <i class="fa-solid fa-calendar-check text-sm"></i>
                    </div>
                    <div class="min-w-0">
                        <div class="text-[10px] text-white/45 uppercase font-bold tracking-wider">Waktu Selesai</div>
                        <div class="text-xs sm:text-[13px] font-bold text-white truncate mt-0.5">
                            {{ $portfolio->completion_date ? \Carbon\Carbon::parse($portfolio->completion_date)->format('F Y') : 'Q3 2026' }}
                        </div>
                    </div>
                </div>

                {{-- Item 4: Views & Engagement --}}
                <div class="bg-white/[0.04] backdrop-blur-md border border-white/10 rounded-2xl p-4 flex items-center gap-3.5 hover:border-cyan-500/30 transition-colors">
                    <div class="w-10 h-10 rounded-xl bg-amber-500/15 border border-amber-500/25 flex items-center justify-center shrink-0 text-amber-400">
                        <i class="fa-solid fa-eye text-sm"></i>
                    </div>
                    <div class="min-w-0">
                        <div class="text-[10px] text-white/45 uppercase font-bold tracking-wider">Total Views</div>
                        <div class="text-xs sm:text-[13px] font-bold text-white truncate mt-0.5">
                            {{ number_format($portfolio->view_count ?: 1200) }} pembaca
                        </div>
                    </div>
                </div>
            </div>

            {{-- Action Buttons Bar --}}
            <div class="flex flex-wrap items-center gap-3.5 pt-2">
                @if ($portfolio->project_url)
                <a href="{{ $portfolio->project_url }}" target="_blank" rel="noopener" class="inline-flex items-center gap-2.5 bg-btn-gradient text-white text-xs sm:text-sm font-bold px-6 sm:px-7 py-3.5 rounded-full shadow-glow-blue hover:scale-105 transition-all">
                    <i class="fa-solid fa-arrow-up-right-from-square text-xs"></i>
                    <span>Buka Demo / Website Live</span>
                    <span class="w-5 h-5 bg-white/20 rounded-full flex items-center justify-center text-[10px]">→</span>
                </a>
                @endif

                @if ($portfolio->github_url)
                <a href="{{ $portfolio->github_url }}" target="_blank" rel="noopener" class="inline-flex items-center gap-2 bg-white/5 hover:bg-white/10 border border-white/15 text-white text-xs sm:text-sm font-semibold px-5 py-3.5 rounded-full transition-all">
                    <i class="fa-brands fa-github text-base"></i>
                    <span>Source Code GitHub</span>
                </a>
                @endif

                <a href="https://wa.me/6285221694067?text={{ urlencode('Halo Scalify, saya tertarik dengan implementasi sistem portofolio: ' . $portfolio->title) }}" target="_blank" class="inline-flex items-center gap-2 bg-emerald-500/15 hover:bg-emerald-500/25 border border-emerald-500/35 text-emerald-300 hover:text-emerald-200 text-xs sm:text-sm font-semibold px-5 sm:px-6 py-3.5 rounded-full transition-all">
                    <i class="fa-brands fa-whatsapp text-sm text-emerald-400"></i>
                    <span>Konsultasi Proyek Serupa</span>
                </a>
            </div>

            {{-- ══════════════════════════════════════════════════
                 BROWSER / DEVICE MOCKUP SHOWCASE FRAME
            ══════════════════════════════════════════════════ --}}
            @php
            $displayImage = $portfolio->featured_image ?: $portfolio->thumbnail_image;
            @endphp
            @if ($displayImage)
            <div class="mt-12 sm:mt-14 relative group">
                {{-- Glow Behind Mockup Frame --}}
                <div class="absolute -inset-1 bg-gradient-to-r from-blue-600/30 via-cyan-500/30 to-indigo-600/30 rounded-3xl blur-2xl opacity-50 group-hover:opacity-80 transition duration-700 pointer-events-none"></div>

                {{-- Browser Window Wrapper --}}
                <div class="relative bg-brand-navy/90 backdrop-blur-2xl border border-white/15 rounded-2xl sm:rounded-3xl overflow-hidden shadow-2xl">

                    {{-- Chrome Browser Window Header --}}
                    <div class="px-4 py-3 bg-[#080d28]/90 border-b border-white/10 flex items-center justify-between gap-3 select-none">
                        {{-- Dot Controls --}}
                        <div class="flex items-center gap-2">
                            <span class="w-3 h-3 rounded-full bg-[#EF4444]/80 inline-block"></span>
                            <span class="w-3 h-3 rounded-full bg-[#F59E0B]/80 inline-block"></span>
                            <span class="w-3 h-3 rounded-full bg-[#10B981]/80 inline-block"></span>
                        </div>

                        {{-- URL Pill Bar --}}
                        <div class="flex-1 max-w-md mx-auto hidden sm:flex items-center justify-center gap-2 px-4 py-1 rounded-lg bg-white/5 border border-white/10 text-[11px] text-white/60 font-mono">
                            <i class="fa-solid fa-lock text-[9px] text-emerald-400"></i>
                            <span class="truncate">https://scalifyintellegence.my.id/project/{{ $portfolio->slug }}</span>
                        </div>

                        {{-- Window Action Icons --}}
                        <div class="flex items-center gap-2.5 text-white/40 text-xs">
                            <i class="fa-solid fa-expand hidden sm:inline"></i>
                            <i class="fa-solid fa-ellipsis-vertical"></i>
                        </div>
                    </div>

                    {{-- Mockup Image Container --}}
                    <div class="relative overflow-hidden aspect-[16/10] sm:aspect-[16/9] bg-[#060a1f]">
                        <img src="{{ asset('storage/' . $displayImage) }}" alt="{{ $portfolio->title }}" class="w-full h-full object-cover object-top" fetchpriority="high" decoding="async">

                        {{-- Subtle inner shadow & gradient overlay --}}
                        <div class="absolute inset-0 bg-gradient-to-t from-brand-dark/40 via-transparent to-transparent pointer-events-none"></div>
                    </div>

                </div>
            </div>
            @endif

        </div>
    </section>

    {{-- ══════════════════════════════════════════════════
         MAIN CONTENT & ARTICLE BODY
    ══════════════════════════════════════════════════ --}}
    <main class="py-12 sm:py-16 px-4 sm:px-6 lg:px-8 max-w-6xl mx-auto relative z-10">

        {{-- 3 KEY BENTO METRIC CARDS (Challenge, Solution, Result) --}}
        @if ($portfolio->challenge || $portfolio->solution || $portfolio->result)
        <div class="mb-14">
            <div class="mb-6">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-cyan-500/10 border border-cyan-500/20 text-cyan-400 font-bold text-[10px] tracking-[0.15em] uppercase">
                    <span class="w-1.5 h-1.5 rounded-full bg-cyan-400"></span>
                    <span>RINGKASAN EKSEKUTIF</span>
                </div>
                <h2 class="font-sans font-bold text-2xl sm:text-3xl text-white tracking-tight mt-2">
                    Tiga Pilar Implementasi Sistem
                </h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-5 sm:gap-6">
                {{-- 1. Tantangan --}}
                @if ($portfolio->challenge)
                <div class="bg-gradient-to-b from-rose-950/20 to-brand-navy/60 backdrop-blur-xl border border-rose-500/20 hover:border-rose-500/40 rounded-2xl p-6 sm:p-7 shadow-card transition-all duration-300 flex flex-col justify-between group">
                    <div>
                        <div class="flex items-center justify-between gap-3 mb-4">
                            <div class="w-10 h-10 rounded-xl bg-rose-500/15 border border-rose-500/30 flex items-center justify-center shrink-0 text-rose-400 shadow-sm">
                                <i class="fa-solid fa-triangle-exclamation text-sm"></i>
                            </div>
                            <span class="text-rose-400/60 font-mono font-bold text-xs">#01 / PROBLEM</span>
                        </div>
                        <h3 class="font-sans font-bold text-base sm:text-lg text-white mb-3 group-hover:text-rose-300 transition-colors">
                            Tantangan (Challenge)
                        </h3>
                        <p class="text-white/70 text-xs sm:text-[13px] leading-relaxed whitespace-pre-line font-normal">
                            {{ $portfolio->challenge }}
                        </p>
                    </div>
                </div>
                @endif

                {{-- 2. Solusi --}}
                @if ($portfolio->solution)
                <div class="bg-gradient-to-b from-cyan-950/20 to-brand-navy/60 backdrop-blur-xl border border-cyan-500/25 hover:border-cyan-500/50 rounded-2xl p-6 sm:p-7 shadow-card transition-all duration-300 flex flex-col justify-between group">
                    <div>
                        <div class="flex items-center justify-between gap-3 mb-4">
                            <div class="w-10 h-10 rounded-xl bg-cyan-500/15 border border-cyan-500/30 flex items-center justify-center shrink-0 text-cyan-400 shadow-sm">
                                <i class="fa-solid fa-microchip text-sm"></i>
                            </div>
                            <span class="text-cyan-400/60 font-mono font-bold text-xs">#02 / ARCHITECTURE</span>
                        </div>
                        <h3 class="font-sans font-bold text-base sm:text-lg text-white mb-3 group-hover:text-cyan-300 transition-colors">
                            Solusi & Rekayasa Sistem
                        </h3>
                        <p class="text-white/70 text-xs sm:text-[13px] leading-relaxed whitespace-pre-line font-normal">
                            {{ $portfolio->solution }}
                        </p>
                    </div>
                </div>
                @endif

                {{-- 3. Hasil --}}
                @if ($portfolio->result)
                <div class="bg-gradient-to-b from-emerald-950/20 to-brand-navy/60 backdrop-blur-xl border border-emerald-500/25 hover:border-emerald-500/50 rounded-2xl p-6 sm:p-7 shadow-card transition-all duration-300 flex flex-col justify-between group">
                    <div>
                        <div class="flex items-center justify-between gap-3 mb-4">
                            <div class="w-10 h-10 rounded-xl bg-emerald-500/15 border border-emerald-500/30 flex items-center justify-center shrink-0 text-emerald-400 shadow-sm">
                                <i class="fa-solid fa-chart-line text-sm"></i>
                            </div>
                            <span class="text-emerald-400/60 font-mono font-bold text-xs">#03 / IMPACT</span>
                        </div>
                        <h3 class="font-sans font-bold text-base sm:text-lg text-white mb-3 group-hover:text-emerald-300 transition-colors">
                            Hasil & Dampak Bisnis
                        </h3>
                        <p class="text-white/70 text-xs sm:text-[13px] leading-relaxed whitespace-pre-line font-normal">
                            {{ $portfolio->result }}
                        </p>
                    </div>
                </div>
                @endif
            </div>
        </div>
        @endif

        {{-- ══════════════════════════════════════════════════
             WYSIWYG FULL DESCRIPTION ARTICLE CONTAINER
        ══════════════════════════════════════════════════ --}}
        <div class="relative mb-16">
            {{-- Top Glow Accent Line --}}
            <div class="w-full h-[1px] bg-gradient-to-r from-transparent via-cyan-500/40 to-transparent"></div>

            <article class="bg-brand-navy/70 backdrop-blur-2xl border border-white/10 rounded-2xl sm:rounded-3xl p-6 sm:p-12 shadow-card mt-6">

                {{-- Article Section Label --}}
                <div class="flex items-center gap-2 pb-5 mb-8 border-b border-white/10 text-xs font-semibold text-white/50">
                    <i class="fa-solid fa-book-open-reader text-cyan-400"></i>
                    <span>DOKUMENTASI DETAIL & BEDAH ARSITEKTUR</span>
                </div>

                {{-- The Rich Quill Content --}}
                <div class="quill-content-dark">
                    {!! $portfolio->full_description !!}
                </div>

                {{-- Article Footer Share / Tag Actions --}}
                <div class="mt-12 pt-6 border-t border-white/10 flex flex-wrap items-center justify-between gap-4 text-xs">
                    <div class="flex items-center gap-2 text-white/50">
                        <span>Bagikan studi kasus:</span>
                        <a href="https://wa.me/?text={{ urlencode('Lihat studi kasus ' . $portfolio->title . ' di Scalify Intelligence: ' . url()->current()) }}" target="_blank" class="w-7 h-7 rounded-full bg-white/5 hover:bg-emerald-500/20 text-white hover:text-emerald-400 flex items-center justify-center transition-colors">
                            <i class="fa-brands fa-whatsapp"></i>
                        </a>
                        <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(url()->current()) }}" target="_blank" class="w-7 h-7 rounded-full bg-white/5 hover:bg-blue-500/20 text-white hover:text-blue-400 flex items-center justify-center transition-colors">
                            <i class="fa-brands fa-linkedin-in"></i>
                        </a>
                    </div>

                    <a href="{{ route('landing.portfolio') }}" class="text-cyan-400 hover:text-cyan-300 font-semibold inline-flex items-center gap-1.5 transition-colors">
                        <i class="fa-solid fa-arrow-left text-[11px]"></i>
                        <span>Kembali ke Semua Portofolio</span>
                    </a>
                </div>

            </article>
        </div>

        {{-- ══════════════════════════════════════════════════
             EXPLORE MORE PROJECTS (POPULAR PORTFOLIO)
        ══════════════════════════════════════════════════ --}}
        @if ($popularPortfolios && count($popularPortfolios) > 0)
        <div class="pt-10 border-t border-white/10 mb-14">
            <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 mb-8">
                <div>
                    <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-cyan-500/15 border border-cyan-500/25 text-cyan-300 text-[10px] font-bold tracking-[0.15em] uppercase mb-2">
                        <span class="w-1.5 h-1.5 rounded-full bg-cyan-400 animate-pulse"></span>
                        STUDI KASUS LAINNYA
                    </div>
                    <h2 class="font-sans font-bold text-2xl sm:text-3xl text-white tracking-tight">
                        Jelajahi Proyek Populer Lainnya
                    </h2>
                </div>
                <a href="{{ route('landing.portfolio') }}" class="text-xs font-bold text-cyan-400 hover:text-white transition-colors inline-flex items-center gap-1.5">
                    <span>Lihat Semua Portofolio</span>
                    <i class="fa-solid fa-arrow-right text-[10px]"></i>
                </a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5 sm:gap-6">
                @foreach ($popularPortfolios->take(3) as $popular)
                <a href="{{ route('portfolio.read', $popular->slug) }}" class="bg-brand-navy/60 backdrop-blur-xl border border-white/10 hover:border-cyan-400/40 rounded-2xl overflow-hidden shadow-card hover:-translate-y-1.5 transition-all duration-300 flex flex-col group">
                    <div class="relative overflow-hidden aspect-[16/10] bg-white/5">
                        @if ($popular->thumbnail_image)
                        <img src="{{ asset('storage/' . $popular->thumbnail_image) }}" alt="{{ $popular->title }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105" loading="lazy" decoding="async">
                        @else
                        <div class="w-full h-full flex items-center justify-center text-white/30">
                            <i class="fa-solid fa-laptop-code text-3xl"></i>
                        </div>
                        @endif
                        <div class="absolute inset-0 bg-gradient-to-t from-brand-dark/80 via-transparent to-transparent opacity-60 group-hover:opacity-20 transition-opacity"></div>
                        @if ($popular->category)
                        <div class="absolute top-3 left-3">
                            <span class="px-2.5 py-1 rounded bg-brand-dark/85 backdrop-blur-md border border-white/15 text-white/90 text-[10px] font-bold uppercase">
                                {{ $popular->category->name }}
                            </span>
                        </div>
                        @endif
                    </div>
                    <div class="p-5 flex-1 flex flex-col justify-between">
                        <h3 class="font-sans font-bold text-base text-white group-hover:text-cyan-300 transition-colors line-clamp-2 mb-2">
                            {{ $popular->title }}
                        </h3>
                        <div class="flex items-center justify-between text-xs text-white/50 pt-3 border-t border-white/5">
                            <span class="text-cyan-400 font-semibold flex items-center gap-1">
                                <span>Lihat Studi Kasus</span>
                                <i class="fa-solid fa-arrow-right text-[10px] group-hover:translate-x-1 transition-transform"></i>
                            </span>
                            @if ($popular->view_count)
                            <span class="flex items-center gap-1">
                                <i class="fa-solid fa-eye text-[10px] text-cyan-400/80"></i> {{ number_format($popular->view_count) }}
                            </span>
                            @endif
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
        @endif

        {{-- ══════════════════════════════════════════════════
             HIGH-CONVERSION BOTTOM CONSULTATION CTA BANNER
        ══════════════════════════════════════════════════ --}}
        <div class="bg-gradient-to-br from-blue-900/40 via-indigo-900/30 to-brand-navy border border-cyan-500/30 rounded-2xl sm:rounded-3xl p-8 sm:p-12 text-center shadow-glow-sm relative overflow-hidden">
            <div class="absolute -right-10 -bottom-10 w-56 h-56 bg-cyan-400/10 rounded-full blur-3xl pointer-events-none"></div>
            <div class="absolute -left-10 -top-10 w-56 h-56 bg-blue-500/10 rounded-full blur-3xl pointer-events-none"></div>

            <div class="relative z-10 max-w-xl mx-auto">
                <div class="w-12 h-12 rounded-2xl bg-btn-gradient flex items-center justify-center mx-auto mb-4 shadow-glow-blue text-white">
                    <i class="fa-solid fa-wand-magic-sparkles text-lg text-cyan-300"></i>
                </div>
                <h3 class="font-sans font-black text-2xl sm:text-3xl text-white mb-3">
                    Siap Mewujudkan Sistem Serupa?
                </h3>
                <p class="text-white/70 text-xs sm:text-sm leading-relaxed mb-8 font-normal">
                    Konsultasikan kebutuhan website company profile, SaaS kustom, atau implementasi sistem AI & Data Science bisnis Anda langsung bersama lead system architect kami.
                </p>
                <div class="flex flex-wrap items-center justify-center gap-3.5">
                    <a href="https://wa.me/6285221694067?text={{ urlencode('Halo Scalify, saya ingin konsultasi pembuatan sistem seperti di portofolio: ' . $portfolio->title) }}" target="_blank" class="inline-flex items-center gap-2.5 bg-btn-gradient text-white text-xs sm:text-sm font-bold px-7 py-3.5 rounded-full shadow-glow-blue hover:scale-105 transition-all">
                        <i class="fa-brands fa-whatsapp text-base text-emerald-300"></i>
                        <span>Konsultasi WhatsApp Sekarang</span>
                        <span class="w-5 h-5 bg-white/20 rounded-full flex items-center justify-center text-[10px]">→</span>
                    </a>
                    <a href="{{ route('landing.portfolio') }}" class="inline-flex items-center gap-2 bg-white/5 border border-white/15 hover:bg-white/10 text-white text-xs sm:text-sm font-semibold px-6 py-3.5 rounded-full transition-all">
                        <i class="fa-solid fa-arrow-left text-xs"></i>
                        <span>Kembali ke Portofolio</span>
                    </a>
                </div>
            </div>
        </div>

    </main>

</div>

{{-- ══════════════════════════════════════════════════
     STYLES FOR QUILL CONTENT IN DARK MIDNIGHT THEME
══════════════════════════════════════════════════ --}}
<style>
    .quill-content-dark {
        font-size: 15.5px;
        line-height: 1.85;
        color: rgba(255, 255, 255, 0.84);
    }

    .quill-content-dark h1 {
        font-size: 1.85rem;
        font-weight: 800;
        color: #ffffff;
        margin: 2rem 0 1rem;
        letter-spacing: -0.02em;
    }

    .quill-content-dark h2 {
        font-size: 1.5rem;
        font-weight: 800;
        color: #ffffff;
        margin: 1.85rem 0 1rem;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        padding-bottom: 0.6rem;
        letter-spacing: -0.02em;
    }

    .quill-content-dark h3 {
        font-size: 1.25rem;
        font-weight: 700;
        color: #60A5FA;
        margin: 1.5rem 0 0.65rem;
    }

    .quill-content-dark h4,
    .quill-content-dark h5,
    .quill-content-dark h6 {
        font-size: 1.05rem;
        font-weight: 700;
        color: #ffffff;
        margin: 1.25rem 0 0.5rem;
    }

    .quill-content-dark p {
        margin-bottom: 1.25rem;
    }

    .quill-content-dark p:last-child {
        margin-bottom: 0;
    }

    .quill-content-dark strong {
        font-weight: 700;
        color: #ffffff;
    }

    .quill-content-dark em {
        font-style: italic;
        color: rgba(255, 255, 255, 0.9);
    }

    .quill-content-dark a {
        color: #60A5FA;
        text-decoration: underline;
        text-underline-offset: 3px;
        transition: color 0.2s;
    }

    .quill-content-dark a:hover {
        color: #93C5FD;
    }

    .quill-content-dark img {
        max-width: 100%;
        height: auto;
        border-radius: 1rem;
        border: 1px solid rgba(255, 255, 255, 0.12);
        box-shadow: 0 12px 35px rgba(0, 0, 0, 0.45);
        margin: 1.75rem 0;
        display: block;
    }

    .quill-content-dark .ql-align-center img,
    .quill-content-dark .ql-align-center {
        text-align: center;
        margin-left: auto;
        margin-right: auto;
    }

    .quill-content-dark .ql-align-right img,
    .quill-content-dark .ql-align-right {
        text-align: right;
    }

    .quill-content-dark .ql-align-left img,
    .quill-content-dark .ql-align-left {
        text-align: left;
    }

    .quill-content-dark ul {
        list-style: disc;
        padding-left: 1.75rem;
        margin-bottom: 1.25rem;
    }

    .quill-content-dark ol {
        list-style: decimal;
        padding-left: 1.75rem;
        margin-bottom: 1.25rem;
    }

    .quill-content-dark li {
        margin-bottom: 0.45rem;
        color: rgba(255, 255, 255, 0.84);
    }

    .quill-content-dark blockquote {
        border-left: 4px solid #38BDF8;
        background: rgba(56, 189, 248, 0.05);
        color: rgba(255, 255, 255, 0.92);
        padding: 1.1rem 1.4rem;
        border-radius: 0 0.75rem 0.75rem 0;
        margin: 1.5rem 0;
        font-style: italic;
    }

    .quill-content-dark code {
        background: rgba(255, 255, 255, 0.08);
        color: #93C5FD;
        padding: 0.2rem 0.45rem;
        border-radius: 0.35rem;
        font-size: 0.88em;
        font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace;
    }

    .quill-content-dark pre.ql-syntax {
        background: #060a18;
        border: 1px solid rgba(255, 255, 255, 0.12);
        color: #E2E8F0;
        padding: 1.25rem 1.4rem;
        border-radius: 0.85rem;
        overflow-x: auto;
        font-size: 0.88em;
        line-height: 1.7;
        margin: 1.5rem 0;
    }

    .quill-content-dark table {
        width: 100%;
        border-collapse: collapse;
        margin: 1.5rem 0;
        border-radius: 0.75rem;
        overflow: hidden;
        border: 1px solid rgba(255, 255, 255, 0.1);
    }

    .quill-content-dark table th {
        background: rgba(255, 255, 255, 0.08);
        color: #ffffff;
        font-weight: 700;
        padding: 0.85rem 1rem;
        border: 1px solid rgba(255, 255, 255, 0.1);
        text-align: left;
    }

    .quill-content-dark table td {
        padding: 0.75rem 1rem;
        border: 1px solid rgba(255, 255, 255, 0.08);
        color: rgba(255, 255, 255, 0.82);
    }

    .quill-content-dark table tr:nth-child(even) td {
        background: rgba(255, 255, 255, 0.02);
    }

</style>
@endsection
