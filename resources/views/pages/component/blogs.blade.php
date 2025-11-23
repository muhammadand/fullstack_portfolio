<!-- BLOG SECTION -->
<section id="blog" class="py-20 px-6">
    <div class="max-w-7xl mx-auto">
        <h2 class="text-4xl font-bold text-center mb-4">Blog & Insights</h2>
        <p class="text-center text-gray-600 mb-16 max-w-2xl mx-auto">
            Tulisan dan insights tentang coding, bisnis digital, dan teknologi AI yang akan membuat Anda lebih smart
            dalam berbisnis.
        </p>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">

            @foreach($latestBlogs as $blog)
                <div class="card-hover glass-effect rounded-2xl overflow-hidden">

                    <!-- IMAGE / BG -->
                    <div class="h-48 bg-gradient-to-br from-purple-200 to-blue-200 relative">
                        @if($blog->featured_image)
                            <img src="{{ asset('storage/'.$blog->featured_image) }}"
                                 class="absolute inset-0 w-full h-full object-cover">
                        @else
                            <div class="absolute inset-0 flex items-center justify-center">
                                <i class="fas fa-image text-6xl opacity-20"></i>
                            </div>
                        @endif
                    </div>

                    <div class="p-6">

                        <!-- Category + Date -->
                        <div class="flex gap-2 mb-3">
                            @if($blog->category)
                                <span class="text-xs bg-purple-100 text-purple-700 px-3 py-1 rounded-full">
                                    {{ $blog->category->name }}
                                </span>
                            @endif

                            <span class="text-xs text-gray-500">
                                {{ $blog->published_at?->format('d M Y') }}
                            </span>
                        </div>

                        <!-- Title -->
                        <h3 class="text-xl font-bold mb-3">{{ $blog->title }}</h3>

                        <!-- Excerpt -->
                        <p class="text-gray-600 text-sm mb-4">
                            {{ $blog->excerpt }}
                        </p>

                        <!-- Read More -->
                        <a href="{{ route('blogs.read', $blog->slug) }}"
                            class="text-purple-600 font-semibold text-sm inline-flex items-center gap-2 hover:gap-3 transition">
                            Baca Selengkapnya <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
            @endforeach

        </div>

        <div class="text-center">
            <a href="{{ route('landing.blogs') }}"
               class="border-2 border-purple-600 text-purple-600 px-8 py-4 rounded-lg font-semibold hover:bg-purple-50 transition">
                Lihat Semua Artikel
            </a>
        </div>
    </div>
</section>
