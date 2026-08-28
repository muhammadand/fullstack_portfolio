            <div class="glass-panel rounded-2xl p-4">
                <div class="flex items-start justify-between mb-3">
                    <div>
                        <h3 class="text-base font-bold text-white mb-0.5">{{ $p->brand_name }}</h3>
                        <div class="flex items-center gap-2 text-[10px] text-slate-400">
                            <span class="px-2 py-0.5 rounded {{ $p->category_name ? 'bg-blue-500/20 text-blue-400' : 'bg-slate-700/50 text-slate-300' }}">
                                {{ $p->category_name ?? 'Tanpa Kategori' }}
                            </span>
                            @if($p->project_price)
                            <span><i class="fa-solid fa-tag mr-1 text-slate-500"></i>Rp {{ number_format($p->project_price, 0, ',', '.') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="w-10 h-10 rounded-xl bg-rose-500/10 flex items-center justify-center text-rose-400 text-lg">
                        <i class="fa-solid fa-file-pdf"></i>
                    </div>
                </div>

                <div class="flex items-center gap-2 mt-4">
                    <!-- Landing Page Split Button -->
                    <div class="flex flex-1 rounded-xl overflow-hidden border border-blue-500/30 shadow-sm active:scale-95 transition-transform">
                        <a href="{{ route('landing.dynamic', $p->slug) }}?ref={{ $affiliate->affiliate_code }}" target="_blank" class="flex-1 py-2 bg-blue-500/20 hover:bg-blue-500/30 text-blue-400 flex justify-center items-center text-[10px] font-semibold transition-colors whitespace-nowrap">
                            <i class="fa-solid fa-eye mr-1.5"></i> Landing
                        </a>
                        <button onclick="copyLink('{{ route('landing.dynamic', $p->slug) }}?ref={{ $affiliate->affiliate_code }}')" class="px-3 bg-blue-500/30 hover:bg-blue-500/40 text-blue-400 flex items-center justify-center border-l border-blue-500/30 transition-colors" title="Copy Link">
                            <i class="fa-solid fa-copy"></i>
                        </button>
                    </div>

                    <!-- Unduh Proposal Button -->
                    <a href="{{ route('proposal.dynamic', $p->slug) }}?ref={{ $affiliate->affiliate_code }}" target="_blank" class="flex-1 py-2 bg-emerald-500/20 hover:bg-emerald-500/30 border border-emerald-500/30 text-emerald-400 text-[10px] font-semibold rounded-xl transition-colors flex items-center justify-center gap-1.5 active:scale-95 whitespace-nowrap">
                        <i class="fa-solid fa-download"></i> Unduh Proposal
                    </a>
                </div>

                <div class="border-t border-white/10 mt-4 mb-3"></div>

                <div>
                    <label class="block text-[10px] font-semibold text-emerald-400 mb-1.5"><i class="fa-brands fa-whatsapp mr-1"></i> Share via WhatsApp:</label>
                    <div class="relative flex gap-2 items-center">
                        <div class="relative flex-1">
                            <select onchange="kirimWaLangsungAffiliate(this, '{{ $p->id }}', '{{ addslashes($p->brand_name) }}', '{{ $p->wa_number }}', '{{ route('landing.dynamic', $p->slug) }}?ref={{ $affiliate->affiliate_code }}', '{{ route('proposal.dynamic', $p->slug) }}?ref={{ $affiliate->affiliate_code }}')" class="w-full appearance-none pl-3 pr-8 py-2 bg-white/5 border border-emerald-500/30 text-emerald-300 text-xs font-medium rounded-xl focus:outline-none focus:border-emerald-500 cursor-pointer transition-all">
                                <option value="" disabled selected class="text-slate-800">Pilih Template Chat...</option>
                                @php
                                $filteredTemplates = $chatTemplates->filter(function($ct) use ($p) {
                                return is_null($ct->business_category_id) || $ct->business_category_id == $p->business_category_id;
                                });
                                @endphp
                                @foreach($filteredTemplates as $ct)
                                <option value="{{ base64_encode($ct->content) }}" class="text-slate-800">{{ $ct->name }}</option>
                                @endforeach
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3 text-emerald-400/70">
                                <i class="fa-solid fa-chevron-down text-[10px]"></i>
                            </div>
                        </div>

                        <div class="relative group shrink-0">
                            <button onclick="generateAiChatAndSend(this, '{{ $p->id }}', '{{ $p->wa_number }}', '{{ route('affiliate.proposals.generate_ai_chat', $p->id) }}', '{{ $tab === 'global' ? route('affiliate.proposals.claim', $p->id) : '' }}')" class="w-10 h-10 bg-indigo-500/20 text-indigo-400 hover:bg-indigo-500 hover:text-white border border-indigo-500/30 rounded-xl flex items-center justify-center transition-colors" title="Generate AI Chat">
                                <i class="fa-solid fa-robot"></i>
                            </button>
                            <!-- Tooltip -->
                            <div class="absolute bottom-full right-0 mb-2 w-48 bg-indigo-600 text-white text-[10px] text-center p-2 rounded-lg opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none z-10 shadow-lg shadow-indigo-500/20">
                                Biar AI yang tulis pesan personal & menarik untuk bisnis ini!
                                <div class="absolute -bottom-1 right-3.5 w-2 h-2 bg-indigo-600 rotate-45"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
