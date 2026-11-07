{{-- 2. Pilih nominal --}}
<section class="p-4 sm:p-5 rounded-2xl bg-white/[0.04] border border-white/10 backdrop-blur-md">
    <h2 class="flex items-center gap-2.5 font-sans font-bold text-sm sm:text-base text-white mb-3">
        <span class="w-6 h-6 rounded-lg bg-btn-gradient flex items-center justify-center text-[11px] font-black">{{ $n }}</span>
        Pilih Nominal
    </h2>
    <div class="grid grid-cols-2 sm:grid-cols-3 gap-2.5" role="radiogroup" aria-label="Pilih nominal top up">
        @foreach($products as $p)
        <button type="button" role="radio" :aria-checked="selected === {{ $p['id'] }}" @if($p['available']) @click="selected = {{ $p['id'] }}; errors.product = null" @else disabled @endif :class="selected === {{ $p['id'] }} ? 'border-brand-accent bg-brand-blue/20 shadow-glow-sm' : 'border-white/10 bg-white/[0.04] hover:border-white/25'" class="relative text-left p-3 rounded-xl border transition-all active:scale-[0.97] disabled:opacity-40 disabled:cursor-not-allowed">
            <span class="block text-[13px] font-bold text-white leading-snug line-clamp-2 min-h-[2.4em]">{{ $p['name'] }}</span>
            <span class="block text-xs font-semibold text-cyan-300 mt-1.5">Rp {{ number_format($p['price'], 0, ',', '.') }}</span>
            @unless($p['available'])
            <span class="block text-[10px] text-white/50 mt-0.5">{{ $p['price'] <= 0 ? 'Harga belum diatur' : 'Sedang gangguan' }}</span>
            @endunless
            <i x-show="selected === {{ $p['id'] }}" style="display:none" class="fa-solid fa-circle-check absolute top-2 right-2 text-brand-accent text-sm"></i>
        </button>
        @endforeach
    </div>
    <p x-show="errors.product" x-text="errors.product" style="display:none" class="text-[11px] text-red-300 mt-2"></p>
</section>
