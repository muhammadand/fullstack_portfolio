@extends('pages.layouts.app')

@section('title', 'Portfolio')

@section('content')

<!-- Hero Section -->
<div class="bg-gradient-to-br from-purple-600 via-purple-700 to-indigo-800 text-white py-20">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto text-center">
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-6 leading-tight">
                Our Amazing Projects
            </h1>
            <p class="text-xl md:text-2xl text-purple-100 mb-8">
                Explore our collection of innovative solutions and successful collaborations
            </p>
            <div class="flex items-center justify-center gap-2 text-purple-200">
                <i class="fas fa-folder-open text-2xl"></i>
                <span class="text-lg">{{ $portfolios->total() }} Projects Completed</span>
            </div>
        </div>
    </div>
</div>

<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
        
        <!-- Main Portfolio Grid -->
        <div class="lg:col-span-3">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @forelse($portfolios as $portfolio)
                    <div class="group relative rounded-2xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-300 hover:-translate-y-2">
                        
                        <!-- Image Container -->
                        <div class="relative h-72 overflow-hidden">
                            <a href="{{ route('portfolio.read', $portfolio->slug) }}">
                                <img src="{{ asset('storage/' . $portfolio->thumbnail_image) }}" 
                                     alt="{{ $portfolio->title }}" 
                                     class="w-full h-full object-cover transition-all duration-700 group-hover:scale-110">
                                
                                <!-- Gradient Overlay -->
                                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent"></div>
                                
                                <!-- Technology Badge (Top Left) -->
                                @php
                                    $techs = is_array($portfolio->technologies) ? $portfolio->technologies : explode(',', $portfolio->technologies);
                                    $firstTech = !empty($techs) ? trim($techs[0]) : '';
                                @endphp
                                
                                @if($firstTech)
                                    <div class="absolute top-4 left-4">
                                        <span class="px-3 py-1.5 text-xs font-semibold rounded-full bg-purple-600/90 text-white uppercase tracking-wide backdrop-blur-sm">
                                            {{ $firstTech }}
                                        </span>
                                    </div>
                                @endif
                                
                                <!-- Content (Bottom) -->
                                <div class="absolute bottom-0 left-0 right-0 p-6">
                                    <h2 class="text-2xl font-bold text-white mb-2 group-hover:text-purple-300 transition-colors duration-300">
                                        {{ $portfolio->title }}
                                    </h2>
                                    <p class="text-white/90 text-sm leading-relaxed line-clamp-2">
                                        {{ $portfolio->short_description }}
                                    </p>
                                </div>
                                
                                <!-- Hover Effect - View Details Button -->
                                <div class="absolute inset-0 bg-purple-600/0 group-hover:bg-purple-600/20 transition-all duration-300 flex items-center justify-center opacity-0 group-hover:opacity-100">
                                    <div class="transform translate-y-4 group-hover:translate-y-0 transition-transform duration-300">
                                        <span class="inline-flex items-center gap-2 px-6 py-3 bg-white text-purple-600 font-bold rounded-full shadow-lg">
                                            View Project
                                            <i class="fas fa-arrow-right"></i>
                                        </span>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>

                @empty
                    <div class="col-span-2 text-center py-16">
                        <div class="mb-6">
                            <i class="fas fa-folder-open text-7xl text-gray-300"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-600 mb-2">No Projects Yet</h3>
                        <p class="text-gray-500">Stay tuned for our upcoming amazing projects!</p>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if($portfolios->hasPages())
                <div class="mt-12">
                    {{ $portfolios->links() }}
                </div>
            @endif
        </div>

        <!-- Sidebar: Popular Portfolio -->
        <div class="lg:col-span-1">
            <div class="sticky top-8">
                <!-- Popular Portfolio Card -->
                <div class="bg-gradient-to-br from-purple-50 to-indigo-50 rounded-2xl p-6 shadow-lg border border-purple-100">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-10 h-10 bg-purple-600 rounded-full flex items-center justify-center">
                            <i class="fas fa-fire text-white"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900">
                            Popular Projects
                        </h3>
                    </div>

                    @if($popularPortfolios->isNotEmpty())
                        <div class="space-y-4">
                            @foreach($popularPortfolios as $popular)
                                <a href="{{ route('portfolio.read', $popular->slug) }}" 
                                   class="group block bg-white rounded-xl overflow-hidden shadow-sm hover:shadow-md transition-all duration-300 hover:-translate-y-1">
                                    <div class="flex gap-3 p-3">
                                        <!-- Thumbnail -->
                                        <div class="relative w-20 h-20 flex-shrink-0 rounded-lg overflow-hidden">
                                            <img src="{{ asset('storage/' . $popular->thumbnail_image) }}" 
                                                 alt="{{ $popular->title }}" 
                                                 class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-110">
                                            <div class="absolute inset-0 bg-gradient-to-t from-black/40 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                                        </div>
                                        
                                        <!-- Content -->
                                        <div class="flex-1 min-w-0">
                                            <h4 class="font-semibold text-gray-900 group-hover:text-purple-600 transition-colors line-clamp-2 mb-2">
                                                {{ $popular->title }}
                                            </h4>
                                            <div class="flex items-center gap-2 text-sm text-gray-500">
                                                <i class="fas fa-eye text-purple-500"></i>
                                                <span class="font-medium">{{ $popular->view_count }}</span>
                                                <span>views</span>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8">
                            <i class="fas fa-chart-line text-4xl text-gray-300 mb-3"></i>
                            <p class="text-gray-500 text-sm">No popular projects yet</p>
                        </div>
                    @endif
                </div>

                <!-- Stats Card -->
                <div class="mt-6 bg-white rounded-2xl p-6 shadow-lg border border-gray-100">
                    <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                        <i class="fas fa-chart-bar text-purple-600"></i>
                        Quick Stats
                    </h3>
                    <div class="space-y-3">
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600 text-sm">Total Projects</span>
                            <span class="text-xl font-bold text-purple-600">{{ $portfolios->total() }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600 text-sm">This Page</span>
                            <span class="text-xl font-bold text-indigo-600">{{ $portfolios->count() }}</span>
                        </div>
                        @if($portfolios->total() > 0)
                            <div class="pt-3 border-t border-gray-100">
                                <div class="flex items-center gap-2 text-sm text-gray-500">
                                    <i class="fas fa-info-circle text-purple-500"></i>
                                    <span>Showing {{ $portfolios->firstItem() }}-{{ $portfolios->lastItem() }}</span>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Call to Action -->
                <div class="mt-6 bg-gradient-to-br from-purple-600 to-indigo-700 rounded-2xl p-6 shadow-lg text-white text-center">
                    <i class="fas fa-briefcase text-4xl mb-3 opacity-90"></i>
                    <h3 class="text-lg font-bold mb-2">Have a Project?</h3>
                    <p class="text-purple-100 text-sm mb-4">Let's work together to bring your ideas to life!</p>
                    <a href="#contact" class="inline-block bg-white text-purple-600 px-6 py-2 rounded-full font-semibold hover:bg-purple-50 transition-colors">
                        Get Started
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection