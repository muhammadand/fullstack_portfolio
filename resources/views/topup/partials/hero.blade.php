{{-- ══════════════════════════════════════════════════
     TOP UP HERO (Mobile First) — tema midnight blue & glass Scalify
══════════════════════════════════════════════════ --}}
<section class="relative pt-8 pb-6 sm:pt-14 sm:pb-10 px-4 sm:px-6 lg:px-8 overflow-hidden border-b border-white/5">
    <div class="absolute inset-0 bg-hero-gradient pointer-events-none"></div>
    <div class="absolute top-0 right-0 w-72 h-72 sm:w-[500px] sm:h-[500px] bg-brand-blue/15 rounded-full blur-[120px] pointer-events-none"></div>
    <div class="absolute inset-0 opacity-[0.035] pointer-events-none" style="background-image: radial-gradient(#ffffff 1px, transparent 1px); background-size: 28px 28px;"></div>

    <div class="relative z-10 max-w-6xl mx-auto">
        <div class="mb-3">
            <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-cyan-500/10 border border-cyan-500/20 text-cyan-400 font-bold text-[10px] sm:text-xs tracking-[0.15em] uppercase">
                <span class="w-1.5 h-1.5 rounded-full bg-cyan-400 animate-pulse"></span>
                <span>Proses Otomatis 24 Jam</span>
            </div>
        </div>

        <h1 class="font-sans font-black text-[28px] leading-[1.15] sm:text-5xl text-white tracking-[-0.03em] max-w-2xl mb-3">
            Top Up Game Favoritmu
            <span class="bg-gradient-to-r from-blue-400 via-cyan-300 to-indigo-400 bg-clip-text text-transparent">Cepat &amp; Murah</span>
        </h1>

        <p class="text-white/65 text-xs sm:text-sm max-w-xl leading-relaxed mb-5">
            Pilih game, masukkan ID, bayar pakai QRIS. Diamond dan voucher langsung masuk tanpa ribet.
        </p>

        {{-- Pencarian brand (client-side, tanpa request tambahan) --}}
        @if(count($brands) > 0)
        <label class="relative block max-w-xl">
            <span class="sr-only">Cari game</span>
            <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-white/40 text-sm pointer-events-none"></i>
            <input type="search" x-model="q" placeholder="Cari game, contoh: Mobile Legends"
                class="w-full h-12 rounded-2xl bg-white/5 border border-white/15 focus:border-brand-accent/60 focus:bg-white/10 focus:outline-none text-white placeholder:text-white/40 text-sm pl-11 pr-4 backdrop-blur-md transition-colors"
                autocomplete="off" enterkeyhint="search">
        </label>
        @endif
    </div>
</section>
