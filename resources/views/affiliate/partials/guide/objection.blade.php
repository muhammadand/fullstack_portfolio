<!-- TAB 6: AI OBJECTION CRUSHER -->
<div id="tab-content-objection" class="tab-pane hidden space-y-5">
    <div class="glass-card-glow p-5 rounded-2xl relative overflow-hidden">
        <div class="flex items-center gap-3 mb-2">
            <div class="w-10 h-10 rounded-xl bg-blue-600/20 border border-blue-500/30 flex items-center justify-center text-blue-400 text-sm shrink-0">
                <i class="fa-solid fa-shield-halved"></i>
            </div>
            <div>
                <h2 class="text-sm font-bold text-white">AI Penakluk Penolakan</h2>
                <p class="text-[11px] text-slate-300">Asisten formulasi respon negosiasi dan keberatan klien</p>
            </div>
        </div>
        <p class="text-xs text-slate-300 leading-relaxed mt-2">
            Pilih atau ketik keberatan yang disampaikan calon klien. AI Gemini akan merumuskan balasan WhatsApp yang persuasif, sopan, dan berorientasi pada solusi investasi bisnis.
        </p>
    </div>

    <div class="glass-panel p-5 rounded-2xl space-y-4">
        <div>
            <label class="block text-xs font-semibold text-slate-300 mb-2">1. Pilih Keberatan Calon Klien</label>
            <select id="obj_type" onchange="toggleCustomObjection()" class="w-full bg-slate-900/80 border border-white/10 rounded-xl px-3 py-2.5 text-xs text-white focus:outline-none focus:border-blue-500">
                <option value="too_expensive">"Jasa website mahal banget ya, kan bisnis saya masih kecil?"</option>
                <option value="already_have_sosmed">"Kan saya sudah jualan di Instagram/TikTok, untuk apa website?"</option>
                <option value="no_budget_now">"Saat ini sedang sepi, nanti saja kalau ada budget lebih."</option>
                <option value="dont_understand_tech">"Saya kurang paham teknologi, khawatir sulit mengelolanya."</option>
                <option value="custom">Ketik Keberatan Calon Klien Sendiri...</option>
            </select>
        </div>

        <div id="custom-obj-box" class="hidden">
            <label class="block text-xs font-semibold text-slate-300 mb-2">Keberatan Klien:</label>
            <input type="text" id="obj_custom_text" placeholder="Contoh: Khawatir tidak ada yang membuka websitenya..." class="w-full bg-slate-900/80 border border-white/10 rounded-xl px-3 py-2.5 text-xs text-white focus:outline-none focus:border-blue-500">
        </div>

        <div>
            <label class="block text-xs font-semibold text-slate-300 mb-2">2. Jenis Bisnis Klien (Opsional)</label>
            <input type="text" id="obj_business_type" placeholder="Contoh: Toko Baju, Coffee Shop, Salon, Konveksi" class="w-full bg-slate-900/80 border border-white/10 rounded-xl px-3 py-2.5 text-xs text-white placeholder-slate-500 focus:outline-none focus:border-blue-500">
        </div>

        <button onclick="generateAiObjectionResponse()" id="btn-generate-obj" class="w-full py-3 bg-blue-600 hover:bg-blue-500 text-white text-xs font-bold rounded-xl shadow-lg shadow-blue-600/25 transition-all flex items-center justify-center gap-2">
            <i class="fa-solid fa-bolt text-xs"></i>
            <span id="btn-obj-text">Susun Balasan Persuasif</span>
        </button>
    </div>

    <!-- Output Box Objection -->
    <div id="obj-output-container" class="glass-panel p-5 rounded-2xl hidden space-y-3 border border-emerald-500/30 bg-emerald-500/5">
        <div class="flex items-center justify-between">
            <span class="text-xs font-semibold text-emerald-400 flex items-center gap-1.5">
                <i class="fa-solid fa-circle-check text-xs"></i> Draf Balasan WhatsApp
            </span>
            <span class="text-[10px] text-slate-400">Siap dikirim ke calon klien</span>
        </div>

        <textarea id="obj-generated-text" rows="6" class="w-full bg-slate-950/80 border border-white/10 rounded-xl p-3 text-xs text-slate-200 leading-relaxed font-sans focus:outline-none focus:border-emerald-500"></textarea>

        <button onclick="copyGeneratedObjText()" class="w-full py-2.5 bg-emerald-600 hover:bg-emerald-500 text-white text-xs font-semibold rounded-xl transition-all flex items-center justify-center gap-1.5 shadow-sm">
            <i class="fa-solid fa-copy text-xs"></i> Salin Balasan ke WhatsApp
        </button>
    </div>
</div>
