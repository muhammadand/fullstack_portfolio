{{-- ===== CHART SECTION ===== --}}
<div class="grid grid-cols-3 gap-4 mb-5">

    {{-- View Statistics Bar Chart (col-span-2) --}}
    <div x-data="viewStats()" x-init="loadData()" class="col-span-2 bg-white border border-slate-100 rounded-2xl shadow-sm p-5">

        <div class="flex items-center justify-between mb-5">
            <div>
                <h3 class="text-sm font-bold text-slate-800">View Statistics</h3>
                <p class="text-[11px] text-slate-400 mt-0.5">Distribusi views berdasarkan tanggal</p>
            </div>
            <div class="flex items-center gap-2">
                {{-- Type selector --}}
                <select x-model="type" @change="loadData()" class="px-2.5 py-1.5 bg-slate-50 border border-slate-200 rounded-lg text-xs text-slate-600 focus:outline-none focus:border-blue-400 cursor-pointer">
                    <option value="blogs">Blogs</option>
                    <option value="portfolios">Portfolios</option>
                    <option value="both">Both</option>
                </select>
                {{-- Date range --}}
                <input type="date" x-model="start" @change="loadData()" class="px-2.5 py-1.5 bg-slate-50 border border-slate-200 rounded-lg text-xs text-slate-600 focus:outline-none focus:border-blue-400">
                <input type="date" x-model="end" @change="loadData()" class="px-2.5 py-1.5 bg-slate-50 border border-slate-200 rounded-lg text-xs text-slate-600 focus:outline-none focus:border-blue-400">
            </div>
        </div>

        {{-- Legend --}}
        <div class="flex items-center gap-4 mb-4">
            <div class="flex items-center gap-1.5" x-show="type !== 'portfolios'">
                <div class="w-2.5 h-2.5 rounded-sm" style="background:#1D4ED8;"></div>
                <span class="text-[11px] text-slate-500">Blog Views</span>
            </div>
            <div class="flex items-center gap-1.5" x-show="type !== 'blogs'">
                <div class="w-2.5 h-2.5 rounded-sm" style="background:#93C5FD;"></div>
                <span class="text-[11px] text-slate-500">Portfolio Views</span>
            </div>
        </div>

        {{-- Chart bars --}}
        <div class="h-44 flex items-end gap-2 overflow-x-auto pb-1" style="scrollbar-width: none;">
            <template x-if="chartData.length === 0">
                <div class="w-full flex flex-col items-center justify-center h-full gap-2 text-slate-300">
                    <i class="fa-solid fa-chart-column text-3xl"></i>
                    <p class="text-xs">Belum ada data pada periode ini</p>
                </div>
            </template>
            <template x-for="item in chartData" :key="item.date">
                <div class="flex-1 flex flex-col items-center gap-1.5 group min-w-[32px]">
                    <div class="w-full flex gap-0.5 items-end h-36">
                        {{-- Blog bar --}}
                        <div x-show="type !== 'portfolios'" class="flex-1 rounded-t-md transition-all duration-300 group-hover:opacity-80" style="background: linear-gradient(180deg, #2563EB, #1E3A8A);" :style="'height:' + Math.max(4, (item.blogs * scale)) + '%'" :title="'Blog: ' + item.blogs + ' views'">
                        </div>
                        {{-- Portfolio bar --}}
                        <div x-show="type !== 'blogs'" class="flex-1 rounded-t-md transition-all duration-300 group-hover:opacity-80" style="background: linear-gradient(180deg, #93C5FD, #60A5FA);" :style="'height:' + Math.max(4, (item.portfolios * scale)) + '%'" :title="'Portfolio: ' + item.portfolios + ' views'">
                        </div>
                    </div>
                    <span class="text-[9px] text-slate-400 truncate max-w-full" x-text="item.date.slice(5)"></span>
                </div>
            </template>
        </div>
    </div>

    {{-- Donut Total Views --}}
    <div class="bg-white border border-slate-100 rounded-2xl shadow-sm p-5 flex flex-col">
        <div class="mb-4">
            <h3 class="text-sm font-bold text-slate-800">Komposisi Views</h3>
            <p class="text-[11px] text-slate-400 mt-0.5">Blog vs Portfolio breakdown</p>
        </div>

        {{-- Donut chart SVG --}}
        <div class="flex justify-center flex-1 items-center">
            <div class="relative w-36 h-36">
                @php
                $max = max(1, $totalViews);
                $blogDash = $totalViews > 0 ? round(($totalBlogViews / $max) * 283) : 0;
                $portDash = $totalViews > 0 ? round(($totalPortfolioViews / $max) * 283) : 0;
                $blogOffset = 0;
                $portOffset = -(283 - $blogDash);
                @endphp
                <svg viewBox="0 0 100 100" class="w-full h-full -rotate-90">
                    {{-- Track --}}
                    <circle cx="50" cy="50" r="38" fill="none" stroke="#F1F5F9" stroke-width="10" />
                    {{-- Blog arc --}}
                    @if($totalBlogViews > 0)
                    <circle cx="50" cy="50" r="38" fill="none" stroke="#1D4ED8" stroke-width="10" stroke-dasharray="{{ $blogDash }} 283" stroke-dashoffset="0" stroke-linecap="round" class="transition-all duration-700" />
                    @endif
                    {{-- Portfolio arc --}}
                    @if($totalPortfolioViews > 0)
                    <circle cx="50" cy="50" r="38" fill="none" stroke="#93C5FD" stroke-width="10" stroke-dasharray="{{ $portDash }} 283" stroke-dashoffset="-{{ $blogDash }}" stroke-linecap="round" class="transition-all duration-700" />
                    @endif
                </svg>
                <div class="absolute inset-0 flex flex-col items-center justify-center rotate-0">
                    <span class="text-[10px] text-slate-400 font-medium">Total</span>
                    <span class="text-xl font-bold text-slate-900">{{ number_format($totalViews) }}</span>
                </div>
            </div>
        </div>

        {{-- Legend --}}
        <div class="mt-4 space-y-2 border-t border-slate-50 pt-4">
            <div class="flex items-center justify-between text-xs">
                <div class="flex items-center gap-2">
                    <div class="w-2 h-2 rounded-full" style="background:#1D4ED8;"></div>
                    <span class="text-slate-600">Blog Views</span>
                </div>
                <span class="font-semibold text-slate-700">{{ number_format($totalBlogViews) }}</span>
            </div>
            <div class="flex items-center justify-between text-xs">
                <div class="flex items-center gap-2">
                    <div class="w-2 h-2 rounded-full" style="background:#93C5FD;"></div>
                    <span class="text-slate-600">Portfolio Views</span>
                </div>
                <span class="font-semibold text-slate-700">{{ number_format($totalPortfolioViews) }}</span>
            </div>
            <div class="flex items-center justify-between text-xs pt-1 border-t border-slate-50">
                <span class="text-slate-400">Avg. per Content</span>
                <span class="font-semibold text-slate-700">
                    {{ ($totalBlogs + $totalPortfolios) > 0 ? number_format($totalViews / ($totalBlogs + $totalPortfolios), 1) : 0 }}
                </span>
            </div>
        </div>
    </div>

</div>

<script>
    function viewStats() {
        return {
            type: 'blogs'
            , start: '{{ now()->subDays(30)->toDateString() }}'
            , end: '{{ now()->toDateString() }}'
            , chartData: []
            , scale: 1,

            async loadData() {
                const url = `/admin/view-stats?start=${this.start}&end=${this.end}&type=${this.type}`;
                const res = await fetch(url);
                const data = await res.json();
                const dates = {};

                (data.blogs || []).forEach(r => {
                    dates[r.date] = dates[r.date] || {
                        date: r.date
                        , blogs: 0
                        , portfolios: 0
                    };
                    dates[r.date].blogs = Number(r.total);
                });
                (data.portfolios || []).forEach(r => {
                    dates[r.date] = dates[r.date] || {
                        date: r.date
                        , blogs: 0
                        , portfolios: 0
                    };
                    dates[r.date].portfolios = Number(r.total);
                });

                this.chartData = Object.values(dates).sort((a, b) => a.date.localeCompare(b.date));

                const maxVal = Math.max(1, ...this.chartData.flatMap(d => [d.blogs, d.portfolios]));
                this.scale = 90 / maxVal; // scale to 90% of chart height
            }
        };
    }

</script>
