{{-- ══════════════════════════════════════════════════
     PROMO PRODUK: GOOGLE REVIEW CARD (MIDNIGHT BLUE & GLASS)
     Desain 100% Selaras dengan Design System Scalify Intelligence
══════════════════════════════════════════════════ --}}
<section id="google-review-card" class="bg-brand-dark py-16 sm:py-24 px-4 sm:px-6 lg:px-8 border-t border-white/5 relative z-20 overflow-hidden" x-data="googleCardPromoApp()">

    {{-- Ambient Glass Glow Accents --}}
    <div class="absolute top-1/3 left-1/2 -translate-x-1/2 w-[700px] h-[400px] bg-blue-600/15 blur-[140px] rounded-full pointer-events-none"></div>
    <div class="absolute -top-12 -left-20 w-80 h-80 bg-indigo-600/10 blur-[100px] rounded-full pointer-events-none"></div>
    <div class="absolute -bottom-12 -right-20 w-80 h-80 bg-cyan-500/10 blur-[100px] rounded-full pointer-events-none"></div>

    <div class="max-w-6xl mx-auto relative z-10">

        {{-- Section Header --}}
        <div class="text-center mb-12 sm:mb-16">
            <div class="mb-3">
                <span class="text-brand-accent font-extrabold text-[11px] sm:text-xs tracking-[0.25em] uppercase bg-brand-accent/10 border border-brand-accent/25 px-4 py-1.5 rounded-full backdrop-blur-md inline-flex items-center gap-2">
                    <span class="w-1.5 h-1.5 rounded-full bg-cyan-400 animate-pulse"></span>
                    <span>PROMO KHUSUS BISNIS &bull; CUMA RP 20.000</span>
                </span>
            </div>
            <h2 class="font-sans font-black text-3xl sm:text-4xl md:text-5xl text-white mb-4 leading-tight tracking-tight">
                Google Review Card Siap Cetak<br>
                <span class="bg-gradient-to-r from-blue-400 via-cyan-300 to-indigo-400 bg-clip-text text-transparent">
                    Tingkatkan Bintang 5 Bisnismu Seketika
                </span>
            </h2>
            <p class="text-white/60 text-center max-w-2xl mx-auto text-xs sm:text-sm font-normal leading-relaxed">
                Solusi praktis pemilik Cafe, Resto, Klinik, Laundry, Barbershop &amp; Toko. Pelanggan tinggal scan QR di meja kasir, formulir ulasan bintang 5 Google langsung terbuka otomatis!
            </p>

            {{-- Quick Social Media Share Tools (Threads, FB, IG, WA) with Traffic Source Tracking --}}
            <div class="flex flex-wrap items-center justify-center gap-2.5 mt-6">
                <button type="button" @click="copyPromoLink()" class="px-3.5 py-1.5 rounded-xl bg-white/5 hover:bg-white/10 border border-white/15 text-white/80 hover:text-white text-xs font-semibold flex items-center gap-2 transition-all active:scale-95 cursor-pointer backdrop-blur-md">
                    <i :class="copiedLink ? 'fa-solid fa-check text-emerald-400' : 'fa-regular fa-copy text-brand-accent'"></i>
                    <span x-text="copiedLink ? 'Link Tersalin!' : 'Salin Link Promo'"></span>
                </button>

                <button type="button" @click="copyCaption()" class="px-3.5 py-1.5 rounded-xl bg-white/5 hover:bg-white/10 border border-white/15 text-white/80 hover:text-white text-xs font-semibold flex items-center gap-2 transition-all active:scale-95 cursor-pointer backdrop-blur-md" title="Salin teks iklan siap posting untuk Threads/Facebook">
                    <i :class="copiedCaption ? 'fa-solid fa-check text-emerald-400' : 'fa-solid fa-bullhorn text-cyan-400'"></i>
                    <span x-text="copiedCaption ? 'Teks Iklan Tersalin!' : 'Salin Teks Iklan (Threads/FB)'"></span>
                </button>

                <a :href="'https://api.whatsapp.com/send?text=' + encodeURIComponent('Mau rating Google Maps bisnismu naik bintang 5 seketika? Bikin Google Review Card siap cetak cuma Rp 20.000 di sini: ' + shareUrl + '?src=whatsapp')" target="_blank" class="w-8 h-8 rounded-xl bg-white/5 hover:bg-emerald-500/20 border border-white/15 hover:border-emerald-500/30 text-white/80 hover:text-emerald-400 flex items-center justify-center transition-all hover:scale-105" title="Bagikan ke WhatsApp">
                    <i class="fa-brands fa-whatsapp text-sm"></i>
                </a>

                <a :href="'https://www.threads.net/intent/post?text=' + encodeURIComponent('Solusi rahasia cafe & toko auto bintang 5 di Google Maps ⭐⭐⭐⭐⭐ Google Review Card siap cetak cuma 20rb: ' + shareUrl + '?src=threads')" target="_blank" class="w-8 h-8 rounded-xl bg-white/5 hover:bg-purple-500/20 border border-white/15 hover:border-purple-500/30 text-white/80 hover:text-purple-300 flex items-center justify-center transition-all hover:scale-105" title="Bagikan ke Threads">
                    <i class="fa-brands fa-threads text-sm"></i>
                </a>

                <a :href="'https://www.facebook.com/sharer/sharer.php?u=' + encodeURIComponent(shareUrl + '?src=facebook')" target="_blank" class="w-8 h-8 rounded-xl bg-white/5 hover:bg-blue-600/20 border border-white/15 hover:border-blue-500/30 text-white/80 hover:text-blue-400 flex items-center justify-center transition-all hover:scale-105" title="Bagikan ke Facebook">
                    <i class="fa-brands fa-facebook text-sm"></i>
                </a>
            </div>
        </div>

        {{-- Main Grid: Mockup Card Preview (Kiri) & Order Form / QRIS (Kanan) --}}
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-10 items-start">

            {{-- ── LEFT: LIVE REAL-TIME CARD MOCKUP SLIDER (5 Cols) ── --}}
            <div class="lg:col-span-5 flex flex-col items-center">

                {{-- Interactive Gesture Helper & Quick Theme Tabs --}}
                <div class="w-full max-w-[340px] mb-3 flex flex-col gap-2">
                    <div class="flex items-center justify-between bg-white/5 border border-white/10 rounded-2xl p-1.5 backdrop-blur-md">
                        <button type="button" @click="prevTheme()" class="w-8 h-8 rounded-xl bg-white/5 hover:bg-white/15 text-white flex items-center justify-center transition-all active:scale-95 cursor-pointer" title="Geser ke Kiri (Sebelumnya)">
                            <i class="fa-solid fa-chevron-left text-xs"></i>
                        </button>

                        <div class="text-center px-2">
                            <span class="text-[10px] text-cyan-300 font-semibold uppercase tracking-wider flex items-center justify-center gap-1.5">
                                <i class="fa-solid fa-hand-pointer text-[10px] animate-pulse"></i>
                                <span>Swipe / Geser Kartu</span>
                            </span>
                            <span class="text-xs font-bold text-white flex items-center justify-center gap-1.5 mt-0.5">
                                <span x-text="currentTheme.name"></span>
                                <span class="text-[10px] font-mono text-white/50" x-text="'(' + (themeIndex + 1) + '/3)'"></span>
                            </span>
                        </div>

                        <button type="button" @click="nextTheme()" class="w-8 h-8 rounded-xl bg-white/5 hover:bg-white/15 text-white flex items-center justify-center transition-all active:scale-95 cursor-pointer" title="Geser ke Kanan (Berikutnya)">
                            <i class="fa-solid fa-chevron-right text-xs"></i>
                        </button>
                    </div>

                    {{-- 3 Quick Theme Pills --}}
                    <div class="grid grid-cols-3 gap-1.5">
                        <template x-for="(thm, idx) in themes" :key="thm.id">
                            <button type="button" @click="setTheme(idx)" :class="themeIndex === idx ? 'bg-white/20 border-brand-accent text-white shadow-sm' : 'bg-white/5 border-white/10 text-white/60 hover:text-white hover:bg-white/10'" class="py-1.5 px-2 rounded-xl border text-[11px] font-semibold transition-all flex items-center justify-center gap-1.5 cursor-pointer truncate">
                                <span class="w-2.5 h-2.5 rounded-full shrink-0" :class="thm.dotColor"></span>
                                <span class="truncate" x-text="thm.shortName"></span>
                            </button>
                        </template>
                    </div>
                </div>

                {{-- Mockup Canvas Container with 3D Stacked Deck & Swipe Support --}}
                <div class="w-full max-w-[340px] relative select-none touch-pan-y"
                     @touchstart="handleTouchStart($event)"
                     @touchmove="handleTouchMove($event)"
                     @touchend="handleTouchEnd($event)"
                     @mousedown="handleMouseDown($event)"
                     @mousemove="handleMouseMove($event)"
                     @mouseup="handleMouseUp($event)"
                     @mouseleave="handleMouseLeave($event)">

                    {{-- Dynamic Ambient Glow behind deck --}}
                    <div class="absolute -inset-3 rounded-[36px] blur-xl opacity-75 transition-all duration-500 pointer-events-none" :class="currentTheme.glowClass"></div>

                    {{-- ── DECK LAYER 3 (Paling Belakang) ── --}}
                    <div class="absolute inset-0 rounded-[28px] transform scale-[0.88] translate-y-5 opacity-25 border border-white/10 shadow-lg pointer-events-none transition-all duration-300"
                         :class="deckThemes[2].cardClass">
                    </div>

                    {{-- ── DECK LAYER 2 (Di Tengah Tumpukan) ── --}}
                    <div class="absolute inset-0 rounded-[28px] transform scale-[0.94] translate-y-2.5 opacity-50 border border-white/15 shadow-xl pointer-events-none transition-all duration-300"
                         :class="deckThemes[1].cardClass">
                    </div>

                    {{-- ── DECK LAYER 1 (KARTU UTAMA AKTIF - BISA DI-SWIPE / GESER) ── --}}
                    <div class="relative rounded-[28px] p-6 shadow-2xl flex flex-col items-center text-center transition-all select-none"
                         :class="[currentTheme.cardClass, isDragging ? 'cursor-grabbing scale-[1.02]' : 'cursor-grab']"
                         :style="{
                             transform: 'translateX(' + dragOffset + 'px) rotate(' + (dragOffset * 0.04) + 'deg)',
                             transition: isDragging ? 'none' : 'transform 0.35s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.3s ease'
                         }"
                         style="box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.65); font-family: 'Outfit', sans-serif;">

                        {{-- Floating Swipe Direction Hint Badge on Card Drag --}}
                        <div x-show="Math.abs(dragOffset) > 20" x-cloak class="absolute top-3 left-1/2 -translate-x-1/2 px-3 py-1 rounded-full text-[10px] font-extrabold uppercase tracking-wider backdrop-blur-md transition-all shadow-md z-30"
                             :class="dragOffset < 0 ? 'bg-cyan-500 text-white' : 'bg-amber-500 text-slate-950'">
                            <span x-text="dragOffset < 0 ? 'Berikutnya ›' : '‹ Sebelumnya'"></span>
                        </div>

                        {{-- Acrylic Top Slot --}}
                        <div class="w-10 h-1.5 rounded-full mb-4 transition-colors" :class="currentTheme.acrylicSlot"></div>

                        {{-- Official Google Multi-Color Icon / Brand Icon --}}
                        <div class="w-12 h-12 mb-2 flex items-center justify-center pointer-events-none">
                            <svg class="w-full h-full" viewBox="0 0 24 24">
                                <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" />
                                <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" />
                                <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.06H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.94l2.85-2.22.81-.63z" />
                                <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.06l3.66 2.84c.87-2.6 3.3-4.52 6.16-4.52z" />
                            </svg>
                        </div>

                        {{-- 5 Gold Stars Rating --}}
                        <div class="flex items-center justify-center gap-1 mb-2 pointer-events-none">
                            <template x-for="i in 5">
                                <svg class="w-5 h-5" :class="currentTheme.starClass" viewBox="0 0 24 24">
                                    <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z" />
                                </svg>
                            </template>
                        </div>

                        {{-- Headline text --}}
                        <p class="font-medium text-sm leading-tight mb-1 pointer-events-none" :class="currentTheme.headlineClass">Bantu Ulas Kami di</p>

                        {{-- Google Wordmark --}}
                        <div class="flex items-center justify-center my-0.5 mb-2 pointer-events-none">
                            <svg viewBox="0 0 272 92" class="h-6 w-auto">
                                <path fill="#EA4335" d="M115.75 47.18c0 12.77-9.99 22.18-22.25 22.18s-22.25-9.41-22.25-22.18C71.25 34.32 81.24 25 93.5 25s22.25 9.32 22.25 22.18zm-9.74 0c0-7.98-5.79-13.44-12.51-13.44S80.99 39.2 80.99 47.18c0 7.9 5.79 13.44 12.51 13.44s12.51-5.55 12.51-13.44z" />
                                <path fill="#FBBC05" d="M163.75 47.18c0 12.77-9.99 22.18-22.25 22.18s-22.25-9.41-22.25-22.18c0-12.85 9.99-22.18 22.25-22.18s22.25 9.32 22.25 22.18zm-9.74 0c0-7.98-5.79-13.44-12.51-13.44s-12.51 5.46-12.51 13.44c0 7.9 5.79 13.44 12.51 13.44s12.51-5.55 12.51-13.44z" />
                                <path fill="#4285F4" d="M209.75 26.34v39.82c0 16.38-9.66 23.07-21.08 23.07-10.75 0-17.22-7.19-19.66-13.07l8.48-3.53c1.51 3.61 5.21 8.19 11.17 8.19 7.31 0 11.84-4.53 11.84-13.02v-3.19h-.34c-2.18 2.69-6.38 5.04-11.68 5.04-11.09 0-21.25-9.66-21.25-22.09 0-12.52 10.16-22.26 21.25-22.26 5.29 0 9.49 2.35 11.68 4.96h.34v-3.92h9.45zm-8.82 20.92c0-7.81-5.21-13.44-11.84-13.44-6.72 0-12.35 5.63-12.35 13.44 0 7.72 5.63 13.35 12.35 13.35 6.63 0 11.84-5.63 11.84-13.35z" />
                                <path fill="#34A853" d="M225 3v65h-9.5V3h9.5z" />
                                <path fill="#EA4335" d="M262.02 54.48l7.56 5.04c-2.44 3.61-8.32 9.83-18.48 9.83-12.6 0-22.01-9.74-22.01-22.18 0-13.19 9.49-22.18 20.92-22.18 11.51 0 17.14 9.16 18.98 14.11l1.01 2.52-29.65 12.28c2.27 4.45 5.8 6.72 10.75 6.72 4.96 0 8.4-2.44 10.92-6.14zm-13.78-8.15l19.82-8.23c-1.09-2.77-4.37-4.7-8.23-4.7-4.95 0-11.84 4.37-11.59 12.93z" />
                                <path fill="#4285F4" d="M35.29 41.41V32H67c.31 1.64.47 3.58.47 5.68 0 7.06-1.93 15.79-8.15 22.01-6.05 6.3-13.78 9.66-24.02 9.66C16.32 69.35.36 53.89.36 34.91.36 15.93 16.32.47 35.3.47c10.5 0 17.98 4.12 23.6 9.49l-6.64 6.64c-4.03-3.78-9.49-6.72-16.97-6.72-13.86 0-24.7 11.17-24.7 25.03 0 13.86 10.84 25.03 24.7 25.03 8.99 0 14.11-3.61 17.39-6.89 2.69-2.69 4.45-6.55 5.12-11.64H35.29z" />
                            </svg>
                        </div>

                        {{-- Real-Time Dynamic Business Name Badge --}}
                        <div class="my-2 px-3.5 py-1 rounded-full text-xs font-bold max-w-[260px] truncate border transition-all pointer-events-none" :class="currentTheme.badgeClass">
                            <span x-text="businessName ? businessName : 'Nama Usaha Anda'"></span>
                        </div>

                        {{-- QR Container with Dynamic Themed Border --}}
                        <div class="w-full p-[2.5px] rounded-2xl my-2 shadow-sm transition-all pointer-events-none" :style="'background: ' + currentTheme.qrBorderGradient">
                            <div class="w-full rounded-[14px] p-3 flex flex-col items-center transition-colors" :class="currentTheme.qrContainerClass">
                                <p class="text-[11px] font-semibold tracking-wide mb-1 transition-colors" :class="currentTheme.qrLabelClass">Scan QR Code</p>

                                {{-- Demo QR image --}}
                                <div class="w-36 h-36 relative flex items-center justify-center p-1 rounded-xl transition-all" :class="currentTheme.qrWrapperClass">
                                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=180x180&data=https://maps.google.com" alt="QR Code Mockup" class="w-full h-full object-contain pointer-events-none">
                                    <div class="absolute inset-0 flex items-center justify-center pointer-events-none">
                                        <div class="w-8 h-8 rounded-full bg-white shadow-md flex items-center justify-center p-1 border border-slate-100">
                                            <svg class="w-5 h-5" viewBox="0 0 24 24">
                                                <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" />
                                                <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" />
                                                <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.06H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.94l2.85-2.22.81-.63z" />
                                                <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.06l3.66 2.84c.87-2.6 3.3-4.52 6.16-4.52z" />
                                            </svg>
                                        </div>
                                    </div>
                                </div>

                                <p class="text-[10px] mt-1.5 font-medium transition-colors" :class="currentTheme.qrSubClass">Arahkan kamera HP ke QR</p>
                            </div>
                        </div>

                        {{-- Footer Badge on Card --}}
                        <div class="w-full pt-2 flex items-center justify-between text-[10px] border-t transition-colors pointer-events-none" :class="currentTheme.footerBorderClass">
                            <span class="font-semibold flex items-center gap-1" :class="currentTheme.footerBadgeClass">
                                <i class="fa-solid fa-certificate text-[10px]"></i> <span x-text="currentTheme.tag"></span>
                            </span>
                            <span class="font-mono text-[9px] opacity-75">PDF &amp; PNG HD</span>
                        </div>
                    </div>
                </div>

                {{-- Dots indicator & Slide Nav Bottom --}}
                <div class="mt-6 flex items-center gap-2">
                    <template x-for="(thm, idx) in themes" :key="'dot-' + thm.id">
                        <button type="button" @click="setTheme(idx)" class="h-2 rounded-full transition-all cursor-pointer" :class="themeIndex === idx ? 'w-6 bg-brand-accent' : 'w-2 bg-white/30 hover:bg-white/60'" :title="thm.name"></button>
                    </template>
                </div>

                {{-- Feature Badges below card --}}
                <div class="mt-4 flex flex-wrap items-center justify-center gap-2 max-w-sm text-center">
                    <span class="px-2.5 py-1 rounded-lg bg-white/5 border border-white/10 text-white/70 text-[11px] flex items-center gap-1">
                        <i class="fa-solid fa-check text-brand-accent"></i> Auto Bintang 5
                    </span>
                    <span class="px-2.5 py-1 rounded-lg bg-white/5 border border-white/10 text-white/70 text-[11px] flex items-center gap-1">
                        <i class="fa-solid fa-check text-brand-accent"></i> Aktif Selamanya
                    </span>
                    <span class="px-2.5 py-1 rounded-lg bg-white/5 border border-white/10 text-white/70 text-[11px] flex items-center gap-1">
                        <i class="fa-solid fa-check text-brand-accent"></i> Tanpa Biaya Bulanan
                    </span>
                </div>
            </div>

            {{-- ── RIGHT: ORDER FORM & QRIS GATEWAY (7 Cols - Dark Glass Panel) ── --}}
            <div class="lg:col-span-7 bg-brand-navy/60 backdrop-blur-xl border border-white/10 rounded-3xl p-6 sm:p-8 shadow-card relative">

                {{-- STEP 1: FORM PEMBELIAN KILAT --}}
                <div x-show="step === 'form'">

                    {{-- Price Pill & Value Proposition --}}
                    <div class="flex flex-wrap items-center justify-between gap-4 mb-6 p-4 rounded-2xl bg-white/[0.04] border border-white/10">
                        <div>
                            <span class="text-[11px] text-brand-accent font-extrabold uppercase tracking-wider block">Harga Promo Investasi</span>
                            <div class="flex items-baseline gap-2 mt-0.5">
                                <span class="text-3xl sm:text-4xl font-black text-white font-mono">Rp 20.000</span>
                                <span class="text-xs text-white/40 line-through">Rp 75.000</span>
                                <span class="text-[10px] font-bold text-brand-accent bg-blue-500/20 border border-blue-400/30 px-2.5 py-0.5 rounded-full">Hemat 73%</span>
                            </div>
                        </div>
                        <div class="text-left sm:text-right">
                            <span class="text-[10px] text-white/50 block">File Master Dikirim Ke:</span>
                            <span class="text-xs font-bold text-white flex items-center sm:justify-end gap-1.5 mt-0.5">
                                <i class="fa-brands fa-whatsapp text-emerald-400 text-sm"></i> WhatsApp Anda
                            </span>
                        </div>
                    </div>

                    <h3 class="text-white font-bold text-lg mb-1">Formulir Pesanan Kilat</h3>
                    <p class="text-white/50 text-xs mb-5">Hanya butuh 1 menit. File master QR &amp; desain siap cetak langsung kami kirimkan ke WhatsApp Anda.</p>

                    <form @submit.prevent="proceedToPayment()" class="space-y-4">
                        {{-- 1. Nama Usaha --}}
                        <div>
                            <label class="block text-xs font-bold text-white/80 mb-1.5 flex items-center justify-between">
                                <span>1. Nama Toko / Cafe / Bisnis Anda <span class="text-rose-400">*</span></span>
                                <span class="text-[10px] text-brand-accent font-normal">Lihat live preview di kiri</span>
                            </label>
                            <input type="text" x-model="businessName" placeholder="Contoh: Kopi Kenangan Senopati" required class="w-full px-4 py-3 rounded-xl bg-white/5 border border-white/10 text-white placeholder-white/30 text-xs sm:text-sm focus:outline-none focus:border-brand-accent transition">
                        </div>

                        {{-- 2. Link Google Maps / Alamat --}}
                        <div>
                            <label class="block text-xs font-bold text-white/80 mb-1.5">
                                2. Link Google Maps / Alamat Lengkap Toko <span class="text-white/40 font-normal">(Opsional)</span>
                            </label>
                            <input type="text" x-model="mapsUrl" placeholder="Contoh: https://maps.app.goo.gl/... atau Jl. Sudirman No 12" class="w-full px-4 py-3 rounded-xl bg-white/5 border border-white/10 text-white placeholder-white/30 text-xs sm:text-sm focus:outline-none focus:border-brand-accent transition">
                            <p class="text-[10px] text-white/40 mt-1">Jika belum punya link maps, cukup ketik nama &amp; kota usaha Anda. Tim kami bantu carikan link review resminya.</p>
                        </div>

                        {{-- 3. Nama Pemesan & WhatsApp --}}
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <div>
                                <label class="block text-xs font-bold text-white/80 mb-1.5">
                                    3. Nama Pemesan <span class="text-rose-400">*</span>
                                </label>
                                <input type="text" x-model="customerName" placeholder="Nama Anda" required class="w-full px-4 py-3 rounded-xl bg-white/5 border border-white/10 text-white placeholder-white/30 text-xs sm:text-sm focus:outline-none focus:border-brand-accent transition">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-white/80 mb-1.5">
                                    4. No. WhatsApp Aktif <span class="text-rose-400">*</span>
                                </label>
                                <input type="tel" x-model="customerPhone" placeholder="Contoh: 081234567890" required class="w-full px-4 py-3 rounded-xl bg-white/5 border border-white/10 text-white placeholder-white/30 text-xs sm:text-sm focus:outline-none focus:border-brand-accent transition">
                            </div>
                        </div>

                        {{-- 4. Pilihan Tema Desain --}}
                        <div>
                            <label class="block text-xs font-bold text-white/80 mb-2 flex items-center justify-between">
                                <span>5. Pilihan Tema Desain:</span>
                                <span class="text-[10px] text-brand-accent font-semibold" x-text="'Terpilih: ' + currentTheme.name"></span>
                            </label>
                            <div class="grid grid-cols-3 gap-2">
                                <template x-for="(thm, idx) in themes" :key="'form-thm-' + thm.id">
                                    <button type="button" @click="setTheme(idx)" :class="themeIndex === idx ? 'border-brand-accent bg-blue-500/15 text-white shadow-glow-sm' : 'border-white/10 bg-white/5 text-white/70 hover:border-white/20'" class="p-2.5 rounded-xl border text-left transition-all flex flex-col gap-1 cursor-pointer">
                                        <div class="flex items-center gap-1.5">
                                            <span class="w-2.5 h-2.5 rounded-full shrink-0" :class="thm.dotColor"></span>
                                            <span class="text-xs font-bold truncate" x-text="thm.shortName"></span>
                                        </div>
                                        <span class="text-[9px] text-white/50 truncate" x-text="thm.subtitle"></span>
                                    </button>
                                </template>
                            </div>
                        </div>

                        {{-- 5. Pilihan Format Desain --}}
                        <div>
                            <label class="block text-xs font-bold text-white/80 mb-2">6. Pilihan Format Siap Cetak:</label>
                            <div class="grid grid-cols-2 gap-2.5">
                                <label class="flex items-center gap-2.5 p-3 rounded-xl border border-white/10 bg-white/5 cursor-pointer hover:border-brand-accent/50 transition">
                                    <input type="radio" name="designType" value="Standee Meja Akrilik" x-model="designType" class="text-blue-500 focus:ring-0">
                                    <div class="text-left">
                                        <p class="text-xs font-bold text-white">Standee Meja</p>
                                        <p class="text-[10px] text-white/50">Cocok di akrilik meja/kasir</p>
                                    </div>
                                </label>
                                <label class="flex items-center gap-2.5 p-3 rounded-xl border border-white/10 bg-white/5 cursor-pointer hover:border-brand-accent/50 transition">
                                    <input type="radio" name="designType" value="Stiker Kasir & Pintu" x-model="designType" class="text-blue-500 focus:ring-0">
                                    <div class="text-left">
                                        <p class="text-xs font-bold text-white">Stiker Kasir / Pintu</p>
                                        <p class="text-[10px] text-white/50">Cocok ditempel di etalase</p>
                                    </div>
                                </label>
                            </div>
                        </div>

                        {{-- Submit Button --}}
                        <div class="pt-2">
                            <button type="submit" :disabled="isLoading" class="w-full py-4 rounded-xl font-bold text-xs sm:text-sm text-white flex items-center justify-center gap-2 shadow-glow-sm hover:shadow-glow-blue transition-all hover:scale-[1.01] active:scale-[0.98] cursor-pointer disabled:opacity-50" style="background: linear-gradient(90deg, #2563EB, #4F46E5);">
                                <template x-if="isLoading">
                                    <span class="flex items-center gap-2">
                                        <i class="fa-solid fa-circle-notch fa-spin text-sm"></i>
                                        <span>Menyiapkan QRIS Pembayaran...</span>
                                    </span>
                                </template>
                                <template x-if="!isLoading">
                                    <span class="flex items-center gap-2">
                                        <i class="fa-solid fa-qrcode text-base"></i>
                                        <span>Lanjut Pembayaran QRIS (Rp 20.000)</span>
                                        <i class="fa-solid fa-arrow-right text-xs"></i>
                                    </span>
                                </template>
                            </button>
                            <p class="text-[11px] text-center text-white/40 mt-2.5">
                                <i class="fa-solid fa-shield-halved text-emerald-400"></i> Pembayaran aman via QRIS (BCA, Mandiri, BRI, GoPay, OVO, Dana, ShopeePay)
                            </p>
                        </div>
                    </form>
                </div>

                {{-- STEP 2: TAMPILAN QRIS RESMI (SCALIFY PAY) & KONFIRMASI WA --}}
                <div x-show="step === 'payment'" x-cloak class="text-left space-y-4">

                    {{-- Header Step 2 --}}
                    <div class="flex items-center justify-between pb-3 border-b border-white/10">
                        <button type="button" @click="step = 'form'" class="text-xs text-white/60 hover:text-white flex items-center gap-1.5 transition cursor-pointer">
                            <i class="fa-solid fa-arrow-left text-[11px]"></i> Ubah Data
                        </button>
                        <span class="text-xs font-mono font-bold text-brand-accent" x-text="orderData.order_id"></span>
                    </div>

                    {{-- QRIS Official Card Container --}}
                    <div class="bg-white rounded-2xl p-4 sm:p-5 text-slate-900 shadow-xl border border-slate-100">

                        {{-- Brand Header --}}
                        <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                            <div class="flex items-center gap-2">
                                <div class="flex items-center tracking-tighter font-extrabold text-slate-900 leading-none">
                                    <span class="text-red-600 text-lg font-black">Q</span>
                                    <span class="text-slate-900 text-lg font-black tracking-tight">RIS</span>
                                </div>
                                <span class="text-[8px] font-semibold text-slate-400 border-l border-slate-200 pl-2 uppercase tracking-wider leading-tight">
                                    Quick Response Code<br>Indonesian Standard
                                </span>
                            </div>
                            <span class="text-[9px] font-bold text-red-600 bg-red-50 border border-red-200 px-2 py-0.5 rounded">GPN &bull; DANA</span>
                        </div>

                        {{-- Total Nominal Highlight --}}
                        <div class="my-3 p-3 rounded-xl bg-slate-50 border border-slate-200 text-center">
                            <span class="text-[10px] text-slate-500 font-bold uppercase tracking-wider">Total Pembayaran</span>
                            <div class="text-2xl font-black text-slate-900 font-mono mt-0.5" x-text="'Rp ' + Number(orderData.amount).toLocaleString('id-ID')">
                            </div>
                            <div class="flex flex-wrap items-center justify-center gap-2 mt-1 text-[11px] text-slate-600">
                                <span>Usaha: <strong class="text-slate-900" x-text="businessName"></strong></span>
                                <span>&bull;</span>
                                <span>Tema: <strong class="text-blue-600" x-text="currentTheme.name"></strong></span>
                            </div>
                        </div>

                        {{-- QR Code Image --}}
                        <div class="flex flex-col items-center justify-center p-2">
                            <div class="p-2 bg-white rounded-xl border-2 border-slate-900/10 shadow-sm">
                                <img :src="orderData.qris_image_url" alt="QRIS Rp 20.000" class="w-48 h-48 sm:w-56 sm:h-56 object-contain">
                            </div>
                            <p class="text-[11px] text-slate-500 mt-2 font-medium text-center">
                                Scan QR di atas dengan <strong>BCA, Livin, BRImo, Dana, GoPay, OVO, atau ShopeePay</strong>
                            </p>
                        </div>

                        {{-- Download QRIS button --}}
                        <div class="mt-2 text-center">
                            <a :href="orderData.qris_image_url" target="_blank" download="qris-google-card-20k.png" class="inline-flex items-center gap-1.5 text-xs text-blue-600 hover:text-blue-800 font-semibold underline">
                                <i class="fa-solid fa-arrow-down-to-bracket text-[10px]"></i> Unduh QRIS / Tampilkan Besar
                            </a>
                        </div>
                    </div>

                    {{-- Next Step: WA Confirmation Button --}}
                    <div class="pt-2 space-y-2.5">
                        <div class="p-3.5 rounded-xl bg-emerald-500/15 border border-emerald-500/30 text-emerald-300 text-xs flex items-start gap-2.5">
                            <i class="fa-solid fa-circle-check text-emerald-400 text-sm mt-0.5 shrink-0"></i>
                            <div>
                                <p class="font-bold text-white mb-0.5">Langkah Terakhir:</p>
                                <p class="text-emerald-200/90 leading-relaxed">
                                    Setelah selesai transfer QRIS, klik tombol hijau di bawah untuk mengirim konfirmasi dan meminta file Google QR Code langsung ke WhatsApp Mas Andi (<strong>085221694067</strong>). File siap cetak PDF &amp; PNG HD langsung dikirim ke chat Anda.
                                </p>
                            </div>
                        </div>

                        {{-- Tombol Konfirmasi WhatsApp --}}
                        <a :href="generateWhatsAppUrl()" target="_blank" class="w-full py-4 rounded-xl font-bold text-xs sm:text-sm text-white flex items-center justify-center gap-2.5 transition-all hover:scale-[1.01] active:scale-[0.98] shadow-lg shadow-emerald-500/25 bg-gradient-to-r from-emerald-600 to-emerald-500 hover:from-emerald-500 hover:to-emerald-400 cursor-pointer">
                            <i class="fa-brands fa-whatsapp text-xl"></i>
                            <span>Saya Sudah Bayar &amp; Minta File QR Code</span>
                            <i class="fa-solid fa-arrow-up-right-from-square text-xs opacity-75"></i>
                        </a>

                        <button type="button" @click="step = 'form'" class="w-full py-2 text-center text-xs text-white/50 hover:text-white transition cursor-pointer">
                            Kembali ke Formulir
                        </button>
                    </div>

                </div>

            </div>

        </div>

        {{-- ── 4-STEP VISUAL ORDER & ACTIVATION FLOW GUIDE ── --}}
        <div class="mt-16 pt-12 border-t border-white/5">
            <div class="text-center mb-8">
                <span class="text-cyan-400 text-[11px] font-bold uppercase tracking-widest">Alur Mudah &amp; Cepat</span>
                <h3 class="text-white font-bold text-xl sm:text-2xl mt-1">Bagaimana Cara Kerja &amp; Aktivasi Kartunya?</h3>
                <p class="text-white/50 text-xs sm:text-sm max-w-xl mx-auto mt-1">Hanya butuh 4 langkah praktis dari pemesanan hingga kartu terpasang di meja kasir Anda.</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                {{-- Step 1 --}}
                <div class="p-5 rounded-2xl bg-white/[0.03] border border-white/10 hover:border-brand-accent/40 transition-all flex flex-col justify-between">
                    <div>
                        <div class="w-9 h-9 rounded-xl bg-blue-500/20 text-brand-accent font-black text-sm flex items-center justify-center mb-3">1</div>
                        <h4 class="text-white font-bold text-sm mb-1">Isi Data Usaha</h4>
                        <p class="text-white/60 text-xs leading-relaxed">Ketik nama toko/usaha Anda, link Google Maps (atau alamat), dan pilih tema favorit di formulir atas.</p>
                    </div>
                    <span class="text-[10px] text-brand-accent font-semibold mt-3 flex items-center gap-1">
                        <i class="fa-regular fa-clock"></i> Cuma 1 Menit
                    </span>
                </div>

                {{-- Step 2 --}}
                <div class="p-5 rounded-2xl bg-white/[0.03] border border-white/10 hover:border-brand-accent/40 transition-all flex flex-col justify-between">
                    <div>
                        <div class="w-9 h-9 rounded-xl bg-indigo-500/20 text-indigo-400 font-black text-sm flex items-center justify-center mb-3">2</div>
                        <h4 class="text-white font-bold text-sm mb-1">Bayar QRIS Rp 20.000</h4>
                        <p class="text-white/60 text-xs leading-relaxed">Buka m-Banking (BCA, Mandiri, BRI) atau e-Wallet (GoPay, OVO, Dana) dan scan kode QRIS otomatis.</p>
                    </div>
                    <span class="text-[10px] text-indigo-400 font-semibold mt-3 flex items-center gap-1">
                        <i class="fa-solid fa-bolt"></i> Pembayaran Instan
                    </span>
                </div>

                {{-- Step 3 --}}
                <div class="p-5 rounded-2xl bg-white/[0.03] border border-white/10 hover:border-brand-accent/40 transition-all flex flex-col justify-between">
                    <div>
                        <div class="w-9 h-9 rounded-xl bg-emerald-500/20 text-emerald-400 font-black text-sm flex items-center justify-center mb-3">3</div>
                        <h4 class="text-white font-bold text-sm mb-1">Konfirmasi ke WhatsApp</h4>
                        <p class="text-white/60 text-xs leading-relaxed">Klik tombol hijau untuk kirim bukti bayar ke WA Mas Andi (<strong>085221694067</strong>). Pesan sudah terisi otomatis.</p>
                    </div>
                    <span class="text-[10px] text-emerald-400 font-semibold mt-3 flex items-center gap-1">
                        <i class="fa-brands fa-whatsapp"></i> Chat Langsung Terhubung
                    </span>
                </div>

                {{-- Step 4 --}}
                <div class="p-5 rounded-2xl bg-white/[0.03] border border-white/10 hover:border-brand-accent/40 transition-all flex flex-col justify-between">
                    <div>
                        <div class="w-9 h-9 rounded-xl bg-cyan-500/20 text-cyan-400 font-black text-sm flex items-center justify-center mb-3">4</div>
                        <h4 class="text-white font-bold text-sm mb-1">Terima File &amp; Siap Cetak</h4>
                        <p class="text-white/60 text-xs leading-relaxed">Tim kami kirimkan file master QR dan desain siap cetak (PDF &amp; PNG HD). Anda tinggal cetak dan pasang di kasir!</p>
                    </div>
                    <span class="text-[10px] text-cyan-400 font-semibold mt-3 flex items-center gap-1">
                        <i class="fa-solid fa-print"></i> Siap Pakai Selamanya
                    </span>
                </div>
            </div>
        </div>

    </div>

</section>

{{-- Alpine.js Logic for Google Card Promo Component --}}
<script>
    function googleCardPromoApp() {
        return {
            step: 'form', // 'form' | 'payment'
            businessName: '',
            mapsUrl: '',
            customerName: '',
            customerPhone: '',
            designType: 'Standee Meja Akrilik',
            isLoading: false,
            copiedLink: false,
            copiedCaption: false,
            shareUrl: '{{ url("/google-review-card") }}',
            themeIndex: 0,
            isDragging: false,
            startX: 0,
            dragOffset: 0,
            themes: [
                {
                    id: 'white',
                    name: 'Classic White',
                    shortName: 'White',
                    subtitle: 'Clean Minimalist',
                    tag: 'Classic Clean Standee',
                    dotColor: 'bg-white border border-slate-300',
                    glowClass: 'bg-gradient-to-b from-blue-600/20 via-indigo-600/10 to-transparent',
                    cardClass: 'bg-white text-slate-900 border border-slate-100',
                    acrylicSlot: 'bg-slate-200',
                    starClass: 'fill-[#FBBC05]',
                    headlineClass: 'text-slate-800',
                    badgeClass: 'bg-slate-100 text-slate-800 border-slate-200',
                    qrBorderGradient: 'linear-gradient(135deg, #4285F4 0%, #34A853 35%, #FBBC05 70%, #EA4335 100%)',
                    qrContainerClass: 'bg-white',
                    qrLabelClass: 'text-slate-700',
                    qrWrapperClass: 'bg-white border border-slate-200',
                    qrSubClass: 'text-slate-500',
                    footerBorderClass: 'border-slate-100 text-slate-400',
                    footerBadgeClass: 'text-slate-600'
                },
                {
                    id: 'dark_gold',
                    name: 'Obsidian Gold',
                    shortName: 'Dark Gold',
                    subtitle: 'Luxury & Fancy Cafe',
                    tag: 'Obsidian Gold Edition',
                    dotColor: 'bg-amber-400 shadow-[0_0_8px_rgba(251,191,36,0.8)]',
                    glowClass: 'bg-gradient-to-b from-amber-500/25 via-yellow-600/15 to-transparent',
                    cardClass: 'bg-[#0B0F19] text-white border border-amber-500/35 shadow-[0_20px_50px_rgba(245,158,11,0.2)]',
                    acrylicSlot: 'bg-amber-400/40',
                    starClass: 'fill-[#F59E0B] drop-shadow-[0_0_4px_rgba(245,158,11,0.6)]',
                    headlineClass: 'text-amber-200',
                    badgeClass: 'bg-amber-500/15 text-amber-300 border-amber-500/40 shadow-sm',
                    qrBorderGradient: 'linear-gradient(135deg, #F59E0B 0%, #FDE68A 50%, #D97706 100%)',
                    qrContainerClass: 'bg-[#111827]',
                    qrLabelClass: 'text-amber-200',
                    qrWrapperClass: 'bg-white border border-amber-500/30 p-1',
                    qrSubClass: 'text-amber-300/60',
                    footerBorderClass: 'border-amber-500/20 text-amber-400/60',
                    footerBadgeClass: 'text-amber-300'
                },
                {
                    id: 'cyber_blue',
                    name: 'Cyber Modern Blue',
                    shortName: 'Cyber Blue',
                    subtitle: 'Retail & Modern Brand',
                    tag: 'Modern Agency Edition',
                    dotColor: 'bg-cyan-400 shadow-[0_0_8px_rgba(6,182,212,0.8)]',
                    glowClass: 'bg-gradient-to-b from-cyan-500/25 via-blue-600/15 to-transparent',
                    cardClass: 'bg-gradient-to-b from-[#0F172A] via-[#1E293B] to-[#0B1120] text-white border border-cyan-400/40 shadow-[0_20px_50px_rgba(6,182,212,0.25)]',
                    acrylicSlot: 'bg-cyan-400/40',
                    starClass: 'fill-[#FBBC05] drop-shadow-[0_0_4px_rgba(251,191,36,0.6)]',
                    headlineClass: 'text-cyan-200',
                    badgeClass: 'bg-cyan-500/15 text-cyan-300 border-cyan-400/40 shadow-sm',
                    qrBorderGradient: 'linear-gradient(135deg, #06B6D4 0%, #3B82F6 50%, #8B5CF6 100%)',
                    qrContainerClass: 'bg-[#0E172A]',
                    qrLabelClass: 'text-cyan-200',
                    qrWrapperClass: 'bg-white border border-cyan-400/30 p-1',
                    qrSubClass: 'text-cyan-300/60',
                    footerBorderClass: 'border-cyan-500/20 text-cyan-400/60',
                    footerBadgeClass: 'text-cyan-300'
                }
            ],
            orderData: {
                order_id: 'GRC-2026-DEMO',
                qris_image_url: 'https://api.qrserver.com/v1/create-qr-code/?size=250x250&data=00020101021126670016ID.DANA.WWW011893600915302105877702150000000000000000303UMI51440014ID.LINKAJA.WWW02150000000000000000303UMI5204581253033605405200005802ID5919SCALIFY%20INDONESIA6007BANDUNG61054011562070703A016304',
                amount: 20000,
            },

            get currentTheme() {
                return this.themes[this.themeIndex] || this.themes[0];
            },

            get deckThemes() {
                const len = this.themes.length;
                return [
                    this.themes[this.themeIndex],
                    this.themes[(this.themeIndex + 1) % len],
                    this.themes[(this.themeIndex + 2) % len],
                ];
            },

            nextTheme() {
                this.themeIndex = (this.themeIndex + 1) % this.themes.length;
            },

            prevTheme() {
                this.themeIndex = (this.themeIndex - 1 + this.themes.length) % this.themes.length;
            },

            setTheme(idx) {
                this.themeIndex = idx;
            },

            // Touch Swipe Handlers (Mobile)
            handleTouchStart(e) {
                if (e.touches && e.touches.length > 0) {
                    this.startX = e.touches[0].clientX;
                    this.isDragging = true;
                    this.dragOffset = 0;
                }
            },

            handleTouchMove(e) {
                if (!this.isDragging || !e.touches || e.touches.length === 0) return;
                const currentX = e.touches[0].clientX;
                this.dragOffset = currentX - this.startX;
            },

            handleTouchEnd() {
                if (!this.isDragging) return;
                this.isDragging = false;
                if (this.dragOffset < -40) {
                    this.nextTheme();
                } else if (this.dragOffset > 40) {
                    this.prevTheme();
                }
                this.dragOffset = 0;
            },

            // Mouse Drag Handlers (Desktop)
            handleMouseDown(e) {
                this.startX = e.clientX;
                this.isDragging = true;
                this.dragOffset = 0;
            },

            handleMouseMove(e) {
                if (!this.isDragging) return;
                this.dragOffset = e.clientX - this.startX;
            },

            handleMouseUp() {
                if (!this.isDragging) return;
                this.isDragging = false;
                if (this.dragOffset < -40) {
                    this.nextTheme();
                } else if (this.dragOffset > 40) {
                    this.prevTheme();
                }
                this.dragOffset = 0;
            },

            handleMouseLeave() {
                if (this.isDragging) {
                    this.handleMouseUp();
                }
            },

            async proceedToPayment() {
                if (!this.businessName.trim() || !this.customerName.trim() || !this.customerPhone.trim()) {
                    alert('Silakan lengkapi nama usaha, nama pemesan, dan no WhatsApp Anda.');
                    return;
                }

                this.isLoading = true;
                try {
                    const response = await fetch('{{ route("landing.google_card.qris") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            business_name: this.businessName,
                            google_maps_url: this.mapsUrl,
                            customer_name: this.customerName,
                            phone: this.customerPhone,
                            design_type: this.designType,
                            theme: this.currentTheme.name
                        })
                    });

                    const res = await response.json();
                    if (res.success && res.data) {
                        this.orderData = res.data;
                        this.step = 'payment';
                    } else {
                        this.orderData.order_id = 'GRC-' + Math.floor(1000 + Math.random() * 9000);
                        this.step = 'payment';
                    }
                } catch (e) {
                    console.error('QRIS error:', e);
                    this.orderData.order_id = 'GRC-' + Math.floor(1000 + Math.random() * 9000);
                    this.step = 'payment';
                } finally {
                    this.isLoading = false;
                }
            },

            generateWhatsAppUrl() {
                const adminPhone = '6285221694067';
                const text = `Halo Mas Andi / Scalify! 👋
Saya sudah transfer Rp 20.000 via QRIS untuk pembuatan Google Review Card.

📋 Detail Pemesanan:
• Order ID: ${this.orderData.order_id || '-'}
• Nama Usaha: ${this.businessName}
• Link/Alamat Maps: ${this.mapsUrl || '-'}
• Pilihan Tema: ${this.currentTheme.name}
• Format Desain: ${this.designType}
• Nama Pemesan: ${this.customerName}
• No WhatsApp: ${this.customerPhone}

Berikut saya lampirkan bukti transfer pembayarannya. Mohon bantu proses dan kirimkan file Google QR Code serta desain siap cetaknya ya mas. Terima kasih banyak!`;

                return 'https://wa.me/' + adminPhone + '?text=' + encodeURIComponent(text);
            },

            copyPromoLink() {
                const trackedUrl = this.shareUrl + (this.shareUrl.includes('?') ? '&' : '?') + 'src=share';
                navigator.clipboard.writeText(trackedUrl).then(() => {
                    this.copiedLink = true;
                    setTimeout(() => this.copiedLink = false, 2500);
                });
            },

            copyCaption() {
                const trackedUrl = this.shareUrl + (this.shareUrl.includes('?') ? '&' : '?') + 'src=threads';
                const caption = `Punya usaha toko, cafe, resto, klinik, atau barbershop tapi sepi ulasan Google Maps? ⭐⭐⭐⭐⭐

Sekarang kamu bisa punya Google Review Card siap cetak cuma Rp 20.000! Pelanggan tinggal scan QR pakai HP mereka, halaman bintang 5 langsung terbuka otomatis.

👉 Pesan langsung di sini (proses cepat 5 menit jadi):
${trackedUrl}`;

                navigator.clipboard.writeText(caption).then(() => {
                    this.copiedCaption = true;
                    setTimeout(() => this.copiedCaption = false, 2500);
                });
            }
        };
    }
</script>
