    <nav class="fixed top-0 left-0 right-0 z-50 bg-brand-dark/80 backdrop-blur-xl border-b border-white/5">
        <div class="max-w-6xl mx-auto px-4 flex items-center justify-between h-14 sm:h-16">
            <div class="flex items-center gap-1.5 sm:gap-2 cursor-pointer" onclick="window.scrollTo(0,0)">
                <div class="w-6 h-6 sm:w-7 sm:h-7 rounded-md sm:rounded-lg bg-btn-gradient flex items-center justify-center shadow-glow-sm">
                    <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                        stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                </div>
                <span class="font-display font-bold text-base sm:text-lg tracking-tight">Scalify<span class="text-brand-accent">
                        Intelligence</span></span>
            </div>
            <div class="hidden md:flex items-center gap-8 text-sm text-white/70 font-medium">
                <a href="#tentang" class="hover:text-brand-accent transition-colors">Tentang Kami</a>
                <a href="#portofolio" class="hover:text-brand-accent transition-colors">Portofolio</a>
                <a href="#layanan" class="hover:text-brand-accent transition-colors">Paket Layanan</a>
                <a href="{{ route('landing.blogs') }}" class="hover:text-brand-accent transition-colors">Blog</a>
            </div>
            <div class="flex items-center gap-2 sm:gap-3">
                <a href="https://wa.me/6285221694067" target="_blank"
                    class="bg-btn-gradient text-white text-xs sm:text-sm font-semibold px-4 sm:px-5 py-2 sm:py-2.5 rounded-full shadow-glow-sm hover:shadow-glow-blue transition-all">
                    Hubungi Kami
                </a>
            </div>
        </div>
    </nav>
