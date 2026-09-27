<section class="py-12 sm:py-16 bg-slate-900 text-white border-b border-slate-900 relative">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <span class="text-emerald-400 font-semibold text-xs tracking-wider uppercase mb-1.5 block">
            Jadwal Rutin & Turnamen
        </span>
        <h2 class="text-xl sm:text-3xl font-bold text-white tracking-tight mb-2.5">
            Sewa Rutin Instansi atau Selenggarakan Turnamen
        </h2>
        <p class="text-xs sm:text-sm text-slate-400 max-w-xl mx-auto leading-relaxed mb-6">
            Konsultasikan kebutuhan jadwal bermain mingguan kantor atau penyewaan gelanggang penuh untuk kejuaraan olahraga bersama tim kami.
        </p>

        <div class="flex flex-col sm:flex-row items-center justify-center gap-2.5">
            <a href="https://wa.me/{{ $cleanWa }}?text={{ urlencode('Halo ' . $brandName . ', saya ingin konsultasi sewa lapangan rutin / turnamen.') }}" target="_blank" class="w-full sm:w-auto px-5 py-2.5 rounded-xl bg-emerald-500 hover:bg-emerald-400 text-slate-950 font-bold text-xs transition flex items-center justify-center gap-1.5 shadow-sm">
                <i class="fab fa-whatsapp"></i>
                <span>Hubungi via WhatsApp</span>
            </a>
            @if(isset($client->slug))
            <a href="{{ route('demo.customer.sport', $client->slug) }}" class="w-full sm:w-auto px-5 py-2.5 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-300 font-semibold text-xs transition flex items-center justify-center gap-1.5">
                <i class="fas fa-mobile-screen-button"></i>
                <span>Simulasi Demo App Mobile</span>
            </a>
            @endif
        </div>
    </div>
</section>
