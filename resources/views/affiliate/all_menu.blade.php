<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Semua Menu - Partner Hub</title>
    <link rel="preconnect" href="https://cdnjs.cloudflare.com" crossorigin>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <x-affiliate.pwa-meta />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            background-color: #0B1120;
            color: #ffffff;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
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
<body class="pb-28 overflow-x-hidden min-h-screen relative">
    <x-affiliate.page-loader />

    <!-- Ambient Glow Background -->
    <div class="fixed top-0 left-0 w-full h-64 bg-blue-600/15 rounded-full blur-[110px] -translate-y-1/2 pointer-events-none z-0"></div>

    <div class="relative z-10 w-full max-w-md mx-auto px-4 pt-5">

        <!-- Header -->
        <div class="flex items-center gap-3 mb-6">
            <a href="{{ route('affiliate.dashboard') }}" wire:navigate class="w-10 h-10 rounded-xl glass-panel flex items-center justify-center text-slate-300 hover:text-white transition-colors active:scale-95" title="Kembali ke Beranda">
                <i class="fa-solid fa-arrow-left text-sm"></i>
            </a>
            <div>
                <h1 class="text-base font-bold text-white leading-tight">Semua Menu</h1>
                <p class="text-xs text-slate-400">Semua alat jualan & akun partner di satu tempat</p>
            </div>
        </div>

        <!-- Kelompok Menu -->
        <div class="space-y-5">
            @foreach($menuGroups as $group)
                <section class="glass-panel rounded-3xl p-4" data-menu-group="{{ $group['key'] }}">
                    <div class="mb-4">
                        <h2 class="text-[11px] font-bold text-slate-300 uppercase tracking-widest pl-2 border-l-2 {{ $group['border'] }} flex items-center gap-1.5">
                            <i class="{{ $group['icon'] }} {{ $group['iconColor'] }} text-[10px]"></i> {{ $group['title'] }}
                        </h2>
                        <p class="text-[11px] text-slate-500 mt-1 pl-2.5">{{ $group['description'] }}</p>
                    </div>

                    <div class="grid grid-cols-4 gap-y-4 gap-x-2">
                        @foreach($group['items'] as $item)
                            <x-affiliate.menu-item :item="$item" :totalProjects="$totalProjects" />
                        @endforeach
                    </div>
                </section>
            @endforeach
        </div>

        <p class="text-center text-[10px] text-slate-500 mt-6">
            Menu bertanda <span class="text-slate-300 font-semibold">Segera</span> sedang kami siapkan.
        </p>
    </div>

    <x-affiliate.bottom-nav />
    <x-affiliate.modals :affiliate="$affiliate" />
    <x-affiliate.scripts />
</body>
</html>
