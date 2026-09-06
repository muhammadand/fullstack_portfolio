{{-- ══════════════════════════════════════════════════
     LIVE PRODUCTS SHOWCASE SECTION
══════════════════════════════════════════════════ --}}
<section id="produk-live" class="bg-brand-dark py-24 px-4 sm:px-6 lg:px-8 relative overflow-hidden border-t border-white/5">

    {{-- Background decorations --}}
    <div class="absolute top-0 left-1/2 -translate-x-1/2 w-[700px] h-[500px] bg-brand-accent/5 rounded-full blur-[120px] pointer-events-none"></div>
    <div class="absolute bottom-0 left-[-10%] w-[400px] h-[400px] bg-brand-indigo/10 rounded-full blur-[100px] pointer-events-none"></div>
    <div class="absolute top-1/2 right-[-5%] w-[500px] h-[500px] bg-emerald-500/5 rounded-full blur-[120px] pointer-events-none"></div>

    <div class="relative z-10 max-w-6xl mx-auto">

        {{-- Section Header --}}
        <div class="text-center mb-16">
            <div class="inline-flex items-center gap-2 bg-emerald-500/10 border border-emerald-400/20 rounded-full px-5 py-2 mb-6 shadow-[0_0_15px_rgba(16,185,129,0.2)]">
                <span class="flex h-2 w-2 relative">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                </span>
                <span class="text-emerald-400 text-xs font-bold tracking-widest uppercase">Produk Live & Berjalan</span>
            </div>
            <h2 class="font-sans font-black text-3xl sm:text-5xl text-white leading-tight mb-5 tracking-tight">
                4 Produk Nyata yang<br>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-brand-accent via-blue-400 to-brand-indigo relative">
                    Sudah Kami Bangun & Jalankan
                </span>
            </h2>
            <p class="text-white/55 max-w-2xl mx-auto text-xs sm:text-sm md:text-base leading-relaxed mt-4 font-normal">
                Bukan sekadar portofolio — ini adalah sistem nyata yang sudah live, digunakan pengguna aktif, dan berjalan penuh di atas infrastruktur produksi kami. Bukti nyata kemampuan kami membangun produk digital dari nol hingga skala penuh.
            </p>
        </div>

        {{-- Products Grid --}}
        <div class="space-y-16 sm:space-y-20">

            {{-- ── PRODUCT 1: KLAUNDRY ── --}}
            <div class="product-card group grid grid-cols-1 lg:grid-cols-2 gap-10 lg:gap-16 items-center opacity-0 translate-y-8 transition-all duration-700">

                {{-- Screenshot Left --}}
                <div class="relative order-2 lg:order-1">
                    <div class="absolute -inset-4 bg-gradient-to-br from-sky-500/20 to-blue-600/10 rounded-3xl blur-xl opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    <div class="relative rounded-2xl overflow-hidden border border-white/10 shadow-2xl shadow-sky-900/30 group-hover:border-sky-400/30 transition-colors duration-300">
                        <a href="https://klaundry.scalifyintellegence.my.id/" target="_blank" rel="noopener">
                            <img src="{{ asset('images/klaundry_mockup.webp') }}" alt="Klaundry - Aplikasi Kasir POS Laundry SaaS" class="w-full h-auto object-cover group-hover:scale-[1.02] transition-transform duration-500" loading="lazy" width="600" height="400">
                            <div class="absolute inset-0 bg-gradient-to-t from-brand-dark/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end justify-center pb-6">
                                <span class="inline-flex items-center gap-2 bg-sky-500 text-white text-xs font-bold px-5 py-2 rounded-full shadow-lg">
                                    <i class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i> Buka Aplikasi Live
                                </span>
                            </div>
                        </a>
                    </div>
                    {{-- Floating stat badge --}}
                    <div class="absolute -bottom-4 -right-4 bg-sky-500/15 backdrop-blur-md border border-sky-400/25 rounded-2xl px-4 py-3 shadow-xl group-hover:translate-y-[-5px] transition-transform duration-500">
                        <p class="text-sky-300 text-[10px] font-semibold uppercase tracking-wider mb-0.5">Platform Type</p>
                        <p class="text-white font-bold text-sm">SaaS Multi-Tenant</p>
                    </div>
                </div>

                {{-- Content Right --}}
                <div class="order-1 lg:order-2 flex flex-col gap-5 text-left">
                    <div class="flex items-center gap-3 flex-wrap">
                        <span class="inline-flex items-center gap-1.5 bg-sky-500/15 border border-sky-400/25 text-sky-300 text-[10px] font-bold px-3 py-1.5 rounded-full tracking-wider uppercase shadow-[0_0_10px_rgba(14,165,233,0.15)]">
                            <i class="fa-solid fa-shirt text-[9px]"></i> Laundry Management
                        </span>
                        <span class="inline-flex items-center gap-1.5 bg-emerald-500/10 border border-emerald-400/20 text-emerald-400 text-[10px] font-bold px-3 py-1.5 rounded-full">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span> Live Production
                        </span>
                    </div>

                    <div>
                        <h3 class="font-sans font-bold text-2xl sm:text-3xl text-white mb-2 leading-tight group-hover:text-sky-400 transition-colors duration-300">Klaundry</h3>
                        <p class="text-sky-300 text-xs sm:text-sm font-medium mb-3">Sistem Kasir POS Laundry Berbasis SaaS</p>
                        <p class="text-white/65 text-xs sm:text-sm leading-relaxed">
                            Platform manajemen laundry lengkap yang memungkinkan pemilik usaha mengelola <strong class="text-white/90">multi-outlet</strong>, karyawan tanpa batas, laporan keuangan real-time, hingga <strong class="text-white/90">notifikasi WhatsApp otomatis</strong> ke pelanggan — semua dalam satu dashboard yang elegan.
                        </p>
                    </div>

                    {{-- Feature list --}}
                    <ul class="space-y-2.5">
                        <li class="flex items-center gap-3 text-xs sm:text-sm text-white/75 group-hover:text-white/90 transition-colors">
                            <div class="w-5 h-5 rounded-full bg-sky-500/20 flex items-center justify-center flex-shrink-0 group-hover:bg-sky-500/40 transition-colors"><i class="fa-solid fa-check text-sky-400" style="font-size:8px;"></i></div>
                            Manajemen multi-outlet & karyawan unlimited
                        </li>
                        <li class="flex items-center gap-3 text-xs sm:text-sm text-white/75 group-hover:text-white/90 transition-colors">
                            <div class="w-5 h-5 rounded-full bg-sky-500/20 flex items-center justify-center flex-shrink-0 group-hover:bg-sky-500/40 transition-colors"><i class="fa-solid fa-check text-sky-400" style="font-size:8px;"></i></div>
                            Notifikasi WhatsApp otomatis ke pelanggan
                        </li>
                        <li class="flex items-center gap-3 text-xs sm:text-sm text-white/75 group-hover:text-white/90 transition-colors">
                            <div class="w-5 h-5 rounded-full bg-sky-500/20 flex items-center justify-center flex-shrink-0 group-hover:bg-sky-500/40 transition-colors"><i class="fa-solid fa-check text-sky-400" style="font-size:8px;"></i></div>
                            Laporan keuangan & pendapatan real-time
                        </li>
                        <li class="flex items-center gap-3 text-xs sm:text-sm text-white/75 group-hover:text-white/90 transition-colors">
                            <div class="w-5 h-5 rounded-full bg-sky-500/20 flex items-center justify-center flex-shrink-0 group-hover:bg-sky-500/40 transition-colors"><i class="fa-solid fa-check text-sky-400" style="font-size:8px;"></i></div>
                            PWA — bisa diinstall layaknya aplikasi native
                        </li>
                    </ul>

                    <div class="flex items-center gap-3 mt-1">
                        <a href="https://klaundry.scalifyintellegence.my.id/" target="_blank" rel="noopener" class="inline-flex items-center gap-2 bg-sky-500 hover:bg-sky-400 text-white text-xs sm:text-sm font-bold px-6 py-3 rounded-full transition-all hover:-translate-y-0.5 shadow-lg shadow-sky-500/25">
                            Lihat Demo Live <i class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i>
                        </a>
                        <a href="https://wa.me/6285221694067?text=Halo%20Scalify,%20saya%20tertarik%20dengan%20sistem%20seperti%20Klaundry" target="_blank" class="inline-flex items-center gap-2 border border-white/15 hover:border-white/30 text-white/70 hover:text-white text-xs sm:text-sm font-medium px-5 py-3 rounded-full transition-all">
                            Buat Serupa <i class="fa-solid fa-chevron-right text-[9px]"></i>
                        </a>
                    </div>
                </div>
            </div>

            {{-- Divider --}}
            <div class="border-t border-white/5 w-full"></div>

            {{-- ── PRODUCT 2: BUDGETIN ── --}}
            <div class="product-card group grid grid-cols-1 lg:grid-cols-2 gap-10 lg:gap-16 items-center opacity-0 translate-y-8 transition-all duration-700">

                {{-- Content Left --}}
                <div class="flex flex-col gap-5 text-left">
                    <div class="flex items-center gap-3 flex-wrap">
                        <span class="inline-flex items-center gap-1.5 bg-emerald-500/15 border border-emerald-400/25 text-emerald-300 text-[10px] font-bold px-3 py-1.5 rounded-full tracking-wider uppercase shadow-[0_0_10px_rgba(16,185,129,0.15)]">
                            <i class="fa-solid fa-wallet text-[9px]"></i> Fintech App
                        </span>
                        <span class="inline-flex items-center gap-1.5 bg-emerald-500/10 border border-emerald-400/20 text-emerald-400 text-[10px] font-bold px-3 py-1.5 rounded-full">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span> Live Production
                        </span>
                    </div>

                    <div>
                        <h3 class="font-sans font-bold text-2xl sm:text-3xl text-white mb-2 leading-tight group-hover:text-emerald-400 transition-colors duration-300">Budgetin</h3>
                        <p class="text-emerald-400 text-xs sm:text-sm font-medium mb-3">Aplikasi Manajemen Keuangan Pribadi & Bisnis</p>
                        <p class="text-white/65 text-xs sm:text-sm leading-relaxed">
                            Solusi manajemen keuangan personal yang membantu ribuan pengguna mencatat pemasukan & pengeluaran, mengalokasikan anggaran bulanan per kategori, dan memantau <strong class="text-white/90">kesehatan finansial secara real-time</strong> dalam satu dashboard yang intuitif.
                        </p>
                    </div>

                    <ul class="space-y-2.5">
                        <li class="flex items-center gap-3 text-xs sm:text-sm text-white/75 group-hover:text-white/90 transition-colors">
                            <div class="w-5 h-5 rounded-full bg-emerald-500/20 flex items-center justify-center flex-shrink-0 group-hover:bg-emerald-500/40 transition-colors"><i class="fa-solid fa-check text-emerald-400" style="font-size:8px;"></i></div>
                            Pencatatan transaksi harian otomatis & cepat
                        </li>
                        <li class="flex items-center gap-3 text-xs sm:text-sm text-white/75 group-hover:text-white/90 transition-colors">
                            <div class="w-5 h-5 rounded-full bg-emerald-500/20 flex items-center justify-center flex-shrink-0 group-hover:bg-emerald-500/40 transition-colors"><i class="fa-solid fa-check text-emerald-400" style="font-size:8px;"></i></div>
                            Alokasi budget per kategori yang fleksibel
                        </li>
                        <li class="flex items-center gap-3 text-xs sm:text-sm text-white/75 group-hover:text-white/90 transition-colors">
                            <div class="w-5 h-5 rounded-full bg-emerald-500/20 flex items-center justify-center flex-shrink-0 group-hover:bg-emerald-500/40 transition-colors"><i class="fa-solid fa-check text-emerald-400" style="font-size:8px;"></i></div>
                            Grafik analisis keuangan visual yang canggih
                        </li>
                        <li class="flex items-center gap-3 text-xs sm:text-sm text-white/75 group-hover:text-white/90 transition-colors">
                            <div class="w-5 h-5 rounded-full bg-emerald-500/20 flex items-center justify-center flex-shrink-0 group-hover:bg-emerald-500/40 transition-colors"><i class="fa-solid fa-check text-emerald-400" style="font-size:8px;"></i></div>
                            10K+ pengguna aktif, Rp 50M+ transaksi dicatat
                        </li>
                    </ul>

                    <div class="flex items-center gap-3 mt-1">
                        <a href="https://budgetin.scalifyintellegence.my.id/" target="_blank" rel="noopener" class="inline-flex items-center gap-2 bg-emerald-600 hover:bg-emerald-500 text-white text-xs sm:text-sm font-bold px-6 py-3 rounded-full transition-all hover:-translate-y-0.5 shadow-lg shadow-emerald-600/25">
                            Lihat Demo Live <i class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i>
                        </a>
                        <a href="https://wa.me/6285221694067?text=Halo%20Scalify,%20saya%20tertarik%20dengan%20sistem%20seperti%20Budgetin" target="_blank" class="inline-flex items-center gap-2 border border-white/15 hover:border-white/30 text-white/70 hover:text-white text-xs sm:text-sm font-medium px-5 py-3 rounded-full transition-all">
                            Buat Serupa <i class="fa-solid fa-chevron-right text-[9px]"></i>
                        </a>
                    </div>
                </div>

                {{-- Screenshot Right --}}
                <div class="relative">
                    <div class="absolute -inset-4 bg-gradient-to-br from-emerald-500/20 to-green-600/10 rounded-3xl blur-xl opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    <div class="relative rounded-2xl overflow-hidden border border-white/10 shadow-2xl shadow-emerald-900/20 group-hover:border-emerald-400/30 transition-colors duration-300">
                        <a href="https://budgetin.scalifyintellegence.my.id/" target="_blank" rel="noopener">
                            <img src="{{ asset('images/budgetin_mockup.webp') }}" alt="Budgetin - Aplikasi Manajemen Keuangan" class="w-full h-auto object-cover group-hover:scale-[1.02] transition-transform duration-500" loading="lazy" width="600" height="400">
                            <div class="absolute inset-0 bg-gradient-to-t from-brand-dark/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end justify-center pb-6">
                                <span class="inline-flex items-center gap-2 bg-emerald-600 text-white text-xs font-bold px-5 py-2 rounded-full shadow-lg">
                                    <i class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i> Buka Aplikasi Live
                                </span>
                            </div>
                        </a>
                    </div>
                    <div class="absolute -bottom-4 -left-4 bg-emerald-500/15 backdrop-blur-md border border-emerald-400/25 rounded-2xl px-4 py-3 shadow-xl group-hover:translate-y-[-5px] transition-transform duration-500">
                        <p class="text-emerald-300 text-[10px] font-semibold uppercase tracking-wider mb-0.5">Pengguna Aktif</p>
                        <p class="text-white font-bold text-sm">10.000+ Users</p>
                    </div>
                </div>
            </div>

            {{-- Divider --}}
            <div class="border-t border-white/5 w-full"></div>

            {{-- ── PRODUCT 3: OMNISCALE AI ── --}}
            <div class="product-card group grid grid-cols-1 lg:grid-cols-2 gap-10 lg:gap-16 items-center opacity-0 translate-y-8 transition-all duration-700">

                {{-- Screenshot Left --}}
                <div class="relative order-2 lg:order-1">
                    <div class="absolute -inset-4 bg-gradient-to-br from-violet-500/20 to-purple-600/10 rounded-3xl blur-xl opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    <div class="relative rounded-2xl overflow-hidden border border-white/10 shadow-2xl shadow-violet-900/30 group-hover:border-violet-400/30 transition-colors duration-300">
                        <a href="https://omniscale-ai.scalifyintellegence.my.id/" target="_blank" rel="noopener">
                            <img src="{{ asset('images/omniscale_mockup.webp') }}" alt="OmniScale AI - Platform Integrasi WhatsApp AI Agent" class="w-full h-auto object-cover group-hover:scale-[1.02] transition-transform duration-500" loading="lazy" width="600" height="400">
                            <div class="absolute inset-0 bg-gradient-to-t from-brand-dark/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end justify-center pb-6">
                                <span class="inline-flex items-center gap-2 bg-violet-600 text-white text-xs font-bold px-5 py-2 rounded-full shadow-lg">
                                    <i class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i> Buka Aplikasi Live
                                </span>
                            </div>
                        </a>
                    </div>
                    <div class="absolute -bottom-4 -right-4 bg-violet-500/15 backdrop-blur-md border border-violet-400/25 rounded-2xl px-4 py-3 shadow-xl group-hover:translate-y-[-5px] transition-transform duration-500">
                        <p class="text-violet-300 text-[10px] font-semibold uppercase tracking-wider mb-0.5">Teknologi</p>
                        <p class="text-white font-bold text-sm">RAG + AI Agent</p>
                    </div>
                </div>

                {{-- Content Right --}}
                <div class="order-1 lg:order-2 flex flex-col gap-5 text-left">
                    <div class="flex items-center gap-3 flex-wrap">
                        <span class="inline-flex items-center gap-1.5 bg-violet-500/15 border border-violet-400/25 text-violet-300 text-[10px] font-bold px-3 py-1.5 rounded-full tracking-wider uppercase shadow-[0_0_10px_rgba(139,92,246,0.15)]">
                            <i class="fa-solid fa-robot text-[9px]"></i> AI Integration
                        </span>
                        <span class="inline-flex items-center gap-1.5 bg-emerald-500/10 border border-emerald-400/20 text-emerald-400 text-[10px] font-bold px-3 py-1.5 rounded-full">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span> Live Production
                        </span>
                    </div>

                    <div>
                        <h3 class="font-sans font-bold text-2xl sm:text-3xl text-white mb-2 leading-tight group-hover:text-violet-400 transition-colors duration-300">OmniScale AI</h3>
                        <p class="text-violet-400 text-xs sm:text-sm font-medium mb-3">Platform Integrasi WhatsApp AI Agent Berbasis RAG</p>
                        <p class="text-white/65 text-xs sm:text-sm leading-relaxed">
                            Terobosan nyata: AI agent yang terhubung langsung ke WhatsApp bisnis Anda. Sistem ini <strong class="text-white/90">membaca, memahami, dan membalas chat pelanggan secara otomatis</strong> berdasarkan knowledge base dokumen perusahaan — bukan tebakan, tapi pemahaman AI yang presisi dengan teknologi Multi-Tenant RAG.
                        </p>
                    </div>

                    <ul class="space-y-2.5">
                        <li class="flex items-center gap-3 text-xs sm:text-sm text-white/75 group-hover:text-white/90 transition-colors">
                            <div class="w-5 h-5 rounded-full bg-violet-500/20 flex items-center justify-center flex-shrink-0 group-hover:bg-violet-500/40 transition-colors"><i class="fa-solid fa-check text-violet-400" style="font-size:8px;"></i></div>
                            WhatsApp AI Bot terhubung knowledge base dokumen
                        </li>
                        <li class="flex items-center gap-3 text-xs sm:text-sm text-white/75 group-hover:text-white/90 transition-colors">
                            <div class="w-5 h-5 rounded-full bg-violet-500/20 flex items-center justify-center flex-shrink-0 group-hover:bg-violet-500/40 transition-colors"><i class="fa-solid fa-check text-violet-400" style="font-size:8px;"></i></div>
                            Multi-tenant: satu platform, banyak bisnis
                        </li>
                        <li class="flex items-center gap-3 text-xs sm:text-sm text-white/75 group-hover:text-white/90 transition-colors">
                            <div class="w-5 h-5 rounded-full bg-violet-500/20 flex items-center justify-center flex-shrink-0 group-hover:bg-violet-500/40 transition-colors"><i class="fa-solid fa-check text-violet-400" style="font-size:8px;"></i></div>
                            Deploy chatbot AI dalam hitungan menit
                        </li>
                        <li class="flex items-center gap-3 text-xs sm:text-sm text-white/75 group-hover:text-white/90 transition-colors">
                            <div class="w-5 h-5 rounded-full bg-violet-500/20 flex items-center justify-center flex-shrink-0 group-hover:bg-violet-500/40 transition-colors"><i class="fa-solid fa-check text-violet-400" style="font-size:8px;"></i></div>
                            Balas CS, sales, support — 24/7 tanpa human agent
                        </li>
                    </ul>

                    <div class="flex items-center gap-3 mt-1">
                        <a href="https://omniscale-ai.scalifyintellegence.my.id/" target="_blank" rel="noopener" class="inline-flex items-center gap-2 bg-violet-600 hover:bg-violet-500 text-white text-xs sm:text-sm font-bold px-6 py-3 rounded-full transition-all hover:-translate-y-0.5 shadow-lg shadow-violet-600/30">
                            Lihat Demo Live <i class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i>
                        </a>
                        <a href="https://wa.me/6285221694067?text=Halo%20Scalify,%20saya%20tertarik%20dengan%20integrasi%20WhatsApp%20AI%20seperti%20OmniScale" target="_blank" class="inline-flex items-center gap-2 border border-white/15 hover:border-white/30 text-white/70 hover:text-white text-xs sm:text-sm font-medium px-5 py-3 rounded-full transition-all">
                            Mau AI Ini <i class="fa-solid fa-chevron-right text-[9px]"></i>
                        </a>
                    </div>
                </div>
            </div>

            {{-- Divider --}}
            <div class="border-t border-white/5 w-full"></div>

            {{-- ── PRODUCT 4: RIVIAN COLLECTION ── --}}
            <div class="product-card group grid grid-cols-1 lg:grid-cols-2 gap-10 lg:gap-16 items-center opacity-0 translate-y-8 transition-all duration-700">

                {{-- Content Left --}}
                <div class="flex flex-col gap-5 text-left">
                    <div class="flex items-center gap-3 flex-wrap">
                        <span class="inline-flex items-center gap-1.5 bg-amber-500/15 border border-amber-400/25 text-amber-300 text-[10px] font-bold px-3 py-1.5 rounded-full tracking-wider uppercase shadow-[0_0_10px_rgba(245,158,11,0.15)]">
                            <i class="fa-solid fa-shirt text-[9px]"></i> Company Profile
                        </span>
                        <span class="inline-flex items-center gap-1.5 bg-emerald-500/10 border border-emerald-400/20 text-emerald-400 text-[10px] font-bold px-3 py-1.5 rounded-full">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span> Live Production
                        </span>
                    </div>

                    <div>
                        <h3 class="font-sans font-bold text-2xl sm:text-3xl text-white mb-2 leading-tight group-hover:text-amber-400 transition-colors duration-300">Rivian Collection</h3>
                        <p class="text-amber-400 text-xs sm:text-sm font-medium mb-3">Platform Konveksi & Garment Profesional</p>
                        <p class="text-white/65 text-xs sm:text-sm leading-relaxed">
                            Website representasi bisnis elegan untuk industri konveksi dan garment. Dirancang khusus untuk memamerkan portofolio busana berkualitas tinggi, meyakinkan calon mitra, dan <strong class="text-white/90">meningkatkan konversi pemesanan B2B & B2C</strong> dengan antarmuka premium yang dinamis.
                        </p>
                    </div>

                    <ul class="space-y-2.5">
                        <li class="flex items-center gap-3 text-xs sm:text-sm text-white/75 group-hover:text-white/90 transition-colors">
                            <div class="w-5 h-5 rounded-full bg-amber-500/20 flex items-center justify-center flex-shrink-0 group-hover:bg-amber-500/40 transition-colors"><i class="fa-solid fa-check text-amber-400" style="font-size:8px;"></i></div>
                            Desain eksklusif bernuansa gold & dark premium
                        </li>
                        <li class="flex items-center gap-3 text-xs sm:text-sm text-white/75 group-hover:text-white/90 transition-colors">
                            <div class="w-5 h-5 rounded-full bg-amber-500/20 flex items-center justify-center flex-shrink-0 group-hover:bg-amber-500/40 transition-colors"><i class="fa-solid fa-check text-amber-400" style="font-size:8px;"></i></div>
                            Katalog portofolio interaktif yang memukau
                        </li>
                        <li class="flex items-center gap-3 text-xs sm:text-sm text-white/75 group-hover:text-white/90 transition-colors">
                            <div class="w-5 h-5 rounded-full bg-amber-500/20 flex items-center justify-center flex-shrink-0 group-hover:bg-amber-500/40 transition-colors"><i class="fa-solid fa-check text-amber-400" style="font-size:8px;"></i></div>
                            Sistem pesanan & integrasi kontak langsung
                        </li>
                        <li class="flex items-center gap-3 text-xs sm:text-sm text-white/75 group-hover:text-white/90 transition-colors">
                            <div class="w-5 h-5 rounded-full bg-amber-500/20 flex items-center justify-center flex-shrink-0 group-hover:bg-amber-500/40 transition-colors"><i class="fa-solid fa-check text-amber-400" style="font-size:8px;"></i></div>
                            SEO Optimized untuk menjangkau klien lebih luas
                        </li>
                    </ul>

                    <div class="flex items-center gap-3 mt-1">
                        <a href="https://rivian-collection.scalifyintellegence.my.id/" target="_blank" rel="noopener" class="inline-flex items-center gap-2 bg-amber-600 hover:bg-amber-500 text-white text-xs sm:text-sm font-bold px-6 py-3 rounded-full transition-all hover:-translate-y-0.5 shadow-lg shadow-amber-600/30">
                            Lihat Demo Live <i class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i>
                        </a>
                        <a href="https://wa.me/6285221694067?text=Halo%20Scalify,%20saya%20tertarik%20dengan%20sistem%20seperti%20Rivian%20Collection" target="_blank" class="inline-flex items-center gap-2 border border-white/15 hover:border-white/30 text-white/70 hover:text-white text-xs sm:text-sm font-medium px-5 py-3 rounded-full transition-all">
                            Buat Serupa <i class="fa-solid fa-chevron-right text-[9px]"></i>
                        </a>
                    </div>
                </div>

                {{-- Screenshot Right --}}
                <div class="relative">
                    <div class="absolute -inset-4 bg-gradient-to-br from-amber-500/20 to-orange-600/10 rounded-3xl blur-xl opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    <div class="relative rounded-2xl overflow-hidden border border-white/10 shadow-2xl shadow-amber-900/20 group-hover:border-amber-400/30 transition-colors duration-300">
                        <a href="https://rivian-collection.scalifyintellegence.my.id/" target="_blank" rel="noopener">
                            <img src="{{ asset('images/rivian_mockup.webp') }}" alt="Rivian Collection - Platform Konveksi & Garment" class="w-full h-auto object-cover group-hover:scale-[1.02] transition-transform duration-500" loading="lazy" width="600" height="400" onerror="this.src='https://images.unsplash.com/photo-1558769132-cb1aea458c5e?q=80&w=600&auto=format&fit=crop'">
                            <div class="absolute inset-0 bg-gradient-to-t from-brand-dark/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end justify-center pb-6">
                                <span class="inline-flex items-center gap-2 bg-amber-600 text-white text-xs font-bold px-5 py-2 rounded-full shadow-lg">
                                    <i class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i> Buka Aplikasi Live
                                </span>
                            </div>
                        </a>
                    </div>
                    <div class="absolute -bottom-4 -left-4 bg-amber-500/15 backdrop-blur-md border border-amber-400/25 rounded-2xl px-4 py-3 shadow-xl group-hover:translate-y-[-5px] transition-transform duration-500">
                        <p class="text-amber-300 text-[10px] font-semibold uppercase tracking-wider mb-0.5">Kategori Bisnis</p>
                        <p class="text-white font-bold text-sm">B2B Portfolio</p>
                    </div>
                </div>
            </div>

        </div>

        {{-- Bottom trust strip --}}
        <div class="mt-20 grid grid-cols-1 sm:grid-cols-3 gap-5">
            <div class="bg-white/[0.04] border border-white/8 rounded-2xl p-6 text-center hover:border-brand-accent/25 transition-colors duration-300 hover:bg-white/[0.06]">
                <div class="text-3xl font-bold text-white mb-1 group-hover:text-brand-accent transition-colors">4</div>
                <div class="text-white/50 text-xs">Produk Digital Live & Berjalan</div>
            </div>
            <div class="bg-white/[0.04] border border-white/8 rounded-2xl p-6 text-center hover:border-brand-accent/25 transition-colors duration-300 hover:bg-white/[0.06]">
                <div class="text-3xl font-bold text-white mb-1">100%</div>
                <div class="text-white/50 text-xs">Dibangun In-House oleh Tim Scalify</div>
            </div>
            <div class="bg-white/[0.04] border border-white/8 rounded-2xl p-6 text-center hover:border-brand-accent/25 transition-colors duration-300 hover:bg-white/[0.06]">
                <div class="text-3xl font-bold text-white mb-1">24/7</div>
                <div class="text-white/50 text-xs">Uptime di Server Produksi VPS</div>
            </div>
        </div>
    </div>

    {{-- Scroll-reveal script --}}
    <script>
        (function() {
            var cards = document.querySelectorAll('.product-card');
            if (!cards.length) return;
            var observer = new IntersectionObserver(function(entries) {
                entries.forEach(function(entry) {
                    if (entry.isIntersecting) {
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'translateY(0)';
                        observer.unobserve(entry.target);
                    }
                });
            }, {
                threshold: 0.12
            });
            cards.forEach(function(card, i) {
                card.style.transitionDelay = (i * 120) + 'ms';
                observer.observe(card);
            });
        })();
    </script>
</section>
