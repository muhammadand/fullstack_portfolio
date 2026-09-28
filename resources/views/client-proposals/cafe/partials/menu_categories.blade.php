<section class="py-12 px-4 sm:px-8 bg-[#120E0C] border-y border-[#362921]/40">
    <div class="max-w-6xl mx-auto">
        
        <div class="flex flex-col md:flex-row md:items-end justify-between mb-8 gap-4">
            <div>
                <span class="text-[11px] font-bold uppercase tracking-[0.2em] text-[#C59B6C] block">
                    Kategori Menu
                </span>
                <h2 class="font-serif text-2xl sm:text-3xl font-bold text-white mt-1">
                    Pilihan Seduhan & Hidangan
                </h2>
            </div>
            <p class="text-xs sm:text-sm text-white/60 max-w-md font-light">
                Dari single origin beans pilihan, signature latte, hingga pastry renyah yang dipanggang segar setiap pagi.
            </p>
        </div>

        <!-- Categories Cards Grid -->
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3">
            @php
            $cats = $cafeDatabase['categories'] ?? [];
            @endphp
            @foreach($cats as $cat)
            <a href="#menu" onclick="filterCategoryOnLanding('{{ $cat['id'] }}')" class="bg-[#1A1410] hover:bg-[#261D17] border border-[#362921]/60 hover:border-[#C59B6C]/50 rounded-2xl p-4 text-center transition-all duration-200 flex flex-col items-center justify-between group">
                <div class="w-10 h-10 rounded-xl bg-[#261D17] group-hover:bg-[#C59B6C] text-[#D8AA73] group-hover:text-[#140F0C] flex items-center justify-center text-sm mb-3 transition-colors">
                    <i class="fas {{ $cat['icon'] }}"></i>
                </div>
                <h3 class="font-semibold text-xs sm:text-sm text-white group-hover:text-[#D8AA73] transition-colors leading-tight mb-1">
                    {{ $cat['name'] }}
                </h3>
                <span class="text-[10px] text-white/40">
                    {{ $cat['badge'] ?? 'Artisan' }}
                </span>
            </a>
            @endforeach
        </div>

    </div>
</section>
