<!-- TAB 3: MARKETING KIT & BANNER -->
<div id="tab-content-marketing-kit" class="tab-pane hidden space-y-5">
    <div class="glass-panel p-5 rounded-2xl">
        <h2 class="text-sm font-bold text-white mb-2 flex items-center gap-2">
            <i class="fa-solid fa-images text-blue-400"></i> Marketing Kit Siap Pakai
        </h2>
        <p class="text-xs text-slate-300 leading-relaxed">
            Gunakan materi visual berstandar agensi ini untuk publikasi promosi. Anda dapat mengunduh poster beresolusi tinggi langsung dari perangkat Anda.
        </p>
    </div>

    <!-- Banner Templates -->
    <div class="space-y-4">
        <!-- Banner 1: UMKM Digital -->
        <div class="glass-panel p-4 rounded-2xl border border-white/10 space-y-3">
            <div class="relative rounded-xl overflow-hidden aspect-video bg-gradient-to-br from-slate-900 via-blue-950 to-slate-900 p-5 flex flex-col justify-between border border-blue-500/20">
                <div class="flex items-center justify-between">
                    <span class="text-[10px] font-semibold px-2 py-0.5 rounded bg-blue-500/20 text-blue-300 border border-blue-400/30">Scalify Creative Agency</span>
                    <span class="text-[10px] text-slate-400 flex items-center gap-1"><i class="fa-solid fa-shield-halved text-emerald-400 text-[9px]"></i> Garansi Maintenance</span>
                </div>
                <div>
                    <h3 class="text-sm font-bold text-white leading-snug">Jasa Pembuatan Website Bisnis & UMKM Profesional</h3>
                    <p class="text-[11px] text-slate-300 mt-1">Otomasi WhatsApp • Katalog Online • Desain Modern 2026</p>
                </div>
                <div class="flex items-center justify-between text-[10px] text-slate-400 border-t border-white/10 pt-2">
                    <span>Partner ID: <b class="text-white">{{ $affiliate->affiliate_code }}</b></span>
                    <span class="text-blue-300 font-semibold">Mulai 200 Ribuan/Bulan</span>
                </div>
            </div>

            <div class="p-2.5 rounded-xl bg-slate-900/60 border border-white/5">
                <p class="text-[11px] text-slate-300 line-clamp-2" id="caption-banner-1">
                    Bisnis tanpa website resmi berisiko kehilangan potensi pelanggan di era digital. Bangun kredibilitas usaha Anda dengan website profesional bersama Scalify Intelligence. Konsultasi dan demo portofolio: {{ url('/sobat-scalify?ref=' . $affiliate->affiliate_code) }}
                </p>
            </div>

            <div class="flex gap-2">
                <button onclick="downloadBannerCanvas('Jasa Website Bisnis & UMKM', 'Otomasi WhatsApp • Desain Modern 2026', 'banner_umkm.png')" class="flex-1 py-2.5 bg-blue-600 hover:bg-blue-500 text-white text-xs font-semibold rounded-xl transition-all flex items-center justify-center gap-1.5">
                    <i class="fa-solid fa-download text-xs"></i> Unduh Poster HD
                </button>
                <button onclick="copyTextById('caption-banner-1', 'Caption Banner berhasil disalin!')" class="px-3.5 py-2.5 glass-panel text-slate-300 hover:text-white text-xs font-semibold rounded-xl transition-all">
                    <i class="fa-solid fa-copy text-xs"></i> Salin Teks
                </button>
            </div>
        </div>

        <!-- Banner 2: Mahasiswa & Skripsi -->
        <div class="glass-panel p-4 rounded-2xl border border-white/10 space-y-3">
            <div class="relative rounded-xl overflow-hidden aspect-video bg-gradient-to-br from-slate-900 via-indigo-950 to-slate-900 p-5 flex flex-col justify-between border border-indigo-500/20">
                <div class="flex items-center justify-between">
                    <span class="text-[10px] font-semibold px-2 py-0.5 rounded bg-indigo-500/20 text-indigo-300 border border-indigo-400/30">Student Tech Solution</span>
                    <span class="text-[10px] text-indigo-300 flex items-center gap-1"><i class="fa-solid fa-bolt text-[9px]"></i> Pengerjaan Cepat</span>
                </div>
                <div>
                    <h3 class="text-sm font-bold text-white leading-snug">Jasa Pembuatan Website Skripsi & Tugas Akhir</h3>
                    <p class="text-[11px] text-slate-300 mt-1">Laravel, React, AI Integration, Full Source Code & Bimbingan</p>
                </div>
                <div class="flex items-center justify-between text-[10px] text-slate-400 border-t border-white/10 pt-2">
                    <span>Partner: <b class="text-white">{{ $affiliate->name }}</b></span>
                    <span class="text-emerald-400 font-semibold">Siap Sidang Lancar</span>
                </div>
            </div>

            <div class="p-2.5 rounded-xl bg-slate-900/60 border border-white/5">
                <p class="text-[11px] text-slate-300 line-clamp-2" id="caption-banner-2">
                    Membutuhkan bantuan pengembangan sistem atau website untuk tugas akhir dan skripsi? Dapatkan solusi sistem teruji dengan bimbingan komprehensif. Konsultasi langsung di: {{ url('/sobat-scalify?ref=' . $affiliate->affiliate_code) }}
                </p>
            </div>

            <div class="flex gap-2">
                <button onclick="downloadBannerCanvas('Website Tugas Akhir & Skripsi', 'Full Source Code + Bimbingan Sampai Lulus', 'banner_mahasiswa.png')" class="flex-1 py-2.5 bg-blue-600 hover:bg-blue-500 text-white text-xs font-semibold rounded-xl transition-all flex items-center justify-center gap-1.5">
                    <i class="fa-solid fa-download text-xs"></i> Unduh Poster HD
                </button>
                <button onclick="copyTextById('caption-banner-2', 'Caption Mahasiswa berhasil disalin!')" class="px-3.5 py-2.5 glass-panel text-slate-300 hover:text-white text-xs font-semibold rounded-xl transition-all">
                    <i class="fa-solid fa-copy text-xs"></i> Salin Teks
                </button>
            </div>
        </div>

        <!-- Banner 3: F&B / Menu QR -->
        <div class="glass-panel p-4 rounded-2xl border border-white/10 space-y-3">
            <div class="relative rounded-xl overflow-hidden aspect-video bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900 p-5 flex flex-col justify-between border border-white/10">
                <div class="flex items-center justify-between">
                    <span class="text-[10px] font-semibold px-2 py-0.5 rounded bg-white/10 text-slate-200 border border-white/10">F&B Digital Solution</span>
                    <span class="text-[10px] text-slate-300 flex items-center gap-1"><i class="fa-solid fa-qrcode text-[9px]"></i> Menu QR Cafe</span>
                </div>
                <div>
                    <h3 class="text-sm font-bold text-white leading-snug">Website Resto & Menu Digital Cafe Modern</h3>
                    <p class="text-[11px] text-slate-300 mt-1">Pesan Langsung via WhatsApp • Efisiensi Operasional Resto</p>
                </div>
                <div class="flex items-center justify-between text-[10px] text-slate-400 border-t border-white/10 pt-2">
                    <span>Scalify Intelligence</span>
                    <span class="text-emerald-400 font-semibold">Tingkatkan Omset</span>
                </div>
            </div>

            <div class="p-2.5 rounded-xl bg-slate-900/60 border border-white/5">
                <p class="text-[11px] text-slate-300 line-clamp-2" id="caption-banner-3">
                    Tingkatkan kenyamanan pelanggan cafe dan restoran dengan Menu QR interaktif yang langsung terhubung ke WhatsApp kasir. Cek demo gratis sekarang: {{ url('/sobat-scalify?ref=' . $affiliate->affiliate_code) }}
                </p>
            </div>

            <div class="flex gap-2">
                <button onclick="downloadBannerCanvas('Website Resto & Menu QR Cafe', 'Pesan Langsung WA • Hemat Cetak Buku Menu', 'banner_cafe.png')" class="flex-1 py-2.5 bg-blue-600 hover:bg-blue-500 text-white text-xs font-semibold rounded-xl transition-all flex items-center justify-center gap-1.5">
                    <i class="fa-solid fa-download text-xs"></i> Unduh Poster HD
                </button>
                <button onclick="copyTextById('caption-banner-3', 'Caption Cafe berhasil disalin!')" class="px-3.5 py-2.5 glass-panel text-slate-300 hover:text-white text-xs font-semibold rounded-xl transition-all">
                    <i class="fa-solid fa-copy text-xs"></i> Salin Teks
                </button>
            </div>
        </div>
    </div>
</div>
