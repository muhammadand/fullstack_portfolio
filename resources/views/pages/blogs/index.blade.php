@extends('layouts.app')

@section('content')
{{-- Highlight Populer Full Bleed --}}
@if ($popular)
<section class="relative z-20 w-full mt-0">
    {{-- Schema.org JSON-LD for Popular Article to boost SEO --}}
    <script type="application/ld+json">
        {
            "@@context": "https://schema.org"
            , "@@type": "BlogPosting"
            , "mainEntityOfPage": {
                "@@type": "WebPage"
                , "@@id": "{{ route('blogs.read', $popular->slug) }}"
            }
            , "headline": "{{ $popular->meta_title ?? $popular->title }}"
            , "description": "{{ $popular->meta_description ?? $popular->excerpt }}"
            , "image": "{{ $popular->featured_image ? asset('storage/' . $popular->featured_image) : asset('scalify-blog-default.webp') }}"
            , "author": {
                "@@type": "Organization"
                , "name": "Scalify Intelligence"
            }
            , "datePublished": "{{ $popular->published_at ? $popular->published_at->toIso8601String() : $popular->created_at->toIso8601String() }}"
        }

    </script>

    <a href="{{ route('blogs.read', $popular->slug) }}" class="block relative w-full h-[60vh] min-h-[450px] lg:h-[80vh] overflow-hidden group">

        {{-- Background Image --}}
        @if ($popular->featured_image)
        <img src="{{ asset('storage/' . $popular->featured_image) }}" class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 ease-out" alt="{{ $popular->title }}" fetchpriority="high" decoding="sync">
        @else
        <img src="{{ asset('scalify-blog-default.webp') }}" class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 ease-out" alt="{{ $popular->title }}" fetchpriority="high" decoding="sync">
        @endif

        {{-- Midnight Blue Gradient Overlay --}}
        <div class="absolute inset-0 bg-gradient-to-t from-[#0f172a] via-[#0f172a]/70 to-[#0f172a]/20 opacity-90 group-hover:opacity-100 transition-opacity duration-500">
        </div>

        {{-- Top Dynamic SEO Keywords Indicator --}}
        <div class="absolute top-6 left-6 right-6 md:top-8 md:left-8 lg:top-10 lg:left-12 z-30 flex items-center gap-3">
            <div class="bg-black/40 backdrop-blur-md border border-white/10 px-4 py-2 rounded-full flex items-center gap-2.5 shadow-lg overflow-hidden max-w-full">
                <div class="relative flex items-center justify-center w-3 h-3">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-1.5 w-1.5 bg-green-500"></span>
                </div>
                <span class="text-white/60 text-[10px] font-bold tracking-widest uppercase flex-shrink-0">
                    Live Search
                </span>
                <div class="h-4 w-px bg-white/20 mx-1"></div>

                @php
                // SEO Tags processing
                $seoTags = ['Teknologi', 'Inovasi', 'Digitalisasi'];
                if ($popular->tags) {
                if (is_array($popular->tags)) {
                $seoTags = array_merge($seoTags, $popular->tags);
                } else {
                $seoTags = array_merge($seoTags, explode(',', $popular->tags));
                }
                }
                if ($popular->category) {
                $seoTags[] = $popular->category->name;
                }
                $seoTags = array_values(array_unique(array_filter(array_map('trim', $seoTags))));
                @endphp

                <div class="relative h-[18px] min-w-[120px] sm:min-w-[200px] overflow-hidden flex items-center">
                    <div id="seo-ticker" class="text-green-400 text-xs sm:text-sm font-semibold whitespace-nowrap transition-all duration-500 transform translate-y-0">
                        {{ $seoTags[0] ?? 'Scalify Intelligence' }}
                    </div>
                </div>
            </div>

            {{-- Google Index Status --}}
            <div class="hidden sm:flex items-center gap-2 bg-white/10 backdrop-blur-md border border-white/5 px-3 py-1.5 rounded-full shadow-sm">
                <i class="fab fa-google text-white text-[10px]"></i>
                <span class="text-white text-[9px] font-bold tracking-wider uppercase">Indexed</span>
            </div>
        </div>

        {{-- Content --}}
        <div class="absolute inset-0 flex flex-col justify-end p-6 sm:p-8 md:p-12 lg:p-16">
            <div class="max-w-7xl mx-auto flex items-end justify-between w-full gap-6 lg:gap-12 pb-4 md:pb-8 relative z-20">
                <div class="text-white w-full max-w-4xl">
                    <div class="flex flex-wrap items-center gap-3 mb-4 sm:mb-6">
                        <span class="text-[11px] font-bold tracking-widest text-[#0f172a] uppercase bg-white px-3 py-1.5 rounded-full shadow-[0_0_15px_rgba(255,255,255,0.3)]">
                            <i class="fas fa-star text-[10px] mr-1 text-orange-500"></i> POPULER
                        </span>
                        @if ($popular->category)
                        <span class="text-[11px] font-bold tracking-wider text-white uppercase bg-white/10 backdrop-blur-md border border-white/20 px-3 py-1.5 rounded-full">
                            {{ $popular->category->name }}
                        </span>
                        @endif
                    </div>

                    <h4 class="font-display font-bold text-2xl md:text-3xl lg:text-4xl mb-4 sm:mb-6 text-white leading-[1.2] group-hover:text-blue-200 transition-colors duration-300 drop-shadow-md">
                        {{ $popular->title }}
                    </h4>

                    <p class="text-white/80 text-sm md:text-base lg:text-lg line-clamp-2 md:line-clamp-3 leading-relaxed font-medium drop-shadow max-w-3xl">
                        {{ $popular->excerpt }}
                    </p>

                    <div class="mt-6 flex items-center gap-4 text-xs font-semibold text-white/60 uppercase tracking-widest">
                        <span><i class="far fa-calendar-alt mr-1.5"></i> {{ $popular->published_at ? $popular->published_at->format('d M Y') : $popular->created_at->format('d M Y') }}</span>
                        <span class="w-1 h-1 rounded-full bg-white/30"></span>
                        <span><i class="far fa-clock mr-1.5"></i> {{ $popular->reading_time ?? '5' }} MIN READ</span>
                    </div>
                </div>

                {{-- Hover Discover Button --}}
                <div class="hidden md:flex flex-col items-center justify-center shrink-0 group-hover:scale-110 transition-transform duration-500">
                    <div class="w-16 h-16 lg:w-20 lg:h-20 rounded-full border border-white/30 bg-white/5 backdrop-blur-sm text-white flex items-center justify-center group-hover:bg-[#2563eb] group-hover:border-[#2563eb] group-hover:shadow-[0_0_30px_rgba(37,99,235,0.4)] transition-all duration-500 transform relative overflow-hidden">
                        <i class="fas fa-arrow-right text-xl lg:text-2xl relative z-10 group-hover:translate-x-1 transition-transform duration-300"></i>
                    </div>
                    <span class="mt-3 text-[10px] font-bold tracking-[0.2em] text-white/50 uppercase group-hover:text-white transition-colors duration-300">Read Article</span>
                </div>
            </div>
        </div>
    </a>
</section>

{{-- Script for SEO Ticker Animation --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const tags = @json($seoTags);
        const ticker = document.getElementById('seo-ticker');
        if (!ticker || tags.length <= 1) return;

        let currentIndex = 0;

        setInterval(() => {
            // Fade out up
            ticker.style.opacity = '0';
            ticker.style.transform = 'translateY(-10px)';

            setTimeout(() => {
                currentIndex = (currentIndex + 1) % tags.length;
                ticker.textContent = tags[currentIndex];

                // Reset to bottom to slide in up
                ticker.style.transition = 'none';
                ticker.style.transform = 'translateY(10px)';

                // Trigger reflow
                void ticker.offsetWidth;

                // Fade in up
                ticker.style.transition = 'all 0.5s ease';
                ticker.style.opacity = '1';
                ticker.style.transform = 'translateY(0)';
            }, 500);

        }, 3500);
    });

</script>
@endif

{{-- Daftar Artikel Grid --}}
<section class="bg-brand-dark text-white py-12 md:py-16 md:px-6 lg:px-8 relative z-20">
    <div class="max-w-7xl mx-auto">
        {{-- Semua blog --}}
        <div class="flex items-center justify-between mb-6 px-5 md:px-0">
            <h3 class="text-xl sm:text-2xl font-display font-bold text-white">Artikel Terkini</h3>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-y-8 sm:gap-6 mb-12">
            @forelse ($blogs as $blog)
            <a href="{{ route('blogs.read', $blog->slug) }}" class="bg-transparent sm:bg-brand-navy border-b sm:border border-white/10 sm:rounded-2xl overflow-hidden sm:shadow-xl hover:shadow-[0_8px_30px_rgba(37,99,235,0.15)] hover:border-brand-accent/30 sm:hover:-translate-y-1 transition-all duration-300 flex flex-col group pb-6 sm:pb-0 cursor-pointer">
                {{-- IMAGE --}}
                <div class="aspect-video w-screen relative left-1/2 -translate-x-1/2 sm:w-full sm:static sm:translate-x-0 bg-white/5 overflow-hidden sm:rounded-t-2xl mb-4 sm:mb-0">
                    @if ($blog->featured_image)
                    <img src="{{ asset('storage/' . $blog->featured_image) }}" class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 ease-out" alt="{{ $blog->title }}" loading="lazy" decoding="async">
                    @else
                    <img src="{{ asset('scalify-blog-default.webp') }}" class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 ease-out" alt="{{ $blog->title }}" loading="lazy" decoding="async">
                    @endif
                </div>

                {{-- CONTENT --}}
                <div class="px-5 sm:p-5 flex flex-col flex-1">
                    {{-- Category + Date & Reading Time --}}
                    <div class="flex items-center gap-2 mb-3 text-[10px] font-semibold tracking-widest text-slate-400 uppercase">
                        @if ($blog->category)
                        <span class="text-brand-accent bg-white/5 border border-brand-accent/20 px-2.5 py-1 rounded-md">
                            {{ $blog->category->name }}
                        </span>
                        @endif
                        <div class="flex items-center gap-2 ml-auto text-white/40">
                            <span><i class="far fa-clock"></i> {{ $blog->reading_time ?? '5' }} min</span>
                            <span class="w-1 h-1 rounded-full bg-white/20"></span>
                            <span>{{ $blog->published_at?->format('d M') ?? $blog->created_at->format('d M') }}</span>
                        </div>
                    </div>

                    {{-- Title --}}
                    <h3 class="font-display text-[15px] font-bold mb-2.5 text-white/95 leading-[1.4] group-hover:text-brand-accent transition-colors line-clamp-2">
                        {{ $blog->title }}</h3>

                    {{-- Excerpt --}}
                    <p class="text-white/60 text-[13px] mb-5 flex-1 line-clamp-2 leading-relaxed">
                        {{ $blog->excerpt }}
                    </p>

                    {{-- Read More --}}
                    <div class="text-white/80 text-[12px] font-semibold inline-flex items-center gap-1.5 group-hover:text-brand-accent transition-colors mt-auto">
                        Baca Selengkapnya <i class="fas fa-arrow-right text-[10px] group-hover:translate-x-1 transition-transform"></i>
                    </div>
                </div>
            </a>
            @empty
            <div class="col-span-full py-16 text-center bg-white/5 border border-white/10 rounded-3xl">
                <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-white/5 mb-4 group-hover:scale-110 transition-transform">
                    <i class="fas fa-newspaper text-3xl text-white/40"></i>
                </div>
                <h3 class="text-xl font-bold text-white mb-2">Belum Ada Artikel</h3>
                <p class="text-white/60">Koleksi artikel baru sedang kami siapkan. Tetap pantau ya!</p>
            </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        <div class="flex justify-center mt-8">
            {{ $blogs->links() }}
        </div>

    </div>
</section>
@endsection
