{{-- ===== CHART SECTION ===== --}}
<div class="grid grid-cols-1 lg:grid-cols-3 gap-4 mb-5">

    {{-- View Statistics Line Chart (col-span-2) --}}
    <div x-data="lineChart()" x-init="initChart()" class="col-span-1 lg:col-span-2 bg-white border border-slate-100 rounded-2xl shadow-sm p-5 relative">
        <div class="flex items-center justify-between mb-5">
            <div>
                <h3 class="text-sm font-bold text-slate-800">View Statistics</h3>
                <p class="text-[11px] text-slate-400 mt-0.5">Tren views berdasarkan tanggal pembuatan konten</p>
            </div>
            <div class="flex items-center gap-2">
                {{-- Type selector --}}
                <select x-model="type" @change="loadData()" class="px-2.5 py-1.5 bg-slate-50 border border-slate-200 rounded-lg text-xs text-slate-600 focus:outline-none focus:border-blue-400 cursor-pointer">
                    <option value="both">Both</option>
                    <option value="blogs">Blogs</option>
                    <option value="portfolios">Portfolios</option>
                </select>
                {{-- Date range (default 6 months back so data is more likely to show) --}}
                <input type="date" x-model="start" @change="loadData()" class="px-2.5 py-1.5 bg-slate-50 border border-slate-200 rounded-lg text-xs text-slate-600 focus:outline-none focus:border-blue-400">
                <input type="date" x-model="end" @change="loadData()" class="px-2.5 py-1.5 bg-slate-50 border border-slate-200 rounded-lg text-xs text-slate-600 focus:outline-none focus:border-blue-400">
            </div>
        </div>

        {{-- Canvas Container for Chart.js --}}
        <div class="relative w-full h-64">
            {{-- Loading overlay --}}
            <div x-show="loading" class="absolute inset-0 bg-white/50 backdrop-blur-sm flex items-center justify-center z-10">
                <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600"></div>
            </div>

            <template x-if="noData">
                <div class="absolute inset-0 flex flex-col items-center justify-center gap-2 text-slate-400 z-10 bg-white">
                    <i class="fa-solid fa-chart-line text-3xl"></i>
                    <p class="text-xs">Tidak ada data konten di rentang tanggal ini.</p>
                </div>
            </template>

            <canvas id="viewChartCanvas"></canvas>
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
                    <circle cx="50" cy="50" r="38" fill="none" stroke="#38BDF8" stroke-width="10" stroke-dasharray="{{ $portDash }} 283" stroke-dashoffset="-{{ $blogDash }}" stroke-linecap="round" class="transition-all duration-700" />
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
                    <div class="w-2 h-2 rounded-full" style="background:#38BDF8;"></div>
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

{{-- Memuat Chart.js dari CDN --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    function lineChart() {
        return {
            type: 'both',
            // Default ke 6 bulan terakhir supaya datanya lebih mudah muncul
            start: '{{ now()->subMonths(6)->toDateString() }}'
            , end: '{{ now()->toDateString() }}'
            , chartInstance: null
            , loading: true
            , noData: false,

            initChart() {
                // Pastikan untuk merender chart awal saat DOM dimuat
                this.loadData();
            },

            async loadData() {
                this.loading = true;
                this.noData = false;

                try {
                    const url = `/admin/view-stats?start=${this.start}&end=${this.end}&type=${this.type}`;
                    const res = await fetch(url);
                    const data = await res.json();

                    const datesMap = {};

                    // Gabungkan data blogs
                    if (data.blogs) {
                        data.blogs.forEach(r => {
                            datesMap[r.date] = datesMap[r.date] || {
                                date: r.date
                                , blogs: 0
                                , portfolios: 0
                            };
                            datesMap[r.date].blogs = Number(r.total);
                        });
                    }

                    // Gabungkan data portfolios
                    if (data.portfolios) {
                        data.portfolios.forEach(r => {
                            datesMap[r.date] = datesMap[r.date] || {
                                date: r.date
                                , blogs: 0
                                , portfolios: 0
                            };
                            datesMap[r.date].portfolios = Number(r.total);
                        });
                    }

                    const sortedData = Object.values(datesMap).sort((a, b) => a.date.localeCompare(b.date));

                    if (sortedData.length === 0) {
                        this.noData = true;
                        if (this.chartInstance) {
                            this.chartInstance.destroy();
                            this.chartInstance = null;
                        }
                    } else {
                        this.renderChart(sortedData);
                    }
                } catch (e) {
                    console.error("Gagal load data chart", e);
                } finally {
                    this.loading = false;
                }
            },

            renderChart(dataList) {
                const labels = dataList.map(item => item.date);
                const blogsData = dataList.map(item => item.blogs);
                const portfoliosData = dataList.map(item => item.portfolios);

                const ctx = document.getElementById('viewChartCanvas').getContext('2d');

                // Hancurkan instance chart yang lama sebelum buat yang baru
                if (this.chartInstance) {
                    this.chartInstance.destroy();
                }

                // Buat gradient garis untuk line chart
                const gradientBlue = ctx.createLinearGradient(0, 0, 0, 400);
                gradientBlue.addColorStop(0, 'rgba(37, 99, 235, 0.5)'); // Blue-600
                gradientBlue.addColorStop(1, 'rgba(37, 99, 235, 0.0)');

                const gradientSky = ctx.createLinearGradient(0, 0, 0, 400);
                gradientSky.addColorStop(0, 'rgba(56, 189, 248, 0.5)'); // Sky-400
                gradientSky.addColorStop(1, 'rgba(56, 189, 248, 0.0)');

                const datasets = [];

                if (this.type === 'both' || this.type === 'blogs') {
                    datasets.push({
                        label: 'Blog Views'
                        , data: blogsData
                        , borderColor: '#2563EB', // Blue 600
                        backgroundColor: gradientBlue
                        , borderWidth: 2
                        , pointBackgroundColor: '#fff'
                        , pointBorderColor: '#2563EB'
                        , pointBorderWidth: 2
                        , pointRadius: 3
                        , pointHoverRadius: 5
                        , fill: true
                        , tension: 0.4 // Membuat kurva melengkung (smooth line)
                    });
                }

                if (this.type === 'both' || this.type === 'portfolios') {
                    datasets.push({
                        label: 'Portfolio Views'
                        , data: portfoliosData
                        , borderColor: '#38BDF8', // Sky 400
                        backgroundColor: gradientSky
                        , borderWidth: 2
                        , pointBackgroundColor: '#fff'
                        , pointBorderColor: '#38BDF8'
                        , pointBorderWidth: 2
                        , pointRadius: 3
                        , pointHoverRadius: 5
                        , fill: true
                        , tension: 0.4
                    });
                }

                this.chartInstance = new Chart(ctx, {
                    type: 'line'
                    , data: {
                        labels: labels
                        , datasets: datasets
                    }
                    , options: {
                        responsive: true
                        , maintainAspectRatio: false
                        , interaction: {
                            mode: 'index'
                            , intersect: false
                        , }
                        , plugins: {
                            legend: {
                                position: 'top'
                                , align: 'end'
                                , labels: {
                                    usePointStyle: true
                                    , boxWidth: 8
                                    , font: {
                                        size: 11
                                        , family: "'Inter', sans-serif"
                                    }
                                }
                            }
                            , tooltip: {
                                backgroundColor: '#1E293B'
                                , titleFont: {
                                    size: 13
                                    , family: "'Inter', sans-serif"
                                }
                                , bodyFont: {
                                    size: 12
                                    , family: "'Inter', sans-serif"
                                }
                                , padding: 10
                                , cornerRadius: 8
                                , displayColors: true
                            }
                        }
                        , scales: {
                            x: {
                                grid: {
                                    display: false
                                    , drawBorder: false
                                }
                                , ticks: {
                                    font: {
                                        size: 10
                                        , family: "'Inter', sans-serif"
                                    }
                                    , color: '#94A3B8'
                                }
                            }
                            , y: {
                                grid: {
                                    color: '#F1F5F9'
                                    , borderDash: [5, 5]
                                    , drawBorder: false
                                }
                                , ticks: {
                                    font: {
                                        size: 10
                                        , family: "'Inter', sans-serif"
                                    }
                                    , color: '#94A3B8'
                                    , beginAtZero: true
                                    , precision: 0
                                }
                            }
                        }
                    }
                });
            }
        };
    }

</script>
