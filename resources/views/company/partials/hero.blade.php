{{-- ══════════════════════════════════════════════════
     HERO SECTION (Left-Aligned Layout & Crisp Typography Sesuai Referensi)
══════════════════════════════════════════════════ --}}
<section class="relative pt-12 pb-16 sm:pt-16 sm:pb-20 px-4 sm:px-6 lg:px-8 overflow-hidden border-b border-white/5">
    <div class="absolute inset-0 bg-hero-gradient pointer-events-none"></div>
    <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-brand-blue/15 rounded-full blur-[140px] pointer-events-none"></div>

    {{-- Subtle Lattice / Japanese Geometric Pattern Background --}}
    <div class="absolute inset-0 opacity-[0.035] pointer-events-none" style="background-image: radial-gradient(#ffffff 1px, transparent 1px); background-size: 28px 28px;"></div>

    <div class="relative z-10 max-w-6xl mx-auto">

        {{-- Tagline / Eyebrow --}}
        <div class="mb-3">
            <span class="text-[#EF4444] font-extrabold text-[11px] sm:text-xs tracking-[0.2em] uppercase">
                Discover Scalify, Digital Agency #1 Indonesia
            </span>
        </div>

        {{-- Main Headline (Left-Aligned, Tight Tracking, Bold Hierarchy) --}}
        <h1 class="font-sans font-black text-3xl sm:text-5xl lg:text-[46px] text-white leading-[1.18] tracking-[-0.03em] max-w-3xl mb-4">
            Partner Pembuatan Website<br class="hidden sm:inline" />
            #1 untuk Bisnis & UMKM Indonesia
        </h1>

        {{-- Subtitle / Description --}}
        <p class="text-white/65 text-xs sm:text-sm md:text-[15px] max-w-2xl leading-relaxed font-normal mb-8">
            Sejak 2020, kami membantu ratusan pelaku usaha, brand, dan korporat menjelajahi transformasi digital dengan website berkelas internasional, harga transparan, performa kilat, dan layanan penuh dari tim ahli.
        </p>

        {{-- CTA Buttons --}}
        <div class="flex flex-wrap items-center gap-3.5 mb-14 sm:mb-16">
            <a href="https://wa.me/6285221694067?text=Halo%20Scalify,%20saya%20ingin%20konsultasi%20pembuatan%20website" target="_blank" class="inline-flex items-center gap-2.5 bg-btn-gradient text-white text-xs sm:text-sm font-bold px-6 sm:px-7 py-3 sm:py-3.5 rounded-full shadow-glow-blue hover:scale-105 transition-all">
                <i class="fa-brands fa-whatsapp text-base"></i>
                <span>Konsultasi Proyek Sekarang</span>
                <span class="w-5 h-5 bg-white/20 rounded-full flex items-center justify-center text-[10px]">→</span>
            </a>
            <a href="{{ route('landing.portfolio') }}" class="inline-flex items-center gap-2 bg-white/5 border border-white/15 hover:bg-white/10 text-white/90 hover:text-white text-xs sm:text-sm font-semibold px-5 sm:px-6 py-3 sm:py-3.5 rounded-full transition-all">
                <i class="fa-solid fa-eye text-brand-accent text-xs"></i>
                <span>Lihat Portofolio</span>
            </a>
        </div>

        {{-- ══════════════════════════════════════════════════
             4 STATS BAR (Bersih, Rapi & Elegan - Persis Gambar Referensi)
        ══════════════════════════════════════════════════ --}}
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-6 sm:gap-8 pt-8 border-t border-white/10">
            <div>
                <div class="font-sans font-black text-3xl sm:text-4xl lg:text-[40px] text-[#EF4444] tracking-tight mb-1">
                    500+
                </div>
                <div class="text-white/50 text-xs sm:text-[13px] font-normal">
                    Klien & proyek sukses
                </div>
            </div>

            <div>
                <div class="font-sans font-black text-3xl sm:text-4xl lg:text-[40px] text-[#EF4444] tracking-tight mb-1">
                    4.9/5.0
                </div>
                <div class="text-white/50 text-xs sm:text-[13px] font-normal">
                    Rating kepuasan klien
                </div>
            </div>

            <div>
                <div class="font-sans font-black text-3xl sm:text-4xl lg:text-[40px] text-[#EF4444] tracking-tight mb-1">
                    Sejak 2020
                </div>
                <div class="text-white/50 text-xs sm:text-[13px] font-normal">
                    Melayani bisnis Indonesia
                </div>
            </div>

            <div>
                <div class="font-sans font-black text-3xl sm:text-4xl lg:text-[40px] text-[#EF4444] tracking-tight mb-1">
                    24/7
                </div>
                <div class="text-white/50 text-xs sm:text-[13px] font-normal">
                    Customer support & garansi
                </div>
            </div>
        </div>

    </div>
</section>
