@extends('layouts.app')

@section('meta_tags')
<title>{{ $blog->meta_title ?? $blog->title }} — Scalify Intelligence</title>
<meta name="title" content="{{ $blog->meta_title ?? $blog->title }}" />
<meta name="description" content="{{ $blog->meta_description ?? $blog->excerpt ?? Str::limit(strip_tags($blog->content), 150) }}" />

@if($blog->tags)
@php
$tagsString = is_array($blog->tags) ? implode(', ', $blog->tags) : $blog->tags;
@endphp
<meta name="keywords" content="{{ $tagsString }}, automasi bisnis, kecerdasan buatan" />
@endif

<meta name="author" content="{{ $blog->author->name ?? 'Scalify Intelligence' }}" />
<meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1" />
<link rel="canonical" href="{{ url()->current() }}" />

{{-- Open Graph / Facebook --}}
<meta property="og:type" content="article" />
<meta property="og:url" content="{{ url()->current() }}" />
<meta property="og:title" content="{{ $blog->meta_title ?? $blog->title }}" />
<meta property="og:description" content="{{ $blog->meta_description ?? $blog->excerpt ?? Str::limit(strip_tags($blog->content), 150) }}" />
<meta property="og:image" content="{{ $blog->featured_image ? asset('storage/' . $blog->featured_image) : asset('og-image.png') }}" />
<meta property="article:published_time" content="{{ $blog->published_at ? $blog->published_at->toIso8601String() : $blog->created_at->toIso8601String() }}" />
<meta property="article:modified_time" content="{{ $blog->updated_at->toIso8601String() }}" />

{{-- Twitter --}}
<meta name="twitter:card" content="summary_large_image" />
<meta name="twitter:url" content="{{ url()->current() }}" />
<meta name="twitter:title" content="{{ $blog->meta_title ?? $blog->title }}" />
<meta name="twitter:description" content="{{ $blog->meta_description ?? $blog->excerpt ?? Str::limit(strip_tags($blog->content), 150) }}" />
<meta name="twitter:image" content="{{ $blog->featured_image ? asset('storage/' . $blog->featured_image) : asset('og-image.png') }}" />

{{-- Schema.org JSON-LD (Rahasia Google Rich Results) --}}
<script type="application/ld+json">
    {
        "@@context": "https://schema.org"
        , "@@type": "BlogPosting"
        , "mainEntityOfPage": {
            "@@type": "WebPage"
            , "@@id": "{{ url()->current() }}"
        }
        , "headline": "{{ $blog->meta_title ?? $blog->title }}"
        , "description": "{{ $blog->meta_description ?? $blog->excerpt ?? Str::limit(strip_tags($blog->content), 150) }}"
        , "image": "{{ $blog->featured_image ? asset('storage/' . $blog->featured_image) : asset('og-image.png') }}"
        , "author": {
            "@@type": "Person"
            , "name": "{{ $blog->author->name ?? 'Admin Scalify' }}"
        }
        , "publisher": {
            "@@type": "Organization"
            , "name": "Scalify Intelligence"
            , "logo": {
                "@@type": "ImageObject"
                , "url": "{{ asset('logo.png') }}"
            }
        }
        , "datePublished": "{{ $blog->published_at ? $blog->published_at->toIso8601String() : $blog->created_at->toIso8601String() }}"
        , "dateModified": "{{ $blog->updated_at->toIso8601String() }}"
    }

</script>
@endsection

@push('styles')
<style>
    .ql-content {
        color: #475569;
        line-height: 1.8;
        font-size: 1rem;
    }

    /* Alignment */
    .ql-content .ql-align-justify {
        text-align: justify;
    }

    .ql-content .ql-align-center {
        text-align: center;
    }

    .ql-content .ql-align-right {
        text-align: right;
    }

    .ql-content .ql-align-left {
        text-align: left;
    }

    /* Font sizes */
    .ql-content .ql-size-small {
        font-size: 0.875rem;
    }

    .ql-content .ql-size-large {
        font-size: 1.25rem;
    }

    .ql-content .ql-size-huge {
        font-size: 1.75rem;
    }

    /* Indents */
    .ql-content .ql-indent-1 {
        padding-left: 2rem;
    }

    .ql-content .ql-indent-2 {
        padding-left: 4rem;
    }

    .ql-content .ql-indent-3 {
        padding-left: 6rem;
    }

    .ql-content .ql-indent-4 {
        padding-left: 8rem;
    }

    .ql-content .ql-indent-5 {
        padding-left: 10rem;
    }

    /* Headings */
    .ql-content h1 {
        font-size: 2rem;
        font-weight: 700;
        color: #0f172a;
        margin: 2.5rem 0 1rem;
        line-height: 1.25;
    }

    .ql-content h2 {
        font-size: 1.6rem;
        font-weight: 700;
        color: #0f172a;
        margin: 2rem 0 0.875rem;
        line-height: 1.3;
    }

    .ql-content h3 {
        font-size: 1.3rem;
        font-weight: 600;
        color: #0f172a;
        margin: 1.75rem 0 0.75rem;
        line-height: 1.35;
    }

    .ql-content h4,
    .ql-content h5,
    .ql-content h6 {
        font-size: 1.1rem;
        font-weight: 600;
        color: #1e293b;
        margin: 1.5rem 0 0.5rem;
    }

    /* Paragraphs */
    .ql-content p {
        margin-bottom: 1.25rem;
    }

    /* Links */
    .ql-content a {
        color: #2563eb;
        font-weight: 600;
        border-bottom: 2px solid #bfdbfe;
        text-decoration: none;
        transition: border-color 0.2s, color 0.2s;
    }

    .ql-content a:hover {
        color: #93c5fd;
        border-color: #2563eb;
    }

    /* Bold / Italic */
    .ql-content strong {
        color: #0f172a;
        font-weight: 700;
    }

    .ql-content em {
        font-style: italic;
    }

    /* Lists */
    .ql-content ul {
        list-style-type: disc;
        padding-left: 1.5rem;
        margin-bottom: 1.25rem;
    }

    .ql-content ol {
        list-style-type: decimal;
        padding-left: 1.5rem;
        margin-bottom: 1.25rem;
    }

    .ql-content li {
        margin: 0.4rem 0;
    }

    /* Blockquote */
    .ql-content blockquote {
        border-left: 4px solid #2563eb;
        background: #f8fafc;
        padding: 1.25rem 1.5rem;
        border-radius: 0 0.5rem 0.5rem 0;
        color: #475569;
        margin: 2rem 0;
        font-style: italic;
    }

    /* Code */
    .ql-content code {
        background: #eff6ff;
        color: #2563eb;
        padding: 0.15rem 0.4rem;
        border-radius: 0.3rem;
        font-size: 0.875em;
        font-family: ui-monospace, monospace;
    }

    .ql-content pre {
        background: #0f172a;
        color: #e2e8f0;
        padding: 1.25rem 1.5rem;
        border-radius: 0.75rem;
        overflow-x: auto;
        margin: 1.5rem 0;
        font-size: 0.875rem;
        line-height: 1.7;
    }

    .ql-content pre code {
        background: transparent;
        color: inherit;
        padding: 0;
    }

    /* Images */
    .ql-content img {
        border-radius: 1rem;
        margin: 2rem auto;
        box-shadow: 0 2px 12px rgb(0, 0, 0, 0.07);
        max-width: 100%;
        display: block;
    }

    /* Horizontal rule */
    .ql-content hr {
        border: none;
        border-top: 1px solid #e2e8f0;
        margin: 2rem 0;
    }

</style>
@endpush

@section('content')
<div class="min-h-screen bg-brand-dark pt-28 pb-32">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Breadcrumb -->
        <div class="mb-8 flex items-center gap-3">
            <a href="{{ route('landing.blogs') }}" class="text-sm font-semibold text-white/60 hover:text-white transition-colors inline-flex items-center gap-2">
                <i class="fas fa-arrow-left"></i> Kembali ke Blog
            </a>
            <span class="text-white/30">/</span>
            <span class="px-3 py-1 bg-white/5 border border-white/10 text-brand-accent rounded-full text-[10px] font-bold tracking-widest uppercase">
                {{ $blog->category->name ?? 'Artikel' }}
            </span>
        </div>

        <div class="grid lg:grid-cols-12 gap-8 lg:gap-12">
            <!-- Main Content -->
            <div class="lg:col-span-8 min-w-0">
                <article class="bg-brand-dark md:bg-brand-navy border border-transparent md:border-white/10 md:rounded-3xl md:shadow-xl overflow-visible md:overflow-hidden relative">
                    <!-- Featured Image -->
                    <div class="aspect-video w-screen relative left-1/2 -translate-x-1/2 md:w-full md:static md:translate-x-0 overflow-hidden md:rounded-t-3xl">
                        @if ($blog->featured_image)
                        <img src="{{ asset('storage/' . $blog->featured_image) }}" alt="{{ $blog->title }}" class="w-full h-full object-cover">
                        @else
                        <img src="{{ asset('scalify-blog-default.webp') }}" alt="{{ $blog->title }}" class="w-full h-full object-cover">
                        @endif
                        <div class="absolute inset-0 bg-gradient-to-t from-brand-dark via-transparent to-transparent md:from-[#0f172a]/30"></div>
                    </div>

                    <div class="pt-6 pb-12 md:p-12 min-w-0">
                        <!-- Title -->
                        <h1 class="text-[22px] md:text-2xl font-display font-bold text-white mb-6 leading-[1.3] break-words">
                            {{ $blog->title }}
                        </h1>

                        <!-- Author & Meta -->
                        <div class="flex items-center justify-between pb-6 border-b border-white/5 mb-8">
                            <div class="flex items-center gap-3 min-w-0">
                                <div class="w-10 h-10 rounded-full bg-brand-accent flex items-center justify-center text-white font-bold text-sm shadow-md flex-shrink-0">
                                    {{ substr($blog->author->name ?? 'A', 0, 1) }}
                                </div>
                                <div class="min-w-0 flex flex-col justify-center">
                                    <p class="font-semibold text-white/90 text-[13px] leading-tight truncate">
                                        {{ $blog->author->name ?? 'Admin' }}
                                    </p>
                                    <p class="text-[11px] text-white/50 font-medium leading-tight truncate mt-0.5">
                                        {{ $blog->published_at?->format('d M Y') }} &bull; {{ $blog->reading_time ?? '5' }} min read
                                    </p>
                                </div>
                            </div>

                            <!-- Share Buttons -->
                            <div class="flex items-center gap-2 flex-shrink-0">
                                <button onclick="sharePost(this)" data-title="{{ $blog->title }}" data-text="{{ $blog->excerpt ?? Str::limit(strip_tags($blog->content), 100) }}" data-url="{{ url()->current() }}" class="w-8 h-8 flex-shrink-0 flex items-center justify-center bg-white/5 text-white/70 hover:bg-brand-accent hover:text-white rounded-full transition-all shadow-sm text-xs" title="Share">
                                    <i class="fas fa-share-nodes"></i>
                                </button>

                                <a href="https://t.me/share/url?url={{ urlencode(url()->current()) }}&text={{ urlencode($blog->title) }}" target="_blank" class="w-8 h-8 flex-shrink-0 flex items-center justify-center bg-white/5 text-[#229ED9] hover:bg-[#229ED9] hover:text-white rounded-full transition-all shadow-sm text-xs" title="Share to Telegram">
                                    <i class="fab fa-telegram-plane"></i>
                                </a>
                            </div>
                        </div>

                        <!-- Excerpt -->
                        @if ($blog->excerpt)
                        <p class="text-white/70 text-sm md:text-md leading-relaxed mb-8 font-medium italic border-l-4 border-brand-accent pl-6 bg-white/5 py-5 pr-5 rounded-r-xl">
                            {{ $blog->excerpt }}
                        </p>
                        @endif


                        <div class="quill-content max-w-none">
                            {!! $blog->content !!}
                        </div>

                        <style>
                            /* ═══ Quill Content Renderer ═══════════════════════════════════ */
                            .quill-content {
                                font-size: 16px;
                                line-height: 1.85;
                                color: rgba(255, 255, 255, 0.85);
                                font-weight: 400;
                                overflow-wrap: anywhere;
                                word-break: break-word;
                            }

                            /* Headings */
                            .quill-content h1 {
                                font-size: 2rem;
                                font-weight: 700;
                                color: #ffffff;
                                margin: 1.5rem 0 0.75rem;
                            }

                            .quill-content h2 {
                                font-size: 1.5rem;
                                font-weight: 700;
                                color: #ffffff;
                                margin: 1.5rem 0 0.75rem;
                                border-bottom: 2px solid rgba(255, 255, 255, 0.1);
                                padding-bottom: 0.4rem;
                            }

                            .quill-content h3 {
                                font-size: 1.25rem;
                                font-weight: 600;
                                color: #60a5fa;
                                margin: 1.25rem 0 0.5rem;
                            }

                            .quill-content h4,
                            .quill-content h5,
                            .quill-content h6 {
                                font-size: 1rem;
                                font-weight: 600;
                                color: rgba(255, 255, 255, 0.7);
                                margin: 1rem 0 0.4rem;
                            }

                            /* Paragraphs */
                            .quill-content p {
                                margin-bottom: 1rem;
                            }

                            .quill-content p:last-child {
                                margin-bottom: 0;
                            }

                            /* Bold / Italic / Underline / Strike */
                            .quill-content strong {
                                font-weight: 700;
                                color: #ffffff;
                            }

                            .quill-content em {
                                font-style: italic;
                            }

                            .quill-content u {
                                text-decoration: underline;
                            }

                            .quill-content s {
                                text-decoration: line-through;
                            }

                            /* Links */
                            .quill-content a {
                                color: #60a5fa;
                                text-decoration: underline;
                                transition: color .2s;
                            }

                            .quill-content a:hover {
                                color: #93c5fd;
                            }

                            /* Images - semua alignment dari Quill */
                            .quill-content img {
                                max-width: 100%;
                                height: auto;
                                border-radius: 12px;
                                box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
                                margin: 1rem 0;
                                display: block;
                            }

                            .quill-content .ql-align-center img,
                            .quill-content .ql-align-center {
                                text-align: center;
                            }

                            .quill-content .ql-align-right img,
                            .quill-content .ql-align-right {
                                text-align: right;
                            }

                            .quill-content .ql-align-left img,
                            .quill-content .ql-align-left {
                                text-align: left;
                            }

                            .quill-content .ql-align-justify {
                                text-align: justify;
                            }

                            /* Lists */
                            .quill-content ul {
                                list-style: disc;
                                padding-left: 1.75rem;
                                margin-bottom: 1rem;
                            }

                            .quill-content ol {
                                list-style: decimal;
                                padding-left: 1.75rem;
                                margin-bottom: 1rem;
                            }

                            .quill-content li {
                                margin-bottom: 0.35rem;
                                color: rgba(255, 255, 255, 0.7);
                            }

                            /* Indented list items (Quill uses data-indent) */
                            .quill-content li.ql-indent-1 {
                                padding-left: 1.5rem;
                            }

                            .quill-content li.ql-indent-2 {
                                padding-left: 3rem;
                            }

                            .quill-content li.ql-indent-3 {
                                padding-left: 4.5rem;
                            }

                            /* Blockquote */
                            .quill-content blockquote {
                                border-left: 4px solid #3b82f6;
                                background: rgba(255, 255, 255, 0.05);
                                color: rgba(255, 255, 255, 0.7);
                                padding: 1rem 1.25rem;
                                border-radius: 0 8px 8px 0;
                                margin: 1.25rem 0;
                                font-style: italic;
                            }

                            /* Code */
                            .quill-content code {
                                background: rgba(255, 255, 255, 0.1);
                                color: #60a5fa;
                                padding: 0.15rem 0.45rem;
                                border-radius: 4px;
                                font-size: 0.875em;
                                font-family: 'Fira Code', monospace;
                            }

                            .quill-content pre.ql-syntax {
                                background: #1e293b;
                                color: #e2e8f0;
                                padding: 1rem 1.25rem;
                                border-radius: 10px;
                                overflow-x: auto;
                                font-size: 0.875em;
                                line-height: 1.7;
                                margin: 1.25rem 0;
                            }

                            /* Video embed */
                            .quill-content .ql-video {
                                width: 100%;
                                aspect-ratio: 16/9;
                                border-radius: 12px;
                                border: none;
                                margin: 1rem 0;
                            }

                            /* Table */
                            .quill-content table {
                                width: 100%;
                                border-collapse: collapse;
                                margin: 1.25rem 0;
                            }

                            .quill-content table th {
                                background: rgba(255, 255, 255, 0.05);
                                color: #ffffff;
                                font-weight: 600;
                                padding: 0.75rem 1rem;
                                border: 1px solid rgba(255, 255, 255, 0.1);
                                text-align: left;
                            }

                            .quill-content table td {
                                padding: 0.65rem 1rem;
                                border: 1px solid rgba(255, 255, 255, 0.1);
                                color: rgba(255, 255, 255, 0.7);
                            }

                            .quill-content table tr:nth-child(even) td {
                                background: rgba(255, 255, 255, 0.02);
                            }

                            /* Subscript / Superscript */
                            .quill-content sub {
                                vertical-align: sub;
                                font-size: 0.75em;
                            }

                            .quill-content sup {
                                vertical-align: super;
                                font-size: 0.75em;
                            }

                        </style>

                        <!-- Tags -->
                        @if ($blog->tags)
                        <div class="mt-12 pt-8 border-t border-white/10">
                            <div class="flex flex-wrap gap-2">
                                @php
                                $tags = [];
                                if (is_array($blog->tags)) {
                                foreach ($blog->tags as $item) {
                                if (strpos($item, ',') !== false) {
                                $tags = array_merge($tags, explode(',', $item));
                                } else {
                                $tags[] = $item;
                                }
                                }
                                } else {
                                $tags = explode(',', $blog->tags);
                                }
                                $tags = array_filter(array_map('trim', $tags), fn($t) => $t !== '');
                                @endphp

                                @foreach ($tags as $tag)
                                <span class="px-4 py-1.5 bg-white/5 border border-white/10 text-white/70 rounded-full text-sm font-medium hover:bg-brand-accent hover:text-white transition-colors cursor-pointer">
                                    #{{ $tag }}
                                </span>
                                @endforeach
                            </div>
                        </div>
                        @endif

                        <!-- CTA Banner -->
                        @if($blog->businessCategory)
                        <div class="mt-12 bg-gradient-to-br from-blue-900 to-slate-900 rounded-3xl p-6 sm:p-10 shadow-2xl relative overflow-hidden text-center text-white border border-brand-accent/20">
                            <div class="absolute -right-12 -top-12 w-40 h-40 bg-white/100/30 rounded-full blur-3xl pointer-events-none"></div>
                            <div class="absolute -left-12 -bottom-12 w-40 h-40 bg-purple-500/30 rounded-full blur-3xl pointer-events-none"></div>

                            <h3 class="text-lg font-bold mb-3 relative z-10">Tertarik Membuat {{ $blog->businessCategory->name }}?</h3>
                            <p class="text-white/30 mb-6 max-w-lg mx-auto relative z-10 text-sm sm:text-base leading-relaxed">Konsultasikan kebutuhan digital Anda bersama tim profesional kami dan dapatkan penawaran spesial!</p>

                            @php
                            $waText = $blog->businessCategory->wa_template ?? "Halo, saya tertarik dengan layanan " . $blog->businessCategory->name;
                            if ($blog->affiliate_id && $blog->affiliate) {
                            $waText .= " (Ref: " . $blog->affiliate->affiliate_code . ")";
                            }
                            @endphp

                            <a href="https://wa.me/6285221694067?text={{ urlencode($waText) }}" target="_blank" class="inline-flex items-center justify-center gap-2 px-6 py-3.5 sm:px-8 bg-orange-500 hover:bg-orange-600 text-white font-bold rounded-xl shadow-[0_0_20px_rgba(249,115,22,0.4)] transition-all transform hover:scale-105 active:scale-95 relative z-10 text-sm sm:text-base">
                                <i class="fa-brands fa-whatsapp text-xl"></i> Konsultasi Gratis Sekarang
                            </a>
                        </div>
                        @endif
                    </div>
                </article>
            </div>

            <!-- Sidebar -->
            <aside class="lg:col-span-4">
                <div class="sticky top-28 space-y-8">
                    <!-- Recent Articles -->
                    <div class="bg-brand-navy border border-white/10 rounded-3xl shadow-xl p-6 sm:p-8">
                        <h3 class="text-lg font-display font-bold text-white mb-6 flex items-center gap-3">
                            <span class="w-1.5 h-6 bg-brand-accent rounded-full"></span>
                            Artikel Terkini
                        </h3>

                        <div class="space-y-6">
                            @if ($related->count())
                            @foreach ($related->take(5) as $item)
                            <a href="{{ route('blogs.read', $item->slug) }}" class="flex gap-4 group items-center">
                                <div class="w-24 h-20 flex-shrink-0 rounded-xl overflow-hidden shadow-sm">
                                    @if ($item->featured_image)
                                    <img src="{{ asset('storage/' . $item->featured_image) }}" alt="{{ $item->title }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                    @else
                                    <img src="{{ asset('scalify-blog-default.webp') }}" alt="{{ $item->title }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                    @endif
                                </div>

                                <div class="flex-1 min-w-0 py-1">
                                    <h4 class="font-display font-semibold text-[13px] text-white mb-1.5 line-clamp-2 group-hover:text-brand-accent transition-colors leading-snug">
                                        {{ $item->title }}
                                    </h4>
                                    <p class="text-[11px] font-semibold tracking-widest uppercase text-white/50">
                                        {{ $item->published_at?->format('d M Y') }}
                                    </p>
                                </div>
                            </a>
                            @endforeach
                            @else
                            <p class="text-sm text-white/60 italic">Belum ada artikel terkait.</p>
                            @endif
                        </div>

                        @if ($related->count())
                        <a href="{{ route('landing.blogs') }}" class="mt-8 block w-full text-center px-4 py-3 bg-white/10 text-white rounded-xl hover:bg-brand-accent transition-colors font-semibold text-sm">
                            Lihat Semua Artikel
                        </a>
                        @endif
                    </div>
                </div>
            </aside>
        </div>

        <!-- More Articles Section -->
        @if ($related->count() > 5)
        <div class="mt-20">
            <div class="flex items-center justify-between mb-8">
                <h2 class="text-xl md:text-2xl font-display font-bold text-white">
                    Baca Juga dari <span class="text-brand-accent">{{ $blog->category->name ?? 'Kategori Ini' }}</span>
                </h2>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach ($related->skip(5)->take(3) as $item)
                <div class="bg-white border border-white/10 text-white/80 rounded-2xl overflow-hidden shadow-[0_2px_15px_rgb(0,0,0,0.02)] hover:shadow-[0_8px_30px_rgb(0,0,0,0.06)] hover:-translate-y-1 transition-all duration-300 flex flex-col group">
                    <div class="aspect-video bg-white/5 relative overflow-hidden">
                        @if ($item->featured_image)
                        <img src="{{ asset('storage/' . $item->featured_image) }}" class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 ease-out">
                        @else
                        <img src="{{ asset('scalify-blog-default.webp') }}" class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 ease-out">
                        @endif
                    </div>

                    <div class="p-4 flex flex-col flex-1">
                        <div class="flex items-center gap-2 mb-2 text-[9px] font-semibold tracking-widest text-white/50 uppercase">
                            <span class="text-brand-accent bg-white/10 px-2 py-0.5 rounded-md">
                                {{ $item->category->name ?? 'Blog' }}
                            </span>
                        </div>

                        <h3 class="font-display text-[13px] font-semibold mb-1.5 text-white leading-snug group-hover:text-brand-accent transition-colors line-clamp-2">
                            {{ $item->title }}
                        </h3>

                        <p class="text-white/60 text-[11px] mb-4 flex-1 line-clamp-2 leading-relaxed">
                            {{ $item->excerpt }}
                        </p>

                        <a href="{{ route('blogs.read', $item->slug) }}" class="text-white text-xs font-semibold inline-flex items-center gap-1.5 hover:text-brand-accent transition-colors mt-auto group/btn">
                            Baca Selengkapnya <i class="fas fa-arrow-right text-[8px] group-hover/btn:translate-x-1 transition-transform"></i>
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Track affiliate CTA clicks from this blog
        document.querySelectorAll('a[href*="sobat-scalify?ref="]').forEach(function(link) {
            link.addEventListener('click', function(e) {
                navigator.sendBeacon("{{ url('/api/blogs/' . $blog->id . '/track-click') }}");
            });
        });
    });

    function sharePost(btn) {
        const title = btn.getAttribute('data-title');
        const text = btn.getAttribute('data-text');
        const url = btn.getAttribute('data-url');

        if (navigator.share) {
            navigator.share({
                title: title
                , text: text
                , url: url
            }).catch((error) => console.log('Error sharing', error));
        } else {
            // Fallback for browsers that don't support Web Share API
            navigator.clipboard.writeText(url).then(() => {
                alert('Link berhasil disalin ke clipboard! Anda bisa membagikannya secara manual.');
            }).catch(() => {
                alert('Gagal menyalin link.');
            });
        }
    }

</script>
@endsection
