<!-- ================= APP BOTTOM NAVIGATION BAR (SCALIFY PARTNER GLASS STYLE) ================= -->
<nav class="fixed bottom-0 left-0 w-full glass-panel border-t border-white/10 z-50 shadow-[0_-8px_32px_rgba(0,0,0,0.5)]">
    <div class="max-w-md mx-auto flex justify-around items-center px-4 py-2.5">
        <button type="button" onclick="switchView('viewHome')" id="navTabHome" class="nav-tab-link active flex flex-col items-center gap-1 text-blue-400 hover:text-blue-300 transition-colors cursor-pointer py-1">
            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
            <span class="text-[10px] font-bold">Home</span>
        </button>
        <button type="button" onclick="switchView('viewHistory')" id="navTabTickets" class="nav-tab-link flex flex-col items-center gap-1 text-slate-400 hover:text-blue-300 transition-colors cursor-pointer py-1">
            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M4 2v20l2-1 2 1 2-1 2 1 2-1 2 1 2-1 2 1V2l-2 1-2-1-2 1-2-1-2 1-2-1-2 1-2-1Z"/><line x1="8" y1="8" x2="16" y2="8"/><line x1="8" y1="12" x2="16" y2="12"/></svg>
            <span class="text-[10px] font-bold">Tiket Saya</span>
        </button>
        <a href="https://wa.me/{{ $waNumber ?? '6281234567890' }}" target="_blank" class="nav-tab-link flex flex-col items-center gap-1 text-slate-400 hover:text-emerald-400 transition-colors cursor-pointer py-1">
            <svg class="w-5 h-5 text-emerald-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"/></svg>
            <span class="text-[10px] font-bold">WhatsApp</span>
        </a>
        <button type="button" onclick="openCustomerAuthModal()" id="navTabAccount" class="nav-tab-link flex flex-col items-center gap-1 text-slate-400 hover:text-blue-300 transition-colors cursor-pointer py-1">
            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
            <span class="text-[10px] font-bold">Akun</span>
        </button>
    </div>
</nav>
