<section id="hero" class="relative pt-28 pb-16 md:pt-36 md:pb-24 px-4 sm:px-8 overflow-hidden bg-gradient-to-b from-[#16110E] via-[#1A1410] to-[#120E0C]">
    
    <!-- Subtle Ambient Glow -->
    <div class="absolute top-1/4 left-1/2 -translate-x-1/2 w-[500px] h-[500px] bg-[#C59B6C]/10 rounded-full blur-[130px] pointer-events-none"></div>

    <div class="max-w-6xl mx-auto relative z-10 grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-12 items-center">
        
        <!-- Left Content (7 Cols) -->
        <div class="lg:col-span-7 text-center lg:text-left">
            
            <!-- Tagline Badge -->
            <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-[#241A13] border border-[#C59B6C]/30 text-[#D8AA73] text-xs font-medium mb-6">
                <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                <span>Self-Order Meja QRIS & POS Modern</span>
            </div>

            <!-- Main Headline -->
            <h1 class="font-serif text-3xl sm:text-5xl lg:text-6xl font-bold text-white leading-[1.15] mb-5 tracking-tight">
                Cita Rasa <span class="text-[#D8AA73] italic">Artisan,</span><br>
                Kemudahan Order <span class="text-[#C59B6C]">Digital Meja.</span>
            </h1>

            <p class="text-white/70 text-xs sm:text-base mb-8 max-w-xl mx-auto lg:mx-0 leading-relaxed font-light">
                Nikmati racikan kopi pilihan dari <strong>{{ $brandName }}</strong> tanpa harus antre. Cukup scan kode QR di meja, pesan menu favorit, kumpulkan poin member, dan bayar seketika dengan QRIS.
            </p>

            <!-- Action Buttons -->
            <div class="flex flex-wrap items-center justify-center lg:justify-start gap-3 mb-10">
                <a href="#menu" class="px-6 py-3 rounded-full bg-[#C59B6C] hover:bg-[#D8AA73] text-[#140F0C] text-xs sm:text-sm font-bold tracking-wide transition shadow-lg shadow-[#C59B6C]/20">
                    Jelajahi Menu
                </a>

                @if(isset($client->slug))
                <a href="{{ route('demo.customer.cafe', $client->slug) }}" class="px-5 py-3 rounded-full bg-[#241A13] hover:bg-[#2E2118] border border-[#C59B6C]/40 text-amber-300 text-xs sm:text-sm font-semibold transition flex items-center gap-2">
                    <i class="fas fa-mobile-alt text-amber-400 text-xs"></i>
                    <span>Coba Demo App HP</span>
                </a>
                @endif

                <a href="https://wa.me/{{ $cleanWa }}?text={{ urlencode('Halo ' . $brandName . ', saya ingin reservasi meja kafe.') }}" target="_blank" class="px-5 py-3 rounded-full bg-white/5 hover:bg-white/10 border border-white/10 text-white/80 hover:text-white text-xs sm:text-sm font-medium transition flex items-center gap-1.5">
                    <i class="fab fa-whatsapp text-emerald-400 text-sm"></i>
                    <span>Reservasi</span>
                </a>
            </div>

            <!-- Key Highlights (Clean Typography, No Icon Clutter) -->
            <div class="grid grid-cols-3 gap-4 max-w-md mx-auto lg:mx-0 pt-6 border-t border-white/10 text-center lg:text-left">
                <div>
                    <p class="text-white font-bold text-sm sm:text-base">100% Cepat</p>
                    <p class="text-[11px] text-white/50 mt-0.5">Pesan dari meja tanpa antre</p>
                </div>
                <div class="border-x border-white/10 px-2">
                    <p class="text-emerald-400 font-bold text-sm sm:text-base">QRIS Otomatis</p>
                    <p class="text-[11px] text-white/50 mt-0.5">Semua bank & e-wallet</p>
                </div>
                <div>
                    <p class="text-amber-400 font-bold text-sm sm:text-base">Loyalty Poin</p>
                    <p class="text-[11px] text-white/50 mt-0.5">Diskon s/d 15% tiap transaksi</p>
                </div>
            </div>

        </div>

        <!-- Right Visual (5 Cols): Coffee Hero Frame -->
        <div class="lg:col-span-5 relative flex justify-center">
            
            <div class="relative w-full max-w-[360px] sm:max-w-[400px] aspect-[4/5] rounded-3xl overflow-hidden border border-[#3A2C22] shadow-2xl shadow-black/70 group">
                <img src="https://images.unsplash.com/photo-1497935586351-b67a49e012bf?auto=format&fit=crop&q=80&w=800" alt="Artisan Coffee" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                <div class="absolute inset-0 bg-gradient-to-t from-[#140F0C] via-black/20 to-transparent"></div>

                <!-- Clean Table Badge -->
                <div class="absolute top-4 left-4 bg-[#140F0C]/90 backdrop-blur-md border border-[#C59B6C]/40 rounded-xl px-3 py-2">
                    <span class="text-[9px] text-[#D8AA73] font-semibold uppercase tracking-wider block">Scan Barcode Meja</span>
                    <span class="text-xs font-bold text-white">Meja 04 • Indoor Lounge</span>
                </div>

                <!-- Clean Bottom Info -->
                <div class="absolute bottom-4 inset-x-4 bg-[#18130F]/95 backdrop-blur-md border border-white/10 rounded-2xl p-3.5 flex items-center justify-between">
                    <div>
                        <p class="text-[10px] text-white/50 uppercase">Standar Kualitas</p>
                        <h4 class="font-bold text-xs text-white">100% Arabica Specialty</h4>
                    </div>
                    <div class="text-right">
                        <span class="text-xs font-bold text-amber-400">4.9 / 5.0</span>
                        <p class="text-[10px] text-emerald-400 font-medium">QRIS Ready</p>
                    </div>
                </div>
            </div>

        </div>

    </div>
</section>
