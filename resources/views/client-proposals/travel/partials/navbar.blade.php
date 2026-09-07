<!-- Top Notification / Status Bar -->
<div class="bg-slate-900 text-slate-300 text-xs py-2 px-4 border-b border-slate-800">
    <div class="max-w-7xl mx-auto flex flex-col sm:flex-row justify-between items-center gap-2">
        <div class="flex items-center gap-3">
            <span class="inline-flex items-center gap-1.5 text-emerald-400 font-semibold text-[11px]">
                <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                Layanan Antar Jemput Door to Door
            </span>
            <span class="hidden md:inline text-slate-500">•</span>
            <span class="hidden md:inline text-slate-300 text-[11px]">Gratis Snack & Makan Rest Area</span>
            <span class="hidden lg:inline text-slate-500">•</span>
            <span class="hidden lg:inline text-amber-300 font-semibold text-[11px]">Program 10x Naik Free 1 Tiket</span>
        </div>
        <div class="flex items-center gap-4 text-[11px]">
            <a href="tel:{{ $cleanWa }}" class="text-slate-300 hover:text-white transition flex items-center gap-1.5 font-medium">
                <i class="fas fa-phone-alt text-sky-400 text-[10px]"></i>
                <span>Hotline: +{{ $cleanWa }}</span>
            </a>
            <a href="{{ route('proposal.dynamic', $client->slug) }}" class="hidden sm:inline-flex items-center gap-1 bg-white/10 hover:bg-white/20 text-white px-2.5 py-0.5 rounded-md font-semibold transition text-[10px]">
                Proposal Proyek
            </a>
        </div>
    </div>
</div>

<!-- Header / Elegant Main Navbar -->
<header class="sticky top-0 z-40 bg-white/90 backdrop-blur-xl border-b border-slate-100 shadow-xs transition-all duration-300" id="mainHeader">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-18 sm:h-20">

            <!-- Minimalist Brand Logo -->
            <a href="#" class="flex items-center gap-3 group">
                <div class="w-10 h-10 rounded-xl bg-slate-900 text-white flex items-center justify-center shadow-sm group-hover:bg-travel-600 transition-colors duration-300">
                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="2" y="5" width="20" height="13" rx="3"></rect>
                        <path d="M7 15h.01M17 15h.01"></path>
                        <path d="M2 10h20"></path>
                        <path d="M7 5v5M17 5v5"></path>
                    </svg>
                </div>
                <div>
                    <span class="font-heading font-black text-xl text-slate-900 tracking-tight block leading-tight">
                        {{ $brandName }}
                    </span>
                    <span class="text-[10px] font-semibold tracking-wider text-slate-400 uppercase">
                        Executive Shuttle & Minibus
                    </span>
                </div>
            </a>

            <!-- Clean Typography Navigation Links (No Clutter Icons) -->
            <nav class="hidden lg:flex items-center gap-8 text-sm font-semibold text-slate-600">
                <a href="#jadwal" class="hover:text-travel-700 transition tracking-tight py-2 border-b-2 border-transparent hover:border-travel-600">
                    Jadwal & Kuota
                </a>
                <a href="#fasilitas" class="hover:text-travel-700 transition tracking-tight py-2 border-b-2 border-transparent hover:border-travel-600">
                    Fasilitas
                </a>
                <a href="#armada" class="hover:text-travel-700 transition tracking-tight py-2 border-b-2 border-transparent hover:border-travel-600">
                    Armada
                </a>
                <a href="#membership" class="hover:text-travel-700 transition tracking-tight py-2 border-b-2 border-transparent hover:border-travel-600">
                    Membership & Reward
                </a>
                <a href="#cara-pesan" class="hover:text-travel-700 transition tracking-tight py-2 border-b-2 border-transparent hover:border-travel-600">
                    Cara Pesan
                </a>
            </nav>

            <!-- Action Buttons -->
            <div class="hidden sm:flex items-center gap-3">
                <a href="#jadwal" class="px-4 py-2.5 rounded-xl text-xs font-bold text-slate-700 hover:text-travel-700 hover:bg-slate-50 transition">
                    Cek Kursi
                </a>
                <a href="https://wa.me/{{ $cleanWa }}?text={{ urlencode('Halo ' . $brandName . ', saya ingin reservasi tiket travel Minibus / HiAce.') }}" target="_blank" class="px-5 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold shadow-sm hover:shadow-md transition-all flex items-center gap-2">
                    <i class="fab fa-whatsapp text-sm"></i>
                    <span>Booking WhatsApp</span>
                </a>
            </div>

            <!-- Mobile Menu Button -->
            <button type="button" onclick="toggleMobileMenu()" class="lg:hidden p-2.5 rounded-xl text-slate-600 hover:bg-slate-100 transition focus:outline-none" aria-label="Menu">
                <i class="fas fa-bars text-lg"></i>
            </button>
        </div>
    </div>

    <!-- Mobile Menu Dropdown -->
    <div id="mobileMenu" class="hidden lg:hidden border-t border-slate-100 bg-white px-5 pt-3 pb-6 space-y-3">
        <a href="#jadwal" onclick="toggleMobileMenu()" class="block py-2.5 text-sm font-semibold text-slate-700 hover:text-travel-600 border-b border-slate-50">Jadwal & Kuota Kursi</a>
        <a href="#fasilitas" onclick="toggleMobileMenu()" class="block py-2.5 text-sm font-semibold text-slate-700 hover:text-travel-600 border-b border-slate-50">Fasilitas Penumpang</a>
        <a href="#armada" onclick="toggleMobileMenu()" class="block py-2.5 text-sm font-semibold text-slate-700 hover:text-travel-600 border-b border-slate-50">Armada Minibus</a>
        <a href="#membership" onclick="toggleMobileMenu()" class="block py-2.5 text-sm font-semibold text-slate-700 hover:text-travel-600 border-b border-slate-50">Membership & Reward</a>
        <a href="#cara-pesan" onclick="toggleMobileMenu()" class="block py-2.5 text-sm font-semibold text-slate-700 hover:text-travel-600 border-b border-slate-50">Cara Pesan</a>
        <div class="pt-2 flex flex-col gap-2">
            <a href="#jadwal" onclick="toggleMobileMenu()" class="w-full py-2.5 text-center rounded-xl bg-slate-50 text-slate-700 font-bold text-xs">Cek Kuota Kursi</a>
            <a href="https://wa.me/{{ $cleanWa }}?text={{ urlencode('Halo ' . $brandName . ', saya ingin pesan tiket travel.') }}" target="_blank" class="w-full py-3 text-center rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs flex items-center justify-center gap-2 shadow-sm">
                <i class="fab fa-whatsapp"></i> Chat WhatsApp
            </a>
        </div>
    </div>
</header>
