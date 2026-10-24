<!-- MODUL KHUSUS: PANDUAN REFERRAL RESELLER 3 TINGKAT -->
<div id="tab-content-referral" class="tab-pane space-y-5" x-data="{ copyToast: false, toastMsg: '' }">

    <!-- Toast Notification -->
    <div x-show="copyToast" x-cloak x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-2" class="fixed top-5 left-1/2 -translate-x-1/2 z-50 px-4 py-2 bg-emerald-500 text-slate-950 font-semibold text-xs rounded-full shadow-lg shadow-emerald-500/20 flex items-center gap-2">
        <i class="fa-solid fa-circle-check"></i>
        <span x-text="toastMsg"></span>
    </div>

    <!-- Hero Card Banner -->
    <div class="glass-panel p-5 rounded-3xl relative overflow-hidden border border-indigo-500/30" style="background: radial-gradient(circle at top right, rgba(99, 102, 241, 0.2) 0%, rgba(11, 17, 32, 0.85) 100%);">
        <div class="flex items-start justify-between gap-3 mb-3">
            <div class="w-12 h-12 rounded-2xl bg-indigo-500/20 text-indigo-400 flex items-center justify-center text-2xl border border-indigo-400/30 shadow-[0_0_20px_rgba(99,102,241,0.3)]">
                <i class="fa-solid fa-network-wired"></i>
            </div>
            <span class="shrink-0 whitespace-nowrap px-2.5 py-1 rounded-full text-[10px] font-bold bg-indigo-500/25 text-indigo-300 border border-indigo-400/30">
                100% Cuan Pasif
            </span>
        </div>
        <h2 class="text-base font-extrabold text-white mb-1.5 tracking-tight">Playbook Referral Jaringan Reseller</h2>
        <p class="text-xs text-slate-300 leading-relaxed mb-4">
            Ajak teman jadi reseller Review Card sekali, nikmati bonus komisi mengalir otomatis <b>hingga 3 generasi downline</b> setiap kali mereka membeli kuota kartu!
        </p>

        <!-- Action Buttons -->
        <div class="grid grid-cols-2 gap-2.5 pt-3 border-t border-white/10">
            <a href="{{ route('affiliate.referrals.index') }}" wire:navigate class="h-11 px-3 rounded-xl bg-indigo-600 hover:bg-indigo-500 text-white text-xs font-bold flex items-center justify-center gap-2 shadow-md shadow-indigo-600/30 transition-all active:scale-95 whitespace-nowrap">
                <i class="fa-solid fa-users text-xs"></i>
                <span>Buka Jaringan</span>
            </a>
            <button type="button" @click="navigator.clipboard.writeText('{{ $affiliate->referral_url }}'); toastMsg = 'Tautan referral disalin!'; copyToast = true; setTimeout(() => copyToast = false, 2000);" class="h-11 px-3 rounded-xl glass-panel hover:bg-white/10 text-slate-200 hover:text-white text-xs font-bold flex items-center justify-center gap-2 transition-all border border-white/15 active:scale-95 whitespace-nowrap">
                <i class="fa-regular fa-copy text-xs text-indigo-400"></i>
                <span>Salin Link</span>
            </button>
        </div>
    </div>

    <!-- 1. KEUNTUNGAN & MANFAAT -->
    <div class="glass-panel p-4 sm:p-5 rounded-2xl border border-white/10 space-y-4">
        <!-- Header Rapi dengan Icon Badge & Label Non-Wrapping -->
        <div class="flex items-center justify-between gap-2.5 pb-2.5 border-b border-white/5">
            <div class="flex items-center gap-2.5 min-w-0 flex-1">
                <div class="w-7 h-7 rounded-lg bg-amber-500/20 text-amber-400 border border-amber-500/30 flex items-center justify-center shrink-0 text-xs">
                    <i class="fa-solid fa-gem"></i>
                </div>
                <h3 class="text-xs sm:text-sm font-bold text-white tracking-wide truncate">
                    1. Keuntungan & Manfaat
                </h3>
            </div>
            <span class="shrink-0 whitespace-nowrap px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-amber-500/15 text-amber-300 border border-amber-500/30">
                Auto-Income
            </span>
        </div>

        <div class="grid grid-cols-1 gap-2.5 text-xs text-slate-300">
            <!-- Poin 1 -->
            <div class="p-3 rounded-xl bg-slate-900/60 border border-white/5 flex items-start gap-3">
                <div class="w-7 h-7 rounded-lg bg-emerald-500/20 text-emerald-400 flex items-center justify-center shrink-0 mt-0.5">
                    <i class="fa-solid fa-sack-dollar text-xs"></i>
                </div>
                <div>
                    <h4 class="font-bold text-white text-xs mb-0.5">Penghasilan Pasif Murni (Tanpa Jualan Fisik)</h4>
                    <p class="text-[11px] text-slate-400 leading-relaxed">
                        Anda tidak perlu mencetak kartu, kirim pesanan, atau negosiasi ke kafe. Cukup ajak teman yang aktif jualan, dan Anda menerima bagian komisi setiap kali mereka order kartu.
                    </p>
                </div>
            </div>

            <!-- Poin 2 -->
            <div class="p-3 rounded-xl bg-slate-900/60 border border-white/5 flex items-start gap-3">
                <div class="w-7 h-7 rounded-lg bg-indigo-500/20 text-indigo-400 flex items-center justify-center shrink-0 mt-0.5">
                    <i class="fa-solid fa-sitemap text-xs"></i>
                </div>
                <div>
                    <h4 class="font-bold text-white text-xs mb-0.5">Komisi 3 Generasi (Tier 1, Tier 2, Tier 3)</h4>
                    <p class="text-[11px] text-slate-400 leading-relaxed">
                        Ketika teman Anda (Tier 1) mengajak temannya lagi (Tier 2), bahkan temannya lagi (Tier 3), bonus komisi tetap mengalir ke saldo Anda!
                    </p>
                </div>
            </div>

            <!-- Poin 3 -->
            <div class="p-3 rounded-xl bg-slate-900/60 border border-white/5 flex items-start gap-3">
                <div class="w-7 h-7 rounded-lg bg-blue-500/20 text-blue-400 flex items-center justify-center shrink-0 mt-0.5">
                    <i class="fa-solid fa-handshake text-xs"></i>
                </div>
                <div>
                    <h4 class="font-bold text-white text-xs mb-0.5">100% Adil & Win-Win Solution</h4>
                    <p class="text-[11px] text-slate-400 leading-relaxed">
                        Teman Anda tidak dirugikan sedikit pun! Mereka tetap membeli kuota dengan harga standar (Rp 10.000) dan untung Rp 50.000 - Rp 100.000 per kartu. Bonus referral murni dibayarkan oleh Scalify sebagai bonus loyalitas.
                    </p>
                </div>
            </div>

            <!-- Poin 4 -->
            <div class="p-3 rounded-xl bg-slate-900/60 border border-white/5 flex items-start gap-3">
                <div class="w-7 h-7 rounded-lg bg-teal-500/20 text-teal-400 flex items-center justify-center shrink-0 mt-0.5">
                    <i class="fa-solid fa-wallet text-xs"></i>
                </div>
                <div>
                    <h4 class="font-bold text-white text-xs mb-0.5">Langsung Masuk Saldo & Bisa Ditarik</h4>
                    <p class="text-[11px] text-slate-400 leading-relaxed">
                        Komisi langsung tercatat di mutasi riwayat dan menambah saldo dompet akun Anda. Begitu mencapai batas penarikan, dana bisa langsung ditarik ke rekening / DANA / e-wallet.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- 2. SKEMA KOMISI & SIMULASI CUAN -->
    <div class="glass-panel p-4 sm:p-5 rounded-2xl border border-white/10 space-y-4">
        <!-- Header Rapi -->
        <div class="flex items-center justify-between gap-2.5 pb-2.5 border-b border-white/5">
            <div class="flex items-center gap-2.5 min-w-0 flex-1">
                <div class="w-7 h-7 rounded-lg bg-indigo-500/20 text-indigo-400 border border-indigo-500/30 flex items-center justify-center shrink-0 text-xs">
                    <i class="fa-solid fa-calculator"></i>
                </div>
                <h3 class="text-xs sm:text-sm font-bold text-white tracking-wide truncate">
                    2. Skema Komisi & Simulasi
                </h3>
            </div>
            <span class="shrink-0 whitespace-nowrap px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-500/15 text-emerald-400 border border-emerald-500/30">
                Transparan
            </span>
        </div>

        <!-- Tabel Pembagian Komisi -->
        <div class="bg-slate-900/80 rounded-xl overflow-hidden border border-white/5 text-xs">
            <div class="grid grid-cols-3 bg-white/5 p-2.5 font-bold text-slate-300 border-b border-white/5">
                <div>Tingkat</div>
                <div class="text-center">Bonus/Kartu</div>
                <div class="text-right">Paket 10 Unit</div>
            </div>
            <div class="grid grid-cols-3 p-2.5 border-b border-white/5 text-slate-300 items-center">
                <div class="font-semibold text-indigo-300">Tier 1 (Teman)</div>
                <div class="text-center font-bold text-emerald-400 font-mono">Rp 500</div>
                <div class="text-right font-bold text-emerald-400 font-mono">Rp 5.000</div>
            </div>
            <div class="grid grid-cols-3 p-2.5 border-b border-white/5 text-slate-300 items-center">
                <div class="font-semibold text-blue-300">Tier 2</div>
                <div class="text-center font-bold text-emerald-400 font-mono">Rp 250</div>
                <div class="text-right font-bold text-emerald-400 font-mono">Rp 2.500</div>
            </div>
            <div class="grid grid-cols-3 p-2.5 text-slate-300 items-center">
                <div class="font-semibold text-teal-300">Tier 3</div>
                <div class="text-center font-bold text-emerald-400 font-mono">Rp 125</div>
                <div class="text-right font-bold text-emerald-400 font-mono">Rp 1.250</div>
            </div>
        </div>

        <!-- Box Simulasi Nyata -->
        <div class="p-3.5 rounded-xl bg-gradient-to-r from-indigo-950/40 via-purple-950/30 to-blue-950/40 border border-indigo-500/30 text-xs">
            <div class="flex items-center gap-2 mb-2 text-indigo-300 font-bold">
                <i class="fa-solid fa-lightbulb"></i>
                <span>Contoh Simulasi Pasif Income Bulanan:</span>
            </div>
            <p class="text-[11px] text-slate-300 leading-relaxed mb-2.5">
                Anda mengajak <b>5 teman aktif</b>. Setiap orang rata-rata menjual <b>10 unit kartu</b> per bulan, dan mereka menduplikasi hal yang sama:
            </p>
            <div class="space-y-1.5 text-[11px] text-slate-300 bg-slate-900/60 p-2.5 rounded-lg border border-white/5 font-mono">
                <div class="flex justify-between">
                    <span>Tier 1 (5 org x 10 kartu):</span>
                    <span class="text-emerald-400 font-bold">Rp 25.000</span>
                </div>
                <div class="flex justify-between">
                    <span>Tier 2 (15 org x 10 kartu):</span>
                    <span class="text-emerald-400 font-bold">Rp 37.500</span>
                </div>
                <div class="flex justify-between">
                    <span>Tier 3 (45 org x 10 kartu):</span>
                    <span class="text-emerald-400 font-bold">Rp 56.250</span>
                </div>
                <div class="flex justify-between border-t border-white/10 pt-1 font-bold text-white">
                    <span>Total Pasif Income / Bulan:</span>
                    <span class="text-emerald-400 text-xs">Rp 118.750</span>
                </div>
            </div>
            <p class="text-[10px] text-slate-400 mt-2 italic">
                *Cuan ini masuk terus menerus setiap kali tim Anda melakukan repeat order kuota kartu!
            </p>
        </div>
    </div>

    <!-- 3. CARA KERJA & STRATEGI -->
    <div class="glass-panel p-4 sm:p-5 rounded-2xl border border-white/10 space-y-4">
        <!-- Header Rapi -->
        <div class="flex items-center justify-between gap-2.5 pb-2.5 border-b border-white/5">
            <div class="flex items-center gap-2.5 min-w-0 flex-1">
                <div class="w-7 h-7 rounded-lg bg-sky-500/20 text-sky-400 border border-sky-500/30 flex items-center justify-center shrink-0 text-xs">
                    <i class="fa-solid fa-list-ol"></i>
                </div>
                <h3 class="text-xs sm:text-sm font-bold text-white tracking-wide truncate">
                    3. Cara Kerja (4 Langkah)
                </h3>
            </div>
            <span class="shrink-0 whitespace-nowrap px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-sky-500/15 text-sky-300 border border-sky-500/30">
                Praktis
            </span>
        </div>

        <div class="space-y-3 text-xs">
            <!-- Langkah 1 -->
            <div class="flex items-start gap-3">
                <div class="w-6 h-6 rounded-full bg-indigo-600 text-white flex items-center justify-center font-bold text-xs shrink-0 mt-0.5 shadow-md shadow-indigo-600/30">
                    1
                </div>
                <div>
                    <h4 class="font-bold text-white text-xs mb-0.5">Targetkan Orang yang Tepat</h4>
                    <p class="text-[11px] text-slate-400 leading-relaxed">
                        Ajak teman kuliah/sekolah, rekan freelancer, sales keliling, anak percetakan, atau teman yang sedang mencari peluang usaha modal kecil tanpa ribet.
                    </p>
                </div>
            </div>

            <!-- Langkah 2 -->
            <div class="flex items-start gap-3">
                <div class="w-6 h-6 rounded-full bg-indigo-600 text-white flex items-center justify-center font-bold text-xs shrink-0 mt-0.5 shadow-md shadow-indigo-600/30">
                    2
                </div>
                <div>
                    <h4 class="font-bold text-white text-xs mb-0.5">Tunjukkan Peluang Produk Fisiknya</h4>
                    <p class="text-[11px] text-slate-400 leading-relaxed">
                        Beri tahu mereka: <i>"Bro, sekarang kafe dan restoran butuh ulasan Google Maps bintang 5. Kita bisa jual standee QR / NFC seharga 50rb-80rb, modalnya cuma 10rb per unit. Mau barengan gak?"</i>
                    </p>
                </div>
            </div>

            <!-- Langkah 3 -->
            <div class="flex items-start gap-3">
                <div class="w-6 h-6 rounded-full bg-indigo-600 text-white flex items-center justify-center font-bold text-xs shrink-0 mt-0.5 shadow-md shadow-indigo-600/30">
                    3
                </div>
                <div>
                    <h4 class="font-bold text-white text-xs mb-0.5">Kirimkan Link Pendaftaran Unik Anda</h4>
                    <p class="text-[11px] text-slate-400 leading-relaxed">
                        Pastikan teman Anda mendaftar melalui link referral Anda (<code class="text-indigo-300 font-mono text-[10px]">{{ $affiliate->affiliate_code }}</code>). Dengan begitu, akun mereka otomatis terkunci sebagai downline Anda selamanya.
                    </p>
                </div>
            </div>

            <!-- Langkah 4 -->
            <div class="flex items-start gap-3">
                <div class="w-6 h-6 rounded-full bg-indigo-600 text-white flex items-center justify-center font-bold text-xs shrink-0 mt-0.5 shadow-md shadow-indigo-600/30">
                    4
                </div>
                <div>
                    <h4 class="font-bold text-white text-xs mb-0.5">Bantu Mereka Order Kartu Pertama Kali</h4>
                    <p class="text-[11px] text-slate-400 leading-relaxed">
                        Begitu mereka membeli paket kuota kartu (1, 5, atau 10 unit) dan pembayaran diverifikasi admin, notifikasi komisi langsung masuk ke HP Anda!
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- 4. TEMPLATE COPYWRITING SIAP PAKAI -->
    <div class="glass-panel p-4 sm:p-5 rounded-2xl border border-white/10 space-y-4">
        <!-- Header Rapi -->
        <div class="flex items-center justify-between gap-2.5 pb-2.5 border-b border-white/5">
            <div class="flex items-center gap-2.5 min-w-0 flex-1">
                <div class="w-7 h-7 rounded-lg bg-teal-500/20 text-teal-400 border border-teal-500/30 flex items-center justify-center shrink-0 text-xs">
                    <i class="fa-solid fa-copy"></i>
                </div>
                <h3 class="text-xs sm:text-sm font-bold text-white tracking-wide truncate">
                    4. Template Copywriting
                </h3>
            </div>
            <span class="shrink-0 whitespace-nowrap px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-teal-500/15 text-teal-300 border border-teal-500/30">
                Tinggal Kirim
            </span>
        </div>

        <!-- Script 1: WhatsApp Japri Teman Santai -->
        @php
        $script1 = "Bro, lu mau dapet cuan tambahan ga? Sekarang lagi rame kafe sama toko lokal butuh standee Google Review buat naikin rating bintang 5. Modal kartunya murah banget cuma 10 ribuan, tapi bisa dijual 50rb - 80rb ke kafe. Lumayan banget profitnya. Coba daftar gratis jadi partner di sini deh:\n\n" . $affiliate->referral_url;
        @endphp
        <div class="p-3.5 rounded-xl bg-slate-900/70 border border-white/5 space-y-2.5">
            <div class="flex items-center justify-between gap-2">
                <span class="text-xs font-bold text-white flex items-center gap-1.5 truncate">
                    <i class="fa-brands fa-whatsapp text-emerald-400 shrink-0"></i>
                    <span>Opsi 1: Japri Teman Santai</span>
                </span>
                <button type="button" @click="navigator.clipboard.writeText(`{{ $script1 }}`); toastMsg = 'Teks berhasil disalin!'; copyToast = true; setTimeout(() => copyToast = false, 2000);" class="px-2.5 py-1 rounded-lg bg-emerald-500/15 hover:bg-emerald-500 text-emerald-300 hover:text-white text-[10px] font-bold flex items-center gap-1.5 transition-all border border-emerald-500/30 active:scale-95 shrink-0 shadow-sm">
                    <i class="fa-regular fa-copy"></i>
                    <span>Salin Teks</span>
                </button>
            </div>
            <div class="text-[11px] text-slate-300 bg-slate-950/60 p-2.5 rounded-lg border border-white/5 leading-relaxed font-sans select-all whitespace-pre-line">{{ $script1 }}</div>
        </div>

        <!-- Script 2: Broadcast Grup WhatsApp / Mahasiswa -->
        @php
        $script2 = "Halo temen-temen! Buat yang lagi cari sampingan modal kecil dengan potensi untung gede, ada peluang bagus jadi reseller Smart QR Review Card. Produk fisik yang dicari banget sama pemilik cafe, salon, dan klinik di sekitar kita.\n\nPendaftaran partner resmi gratis dan bisa langsung dapat materi promosi siap pakai:\n" . $affiliate->referral_url . "\n\nYuk buruan ambil slotnya mumpung belum banyak yang garap di kota kita!";
        @endphp
        <div class="p-3.5 rounded-xl bg-slate-900/70 border border-white/5 space-y-2.5">
            <div class="flex items-center justify-between gap-2">
                <span class="text-xs font-bold text-white flex items-center gap-1.5 truncate">
                    <i class="fa-solid fa-users text-blue-400 shrink-0"></i>
                    <span>Opsi 2: Broadcast Grup Komunitas</span>
                </span>
                <button type="button" @click="navigator.clipboard.writeText(`{{ $script2 }}`); toastMsg = 'Teks berhasil disalin!'; copyToast = true; setTimeout(() => copyToast = false, 2000);" class="px-2.5 py-1 rounded-lg bg-blue-500/15 hover:bg-blue-500 text-blue-300 hover:text-white text-[10px] font-bold flex items-center gap-1.5 transition-all border border-blue-500/30 active:scale-95 shrink-0 shadow-sm">
                    <i class="fa-regular fa-copy"></i>
                    <span>Salin Teks</span>
                </button>
            </div>
            <div class="text-[11px] text-slate-300 bg-slate-950/60 p-2.5 rounded-lg border border-white/5 leading-relaxed font-sans select-all whitespace-pre-line">{{ $script2 }}</div>
        </div>

        <!-- Script 3: Story WhatsApp / Instagram -->
        @php
        $script3 = "Lagi rame banget pemilik cafe & resto pesen kartu Smart QR Google Review buat kasir mereka. Modal mulai 10 ribuan bisa dijual 50k-80k per toko. Yang mau ikut jadi reseller resmi, daftar gratis klik link ini ya: " . $affiliate->referral_url;
        @endphp
        <div class="p-3.5 rounded-xl bg-slate-900/70 border border-white/5 space-y-2.5">
            <div class="flex items-center justify-between gap-2">
                <span class="text-xs font-bold text-white flex items-center gap-1.5 truncate">
                    <i class="fa-brands fa-instagram text-pink-400 shrink-0"></i>
                    <span>Opsi 3: Story WhatsApp / IG</span>
                </span>
                <button type="button" @click="navigator.clipboard.writeText(`{{ $script3 }}`); toastMsg = 'Teks berhasil disalin!'; copyToast = true; setTimeout(() => copyToast = false, 2000);" class="px-2.5 py-1 rounded-lg bg-pink-500/15 hover:bg-pink-500 text-pink-300 hover:text-white text-[10px] font-bold flex items-center gap-1.5 transition-all border border-pink-500/30 active:scale-95 shrink-0 shadow-sm">
                    <i class="fa-regular fa-copy"></i>
                    <span>Salin Teks</span>
                </button>
            </div>
            <div class="text-[11px] text-slate-300 bg-slate-950/60 p-2.5 rounded-lg border border-white/5 leading-relaxed font-sans select-all whitespace-pre-line">{{ $script3 }}</div>
        </div>
    </div>

    <!-- Bottom CTA Bar -->
    <div class="p-4 rounded-2xl bg-gradient-to-r from-indigo-900/40 via-blue-900/30 to-purple-900/40 border border-indigo-500/30 text-center">
        <h3 class="text-xs font-bold text-white mb-1">Mulai Bangun Jaringan Reseller Anda Sekarang!</h3>
        <p class="text-[11px] text-indigo-200/80 mb-3 leading-relaxed">Semakin banyak teman yang aktif menjual, semakin besar komisi pasif yang Anda nikmati setiap hari.</p>
        <a href="{{ route('affiliate.referrals.index') }}" wire:navigate class="inline-flex items-center justify-center gap-2 py-2.5 px-6 rounded-xl bg-indigo-600 hover:bg-indigo-500 text-white text-xs font-bold shadow-lg shadow-indigo-600/30 transition-all active:scale-95">
            <i class="fa-solid fa-network-wired text-xs"></i>
            <span>Buka Dashboard Tim & Komisi</span>
        </a>
    </div>

</div>
