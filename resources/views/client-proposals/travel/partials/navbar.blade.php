<!-- Top Compact Notification Bar -->
<div class="bg-slate-950 text-slate-300 text-xs py-2 px-4 border-b border-slate-800/80">
    <div class="max-w-7xl mx-auto flex flex-col sm:flex-row justify-between items-center gap-1.5 sm:gap-2">
        <div class="flex items-center gap-2.5 text-[11px] text-slate-300">
            <span class="inline-flex items-center gap-1 text-emerald-400 font-semibold">
                <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                Door to Door Antar Jemput
            </span>
            <span class="text-slate-600">•</span>
            <span class="hidden sm:inline">Gratis Makan & Snack di Rest Area</span>
            <span class="hidden md:inline text-slate-600">•</span>
            <span class="hidden md:inline text-amber-300 font-medium">Program Loyalitas Naik 10x Free 1 Tiket</span>
        </div>
        <div class="flex items-center gap-3 text-[11px]">
            @if(isset($client->slug))
            <a href="{{ route('demo.customer.travel', $client->slug) }}" class="inline-flex items-center gap-1.5 bg-gradient-to-r from-travel-600 to-sky-600 text-white px-3 py-0.5 rounded-full font-bold shadow-xs hover:brightness-110 transition text-[10px]">
                <i class="fas fa-mobile-screen-button text-[10px]"></i>
                <span>Demo Customer App</span>
            </a>
            <a href="{{ route('proposal.dynamic', $client->slug) }}" class="hidden sm:inline-flex items-center gap-1 bg-white/10 hover:bg-white/20 text-white px-2.5 py-0.5 rounded-md font-semibold transition text-[10px]">
                Proposal Proyek
            </a>
            @endif
            <a href="tel:{{ $cleanWa }}" class="text-slate-300 hover:text-white transition flex items-center gap-1.5 font-medium">
                <i class="fas fa-phone-alt text-sky-400 text-[10px]"></i>
                <span>Hotline: +{{ $cleanWa }}</span>
            </a>
        </div>
    </div>
</div>

<!-- Header / Elegant Main Navbar -->
<header class="sticky top-0 z-40 bg-white/95 backdrop-blur-md border-b border-slate-200/80 transition-all duration-300" id="mainHeader">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16 sm:h-20">

            <!-- Minimalist Executive Brand Logo -->
            <a href="#" class="flex items-center gap-3 group">
                <div class="w-10 h-10 rounded-xl bg-slate-900 text-white flex items-center justify-center shadow-sm group-hover:bg-travel-700 transition-colors duration-200">
                    <i class="fas fa-van-shuttle text-base"></i>
                </div>
                <div>
                    <span class="font-bold text-lg sm:text-xl text-slate-900 tracking-tight block leading-tight">
                        {{ $brandName }}
                    </span>
                    <span class="text-[10px] font-semibold tracking-wider text-slate-400 uppercase block">
                        Executive Minibus & Shuttle
                    </span>
                </div>
            </a>

            <!-- Clean Navigation Links -->
            <nav class="hidden lg:flex items-center gap-7 text-sm font-semibold text-slate-600">
                <a href="#jadwal" class="hover:text-travel-700 transition py-1">Jadwal & Kuota</a>
                <a href="#fasilitas" class="hover:text-travel-700 transition py-1">Fasilitas</a>
                <a href="#armada" class="hover:text-travel-700 transition py-1">Armada</a>
                <a href="#membership" class="hover:text-travel-700 transition py-1">Membership</a>
                <a href="#cara-pesan" class="hover:text-travel-700 transition py-1">Cara Pesan</a>
            </nav>

            <!-- Action Buttons -->
            <div class="hidden sm:flex items-center gap-2.5">
                @if(isset($client->slug))
                <a href="{{ route('demo.customer.travel', $client->slug) }}" class="px-3.5 py-2.5 rounded-xl border border-travel-600 text-travel-700 hover:bg-sky-50 text-xs font-bold transition flex items-center gap-1.5">
                    <i class="fas fa-mobile-screen-button text-xs"></i>
                    <span>Demo Mobile App</span>
                </a>
                @endif
                <a href="https://wa.me/{{ $cleanWa }}?text={{ urlencode('Halo ' . $brandName . ', saya ingin reservasi tiket travel Minibus / HiAce.') }}" target="_blank" class="px-4.5 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold shadow-sm transition-all flex items-center gap-2">
                    <i class="fab fa-whatsapp text-sm"></i>
                    <span>Booking via WhatsApp</span>
                </a>
            </div>

            <!-- Mobile Menu Toggle Button -->
            <button type="button" onclick="toggleMobileMenu()" class="lg:hidden p-2.5 rounded-xl text-slate-700 hover:bg-slate-100 transition focus:outline-none" aria-label="Menu Navigasi">
                <i class="fas fa-bars text-lg"></i>
            </button>
        </div>
    </div>

    <!-- Mobile Menu Dropdown -->
    <div id="mobileMenu" class="hidden lg:hidden border-t border-slate-100 bg-white px-5 pt-3 pb-6 space-y-2 shadow-xl">
        @if(isset($client->slug))
        <div class="pb-2 mb-2 border-b border-slate-100">
            <a href="{{ route('demo.customer.travel', $client->slug) }}" class="w-full py-3 text-center rounded-xl bg-gradient-to-r from-travel-700 to-sky-600 text-white font-bold text-xs flex items-center justify-center gap-2 shadow-sm">
                <i class="fas fa-mobile-screen-button text-sm"></i>
                <span>Buka Demo Customer App (Mobile)</span>
            </a>
        </div>
        @endif
        <a href="#jadwal" onclick="toggleMobileMenu()" class="block py-2.5 text-sm font-semibold text-slate-700 hover:text-travel-700 border-b border-slate-100">Jadwal & Kuota Kursi</a>
        <a href="#fasilitas" onclick="toggleMobileMenu()" class="block py-2.5 text-sm font-semibold text-slate-700 hover:text-travel-700 border-b border-slate-100">Fasilitas Penumpang</a>
        <a href="#armada" onclick="toggleMobileMenu()" class="block py-2.5 text-sm font-semibold text-slate-700 hover:text-travel-700 border-b border-slate-100">Armada HiAce & Elf</a>
        <a href="#membership" onclick="toggleMobileMenu()" class="block py-2.5 text-sm font-semibold text-slate-700 hover:text-travel-700 border-b border-slate-100">Membership & Reward</a>
        <a href="#cara-pesan" onclick="toggleMobileMenu()" class="block py-2.5 text-sm font-semibold text-slate-700 hover:text-travel-700 border-b border-slate-100">Cara Pesan</a>
        <div class="pt-2 flex flex-col gap-2.5">
            <a href="https://wa.me/{{ $cleanWa }}?text={{ urlencode('Halo ' . $brandName . ', saya ingin pesan tiket travel.') }}" target="_blank" class="w-full py-3.5 text-center rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs flex items-center justify-center gap-2 shadow-sm">
                <i class="fab fa-whatsapp text-sm"></i> Chat WhatsApp Sekarang
            </a>
        </div>
    </div>
</header>
