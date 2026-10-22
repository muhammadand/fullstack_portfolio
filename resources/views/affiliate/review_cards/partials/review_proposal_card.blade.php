<div class="glass-panel rounded-2xl p-4 transition-all hover:border-blue-500/30">
    <div class="flex items-start justify-between mb-2.5">
        <div>
            <h3 class="text-base font-bold text-white mb-1">{{ $p->brand_name }}</h3>
            <div class="flex flex-wrap items-center gap-1.5 text-[10px]">
                <!-- Kategori Bisnis -->
                <span class="px-2 py-0.5 rounded {{ $p->category_name || ($p->category ? $p->category->name : null) ? 'bg-blue-500/20 text-blue-400' : 'bg-slate-700/50 text-slate-300' }}">
                    <i class="fa-solid fa-tag text-[9px] mr-1"></i>{{ $p->category_name ?? ($p->category->name ?? 'Bisnis') }}
                </span>

                <!-- Status Penawaran Website (Cross-Sell Status) -->
                @php
                $webOffer = $p->offerings ? $p->offerings->firstWhere('product_type', 'website') : null;
                @endphp
                @if($webOffer)
                @if($webOffer->affiliate_id === $affiliate->id)
                <span class="px-2 py-0.5 rounded bg-emerald-500/20 text-emerald-300 font-medium" title="Bisnis ini sudah Anda follow up untuk Pembuatan Website">
                    <i class="fa-solid fa-laptop-code mr-0.5"></i> Web: Anda
                </span>
                @else
                <span class="px-2 py-0.5 rounded bg-amber-500/20 text-amber-300 font-medium" title="Bisnis ini sudah di-follow up website oleh partner lain">
                    <i class="fa-solid fa-user-check mr-0.5"></i> Web: Partner Lain
                </span>
                @endif
                @else
                <span class="px-2 py-0.5 rounded bg-slate-800 text-slate-400" title="Bisnis ini belum ditawari website">
                    <i class="fa-solid fa-circle-notch mr-0.5"></i> Web: Belum
                </span>
                @endif
            </div>
        </div>

        <!-- Icon Google Review Pin -->
        <div class="w-10 h-10 rounded-xl bg-blue-500/10 border border-blue-500/20 flex items-center justify-center text-blue-400 text-lg shrink-0">
            <i class="fa-solid fa-qrcode"></i>
        </div>
    </div>

    <!-- Info Singkat Target & No WA -->
    <div class="flex items-center justify-between text-xs text-slate-300 bg-slate-900/60 rounded-xl px-3 py-2 my-3 border border-white/5">
        <div class="flex items-center gap-1.5">
            <i class="fa-brands fa-whatsapp text-emerald-400"></i>
            <span class="font-mono text-[11px]">{{ $p->wa_number ?? '-' }}</span>
        </div>
        <div class="text-[10px] text-blue-300 font-semibold flex items-center gap-1">
            <i class="fa-solid fa-star text-amber-400"></i> Target Ulasan Bintang 5
        </div>
    </div>

    <div class="border-t border-white/10 my-3"></div>

    <!-- Template Chat & AI Action -->
    <div>
        <label class="block text-[10px] font-semibold text-blue-400 mb-1.5">
            <i class="fa-brands fa-whatsapp mr-1 text-emerald-400"></i> Hubungi & Tawarkan Review Card:
        </label>
        <div class="relative flex gap-2 items-center">
            <div class="relative flex-1">
                <select onchange="kirimWaReviewCard(this, '{{ $p->id }}', '{{ addslashes($p->brand_name) }}', '{{ $p->wa_number }}')" class="w-full appearance-none pl-3 pr-8 py-2 bg-white/5 border border-blue-500/30 text-blue-200 text-xs font-medium rounded-xl focus:outline-none focus:border-blue-500 cursor-pointer transition-all">
                    <option value="" disabled selected class="text-slate-800">Pilih Template Chat...</option>
                    @foreach($chatTemplates as $ct)
                    <option value="{{ base64_encode($ct->content) }}" class="text-slate-800">{{ $ct->name }}</option>
                    @endforeach
                </select>
                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3 text-blue-400/70">
                    <i class="fa-solid fa-chevron-down text-[10px]"></i>
                </div>
            </div>

            <!-- Tombol AI Generate WhatsApp Pitch -->
            <div class="relative group shrink-0">
                <button onclick="generateAiReviewCardChat(this, '{{ $p->id }}', '{{ $p->wa_number }}', '{{ route('affiliate.review_proposals.generate_ai_chat', $p->id) }}', '{{ $tab === 'global' ? route('affiliate.review_proposals.claim', $p->id) : '' }}')" class="w-10 h-10 bg-indigo-500/20 text-indigo-400 hover:bg-indigo-500 hover:text-white border border-indigo-500/30 rounded-xl flex items-center justify-center transition-colors" title="Biar AI yang tulis chat penawaran kartu review!">
                    <i class="fa-solid fa-robot"></i>
                </button>
                <div class="absolute bottom-full right-0 mb-2 w-48 bg-indigo-600 text-white text-[10px] text-center p-2 rounded-lg opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none z-10 shadow-lg shadow-indigo-500/20">
                    Biar AI yang susun kata-kata penawaran kartu review bintang 5!
                    <div class="absolute -bottom-1 right-3.5 w-2 h-2 bg-indigo-600 rotate-45"></div>
                </div>
            </div>
        </div>
    </div>
</div>
