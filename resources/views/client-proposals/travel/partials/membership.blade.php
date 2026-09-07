<!-- Section: Program Loyalitas & Membership Penumpang (Soft Luxury Style) -->
<section id="membership" class="py-24 bg-gradient-to-b from-white via-amber-50/30 to-sky-50/40 text-slate-900 relative overflow-hidden border-b border-slate-100">
    <!-- Ambient Soft Glows -->
    <div class="absolute top-10 left-1/2 -translate-x-1/2 w-[700px] h-[450px] bg-amber-200/30 rounded-full blur-[140px] pointer-events-none"></div>
    <div class="absolute bottom-10 right-10 w-[450px] h-[450px] bg-sky-200/30 rounded-full blur-[130px] pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">

        <div class="text-center max-w-3xl mx-auto mb-16">
            <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-amber-100/80 text-amber-900 text-xs font-black mb-4 border border-amber-300/80 shadow-2xs">
                <i class="fas fa-crown text-amber-600"></i> Program Loyalitas Penumpang Setia
            </div>
            <h2 class="font-heading text-2xl sm:text-4xl font-black text-slate-900 tracking-tight mb-4">
                Kumpulkan Poin, <span class="text-transparent bg-clip-text bg-gradient-to-r from-amber-600 via-yellow-600 to-amber-700">Naik 10x Gratis 1x Tiket!</span>
            </h2>
            <p class="text-slate-600 text-sm sm:text-base leading-relaxed">
                Setiap kali Anda bepergian bersama {{ $brandName }}, Anda otomatis mengumpulkan poin member yang dapat ditukar dengan tiket gratis, diskon langsung, dan keistimewaan kursi prioritas.
            </p>
        </div>

        <!-- Dynamic Membership Cards Grid from JSON -->
        <div id="dynamicMembershipGrid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 items-stretch">
            <!-- Rendered dynamically via JS -->
        </div>

        <!-- Interactive Membership Poin Simulation Box -->
        <div class="mt-16 bg-white rounded-3xl p-8 sm:p-10 border border-amber-200/70 max-w-3xl mx-auto shadow-xl shadow-amber-900/5">
            <div class="flex flex-col sm:flex-row items-center justify-between gap-6">
                <div class="text-center sm:text-left">
                    <span class="inline-flex items-center gap-1.5 px-3.5 py-1 rounded-full bg-emerald-50 text-emerald-800 text-[11px] font-extrabold uppercase mb-2.5 border border-emerald-200">
                        <i class="fas fa-calculator text-emerald-600"></i> Cek Poin & Tiket Gratis
                    </span>
                    <h4 class="font-heading font-black text-lg text-slate-900">Berapa Kali Anda Bepergian per Bulan?</h4>
                    <p class="text-xs text-slate-500 mt-1">Cukup beritahukan nomor WhatsApp Anda ke admin saat booking, poin akan dicatat otomatis!</p>
                </div>
                <div class="shrink-0 text-center">
                    <a href="https://wa.me/{{ $cleanWa }}?text={{ urlencode('Halo ' . $brandName . ', saya ingin cek status poin membership dan diskon tiket saya.') }}" target="_blank" class="px-7 py-3.5 rounded-2xl bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-600 hover:to-amber-700 text-white font-heading font-black text-xs shadow-lg shadow-amber-500/25 transition-all transform active:scale-95 flex items-center justify-center gap-2">
                        <i class="fas fa-wallet"></i> Cek Poin via WhatsApp
                    </a>
                </div>
            </div>
        </div>

    </div>
</section>
