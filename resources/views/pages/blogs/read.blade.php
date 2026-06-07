@extends('pages.layouts.app')

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
<meta name="robots" content="index, follow" />

{{-- Open Graph / Facebook --}}
<meta property="og:type" content="article" />
<meta property="og:url" content="{{ url()->current() }}" />
<meta property="og:title" content="{{ $blog->meta_title ?? $blog->title }}" />
<meta property="og:description" content="{{ $blog->meta_description ?? $blog->excerpt ?? Str::limit(strip_tags($blog->content), 150) }}" />
<meta property="og:image" content="{{ $blog->featured_image ? asset('storage/' . $blog->featured_image) : asset('og-image.png') }}" />

{{-- Twitter --}}
<meta name="twitter:card" content="summary_large_image" />
<meta name="twitter:url" content="{{ url()->current() }}" />
<meta name="twitter:title" content="{{ $blog->meta_title ?? $blog->title }}" />
<meta name="twitter:description" content="{{ $blog->meta_description ?? $blog->excerpt ?? Str::limit(strip_tags($blog->content), 150) }}" />
<meta name="twitter:image" content="{{ $blog->featured_image ? asset('storage/' . $blog->featured_image) : asset('og-image.png') }}" />
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
        color: #1e40af;
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
<div class="min-h-screen bg-slate-50 pt-24 pb-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Breadcrumb -->
        <div class="mb-8 flex items-center gap-3">
            <a href="{{ route('landing.blogs') }}" class="text-sm font-semibold text-slate-500 hover:text-blue-600 transition-colors inline-flex items-center gap-2">
                <i class="fas fa-arrow-left"></i> Kembali ke Blog
            </a>
            <span class="text-slate-300">/</span>
            <span class="px-3 py-1 bg-blue-50 text-blue-600 rounded-full text-[10px] font-bold tracking-widest uppercase">
                {{ $blog->category->name ?? 'Artikel' }}
            </span>
        </div>

        <div class="grid lg:grid-cols-12 gap-8 lg:gap-12">
            <!-- Main Content -->
            <div class="lg:col-span-8">
                <article class="bg-white rounded-3xl shadow-[0_4px_20px_rgb(0,0,0,0.03)] overflow-hidden">
                    <!-- Featured Image -->
                    @if ($blog->featured_image)
                    <div class="aspect-video w-full overflow-hidden relative">
                        <img src="{{ asset('storage/' . $blog->featured_image) }}" alt="{{ $blog->title }}" class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-gradient-to-t from-[#0f172a]/30 to-transparent"></div>
                    </div>
                    @endif

                    <div class="p-6 sm:p-8 md:p-12">
                        <!-- Title -->
                        <h1 class="text-xl md:text-2xl font-display font-bold text-slate-900 mb-6 leading-tight">
                            {{ $blog->title }}
                        </h1>

                        <!-- Author & Meta -->
                        <div class="flex items-center justify-between flex-wrap gap-4 pb-8 border-b border-slate-100 mb-8">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-full bg-[#0f172a] flex items-center justify-center text-white font-bold text-lg shadow-md">
                                    {{ substr($blog->author->name ?? 'A', 0, 1) }}
                                </div>
                                <div>
                                    <p class="font-semibold text-slate-900 text-base">
                                        {{ $blog->author->name ?? 'Admin' }}
                                    </p>
                                    <p class="text-sm text-slate-500 font-medium">
                                        {{ $blog->published_at?->format('d M Y') }} &bull;
                                        {{ $blog->reading_time ?? '5' }} min read
                                    </p>
                                </div>
                            </div>

                            <!-- Share Buttons -->
                            <div class="flex items-center gap-2">
                                <button class="w-10 h-10 flex items-center justify-center bg-slate-50 text-slate-600 hover:bg-[#0f172a] hover:text-white rounded-full transition-all shadow-sm" title="Share">
                                    <i class="fas fa-share-nodes"></i>
                                </button>
                                <button class="w-10 h-10 flex items-center justify-center bg-slate-50 text-slate-600 hover:bg-[#0f172a] hover:text-white rounded-full transition-all shadow-sm" title="Bookmark">
                                    <i class="far fa-bookmark"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Excerpt -->
                        @if ($blog->excerpt)
                        <p class="text-slate-600 text-sm md:text-md leading-relaxed mb-8 font-medium italic border-l-4 border-blue-500 pl-6 bg-slate-50 py-5 pr-5 rounded-r-xl">
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
                                line-height: 1.8;
                                color: #374151;
                            }

                            /* Headings */
                            .quill-content h1 {
                                font-size: 2rem;
                                font-weight: 700;
                                color: #111827;
                                margin: 1.5rem 0 0.75rem;
                            }

                            .quill-content h2 {
                                font-size: 1.5rem;
                                font-weight: 700;
                                color: #111827;
                                margin: 1.5rem 0 0.75rem;
                                border-bottom: 2px solid #e5e7eb;
                                padding-bottom: 0.4rem;
                            }

                            .quill-content h3 {
                                font-size: 1.25rem;
                                font-weight: 600;
                                color: #1e3a8a;
                                margin: 1.25rem 0 0.5rem;
                            }

                            .quill-content h4,
                            .quill-content h5,
                            .quill-content h6 {
                                font-size: 1rem;
                                font-weight: 600;
                                color: #374151;
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
                                color: #111827;
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
                                color: #1e3a8a;
                                text-decoration: underline;
                                transition: color .2s;
                            }

                            .quill-content a:hover {
                                color: #1e40af;
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
                                color: #374151;
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
                                border-left: 4px solid #1e3a8a;
                                background: #f0f4ff;
                                color: #374151;
                                padding: 1rem 1.25rem;
                                border-radius: 0 8px 8px 0;
                                margin: 1.25rem 0;
                                font-style: italic;
                            }

                            /* Code */
                            .quill-content code {
                                background: #f3f4f6;
                                color: #1e3a8a;
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
                                background: #f0f4ff;
                                color: #111827;
                                font-weight: 600;
                                padding: 0.75rem 1rem;
                                border: 1px solid #e5e7eb;
                                text-align: left;
                            }

                            .quill-content table td {
                                padding: 0.65rem 1rem;
                                border: 1px solid #e5e7eb;
                                color: #374151;
                            }

                            .quill-content table tr:nth-child(even) td {
                                background: #f9fafb;
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
                        <div class="mt-12 pt-8 border-t border-slate-100">
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
                                <span class="px-4 py-1.5 bg-slate-50 border border-slate-100 text-slate-600 rounded-full text-sm font-medium hover:bg-[#0f172a] hover:text-white transition-colors cursor-pointer">
                                    #{{ $tag }}
                                </span>
                                @endforeach
                            </div>
                        </div>
                        @endif
                    </div>
                </article>
            </div>

            <!-- Sidebar -->
            <aside class="lg:col-span-4">
                <div class="sticky top-28 space-y-8">
                    <!-- Recent Articles -->
                    <div class="bg-white rounded-3xl shadow-[0_4px_20px_rgb(0,0,0,0.03)] p-6 sm:p-8">
                        <h3 class="text-xl font-display font-bold text-slate-900 mb-6 flex items-center gap-3">
                            <span class="w-1.5 h-6 bg-blue-600 rounded-full"></span>
                            Artikel Terkini
                        </h3>

                        <div class="space-y-6">
                            @if ($related->count())
                            @foreach ($related->take(5) as $item)
                            <a href="{{ route('blogs.read', $item->slug) }}" class="flex gap-4 group items-center">
                                @if ($item->featured_image)
                                <div class="w-24 h-20 flex-shrink-0 rounded-xl overflow-hidden shadow-sm">
                                    <img src="{{ asset('storage/' . $item->featured_image) }}" alt="{{ $item->title }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                </div>
                                @else
                                <div class="w-24 h-20 flex-shrink-0 rounded-xl bg-slate-100 flex items-center justify-center">
                                    <i class="fas fa-image text-slate-300"></i>
                                </div>
                                @endif

                                <div class="flex-1 min-w-0 py-1">
                                    <h4 class="font-display font-semibold text-[15px] text-slate-900 mb-1.5 line-clamp-2 group-hover:text-blue-600 transition-colors leading-snug">
                                        {{ $item->title }}
                                    </h4>
                                    <p class="text-[11px] font-semibold tracking-widest uppercase text-slate-400">
                                        {{ $item->published_at?->format('d M Y') }}
                                    </p>
                                </div>
                            </a>
                            @endforeach
                            @else
                            <p class="text-sm text-slate-500 italic">Belum ada artikel terkait.</p>
                            @endif
                        </div>

                        @if ($related->count())
                        <a href="{{ route('landing.blogs') }}" class="mt-8 block w-full text-center px-4 py-3 bg-slate-900 text-white rounded-xl hover:bg-blue-600 transition-colors font-semibold text-sm">
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
                <h2 class="text-2xl md:text-3xl font-display font-bold text-slate-900">
                    Baca Juga dari <span class="text-blue-600">{{ $blog->category->name ?? 'Kategori Ini' }}</span>
                </h2>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach ($related->skip(5)->take(3) as $item)
                <div class="bg-white border border-slate-100 text-slate-800 rounded-2xl overflow-hidden shadow-[0_2px_15px_rgb(0,0,0,0.02)] hover:shadow-[0_8px_30px_rgb(0,0,0,0.06)] hover:-translate-y-1 transition-all duration-300 flex flex-col group">
                    <div class="aspect-video bg-slate-50 relative overflow-hidden">
                        @if ($item->featured_image)
                        <img src="{{ asset('storage/' . $item->featured_image) }}" class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 ease-out">
                        @else
                        <div class="absolute inset-0 flex items-center justify-center">
                            <i class="fas fa-image text-3xl text-slate-200"></i>
                        </div>
                        @endif
                    </div>

                    <div class="p-4 flex flex-col flex-1">
                        <div class="flex items-center gap-2 mb-2 text-[9px] font-semibold tracking-widest text-slate-400 uppercase">
                            <span class="text-blue-500 bg-blue-50 px-2 py-0.5 rounded-md">
                                {{ $item->category->name ?? 'Blog' }}
                            </span>
                        </div>

                        <h3 class="font-display text-sm font-semibold mb-1.5 text-slate-900 leading-snug group-hover:text-blue-600 transition-colors line-clamp-2">
                            {{ $item->title }}
                        </h3>

                        <p class="text-slate-500 text-xs mb-4 flex-1 line-clamp-2 leading-relaxed">
                            {{ $item->excerpt }}
                        </p>

                        <a href="{{ route('blogs.read', $item->slug) }}" class="text-slate-900 text-xs font-semibold inline-flex items-center gap-1.5 hover:text-blue-600 transition-colors mt-auto group/btn">
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
@endsection
