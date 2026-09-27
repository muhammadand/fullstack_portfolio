<section id="komunitas" class="py-12 sm:py-16 bg-slate-950 text-white border-b border-slate-900 relative">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Header -->
        <div class="text-center max-w-2xl mx-auto mb-10">
            <span class="text-emerald-400 font-semibold text-xs tracking-wider uppercase mb-1.5 block">
                Komunitas & Sparring
            </span>
            <h2 class="text-xl sm:text-3xl font-bold text-white tracking-tight">
                Pusat Komunitas & Main Bareng
            </h2>
            <p class="text-xs sm:text-sm text-slate-400 mt-2">
                Temukan teman bermain atau cari lawan tanding sparring dari berbagai klub member yang terdaftar.
            </p>
        </div>

        <!-- 2 Columns -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

            <!-- Left: Active Communities (7 Cols) -->
            <div class="lg:col-span-7 space-y-3">
                <div class="flex items-center justify-between pb-2 border-b border-slate-800">
                    <h3 class="text-sm font-bold text-white">Komunitas Member Terdaftar</h3>
                    <span class="text-xs text-slate-400">5+ Klub Aktif</span>
                </div>

                <div class="space-y-2.5">
                    @if(isset($sportDatabase['initial_communities']))
                    @foreach($sportDatabase['initial_communities'] as $com)
                    <div class="bg-slate-900/70 border border-slate-800 rounded-xl p-3.5 hover:border-slate-700 transition flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                        <div class="min-w-0">
                            <div class="flex items-center gap-2">
                                <h4 class="text-xs font-bold text-white truncate">{{ $com['name'] }}</h4>
                                <span class="text-[9px] font-medium px-1.5 py-0.5 rounded bg-slate-800 text-slate-400">
                                    {{ $com['sport_name'] }}
                                </span>
                            </div>
                            <p class="text-[11px] text-emerald-400 mt-0.5">
                                {{ $com['schedule'] }} • {{ $com['homebase'] }}
                            </p>
                            <p class="text-[11px] text-slate-400 mt-0.5 line-clamp-1">
                                {{ $com['description'] }}
                            </p>
                        </div>

                        <div class="flex items-center sm:flex-col sm:items-end justify-between shrink-0 pt-2 sm:pt-0 border-t sm:border-t-0 border-slate-800">
                            <span class="text-[11px] font-semibold text-slate-300">
                                {{ $com['members_count'] }} Member
                            </span>
                            @if(isset($client->slug))
                            <a href="{{ route('demo.customer.sport', $client->slug) }}" class="mt-1 px-2.5 py-1 rounded bg-slate-800 hover:bg-slate-700 text-slate-300 hover:text-white text-[10px] font-medium transition">
                                Lihat di App
                            </a>
                            @endif
                        </div>
                    </div>
                    @endforeach
                    @endif
                </div>
            </div>

            <!-- Right: Open Mabar Board (5 Cols) -->
            <div class="lg:col-span-5 space-y-3">
                <div class="flex items-center justify-between pb-2 border-b border-slate-800">
                    <h3 class="text-sm font-bold text-white">Papan Mabar & Sparring</h3>
                    <span class="text-[9px] bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 px-2 py-0.5 rounded font-medium">Buka Slot</span>
                </div>

                <div class="space-y-2.5">
                    @if(isset($sportDatabase['initial_mabar_open']))
                    @foreach($sportDatabase['initial_mabar_open'] as $mbr)
                    <div class="bg-slate-900/70 border border-slate-800 rounded-xl p-3.5 hover:border-slate-700 transition">
                        <div class="flex items-center justify-between mb-1.5">
                            <span class="text-[10px] font-semibold text-emerald-400 uppercase">
                                {{ $mbr['sport_name'] }}
                            </span>
                            <span class="text-[9px] text-slate-300 bg-slate-800 px-1.5 py-0.5 rounded font-medium">
                                Butuh {{ $mbr['slots_needed'] }}
                            </span>
                        </div>

                        <h4 class="text-xs font-semibold text-white mb-2 leading-tight">
                            {{ $mbr['title'] }}
                        </h4>

                        <div class="text-[10px] text-slate-400 space-y-0.5 mb-2.5">
                            <p>{{ $mbr['date'] }} • {{ $mbr['time'] }} ({{ $mbr['court_name'] }})</p>
                            <p>Biaya: <strong class="text-slate-200">{{ $mbr['cost_per_person'] }}</strong></p>
                        </div>

                        <a href="https://wa.me/{{ $cleanWa }}?text={{ urlencode('Halo ' . $brandName . ', saya ingin join slot mabar: ' . $mbr['title'] . '.') }}" target="_blank" class="w-full py-1.5 rounded-lg bg-slate-800 hover:bg-slate-700 text-slate-200 font-semibold text-[11px] transition flex items-center justify-center gap-1.5">
                            <i class="fab fa-whatsapp text-emerald-400"></i>
                            <span>Join Slot Mabar</span>
                        </a>
                    </div>
                    @endforeach
                    @endif
                </div>
            </div>

        </div>

    </div>
</section>
