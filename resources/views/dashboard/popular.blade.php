{{-- ===== TOP BLOGS & PORTFOLIOS ===== --}}
<div class="grid grid-cols-1 md:grid-cols-2 gap-4">

    {{-- TOP BLOGS --}}
    <div class="bg-white border border-slate-100 rounded-2xl shadow-sm p-5">
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center gap-2.5">
                <div class="w-8 h-8 rounded-xl flex items-center justify-center" style="background: linear-gradient(135deg, #EFF6FF, #DBEAFE);">
                    <i class="fa-solid fa-pen-nib text-blue-700" style="font-size:12px;"></i>
                </div>
                <div>
                    <h3 class="text-sm font-bold text-slate-800 leading-tight">Top Blogs</h3>
                    <p class="text-[10px] text-slate-400">Berdasarkan jumlah views</p>
                </div>
            </div>
            <a href="{{ route('blogs.index') }}" class="text-[11px] font-semibold text-blue-600 hover:text-blue-800 flex items-center gap-1 transition-colors">
                Lihat semua <i class="fa-solid fa-arrow-right" style="font-size:9px;"></i>
            </a>
        </div>

        @if($topBlogs->isEmpty())
        <div class="flex flex-col items-center justify-center py-8 text-slate-300 gap-2">
            <i class="fa-solid fa-pen-to-square text-2xl"></i>
            <p class="text-xs">Belum ada data blog.</p>
        </div>
        @else
        <ul class="space-y-2">
            @foreach($topBlogs as $index => $blog)
            <li class="flex items-center gap-3 p-3 rounded-xl hover:bg-slate-50 transition-colors duration-150 group">
                <span class="w-5 h-5 rounded-md flex items-center justify-center text-[10px] font-bold flex-shrink-0
                            {{ $index === 0 ? 'bg-blue-600 text-white' : 'bg-slate-100 text-slate-400' }}">
                    {{ $index + 1 }}
                </span>
                <div class="flex-1 min-w-0">
                    <p class="text-xs font-semibold text-slate-700 truncate">{{ $blog->title }}</p>
                    <div class="flex items-center gap-2 mt-0.5">
                        <div class="flex-1 bg-slate-100 rounded-full h-1">
                            @php $blogMax = $topBlogs->max('view_count') ?: 1; @endphp
                            <div class="h-1 rounded-full bg-blue-500 transition-all duration-500" style="width: {{ round(($blog->view_count / $blogMax) * 100) }}%"></div>
                        </div>
                        <span class="text-[10px] text-slate-400 font-medium whitespace-nowrap">{{ number_format($blog->view_count) }} views</span>
                    </div>
                </div>
                <a href="{{ route('blogs.show', $blog->id) }}" class="w-7 h-7 rounded-lg flex items-center justify-center bg-slate-50 border border-slate-200 text-slate-400 hover:bg-blue-50 hover:border-blue-200 hover:text-blue-600 transition-all duration-150 flex-shrink-0 opacity-0 group-hover:opacity-100">
                    <i class="fa-solid fa-eye" style="font-size:10px;"></i>
                </a>
            </li>
            @endforeach
        </ul>
        @endif
    </div>

    {{-- TOP PORTFOLIOS --}}
    <div class="bg-white border border-slate-100 rounded-2xl shadow-sm p-5">
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center gap-2.5">
                <div class="w-8 h-8 rounded-xl flex items-center justify-center" style="background: linear-gradient(135deg, #EEF2FF, #E0E7FF);">
                    <i class="fa-solid fa-briefcase text-indigo-700" style="font-size:12px;"></i>
                </div>
                <div>
                    <h3 class="text-sm font-bold text-slate-800 leading-tight">Top Portfolios</h3>
                    <p class="text-[10px] text-slate-400">Berdasarkan jumlah views</p>
                </div>
            </div>
            <a href="{{ route('portfolio.index') }}" class="text-[11px] font-semibold text-indigo-600 hover:text-indigo-800 flex items-center gap-1 transition-colors">
                Lihat semua <i class="fa-solid fa-arrow-right" style="font-size:9px;"></i>
            </a>
        </div>

        @if($topPortfolios->isEmpty())
        <div class="flex flex-col items-center justify-center py-8 text-slate-300 gap-2">
            <i class="fa-solid fa-briefcase text-2xl"></i>
            <p class="text-xs">Belum ada data portfolio.</p>
        </div>
        @else
        <ul class="space-y-2">
            @foreach($topPortfolios as $index => $portfolio)
            <li class="flex items-center gap-3 p-3 rounded-xl hover:bg-slate-50 transition-colors duration-150 group">
                <span class="w-5 h-5 rounded-md flex items-center justify-center text-[10px] font-bold flex-shrink-0
                            {{ $index === 0 ? 'bg-indigo-600 text-white' : 'bg-slate-100 text-slate-400' }}">
                    {{ $index + 1 }}
                </span>
                <div class="flex-1 min-w-0">
                    <p class="text-xs font-semibold text-slate-700 truncate">{{ $portfolio->title }}</p>
                    <div class="flex items-center gap-2 mt-0.5">
                        <div class="flex-1 bg-slate-100 rounded-full h-1">
                            @php $portMax = $topPortfolios->max('view_count') ?: 1; @endphp
                            <div class="h-1 rounded-full bg-indigo-500 transition-all duration-500" style="width: {{ round(($portfolio->view_count / $portMax) * 100) }}%"></div>
                        </div>
                        <span class="text-[10px] text-slate-400 font-medium whitespace-nowrap">{{ number_format($portfolio->view_count) }} views</span>
                    </div>
                </div>
                <a href="{{ route('portfolio.show', $portfolio->id) }}" class="w-7 h-7 rounded-lg flex items-center justify-center bg-slate-50 border border-slate-200 text-slate-400 hover:bg-indigo-50 hover:border-indigo-200 hover:text-indigo-600 transition-all duration-150 flex-shrink-0 opacity-0 group-hover:opacity-100">
                    <i class="fa-solid fa-eye" style="font-size:10px;"></i>
                </a>
            </li>
            @endforeach
        </ul>
        @endif
    </div>

</div>
