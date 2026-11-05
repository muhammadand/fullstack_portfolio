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
        <div class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-5 lg:grid-cols-6 gap-2.5 sm:gap-4">
            @foreach($brands as $brand)
            <a href="{{ route('topup.show', $brand['slug']) }}" x-show="visible.includes(@js($brand['slug']))"
                class="group flex flex-col rounded-2xl overflow-hidden bg-brand-mid border border-white/10 hover:border-brand-accent/50 hover:-translate-y-1 transition-all duration-200 active:scale-95">
                {{-- Poster game: rasio potret, tepi bawah bergelombang --}}
                <div class="relative aspect-[3/4] bg-gradient-to-br from-blue-600/30 to-indigo-600/30">
                    @if($brand['image'])
                    <img src="{{ asset('storage/' . $brand['image']) }}" alt="Top up {{ $brand['name'] }}" width="300" height="400"
                        loading="{{ $loop->index < 8 ? 'eager' : 'lazy' }}" @if($loop->index < 4) fetchpriority="high" @endif decoding="async" class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                    @else
                    <span class="absolute inset-0 flex items-center justify-center font-sans font-black text-4xl text-white/70 select-none">{{ mb_strtoupper(mb_substr($brand['name'], 0, 1)) }}</span>
                    @endif
                    <svg class="absolute -bottom-px left-0 w-full h-2.5 sm:h-3 fill-brand-mid" viewBox="0 0 100 10" preserveAspectRatio="none" aria-hidden="true">
                        <path d="M0 10V6l6-3 6 3 7-4 7 4 6-3 8 4 7-3 8 3 7-4 8 4 8-3 10 3v6z"/>
                    </svg>
                </div>
                <span class="flex items-center justify-center text-center px-1.5 pb-3 pt-1 min-h-[3.25rem] sm:min-h-[3.75rem] text-[11px] sm:text-sm font-bold text-white leading-tight line-clamp-2">{{ $brand['name'] }}</span>
            </a>
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
