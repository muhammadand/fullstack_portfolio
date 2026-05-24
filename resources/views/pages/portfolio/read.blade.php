@extends('layouts.app')

@section('title', $portfolio->title)

@section('content')
    <!-- Hero Section - Midnight Blue Theme -->
    <div class="relative h-[70vh] overflow-hidden">
        <img src="{{ asset('storage/' . $portfolio->thumbnail_image) }}" alt="{{ $portfolio->title }}"
            class="w-full h-full object-cover">

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
                                <span
                                    class="px-3 py-1 text-xs font-semibold rounded-full bg-[#1e3a8a]/70 text-blue-200 uppercase tracking-widest border border-blue-400/30 backdrop-blur-sm">
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
                        <a href="{{ $portfolio->project_url }}" target="_blank"
                            class="inline-flex items-center gap-2 bg-[#1e3a8a] text-white px-6 py-3 rounded-full hover:bg-[#1e40af] transition-all duration-300 font-semibold shadow-lg hover:shadow-xl hover:-translate-y-1">
                            <i class="fas fa-external-link-alt"></i>
                            Visit Live Project
                        </a>
                    @endif
                    @if ($portfolio->github_url)
                        <a href="{{ $portfolio->github_url }}" target="_blank"
                            class="inline-flex items-center gap-2 bg-gray-900 text-white px-6 py-3 rounded-full hover:bg-gray-800 transition-all duration-300 font-semibold shadow-lg hover:shadow-xl hover:-translate-y-1">
                            <i class="fab fa-github"></i>ß
                            View on Github
                        </a>
                    @endif
                </div>

                <!-- Project Description - WYSIWYG Rendered -->
                <div
                    class="prose prose-blue max-w-none text-gray-700
                        prose-headings:text-gray-900 prose-headings:font-bold
                        prose-h1:text-3xl prose-h2:text-2xl prose-h3:text-xl
                        prose-p:leading-relaxed prose-p:mb-4
                        prose-ul:list-disc prose-ul:pl-6 prose-ul:space-y-1
                        prose-ol:list-decimal prose-ol:pl-6 prose-ol:space-y-1
                        prose-li:text-gray-700
                        prose-strong:text-gray-900 prose-strong:font-semibold
                        prose-em:italic
                        prose-blockquote:border-l-4 prose-blockquote:border-[#1e3a8a] prose-blockquote:pl-4 prose-blockquote:italic prose-blockquote:text-gray-600
                        prose-a:text-[#1e3a8a] prose-a:underline hover:prose-a:text-[#1e40af]
                        prose-img:rounded-xl prose-img:shadow-md
                        prose-table:w-full prose-th:bg-[#f0f4ff] prose-th:text-gray-800 prose-td:border prose-td:border-gray-200 prose-td:px-4 prose-td:py-2
                        prose-code:bg-gray-100 prose-code:px-1.5 prose-code:py-0.5 prose-code:rounded prose-code:text-sm prose-code:text-[#1e3a8a]
                        prose-pre:bg-gray-900 prose-pre:text-gray-100 prose-pre:rounded-xl prose-pre:p-4 prose-pre:overflow-x-auto">
                    {!! $portfolio->full_description !!}
                </div>
                <br>

                <!-- Challenge, Solution, Result Cards -->
                @if ($portfolio->challenge || $portfolio->solution || $portfolio->result)
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-16">
                        @if ($portfolio->challenge)
                            <div
                                class="bg-gradient-to-br from-red-50 to-orange-50 p-8 rounded-2xl shadow-md hover:shadow-xl transition-all duration-300 border border-red-100">
                                <div class="flex items-center gap-3 mb-4">
                                    <div
                                        class="w-12 h-12 bg-red-500 rounded-full flex items-center justify-center text-white">
                                        <i class="fas fa-exclamation-triangle text-xl"></i>
                                    </div>
                                    <h3 class="text-xl font-bold text-gray-900">Challenge</h3>
                                </div>
                                <p class="text-gray-700 leading-relaxed whitespace-pre-line">{{ $portfolio->challenge }}
                                </p>
                            </div>
                        @endif

                        @if ($portfolio->solution)
                            <div
                                class="bg-gradient-to-br from-blue-50 to-indigo-50 p-8 rounded-2xl shadow-md hover:shadow-xl transition-all duration-300 border border-blue-100">
                                <div class="flex items-center gap-3 mb-4">
                                    <div
                                        class="w-12 h-12 bg-[#1e3a8a] rounded-full flex items-center justify-center text-white">
                                        <i class="fas fa-lightbulb text-xl"></i>
                                    </div>
                                    <h3 class="text-xl font-bold text-gray-900">Solution</h3>
                                </div>
                                <p class="text-gray-700 leading-relaxed whitespace-pre-line">{{ $portfolio->solution }}</p>
                            </div>
                        @endif

                        @if ($portfolio->result)
                            <div
                                class="bg-gradient-to-br from-green-50 to-emerald-50 p-8 rounded-2xl shadow-md hover:shadow-xl transition-all duration-300 border border-green-100">
                                <div class="flex items-center gap-3 mb-4">
                                    <div
                                        class="w-12 h-12 bg-green-500 rounded-full flex items-center justify-center text-white">
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
                            <a href="{{ route('portfolio.read', $popular->slug) }}"
                                class="group relative rounded-2xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-300 hover:-translate-y-2">

                                <!-- Image -->
                                <div class="relative h-64 overflow-hidden">
                                    <img src="{{ asset('storage/' . $popular->thumbnail_image) }}"
                                        alt="{{ $popular->title }}"
                                        class="w-full h-full object-cover transition-all duration-700 group-hover:scale-110">

                                    <!-- Overlay - Midnight Blue tint -->
                                    <div
                                        class="absolute inset-0 bg-gradient-to-t from-[#0a0f2e]/90 via-[#0d1547]/50 to-transparent">
                                    </div>

                                    <!-- Content -->
                                    <div class="absolute bottom-0 left-0 right-0 p-5">
                                        <h3
                                            class="text-xl font-bold text-white mb-2 group-hover:text-blue-300 transition-colors">
                                            {{ $popular->title }}
                                        </h3>
                                        <div class="flex items-center gap-2 text-white/80 text-sm">
                                            <i class="fas fa-eye"></i>
                                            <span>{{ $popular->view_count }} views</span>
                                        </div>
                                    </div>

                                    <!-- Hover Effect - midnight blue tint -->
                                    <div
                                        class="absolute inset-0 bg-[#1e3a8a]/0 group-hover:bg-[#1e3a8a]/20 transition-all duration-300">
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
            <a href="{{ route('landing.portfolio') }}"
                class="inline-flex items-center gap-2 text-[#1e3a8a] font-semibold hover:gap-3 transition-all duration-300 text-lg">
                <i class="fas fa-arrow-left"></i>
                Back to All Projects
            </a>
        </div>
    </div>

@endsection
