<section id="membership" class="py-12 sm:py-16 bg-slate-900/60 text-white border-b border-slate-900 relative">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Section Header -->
        <div class="text-center max-w-2xl mx-auto mb-10">
            <span class="text-emerald-400 font-semibold text-xs tracking-wider uppercase mb-1.5 block">
                Membership & Keuntungan
            </span>
            <h2 class="text-xl sm:text-3xl font-bold text-white tracking-tight">
                Langganan Member & Akses Komunitas
            </h2>
            <p class="text-xs sm:text-sm text-slate-400 mt-2">
                Dapatkan potongan harga sewa lapangan, prioritas booking slot prime time, dan hak membuat komunitas mabar sendiri.
            </p>
        </div>

        <!-- Membership Cards Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-5 max-w-5xl mx-auto items-stretch">
            @if(isset($sportDatabase['memberships']))
            @foreach($sportDatabase['memberships'] as $mem)
            @php
            $isPopular = !empty($mem['popular']);
            $cardBorder = $isPopular ? 'border-emerald-500/60 bg-slate-950 shadow-md relative' : 'border-slate-800 bg-slate-950/80';
            @endphp
            <div class="border {{ $cardBorder }} rounded-2xl p-5 sm:p-6 flex flex-col justify-between">

                @if($isPopular)
                <div class="absolute -top-3 left-1/2 -translate-x-1/2 bg-emerald-500 text-slate-950 text-[9px] font-bold uppercase tracking-wider px-3 py-0.5 rounded-full">
                    Paling Populer
                </div>
                @endif

                <div>
                    <!-- Title & Badge -->
                    <div class="flex items-center justify-between mb-3">
                        <h3 class="text-base font-bold text-white">{{ $mem['tier'] }}</h3>
                        <span class="text-[10px] font-semibold px-2 py-0.5 rounded {{ $isPopular ? 'bg-emerald-500/20 text-emerald-400 border border-emerald-500/30' : 'bg-slate-800 text-slate-400' }}">
                            Diskon {{ $mem['discount_percent'] }}%
                        </span>
                    </div>

                    <!-- Price -->
                    <div class="mb-5 pb-5 border-b border-slate-800/80">
                        <div class="flex items-baseline gap-1">
                            <span class="text-xs text-slate-400">Rp</span>
                            <span class="text-2xl sm:text-3xl font-bold text-white">{{ number_format($mem['price'], 0, ',', '.') }}</span>
                            <span class="text-xs text-slate-400">{{ $mem['period'] }}</span>
                        </div>
                        <p class="text-[11px] text-emerald-400 font-medium mt-1">
                            Hak buat {{ $mem['community_limit'] }}
                        </p>
                    </div>

                    <!-- Perks List -->
                    <ul class="space-y-2.5 mb-6 text-xs text-slate-300">
                        @foreach($mem['perks'] as $perk)
                        <li class="flex items-start gap-2">
                            <i class="fas fa-check text-emerald-400 text-[10px] mt-1 shrink-0"></i>
                            <span class="leading-relaxed">{{ $perk }}</span>
                        </li>
                        @endforeach
                    </ul>
                </div>

                <!-- CTA Button -->
                <a href="https://wa.me/{{ $cleanWa }}?text={{ urlencode('Halo ' . $brandName . ', saya ingin mendaftar Membership ' . $mem['tier'] . '.') }}" target="_blank" class="w-full py-2.5 rounded-xl {{ $isPopular ? 'bg-emerald-500 hover:bg-emerald-400 text-slate-950 font-bold' : 'bg-slate-800 hover:bg-slate-700 text-slate-200 font-semibold' }} text-xs text-center transition flex items-center justify-center gap-1.5">
                    <i class="fab fa-whatsapp text-xs"></i>
                    <span>Daftar {{ $mem['tier'] }}</span>
                </a>
            </div>
            @endforeach
            @endif
        </div>

        <!-- Community Callout Banner -->
        <div class="mt-8 max-w-4xl mx-auto bg-slate-950 border border-slate-800 rounded-2xl p-5 flex flex-col sm:flex-row items-center justify-between gap-4">
            <div>
                <h4 class="text-sm font-bold text-white">Ingin Membentuk Komunitas Sendiri?</h4>
                <p class="text-xs text-slate-400 mt-0.5">Daftarkan tim atau klub Anda, atur jadwal mabar mingguan, dan cari lawan sparring antar member secara mudah.</p>
            </div>
            <a href="#komunitas" class="shrink-0 px-4 py-2 rounded-lg bg-slate-800 hover:bg-slate-700 text-slate-200 text-xs font-semibold transition whitespace-nowrap">
                Lihat Komunitas ➔
            </a>
        </div>

    </div>
</section>
