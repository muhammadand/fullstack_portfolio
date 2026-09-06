{{-- ══════════════════════════════════════════════════
     PRICING & SERVICE PACKAGES SECTION (MIDNIGHT BLUE & GLASS)
══════════════════════════════════════════════════ --}}
<section id="layanan" class="bg-brand-dark py-16 sm:py-24 px-4 sm:px-6 lg:px-8 border-t border-white/5 relative z-20 overflow-hidden">
    <!-- Ambient Glass Glow Accents -->
    <div class="absolute top-1/3 left-1/2 -translate-x-1/2 w-[700px] h-[400px] bg-blue-600/15 blur-[140px] rounded-full pointer-events-none"></div>
    <div class="absolute -top-12 -left-20 w-80 h-80 bg-indigo-600/10 blur-[100px] rounded-full pointer-events-none"></div>
    <div class="absolute -bottom-12 -right-20 w-80 h-80 bg-cyan-500/10 blur-[100px] rounded-full pointer-events-none"></div>

    <div class="max-w-7xl mx-auto relative z-10">
        <div class="text-center mb-16">
            <div class="mb-3">
                <span class="text-brand-accent font-extrabold text-[11px] sm:text-xs tracking-[0.25em] uppercase bg-brand-accent/10 border border-brand-accent/25 px-4 py-1.5 rounded-full backdrop-blur-md inline-block">
                    PILIHAN PAKET INVESTASI
                </span>
            </div>
            <h2 class="font-sans font-black text-3xl sm:text-4xl md:text-5xl text-white mb-4 leading-tight tracking-tight">
                Paket Layanan Pembuatan Website
            </h2>
            <p class="text-white/60 text-center max-w-2xl mx-auto text-xs sm:text-sm font-normal leading-relaxed">
                Pilih solusi pembuatan website & automasi cerdas yang paling sesuai dengan skala dan target akselerasi bisnis Anda saat ini.
            </p>
        </div>

        <!-- 4 Package Cards (Midnight Blue & Glass Grid) -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 items-stretch">

            {{-- 1. Paket Silver --}}
            <div class="bg-white/[0.04] backdrop-blur-xl border border-white/10 hover:border-white/20 rounded-3xl p-6 sm:p-7 flex flex-col justify-between text-white shadow-card hover:bg-white/[0.06] transition-all duration-300 group">
                <div>
                    <div class="w-14 h-14 rounded-2xl bg-white/5 border border-white/10 group-hover:border-brand-accent/30 backdrop-blur-md flex items-center justify-center text-brand-accent text-2xl mb-4 mx-auto shadow-inner transition">
                        <i class="fas fa-award"></i>
                    </div>
                    <h3 class="text-center font-bold text-2xl text-white mb-2">Paket Silver</h3>
                    <p class="text-center text-xs text-white/60 leading-relaxed min-h-[48px]">
                        Paket ini cocok untuk Anda yang baru memulai bisnis dan membutuhkan website sederhana yang praktis.
                    </p>

                    <div class="my-5 py-2 px-5 rounded-full border border-white/20 bg-white/5 backdrop-blur-md text-center font-extrabold text-xs tracking-wider mx-auto w-max text-white">
                        IDR. 700K
                    </div>
                </div>

                <div>
                    <button type="button" onclick="openCompanyPricingModal('silver')" class="w-full py-2.5 px-4 rounded-xl bg-white/10 hover:bg-white/20 border border-white/15 text-white text-xs font-semibold backdrop-blur-md shadow-sm transition mb-3 cursor-pointer">
                        Detail Paket
                    </button>
                    <p class="text-center text-xs text-white/50 mb-4 font-medium">
                        Perpanjangan 500rb/tahun
                    </p>
                    <a href="https://wa.me/6285221694067?text=Halo%20Scalify,%20saya%20tertarik%20untuk%20memesan%20Paket%20Silver." target="_blank" class="w-full py-3.5 px-4 rounded-xl bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-500 hover:to-indigo-500 text-white text-xs sm:text-sm font-bold flex items-center justify-center gap-2 shadow-glow-sm hover:shadow-glow-blue transition-all hover:scale-[1.02]">
                        <i class="fab fa-whatsapp text-base text-green-400"></i> Book Now
                    </a>
                </div>
            </div>

            {{-- 2. Paket Gold (Featured / Populer) --}}
            <div class="relative bg-gradient-to-b from-blue-600/30 via-indigo-600/20 to-[#0A0E2A]/70 border-2 border-brand-accent/80 rounded-3xl p-6 sm:p-7 flex flex-col justify-between text-white shadow-glow-blue backdrop-blur-2xl transform lg:-translate-y-2 hover:border-brand-accent transition-all duration-300">
                <div class="absolute -top-3.5 left-1/2 -translate-x-1/2 bg-gradient-to-r from-amber-400 to-amber-500 text-slate-950 text-[10px] font-black uppercase tracking-widest px-4 py-1 rounded-full shadow-lg border border-amber-300/40">
                    POPULER
                </div>
                <div>
                    <div class="w-14 h-14 rounded-2xl bg-brand-accent/20 border border-brand-accent/40 backdrop-blur-md flex items-center justify-center text-brand-accent text-2xl mb-4 mx-auto shadow-inner">
                        <i class="fas fa-award"></i>
                    </div>
                    <h3 class="text-center font-bold text-2xl text-white mb-2">Paket Gold</h3>
                    <p class="text-center text-xs text-blue-100/80 leading-relaxed min-h-[48px]">
                        Paket ini ideal untuk Anda yang membutuhkan website dengan fitur lengkap seperti e-commerce, blog, dan lainnya.
                    </p>

                    <div class="my-5 py-2 px-5 rounded-full border-2 border-brand-accent/60 bg-brand-accent/15 backdrop-blur-md text-center font-extrabold text-xs tracking-wider mx-auto w-max text-brand-accent shadow-sm">
                        IDR 1,6JUTA
                    </div>
                </div>

                <div>
                    <button type="button" onclick="openCompanyPricingModal('gold')" class="w-full py-2.5 px-4 rounded-xl bg-brand-accent/20 hover:bg-brand-accent/30 border border-brand-accent/50 text-white text-xs font-bold backdrop-blur-md shadow-sm transition mb-3 cursor-pointer">
                        Detail Paket
                    </button>
                    <p class="text-center text-xs text-brand-accent/90 mb-4 font-medium">
                        Perpanjangan 600rb/tahun
                    </p>
                    <a href="https://wa.me/6285221694067?text=Halo%20Scalify,%20saya%20tertarik%20untuk%20memesan%20Paket%20Gold." target="_blank" class="w-full py-3.5 px-4 rounded-xl bg-btn-gradient hover:opacity-95 text-white text-xs sm:text-sm font-bold flex items-center justify-center gap-2 shadow-glow-blue transition-all hover:scale-[1.02] border border-white/20">
                        <i class="fab fa-whatsapp text-base text-green-400"></i> Book Now
                    </a>
                </div>
            </div>

            {{-- 3. Paket Diamond --}}
            <div class="bg-white/[0.04] backdrop-blur-xl border border-white/10 hover:border-white/20 rounded-3xl p-6 sm:p-7 flex flex-col justify-between text-white shadow-card hover:bg-white/[0.06] transition-all duration-300 group">
                <div>
                    <div class="w-14 h-14 rounded-2xl bg-white/5 border border-white/10 group-hover:border-brand-accent/30 backdrop-blur-md flex items-center justify-center text-brand-accent text-2xl mb-4 mx-auto shadow-inner transition">
                        <i class="fas fa-award"></i>
                    </div>
                    <h3 class="text-center font-bold text-2xl text-white mb-2">Paket Diamond</h3>
                    <p class="text-center text-xs text-white/60 leading-relaxed min-h-[48px]">
                        Paket ini cocok untuk Anda yang membutuhkan website profil bisnis untuk meningkatkan kehadiran online.
                    </p>

                    <div class="my-5 py-2 px-5 rounded-full border border-white/20 bg-white/5 backdrop-blur-md text-center font-extrabold text-xs tracking-wider mx-auto w-max text-white">
                        IDR. 2JUTA
                    </div>
                </div>

                <div>
                    <button type="button" onclick="openCompanyPricingModal('diamond')" class="w-full py-2.5 px-4 rounded-xl bg-white/10 hover:bg-white/20 border border-white/15 text-white text-xs font-semibold backdrop-blur-md shadow-sm transition mb-3 cursor-pointer">
                        Detail Paket
                    </button>
                    <p class="text-center text-xs text-white/50 mb-4 font-medium">
                        Perpanjangan 1juta/tahun
                    </p>
                    <a href="https://wa.me/6285221694067?text=Halo%20Scalify,%20saya%20tertarik%20untuk%20memesan%20Paket%20Diamond." target="_blank" class="w-full py-3.5 px-4 rounded-xl bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-500 hover:to-indigo-500 text-white text-xs sm:text-sm font-bold flex items-center justify-center gap-2 shadow-glow-sm hover:shadow-glow-blue transition-all hover:scale-[1.02]">
                        <i class="fab fa-whatsapp text-base text-green-400"></i> Book Now
                    </a>
                </div>
            </div>

            {{-- 4. Paket Platinum --}}
            <div class="bg-white/[0.04] backdrop-blur-xl border border-white/10 hover:border-white/20 rounded-3xl p-6 sm:p-7 flex flex-col justify-between text-white shadow-card hover:bg-white/[0.06] transition-all duration-300 group">
                <div>
                    <div class="w-14 h-14 rounded-2xl bg-white/5 border border-white/10 group-hover:border-brand-accent/30 backdrop-blur-md flex items-center justify-center text-brand-accent text-2xl mb-4 mx-auto shadow-inner transition">
                        <i class="fas fa-award"></i>
                    </div>
                    <h3 class="text-center font-bold text-2xl text-white mb-2">Paket Platinum</h3>
                    <p class="text-center text-xs text-white/60 leading-relaxed min-h-[48px]">
                        Paket ini ideal untuk Anda yang membutuhkan website dengan fitur kompleks dan desain yang unik serta menarik.
                    </p>

                    <div class="my-5 py-2 px-5 rounded-full border border-white/20 bg-white/5 backdrop-blur-md text-center font-extrabold text-xs tracking-wider mx-auto w-max text-white">
                        IDR. 3JUTA
                    </div>
                </div>

                <div>
                    <button type="button" onclick="openCompanyPricingModal('platinum')" class="w-full py-2.5 px-4 rounded-xl bg-white/10 hover:bg-white/20 border border-white/15 text-white text-xs font-semibold backdrop-blur-md shadow-sm transition mb-3 cursor-pointer">
                        Detail Paket
                    </button>
                    <p class="text-center text-xs text-white/50 mb-4 font-medium">
                        Perpanjangan 50% per tahun
                    </p>
                    <a href="https://wa.me/6285221694067?text=Halo%20Scalify,%20saya%20tertarik%20untuk%20memesan%20Paket%20Platinum." target="_blank" class="w-full py-3.5 px-4 rounded-xl bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-500 hover:to-indigo-500 text-white text-xs sm:text-sm font-bold flex items-center justify-center gap-2 shadow-glow-sm hover:shadow-glow-blue transition-all hover:scale-[1.02]">
                        <i class="fab fa-whatsapp text-base text-green-400"></i> Book Now
                    </a>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- Modal Detail Paket Layanan Website (Midnight Glassmorphism) -->
<div id="companyPricingModal" class="fixed inset-0 bg-[#060919]/80 z-50 hidden items-center justify-center p-4 backdrop-blur-md">
    <div class="bg-[#0D1240]/95 backdrop-blur-2xl border border-white/15 text-white rounded-3xl max-w-lg w-full p-6 sm:p-8 shadow-2xl relative animate-fade-in">
        <button onclick="closeCompanyPricingModal()" class="absolute top-5 right-5 w-9 h-9 rounded-full bg-white/10 hover:bg-white/20 text-white/70 hover:text-white flex items-center justify-center transition cursor-pointer">
            <i class="fas fa-times"></i>
        </button>

        <div class="flex items-center gap-3.5 mb-5">
            <div id="cpModalIcon" class="w-12 h-12 rounded-2xl bg-brand-accent/20 border border-brand-accent/30 text-brand-accent flex items-center justify-center text-xl shadow-inner">
                <i class="fas fa-award"></i>
            </div>
            <div>
                <h3 id="cpModalTitle" class="text-xl font-bold text-white font-sans">Detail Paket</h3>
                <p id="cpModalPrice" class="text-xs font-bold text-brand-accent mt-0.5"></p>
            </div>
        </div>

        <p id="cpModalDesc" class="text-xs text-white/70 mb-5 bg-white/5 p-4 rounded-2xl border border-white/10 leading-relaxed"></p>

        <div class="mb-6">
            <h4 class="text-xs font-bold uppercase tracking-wider text-brand-accent mb-3">Fasilitas & Fitur Termasuk:</h4>
            <ul id="cpModalFeatures" class="space-y-2.5 text-xs text-white/80">
                <!-- Dynamic List -->
            </ul>
        </div>

        <div class="flex gap-3 pt-3 border-t border-white/10">
            <button type="button" onclick="closeCompanyPricingModal()" class="flex-1 py-3 px-4 rounded-xl border border-white/15 bg-white/5 hover:bg-white/10 text-white/80 text-xs font-semibold transition cursor-pointer">
                Tutup
            </button>
            <a id="cpModalWaBtn" href="#" target="_blank" class="flex-1 py-3 px-4 rounded-xl bg-btn-gradient hover:opacity-95 text-white text-xs font-bold flex items-center justify-center gap-2 shadow-glow-blue transition">
                <i class="fab fa-whatsapp text-base text-green-400"></i> Pilih Paket Ini
            </a>
        </div>
    </div>
</div>

<script>
    const companyPackageDetails = {
        silver: {
            title: 'Paket Silver'
            , price: 'IDR. 700K (Perpanjangan 500rb/tahun)'
            , desc: 'Paket ini cocok untuk Anda yang baru memulai bisnis dan membutuhkan website sederhana yang praktis.'
            , features: [
                'Landing Page Sales & Brosur Online Konversi Tinggi (One-Page)'
                , 'Desain 100% Responsif & Mobile-First yang Cepat'
                , 'Katalog Produk / Portofolio Layanan Standar'
                , 'Integrasi Tombol WhatsApp Konsultasi Cepat'
                , 'Free Domain Resmi (.com / .id) + Cloud Server 1 Tahun'
                , 'Garansi & Pemeliharaan Awal 1 Bulan'
            ]
        }
        , gold: {
            title: 'Paket Gold (Paling Diminati)'
            , price: 'IDR 1,6JUTA (Perpanjangan 600rb/tahun)'
            , desc: 'Paket ini ideal untuk Anda yang membutuhkan website dengan fitur lengkap seperti e-commerce, blog, dan lainnya.'
            , features: [
                'Website Multi-Page Modern & Dynamic CMS Panel Admin'
                , 'Kelola Mandiri: Update Produk, Artikel Blog, Galeri & Harga'
                , 'Sistem Toko Online / Katalog Interaktif & Keranjang Belanja'
                , 'Integrasi WhatsApp Notifikasi Otomatis'
                , 'Optimasi SEO Basic Google & Setup Google Search Console'
                , 'Free Domain (.com) + High-Speed SSD Cloud Server 1 Tahun + SSL'
                , 'Garansi & Support Teknis 3 Bulan'
            ]
        }
        , diamond: {
            title: 'Paket Diamond'
            , price: 'IDR. 2JUTA (Perpanjangan 1juta/tahun)'
            , desc: 'Paket ini cocok untuk Anda yang membutuhkan website profil bisnis untuk meningkatkan kehadiran online.'
            , features: [
                'Semua Fitur Unggulan Paket Gold'
                , 'Sistem Web App Kustom (Booking / Reservasi / Portal Klien)'
                , 'Payment Gateway Otomatis (QRIS, VA Bank & E-Wallet)'
                , 'Sistem Member Area / Loyalty Reward & Voucher Promo'
                , 'SEO On-Page & Local Business Maps Optimization'
                , 'Backup Otomatis Berkala & Proteksi Keamanan SSL Tingkat Lanjut'
                , 'Garansi & Maintenance Prioritas 6 Bulan'
            ]
        }
        , platinum: {
            title: 'Paket Platinum (Enterprise Solution)'
            , price: 'IDR. 3JUTA (Perpanjangan 50% per tahun)'
            , desc: 'Paket ini ideal untuk Anda yang membutuhkan website dengan fitur kompleks dan desain yang unik serta menarik.'
            , features: [
                'Semua Fitur Lengkap Paket Diamond'
                , 'Arsitektur Web App Kompleks & AI Agent / Chatbot Automation'
                , 'Integrasi Kasir (POS) Cloud / Multi-Cabang Terpusat'
                , 'Desain Ultra-Premium 100% Kustom sesuai Permintaan Brand'
                , 'Dedicated VPS Cloud Server Performa Tinggi & Skalabilitas Besar'
                , 'Priority Dedicated Support 24/7 & Garansi 1 Tahun Penuh'
            ]
        }
    };

    function openCompanyPricingModal(type) {
        const data = companyPackageDetails[type];
        if (!data) return;

        document.getElementById('cpModalTitle').textContent = data.title;
        document.getElementById('cpModalPrice').textContent = data.price;
        document.getElementById('cpModalDesc').textContent = data.desc;

        const list = document.getElementById('cpModalFeatures');
        list.innerHTML = '';
        data.features.forEach(feat => {
            const li = document.createElement('li');
            li.className = 'flex items-start gap-2.5';
            li.innerHTML = '<i class="fas fa-check-circle text-brand-accent mt-0.5 shrink-0"></i> <span>' + feat + '</span>';
            list.appendChild(li);
        });

        const waText = encodeURIComponent('Halo Scalify, saya tertarik untuk berkonsultasi mengenai ' + data.title + '. Mohon info detailnya.');
        document.getElementById('cpModalWaBtn').href = 'https://wa.me/6285221694067?text=' + waText;

        const modal = document.getElementById('companyPricingModal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closeCompanyPricingModal() {
        const modal = document.getElementById('companyPricingModal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }

    window.addEventListener('click', function(event) {
        const modal = document.getElementById('companyPricingModal');
        if (event.target === modal) {
            closeCompanyPricingModal();
        }
    });

</script>
