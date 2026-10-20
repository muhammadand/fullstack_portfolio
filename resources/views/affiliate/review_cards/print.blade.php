<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Cetak Desain Review Card - {{ $card->serial_number }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@500;600;700&display=swap" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <!-- CDN html2canvas & html2pdf untuk ekspor cetak 300 DPI -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
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

        .glass-panel {
            background: rgba(255, 255, 255, 0.04);
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
            border: 1px solid rgba(255, 255, 255, 0.08);
        }

        @media print {
            body * {
                visibility: hidden !important;
            }

            .printable-active,
            .printable-active * {
                visibility: visible !important;
            }

            .printable-active {
                position: fixed !important;
                left: 50% !important;
                top: 50% !important;
                transform: translate(-50%, -50%) !important;
                box-shadow: none !important;
                border: 1px solid #ccc !important;
                margin: 0 !important;
            }

            @page {
                size: auto;
                margin: 0;
            }
        }

    </style>
</head>
<body class="pb-20 min-h-screen flex flex-col justify-between p-4" x-data="partnerCardDesigner()">

    <div class="max-w-md w-full mx-auto">

        <!-- Top Header Navigation -->
        <div class="flex items-center justify-between gap-3 mb-4">
            <a href="{{ route('affiliate.review_cards.index') }}" class="w-10 h-10 rounded-2xl glass-panel flex items-center justify-center text-slate-300 hover:text-white transition-colors active:scale-95">
                <i class="fa-solid fa-arrow-left text-sm"></i>
            </a>
            <div class="text-center flex-1">
                <h1 class="text-base font-bold text-white font-outfit leading-tight">Desain Siap Cetak</h1>
                <p class="text-[11px] text-blue-400 font-mono">{{ $card->serial_number }}</p>
            </div>
            <div class="w-10"></div> <!-- Placeholder spacer -->
        </div>

        <!-- Template Selector Tab -->
        <div class="glass-panel p-1.5 rounded-2xl mb-5">
            <div class="text-[11px] font-semibold text-slate-400 px-2 py-1 mb-1 flex items-center justify-between">
                <span>Pilih Gaya Template:</span>
                <span class="text-[10px] text-blue-400 font-normal">2 Pilihan Desain</span>
            </div>
            <div class="grid grid-cols-2 gap-1.5">
                <!-- Option 1: Square NFC Tap & QR -->
                <button type="button" @click="selectedTemplate = 'square_nfc'" :class="selectedTemplate === 'square_nfc' ? 'bg-gradient-to-r from-blue-600 to-indigo-600 text-white shadow-md shadow-blue-500/20 border-transparent' : 'text-slate-400 hover:text-white hover:bg-white/5 border-white/5'" class="p-2.5 rounded-xl border transition-all text-left flex items-start gap-2.5">
                    <div class="w-8 h-8 rounded-lg flex items-center justify-center shrink-0" :class="selectedTemplate === 'square_nfc' ? 'bg-white/20 text-white' : 'bg-slate-800 text-slate-400'">
                        <i class="fa-solid fa-wifi text-xs rotate-90"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center gap-1.5">
                            <span class="text-xs font-bold font-outfit truncate">Square NFC</span>
                            <span class="text-[9px] px-1.5 py-0.2 rounded bg-amber-500/20 text-amber-300 font-semibold shrink-0">Hot</span>
                        </div>
                        <p class="text-[10px] opacity-80 leading-snug truncate">Tempel NFC + Scan QR</p>
                    </div>
                </button>

                <!-- Option 2: Standee Meja Portrait -->
                <button type="button" @click="selectedTemplate = 'portrait_standee'" :class="selectedTemplate === 'portrait_standee' ? 'bg-gradient-to-r from-blue-600 to-indigo-600 text-white shadow-md shadow-blue-500/20 border-transparent' : 'text-slate-400 hover:text-white hover:bg-white/5 border-white/5'" class="p-2.5 rounded-xl border transition-all text-left flex items-start gap-2.5">
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

        <!-- The Physical Card Canvas Container -->
        <div class="flex justify-center mb-6 min-h-[380px]">
            <!-- Template 1: Square NFC Tap & QR (Partial) -->
            <div x-show="selectedTemplate === 'square_nfc'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" :class="{ 'printable-active': selectedTemplate === 'square_nfc' }">
                @include('affiliate.review_cards.partials.template_square_nfc')
            </div>

            <!-- Template 2: Standee Portrait (Partial) -->
            <div x-show="selectedTemplate === 'portrait_standee'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" :class="{ 'printable-active': selectedTemplate === 'portrait_standee' }">
                @include('affiliate.review_cards.partials.template_portrait_standee')
            </div>
        </div>

        <!-- Download & Print Actions Panel -->
        <div class="glass-panel p-4 rounded-3xl space-y-2.5">
            <h3 class="text-xs font-bold text-slate-300 uppercase tracking-wider mb-2 font-outfit flex items-center gap-1.5">
                <i class="fa-solid fa-download text-blue-400"></i>
                Download Format Cetak (<span x-text="selectedTemplate === 'square_nfc' ? 'Square NFC' : 'Standee Portrait'"></span>)
            </h3>

            <!-- Download PNG -->
            <button type="button" @click="downloadPNG()" :disabled="isGenerating" class="w-full py-3 px-4 bg-gradient-to-r from-blue-600 to-blue-500 hover:from-blue-500 hover:to-blue-600 text-white font-semibold rounded-2xl text-xs transition-all shadow-lg shadow-blue-500/25 flex items-center justify-between group disabled:opacity-60">
                <div class="flex items-center gap-2.5">
                    <i class="fa-solid fa-file-image text-sm"></i>
                    <span>Download Gambar (PNG 300 DPI)</span>
                </div>
                <i class="fa-solid fa-arrow-down" :class="isGenerating ? 'fa-spin fa-circle-notch' : 'fa-arrow-down'"></i>
            </button>

            <!-- Download PDF -->
            <button type="button" @click="downloadPDF()" :disabled="isGenerating" class="w-full py-3 px-4 bg-slate-800 hover:bg-slate-700 text-white font-semibold rounded-2xl text-xs transition-all flex items-center justify-between border border-slate-700 disabled:opacity-60">
                <div class="flex items-center gap-2.5">
                    <i class="fa-solid fa-file-pdf text-red-400 text-sm"></i>
                    <span>Download Dokumen PDF (Vektor Cetak)</span>
                </div>
                <i class="fa-solid fa-arrow-down" :class="isGenerating ? 'fa-spin fa-circle-notch' : 'fa-arrow-down'"></i>
            </button>

            <!-- Direct Print via Browser -->
            <button type="button" @click="window.print()" :disabled="isGenerating" class="w-full py-2.5 px-4 bg-transparent hover:bg-white/5 text-slate-300 hover:text-white font-medium rounded-2xl text-xs transition-all flex items-center justify-center gap-2 border border-slate-700/60">
                <i class="fa-solid fa-print text-slate-400 text-xs"></i>
                <span>Cetak Langsung via Browser (Ctrl / Cmd + P)</span>
            </button>
        </div>

        <p class="text-center text-[11px] text-slate-500 mt-4 leading-relaxed">
            💡 Serahkan file gambar/PDF ini ke percetakan terdekat untuk dicetak di stiker vinyl, kartu akrilik, kartu PVC NFC, atau standee meja.
        </p>

    </div>

    <script>
        function partnerCardDesigner() {
            return {
                isGenerating: false
                , selectedTemplate: 'square_nfc', // default template baru dari foto

                getActiveCardElement() {
                    return this.selectedTemplate === 'square_nfc' ?
                        document.getElementById('cardSquareNfc') :
                        document.getElementById('cardPortraitStandee');
                },

                async downloadPNG() {
                    this.isGenerating = true;
                    const element = this.getActiveCardElement();

                    if (!element) {
                        alert('Elemen desain tidak ditemukan.');
                        this.isGenerating = false;
                        return;
                    }

                    try {
                        const canvas = await html2canvas(element, {
                            scale: 3
                            , useCORS: true
                            , allowTaint: false
                            , backgroundColor: null
                        });

                        const suffix = this.selectedTemplate === 'square_nfc' ? 'Square-NFC' : 'Standee-Portrait';
                        const link = document.createElement('a');
                        link.download = `Google-Review-${suffix}-{{ $card->serial_number }}.png`;
                        link.href = canvas.toDataURL('image/png');
                        link.click();
                    } catch (error) {
                        console.error(error);
                        alert('Gagal membuat file PNG. Silakan coba opsi Cetak Langsung via Browser.');
                    } finally {
                        this.isGenerating = false;
                    }
                },

                async downloadPDF() {
                    this.isGenerating = true;
                    const element = this.getActiveCardElement();

                    if (!element) {
                        alert('Elemen desain tidak ditemukan.');
                        this.isGenerating = false;
                        return;
                    }

                    const suffix = this.selectedTemplate === 'square_nfc' ? 'Square-NFC' : 'Standee-Portrait';
                    const isSquare = this.selectedTemplate === 'square_nfc';

                    const opt = {
                        margin: [8, 8, 8, 8]
                        , filename: `Google-Review-${suffix}-{{ $card->serial_number }}.pdf`
                        , image: {
                            type: 'jpeg'
                            , quality: 0.98
                        }
                        , html2canvas: {
                            scale: 3
                            , useCORS: true
                        }
                        , jsPDF: {
                            unit: 'mm'
                            , format: isSquare ? [110, 125] : 'a6'
                            , orientation: 'portrait'
                        }
                    };

                    try {
                        await html2pdf().set(opt).from(element).save();
                    } catch (err) {
                        console.error(err);
                        window.print();
                    } finally {
                        this.isGenerating = false;
                    }
                }
            }
        }

    </script>

</body>
</html>
