@extends('layouts.app')

@section('content')
    {{-- Highlight Populer Full Bleed --}}
    @if ($popular)
        <section class="relative z-20 w-full mt-0">
            <a href="{{ route('blogs.read', $popular->slug) }}"
                class="block relative w-full h-[60vh] min-h-[450px] lg:h-[80vh] overflow-hidden group">

                {{-- Background Image --}}
                @if ($popular->featured_image)
                    <img src="{{ asset('storage/' . $popular->featured_image) }}"
                        class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 ease-out">
                @else
                    <div class="absolute inset-0 bg-slate-800 flex items-center justify-center">
                        <i class="fas fa-image text-6xl text-slate-600"></i>
                    </div>
                @endif

                {{-- Midnight Blue Gradient Overlay --}}
                <div
                    class="absolute inset-0 bg-gradient-to-t from-[#0f172a] via-[#0f172a]/60 to-[#0f172a]/10 opacity-90 group-hover:opacity-100 transition-opacity duration-500">
                </div>

                {{-- Content --}}
                <div class="absolute inset-0 flex flex-col justify-end p-6 sm:p-8 md:p-12 lg:p-16">
                    <div class="max-w-7xl mx-auto flex items-end justify-between w-full gap-6 lg:gap-12 pb-4 md:pb-8">
                        <div class="text-white w-full max-w-4xl">
                            <div class="flex items-center gap-3 mb-4">
                                <span
                                    class="text-[11px] font-bold tracking-widest text-white uppercase bg-white/20 backdrop-blur-md px-3 py-1 rounded-full border border-white/10">
                                    FEATURED
                                </span>
                                @if ($popular->category)
                                    <span class="text-[12px] font-semibold tracking-wider text-blue-300 uppercase">
                                        {{ $popular->category->name }}
                                    </span>
                                @endif
                            </div>
                            <h4
                                class="font-display font-semibold text-3xl sm:text-4xl md:text-5xl lg:text-[4rem] mb-4 sm:mb-6 text-white leading-[1.1] group-hover:text-blue-100 transition-colors">
                                {{ $popular->title }}
                            </h4>
                            <p
                                class="text-slate-300 text-sm md:text-base lg:text-lg line-clamp-2 md:line-clamp-3 leading-relaxed font-light">
                                {{ $popular->excerpt }}
                            </p>
                        </div>

                        {{-- Arrow --}}
                        <div
                            class="hidden md:flex items-center justify-center w-14 h-14 lg:w-16 lg:h-16 rounded-full border-2 border-white/20 text-white group-hover:bg-white group-hover:text-[#0f172a] group-hover:border-white transition-all duration-500 shrink-0 transform group-hover:translate-x-2">
                            <i class="fas fa-arrow-right text-xl lg:text-2xl"></i>
                        </div>
                    </div>
                </div>
            </a>
        </section>
    @endif

    {{-- Daftar Artikel Grid --}}
    <section class="bg-white text-slate-800 py-16 px-4 sm:px-6 lg:px-8 relative z-20">
        <div class="max-w-7xl mx-auto">
            {{-- Semua blog --}}
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-xl sm:text-2xl font-display font-semibold text-slate-900">Artikel Terkini</h3>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 mb-12">
                @foreach ($blogs as $blog)
                    <div
                        class="bg-white border border-slate-100 text-slate-800 rounded-2xl overflow-hidden shadow-[0_2px_15px_rgb(0,0,0,0.02)] hover:shadow-[0_8px_30px_rgb(0,0,0,0.06)] hover:-translate-y-1 transition-all duration-300 flex flex-col group">
                        {{-- IMAGE --}}
                        <div class="aspect-video bg-slate-50 relative overflow-hidden">
                            @if ($blog->featured_image)
                                <img src="{{ asset('storage/' . $blog->featured_image) }}"
                                    class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 ease-out">
                            @else
                                <div class="absolute inset-0 flex items-center justify-center">
                                    <i class="fas fa-image text-3xl text-slate-200"></i>
                                </div>
                            @endif
                        </div>

                        {{-- CONTENT --}}
                        <div class="p-4 flex flex-col flex-1">
                            {{-- Category + Date --}}
                            <div
                                class="flex items-center gap-2 mb-2 text-[10px] font-semibold tracking-widest text-slate-400 uppercase">
                                @if ($blog->category)
                                    <span class="text-blue-500 bg-blue-50 px-2 py-0.5 rounded-md">
                                        {{ $blog->category->name }}
                                    </span>
                                @endif
                            </div>

                            {{-- Title --}}
                            <h3
                                class="font-display text-[15px] font-semibold mb-2 text-slate-900 leading-snug group-hover:text-blue-600 transition-colors line-clamp-2">
                                {{ $blog->title }}</h3>

                            {{-- Excerpt --}}
                            <p class="text-slate-500 text-[12px] mb-4 flex-1 line-clamp-2 leading-relaxed">
                                {{ $blog->excerpt }}
                            </p>

                            {{-- Read More --}}
                            <a href="{{ route('blogs.read', $blog->slug) }}"
                                class="text-slate-900 text-[12px] font-semibold inline-flex items-center gap-1.5 hover:text-blue-600 transition-colors mt-auto group/btn">
                                Baca Selengkapnya <i
                                    class="fas fa-arrow-right text-[9px] group-hover/btn:translate-x-1 transition-transform"></i>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Pagination --}}
            <div class="flex justify-center mt-8">
                {{ $blogs->links() }}
            </div>

        </div>
    </section>
@endsection
