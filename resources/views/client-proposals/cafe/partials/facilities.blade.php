<section id="fasilitas" class="py-16 md:py-24 px-4 sm:px-8 bg-[#16110E] relative">
    <div class="max-w-6xl mx-auto">

        <div class="text-center max-w-2xl mx-auto mb-12">
            <span class="text-[11px] font-bold uppercase tracking-[0.2em] text-[#C59B6C] block">
                Kenyamanan Tempat
            </span>
            <h2 class="font-serif text-3xl sm:text-4xl font-bold text-white mt-1 mb-3">
                Fasilitas Lengkap untuk Setiap Momen
            </h2>
            <p class="text-xs sm:text-sm text-white/60 font-light">
                Dirancang untuk Anda yang ingin fokus bekerja, meeting santai, maupun menikmati waktu berkualitas bersama teman.
            </p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
            @php
            $facilities = $cafeDatabase['facilities'] ?? [];
            @endphp
            @foreach($facilities as $f)
            <div class="bg-[#1C1713] border border-[#362921]/60 rounded-2xl p-5 hover:border-[#C59B6C]/40 transition-all duration-200 group">
                <div class="w-10 h-10 rounded-xl bg-[#261D17] text-[#D8AA73] group-hover:bg-[#C59B6C] group-hover:text-[#140F0C] flex items-center justify-center text-sm mb-3.5 transition-colors">
                    <i class="fas {{ $f['icon'] }}"></i>
                </div>
                <h3 class="font-serif font-bold text-sm text-white group-hover:text-[#D8AA73] transition-colors mb-1.5">
                    {{ $f['title'] }}
                </h3>
                <p class="text-xs text-white/60 leading-relaxed font-light">
                    {{ $f['desc'] }}
                </p>
            </div>
            @endforeach
        </div>

    </div>
</section>
