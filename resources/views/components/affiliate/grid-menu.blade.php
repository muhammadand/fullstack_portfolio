@props(['totalProjects', 'totalClicks'])

<div class="grid grid-cols-4 gap-y-6 gap-x-2 mb-8">
    <!-- 1. Bagikan Web -->
    <div class="flex flex-col items-center gap-2 cursor-pointer" onclick="openShareModal()">
        <div class="w-12 h-12 rounded-2xl glass-panel flex items-center justify-center text-indigo-400 text-lg shadow-inner relative transition-transform active:scale-95">
            <i class="fa-solid fa-share-nodes"></i>
        </div>
        <span class="text-[10px] text-slate-300 font-medium text-center leading-tight">Bagikan<br>Web</span>
    </div>

    <!-- 2. Katalog Proposal -->
    <a href="{{ route('affiliate.proposals') }}" class="flex flex-col items-center gap-2">
        <div class="w-12 h-12 rounded-2xl glass-panel flex items-center justify-center text-rose-400 text-lg shadow-inner relative transition-transform active:scale-95">
            <i class="fa-solid fa-folder-open"></i>
        </div>
        <span class="text-[10px] text-slate-300 font-medium text-center leading-tight">Katalog<br>Proposal</span>
    </a>

    <!-- 3. Riwayat Dana -->
    <a href="{{ route('affiliate.history') }}" class="flex flex-col items-center gap-2">
        <div class="w-12 h-12 rounded-2xl glass-panel flex items-center justify-center text-blue-400 text-lg shadow-inner transition-transform active:scale-95">
            <i class="fa-solid fa-clock-rotate-left"></i>
        </div>
        <span class="text-[10px] text-slate-300 font-medium text-center leading-tight">Riwayat<br>Dana</span>
    </a>

    <!-- 4. Bagikan Akses -->
    <a href="{{ route('affiliate.magic_login_qr') }}" class="flex flex-col items-center gap-2">
        <div class="w-12 h-12 rounded-2xl glass-panel flex items-center justify-center text-purple-400 text-lg shadow-inner transition-transform active:scale-95">
            <i class="fa-solid fa-key"></i>
        </div>
        <span class="text-[10px] text-slate-300 font-medium text-center leading-tight">Akses<br>Login</span>
    </a>

    <!-- 5. Project Deal -->
    <div class="flex flex-col items-center gap-2">
        <div class="w-12 h-12 rounded-2xl glass-panel flex items-center justify-center text-emerald-400 text-lg shadow-inner">
            <div class="flex items-center gap-1">
                <span class="font-bold text-sm">{{ $totalProjects }}</span>
            </div>
        </div>
        <span class="text-[10px] text-slate-300 font-medium text-center leading-tight">Project<br>Deal</span>
    </div>

    <!-- 6. Total Klik -->
    {{-- <div class="flex flex-col items-center gap-2">
        <div class="w-12 h-12 rounded-2xl glass-panel flex items-center justify-center text-yellow-400 text-lg shadow-inner">
            <div class="flex items-center gap-1">
                <span class="font-bold text-sm">{{ $totalClicks }}</span>
</div>
</div>
<span class="text-[10px] text-slate-300 font-medium text-center leading-tight">Total<br>Klik</span>
</div> --}}

<!-- 7. Cara Kerja -->
<a href="{{ route('affiliate.guide') }}" onclick="closeDashboardCoachMark()" class="flex flex-col items-center gap-2 relative">
    <div class="w-12 h-12 rounded-2xl glass-panel flex items-center justify-center text-orange-400 text-lg shadow-inner transition-transform active:scale-95">
        <i class="fa-solid fa-book-open"></i>
    </div>
    <span class="text-[10px] text-slate-300 font-medium text-center leading-tight">Cara<br>Kerja</span>

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

<!-- 8. Template Chat -->
<a href="{{ route('affiliate.chat_templates.index') }}" class="flex flex-col items-center gap-2">
    <div class="w-12 h-12 rounded-2xl glass-panel flex items-center justify-center text-teal-400 text-lg shadow-inner transition-transform active:scale-95">
        <i class="fa-solid fa-message"></i>
    </div>
    <span class="text-[10px] text-slate-300 font-medium text-center leading-tight">Template<br>Chat</span>
</a>

<!-- 9. Data Mahasiswa -->
<a href="{{ route('affiliate.student_leads.index') }}" class="flex flex-col items-center gap-2">
    <div class="w-12 h-12 rounded-2xl glass-panel flex items-center justify-center text-cyan-400 text-lg shadow-inner transition-transform active:scale-95">
        <i class="fa-solid fa-users"></i>
    </div>
    <span class="text-[10px] text-slate-300 font-medium text-center leading-tight">Data<br>Mahasiswa</span>
</a>
</div>
