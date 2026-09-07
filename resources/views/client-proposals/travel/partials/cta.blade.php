<!-- Section: CTA Banner & WhatsApp Hotline -->
<section class="py-16 bg-gradient-to-r from-travel-700 via-sky-600 to-travel-800 text-white relative overflow-hidden">
    <!-- Ambient Blur -->
    <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_top,_var(--tw-gradient-stops))] from-white/10 via-transparent to-black/20 pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
        <h2 class="font-heading text-2xl sm:text-4xl font-black tracking-tight mb-4">
            Siap Melakukan Perjalanan Nyaman & Tepat Waktu?
        </h2>
        <p class="text-sky-100 text-sm sm:text-base max-w-2xl mx-auto mb-8 leading-relaxed">
            Jangan sampai kehabisan kursi favorit Anda. Hubungi layanan WhatsApp 24 jam kami untuk reservasi cepat atau sewa charter private 1 unit Minibus / HiAce.
        </p>
        <div class="flex flex-wrap justify-center gap-4">
            <a href="#jadwal" class="px-8 py-4 rounded-2xl bg-white text-travel-800 hover:bg-sky-50 font-heading font-black text-sm shadow-xl transition-all transform active:scale-95 flex items-center gap-2">
                <i class="fas fa-chair text-travel-600"></i> Pilih Kursi Sekarang
            </a>
            <a href="https://wa.me/{{ $cleanWa }}?text={{ urlencode('Halo ' . $brandName . ', saya ingin konsultasi jadwal & ketersediaan kursi travel Minibus / HiAce.') }}" target="_blank" class="px-8 py-4 rounded-2xl bg-emerald-500 hover:bg-emerald-600 text-white font-heading font-black text-sm shadow-xl shadow-emerald-600/30 transition-all transform active:scale-95 flex items-center gap-2">
                <i class="fab fa-whatsapp text-lg"></i> Chat CS WhatsApp 24 Jam
            </a>
        </div>
    </div>
</section>

