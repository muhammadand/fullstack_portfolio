<!-- TAB 1: ROADMAP 1 DEAL & SPRINT CALENDAR -->
<div id="tab-content-roadmap" class="tab-pane space-y-5">
    <!-- Role Definition -->
    <div class="glass-panel p-5 rounded-2xl relative overflow-hidden">
        <div class="flex items-center gap-3 mb-2.5">
            <div class="w-8 h-8 rounded-lg bg-blue-500/20 text-blue-400 flex items-center justify-center font-bold text-sm">
                <i class="fa-solid fa-building-columns"></i>
            </div>
            <h2 class="text-sm font-bold text-white">Posisi Anda: Creative Agency Partner</h2>
        </div>
        <p class="text-xs text-slate-300 leading-relaxed">
            Anda bukan sekadar penyebar link, melainkan <b>Konsultan Transformasi Digital</b> dari Scalify Intelligence. Tugas Anda adalah membantu UMKM dan pemilik usaha memiliki website resmi dengan automasi dan integrasi WhatsApp.
        </p>
    </div>

    <!-- 3-Step Closing Formula -->
    <div>
        <h2 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-3 px-1 flex items-center gap-2">
            <i class="fa-solid fa-circle-check text-blue-400"></i> Formula 3 Langkah Closing
        </h2>
        <div class="space-y-3">
            <!-- Step 1 -->
            <div class="glass-panel p-4 rounded-2xl border-l-2 border-blue-500">
                <div class="flex items-start gap-3">
                    <div class="w-6 h-6 rounded-lg bg-blue-500/20 text-blue-400 flex items-center justify-center font-bold text-xs shrink-0 mt-0.5">1</div>
                    <div class="flex-1">
                        <h3 class="text-xs font-bold text-white mb-1">Riset 10 Target UMKM (10 Menit)</h3>
                        <p class="text-[11px] text-slate-300 leading-relaxed mb-2">
                            Buka Google Maps atau Instagram, cari bisnis lokal (Cafe, Salon, Rental Kendaraan, Klinik, Bakery) yang belum memiliki tautan website resmi.
                        </p>
                        <span class="text-[10px] text-blue-400 font-medium flex items-center gap-1">
                            <i class="fa-solid fa-info-circle text-[9px]"></i> Lihat tab "Target Kategori" untuk referensi kebutuhan industri.
                        </span>
                    </div>
                </div>
            </div>

            <!-- Step 2 -->
            <div class="glass-panel p-4 rounded-2xl border-l-2 border-emerald-500">
                <div class="flex items-start gap-3">
                    <div class="w-6 h-6 rounded-lg bg-emerald-500/20 text-emerald-400 flex items-center justify-center font-bold text-xs shrink-0 mt-0.5">2</div>
                    <div class="flex-1">
                        <h3 class="text-xs font-bold text-white mb-1">Generate Live Proposal Klien</h3>
                        <p class="text-[11px] text-slate-300 leading-relaxed mb-2">
                            Buka menu <b>Katalog Proposal</b> di dashboard, masukkan nama bisnis prospek. Sistem akan secara otomatis membuat mockup landing page interaktif dengan nama bisnis mereka.
                        </p>
                        <a href="{{ route('affiliate.proposals') }}" wire:navigate class="inline-flex items-center gap-1.5 text-[11px] font-semibold text-emerald-400 hover:text-emerald-300">
                            Buka Katalog Proposal <i class="fa-solid fa-arrow-right text-[10px]"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Step 3 -->
            <div class="glass-panel p-4 rounded-2xl border-l-2 border-indigo-500">
                <div class="flex items-start gap-3">
                    <div class="w-6 h-6 rounded-lg bg-indigo-500/20 text-indigo-400 flex items-center justify-center font-bold text-xs shrink-0 mt-0.5">3</div>
                    <div class="flex-1">
                        <h3 class="text-xs font-bold text-white mb-1">Kirim Chat WhatsApp & Follow-Up</h3>
                        <p class="text-[11px] text-slate-300 leading-relaxed mb-2">
                            Gunakan <b>Template Chat</b> atau minta <b>AI Social Studio</b> untuk menyusun pesan konsultasi yang sopan dan profesional kepada pemilik bisnis.
                        </p>
                        <a href="{{ route('affiliate.chat_templates.index') }}" wire:navigate class="inline-flex items-center gap-1.5 text-[11px] font-semibold text-indigo-400 hover:text-indigo-300">
                            Buka Template Chat <i class="fa-solid fa-arrow-right text-[10px]"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Interactive 7-Day Sprint Calendar Widget -->
    <div class="glass-panel p-5 rounded-2xl space-y-4">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-xs font-bold text-slate-300 uppercase tracking-wider flex items-center gap-2">
                    <i class="fa-solid fa-calendar-days text-blue-400"></i> Kalender Sprint 7 Hari (1 Deal)
                </h2>
                <p class="text-[11px] text-slate-400 mt-0.5">Pilih hari untuk melihat panduan aksi harian</p>
            </div>
            <div class="text-right">
                <span id="sprint-progress-badge" class="px-2 py-0.5 rounded text-[10px] font-semibold bg-blue-500/20 text-blue-300 border border-blue-400/30">
                    0/6 Selesai
                </span>
            </div>
        </div>

        <!-- Horizontal Day Selector Strip -->
        <div class="grid grid-cols-6 gap-1.5 pt-1">
            <button type="button" onclick="selectSprintDay(1)" id="day-btn-1" class="day-tab-btn active p-2 rounded-xl text-center border transition-all flex flex-col items-center justify-center">
                <span class="text-[9px] font-semibold uppercase text-slate-400">Sen</span>
                <span class="text-xs font-bold mt-0.5 text-white">01</span>
                <i id="check-icon-1" class="fa-solid fa-circle-check text-[9px] text-emerald-400 mt-1 hidden"></i>
            </button>
            <button type="button" onclick="selectSprintDay(2)" id="day-btn-2" class="day-tab-btn p-2 rounded-xl text-center border transition-all flex flex-col items-center justify-center">
                <span class="text-[9px] font-semibold uppercase text-slate-400">Sel</span>
                <span class="text-xs font-bold mt-0.5 text-white">02</span>
                <i id="check-icon-2" class="fa-solid fa-circle-check text-[9px] text-emerald-400 mt-1 hidden"></i>
            </button>
            <button type="button" onclick="selectSprintDay(3)" id="day-btn-3" class="day-tab-btn p-2 rounded-xl text-center border transition-all flex flex-col items-center justify-center">
                <span class="text-[9px] font-semibold uppercase text-slate-400">Rab</span>
                <span class="text-xs font-bold mt-0.5 text-white">03</span>
                <i id="check-icon-3" class="fa-solid fa-circle-check text-[9px] text-emerald-400 mt-1 hidden"></i>
            </button>
            <button type="button" onclick="selectSprintDay(4)" id="day-btn-4" class="day-tab-btn p-2 rounded-xl text-center border transition-all flex flex-col items-center justify-center">
                <span class="text-[9px] font-semibold uppercase text-slate-400">Kam</span>
                <span class="text-xs font-bold mt-0.5 text-white">04</span>
                <i id="check-icon-4" class="fa-solid fa-circle-check text-[9px] text-emerald-400 mt-1 hidden"></i>
            </button>
            <button type="button" onclick="selectSprintDay(5)" id="day-btn-5" class="day-tab-btn p-2 rounded-xl text-center border transition-all flex flex-col items-center justify-center">
                <span class="text-[9px] font-semibold uppercase text-slate-400">Jum</span>
                <span class="text-xs font-bold mt-0.5 text-white">05</span>
                <i id="check-icon-5" class="fa-solid fa-circle-check text-[9px] text-emerald-400 mt-1 hidden"></i>
            </button>
            <button type="button" onclick="selectSprintDay(6)" id="day-btn-6" class="day-tab-btn p-2 rounded-xl text-center border transition-all flex flex-col items-center justify-center">
                <span class="text-[9px] font-semibold uppercase text-slate-400">Weekend</span>
                <span class="text-xs font-bold mt-0.5 text-white">06-7</span>
                <i id="check-icon-6" class="fa-solid fa-circle-check text-[9px] text-emerald-400 mt-1 hidden"></i>
            </button>
        </div>

        <!-- Dynamic Day Detail Card -->
        <div id="sprint-detail-card" class="p-4 rounded-xl bg-slate-900/70 border border-white/10 space-y-3">
            <div class="flex items-center justify-between">
                <div>
                    <span id="sprint-day-badge" class="text-[10px] font-bold text-blue-400 uppercase tracking-wider">Hari 1: Senin</span>
                    <h3 id="sprint-day-title" class="text-sm font-bold text-white mt-0.5">Riset 10 Bisnis Lokal di Google Maps</h3>
                </div>
                <span id="sprint-day-target" class="px-2 py-0.5 rounded text-[10px] font-mono font-semibold bg-white/5 text-slate-300 border border-white/10">
                    Target: 10 Kontak
                </span>
            </div>

            <p id="sprint-day-desc" class="text-xs text-slate-300 leading-relaxed">
                Buka Google Maps atau Instagram di area kota Anda. Cari 10 bisnis lokal (contoh: Cafe, Salon, Rental Mobil, Klinik, Bakery) yang belum memiliki link website di profil mereka. Simpan nama bisnis dan nomor WhatsApp pemilik usaha.
            </p>

            <!-- Step Checklist -->
            <div class="p-3 rounded-lg bg-black/20 border border-white/5 space-y-2 text-xs">
                <div class="flex items-center gap-2">
                    <input type="checkbox" id="task-check-1" onchange="toggleTaskDone(1)" class="rounded border-white/20 bg-slate-800 text-blue-600 focus:ring-0">
                    <label for="task-check-1" id="task-label-1" class="text-slate-300 cursor-pointer">Tandai aksi hari ini selesai</label>
                </div>
            </div>

            <!-- Direct Action Shortcut -->
            <div class="pt-1 flex gap-2" id="sprint-action-box">
                <button onclick="switchTab('categories')" class="flex-1 py-2 bg-blue-600 hover:bg-blue-500 text-white text-xs font-semibold rounded-xl transition-all flex items-center justify-center gap-1.5">
                    <i class="fa-solid fa-layer-group text-xs"></i> Lihat Referensi Kategori
                </button>
            </div>
        </div>
    </div>
</div>
