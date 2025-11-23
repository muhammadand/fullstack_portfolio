@extends('pages.layouts.app')

@section('content')
    <div class="min-h-screen bg-gray-50">
        <!-- Compact Navigation -->
        <div class="bg-white border-b sticky top-0 z-10">
            <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
                <nav class="flex gap-6 py-3 overflow-x-auto text-sm">
                    <a href="#" class="text-gray-600 hover:text-gray-900 transition whitespace-nowrap">Project</a>
                    <a href="#" class="text-gray-600 hover:text-gray-900 transition whitespace-nowrap">Remote</a>
                    <a href="#" class="text-gray-600 hover:text-gray-900 transition whitespace-nowrap">Teamwork</a>
                    <a href="#" class="text-purple-600 font-semibold border-b-2 border-purple-600 pb-3 -mb-[1px] whitespace-nowrap">Productivity</a>
                    <a href="#" class="text-gray-600 hover:text-gray-900 transition whitespace-nowrap">Marketing</a>
                </nav>
            </div>
        </div>

        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="grid lg:grid-cols-12 gap-8">

                <!-- Main Content -->
                <div class="lg:col-span-8">
                    <!-- Breadcrumb -->
                    <div class="mb-4">
                        <a href="{{ route('landing.blogs') }}" class="text-sm text-purple-600 hover:text-purple-700 inline-flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                            </svg>
                            Back
                        </a>
                        <span class="inline-block ml-3 px-2.5 py-1 bg-purple-100 text-purple-700 rounded-full text-xs font-medium">
                            {{ $blog->category->name ?? 'Blog' }}
                        </span>
                    </div>

                    <!-- Article Header -->
                    <article class="bg-white rounded-xl shadow-sm overflow-hidden">
                        <!-- Featured Image -->
                        @if ($blog->featured_image)
                            <div class="aspect-[16/9] overflow-hidden">
                                <img src="{{ asset('storage/' . $blog->featured_image) }}" alt="{{ $blog->title }}"
                                    class="w-full h-full object-cover hover:scale-105 transition-transform duration-500">
                            </div>
                        @endif

                        <div class="p-6 sm:p-8">
                            <!-- Title -->
                            <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-3 leading-tight">
                                {{ $blog->title }}
                            </h1>

                            <!-- Excerpt -->
                            @if ($blog->excerpt)
                                <p class="text-gray-600 text-base leading-relaxed mb-6">
                                    {{ $blog->excerpt }}
                                </p>
                            @endif

                            <!-- Author & Meta -->
                            <div class="flex items-center justify-between flex-wrap gap-3 pb-6 border-b">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-purple-400 to-pink-500 flex items-center justify-center text-white font-semibold text-sm">
                                        {{ substr($blog->author->name ?? 'A', 0, 1) }}
                                    </div>
                                    <div>
                                        <p class="font-semibold text-gray-900 text-sm">
                                            {{ $blog->author->name ?? 'Admin' }}
                                        </p>
                                        <p class="text-xs text-gray-500">
                                            {{ $blog->published_at->format('M d, Y') }} · 5 min read
                                        </p>
                                    </div>
                                </div>

                                <!-- Share Buttons -->
                                <div class="flex items-center gap-1">
                                    <button class="p-2 hover:bg-gray-100 rounded-lg transition" title="Share">
                                        <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/>
                                        </svg>
                                    </button>
                                    <button class="p-2 hover:bg-gray-100 rounded-lg transition" title="Bookmark">
                                        <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/>
                                        </svg>
                                    </button>
                                </div>
                            </div>

                            <!-- Content -->
                            <div class="mt-6 prose prose-base max-w-none 
                                        prose-headings:font-bold prose-headings:text-gray-900 
                                        prose-h2:text-xl prose-h2:mt-8 prose-h2:mb-3
                                        prose-h3:text-lg prose-h3:mt-6 prose-h3:mb-2
                                        prose-p:text-gray-700 prose-p:leading-relaxed prose-p:mb-4
                                        prose-a:text-purple-600 prose-a:no-underline hover:prose-a:underline
                                        prose-strong:text-gray-900 prose-strong:font-semibold
                                        prose-ul:my-4 prose-ol:my-4
                                        prose-li:text-gray-700 prose-li:my-1
                                        prose-img:rounded-lg prose-img:shadow-md
                                        prose-blockquote:border-l-4 prose-blockquote:border-purple-500 prose-blockquote:bg-purple-50 prose-blockquote:py-2 prose-blockquote:px-4 prose-blockquote:rounded-r
                                        prose-code:text-purple-600 prose-code:bg-purple-50 prose-code:px-1 prose-code:py-0.5 prose-code:rounded prose-code:text-sm">
                                {!! $blog->content !!}
                            </div>

                            <!-- Tags -->
                            @if ($blog->tags)
                                <div class="mt-8 pt-6 border-t">
                                    <div class="flex flex-wrap gap-2">
                                        @php
                                            $tags = [];
                                            if (is_array($blog->tags)) {
                                                foreach ($blog->tags as $item) {
                                                    if (strpos($item, ',') !== false) {
                                                        $parts = explode(',', $item);
                                                        foreach ($parts as $p) {
                                                            $tags[] = trim($p);
                                                        }
                                                    } else {
                                                        $tags[] = trim($item);
                                                    }
                                                }
                                            } else {
                                                $tags = array_map('trim', explode(',', $blog->tags));
                                            }
                                            $tags = array_filter($tags, fn($t) => $t !== '');
                                        @endphp

                                        @foreach ($tags as $tag)
                                            <span class="px-3 py-1 bg-gray-100 text-gray-700 rounded-full text-sm hover:bg-purple-100 hover:text-purple-700 transition cursor-pointer">
                                                #{{ $tag }}
                                            </span>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                    </article>
                </div>

                <!-- Compact Sidebar -->
                <aside class="lg:col-span-4">
                    <div class="sticky top-20">
                        <!-- Recent Articles -->
                        <div class="bg-white rounded-xl shadow-sm p-5">
                            <h3 class="text-lg font-bold text-gray-900 mb-4">Recent Articles</h3>

                            <div class="space-y-4">
                                @if ($related->count())
                                    @foreach ($related->take(5) as $item)
                                        <a href="{{ route('blogs.read', $item->slug) }}" class="flex gap-3 group">
                                            <!-- Thumbnail -->
                                            @if ($item->featured_image)
                                                <div class="w-20 h-16 flex-shrink-0 rounded-lg overflow-hidden">
                                                    <img src="{{ asset('storage/' . $item->featured_image) }}"
                                                        alt="{{ $item->title }}"
                                                        class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                                                </div>
                                            @else
                                                <div class="w-20 h-16 flex-shrink-0 rounded-lg bg-gradient-to-br from-purple-200 to-pink-200"></div>
                                            @endif

                                            <div class="flex-1 min-w-0">
                                                <h4 class="font-semibold text-sm text-gray-900 mb-1 line-clamp-2 group-hover:text-purple-600 transition">
                                                    {{ $item->title }}
                                                </h4>
                                                <p class="text-xs text-gray-500">
                                                    {{ $item->published_at->format('M d, Y') }}
                                                </p>
                                            </div>
                                        </a>
                                    @endforeach
                                @else
                                    <p class="text-sm text-gray-500">No related articles</p>
                                @endif
                            </div>

                            @if ($related->count())
                                <a href="{{ route('landing.blogs') }}"
                                    class="mt-5 block w-full text-center px-4 py-2.5 bg-gray-900 text-white rounded-lg hover:bg-gray-800 transition font-medium text-sm">
                                    View All
                                </a>
                            @endif
                        </div>
                    </div>
                </aside>
            </div>

            <!-- More Articles Grid -->
            @if ($related->count() > 5)
                <section class="mt-12">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">
                        More from {{ $blog->category->name ?? 'this category' }}
                    </h2>

                    <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach ($related->skip(5)->take(3) as $item)
                            <a href="{{ route('blogs.read', $item->slug) }}"
                                class="group bg-white rounded-xl overflow-hidden shadow-sm hover:shadow-md transition-all">

                                @if ($item->featured_image)
                                    <div class="aspect-[16/10] overflow-hidden">
                                        <img src="{{ asset('storage/' . $item->featured_image) }}"
                                            alt="{{ $item->title }}"
                                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                    </div>
                                @else
                                    <div class="aspect-[16/10] bg-gradient-to-br from-blue-200 to-blue-400"></div>
                                @endif

                                <div class="p-5">
                                    <h3 class="font-bold text-base text-gray-900 mb-2 line-clamp-2 group-hover:text-purple-600 transition">
                                        {{ $item->title }}
                                    </h3>

                                    @if ($item->excerpt)
                                        <p class="text-gray-600 text-sm mb-3 line-clamp-2">
                                            {{ $item->excerpt }}
                                        </p>
                                    @endif

                                    <div class="flex items-center gap-2 text-xs text-gray-500">
                                        <div class="w-6 h-6 rounded-full bg-gradient-to-br from-purple-400 to-pink-500 flex items-center justify-center text-white font-semibold">
                                            {{ substr($item->author->name ?? 'A', 0, 1) }}
                                        </div>
                                        <span>{{ $item->author->name ?? 'Admin' }}</span>
                                        <span>•</span>
                                        <span>{{ $item->published_at->format('M d') }}</span>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </section>
            @endif
        </div>
    </div>
@endsection