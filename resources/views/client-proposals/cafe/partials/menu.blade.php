<section id="menu" class="py-16 md:py-24 px-4 sm:px-8 bg-[#16110E] relative">
    <div class="max-w-6xl mx-auto">
        
        <div class="text-center max-w-2xl mx-auto mb-10">
            <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold bg-[#241A13] text-[#D8AA73] border border-[#C59B6C]/30 mb-2">
                Menu Andalan Barista
            </span>
            <h2 class="font-serif text-3xl sm:text-4xl font-bold text-white mb-3">
                Signature Coffee & Artisan Food
            </h2>
            <p class="text-xs sm:text-sm text-white/60 font-light">
                Setiap cangkir kopi diseduh dengan rasio presisi menggunakan biji kopi kualitas terbaik.
            </p>

            <!-- Clean Text-Only Filter Pills (No Icon Clutter) -->
            <div class="flex items-center justify-center gap-2 flex-wrap mt-6" id="landingCatFilters">
                @php
                $cats = $cafeDatabase['categories'] ?? [];
                @endphp
                @foreach($cats as $idx => $cat)
                <button onclick="filterMenu('{{ $cat['id'] }}', this)" class="menu-filter-btn px-4 py-1.5 rounded-full text-xs font-medium transition-all duration-150 {{ $idx === 0 ? 'bg-[#C59B6C] text-[#140F0C] font-bold shadow-md' : 'bg-white/5 hover:bg-white/10 text-white/70 hover:text-white border border-white/5' }}" data-category="{{ $cat['id'] }}">
                    {{ $cat['name'] }}
                </button>
                @endforeach
            </div>
        </div>

        <!-- Menu Cards Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5" id="landingMenuGrid">
            @php
            $menuItems = $cafeDatabase['menu'] ?? [];
            @endphp
            @foreach($menuItems as $item)
            <div class="menu-item-card bg-[#1C1713] rounded-2xl border border-[#362921]/60 overflow-hidden flex flex-col justify-between hover:border-[#C59B6C]/50 transition-all duration-200 group hover:-translate-y-1 shadow-md" data-cat="{{ $item['category'] }}">
                
                <!-- Image & Clean Badge -->
                <div class="relative h-48 overflow-hidden">
                    <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}" loading="lazy" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    <div class="absolute inset-0 bg-gradient-to-t from-[#1C1713] via-transparent to-black/20"></div>

                    <span class="absolute top-3 left-3 px-2 py-0.5 rounded-md text-[9px] font-semibold bg-[#140F0C]/80 text-[#D8AA73] border border-white/10">
                        {{ $item['badge'] }}
                    </span>
                </div>

                <!-- Content -->
                <div class="p-4 flex flex-col justify-between flex-grow">
                    <div>
                        <h3 class="font-serif font-bold text-sm text-white group-hover:text-[#D8AA73] transition-colors leading-snug">
                            {{ $item['name'] }}
                        </h3>
                        <p class="text-xs text-white/60 line-clamp-2 mt-1.5 leading-relaxed font-light">
                            {{ $item['description'] }}
                        </p>
                    </div>

                    <!-- Price & Clean Button -->
                    <div class="pt-3 mt-3 border-t border-white/10 flex items-center justify-between">
                        <span class="font-mono text-sm font-bold text-[#D8AA73]">
                            Rp {{ number_format($item['price'], 0, ',', '.') }}
                        </span>

                        <button onclick="openQuickOrderModal('{{ $item['id'] }}')" class="px-3 py-1.5 rounded-lg bg-[#241A13] hover:bg-[#C59B6C] text-[#D8AA73] hover:text-[#140F0C] text-xs font-semibold transition border border-[#C59B6C]/30">
                            Pesan
                        </button>
                    </div>
                </div>

            </div>
            @endforeach
        </div>

        <!-- Banner under Menu: Mobile Demo Teaser -->
        <div class="mt-12 p-6 rounded-2xl bg-[#1C1612] border border-[#C59B6C]/30 flex flex-col sm:flex-row items-center justify-between gap-4">
            <div>
                <h4 class="font-serif font-bold text-base text-white">Ingin Coba Pesan Langsung dari Smartphone?</h4>
                <p class="text-xs text-white/60 mt-0.5 font-light">Buka simulasi web-app self-order lengkap dengan kalkulator diskon member & pembayaran QRIS dinamis.</p>
            </div>

            @if(isset($client->slug))
            <a href="{{ route('demo.customer.cafe', $client->slug) }}" class="shrink-0 px-5 py-2.5 rounded-full bg-[#C59B6C] hover:bg-[#D8AA73] text-[#140F0C] text-xs font-bold transition flex items-center gap-2">
                <i class="fas fa-mobile-alt text-xs"></i>
                <span>Buka Demo App HP</span>
            </a>
            @endif
        </div>

    </div>
</section>
