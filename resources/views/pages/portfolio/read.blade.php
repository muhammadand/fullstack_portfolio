@extends('layouts.app')

@section('meta_tags')
<title>{{ $portfolio->title }} — Portofolio Scalify Intelligence</title>
<meta name="title" content="{{ $portfolio->title }} — Portofolio Scalify Intelligence" />
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
<meta property="og:image" content="{{ $portfolio->thumbnail_image ? asset('storage/' . $portfolio->thumbnail_image) : asset('og-image.png') }}" />
<meta property="og:site_name" content="Scalify Intelligence" />
<meta property="og:locale" content="id_ID" />

{{-- Twitter --}}
<meta name="twitter:card" content="summary_large_image" />
<meta name="twitter:url" content="{{ url()->current() }}" />
<meta name="twitter:title" content="{{ $portfolio->title }}" />
<meta name="twitter:description" content="{{ $portfolio->short_description ?? Str::limit(strip_tags($portfolio->full_description), 150) }}" />
<meta name="twitter:image" content="{{ $portfolio->thumbnail_image ? asset('storage/' . $portfolio->thumbnail_image) : asset('og-image.png') }}" />

{{-- Schema.org JSON-LD Structured Data for CreativeWork / Article --}}
@php
$schema = [
'@context' => 'https://schema.org',
'@type' => 'CreativeWork',
'headline' => $portfolio->title,
'name' => $portfolio->title,
'description' => $portfolio->short_description ?? Str::limit(strip_tags($portfolio->full_description), 150),
'image' => $portfolio->thumbnail_image ? asset('storage/' . $portfolio->thumbnail_image) : asset('og-image.png'),
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
<div class="min-h-screen bg-brand-dark text-white relative overflow-hidden">

    {{-- Ambient Midnight Glow Background Effects --}}
    <div class="absolute top-0 left-1/2 -translate-x-1/2 w-full max-w-7xl h-[450px] bg-gradient-to-b from-brand-blue/15 via-brand-indigo/10 to-transparent blur-3xl pointer-events-none"></div>
    <div class="absolute top-32 right-5 w-96 h-96 bg-brand-accent/10 rounded-full blur-[120px] pointer-events-none"></div>

    {{-- ══════════════════════════════════════════════════
         HERO SECTION - MIDNIGHT BLUE WITH THUMBNAIL BACKDROP
    ══════════════════════════════════════════════════ --}}
    <section class="relative pt-12 pb-14 sm:pt-16 sm:pb-20 px-4 sm:px-6 lg:px-8 border-b border-white/5 overflow-hidden">

        {{-- Thumbnail Background Overlay --}}
        @if ($portfolio->thumbnail_image)
        <div class="absolute inset-0 z-0">
            <img src="{{ asset('storage/' . $portfolio->thumbnail_image) }}" alt="{{ $portfolio->title }}" class="w-full h-full object-cover object-center opacity-15 filter blur-sm scale-105">
            <div class="absolute inset-0 bg-gradient-to-t from-brand-dark via-brand-dark/85 to-brand-dark/70"></div>
        </div>
        @endif

        <div class="max-w-6xl mx-auto relative z-10">

            {{-- Breadcrumb & Back Button --}}
            <div class="flex items-center gap-2 text-xs text-white/50 mb-6 flex-wrap">
                <a href="{{ route('index.company.profile') }}" class="hover:text-brand-accent transition-colors">Home</a>
                <span>/</span>
                <a href="{{ route('landing.portfolio') }}" class="hover:text-brand-accent transition-colors">Portofolio</a>
                <span>/</span>
                <span class="text-white/80 font-medium truncate max-w-xs">{{ $portfolio->title }}</span>
            </div>

            {{-- Tech Badges Row --}}
            @php
            $techList = is_array($portfolio->technologies)
            ? $portfolio->technologies
            : (is_string($portfolio->technologies) ? explode(',', $portfolio->technologies) : []);
            @endphp
            @if (!empty($techList) || $portfolio->category)
            <div class="flex items-center gap-2 mb-4 flex-wrap">
                @if ($portfolio->category)
                <span class="px-3 py-1 rounded-full bg-brand-accent/15 border border-brand-accent/30 text-brand-accent text-[11px] font-bold tracking-wider uppercase shadow-sm">
                    {{ $portfolio->category->name }}
                </span>
                @endif
                @foreach ($techList as $tech)
                <span class="px-3 py-1 rounded-full bg-white/5 border border-white/10 text-white/80 text-[11px] font-medium backdrop-blur-sm">
                    {{ trim($tech) }}
                </span>
                @endforeach
            </div>
            @endif

            {{-- Main Title --}}
            <h1 class="font-sans font-black text-2xl sm:text-4xl lg:text-[42px] text-white leading-[1.18] tracking-[-0.03em] max-w-4xl mb-6">
                {{ $portfolio->title }}
            </h1>

            {{-- Metadata Info Bar --}}
            <div class="flex flex-wrap items-center gap-5 sm:gap-8 text-xs sm:text-sm text-white/70 pt-4 border-t border-white/10">
                @if ($portfolio->client_name)
                <div class="flex items-center gap-2">
                    <i class="fa-solid fa-building text-brand-accent"></i>
                    <span><strong class="text-white font-medium">Klien:</strong> {{ $portfolio->client_name }}</span>
                </div>
                @endif

                @if ($portfolio->project_type)
                <div class="flex items-center gap-2">
                    <i class="fa-solid fa-folder text-brand-accent"></i>
                    <span><strong class="text-white font-medium">Kategori:</strong> {{ $portfolio->project_type }}</span>
                </div>
                @endif

                @if ($portfolio->completion_date)
                <div class="flex items-center gap-2">
                    <i class="fa-solid fa-calendar-check text-brand-accent"></i>
                    <span><strong class="text-white font-medium">Selesai:</strong> {{ \Carbon\Carbon::parse($portfolio->completion_date)->format('d M Y') }}</span>
                </div>
                @endif

                @if ($portfolio->view_count)
                <div class="flex items-center gap-2 text-white/50">
                    <i class="fa-solid fa-eye text-brand-accent"></i>
                    <span>{{ number_format($portfolio->view_count) }} views</span>
                </div>
                @endif
            </div>

            {{-- Action Buttons (Demo, GitHub, WA) --}}
            <div class="flex flex-wrap items-center gap-3.5 mt-8">
                @if ($portfolio->project_url)
                <a href="{{ $portfolio->project_url }}" target="_blank" rel="noopener" class="inline-flex items-center gap-2.5 bg-btn-gradient text-white text-xs sm:text-sm font-bold px-6 py-3.5 rounded-full shadow-glow-blue hover:scale-105 transition-all">
                    <i class="fa-solid fa-arrow-up-right-from-square text-xs"></i>
                    <span>Buka Website / Demo Live</span>
                </a>
                @endif

                @if ($portfolio->github_url)
                <a href="{{ $portfolio->github_url }}" target="_blank" rel="noopener" class="inline-flex items-center gap-2 bg-white/5 hover:bg-white/10 border border-white/15 text-white text-xs sm:text-sm font-semibold px-5 py-3.5 rounded-full transition-all">
                    <i class="fa-brands fa-github text-base"></i>
                    <span>Source Code GitHub</span>
                </a>
                @endif

                <a href="https://wa.me/6285221694067?text={{ urlencode('Halo Scalify, saya tertarik dengan proyek portofolio: ' . $portfolio->title) }}" target="_blank" class="inline-flex items-center gap-2 bg-emerald-600/20 hover:bg-emerald-600/30 border border-emerald-500/40 text-emerald-300 hover:text-emerald-200 text-xs sm:text-sm font-semibold px-5 py-3.5 rounded-full transition-all">
                    <i class="fa-brands fa-whatsapp text-sm"></i>
                    <span>Konsultasi Proyek Serupa</span>
                </a>
            </div>

        </div>
    </section>

    {{-- ══════════════════════════════════════════════════
         MAIN CONTENT & ARTICLE BODY
    ══════════════════════════════════════════════════ --}}
    <main class="py-12 sm:py-16 px-4 sm:px-6 lg:px-8 max-w-6xl mx-auto relative z-10">

        {{-- 3 KEY METRIC CARDS (Challenge, Solution, Result) --}}
        @if ($portfolio->challenge || $portfolio->solution || $portfolio->result)
        <div class="grid grid-cols-1 md:grid-cols-3 gap-5 sm:gap-6 mb-14">
            @if ($portfolio->challenge)
            <div class="bg-red-500/10 border border-red-500/25 rounded-2xl p-6 shadow-card hover:border-red-500/40 transition-all">
                <div class="flex items-center gap-3 mb-3 text-red-400">
                    <div class="w-9 h-9 rounded-xl bg-red-500/20 flex items-center justify-center shrink-0">
                        <i class="fa-solid fa-triangle-exclamation text-sm"></i>
                    </div>
                    <h3 class="font-sans font-bold text-base text-white">Tantangan (Challenge)</h3>
                </div>
                <p class="text-white/70 text-xs sm:text-[13px] leading-relaxed whitespace-pre-line font-normal">
                    {{ $portfolio->challenge }}
                </p>
            </div>
            @endif

            @if ($portfolio->solution)
            <div class="bg-blue-500/10 border border-blue-500/25 rounded-2xl p-6 shadow-card hover:border-blue-500/40 transition-all">
                <div class="flex items-center gap-3 mb-3 text-brand-accent">
                    <div class="w-9 h-9 rounded-xl bg-blue-500/20 flex items-center justify-center shrink-0">
                        <i class="fa-solid fa-lightbulb text-sm"></i>
                    </div>
                    <h3 class="font-sans font-bold text-base text-white">Solusi Arsitektur</h3>
                </div>
                <p class="text-white/70 text-xs sm:text-[13px] leading-relaxed whitespace-pre-line font-normal">
                    {{ $portfolio->solution }}
                </p>
            </div>
            @endif

            @if ($portfolio->result)
            <div class="bg-emerald-500/10 border border-emerald-500/25 rounded-2xl p-6 shadow-card hover:border-emerald-500/40 transition-all">
                <div class="flex items-center gap-3 mb-3 text-emerald-400">
                    <div class="w-9 h-9 rounded-xl bg-emerald-500/20 flex items-center justify-center shrink-0">
                        <i class="fa-solid fa-circle-check text-sm"></i>
                    </div>
                    <h3 class="font-sans font-bold text-base text-white">Hasil & Dampak</h3>
                </div>
                <p class="text-white/70 text-xs sm:text-[13px] leading-relaxed whitespace-pre-line font-normal">
                    {{ $portfolio->result }}
                </p>
            </div>
            @endif
        </div>
        @endif

        {{-- WYSIWYG Full Description Container --}}
        <div class="bg-brand-navy/60 backdrop-blur-xl border border-white/10 rounded-2xl sm:rounded-3xl p-6 sm:p-10 shadow-card mb-16">
            <div class="quill-content-dark">
                {!! $portfolio->full_description !!}
            </div>
        </div>

        {{-- ══════════════════════════════════════════════════
             EXPLORE MORE PROJECTS (POPULAR PORTFOLIO)
        ══════════════════════════════════════════════════ --}}
        @if ($popularPortfolios && count($popularPortfolios) > 0)
        <div class="pt-10 border-t border-white/10 mb-14">
            <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 mb-8">
                <div>
                    <div class="text-[#EF4444] font-extrabold text-[11px] uppercase tracking-[0.2em] mb-1">
                        STUDI KASUS LAINNYA
                    </div>
                    <h2 class="font-sans font-bold text-2xl sm:text-3xl text-white tracking-tight">
                        Jelajahi Proyek Populer Lainnya
                    </h2>
                </div>
                <a href="{{ route('landing.portfolio') }}" class="text-xs font-bold text-brand-accent hover:text-white transition-colors inline-flex items-center gap-1.5">
                    <span>Lihat Semua Portofolio</span>
                    <i class="fa-solid fa-arrow-right text-[10px]"></i>
                </a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5 sm:gap-6">
                @foreach ($popularPortfolios->take(3) as $popular)
                <a href="{{ route('portfolio.read', $popular->slug) }}" class="bg-brand-navy/60 backdrop-blur-xl border border-white/10 hover:border-brand-accent/50 rounded-2xl overflow-hidden shadow-card hover:-translate-y-1.5 transition-all duration-300 flex flex-col group">
                    <div class="relative overflow-hidden aspect-[16/10] bg-white/5">
                        @if ($popular->thumbnail_image)
                        <img src="{{ asset('storage/' . $popular->thumbnail_image) }}" alt="{{ $popular->title }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105" loading="lazy">
                        @else
                        <div class="w-full h-full flex items-center justify-center text-white/30">
                            <i class="fa-solid fa-laptop-code text-3xl"></i>
                        </div>
                        @endif
                        <div class="absolute inset-0 bg-gradient-to-t from-brand-dark/80 via-transparent to-transparent opacity-60"></div>
                        @if ($popular->category)
                        <div class="absolute top-3 left-3">
                            <span class="px-2.5 py-1 rounded bg-brand-dark/80 backdrop-blur-md border border-white/15 text-white/90 text-[10px] font-bold uppercase">
                                {{ $popular->category->name }}
                            </span>
                        </div>
                        @endif
                    </div>
                    <div class="p-5 flex-1 flex flex-col justify-between">
                        <h3 class="font-sans font-bold text-base text-white group-hover:text-brand-accent transition-colors line-clamp-2 mb-2">
                            {{ $popular->title }}
                        </h3>
                        <div class="flex items-center justify-between text-xs text-white/50 pt-3 border-t border-white/5">
                            <span class="text-brand-accent font-semibold flex items-center gap-1">
                                <span>Lihat Studi Kasus</span>
                                <i class="fa-solid fa-arrow-right text-[10px]"></i>
                            </span>
                            @if ($popular->view_count)
                            <span class="flex items-center gap-1">
                                <i class="fa-solid fa-eye text-[10px]"></i> {{ number_format($popular->view_count) }}
                            </span>
                            @endif
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
        @endif

        {{-- Bottom CTA Box --}}
        <div class="bg-gradient-to-br from-blue-900/40 via-indigo-900/30 to-brand-navy border border-brand-accent/30 rounded-2xl sm:rounded-3xl p-8 sm:p-12 text-center shadow-glow-sm relative overflow-hidden">
            <div class="absolute -right-10 -bottom-10 w-48 h-48 bg-brand-accent/15 rounded-full blur-3xl pointer-events-none"></div>
            <div class="relative z-10 max-w-xl mx-auto">
                <h3 class="font-sans font-black text-2xl sm:text-3xl text-white mb-3">
                    Siap Membangun Sistem Serupa?
                </h3>
                <p class="text-white/70 text-xs sm:text-sm leading-relaxed mb-8 font-normal">
                    Diskusikan ide proyek website, web app kustom, atau implementasi metode komputasi & AI bisnis Anda bersama lead engineer Scalify Intelligence.
                </p>
                <div class="flex flex-wrap items-center justify-center gap-3.5">
                    <a href="https://wa.me/6285221694067?text={{ urlencode('Halo Scalify, saya ingin konsultasi pembuatan sistem seperti di portofolio: ' . $portfolio->title) }}" target="_blank" class="inline-flex items-center gap-2.5 bg-btn-gradient text-white text-xs sm:text-sm font-bold px-7 py-3.5 rounded-full shadow-glow-blue hover:scale-105 transition-all">
                        <i class="fa-brands fa-whatsapp text-base"></i>
                        <span>Konsultasi WhatsApp Sekarang</span>
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
        font-size: 15px;
        line-height: 1.85;
        color: rgba(255, 255, 255, 0.82);
    }

    .quill-content-dark h1 {
        font-size: 1.85rem;
        font-weight: 800;
        color: #ffffff;
        margin: 1.75rem 0 0.85rem;
        letter-spacing: -0.02em;
    }

    .quill-content-dark h2 {
        font-size: 1.5rem;
        font-weight: 800;
        color: #ffffff;
        margin: 1.6rem 0 0.85rem;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        padding-bottom: 0.5rem;
        letter-spacing: -0.02em;
    }

    .quill-content-dark h3 {
        font-size: 1.25rem;
        font-weight: 700;
        color: #60A5FA;
        margin: 1.35rem 0 0.6rem;
    }

    .quill-content-dark h4,
    .quill-content-dark h5,
    .quill-content-dark h6 {
        font-size: 1.05rem;
        font-weight: 700;
        color: #ffffff;
        margin: 1.15rem 0 0.5rem;
    }

    .quill-content-dark p {
        margin-bottom: 1.15rem;
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
        border: 1px solid rgba(255, 255, 255, 0.1);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.4);
        margin: 1.5rem 0;
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
        margin-bottom: 1.15rem;
    }

    .quill-content-dark ol {
        list-style: decimal;
        padding-left: 1.75rem;
        margin-bottom: 1.15rem;
    }

    .quill-content-dark li {
        margin-bottom: 0.4rem;
        color: rgba(255, 255, 255, 0.82);
    }

    .quill-content-dark blockquote {
        border-left: 4px solid #3B82F6;
        background: rgba(255, 255, 255, 0.04);
        color: rgba(255, 255, 255, 0.9);
        padding: 1rem 1.35rem;
        border-radius: 0 0.75rem 0.75rem 0;
        margin: 1.35rem 0;
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
        border: 1px solid rgba(255, 255, 255, 0.1);
        color: #E2E8F0;
        padding: 1.15rem 1.35rem;
        border-radius: 0.85rem;
        overflow-x: auto;
        font-size: 0.88em;
        line-height: 1.7;
        margin: 1.35rem 0;
    }

    .quill-content-dark table {
        width: 100%;
        border-collapse: collapse;
        margin: 1.35rem 0;
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
        color: rgba(255, 255, 255, 0.8);
    }

    .quill-content-dark table tr:nth-child(even) td {
        background: rgba(255, 255, 255, 0.02);
    }

</style>
@endsection
