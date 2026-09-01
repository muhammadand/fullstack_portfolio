<!-- TAB 4: TARGET KATEGORI -->
<div id="tab-content-categories" class="tab-pane hidden space-y-5">
    <div class="glass-panel p-5 rounded-2xl">
        <h2 class="text-sm font-bold text-white mb-2 flex items-center gap-2">
            <i class="fa-solid fa-layer-group text-blue-400"></i> Kategori Bisnis Potensial
        </h2>
        <p class="text-xs text-slate-300 leading-relaxed">
            Pelajari kebutuhan digital spesifik dari tiap sektor usaha untuk mempertajam argumen penjualan Anda saat presentasi atau konsultasi dengan klien.
        </p>
    </div>

    <div class="space-y-4">
        @foreach($businessCategories as $category)
        <div class="glass-panel p-5 rounded-2xl relative overflow-hidden border border-white/10 hover:border-blue-500/30 transition-all">
            <div class="flex items-center justify-between mb-3">
                <div class="flex items-center gap-2.5">
                    <div class="w-8 h-8 rounded-lg bg-blue-500/20 text-blue-400 flex items-center justify-center text-xs font-bold">
                        <i class="fa-solid fa-store"></i>
                    </div>
                    <div>
                        <h3 class="text-xs font-bold text-white">{{ $category->name }}</h3>
                        <span class="text-[10px] text-slate-400">Estimasi Nilai Project: Rp {{ number_format($category->project_price, 0, ',', '.') }}</span>
                    </div>
                </div>
                <span class="px-2 py-0.5 rounded text-[10px] font-semibold bg-emerald-500/15 text-emerald-400 border border-emerald-500/25">
                    Komisi 10%
                </span>
            </div>

            @if($category->wa_template)
            <div class="p-3 rounded-xl bg-slate-900/60 border border-white/5 mb-3">
                <span class="text-[10px] text-slate-400 font-semibold uppercase tracking-wider block mb-1">Nilai Tambah untuk Klien:</span>
                <p class="text-xs text-slate-300 leading-relaxed line-clamp-3">{{ $category->wa_template }}</p>
            </div>
            @endif

            <div class="flex gap-2 pt-2 border-t border-white/5">
                <a href="{{ route('affiliate.proposals', ['category_id' => $category->id]) }}" wire:navigate class="flex-1 py-2 bg-blue-600 hover:bg-blue-500 text-white text-xs font-semibold rounded-xl transition-all text-center">
                    <i class="fa-solid fa-folder-plus mr-1 text-[11px]"></i> Buat Proposal
                </a>
                <a href="{{ route('affiliate.chat_templates.index') }}" wire:navigate class="px-3 py-2 glass-panel text-slate-300 hover:text-white text-xs font-medium rounded-xl transition-all flex items-center justify-center" title="Buka Template Chat">
                    <i class="fa-solid fa-comment-dots text-xs"></i>
                </a>
            </div>
        </div>
        @endforeach

        <!-- Target Ideas from TargetIdeaController -->
        @foreach($targetIdeas as $slug => $idea)
        <div class="glass-panel p-4 rounded-2xl border border-white/10 space-y-3">
            <div class="flex items-center gap-3">
                <img src="{{ $idea['image'] }}" alt="{{ $idea['title'] }}" loading="lazy" width="48" height="48" class="w-12 h-12 rounded-xl object-cover border border-white/10 shrink-0">
                <div>
                    <h4 class="text-xs font-bold text-white">{{ $idea['title'] }}</h4>
                    <p class="text-[11px] text-slate-400 line-clamp-1">{{ $idea['short_desc'] }}</p>
                </div>
            </div>
            <p class="text-xs text-slate-300 leading-relaxed bg-slate-900/50 p-2.5 rounded-xl border border-white/5">
                <b>Kebutuhan Website:</b> {{ $idea['reason'] }}
            </p>
            <div class="flex flex-wrap gap-1.5">
                @foreach($idea['features'] as $feat)
                <span class="px-2 py-0.5 rounded-md text-[9px] bg-white/5 text-slate-300 border border-white/10">
                    {{ $feat }}
                </span>
                @endforeach
            </div>
        </div>
        @endforeach
    </div>
</div>
