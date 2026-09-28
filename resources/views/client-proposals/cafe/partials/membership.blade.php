<section id="membership" class="py-16 md:py-24 px-4 sm:px-8 bg-[#16110E] relative">
    <div class="max-w-6xl mx-auto">
        
        <div class="text-center max-w-2xl mx-auto mb-10">
            <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold bg-[#241A13] text-amber-300 border border-amber-500/30 mb-2">
                Loyalty Rewards Program
            </span>
            <h2 class="font-serif text-3xl sm:text-4xl font-bold text-white mb-3">
                {{ $brandName }} VIP Coffee Club
            </h2>
            <p class="text-xs sm:text-sm text-white/60 font-light">
                Apresiasi untuk pelanggan setia kami. Dapatkan poin di setiap pesanan, diskon otomatis di kasir, dan voucher penawaran khusus.
            </p>
        </div>

        <!-- Membership Tiers Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
            @php
            $tiers = $cafeDatabase['membership_tiers'] ?? [];
            @endphp
            @foreach($tiers as $tier)
            <div class="bg-[#1C1713] rounded-2xl border {{ !empty($tier['is_popular']) ? 'border-amber-500/50 shadow-xl shadow-amber-500/5' : 'border-[#362921]/60' }} p-6 flex flex-col justify-between relative group hover:border-[#C59B6C]/50 transition-all duration-200">
                
                @if(!empty($tier['is_popular']))
                <div class="absolute -top-3 left-1/2 -translate-x-1/2 px-3 py-0.5 rounded-full bg-[#C59B6C] text-[#140F0C] font-bold text-[9px] uppercase tracking-wider">
                    Paling Populer
                </div>
                @endif

                <div>
                    <div class="w-10 h-10 rounded-xl bg-white/5 border border-white/10 flex items-center justify-center text-base mb-4 text-amber-400">
                        <i class="fas {{ $tier['icon'] }}"></i>
                    </div>

                    <h3 class="font-serif font-bold text-lg text-white">{{ $tier['name'] }}</h3>
                    <p class="text-xs text-amber-300 font-semibold mt-1">{{ $tier['discount'] }}</p>
                    <p class="text-[11px] text-white/40 mt-0.5">{{ $tier['min_spend'] }}</p>

                    <!-- Perks List (Clean bullets without loud icon clutter) -->
                    <ul class="space-y-2 mt-5 pt-5 border-t border-white/10 text-xs text-white/70 font-light">
                        @foreach($tier['perks'] as $perk)
                        <li class="flex items-start gap-2">
                            <span class="text-amber-400 font-bold">•</span>
                            <span class="leading-relaxed">{{ $perk }}</span>
                        </li>
                        @endforeach
                    </ul>
                </div>

                @if(isset($client->slug))
                <div class="pt-5 mt-5 border-t border-white/10">
                    <a href="{{ route('demo.customer.cafe', $client->slug) }}" class="w-full py-2 rounded-xl {{ !empty($tier['is_popular']) ? 'bg-[#C59B6C] text-[#140F0C] font-bold' : 'bg-white/5 hover:bg-white/10 text-white font-medium border border-white/10' }} text-xs text-center transition flex items-center justify-center gap-1.5">
                        <i class="fas fa-id-card text-xs"></i>
                        <span>Cek Kartu di Demo HP</span>
                    </a>
                </div>
                @endif

            </div>
            @endforeach
        </div>

        <!-- VIP Digital Pass Card Showcase -->
        <div class="max-w-xl mx-auto rounded-2xl p-5 bg-[#1C1612] border border-[#3A2C22] text-center sm:text-left flex flex-col sm:flex-row items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-amber-500/20 text-amber-400 flex items-center justify-center text-xl shrink-0">
                <i class="fas fa-id-badge"></i>
            </div>
            <div>
                <h4 class="font-serif font-bold text-sm text-white">Kartu Digital Tersimpan di Smartphone</h4>
                <p class="text-xs text-white/60 mt-0.5 leading-relaxed font-light">
                    Pelanggan tidak perlu repot membawa kartu fisik. Cukup buka link website kafe atau sebutkan nomor WhatsApp saat pesan di meja.
                </p>
            </div>
        </div>

    </div>
</section>
