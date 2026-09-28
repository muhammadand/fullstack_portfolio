<section id="cara-pesan" class="py-16 md:py-24 px-4 sm:px-8 bg-[#120E0C] border-t border-[#362921]/40">
    <div class="max-w-6xl mx-auto">

        <div class="text-center max-w-2xl mx-auto mb-12">
            <span class="text-[11px] font-bold uppercase tracking-[0.2em] text-[#C59B6C] block">
                Pengalaman Digital Meja
            </span>
            <h2 class="font-serif text-3xl sm:text-4xl font-bold text-white mt-1 mb-3">
                4 Langkah Mudah Pesan Tanpa Antre
            </h2>
            <p class="text-xs sm:text-sm text-white/60 font-light">
                Teknologi self-order yang praktis dan nyaman untuk pelanggan maupun barista kafe Anda.
            </p>
        </div>

        <!-- 4 Steps Grid (Clean Numbers, No Icon Clutter) -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
            @php
            $steps = $cafeDatabase['how_it_works'] ?? [];
            @endphp
            @foreach($steps as $step)
            <div class="bg-[#1A1410] border border-[#362921]/60 rounded-2xl p-5 group hover:border-[#C59B6C]/50 transition-all duration-200 flex flex-col justify-between">
                <div>
                    <span class="font-mono text-2xl font-bold text-[#C59B6C] block mb-3">
                        {{ $step['step'] }}
                    </span>

                    <h3 class="font-serif font-bold text-sm text-white group-hover:text-[#D8AA73] transition-colors mb-1.5">
                        {{ $step['title'] }}
                    </h3>
                    <p class="text-xs text-white/60 leading-relaxed font-light">
                        {{ $step['desc'] }}
                    </p>
                </div>
                <div class="pt-3 mt-4 border-t border-white/5 text-[10px] text-white/40">
                    Proses Instan & Mandiri
                </div>
            </div>
            @endforeach
        </div>

    </div>
</section>
