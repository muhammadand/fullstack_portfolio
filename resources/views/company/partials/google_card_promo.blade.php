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
                <div class="w-full max-w-[340px] relative select-none touch-pan-y" @touchstart="handleTouchStart($event)" @touchmove="handleTouchMove($event)" @touchend="handleTouchEnd($event)" @mousedown="handleMouseDown($event)" @mousemove="handleMouseMove($event)" @mouseup="handleMouseUp($event)" @mouseleave="handleMouseLeave($event)">

                    {{-- Dynamic Ambient Glow behind deck --}}
                    <div class="absolute -inset-3 rounded-[36px] blur-xl opacity-75 transition-all duration-500 pointer-events-none" :class="currentTheme.glowClass"></div>

                    {{-- ── DECK LAYER 3 (Paling Belakang) ── --}}
                    <div class="absolute inset-0 rounded-[28px] transform scale-[0.88] translate-y-5 opacity-25 border border-white/10 shadow-lg pointer-events-none transition-all duration-300" :class="deckThemes[2].cardClass">
                    </div>

                    {{-- ── DECK LAYER 2 (Di Tengah Tumpukan) ── --}}
                    <div class="absolute inset-0 rounded-[28px] transform scale-[0.94] translate-y-2.5 opacity-50 border border-white/15 shadow-xl pointer-events-none transition-all duration-300" :class="deckThemes[1].cardClass">
                    </div>

                    {{-- ── DECK LAYER 1 (KARTU UTAMA AKTIF - BISA DI-SWIPE / GESER) ── --}}
                    <div class="relative rounded-[28px] p-6 shadow-2xl flex flex-col items-center text-center transition-all select-none" :class="[currentTheme.cardClass, isDragging ? 'cursor-grabbing scale-[1.02]' : 'cursor-grab']" :style="{
                             transform: 'translateX(' + dragOffset + 'px) rotate(' + (dragOffset * 0.04) + 'deg)',
                             transition: isDragging ? 'none' : 'transform 0.35s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.3s ease'
                         }" style="box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.65); font-family: 'Outfit', sans-serif;">

                        {{-- Floating Swipe Direction Hint Badge on Card Drag --}}
                        <div x-show="Math.abs(dragOffset) > 20" x-cloak class="absolute top-3 left-1/2 -translate-x-1/2 px-3 py-1 rounded-full text-[10px] font-extrabold uppercase tracking-wider backdrop-blur-md transition-all shadow-md z-30" :class="dragOffset < 0 ? 'bg-cyan-500 text-white' : 'bg-amber-500 text-slate-950'">
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
                                    <template x-if="customerQrDataUrl">
                                        <img :src="customerQrDataUrl" alt="QR Code Mockup" class="w-full h-full object-contain pointer-events-none">
                                    </template>
                                    <template x-if="!customerQrDataUrl">
                                        <div class="w-full h-full flex items-center justify-center text-slate-300">
                                            <i class="fa-solid fa-qrcode text-5xl"></i>
                                        </div>
                                    </template>
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
                        <button type="button" @click="step = 'form'; stopPolling();" class="text-xs text-white/60 hover:text-white flex items-center gap-1.5 transition cursor-pointer">
                            <i class="fa-solid fa-arrow-left text-[11px]"></i> Ubah Data
                        </button>
                        <span class="text-xs font-mono font-bold text-brand-accent" x-text="orderData.order_id"></span>
                    </div>

                    {{-- Status Banner Realtime (Jika Terdeteksi Lunas) --}}
                    <template x-if="isPaid">
                        <div class="p-4 rounded-2xl bg-emerald-500/20 border border-emerald-400/50 text-emerald-200 text-center space-y-2 shadow-lg shadow-emerald-950/40">
                            <div class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-emerald-500 text-white text-lg shadow-md mb-1 animate-bounce">
                                <i class="fa-solid fa-check"></i>
                            </div>
                            <h4 class="text-white font-bold text-sm sm:text-base">Pembayaran Berhasil Dikonfirmasi Lunas!</h4>
                            <p class="text-xs text-emerald-300">File master Google Review Card siap cetak Anda sudah tersedia untuk diunduh.</p>
                            <button type="button" @click="openSuccessModal()" class="mt-2 px-5 py-2.5 rounded-xl bg-gradient-to-r from-emerald-500 to-cyan-500 hover:from-emerald-400 hover:to-cyan-400 text-slate-950 font-black text-xs uppercase tracking-wider inline-flex items-center gap-2 shadow-lg shadow-emerald-500/30 transition-all hover:scale-[1.02] cursor-pointer">
                                <i class="fa-solid fa-download"></i>
                                <span>Buka Pop-up Unduh File (PDF &amp; PNG)</span>
                            </button>
                        </div>
                    </template>

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
                            <span class="text-[9px] font-bold text-red-600 bg-red-50 border border-red-200 px-2 py-0.5 rounded">GPN &bull; SCALIFY PAY</span>
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
                            <div class="p-2 bg-white rounded-xl border-2 border-slate-900/10 shadow-sm flex items-center justify-center min-h-[200px]">
                                <template x-if="effectiveQrisImageUrl">
                                    <img :src="effectiveQrisImageUrl" alt="QRIS Rp 20.000" class="w-48 h-48 sm:w-56 sm:h-56 object-contain block" style="image-rendering: -webkit-optimize-contrast; shape-rendering: crispEdges;">
                                </template>
                                <template x-if="!effectiveQrisImageUrl">
                                    <div class="w-48 h-48 flex flex-col items-center justify-center text-slate-400 gap-2">
                                        <i class="fa-solid fa-circle-notch fa-spin text-2xl text-blue-500"></i>
                                        <span class="text-[11px] font-medium">Memuat QRIS...</span>
                                    </div>
                                </template>
                            </div>
                            <div class="mt-2 text-center space-y-1">
                                <div class="flex items-center justify-center gap-1.5 text-[11px] font-semibold" :class="isPaid ? 'text-emerald-600' : 'text-slate-600'">
                                    <span class="w-2 h-2 rounded-full" :class="isPaid ? 'bg-emerald-500' : 'bg-amber-400 animate-ping'"></span>
                                    <span x-text="isPaid ? 'Pembayaran Lunas (Terverifikasi)' : 'Menunggu pembayaran otomatis via QRIS...'"></span>
                                </div>
                                <p class="text-[10px] text-slate-400 font-medium">
                                    Buka aplikasi <strong>BCA, Livin, BRImo, Dana, GoPay, OVO, atau ShopeePay</strong> lalu scan QR di atas
                                </p>
                            </div>
                        </div>

                        {{-- Download QRIS button --}}
                        <div class="mt-2 text-center">
                            <a :href="effectiveQrisImageUrl" target="_blank" download="qris-google-card-20k.png" class="inline-flex items-center gap-1.5 text-xs text-blue-600 hover:text-blue-800 font-semibold underline">
                                <i class="fa-solid fa-arrow-down-to-bracket text-[10px]"></i> Unduh QRIS / Tampilkan Besar
                            </a>
                        </div>

                        {{-- Manual Check Status --}}
                        <div class="mt-3 pt-3 border-t border-slate-100 flex items-center justify-center">
                            <button type="button" @click="checkStatusManual()" :disabled="isCheckingStatus" class="px-4 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold flex items-center gap-2 transition cursor-pointer disabled:opacity-50">
                                <i :class="isCheckingStatus ? 'fa-solid fa-circle-notch fa-spin text-blue-600' : 'fa-solid fa-rotate text-blue-600'"></i>
                                <span x-text="isCheckingStatus ? 'Mengecek Pembayaran...' : 'Cek Status Pembayaran'"></span>
                            </button>
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

    {{-- ══════════════════════════════════════════════════════════
         POP-UP MODAL: SUDAH BAYAR / LUNAS — WAJIB DOWNLOAD FILE
         ══════════════════════════════════════════════════════════ --}}
    <div x-show="showSuccessModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-3 sm:p-6 overflow-y-auto" role="dialog" aria-modal="true" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">

        {{-- Dark Backdrop Blur --}}
        <div class="fixed inset-0 bg-slate-950/85 backdrop-blur-md transition-opacity" @click="showSuccessModal = false"></div>

        {{-- Modal Box Container (2-Column Professional Layout) --}}
        <div class="relative w-full max-w-4xl lg:max-w-5xl bg-[#0B0F19] border border-white/10 rounded-3xl p-5 sm:p-7 shadow-[0_25px_70px_rgba(0,0,0,0.6)] my-auto z-10 text-white max-h-[92vh] overflow-y-auto" x-transition:enter="transition ease-out duration-300 transform" x-transition:enter-start="opacity-0 scale-95 translate-y-4" x-transition:enter-end="opacity-100 scale-100 translate-y-0" x-transition:leave="transition ease-in duration-200 transform" x-transition:leave-start="opacity-100 scale-100 translate-y-0" x-transition:leave-end="opacity-0 scale-95 translate-y-4">

            {{-- Ambient Top Glow --}}
            <div class="absolute -top-24 left-1/2 -translate-x-1/2 w-72 h-72 bg-emerald-500/15 blur-[100px] rounded-full pointer-events-none"></div>

            {{-- Header Bar --}}
            <div class="flex items-start justify-between pb-4 border-b border-white/10 relative">
                <div class="flex items-center gap-3">
                    <div class="w-11 h-11 rounded-2xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 flex items-center justify-center shrink-0">
                        <i class="fa-solid fa-circle-check text-xl"></i>
                    </div>
                    <div>
                        <div class="flex items-center gap-2">
                            <h3 class="text-lg sm:text-xl font-bold text-white tracking-tight">Pembayaran Berhasil</h3>
                            <span class="px-2 py-0.5 rounded-full bg-emerald-500/10 border border-emerald-500/30 text-emerald-300 text-[10px] font-semibold tracking-wide">
                                Lunas
                            </span>
                        </div>
                        <p class="text-xs text-slate-400 mt-0.5">
                            Terima kasih, <strong class="text-white" x-text="customerName || 'Kak'"></strong>! Desain Google Review Card untuk <strong class="text-cyan-300" x-text="businessName || 'Usaha Anda'"></strong> sudah siap diunduh.
                        </p>
                    </div>
                </div>

                {{-- Close Button --}}
                <button type="button" @click="showSuccessModal = false" class="w-8 h-8 rounded-xl bg-white/5 hover:bg-white/10 text-slate-400 hover:text-white flex items-center justify-center transition cursor-pointer" title="Tutup Jendela">
                    <i class="fa-solid fa-xmark text-sm"></i>
                </button>
            </div>

            {{-- 2-Column Side-by-Side Content Grid --}}
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start mt-5">

                {{-- ── LEFT: CARD & QR CODE PREVIEW (5 Cols) ── --}}
                <div class="lg:col-span-5 flex flex-col items-center">
                    <div class="w-full bg-slate-950/50 border border-white/5 rounded-2xl p-4 flex flex-col items-center">
                        <span class="text-[11px] font-semibold text-slate-400 tracking-wider uppercase mb-3 flex items-center gap-1.5">
                            <i class="fa-solid fa-eye text-cyan-400 text-xs"></i> Preview Desain Kartu
                        </span>

                        {{-- THE PRINTABLE CARD NODE (Rendered by html2canvas & jsPDF) --}}
                        <div id="printableCardNode" class="w-[260px] sm:w-[280px] rounded-[22px] p-4 sm:p-5 shadow-2xl flex flex-col items-center text-center relative select-none box-border border" :class="currentTheme.cardClass" style="font-family: 'Outfit', sans-serif;">

                            {{-- Acrylic Top Slot --}}
                            <div class="w-9 h-1.5 rounded-full mb-2.5" :class="currentTheme.acrylicSlot"></div>

                            {{-- Official Google Emblem --}}
                            <div class="w-9 h-9 mb-1 flex items-center justify-center">
                                <svg class="w-full h-full" viewBox="0 0 24 24">
                                    <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" />
                                    <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" />
                                    <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.06H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.94l2.85-2.22.81-.63z" />
                                    <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.06l3.66 2.84c.87-2.6 3.3-4.52 6.16-4.52z" />
                                </svg>
                            </div>

                            {{-- Business Name Badge --}}
                            <div class="my-1 px-3 py-0.5 rounded-full text-xs font-bold max-w-[230px] truncate border" :class="currentTheme.badgeClass">
                                <span x-text="businessName || 'Nama Toko Anda'"></span>
                            </div>

                            {{-- Bantu Ulas Kami di Google --}}
                            <p class="font-medium text-[11px] leading-tight mb-0.5" :class="currentTheme.headlineClass">Bantu Ulas Kami di</p>
                            <div class="flex items-center justify-center my-0.5 mb-1.5">
                                <svg viewBox="0 0 272 92" class="h-4 sm:h-5 w-auto">
                                    <path fill="#EA4335" d="M115.75 47.18c0 12.77-9.99 22.18-22.25 22.18s-22.25-9.41-22.25-22.18C71.25 34.32 81.24 25 93.5 25s22.25 9.32 22.25 22.18zm-9.74 0c0-7.98-5.79-13.44-12.51-13.44S80.99 39.2 80.99 47.18c0 7.9 5.79 13.44 12.51 13.44s12.51-5.55 12.51-13.44z" />
                                    <path fill="#FBBC05" d="M163.75 47.18c0 12.77-9.99 22.18-22.25 22.18s-22.25-9.41-22.25-22.18c0-12.85 9.99-22.18 22.25-22.18s22.25 9.32 22.25 22.18zm-9.74 0c0-7.98-5.79-13.44-12.51-13.44s-12.51 5.46-12.51 13.44c0 7.9 5.79 13.44 12.51 13.44s12.51-5.55 12.51-13.44z" />
                                    <path fill="#4285F4" d="M209.75 26.34v39.82c0 16.38-9.66 23.07-21.08 23.07-10.75 0-17.22-7.19-19.66-13.07l8.48-3.53c1.51 3.61 5.21 8.19 11.17 8.19 7.31 0 11.84-4.53 11.84-13.02v-3.19h-.34c-2.18 2.69-6.38 5.04-11.68 5.04-11.09 0-21.25-9.66-21.25-22.09 0-12.52 10.16-22.26 21.25-22.26 5.29 0 9.49 2.35 11.68 4.96h.34v-3.92h9.45zm-8.82 20.92c0-7.81-5.21-13.44-11.84-13.44-6.72 0-12.35 5.63-12.35 13.44 0 7.72 5.63 13.35 12.35 13.35 6.63 0 11.84-5.63 11.84-13.35z" />
                                    <path fill="#34A853" d="M225 3v65h-9.5V3h9.5z" />
                                    <path fill="#EA4335" d="M262.02 54.48l7.56 5.04c-2.44 3.61-8.32 9.83-18.48 9.83-12.6 0-22.01-9.74-22.01-22.18 0-13.19 9.49-22.18 20.92-22.18 11.51 0 17.14 9.16 18.98 14.11l1.01 2.52-29.65 12.28c2.27 4.45 5.8 6.72 10.75 6.72 4.96 0 8.4-2.44 10.92-6.14zm-13.78-8.15l19.82-8.23c-1.09-2.77-4.37-4.7-8.23-4.7-4.95 0-11.84 4.37-11.59 12.93z" />
                                    <path fill="#4285F4" d="M35.29 41.41V32H67c.31 1.64.47 3.58.47 5.68 0 7.06-1.93 15.79-8.15 22.01-6.05 6.3-13.78 9.66-24.02 9.66C16.32 69.35.36 53.89.36 34.91.36 15.93 16.32.47 35.3.47c10.5 0 17.98 4.12 23.6 9.49l-6.64 6.64c-4.03-3.78-9.49-6.72-16.97-6.72-13.86 0-24.7 11.17-24.7 25.03 0 13.86 10.84 25.03 24.7 25.03 8.99 0 14.11-3.61 17.39-6.89 2.69-2.69 4.45-6.55 5.12-11.64H35.29z" />
                                </svg>
                            </div>

                            {{-- 5 Gold Stars Rating --}}
                            <div class="flex items-center justify-center gap-1 mb-1.5">
                                <template x-for="i in 5">
                                    <i class="fa-solid fa-star text-xs" :class="currentTheme.starClass"></i>
                                </template>
                            </div>

                            {{-- QR Container with dynamic gradient border --}}
                            <div class="w-full p-[2px] rounded-2xl my-1 shadow-sm" :style="'background: ' + currentTheme.qrBorderGradient">
                                <div class="w-full rounded-[14px] p-2 flex flex-col items-center" :class="currentTheme.qrContainerClass">
                                    <p class="text-[9px] font-bold tracking-wide mb-1" :class="currentTheme.qrLabelClass">SCAN QR REVIEW</p>

                                    {{-- QR Code Image for customer review --}}
                                    <div class="w-28 h-28 relative flex items-center justify-center p-1 rounded-xl" :class="currentTheme.qrWrapperClass">
                                        <img :src="customerQrDataUrl" alt="QR Code Google Review" class="w-full h-full object-contain block" style="image-rendering: -webkit-optimize-contrast; shape-rendering: crispEdges;">
                                        <div class="absolute inset-0 flex items-center justify-center pointer-events-none">
                                            <div class="w-6 h-6 rounded-full bg-white shadow-md flex items-center justify-center p-0.5 border border-slate-100">
                                                <svg class="w-3.5 h-3.5" viewBox="0 0 24 24">
                                                    <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" />
                                                    <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" />
                                                    <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.06H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.94l2.85-2.22.81-.63z" />
                                                    <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.06l3.66 2.84c.87-2.6 3.3-4.52 6.16-4.52z" />
                                                </svg>
                                            </div>
                                        </div>
                                    </div>

                                    <p class="text-[8px] mt-1 font-medium" :class="currentTheme.qrSubClass">Arahkan kamera HP ke QR</p>
                                </div>
                            </div>

                            {{-- Footer --}}
                            <div class="w-full pt-1.5 mt-1 flex items-center justify-between text-[8px] border-t" :class="currentTheme.footerBorderClass">
                                <span class="font-semibold flex items-center gap-1" :class="currentTheme.footerBadgeClass">
                                    <i class="fa-solid fa-certificate"></i> <span x-text="currentTheme.tag"></span>
                                </span>
                                <span class="font-mono opacity-75">Scalify &bull; 300 DPI</span>
                            </div>
                        </div>

                        <p class="text-[10px] text-slate-400 mt-2.5 text-center flex items-center justify-center gap-1.5">
                            <i class="fa-solid fa-circle-info text-slate-400"></i> Standee Akrilik Meja A6 (10.5 &times; 14.8 cm)
                        </p>
                    </div>
                </div>

                {{-- ── RIGHT: INFORMATION & DOWNLOAD ACTIONS (7 Cols) ── --}}
                <div class="lg:col-span-7 flex flex-col gap-3">

                    {{-- Metadata Info Bar --}}
                    <div class="p-3.5 rounded-2xl bg-white/[0.03] border border-white/10 flex flex-wrap items-center justify-between gap-2">
                        <div class="flex flex-wrap items-center gap-2 text-xs">
                            <span class="text-slate-400 font-mono text-[11px]">Order: <strong class="text-white" x-text="orderData.order_id"></strong></span>
                            <span class="text-white/20">&bull;</span>
                            <span class="text-slate-400 text-[11px]">Format: <strong class="text-slate-200" x-text="designType"></strong></span>
                            <span class="text-white/20">&bull;</span>
                            <span class="text-slate-400 text-[11px]">Tema: <strong class="text-cyan-300" x-text="currentTheme.name"></strong></span>
                        </div>
                        <template x-if="reviewCard">
                            <a :href="reviewCard.scan_url || reviewCard.google_review_url" target="_blank" class="text-cyan-400 hover:text-cyan-300 text-[11px] font-medium underline flex items-center gap-1">
                                <i class="fa-solid fa-arrow-up-right-from-square text-[9px]"></i>
                                <span>Tes Link Ulasan Google</span>
                            </a>
                        </template>
                    </div>

                    {{-- Soft Information Callout --}}
                    <div class="p-3.5 rounded-2xl bg-blue-500/10 border border-blue-500/20 text-xs flex items-start gap-3">
                        <div class="w-8 h-8 rounded-xl bg-blue-500/20 text-cyan-300 flex items-center justify-center shrink-0 mt-0.5">
                            <i class="fa-solid fa-download text-xs"></i>
                        </div>
                        <div>
                            <p class="font-bold text-white text-xs mb-0.5">Simpan Berkas Master Cetak</p>
                            <p class="text-slate-300 text-[11px] leading-relaxed">
                                Unduh file siap cetak beresolusi tinggi di bawah ini untuk disimpan di perangkat Anda dan dibawa ke percetakan terdekat.
                            </p>
                        </div>
                    </div>

                    {{-- Download Buttons List --}}
                    <div class="space-y-2.5 mt-1">
                        <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block">Pilih Berkas yang Ingin Diunduh:</span>

                        {{-- Button 1: PDF Siap Cetak --}}
                        <button type="button" @click="downloadPdf()" :disabled="isDownloadingPdf" class="w-full p-3.5 rounded-2xl bg-slate-900/80 hover:bg-slate-800/90 border border-slate-700/60 hover:border-blue-500/50 text-white transition-all flex items-center justify-between group cursor-pointer disabled:opacity-50">
                            <div class="flex items-center gap-3 text-left">
                                <div class="w-10 h-10 rounded-xl bg-red-500/10 border border-red-500/20 text-red-400 flex items-center justify-center shrink-0 group-hover:scale-105 transition-transform">
                                    <template x-if="!isDownloadingPdf">
                                        <i class="fa-solid fa-file-pdf text-lg"></i>
                                    </template>
                                    <template x-if="isDownloadingPdf">
                                        <i class="fa-solid fa-circle-notch fa-spin text-white text-lg"></i>
                                    </template>
                                </div>
                                <div>
                                    <div class="flex items-center gap-2">
                                        <span class="font-bold text-xs sm:text-sm text-white group-hover:text-cyan-300 transition-colors">1. PDF Siap Cetak (A6)</span>
                                        <span x-show="pdfDownloaded" x-cloak class="px-2 py-0.5 rounded-md bg-emerald-500/20 border border-emerald-500/30 text-emerald-300 text-[10px] font-semibold flex items-center gap-1">
                                            <i class="fa-solid fa-check text-[9px]"></i> Tersimpan
                                        </span>
                                    </div>
                                    <p class="text-[11px] text-slate-400">Standar percetakan akrilik meja &bull; 300 DPI</p>
                                </div>
                            </div>
                            <div class="px-3 py-1.5 rounded-xl bg-white/5 border border-white/10 text-xs font-semibold text-slate-300 group-hover:bg-blue-600 group-hover:text-white transition-all flex items-center gap-1.5 shrink-0">
                                <span x-text="isDownloadingPdf ? 'Membuat...' : 'Unduh PDF'"></span>
                                <i class="fa-solid fa-arrow-down text-[10px]"></i>
                            </div>
                        </button>

                        {{-- Button 2: Desain Kartu (PNG HD) --}}
                        <button type="button" @click="downloadCardPng()" :disabled="isDownloadingPng" class="w-full p-3.5 rounded-2xl bg-slate-900/80 hover:bg-slate-800/90 border border-slate-700/60 hover:border-cyan-500/50 text-white transition-all flex items-center justify-between group cursor-pointer disabled:opacity-50">
                            <div class="flex items-center gap-3 text-left">
                                <div class="w-10 h-10 rounded-xl bg-cyan-500/10 border border-cyan-500/20 text-cyan-400 flex items-center justify-center shrink-0 group-hover:scale-105 transition-transform">
                                    <template x-if="!isDownloadingPng">
                                        <i class="fa-solid fa-image text-lg"></i>
                                    </template>
                                    <template x-if="isDownloadingPng">
                                        <i class="fa-solid fa-circle-notch fa-spin text-white text-lg"></i>
                                    </template>
                                </div>
                                <div>
                                    <div class="flex items-center gap-2">
                                        <span class="font-bold text-xs sm:text-sm text-white group-hover:text-cyan-300 transition-colors">2. Desain Kartu (PNG HD)</span>
                                        <span x-show="pngDownloaded" x-cloak class="px-2 py-0.5 rounded-md bg-emerald-500/20 border border-emerald-500/30 text-emerald-300 text-[10px] font-semibold flex items-center gap-1">
                                            <i class="fa-solid fa-check text-[9px]"></i> Tersimpan
                                        </span>
                                    </div>
                                    <p class="text-[11px] text-slate-400">Gambar jernih untuk sosmed &amp; cetak foto</p>
                                </div>
                            </div>
                            <div class="px-3 py-1.5 rounded-xl bg-white/5 border border-white/10 text-xs font-semibold text-slate-300 group-hover:bg-cyan-600 group-hover:text-white transition-all flex items-center gap-1.5 shrink-0">
                                <span x-text="isDownloadingPng ? 'Memproses...' : 'Unduh PNG'"></span>
                                <i class="fa-solid fa-arrow-down text-[10px]"></i>
                            </div>
                        </button>

                        {{-- Button 3: QR Code Saja (PNG) --}}
                        <button type="button" @click="downloadQrPng()" :disabled="isDownloadingQr" class="w-full p-3.5 rounded-2xl bg-slate-900/80 hover:bg-slate-800/90 border border-slate-700/60 hover:border-amber-500/50 text-white transition-all flex items-center justify-between group cursor-pointer disabled:opacity-50">
                            <div class="flex items-center gap-3 text-left">
                                <div class="w-10 h-10 rounded-xl bg-amber-500/10 border border-amber-500/20 text-amber-400 flex items-center justify-center shrink-0 group-hover:scale-105 transition-transform">
                                    <template x-if="!isDownloadingQr">
                                        <i class="fa-solid fa-qrcode text-lg"></i>
                                    </template>
                                    <template x-if="isDownloadingQr">
                                        <i class="fa-solid fa-circle-notch fa-spin text-white text-lg"></i>
                                    </template>
                                </div>
                                <div>
                                    <div class="flex items-center gap-2">
                                        <span class="font-bold text-xs sm:text-sm text-white group-hover:text-amber-300 transition-colors">3. QR Code Khusus (PNG)</span>
                                        <span x-show="qrDownloaded" x-cloak class="px-2 py-0.5 rounded-md bg-emerald-500/20 border border-emerald-500/30 text-emerald-300 text-[10px] font-semibold flex items-center gap-1">
                                            <i class="fa-solid fa-check text-[9px]"></i> Tersimpan
                                        </span>
                                    </div>
                                    <p class="text-[11px] text-slate-400">File QR murni untuk nota, kemasan, atau stiker kasir</p>
                                </div>
                            </div>
                            <div class="px-3 py-1.5 rounded-xl bg-white/5 border border-white/10 text-xs font-semibold text-slate-300 group-hover:bg-amber-600 group-hover:text-white transition-all flex items-center gap-1.5 shrink-0">
                                <span x-text="isDownloadingQr ? 'Menyiapkan...' : 'Unduh QR'"></span>
                                <i class="fa-solid fa-arrow-down text-[10px]"></i>
                            </div>
                        </button>
                    </div>

                    {{-- WhatsApp Backup Option --}}
                    <div class="mt-2 p-3 rounded-2xl bg-white/[0.02] border border-white/5 flex items-center justify-between gap-3 text-xs">
                        <div class="flex items-center gap-2.5">
                            <i class="fa-brands fa-whatsapp text-emerald-400 text-base shrink-0"></i>
                            <span class="text-slate-300 text-[11px]">Butuh bantuan cetak atau file dikirim via WA?</span>
                        </div>
                        <a :href="generateWhatsAppUrl()" target="_blank" class="px-3 py-1.5 rounded-xl bg-emerald-600/20 hover:bg-emerald-600/30 border border-emerald-500/40 text-emerald-300 text-[11px] font-semibold flex items-center gap-1.5 transition shrink-0">
                            <span>Chat Admin</span>
                            <i class="fa-solid fa-arrow-up-right-from-square text-[9px]"></i>
                        </a>
                    </div>

                </div>

            </div>

            {{-- Modal Footer --}}
            <div class="mt-6 pt-4 border-t border-white/10 flex items-center justify-between text-xs">
                <span class="text-[11px] text-slate-400 flex items-center gap-1.5">
                    <i class="fa-solid fa-circle-check text-emerald-400"></i> Berkas tersimpan &bull; Siap dicetak
                </span>
                <button type="button" @click="showSuccessModal = false" class="px-5 py-2 rounded-xl bg-white/10 hover:bg-white/15 text-white text-xs font-semibold transition cursor-pointer">
                    Selesai &amp; Tutup
                </button>
            </div>

        </div>
    </div>

</section>

{{-- Client-Side PDF, Canvas, QRCode & Confetti Libraries --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.9.2/dist/confetti.browser.min.js"></script>

{{-- Alpine.js Logic for Google Card Promo Component --}}
<script>
    function googleCardPromoApp() {
        return {
            step: 'form', // 'form' | 'payment'
            businessName: ''
            , mapsUrl: ''
            , customerName: ''
            , customerPhone: ''
            , designType: 'Standee Meja Akrilik'
            , isLoading: false
            , isPaid: false
            , showSuccessModal: false
            , reviewCard: null
            , customerQrDataUrl: ''
            , isCheckingStatus: false
            , isDownloadingPdf: false
            , isDownloadingPng: false
            , isDownloadingQr: false
            , pdfDownloaded: false
            , pngDownloaded: false
            , qrDownloaded: false
            , pollTimer: null
            , copiedLink: false
            , copiedCaption: false
            , shareUrl: '{{ url("/google-review-card") }}'
            , themeIndex: 0
            , isDragging: false
            , startX: 0
            , dragOffset: 0
            , themes: [{
                    id: 'white'
                    , name: 'Classic White'
                    , shortName: 'White'
                    , subtitle: 'Clean Minimalist'
                    , tag: 'Classic Clean Standee'
                    , dotColor: 'bg-white border border-slate-300'
                    , glowClass: 'bg-gradient-to-b from-blue-600/20 via-indigo-600/10 to-transparent'
                    , cardClass: 'bg-white text-slate-900 border border-slate-100'
                    , acrylicSlot: 'bg-slate-200'
                    , starClass: 'fill-[#FBBC05]'
                    , headlineClass: 'text-slate-800'
                    , badgeClass: 'bg-slate-100 text-slate-800 border-slate-200'
                    , qrBorderGradient: 'linear-gradient(135deg, #4285F4 0%, #34A853 35%, #FBBC05 70%, #EA4335 100%)'
                    , qrContainerClass: 'bg-white'
                    , qrLabelClass: 'text-slate-700'
                    , qrWrapperClass: 'bg-white border border-slate-200'
                    , qrSubClass: 'text-slate-500'
                    , footerBorderClass: 'border-slate-100 text-slate-400'
                    , footerBadgeClass: 'text-slate-600'
                }
                , {
                    id: 'dark_gold'
                    , name: 'Obsidian Gold'
                    , shortName: 'Dark Gold'
                    , subtitle: 'Luxury & Fancy Cafe'
                    , tag: 'Obsidian Gold Edition'
                    , dotColor: 'bg-amber-400 shadow-[0_0_8px_rgba(251,191,36,0.8)]'
                    , glowClass: 'bg-gradient-to-b from-amber-500/25 via-yellow-600/15 to-transparent'
                    , cardClass: 'bg-[#0B0F19] text-white border border-amber-500/35 shadow-[0_20px_50px_rgba(245,158,11,0.2)]'
                    , acrylicSlot: 'bg-amber-400/40'
                    , starClass: 'fill-[#F59E0B] drop-shadow-[0_0_4px_rgba(245,158,11,0.6)]'
                    , headlineClass: 'text-amber-200'
                    , badgeClass: 'bg-amber-500/15 text-amber-300 border-amber-500/40 shadow-sm'
                    , qrBorderGradient: 'linear-gradient(135deg, #F59E0B 0%, #FDE68A 50%, #D97706 100%)'
                    , qrContainerClass: 'bg-[#111827]'
                    , qrLabelClass: 'text-amber-200'
                    , qrWrapperClass: 'bg-white border border-amber-500/30 p-1'
                    , qrSubClass: 'text-amber-300/60'
                    , footerBorderClass: 'border-amber-500/20 text-amber-400/60'
                    , footerBadgeClass: 'text-amber-300'
                }
                , {
                    id: 'cyber_blue'
                    , name: 'Cyber Modern Blue'
                    , shortName: 'Cyber Blue'
                    , subtitle: 'Retail & Modern Brand'
                    , tag: 'Modern Agency Edition'
                    , dotColor: 'bg-cyan-400 shadow-[0_0_8px_rgba(6,182,212,0.8)]'
                    , glowClass: 'bg-gradient-to-b from-cyan-500/25 via-blue-600/15 to-transparent'
                    , cardClass: 'bg-gradient-to-b from-[#0F172A] via-[#1E293B] to-[#0B1120] text-white border border-cyan-400/40 shadow-[0_20px_50px_rgba(6,182,212,0.25)]'
                    , acrylicSlot: 'bg-cyan-400/40'
                    , starClass: 'fill-[#FBBC05] drop-shadow-[0_0_4px_rgba(251,191,36,0.6)]'
                    , headlineClass: 'text-cyan-200'
                    , badgeClass: 'bg-cyan-500/15 text-cyan-300 border-cyan-400/40 shadow-sm'
                    , qrBorderGradient: 'linear-gradient(135deg, #06B6D4 0%, #3B82F6 50%, #8B5CF6 100%)'
                    , qrContainerClass: 'bg-[#0E172A]'
                    , qrLabelClass: 'text-cyan-200'
                    , qrWrapperClass: 'bg-white border border-cyan-400/30 p-1'
                    , qrSubClass: 'text-cyan-300/60'
                    , footerBorderClass: 'border-cyan-500/20 text-cyan-400/60'
                    , footerBadgeClass: 'text-cyan-300'
                }
            ]
            , orderData: {
                order_id: 'GRC-2026-DEMO'
                , qris_image_url: ''
                , midtrans_qr_url: ''
                , qris_payload: ''
                , amount: 20000
            , },

            init() {
                this.updateCustomerQr();

                // Support testing mode via URL: ?test_popup=1
                const urlParams = new URLSearchParams(window.location.search);
                if (urlParams.get('test_popup') === '1' || urlParams.get('test_popup') === 'true') {
                    this.step = 'payment';
                    this.isPaid = true;
                    if (!this.businessName) this.businessName = 'Kopi Kenangan Senopati';
                    if (!this.customerName) this.customerName = 'Budi Santoso';
                    this.triggerSuccess();
                }
            },

            get currentTheme() {
                return this.themes[this.themeIndex] || this.themes[0];
            },

            get deckThemes() {
                const len = this.themes.length;
                return [
                    this.themes[this.themeIndex]
                    , this.themes[(this.themeIndex + 1) % len]
                    , this.themes[(this.themeIndex + 2) % len]
                , ];
            },

            get effectiveQrisImageUrl() {
                if (this.orderData && this.orderData.midtrans_qr_url) {
                    return this.orderData.midtrans_qr_url;
                }
                if (this.orderData && this.orderData.qris_image_url) {
                    return this.orderData.qris_image_url;
                }
                return '';
            },

            get reviewTargetUrl() {
                if (this.reviewCard && this.reviewCard.scan_url) {
                    return this.reviewCard.scan_url;
                }
                if (this.reviewCard && this.reviewCard.google_review_url) {
                    return this.reviewCard.google_review_url;
                }
                if (this.mapsUrl && (this.mapsUrl.startsWith('http://') || this.mapsUrl.startsWith('https://'))) {
                    return this.mapsUrl.trim();
                }
                if (this.businessName && this.businessName.trim()) {
                    return 'https://www.google.com/maps/search/?api=1&query=' + encodeURIComponent(this.businessName.trim());
                }
                return 'https://maps.google.com';
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

            async updateCustomerQr() {
                const url = this.reviewTargetUrl;
                if (!url) return;

                if (typeof QRCode !== 'undefined') {
                    try {
                        const tempDiv = document.createElement('div');
                        new QRCode(tempDiv, {
                            text: url
                            , width: 600
                            , height: 600
                            , colorDark: '#000000'
                            , colorLight: '#ffffff'
                            , correctLevel: QRCode.CorrectLevel.H
                        });

                        setTimeout(() => {
                            const canvas = tempDiv.querySelector('canvas');
                            if (canvas) {
                                this.customerQrDataUrl = canvas.toDataURL('image/png');
                            }
                        }, 50);
                    } catch (e) {
                        console.error('QRCode render error:', e);
                    }
                }
            },

            openSuccessModal() {
                this.showSuccessModal = true;
                this.updateCustomerQr();
            },

            triggerSuccess(orderInfo = {}) {
                this.isPaid = true;
                this.stopPolling();

                if (orderInfo.business_name && !this.businessName) this.businessName = orderInfo.business_name;
                if (orderInfo.google_maps_url && !this.mapsUrl) this.mapsUrl = orderInfo.google_maps_url;
                if (orderInfo.customer_name && !this.customerName) this.customerName = orderInfo.customer_name;
                if (orderInfo.design_type && !this.designType) this.designType = orderInfo.design_type;
                if (orderInfo.review_card) this.reviewCard = orderInfo.review_card;

                this.updateCustomerQr();
                this.showSuccessModal = true;

                // Fire celebration confetti!
                if (typeof confetti === 'function') {
                    try {
                        confetti({
                            particleCount: 120
                            , spread: 80
                            , origin: {
                                y: 0.6
                            }
                        });
                        setTimeout(() => {
                            confetti({
                                particleCount: 60
                                , angle: 60
                                , spread: 55
                                , origin: {
                                    x: 0
                                }
                            });
                            confetti({
                                particleCount: 60
                                , angle: 120
                                , spread: 55
                                , origin: {
                                    x: 1
                                }
                            });
                        }, 250);
                    } catch (e) {}
                }
            },

            async proceedToPayment() {
                if (!this.businessName.trim() || !this.customerName.trim() || !this.customerPhone.trim()) {
                    alert('Silakan lengkapi nama usaha, nama pemesan, dan no WhatsApp Anda.');
                    return;
                }

                this.isLoading = true;
                this.updateCustomerQr();

                try {
                    const response = await fetch('{{ route("landing.google_card.qris") }}', {
                        method: 'POST'
                        , headers: {
                            'Content-Type': 'application/json'
                            , 'Accept': 'application/json'
                            , 'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                        , body: JSON.stringify({
                            business_name: this.businessName
                            , google_maps_url: this.mapsUrl
                            , customer_name: this.customerName
                            , phone: this.customerPhone
                            , design_type: this.designType
                            , theme: this.currentTheme.name
                        })
                    });

                    const res = await response.json();
                    if (res.success && res.data) {
                        this.orderData = res.data;
                        this.step = 'payment';
                        this.isPaid = false;
                        this.startPolling();
                    } else {
                        alert(res.message || 'Gagal menyiapkan QRIS pembayaran. Silakan coba kembali.');
                    }
                } catch (e) {
                    console.error('QRIS error:', e);
                    alert('Terjadi kendala saat menghubungi server pembayaran. Silakan coba lagi.');
                } finally {
                    this.isLoading = false;
                }
            },

            startPolling() {
                this.stopPolling();
                if (!this.orderData || !this.orderData.order_id) return;

                this.pollTimer = setInterval(async () => {
                    if (this.isPaid || this.step !== 'payment') {
                        this.stopPolling();
                        return;
                    }

                    try {
                        const statusUrl = `{{ url('/api/google-card/orders') }}/${encodeURIComponent(this.orderData.order_id)}/status`;
                        const res = await fetch(statusUrl, {
                            headers: {
                                'Accept': 'application/json'
                            }
                        });
                        const data = await res.json();
                        if (data.success && data.data && data.data.is_paid) {
                            this.triggerSuccess(data.data);
                        }
                    } catch (err) {
                        // Polling background silent fail
                    }
                }, 3500);
            },

            stopPolling() {
                if (this.pollTimer) {
                    clearInterval(this.pollTimer);
                    this.pollTimer = null;
                }
            },

            async checkStatusManual() {
                if (!this.orderData || !this.orderData.order_id) return;
                this.isCheckingStatus = true;
                try {
                    const statusUrl = `{{ url('/api/google-card/orders') }}/${encodeURIComponent(this.orderData.order_id)}/status`;
                    const res = await fetch(statusUrl, {
                        headers: {
                            'Accept': 'application/json'
                        }
                    });
                    const data = await res.json();
                    if (data.success && data.data && data.data.is_paid) {
                        this.triggerSuccess(data.data);
                    } else {
                        alert('Pembayaran belum terverifikasi lunas. Jika Anda baru saja transfer, mohon tunggu sekitar 5-10 detik lalu coba klik kembali.');
                    }
                } catch (e) {
                    alert('Gagal mengecek status pembayaran. Silakan pastikan koneksi internet Anda aktif.');
                } finally {
                    this.isCheckingStatus = false;
                }
            },

            async downloadPdf() {
                this.isDownloadingPdf = true;
                try {
                    await this.updateCustomerQr();
                    const node = document.getElementById('printableCardNode');
                    if (!node) throw new Error('Preview card element tidak ditemukan.');

                    if (document.fonts && document.fonts.ready) {
                        await document.fonts.ready;
                    }

                    if (typeof html2canvas === 'undefined') {
                        throw new Error('Library html2canvas belum termuat.');
                    }

                    const canvas = await html2canvas(node, {
                        scale: 3, // 3x scale ultra-sharp (300 DPI)
                        useCORS: true
                        , allowTaint: true
                        , backgroundColor: null
                        , logging: false
                    });

                    const imgData = canvas.toDataURL('image/png');
                    const jsPDFClass = (window.jspdf && window.jspdf.jsPDF) ? window.jspdf.jsPDF : window.jsPDF;
                    if (!jsPDFClass) {
                        throw new Error('Library jsPDF belum termuat.');
                    }

                    // Format A6 Standee: 105mm x 148mm (Ukuran Standar Akrilik Meja)
                    const pdf = new jsPDFClass({
                        orientation: 'portrait'
                        , unit: 'mm'
                        , format: [105, 148]
                    });

                    pdf.addImage(imgData, 'PNG', 0, 0, 105, 148, undefined, 'FAST');

                    const safeName = (this.businessName || 'Review-Card').replace(/[^a-zA-Z0-9_\-]+/g, '_');
                    pdf.save(`Google-Review-Card-${safeName}.pdf`);
                    this.pdfDownloaded = true;
                } catch (err) {
                    console.error('PDF generation error:', err);
                    alert('Gagal membuat PDF: ' + err.message);
                } finally {
                    this.isDownloadingPdf = false;
                }
            },

            async downloadCardPng() {
                this.isDownloadingPng = true;
                try {
                    await this.updateCustomerQr();
                    const node = document.getElementById('printableCardNode');
                    if (!node) throw new Error('Preview card element tidak ditemukan.');

                    if (document.fonts && document.fonts.ready) {
                        await document.fonts.ready;
                    }

                    if (typeof html2canvas === 'undefined') {
                        throw new Error('Library html2canvas belum termuat.');
                    }

                    const canvas = await html2canvas(node, {
                        scale: 3
                        , useCORS: true
                        , allowTaint: true
                        , backgroundColor: null
                        , logging: false
                    });

                    const safeName = (this.businessName || 'Review-Card').replace(/[^a-zA-Z0-9_\-]+/g, '_');
                    const filename = `Google-Review-Card-${safeName}.png`;

                    canvas.toBlob((blob) => {
                        if (!blob) {
                            this.isDownloadingPng = false;
                            return;
                        }

                        const isMobile = /iPhone|iPad|iPod|Android/i.test(navigator.userAgent);
                        if (isMobile && navigator.canShare) {
                            try {
                                const file = new File([blob], filename, {
                                    type: 'image/png'
                                });
                                if (navigator.canShare({
                                        files: [file]
                                    })) {
                                    navigator.share({
                                        files: [file]
                                        , title: 'Google Review Card ' + (this.businessName || '')
                                    }).catch(() => {});
                                    this.pngDownloaded = true;
                                    this.isDownloadingPng = false;
                                    return;
                                }
                            } catch (e) {}
                        }

                        const url = URL.createObjectURL(blob);
                        const a = document.createElement('a');
                        a.href = url;
                        a.download = filename;
                        document.body.appendChild(a);
                        a.click();
                        document.body.removeChild(a);
                        setTimeout(() => URL.revokeObjectURL(url), 1000);
                        this.pngDownloaded = true;
                        this.isDownloadingPng = false;
                    }, 'image/png');
                } catch (err) {
                    console.error('PNG download error:', err);
                    alert('Gagal mengunduh gambar: ' + err.message);
                    this.isDownloadingPng = false;
                }
            },

            async downloadQrPng() {
                this.isDownloadingQr = true;
                try {
                    const safeName = (this.businessName || 'Google-Review').replace(/[^a-zA-Z0-9_\-]+/g, '_');
                    const filename = `QR-Google-Review-${safeName}.png`;

                    if (typeof QRCode !== 'undefined') {
                        const tempDiv = document.createElement('div');
                        new QRCode(tempDiv, {
                            text: this.reviewTargetUrl
                            , width: 1024
                            , height: 1024
                            , colorDark: '#000000'
                            , colorLight: '#ffffff'
                            , correctLevel: QRCode.CorrectLevel.H
                        });

                        setTimeout(() => {
                            const canvas = tempDiv.querySelector('canvas');
                            if (canvas) {
                                const dataUrl = canvas.toDataURL('image/png');
                                const a = document.createElement('a');
                                a.href = dataUrl;
                                a.download = filename;
                                document.body.appendChild(a);
                                a.click();
                                document.body.removeChild(a);
                                this.qrDownloaded = true;
                            }
                            this.isDownloadingQr = false;
                        }, 50);
                        return;
                    } else if (this.customerQrDataUrl) {
                        const a = document.createElement('a');
                        a.href = this.customerQrDataUrl;
                        a.download = filename;
                        document.body.appendChild(a);
                        a.click();
                        document.body.removeChild(a);
                        this.qrDownloaded = true;
                    }
                } catch (err) {
                    console.error('QR download error:', err);
                } finally {
                    this.isDownloadingQr = false;
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

Berikut saya lampirkan bukti transfer pembayarannya. Mohon bantu konfirmasi dan kirimkan file Google QR Code serta desain siap cetaknya ya mas. Terima kasih banyak!`;

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
