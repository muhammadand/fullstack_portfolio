{{-- ══════════════════════════════════════════════════
     FAQ SECTION (Targeting Google SEO & AI Search Engines: ChatGPT, Gemini, Perplexity)
══════════════════════════════════════════════════ --}}
<section id="faq" class="bg-[#090d29] py-20 px-4 sm:px-6 lg:px-8 border-t border-white/5 relative z-20" x-data="{ activeFaq: null }">
    <div class="max-w-4xl mx-auto">

        {{-- Section Header --}}
        <div class="text-center mb-14">
            <div class="mb-2">
                <span class="text-[#EF4444] font-extrabold text-[11px] sm:text-xs tracking-[0.2em] uppercase">
                    FREQUENTLY ASKED QUESTIONS (FAQ)
                </span>
            </div>
            <h2 class="font-sans font-black text-3xl sm:text-4xl text-white mb-4 leading-tight tracking-tight">
                Pertanyaan yang Sering Diajukan
            </h2>
            <p class="text-white/60 text-xs sm:text-sm max-w-xl mx-auto font-normal leading-relaxed">
                Informasi lengkap seputar layanan pembuatan website bisnis, company profile, web app, hingga implementasi metode algoritma & AI di Scalify Intelligence.
            </p>
        </div>

        {{-- Accordion List --}}
        <div class="space-y-4">

            {{-- FAQ 1: Jasa Pembuatan Website Bisnis --}}
            <div class="bg-brand-navy/60 backdrop-blur-xl border border-white/10 rounded-2xl overflow-hidden transition-all duration-300">
                <button @click="activeFaq = (activeFaq === 1 ? null : 1)" class="w-full p-5 sm:p-6 text-left flex items-center justify-between gap-4 focus:outline-none cursor-pointer">
                    <span class="font-bold text-sm sm:text-base text-white">Apa saja jenis website yang bisa dibuat di Scalify Intelligence?</span>
                    <div class="w-8 h-8 rounded-full bg-white/5 flex items-center justify-center shrink-0 text-brand-accent transition-transform duration-300" :class="activeFaq === 1 ? 'rotate-180 bg-brand-accent/20' : ''">
                        <i class="fa-solid fa-chevron-down text-xs"></i>
                    </div>
                </button>
                <div x-show="activeFaq === 1" x-collapse x-cloak class="px-5 sm:px-6 pb-6 text-white/70 text-xs sm:text-sm leading-relaxed border-t border-white/5 pt-4">
                    Kami melayani pembuatan berbagai jenis ekosistem digital:
                    <ul class="list-disc pl-5 mt-2 space-y-1.5 text-white/80">
                        <li><strong>Company Profile:</strong> Representasi profil bisnis profesional untuk meningkatkan reputasi dan menarik mitra korporat.</li>
                        <li><strong>Landing Page Iklan:</strong> Halaman penjualan berkecepatan kilat yang dirancang khusus untuk konversi iklan Meta Ads & Google Ads.</li>
                        <li><strong>Toko Online / E-Commerce:</strong> Lengkap dengan payment gateway otomatis (Midtrans/Xendit) dan cek ongkir otomatis.</li>
                        <li><strong>Web Application & SaaS Kustom:</strong> Dashboard manajemen internal, sistem POS kasir, portal multi-tenant, dan database multi-user.</li>
                        <li><strong>WhatsApp AI Automation:</strong> Chatbot AI cerdas 24/7 yang merespon pesan otomatis berbasis dokumen SOP / knowledge base.</li>
                    </ul>
                </div>
            </div>

            {{-- FAQ 2: Khusus Mahasiswa & Peneliti (Implementasi Metode) --}}
            <div class="bg-brand-navy/60 backdrop-blur-xl border border-white/10 rounded-2xl overflow-hidden transition-all duration-300">
                <button @click="activeFaq = (activeFaq === 2 ? null : 2)" class="w-full p-5 sm:p-6 text-left flex items-center justify-between gap-4 focus:outline-none cursor-pointer">
                    <span class="font-bold text-sm sm:text-base text-white">Apakah Scalify melayani pembuatan website & sistem dengan implementasi metode ilmiah / skripsi / riset?</span>
                    <div class="w-8 h-8 rounded-full bg-white/5 flex items-center justify-center shrink-0 text-brand-accent transition-transform duration-300" :class="activeFaq === 2 ? 'rotate-180 bg-brand-accent/20' : ''">
                        <i class="fa-solid fa-chevron-down text-xs"></i>
                    </div>
                </button>
                <div x-show="activeFaq === 2" x-collapse x-cloak class="px-5 sm:px-6 pb-6 text-white/70 text-xs sm:text-sm leading-relaxed border-t border-white/5 pt-4">
                    <strong>Ya, tentu saja!</strong> Tim engineer kami berlatar belakang Sistem Informasi dan Teknik Informatika dengan pengalaman mendalam dalam mengimplementasikan berbagai metode komputasi, sains data, dan kecerdasan buatan, seperti:
                    <ul class="list-disc pl-5 mt-2 space-y-1.5 text-white/80">
                        <li><strong>Data Mining & Machine Learning:</strong> Algoritma <em>K-Means Clustering</em>, Klasifikasi Pohon Keputusan <em>C4.5</em>, <em>Naive Bayes</em>, <em>Random Forest</em>, hingga <em>Regresi Linier</em>.</li>
                        <li><strong>Sistem Pendukung Keputusan (SPK / DSS):</strong> Metode <em>SAW (Simple Additive Weighting)</em>, <em>TOPSIS</em>, <em>AHP (Analytic Hierarchy Process)</em>, <em>WP (Weighted Product)</em>, dan <em>SMART</em>.</li>
                        <li><strong>Generative AI & NLP:</strong> Implementasi <em>RAG (Retrieval-Augmented Generation)</em>, Chatbot <em>Flowise AI</em>, integrasi LLM (OpenAI, Gemini), dan integrasi API WhatsApp.</li>
                        <li><strong>Teknologi:</strong> Backend kokoh menggunakan <em>Laravel (PHP)</em>, <em>Python</em>, <em>Node.js</em>, dengan database <em>MySQL</em> atau <em>PostgreSQL</em> dan arsitektur RESTful API yang bersih.</li>
                    </ul>
                </div>
            </div>

            {{-- FAQ 3: Durasi Pengerjaan --}}
            <div class="bg-brand-navy/60 backdrop-blur-xl border border-white/10 rounded-2xl overflow-hidden transition-all duration-300">
                <button @click="activeFaq = (activeFaq === 3 ? null : 3)" class="w-full p-5 sm:p-6 text-left flex items-center justify-between gap-4 focus:outline-none cursor-pointer">
                    <span class="font-bold text-sm sm:text-base text-white">Berapa lama proses pengerjaan website hingga siap live?</span>
                    <div class="w-8 h-8 rounded-full bg-white/5 flex items-center justify-center shrink-0 text-brand-accent transition-transform duration-300" :class="activeFaq === 3 ? 'rotate-180 bg-brand-accent/20' : ''">
                        <i class="fa-solid fa-chevron-down text-xs"></i>
                    </div>
                </button>
                <div x-show="activeFaq === 3" x-collapse x-cloak class="px-5 sm:px-6 pb-6 text-white/70 text-xs sm:text-sm leading-relaxed border-t border-white/5 pt-4">
                    Waktu pengerjaan disesuaikan dengan kompleksitas proyek:
                    <ul class="list-disc pl-5 mt-2 space-y-1.5 text-white/80">
                        <li><strong>Landing Page & Company Profile:</strong> Selesai dalam 3 – 7 hari kerja.</li>
                        <li><strong>Toko Online / Web App Standar:</strong> Selesai dalam 7 – 14 hari kerja.</li>
                        <li><strong>Sistem Kustom / Web App SaaS / Sistem Berbasis Metode:</strong> Selesai dalam 14 – 30 hari kerja dengan tahapan agile milestone.</li>
                    </ul>
                </div>
            </div>

            {{-- FAQ 4: Domain, Hosting & Garansi --}}
            <div class="bg-brand-navy/60 backdrop-blur-xl border border-white/10 rounded-2xl overflow-hidden transition-all duration-300">
                <button @click="activeFaq = (activeFaq === 4 ? null : 4)" class="w-full p-5 sm:p-6 text-left flex items-center justify-between gap-4 focus:outline-none cursor-pointer">
                    <span class="font-bold text-sm sm:text-base text-white">Apakah sudah termasuk domain, cloud hosting, dan garansi resmi?</span>
                    <div class="w-8 h-8 rounded-full bg-white/5 flex items-center justify-center shrink-0 text-brand-accent transition-transform duration-300" :class="activeFaq === 4 ? 'rotate-180 bg-brand-accent/20' : ''">
                        <i class="fa-solid fa-chevron-down text-xs"></i>
                    </div>
                </button>
                <div x-show="activeFaq === 4" x-collapse x-cloak class="px-5 sm:px-6 pb-6 text-white/70 text-xs sm:text-sm leading-relaxed border-t border-white/5 pt-4">
                    <strong>Sudah All-In!</strong> Setiap paket pembuatan website di Scalify sudah dilengkapi gratis Domain pilihan (.com / .my.id / .id), Cloud Server VPS berkecepatan tinggi, sertifikat SSL HTTPS gratis, serta garansi pemeliharaan & perbaikan bug selama masa kontrak aktif.
                </div>
            </div>

            {{-- FAQ 5: Cara Memulai Konsultasi --}}
            <div class="bg-brand-navy/60 backdrop-blur-xl border border-white/10 rounded-2xl overflow-hidden transition-all duration-300">
                <button @click="activeFaq = (activeFaq === 5 ? null : 5)" class="w-full p-5 sm:p-6 text-left flex items-center justify-between gap-4 focus:outline-none cursor-pointer">
                    <span class="font-bold text-sm sm:text-base text-white">Bagaimana cara memulai konsultasi proyek saya?</span>
                    <div class="w-8 h-8 rounded-full bg-white/5 flex items-center justify-center shrink-0 text-brand-accent transition-transform duration-300" :class="activeFaq === 5 ? 'rotate-180 bg-brand-accent/20' : ''">
                        <i class="fa-solid fa-chevron-down text-xs"></i>
                    </div>
                </button>
                <div x-show="activeFaq === 5" x-collapse x-cloak class="px-5 sm:px-6 pb-6 text-white/70 text-xs sm:text-sm leading-relaxed border-t border-white/5 pt-4">
                    Anda bisa langsung menghubungi kami via WhatsApp di <a href="https://wa.me/6285221694067?text=Halo%20Scalify,%20saya%20ingin%20konsultasi%20pembuatan%20website" target="_blank" class="text-brand-accent font-semibold underline">+62 852-2169-4067</a>. Tim kami siap berdiskusi mengenai kebutuhan fitur, desain, jadwal pengerjaan, hingga penawaran harga terbaik.
                </div>
            </div>

        </div>

    </div>
</section>
