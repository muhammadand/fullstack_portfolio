<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Performa Blog - Partner Dashboard</title>
    <x-affiliate.pwa-meta />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            background-color: #0B1120;
            color: #ffffff;
            font-family: 'Inter', sans-serif;
            -webkit-tap-highlight-color: transparent;
        }

        .glass-panel {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

    </style>
</head>
<body class="pb-24 overflow-x-hidden min-h-screen flex flex-col relative">

    <x-affiliate.page-loader />

    <!-- Background Decoration -->
    <div class="fixed top-0 left-0 w-full h-64 bg-indigo-600/20 rounded-full blur-[100px] -translate-y-1/2 pointer-events-none z-0"></div>

    <div class="relative z-10 w-full max-w-md mx-auto flex flex-col min-h-screen px-4 pt-6">

        <!-- Header -->
        <div class="flex items-center justify-between mb-8">
            <div class="flex items-center gap-4">
                <a href="{{ route('affiliate.dashboard') }}" class="w-10 h-10 rounded-full glass-panel flex items-center justify-center text-slate-300 hover:text-white transition-colors">
                    <i class="fa-solid fa-arrow-left"></i>
                </a>
                <div>
                    <p class="text-xs text-indigo-400 font-medium tracking-wider uppercase">Analitik</p>
                    <h1 class="text-xl font-bold text-white">Performa Blog</h1>
                </div>
            </div>
        </div>

        <!-- Summary Stats -->
        @php
        $totalViews = $blogs->sum('view_count');
        $totalClicks = $blogs->sum('link_clicks');
        $avgCtr = $totalViews > 0 ? round(($totalClicks / $totalViews) * 100, 1) : 0;
        @endphp

        <div class="grid grid-cols-2 gap-4 mb-6">
            <div class="glass-panel rounded-2xl p-4 flex flex-col relative overflow-hidden">
                <div class="absolute -right-4 -top-4 w-16 h-16 bg-blue-500/20 rounded-full blur-xl"></div>
                <div class="w-8 h-8 rounded-full bg-blue-500/20 text-blue-400 flex items-center justify-center mb-3">
                    <i class="fa-solid fa-eye text-sm"></i>
                </div>
                <p class="text-xs text-slate-400 font-medium mb-1">Total Views</p>
                <h3 class="text-2xl font-bold text-white">{{ number_format($totalViews) }}</h3>
            </div>

            <div class="glass-panel rounded-2xl p-4 flex flex-col relative overflow-hidden">
                <div class="absolute -right-4 -top-4 w-16 h-16 bg-orange-500/20 rounded-full blur-xl"></div>
                <div class="w-8 h-8 rounded-full bg-orange-500/20 text-orange-400 flex items-center justify-center mb-3">
                    <i class="fa-solid fa-mouse-pointer text-sm"></i>
                </div>
                <p class="text-xs text-slate-400 font-medium mb-1">Total Clicks</p>
                <h3 class="text-2xl font-bold text-white">{{ number_format($totalClicks) }}</h3>
            </div>
        </div>

        <!-- Article List -->
        <h2 class="text-sm font-bold text-white mb-4">Detail Per Artikel</h2>
        <div class="flex flex-col gap-4">
            @forelse($blogs as $blog)
            @php
            $ctr = $blog->view_count > 0 ? round(($blog->link_clicks / $blog->view_count) * 100, 1) : 0;
            @endphp
            <div class="glass-panel rounded-2xl p-4 flex flex-col gap-3 relative overflow-hidden shadow-lg shadow-black/20">
                <div class="flex justify-between items-start gap-2">
                    <h3 class="text-sm font-bold text-white leading-tight line-clamp-2">{{ $blog->title }}</h3>
                    <a href="{{ route('blogs.read', $blog->slug) }}?ref={{ $affiliate->affiliate_code }}" target="_blank" class="shrink-0 w-7 h-7 rounded-full bg-white/5 flex items-center justify-center text-slate-400 hover:text-white hover:bg-white/10 transition-colors">
                        <i class="fa-solid fa-external-link-alt text-[10px]"></i>
                    </a>
                </div>

                <div class="grid grid-cols-3 gap-2 mt-1">
                    <div class="bg-[#0B1120]/50 rounded-lg p-2 text-center border border-white/5">
                        <p class="text-[9px] text-slate-400 uppercase tracking-wider mb-1">Views</p>
                        <p class="text-xs font-bold text-blue-400">{{ number_format($blog->view_count) }}</p>
                    </div>
                    <div class="bg-[#0B1120]/50 rounded-lg p-2 text-center border border-white/5">
                        <p class="text-[9px] text-slate-400 uppercase tracking-wider mb-1">Clicks</p>
                        <p class="text-xs font-bold text-orange-400">{{ number_format($blog->link_clicks) }}</p>
                    </div>
                    <div class="bg-[#0B1120]/50 rounded-lg p-2 text-center border border-white/5">
                        <p class="text-[9px] text-slate-400 uppercase tracking-wider mb-1">CTR</p>
                        <p class="text-xs font-bold text-emerald-400">{{ $ctr }}%</p>
                    </div>
                </div>

                <div class="text-[10px] text-slate-500 mt-1 flex justify-between items-center">
                    <span><i class="fa-regular fa-calendar mr-1"></i> {{ $blog->published_at ? $blog->published_at->format('d M Y') : 'Belum Publish' }}</span>
                    <span class="text-orange-500/80">{{ $blog->businessCategory->name ?? 'Umum' }}</span>
                </div>
            </div>
            @empty
            <div class="p-8 text-center glass-panel rounded-2xl flex flex-col items-center shadow-lg shadow-black/20">
                <div class="w-16 h-16 rounded-full bg-white/5 flex items-center justify-center text-2xl mb-3 text-slate-500">
                    <i class="fa-solid fa-chart-simple"></i>
                </div>
                <p class="text-white font-semibold mb-1">Belum Ada Data</p>
                <p class="text-xs text-slate-400">Data analitik akan muncul setelah artikelmu dibaca orang.</p>
            </div>
            @endforelse
        </div>
    </div>

    <x-affiliate.bottom-nav />
    <x-affiliate.scripts />
</body>
</html>
