<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Progres Api Streak - Partner</title>
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
<body class="pb-10 overflow-x-hidden min-h-screen relative">
    <!-- Header -->
    <div class="fixed top-0 left-0 w-full z-50 glass-panel border-b border-white/10 px-5 py-4 flex items-center gap-4">
        <a href="{{ route('affiliate.dashboard') }}" class="w-10 h-10 rounded-full bg-slate-800/80 flex items-center justify-center text-slate-300 hover:text-white transition-colors">
            <i class="fa-solid fa-arrow-left"></i>
        </a>
        <h1 class="text-lg font-bold text-white">Progres Api Streak</h1>
    </div>

    <div class="pt-24 px-5 pb-6">
        <div class="text-center mb-8 mt-4">
            <div class="inline-block px-5 py-2 rounded-full bg-orange-500/20 text-orange-400 font-bold mb-4 border border-orange-500/30 shadow-[0_0_15px_rgba(249,115,22,0.2)]">
                <i class="fa-solid fa-fire mr-1"></i> {{ $streak }} Hari Beruntun!
            </div>
            <p class="text-sm text-slate-300 leading-relaxed px-4">Pertahankan klaim harian Anda selama 7 hari berturut-turut untuk mendapat <b class="text-yellow-400">+50 Poin Bonus</b> di hari ke-7.</p>
        </div>

        <div class="glass-panel p-6 rounded-3xl relative overflow-hidden mb-8">
            <h4 class="text-sm font-bold text-white mb-8 text-center">Progres Minggu Ini</h4>
            <div class="flex justify-between items-center relative z-10 px-2">
                <!-- Garis Background -->
                <div class="absolute top-1/2 left-6 right-6 h-1.5 bg-slate-800 -translate-y-1/2 z-0 rounded-full"></div>

                @for($i = 1; $i <= 7; $i++) @php $isAchieved=$i <=$currentWeekDay; $isToday=$i==$currentWeekDay && $affiliate->last_claim_date === $today;
                    $isNext = $i == $currentWeekDay + 1 && $affiliate->last_claim_date !== $today;
                    if ($streak == 0 && $i == 1) $isNext = true;
                    @endphp

                    <div class="relative z-10 flex flex-col items-center gap-3">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center text-[11px] font-bold border-[3px] transition-all
                            {{ $isAchieved ? 'bg-gradient-to-br from-orange-400 to-red-500 border-red-400 text-white shadow-[0_0_15px_rgba(249,115,22,0.6)]' : 'bg-slate-900 border-slate-700 text-slate-600' }}
                            {{ $isNext ? 'border-orange-500 bg-slate-800 text-orange-500' : '' }}
                        ">
                            @if($isAchieved)
                            <i class="fa-solid fa-check text-sm"></i>
                            @elseif($i == 7)
                            <i class="fa-solid fa-gift text-yellow-500 text-sm"></i>
                            @else
                            {{ $i }}
                            @endif
                        </div>
                        <span class="text-[10px] {{ $isAchieved ? 'text-white font-bold' : 'text-slate-500' }}">Hari {{ $i }}</span>
                    </div>
                    @endfor
            </div>
        </div>

        <!-- Pencapaian Mingguan -->
        <div class="glass-panel p-6 rounded-3xl relative overflow-hidden mb-8">
            <h4 class="text-sm font-bold text-white mb-6 flex items-center gap-2">
                <i class="fa-solid fa-calendar-check text-emerald-400 text-lg"></i> Pencapaian Bulanan
            </h4>

            <div class="grid grid-cols-4 gap-3 relative z-10">
                @for($w = 1; $w <= 4; $w++) @php $isWeekLit=$streak>= ($w * 7);
                    $isWeekCurrent = $streak >= (($w - 1) * 7) && $streak < ($w * 7); @endphp <div class="flex flex-col items-center gap-2">
                        <div class="w-14 h-14 rounded-2xl flex items-center justify-center text-xl transition-all relative overflow-hidden
                            {{ $isWeekLit ? 'bg-gradient-to-br from-orange-400 to-red-500 shadow-[0_0_15px_rgba(249,115,22,0.4)] border border-red-400/50' : 'bg-slate-800/50 border border-white/5' }}
                            {{ $isWeekCurrent ? 'border-orange-500/50 bg-slate-800' : '' }}
                        ">
                            @if($isWeekLit)
                            <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-30 mix-blend-overlay"></div>
                            <i class="fa-solid fa-fire text-white relative z-10 drop-shadow-md"></i>
                            @else
                            <i class="fa-solid fa-fire text-slate-600"></i>
                            @endif
                        </div>
                        <span class="text-[10px] {{ $isWeekLit ? 'text-orange-400 font-bold' : 'text-slate-500' }}">Minggu {{ $w }}</span>
            </div>
            @endfor
        </div>
    </div>

    <div class="glass-panel p-6 rounded-3xl relative overflow-hidden">
        <h4 class="text-sm font-bold text-white mb-5 flex items-center gap-2">
            <i class="fa-solid fa-ranking-star text-yellow-400 text-lg"></i> Level Api
        </h4>

        <div class="space-y-4">
            <div class="flex items-center gap-4 bg-slate-800/40 p-3 rounded-2xl border border-white/5">
                <div class="w-12 h-12 rounded-full bg-orange-500/20 flex items-center justify-center shrink-0">
                    <i class="fa-solid fa-fire text-orange-500 text-xl"></i>
                </div>
                <div class="flex-1">
                    <h5 class="text-sm font-bold text-white">Level 1 (Api Merah)</h5>
                    <p class="text-[11px] text-slate-400 mt-0.5">Berlangsung selama 1 - 29 hari</p>
                </div>
            </div>

            <div class="flex items-center gap-4 bg-slate-800/40 p-3 rounded-2xl border border-white/5">
                <div class="w-12 h-12 rounded-full bg-cyan-500/20 flex items-center justify-center shrink-0 relative">
                    <i class="fa-solid fa-fire text-cyan-400 text-xl"></i>
                    <i class="fa-solid fa-bolt absolute text-[10px] text-white opacity-80 bottom-2 right-2"></i>
                </div>
                <div class="flex-1">
                    <h5 class="text-sm font-bold text-white">Level 2 (Api Biru)</h5>
                    <p class="text-[11px] text-slate-400 mt-0.5">Berlangsung selama 30 - 59 hari</p>
                </div>
            </div>

            <div class="flex items-center gap-4 bg-slate-800/40 p-3 rounded-2xl border border-white/5 relative overflow-hidden">
                <div class="absolute -right-6 -top-6 w-24 h-24 bg-yellow-500/10 rounded-full blur-2xl pointer-events-none"></div>
                <div class="w-12 h-12 rounded-full bg-yellow-500/20 flex items-center justify-center shrink-0 relative z-10">
                    <i class="fa-solid fa-fire text-yellow-400 text-xl drop-shadow-[0_0_10px_rgba(250,204,21,0.8)] animate-pulse"></i>
                    <i class="fa-solid fa-crown absolute text-[12px] text-white opacity-90 -top-2"></i>
                </div>
                <div class="flex-1 relative z-10">
                    <h5 class="text-sm font-bold text-white">Level 3 (Api Emas)</h5>
                    <p class="text-[11px] text-slate-400 mt-0.5">60+ hari tanpa putus!</p>
                </div>
            </div>
        </div>
    </div>
    </div>
</body>
</html>
