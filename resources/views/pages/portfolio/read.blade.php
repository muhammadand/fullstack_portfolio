@extends('layouts.app')

@section('meta_tags')
<title>{{ $portfolio->title }} — Portfolio Scalify Intelligence</title>
<meta name="title" content="{{ $portfolio->title }}" />
<meta name="description" content="{{ $portfolio->excerpt ?? Str::limit(strip_tags($portfolio->full_description), 150) }}" />

@if($portfolio->technologies)
@php
$techs = is_array($portfolio->technologies) ? implode(', ', $portfolio->technologies) : $portfolio->technologies;
@endphp
<meta name="keywords" content="{{ $techs }}, portfolio bisnis, automasi bisnis, kecerdasan buatan" />
@endif

<meta name="author" content="Scalify Intelligence" />
<meta name="robots" content="index, follow" />

{{-- Open Graph / Facebook --}}
<meta property="og:type" content="article" />
<meta property="og:url" content="{{ url()->current() }}" />
<meta property="og:title" content="{{ $portfolio->title }}" />
<meta property="og:description" content="{{ $portfolio->excerpt ?? Str::limit(strip_tags($portfolio->full_description), 150) }}" />
<meta property="og:image" content="{{ $portfolio->thumbnail_image ? asset('storage/' . $portfolio->thumbnail_image) : asset('og-image.png') }}" />

{{-- Twitter --}}
<meta name="twitter:card" content="summary_large_image" />
<meta name="twitter:url" content="{{ url()->current() }}" />
<meta name="twitter:title" content="{{ $portfolio->title }}" />
<meta name="twitter:description" content="{{ $portfolio->excerpt ?? Str::limit(strip_tags($portfolio->full_description), 150) }}" />
<meta name="twitter:image" content="{{ $portfolio->thumbnail_image ? asset('storage/' . $portfolio->thumbnail_image) : asset('og-image.png') }}" />
@endsection

@section('content')
<!-- Hero Section - Midnight Blue Theme -->
<div class="relative h-[70vh] overflow-hidden">
    <img src="{{ asset('storage/' . $portfolio->thumbnail_image) }}" alt="{{ $portfolio->title }}" class="w-full h-full object-cover">

    <!-- Midnight Blue Gradient Overlay -->
    <div class="absolute inset-0 bg-gradient-to-t from-[#0a0f2e] via-[#0d1547]/80 to-[#1a237e]/30"></div>
    <!-- Side vignette for depth -->
    <div class="absolute inset-0 bg-gradient-to-r from-[#0a0f2e]/60 via-transparent to-[#0a0f2e]/40"></div>

    <!-- Title Content -->
    <div class="absolute bottom-0 left-0 right-0">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 pb-12">
            <div class="max-w-4xl">
                <!-- Tech Badges -->
                @if ($portfolio->technologies && count($portfolio->technologies))
                <div class="flex flex-wrap gap-2 mb-4">
                    @foreach ($portfolio->technologies as $tech)
                    <span class="px-3 py-1 text-xs font-semibold rounded-full bg-[#1e3a8a]/70 text-blue-200 uppercase tracking-widest border border-blue-400/30 backdrop-blur-sm">
                        {{ $tech }}
                    </span>
                    @endforeach
                </div>
                @endif

                <h1 class="text-2xl md:text-3xl lg:text-4xl font-bold text-white mb-4 leading-tight drop-shadow-lg">
                    {{ $portfolio->title }}
                </h1>

                <!-- Meta Info -->
                <div class="flex flex-wrap gap-6 text-blue-100/90">
                    @if ($portfolio->client_name)
                    <div class="flex items-center gap-2">
                        <i class="fas fa-user text-blue-400"></i>
                        <span>{{ $portfolio->client_name }}</span>
                    </div>
                    @endif
                    @if ($portfolio->project_type)
                    <div class="flex items-center gap-2">
                        <i class="fas fa-folder text-blue-400"></i>
                        <span>{{ $portfolio->project_type }}</span>
                    </div>
                    @endif
                    @if ($portfolio->completion_date)
                    <div class="flex items-center gap-2">
                        <i class="fas fa-calendar text-blue-400"></i>
                        <span>{{ $portfolio->completion_date->format('d M Y') }}</span>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Main Content - White Background -->
<div class="bg-white">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="max-w-6xl mx-auto">

            <!-- Action Buttons -->
            <div class="flex flex-wrap gap-4 mb-12">
                @if ($portfolio->project_url)
                <a href="{{ $portfolio->project_url }}" target="_blank" class="inline-flex items-center gap-2 bg-[#1e3a8a] text-white px-6 py-3 rounded-full hover:bg-[#1e40af] transition-all duration-300 font-semibold shadow-lg hover:shadow-xl hover:-translate-y-1">
                    <i class="fas fa-external-link-alt"></i>
                    Visit Live Project
                </a>
                @endif
                @if ($portfolio->github_url)
                <a href="{{ $portfolio->github_url }}" target="_blank" class="inline-flex items-center gap-2 bg-gray-900 text-white px-6 py-3 rounded-full hover:bg-gray-800 transition-all duration-300 font-semibold shadow-lg hover:shadow-xl hover:-translate-y-1">
                    <i class="fab fa-github"></i>ß
                    View on Github
                </a>
                @endif
            </div>

            <!-- Project Description - WYSIWYG Rendered -->
            <div class="quill-content mb-12">
                {!! $portfolio->full_description !!}
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

            <!-- Challenge, Solution, Result Cards -->
            @if ($portfolio->challenge || $portfolio->solution || $portfolio->result)
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-16">
                @if ($portfolio->challenge)
                <div class="bg-gradient-to-br from-red-50 to-orange-50 p-8 rounded-2xl shadow-md hover:shadow-xl transition-all duration-300 border border-red-100">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-12 h-12 bg-red-500 rounded-full flex items-center justify-center text-white">
                            <i class="fas fa-exclamation-triangle text-xl"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900">Challenge</h3>
                    </div>
                    <p class="text-gray-700 leading-relaxed whitespace-pre-line">{{ $portfolio->challenge }}
                    </p>
                </div>
                @endif

                @if ($portfolio->solution)
                <div class="bg-gradient-to-br from-blue-50 to-indigo-50 p-8 rounded-2xl shadow-md hover:shadow-xl transition-all duration-300 border border-blue-100">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-12 h-12 bg-[#1e3a8a] rounded-full flex items-center justify-center text-white">
                            <i class="fas fa-lightbulb text-xl"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900">Solution</h3>
                    </div>
                    <p class="text-gray-700 leading-relaxed whitespace-pre-line">{{ $portfolio->solution }}</p>
                </div>
                @endif

                @if ($portfolio->result)
                <div class="bg-gradient-to-br from-green-50 to-emerald-50 p-8 rounded-2xl shadow-md hover:shadow-xl transition-all duration-300 border border-green-100">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-12 h-12 bg-green-500 rounded-full flex items-center justify-center text-white">
                            <i class="fas fa-check-circle text-xl"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900">Result</h3>
                    </div>
                    <p class="text-gray-700 leading-relaxed whitespace-pre-line">{{ $portfolio->result }}</p>
                </div>
                @endif
            </div>
            @endif

        </div>
    </div>
</div>

<!-- Popular Portfolio Section -->
@if ($popularPortfolios && count($popularPortfolios) > 0)
<div class="bg-gradient-to-b from-gray-50 to-white py-16">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                    Explore More Projects
                </h2>
                <p class="text-gray-600 text-lg">Check out our other amazing work</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach ($popularPortfolios as $popular)
                <a href="{{ route('portfolio.read', $popular->slug) }}" class="group relative rounded-2xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-300 hover:-translate-y-2">

                    <!-- Image -->
                    <div class="relative h-64 overflow-hidden">
                        <img src="{{ asset('storage/' . $popular->thumbnail_image) }}" alt="{{ $popular->title }}" class="w-full h-full object-cover transition-all duration-700 group-hover:scale-110">

                        <!-- Overlay - Midnight Blue tint -->
                        <div class="absolute inset-0 bg-gradient-to-t from-[#0a0f2e]/90 via-[#0d1547]/50 to-transparent">
                        </div>

                        <!-- Content -->
                        <div class="absolute bottom-0 left-0 right-0 p-5">
                            <h3 class="text-xl font-bold text-white mb-2 group-hover:text-blue-300 transition-colors">
                                {{ $popular->title }}
                            </h3>
                            <div class="flex items-center gap-2 text-white/80 text-sm">
                                <i class="fas fa-eye"></i>
                                <span>{{ $popular->view_count }} views</span>
                            </div>
                        </div>

                        <!-- Hover Effect - midnight blue tint -->
                        <div class="absolute inset-0 bg-[#1e3a8a]/0 group-hover:bg-[#1e3a8a]/20 transition-all duration-300">
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endif

<!-- Back to Portfolio Button -->
<div class="bg-white container mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="max-w-6xl mx-auto text-center">
        <a href="{{ route('landing.portfolio') }}" class="inline-flex items-center gap-2 text-[#1e3a8a] font-semibold hover:gap-3 transition-all duration-300 text-lg">
            <i class="fas fa-arrow-left"></i>
            Back to All Projects
        </a>
    </div>
</div>

@endsection
