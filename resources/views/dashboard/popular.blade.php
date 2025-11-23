


<!-- Top Blogs & Top Portfolios -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-5 mt-6">

    <!-- TOP BLOGS -->
    <div class="bg-white border border-gray-100 p-6 rounded-2xl shadow-sm hover:shadow-lg transition-all duration-300">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-lg font-bold text-gray-900">Top Blogs</h2>
        </div>

        @if($topBlogs->isEmpty())
            <p class="text-sm text-gray-500">Belum ada data blog.</p>
        @else
            <ul class="space-y-4">
                @foreach($topBlogs as $blog)
                    <li
                        class="flex justify-between items-center p-3 bg-gray-50 rounded-xl hover:bg-purple-100/30 hover:shadow-md transition cursor-pointer">
                        
                        <div>
                            <p class="text-sm font-semibold text-gray-900">
                                {{ $blog->title }}
                            </p>
                            <p class="text-xs text-gray-500">{{ $blog->view_count }} views</p>
                        </div>

                        <a href="{{ route('blogs.show', $blog->id) }}"
                           class="p-2 rounded-full bg-purple-50 text-purple-600 hover:bg-purple-200 transition">
                            <i class="fas fa-eye"></i>
                        </a>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>


    <!-- TOP PORTFOLIOS -->
    <div class="bg-white border border-gray-100 p-6 rounded-2xl shadow-sm hover:shadow-lg transition-all duration-300">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-lg font-bold text-gray-900">Top Portfolios</h2>
        </div>

        @if($topPortfolios->isEmpty())
            <p class="text-sm text-gray-500">Belum ada data portfolio.</p>
        @else
            <ul class="space-y-4">
                @foreach($topPortfolios as $portfolio)
                    <li
                        class="flex justify-between items-center p-3 bg-gray-50 rounded-xl hover:bg-purple-100/30 hover:shadow-md transition cursor-pointer">

                        <div>
                            <p class="text-sm font-semibold text-gray-900">
                                {{ $portfolio->title }}
                            </p>
                            <p class="text-xs text-gray-500">{{ $portfolio->view_count }} views</p>
                        </div>

                        <a href="{{ route('portfolio.show', $portfolio->id) }}"
                           class="p-2 rounded-full bg-purple-50 text-purple-600 hover:bg-purple-200 transition">
                            <i class="fas fa-eye"></i>
                        </a>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>

</div>
