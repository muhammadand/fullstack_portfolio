<!-- Certificate Verification Section (Clean & Minimal) -->
<section id="verifikasi-sertifikat" class="py-20 bg-slate-50 relative">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Section Header -->
        <div class="text-center max-w-xl mx-auto mb-10">
            <h2 class="font-heading text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
                Verifikasi Sertifikat
            </h2>
            <p class="mt-2 text-slate-600 text-xs sm:text-sm">
                Periksa keabsahan sertifikat kompetensi dan kelulusan siswa berstandar BNSP secara online.
            </p>

            <!-- Quick Sample Pills -->
            <div class="mt-4 flex flex-wrap items-center justify-center gap-1.5 text-xs">
                <span class="text-slate-400 text-[11px]">Contoh ID:</span>
                <button onclick="lookupCertificate('CERT-LPK-2026-JP091')" class="px-2.5 py-1 rounded bg-white border border-slate-200 text-slate-700 hover:text-blue-600 font-mono text-[11px] transition">
                    CERT-LPK-2026-JP091
                </button>
                <button onclick="lookupCertificate('CERT-LPK-2026-KR044')" class="px-2.5 py-1 rounded bg-white border border-slate-200 text-slate-700 hover:text-blue-600 font-mono text-[11px] transition">
                    CERT-LPK-2026-KR044
                </button>
                <button onclick="lookupCertificate('CERT-LPK-2026-WL019')" class="px-2.5 py-1 rounded bg-white border border-slate-200 text-slate-700 hover:text-blue-600 font-mono text-[11px] transition">
                    CERT-LPK-2026-WL019
                </button>
            </div>
        </div>

        <!-- Search Input Bar -->
        <div class="max-w-lg mx-auto mb-8">
            <div class="flex gap-2 bg-white p-1.5 rounded-2xl border border-slate-200 shadow-xs">
                <input type="text" id="inputCertId" placeholder="Masukkan nomor sertifikat..." class="flex-1 px-3 py-2 text-xs sm:text-sm font-mono text-slate-900 outline-none">
                <button onclick="verifyCertificateManual()" class="px-4 py-2 bg-slate-900 hover:bg-slate-800 text-white font-semibold text-xs rounded-xl transition">
                    Periksa
                </button>
            </div>
        </div>

        <!-- Certificate Card Display -->
        <div id="certificateResultDisplay" class="bg-white rounded-2xl border border-slate-200 p-6 sm:p-8 shadow-sm">
            
            <div class="flex items-center justify-between border-b border-slate-100 pb-4 mb-5">
                <div>
                    <span class="text-blue-600 text-[10px] font-bold uppercase tracking-wider block font-mono">E-Sertifikat Resmi</span>
                    <h3 class="font-heading font-bold text-slate-900 text-base sm:text-lg mt-0.5">{{ $brandName }}</h3>
                </div>
                <span id="certCardStatusBadge" class="px-2.5 py-1 rounded bg-emerald-50 text-emerald-700 font-bold text-[10px] border border-emerald-200">
                    TERVERIFIKASI
                </span>
            </div>

            <div class="text-center py-4 space-y-2">
                <span class="text-[11px] text-slate-400 uppercase">Diberikan Kepada:</span>
                <h4 id="certStudentName" class="font-heading font-extrabold text-2xl text-slate-900 text-slate-900">
                    Bayu Pratama Wijaya
                </h4>
                <p class="text-xs text-slate-500 max-w-md mx-auto pt-1">
                    Dinyatakan kompeten pada program:
                </p>
                <div class="inline-block px-3 py-1.5 rounded-lg bg-slate-100 font-semibold text-slate-900 text-xs sm:text-sm">
                    <span id="certProgramName">Tokutei Ginou SSW - Manufaktur & Bahasa Jepang</span>
                </div>
            </div>

            <!-- Meta Grid -->
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-2.5 bg-slate-50 rounded-xl p-3 border border-slate-100 text-xs my-5">
                <div>
                    <span class="text-slate-400 text-[10px] block">No. Sertifikat</span>
                    <span id="certNumber" class="font-mono font-bold text-slate-800 text-[11px]">CERT-LPK-2026-JP091</span>
                </div>
                <div>
                    <span class="text-slate-400 text-[10px] block">Nilai</span>
                    <span id="certGrade" class="font-bold text-emerald-600 text-[11px]">Sangat Baik (A / 94.5)</span>
                </div>
                <div>
                    <span class="text-slate-400 text-[10px] block">Reg. BNSP</span>
                    <span id="certBnsp" class="font-mono font-bold text-slate-800 text-[11px]">BNSP-REG-882910</span>
                </div>
                <div>
                    <span class="text-slate-400 text-[10px] block">Tanggal</span>
                    <span id="certDate" class="font-semibold text-slate-800 text-[11px]">15 Agustus 2026</span>
                </div>
            </div>

            <!-- Placement Info -->
            <div class="p-3 bg-emerald-50/60 rounded-xl border border-emerald-100 text-xs flex items-center gap-2">
                <span class="text-emerald-700 font-semibold">Status Penempatan:</span>
                <span id="certPlacement" class="text-emerald-900">Toyota Tsusho Co., Nagoya, Jepang</span>
            </div>

        </div>

    </div>
</section>
