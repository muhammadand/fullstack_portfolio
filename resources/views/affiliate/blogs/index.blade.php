<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Artikel Saya - Partner Dashboard</title>
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
    <div class="fixed top-0 left-0 w-full h-64 bg-orange-600/20 rounded-full blur-[100px] -translate-y-1/2 pointer-events-none z-0"></div>

    <div class="relative z-10 w-full max-w-md mx-auto flex flex-col min-h-screen px-4 pt-6">

        <!-- Header -->
        <div class="flex items-center justify-between mb-8">
            <div class="flex items-center gap-4">
                <a href="{{ route('affiliate.dashboard') }}" class="w-10 h-10 rounded-full glass-panel flex items-center justify-center text-slate-300 hover:text-white transition-colors">
                    <i class="fa-solid fa-arrow-left"></i>
                </a>
                <div>
                    <p class="text-xs text-orange-400 font-medium tracking-wider uppercase">Konten Kreator</p>
                    <h1 class="text-xl font-bold text-white">Artikel Saya</h1>
                </div>
            </div>

            <a href="{{ route('affiliate.blogs.create') }}" class="w-10 h-10 rounded-full bg-orange-500 flex items-center justify-center text-white shadow-lg shadow-orange-500/30">
                <i class="fa-solid fa-plus"></i>
            </a>
        </div>

        {{-- Session Messages --}}
        @if(session('success'))
        <script>
            window.addEventListener('DOMContentLoaded', () => {
                showToast("{{ session('success') }}", 'success');
            });

        </script>
        @endif

        <div class="glass-panel rounded-2xl p-4 mb-6">
            <div class="flex gap-4 items-center">
                <div class="w-12 h-12 rounded-xl bg-orange-500/20 text-orange-400 flex items-center justify-center text-xl">
                    <i class="fa-solid fa-medal"></i>
                </div>
                <div>
                    <h3 class="text-sm font-bold text-white mb-1">Tulis & Dapat Poin!</h3>
                    <p class="text-xs text-slate-400 leading-relaxed">Dapatkan <span class="text-yellow-400 font-bold">+10 Poin Emas</span> untuk setiap artikel yang berhasil diterbitkan oleh Admin. Sambil nulis, sambil promosi link affiliate-mu!</p>
                </div>
            </div>
        </div>

        <!-- List Artikel -->
        <div class="space-y-4">
            @forelse($blogs as $blog)
            <div class="glass-panel rounded-2xl overflow-hidden relative">
                @if($blog->is_published)
                <div class="absolute top-3 right-3 px-2 py-1 bg-emerald-500/20 text-emerald-400 border border-emerald-500/30 rounded text-[10px] font-bold z-10 backdrop-blur-md">
                    Published
                </div>
                @else
                <div class="absolute top-3 right-3 px-2 py-1 bg-yellow-500/20 text-yellow-400 border border-yellow-500/30 rounded text-[10px] font-bold z-10 backdrop-blur-md">
                    Menunggu Review
                </div>
                @endif

                <div class="flex h-24">
                    <div class="w-1/3 h-full relative">
                        @if($blog->featured_image)
                        <img src="{{ asset('storage/' . $blog->featured_image) }}" alt="Thumbnail" class="w-full h-full object-cover">
                        @else
                        <img src="{{ asset('storage/scalify-blog-default.webp') }}" alt="Thumbnail" class="w-full h-full object-cover">
                        @endif
                        <div class="absolute inset-0 bg-gradient-to-r from-transparent to-[#0B1120]/90"></div>
                    </div>
                    <div class="w-2/3 p-3 flex flex-col justify-center">
                        <h3 class="text-sm font-bold text-white mb-1 line-clamp-2 leading-tight">{{ $blog->title }}</h3>
                        <p class="text-[10px] text-slate-400 mb-2">Kategori: {{ $blog->businessCategory->name ?? 'Umum' }}</p>

                        <div class="flex items-center justify-between mt-auto">
                            <span class="text-[10px] text-slate-500">{{ $blog->created_at->format('d M Y') }}</span>
                            @if($blog->is_published && $blog->slug)
                            <a href="{{ route('blogs.read', $blog->slug) }}?ref={{ $affiliate->affiliate_code }}" target="_blank" class="text-[10px] text-blue-400 font-medium flex items-center gap-1">
                                Lihat Web <i class="fa-solid fa-arrow-up-right-from-square"></i>
                            </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="p-8 text-center glass-panel rounded-2xl flex flex-col items-center">
                <div class="w-16 h-16 rounded-full bg-white/5 flex items-center justify-center text-2xl mb-3 text-slate-500">
                    <i class="fa-solid fa-pen-fancy"></i>
                </div>
                <p class="text-white font-semibold mb-1">Belum Ada Artikel</p>
                <p class="text-xs text-slate-400">Ayo mulai menulis artikel pertama kamu dan kumpulkan poinnya!</p>
            </div>
            @endforelse
        </div>

        @if($blogs->hasPages())
        <div class="mt-6">
            {{ $blogs->links('pagination::tailwind') }}
        </div>
        @endif

    </div>

    <x-affiliate.bottom-nav />
    <x-affiliate.scripts />
</body>
</html>
