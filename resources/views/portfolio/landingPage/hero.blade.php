<section class="relative min-h-[80vh] flex items-center overflow-hidden">
    <!-- Decorative background elements -->
    <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-gold/5 rounded-full blur-[120px] -translate-y-1/2 translate-x-1/4">
    </div>
    <div class="absolute bottom-0 left-0 w-[300px] h-[300px] bg-olive/10 rounded-full blur-[100px] translate-y-1/4 -translate-x-1/4">
    </div>

    <div class="max-w-7xl mx-auto px-8 w-full relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-16 items-center">

            <!-- Text Content -->
            <div class="lg:col-span-7 space-y-8">
                <div class="inline-flex items-center gap-4 group">
                    <span class="h-px w-8 bg-gold/50 group-hover:w-12 transition-all duration-500"></span>
                    <span class="text-gold font-medium tracking-[0.4em] text-xs uppercase">
                        Muhammad Andi Mubarok
                    </span>
                </div>

                <h1 class="text-5xl md:text-7xl font-light leading-[1.1] tracking-tight">
                    Building <br>
                    <span class="relative inline-block">
                        Scalable &
                        <svg class="absolute -bottom-2 left-0 w-full h-2 text-gold/30" viewBox="0 0 100 10" preserveAspectRatio="none">
                            <path d="M0 5 Q 25 0, 50 5 T 100 5" fill="none" stroke="currentColor" stroke-width="2" />
                        </svg>
                    </span>
                    <span class="text-gold italic font-serif ml-2">Intelligent Backends</span>
                </h1>

                <p class="text-gray-400 text-lg md:text-xl max-w-xl leading-relaxed font-light">
                    <span class="text-white font-medium">Backend Engineer</span> berpengalaman dalam <span class="text-white border-b border-olive/50">sistem skala nasional</span> dan integrasi <span class="text-gold italic">AI Chatbot</span>. Mengubah logika kompleks menjadi infrastruktur
                    digital yang efisien.
                </p>

                <div class="flex flex-wrap gap-6 pt-4">
                    <a href="#contact" class="group relative overflow-hidden bg-gold text-navy px-12 py-5 font-bold text-sm uppercase tracking-[0.2em] transition-all duration-500 hover:shadow-[0_0_40px_rgba(201,169,110,0.3)]">
                        <span class="relative z-10">Mulai Proyek</span>
                        <div class="absolute inset-0 bg-white translate-y-full group-hover:translate-y-0 transition-transform duration-500">
                        </div>
                    </a>

                    <a href="#work" class="group flex items-center gap-4 text-white font-bold text-sm uppercase tracking-[0.2em] hover:text-gold transition-colors duration-300">
                        <span class="w-12 h-12 rounded-full border border-olive/30 flex items-center justify-center group-hover:border-gold transition-colors">
                            <svg class="w-4 h-4 translate-x-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" />
                            </svg>
                        </span>
                        Eksplorasi Karya
                    </a>
                </div>
            </div>

            <!-- Visual Component -->
            <div class="lg:col-span-5 relative">
                <div class="relative z-20 group">
                    <!-- Main Image Frame -->
                    <div class="relative overflow-hidden shadow-2xl transition-transform duration-700 group-hover:scale-[1.02]">
                        <img src="{{ asset('hero.jpg') }}" alt="Hero Portfolio" class="w-full aspect-[4/5] object-cover grayscale-[20%] group-hover:grayscale-0 transition-all duration-700" fetchpriority="high">
                        <div class="absolute inset-0 bg-gradient-to-t from-navy/60 to-transparent opacity-60"></div>
                    </div>

                    <!-- Floating Decorative Elements -->
                    <div class="absolute -top-10 -right-10 w-40 h-40 border border-gold/20 -z-10 animate-spin-slow">
                    </div>
                    <div class="absolute -bottom-6 -left-6 w-32 h-32 bg-olive/10 backdrop-blur-xl border border-white/5 -z-10">
                    </div>

                    <!-- Stats / Floating Info -->
                    <div class="absolute -right-8 bottom-12 bg-white/5 backdrop-blur-md border border-white/10 p-6 shadow-2xl translate-x-4">
                        <div class="text-gold text-3xl font-serif mb-1">08+</div>
                        <div class="text-[10px] uppercase tracking-widest text-gray-400">Tahun Pengalaman</div>
                    </div>
                </div>

                <!-- Abstract Shapes -->
                <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[120%] h-[120%] border border-gold/5 rounded-full pointer-events-none">
                </div>
                <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[140%] h-[140%] border border-olive/5 rounded-full pointer-events-none">
                </div>
            </div>

        </div>
    </div>

    <!-- Scroll Indicator -->
    <div class="absolute bottom-10 left-1/2 -translate-x-1/2 flex flex-col items-center gap-4 opacity-50">
        <span class="text-[10px] uppercase tracking-[0.5em] text-gold">Scroll</span>
        <div class="w-px h-12 bg-gradient-to-b from-gold to-transparent"></div>
    </div>
</section>

<style>
    @keyframes spin-slow {
        from {
            transform: rotate(0deg);
        }

        to {
            transform: rotate(360deg);
        }
    }

    .animate-spin-slow {
        animation: spin-slow 20s linear infinite;
    }

</style>
