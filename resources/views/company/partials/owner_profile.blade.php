{{-- ══════════════════════════════════════════════════
     OWNER & LEAD ENGINEER PROFILE SECTION
══════════════════════════════════════════════════ --}}
<section id="ownerprofile" class="bg-brand-dark py-20 px-4 sm:px-6 lg:px-8 relative overflow-hidden border-t border-white/5">
    <!-- Background Decor -->
    <div class="absolute top-0 right-0 w-1/2 h-full bg-blue-glow opacity-20 pointer-events-none"></div>
    <div class="absolute bottom-[-10%] left-[-10%] w-[40%] h-[40%] rounded-full bg-brand-indigo/20 blur-[120px] pointer-events-none"></div>

    <div class="max-w-6xl mx-auto relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-20 items-center">

            {{-- Kiri: Teks & Spesialisasi --}}
            <div class="flex flex-col text-left order-2 lg:order-1">
                {{-- Badge Founder --}}
                <div class="inline-flex items-center gap-2 bg-brand-accent/10 border border-brand-accent/20 rounded-full px-4 py-1.5 mb-6 w-max">
                    <span class="w-2 h-2 rounded-full bg-brand-accent animate-pulse"></span>
                    <span class="text-brand-accent text-xs font-semibold tracking-wider uppercase">Founder & Lead Engineer</span>
                </div>

                {{-- Headline --}}
                <h2 class="font-sans font-black text-3xl sm:text-4xl lg:text-[2.5rem] text-white mb-6 leading-[1.18] tracking-tight">
                    Mengubah Web Konvensional Menjadi <span class="text-transparent bg-clip-text bg-gradient-to-r from-brand-accent to-brand-indigo">Sistem Cerdas</span>
                </h2>

                {{-- Deskripsi personal founder --}}
                <p class="text-white/70 mb-8 text-xs sm:text-sm leading-relaxed font-normal">
                    Berlatar belakang pendidikan Sistem Informasi dan berpengalaman matang dalam arsitektur backend, saya fokus memimpin pengembangan sistem digital enterprise. Dengan rekam jejak menangani integrasi sistem berskala nasional hingga otomasi masa depan, saya siap membantu mentransformasi bisnis Anda lewat teknologi yang kokoh, cerdas, dan scalable.
                </p>

                {{-- Riwayat Keahlian / Track Record Founder --}}
                <div class="space-y-5 mb-10">
                    {{-- Poin 1: Pengalaman Kementerian (Simkopdes) --}}
                    <div class="flex items-start gap-4 p-5 rounded-2xl bg-white/5 border border-white/10 hover:border-brand-accent/30 hover:bg-white/10 transition-all duration-300">
                        <div class="w-11 h-11 rounded-xl bg-blue-500/20 flex items-center justify-center flex-shrink-0 border border-blue-500/30 shadow-[0_0_15px_rgba(59,130,246,0.3)]">
                            <i class="fa-solid fa-server text-brand-accent text-lg"></i>
                        </div>
                        <div>
                            <h3 class="text-white font-bold text-sm mb-1">Pengembangan Sistem Skala Nasional</h3>
                            <p class="text-white/60 text-xs leading-relaxed">Dipercaya sebagai backend engineer yang menghandle proyek strategis nasional, termasuk pengembangan <span class="text-white/80 font-medium">Simkopdes</span> di <span class="text-white/80 font-medium">Kementerian Koperasi dan UKM</span>. Ahli dalam merancang arsitektur aplikasi yang andal untuk volume data besar.</p>
                        </div>
                    </div>

                    {{-- Poin 2: Spesialisasi AI Agent --}}
                    <div class="flex items-start gap-4 p-5 rounded-2xl bg-white/5 border border-white/10 hover:border-brand-accent/30 hover:bg-white/10 transition-all duration-300">
                        <div class="w-11 h-11 rounded-xl bg-blue-500/20 flex items-center justify-center flex-shrink-0 border border-blue-500/30 shadow-[0_0_15px_rgba(59,130,246,0.3)]">
                            <i class="fa-solid fa-robot text-brand-accent text-lg"></i>
                        </div>
                        <div>
                            <h3 class="text-white font-bold text-sm mb-1">Spesialisasi AI Agent & Integrasi Multi-Platform</h3>
                            <p class="text-white/60 text-xs leading-relaxed">Melalui pengalaman di <span class="text-white/80 font-medium">Global Komunika</span>, saya mendalami perancangan agen pintar (AI Agent) untuk otomatisasi alur kerja serta membangun integrasi API multi-platform yang menjamin kelancaran komunikasi data antar ekosistem digital.</p>
                        </div>
                    </div>
                </div>

                <div>
                    <a href="https://wa.me/6285221694067?text=Halo%20Mas%20Andi,%20saya%20ingin%20konsultasi%20langsung%20proyek%20website" target="_blank" class="inline-flex items-center gap-3 bg-btn-gradient text-white font-semibold px-8 py-4 rounded-full shadow-glow-blue hover:scale-105 transition-all duration-300 text-sm group">
                        <span>Konsultasi Langsung dengan Founder</span>
                        <span class="w-7 h-7 bg-white/20 rounded-full flex items-center justify-center group-hover:bg-white/30 transition-colors">
                            <i class="fa-solid fa-arrow-right text-xs"></i>
                        </span>
                    </a>
                </div>
            </div>

            <div class="relative flex items-center justify-center lg:justify-end order-1 lg:order-2">
                {{-- Ornamen dekorasi di belakang foto --}}
                <div class="absolute inset-0 bg-gradient-to-br from-brand-accent/20 to-brand-indigo/30 rounded-[2rem] transform rotate-3 scale-105 blur-md hidden md:block"></div>
                <div class="absolute inset-0 border border-brand-accent/20 rounded-[2rem] transform -rotate-2 hidden md:block"></div>

                {{-- Wadah gambar --}}
                <div class="relative w-full max-w-sm lg:max-w-md aspect-[4/5] rounded-[2rem] overflow-hidden border border-white/10 shadow-2xl bg-brand-navy">
                    <div class="absolute inset-0 bg-gradient-to-t from-[#0A0E2A] via-[#0A0E2A]/20 to-transparent z-10"></div>

                    <img src="{{ asset('images/founder.jpg') }}" alt="Founder Scalify" class="w-full h-full object-cover object-top relative z-0" loading="lazy">

                    {{-- Badge nama di atas gambar --}}
                    <div class="absolute bottom-6 left-6 right-6 z-20 p-4 rounded-xl border border-white/20 shadow-xl" style="background: rgba(255, 255, 255, 0.05); backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px);">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-white font-bold text-lg tracking-wide">Muhammad Andi</h3>
                                <p class="text-brand-accent text-xs font-medium mt-0.5">Founder & System Architect</p>
                            </div>
                            <a href="https://www.linkedin.com/in/muhammad-andi-mubarok" target="_blank" aria-label="LinkedIn Muhammad Andi" class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center border border-white/20 hover:bg-white/20 transition-colors">
                                <i class="fa-brands fa-linkedin-in text-white text-sm"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>
