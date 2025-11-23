<div class="grid grid-cols-4 gap-5 mb-6">

    <!-- Total Blog Views -->
    <div class="bg-white border border-gray-100 p-5 rounded-2xl shadow-sm transition-all duration-300 hover:shadow-lg hover:-translate-y-1 cursor-pointer">
        <div class="flex items-center justify-between mb-4">
            <span class="text-gray-600 font-medium text-sm">Total Blog Views</span>
            <button class="w-8 h-8 bg-gray-50 rounded-lg flex items-center justify-center transition-all duration-300 hover:bg-purple-50 hover:rotate-45">
                <i class="fas fa-eye text-gray-600 text-xs"></i>
            </button>
        </div>
        <div class="mb-2">
            <span class="text-3xl font-bold text-gray-900">{{ number_format($totalBlogViews) }}</span>
        </div>
        <div class="flex items-center gap-1 text-xs">
            <span class="text-green-500 font-medium">Blog Traffic</span>
        </div>
    </div>

    <!-- Total Portfolio Views -->
    <div class="bg-white border border-gray-100 p-5 rounded-2xl shadow-sm transition-all duration-300 hover:shadow-lg hover:-translate-y-1 cursor-pointer">
        <div class="flex items-center justify-between mb-4">
            <span class="text-gray-600 font-medium text-sm">Total Portfolio Views</span>
            <button class="w-8 h-8 bg-gray-50 rounded-lg flex items-center justify-center transition-all duration-300 hover:bg-purple-50 hover:rotate-45">
                <i class="fas fa-chart-line text-gray-600 text-xs"></i>
            </button>
        </div>
        <div class="mb-2">
            <span class="text-3xl font-bold text-gray-900">{{ number_format($totalPortfolioViews) }}</span>
        </div>
        <div class="flex items-center gap-1 text-xs">
            <span class="text-green-500 font-medium">Portfolio Traffic</span>
        </div>
    </div>

    <!-- Total Blogs -->
    <div class="bg-white border border-gray-100 p-5 rounded-2xl shadow-sm transition-all duration-300 hover:shadow-lg hover:-translate-y-1 cursor-pointer">
        <div class="flex items-center justify-between mb-4">
            <span class="text-gray-600 font-medium text-sm">Total Blogs</span>
            <button class="w-8 h-8 bg-gray-50 rounded-lg flex items-center justify-center transition-all duration-300 hover:bg-purple-50 hover:rotate-45">
                <i class="fas fa-newspaper text-gray-600 text-xs"></i>
            </button>
        </div>
        <div class="mb-2">
            <span class="text-3xl font-bold text-gray-900">{{ number_format($totalBlogs) }}</span>
        </div>
        <div class="flex items-center gap-1 text-xs">
            <span class="text-purple-500 font-medium">Published Articles</span>
        </div>
    </div>

    <!-- Total Portfolios -->
    <div class="bg-white border border-gray-100 p-5 rounded-2xl shadow-sm transition-all duration-300 hover:shadow-lg hover:-translate-y-1 cursor-pointer">
        <div class="flex items-center justify-between mb-4">
            <span class="text-gray-600 font-medium text-sm">Total Portfolios</span>
            <button class="w-8 h-8 bg-gray-50 rounded-lg flex items-center justify-center transition-all duration-300 hover:bg-purple-50 hover:rotate-45">
                <i class="fas fa-briefcase text-gray-600 text-xs"></i>
            </button>
        </div>
        <div class="mb-2">
            <span class="text-3xl font-bold text-gray-900">{{ number_format($totalPortfolios) }}</span>
        </div>
        <div class="flex items-center gap-1 text-xs">
            <span class="text-blue-500 font-medium">Projects Completed</span>
        </div>
    </div>

</div>
