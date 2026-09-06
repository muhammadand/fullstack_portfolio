{{-- Top Announcement Bar (Promo Banner) --}}
<div class="bg-gradient-to-r from-blue-700 via-indigo-600 to-blue-600 text-white text-[11px] sm:text-xs font-semibold py-1.5 px-4 text-center relative z-50 overflow-hidden shadow-sm">
    <a href="https://wa.me/6285221694067?text=Halo%20Scalify,%20saya%20ingin%20konsultasi%20pembuatan%20website" target="_blank" class="inline-flex items-center justify-center gap-1.5 hover:underline transition-all">
        <span class="bg-white/20 px-2 py-0.5 rounded-full text-[10px] uppercase tracking-wider font-bold">Promo Spesial</span>
        <span>Jasa Pembuatan Website & Landing Page Profesional No. 1 di Indonesia · Free Domain & Cloud Hosting!</span>
        <i class="fa-solid fa-arrow-right text-[10px] ml-1"></i>
    </a>
</div>

{{-- Main Navbar with 2-Tier Navigation --}}
<nav class="sticky top-0 left-0 right-0 z-40 bg-brand-dark/90 backdrop-blur-xl border-b border-white/10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Row 1: Logo + Search + Main Menu + Action Button --}}
        <div class="flex items-center justify-between h-16 sm:h-18 gap-4">

            {{-- Logo --}}
            <a href="{{ route('login') }}" class="flex items-center gap-2.5 cursor-pointer shrink-0">
                <div class="w-8 h-8 sm:w-9 sm:h-9 overflow-hidden rounded-lg shadow-glow-sm border border-white/15 bg-white/5">
                    <img src="{{ asset('scalify.png') }}" alt="Scalify Intelligence Logo" class="w-full h-full object-cover">
                </div>
                <span class="font-display font-bold text-lg sm:text-xl tracking-tight text-white">
                    Scalify<span class="text-brand-accent"> Intelligence</span>
                </span>
            </a>

            {{-- Search Bar (Desktop) --}}
            <div class="hidden lg:flex items-center flex-1 max-w-sm mx-4">
                <form action="{{ route('landing.blogs') }}" method="GET" class="w-full relative">
                    <div class="flex items-center bg-white/5 border border-white/15 rounded-full pl-3.5 pr-1 py-1 focus-within:border-brand-accent focus-within:ring-2 focus-within:ring-brand-accent/20 transition-all">
                        <i class="fa-solid fa-magnifying-glass text-white/40 text-xs mr-2"></i>
                        <input type="text" name="search" placeholder="Cari layanan, paket web, portofolio..." class="w-full bg-transparent text-xs text-white placeholder-white/40 focus:outline-none">
                        <button type="submit" class="bg-btn-gradient text-white text-xs font-semibold px-4 py-1.5 rounded-full shadow-glow-sm hover:opacity-90 transition shrink-0">
                            Cari
                        </button>
                    </div>
                </form>
            </div>

            {{-- Desktop Main Links --}}
            <div class="hidden md:flex items-center gap-6 lg:gap-7 text-xs sm:text-sm text-white/80 font-medium">
                <a href="{{ route('index.company.profile') }}" class="hover:text-brand-accent transition-colors py-2">Home</a>
                <a href="{{ route('landing.portfolio') }}" class="hover:text-brand-accent transition-colors py-2">Portofolio</a>
                <a href="{{ route('index.company.profile') }}#layanan" class="hover:text-brand-accent transition-colors py-2">Paket Harga</a>
                <a href="{{ route('index.company.profile') }}#produk-live" class="hover:text-brand-accent transition-colors py-2">Produk Live</a>
                <a href="{{ route('landing.blogs') }}" class="hover:text-brand-accent transition-colors py-2">Blog</a>
                <a href="{{ route('index.company.profile') }}#ownerprofile" class="hover:text-brand-accent transition-colors py-2">Tentang Kami</a>
            </div>

            {{-- Right CTA & Mobile Toggle --}}
            <div class="flex items-center gap-2 sm:gap-3">
                <a href="https://wa.me/6285221694067" target="_blank" class="hidden sm:inline-flex items-center gap-2 bg-btn-gradient text-white text-xs sm:text-sm font-semibold px-4 sm:px-5 py-2.5 rounded-full shadow-glow-sm hover:shadow-glow-blue transition-all">
                    <i class="fa-brands fa-whatsapp text-sm"></i>
                    <span>Konsultasi Web</span>
                </a>

                {{-- Hamburger Button (Mobile only) --}}
                <button id="nav-toggle" aria-label="Toggle menu" aria-expanded="false" class="md:hidden flex items-center justify-center w-9 h-9 rounded-lg bg-white/5 border border-white/10 text-white focus:outline-none">
                    <svg id="icon-open" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    <svg id="icon-close" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" class="w-5 h-5 hidden">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

        </div>

        {{-- Row 2: Secondary Quick Sub-Nav / Services Category Bar (Desktop) --}}
        <div class="hidden md:flex items-center justify-between border-t border-white/5 py-2.5 overflow-x-auto text-[11px] lg:text-xs text-white/60 font-medium">
            <div class="flex items-center gap-6 lg:gap-8">
                <a href="{{ route('index.company.profile') }}#layanan" class="hover:text-brand-accent transition-colors flex items-center gap-1.5 whitespace-nowrap">
                    <i class="fa-solid fa-laptop-code text-brand-accent/80"></i> Company Profile
                </a>
                <a href="{{ route('index.company.profile') }}#layanan" class="hover:text-brand-accent transition-colors flex items-center gap-1.5 whitespace-nowrap">
                    <i class="fa-solid fa-bullhorn text-brand-accent/80"></i> Landing Page Sales
                </a>
                <a href="{{ route('index.company.profile') }}#layanan" class="hover:text-brand-accent transition-colors flex items-center gap-1.5 whitespace-nowrap">
                    <i class="fa-solid fa-cart-shopping text-brand-accent/80"></i> Toko Online / E-Commerce
                </a>
                <a href="{{ route('index.company.profile') }}#produk-live" class="hover:text-brand-accent transition-colors flex items-center gap-1.5 whitespace-nowrap">
                    <i class="fa-solid fa-cubes text-brand-accent/80"></i> Web App & SaaS Kustom
                </a>
                <a href="{{ route('index.company.profile') }}#ownerprofile" class="hover:text-brand-accent transition-colors flex items-center gap-1.5 whitespace-nowrap">
                    <i class="fa-solid fa-robot text-brand-accent/80"></i> WhatsApp AI Bot
                </a>
                <a href="{{ route('landing.blogs') }}" class="hover:text-brand-accent transition-colors flex items-center gap-1.5 whitespace-nowrap">
                    <i class="fa-solid fa-magnifying-glass-chart text-brand-accent/80"></i> Optimasi SEO & Speed
                </a>
            </div>
            <div class="text-[11px] text-brand-accent font-semibold tracking-wider uppercase pl-4 flex items-center gap-1 shrink-0">
                <i class="fa-solid fa-star text-[10px] text-amber-400"></i> No. 1 Agency Indonesia
            </div>
        </div>

    </div>

    {{-- Mobile Menu Drawer --}}
    <div id="mobile-menu" class="md:hidden overflow-hidden max-h-0 transition-all duration-300 ease-in-out border-t border-white/0 bg-brand-dark/95 backdrop-blur-2xl">
        <div class="px-4 py-4 flex flex-col gap-1.5">
            {{-- Search Bar (Mobile) --}}
            <form action="{{ route('landing.blogs') }}" method="GET" class="mb-3">
                <div class="flex items-center bg-white/5 border border-white/15 rounded-full px-3 py-1.5">
                    <i class="fa-solid fa-magnifying-glass text-white/40 text-xs mr-2"></i>
                    <input type="text" name="search" placeholder="Cari layanan website..." class="w-full bg-transparent text-xs text-white placeholder-white/40 focus:outline-none">
                    <button type="submit" class="bg-btn-gradient text-white text-[11px] font-bold px-3.5 py-1 rounded-full shrink-0">Cari</button>
                </div>
            </form>

            <div class="text-[10px] uppercase text-white/40 font-bold px-3 pt-1 tracking-wider">Navigasi Utama</div>
            <a href="{{ route('index.company.profile') }}" class="mobile-nav-link text-sm text-white/80 font-medium px-3 py-2 rounded-lg hover:bg-white/5 hover:text-brand-accent transition-all">Home</a>
            <a href="{{ route('landing.portfolio') }}" class="mobile-nav-link text-sm text-white/80 font-medium px-3 py-2 rounded-lg hover:bg-white/5 hover:text-brand-accent transition-all">Portofolio Klien</a>
            <a href="{{ route('index.company.profile') }}#layanan" class="mobile-nav-link text-sm text-white/80 font-medium px-3 py-2 rounded-lg hover:bg-white/5 hover:text-brand-accent transition-all">Paket Harga Website</a>
            <a href="{{ route('index.company.profile') }}#produk-live" class="mobile-nav-link text-sm text-white/80 font-medium px-3 py-2 rounded-lg hover:bg-white/5 hover:text-brand-accent transition-all">Produk Live & Berjalan</a>
            <a href="{{ route('landing.blogs') }}" class="mobile-nav-link text-sm text-white/80 font-medium px-3 py-2 rounded-lg hover:bg-white/5 hover:text-brand-accent transition-all">Blog & Insight</a>
            <a href="{{ route('index.company.profile') }}#ownerprofile" class="mobile-nav-link text-sm text-white/80 font-medium px-3 py-2 rounded-lg hover:bg-white/5 hover:text-brand-accent transition-all">Tentang Kami & Founder</a>

            <div class="border-t border-white/10 mt-2 pt-3">
                <a href="https://wa.me/6285221694067" target="_blank" class="block text-center bg-btn-gradient text-white text-sm font-semibold px-5 py-2.5 rounded-full shadow-glow-sm hover:shadow-glow-blue transition-all">
                    <i class="fa-brands fa-whatsapp mr-1.5"></i> Hubungi Kami via WhatsApp
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
            menu.style.borderTopColor = 'rgba(255,255,255,0.05)';
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

</script>
