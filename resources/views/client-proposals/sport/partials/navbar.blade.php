<nav class="sticky top-0 z-50 bg-slate-950/90 backdrop-blur-md border-b border-slate-800/80 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16 sm:h-18">
            <!-- Brand Logo -->
            <a href="#" class="flex items-center gap-2.5 group">
                <div class="w-8 h-8 rounded-lg bg-emerald-500 text-slate-950 flex items-center justify-center font-extrabold text-sm shadow-sm group-hover:bg-emerald-400 transition">
                    <i class="fas fa-trophy text-xs"></i>
                </div>
                <div>
                    <span class="font-bold text-sm sm:text-base tracking-tight text-white block leading-tight">
                        {{ $client->brand_name ?? 'Apex Arena' }}
                    </span>
                    <span class="text-[10px] text-slate-400 font-medium block">
                        Sports & Community Hub
                    </span>
                </div>
            </a>

            <!-- Desktop Navigation Links -->
            <div class="hidden lg:flex items-center gap-6 text-xs font-medium text-slate-300">
                <a href="#cabor" class="hover:text-emerald-400 transition-colors py-1">Cabang Olahraga</a>
                <a href="#lapangan" class="hover:text-emerald-400 transition-colors py-1">Jadwal & Slot</a>
                <a href="#membership" class="hover:text-emerald-400 transition-colors py-1">Membership</a>
                <a href="#komunitas" class="hover:text-emerald-400 transition-colors py-1">Komunitas & Mabar</a>
                <a href="#fasilitas" class="hover:text-emerald-400 transition-colors py-1">Fasilitas</a>
            </div>

            <!-- Header Action Buttons -->
            <div class="hidden sm:flex items-center gap-2.5">
                <!-- Button Cek Transaksi / Tiket Saya -->
                <button type="button" onclick="openHistoryModal()" class="inline-flex items-center gap-1.5 px-3 py-2 rounded-lg bg-slate-900 hover:bg-slate-800 text-slate-200 border border-slate-800 text-xs font-semibold transition cursor-pointer">
                    <i class="fas fa-receipt text-[11px] text-emerald-400"></i>
                    <span>Tiket Saya</span>
                </button>

                @if(isset($client->slug))
                <a href="{{ route('demo.customer.sport', $client->slug) }}" class="inline-flex items-center gap-1.5 px-3 py-2 rounded-lg bg-slate-900 hover:bg-slate-800 text-emerald-400 border border-slate-800 text-xs font-semibold transition">
                    <i class="fas fa-mobile-screen-button text-[11px]"></i>
                    <span>Demo App</span>
                </a>
                @endif

                <a href="#lapangan" class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-lg bg-emerald-500 hover:bg-emerald-400 text-slate-950 text-xs font-bold transition active:scale-95 shadow-sm">
                    <i class="fas fa-calendar-check text-xs"></i>
                    <span>Booking Slot</span>
                </a>
            </div>

            <!-- Mobile Hamburger Button -->
            <div class="flex sm:hidden items-center gap-2">
                <button type="button" onclick="openHistoryModal()" class="px-2.5 py-1.5 rounded-lg bg-slate-900 border border-slate-800 text-slate-300 text-[11px] font-semibold flex items-center gap-1">
                    <i class="fas fa-receipt text-emerald-400"></i>
                    <span>Tiket</span>
                </button>
                @if(isset($client->slug))
                <a href="{{ route('demo.customer.sport', $client->slug) }}" class="px-2.5 py-1.5 rounded-lg bg-slate-900 border border-slate-800 text-emerald-400 text-[11px] font-semibold">
                    App
                </a>
                @endif
                <button type="button" onclick="toggleMobileNav()" class="w-8 h-8 rounded-lg bg-slate-900 border border-slate-800 text-slate-300 flex items-center justify-center text-xs focus:outline-none">
                    <i id="navIcon" class="fas fa-bars"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Drawer Menu -->
    <div id="mobileMenu" class="hidden lg:hidden border-t border-slate-800 bg-slate-950/95 backdrop-blur-xl px-4 pt-3 pb-5 space-y-2.5 text-xs">
        <a href="#cabor" onclick="toggleMobileNav()" class="block py-2 text-slate-300 hover:text-emerald-400 border-b border-slate-900">Cabang Olahraga</a>
        <a href="#lapangan" onclick="toggleMobileNav()" class="block py-2 text-slate-300 hover:text-emerald-400 border-b border-slate-900">Jadwal & Ketersediaan Lapangan</a>
        <a href="#membership" onclick="toggleMobileNav()" class="block py-2 text-slate-300 hover:text-emerald-400 border-b border-slate-900">Paket Membership</a>
        <a href="#komunitas" onclick="toggleMobileNav()" class="block py-2 text-slate-300 hover:text-emerald-400 border-b border-slate-900">Komunitas & Mabar</a>
        <a href="#fasilitas" onclick="toggleMobileNav()" class="block py-2 text-slate-300 hover:text-emerald-400 border-b border-slate-900">Fasilitas Venue</a>

        <div class="pt-2 space-y-2">
            <button type="button" onclick="toggleMobileNav(); openHistoryModal();" class="w-full py-2.5 text-center rounded-lg bg-slate-900 text-slate-200 border border-slate-800 font-semibold text-xs flex items-center justify-center gap-1.5">
                <i class="fas fa-receipt text-emerald-400"></i>
                <span>Lihat Riwayat Tiket Saya</span>
            </button>
            @if(isset($client->slug))
            <a href="{{ route('demo.customer.sport', $client->slug) }}" class="w-full py-2.5 text-center rounded-lg bg-slate-900 text-emerald-400 border border-slate-800 font-semibold text-xs flex items-center justify-center gap-1.5">
                <i class="fas fa-mobile-screen-button"></i>
                <span>Buka Demo Mobile App</span>
            </a>
            @endif
            <a href="https://wa.me/{{ $cleanWa }}?text={{ urlencode('Halo ' . $brandName . ', saya ingin booking lapangan.') }}" target="_blank" class="w-full py-2.5 text-center rounded-lg bg-emerald-500 text-slate-950 font-bold text-xs flex items-center justify-center gap-1.5 shadow-sm">
                <i class="fab fa-whatsapp"></i>
                <span>Booking via WhatsApp</span>
            </a>
        </div>
    </div>
</nav>
