<!-- ================= APP BOTTOM NAVIGATION BAR (TRAVELOKA STYLE) ================= -->
<nav class="bg-white border-t border-slate-200 px-6 py-2 flex items-center justify-between absolute bottom-0 inset-x-0 z-40 text-slate-400">
    <button type="button" onclick="switchView('viewHome')" class="nav-tab-btn flex flex-col items-center gap-0.5 text-sky-500 cursor-pointer" id="tabNavHome">
        <i class="fas fa-house text-sm"></i>
        <span class="text-[9px] font-bold">Beranda</span>
    </button>

    <button type="button" onclick="executeScheduleSearch()" class="nav-tab-btn flex flex-col items-center gap-0.5 hover:text-sky-500 cursor-pointer" id="tabNavSchedules">
        <i class="fas fa-car-side text-sm"></i>
        <span class="text-[9px] font-bold">Jadwal</span>
    </button>

    <button type="button" onclick="switchView('viewHistory')" class="nav-tab-btn flex flex-col items-center gap-0.5 hover:text-sky-500 cursor-pointer" id="tabNavHistory">
        <i class="fas fa-receipt text-sm"></i>
        <span class="text-[9px] font-bold">Pesanan</span>
    </button>

    <a href="https://wa.me/{{ $waNumber ?? '6281234567890' }}?text={{ urlencode('Halo CS ' . ($brandName ?? 'Rivian Travel') . ', saya ingin tanya jadwal travel shuttle Daihatsu Xenia.') }}" target="_blank" class="nav-tab-btn flex flex-col items-center gap-0.5 hover:text-emerald-600 cursor-pointer">
        <i class="fab fa-whatsapp text-sm text-emerald-600"></i>
        <span class="text-[9px] font-bold text-emerald-600">Bantuan</span>
    </a>
</nav>
