<section class="py-16 md:py-24 px-4 sm:px-8 bg-[#120E0C] border-t border-[#362921]/40">
    <div class="max-w-4xl mx-auto rounded-3xl bg-[#1C1612] border border-[#3A2C22] p-8 sm:p-12 text-center relative shadow-xl">

        <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold bg-[#241A13] text-[#D8AA73] border border-[#C59B6C]/30 mb-4">
            Pengalaman Ngopi Terbaik
        </span>

        <h2 class="font-serif text-2xl sm:text-4xl font-bold text-white mb-3 leading-tight">
            Siap Menikmati Seduhan Kopi Hangat Hari Ini?
        </h2>

        <p class="text-xs sm:text-sm text-white/70 mb-8 max-w-lg mx-auto leading-relaxed font-light">
            Kunjungi gerai kami atau pesan lebih awal. Rasakan kemudahan memesan dari meja dengan QRIS dan nikmati diskon eksklusif member.
        </p>

        <div class="flex flex-wrap items-center justify-center gap-3">
            <a href="https://wa.me/{{ $cleanWa }}?text={{ urlencode('Halo ' . $brandName . ', saya ingin reservasi meja kafe.') }}" target="_blank" class="px-6 py-3 rounded-full bg-[#C59B6C] hover:bg-[#D8AA73] text-[#140F0C] text-xs sm:text-sm font-bold tracking-wide transition shadow-lg shadow-[#C59B6C]/20 flex items-center gap-2">
                <i class="fab fa-whatsapp text-sm"></i>
                <span>Reservasi via WhatsApp</span>
            </a>

            @if(isset($client->slug))
            <a href="{{ route('demo.customer.cafe', $client->slug) }}" class="px-5 py-3 rounded-full bg-[#241A13] hover:bg-[#2E2118] border border-white/10 text-white text-xs sm:text-sm font-semibold transition flex items-center gap-2">
                <i class="fas fa-mobile-alt text-amber-400 text-xs"></i>
                <span>Buka Demo App HP</span>
            </a>
            @endif
        </div>

        <p class="text-[11px] text-white/40 mt-6">
            Buka Setiap Hari: 07:00 - 23:00 WIB • {{ $brandName }}
        </p>

    </div>
</section>
