<nav class="fixed top-0 inset-x-0 z-50 transition-all duration-300 bg-[#140F0C]/90 backdrop-blur-md border-b border-[#362921]/60 py-3.5 px-4 sm:px-8" id="navbar">
    <div class="max-w-7xl mx-auto flex items-center justify-between gap-4">
        
        <!-- Brand Logo -->
        <a href="#" class="flex items-center gap-3 group">
            <div class="w-10 h-10 rounded-2xl bg-gradient-to-br from-[#C59B6C] to-[#8C6239] flex items-center justify-center text-[#140F0C] font-serif text-lg shadow-lg shadow-[#C59B6C]/20 group-hover:scale-105 transition-transform duration-300">
                <i class="fas fa-coffee text-sm"></i>
            </div>
            <div>
                <h1 class="font-serif font-bold text-white leading-tight tracking-[0.08em] text-sm md:text-base group-hover:text-[#D8AA73] transition-colors">
                    {{ strtoupper($brandName) }}
                </h1>
                <p class="text-[9px] tracking-[0.25em] text-[#C59B6C] uppercase font-medium">Artisan Coffee & POS</p>
            </div>
        </a>

        <!-- Desktop Navigation Links -->
        <div class="hidden lg:flex items-center gap-8 text-[13px] font-medium text-white/75">
            <a href="#hero" class="hover:text-[#D8AA73] transition">Beranda</a>
            <a href="#menu" class="hover:text-[#D8AA73] transition">Menu Pilihan</a>
            <a href="#fitur-pos" class="hover:text-[#D8AA73] transition flex items-center gap-1.5">
                <span>POS & QRIS Meja</span>
                <span class="px-1.5 py-0.5 rounded text-[9px] font-bold bg-[#C59B6C]/20 text-[#D8AA73] border border-[#C59B6C]/40">Baru</span>
            </a>
            <a href="#membership" class="hover:text-[#D8AA73] transition">VIP Member</a>
            <a href="#cara-pesan" class="hover:text-[#D8AA73] transition">Cara Pesan</a>
            <a href="#fasilitas" class="hover:text-[#D8AA73] transition">Fasilitas</a>
        </div>

        <!-- Action Buttons -->
        <div class="flex items-center gap-2 sm:gap-3">
            @if(isset($client->slug))
            <!-- Direct Link to Customer Mobile Demo App -->
            <a href="{{ route('demo.customer.cafe', $client->slug) }}" class="px-3.5 sm:px-4 py-2 rounded-xl bg-gradient-to-r from-amber-600/30 to-amber-500/20 hover:from-amber-600/40 hover:to-amber-500/30 border border-amber-500/50 text-amber-300 text-xs font-bold transition flex items-center gap-1.5 shadow-sm">
                <i class="fas fa-mobile-alt text-xs text-amber-400"></i>
                <span class="hidden sm:inline">Demo App HP</span>
                <span class="sm:hidden">Demo</span>
            </a>
            <a href="{{ route('proposal.dynamic', $client->slug) }}" class="hidden md:inline-flex px-4 py-2 rounded-xl bg-[#C59B6C] hover:bg-[#D8AA73] text-[#140F0C] text-xs font-bold tracking-wide transition shadow-lg shadow-[#C59B6C]/20 items-center gap-1.5">
                <span>Proposal</span>
                <i class="fas fa-arrow-right text-[10px]"></i>
            </a>
            @endif

            <!-- Mobile Menu Toggle Button -->
            <button onclick="toggleMobileNav()" class="lg:hidden w-9 h-9 rounded-xl bg-white/5 border border-white/10 text-white flex items-center justify-center hover:bg-white/10 transition">
                <i class="fas fa-bars text-sm" id="mobileNavIcon"></i>
            </button>
        </div>

    </div>

    <!-- Mobile Dropdown Nav Menu -->
    <div id="mobileNavDropdown" class="hidden lg:hidden mt-3 pt-3 border-t border-white/10 flex flex-col gap-2 pb-2 text-sm text-white/80">
        <a href="#hero" onclick="toggleMobileNav()" class="px-3 py-2 rounded-lg hover:bg-white/5">Beranda</a>
        <a href="#menu" onclick="toggleMobileNav()" class="px-3 py-2 rounded-lg hover:bg-white/5">Menu Pilihan</a>
        <a href="#fitur-pos" onclick="toggleMobileNav()" class="px-3 py-2 rounded-lg hover:bg-white/5 text-[#D8AA73]">POS & Pembayaran QRIS</a>
        <a href="#membership" onclick="toggleMobileNav()" class="px-3 py-2 rounded-lg hover:bg-white/5">Loyalty Member</a>
        <a href="#cara-pesan" onclick="toggleMobileNav()" class="px-3 py-2 rounded-lg hover:bg-white/5">Cara Pesan di Meja</a>
        <a href="#fasilitas" onclick="toggleMobileNav()" class="px-3 py-2 rounded-lg hover:bg-white/5">Fasilitas Kafe</a>
        @if(isset($client->slug))
        <div class="pt-2 border-t border-white/10 flex gap-2">
            <a href="{{ route('demo.customer.cafe', $client->slug) }}" class="flex-1 py-2 text-center rounded-xl bg-amber-500/20 text-amber-300 font-bold text-xs border border-amber-500/30">
                <i class="fas fa-mobile-screen-button mr-1"></i> Buka Demo App HP
            </a>
            <a href="{{ route('proposal.dynamic', $client->slug) }}" class="flex-1 py-2 text-center rounded-xl bg-[#C59B6C] text-[#140F0C] font-bold text-xs">
                Proposal
            </a>
        </div>
        @endif
    </div>
</nav>

<script>
    function toggleMobileNav() {
        const el = document.getElementById('mobileNavDropdown');
        const icon = document.getElementById('mobileNavIcon');
        if (el.classList.contains('hidden')) {
            el.classList.remove('hidden');
            icon.classList.remove('fa-bars');
            icon.classList.add('fa-times');
        } else {
            el.classList.add('hidden');
            icon.classList.remove('fa-times');
            icon.classList.add('fa-bars');
        }
    }
</script>
