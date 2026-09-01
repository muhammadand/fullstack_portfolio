<!-- TAB 5: CASE STUDY KLIEN -->
<div id="tab-content-case-study" class="tab-pane hidden space-y-5">
    <div class="glass-panel p-5 rounded-2xl">
        <h2 class="text-sm font-bold text-white mb-2 flex items-center gap-2">
            <i class="fa-solid fa-briefcase text-blue-400"></i> Case Study & Portofolio Sukses
        </h2>
        <p class="text-xs text-slate-300 leading-relaxed">
            Gunakan bukti portofolio Scalify Intelligence ini saat berkomunikasi dengan calon klien guna membangun kepercayaan dan mempercepat proses closing.
        </p>
    </div>

    <div class="space-y-4">
        @forelse($portfolios as $item)
        <div class="glass-panel p-4 rounded-2xl border border-white/10 space-y-3">
            @if($item->thumbnail_image)
            <div class="rounded-xl overflow-hidden aspect-video bg-slate-900 relative">
                <img src="{{ asset('storage/' . $item->thumbnail_image) }}" alt="{{ $item->title }}" loading="lazy" class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-transparent"></div>
                <div class="absolute bottom-2 left-3 right-3 flex items-center justify-between">
                    <span class="text-xs font-bold text-white">{{ $item->client_name ?? $item->title }}</span>
                    <span class="px-2 py-0.5 rounded text-[10px] bg-blue-600/80 text-white font-semibold">{{ $item->project_type ?? 'Web Application' }}</span>
                </div>
            </div>
            @endif

            <div>
                <h3 class="text-xs font-bold text-white mb-1">{{ $item->title }}</h3>
                <p class="text-[11px] text-slate-300 leading-relaxed">{{ $item->short_description }}</p>
            </div>

            @if($item->result || $item->solution)
            <div class="p-3 rounded-xl bg-slate-900/70 border border-white/10 space-y-1.5">
                @if($item->solution)
                <p class="text-[11px] text-slate-300">
                    <b class="text-blue-400">Solusi:</b> {{ \Illuminate\Support\Str::limit($item->solution, 120) }}
                </p>
                @endif
                @if($item->result)
                <p class="text-[11px] text-emerald-400">
                    <b class="text-emerald-300">Hasil:</b> {{ \Illuminate\Support\Str::limit($item->result, 120) }}
                </p>
                @endif
            </div>
            @endif

            <div class="flex gap-2 pt-2 border-t border-white/5">
                @if($item->project_url)
                <a href="{{ $item->project_url }}" target="_blank" rel="noopener noreferrer" class="flex-1 py-2 bg-blue-600 hover:bg-blue-500 text-white text-xs font-semibold rounded-xl transition-all text-center">
                    <i class="fa-solid fa-arrow-up-right-from-square mr-1 text-[10px]"></i> Live Demo
                </a>
                @endif
                <button onclick="copyCaseStudy('{{ addslashes($item->title) }}', '{{ addslashes($item->client_name ?? 'Klien UMKM') }}', '{{ addslashes($item->result ?? $item->short_description) }}', '{{ $item->project_url ?? url('/') }}')" class="flex-1 py-2 glass-panel text-slate-300 hover:text-white text-xs font-semibold rounded-xl transition-all">
                    <i class="fa-solid fa-copy mr-1 text-[10px]"></i> Salin Ringkasan
                </button>
            </div>
        </div>
        @empty
        <div class="glass-panel p-6 rounded-2xl text-center">
            <i class="fa-solid fa-folder-open text-2xl text-slate-500 mb-2"></i>
            <p class="text-xs text-slate-400">Daftar portofolio klien akan segera diperbarui.</p>
        </div>
        @endforelse
    </div>
</div>
