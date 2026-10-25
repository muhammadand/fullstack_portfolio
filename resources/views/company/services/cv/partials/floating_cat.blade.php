{{-- ══════════════════════════════════════════════════════════════════
     INTERACTIVE FLOATING MASCOT: SI OYEN PEJUANG LOKER
     - Animasi kucing oyen jalan bolak-balik (CSS GPU hardware)
     - Audio meong lucu (HTML5 audio + Web Audio synthesizer)
     - Desain modal 100% FontAwesome (Bebas emoji non-standar)
     - Tiket Resmi QRIS Dinamis tampil langsung di dalam modal
     - 0% Blade tag di dalam script JS (Kebal format & anti-error)
══════════════════════════════════════════════════════════════════ --}}
<div x-data="floatingCatMascot()" x-init="initMascot()" class="select-none">

    {{-- Audio Element --}}
    <audio id="oyenMeowAudio" preload="auto">
        <source src="{{ asset('audio/meow.mp3') }}" type="audio/mpeg">
        <source src="{{ asset('audio/meow.ogg') }}" type="audio/ogg">
    </audio>

    {{-- Floating & Walking Container --}}
    <div x-show="isVisible" x-transition:enter="transition ease-out duration-500 transform" x-transition:enter-start="translate-y-20 opacity-0 scale-75" x-transition:enter-end="translate-y-0 opacity-100 scale-100" x-transition:leave="transition ease-in duration-300 transform" x-transition:leave-start="translate-y-0 opacity-100 scale-100" x-transition:leave-end="translate-y-20 opacity-0 scale-75" class="fixed bottom-4 right-4 sm:bottom-6 sm:right-6 z-40 flex flex-col items-end group" :style="'transform: translate3d(-' + walkOffset + 'px, 0, 0); transition: transform ' + walkTransition + '; filter: drop-shadow(0 12px 28px rgba(0,0,0,0.45));'">

        {{-- 1. Floating Meow Particle (Muncul saat bersuara) --}}
        <div x-show="showMeowEffect" x-transition:enter="transition ease-out duration-300 transform" x-transition:enter-start="opacity-0 translate-y-2 scale-75" x-transition:enter-end="opacity-100 -translate-y-4 scale-110" x-transition:leave="transition ease-in duration-300 transform" x-transition:leave-start="opacity-100 -translate-y-4 scale-110" x-transition:leave-end="opacity-0 -translate-y-8 scale-90" class="absolute -top-10 right-6 bg-gradient-to-r from-amber-400 to-orange-500 text-slate-950 font-bold text-xs px-3 py-1 rounded-full shadow-lg pointer-events-none flex items-center gap-1.5 z-50 animate-bounce">
            <i class="fa-solid fa-volume-high text-[10px]"></i>
            <span x-text="meowText"></span>
        </div>

        {{-- 2. Speech Bubble (Balon Kata Profesional & Rapi) --}}
        <div x-show="showBubble && !isMinimized" x-transition:enter="transition ease-out duration-300 transform" x-transition:enter-start="opacity-0 scale-90 translate-y-2" x-transition:enter-end="opacity-100 scale-100 translate-y-0" x-transition:leave="transition ease-in duration-200 transform" x-transition:leave-start="opacity-100 scale-100 translate-y-0" x-transition:leave-end="opacity-0 scale-90 translate-y-2" class="relative w-[280px] sm:w-[320px] mb-2.5 p-3.5 rounded-2xl border text-left shadow-2xl backdrop-blur-xl" style="background: rgba(15, 23, 42, 0.96); border-color: rgba(249, 115, 22, 0.35); box-shadow: 0 10px 30px -5px rgba(0,0,0,0.5);">

            {{-- Clean Header Row --}}
            <div class="flex items-center justify-between gap-2 mb-2 pb-2 border-b border-white/10">
                <div class="flex items-center gap-1.5 min-w-0">
                    <span class="w-2 h-2 rounded-full bg-amber-400 shrink-0" :class="isWalking ? 'animate-ping' : ''"></span>
                    <span class="text-[11px] font-black uppercase tracking-wider text-amber-400 whitespace-nowrap">Si Oyen</span>
                    <span class="text-[10px] text-white/50 truncate flex items-center gap-1" x-show="!isWalking">
                        <span>· Pejuang Loker</span>
                    </span>
                    <span class="text-[10px] text-amber-300/90 truncate font-semibold flex items-center gap-1" x-show="isWalking">
                        <span>· Patroli</span>
                        <i class="fa-solid fa-paw text-[9px]"></i>
                    </span>
                </div>

                {{-- Actions: Sound & Minimize in clean inline cluster --}}
                <div class="flex items-center gap-1.5 shrink-0">
                    {{-- Mute / Unmute --}}
                    <button @click.stop="toggleSound()" type="button" class="w-6 h-6 rounded-lg border flex items-center justify-center text-[11px] transition-all hover:scale-105 cursor-pointer" :class="isMuted ? 'bg-rose-950/60 border-rose-500/30 text-rose-300' : 'bg-white/5 border-white/10 text-amber-400 hover:bg-white/10'" :title="isMuted ? 'Nyalakan Audio' : 'Senyapkan Audio'">
                        <i :class="isMuted ? 'fa-solid fa-volume-xmark' : 'fa-solid fa-volume-high'"></i>
                    </button>

                    {{-- Close / Minimize --}}
                    <button @click.stop="minimizeCat()" type="button" class="w-6 h-6 rounded-lg bg-white/5 hover:bg-white/10 border border-white/10 text-white/60 hover:text-white flex items-center justify-center text-[10px] transition-all hover:scale-105 cursor-pointer" title="Sembunyikan Karakter">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
            </div>

            {{-- Speech Text --}}
            <p class="text-xs text-white/90 leading-relaxed font-normal py-0.5" x-text="currentQuote"></p>

            {{-- Quick Click CTA inside bubble --}}
            <button @click.stop="openDonationModal()" type="button" class="mt-2.5 w-full py-2 px-3 rounded-xl bg-gradient-to-r from-amber-500 via-orange-500 to-amber-500 hover:brightness-110 text-slate-950 text-xs font-black shadow-md shadow-orange-500/20 flex items-center justify-center gap-2 hover:scale-[1.01] active:scale-[0.98] transition-all cursor-pointer">
                <i class="fa-solid fa-qrcode text-xs"></i>
                <span>Donasi via QRIS </span>
            </button>

            {{-- Speech Bubble Pointer Arrow --}}
            <div class="absolute -bottom-2 right-10 sm:right-12 w-0 h-0 border-l-[8px] border-l-transparent border-r-[8px] border-r-transparent border-t-[8px]" style="border-t-color: rgba(15, 23, 42, 0.96);"></div>
        </div>

        {{-- 3. Mascot Character Body --}}
        <div class="relative flex items-center justify-end">

            {{-- Minimized Pill Badge (Ketika di-minimize) --}}
            <div x-show="isMinimized" @click="restoreCat()" class="cursor-pointer bg-slate-900/95 border border-amber-500/40 rounded-full py-2 px-3.5 flex items-center gap-2 shadow-xl hover:border-amber-400 transition-all hover:scale-105">
                <i class="fa-solid fa-paw text-amber-400 text-xs"></i>
                <span class="text-xs font-bold text-amber-300">Si Oyen Butuh Dukungan</span>
                <i class="fa-solid fa-chevron-up text-[10px] text-white/60"></i>
            </div>

            {{-- Active Cat Mascot Figure --}}
            <div x-show="!isMinimized" @click="onCatClicked()" @mouseenter="onHoverCat()" @mouseleave="onLeaveCat()" class="cursor-pointer relative transform transition-all duration-200 group-hover:brightness-105" :class="isHovered ? 'scale-110' : ''">

                <div :style="'transform: scaleX(' + (direction === 'left' ? '-1' : '1') + '); transition: transform 0.25s ease-out;'">
                    <img src="{{ asset('images/cat-walking-orange.gif') }}" alt="Si Oyen Jobseeker" class="w-24 h-auto sm:w-28 select-none pointer-events-auto object-contain drop-shadow-md" loading="lazy">
                </div>

                {{-- Subtle Under-Feet Shadow --}}
                <div class="w-20 h-2.5 bg-black/40 rounded-full mx-auto blur-[2px] -mt-1 transition-all" :class="isWalking ? 'scale-x-110 opacity-70' : ''"></div>
            </div>

        </div>

    </div>

    {{-- ══════════════════════════════════════════════════════════════════
         PROFESSIONAL MODAL: TIKET QRIS DINAMIS LANGSUNG DI DALAM MODAL
    ══════════════════════════════════════════════════════════════════ --}}
    <div x-show="showModal" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 z-[9999] flex items-center justify-center p-3 sm:p-4 bg-slate-950/80 backdrop-blur-md" @click="closeModal()" x-cloak>

        <div class="relative w-full max-w-sm sm:max-w-md max-h-[94vh] overflow-y-auto rounded-3xl border border-white/10 shadow-2xl p-4 sm:p-6 text-center" style="background: linear-gradient(150deg, rgba(15, 23, 42, 0.98), rgba(9, 13, 36, 0.99));" @click.stop>

            {{-- Top Gradient Line --}}
            <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-amber-400 via-orange-500 to-rose-500"></div>

            {{-- ════════════ TAMPILAN 1: PILIH NOMINAL DONASI ════════════ --}}
            <div x-show="modalStep === 'select'">

                {{-- Close Button --}}
                <div class="flex justify-end mb-1">
                    <button @click="closeModal()" type="button" class="text-white/40 hover:text-white transition w-8 h-8 rounded-full bg-white/5 hover:bg-white/10 flex items-center justify-center text-sm cursor-pointer" title="Tutup Modal">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>

                {{-- Mascot Header in Modal --}}
                <div class="relative w-20 h-20 mx-auto mb-2 cursor-pointer" @click="playMeow(true)" title="Klik untuk mendengar suara Oyen">
                    <div class="absolute inset-0 rounded-full bg-amber-500/20 blur-xl animate-pulse"></div>
                    <img src="{{ asset('images/cat-jobseeker.webp') }}" alt="Si Oyen Jobseeker" class="w-full h-full object-contain relative z-10 cat-modal-shake">
                </div>

                <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-amber-500/10 border border-amber-500/30 text-amber-300 text-[11px] font-semibold mb-2">
                    <i class="fa-solid fa-shield-heart text-amber-400 text-xs"></i>
                    <span>Dukungan Operasional Karir</span>
                </div>

                <h3 class="text-white font-extrabold text-lg sm:text-xl tracking-tight">
                    Dukung Si Oyen Lolos Kerja!
                </h3>
                <p class="text-white/60 text-xs mt-1 leading-relaxed">
                    Setiap donasi Anda digunakan untuk pemeliharaan server AI CV Builder dan kuota pelamar kerja. Pembayaran diproses secara instan via <strong class="text-amber-300">QRIS</strong>.
                </p>

                {{-- Form Kirim AJAX (URL diambil dari atribut form, 0% Blade di Script) --}}
                <form id="qrisDonationForm" action="{{ route('layanan.cv.donate_qris') }}" @submit.prevent="submitQris($event)" class="mt-4">
                    @csrf
                    <input type="hidden" name="amount" x-model="selectedNominal">

                    {{-- Nominal Presets Grid (Professional & Clean Icons) --}}
                    <div class="grid grid-cols-2 gap-2.5 mb-3 text-left">
                        {{-- 5.000 --}}
                        <button type="button" @click="selectPreset('5000')" :class="selectedNominal === '5000' && !isCustom ? 'border-amber-400 bg-amber-500/15 text-white shadow-md shadow-amber-500/15 ring-1 ring-amber-400/50' : 'border-white/10 bg-white/5 text-white/70 hover:border-white/20'" class="p-3 rounded-xl border text-left transition-all cursor-pointer">
                            <div class="flex items-center gap-1.5 text-amber-300 text-[10px] font-semibold mb-1">
                                <i class="fa-solid fa-mug-saucer text-[10px]"></i>
                                <span>Paket Es Teh</span>
                            </div>
                            <p class="text-sm font-black text-white">Rp 5.000</p>
                        </button>

                        {{-- 10.000 (Popular) --}}
                        <button type="button" @click="selectPreset('10000')" :class="selectedNominal === '10000' && !isCustom ? 'border-amber-400 bg-amber-500/15 text-white shadow-md shadow-amber-500/15 ring-1 ring-amber-400/50' : 'border-white/10 bg-white/5 text-white/70 hover:border-white/20'" class="p-3 rounded-xl border text-left transition-all cursor-pointer relative">
                            <span class="absolute -top-2 right-2 bg-gradient-to-r from-amber-400 to-orange-500 text-slate-950 text-[9px] font-black px-1.5 py-0.2 rounded-full uppercase flex items-center gap-0.5">
                                <i class="fa-solid fa-star text-[8px]"></i>
                                <span>Favorit</span>
                            </span>
                            <div class="flex items-center gap-1.5 text-amber-300 text-[10px] font-semibold mb-1">
                                <i class="fa-solid fa-fish text-[10px]"></i>
                                <span>Paket Whiskas</span>
                            </div>
                            <p class="text-sm font-black text-white">Rp 10.000</p>
                        </button>

                        {{-- 25.000 --}}
                        <button type="button" @click="selectPreset('25000')" :class="selectedNominal === '25000' && !isCustom ? 'border-amber-400 bg-amber-500/15 text-white shadow-md shadow-amber-500/15 ring-1 ring-amber-400/50' : 'border-white/10 bg-white/5 text-white/70 hover:border-white/20'" class="p-3 rounded-xl border text-left transition-all cursor-pointer">
                            <div class="flex items-center gap-1.5 text-amber-300 text-[10px] font-semibold mb-1">
                                <i class="fa-solid fa-bowl-food text-[10px]"></i>
                                <span>Paket Nasi Padang</span>
                            </div>
                            <p class="text-sm font-black text-white">Rp 25.000</p>
                        </button>

                        {{-- 50.000 --}}
                        <button type="button" @click="selectPreset('50000')" :class="selectedNominal === '50000' && !isCustom ? 'border-amber-400 bg-amber-500/15 text-white shadow-md shadow-amber-500/15 ring-1 ring-amber-400/50' : 'border-white/10 bg-white/5 text-white/70 hover:border-white/20'" class="p-3 rounded-xl border text-left transition-all cursor-pointer">
                            <div class="flex items-center gap-1.5 text-amber-300 text-[10px] font-semibold mb-1">
                                <i class="fa-solid fa-crown text-[10px]"></i>
                                <span>Paket Donatur Utama</span>
                            </div>
                            <p class="text-sm font-black text-white">Rp 50.000</p>
                        </button>
                    </div>

                    {{-- Input Fields: 2 Jajarkan (Nominal Kustom & Nama Donatur) --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5 mb-3 text-left">
                        {{-- Field 1: Custom Nominal --}}
                        <div>
                            <label class="block text-[11px] font-medium text-white/60 mb-1">Nominal Kustom</label>
                            <div class="relative">
                                <span class="absolute left-3 top-2.5 text-xs text-white/40 font-bold">Rp</span>
                                <input type="number" x-model="customNominal" @input="onCustomNominalInput()" placeholder="Min. 1.000" class="w-full bg-white/5 border border-white/15 focus:border-amber-400 focus:ring-1 focus:ring-amber-400 rounded-xl py-2 pl-9 pr-2.5 text-xs text-white placeholder-white/30 outline-none transition font-sans">
                            </div>
                        </div>

                        {{-- Field 2: Nama Donatur --}}
                        <div>
                            <label class="block text-[11px] font-medium text-white/60 mb-1">Nama Donatur</label>
                            <div class="relative">
                                <span class="absolute left-3 top-2.5 text-xs text-white/40">
                                    <i class="fa-solid fa-user text-[11px]"></i>
                                </span>
                                <input type="text" name="donor_name" x-model="donorName" placeholder="Nama / Inisial Anda" class="w-full bg-white/5 border border-white/15 focus:border-amber-400 focus:ring-1 focus:ring-amber-400 rounded-xl py-2 pl-8 pr-2.5 text-xs text-white placeholder-white/30 outline-none transition font-sans">
                            </div>
                        </div>
                    </div>

                    {{-- Error Alert --}}
                    <div x-show="errorMessage" x-cloak class="mb-3 p-2.5 rounded-xl bg-rose-500/20 border border-rose-500/30 text-rose-300 text-xs flex items-center gap-2 text-left">
                        <i class="fa-solid fa-circle-exclamation shrink-0"></i>
                        <span x-text="errorMessage"></span>
                    </div>

                    {{-- Buttons: 2 Jajarkan (Bayar QRIS & Kirim WhatsApp) --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 mt-3">
                        {{-- Main Submit QRIS Button --}}
                        <button type="submit" :disabled="isLoading" class="w-full py-3 px-3 rounded-xl font-bold text-xs text-slate-950 flex items-center justify-center gap-1.5 transition-all hover:scale-[1.01] active:scale-[0.98] shadow-lg shadow-amber-500/25 cursor-pointer disabled:opacity-60 disabled:cursor-not-allowed text-center" style="background: linear-gradient(135deg, #f59e0b, #fbbf24);">
                            <template x-if="isLoading">
                                <div class="flex items-center gap-1.5">
                                    <i class="fa-solid fa-circle-notch fa-spin text-xs"></i>
                                    <span class="text-[11px]">Memproses...</span>
                                </div>
                            </template>
                            <template x-if="!isLoading">
                                <div class="flex items-center justify-center gap-1.5">
                                    <i class="fa-solid fa-qrcode text-sm"></i>
                                    <span>Donasi <span x-text="'Rp ' + formatNumber(getActiveNominal())"></span></span>
                                    <i class="fa-solid fa-arrow-right text-[10px] opacity-75"></i>
                                </div>
                            </template>
                        </button>

                        {{-- WhatsApp Support Link --}}
                        <a href="https://wa.me/6285254009888?text=Halo%20Oyen,%20semangat%20ya%20cari%20kerjanya!%20Aku%20mau%20bantu%20donasi%20nih." target="_blank" rel="noopener noreferrer" @click="playMeow(true)" class="w-full py-3 px-3 rounded-xl font-semibold text-xs text-white/80 bg-white/5 hover:bg-white/10 border border-white/10 flex items-center justify-center gap-1.5 transition cursor-pointer text-center">
                            <i class="fa-brands fa-whatsapp text-emerald-400 text-sm"></i>
                            <span>Pesan WhatsApp</span>
                        </a>
                    </div>
                </form>

                {{-- Footer Note --}}
                <div class="mt-4 pt-3 border-t border-white/10 text-[10px] text-white/40 flex items-center justify-center gap-1.5">
                    <i class="fa-solid fa-shield-halved text-amber-400 text-[11px]"></i>
                    <span>Transaksi aman &amp; terenkripsi standar Bank Indonesia. Terima kasih atas dukungan Anda.</span>
                </div>

            </div>

            {{-- ════════════ TAMPILAN 2: TIKET RESMI QRIS DINAMIS (PERSIS DESAIN USER) ════════════ --}}
            <div x-show="modalStep === 'qris' && qrisResult" x-cloak>

                {{-- Top Navigation Bar in Modal --}}
                <div class="flex items-center justify-between mb-3 pb-2 border-b border-white/10">
                    <button @click="backToNominal()" type="button" class="w-8 h-8 rounded-xl bg-white/5 hover:bg-white/10 border border-white/10 flex items-center justify-center text-slate-300 hover:text-white transition cursor-pointer" title="Ubah Nominal">
                        <i class="fa-solid fa-arrow-left text-xs"></i>
                    </button>

                    <div class="text-center">
                        <span class="text-xs font-semibold text-slate-200">Donasi Si Oyen Pejuang Loker</span>
                        <p class="text-[10px] text-slate-400 font-mono leading-none mt-0.5" x-text="'#' + (qrisResult ? qrisResult.order_id : '')"></p>
                    </div>

                    <!-- Countdown Timer Chip -->
                    <div class="flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-amber-500/10 border border-amber-500/20 text-amber-300 text-[11px] font-mono font-medium">
                        <i class="fa-regular fa-clock text-[10px]"></i>
                        <span x-text="countdownString">30:00</span>
                    </div>
                </div>

                {{-- Official QRIS Ticket Card (White Canvas) --}}
                <div class="bg-white rounded-3xl shadow-2xl overflow-hidden text-slate-900 border border-slate-100 mb-4 text-left">

                    {{-- Card Header: Official QRIS & GPN Branding --}}
                    <div class="p-4 pb-3 bg-gradient-to-b from-slate-50 to-white border-b border-slate-100">
                        <div class="flex items-center justify-between">
                            {{-- Official QRIS Logo --}}
                            <div class="flex items-center gap-2">
                                <div class="flex items-center tracking-tighter font-extrabold text-slate-900 leading-none">
                                    <span class="text-red-600 text-lg font-black">Q</span>
                                    <span class="text-slate-900 text-lg font-black tracking-tight">RIS</span>
                                </div>
                                <span class="text-[9px] font-semibold text-slate-400 border-l border-slate-200 pl-2 uppercase tracking-wider leading-tight">
                                    Quick Response Code<br>Indonesian Standard
                                </span>
                            </div>

                            {{-- GPN Logo Badge --}}
                            <div class="flex items-center gap-1 bg-red-600 text-white text-[9px] font-black px-2 py-0.5 rounded tracking-wider shadow-xs">
                                <span>GPN</span>
                            </div>
                        </div>

                        {{-- Merchant Name & NMID --}}
                        <div class="mt-3 pt-2.5 border-t border-slate-100/80 flex items-center justify-between text-left">
                            <div>
                                <h2 class="text-xs font-bold text-slate-800 tracking-tight uppercase" x-text="qrisResult ? (qrisResult.merchant_name || 'SCALIFY / SI OYEN PEJUANG LOKER') : ''"></h2>
                                <p class="text-[10px] text-slate-500 font-mono">NMID: ID1021058777975</p>
                            </div>
                            <div class="text-right">
                                <span class="text-[9px] font-semibold text-slate-500 bg-slate-100 px-1.5 py-0.5 rounded">
                                    DANA &bull; QRIS
                                </span>
                            </div>
                        </div>
                    </div>

                    {{-- QR Code Centerpiece Canvas --}}
                    <div class="p-4 flex flex-col items-center justify-center bg-white text-center">
                        <div class="relative p-2 bg-white rounded-2xl border-2 border-slate-900/10 shadow-sm flex items-center justify-center">
                            <img :src="qrisResult ? qrisResult.qris_image_url : ''" alt="QRIS Donasi Si Oyen" class="w-52 h-52 sm:w-60 sm:h-60 object-contain select-none">
                        </div>
                        <p class="text-[11px] text-slate-500 mt-2 font-medium flex items-center justify-center gap-1">
                            <i class="fa-solid fa-qrcode text-[11px]"></i>
                            <span>Scan menggunakan m-Banking atau e-Wallet apapun</span>
                        </p>
                    </div>

                    {{-- Ticket Divider with circle cuts --}}
                    <div class="ticket-divider h-5 flex items-center justify-center px-4">
                        <div class="dashed-line w-full"></div>
                    </div>

                    {{-- Payment Details & Unique Amount --}}
                    <div class="p-4 pt-2 bg-slate-50/60">
                        <div class="p-3.5 rounded-2xl bg-amber-500/10 border border-amber-500/25 text-center">
                            <span class="text-[10px] font-bold uppercase text-amber-800 tracking-wider">Total Pembayaran Donasi</span>
                            <div class="flex items-center justify-center gap-2 mt-1">
                                <span class="text-2xl font-black text-amber-600 font-mono" x-text="qrisResult ? ('Rp ' + formatNumber(qrisResult.total_amount)) : ''"></span>
                                <button type="button" @click="copyTotal()" class="px-2.5 py-1 rounded-lg bg-amber-200 hover:bg-amber-300 text-amber-900 text-xs font-bold transition flex items-center gap-1 active:scale-95 cursor-pointer">
                                    <i :class="copied ? 'fa-solid fa-check' : 'fa-regular fa-copy'"></i>
                                    <span x-text="copied ? 'Tersalin' : 'Salin'"></span>
                                </button>
                            </div>
                            <p class="text-[10px] text-amber-900/80 font-medium mt-1.5 leading-tight flex items-center justify-center gap-1">
                                <i class="fa-solid fa-triangle-exclamation text-amber-600 text-[10px]"></i>
                                <span>Transfer <strong>persis sampai 3 digit terakhir</strong> agar terverifikasi otomatis.</span>
                            </p>
                        </div>

                        <div class="mt-3 space-y-1.5 text-xs text-slate-600">
                            <div class="flex justify-between py-1 border-b border-slate-200/60">
                                <span class="text-slate-400">Donatur:</span>
                                <span class="font-semibold text-slate-800" x-text="donorName || 'Sahabat Si Oyen'"></span>
                            </div>
                            <div class="flex justify-between py-1 border-b border-slate-200/60">
                                <span class="text-slate-400">ID Transaksi:</span>
                                <span class="font-mono text-slate-800" x-text="qrisResult ? qrisResult.order_id : ''"></span>
                            </div>
                        </div>
                    </div>

                    {{-- Supported Channels Footer --}}
                    <div class="p-3 bg-slate-100/80 border-t border-slate-200 text-center">
                        <p class="text-[10px] text-slate-500 font-medium leading-relaxed">
                            BCA Mobile &bull; Livin' Mandiri &bull; BRImo &bull; BNI &bull; GoPay &bull; OVO &bull; DANA &bull; ShopeePay
                        </p>
                    </div>
                </div>

                {{-- Action Buttons --}}
                <div class="space-y-2">
                    {{-- WhatsApp Confirmation --}}
                    <a :href="'https://wa.me/6285254009888?text=' + encodeURIComponent('Halo Tim Scalify! Saya sudah transfer donasi via QRIS sebesar Rp ' + (qrisResult ? formatNumber(qrisResult.total_amount) : '') + ' (ID: ' + (qrisResult ? qrisResult.order_id : '') + '). Semangat terus untuk pengembangan platform CV gratis!')" target="_blank" rel="noopener noreferrer" class="w-full py-3.5 px-4 rounded-xl font-bold text-xs sm:text-sm text-slate-950 flex items-center justify-center gap-2 transition hover:scale-[1.01] shadow-lg shadow-emerald-500/20 bg-emerald-400 hover:bg-emerald-300 cursor-pointer">
                        <i class="fa-brands fa-whatsapp text-base"></i>
                        <span>Konfirmasi Pembayaran via WhatsApp</span>
                    </a>

                    {{-- Download / Unduh QRIS --}}
                    <a :href="qrisResult ? qrisResult.qris_image_url : '#'" target="_blank" download="qris-donasi-si-oyen.png" class="w-full py-2.5 px-4 rounded-xl font-semibold text-xs text-white/80 bg-white/5 hover:bg-white/10 border border-white/10 flex items-center justify-center gap-2 transition cursor-pointer">
                        <i class="fa-solid fa-arrow-down-to-bracket text-xs"></i>
                        <span>Unduh / Tampilkan QRIS Layar Penuh</span>
                    </a>

                    {{-- Selesai / Tutup --}}
                    <button type="button" @click="closeModal()" class="w-full py-2 px-4 rounded-xl font-semibold text-xs text-white/50 hover:text-white transition cursor-pointer">
                        <span>Selesai / Tutup Modal</span>
                    </button>
                </div>

            </div>

        </div>
    </div>

</div>

{{-- ══════════════════════════════════════════════════════════════════
     ULTRA LIGHTWEIGHT STYLES & SCRIPT (100% PURE JS - ZERO BLADE DIRECTIVES)
══════════════════════════════════════════════════════════════════ --}}
<style>
    [x-cloak] {
        display: none !important;
    }

    .ticket-divider {
        position: relative;
        background-image: radial-gradient(circle at 0 50%, transparent 10px, #ffffff 11px), radial-gradient(circle at 100% 50%, transparent 10px, #ffffff 11px);
        background-size: 100% 100%;
    }

    .dashed-line {
        border-bottom: 2px dashed #E2E8F0;
    }

    @keyframes catBob {

        0%,
        100% {
            transform: translateY(0px) rotate(0deg);
        }

        50% {
            transform: translateY(-5px) rotate(-1.5deg);
        }
    }

    @keyframes catWaddle {

        0%,
        100% {
            transform: translateY(0) rotate(0deg);
        }

        25% {
            transform: translateY(-8px) rotate(-5deg);
        }

        50% {
            transform: translateY(0) rotate(0deg);
        }

        75% {
            transform: translateY(-8px) rotate(5deg);
        }
    }

    @keyframes catShake {

        0%,
        100% {
            transform: scale(1) rotate(0deg);
        }

        25% {
            transform: scale(1.05) rotate(-3deg);
        }

        75% {
            transform: scale(1.05) rotate(3deg);
        }
    }

    .cat-walking-bob {
        animation: catBob 2.6s ease-in-out infinite;
        will-change: transform;
    }

    .cat-waddling {
        animation: catWaddle 0.5s ease-in-out infinite !important;
        will-change: transform;
    }

    .cat-modal-shake {
        animation: catShake 2.4s ease-in-out infinite;
    }

</style>

<script>
    function floatingCatMascot() {
        return {
            isVisible: false
            , isMinimized: false
            , showBubble: false
            , showModal: false
            , modalStep: 'select', // 'select' | 'qris'
            isHovered: false
            , isWalking: false
            , walkOffset: 0
            , walkTransition: 'transform 0.4s ease-out'
            , direction: 'left'
            , isMuted: false
            , showMeowEffect: false
            , meowText: 'Meoong!',

            // Form state
            selectedNominal: '10000'
            , customNominal: ''
            , isCustom: false
            , donorName: ''
            , isLoading: false
            , errorMessage: ''
            , qrisResult: null
            , copied: false
            , countdownSeconds: 1800
            , countdownString: '30:00'
            , timerInterval: null,

            quotes: [
                'Mewow mau uang, kirim donasinya ya kak, janji mewow ga nakal lagi!!!.'
                , 'Kakak semangat cari kerja nya yakkkkk, mewow mau bobo.'
                , 'Aku belum makan kakak, minta ikan satu boleeee?.'
                , 'Kakak suka aku kan ?.'
                , 'Donasi Kak!!! janji ga jadi mewow nakal lagiii!'
            ]
            , quoteIndex: 0
            , currentQuote: ''
            , quoteTimer: null
            , walkTimer: null
            , audioCtx: null,

            initMascot() {
                setTimeout(() => {
                    this.isVisible = true;
                    this.currentQuote = this.quotes[0];
                    this.showBubble = true;

                    this.startQuoteLoop();
                    this.startWalkPatrol();
                }, 1800);

                document.addEventListener('visibilitychange', () => {
                    if (document.hidden) {
                        this.stopAllTimers();
                    } else if (this.isVisible && !this.isMinimized) {
                        this.startQuoteLoop();
                        this.startWalkPatrol();
                    }
                });
            },

            // Form Submit via AJAX (URL & Token diambil dari atribut form HTML murni)
            async submitQris(event) {
                const form = event.target;
                const url = form.getAttribute('action');
                const tokenInput = form.querySelector('input[name="_token"]');
                const csrfToken = tokenInput ? tokenInput.value : '';

                this.isLoading = true;
                this.errorMessage = '';

                try {
                    const response = await fetch(url, {
                        method: 'POST'
                        , headers: {
                            'Content-Type': 'application/json'
                            , 'Accept': 'application/json'
                            , 'X-CSRF-TOKEN': csrfToken
                        }
                        , body: JSON.stringify({
                            amount: this.getActiveNominal()
                            , donor_name: this.donorName || 'Sahabat Si Oyen'
                        })
                    });

                    const data = await response.json();

                    if (!response.ok || !data.success) {
                        throw new Error(data.message || 'Gagal memproses QRIS. Silakan coba kembali.');
                    }

                    this.qrisResult = data.data;
                    this.modalStep = 'qris';
                    this.startCountdown();
                    this.playMeow(true);

                } catch (err) {
                    this.errorMessage = err.message || 'Terjadi gangguan jaringan saat menghubungi gateway QRIS.';
                } finally {
                    this.isLoading = false;
                }
            },

            startCountdown() {
                if (this.timerInterval) clearInterval(this.timerInterval);
                this.countdownSeconds = 1800;
                this.updateCountdownString();

                this.timerInterval = setInterval(() => {
                    if (this.countdownSeconds <= 0) {
                        clearInterval(this.timerInterval);
                        this.countdownString = 'Kadaluarsa';
                        return;
                    }
                    this.countdownSeconds--;
                    this.updateCountdownString();
                }, 1000);
            },

            updateCountdownString() {
                const m = Math.floor(this.countdownSeconds / 60);
                const s = this.countdownSeconds % 60;
                this.countdownString = (m < 10 ? '0' : '') + m + ':' + (s < 10 ? '0' : '') + s;
            },

            copyTotal() {
                if (!this.qrisResult || !this.qrisResult.total_amount) return;
                const str = String(this.qrisResult.total_amount);
                if (navigator.clipboard) {
                    navigator.clipboard.writeText(str);
                } else {
                    const ta = document.createElement('textarea');
                    ta.value = str;
                    document.body.appendChild(ta);
                    ta.select();
                    document.execCommand('copy');
                    document.body.removeChild(ta);
                }
                this.copied = true;
                setTimeout(() => {
                    this.copied = false;
                }, 2000);
            },

            backToNominal() {
                this.modalStep = 'select';
                if (this.timerInterval) clearInterval(this.timerInterval);
            },

            startWalkPatrol() {
                this.stopWalkPatrol();
                this.walkTimer = setInterval(() => {
                    if (this.isMinimized || this.showModal || this.isHovered) return;

                    const maxWalk = Math.min(window.innerWidth - 180, 260);
                    if (maxWalk <= 30) return;

                    if (this.walkOffset <= 20) {
                        this.direction = 'left';
                        const target = Math.floor(Math.random() * (maxWalk - 80)) + 80;
                        const durationSec = Math.max(1.5, (target - this.walkOffset) / 80);
                        this.walkTo(target, durationSec);
                    } else {
                        this.direction = 'right';
                        const durationSec = Math.max(1.5, this.walkOffset / 80);
                        this.walkTo(0, durationSec);
                    }
                }, 9000);
            },

            walkTo(targetX, durationSec) {
                this.isWalking = true;
                this.walkTransition = `transform ${durationSec.toFixed(1)}s cubic-bezier(0.4, 0, 0.2, 1)`;
                this.walkOffset = targetX;

                if (Math.random() > 0.4) {
                    this.playMeow();
                }

                setTimeout(() => {
                    this.isWalking = false;
                }, durationSec * 1000);
            },

            stopWalkPatrol() {
                if (this.walkTimer) clearInterval(this.walkTimer);
            },

            startQuoteLoop() {
                this.stopQuoteLoop();
                this.quoteTimer = setInterval(() => {
                    if (!this.isMinimized && !this.showModal && !this.isWalking) {
                        this.showBubble = false;
                        setTimeout(() => {
                            this.quoteIndex = (this.quoteIndex + 1) % this.quotes.length;
                            this.currentQuote = this.quotes[this.quoteIndex];
                            this.showBubble = true;
                            this.playMeow();
                        }, 300);
                    }
                }, 7500);
            },

            stopQuoteLoop() {
                if (this.quoteTimer) clearInterval(this.quoteTimer);
            },

            stopAllTimers() {
                this.stopQuoteLoop();
                this.stopWalkPatrol();
            },

            selectPreset(amount) {
                this.selectedNominal = amount;
                this.isCustom = false;
                this.customNominal = '';
                this.playMeow();
            },

            onCustomNominalInput() {
                const val = parseInt(this.customNominal, 10);
                if (val && val >= 1000) {
                    this.isCustom = true;
                    this.selectedNominal = val.toString();
                } else if (!this.customNominal) {
                    this.isCustom = false;
                    this.selectedNominal = '10000';
                }
            },

            getActiveNominal() {
                const val = parseInt(this.selectedNominal, 10);
                return isNaN(val) || val < 1000 ? 10000 : val;
            },

            formatNumber(num) {
                return Number(num || 0).toLocaleString('id-ID');
            },

            closeModal() {
                this.showModal = false;
                if (this.timerInterval) clearInterval(this.timerInterval);
            },

            playMeow(force = false) {
                if (this.isMuted && !force) return;

                const meowVariations = ['Meoong!', 'Miuww!', 'Meow Meow!', 'Meoong~'];
                this.meowText = meowVariations[Math.floor(Math.random() * meowVariations.length)];
                this.showMeowEffect = true;
                setTimeout(() => {
                    this.showMeowEffect = false;
                }, 1600);

                try {
                    const audio = document.getElementById('oyenMeowAudio');
                    if (audio) {
                        audio.currentTime = 0;
                        audio.volume = 0.55;
                        const promise = audio.play();
                        if (promise !== undefined) {
                            promise.catch(() => {
                                this.playSynthMeow();
                            });
                        }
                        return;
                    }
                } catch (e) {
                    this.playSynthMeow();
                }
            },

            playSynthMeow() {
                try {
                    const AudioContext = window.AudioContext || window.webkitAudioContext;
                    if (!AudioContext) return;
                    if (!this.audioCtx) this.audioCtx = new AudioContext();
                    if (this.audioCtx.state === 'suspended') this.audioCtx.resume();

                    const ctx = this.audioCtx;
                    const osc = ctx.createOscillator();
                    const gain = ctx.createGain();

                    osc.type = 'triangle';
                    const now = ctx.currentTime;
                    osc.frequency.setValueAtTime(450, now);
                    osc.frequency.exponentialRampToValueAtTime(850, now + 0.18);
                    osc.frequency.exponentialRampToValueAtTime(420, now + 0.55);

                    gain.gain.setValueAtTime(0.01, now);
                    gain.gain.linearRampToValueAtTime(0.2, now + 0.08);
                    gain.gain.exponentialRampToValueAtTime(0.001, now + 0.55);

                    osc.connect(gain);
                    gain.connect(ctx.destination);

                    osc.start(now);
                    osc.stop(now + 0.56);
                } catch (e) {
                    // blocked
                }
            },

            toggleSound() {
                this.isMuted = !this.isMuted;
                if (!this.isMuted) {
                    this.playMeow(true);
                }
            },

            onCatClicked() {
                this.playMeow(true);
                this.openDonationModal();
            },

            onHoverCat() {
                this.isHovered = true;
                this.isWalking = false;
                this.playMeow();
            },

            onLeaveCat() {
                this.isHovered = false;
            },

            minimizeCat() {
                this.isMinimized = true;
                this.showBubble = false;
                this.stopWalkPatrol();
            },

            restoreCat() {
                this.isMinimized = false;
                this.showBubble = true;
                this.playMeow(true);
                this.startWalkPatrol();
            },

            openDonationModal() {
                this.showModal = true;
                this.playMeow(true);
            }
        };
    }

</script>
