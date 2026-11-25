@extends('layouts.app')

{{-- Halaman topik/tag. Data SEO & JSON-LD disiapkan di HomeController::blogTag(). --}}
@section('meta_tags')
<title>{{ $seo['title'] }} — Scalify Intelligence</title>
<meta name="title" content="{{ $seo['title'] }}" />
<meta name="description" content="{{ $seo['description'] }}" />
<meta name="keywords" content="{{ $tag['name'] }}, {{ $relatedTags->pluck('name')->take(6)->implode(', ') }}" />
<meta name="robots" content="{{ $seo['robots'] }}" />
<link rel="canonical" href="{{ $seo['canonical'] }}" />
@if ($blogs->previousPageUrl())
<link rel="prev" href="{{ $blogs->previousPageUrl() }}" />
@endif
@if ($blogs->nextPageUrl())
<link rel="next" href="{{ $blogs->nextPageUrl() }}" />
@endif

<meta property="og:type" content="website" />
<meta property="og:url" content="{{ $seo['canonical'] }}" />
<meta property="og:title" content="{{ $seo['title'] }}" />
<meta property="og:description" content="{{ $seo['description'] }}" />
<meta property="og:image" content="{{ asset('og-image.png') }}" />
<meta property="og:site_name" content="Scalify Intelligence" />
<meta property="og:locale" content="id_ID" />
<meta name="twitter:card" content="summary_large_image" />
<meta name="twitter:title" content="{{ $seo['title'] }}" />
<meta name="twitter:description" content="{{ $seo['description'] }}" />

<script type="application/ld+json">@json($schema)</script>
@endsection

@section('content')
<div class="min-h-screen bg-brand-dark text-white relative overflow-hidden">
    <div class="absolute top-0 left-1/2 -translate-x-1/2 w-full max-w-7xl h-[380px] bg-gradient-to-b from-brand-blue/15 via-brand-indigo/10 to-transparent blur-3xl pointer-events-none"></div>

    <section class="relative pt-20 pb-8 sm:pt-28 sm:pb-12 px-4 sm:px-6 lg:px-8 border-b border-white/5">
        <div class="max-w-7xl mx-auto relative z-10">
            {{-- Breadcrumb --}}
            <nav aria-label="Breadcrumb" class="mb-5 text-xs text-white/50">
                <ol class="flex flex-wrap items-center gap-1.5">
                    <li><a href="{{ url('/') }}" class="hover:text-white transition-colors">Beranda</a></li>
                    <li aria-hidden="true">/</li>
                    <li><a href="{{ route('landing.blogs') }}" class="hover:text-white transition-colors">Blog</a></li>
                    <li aria-hidden="true">/</li>
                    <li class="text-white/80 font-semibold" aria-current="page">#{{ $tag['name'] }}</li>
                </ol>
            </nav>

            <div class="mb-4">
                <span class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-cyan-500/10 border border-cyan-500/20 text-cyan-400 font-bold text-[11px] sm:text-xs tracking-[0.15em] uppercase">
                    <i class="fa-solid fa-hashtag text-[10px]"></i> Topik
                </span>
            </div>

            <h1 class="font-sans font-black text-3xl sm:text-5xl text-white leading-[1.15] tracking-[-0.03em] mb-3 break-words">
                <span class="bg-gradient-to-r from-blue-400 via-cyan-300 to-indigo-400 bg-clip-text text-transparent">#{{ $tag['name'] }}</span>
            </h1>
            <p class="text-white/65 text-sm sm:text-[15px] max-w-3xl leading-relaxed">
                {{ $tag['count'] }} artikel tentang <strong class="text-white/90 font-semibold">{{ $tag['name'] }}</strong>: panduan, tips, dan studi kasus dari tim Scalify Intelligence.
            </p>

            @if ($relatedTags->isNotEmpty())
            <div class="mt-6">
                <p class="text-[11px] font-bold text-white/40 uppercase tracking-widest mb-2.5">Topik terkait</p>
                <div class="flex flex-wrap gap-2">
                    @foreach ($relatedTags as $related)
                    <a href="{{ route('blogs.tag', $related['slug']) }}" rel="tag" class="px-3.5 py-1.5 rounded-full text-xs font-semibold bg-white/5 border border-white/10 text-white/70 hover:bg-brand-accent hover:text-white hover:border-transparent transition-colors">
                        #{{ $related['name'] }} <span class="text-white/40">{{ $related['count'] }}</span>
                    </a>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </section>

    <section class="py-8 sm:py-14 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto relative z-10">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 sm:gap-6 lg:gap-8 mb-12">
            @foreach ($blogs as $blog)
            @include('pages.blogs.partials.card', ['blog' => $blog])
            @endforeach
        </div>

        <div class="flex justify-center mt-8">
            {{ $blogs->links() }}
        </div>

        <div class="mt-10 text-center">
            <a href="{{ route('landing.blogs') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-brand-accent hover:underline">
                <i class="fa-solid fa-arrow-left text-xs"></i> Lihat semua artikel
            </a>
        </div>
    </section>
</div>
@endsection
