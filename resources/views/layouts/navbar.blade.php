    <nav class="fixed top-0 left-0 right-0 z-50 bg-brand-dark/80 backdrop-blur-xl border-b border-white/5">
        <div class="max-w-6xl mx-auto px-4 flex items-center justify-between h-14 sm:h-16">

            {{-- Logo --}}
            <div class="flex items-center gap-1.5 sm:gap-2 cursor-pointer" onclick="window.scrollTo(0,0)">
                <div
                    class="w-6 h-6 sm:w-7 sm:h-7 rounded-md sm:rounded-lg bg-btn-gradient flex items-center justify-center shadow-glow-sm">
                    <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 text-white" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                </div>
                <span class="font-display font-bold text-base sm:text-lg tracking-tight">Scalify<span
                        class="text-brand-accent"> Intelligence</span></span>
            </div>

            {{-- Desktop Nav --}}
            <div class="hidden md:flex items-center gap-8 text-sm text-white/70 font-medium">
                <a href="{{ route('index.company.profile') }}" class="hover:text-brand-accent transition-colors">Tentang
                    Kami</a>
                <a href="{{ route('index.company.profile') }}#portofolio"
                    class="hover:text-brand-accent transition-colors">Portofolio</a>
                <a href="{{ route('index.company.profile') }}#layanan"
                    class="hidden hover:text-brand-accent transition-colors">Paket Layanan</a>
                <a href="{{ route('landing.blogs') }}" class="hover:text-brand-accent transition-colors">Blog</a>
            </div>

            {{-- Right side: CTA + Hamburger --}}
            <div class="flex items-center gap-2 sm:gap-3">
                <a href="https://wa.me/6285221694067" target="_blank"
                    class="bg-btn-gradient text-white text-xs sm:text-sm font-semibold px-4 sm:px-5 py-2 sm:py-2.5 rounded-full shadow-glow-sm hover:shadow-glow-blue transition-all">
                    Hubungi Kami
                </a>

                {{-- Hamburger Button (mobile only) --}}
                <button id="nav-toggle" aria-label="Toggle menu" aria-expanded="false"
                    class="md:hidden flex items-center justify-center w-8 h-8 rounded-md focus:outline-none text-white">
                    {{-- Hamburger icon --}}
                    <svg id="icon-open" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2" style="width:1.25rem;height:1.25rem;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    {{-- X / Close icon (hidden by default) --}}
                    <svg id="icon-close" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2" style="width:1.25rem;height:1.25rem;display:none;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>

        {{-- Mobile Menu Drawer --}}
        <div id="mobile-menu"
            class="md:hidden overflow-hidden max-h-0 transition-all duration-300 ease-in-out border-t border-white/0">
            <div class="px-4 py-4 flex flex-col gap-1 bg-brand-dark/95 backdrop-blur-xl">
                <a href="{{ route('index.company.profile') }}"
                    class="mobile-nav-link text-sm text-white/70 font-medium px-3 py-3 rounded-lg hover:bg-white/5 hover:text-brand-accent transition-all">
                    Tentang Kami
                </a>
                <a href="{{ route('index.company.profile') }}#portofolio"
                    class="mobile-nav-link text-sm text-white/70 font-medium px-3 py-3 rounded-lg hover:bg-white/5 hover:text-brand-accent transition-all">
                    Portofolio
                </a>
                <a href="{{ route('index.company.profile') }}#layanan"
                    class="mobile-nav-link text-sm text-white/70 font-medium px-3 py-3 rounded-lg hover:bg-white/5 hover:text-brand-accent transition-all">
                    Paket Layanan
                </a>
                <a href="{{ route('landing.blogs') }}"
                    class="mobile-nav-link text-sm text-white/70 font-medium px-3 py-3 rounded-lg hover:bg-white/5 hover:text-brand-accent transition-all">
                    Blog
                </a>
                <div class="border-t border-white/10 mt-2 pt-3">
                    <a href="https://wa.me/6285221694067" target="_blank"
                        class="block text-center bg-btn-gradient text-white text-sm font-semibold px-5 py-2.5 rounded-full shadow-glow-sm hover:shadow-glow-blue transition-all">
                        Hubungi Kami
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

            function openMenu() {
                open = true;
                toggle.setAttribute('aria-expanded', 'true');
                menu.style.maxHeight = menu.scrollHeight + 'px';
                menu.style.borderTopColor = 'rgba(255,255,255,0.05)';
                iconOpen.style.display = 'none';
                iconClose.style.display = 'block';
            }

            function closeMenu() {
                open = false;
                toggle.setAttribute('aria-expanded', 'false');
                menu.style.maxHeight = '0';
                menu.style.borderTopColor = 'transparent';
                iconOpen.style.display = 'block';
                iconClose.style.display = 'none';
            }

            toggle.addEventListener('click', function() {
                open ? closeMenu() : openMenu();
            });

            // Close on mobile nav link click
            document.querySelectorAll('.mobile-nav-link').forEach(function(link) {
                link.addEventListener('click', closeMenu);
            });

            // Close on outside click
            document.addEventListener('click', function(e) {
                if (open && !menu.contains(e.target) && !toggle.contains(e.target)) {
                    closeMenu();
                }
            });
        })();
    </script>
