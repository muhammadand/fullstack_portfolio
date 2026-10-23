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

        {{-- ── Cetak Actions ── --}}
        <div class="glass-panel p-4 rounded-3xl space-y-2.5">
            <h3 class="text-xs font-bold text-slate-300 uppercase tracking-wider mb-2 font-outfit flex items-center gap-1.5">
                <i class="fa-solid fa-print text-blue-400"></i>
                Cetak Desain
                (<span x-text="selectedTemplate === 'square_nfc' ? 'Square Card' : 'Standee Portrait'"></span>)
            </h3>

            {{-- Print via Browser (Langsung cetak ke printer atau Simpan PDF) --}}
            <button type="button" @click="window.print()" class="group w-full py-3.5 px-4 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-500 hover:to-indigo-500 text-white font-semibold rounded-2xl text-xs transition-all shadow-lg shadow-blue-500/25 flex items-center justify-between cursor-pointer">
                <div class="flex items-center gap-2.5">
                    <i class="fa-solid fa-print text-base"></i>
                    <span>Cetak Desain / Simpan PDF (Ctrl / Cmd + P)</span>
                </div>
                <i class="fa-solid fa-arrow-right group-hover:translate-x-1 transition-transform"></i>
            </button>
        </div>

        <p class="text-center text-[11px] text-slate-500 mt-4 leading-relaxed">
            💡 Serahkan file gambar/PDF ini ke percetakan terdekat untuk dicetak di stiker vinyl, kartu akrilik, kartu PVC NFC, atau standee meja.
        </p>

    </div>

    {{-- TIDAK ADA <script> logic di sini. Semua ada di /js/review-card-designer.js --}}

</body>
</html>
