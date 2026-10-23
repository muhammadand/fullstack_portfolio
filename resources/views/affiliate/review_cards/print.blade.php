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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
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

    {{-- ============================================================
         HIDDEN CONFIG — all Blade/PHP values live HERE, never inside <script>.
         This prevents auto-formatters from ever breaking PHP syntax.
         ============================================================ --}}
    <div id="cardConfig" data-serial="{{ $card->serial_number }}" data-scan-url="{{ url('/r/' . $card->slug) }}" data-export-url="{{ route('affiliate.review_cards.download_export') }}" data-csrf="{{ csrf_token() }}" style="display:none;"></div>

    <div class="max-w-md w-full mx-auto">

        {{-- Top Header Navigation --}}
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

        {{-- Template Selector --}}
        <div class="glass-panel p-1.5 rounded-2xl mb-5">
            <div class="text-[11px] font-semibold text-slate-400 px-2 py-1 mb-1 flex items-center justify-between">
                <span>Pilih Gaya Template:</span>
                <span class="text-[10px] text-blue-400 font-normal">2 Pilihan Desain</span>
            </div>
            <div class="grid grid-cols-2 gap-1.5">
                <button type="button" @click="selectedTemplate = 'square_nfc'" :disabled="isGenerating" :class="selectedTemplate === 'square_nfc' ? 'bg-gradient-to-r from-blue-600 to-indigo-600 text-white shadow-md shadow-blue-500/20 border-transparent' : 'text-slate-400 hover:text-white hover:bg-white/5 border-white/5'" class="p-2.5 rounded-xl border transition-all text-left flex items-start gap-2.5 cursor-pointer disabled:cursor-not-allowed">
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
                <button type="button" @click="selectedTemplate = 'portrait_standee'" :disabled="isGenerating" :class="selectedTemplate === 'portrait_standee' ? 'bg-gradient-to-r from-blue-600 to-indigo-600 text-white shadow-md shadow-blue-500/20 border-transparent' : 'text-slate-400 hover:text-white hover:bg-white/5 border-white/5'" class="p-2.5 rounded-xl border transition-all text-left flex items-start gap-2.5 cursor-pointer disabled:cursor-not-allowed">
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

        {{-- Card Canvas --}}
        <div class="flex justify-center mb-6 min-h-[390px]">
            <div x-show="selectedTemplate === 'square_nfc'" :class="{ 'printable-active': selectedTemplate === 'square_nfc' }">
                @include('affiliate.review_cards.partials.template_square_nfc')
            </div>
            <div x-show="selectedTemplate === 'portrait_standee'" :class="{ 'printable-active': selectedTemplate === 'portrait_standee' }">
                @include('affiliate.review_cards.partials.template_portrait_standee')
            </div>
        </div>

        {{-- Download & Print Actions --}}
        <div class="glass-panel p-4 rounded-3xl space-y-2.5">
            <h3 class="text-xs font-bold text-slate-300 uppercase tracking-wider mb-2 font-outfit flex items-center gap-1.5">
                <i class="fa-solid fa-download text-blue-400"></i>
                Download Format Cetak (<span x-text="selectedTemplate === 'square_nfc' ? 'Square Card' : 'Standee Portrait'"></span>)
            </h3>

            {{-- Status Banner --}}
            <div x-show="statusMessage" x-transition x-cloak :class="statusType === 'error' ? 'bg-red-500/15 border-red-400/30 text-red-200' : 'bg-blue-500/20 border-blue-400/30 text-blue-200'" class="p-2.5 rounded-xl border flex items-center gap-2 text-xs font-medium">
                <i class="fa-solid" :class="isGenerating ? 'fa-spinner fa-spin text-blue-400' : (statusType === 'error' ? 'fa-circle-exclamation text-red-400' : 'fa-circle-check text-emerald-400')"></i>
                <span x-text="statusMessage"></span>
            </div>

            {{-- Download PNG --}}
            <button type="button" @click="downloadPNG()" :disabled="isGenerating" class="group w-full py-3 px-4 bg-gradient-to-r from-blue-600 to-blue-500 hover:from-blue-500 hover:to-blue-600 text-white font-semibold rounded-2xl text-xs transition-all shadow-lg shadow-blue-500/25 flex items-center justify-between disabled:opacity-60 disabled:cursor-not-allowed cursor-pointer">
                <div class="flex items-center gap-2.5">
                    <i class="fa-solid fa-file-image text-sm"></i>
                    <span>Download Gambar (PNG Siap Cetak)</span>
                </div>
                <i class="fa-solid" :class="isGenerating && generatingType === 'png' ? 'fa-spin fa-circle-notch' : 'fa-arrow-down group-hover:translate-y-0.5 transition-transform'"></i>
            </button>

            {{-- Download PDF --}}
            <button type="button" @click="downloadPDF()" :disabled="isGenerating" class="group w-full py-3 px-4 bg-slate-800 hover:bg-slate-700 text-white font-semibold rounded-2xl text-xs transition-all flex items-center justify-between border border-slate-700 disabled:opacity-60 disabled:cursor-not-allowed cursor-pointer">
                <div class="flex items-center gap-2.5">
                    <i class="fa-solid fa-file-pdf text-red-400 text-sm"></i>
                    <span>Download Dokumen PDF (Siap Cetak)</span>
                </div>
                <i class="fa-solid" :class="isGenerating && generatingType === 'pdf' ? 'fa-spin fa-circle-notch' : 'fa-arrow-down group-hover:translate-y-0.5 transition-transform'"></i>
            </button>

            {{-- Print via Browser --}}
            <button type="button" @click="window.print()" :disabled="isGenerating" class="w-full py-2.5 px-4 bg-transparent hover:bg-white/5 text-slate-300 hover:text-white font-medium rounded-2xl text-xs transition-all flex items-center justify-center gap-2 border border-slate-700/60 disabled:opacity-60 cursor-pointer">
                <i class="fa-solid fa-print text-slate-400 text-xs"></i>
                <span>Cetak Langsung via Browser (Ctrl / Cmd + P)</span>
            </button>
        </div>

        <p class="text-center text-[11px] text-slate-500 mt-4 leading-relaxed">
            💡 Serahkan file gambar/PDF ini ke percetakan terdekat untuk dicetak di stiker vinyl, kartu akrilik, kartu PVC NFC, atau standee meja.
        </p>

    </div>

    {{-- ============================================================
         SCRIPT — 100% pure JavaScript. ZERO Blade/PHP directives.
         All config read from #cardConfig data-* attributes above.
         Auto-formatter safe. Will never cause PHP ParseError.
         ============================================================ --}}
    <script>
        /* eslint-disable */
        // @formatter:off
        function partnerCardDesigner() {
            var cfg = document.getElementById('cardConfig');
            var d = cfg ? cfg.dataset : {};

            return {
                isGenerating: false
                , generatingType: ''
                , statusMessage: ''
                , statusType: 'info'
                , selectedTemplate: 'square_nfc'
                , scanUrl: d.scanUrl || ''
                , serialNumber: d.serial || ''
                , exportUrl: d.exportUrl || ''
                , csrfToken: d.csrf || ''
                , pdfWidthMm: {
                    square_nfc: 110
                    , portrait_standee: 100
                },

                init: function() {
                    this.renderQRCodes();
                },

                setStatus: function(message, type, clearAfterMs) {
                    type = type || 'info';
                    clearAfterMs = clearAfterMs || 0;
                    this.statusMessage = message;
                    this.statusType = type;
                    if (clearAfterMs > 0) {
                        var self = this;
                        setTimeout(function() {
                            self.statusMessage = '';
                        }, clearAfterMs);
                    }
                },

                get safeSerial() {
                    return String(this.serialNumber).replace(/[^a-zA-Z0-9_\-]+/g, '-');
                },

                get templateSuffix() {
                    return this.selectedTemplate === 'square_nfc' ? 'Square-Google' : 'Standee-Portrait';
                },

                renderQRCodes: function() {
                    var url = this.scanUrl;
                    var ids = ['localQrSquare', 'localQrPortrait'];
                    ids.forEach(function(id) {
                        var el = document.getElementById(id);
                        if (!el) return;
                        el.innerHTML = '';
                        new QRCode(el, {
                            text: url
                            , width: 600
                            , height: 600
                            , colorDark: '#000000'
                            , colorLight: '#ffffff'
                            , correctLevel: QRCode.CorrectLevel.H
                        });
                        setTimeout(function() {
                            var img = el.querySelector('img') || el.querySelector('canvas');
                            if (img) {
                                img.style.width = '100%';
                                img.style.height = '100%';
                                img.style.objectFit = 'contain';
                                img.style.display = 'block';
                            }
                        }, 80);
                    });
                },

                getActiveCardElement: function() {
                    return this.selectedTemplate === 'square_nfc' ?
                        document.getElementById('cardSquareNfc') :
                        document.getElementById('cardPortraitStandee');
                },

                captureCard: function(element, bg) {
                    var rect = element.getBoundingClientRect();
                    var w = Math.round(rect.width);
                    var h = Math.round(rect.height);
                    if (!w || !h) return Promise.reject(new Error('Ukuran kartu tidak terbaca.'));

                    var wrapper = document.createElement('div');
                    wrapper.style.cssText = 'position:fixed;left:0;top:0;width:' + w + 'px;height:' + h + 'px;z-index:-1;pointer-events:none;overflow:hidden';

                    var clone = element.cloneNode(true);
                    clone.removeAttribute('id');
                    clone.style.position = 'relative';
                    clone.style.left = '0';
                    clone.style.top = '0';
                    clone.style.width = w + 'px';
                    clone.style.height = h + 'px';
                    clone.style.margin = '0';
                    clone.style.transform = 'none';
                    clone.style.boxShadow = 'none';
                    clone.style.visibility = 'visible';
                    clone.style.opacity = '1';

                    wrapper.appendChild(clone);
                    document.body.appendChild(wrapper);

                    var maxPx = 16000000;
                    var scale = Math.min(4, Math.sqrt(maxPx / (w * h)));

                    return new Promise(function(resolve) {
                        requestAnimationFrame(function() {
                            requestAnimationFrame(function() {
                                resolve();
                            });
                        });
                    }).then(function() {
                        return html2canvas(clone, {
                            scale: scale
                            , useCORS: true
                            , allowTaint: false
                            , backgroundColor: bg
                            , scrollX: 0
                            , scrollY: 0
                            , x: 0
                            , y: 0
                            , width: w
                            , height: h
                            , logging: false
                        });
                    }).catch(function() {
                        return html2canvas(clone, {
                            scale: 2
                            , useCORS: true
                            , allowTaint: false
                            , backgroundColor: bg
                            , scrollX: 0
                            , scrollY: 0
                            , x: 0
                            , y: 0
                            , width: w
                            , height: h
                            , logging: false
                        });
                    }).finally(function() {
                        if (document.body.contains(wrapper)) document.body.removeChild(wrapper);
                    });
                },

                serverDownload: function(dataUrl, filename, fileType) {
                    if (!this.exportUrl || !this.csrfToken) {
                        // Fallback: client-side download
                        var a = document.createElement('a');
                        a.href = dataUrl;
                        a.download = filename;
                        document.body.appendChild(a);
                        a.click();
                        setTimeout(function() {
                            if (document.body.contains(a)) document.body.removeChild(a);
                        }, 1000);
                        return;
                    }

                    var form = document.createElement('form');
                    form.method = 'POST';
                    form.action = this.exportUrl;
                    form.style.display = 'none';

                    var fields = {
                        '_token': this.csrfToken
                        , 'file_data': dataUrl
                        , 'filename': filename
                        , 'file_type': fileType || 'png'
                    };

                    Object.keys(fields).forEach(function(name) {
                        var input = document.createElement('input');
                        input.type = 'hidden';
                        input.name = name;
                        input.value = fields[name];
                        form.appendChild(input);
                    });

                    document.body.appendChild(form);
                    form.submit();
                    setTimeout(function() {
                        if (document.body.contains(form)) document.body.removeChild(form);
                    }, 3000);
                },

                downloadPNG: function() {
                    if (this.isGenerating) return;
                    var el = this.getActiveCardElement();
                    if (!el) {
                        this.setStatus('Elemen desain tidak ditemukan.', 'error', 4000);
                        return;
                    }

                    this.isGenerating = true;
                    this.generatingType = 'png';
                    this.setStatus('Menyiapkan gambar PNG resolusi tinggi...');

                    var self = this;
                    this.captureCard(el, null).then(function(canvas) {
                        var dataUrl = canvas.toDataURL('image/png', 1.0);
                        var filename = 'Google-Review-' + self.templateSuffix + '-' + self.safeSerial + '-HD.png';
                        self.serverDownload(dataUrl, filename, 'png');
                        self.setStatus('PNG berhasil di-download!', 'info', 3000);
                    }).catch(function(err) {
                        console.error('Error PNG:', err);
                        self.setStatus('Gagal download PNG: ' + (err.message || 'Coba lagi.'), 'error', 6000);
                    }).finally(function() {
                        self.isGenerating = false;
                        self.generatingType = '';
                    });
                },

                downloadPDF: function() {
                    if (this.isGenerating) return;
                    var el = this.getActiveCardElement();
                    if (!el) {
                        this.setStatus('Elemen desain tidak ditemukan.', 'error', 4000);
                        return;
                    }

                    this.isGenerating = true;
                    this.generatingType = 'pdf';
                    this.setStatus('Menyusun dokumen PDF siap cetak...');

                    var self = this;
                    this.captureCard(el, '#ffffff').then(function(canvas) {
                        var imgData = canvas.toDataURL('image/png', 1.0);
                        var pdfW = (self.pdfWidthMm[self.selectedTemplate] || 100);
                        var pdfH = +(pdfW * (canvas.height / canvas.width)).toFixed(2);

                        var jsPDF = window.jspdf.jsPDF;
                        var pdf = new jsPDF({
                            orientation: pdfH >= pdfW ? 'portrait' : 'landscape'
                            , unit: 'mm'
                            , format: [pdfW, pdfH]
                            , compress: true
                        });
                        pdf.addImage(imgData, 'PNG', 0, 0, pdfW, pdfH, undefined, 'FAST');

                        var filename = 'Google-Review-' + self.templateSuffix + '-' + self.safeSerial + '-PrintReady.pdf';
                        var pdfDataUri = pdf.output('datauristring');
                        self.serverDownload(pdfDataUri, filename, 'pdf');
                        self.setStatus('PDF berhasil di-download!', 'info', 3000);
                    }).catch(function(err) {
                        console.error('Error PDF:', err);
                        self.setStatus('Gagal membuat PDF: ' + (err.message || 'Coba lagi.'), 'error', 6000);
                    }).finally(function() {
                        self.isGenerating = false;
                        self.generatingType = '';
                    });
                }
            };
        }
        // @formatter:on

    </script>

</body>
</html>
