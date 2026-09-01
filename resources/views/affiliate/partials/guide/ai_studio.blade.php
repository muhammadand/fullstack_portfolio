<!-- TAB 2: AI SOCIAL STUDIO -->
<div id="tab-content-ai-studio" class="tab-pane hidden space-y-5">
    <div class="glass-card-glow p-5 rounded-2xl relative overflow-hidden">
        <div class="flex items-center gap-3 mb-2">
            <div class="w-10 h-10 rounded-xl bg-blue-600/20 border border-blue-500/30 flex items-center justify-center text-blue-400 text-sm shrink-0">
                <i class="fa-solid fa-wand-magic-sparkles"></i>
            </div>
            <div>
                <h2 class="text-sm font-bold text-white">AI Gemini Social Studio</h2>
                <p class="text-[11px] text-slate-300">Generator konten instan untuk WhatsApp, Facebook, IG & Telegram</p>
            </div>
        </div>
        <p class="text-xs text-slate-300 leading-relaxed mt-2">
            Cukup pilih tema atau klik inspirasi topik cepat di bawah. AI Gemini akan menuliskan caption berkelas siap share yang langsung mengarahkan calon klien ke link referral Anda!
        </p>
    </div>

    <!-- AI Generator Form -->
    <div class="glass-panel p-5 rounded-2xl space-y-4">
        <!-- Platform Selection -->
        <div>
            <label class="block text-xs font-semibold text-slate-300 mb-2">1. Pilih Saluran Media Sosial</label>
            <div class="grid grid-cols-3 gap-2">
                <label class="flex items-center gap-1.5 p-2 rounded-xl border border-white/10 bg-slate-900/50 cursor-pointer hover:border-blue-500 transition-colors">
                    <input type="radio" name="ai_platform" value="wa_story" checked class="text-blue-600 focus:ring-0">
                    <span class="text-[11px] text-white flex items-center gap-1"><i class="fa-brands fa-whatsapp text-emerald-400"></i> WhatsApp</span>
                </label>
                <label class="flex items-center gap-1.5 p-2 rounded-xl border border-white/10 bg-slate-900/50 cursor-pointer hover:border-blue-500 transition-colors">
                    <input type="radio" name="ai_platform" value="facebook" class="text-blue-600 focus:ring-0">
                    <span class="text-[11px] text-white flex items-center gap-1"><i class="fa-brands fa-facebook text-blue-400"></i> Facebook</span>
                </label>
                <label class="flex items-center gap-1.5 p-2 rounded-xl border border-white/10 bg-slate-900/50 cursor-pointer hover:border-blue-500 transition-colors">
                    <input type="radio" name="ai_platform" value="instagram" class="text-blue-600 focus:ring-0">
                    <span class="text-[11px] text-white flex items-center gap-1"><i class="fa-brands fa-instagram text-pink-400"></i> Instagram</span>
                </label>
                <label class="flex items-center gap-1.5 p-2 rounded-xl border border-white/10 bg-slate-900/50 cursor-pointer hover:border-blue-500 transition-colors">
                    <input type="radio" name="ai_platform" value="telegram" class="text-blue-600 focus:ring-0">
                    <span class="text-[11px] text-white flex items-center gap-1"><i class="fa-brands fa-telegram text-sky-400"></i> Telegram</span>
                </label>
                <label class="flex items-center gap-1.5 p-2 rounded-xl border border-white/10 bg-slate-900/50 cursor-pointer hover:border-blue-500 transition-colors">
                    <input type="radio" name="ai_platform" value="twitter" class="text-blue-600 focus:ring-0">
                    <span class="text-[11px] text-white flex items-center gap-1"><i class="fa-brands fa-x-twitter text-slate-300"></i> Twitter / X</span>
                </label>
                <label class="flex items-center gap-1.5 p-2 rounded-xl border border-white/10 bg-slate-900/50 cursor-pointer hover:border-blue-500 transition-colors">
                    <input type="radio" name="ai_platform" value="linkedin" class="text-blue-600 focus:ring-0">
                    <span class="text-[11px] text-white flex items-center gap-1"><i class="fa-brands fa-linkedin text-blue-400"></i> LinkedIn</span>
                </label>
            </div>
        </div>

        <!-- Quick Topic Preset Inspiration -->
        <div>
            <label class="block text-xs font-semibold text-slate-300 mb-1.5">2. Inspirasi Tema Cepat (Klik untuk Pilih)</label>
            <div class="flex flex-wrap gap-1.5 mb-2">
                <button type="button" onclick="setQuickTopic('Menu QR Resto & Cafe')" class="px-2.5 py-1 rounded-lg text-[10px] font-medium bg-slate-800/80 hover:bg-blue-600 text-slate-300 hover:text-white border border-white/10 transition-all">
                    Menu QR Resto
                </button>
                <button type="button" onclick="setQuickTopic('Pentingnya Website untuk Kredibilitas UMKM')" class="px-2.5 py-1 rounded-lg text-[10px] font-medium bg-slate-800/80 hover:bg-blue-600 text-slate-300 hover:text-white border border-white/10 transition-all">
                    Website Bisnis UMKM
                </button>
                <button type="button" onclick="setQuickTopic('Jasa Pembuatan Website Skripsi & Tugas Akhir Cepat')" class="px-2.5 py-1 rounded-lg text-[10px] font-medium bg-slate-800/80 hover:bg-blue-600 text-slate-300 hover:text-white border border-white/10 transition-all">
                    Web Skripsi & Mahasiswa
                </button>
                <button type="button" onclick="setQuickTopic('Promo Terbatas Website Bisnis Gratis Domain & Server')" class="px-2.5 py-1 rounded-lg text-[10px] font-medium bg-slate-800/80 hover:bg-blue-600 text-slate-300 hover:text-white border border-white/10 transition-all">
                    Promo Diskon & Domain
                </button>
                <button type="button" onclick="setQuickTopic('Automasi Order WhatsApp 24 Jam Non-stop')" class="px-2.5 py-1 rounded-lg text-[10px] font-medium bg-slate-800/80 hover:bg-blue-600 text-slate-300 hover:text-white border border-white/10 transition-all">
                    Automasi Order WA
                </button>
                <button type="button" onclick="setQuickTopic('Kisah Klien Omset Naik 3x Lipat Setelah Punya Website')" class="px-2.5 py-1 rounded-lg text-[10px] font-medium bg-slate-800/80 hover:bg-blue-600 text-slate-300 hover:text-white border border-white/10 transition-all">
                    Studi Kasus Naik Omset
                </button>
            </div>
            <input type="text" id="ai_custom_topic" placeholder="Ketik topik sendiri atau pilih tombol tema di atas..." class="w-full bg-slate-900/80 border border-white/10 rounded-xl px-3 py-2.5 text-xs text-white placeholder-slate-500 focus:outline-none focus:border-blue-500">
        </div>

        <!-- Persona / Angle -->
        <div>
            <label class="block text-xs font-semibold text-slate-300 mb-2">3. Sudut Pandang (Persona)</label>
            <select id="ai_persona" class="w-full bg-slate-900/80 border border-white/10 rounded-xl px-3 py-2.5 text-xs text-white focus:outline-none focus:border-blue-500">
                <option value="agency_consultant">Konsultan Digital Agency (Edukasi & Solutif)</option>
                <option value="case_study">Studi Kasus & Transformasi Bisnis UMKM</option>
                <option value="promo_limited">Penawaran Promo & Slot Terbatas</option>
                <option value="student_helper">Layanan Pembuatan Website Mahasiswa & Skripsi</option>
            </select>
        </div>

        <!-- Niche / Category -->
        <div>
            <label class="block text-xs font-semibold text-slate-300 mb-2">4. Target Kategori Industri (Opsional)</label>
            <select id="ai_category" class="w-full bg-slate-900/80 border border-white/10 rounded-xl px-3 py-2.5 text-xs text-white focus:outline-none focus:border-blue-500">
                <option value="">Umum (Semua UMKM)</option>
                @foreach($businessCategories as $cat)
                <option value="{{ $cat->name }}">{{ $cat->name }}</option>
                @endforeach
                <option value="Mahasiswa & Akademik">Mahasiswa & Skripsi</option>
            </select>
        </div>

        <button onclick="generateAiSocialPost()" id="btn-generate-ai" class="w-full py-3 bg-blue-600 hover:bg-blue-500 text-white text-xs font-bold rounded-xl shadow-lg shadow-blue-600/25 transition-all flex items-center justify-center gap-2">
            <i class="fa-solid fa-wand-magic-sparkles text-xs"></i>
            <span id="btn-ai-text">Generate Konten AI</span>
        </button>
    </div>

    <!-- Output Box -->
    <div id="ai-output-container" class="glass-panel p-5 rounded-2xl hidden space-y-4 border border-emerald-500/30 bg-emerald-500/5">
        <div class="flex items-center justify-between">
            <span class="text-xs font-semibold text-emerald-400 flex items-center gap-1.5">
                <i class="fa-solid fa-circle-check text-xs"></i> Draf Konten Siap Bagikan
            </span>
            <span class="text-[10px] text-slate-400">Link referral otomatis terpasang</span>
        </div>

        <textarea id="ai-generated-text" rows="8" class="w-full bg-slate-950/80 border border-white/10 rounded-xl p-3 text-xs text-slate-200 leading-relaxed font-sans focus:outline-none focus:border-emerald-500"></textarea>

        <!-- 1-Click Multi Share Action Bar -->
        <div>
            <span class="block text-[11px] font-semibold text-slate-300 mb-2">Langsung Bagikan ke:</span>
            <div class="grid grid-cols-4 gap-2">
                <a id="btn-share-wa" href="#" target="_blank" class="py-2.5 px-2 bg-emerald-600/20 hover:bg-emerald-600 border border-emerald-500/30 text-emerald-300 hover:text-white text-xs font-semibold rounded-xl transition-all flex items-center justify-center gap-1.5">
                    <i class="fa-brands fa-whatsapp text-sm"></i> WA
                </a>
                <a id="btn-share-fb" href="#" target="_blank" class="py-2.5 px-2 bg-blue-600/20 hover:bg-blue-600 border border-blue-500/30 text-blue-300 hover:text-white text-xs font-semibold rounded-xl transition-all flex items-center justify-center gap-1.5">
                    <i class="fa-brands fa-facebook text-sm"></i> FB
                </a>
                <a id="btn-share-tg" href="#" target="_blank" class="py-2.5 px-2 bg-sky-600/20 hover:bg-sky-600 border border-sky-500/30 text-sky-300 hover:text-white text-xs font-semibold rounded-xl transition-all flex items-center justify-center gap-1.5">
                    <i class="fa-brands fa-telegram text-sm"></i> Telegram
                </a>
                <a id="btn-share-tw" href="#" target="_blank" class="py-2.5 px-2 bg-slate-800 hover:bg-slate-700 border border-white/10 text-white text-xs font-semibold rounded-xl transition-all flex items-center justify-center gap-1.5">
                    <i class="fa-brands fa-x-twitter text-sm"></i> X/Twitter
                </a>
            </div>
        </div>

        <div class="flex gap-2 pt-2 border-t border-white/5">
            <button onclick="copyGeneratedAiText()" class="flex-1 py-2.5 bg-blue-600 hover:bg-blue-500 text-white text-xs font-semibold rounded-xl transition-all flex items-center justify-center gap-1.5 shadow-sm">
                <i class="fa-solid fa-copy text-xs"></i> Salin Teks (IG / TikTok)
            </button>
            <button onclick="generateAiSocialPost()" class="px-3.5 py-2.5 glass-panel text-slate-300 hover:text-white text-xs font-medium rounded-xl transition-all flex items-center gap-1">
                <i class="fa-solid fa-rotate-right text-xs"></i> Variasi Lain
            </button>
        </div>
    </div>
</div>
