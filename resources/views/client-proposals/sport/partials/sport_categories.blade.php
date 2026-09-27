<section id="cabor" class="py-12 sm:py-16 bg-slate-900/60 text-white border-b border-slate-900 relative">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Section Header -->
        <div class="text-center max-w-2xl mx-auto mb-10">
            <span class="text-emerald-400 font-semibold text-xs tracking-wider uppercase mb-1.5 block">
                Fasilitas Olahraga
            </span>
            <h2 class="text-xl sm:text-3xl font-bold text-white tracking-tight">
                Pilihan Cabang Olahraga
            </h2>
            <p class="text-xs sm:text-sm text-slate-400 mt-2">
                Fasilitas lapangan berstandar kompetisi dengan pencahayaan LED optimal dan lantai terawat.
            </p>
        </div>

        <!-- Sport Cards Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
            @if(isset($sportDatabase['sports']))
                @foreach($sportDatabase['sports'] as $sport)
                <div class="bg-slate-950 border border-slate-800/80 rounded-2xl overflow-hidden hover:border-slate-700 transition flex flex-col justify-between">
                    <!-- Image -->
                    <div class="relative h-44 overflow-hidden">
                        <img src="{{ $sport['image'] }}" alt="{{ $sport['name'] }}" class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-950/30 to-transparent"></div>
                        <span class="absolute top-3 left-3 px-2.5 py-0.5 rounded-md bg-slate-900/90 border border-slate-800 text-[10px] font-medium text-emerald-400">
                            {{ $sport['badge'] }}
                        </span>
                        <div class="absolute bottom-3 left-3 right-3 flex items-center justify-between">
                            <h3 class="text-base font-bold text-white">
                                {{ $sport['name'] }}
                            </h3>
                            <span class="text-[10px] text-slate-300 bg-slate-900/80 px-2 py-0.5 rounded border border-slate-800 font-medium">
                                {{ count($sport['courts']) }} Lapangan
                            </span>
                        </div>
                    </div>

                    <!-- Body Content -->
                    <div class="p-4 flex-1 flex flex-col justify-between">
                        <p class="text-xs text-slate-400 leading-relaxed mb-3.5">
                            {{ $sport['description'] }}
                        </p>

                        <!-- Court Types List -->
                        <div class="space-y-1.5 mb-4">
                            @foreach($sport['courts'] as $court)
                            <div class="flex items-center justify-between text-[11px] bg-slate-900 px-2.5 py-1.5 rounded-lg border border-slate-800/80">
                                <span class="font-medium text-slate-300 truncate pr-2">{{ $court['name'] }}</span>
                                <span class="font-semibold text-emerald-400 shrink-0">Rp {{ number_format($court['price_regular'], 0, ',', '.') }}<span class="text-[9px] text-slate-500 font-normal">/jam</span></span>
                            </div>
                            @endforeach
                        </div>

                        <!-- Card Action -->
                        <button type="button" onclick="selectSportCategory('{{ $sport['id'] }}')" class="w-full py-2 rounded-lg bg-slate-800 hover:bg-slate-700 text-slate-200 hover:text-white font-semibold text-xs transition flex items-center justify-center gap-1.5 cursor-pointer">
                            <span>Jadwal & Booking {{ $sport['name'] }}</span>
                            <i class="fas fa-arrow-right text-[9px] text-emerald-400"></i>
                        </button>
                    </div>
                </div>
                @endforeach
            @endif
        </div>

    </div>
</section>
