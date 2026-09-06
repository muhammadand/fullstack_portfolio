@extends('layouts.app')

@section('meta_tags')
<title>Blog & Panduan Pembuatan Website Profesional — Scalify Intelligence</title>
<meta name="title" content="Blog & Panduan Pembuatan Website Profesional — Scalify Intelligence" />
<meta name="description" content="Kumpulan artikel, tren desain web, tips UI/UX, dan panduan pembuatan website profesional, landing page konversi tinggi, serta web app kustom untuk bisnis Anda." />
<meta name="keywords" content="jasa pembuatan website, web development agency, bikin website bisnis, landing page profesional, web application kustom, ui ux design, digital agency indonesia, scalify intelligence" />
<meta name="author" content="Scalify Intelligence" />
<meta name="robots" content="index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1" />
<link rel="canonical" href="{{ route('landing.blogs') }}" />

{{-- Open Graph / Facebook --}}
<meta property="og:type" content="blog" />
<meta property="og:url" content="{{ route('landing.blogs') }}" />
<meta property="og:title" content="Blog & Panduan Pembuatan Website Profesional — Scalify Intelligence" />
<meta property="og:description" content="Kumpulan artikel, tips UI/UX, dan panduan pembuatan website serta web app modern dari agency digital Scalify Intelligence." />
<meta property="og:image" content="{{ asset('og-image.png') }}" />
<meta property="og:site_name" content="Scalify Intelligence" />
<meta property="og:locale" content="id_ID" />

{{-- Twitter --}}
<meta name="twitter:card" content="summary_large_image" />
<meta name="twitter:url" content="{{ route('landing.blogs') }}" />
<meta name="twitter:title" content="Blog & Panduan Pembuatan Website Profesional — Scalify Intelligence" />
<meta name="twitter:description" content="Kumpulan artikel, tips UI/UX, dan panduan pembuatan website serta web app modern dari agency digital Scalify Intelligence." />
<meta name="twitter:image" content="{{ asset('og-image.png') }}" />

{{-- Schema.org JSON-LD Structured Data for Indexing --}}
@php
$schemaItems = [];
foreach ($blogs as $index => $b) {
$schemaItems[] = [
'@type' => 'ListItem',
'position' => $index + 1,
'url' => route('blogs.read', $b->slug),
'name' => $b->title,
];
}
$collectionSchema = [
'@context' => 'https://schema.org',
'@type' => 'CollectionPage',
'name' => 'Blog Pembuatan Website & Digital Agency — Scalify Intelligence',
'url' => route('landing.blogs'),
'description' => 'Kumpulan artikel dan wawasan pengembangan website profesional, web aplikasi, UI/UX, dan strategi digital agency.',
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
    <div class="absolute top-0 left-1/2 -translate-x-1/2 w-full max-w-7xl h-[450px] bg-gradient-to-b from-brand-blue/15 via-brand-indigo/10 to-transparent blur-3xl pointer-events-none"></div>
    <div class="absolute top-20 right-10 w-96 h-96 bg-brand-accent/10 rounded-full blur-[100px] pointer-events-none"></div>

    {{-- Hero Section (Digital Agency Website Focus) --}}
    <section class="relative pt-20 pb-8 sm:pt-28 sm:pb-16 px-4 sm:px-6 lg:px-8 border-b border-white/5">
        <div class="max-w-7xl mx-auto relative z-10">
            {{-- Tagline / Eyebrow --}}
            <div class="mb-2 sm:mb-3">
                <span class="text-brand-accent font-bold text-[10px] sm:text-xs tracking-[0.25em] uppercase inline-flex items-center gap-1.5 sm:gap-2">
                    <span class="w-1.5 h-1.5 sm:w-2 sm:h-2 rounded-full bg-brand-accent animate-pulse"></span>
                    Digital Agency & Web Development
                </span>
            </div>

            {{-- Main Heading --}}
            <h1 class="text-2xl sm:text-4xl md:text-5xl font-extrabold text-white tracking-tight font-display mb-2.5 sm:mb-3 leading-tight">
                Inspirasi Website, Web App & Strategi Digital
            </h1>

            {{-- Subtitle --}}
            <p class="text-white/70 text-xs sm:text-base max-w-3xl leading-relaxed mb-6 sm:mb-8">
                Temukan panduan pembuatan website modern, optimasi kecepatan, desain UI/UX berkonversi tinggi, dan studi kasus pengembangan web app dari tim Scalify Intelligence.
            </p>

            {{-- Search Bar --}}
            <form action="{{ route('landing.blogs') }}" method="GET" class="mb-6 sm:mb-8 max-w-xl">
                @if(request('category'))
                <input type="hidden" name="category" value="{{ request('category') }}">
                @endif
                <div class="flex items-center bg-white/5 backdrop-blur-xl rounded-full border border-white/15 p-1 sm:p-1.5 focus-within:border-brand-accent focus-within:ring-2 focus-within:ring-brand-accent/20 transition-all shadow-lg">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari artikel website, landing page, UI/UX, tech stack..." class="w-full bg-transparent px-3.5 sm:px-4 py-1.5 text-xs sm:text-sm text-white placeholder-white/40 focus:outline-none">
                    <button type="submit" class="bg-btn-gradient hover:opacity-95 text-white text-xs sm:text-sm font-bold px-5 sm:px-6 py-2 rounded-full transition shadow-glow-sm shrink-0 flex items-center gap-1.5">
                        Cari
                    </button>
                </div>
            </form>

            {{-- Category Filter Pills --}}
            <div class="flex flex-wrap items-center gap-2 sm:gap-2.5">
                {{-- Semua Tab --}}
                <a href="{{ route('landing.blogs', array_filter(['search' => request('search')])) }}" class="px-4 py-1.5 sm:py-2 rounded-full text-xs font-semibold whitespace-nowrap transition-all duration-200 {{ !request('category') ? 'bg-btn-gradient text-white shadow-glow-sm' : 'bg-white/5 hover:bg-white/10 border border-white/10 text-white/70 hover:text-white' }}">
                    Semua
                </a>

                {{-- Dynamic Categories --}}
                @foreach ($categories as $cat)
                <a href="{{ route('landing.blogs', array_filter(['category' => $cat->slug, 'search' => request('search')])) }}" class="px-4 py-1.5 sm:py-2 rounded-full text-xs font-semibold whitespace-nowrap transition-all duration-200 {{ request('category') == $cat->slug ? 'bg-btn-gradient text-white shadow-glow-sm' : 'bg-white/5 hover:bg-white/10 border border-white/10 text-white/70 hover:text-white' }}">
                    {{ $cat->name }}
                </a>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Main Content Section --}}
    <section class="py-8 sm:py-14 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto relative z-10">

        {{-- Featured Article (Large Card) --}}
        @if ($popular && !request('search') && !request('category'))
        <div class="mb-8 sm:mb-12">
            <a href="{{ route('blogs.read', $popular->slug) }}" class="block bg-brand-navy/70 backdrop-blur-xl border border-white/10 hover:border-brand-accent/40 rounded-2xl sm:rounded-3xl p-3 sm:p-6 shadow-card hover:shadow-glow-blue transition-all duration-300 group">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-4 sm:gap-6 items-center">

                    {{-- Featured Image --}}
                    <div class="lg:col-span-4 rounded-xl sm:rounded-2xl overflow-hidden aspect-[16/10] sm:aspect-video lg:aspect-[4/3] relative bg-white/5 shrink-0 border border-white/5">
                        @if ($popular->featured_image)
                        <img src="{{ asset('storage/' . $popular->featured_image) }}" alt="{{ $popular->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 ease-out" fetchpriority="high">
                        @else
                        <img src="{{ asset('scalify-blog-default.webp') }}" alt="{{ $popular->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 ease-out" fetchpriority="high">
                        @endif
                    </div>

                    {{-- Featured Info --}}
                    <div class="lg:col-span-8 flex flex-col justify-center px-1 sm:px-0 lg:pr-4">
                        {{-- Category, Date & Read Time --}}
                        <div class="flex items-center gap-2.5 text-xs mb-1.5 sm:mb-2.5">
                            <span class="text-brand-accent font-bold tracking-wider uppercase text-[11px] sm:text-xs">
                                {{ $popular->category->name ?? 'WEB DEVELOPMENT' }}
                            </span>
                            <span class="text-white/40 font-normal text-[11px] sm:text-xs">
                                {{ $popular->published_at ? $popular->published_at->format('d M Y') : $popular->created_at->format('d M Y') }}
                            </span>
                            <span class="text-white/40 font-normal text-[11px] sm:text-xs">
                                {{ $popular->reading_time ?? '5' }} min read
                            </span>
                        </div>

                        {{-- Title --}}
                        <h2 class="text-base sm:text-2xl lg:text-[26px] font-bold text-white group-hover:text-brand-accent transition-colors leading-snug mb-2 sm:mb-3">
                            {{ $popular->title }}
                        </h2>

                        {{-- Excerpt --}}
                        <p class="text-white/70 text-xs sm:text-sm leading-relaxed line-clamp-2 sm:line-clamp-3 mb-3 sm:mb-5 font-normal">
                            {{ $popular->excerpt }}
                        </p>

                        {{-- Author Info --}}
                        <div class="flex items-center gap-2.5 mt-auto">
                            @php
                            $authorName = $popular->author->name ?? ($popular->affiliate->name ?? 'Scalify Team');
                            $initial = strtoupper(substr($authorName, 0, 1));
                            @endphp
                            <div class="w-6 h-6 sm:w-8 sm:h-8 rounded-full bg-btn-gradient text-white flex items-center justify-center font-bold text-[10px] sm:text-xs shrink-0 shadow-sm border border-white/20">
                                {{ $initial }}
                            </div>
                            <span class="text-xs sm:text-sm font-semibold text-white/90">
                                {{ $authorName }}
                            </span>
                        </div>
                    </div>

                </div>
            </a>
        </div>
        @endif

        {{-- Active Filter / Search Info (If filtering) --}}
        @if(request('search') || request('category'))
        <div class="flex items-center justify-between mb-6 pb-3 border-b border-white/10">
            <div class="flex items-center gap-2 flex-wrap">
                <span class="text-xs sm:text-sm text-white/50">Menampilkan hasil untuk:</span>
                @if(request('category'))
                <span class="bg-brand-blue/20 border border-brand-blue/30 text-brand-accent px-2.5 py-0.5 rounded-full text-xs font-semibold">
                    Kategori: {{ $categories->firstWhere('slug', request('category'))->name ?? request('category') }}
                </span>
                @endif
                @if(request('search'))
                <span class="bg-white/10 border border-white/10 text-white px-2.5 py-0.5 rounded-full text-xs font-semibold">
                    "{{ request('search') }}"
                </span>
                @endif
            </div>
            <a href="{{ route('landing.blogs') }}" class="text-xs font-semibold text-brand-accent hover:underline shrink-0">
                Reset Filter
            </a>
        </div>
        @endif

        {{-- Articles List / Grid (Mobile: Horizontal List Card, Desktop: 3-Col Vertical Card Grid) --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 sm:gap-6 lg:gap-8 mb-12">
            @forelse ($blogs as $blog)
            <a href="{{ route('blogs.read', $blog->slug) }}" class="bg-brand-navy/70 backdrop-blur-xl border border-white/10 rounded-2xl overflow-hidden shadow-card hover:shadow-glow-sm hover:border-brand-accent/40 hover:-translate-y-0.5 transition-all duration-300 flex flex-row sm:flex-col group h-full p-2.5 sm:p-0 items-center sm:items-stretch">

                {{-- Card Image (Mobile: Square Thumbnail di Kiri, Desktop: 16:10 Banner di Atas) --}}
                <div class="w-24 h-24 sm:w-full sm:h-auto sm:aspect-[16/10] rounded-xl sm:rounded-none overflow-hidden relative bg-white/5 shrink-0 sm:border-b border-white/5">
                    @if ($blog->featured_image)
                    <img src="{{ asset('storage/' . $blog->featured_image) }}" alt="{{ $blog->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500 ease-out" loading="lazy" decoding="async">
                    @else
                    <img src="{{ asset('scalify-blog-default.webp') }}" alt="{{ $blog->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500 ease-out" loading="lazy" decoding="async">
                    @endif
                </div>

                {{-- Card Content (Mobile: Sisi Kanan, Desktop: Bawah Gambar) --}}
                <div class="p-2.5 sm:p-5 lg:p-6 flex flex-col flex-1 min-w-0 justify-center sm:justify-start">
                    {{-- Category --}}
                    <div class="text-brand-accent font-bold text-[10px] sm:text-[11px] tracking-wider uppercase mb-1 sm:mb-2">
                        {{ $blog->category->name ?? 'WEB DEVELOPMENT' }}
                    </div>

                    {{-- Title --}}
                    <h3 class="font-bold text-[13px] sm:text-base leading-snug text-white/95 group-hover:text-brand-accent transition-colors line-clamp-2 mb-1.5 sm:mb-3">
                        {{ $blog->title }}
                    </h3>

                    {{-- Footer: Date & Reading Time --}}
                    <div class="mt-auto flex items-center text-[11px] sm:text-xs text-white/40 font-medium gap-2 sm:gap-3 pt-1 sm:pt-3 sm:border-t border-white/5">
                        <span>{{ $blog->published_at ? $blog->published_at->format('d M Y') : $blog->created_at->format('d M Y') }}</span>
                        <span>{{ $blog->reading_time ?? '5' }} min read</span>
                    </div>
                </div>

            </a>
            @empty
            <div class="col-span-full py-16 text-center bg-white/5 backdrop-blur-md border border-white/10 rounded-2xl">
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-white/5 mb-4 text-white/40">
                    <i class="fas fa-newspaper text-2xl"></i>
                </div>
                <h3 class="text-lg font-bold text-white mb-1">Artikel Tidak Ditemukan</h3>
                <p class="text-white/60 text-sm mb-4">Coba cari kata kunci lain atau pilih kategori yang berbeda.</p>
                <a href="{{ route('landing.blogs') }}" class="inline-block bg-btn-gradient text-white px-5 py-2 rounded-full text-xs font-semibold shadow-glow-sm hover:opacity-90 transition">
                    Lihat Semua Artikel
                </a>
            </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        <div class="flex justify-center mt-8">
            {{ $blogs->links() }}
        </div>

    </section>
</div>
@endsection
