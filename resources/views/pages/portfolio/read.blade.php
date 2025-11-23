@extends('pages.layouts.app')

@section('title', $portfolio->title)

@section('content')
<!-- Hero Section with Image -->
<div class="relative h-[70vh] overflow-hidden">
    @if($portfolio->featured_image)
        <img src="{{ asset('storage/' . $portfolio->featured_image) }}" 
             alt="{{ $portfolio->title }}" 
             class="w-full h-full object-cover">
    @else
        <img src="{{ asset('storage/' . $portfolio->thumbnail_image) }}" 
             alt="{{ $portfolio->title }}" 
             class="w-full h-full object-cover">
    @endif
    
    <!-- Gradient Overlay -->
    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/50 to-transparent"></div>
    
    <!-- Title Content -->
    <div class="absolute bottom-0 left-0 right-0">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 pb-12">
            <div class="max-w-4xl">
                <!-- Tech Badges -->
                @if($portfolio->technologies && count($portfolio->technologies))
                    <div class="flex flex-wrap gap-2 mb-4">
                        @foreach($portfolio->technologies as $tech)
                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-purple-600/80 text-white uppercase tracking-wide backdrop-blur-sm">
                                {{ $tech }}
                            </span>
                        @endforeach
                    </div>
                @endif
                
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-white mb-4 leading-tight">
                    {{ $portfolio->title }}
                </h1>
                
                <!-- Meta Info -->
                <div class="flex flex-wrap gap-6 text-white/90">
                    @if($portfolio->client_name)
                        <div class="flex items-center gap-2">
                            <i class="fas fa-user text-purple-400"></i>
                            <span>{{ $portfolio->client_name }}</span>
                        </div>
                    @endif
                    @if($portfolio->project_type)
                        <div class="flex items-center gap-2">
                            <i class="fas fa-folder text-purple-400"></i>
                            <span>{{ $portfolio->project_type }}</span>
                        </div>
                    @endif
                    @if($portfolio->completion_date)
                        <div class="flex items-center gap-2">
                            <i class="fas fa-calendar text-purple-400"></i>
                            <span>{{ $portfolio->completion_date->format('d M Y') }}</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Main Content -->
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="max-w-6xl mx-auto">
        
        <!-- Action Buttons -->
        <div class="flex flex-wrap gap-4 mb-12">
            @if($portfolio->project_url)
                <a href="{{ $portfolio->project_url }}" 
                   target="_blank" 
                   class="inline-flex items-center gap-2 bg-purple-600 text-white px-6 py-3 rounded-full hover:bg-purple-700 transition-all duration-300 font-semibold shadow-lg hover:shadow-xl hover:-translate-y-1">
                    <i class="fas fa-external-link-alt"></i>
                    Visit Live Project
                </a>
            @endif
            @if($portfolio->github_url)
                <a href="{{ $portfolio->github_url }}" 
                   target="_blank" 
                   class="inline-flex items-center gap-2 bg-gray-900 text-white px-6 py-3 rounded-full hover:bg-gray-800 transition-all duration-300 font-semibold shadow-lg hover:shadow-xl hover:-translate-y-1">
                    <i class="fab fa-github"></i>
                    View on Github
                </a>
            @endif
        </div>

        <!-- Project Description -->
        <div class="mb-16">
            <h2 class="text-3xl font-bold text-gray-900 mb-6 flex items-center gap-3">
                <span class="w-1 h-8 bg-purple-600 rounded-full"></span>
                Project Overview
            </h2>
            <div class="prose prose-lg max-w-none text-gray-700 leading-relaxed">
                <p class="whitespace-pre-line">{{ $portfolio->full_description }}</p>
            </div>
        </div>

        <!-- Challenge, Solution, Result Cards -->
        @if($portfolio->challenge || $portfolio->solution || $portfolio->result)
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-16">
                @if($portfolio->challenge)
                    <div class="bg-gradient-to-br from-red-50 to-orange-50 p-8 rounded-2xl shadow-md hover:shadow-xl transition-all duration-300 border border-red-100">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-12 h-12 bg-red-500 rounded-full flex items-center justify-center text-white">
                                <i class="fas fa-exclamation-triangle text-xl"></i>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900">Challenge</h3>
                        </div>
                        <p class="text-gray-700 leading-relaxed whitespace-pre-line">{{ $portfolio->challenge }}</p>
                    </div>
                @endif

                @if($portfolio->solution)
                    <div class="bg-gradient-to-br from-blue-50 to-indigo-50 p-8 rounded-2xl shadow-md hover:shadow-xl transition-all duration-300 border border-blue-100">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-12 h-12 bg-blue-500 rounded-full flex items-center justify-center text-white">
                                <i class="fas fa-lightbulb text-xl"></i>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900">Solution</h3>
                        </div>
                        <p class="text-gray-700 leading-relaxed whitespace-pre-line">{{ $portfolio->solution }}</p>
                    </div>
                @endif

                @if($portfolio->result)
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

<!-- Popular Portfolio Section -->
@if($popularPortfolios && count($popularPortfolios) > 0)
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
                    @foreach($popularPortfolios as $popular)
                        <a href="{{ route('portfolio.read', $popular->slug) }}" 
                           class="group relative rounded-2xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-300 hover:-translate-y-2">
                            
                            <!-- Image -->
                            <div class="relative h-64 overflow-hidden">
                                <img src="{{ asset('storage/' . $popular->thumbnail_image) }}" 
                                     alt="{{ $popular->title }}" 
                                     class="w-full h-full object-cover transition-all duration-700 group-hover:scale-110">
                                
                                <!-- Overlay -->
                                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent"></div>
                                
                                <!-- Content -->
                                <div class="absolute bottom-0 left-0 right-0 p-5">
                                    <h3 class="text-xl font-bold text-white mb-2 group-hover:text-purple-300 transition-colors">
                                        {{ $popular->title }}
                                    </h3>
                                    <div class="flex items-center gap-2 text-white/80 text-sm">
                                        <i class="fas fa-eye"></i>
                                        <span>{{ $popular->view_count }} views</span>
                                    </div>
                                </div>
                                
                                <!-- Hover Effect -->
                                <div class="absolute inset-0 bg-purple-600/0 group-hover:bg-purple-600/20 transition-all duration-300"></div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endif

<!-- Back to Portfolio Button -->
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="max-w-6xl mx-auto text-center">
        <a href="{{ route('portfolio.index') }}" 
           class="inline-flex items-center gap-2 text-purple-600 font-semibold hover:gap-3 transition-all duration-300 text-lg">
            <i class="fas fa-arrow-left"></i>
            Back to All Projects
        </a>
    </div>
</div>

@endsection