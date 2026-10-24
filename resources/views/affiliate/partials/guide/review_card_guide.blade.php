<!-- MODUL KHUSUS: PANDUAN STRATEGI JUAL GOOGLE REVIEW CARD -->
<div id="tab-content-review-card" class="tab-pane space-y-6">

    <!-- Hero Card Banner -->
    <div class="glass-panel p-5 rounded-3xl relative overflow-hidden border border-sky-500/30" style="background: radial-gradient(circle at top right, rgba(14, 165, 233, 0.15) 0%, rgba(11, 17, 32, 0.8) 100%);">
        <div class="flex items-start justify-between gap-3 mb-3">
            <div class="w-12 h-12 rounded-2xl bg-sky-500/20 text-sky-400 flex items-center justify-center text-2xl border border-sky-400/30 shadow-[0_0_20px_rgba(14,165,233,0.3)]">
                <i class="fa-solid fa-qrcode"></i>
            </div>
            <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-sky-500/20 text-sky-300 border border-sky-400/30">
                Profit Margin s/d 800%
            </span>
        </div>
        <h2 class="text-base font-extrabold text-white mb-1.5 tracking-tight">Playbook Jual Google Review Card</h2>
        <p class="text-xs text-slate-300 leading-relaxed mb-4">
            Produk terlaris dengan closing paling cepat! Pemilik toko, cafe, salon, dan klinik langsung paham manfaatnya hanya dalam <b>demo 5 detik</b>.
        </p>

        <!-- Quick CTA Buttons -->
        <div class="grid grid-cols-2 gap-2.5 pt-3 border-t border-white/10">
            <a href="{{ route('affiliate.review_proposals') }}" wire:navigate class="h-11 px-3 rounded-xl bg-sky-600 hover:bg-sky-500 text-white text-xs font-bold flex items-center justify-center gap-1.5 shadow-md shadow-sky-600/30 transition-all active:scale-95 whitespace-nowrap">
                <i class="fa-solid fa-star-half-stroke text-xs"></i>
                <span>Tawarkan Leads</span>
            </a>
            <a href="{{ route('affiliate.review_cards.index') }}" wire:navigate class="h-11 px-3 rounded-xl glass-panel hover:bg-white/10 text-slate-200 hover:text-white text-xs font-bold flex items-center justify-center gap-1.5 transition-all border border-white/15 active:scale-95 whitespace-nowrap">
                <i class="fa-solid fa-box text-xs text-amber-400"></i>
                <span>Beli Stok Kartu</span>
            </a>
        </div>
    </div>

    <!-- 1. Skema Keuntungan & Cuan Reseller -->
    <div class="glass-panel p-4 sm:p-5 rounded-2xl border border-white/10 space-y-4">
        <div class="flex items-center justify-between gap-2.5 pb-2.5 border-b border-white/5">
            <div class="flex items-center gap-2 text-xs font-bold text-amber-400 uppercase tracking-wider min-w-0 flex-1">
                <i class="fa-solid fa-calculator text-amber-400 shrink-0"></i>
                <span class="truncate">1. Kalkulator Cuan & Margin</span>
            </div>
            <span class="shrink-0 whitespace-nowrap px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-500/15 text-emerald-400 border border-emerald-500/30">
                ROI s/d 800%
            </span>
        </div>

        <p class="text-xs text-slate-300 leading-relaxed">
            Harga kartu di Scalify sangat terjangkau, sementara harga pasaran kartu NFC Google Review di toko dan resto berkisar antara <span class="text-white font-semibold">Rp 50.000 – Rp 99.000</span>.
        </p>

        <!-- Pricing Comparison Grid -->
        <div class="space-y-2.5">
            <div class="grid grid-cols-2 gap-2.5">
                <!-- Modal Reseller -->
                <div class="p-3 rounded-xl bg-slate-900/60 border border-white/5 flex flex-col justify-between">
                    <div class="flex items-center gap-1.5 text-slate-400 text-[10px] mb-1">
                        <i class="fa-solid fa-tag text-rose-400 text-[10px]"></i>
                        <span>Modal Kartu</span>
                    </div>
                    <div class="text-sm font-bold text-rose-400 tracking-tight whitespace-nowrap">
                        Rp 8.000 <span class="text-[10px] text-slate-400 font-normal">/ pcs</span>
                    </div>
                </div>

                <!-- Harga Jual Pasar -->
                <div class="p-3 rounded-xl bg-slate-900/60 border border-white/5 flex flex-col justify-between">
                    <div class="flex items-center gap-1.5 text-slate-400 text-[10px] mb-1">
                        <i class="fa-solid fa-store text-sky-400 text-[10px]"></i>
                        <span>Harga Jual Pasaran</span>
                    </div>
                    <div class="text-sm font-bold text-sky-400 tracking-tight whitespace-nowrap">
                        Rp 50rb – 85rb
                    </div>
                </div>
            </div>

            <!-- Cuan Bersih Highlight Banner -->
            <div class="p-3.5 rounded-xl bg-gradient-to-r from-emerald-950/40 via-emerald-900/20 to-teal-950/40 border border-emerald-500/30 flex items-center justify-between gap-3 shadow-[0_0_15px_rgba(16,185,129,0.1)]">
                <div class="flex items-center gap-2.5">
                    <div class="w-9 h-9 rounded-xl bg-emerald-500/20 border border-emerald-500/30 flex items-center justify-center text-emerald-400 text-sm shrink-0">
                        <i class="fa-solid fa-sack-dollar"></i>
                    </div>
                    <div>
                        <span class="text-[10px] text-emerald-300/90 font-semibold uppercase tracking-wider block">Profit Bersih Anda</span>
                        <div class="text-sm sm:text-base font-extrabold text-emerald-400 tracking-tight">
                            +Rp 42.000 – 75.000 <span class="text-[10px] font-normal text-emerald-300/70">/ kartu</span>
                        </div>
                    </div>
                </div>
                <div class="text-right shrink-0">
                    <span class="px-2 py-1 rounded-lg text-[10px] font-bold bg-emerald-500/20 text-emerald-300 border border-emerald-400/30">
                        +500% Cuan
                    </span>
                </div>
            </div>
        </div>

        <!-- Pro Tip: Paket Bundling Kasir -->
        <div class="text-[11px] text-slate-300 bg-blue-950/30 p-3 rounded-xl border border-blue-500/20 flex items-start gap-2.5">
            <div class="w-5 h-5 rounded-md bg-blue-500/20 text-blue-400 flex items-center justify-center shrink-0 mt-0.5 text-[10px]">
                <i class="fa-solid fa-lightbulb"></i>
            </div>
            <div class="leading-relaxed">
                <span class="text-white font-bold">Trik Cepat Cuan (Paket Bundling):</span> Jual 2 kartu per toko (1 di kasir + 1 di meja reservasi) seharga <span class="text-sky-300 font-semibold">Rp 120.000</span>. Modal hanya Rp 16rb – 20rb, profit bersih langsung <span class="text-emerald-400 font-bold">+Rp 100.000</span> dalam 1 kali closing!
            </div>
        </div>
    </div>

    <!-- 2. Trik Closing Magic Tap 5 Detik -->
    <div class="glass-panel p-5 rounded-2xl border border-white/10 space-y-3.5">
        <div class="flex items-center gap-2 text-xs font-bold text-sky-400 uppercase tracking-wider">
            <i class="fa-solid fa-wand-magic-sparkles"></i>
            <span>2. Trik Closing Offline "Magic Tap" 5 Detik</span>
        </div>
        <p class="text-xs text-slate-300 leading-relaxed">
            Metode paling mematikan saat Anda sedang nongkrong di cafe, potong rambut di barbershop, atau makan di resto langganan:
        </p>

        <div class="space-y-2.5 text-xs">
            <div class="flex items-start gap-2.5 p-3 rounded-xl bg-slate-900/50 border border-white/5">
                <span class="w-5 h-5 rounded-full bg-blue-500/20 text-blue-400 font-bold flex items-center justify-center shrink-0 text-[10px] mt-0.5">1</span>
                <div>
                    <b class="text-white">Bawa 1 Contoh Kartu Aktif</b>
                    <p class="text-slate-400 text-[11px] mt-0.5">Pastikan Anda sudah mengaktifkan 1 kartu review untuk demo langsung.</p>
                </div>
            </div>

            <div class="flex items-start gap-2.5 p-3 rounded-xl bg-slate-900/50 border border-white/5">
                <span class="w-5 h-5 rounded-full bg-blue-500/20 text-blue-400 font-bold flex items-center justify-center shrink-0 text-[10px] mt-0.5">2</span>
                <div>
                    <b class="text-white">Lakukan Trik Magic Tap ke HP Owner/Kasir</b>
                    <p class="text-slate-400 text-[11px] mt-0.5">Sapa owner/kasir: <i>"Mas/Mbak, boleh pinjam HP-nya 3 detik? Coba tempel ke kartu ini."</i></p>
                </div>
            </div>

            <div class="flex items-start gap-2.5 p-3 rounded-xl bg-slate-900/50 border border-white/5">
                <span class="w-5 h-5 rounded-full bg-blue-500/20 text-blue-400 font-bold flex items-center justify-center shrink-0 text-[10px] mt-0.5">3</span>
                <div>
                    <b class="text-white">Lihat Reaksi Takjub & Closing Langsung!</b>
                    <p class="text-slate-400 text-[11px] mt-0.5">
                        Begitu layar HP langsung memunculkan rating bintang 5 Google Maps mereka: <i>"Nah, bayangkan kalau customer tinggal tap begini di meja kasir, ulasan Google cafe Mas langsung melesat banyak!"</i>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- 3. Target Niche Bisnis Paling Empuk -->
    <div class="glass-panel p-5 rounded-2xl border border-white/10 space-y-3">
        <div class="flex items-center gap-2 text-xs font-bold text-emerald-400 uppercase tracking-wider">
            <i class="fa-solid fa-bullseye"></i>
            <span>3. Target Bisnis Paling Butuh Review Card</span>
        </div>
        <p class="text-xs text-slate-300 leading-relaxed">
            Fokus tawarkan ke 5 jenis usaha ini karena mereka sangat bergantung pada reputasi bintang Google Maps:
        </p>

        <div class="grid grid-cols-2 gap-2 text-xs">
            <div class="p-3 rounded-xl bg-slate-900/60 border border-white/5">
                <div class="flex items-center gap-1.5 font-bold text-white mb-1">
                    <i class="fa-solid fa-mug-hot text-amber-400 text-[11px]"></i>
                    <span>Cafe & Restoran</span>
                </div>
                <p class="text-[10px] text-slate-400">Ditaruh di kasir / meja tunggu. Pelanggan santai sambil ngopi.</p>
            </div>

            <div class="p-3 rounded-xl bg-slate-900/60 border border-white/5">
                <div class="flex items-center gap-1.5 font-bold text-white mb-1">
                    <i class="fa-solid fa-scissors text-blue-400 text-[11px]"></i>
                    <span>Barbershop & Salon</span>
                </div>
                <p class="text-[10px] text-slate-400">Customer puas dengan potongan rambut, langsung diajak tap ulasan.</p>
            </div>

            <div class="p-3 rounded-xl bg-slate-900/60 border border-white/5">
                <div class="flex items-center gap-1.5 font-bold text-white mb-1">
                    <i class="fa-solid fa-tooth text-emerald-400 text-[11px]"></i>
                    <span>Klinik & Apotek</span>
                </div>
                <p class="text-[10px] text-slate-400">Pasien selesai konsultasi/obat di resepsionis langsung tap kartu.</p>
            </div>

            <div class="p-3 rounded-xl bg-slate-900/60 border border-white/5">
                <div class="flex items-center gap-1.5 font-bold text-white mb-1">
                    <i class="fa-solid fa-car text-rose-400 text-[11px]"></i>
                    <span>Bengkel & Carwash</span>
                </div>
                <p class="text-[10px] text-slate-400">Saat customer bayar nota cuci mobil/servis di meja kasir.</p>
            </div>
        </div>
    </div>

    <!-- 4. Script Chat WhatsApp Closing Siap Salin -->
    <div class="glass-panel p-5 rounded-2xl border border-white/10 space-y-3.5">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-2 text-xs font-bold text-indigo-400 uppercase tracking-wider">
                <i class="fa-brands fa-whatsapp"></i>
                <span>4. Script Chat WA Siap Pakai</span>
            </div>
            <span class="text-[10px] text-slate-400">1-Klik Salin</span>
        </div>

        <!-- Script 1: Pendekatan Santai & Manfaat -->
        <div class="bg-slate-900/80 p-3.5 rounded-xl border border-white/10 relative">
            <div class="flex items-center justify-between mb-2">
                <span class="text-[11px] font-bold text-emerald-400">Script 1: Pendekatan Santai (Toko/Cafe)</span>
                <button type="button" onclick="copyReviewScript('script-rc-1')" class="text-[10px] text-slate-300 hover:text-white px-2 py-0.5 rounded bg-white/10 hover:bg-white/20 transition-all flex items-center gap-1">
                    <i class="fa-regular fa-copy"></i>
                    <span>Salin</span>
                </button>
            </div>
            <p id="script-rc-1" class="text-xs text-slate-300 font-mono leading-relaxed select-all">
                Halo Kak [Nama Owner / Admin [Nama Bisnis]], salam kenal dari saya [Nama Anda]. 😊

                Saya perhatikan ulasan dan tempat [Nama Bisnis] di Google Maps sudah sangat bagus. Supaya pelanggan yang datang makin rajin kasih review bintang 5 tanpa ribet cari nama toko, sekarang ada Smart Google Review Card.

                Tinggal taruh kartunya di meja kasir, customer cukup tempel HP (NFC) atau scan QR, dalam 3 detik langsung terbuka form review bintang 5!

                Harganya cuma 75 ribu sekali bayar selamanya tanpa biaya bulanan. Apakah boleh saya kirimkan video demo 5 detiknya Kak? 🙏
            </p>
        </div>

        <!-- Script 2: Follow Up Penawaran Langsung Closing -->
        <div class="bg-slate-900/80 p-3.5 rounded-xl border border-white/10 relative">
            <div class="flex items-center justify-between mb-2">
                <span class="text-[11px] font-bold text-sky-400">Script 2: Penawaran Promo & Garansi</span>
                <button type="button" onclick="copyReviewScript('script-rc-2')" class="text-[10px] text-slate-300 hover:text-white px-2 py-0.5 rounded bg-white/10 hover:bg-white/20 transition-all flex items-center gap-1">
                    <i class="fa-regular fa-copy"></i>
                    <span>Salin</span>
                </button>
            </div>
            <p id="script-rc-2" class="text-xs text-slate-300 font-mono leading-relaxed select-all">
                Halo Kak [Nama Owner], untuk bantu [Nama Bisnis] makin mendominasi urutan teratas pencarian lokal di Google Maps minggu ini, kami ada promo khusus:

                ✅ 1x Smart Review Card (Support NFC & QR Code)
                ✅ Gratis Aktivasi & Terhubung Langsung ke Google Maps Toko Kakak
                ✅ Sekali Beli Aktif Selamanya (Tanpa Iuran)

                Cuma Rp 69.000 (hemat dari harga normal 99rb). Kami bisa bantu setingkan hari ini juga Kak, mau dikirimkan ke alamat mana ya?
            </p>
        </div>
    </div>

    <!-- 5. Cara Menjawab Keberatan Klien (Objection Handling) -->
    <div class="glass-panel p-5 rounded-2xl border border-white/10 space-y-3">
        <div class="flex items-center gap-2 text-xs font-bold text-purple-400 uppercase tracking-wider">
            <i class="fa-solid fa-shield-halved"></i>
            <span>5. Solusi Menjawab Keberatan Klien</span>
        </div>

        <div class="space-y-2.5 text-xs">
            <div class="p-3 rounded-xl bg-slate-900/60 border border-white/5">
                <b class="text-rose-300 block mb-1">❌ "Kalau HP customer jadul atau gak ada NFC gimana?"</b>
                <p class="text-slate-300 leading-relaxed text-[11px]">
                    <b>Jawaban:</b> <i>"Tenang Kak, kartu ini punya teknologi ganda! Jika HP ada NFC tinggal tap, jika HP belum ada NFC tinggal scan QR Code di kartu pakai kamera HP biasa. Jadi 100% semua jenis HP Android & iPhone bisa pakai."</i>
                </p>
            </div>

            <div class="p-3 rounded-xl bg-slate-900/60 border border-white/5">
                <b class="text-rose-300 block mb-1">❌ "Review Google toko saya kan sudah lumayan banyak mas."</b>
                <p class="text-slate-300 leading-relaxed text-[11px]">
                    <b>Jawaban:</b> <i>"Betul Kak, tapi kompetitor di sekitar juga terus bertambah. Algoritma Google Maps selalu memprioritaskan bisnis yang ulasannya konsisten baru setiap minggu. Dengan kartu ini di kasir, jumlah ulasan bintang 5 Kakak akan bertambah otomatis setiap hari tanpa perlu capek minta ke customer."</i>
                </p>
            </div>

            <div class="p-3 rounded-xl bg-slate-900/60 border border-white/5">
                <b class="text-rose-300 block mb-1">❌ "Cara setting link tokonya ribet gak mas?"</b>
                <p class="text-slate-300 leading-relaxed text-[11px]">
                    <b>Jawaban:</b> <i>"Sama sekali tidak Kak! Kakak cukup berikan nama bisnis Google Maps-nya, tim kami yang bantu setingkan langsung sampai siap pakai. Begitu kartu sampai di meja kasir, langsung bisa digunakan detik itu juga."</i>
                </p>
            </div>
        </div>
    </div>

    <!-- Bottom Action Card -->
    <div class="p-4 rounded-2xl bg-gradient-to-r from-sky-900/40 via-blue-900/30 to-indigo-900/40 border border-sky-500/30 text-center space-y-2.5">
        <h3 class="text-xs font-bold text-white">Siap Mulai Menghasilkan Cuan dari Review Card?</h3>
        <p class="text-[11px] text-sky-200/70 max-w-xs mx-auto">
            Buka menu penawaran sekarang untuk melihat ratusan calon klien yang siap Anda tawari di kota Anda.
        </p>
        <div class="pt-1">
            <a href="{{ route('affiliate.review_proposals') }}" wire:navigate class="inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl bg-sky-500 hover:bg-sky-400 text-white text-xs font-bold shadow-lg shadow-sky-500/30 transition-all">
                <i class="fa-solid fa-arrow-right"></i>
                <span>Buka Menu Tawarkan Review Card</span>
            </a>
        </div>
    </div>

</div>

<script>
    function copyReviewScript(elementId) {
        const text = document.getElementById(elementId).innerText.trim();
        navigator.clipboard.writeText(text).then(() => {
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    toast: true
                    , position: 'top-end'
                    , icon: 'success'
                    , title: 'Script WA Berhasil Disalin!'
                    , background: '#1E293B'
                    , color: '#fff'
                    , showConfirmButton: false
                    , timer: 2000
                    , timerProgressBar: true
                });
            } else {
                alert('Script WA Berhasil Disalin!');
            }
        });
    }

</script>
