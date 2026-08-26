@props(['totalProjects', 'totalClicks'])

<div class="space-y-7 mb-8">

    <!-- SECTION: ALAT PROMOSI -->
    <div>
        <h3 class="text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-3.5 pl-2 border-l-2 border-indigo-500 flex items-center gap-1.5">
            <i class="fa-solid fa-bullhorn text-indigo-400 text-[10px]"></i> Alat Promosi
        </h3>
        <div class="grid grid-cols-4 gap-y-4 gap-x-2">
            <!-- 1. Bagikan Web -->
            <div class="flex flex-col items-center gap-2 cursor-pointer group" onclick="openShareModal()">
                <div class="w-12 h-12 rounded-2xl glass-panel flex items-center justify-center text-indigo-400 text-lg shadow-inner relative transition-all active:scale-95 group-hover:bg-indigo-500/10 group-hover:border-indigo-500/30">
                    <i class="fa-solid fa-share-nodes"></i>
                </div>
                <span class="text-[10px] text-slate-300 font-medium text-center leading-tight group-hover:text-white transition-colors">Bagikan<br>Web</span>
            </div>

            <!-- 2. Katalog Proposal -->
            <a href="{{ route('affiliate.proposals') }}" wire:navigate class="flex flex-col items-center gap-2 group">
                <div class="w-12 h-12 rounded-2xl glass-panel flex items-center justify-center text-rose-400 text-lg shadow-inner relative transition-all active:scale-95 group-hover:bg-rose-500/10 group-hover:border-rose-500/30">
                    <i class="fa-solid fa-folder-open"></i>
                </div>
                <span class="text-[10px] text-slate-300 font-medium text-center leading-tight group-hover:text-white transition-colors">Katalog<br>Proposal</span>
            </a>

            <!-- 3. Template Chat -->
            <a href="{{ route('affiliate.chat_templates.index') }}" wire:navigate class="flex flex-col items-center gap-2 group">
                <div class="w-12 h-12 rounded-2xl glass-panel flex items-center justify-center text-teal-400 text-lg shadow-inner transition-all active:scale-95 group-hover:bg-teal-500/10 group-hover:border-teal-500/30">
                    <i class="fa-solid fa-message"></i>
                </div>
                <span class="text-[10px] text-slate-300 font-medium text-center leading-tight group-hover:text-white transition-colors">Template<br>Chat</span>
            </a>

            <!-- 4. Data Mahasiswa -->
            <a href="{{ route('affiliate.student_leads.index') }}" wire:navigate class="flex flex-col items-center gap-2 group">
                <div class="w-12 h-12 rounded-2xl glass-panel flex items-center justify-center text-cyan-400 text-lg shadow-inner transition-all active:scale-95 group-hover:bg-cyan-500/10 group-hover:border-cyan-500/30">
                    <i class="fa-solid fa-users"></i>
                </div>
                <span class="text-[10px] text-slate-300 font-medium text-center leading-tight group-hover:text-white transition-colors">Data<br>Mahasiswa</span>
            </a>

            <!-- 5. Project Deal -->
            <a href="{{ route('affiliate.history') }}" wire:navigate class="flex flex-col items-center gap-2 group">
                <div class="w-12 h-12 rounded-2xl glass-panel flex items-center justify-center text-emerald-400 text-lg shadow-inner transition-all active:scale-95 group-hover:bg-emerald-500/10 group-hover:border-emerald-500/30">
                    <div class="flex items-center gap-1">
                        <span class="font-bold text-sm">{{ $totalProjects }}</span>
                    </div>
                </div>
                <span class="text-[10px] text-slate-300 font-medium text-center leading-tight group-hover:text-white transition-colors">Project<br>Deal</span>
            </a>

            <!-- 6. Riwayat Dana -->
            <a href="{{ route('affiliate.history') }}" wire:navigate class="flex flex-col items-center gap-2 group">
                <div class="w-12 h-12 rounded-2xl glass-panel flex items-center justify-center text-blue-400 text-lg shadow-inner transition-all active:scale-95 group-hover:bg-blue-500/10 group-hover:border-blue-500/30">
                    <i class="fa-solid fa-clock-rotate-left"></i>
                </div>
                <span class="text-[10px] text-slate-300 font-medium text-center leading-tight group-hover:text-white transition-colors">Riwayat<br>Dana</span>
            </a>
        </div>
    </div>

    <!-- SECTION: KONTEN & INTERAKSI -->
    <div>
        <h3 class="text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-3.5 pl-2 border-l-2 border-orange-500 flex items-center gap-1.5">
            <i class="fa-solid fa-fire text-orange-400 text-[10px]"></i> Konten & Interaksi
        </h3>
        <div class="grid grid-cols-4 gap-y-4 gap-x-2">
            <!-- 4. Tulis Artikel -->
            <a href="{{ route('affiliate.blogs.index') }}" wire:navigate class="flex flex-col items-center gap-2 group">
                <div class="w-12 h-12 rounded-2xl glass-panel flex items-center justify-center text-orange-400 text-lg shadow-inner transition-all active:scale-95 group-hover:bg-orange-500/10 group-hover:border-orange-500/30 relative">
                    <i class="fa-solid fa-pen-nib"></i>
                    <!-- Badge Point -->
                    <span class="absolute -top-1.5 -right-1.5 bg-yellow-500 text-white text-[8px] font-bold px-1.5 py-0.5 rounded-full shadow-md shadow-yellow-500/40 animate-pulse">+Poin</span>
                </div>
                <span class="text-[10px] text-slate-300 font-medium text-center leading-tight group-hover:text-white transition-colors">Tulis<br>Artikel</span>
            </a>

            <!-- 5. Scalify Store (Tukar Poin) -->
            <a href="{{ route('affiliate.store') }}" wire:navigate class="flex flex-col items-center gap-2 group">
                <div class="w-12 h-12 rounded-2xl glass-panel flex items-center justify-center text-pink-400 text-lg shadow-inner transition-all active:scale-95 group-hover:bg-pink-500/10 group-hover:border-pink-500/30">
                    <i class="fa-solid fa-store"></i>
                </div>
                <span class="text-[10px] text-slate-300 font-medium text-center leading-tight group-hover:text-white transition-colors">Tukar<br>Poin</span>
            </a>
        </div>
    </div>



    <!-- SECTION: PANDUAN & AKSES -->
    <div>
        <h3 class="text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-3.5 pl-2 border-l-2 border-purple-500 flex items-center gap-1.5">
            <i class="fa-solid fa-circle-question text-purple-400 text-[10px]"></i> Panduan & Akses
        </h3>
        <div class="grid grid-cols-4 gap-y-4 gap-x-2">
            <!-- 8. Cara Kerja -->
            <a href="{{ route('affiliate.guide') }}" wire:navigate onclick="closeDashboardCoachMark()" class="flex flex-col items-center gap-2 relative group">
                <div class="w-12 h-12 rounded-2xl glass-panel flex items-center justify-center text-yellow-400 text-lg shadow-inner transition-all active:scale-95 group-hover:bg-yellow-500/10 group-hover:border-yellow-500/30">
                    <i class="fa-solid fa-book-open"></i>
                </div>
                <span class="text-[10px] text-slate-300 font-medium text-center leading-tight group-hover:text-white transition-colors">Cara<br>Kerja</span>

                <!-- Coach Mark -->
                <div id="dashboardCoachMark" class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 hidden z-[60] w-44 pointer-events-none">
                    <div class="bg-blue-600 text-white text-[11px] font-medium p-3 rounded-2xl shadow-xl shadow-blue-500/30 relative animate-bounce text-center">
                        Yuk baca panduan Cara Kerja dulu!
                        <div class="absolute -bottom-1.5 left-1/2 -translate-x-1/2 w-3 h-3 bg-blue-600 rotate-45"></div>
                    </div>
                    <!-- Glow ring around the icon -->
                    <div class="absolute top-[3rem] left-1/2 -translate-x-1/2 w-16 h-16 rounded-3xl border-2 border-blue-500 animate-ping"></div>
                </div>
            </a>

            <!-- 9. Bagikan Akses -->
            <a href="{{ route('affiliate.magic_login_qr') }}" wire:navigate class="flex flex-col items-center gap-2 group">
                <div class="w-12 h-12 rounded-2xl glass-panel flex items-center justify-center text-purple-400 text-lg shadow-inner transition-all active:scale-95 group-hover:bg-purple-500/10 group-hover:border-purple-500/30">
                    <i class="fa-solid fa-key"></i>
                </div>
                <span class="text-[10px] text-slate-300 font-medium text-center leading-tight group-hover:text-white transition-colors">Akses<br>Login</span>
            </a>
        </div>
    </div>

</div>
