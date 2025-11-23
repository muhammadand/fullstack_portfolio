@extends('pages.layouts.app')

@section('content')
    <section class="py-20 px-6 max-w-7xl mx-auto">

        <h2 class="text-4xl font-bold text-center mb-4">Blog & Insights</h2>
        <p class="text-center text-gray-600 mb-16 max-w-2xl mx-auto">
            Tulisan dan insights terbaru tentang coding, bisnis digital, dan teknologi AI.
        </p>

        {{-- Highlight 4 populer --}}
        @if ($popular->count())
            <h3 class="text-2xl font-semibold mb-6">Top 4 Popular</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
                @foreach ($popular as $blog)
                    <div class="card-hover glass-effect rounded-2xl overflow-hidden">
                        <div class="h-40 bg-gray-200 relative">
                            @if ($blog->featured_image)
                                <img src="{{ asset('storage/' . $blog->featured_image) }}"
                                    class="absolute inset-0 w-full h-full object-cover">
                            @else
                                <div class="absolute inset-0 flex items-center justify-center">
                                    <i class="fas fa-image text-6xl opacity-20"></i>
                                </div>
                            @endif
                        </div>
                        <div class="p-4">
                            <div class="flex gap-2 mb-2 text-xs text-gray-500">
                                @if ($blog->category)
                                    <span class="bg-purple-100 text-purple-700 px-2 py-1 rounded-full">
                                        {{ $blog->category->name }}
                                    </span>
                                @endif
                                <span>{{ $blog->published_at?->format('d M Y') }}</span>
                            </div>
                            <h4 class="font-bold mb-2 text-sm md:text-base">{{ $blog->title }}</h4>
                            <p class="text-gray-600 text-xs md:text-sm mb-2">{{ $blog->excerpt }}</p>
                            <a href="{{ route('blogs.read', $blog->slug) }}"
                                class="text-purple-600 text-sm font-semibold inline-flex items-center gap-1 hover:gap-2 transition">
                                Baca Selengkapnya <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        {{-- Semua blog --}}
        <h3 class="text-2xl font-semibold mb-6">Semua Artikel</h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8 mb-12">
            @foreach ($blogs as $blog)
                <div class="card-hover glass-effect rounded-2xl overflow-hidden flex flex-col">
                    {{-- IMAGE --}}
                    <div class="h-48 bg-gray-200 relative">
                        @if ($blog->featured_image)
                            <img src="{{ asset('storage/' . $blog->featured_image) }}"
                                class="absolute inset-0 w-full h-full object-cover">
                        @else
                            <div class="absolute inset-0 flex items-center justify-center">
                                <i class="fas fa-image text-6xl opacity-20"></i>
                            </div>
                        @endif
                    </div>

                    {{-- CONTENT --}}
                    <div class="p-6 flex flex-col flex-1">
                        {{-- Category + Date --}}
                        <div class="flex gap-2 mb-3 text-xs text-gray-500">
                            @if ($blog->category)
                                <span class="bg-purple-100 text-purple-700 px-3 py-1 rounded-full">
                                    {{ $blog->category->name }}
                                </span>
                            @endif
                            <span>{{ $blog->published_at?->format('d M Y') }}</span>
                        </div>

                        {{-- Title --}}
                        <h3 class="text-xl font-bold mb-3">{{ $blog->title }}</h3>

                        {{-- Excerpt --}}
                        <p class="text-gray-600 text-sm mb-4 flex-1">{{ $blog->excerpt }}</p>

                        {{-- Read More --}}
                        <a href="{{ route('blogs.read', $blog->slug) }}"
                            class="text-purple-600 font-semibold text-sm inline-flex items-center gap-2 hover:gap-3 transition mt-auto">
                            Baca Selengkapnya <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>


        {{-- Pagination --}}
        <div class="flex justify-center">
            {{ $blogs->links() }}
        </div>

    </section>
@endsection
