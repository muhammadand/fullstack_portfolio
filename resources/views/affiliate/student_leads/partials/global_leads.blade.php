<div class="glass-panel p-4 rounded-2xl relative overflow-hidden">
    <div class="absolute top-0 right-0 w-20 h-20 bg-cyan-500/10 rounded-bl-full blur-xl pointer-events-none"></div>

    <div class="flex justify-between items-start mb-3">
        <div>
            <h3 class="font-bold text-sm text-white mb-1">{{ $lead->name ?? 'Anonim' }}</h3>
            <p class="text-[11px] text-slate-400"><i class="fa-solid fa-graduation-cap mr-1 text-cyan-400"></i> {{ $lead->university ?? 'Universitas Belum Diisi' }}</p>
        </div>
        <div class="flex items-center gap-2">
            @if($lead->status === 'new')
            <span class="px-2 py-1 bg-yellow-500/20 text-yellow-400 rounded-md text-[10px] font-bold">Baru</span>
            @elseif($lead->status === 'contacted')
            <span class="px-2 py-1 bg-blue-500/20 text-blue-400 rounded-md text-[10px] font-bold">Dihubungi</span>
            @elseif($lead->status === 'deal')
            <span class="px-2 py-1 bg-emerald-500/20 text-emerald-400 rounded-md text-[10px] font-bold">Deal</span>
            @endif
        </div>
    </div>

    <div class="bg-white/5 rounded-xl p-3 mb-4">
        <p class="text-[11px] text-slate-300 font-medium mb-1"><i class="fa-solid fa-clipboard-list mr-1"></i> Kebutuhan:</p>
        <p class="text-xs text-white font-bold">{{ $lead->needs }}</p>
    </div>

    <div class="mt-2">
        <label class="block text-[10px] font-semibold text-emerald-400 mb-1.5"><i class="fa-brands fa-whatsapp mr-1"></i> Pilih Template Chat & Klaim:</label>
        <div class="relative flex gap-2 items-center">
            <div class="relative flex-1">
                <select onchange="kirimWaLangsungAffiliate(this, '{{ $lead->id }}', '{{ addslashes($lead->name) }}', '{{ $lead->wa_number }}', '{{ $lead->proposal_slug ? route('landing.dynamic', $lead->proposal_slug) . '?ref=' . $affiliate->affiliate_code : '' }}', '{{ $lead->proposal_slug ? route('proposal.dynamic', $lead->proposal_slug) . '?ref=' . $affiliate->affiliate_code : '' }}', '{{ route('affiliate.student_leads.claim', $lead->id) }}')" class="w-full appearance-none pl-3 pr-8 py-2 bg-white/5 border border-emerald-500/30 text-emerald-300 text-xs font-medium rounded-xl focus:outline-none focus:border-emerald-500 cursor-pointer transition-all">
                    <option value="" disabled selected class="text-slate-800">Pilih Template Chat...</option>
                    @foreach($chatTemplates as $ct)
                    <option value="{{ base64_encode($ct->content) }}" class="text-slate-800">{{ $ct->name }}</option>
                    @endforeach
                </select>
                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3 text-emerald-400/70">
                    <i class="fa-solid fa-chevron-down text-[10px]"></i>
                </div>
            </div>

            <div class="relative group shrink-0">
                <button onclick="openAiOfferModal('{{ $lead->id }}', '{{ addslashes($lead->name) }}', '{{ $lead->wa_number }}', '{{ addslashes($lead->needs) }}', '{{ route('affiliate.student_leads.claim', $lead->id) }}')" class="w-10 h-10 bg-indigo-500/20 text-indigo-400 hover:bg-indigo-500 hover:text-white border border-indigo-500/30 rounded-xl flex items-center justify-center transition-colors" title="Rekomendasi AI (Produk & Jasa)">
                    <i class="fa-solid fa-wand-magic-sparkles"></i>
                </button>
                <!-- Tooltip -->
                <div class="absolute bottom-full right-0 mb-2 w-48 bg-indigo-600 text-white text-[10px] text-center p-2 rounded-lg opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none z-10 shadow-lg shadow-indigo-500/20">
                    Pilih produk digital & biarkan AI buatkan chat soft-selling!
                    <div class="absolute -bottom-1 right-3.5 w-2 h-2 bg-indigo-600 rotate-45"></div>
                </div>
            </div>
        </div>
    </div>

    @if($lead->proposal_slug)
    <div class="flex gap-2 mt-3">
        <a href="{{ route('landing.dynamic', $lead->proposal_slug) }}" target="_blank" class="flex-1 py-2 bg-white/10 hover:bg-white/20 text-white text-center text-xs font-bold rounded-xl transition-colors">
            <i class="fa-solid fa-globe mr-1"></i> Lihat Proposal
        </a>
    </div>
    @endif
</div>
