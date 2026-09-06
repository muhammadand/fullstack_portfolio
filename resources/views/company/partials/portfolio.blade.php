{{-- ══════════════════════════════════════════════════
     PORTOFOLIO VIDEO CAROUSEL SECTION
══════════════════════════════════════════════════ --}}
<section id="portofolio" class="bg-brand-dark py-20 sm:py-24 px-4 sm:px-6 lg:px-8 border-t border-white/5 overflow-hidden relative z-20" x-data="{}">
    <div class="max-w-6xl mx-auto">
        <!-- Header -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-12 gap-6">
            <div class="max-w-xl text-left">
                <div class="text-[#EF4444] font-extrabold text-[11px] sm:text-xs tracking-[0.2em] uppercase mb-1.5">
                    REKAM JEJAK & DEMO
                </div>
                <h2 class="font-sans font-black text-3xl sm:text-4xl lg:text-[2.4rem] text-white leading-[1.18] tracking-tight">
                    Katalog Portofolio &<br>
                    <span class="text-brand-accent">Implementasi Nyata</span>
                </h2>
            </div>
            <div class="max-w-xs text-white/60 text-xs sm:text-sm leading-relaxed pb-1 md:text-right">
                Kumpulan video implementasi teknologi, aplikasi web, dan automasi bisnis yang telah kami selesaikan.
            </div>
        </div>

        <!-- Slider Wrapper -->
        <div class="relative w-full group">
            <!-- Carousel Container -->
            <div x-ref="slider" class="flex gap-5 sm:gap-6 overflow-x-auto snap-x snap-mandatory pb-8 pt-2 -mx-4 px-4 sm:-mx-6 sm:px-6 lg:mx-0 lg:px-0" style="scrollbar-width: none; -ms-overflow-style: none;">

                <!-- Card 1 -->
                <div class="shrink-0 w-[280px] sm:w-[360px] snap-center group/card" x-data="{ playing: false }">
                    <div class="relative w-full rounded-2xl overflow-hidden bg-brand-navy border border-white/10 shadow-card transition-all duration-300 group-hover/card:border-brand-accent/50 group-hover/card:-translate-y-1">
                        <div style="padding-top: 56.25%;"></div>
                        <template x-if="playing">
                            <iframe class="absolute top-0 left-0 w-full h-full" src="https://www.youtube.com/embed/iUJWNHxI2RU?autoplay=1" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                        </template>
                        <div x-show="!playing" @click="playing = true" class="absolute inset-0 cursor-pointer flex items-center justify-center bg-cover bg-center" style="background-image: url('https://img.youtube.com/vi/iUJWNHxI2RU/hqdefault.jpg')">
                            <div class="absolute inset-0 bg-black/40 group-hover/card:bg-black/55 transition-colors"></div>
                            <button aria-label="Putar video portofolio 1" class="relative z-10 w-13 h-13 rounded-full bg-red-600 hover:bg-red-500 flex items-center justify-center text-white shadow-lg transition-transform duration-300 group-hover/card:scale-110">
                                <i class="fa-solid fa-play text-base ml-1"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Card 2 -->
                <div class="shrink-0 w-[280px] sm:w-[360px] snap-center group/card" x-data="{ playing: false }">
                    <div class="relative w-full rounded-2xl overflow-hidden bg-brand-navy border border-white/10 shadow-card transition-all duration-300 group-hover/card:border-brand-accent/50 group-hover/card:-translate-y-1">
                        <div style="padding-top: 56.25%;"></div>
                        <template x-if="playing">
                            <iframe class="absolute top-0 left-0 w-full h-full" src="https://www.youtube.com/embed/-bkn_ignjD4?autoplay=1" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                        </template>
                        <div x-show="!playing" @click="playing = true" class="absolute inset-0 cursor-pointer flex items-center justify-center bg-cover bg-center" style="background-image: url('https://img.youtube.com/vi/-bkn_ignjD4/hqdefault.jpg')">
                            <div class="absolute inset-0 bg-black/40 group-hover/card:bg-black/55 transition-colors"></div>
                            <button aria-label="Putar video portofolio 2" class="relative z-10 w-13 h-13 rounded-full bg-red-600 hover:bg-red-500 flex items-center justify-center text-white shadow-lg transition-transform duration-300 group-hover/card:scale-110">
                                <i class="fa-solid fa-play text-base ml-1"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Card 3 -->
                <div class="shrink-0 w-[280px] sm:w-[360px] snap-center group/card" x-data="{ playing: false }">
                    <div class="relative w-full rounded-2xl overflow-hidden bg-brand-navy border border-white/10 shadow-card transition-all duration-300 group-hover/card:border-brand-accent/50 group-hover/card:-translate-y-1">
                        <div style="padding-top: 56.25%;"></div>
                        <template x-if="playing">
                            <iframe class="absolute top-0 left-0 w-full h-full" src="https://www.youtube.com/embed/kMWZS8c5Xuo?autoplay=1" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                        </template>
                        <div x-show="!playing" @click="playing = true" class="absolute inset-0 cursor-pointer flex items-center justify-center bg-cover bg-center" style="background-image: url('https://img.youtube.com/vi/kMWZS8c5Xuo/hqdefault.jpg')">
                            <div class="absolute inset-0 bg-black/40 group-hover/card:bg-black/55 transition-colors"></div>
                            <button aria-label="Putar video portofolio 3" class="relative z-10 w-13 h-13 rounded-full bg-red-600 hover:bg-red-500 flex items-center justify-center text-white shadow-lg transition-transform duration-300 group-hover/card:scale-110">
                                <i class="fa-solid fa-play text-base ml-1"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Card 4 -->
                <div class="shrink-0 w-[280px] sm:w-[360px] snap-center group/card" x-data="{ playing: false }">
                    <div class="relative w-full rounded-2xl overflow-hidden bg-brand-navy border border-white/10 shadow-card transition-all duration-300 group-hover/card:border-brand-accent/50 group-hover/card:-translate-y-1">
                        <div style="padding-top: 56.25%;"></div>
                        <template x-if="playing">
                            <iframe class="absolute top-0 left-0 w-full h-full" src="https://www.youtube.com/embed/tO4PwTDOLX8?autoplay=1" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                        </template>
                        <div x-show="!playing" @click="playing = true" class="absolute inset-0 cursor-pointer flex items-center justify-center bg-cover bg-center" style="background-image: url('https://img.youtube.com/vi/tO4PwTDOLX8/hqdefault.jpg')">
                            <div class="absolute inset-0 bg-black/40 group-hover/card:bg-black/55 transition-colors"></div>
                            <button aria-label="Putar video portofolio 4" class="relative z-10 w-13 h-13 rounded-full bg-red-600 hover:bg-red-500 flex items-center justify-center text-white shadow-lg transition-transform duration-300 group-hover/card:scale-110">
                                <i class="fa-solid fa-play text-base ml-1"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Card 5 -->
                <div class="shrink-0 w-[280px] sm:w-[360px] snap-center group/card" x-data="{ playing: false }">
                    <div class="relative w-full rounded-2xl overflow-hidden bg-brand-navy border border-white/10 shadow-card transition-all duration-300 group-hover/card:border-brand-accent/50 group-hover/card:-translate-y-1">
                        <div style="padding-top: 56.25%;"></div>
                        <template x-if="playing">
                            <iframe class="absolute top-0 left-0 w-full h-full" src="https://www.youtube.com/embed/mG9gcUFLMeM?autoplay=1" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                        </template>
                        <div x-show="!playing" @click="playing = true" class="absolute inset-0 cursor-pointer flex items-center justify-center bg-cover bg-center" style="background-image: url('https://img.youtube.com/vi/mG9gcUFLMeM/hqdefault.jpg')">
                            <div class="absolute inset-0 bg-black/40 group-hover/card:bg-black/55 transition-colors"></div>
                            <button aria-label="Putar video portofolio 5" class="relative z-10 w-13 h-13 rounded-full bg-red-600 hover:bg-red-500 flex items-center justify-center text-white shadow-lg transition-transform duration-300 group-hover/card:scale-110">
                                <i class="fa-solid fa-play text-base ml-1"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Card 6 -->
                <div class="shrink-0 w-[280px] sm:w-[360px] snap-center group/card" x-data="{ playing: false }">
                    <div class="relative w-full rounded-2xl overflow-hidden bg-brand-navy border border-white/10 shadow-card transition-all duration-300 group-hover/card:border-brand-accent/50 group-hover/card:-translate-y-1">
                        <div style="padding-top: 56.25%;"></div>
                        <template x-if="playing">
                            <iframe class="absolute top-0 left-0 w-full h-full" src="https://www.youtube.com/embed/9vuxrTVfRNo?autoplay=1" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                        </template>
                        <div x-show="!playing" @click="playing = true" class="absolute inset-0 cursor-pointer flex items-center justify-center bg-cover bg-center" style="background-image: url('https://img.youtube.com/vi/9vuxrTVfRNo/hqdefault.jpg')">
                            <div class="absolute inset-0 bg-black/40 group-hover/card:bg-black/55 transition-colors"></div>
                            <button aria-label="Putar video portofolio 6" class="relative z-10 w-13 h-13 rounded-full bg-red-600 hover:bg-red-500 flex items-center justify-center text-white shadow-lg transition-transform duration-300 group-hover/card:scale-110">
                                <i class="fa-solid fa-play text-base ml-1"></i>
                            </button>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Bottom Controls -->
            <div class="flex items-center justify-between mt-4">
                <a href="{{ route('landing.portfolio') }}" class="bg-btn-gradient text-white font-semibold px-6 py-3 rounded-full shadow-glow-sm hover:shadow-glow-blue hover:-translate-y-0.5 transition-all duration-300 text-xs sm:text-sm flex items-center gap-2">
                    <span>Semua Portofolio</span> <i class="fa-solid fa-arrow-right text-xs"></i>
                </a>

                <div class="flex items-center gap-3">
                    <button @click="$refs.slider.scrollBy({left: -360, behavior: 'smooth'})" aria-label="Slide sebelumnya" class="w-11 h-11 rounded-full bg-white/5 border border-white/15 flex items-center justify-center text-white/70 hover:text-white hover:bg-white/10 hover:border-brand-accent/40 transition-colors shadow-sm">
                        <i class="fa-solid fa-chevron-left text-sm"></i>
                    </button>
                    <button @click="$refs.slider.scrollBy({left: 360, behavior: 'smooth'})" aria-label="Slide berikutnya" class="w-11 h-11 rounded-full bg-white/5 border border-white/15 flex items-center justify-center text-white/70 hover:text-white hover:bg-white/10 hover:border-brand-accent/40 transition-colors shadow-sm">
                        <i class="fa-solid fa-chevron-right text-sm"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <style>
        #portofolio .overflow-x-auto::-webkit-scrollbar {
            display: none;
        }
    </style>
</section>
