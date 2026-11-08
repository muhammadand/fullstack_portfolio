@extends('layouts.admin.app')

@section('content')
<div x-data="{
    copyFeedback: '',
    sharePlatform: 'threads',
    baseCardUrl: '{{ url('/google-review-card') }}',
    get generatedUrl() {
        return this.baseCardUrl + '?src=' + this.sharePlatform;
    },
    copyGeneratedLink() {
        navigator.clipboard.writeText(this.generatedUrl).then(() => {
            this.copyFeedback = 'Link ' + this.sharePlatform + ' berhasil disalin!';
            setTimeout(() => this.copyFeedback = '', 3000);
        });
    }
}" class="space-y-6">

    {{-- Page Header --}}
    <x-admin.page-header title="Analitik Google Review Cards" subtitle="Pengunjung landing page Google Review Card & evaluasi performa kanal promosi." :back="route('admin.review_cards.index')">
        <x-admin.button variant="secondary" icon="fa-solid fa-id-card-clip" :href="route('admin.review_cards.index')">
            Kelola Kartu
        </x-admin.button>
        <x-admin.button variant="primary" icon="fa-solid fa-arrow-up-right-from-square" :href="route('landing.google_review_card')" target="_blank">
            Buka Halaman Publik
        </x-admin.button>
    </x-admin.page-header>

    {{-- ===== 1. TOP STATS CARDS ===== --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-2.5 lg:gap-4">
        <x-admin.stat label="Total Kunjungan" :value="$totalVisits" icon="fa-solid fa-eye" tone="blue" />
        <x-admin.stat label="IP Unik" :value="$uniqueVisits" icon="fa-solid fa-fingerprint" tone="indigo" />
        <x-admin.stat label="Hari Ini" :value="$todayVisits" icon="fa-solid fa-calendar-day" tone="emerald" />
        <x-admin.stat label="Dari Medsos" :value="$socialVisits" icon="fa-solid fa-share-nodes" tone="purple">{{ $socialPct }}% · SEO {{ number_format($seoVisits) }} ({{ $seoPct }}%)</x-admin.stat>
    </div>

    {{-- ===== 2. TREN KUNJUNGAN CHART & PERANGKAT ===== --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- Visitors 30 Days Chart (Col 2) --}}
        <x-admin.card class="lg:col-span-2 flex flex-col justify-between">
            <div>
                {{-- Header + Filter buttons --}}
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-4">
                    <div>
                        <div class="flex items-center gap-2">
                            <h3 class="font-bold text-slate-900 text-sm">Tren Kunjungan Halaman Google Review Card</h3>
                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-semibold bg-emerald-50 text-emerald-600 border border-emerald-200">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span> Live Track
                            </span>
                        </div>
                        <p class="text-xs text-slate-500 mt-0.5">Grafik kunjungan harian per IP unik (real-time visitor)</p>
                    </div>

                    {{-- Time Range Filter Pills --}}
                    <div class="inline-flex p-1 bg-slate-100 rounded-lg border border-slate-200 self-start sm:self-auto">
                        <button type="button" onclick="changeChartRange(7)" id="range-btn-7" class="range-btn px-2.5 py-1 text-xs font-semibold rounded-md text-slate-600 hover:text-slate-900 transition-all cursor-pointer">
                            7 Hari
                        </button>
                        <button type="button" onclick="changeChartRange(14)" id="range-btn-14" class="range-btn px-2.5 py-1 text-xs font-semibold rounded-md text-slate-600 hover:text-slate-900 transition-all cursor-pointer">
                            14 Hari
                        </button>
                        <button type="button" onclick="changeChartRange(30)" id="range-btn-30" class="range-btn px-2.5 py-1 text-xs font-semibold rounded-md bg-white text-blue-600 shadow-sm transition-all cursor-pointer">
                            30 Hari
                        </button>
                    </div>
                </div>

                {{-- Metric Insight Badges --}}
                <div class="grid grid-cols-3 gap-2 sm:gap-3 p-3 bg-slate-50 rounded-lg border border-slate-200 mb-4">
                    <div>
                        <span class="text-[10px] text-slate-400 font-medium block">Total 30 Hari</span>
                        <span class="text-sm sm:text-base font-bold text-slate-800">{{ number_format($chartStats['total_30']) }}</span>
                        <span class="text-[10px] text-slate-400 ml-0.5">kunjungan</span>
                    </div>
                    <div class="border-x border-slate-200 px-2 sm:px-3">
                        <span class="text-[10px] text-slate-400 font-medium block">Rata-rata Harian</span>
                        <span class="text-sm sm:text-base font-bold text-blue-600">{{ $chartStats['avg_per_day'] }}</span>
                        <span class="text-[10px] text-slate-400 ml-0.5">/hari</span>
                    </div>
                    <div class="text-right sm:text-left">
                        <span class="text-[10px] text-slate-400 font-medium block">Puncak Tertinggi</span>
                        <span class="text-sm sm:text-base font-bold text-emerald-600">{{ number_format($chartStats['peak_count']) }}</span>
                        <span class="text-[10px] text-slate-400 ml-0.5">({{ $chartStats['peak_day'] }})</span>
                    </div>
                </div>
            </div>

            {{-- Canvas --}}
            <div class="relative w-full h-[220px]">
                <canvas id="visitsChart"></canvas>
            </div>
        </x-admin.card>

        {{-- Side Column: Device Breakdown + Kanal Breakdown (Col 1) --}}
        <div class="space-y-6">

            {{-- Tipe Perangkat --}}
            <x-admin.card title="Tipe Perangkat" icon="fa-solid fa-mobile-screen-button">
                @php
                $totalDev = $deviceStats->sum('total') ?: 1;
                $devColors = ['desktop' => 'bg-blue-500', 'mobile' => 'bg-emerald-500', 'tablet' => 'bg-amber-500'];
                $devIcons = ['desktop' => 'fa-desktop', 'mobile' => 'fa-mobile-screen', 'tablet' => 'fa-tablet-screen-button'];
                @endphp
                <div class="space-y-3">
                    @forelse($deviceStats as $dev)
                    @php $pct = round($dev->total / $totalDev * 100); @endphp
                    <div>
                        <div class="flex items-center justify-between text-xs mb-1">
                            <span class="flex items-center gap-1.5 text-slate-600 font-medium capitalize">
                                <i class="fa-solid {{ $devIcons[$dev->device_type] ?? 'fa-globe' }} text-slate-400 w-3.5 text-center"></i>
                                {{ ucfirst($dev->device_type ?? 'Unknown') }}
                            </span>
                            <span class="text-slate-500 font-semibold">{{ number_format($dev->total) }} ({{ $pct }}%)</span>
                        </div>
                        <div class="h-2 bg-slate-100 rounded-full overflow-hidden">
                            <div class="{{ $devColors[$dev->device_type] ?? 'bg-slate-400' }} h-full rounded-full transition-all" style="width: {{ $pct }}%"></div>
                        </div>
                    </div>
                    @empty
                    <p class="text-xs text-slate-400">Belum ada data perangkat.</p>
                    @endforelse
                </div>
            </x-admin.card>

            {{-- Distribusi Kanal Sumber (SEO vs Medsos vs WA vs Direct) --}}
            <x-admin.card title="Kanal Rujukan Utama" icon="fa-solid fa-share-nodes">
                <div class="space-y-3 text-xs">
                    <div>
                        <div class="flex items-center justify-between mb-1">
                            <span class="text-slate-600 font-medium flex items-center gap-1.5">
                                <i class="fa-brands fa-google text-emerald-500 w-3.5 text-center"></i> SEO &amp; Organik
                            </span>
                            <span class="text-slate-500 font-semibold">{{ number_format($seoVisits) }} ({{ $seoPct }}%)</span>
                        </div>
                        <div class="h-2 bg-slate-100 rounded-full overflow-hidden">
                            <div class="bg-emerald-500 h-full rounded-full transition-all" style="width: {{ $seoPct }}%"></div>
                        </div>
                    </div>

                    <div>
                        <div class="flex items-center justify-between mb-1">
                            <span class="text-slate-600 font-medium flex items-center gap-1.5">
                                <i class="fa-brands fa-threads text-purple-600 w-3.5 text-center"></i> Media Sosial
                            </span>
                            <span class="text-slate-500 font-semibold">{{ number_format($socialVisits) }} ({{ $socialPct }}%)</span>
                        </div>
                        <div class="h-2 bg-slate-100 rounded-full overflow-hidden">
                            <div class="bg-purple-500 h-full rounded-full transition-all" style="width: {{ $socialPct }}%"></div>
                        </div>
                    </div>

                    <div>
                        <div class="flex items-center justify-between mb-1">
                            <span class="text-slate-600 font-medium flex items-center gap-1.5">
                                <i class="fa-brands fa-whatsapp text-teal-500 w-3.5 text-center"></i> Link Dibagikan (WA)
                            </span>
                            <span class="text-slate-500 font-semibold">{{ number_format($sharedVisits) }} ({{ $sharedPct }}%)</span>
                        </div>
                        <div class="h-2 bg-slate-100 rounded-full overflow-hidden">
                            <div class="bg-teal-500 h-full rounded-full transition-all" style="width: {{ $sharedPct }}%"></div>
                        </div>
                    </div>

                    <div>
                        <div class="flex items-center justify-between mb-1">
                            <span class="text-slate-600 font-medium flex items-center gap-1.5">
                                <i class="fa-solid fa-arrow-pointer text-amber-500 w-3.5 text-center"></i> Direct &amp; Bookmark
                            </span>
                            <span class="text-slate-500 font-semibold">{{ number_format($directVisits) }} ({{ $directPct }}%)</span>
                        </div>
                        <div class="h-2 bg-slate-100 rounded-full overflow-hidden">
                            <div class="bg-amber-500 h-full rounded-full transition-all" style="width: {{ $directPct }}%"></div>
                        </div>
                    </div>
                </div>
            </x-admin.card>

        </div>
    </div>

    {{-- ===== 3. SMART MARKETING LINK GENERATOR WIDGET ===== --}}
    <div class="bg-gradient-to-r from-slate-900 via-indigo-950 to-slate-900 rounded-xl p-5 text-white shadow-sm border border-indigo-950">
        <div class="flex flex-col lg:flex-row items-start lg:items-center justify-between gap-4">
            <div class="max-w-xl">
                <div class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-blue-500/20 border border-blue-400/30 text-blue-300 text-[11px] font-semibold mb-2">
                    <i class="fa-solid fa-wand-magic-sparkles text-xs"></i>
                    Generator Link Tracking Otomatis
                </div>
                <h3 class="text-base font-bold text-white leading-tight">Buat Link Kampanye yang Otomatis Terlacak</h3>
                <p class="text-xs text-slate-300 mt-1">Pilih kanal promosi untuk mendapatkan link dengan tag otomatis, sehingga kunjungan dari tiap postingan langsung terdata di dashboard ini.</p>
            </div>

            <div class="w-full lg:w-auto flex-1 max-w-xl">
                <div class="flex flex-wrap items-center gap-1.5 mb-2.5">
                    <button type="button" @click="sharePlatform = 'threads'" :class="sharePlatform === 'threads' ? 'bg-purple-600 text-white shadow-sm' : 'bg-white/10 text-slate-300 hover:bg-white/15'" class="px-3 py-1.5 rounded-lg text-xs font-semibold flex items-center gap-1.5 transition-all cursor-pointer">
                        <i class="fa-brands fa-threads"></i> Threads
                    </button>
                    <button type="button" @click="sharePlatform = 'whatsapp'" :class="sharePlatform === 'whatsapp' ? 'bg-emerald-600 text-white shadow-sm' : 'bg-white/10 text-slate-300 hover:bg-white/15'" class="px-3 py-1.5 rounded-lg text-xs font-semibold flex items-center gap-1.5 transition-all cursor-pointer">
                        <i class="fa-brands fa-whatsapp"></i> WhatsApp
                    </button>
                    <button type="button" @click="sharePlatform = 'instagram'" :class="sharePlatform === 'instagram' ? 'bg-rose-600 text-white shadow-sm' : 'bg-white/10 text-slate-300 hover:bg-white/15'" class="px-3 py-1.5 rounded-lg text-xs font-semibold flex items-center gap-1.5 transition-all cursor-pointer">
                        <i class="fa-brands fa-instagram"></i> Instagram
                    </button>
                    <button type="button" @click="sharePlatform = 'facebook'" :class="sharePlatform === 'facebook' ? 'bg-blue-600 text-white shadow-sm' : 'bg-white/10 text-slate-300 hover:bg-white/15'" class="px-3 py-1.5 rounded-lg text-xs font-semibold flex items-center gap-1.5 transition-all cursor-pointer">
                        <i class="fa-brands fa-facebook"></i> Facebook
                    </button>
                    <button type="button" @click="sharePlatform = 'tiktok'" :class="sharePlatform === 'tiktok' ? 'bg-slate-700 text-white shadow-sm' : 'bg-white/10 text-slate-300 hover:bg-white/15'" class="px-3 py-1.5 rounded-lg text-xs font-semibold flex items-center gap-1.5 transition-all cursor-pointer">
                        <i class="fa-brands fa-tiktok"></i> TikTok
                    </button>
                </div>

                <div class="flex items-center gap-2">
                    <div class="flex-1 bg-black/40 border border-white/15 rounded-xl px-3 py-2 text-xs font-mono text-cyan-300 truncate select-all" x-text="generatedUrl"></div>
                    <button type="button" @click="copyGeneratedLink()" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-xs font-medium rounded-lg flex items-center gap-1.5 transition-colors shrink-0 shadow-sm active:scale-95 cursor-pointer">
                        <i class="fa-regular fa-copy"></i>
                        <span>Salin Link</span>
                    </button>
                </div>

                <div x-show="copyFeedback" x-transition class="text-xs text-emerald-400 font-medium mt-1.5 flex items-center gap-1.5">
                    <i class="fa-solid fa-check"></i>
                    <span x-text="copyFeedback"></span>
                </div>
            </div>
        </div>
    </div>

    {{-- ===== 4. REAL-TIME VISITOR LOGS TABLE ===== --}}
    <x-admin.card :padding="false">
        <div class="p-4 border-b border-slate-200 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h3 class="font-semibold text-slate-900 text-sm">Semua Aktivitas Kunjungan</h3>
                <p class="text-xs text-slate-500 mt-0.5">{{ number_format($totalVisits) }} log kunjungan pengunjung tercatat</p>
            </div>

            {{-- Filter by Source Category --}}
            <div class="flex flex-wrap items-center gap-1.5">
                <a href="{{ route('admin.review_cards.analytics') }}" class="px-3 py-1.5 rounded-lg text-xs font-medium transition-colors {{ empty($sourceFilter) ? 'bg-slate-900 text-white shadow-sm' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                    Semua
                </a>
                <a href="{{ route('admin.review_cards.analytics', ['source' => 'seo']) }}" class="px-3 py-1.5 rounded-lg text-xs font-medium transition-colors {{ $sourceFilter === 'seo' ? 'bg-emerald-600 text-white shadow-sm' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                    <i class="fa-brands fa-google mr-1"></i> SEO
                </a>
                <a href="{{ route('admin.review_cards.analytics', ['source' => 'social']) }}" class="px-3 py-1.5 rounded-lg text-xs font-medium transition-colors {{ $sourceFilter === 'social' ? 'bg-purple-600 text-white shadow-sm' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                    <i class="fa-brands fa-threads mr-1"></i> Medsos
                </a>
                <a href="{{ route('admin.review_cards.analytics', ['source' => 'shared']) }}" class="px-3 py-1.5 rounded-lg text-xs font-medium transition-colors {{ $sourceFilter === 'shared' ? 'bg-teal-600 text-white shadow-sm' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                    <i class="fa-brands fa-whatsapp mr-1"></i> Dibagikan
                </a>
                <a href="{{ route('admin.review_cards.analytics', ['source' => 'direct']) }}" class="px-3 py-1.5 rounded-lg text-xs font-medium transition-colors {{ $sourceFilter === 'direct' ? 'bg-amber-600 text-white shadow-sm' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                    Direct
                </a>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full text-xs">
                <thead class="bg-slate-50 text-left text-xs font-semibold uppercase tracking-wider text-slate-500 border-b border-slate-200">
                    <tr>
                        <th class="px-5 py-3">Waktu</th>
                        <th class="px-5 py-3">Kategori</th>
                        <th class="px-5 py-3">Sumber / Platform</th>
                        <th class="px-5 py-3">Perangkat</th>
                        <th class="px-5 py-3">Referer Asli</th>
                        <th class="px-5 py-3">IP Address</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    @forelse($recentLogs as $log)
                    @php
                    $badgeColor = match($log->source_type) {
                        'seo' => 'green',
                        'social' => 'blue',
                        'shared' => 'blue',
                        default => 'yellow',
                    };
                    $createdAt = \Carbon\Carbon::parse($log->created_at);
                    @endphp
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-5 py-3.5 text-slate-500 whitespace-nowrap">
                            <div class="font-semibold text-slate-900">{{ $createdAt->format('d M Y, H:i') }}</div>
                            <div class="text-[10px] text-slate-400">{{ $createdAt->diffForHumans() }}</div>
                        </td>
                        <td class="px-5 py-3.5 whitespace-nowrap">
                            <x-admin.badge :color="$badgeColor">
                                <i class="fa-solid fa-circle text-[6px]"></i>
                                {{ match($log->source_type) {
                                    'seo' => 'SEO (Organik)',
                                    'social' => 'Media Sosial',
                                    'shared' => 'Link Dibagikan',
                                    default => 'Direct / Bookmark',
                                } }}
                            </x-admin.badge>
                        </td>
                        <td class="px-5 py-3.5 whitespace-nowrap font-medium text-slate-900">
                            {{ $log->source_name }}
                            @if($log->utm_source)
                            <span class="text-[10px] text-blue-600 font-normal block font-mono">?src={{ $log->utm_source }}</span>
                            @endif
                        </td>
                        <td class="px-5 py-3.5 whitespace-nowrap">
                            <span class="inline-flex items-center gap-1.5 text-slate-600 capitalize">
                                @if($log->device_type === 'mobile')
                                <i class="fa-solid fa-mobile-screen text-blue-500"></i> HP / Mobile
                                @elseif($log->device_type === 'tablet')
                                <i class="fa-solid fa-tablet-screen-button text-purple-500"></i> Tablet
                                @else
                                <i class="fa-solid fa-desktop text-indigo-500"></i> Desktop
                                @endif
                            </span>
                        </td>
                        <td class="px-5 py-3.5 max-w-xs truncate text-slate-500" title="{{ $log->referer ?? 'Tidak ada referer' }}">
                            {{ $log->referer ?? '—' }}
                        </td>
                        <td class="px-5 py-3.5 text-slate-600 font-mono text-[11px] whitespace-nowrap">
                            {{ $log->ip_address ?? '—' }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-5 py-12 text-center text-slate-400">
                            <i class="fa-regular fa-folder-open text-3xl mb-2 block opacity-40"></i>
                            Belum ada data kunjungan yang tercatat
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($recentLogs->hasPages())
        <div class="p-4 border-t border-slate-200">
            {{ $recentLogs->links('pagination::tailwind') }}
        </div>
        @endif
    </x-admin.card>

</div>

{{-- Load Chart.js CDN (Mengikuti Standar CV Service) --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js@4"></script>
<script>
    const fullLabels = @json($chartLabels);
    const fullData = @json($chartData);

    const canvas = document.getElementById('visitsChart');
    const ctx = canvas.getContext('2d');

    // Create modern gradient fill (Standar CV Service)
    const gradient = ctx.createLinearGradient(0, 0, 0, 220);
    gradient.addColorStop(0, 'rgba(37, 99, 235, 0.25)'); // #2563eb
    gradient.addColorStop(1, 'rgba(37, 99, 235, 0.00)');

    const chartConfig = {
        type: 'line',
        data: {
            labels: [...fullLabels],
            datasets: [{
                label: 'Kunjungan Unik',
                data: [...fullData],
                borderColor: '#2563eb',
                borderWidth: 2.5,
                backgroundColor: gradient,
                fill: true,
                tension: 0.38,
                pointBackgroundColor: '#2563eb',
                pointBorderColor: '#ffffff',
                pointBorderWidth: 2,
                pointRadius: 3,
                pointHoverRadius: 6,
                pointHoverBackgroundColor: '#1d4ed8',
                pointHoverBorderColor: '#ffffff',
                pointHoverBorderWidth: 2.5,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            interaction: {
                mode: 'index',
                intersect: false,
            },
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: 'rgba(15, 23, 42, 0.92)',
                    titleColor: '#ffffff',
                    bodyColor: '#93c5fd',
                    titleFont: {
                        size: 12,
                        weight: '600'
                    },
                    bodyFont: {
                        size: 12,
                        weight: '700'
                    },
                    padding: 10,
                    cornerRadius: 8,
                    displayColors: false,
                    callbacks: {
                        label: function(context) {
                            return ` ${context.parsed.y} Kunjungan Pengunjung`;
                        }
                    }
                }
            },
            scales: {
                x: {
                    grid: {
                        display: false
                    },
                    ticks: {
                        font: {
                            size: 11
                        },
                        color: '#94a3b8',
                        maxTicksLimit: 10,
                        maxRotation: 0,
                    }
                },
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(226, 232, 240, 0.6)',
                    },
                    ticks: {
                        precision: 0,
                        font: {
                            size: 11
                        },
                        color: '#94a3b8',
                        padding: 8,
                    }
                }
            }
        }
    };

    const visitsChart = new Chart(canvas, chartConfig);

    // Interactive Range switcher (Standar CV Service)
    function changeChartRange(days) {
        document.querySelectorAll('.range-btn').forEach(btn => {
            btn.classList.remove('bg-white', 'text-blue-600', 'shadow-sm');
            btn.classList.add('text-slate-600');
        });
        const activeBtn = document.getElementById(`range-btn-${days}`);
        if (activeBtn) {
            activeBtn.classList.add('bg-white', 'text-blue-600', 'shadow-sm');
            activeBtn.classList.remove('text-slate-600');
        }

        const slicedLabels = fullLabels.slice(-days);
        const slicedData = fullData.slice(-days);

        visitsChart.data.labels = slicedLabels;
        visitsChart.data.datasets[0].data = slicedData;
        visitsChart.update('active');
    }
</script>
@endsection
