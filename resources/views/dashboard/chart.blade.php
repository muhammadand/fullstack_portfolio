    <div class="grid grid-cols-3 gap-5 mb-6">
        <!-- Money Flow Chart -->
        {{-- <div class="col-span-2 bg-white border border-gray-100 p-6 rounded-2xl shadow-sm transition-all duration-300 hover:shadow-lg">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-lg font-bold text-gray-900">Money flow</h2>
                        <div class="flex items-center gap-4">
                            <div class="flex items-center gap-2">
                                <div class="w-2.5 h-2.5 bg-purple-500 rounded-full"></div>
                                <span class="text-xs text-gray-600">Income</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <div class="w-2.5 h-2.5 bg-purple-300 rounded-full"></div>
                                <span class="text-xs text-gray-600">Expense</span>
                            </div>
                            <select class="px-3 py-1.5 bg-white border border-gray-200 rounded-lg text-xs transition-all duration-300 hover:border-purple-300 cursor-pointer">
                                <option>All accounts</option>
                            </select>
                            <select class="px-3 py-1.5 bg-white border border-gray-200 rounded-lg text-xs transition-all duration-300 hover:border-purple-300 cursor-pointer">
                                <option>This year</option>
                            </select>
                        </div>
                    </div>
                    <div class="h-56 flex items-end justify-between gap-3 px-2">
                        <div class="flex-1 flex flex-col items-center gap-2 group">
                            <div class="w-full flex gap-1 items-end h-44">
                                <div class="flex-1 bg-gradient-to-t from-purple-200 to-purple-100 rounded-t-lg transition-all duration-300 group-hover:from-purple-300 group-hover:to-purple-200" style="height: 55%"></div>
                                <div class="flex-1 bg-gradient-to-t from-purple-600 to-purple-400 rounded-t-lg transition-all duration-300 group-hover:from-purple-700 group-hover:to-purple-500" style="height: 70%"></div>
                            </div>
                            <span class="text-xs text-gray-500">Jan</span>
                        </div>
                        <div class="flex-1 flex flex-col items-center gap-2 group">
                            <div class="w-full flex gap-1 items-end h-44">
                                <div class="flex-1 bg-gradient-to-t from-purple-200 to-purple-100 rounded-t-lg transition-all duration-300 group-hover:from-purple-300 group-hover:to-purple-200" style="height: 75%"></div>
                                <div class="flex-1 bg-gradient-to-t from-purple-600 to-purple-400 rounded-t-lg transition-all duration-300 group-hover:from-purple-700 group-hover:to-purple-500" style="height: 85%"></div>
                            </div>
                            <span class="text-xs text-gray-500">Feb</span>
                        </div>
                        <div class="flex-1 flex flex-col items-center gap-2 group">
                            <div class="w-full flex gap-1 items-end h-44 relative">
                                <div class="absolute -top-7 left-1/2 transform -translate-x-1/2 bg-purple-600 text-white px-2 py-1 rounded text-xs whitespace-nowrap opacity-0 group-hover:opacity-100 transition-opacity">$10,000</div>
                                <div class="flex-1 bg-gradient-to-t from-purple-200 to-purple-100 rounded-t-lg transition-all duration-300 group-hover:from-purple-300 group-hover:to-purple-200" style="height: 50%"></div>
                                <div class="flex-1 bg-gradient-to-t from-purple-600 to-purple-400 rounded-t-lg transition-all duration-300 group-hover:from-purple-700 group-hover:to-purple-500" style="height: 68%"></div>
                            </div>
                            <span class="text-xs text-gray-500">Mar</span>
                        </div>
                        <div class="flex-1 flex flex-col items-center gap-2 group">
                            <div class="w-full flex gap-1 items-end h-44">
                                <div class="flex-1 bg-gradient-to-t from-purple-200 to-purple-100 rounded-t-lg transition-all duration-300 group-hover:from-purple-300 group-hover:to-purple-200" style="height: 80%"></div>
                                <div class="flex-1 bg-gradient-to-t from-purple-600 to-purple-400 rounded-t-lg transition-all duration-300 group-hover:from-purple-700 group-hover:to-purple-500" style="height: 95%"></div>
                            </div>
                            <span class="text-xs text-gray-500">Apr</span>
                        </div>
                        <div class="flex-1 flex flex-col items-center gap-2 group">
                            <div class="w-full flex gap-1 items-end h-44">
                                <div class="flex-1 bg-gradient-to-t from-purple-200 to-purple-100 rounded-t-lg transition-all duration-300 group-hover:from-purple-300 group-hover:to-purple-200" style="height: 85%"></div>
                                <div class="flex-1 bg-gradient-to-t from-purple-600 to-purple-400 rounded-t-lg transition-all duration-300 group-hover:from-purple-700 group-hover:to-purple-500" style="height: 88%"></div>
                            </div>
                            <span class="text-xs text-gray-500">May</span>
                        </div>
                        <div class="flex-1 flex flex-col items-center gap-2 group">
                            <div class="w-full flex gap-1 items-end h-44">
                                <div class="flex-1 bg-gradient-to-t from-purple-200 to-purple-100 rounded-t-lg transition-all duration-300 group-hover:from-purple-300 group-hover:to-purple-200" style="height: 60%"></div>
                                <div class="flex-1 bg-gradient-to-t from-purple-600 to-purple-400 rounded-t-lg transition-all duration-300 group-hover:from-purple-700 group-hover:to-purple-500" style="height: 65%"></div>
                            </div>
                            <span class="text-xs text-gray-500">Jun</span>
                        </div>
                        <div class="flex-1 flex flex-col items-center gap-2 group">
                            <div class="w-full flex gap-1 items-end h-44">
                                <div class="flex-1 bg-gradient-to-t from-purple-200 to-purple-100 rounded-t-lg transition-all duration-300 group-hover:from-purple-300 group-hover:to-purple-200" style="height: 70%"></div>
                                <div class="flex-1 bg-gradient-to-t from-purple-600 to-purple-400 rounded-t-lg transition-all duration-300 group-hover:from-purple-700 group-hover:to-purple-500" style="height: 72%"></div>
                            </div>
                            <span class="text-xs text-gray-500">Jul</span>
                        </div>
                    </div>
                </div> --}}
        <div x-data="viewStats()" x-init="loadData()"
            class="col-span-2 bg-white border border-gray-100 p-6 rounded-2xl shadow-sm">

            <div class="flex items-center justify-between mb-6">
                <h2 class="text-lg font-bold text-gray-900">View Statistics</h2>

                <div class="flex items-center gap-3">

                    <!-- Pilih Type -->
                    <select x-model="type" @change="loadData()"
                        class="px-3 py-1.5 bg-white border border-gray-200 rounded-lg text-xs">
                        <option value="blogs">Blogs</option>
                        <option value="portfolios">Portfolios</option>
                        <option value="both">Both</option>
                    </select>

                    <!-- Date Range -->
                    <input type="date" x-model="start" @change="loadData()"
                        class="px-3 py-1.5 bg-white border border-gray-200 rounded-lg text-xs">
                    <input type="date" x-model="end" @change="loadData()"
                        class="px-3 py-1.5 bg-white border border-gray-200 rounded-lg text-xs">
                </div>
            </div>

            <!-- Chart -->
            <div class="h-56 flex items-end gap-3 px-2 overflow-x-auto">

                <template x-for="item in chartData">
                    <div class="flex-1 flex flex-col items-center gap-2 group min-w-[50px]">

                        <div class="w-full flex gap-1 items-end h-44">

                            <!-- Blog bar -->
                            <div x-show="type !== 'portfolios'" class="flex-1 bg-purple-600 rounded-t-lg"
                                :style="'height:' + (item.blogs * scale) + '%'">
                            </div>

                            <!-- Portfolio bar -->
                            <div x-show="type !== 'blogs'" class="flex-1 bg-purple-300 rounded-t-lg"
                                :style="'height:' + (item.portfolios * scale) + '%'">
                            </div>
                        </div>

                        <span class="text-xs text-gray-500" x-text="item.date"></span>
                    </div>
                </template>

            </div>
        </div>


        <script>
            function viewStats() {
                return {
                    type: 'blogs', // default
                    start: '{{ now()->subDays(30)->toDateString() }}',
                    end: '{{ now()->toDateString() }}',

                    chartData: [],
                    scale: 4,

                    async loadData() {
                        const url = `/admin/view-stats?start=${this.start}&end=${this.end}&type=${this.type}`;
                        const res = await fetch(url);
                        const data = await res.json();

                        const dates = {};

                        if (data.blogs) {
                            data.blogs.forEach(r => {
                                dates[r.date] = dates[r.date] || {
                                    date: r.date,
                                    blogs: 0,
                                    portfolios: 0
                                };
                                dates[r.date].blogs = r.total;
                            });
                        }

                        if (data.portfolios) {
                            data.portfolios.forEach(r => {
                                dates[r.date] = dates[r.date] || {
                                    date: r.date,
                                    blogs: 0,
                                    portfolios: 0
                                };
                                dates[r.date].portfolios = r.total;
                            });
                        }

                        this.chartData = Object.values(dates).sort((a, b) => a.date.localeCompare(b.date));
                    }
                };
            }
        </script>


        <div
            class="bg-white border border-gray-100 p-6 rounded-2xl shadow-sm transition-all duration-300 hover:shadow-lg">

            <div class="flex items-center justify-between mb-6">
                <h2 class="text-lg font-bold text-gray-900">Total Views</h2>
                <button
                    class="w-8 h-8 bg-gray-50 rounded-lg flex items-center justify-center transition-all duration-300 hover:bg-purple-50 hover:rotate-45">
                    <i class="fas fa-eye text-gray-600 text-xs"></i>
                </button>
            </div>

            <div class="flex justify-center mb-6">
                <div class="relative w-44 h-44">

                    @php
                        // buat persentase untuk progress
                        $max = max(1, $totalViews);
                        $percentage = min(100, ($totalViews / $max) * 100);
                        $dashoffset = 440 - (440 * $percentage) / 100;
                    @endphp

                    <svg class="w-full h-full transform -rotate-90">
                        <circle cx="88" cy="88" r="70" fill="none" stroke="#f3f4f6" stroke-width="16">
                        </circle>

                        <circle cx="88" cy="88" r="70" fill="none" stroke="#7c3aed" stroke-width="16"
                            stroke-dasharray="440" stroke-dashoffset="{{ $dashoffset }}" stroke-linecap="round"
                            class="transition-all duration-500"></circle>
                    </svg>

                    <div class="absolute inset-0 flex flex-col items-center justify-center">
                        <span class="text-xs text-gray-400">Total Views</span>
                        <span class="text-xl font-bold text-gray-900">{{ number_format($totalViews) }}</span>
                    </div>
                </div>
            </div>

            <div class="space-y-2.5">
                <div class="flex items-center justify-between text-xs">
                    <div class="flex items-center gap-2">
                        <div class="w-2.5 h-2.5 bg-purple-500 rounded-full"></div>
                        <span class="text-gray-700">Blog Views</span>
                    </div>
                    <span>{{ number_format($totalBlogViews) }}</span>
                </div>

                <div class="flex items-center justify-between text-xs">
                    <div class="flex items-center gap-2">
                        <div class="w-2.5 h-2.5 bg-purple-300 rounded-full"></div>
                        <span class="text-gray-700">Portfolio Views</span>
                    </div>
                    <span>{{ number_format($totalPortfolioViews) }}</span>
                </div>
            </div>
        </div>

    </div>
