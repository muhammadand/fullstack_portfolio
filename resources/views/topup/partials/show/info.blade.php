{{-- Info game --}}
<header class="lg:sticky lg:top-24 flex items-center gap-4 lg:flex-col lg:items-stretch lg:gap-0 p-4 lg:p-0 rounded-2xl lg:rounded-none bg-white/[0.04] lg:bg-transparent border border-white/10 lg:border-0 mb-4 lg:mb-0">
    <div class="w-20 lg:w-full shrink-0 aspect-[3/4] rounded-xl lg:rounded-2xl overflow-hidden bg-gradient-to-br from-blue-600/30 to-indigo-600/30 border border-white/10 relative">
        @if($brand['image'])
        <img src="{{ asset('storage/' . $brand['image']) }}" alt="Top up {{ $gameName }}" width="320" height="427" fetchpriority="high" class="absolute inset-0 w-full h-full object-cover">
        @else
        <span class="absolute inset-0 flex items-center justify-center font-sans font-black text-4xl text-white/70 select-none">{{ mb_strtoupper(mb_substr($gameName, 0, 1)) }}</span>
        @endif
    </div>
    <div class="min-w-0 lg:mt-4">
        <h1 class="font-sans font-extrabold text-lg lg:text-2xl text-white leading-tight tracking-tight">Top Up {{ $gameName }}</h1>
        <div class="flex flex-wrap gap-1.5 mt-2.5">
            @foreach([['fa-bolt', 'text-amber-400', 'Proses instan'], ['fa-qrcode', 'text-cyan-400', 'QRIS'], ['fa-shield-halved', 'text-emerald-400', 'Aman']] as [$ic, $col, $lbl])
            <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full bg-white/5 border border-white/10 text-[10px] font-semibold text-white/70">
                <i class="fa-solid {{ $ic }} {{ $col }}"></i>{{ $lbl }}
            </span>
            @endforeach
        </div>
    </div>
</header>
