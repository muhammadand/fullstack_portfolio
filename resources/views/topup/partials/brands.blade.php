{{-- ══════════════════════════════════════════════════
     KATEGORI GAMES + DAFTAR BRAND (grid ikon, mobile first)
══════════════════════════════════════════════════ --}}
{{-- Memakai scope Alpine (q, visible) dari wrapper di topup/index.blade.php --}}
<section class="bg-brand-dark px-4 sm:px-6 lg:px-8 py-8 sm:py-12">

    <div class="max-w-6xl mx-auto">
        <div class="flex items-end justify-between gap-3 mb-5">
            <div>
                <h2 class="font-sans font-extrabold text-xl sm:text-2xl text-white tracking-tight flex items-center gap-2.5">
                    <span class="w-8 h-8 rounded-xl bg-btn-gradient flex items-center justify-center shadow-glow-sm">
                        <i class="fa-solid fa-gamepad text-white text-sm"></i>
                    </span>
                    {{ $catalog['category']['name'] ?? 'Games' }}
                </h2>
                <p class="text-white/50 text-xs mt-1.5">Pilih game yang ingin kamu top up</p>
            </div>

            @if(count($brands) > 0)
            <span class="shrink-0 px-2.5 py-1 rounded-full bg-white/5 border border-white/10 text-white/60 text-[11px] font-semibold">
                <span x-text="visible.length">{{ count($brands) }}</span> game
            </span>
            @endif
        </div>

        @if(count($brands) > 0)
        <div class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-5 lg:grid-cols-6 gap-3 sm:gap-4">
            @foreach($brands as $brand)
            <div x-show="visible.includes(@js($brand['slug']))"
                class="group flex flex-col items-center gap-2 p-2.5 sm:p-3 rounded-2xl bg-white/[0.04] hover:bg-white/[0.08] border border-white/10 hover:border-brand-accent/40 backdrop-blur-md transition-all active:scale-95">
                <div class="w-full aspect-square rounded-xl overflow-hidden bg-gradient-to-br from-blue-600/30 to-indigo-600/30 border border-white/10 flex items-center justify-center">
                    @if($brand['logo'])
                    <img src="{{ asset('storage/' . $brand['logo']) }}" alt="Top up {{ $brand['name'] }}" width="120" height="120"
                        loading="lazy" decoding="async" class="w-full h-full object-cover">
                    @else
                    <span class="font-sans font-black text-2xl sm:text-3xl text-white/80 select-none">{{ mb_strtoupper(mb_substr($brand['name'], 0, 1)) }}</span>
                    @endif
                </div>
                <span class="w-full text-center text-[11px] sm:text-xs font-semibold text-white/85 leading-tight line-clamp-2 min-h-[2.2em]">{{ $brand['name'] }}</span>
            </div>
            @endforeach
        </div>

        <div x-show="visible.length === 0" style="display: none;" class="text-center py-12">
            <div class="w-12 h-12 rounded-2xl bg-white/5 text-white/40 flex items-center justify-center mx-auto mb-3">
                <i class="fa-solid fa-magnifying-glass text-lg"></i>
            </div>
            <p class="text-sm font-semibold text-white/80">Game tidak ditemukan</p>
            <p class="text-xs text-white/50 mt-1">Coba kata kunci lain.</p>
        </div>
        @else
        <div class="text-center py-14 rounded-2xl bg-white/[0.03] border border-white/10">
            <div class="w-12 h-12 rounded-2xl bg-white/5 text-white/40 flex items-center justify-center mx-auto mb-3">
                <i class="fa-solid fa-gamepad text-lg"></i>
            </div>
            <p class="text-sm font-semibold text-white/80">Belum ada game tersedia</p>
            <p class="text-xs text-white/50 mt-1">Silakan kembali lagi sebentar lagi.</p>
        </div>
        @endif
    </div>
</section>
