@extends('layouts.app')

@section('meta_tags')
<title>Portofolio & Rekam Jejak Pembuatan Website & Sistem Cerdas — Scalify Intelligence</title>
<meta name="title" content="Portofolio & Rekam Jejak Pembuatan Website & Sistem Cerdas — Scalify Intelligence" />
<meta name="description" content="Katalog proyek pembuatan website, landing page berkonversi tinggi, aplikasi web SaaS kustom, dan implementasi metode algoritma & AI (K-Means, C4.5, SPK, RAG) oleh Scalify Intelligence." />
<meta name="keywords" content="portofolio website, contoh company profile, portofolio web app, implementasi metode k-means, algoritma c4.5 laravel, chatbot ai whatsapp, agency digital indonesia, scalify intelligence" />
<meta name="author" content="Scalify Intelligence" />
<meta name="robots" content="index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1" />
<link rel="canonical" href="{{ route('landing.portfolio') }}" />

{{-- Open Graph / Facebook --}}
<meta property="og:type" content="website" />
<meta property="og:url" content="{{ route('landing.portfolio') }}" />
<meta property="og:title" content="Portofolio & Rekam Jejak Pembuatan Website & Sistem Cerdas — Scalify Intelligence" />
<meta property="og:description" content="Katalog proyek nyata pembuatan website, landing page, web app SaaS, dan implementasi metode kecerdasan buatan oleh Scalify Intelligence." />
<meta property="og:image" content="{{ asset('og-image.png') }}" />
<meta property="og:site_name" content="Scalify Intelligence" />
<meta property="og:locale" content="id_ID" />

{{-- Twitter --}}
<meta name="twitter:card" content="summary_large_image" />
<meta name="twitter:url" content="{{ route('landing.portfolio') }}" />
<meta name="twitter:title" content="Portofolio Pembuatan Website & Web App — Scalify Intelligence" />
<meta name="twitter:description" content="Katalog proyek pembuatan website profesional, web app SaaS, dan sistem cerdas di Indonesia." />
<meta name="twitter:image" content="{{ asset('og-image.png') }}" />

{{-- Schema.org JSON-LD Structured Data for Portfolio Indexing --}}
@php
$schemaItems = [];
foreach ($portfolios as $index => $p) {
$schemaItems[] = [
'@type' => 'CreativeWork',
'position' => $index + 1,
'name' => $p->title,
'url' => route('portfolio.read', $p->slug),
'description' => $p->short_description,
'image' => $p->thumbnail_image ? asset('storage/' . $p->thumbnail_image) : asset('og-image.png'),
];
}
$collectionSchema = [
'@context' => 'https://schema.org',
'@type' => 'CollectionPage',
'name' => 'Katalog Portofolio & Proyek Digital — Scalify Intelligence',
'url' => route('landing.portfolio'),
'description' => 'Koleksi studi kasus pembuatan website, landing page, web app, dan implementasi sistem berbasis metode komputasi & AI.',
'publisher' => [
'@type' => 'Organization',
'name' => 'Scalify Intelligence',
'url' => 'https://scalifyintellegence.my.id',
'logo' => [
'@type' => 'ImageObject',
'url' => asset('scalify.png'),
],
],
'mainEntity' => [
'@type' => 'ItemList',
'itemListElement' => $schemaItems,
],
];
@endphp
<script type="application/ld+json">
    {
        !!json_encode($collectionSchema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) !!
    }

</script>
@endsection

@section('content')
<div class="min-h-screen bg-brand-dark text-white relative overflow-hidden">

    {{-- Ambient Midnight Glow Background Effects --}}
    <div class="absolute top-0 left-1/2 -translate-x-1/2 w-full max-w-7xl h-[480px] bg-gradient-to-b from-brand-blue/15 via-brand-indigo/10 to-transparent blur-3xl pointer-events-none"></div>
    <div class="absolute top-24 right-10 w-96 h-96 bg-brand-accent/10 rounded-full blur-[110px] pointer-events-none"></div>
    <div class="absolute top-80 left-5 w-80 h-80 bg-brand-indigo/10 rounded-full blur-[100px] pointer-events-none"></div>

    {{-- ══════════════════════════════════════════════════
         HERO SECTION: PORTFOLIO & REKAM JEJAK
    ══════════════════════════════════════════════════ --}}
    <section class="relative pt-12 pb-10 sm:pt-20 sm:pb-14 px-4 sm:px-6 lg:px-8 border-b border-white/5">
        <div class="max-w-7xl mx-auto relative z-10">

            {{-- Eyebrow --}}
            <div class="mb-3">
                <span class="text-[#EF4444] font-extrabold text-[11px] sm:text-xs tracking-[0.2em] uppercase inline-flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-[#EF4444] animate-pulse"></span>
                    REKAM JEJAK & STUDI KASUS NYATA
                </span>
            </div>

            {{-- Main Heading --}}
            <h1 class="font-sans font-black text-3xl sm:text-5xl lg:text-[44px] text-white leading-[1.18] tracking-[-0.03em] max-w-3xl mb-4">
                Katalog Portofolio & Solusi Digital Kami
            </h1>

            {{-- Subtitle --}}
            <p class="text-white/65 text-xs sm:text-sm md:text-base max-w-2xl leading-relaxed font-normal mb-8">
                Jelajahi berbagai proyek nyata yang telah kami selesaikan — mulai dari website company profile kelas dunia, landing page konversi tinggi, aplikasi web SaaS multi-tenant, hingga sistem komputasi berbasis metode data science & automasi AI.
            </p>

            {{-- ══════════════════════════════════════════════════
                 FEATURED PROJECT HIGHLIGHT (Jika ada)
            ══════════════════════════════════════════════════ --}}
            @if ($featuredPortfolio)
            <div class="mt-4 mb-6">
                <a href="{{ route('portfolio.read', $featuredPortfolio->slug) }}" class="block bg-brand-navy/70 backdrop-blur-xl border border-white/10 hover:border-brand-accent/50 rounded-2xl sm:rounded-3xl p-4 sm:p-7 shadow-card hover:shadow-glow-blue transition-all duration-300 group relative overflow-hidden">

                    {{-- Background Accent Glow --}}
                    <div class="absolute -right-20 -top-20 w-80 h-80 bg-brand-accent/10 rounded-full blur-[80px] pointer-events-none"></div>

                    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 lg:gap-8 items-center">

                        {{-- Screenshot Thumbnail --}}
                        <div class="lg:col-span-6 rounded-xl sm:rounded-2xl overflow-hidden aspect-[16/10] sm:aspect-video relative bg-white/5 border border-white/10">
                            @if ($featuredPortfolio->thumbnail_image)
                            <img src="{{ asset('storage/' . $featuredPortfolio->thumbnail_image) }}" alt="{{ $featuredPortfolio->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 ease-out" fetchpriority="high">
                            @else
                            <div class="w-full h-full flex items-center justify-center bg-brand-navy text-white/40">
                                <i class="fa-solid fa-laptop-code text-4xl text-brand-accent/40"></i>
                            </div>
                            @endif
                            <div class="absolute inset-0 bg-gradient-to-t from-brand-dark/70 via-transparent to-transparent opacity-60 group-hover:opacity-30 transition-opacity"></div>
                        </div>

                        {{-- Project Info --}}
                        <div class="lg:col-span-6 flex flex-col justify-center">
                            <div class="flex items-center gap-2.5 mb-3 flex-wrap">
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-brand-accent/15 border border-brand-accent/30 text-brand-accent text-[10px] font-bold tracking-wider uppercase shadow-sm">
                                    <i class="fa-solid fa-star text-[9px] text-amber-400"></i> Featured Project
                                </span>
                                @if ($featuredPortfolio->category)
                                <span class="text-white/60 text-xs font-semibold uppercase tracking-wider">
                                    {{ $featuredPortfolio->category->name }}
                                </span>
                                @endif
                                @if ($featuredPortfolio->view_count)
                                <span class="text-white/40 text-xs flex items-center gap-1">
                                    <i class="fa-solid fa-eye text-brand-accent text-[10px]"></i> {{ number_format($featuredPortfolio->view_count) }} views
                                </span>
                                @endif
                            </div>

                            <h2 class="font-sans font-bold text-xl sm:text-2xl lg:text-3xl text-white group-hover:text-brand-accent transition-colors leading-tight mb-3">
                                {{ $featuredPortfolio->title }}
                            </h2>

                            <p class="text-white/70 text-xs sm:text-sm leading-relaxed mb-6 font-normal line-clamp-3">
                                {{ $featuredPortfolio->short_description }}
                            </p>

                            {{-- Tech Tags --}}
                            @php
                            $techs = is_array($featuredPortfolio->technologies)
                            ? $featuredPortfolio->technologies
                            : (is_string($featuredPortfolio->technologies) ? explode(',', $featuredPortfolio->technologies) : []);
                            @endphp
                            @if (!empty($techs))
                            <div class="flex items-center gap-2 mb-6 flex-wrap">
                                @foreach(array_slice($techs, 0, 4) as $tech)
                                <span class="px-2.5 py-1 rounded-lg bg-white/5 border border-white/10 text-white/80 text-[11px] font-medium">
                                    {{ trim($tech) }}
                                </span>
                                @endforeach
                            </div>
                            @endif

                            <div class="flex items-center gap-3">
                                <span class="inline-flex items-center gap-2 bg-btn-gradient text-white text-xs sm:text-sm font-bold px-6 py-3 rounded-full shadow-glow-sm group-hover:shadow-glow-blue transition-all">
                                    <span>Lihat Detail Studi Kasus</span>
                                    <i class="fa-solid fa-arrow-right text-xs group-hover:translate-x-1 transition-transform"></i>
                                </span>
                            </div>
                        </div>

                    </div>
                </a>
            </div>
            @endif

        </div>

        {{-- ══════════════════════════════════════════════════
             MARQUEE CHIPS: TECH CAPABILITIES
        ══════════════════════════════════════════════════ --}}
        <div class="relative bg-[#080c26] border-t border-white/5 py-3 overflow-hidden mt-8">
            <div class="absolute left-0 top-0 bottom-0 w-16 bg-gradient-to-r from-[#080c26] to-transparent z-10 pointer-events-none"></div>
            <div class="absolute right-0 top-0 bottom-0 w-16 bg-gradient-to-l from-[#080c26] to-transparent z-10 pointer-events-none"></div>

            <div class="flex w-max gap-3 animate-infinite-marquee">
                @php
                $chips = [
                ['icon' => 'fa-laptop-code', 'label' => 'Company Profile Website'],
                ['icon' => 'fa-bullhorn', 'label' => 'Landing Page Ads & Sales'],
                ['icon' => 'fa-cubes', 'label' => 'Web App SaaS Multi-Tenant'],
                ['icon' => 'fa-robot', 'label' => 'WhatsApp AI Bot Automation'],
                ['icon' => 'fa-diagram-project', 'label' => 'Metode K-Means Clustering'],
                ['icon' => 'fa-tree', 'label' => 'Algoritma C4.5 Decision Tree'],
                ['icon' => 'fa-chart-pie', 'label' => 'Sistem Pendukung Keputusan (SPK)'],
                ['icon' => 'fa-credit-card', 'label' => 'Payment Gateway Otomatis'],
                ['icon' => 'fa-server', 'label' => 'Laravel & Cloud VPS Deploy'],
                ];
                @endphp

                @foreach ($chips as $chip)
                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full border border-white/10 bg-white/5 text-white/70 text-xs font-normal whitespace-nowrap">
                    <i class="fa-solid {{ $chip['icon'] }} text-brand-accent text-[11px]"></i>
                    <span>{{ $chip['label'] }}</span>
                </div>
                @endforeach

                @foreach ($chips as $chip)
                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full border border-white/10 bg-white/5 text-white/70 text-xs font-normal whitespace-nowrap">
                    <i class="fa-solid {{ $chip['icon'] }} text-brand-accent text-[11px]"></i>
                    <span>{{ $chip['label'] }}</span>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ══════════════════════════════════════════════════
         MAIN PORTFOLIO GRID & SIDEBAR SECTION
    ══════════════════════════════════════════════════ --}}
    <section class="py-12 sm:py-16 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto relative z-10">

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-10 items-start">

            {{-- ══════════════════════════════════════════════════
                 LEFT: PORTFOLIO CARDS GRID (Col 8)
            ══════════════════════════════════════════════════ --}}
            <div class="lg:col-span-8">

                {{-- Header count --}}
                <div class="flex items-center justify-between mb-8 pb-3 border-b border-white/10">
                    <div>
                        <h2 class="font-sans font-bold text-xl sm:text-2xl text-white tracking-tight">
                            Semua Proyek & Implementasi
                        </h2>
                        <p class="text-white/50 text-xs mt-1">
                            Menampilkan {{ $portfolios->count() }} dari total {{ $portfolios->total() }} proyek terverifikasi
                        </p>
                    </div>
                    <div class="text-xs text-brand-accent font-semibold tracking-wider uppercase hidden sm:block">
                        <i class="fa-solid fa-circle-check text-[10px]"></i> Live Production Ready
                    </div>
                </div>

                {{-- 2-Column Grid of Project Cards --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 sm:gap-6">
                    @forelse($portfolios as $portfolio)
                    <div class="bg-brand-navy/60 backdrop-blur-xl border border-white/10 hover:border-brand-accent/50 rounded-2xl overflow-hidden shadow-card hover:-translate-y-1.5 transition-all duration-300 flex flex-col h-full group">

                        {{-- Card Image --}}
                        <div class="relative overflow-hidden aspect-[16/10] bg-white/5">
                            <a href="{{ route('portfolio.read', $portfolio->slug) }}" class="block w-full h-full">
                                @if ($portfolio->thumbnail_image)
                                <img src="{{ asset('storage/' . $portfolio->thumbnail_image) }}" alt="{{ $portfolio->title }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105" loading="lazy">
                                @else
                                <div class="w-full h-full flex items-center justify-center bg-brand-navy text-white/30">
                                    <i class="fa-solid fa-layer-group text-3xl"></i>
                                </div>
                                @endif
                                <div class="absolute inset-0 bg-gradient-to-t from-brand-dark/80 via-transparent to-transparent opacity-50 group-hover:opacity-20 transition-opacity"></div>
                            </a>

                            {{-- Category Badge Top Left --}}
                            @if ($portfolio->category)
                            <div class="absolute top-3 left-3">
                                <span class="px-2.5 py-1 rounded-md bg-brand-dark/80 backdrop-blur-md border border-white/15 text-white/90 text-[10px] font-bold tracking-wider uppercase shadow-sm">
                                    {{ $portfolio->category->name }}
                                </span>
                            </div>
                            @endif

                            {{-- Completion Year Top Right --}}
                            @if ($portfolio->completion_date)
                            <div class="absolute top-3 right-3">
                                <span class="px-2 py-0.5 rounded-md bg-white/10 backdrop-blur-md border border-white/10 text-white/70 text-[10px] font-medium">
                                    {{ \Carbon\Carbon::parse($portfolio->completion_date)->format('Y') }}
                                </span>
                            </div>
                            @endif
                        </div>

                        {{-- Card Body --}}
                        <div class="p-5 flex-1 flex flex-col justify-between">
                            <div>
                                {{-- Client or Type --}}
                                <div class="text-white/40 text-[11px] font-medium mb-1.5 uppercase tracking-wider">
                                    {{ $portfolio->client_name ?: 'Digital Solution' }}
                                </div>

                                {{-- Title --}}
                                <h3 class="font-sans font-bold text-base sm:text-lg text-white group-hover:text-brand-accent transition-colors leading-snug mb-2 line-clamp-2">
                                    <a href="{{ route('portfolio.read', $portfolio->slug) }}">
                                        {{ $portfolio->title }}
                                    </a>
                                </h3>

                                {{-- Short description --}}
                                <p class="text-white/60 text-xs sm:text-[13px] leading-relaxed line-clamp-2 mb-4 font-normal">
                                    {{ $portfolio->short_description }}
                                </p>
                            </div>

                            {{-- Tech Badges & View Details Button --}}
                            <div>
                                @php
                                $techList = is_array($portfolio->technologies)
                                ? $portfolio->technologies
                                : (is_string($portfolio->technologies) ? explode(',', $portfolio->technologies) : []);
                                @endphp
                                @if (!empty($techList))
                                <div class="flex items-center gap-1.5 mb-4 flex-wrap">
                                    @foreach(array_slice($techList, 0, 3) as $tech)
                                    <span class="px-2 py-0.5 rounded bg-white/5 border border-white/10 text-white/70 text-[10px]">
                                        {{ trim($tech) }}
                                    </span>
                                    @endforeach
                                </div>
                                @endif

                                <div class="pt-3 border-t border-white/5 flex items-center justify-between">
                                    <a href="{{ route('portfolio.read', $portfolio->slug) }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-brand-accent group-hover:text-white transition-colors">
                                        <span>Lihat Detail</span>
                                        <i class="fa-solid fa-arrow-right text-[10px] group-hover:translate-x-1 transition-transform"></i>
                                    </a>
                                    @if ($portfolio->view_count)
                                    <span class="text-white/40 text-[11px] flex items-center gap-1">
                                        <i class="fa-solid fa-eye text-[9px]"></i> {{ number_format($portfolio->view_count) }}
                                    </span>
                                    @endif
                                </div>
                            </div>

                        </div>
                    </div>
                    @empty
                    <div class="col-span-2 text-center py-16 bg-white/5 rounded-2xl border border-white/10 p-8">
                        <div class="w-16 h-16 rounded-full bg-white/10 flex items-center justify-center mx-auto mb-4 text-brand-accent">
                            <i class="fa-solid fa-folder-open text-2xl"></i>
                        </div>
                        <h3 class="text-lg font-bold text-white mb-1">Belum Ada Proyek</h3>
                        <p class="text-white/50 text-xs">Daftar proyek portofolio akan segera ditambahkan di sini.</p>
                    </div>
                    @endforelse
                </div>

                {{-- Pagination --}}
                @if ($portfolios->hasPages())
                <div class="mt-12 flex justify-center">
                    <div class="bg-brand-navy/80 backdrop-blur-xl border border-white/10 p-2 rounded-2xl shadow-card">
                        {{ $portfolios->links() }}
                    </div>
                </div>
                @endif

            </div>

            {{-- ══════════════════════════════════════════════════
                 RIGHT: SIDEBAR WIDGETS (Col 4)
            ══════════════════════════════════════════════════ --}}
            <div class="lg:col-span-4">
                <div class="sticky top-24 space-y-6">

                    {{-- Widget 1: Popular Projects --}}
                    <div class="bg-brand-navy/60 backdrop-blur-xl border border-white/10 rounded-2xl p-5 sm:p-6 shadow-card">
                        <div class="flex items-center gap-3 mb-5 pb-3 border-b border-white/10">
                            <div class="w-9 h-9 rounded-xl bg-btn-gradient flex items-center justify-center shadow-glow-sm text-white">
                                <i class="fa-solid fa-fire text-sm"></i>
                            </div>
                            <div>
                                <h3 class="font-sans font-bold text-base text-white">Proyek Terpopuler</h3>
                                <p class="text-white/50 text-[11px]">Banyak dilihat & diimplementasikan</p>
                            </div>
                        </div>

                        @if ($popularPortfolios->isNotEmpty())
                        <div class="space-y-3.5">
                            @foreach ($popularPortfolios as $popular)
                            <a href="{{ route('portfolio.read', $popular->slug) }}" class="group flex items-center gap-3 p-2.5 rounded-xl hover:bg-white/5 border border-transparent hover:border-white/10 transition-all duration-300">
                                <div class="w-14 h-14 rounded-lg overflow-hidden bg-white/5 shrink-0 border border-white/10">
                                    @if ($popular->thumbnail_image)
                                    <img src="{{ asset('storage/' . $popular->thumbnail_image) }}" alt="{{ $popular->title }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                    @else
                                    <div class="w-full h-full flex items-center justify-center text-white/30 text-xs">
                                        <i class="fa-solid fa-globe"></i>
                                    </div>
                                    @endif
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h4 class="text-xs sm:text-[13px] font-bold text-white/90 group-hover:text-brand-accent transition-colors line-clamp-1 mb-1">
                                        {{ $popular->title }}
                                    </h4>
                                    <div class="flex items-center gap-2 text-[11px] text-white/40">
                                        <span class="flex items-center gap-1 text-brand-accent">
                                            <i class="fa-solid fa-eye text-[9px]"></i> {{ number_format($popular->view_count) }}
                                        </span>
                                        <span>•</span>
                                        <span class="truncate">{{ $popular->category->name ?? 'Project' }}</span>
                                    </div>
                                </div>
                            </a>
                            @endforeach
                        </div>
                        @else
                        <p class="text-white/40 text-xs text-center py-4">Belum ada data proyek populer.</p>
                        @endif
                    </div>

                    {{-- Widget 2: Quick Metrics / Agency Trust Stats --}}
                    <div class="bg-gradient-to-br from-blue-900/40 via-indigo-900/30 to-brand-navy border border-brand-accent/30 rounded-2xl p-6 shadow-glow-sm relative overflow-hidden">
                        <div class="absolute -right-6 -bottom-6 w-32 h-32 bg-brand-accent/15 rounded-full blur-2xl pointer-events-none"></div>
                        <div class="relative z-10">
                            <div class="mb-4">
                                <span class="text-[#EF4444] font-extrabold text-[10px] tracking-[0.2em] uppercase">METRIK & PERFORMA</span>
                                <h3 class="font-sans font-bold text-lg text-white mt-0.5">Statistik Scalify</h3>
                            </div>

                            <div class="space-y-3.5 text-xs">
                                <div class="flex items-center justify-between pb-2.5 border-b border-white/10">
                                    <span class="text-white/60">Total Proyek Selesai</span>
                                    <span class="font-bold text-base text-white">500+</span>
                                </div>
                                <div class="flex items-center justify-between pb-2.5 border-b border-white/10">
                                    <span class="text-white/60">Rating Kepuasan Klien</span>
                                    <span class="font-bold text-base text-amber-400">4.9 / 5.0</span>
                                </div>
                                <div class="flex items-center justify-between pb-2.5 border-b border-white/10">
                                    <span class="text-white/60">Infrastruktur Produksi</span>
                                    <span class="font-bold text-base text-emerald-400">Cloud VPS 24/7</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-white/60">Implementasi Algoritma & AI</span>
                                    <span class="font-bold text-base text-brand-accent">100% In-House</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Widget 3: CTA Box --}}
                    <div class="bg-brand-navy/70 backdrop-blur-xl border border-white/10 rounded-2xl p-6 shadow-card text-center relative overflow-hidden">
                        <div class="w-12 h-12 rounded-2xl bg-btn-gradient flex items-center justify-center mx-auto mb-4 shadow-glow-blue text-white">
                            <i class="fa-brands fa-whatsapp text-xl"></i>
                        </div>
                        <h3 class="font-sans font-bold text-lg text-white mb-2">Ingin Bangun Website Serupa?</h3>
                        <p class="text-white/60 text-xs leading-relaxed mb-5 font-normal">
                            Konsultasikan kebutuhan website company profile, web app SaaS, atau implementasi sistem metode algoritma Anda langsung dengan tim lead engineer kami.
                        </p>
                        <a href="https://wa.me/6285221694067?text=Halo%20Scalify,%20saya%20tertarik%20dengan%20proyek%20portofolio%20website%20Anda" target="_blank" class="w-full inline-flex items-center justify-center gap-2 bg-btn-gradient text-white text-xs sm:text-sm font-bold py-3.5 px-5 rounded-full shadow-glow-sm hover:shadow-glow-blue hover:scale-105 transition-all">
                            <span>Konsultasi Proyek Sekarang</span>
                            <i class="fa-solid fa-arrow-right text-xs"></i>
                        </a>
                    </div>

                </div>
            </div>

        </div>

    </section>

</div>

<style>
    @keyframes infiniteMarquee {
        0% {
            transform: translateX(0);
        }

        100% {
            transform: translateX(-50%);
        }
    }

    .animate-infinite-marquee {
        animation: infiniteMarquee 26s linear infinite;
    }

    .animate-infinite-marquee:hover {
        animation-play-state: paused;
    }

</style>
@endsection
