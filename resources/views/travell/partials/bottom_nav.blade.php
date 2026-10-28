<!-- ================= APP BOTTOM NAVIGATION BAR (SCALIFY PARTNER GLASS STYLE) ================= -->
<nav class="fixed bottom-0 left-0 w-full glass-panel border-t border-white/10 z-50 shadow-[0_-8px_32px_rgba(0,0,0,0.5)]">
    <div class="max-w-md mx-auto flex justify-around items-center px-4 py-2.5">
        <button type="button" onclick="switchView('viewHome')" id="navTabHome" class="nav-tab-link active flex flex-col items-center gap-1 text-blue-400 hover:text-blue-300 transition-colors cursor-pointer py-1">
            <i class="fas fa-house text-lg"></i>
            <span class="text-[10px] font-bold">Home</span>
        </button>
        <button type="button" onclick="switchView('viewHistory')" id="navTabTickets" class="nav-tab-link flex flex-col items-center gap-1 text-slate-400 hover:text-blue-300 transition-colors cursor-pointer py-1">
            <i class="fas fa-receipt text-lg"></i>
            <span class="text-[10px] font-bold">Tiket Saya</span>
        </button>
        <a href="https://wa.me/{{ $waNumber ?? '6281234567890' }}" target="_blank" class="nav-tab-link flex flex-col items-center gap-1 text-slate-400 hover:text-emerald-400 transition-colors cursor-pointer py-1">
            <i class="fab fa-whatsapp text-lg text-emerald-400"></i>
            <span class="text-[10px] font-bold">WhatsApp</span>
        </a>
        <button type="button" onclick="openCustomerAuthModal()" id="navTabAccount" class="nav-tab-link flex flex-col items-center gap-1 text-slate-400 hover:text-blue-300 transition-colors cursor-pointer py-1">
            <i class="fas fa-user text-lg"></i>
            <span class="text-[10px] font-bold">Akun</span>
        </button>
    </div>
</nav>
