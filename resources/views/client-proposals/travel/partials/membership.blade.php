<!-- Section: Program Loyalitas & Membership Penumpang -->
<section id="membership" class="py-16 sm:py-24 bg-slate-50/60 border-b border-slate-200/80">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="text-center max-w-3xl mx-auto mb-12 sm:mb-16">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-amber-100/80 text-amber-900 text-xs font-semibold mb-3 border border-amber-200">
                <i class="fas fa-crown text-amber-700"></i> Program Loyalitas Penumpang
            </span>
            <h2 class="text-2xl sm:text-4xl font-extrabold text-slate-900 tracking-tight">
                Kumpulkan Poin, Naik 10x Free 1 Tiket
            </h2>
            <p class="text-xs sm:text-sm text-slate-600 mt-2 max-w-2xl mx-auto">
                Setiap kali bepergian bersama {{ $brandName }}, nomor WhatsApp Anda otomatis mengumpulkan poin member untuk ditukarkan dengan tiket gratis dan diskon spesial.
            </p>
        </div>

        <!-- Dynamic Membership Cards Grid from JSON -->
        <div id="dynamicMembershipGrid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5 sm:gap-6 items-stretch">
            <!-- Rendered dynamically via JS -->
        </div>

        <!-- Membership Simulation Banner -->
        <div class="mt-12 bg-white rounded-2xl p-6 sm:p-8 border border-slate-200/80 max-w-3xl mx-auto shadow-xs">
            <div class="flex flex-col sm:flex-row items-center justify-between gap-5">
                <div class="text-center sm:text-left">
                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-md bg-emerald-50 text-emerald-800 text-[11px] font-bold uppercase mb-2 border border-emerald-200">
                        <i class="fas fa-check-circle text-emerald-600"></i> Poin Otomatis
                    </span>
                    <h4 class="font-bold text-base text-slate-900">Cek Status Poin & Diskon Tiket Anda</h4>
                    <p class="text-xs text-slate-500 mt-0.5">Cukup sebutkan nomor WhatsApp yang terdaftar untuk memeriksa akumulasi poin Anda.</p>
                </div>
                <div class="shrink-0">
                    <a href="https://wa.me/{{ $cleanWa }}?text={{ urlencode('Halo ' . $brandName . ', saya ingin cek status poin membership dan diskon tiket saya.') }}" target="_blank" class="px-5 py-3 rounded-xl bg-slate-900 hover:bg-travel-700 text-white font-bold text-xs shadow-sm transition-all flex items-center justify-center gap-2">
                        <i class="fas fa-wallet text-amber-400"></i>
                        <span>Cek Poin via WhatsApp</span>
                    </a>
                </div>
            </div>
        </div>

    </div>
</section>
