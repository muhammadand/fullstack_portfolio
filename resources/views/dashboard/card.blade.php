{{-- ===== STATS CARDS ===== --}}
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-5">

    {{-- Total Views (Combined) --}}
    <div class="bg-white border border-slate-100 rounded-2xl p-5 shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all duration-200 group">
        <div class="flex items-center justify-between mb-4">
            <div class="w-9 h-9 rounded-xl flex items-center justify-center" style="background: linear-gradient(135deg, #EFF6FF, #DBEAFE);">
                <i class="fa-solid fa-eye text-blue-600" style="font-size:13px;"></i>
            </div>
            <span class="text-[10px] font-semibold text-emerald-600 bg-emerald-50 border border-emerald-100 px-2 py-0.5 rounded-full flex items-center gap-1">
                <i class="fa-solid fa-arrow-trend-up" style="font-size:8px;"></i> Live
            </span>
        </div>
        <p class="text-2xl font-bold text-slate-900 mb-0.5 tracking-tight">{{ number_format($totalViews) }}</p>
        <p class="text-xs text-slate-400 font-medium">Total Views Keseluruhan</p>
        <div class="mt-3 pt-3 border-t border-slate-50 flex items-center justify-between text-[11px] text-slate-400">
            <span>Blog: <span class="text-slate-600 font-semibold">{{ number_format($totalBlogViews) }}</span></span>
            <span>Portfolio: <span class="text-slate-600 font-semibold">{{ number_format($totalPortfolioViews) }}</span></span>
        </div>
    </div>

    {{-- Blog Views --}}
    <div class="bg-white border border-slate-100 rounded-2xl p-5 shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all duration-200">
        <div class="flex items-center justify-between mb-4">
            <div class="w-9 h-9 rounded-xl flex items-center justify-center" style="background: linear-gradient(135deg, #F0FDF4, #DCFCE7);">
                <i class="fa-solid fa-rss text-emerald-600" style="font-size:13px;"></i>
            </div>
            <span class="text-[10px] text-slate-400">Blog Traffic</span>
        </div>
        <p class="text-2xl font-bold text-slate-900 mb-0.5 tracking-tight">{{ number_format($totalBlogViews) }}</p>
        <p class="text-xs text-slate-400 font-medium">Total Blog Views</p>
        <div class="mt-3 pt-3 border-t border-slate-50">
            <div class="w-full bg-slate-100 rounded-full h-1.5">
                @php $blogPct = $totalViews > 0 ? round(($totalBlogViews / $totalViews) * 100) : 0; @endphp
                <div class="h-1.5 rounded-full bg-emerald-500 transition-all duration-500" style="width: {{ $blogPct }}%"></div>
            </div>
            <p class="text-[11px] text-slate-400 mt-1.5">{{ $blogPct }}% dari total views</p>
        </div>
    </div>

    {{-- Portfolio Views --}}
    <div class="bg-white border border-slate-100 rounded-2xl p-5 shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all duration-200">
        <div class="flex items-center justify-between mb-4">
            <div class="w-9 h-9 rounded-xl flex items-center justify-center" style="background: linear-gradient(135deg, #EEF2FF, #E0E7FF);">
                <i class="fa-solid fa-chart-line text-indigo-600" style="font-size:13px;"></i>
            </div>
            <span class="text-[10px] text-slate-400">Portfolio Traffic</span>
        </div>
        <p class="text-2xl font-bold text-slate-900 mb-0.5 tracking-tight">{{ number_format($totalPortfolioViews) }}</p>
        <p class="text-xs text-slate-400 font-medium">Total Portfolio Views</p>
        <div class="mt-3 pt-3 border-t border-slate-50">
            <div class="w-full bg-slate-100 rounded-full h-1.5">
                @php $portPct = $totalViews > 0 ? round(($totalPortfolioViews / $totalViews) * 100) : 0; @endphp
                <div class="h-1.5 rounded-full bg-indigo-500 transition-all duration-500" style="width: {{ $portPct }}%"></div>
            </div>
            <p class="text-[11px] text-slate-400 mt-1.5">{{ $portPct }}% dari total views</p>
        </div>
    </div>

    {{-- Content Count --}}
    <div class="bg-white border border-slate-100 rounded-2xl p-5 shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all duration-200">
        <div class="flex items-center justify-between mb-4">
            <div class="w-9 h-9 rounded-xl flex items-center justify-center" style="background: linear-gradient(135deg, #F0F9FF, #E0F2FE);">
                <i class="fa-solid fa-layer-group text-sky-600" style="font-size:13px;"></i>
            </div>
            <span class="text-[10px] text-slate-400">Content</span>
        </div>
        <p class="text-2xl font-bold text-slate-900 mb-0.5 tracking-tight">{{ $totalBlogs + $totalPortfolios }}</p>
        <p class="text-xs text-slate-400 font-medium">Total Konten Aktif</p>
        <div class="mt-3 pt-3 border-t border-slate-50 flex items-center justify-between text-[11px] text-slate-400">
            <span class="flex items-center gap-1"><i class="fa-solid fa-pen-nib text-slate-300" style="font-size:9px;"></i> {{ $totalBlogs }} Blogs</span>
            <span class="flex items-center gap-1"><i class="fa-solid fa-briefcase text-slate-300" style="font-size:9px;"></i> {{ $totalPortfolios }} Projects</span>
        </div>
    </div>

</div>
