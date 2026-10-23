<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Cetak Desain Review Card - {{ $card->serial_number }}</title>

    {{-- Styles --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.cdnfonts.com/css/product-sans" rel="stylesheet">

    {{-- Alpine.js --}}
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    {{-- Libraries: QR, html2canvas, jsPDF --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

    {{-- Our JS — file terpisah, 100% murni JS, auto-formatter aman --}}
    <script src="{{ asset('js/review-card-designer.js') }}"></script>

    <style>
        body {
            background-color: #0B1120;
            color: #ffffff;
            font-family: 'Plus Jakarta Sans', sans-serif;
            -webkit-tap-highlight-color: transparent;
        }

        .font-outfit {
            font-family: 'Outfit', sans-serif;
        }

        .font-google {
            font-family: 'Product Sans', 'Plus Jakarta Sans', sans-serif;
        }

        .glass-panel {
            background: rgba(255, 255, 255, 0.04);
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
            border: 1px solid rgba(255, 255, 255, 0.08);
        }

        /* Print: hanya tampilkan kartu aktif, centered di A4 */
        @media print {

            html,
            body {
                background: #ffffff !important;
                margin: 0 !important;
                padding: 0 !important;
                width: 100% !important;
                overflow: visible !important;
            }

            body * {
                visibility: hidden !important;
            }

            .printable-active,
            .printable-active * {
                visibility: visible !important;
            }

            .printable-active {
                position: absolute !important;
                left: 0 !important;
                top: 0 !important;
                width: 100% !important;
                display: flex !important;
                justify-content: center !important;
                align-items: center !important;
                padding-top: 15mm !important;
                margin: 0 auto !important;
                transform: none !important;
            }

            #cardSquareNfc,
            #cardPortraitStandee {
                box-shadow: none !important;
                page-break-inside: avoid !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }

            @page {
                size: A4 portrait;
                margin: 10mm;
            }
        }

    </style>
</head>

<body class="pb-20 min-h-screen flex flex-col justify-between p-4" x-data="partnerCardDesigner()">

    {{-- ╔══════════════════════════════════════════════════════════╗
         ║  HIDDEN CONFIG — Semua data PHP/Blade ada di sini saja  ║
         ║  JavaScript membaca via dataset, tidak ada PHP di JS    ║
         ╚══════════════════════════════════════════════════════════╝ --}}
    <div id="cardConfig" data-serial="{{ $card->serial_number }}" data-scan-url="{{ url('/r/' . $card->slug) }}" data-export-url="{{ route('affiliate.review_cards.download_export') }}" data-csrf="{{ csrf_token() }}" style="display:none;"></div>

    <div class="max-w-md w-full mx-auto">

        {{-- ── Header Navigation ── --}}
        <div class="flex items-center justify-between gap-3 mb-4">
            <a href="{{ route('affiliate.review_cards.index') }}" class="w-10 h-10 rounded-2xl glass-panel flex items-center justify-center text-slate-300 hover:text-white transition-colors active:scale-95">
                <i class="fa-solid fa-arrow-left text-sm"></i>
            </a>
            <div class="text-center flex-1">
                <h1 class="text-base font-bold text-white font-outfit leading-tight">Desain Siap Cetak</h1>
                <p class="text-[11px] text-blue-400 font-mono">{{ $card->serial_number }}</p>
            </div>
            <div class="w-10"></div>
        </div>

        {{-- ── Template Selector ── --}}
        <div class="glass-panel p-1.5 rounded-2xl mb-5">
            <div class="text-[11px] font-semibold text-slate-400 px-2 py-1 mb-1 flex items-center justify-between">
                <span>Pilih Gaya Template:</span>
                <span class="text-[10px] text-blue-400 font-normal">2 Pilihan Desain</span>
            </div>
            <div class="grid grid-cols-2 gap-1.5">
                {{-- Square Card --}}
                <button type="button" @click="setTemplate('square_nfc')" :disabled="isGenerating" :class="selectedTemplate === 'square_nfc'
                        ? 'bg-gradient-to-r from-blue-600 to-indigo-600 text-white shadow-md shadow-blue-500/20 border-transparent'
                        : 'text-slate-400 hover:text-white hover:bg-white/5 border-white/5'" class="p-2.5 rounded-xl border transition-all text-left flex items-start gap-2.5 cursor-pointer disabled:cursor-not-allowed">
                    <div class="w-8 h-8 rounded-lg flex items-center justify-center shrink-0" :class="selectedTemplate === 'square_nfc' ? 'bg-white/20 text-white' : 'bg-slate-800 text-slate-400'">
                        <i class="fa-solid fa-qrcode text-xs"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center gap-1.5">
                            <span class="text-xs font-bold font-outfit truncate">Square Card</span>
                            <span class="text-[9px] px-1.5 py-0.5 rounded bg-amber-500/20 text-amber-300 font-semibold shrink-0">Sesuai Foto</span>
                        </div>
                        <p class="text-[10px] opacity-80 leading-snug truncate">Desain Kotak Google (QR)</p>
                    </div>
                </button>

                {{-- Standee Portrait --}}
                <button type="button" @click="setTemplate('portrait_standee')" :disabled="isGenerating" :class="selectedTemplate === 'portrait_standee'
                        ? 'bg-gradient-to-r from-blue-600 to-indigo-600 text-white shadow-md shadow-blue-500/20 border-transparent'
                        : 'text-slate-400 hover:text-white hover:bg-white/5 border-white/5'" class="p-2.5 rounded-xl border transition-all text-left flex items-start gap-2.5 cursor-pointer disabled:cursor-not-allowed">
                    <div class="w-8 h-8 rounded-lg flex items-center justify-center shrink-0" :class="selectedTemplate === 'portrait_standee' ? 'bg-white/20 text-white' : 'bg-slate-800 text-slate-400'">
                        <i class="fa-solid fa-id-card text-xs"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <span class="text-xs font-bold font-outfit truncate block">Standee Portrait</span>
                        <p class="text-[10px] opacity-80 leading-snug truncate">Meja / Akrilik Berdiri</p>
                    </div>
                </button>
            </div>
        </div>

        {{-- ── Card Preview ── --}}
        <div class="flex justify-center mb-6 min-h-[390px]">
            <div x-show="selectedTemplate === 'square_nfc'" :class="{ 'printable-active': selectedTemplate === 'square_nfc' }">
                @include('affiliate.review_cards.partials.template_square_nfc')
            </div>
            <div x-show="selectedTemplate === 'portrait_standee'" :class="{ 'printable-active': selectedTemplate === 'portrait_standee' }">
                @include('affiliate.review_cards.partials.template_portrait_standee')
            </div>
        </div>

        {{-- ── Download & Cetak Actions ── --}}
        <div class="glass-panel p-4 rounded-3xl space-y-2.5">
            <h3 class="text-xs font-bold text-slate-300 uppercase tracking-wider mb-2 font-outfit flex items-center justify-between">
                <span class="flex items-center gap-1.5">
                    <i class="fa-solid fa-cloud-arrow-down text-blue-400"></i>
                    Download & Cetak
                </span>
                <span class="text-[10px] text-slate-400 font-normal">
                    Format: <span class="text-blue-400 font-semibold" x-text="selectedTemplate === 'square_nfc' ? 'Square (110mm)' : 'Standee (100mm)'"></span>
                </span>
            </h3>

            {{-- Deteksi In-App Browser (WhatsApp / Instagram / Line) --}}
            <div x-show="isInAppBrowser()" x-cloak class="p-3 rounded-2xl bg-amber-500/15 border border-amber-500/30 text-amber-200 text-[11px] flex items-start gap-2.5">
                <i class="fa-solid fa-circle-exclamation text-amber-400 mt-0.5 text-sm shrink-0"></i>
                <div class="leading-relaxed">
                    <span class="font-bold text-amber-300">Tips Membuka dari WhatsApp/Instagram:</span><br>
                    Jika file tidak tersimpan otomatis, ketuk ikon <span class="font-bold text-white">titik tiga (⋮)</span> di pojok atas lalu pilih <span class="font-bold text-white underline">"Buka di Browser / Chrome / Safari"</span> agar file langsung masuk ke memori HP.
                </div>
            </div>

            {{-- Status Banner (Animasi Loading / Pesan Sukses / Error) --}}
            <div x-show="statusMessage" x-transition x-cloak :class="statusType === 'error'
                    ? 'bg-red-500/15 border-red-400/30 text-red-200'
                    : 'bg-blue-500/20 border-blue-400/30 text-blue-200'" class="p-2.5 rounded-xl border flex items-center gap-2.5 text-xs font-medium">
                <i class="fa-solid text-sm shrink-0" :class="isGenerating
                        ? 'fa-spinner fa-spin text-blue-400'
                        : (statusType === 'error' ? 'fa-circle-xmark text-red-400' : 'fa-circle-check text-emerald-400')"></i>
                <span x-text="statusMessage" class="leading-tight"></span>
            </div>

            {{-- 1. Tombol Download Dokumen PDF (Siap Cetak) --}}
            <button type="button" @click="downloadPDF()" :disabled="isGenerating" class="group w-full py-3.5 px-4 bg-gradient-to-r from-red-600 via-rose-600 to-red-500 hover:from-red-500 hover:to-rose-500 text-white font-semibold rounded-2xl text-xs transition-all shadow-lg shadow-red-500/25 flex items-center justify-between disabled:opacity-60 disabled:cursor-not-allowed cursor-pointer active:scale-[0.99]">
                <div class="flex items-center gap-3 text-left">
                    <div class="w-8 h-8 rounded-xl bg-white/20 flex items-center justify-center shrink-0">
                        <i class="fa-solid fa-file-pdf text-base text-white"></i>
                    </div>
                    <div>
                        <div class="font-bold font-outfit text-white text-[13px] leading-tight">Download Dokumen PDF (Siap Cetak)</div>
                        <div class="text-[10px] text-red-100/90 leading-tight mt-0.5">Ukuran pas sesuai template cetak (Vektor Tajam)</div>
                    </div>
                </div>
                <div class="shrink-0 ml-2">
                    <i class="fa-solid text-sm" :class="isGenerating && generatingType === 'pdf' ? 'fa-spin fa-circle-notch text-white' : 'fa-arrow-down group-hover:translate-y-0.5 transition-transform'"></i>
                </div>
            </button>

            {{-- 2. Tombol Download Gambar PNG HD --}}
            <button type="button" @click="downloadPNG()" :disabled="isGenerating" class="group w-full py-3 px-4 bg-slate-800 hover:bg-slate-700/90 text-white font-semibold rounded-2xl text-xs transition-all border border-slate-700/80 shadow-md flex items-center justify-between disabled:opacity-60 disabled:cursor-not-allowed cursor-pointer active:scale-[0.99]">
                <div class="flex items-center gap-3 text-left">
                    <div class="w-8 h-8 rounded-xl bg-emerald-500/20 text-emerald-400 flex items-center justify-center shrink-0">
                        <i class="fa-solid fa-file-image text-sm"></i>
                    </div>
                    <div>
                        <div class="font-bold font-outfit text-slate-100 text-[12px] leading-tight">Download Gambar PNG (Resolusi Tinggi)</div>
                        <div class="text-[10px] text-slate-400 leading-tight mt-0.5">Bisa langsung kirim via WhatsApp ke percetakan</div>
                    </div>
                </div>
                <div class="shrink-0 ml-2">
                    <i class="fa-solid text-sm text-slate-300" :class="isGenerating && generatingType === 'png' ? 'fa-spin fa-circle-notch text-blue-400' : 'fa-arrow-down group-hover:translate-y-0.5 transition-transform'"></i>
                </div>
            </button>

            {{-- 3. Tombol Download Hanya QR Code --}}
            <button type="button" @click="downloadQR()" :disabled="isGenerating" class="group w-full py-2.5 px-4 bg-slate-800/60 hover:bg-slate-700/60 text-slate-300 hover:text-white font-medium rounded-2xl text-xs transition-all border border-slate-700/50 flex items-center justify-between disabled:opacity-60 disabled:cursor-not-allowed cursor-pointer">
                <div class="flex items-center gap-2.5">
                    <i class="fa-solid fa-qrcode text-amber-400 text-sm"></i>
                    <span class="text-[11px]">Download Hanya QR Code (PNG Ultra-HD)</span>
                </div>
                <i class="fa-solid text-xs text-slate-400" :class="isGenerating && generatingType === 'qr' ? 'fa-spin fa-circle-notch text-amber-400' : 'fa-arrow-down'"></i>
            </button>

            {{-- 4. Print Langsung ke Printer Fisik / AirPrint --}}
            <button type="button" @click="window.print()" :disabled="isGenerating" class="w-full py-2 px-4 bg-transparent hover:bg-white/5 text-slate-400 hover:text-slate-200 font-medium rounded-2xl text-[11px] transition-all flex items-center justify-center gap-2 border border-slate-700/40 disabled:opacity-60 cursor-pointer">
                <i class="fa-solid fa-print text-slate-500 text-xs"></i>
                <span>Cetak Langsung via Printer Browser (Ctrl / Cmd + P)</span>
            </button>
        </div>

        {{-- Petunjuk Khusus Pengguna HP --}}
        <div class="glass-panel p-3.5 rounded-2xl mt-4 text-[11px] text-slate-400 space-y-1.5 leading-relaxed">
            <div class="font-bold text-slate-300 font-outfit flex items-center gap-1.5">
                <i class="fa-solid fa-mobile-screen text-blue-400"></i>
                Panduan Download di HP (iPhone & Android):
            </div>
            <ul class="space-y-1 list-disc list-inside text-slate-400 pl-1">
                <li><strong class="text-slate-300">iPhone:</strong> Saat menu bagikan muncul, pilih <span class="text-blue-300">"Simpan ke File" (Save to Files)</span> atau kirim langsung ke WhatsApp tukang cetak.</li>
                <li><strong class="text-slate-300">Android:</strong> File akan otomatis tersimpan di folder <span class="text-blue-300">"Download"</span> atau galeri HP Anda.</li>
                <li><strong class="text-slate-300">Kirim ke Percetakan:</strong> Anda cukup mengirimkan file PDF / PNG ini ke percetakan untuk dicetak pada kartu PVC, akrilik, stiker vinyl, atau standee meja.</li>
            </ul>
        </div>

    </div>

    {{-- TIDAK ADA <script> logic di sini. Semua ada di /js/review-card-designer.js --}}

</body>
</html>
