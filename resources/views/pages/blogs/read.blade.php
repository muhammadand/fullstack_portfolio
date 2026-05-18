@extends('pages.layouts.app')

@section('content')
    <div class="min-h-screen bg-slate-50 pt-24 pb-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Breadcrumb -->
            <div class="mb-8 flex items-center gap-3">
                <a href="{{ route('landing.blogs') }}"
                    class="text-sm font-semibold text-slate-500 hover:text-blue-600 transition-colors inline-flex items-center gap-2">
                    <i class="fas fa-arrow-left"></i> Kembali ke Blog
                </a>
                <span class="text-slate-300">/</span>
                <span
                    class="px-3 py-1 bg-blue-50 text-blue-600 rounded-full text-[10px] font-bold tracking-widest uppercase">
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
                                <img src="{{ asset('storage/' . $blog->featured_image) }}" alt="{{ $blog->title }}"
                                    class="w-full h-full object-cover">
                                <div class="absolute inset-0 bg-gradient-to-t from-[#0f172a]/30 to-transparent"></div>
                            </div>
                        @endif

                        <div class="p-6 sm:p-8 md:p-12">
                            <!-- Title -->
                            <h1 class="text-xl md:text-2xl font-display font-bold text-slate-900 mb-6 leading-tight">
                                {{ $blog->title }}
                            </h1>

                            <!-- Author & Meta -->
                            <div
                                class="flex items-center justify-between flex-wrap gap-4 pb-8 border-b border-slate-100 mb-8">
                                <div class="flex items-center gap-4">
                                    <div
                                        class="w-12 h-12 rounded-full bg-[#0f172a] flex items-center justify-center text-white font-bold text-lg shadow-md">
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
                                    <button
                                        class="w-10 h-10 flex items-center justify-center bg-slate-50 text-slate-600 hover:bg-[#0f172a] hover:text-white rounded-full transition-all shadow-sm"
                                        title="Share">
                                        <i class="fas fa-share-nodes"></i>
                                    </button>
                                    <button
                                        class="w-10 h-10 flex items-center justify-center bg-slate-50 text-slate-600 hover:bg-[#0f172a] hover:text-white rounded-full transition-all shadow-sm"
                                        title="Bookmark">
                                        <i class="far fa-bookmark"></i>
                                    </button>
                                </div>
                            </div>

                            <!-- Excerpt -->
                            @if ($blog->excerpt)
                                <p
                                    class="text-slate-600 text-sm md:text-md leading-relaxed mb-8 font-medium italic border-l-4 border-blue-500 pl-6 bg-slate-50 py-5 pr-5 rounded-r-xl">
                                    {{ $blog->excerpt }}
                                </p>
                            @endif

                            <div
                                class="prose prose-lg prose-slate max-w-none
                                prose-headings:font-display prose-headings:text-slate-900
                                prose-h2:text-3xl prose-h2:font-bold prose-h2:mt-10 prose-h2:mb-5 prose-h2:leading-snug
                                prose-h3:text-2xl prose-h3:font-semibold prose-h3:mt-8 prose-h3:mb-4 prose-h3:leading-snug
                                prose-p:text-slate-600 prose-p:leading-relaxed prose-p:mb-6
                                prose-a:text-blue-600 prose-a:font-semibold prose-a:no-underline prose-a:border-b-2 prose-a:border-blue-200 hover:prose-a:border-blue-600 hover:prose-a:text-blue-800 prose-a:transition-colors
                                prose-strong:text-slate-900 prose-strong:font-bold
                                prose-ul:list-disc prose-ul:pl-6 prose-ol:list-decimal prose-ol:pl-6
                                prose-li:my-2
                                prose-img:rounded-2xl prose-img:my-10 prose-img:shadow-sm
                                prose-blockquote:border-l-4 prose-blockquote:border-blue-600 prose-blockquote:bg-slate-50 prose-blockquote:py-5 prose-blockquote:px-6 prose-blockquote:rounded-r-lg prose-blockquote:text-slate-700 prose-blockquote:my-8 prose-blockquote:italic
                                prose-code:text-blue-600 prose-code:bg-blue-50 prose-code:px-1.5 prose-code:py-0.5 prose-code:rounded-md prose-code:before:content-none prose-code:after:content-none
                                [&_.ql-align-justify]:text-justify">
                                {!! $blog->content !!}
                            </div>

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
                                            <span
                                                class="px-4 py-1.5 bg-slate-50 border border-slate-100 text-slate-600 rounded-full text-sm font-medium hover:bg-[#0f172a] hover:text-white transition-colors cursor-pointer">
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
                                        <a href="{{ route('blogs.read', $item->slug) }}"
                                            class="flex gap-4 group items-center">
                                            @if ($item->featured_image)
                                                <div class="w-24 h-20 flex-shrink-0 rounded-xl overflow-hidden shadow-sm">
                                                    <img src="{{ asset('storage/' . $item->featured_image) }}"
                                                        alt="{{ $item->title }}"
                                                        class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                                </div>
                                            @else
                                                <div
                                                    class="w-24 h-20 flex-shrink-0 rounded-xl bg-slate-100 flex items-center justify-center">
                                                    <i class="fas fa-image text-slate-300"></i>
                                                </div>
                                            @endif

                                            <div class="flex-1 min-w-0 py-1">
                                                <h4
                                                    class="font-display font-semibold text-[15px] text-slate-900 mb-1.5 line-clamp-2 group-hover:text-blue-600 transition-colors leading-snug">
                                                    {{ $item->title }}
                                                </h4>
                                                <p
                                                    class="text-[11px] font-semibold tracking-widest uppercase text-slate-400">
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
                                <a href="{{ route('landing.blogs') }}"
                                    class="mt-8 block w-full text-center px-4 py-3 bg-slate-900 text-white rounded-xl hover:bg-blue-600 transition-colors font-semibold text-sm">
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
                            <div
                                class="bg-white border border-slate-100 text-slate-800 rounded-2xl overflow-hidden shadow-[0_2px_15px_rgb(0,0,0,0.02)] hover:shadow-[0_8px_30px_rgb(0,0,0,0.06)] hover:-translate-y-1 transition-all duration-300 flex flex-col group">
                                <div class="aspect-video bg-slate-50 relative overflow-hidden">
                                    @if ($item->featured_image)
                                        <img src="{{ asset('storage/' . $item->featured_image) }}"
                                            class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 ease-out">
                                    @else
                                        <div class="absolute inset-0 flex items-center justify-center">
                                            <i class="fas fa-image text-3xl text-slate-200"></i>
                                        </div>
                                    @endif
                                </div>

                                <div class="p-4 flex flex-col flex-1">
                                    <div
                                        class="flex items-center gap-2 mb-2 text-[9px] font-semibold tracking-widest text-slate-400 uppercase">
                                        <span class="text-blue-500 bg-blue-50 px-2 py-0.5 rounded-md">
                                            {{ $item->category->name ?? 'Blog' }}
                                        </span>
                                    </div>

                                    <h3
                                        class="font-display text-sm font-semibold mb-1.5 text-slate-900 leading-snug group-hover:text-blue-600 transition-colors line-clamp-2">
                                        {{ $item->title }}
                                    </h3>

                                    <p class="text-slate-500 text-xs mb-4 flex-1 line-clamp-2 leading-relaxed">
                                        {{ $item->excerpt }}
                                    </p>

                                    <a href="{{ route('blogs.read', $item->slug) }}"
                                        class="text-slate-900 text-xs font-semibold inline-flex items-center gap-1.5 hover:text-blue-600 transition-colors mt-auto group/btn">
                                        Baca Selengkapnya <i
                                            class="fas fa-arrow-right text-[8px] group-hover/btn:translate-x-1 transition-transform"></i>
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
