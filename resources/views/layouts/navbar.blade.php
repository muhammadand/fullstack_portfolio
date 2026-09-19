{{-- Top Announcement Bar (Promo Banner) --}}
<div class="bg-gradient-to-r from-blue-700 via-indigo-600 to-blue-600 text-white text-[11px] sm:text-xs font-semibold py-1.5 px-4 text-center relative z-50 overflow-hidden shadow-sm">
    <a href="https://wa.me/6285221694067?text=Halo%20Scalify,%20saya%20ingin%20konsultasi%20pembuatan%20website" target="_blank" class="inline-flex items-center justify-center gap-1.5 hover:underline transition-all group">
        <span class="bg-white/20 px-2 py-0.5 rounded-full text-[10px] uppercase tracking-wider font-bold group-hover:bg-white/30 transition-colors">Promo Spesial</span>
        <span class="truncate max-w-[280px] sm:max-w-none">Jasa Pembuatan Website & Landing Page Profesional No. 1 di Indonesia · Free Domain & Cloud Hosting!</span>
        <i class="fa-solid fa-arrow-right text-[10px] ml-1 transition-transform group-hover:translate-x-0.5"></i>
    </a>
</div>

{{-- Main Navbar --}}
<nav class="sticky top-0 left-0 right-0 z-40 bg-[#0B1120]/85 backdrop-blur-xl border-b border-white/[0.08] transition-all duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-18 sm:h-20 gap-4">

            {{-- Brand Logo --}}
            <a href="{{ route('index.company.profile') }}" class="flex items-center gap-3 cursor-pointer shrink-0 group">
                <div class="w-9 h-9 sm:w-10 sm:h-10 overflow-hidden rounded-xl shadow-lg shadow-blue-500/10 border border-white/15 bg-white/5 p-0.5 group-hover:border-brand-accent/50 transition-colors">
                    <img src="{{ asset('scalify.png') }}" alt="Scalify Intelligence Logo" class="w-full h-full object-cover rounded-[10px]">
                </div>
                <div class="flex flex-col">
                    <span class="font-display font-bold text-lg sm:text-xl tracking-tight text-white group-hover:text-white transition-colors">
                        Scalify<span class="text-brand-accent"> Intelligence</span>
                    </span>
                    <span class="text-[10px] text-white/40 tracking-wider font-medium uppercase -mt-0.5 hidden sm:block">Digital & Tech Agency</span>
                </div>
            </a>

            {{-- Desktop Navigation Links with Dropdowns --}}
            <div class="hidden lg:flex items-center gap-1 xl:gap-2">

                {{-- Home --}}
                <a href="{{ route('index.company.profile') }}" class="px-3.5 py-2 rounded-xl text-xs xl:text-sm font-medium text-white/80 hover:text-white hover:bg-white/5 transition-all">
                    Home
                </a>

                {{-- Dropdown: Layanan & Solusi --}}
                <div class="relative group py-2">
                    <button class="px-3.5 py-2 rounded-xl text-xs xl:text-sm font-medium text-white/80 hover:text-white hover:bg-white/5 transition-all flex items-center gap-1.5 focus:outline-none cursor-pointer">
                        <span>Layanan & Solusi</span>
                        <i class="fa-solid fa-chevron-down text-[10px] text-white/40 transition-transform duration-300 group-hover:rotate-180 group-hover:text-brand-accent"></i>
                    </button>

                    {{-- Mega Dropdown Menu --}}
                    <div class="absolute top-full left-1/2 -translate-x-1/2 w-[480px] pt-3 hidden group-hover:block transition-all duration-200 z-50">
                        <div class="bg-[#0B1120]/95 backdrop-blur-2xl border border-white/10 rounded-2xl p-3 shadow-2xl shadow-black/80">

                            <div class="text-[10px] uppercase font-bold tracking-wider text-white/40 px-3 py-1 mb-1">
                                Solusi Pengembangan Web
                            </div>

                            <div class="grid grid-cols-2 gap-1.5">
                                {{-- Company Profile --}}
                                <a href="{{ route('index.company.profile') }}#layanan" class="flex items-start gap-3 p-2.5 rounded-xl hover:bg-white/5 transition-all group/item">
                                    <div class="w-8 h-8 rounded-lg bg-blue-500/15 text-blue-400 flex items-center justify-center shrink-0 mt-0.5 border border-blue-500/20 group-hover/item:scale-105 transition-transform">
                                        <i class="fa-solid fa-laptop-code text-xs"></i>
                                    </div>
                                    <div>
                                        <span class="text-xs font-semibold text-white group-hover/item:text-brand-accent block transition-colors">Company Profile</span>
                                        <p class="text-[11px] text-white/50 leading-snug mt-0.5">Website elegan untuk citra bisnis & korporasi</p>
                                    </div>
                                </a>

                                {{-- Landing Page Sales --}}
                                <a href="{{ route('index.company.profile') }}#layanan" class="flex items-start gap-3 p-2.5 rounded-xl hover:bg-white/5 transition-all group/item">
                                    <div class="w-8 h-8 rounded-lg bg-emerald-500/15 text-emerald-400 flex items-center justify-center shrink-0 mt-0.5 border border-emerald-500/20 group-hover/item:scale-105 transition-transform">
                                        <i class="fa-solid fa-bullhorn text-xs"></i>
                                    </div>
                                    <div>
                                        <span class="text-xs font-semibold text-white group-hover/item:text-brand-accent block transition-colors">Landing Page Sales</span>
                                        <p class="text-[11px] text-white/50 leading-snug mt-0.5">Halaman promosi konversi tinggi untuk iklan</p>
                                    </div>
                                </a>

                                {{-- E-Commerce --}}
                                <a href="{{ route('index.company.profile') }}#layanan" class="flex items-start gap-3 p-2.5 rounded-xl hover:bg-white/5 transition-all group/item">
                                    <div class="w-8 h-8 rounded-lg bg-indigo-500/15 text-indigo-400 flex items-center justify-center shrink-0 mt-0.5 border border-indigo-500/20 group-hover/item:scale-105 transition-transform">
                                        <i class="fa-solid fa-cart-shopping text-xs"></i>
                                    </div>
                                    <div>
                                        <span class="text-xs font-semibold text-white group-hover/item:text-brand-accent block transition-colors">Toko Online</span>
                                        <p class="text-[11px] text-white/50 leading-snug mt-0.5">Katalog produk, keranjang & payment gateway</p>
                                    </div>
                                </a>

                                {{-- Web App & SaaS --}}
                                <a href="{{ route('index.company.profile') }}#produk-live" class="flex items-start gap-3 p-2.5 rounded-xl hover:bg-white/5 transition-all group/item">
                                    <div class="w-8 h-8 rounded-lg bg-cyan-500/15 text-cyan-400 flex items-center justify-center shrink-0 mt-0.5 border border-cyan-500/20 group-hover/item:scale-105 transition-transform">
                                        <i class="fa-solid fa-cubes text-xs"></i>
                                    </div>
                                    <div>
                                        <span class="text-xs font-semibold text-white group-hover/item:text-brand-accent block transition-colors">Web App & SaaS</span>
                                        <p class="text-[11px] text-white/50 leading-snug mt-0.5">Sistem custom, portal dashboard & automasi</p>
                                    </div>
                                </a>
                            </div>

                            {{-- Footer Dropdown --}}
                            <div class="mt-2 pt-2 border-t border-white/5 flex items-center justify-between px-2.5 text-[11px]">
                                <a href="{{ route('index.company.profile') }}#layanan" class="text-brand-accent hover:underline flex items-center gap-1 font-medium">
                                    <i class="fa-solid fa-tag text-[10px]"></i> Lihat Semua Paket Harga
                                </a>
                                <span class="text-white/40">Mulai Rp 700rb-an</span>
                            </div>

                        </div>
                    </div>
                </div>

                {{-- Portofolio --}}
                <a href="{{ route('landing.portfolio') }}" class="px-3.5 py-2 rounded-xl text-xs xl:text-sm font-medium text-white/80 hover:text-white hover:bg-white/5 transition-all">
                    Portofolio
                </a>

                {{-- Produk Live --}}
                <a href="{{ route('index.company.profile') }}#produk-live" class="px-3.5 py-2 rounded-xl text-xs xl:text-sm font-medium text-white/80 hover:text-white hover:bg-white/5 transition-all">
                    Produk Live
                </a>

                {{-- Dropdown: Program & Karir --}}
                <div class="relative group py-2">
                    <button class="px-3.5 py-2 rounded-xl text-xs xl:text-sm font-medium text-white/80 hover:text-white hover:bg-white/5 transition-all flex items-center gap-1.5 focus:outline-none cursor-pointer">
                        <span>Program & Karir</span>
                        <i class="fa-solid fa-chevron-down text-[10px] text-white/40 transition-transform duration-300 group-hover:rotate-180 group-hover:text-brand-accent"></i>
                    </button>

                    <div class="absolute top-full right-0 w-72 pt-3 hidden group-hover:block transition-all duration-200 z-50">
                        <div class="bg-[#0B1120]/95 backdrop-blur-2xl border border-white/10 rounded-2xl p-2.5 shadow-2xl shadow-black/80 space-y-1">

                            {{-- Sobat Scalify --}}
                            <a href="{{ route('sobat-scalify') }}" class="flex items-start gap-3 p-2.5 rounded-xl hover:bg-white/5 transition-all group/item">
                                <div class="w-8 h-8 rounded-lg bg-amber-500/15 text-amber-400 flex items-center justify-center shrink-0 mt-0.5 border border-amber-500/20 group-hover/item:scale-105 transition-transform">
                                    <i class="fa-solid fa-handshake text-xs"></i>
                                </div>
                                <div>
                                    <div class="flex items-center gap-1.5">
                                        <span class="text-xs font-semibold text-white group-hover/item:text-brand-accent">Sobat Scalify</span>
                                        <span class="px-1.5 py-0.2 bg-amber-500/20 text-amber-300 text-[9px] font-bold rounded-full border border-amber-500/30">Partner</span>
                                    </div>
                                    <p class="text-[11px] text-white/50 leading-tight mt-0.5">Program kemitraan & raih penghasilan komisi</p>
                                </div>
                            </a>

                            {{-- Karir --}}
                            <a href="{{ route('landing.careers') }}" class="flex items-start gap-3 p-2.5 rounded-xl hover:bg-white/5 transition-all group/item">
                                <div class="w-8 h-8 rounded-lg bg-emerald-500/15 text-emerald-400 flex items-center justify-center shrink-0 mt-0.5 border border-emerald-500/20 group-hover/item:scale-105 transition-transform">
                                    <i class="fa-solid fa-briefcase text-xs"></i>
                                </div>
                                <div>
                                    <div class="flex items-center gap-1.5">
                                        <span class="text-xs font-semibold text-white group-hover/item:text-brand-accent">Karir & Lowongan</span>
                                        <span class="px-1.5 py-0.2 bg-emerald-500/20 text-emerald-300 text-[9px] font-bold rounded-full border border-emerald-500/30">Hiring</span>
                                    </div>
                                    <p class="text-[11px] text-white/50 leading-tight mt-0.5">Bergabung dengan tim tech & digital agency</p>
                                </div>
                            </a>

                            {{-- Template CV & AI Builder --}}
                            <a href="{{ route('layanan.cv') }}" class="flex items-start gap-3 p-2.5 rounded-xl hover:bg-white/5 transition-all group/item">
                                <div class="w-8 h-8 rounded-lg bg-cyan-500/15 text-cyan-400 flex items-center justify-center shrink-0 mt-0.5 border border-cyan-500/20 group-hover/item:scale-105 transition-transform">
                                    <i class="fa-solid fa-file-invoice text-xs"></i>
                                </div>
                                <div>
                                    <div class="flex items-center gap-1.5">
                                        <span class="text-xs font-semibold text-white group-hover/item:text-brand-accent">Template CV & AI</span>
                                        <span class="px-1.5 py-0.2 bg-cyan-500/20 text-cyan-300 text-[9px] font-bold rounded-full border border-cyan-500/30">AI Tools</span>
                                    </div>
                                    <p class="text-[11px] text-white/50 leading-tight mt-0.5">Buat CV profesional standar HRD & ATS</p>
                                </div>
                            </a>

                            {{-- Tentang Kami --}}
                            <a href="{{ route('index.company.profile') }}#ownerprofile" class="flex items-start gap-3 p-2.5 rounded-xl hover:bg-white/5 transition-all group/item">
                                <div class="w-8 h-8 rounded-lg bg-blue-500/15 text-blue-400 flex items-center justify-center shrink-0 mt-0.5 border border-blue-500/20 group-hover/item:scale-105 transition-transform">
                                    <i class="fa-solid fa-user-tie text-xs"></i>
                                </div>
                                <div>
                                    <span class="text-xs font-semibold text-white group-hover/item:text-brand-accent">Tentang Kami & Founder</span>
                                    <p class="text-[11px] text-white/50 leading-tight mt-0.5">Profil agensi dan visi Scalify Intelligence</p>
                                </div>
                            </a>

                        </div>
                    </div>
                </div>

                {{-- Blog --}}
                <a href="{{ route('landing.blogs') }}" class="px-3.5 py-2 rounded-xl text-xs xl:text-sm font-medium text-white/80 hover:text-white hover:bg-white/5 transition-all">
                    Blog
                </a>

            </div>

            {{-- Right Actions (Search Icon + WA CTA + Mobile Toggle) --}}
            <div class="flex items-center gap-3">

                {{-- Compact Search Button / Modal Trigger (Desktop) --}}
                <div class="relative group/search hidden md:block">
                    <button type="button" id="search-desktop-trigger" onclick="toggleDesktopSearch()" class="w-9 h-9 rounded-full bg-white/5 hover:bg-white/10 border border-white/10 text-white/70 hover:text-white flex items-center justify-center transition-all cursor-pointer" title="Cari di Blog & Layanan">
                        <i class="fa-solid fa-magnifying-glass text-xs"></i>
                    </button>

                    {{-- Floating Search Popover --}}
                    <div id="desktop-search-popover" class="absolute top-full right-0 mt-2 w-80 hidden z-50">
                        <div class="bg-[#0B1120]/95 backdrop-blur-xl border border-white/15 rounded-2xl p-2 shadow-2xl shadow-black/90">
                            <form action="{{ route('landing.blogs') }}" method="GET" class="relative flex items-center">
                                <i class="fa-solid fa-magnifying-glass text-white/40 text-xs ml-3 mr-2"></i>
                                <input type="text" name="search" placeholder="Cari artikel, topik, layanan..." class="w-full bg-transparent text-xs text-white placeholder-white/40 py-1.5 pr-2 focus:outline-none" autofocus>
                                <button type="submit" class="bg-brand-accent hover:opacity-90 text-white text-[10px] font-bold px-3 py-1.5 rounded-xl shrink-0 transition-opacity">
                                    Cari
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                {{-- WhatsApp Consultation Button --}}
                <a href="https://wa.me/6285221694067?text=Halo%20Scalify,%20saya%20ingin%20konsultasi%20pembuatan%20website" target="_blank" class="hidden sm:inline-flex items-center gap-2 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-500 hover:to-indigo-500 text-white text-xs sm:text-sm font-semibold px-5 py-2.5 rounded-full shadow-lg shadow-blue-500/20 hover:shadow-blue-500/35 border border-white/10 active:scale-95 transition-all">
                    <i class="fa-brands fa-whatsapp text-sm text-emerald-300"></i>
                    <span>Konsultasi Web</span>
                </a>

                {{-- Mobile Hamburger Toggle --}}
                <button id="nav-toggle" aria-label="Toggle menu" aria-expanded="false" class="lg:hidden flex items-center justify-center w-10 h-10 rounded-xl bg-white/5 hover:bg-white/10 border border-white/10 text-white focus:outline-none transition-colors">
                    <svg id="icon-open" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    <svg id="icon-close" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" class="w-5 h-5 hidden">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>

            </div>

        </div>
    </div>

    {{-- Mobile Menu Drawer --}}
    <div id="mobile-menu" class="lg:hidden overflow-hidden max-h-0 transition-all duration-300 ease-in-out border-t border-transparent bg-[#0B1120]/98 backdrop-blur-2xl">
        <div class="px-4 py-5 flex flex-col gap-2 max-h-[80vh] overflow-y-auto">

            {{-- Search Bar (Mobile) --}}
            <form action="{{ route('landing.blogs') }}" method="GET" class="mb-2">
                <div class="flex items-center bg-white/5 border border-white/15 rounded-xl px-3.5 py-2 focus-within:border-brand-accent">
                    <i class="fa-solid fa-magnifying-glass text-white/40 text-xs mr-2"></i>
                    <input type="text" name="search" placeholder="Cari layanan, artikel..." class="w-full bg-transparent text-xs text-white placeholder-white/40 focus:outline-none">
                    <button type="submit" class="bg-brand-accent text-white text-[11px] font-bold px-3 py-1 rounded-lg shrink-0">Cari</button>
                </div>
            </form>

            <a href="{{ route('index.company.profile') }}" class="mobile-nav-link text-sm text-white/90 font-medium px-3.5 py-2.5 rounded-xl hover:bg-white/5 transition-all">Home</a>

            {{-- Mobile Collapsible: Layanan --}}
            <div class="rounded-xl bg-white/[0.02] border border-white/5 p-2">
                <div class="text-[10px] uppercase font-bold text-white/40 px-2 py-1 tracking-wider">Layanan & Solusi</div>
                <div class="flex flex-col gap-1 mt-1">
                    <a href="{{ route('index.company.profile') }}#layanan" class="mobile-nav-link flex items-center gap-2.5 text-xs text-white/80 font-medium px-2.5 py-2 rounded-lg hover:bg-white/5">
                        <i class="fa-solid fa-laptop-code text-blue-400 w-4 text-center"></i> Company Profile
                    </a>
                    <a href="{{ route('index.company.profile') }}#layanan" class="mobile-nav-link flex items-center gap-2.5 text-xs text-white/80 font-medium px-2.5 py-2 rounded-lg hover:bg-white/5">
                        <i class="fa-solid fa-bullhorn text-emerald-400 w-4 text-center"></i> Landing Page Sales
                    </a>
                    <a href="{{ route('index.company.profile') }}#layanan" class="mobile-nav-link flex items-center gap-2.5 text-xs text-white/80 font-medium px-2.5 py-2 rounded-lg hover:bg-white/5">
                        <i class="fa-solid fa-cart-shopping text-indigo-400 w-4 text-center"></i> Toko Online / E-Commerce
                    </a>
                    <a href="{{ route('index.company.profile') }}#produk-live" class="mobile-nav-link flex items-center gap-2.5 text-xs text-white/80 font-medium px-2.5 py-2 rounded-lg hover:bg-white/5">
                        <i class="fa-solid fa-cubes text-cyan-400 w-4 text-center"></i> Web App & SaaS
                    </a>
                    <a href="{{ route('index.company.profile') }}#layanan" class="mobile-nav-link flex items-center justify-between text-xs text-brand-accent font-semibold px-2.5 py-2 rounded-lg hover:bg-white/5">
                        <span class="flex items-center gap-2.5"><i class="fa-solid fa-tag text-brand-accent w-4 text-center"></i> Semua Paket Harga</span>
                        <span class="text-[10px] text-white/50">Mulai 700rb</span>
                    </a>
                </div>
            </div>

            <a href="{{ route('landing.portfolio') }}" class="mobile-nav-link text-sm text-white/90 font-medium px-3.5 py-2.5 rounded-xl hover:bg-white/5 transition-all">Portofolio Klien</a>
            <a href="{{ route('index.company.profile') }}#produk-live" class="mobile-nav-link text-sm text-white/90 font-medium px-3.5 py-2.5 rounded-xl hover:bg-white/5 transition-all">Produk Live</a>

            {{-- Mobile Collapsible: Program & Karir --}}
            <div class="rounded-xl bg-white/[0.02] border border-white/5 p-2">
                <div class="text-[10px] uppercase font-bold text-white/40 px-2 py-1 tracking-wider">Program & Info</div>
                <div class="flex flex-col gap-1 mt-1">
                    <a href="{{ route('sobat-scalify') }}" class="mobile-nav-link flex items-center justify-between text-xs text-white/80 font-medium px-2.5 py-2 rounded-lg hover:bg-white/5">
                        <span class="flex items-center gap-2.5"><i class="fa-solid fa-handshake text-amber-400 w-4 text-center"></i> Sobat Scalify (Partner)</span>
                        <span class="px-2 py-0.2 bg-amber-500/20 text-amber-300 text-[9px] font-bold rounded-full">Cuan</span>
                    </a>
                    <a href="{{ route('landing.careers') }}" class="mobile-nav-link flex items-center justify-between text-xs text-white/80 font-medium px-2.5 py-2 rounded-lg hover:bg-white/5">
                        <span class="flex items-center gap-2.5"><i class="fa-solid fa-briefcase text-emerald-400 w-4 text-center"></i> Karir & Lowongan</span>
                        <span class="px-2 py-0.2 bg-emerald-500/20 text-emerald-300 text-[9px] font-bold rounded-full">Hiring</span>
                    </a>
                    <a href="{{ route('layanan.cv') }}" class="mobile-nav-link flex items-center justify-between text-xs text-white/80 font-medium px-2.5 py-2 rounded-lg hover:bg-white/5">
                        <span class="flex items-center gap-2.5"><i class="fa-solid fa-file-invoice text-cyan-400 w-4 text-center"></i> Template CV & AI Builder</span>
                        <span class="px-2 py-0.2 bg-cyan-500/20 text-cyan-300 text-[9px] font-bold rounded-full">Baru</span>
                    </a>
                    <a href="{{ route('index.company.profile') }}#ownerprofile" class="mobile-nav-link flex items-center gap-2.5 text-xs text-white/80 font-medium px-2.5 py-2 rounded-lg hover:bg-white/5">
                        <i class="fa-solid fa-user-tie text-blue-400 w-4 text-center"></i> Tentang Kami & Founder
                    </a>
                </div>
            </div>

            <a href="{{ route('landing.blogs') }}" class="mobile-nav-link text-sm text-white/90 font-medium px-3.5 py-2.5 rounded-xl hover:bg-white/5 transition-all">Blog & Insight</a>

            {{-- WhatsApp Consultation Mobile Button --}}
            <div class="mt-2 pt-2">
                <a href="https://wa.me/6285221694067?text=Halo%20Scalify,%20saya%20ingin%20konsultasi%20pembuatan%20website" target="_blank" class="flex items-center justify-center gap-2 bg-gradient-to-r from-blue-600 to-indigo-600 text-white text-xs font-semibold px-5 py-3 rounded-xl shadow-lg shadow-blue-500/20 active:scale-95 transition-all">
                    <i class="fa-brands fa-whatsapp text-base text-emerald-300"></i>
                    <span>Konsultasi via WhatsApp</span>
                </a>
            </div>

        </div>
    </div>
</nav>

<script>
    (function() {
        const toggle = document.getElementById('nav-toggle');
        const menu = document.getElementById('mobile-menu');
        const iconOpen = document.getElementById('icon-open');
        const iconClose = document.getElementById('icon-close');
        let open = false;

        if (!toggle || !menu) return;

        function openMenu() {
            open = true;
            toggle.setAttribute('aria-expanded', 'true');
            menu.style.maxHeight = menu.scrollHeight + 'px';
            menu.style.borderTopColor = 'rgba(255,255,255,0.08)';
            if (iconOpen) iconOpen.style.display = 'none';
            if (iconClose) iconClose.style.display = 'block';
        }

        function closeMenu() {
            open = false;
            toggle.setAttribute('aria-expanded', 'false');
            menu.style.maxHeight = '0';
            menu.style.borderTopColor = 'transparent';
            if (iconOpen) iconOpen.style.display = 'block';
            if (iconClose) iconClose.style.display = 'none';
        }

        toggle.addEventListener('click', function() {
            open ? closeMenu() : openMenu();
        });

        document.querySelectorAll('.mobile-nav-link').forEach(function(link) {
            link.addEventListener('click', closeMenu);
        });

        document.addEventListener('click', function(e) {
            if (open && !menu.contains(e.target) && !toggle.contains(e.target)) {
                closeMenu();
            }
        });
    })();

    function toggleDesktopSearch() {
        const popover = document.getElementById('desktop-search-popover');
        if (!popover) return;
        popover.classList.toggle('hidden');
        if (!popover.classList.contains('hidden')) {
            const input = popover.querySelector('input');
            if (input) input.focus();
        }
    }

    // Close search popover when clicking outside
    document.addEventListener('click', function(e) {
        const popover = document.getElementById('desktop-search-popover');
        const trigger = document.getElementById('search-desktop-trigger');
        if (popover && !popover.classList.contains('hidden')) {
            if (!popover.contains(e.target) && trigger && !trigger.contains(e.target)) {
                popover.classList.add('hidden');
            }
        }
    });

</script>
