    <!-- FOOTER -->
    <footer class="bg-[#080D1A] text-white pt-16 pb-12 px-6 border-t border-white/10">
        <div class="max-w-7xl mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10 lg:gap-12 mb-12">
                {{-- Col 1: Brand & Bio --}}
                <div>
                    <div class="flex items-center gap-2.5 mb-4">
                        <div class="w-9 h-9 overflow-hidden rounded-lg shadow-glow-sm border border-white/15 bg-white/5">
                            <img src="{{ asset('scalify.png') }}" alt="Scalify Intelligence Logo" class="w-full h-full object-cover">
                        </div>
                        <span class="font-display font-bold text-xl tracking-tight text-white">
                            Scalify<span class="text-brand-accent"> Intelligence</span>
                        </span>
                    </div>
                    <p class="text-slate-400 text-sm leading-relaxed mb-4">
                        Agency Digital Pembuatan Website No. 1 di Indonesia. Menghadirkan website modern berkonversi tinggi, landing page cepat, dan sistem automasi bisnis cerdas.
                    </p>
                    <p class="text-slate-500 text-xs italic">"Building high-performance digital presence with purpose & heart."</p>
                </div>

                {{-- Col 2: Layanan --}}
                <div>
                    <p class="font-bold text-white text-sm uppercase tracking-wider mb-4 border-l-2 border-brand-accent pl-2.5">Layanan Pembuatan Web</p>
                    <ul class="space-y-2.5 text-slate-400 text-sm">
                        <li><a href="{{ route('index.company.profile') }}#layanan" class="hover:text-brand-accent transition flex items-center gap-2"><i class="fa-solid fa-angle-right text-xs text-brand-accent/60"></i> Website Company Profile</a></li>
                        <li><a href="{{ route('index.company.profile') }}#layanan" class="hover:text-brand-accent transition flex items-center gap-2"><i class="fa-solid fa-angle-right text-xs text-brand-accent/60"></i> Landing Page Promosi / Sales</a></li>
                        <li><a href="{{ route('index.company.profile') }}#layanan" class="hover:text-brand-accent transition flex items-center gap-2"><i class="fa-solid fa-angle-right text-xs text-brand-accent/60"></i> Toko Online & E-Commerce</a></li>
                        <li><a href="{{ route('index.company.profile') }}#produk-live" class="hover:text-brand-accent transition flex items-center gap-2"><i class="fa-solid fa-angle-right text-xs text-brand-accent/60"></i> Web App & SaaS Kustom</a></li>
                        <li><a href="{{ route('landing.blogs') }}" class="hover:text-brand-accent transition flex items-center gap-2"><i class="fa-solid fa-angle-right text-xs text-brand-accent/60"></i> Optimasi SEO & Speed Web</a></li>
                    </ul>
                </div>

                {{-- Col 3: Program & Karir --}}
                <div>
                    <p class="font-bold text-white text-sm uppercase tracking-wider mb-4 border-l-2 border-amber-500 pl-2.5">Program & Karir</p>
                    <ul class="space-y-2.5 text-slate-400 text-sm">
                        <li>
                            <a href="{{ route('sobat-scalify') }}" class="hover:text-amber-400 transition flex items-center justify-between group">
                                <span class="flex items-center gap-2"><i class="fa-solid fa-handshake text-amber-400 text-xs"></i> Sobat Scalify (Partner)</span>
                                <span class="px-1.5 py-0.5 bg-amber-500/20 text-amber-300 text-[10px] font-bold rounded-full border border-amber-500/30">Cuan</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('landing.careers') }}" class="hover:text-emerald-400 transition flex items-center justify-between group">
                                <span class="flex items-center gap-2"><i class="fa-solid fa-briefcase text-emerald-400 text-xs"></i> Karir & Lowongan</span>
                                <span class="px-1.5 py-0.5 bg-emerald-500/20 text-emerald-300 text-[10px] font-bold rounded-full border border-emerald-500/30">Hiring</span>
                            </a>
                        </li>
                        <li><a href="{{ route('landing.portfolio') }}" class="hover:text-brand-accent transition flex items-center gap-2"><i class="fa-solid fa-angle-right text-xs text-brand-accent/60"></i> Portofolio Klien</a></li>
                        <li><a href="{{ route('landing.blogs') }}" class="hover:text-brand-accent transition flex items-center gap-2"><i class="fa-solid fa-angle-right text-xs text-brand-accent/60"></i> Blog & Insight Bisnis</a></li>
                        <li><a href="{{ route('index.company.profile') }}#ownerprofile" class="hover:text-brand-accent transition flex items-center gap-2"><i class="fa-solid fa-angle-right text-xs text-brand-accent/60"></i> Tentang Kami & Founder</a></li>
                    </ul>
                </div>

                {{-- Col 4: Kontak & Konsultasi --}}
                <div>
                    <p class="font-bold text-white text-sm uppercase tracking-wider mb-4 border-l-2 border-emerald-500 pl-2.5">Hubungi Kami</p>
                    <div class="space-y-3 text-slate-400 text-sm mb-5">
                        <div class="flex items-start gap-2.5">
                            <i class="fa-solid fa-location-dot text-brand-accent mt-1 text-xs"></i>
                            <span class="text-xs">Jakarta & Bandung, Indonesia</span>
                        </div>
                        <div class="flex items-center gap-2.5">
                            <i class="fa-solid fa-envelope text-brand-accent text-xs"></i>
                            <a href="mailto:sales@scalifyintellegence.my.id" class="text-xs hover:text-white transition">sales@scalifyintellegence.my.id</a>
                        </div>
                        <div class="flex items-center gap-2.5">
                            <i class="fa-brands fa-whatsapp text-emerald-400 text-sm"></i>
                            <a href="https://wa.me/6285221694067" target="_blank" class="text-xs text-white font-semibold hover:text-emerald-400 transition">+62 852 2169 4067</a>
                        </div>
                    </div>

                    <p class="text-xs font-semibold text-slate-300 mb-2.5">Media Sosial & Portofolio</p>
                    <div class="flex gap-2.5">
                        <a href="https://instagram.com" target="_blank" class="w-8 h-8 rounded-lg bg-white/5 border border-white/10 flex items-center justify-center text-slate-400 hover:text-white hover:bg-white/10 transition text-xs">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="https://linkedin.com" target="_blank" class="w-8 h-8 rounded-lg bg-white/5 border border-white/10 flex items-center justify-center text-slate-400 hover:text-white hover:bg-white/10 transition text-xs">
                            <i class="fab fa-linkedin"></i>
                        </a>
                        <a href="https://github.com" target="_blank" class="w-8 h-8 rounded-lg bg-white/5 border border-white/10 flex items-center justify-center text-slate-400 hover:text-white hover:bg-white/10 transition text-xs">
                            <i class="fab fa-github"></i>
                        </a>
                        <a href="https://youtube.com" target="_blank" class="w-8 h-8 rounded-lg bg-white/5 border border-white/10 flex items-center justify-center text-slate-400 hover:text-white hover:bg-white/10 transition text-xs">
                            <i class="fab fa-youtube"></i>
                        </a>
                    </div>
                </div>
            </div>

            <div class="border-t border-white/10 pt-8 flex flex-col md:flex-row justify-between items-center gap-4">
                <p class="text-slate-500 text-xs text-center md:text-left">
                    © 2026 Scalify Intelligence. All rights reserved · Agency Digital Pembuatan Website No. 1 di Indonesia.
                </p>
                <div class="flex gap-6 text-xs text-slate-400">
                    <a href="{{ route('index.company.profile') }}" class="hover:text-white transition">Home</a>
                    <a href="{{ route('landing.portfolio') }}" class="hover:text-white transition">Portofolio</a>
                    <a href="{{ route('sobat-scalify') }}" class="hover:text-amber-400 transition">Sobat Scalify</a>
                    <a href="{{ route('landing.careers') }}" class="hover:text-emerald-400 transition">Karir</a>
                </div>
            </div>
        </div>
    </footer>

    <script>
        // Smooth scroll behavior
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth'
                    });
                }
            });
        });

        // Add animation on scroll
        const observerOptions = {
            threshold: 0.1
            , rootMargin: '0px 0px -100px 0px'
        };

        const observer = new IntersectionObserver(function(entries) {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.animation = 'fadeInUp 0.6s ease forwards';
                    observer.unobserve(entry.target);
                }
            });
        }, observerOptions);

        document.querySelectorAll('.card-hover, .glass-effect').forEach(el => {
            el.style.opacity = '0';
            observer.observe(el);
        });

        // Add fade-in animation
        const style = document.createElement('style');
        style.textContent = `
            @keyframes fadeInUp {
                from {
                    opacity: 0;
                    transform: translateY(30px);
                }
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }
        `;
        document.head.appendChild(style);

    </script>
