{{-- ══════════════════════════════════════════════════
     SECTION FAQ (Pertanyaan yang Sering Diajukan)
══════════════════════════════════════════════════ --}}
<section class="py-14 sm:py-18 px-4 sm:px-6 lg:px-8 bg-[#090d29] border-b border-white/5 relative z-20" x-data="{ activeFaq: null }">
    <div class="max-w-4xl mx-auto">

        {{-- Section Title --}}
        <div class="text-center mb-10">
            <div class="mb-2">
                <span class="text-cyan-400 font-extrabold text-[11px] sm:text-xs tracking-[0.2em] uppercase inline-flex items-center gap-1.5">
                    <span class="w-1.5 h-1.5 rounded-full bg-cyan-400"></span>
                    FREQUENTLY ASKED QUESTIONS (FAQ)
                </span>
            </div>
            <h2 class="font-sans font-black text-2xl sm:text-3xl lg:text-4xl text-white mb-3 leading-tight tracking-tight">
                Pertanyaan yang Sering Diajukan
            </h2>
            <p class="text-white/60 text-xs sm:text-sm max-w-xl mx-auto font-normal leading-relaxed">
                Informasi penting seputar standar CV, proses ekspor PDF A4, dan panduan rekrutmen.
            </p>
        </div>

        {{-- Accordion List --}}
        <div class="space-y-3.5">
            
            {{-- FAQ Item 1 --}}
            <div class="bg-brand-navy/60 backdrop-blur-xl border border-white/10 rounded-2xl overflow-hidden transition-all duration-300">
                <button @click="activeFaq = (activeFaq === 1 ? null : 1)" class="w-full p-5 text-left flex items-center justify-between gap-4 focus:outline-none cursor-pointer">
                    <span class="font-bold text-sm sm:text-base text-white">Apakah format template CV 2-kolom ini aman untuk sistem seleksi ATS?</span>
                    <div class="w-7 h-7 rounded-full bg-white/5 flex items-center justify-center shrink-0 text-cyan-400 transition-transform duration-300" :class="activeFaq === 1 ? 'rotate-180 bg-cyan-500/20' : ''">
                        <i class="fa-solid fa-chevron-down text-xs"></i>
                    </div>
                </button>
                <div x-show="activeFaq === 1" x-collapse x-cloak class="px-5 pb-5 text-white/70 text-xs sm:text-sm leading-relaxed border-t border-white/5 pt-3">
                    Ya, struktur kode HTML & teks pada template ini disusun secara semantik dengan heading hierarki yang jelas. Teks tetap berupa teks nyata (bukan gambar raster), sehingga parser ATS modern (seperti Workday, Taleo, Greenhouse, LinkedIn Recruiter) maupun tim HRD manusia dapat membaca data Anda dengan sangat akurat.
                </div>
            </div>

            {{-- FAQ Item 2 --}}
            <div class="bg-brand-navy/60 backdrop-blur-xl border border-white/10 rounded-2xl overflow-hidden transition-all duration-300">
                <button @click="activeFaq = (activeFaq === 2 ? null : 2)" class="w-full p-5 text-left flex items-center justify-between gap-4 focus:outline-none cursor-pointer">
                    <span class="font-bold text-sm sm:text-base text-white">Apakah saya boleh menyertakan foto pada CV?</span>
                    <div class="w-7 h-7 rounded-full bg-white/5 flex items-center justify-center shrink-0 text-cyan-400 transition-transform duration-300" :class="activeFaq === 2 ? 'rotate-180 bg-cyan-500/20' : ''">
                        <i class="fa-solid fa-chevron-down text-xs"></i>
                    </div>
                </button>
                <div x-show="activeFaq === 2" x-collapse x-cloak class="px-5 pb-5 text-white/70 text-xs sm:text-sm leading-relaxed border-t border-white/5 pt-3">
                    Untuk standar rekrutmen di Indonesia dan Asia Tenggara (BUMN, Startup, Perbankan, Swasta Nasional), menyertakan foto formal beresolusi tinggi sangat dianjurkan karena memberikan kesan profesional dan kredibel. Fitur upload foto kami memudahkan Anda memasang foto formal secara instan.
                </div>
            </div>

            {{-- FAQ Item 3 --}}
            <div class="bg-brand-navy/60 backdrop-blur-xl border border-white/10 rounded-2xl overflow-hidden transition-all duration-300">
                <button @click="activeFaq = (activeFaq === 3 ? null : 3)" class="w-full p-5 text-left flex items-center justify-between gap-4 focus:outline-none cursor-pointer">
                    <span class="font-bold text-sm sm:text-base text-white">Bagaimana cara menyimpan CV hasil edit ke file PDF?</span>
                    <div class="w-7 h-7 rounded-full bg-white/5 flex items-center justify-center shrink-0 text-cyan-400 transition-transform duration-300" :class="activeFaq === 3 ? 'rotate-180 bg-cyan-500/20' : ''">
                        <i class="fa-solid fa-chevron-down text-xs"></i>
                    </div>
                </button>
                <div x-show="activeFaq === 3" x-collapse x-cloak class="px-5 pb-5 text-white/70 text-xs sm:text-sm leading-relaxed border-t border-white/5 pt-3">
                    Cukup klik tombol <strong>"Cetak / Simpan PDF"</strong> di atas lembar CV. Dialog cetak browser akan terbuka. Pilih opsi Destination: <em>"Save as PDF"</em> (Simpan sebagai PDF), pastikan opsi Paper Size adalah <em>A4</em> dan checklist <em>"Background graphics"</em> aktif. CV Anda akan tersimpan dalam resolusi tajam 1 halaman penuh.
                </div>
            </div>

            {{-- FAQ Item 4 --}}
            <div class="bg-brand-navy/60 backdrop-blur-xl border border-white/10 rounded-2xl overflow-hidden transition-all duration-300">
                <button @click="activeFaq = (activeFaq === 4 ? null : 4)" class="w-full p-5 text-left flex items-center justify-between gap-4 focus:outline-none cursor-pointer">
                    <span class="font-bold text-sm sm:text-base text-white">Apakah saya bisa berkonsultasi jika ingin CV saya dibuatkan khusus oleh tim HRD?</span>
                    <div class="w-7 h-7 rounded-full bg-white/5 flex items-center justify-center shrink-0 text-cyan-400 transition-transform duration-300" :class="activeFaq === 4 ? 'rotate-180 bg-cyan-500/20' : ''">
                        <i class="fa-solid fa-chevron-down text-xs"></i>
                    </div>
                </button>
                <div x-show="activeFaq === 4" x-collapse x-cloak class="px-5 pb-5 text-white/70 text-xs sm:text-sm leading-relaxed border-t border-white/5 pt-3">
                    Tentu saja! Kami menyediakan layanan <strong>Pro CV Revamp</strong> di mana praktisi HRD kami akan membedah pengalaman Anda, menyesuaikan kata kunci dengan deskripsi pekerjaan target, serta menyusun surat lamaran (cover letter) pendukung via WhatsApp.
                </div>
            </div>

        </div>

    </div>
</section>
