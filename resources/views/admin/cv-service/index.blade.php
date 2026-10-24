@extends('layouts.admin.app')

@section('content')

{{-- Page Header --}}
<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
    <div>
        <p class="text-[10px] sm:text-xs text-slate-400 font-medium uppercase tracking-widest mb-0.5">Layanan</p>
        <h2 class="text-slate-800 font-bold text-xl sm:text-2xl leading-tight">CV Service Analytics</h2>
        <p class="text-slate-500 text-xs mt-0.5">Pengunjung halaman &amp; ulasan pengguna CV Builder</p>
    </div>
    <a href="{{ route('layanan.cv') }}" target="_blank"
        class="flex items-center gap-2 px-4 py-2 rounded-lg text-xs font-semibold text-white shadow-sm"
        style="background: linear-gradient(90deg, #0ea5e9, #2563EB);">
        <i class="fa-solid fa-arrow-up-right-from-square"></i> Buka Halaman CV
    </a>
</div>

{{-- ===== STATS CARDS ===== --}}
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    {{-- Total Pengunjung --}}
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5">
        <div class="flex items-center justify-between mb-3">
            <div class="w-9 h-9 rounded-xl bg-blue-50 flex items-center justify-center">
                <i class="fa-solid fa-eye text-blue-500 text-sm"></i>
            </div>
            <span class="text-[10px] font-semibold text-slate-400 uppercase tracking-wider">Total</span>
        </div>
        <p class="text-2xl font-black text-slate-800">{{ number_format($totalVisits) }}</p>
        <p class="text-xs text-slate-400 mt-0.5">Total Kunjungan</p>
    </div>

    {{-- Unique Pengunjung --}}
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5">
        <div class="flex items-center justify-between mb-3">
            <div class="w-9 h-9 rounded-xl bg-emerald-50 flex items-center justify-center">
                <i class="fa-solid fa-users text-emerald-500 text-sm"></i>
            </div>
            <span class="text-[10px] font-semibold text-slate-400 uppercase tracking-wider">Unik</span>
        </div>
        <p class="text-2xl font-black text-slate-800">{{ number_format($uniqueVisits) }}</p>
        <p class="text-xs text-slate-400 mt-0.5">IP Unik</p>
    </div>

    {{-- Hari Ini --}}
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5">
        <div class="flex items-center justify-between mb-3">
            <div class="w-9 h-9 rounded-xl bg-amber-50 flex items-center justify-center">
                <i class="fa-solid fa-calendar-day text-amber-500 text-sm"></i>
            </div>
            <span class="text-[10px] font-semibold text-slate-400 uppercase tracking-wider">Hari Ini</span>
        </div>
        <p class="text-2xl font-black text-slate-800">{{ number_format($todayVisits) }}</p>
        <p class="text-xs text-slate-400 mt-0.5">Kunjungan Hari Ini</p>
    </div>

    {{-- Reviews --}}
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5">
        <div class="flex items-center justify-between mb-3">
            <div class="w-9 h-9 rounded-xl bg-rose-50 flex items-center justify-center">
                <i class="fa-solid fa-star text-rose-500 text-sm"></i>
            </div>
            <span class="text-[10px] font-semibold text-slate-400 uppercase tracking-wider">Rating</span>
        </div>
        <p class="text-2xl font-black text-slate-800">
            {{ $avgRating > 0 ? $avgRating : '—' }}
            <span class="text-sm font-medium text-slate-400">/5</span>
        </p>
        <p class="text-xs text-slate-400 mt-0.5">Avg dari {{ number_format($totalReviews) }} ulasan</p>
    </div>
</div>

{{-- ===== CHARTS ROW ===== --}}
<div class="grid grid-cols-1 lg:grid-cols-3 gap-5 mb-6">

    {{-- Visitors 30 Days Chart --}}
    <div class="lg:col-span-2 bg-white rounded-2xl border border-slate-100 shadow-sm p-5 flex flex-col justify-between">
        <div>
            {{-- Header + Filter buttons --}}
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-4">
                <div>
                    <div class="flex items-center gap-2">
                        <p class="font-bold text-slate-800 text-sm">Tren Kunjungan Halaman CV</p>
                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-semibold bg-emerald-50 text-emerald-600 border border-emerald-200/60">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span> Live Track
                        </span>
                    </div>
                    <p class="text-xs text-slate-400 mt-0.5">Grafik kunjungan harian per IP unik (real-time visitor)</p>
                </div>

                {{-- Time Range Filter Pills --}}
                <div class="inline-flex p-1 bg-slate-100/80 rounded-xl border border-slate-200/50 self-start sm:self-auto">
                    <button type="button" onclick="changeChartRange(7)" id="range-btn-7"
                        class="range-btn px-2.5 py-1 text-xs font-semibold rounded-lg text-slate-600 hover:text-slate-900 transition-all">
                        7 Hari
                    </button>
                    <button type="button" onclick="changeChartRange(14)" id="range-btn-14"
                        class="range-btn px-2.5 py-1 text-xs font-semibold rounded-lg text-slate-600 hover:text-slate-900 transition-all">
                        14 Hari
                    </button>
                    <button type="button" onclick="changeChartRange(30)" id="range-btn-30"
                        class="range-btn px-2.5 py-1 text-xs font-semibold rounded-lg bg-white text-blue-600 shadow-sm transition-all">
                        30 Hari
                    </button>
                </div>
            </div>

            {{-- Metric Insight Badges --}}
            <div class="grid grid-cols-3 gap-2 sm:gap-3 p-3 bg-slate-50/70 rounded-xl border border-slate-100 mb-4">
                <div>
                    <span class="text-[10px] text-slate-400 font-medium block">Total 30 Hari</span>
                    <span class="text-sm sm:text-base font-bold text-slate-700">{{ number_format($chartStats['total_30']) }}</span>
                    <span class="text-[10px] text-slate-400 ml-0.5">kunjungan</span>
                </div>
                <div class="border-x border-slate-200/60 px-2 sm:px-3">
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
    </div>

    {{-- Device Breakdown + Rating Dist --}}
    <div class="space-y-4">

        {{-- Device --}}
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5">
            <p class="font-semibold text-slate-700 text-sm mb-4">Tipe Perangkat</p>
            @php
                $totalDev = $deviceStats->sum('total') ?: 1;
                $devColors = ['desktop' => 'bg-blue-500', 'mobile' => 'bg-emerald-500', 'tablet' => 'bg-amber-500'];
                $devIcons  = ['desktop' => 'fa-desktop', 'mobile' => 'fa-mobile-screen', 'tablet' => 'fa-tablet-screen-button'];
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
                        <span class="text-slate-400">{{ number_format($dev->total) }} ({{ $pct }}%)</span>
                    </div>
                    <div class="h-2 bg-slate-100 rounded-full overflow-hidden">
                        <div class="{{ $devColors[$dev->device_type] ?? 'bg-slate-400' }} h-full rounded-full transition-all" style="width: {{ $pct }}%"></div>
                    </div>
                </div>
                @empty
                <p class="text-xs text-slate-400">Belum ada data perangkat.</p>
                @endforelse
            </div>
        </div>

        {{-- Rating Distribution --}}
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5">
            <p class="font-semibold text-slate-700 text-sm mb-4">Distribusi Rating</p>
            @php $totalRev = $ratingDist->sum('total') ?: 1; @endphp
            <div class="space-y-2">
                @foreach([5,4,3,2,1] as $star)
                @php $found = $ratingDist->firstWhere('rating', $star); $cnt = $found ? $found->total : 0; $pct = round($cnt / $totalRev * 100); @endphp
                <div class="flex items-center gap-2 text-xs">
                    <span class="text-amber-400 w-14 shrink-0">
                        @for($i=1;$i<=5;$i++)<i class="fa-{{ $i <= $star ? 'solid' : 'regular' }} fa-star text-[10px]"></i>@endfor
                    </span>
                    <div class="flex-1 h-2 bg-slate-100 rounded-full overflow-hidden">
                        <div class="bg-amber-400 h-full rounded-full" style="width: {{ $pct }}%"></div>
                    </div>
                    <span class="text-slate-400 w-6 text-right">{{ $cnt }}</span>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

{{-- ===== REVIEWS TABLE ===== --}}
<div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
    <div class="flex items-center justify-between px-5 py-4 border-b border-slate-100">
        <div>
            <p class="font-semibold text-slate-700 text-sm">Semua Ulasan</p>
            <p class="text-xs text-slate-400">{{ number_format($totalReviews) }} ulasan masuk</p>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-xs">
            <thead>
                <tr class="bg-slate-50 border-b border-slate-100">
                    <th class="px-5 py-3 text-left text-[10px] font-semibold text-slate-400 uppercase tracking-wider">#</th>
                    <th class="px-5 py-3 text-left text-[10px] font-semibold text-slate-400 uppercase tracking-wider">Waktu</th>
                    <th class="px-5 py-3 text-left text-[10px] font-semibold text-slate-400 uppercase tracking-wider">Rating</th>
                    <th class="px-5 py-3 text-left text-[10px] font-semibold text-slate-400 uppercase tracking-wider">Catatan</th>
                    <th class="px-5 py-3 text-left text-[10px] font-semibold text-slate-400 uppercase tracking-wider">IP</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($reviews as $review)
                <tr class="hover:bg-slate-50 transition-colors">
                    <td class="px-5 py-3.5 text-slate-400">{{ $review->id }}</td>
                    <td class="px-5 py-3.5 text-slate-500 whitespace-nowrap">
                        {{ $review->created_at->format('d M Y, H:i') }}
                    </td>
                    <td class="px-5 py-3.5">
                        <span class="flex items-center gap-0.5 text-amber-400">
                            @for($i = 1; $i <= 5; $i++)
                                <i class="fa-{{ $i <= $review->rating ? 'solid' : 'regular' }} fa-star text-[11px]"></i>
                            @endfor
                            <span class="ml-1 text-slate-500 font-semibold">{{ $review->rating }}</span>
                        </span>
                    </td>
                    <td class="px-5 py-3.5 text-slate-600 max-w-sm">
                        {{ $review->note ?: '—' }}
                    </td>
                    <td class="px-5 py-3.5 text-slate-400 font-mono">{{ $review->ip_address ?? '—' }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-5 py-10 text-center text-slate-400">
                        <i class="fa-regular fa-comment-dots text-2xl mb-2 block opacity-30"></i>
                        Belum ada ulasan masuk
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($reviews->hasPages())
    <div class="px-5 py-4 border-t border-slate-100">
        {{ $reviews->links() }}
    </div>
    @endif
</div>

{{-- Chart.js --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js@4"></script>
<script>
    const fullLabels = @json($chartLabels);
    const fullData   = @json($chartData);

    const canvas = document.getElementById('visitsChart');
    const ctx = canvas.getContext('2d');

    // Create modern gradient fill
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
                legend: { display: false },
                tooltip: {
                    backgroundColor: 'rgba(15, 23, 42, 0.92)',
                    titleColor: '#ffffff',
                    bodyColor: '#93c5fd',
                    titleFont: { size: 12, weight: '600' },
                    bodyFont: { size: 12, weight: '700' },
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
                    grid: { display: false },
                    ticks: {
                        font: { size: 11 },
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
                        font: { size: 11 },
                        color: '#94a3b8',
                        padding: 8,
                    }
                }
            }
        }
    };

    const visitsChart = new Chart(canvas, chartConfig);

    // Interactive Range switcher
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
        const slicedData   = fullData.slice(-days);

        visitsChart.data.labels = slicedLabels;
        visitsChart.data.datasets[0].data = slicedData;
        visitsChart.update('active');
    }
</script>

@endsection
