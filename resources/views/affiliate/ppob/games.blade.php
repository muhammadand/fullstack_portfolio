<!DOCTYPE html>
<html lang="id">
<head>
    @include('affiliate.ppob.partials.head', ['title' => 'Top Up Game'])
</head>
<body class="pb-28 overflow-x-hidden min-h-screen relative">
    <x-affiliate.page-loader />
    <div class="fixed top-0 left-0 w-full h-64 bg-indigo-600/10 rounded-full blur-[110px] -translate-y-1/2 pointer-events-none z-0"></div>

    <div class="relative z-10 w-full max-w-md mx-auto px-4 pt-5">
        <div class="flex items-center gap-3 mb-4">
            <a href="{{ route('affiliate.menu') }}" class="w-10 h-10 rounded-xl glass-panel flex items-center justify-center text-slate-300 active:scale-95" aria-label="Kembali">
                <i class="fa-solid fa-arrow-left text-sm"></i>
            </a>
            <div>
                <h1 class="text-base font-bold text-white leading-tight">Top Up Game</h1>
                <p class="text-xs text-slate-400">Pilih game, harga khusus partner</p>
            </div>
        </div>

        <div class="mb-4">@include('affiliate.ppob.partials.wallet')</div>

        @if(empty($catalog['brands']))
            <div class="glass-panel rounded-3xl p-6 text-center">
                <div class="w-14 h-14 mx-auto rounded-2xl bg-indigo-500/10 flex items-center justify-center text-indigo-300 text-xl mb-3"><i class="fa-solid fa-gamepad"></i></div>
                <h2 class="text-sm font-bold text-white mb-1">Produk game belum tersedia</h2>
                <p class="text-xs text-slate-400">Produk akan muncul setelah admin mengaktifkan katalog game.</p>
            </div>
        @else
            <div class="grid grid-cols-3 gap-3" data-games>
                @foreach($catalog['brands'] as $brand)
                <a href="{{ route('affiliate.ppob.game', $brand['slug']) }}" class="glass-panel rounded-2xl p-2.5 flex flex-col items-center gap-2 text-center active:scale-95 transition-transform">
                    @if($brand['image'])
                    <img src="{{ asset('storage/' . $brand['image']) }}" alt="" class="w-14 h-14 rounded-xl object-cover bg-slate-800" loading="lazy">
                    @else
                    <span class="w-14 h-14 rounded-xl bg-indigo-500/15 text-indigo-200 flex items-center justify-center text-lg font-bold">{{ mb_strtoupper(mb_substr($brand['name'], 0, 1)) }}</span>
                    @endif
                    <span class="text-[11px] font-semibold text-slate-200 leading-tight line-clamp-2">{{ $brand['name'] }}</span>
                </a>
                @endforeach
            </div>
        @endif
    </div>

    <x-affiliate.bottom-nav />
</body>
</html>
