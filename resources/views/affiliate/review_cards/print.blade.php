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
    <link href="https://fonts.cdnfonts.com/css/product-sans" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <!-- CDN Dependencies: QRCode.js, html2canvas, jsPDF, and FileSaver.js (Guarantees proper filenames and extensions) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/file-saver@2.0.5/dist/FileSaver.min.js"></script>
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

        @media print {

            html,
            body {
                background: #ffffff !important;
                margin: 0 !important;
                padding: 0 !important;
                width: 100% !important;
                height: 100% !important;
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
                break-inside: avoid !important;
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
                <!-- Option 1: Square Google Card (Sesuai Foto - Scan QR) -->
                <button type="button" @click="selectedTemplate = 'square_nfc'" :class="selectedTemplate === 'square_nfc' ? 'bg-gradient-to-r from-blue-600 to-indigo-600 text-white shadow-md shadow-blue-500/20 border-transparent' : 'text-slate-400 hover:text-white hover:bg-white/5 border-white/5'" class="p-2.5 rounded-xl border transition-all text-left flex items-start gap-2.5 cursor-pointer">
                    <div class="w-8 h-8 rounded-lg flex items-center justify-center shrink-0" :class="selectedTemplate === 'square_nfc' ? 'bg-white/20 text-white' : 'bg-slate-800 text-slate-400'">
                        <i class="fa-solid fa-qrcode text-xs"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center gap-1.5">
                            <span class="text-xs font-bold font-outfit truncate">Square Card</span>
                            <span class="text-[9px] px-1.5 py-0.2 rounded bg-amber-500/20 text-amber-300 font-semibold shrink-0">Sesuai Foto</span>
                        </div>
                        <p class="text-[10px] opacity-80 leading-snug truncate">Desain Kotak Google (QR)</p>
                    </div>
                </button>

                <!-- Option 2: Standee Meja Portrait -->
                <button type="button" @click="selectedTemplate = 'portrait_standee'" :class="selectedTemplate === 'portrait_standee' ? 'bg-gradient-to-r from-blue-600 to-indigo-600 text-white shadow-md shadow-blue-500/20 border-transparent' : 'text-slate-400 hover:text-white hover:bg-white/5 border-white/5'" class="p-2.5 rounded-xl border transition-all text-left flex items-start gap-2.5 cursor-pointer">
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
        <div class="flex justify-center mb-6 min-h-[390px]">
            <!-- Template 1: Square NFC Tap & QR (Partial) -->
            <div x-show="selectedTemplate === 'square_nfc'" :class="{ 'printable-active': selectedTemplate === 'square_nfc' }">
                @include('affiliate.review_cards.partials.template_square_nfc')
            </div>

            <!-- Template 2: Standee Portrait (Partial) -->
            <div x-show="selectedTemplate === 'portrait_standee'" :class="{ 'printable-active': selectedTemplate === 'portrait_standee' }">
                @include('affiliate.review_cards.partials.template_portrait_standee')
            </div>
        </div>

        <!-- Download & Print Actions Panel -->
        <div class="glass-panel p-4 rounded-3xl space-y-2.5">
            <h3 class="text-xs font-bold text-slate-300 uppercase tracking-wider mb-2 font-outfit flex items-center gap-1.5">
                <i class="fa-solid fa-download text-blue-400"></i>
                Download Format Cetak (<span x-text="selectedTemplate === 'square_nfc' ? 'Square Card' : 'Standee Portrait'"></span>)
            </h3>

            <!-- Status Feedback Banner -->
            <div x-show="statusMessage" x-transition class="p-2.5 rounded-xl bg-blue-500/20 border border-blue-400/30 flex items-center gap-2 text-xs text-blue-200 font-medium">
                <i class="fa-solid" :class="isGenerating ? 'fa-spinner fa-spin text-blue-400' : 'fa-circle-check text-emerald-400'"></i>
                <span x-text="statusMessage"></span>
            </div>

            <!-- Download PNG (Ultra-Crisp 450 DPI, Zero Clipping) -->
            <button type="button" @click="downloadPNG()" :disabled="isGenerating" class="w-full py-3 px-4 bg-gradient-to-r from-blue-600 to-blue-500 hover:from-blue-500 hover:to-blue-600 text-white font-semibold rounded-2xl text-xs transition-all shadow-lg shadow-blue-500/25 flex items-center justify-between group disabled:opacity-60 cursor-pointer">
                <div class="flex items-center gap-2.5">
                    <i class="fa-solid fa-file-image text-sm"></i>
                    <span>Download Gambar (PNG Siap Cetak)</span>
                </div>
                <i class="fa-solid" :class="isGenerating && generatingType === 'png' ? 'fa-spin fa-circle-notch' : 'fa-arrow-down group-hover:translate-y-0.5 transition-transform'"></i>
            </button>

            <!-- Download PDF (Precision Print Dimensions) -->
            <button type="button" @click="downloadPDF()" :disabled="isGenerating" class="w-full py-3 px-4 bg-slate-800 hover:bg-slate-700 text-white font-semibold rounded-2xl text-xs transition-all flex items-center justify-between border border-slate-700 disabled:opacity-60 cursor-pointer">
                <div class="flex items-center gap-2.5">
                    <i class="fa-solid fa-file-pdf text-red-400 text-sm"></i>
                    <span>Download Dokumen PDF (Vektor Cetak)</span>
                </div>
                <i class="fa-solid" :class="isGenerating && generatingType === 'pdf' ? 'fa-spin fa-circle-notch' : 'fa-arrow-down group-hover:translate-y-0.5 transition-transform'"></i>
            </button>

            <!-- Direct Print via Browser -->
            <button type="button" @click="window.print()" :disabled="isGenerating" class="w-full py-2.5 px-4 bg-transparent hover:bg-white/5 text-slate-300 hover:text-white font-medium rounded-2xl text-xs transition-all flex items-center justify-center gap-2 border border-slate-700/60 cursor-pointer">
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
                , generatingType: ''
                , statusMessage: ''
                , selectedTemplate: 'square_nfc'
                , scanUrl: @json(url('/r/' . $card->slug))
                , serialNumber: '{{ $card->serial_number }}',

                init() {
                    this.renderQRCodes();
                },

                renderQRCodes() {
                    const containers = [
                        document.getElementById('localQrSquare')
                        , document.getElementById('localQrPortrait')
                    ];

                    containers.forEach(container => {
                        if (!container) return;
                        container.innerHTML = '';
                        new QRCode(container, {
                            text: this.scanUrl
                            , width: 600
                            , height: 600
                            , colorDark: '#000000'
                            , colorLight: '#ffffff'
                            , correctLevel: QRCode.CorrectLevel.H
                        });

                        setTimeout(() => {
                            const qrImg = container.querySelector('img') || container.querySelector('canvas');
                            if (qrImg) {
                                qrImg.style.width = '100%';
                                qrImg.style.height = '100%';
                                qrImg.style.objectFit = 'contain';
                                qrImg.style.display = 'block';
                            }
                        }, 50);
                    });
                },

                getActiveCardElement() {
                    return this.selectedTemplate === 'square_nfc' ?
                        document.getElementById('cardSquareNfc') :
                        document.getElementById('cardPortraitStandee');
                },

                async captureCardCanvas(element) {
                    // Clone the element into an isolated offscreen container (at 0,0, no transforms, no scroll offset)
                    // This 100% eliminates cropping, clipping, and scroll displacement bugs!
                    const clone = element.cloneNode(true);
                    clone.style.position = 'fixed';
                    clone.style.left = '0';
                    clone.style.top = '0';
                    clone.style.zIndex = '-99999';
                    clone.style.transform = 'none';
                    clone.style.margin = '0';
                    clone.style.boxShadow = 'none';
                    clone.style.visibility = 'visible';
                    clone.style.opacity = '1';
                    document.body.appendChild(clone);

                    // Allow browser to render layout of cloned element
                    await new Promise(r => setTimeout(r, 60));

                    try {
                        const width = element.offsetWidth;
                        const height = element.offsetHeight;

                        const canvas = await html2canvas(clone, {
                            scale: 4, // 450 DPI Ultra Crisp
                            useCORS: true
                            , allowTaint: false
                            , backgroundColor: null
                            , scrollX: 0
                            , scrollY: 0
                            , x: 0
                            , y: 0
                            , width: width
                            , height: height
                            , logging: false
                        });

                        return canvas;
                    } finally {
                        document.body.removeChild(clone);
                    }
                },

                async downloadPNG() {
                    this.isGenerating = true;
                    this.generatingType = 'png';
                    this.statusMessage = 'Menyiapkan gambar PNG resolusi tinggi...';
                    const element = this.getActiveCardElement();

                    if (!element) {
                        alert('Elemen desain tidak ditemukan.');
                        this.isGenerating = false;
                        return;
                    }

                    try {
                        const canvas = await this.captureCardCanvas(element);
                        const suffix = this.selectedTemplate === 'square_nfc' ? 'Square-Google' : 'Standee-Portrait';
                        const filename = `Google-Review-${suffix}-${this.serialNumber}-HD.png`;

                        // Direct DataURL guarantees Chrome and Arc never assign random UUIDs and preserves the .png extension
                        const dataUrl = canvas.toDataURL('image/png', 1.0);
                        const link = document.createElement('a');
                        link.download = filename;
                        link.href = dataUrl;
                        document.body.appendChild(link);
                        link.click();

                        setTimeout(() => {
                            if (document.body.contains(link)) {
                                document.body.removeChild(link);
                            }
                        }, 500);

                        this.statusMessage = 'PNG berhasil di-download!';
                        setTimeout(() => {
                            this.statusMessage = '';
                        }, 3000);
                    } catch (error) {
                        console.error('Error PNG:', error);
                        alert('Gagal mendownload kartu: ' + (error.message || 'Silakan coba lagi.'));
                    } finally {
                        this.isGenerating = false;
                        this.generatingType = '';
                    }
                },

                async downloadPDF() {
                    this.isGenerating = true;
                    this.generatingType = 'pdf';
                    this.statusMessage = 'Menyusun dokumen PDF siap cetak...';
                    const element = this.getActiveCardElement();

                    if (!element) {
                        alert('Elemen desain tidak ditemukan.');
                        this.isGenerating = false;
                        return;
                    }

                    try {
                        const canvas = await this.captureCardCanvas(element);
                        const imgData = canvas.toDataURL('image/png', 1.0);
                        const suffix = this.selectedTemplate === 'square_nfc' ? 'Square-Google' : 'Standee-Portrait';
                        const isSquare = this.selectedTemplate === 'square_nfc';
                        const filename = `Google-Review-${suffix}-${this.serialNumber}-PrintReady.pdf`;

                        const {
                            jsPDF
                        } = window.jspdf;
                        const pdfWidth = isSquare ? 110 : 100;
                        const pdfHeight = isSquare ? 130 : 150;

                        const pdf = new jsPDF({
                            orientation: 'portrait'
                            , unit: 'mm'
                            , format: [pdfWidth, pdfHeight]
                        });

                        pdf.addImage(imgData, 'PNG', 0, 0, pdfWidth, pdfHeight, undefined, 'FAST');

                        const pdfBlob = pdf.output('blob');
                        if (typeof saveAs !== 'undefined') {
                            saveAs(pdfBlob, filename);
                        } else {
                            pdf.save(filename);
                        }

                        this.statusMessage = 'PDF berhasil di-download!';
                        setTimeout(() => {
                            this.statusMessage = '';
                        }, 3000);
                    } catch (err) {
                        console.error('Error PDF:', err);
                        alert('Gagal membuat PDF: ' + (err.message || 'Silakan coba lagi.'));
                    } finally {
                        this.isGenerating = false;
                        this.generatingType = '';
                    }
                }
            }
        }

    </script>

</body>
</html>
