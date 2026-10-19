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

            #printableCard,
            #printableCard * {
                visibility: visible !important;
            }

            #printableCard {
                position: fixed !important;
                left: 50% !important;
                top: 50% !important;
                transform: translate(-50%, -50%) !important;
                box-shadow: none !important;
                border: 1px solid #ccc !important;
                width: 100mm !important;
                min-height: 150mm !important;
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
        <div class="flex items-center justify-between gap-3 mb-5">
            <a href="{{ route('affiliate.review_cards.index') }}" class="w-10 h-10 rounded-2xl glass-panel flex items-center justify-center text-slate-300 hover:text-white transition-colors active:scale-95">
                <i class="fa-solid fa-arrow-left text-sm"></i>
            </a>
            <div class="text-center flex-1">
                <h1 class="text-base font-bold text-white font-outfit leading-tight">Desain Siap Cetak</h1>
                <p class="text-[11px] text-blue-400 font-mono">{{ $card->serial_number }}</p>
            </div>
            <div class="w-10"></div> <!-- Placeholder spacer -->
        </div>

        <!-- The Physical Card Canvas Container -->
        <div class="flex justify-center mb-6">
            <div id="printableCard" class="bg-white text-slate-900 rounded-[30px] shadow-2xl relative overflow-hidden flex flex-col items-center justify-between transition-all duration-300" style="width: 320px; min-height: 520px; font-family: 'Outfit', sans-serif; border: 1px solid rgba(0,0,0,0.06); box-shadow: 0 20px 45px -15px rgba(0, 0, 0, 0.35);">

                <!-- Top Area: Google G, 5 Stars, Headline & Google Wordmark -->
                <div class="w-full pt-7 px-5 flex flex-col items-center text-center">

                    <!-- Official Google G Multi-Color SVG -->
                    <div class="w-12 h-12 mb-2.5 flex items-center justify-center">
                        <svg class="w-full h-full drop-shadow-sm" viewBox="0 0 24 24">
                            <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" />
                            <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" />
                            <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.06H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.94l2.85-2.22.81-.63z" />
                            <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.06l3.66 2.84c.87-2.6 3.3-4.52 6.16-4.52z" />
                        </svg>
                    </div>

                    <!-- 5 Gold Stars Rating -->
                    <div class="flex items-center justify-center gap-1 mb-2">
                        <i class="fa-solid fa-star text-[#F59E0B] text-lg"></i>
                        <i class="fa-solid fa-star text-[#F59E0B] text-lg"></i>
                        <i class="fa-solid fa-star text-[#F59E0B] text-lg"></i>
                        <i class="fa-solid fa-star text-[#F59E0B] text-lg"></i>
                        <i class="fa-solid fa-star text-[#F59E0B] text-lg"></i>
                    </div>

                    <!-- Headline Text -->
                    <p class="text-slate-800 font-medium text-[15px] leading-tight tracking-normal mb-1">Nos avalie no</p>

                    <!-- Official Google Full Wordmark SVG -->
                    <div class="flex items-center justify-center my-0.5">
                        <svg viewBox="0 0 272 92" class="h-7 w-auto drop-shadow-sm">
                            <path fill="#EA4335" d="M115.75 47.18c0 12.77-9.99 22.18-22.25 22.18s-22.25-9.41-22.25-22.18C71.25 34.32 81.24 25 93.5 25s22.25 9.32 22.25 22.18zm-9.74 0c0-7.98-5.79-13.44-12.51-13.44S80.99 39.2 80.99 47.18c0 7.9 5.79 13.44 12.51 13.44s12.51-5.55 12.51-13.44z" />
                            <path fill="#FBBC05" d="M163.75 47.18c0 12.77-9.99 22.18-22.25 22.18s-22.25-9.41-22.25-22.18c0-12.85 9.99-22.18 22.25-22.18s22.25 9.32 22.25 22.18zm-9.74 0c0-7.98-5.79-13.44-12.51-13.44s-12.51 5.46-12.51 13.44c0 7.9 5.79 13.44 12.51 13.44s12.51-5.55 12.51-13.44z" />
                            <path fill="#4285F4" d="M209.75 26.34v39.82c0 16.38-9.66 23.07-21.08 23.07-10.75 0-17.22-7.19-19.66-13.07l8.48-3.53c1.51 3.61 5.21 8.19 11.17 8.19 7.31 0 11.84-4.53 11.84-13.02v-3.19h-.34c-2.18 2.69-6.38 5.04-11.68 5.04-11.09 0-21.25-9.66-21.25-22.09 0-12.52 10.16-22.26 21.25-22.26 5.29 0 9.49 2.35 11.68 4.96h.34v-3.92h9.45zm-8.82 20.92c0-7.81-5.21-13.44-11.84-13.44-6.72 0-12.35 5.63-12.35 13.44 0 7.72 5.63 13.35 12.35 13.35 6.63 0 11.84-5.63 11.84-13.35z" />
                            <path fill="#34A853" d="M225 3v65h-9.5V3h9.5z" />
                            <path fill="#EA4335" d="M262.02 54.48l7.56 5.04c-2.44 3.61-8.32 9.83-18.48 9.83-12.6 0-22.01-9.74-22.01-22.18 0-13.19 9.49-22.18 20.92-22.18 11.51 0 17.14 9.16 18.98 14.11l1.01 2.52-29.65 12.28c2.27 4.45 5.8 6.72 10.75 6.72 4.96 0 8.4-2.44 10.92-6.14zm-13.78-8.15l19.82-8.23c-1.09-2.77-4.37-4.7-8.23-4.7-4.95 0-11.84 4.37-11.59 12.93z" />
                            <path fill="#4285F4" d="M35.29 41.41V32H67c.31 1.64.47 3.58.47 5.68 0 7.06-1.93 15.79-8.15 22.01-6.05 6.3-13.78 9.66-24.02 9.66C16.32 69.35.36 53.89.36 34.91.36 15.93 16.32.47 35.3.47c10.5 0 17.98 4.12 23.6 9.49l-6.64 6.64c-4.03-3.78-9.49-6.72-16.97-6.72-13.86 0-24.7 11.17-24.7 25.03 0 13.86 10.84 25.03 24.7 25.03 8.99 0 14.11-3.61 17.39-6.89 2.69-2.69 4.45-6.55 5.12-11.64H35.29z" />
                        </svg>
                    </div>

                    @if($card->business_name)
                    <div class="mt-1 px-3 py-0.5 rounded-full bg-slate-100 text-slate-700 text-[11px] font-semibold max-w-[240px] truncate">
                        {{ $card->business_name }}
                    </div>
                    @endif
                </div>

                <!-- Middle: QR Container with Rainbow Gradient Border -->
                <div class="w-full px-5 py-2 flex flex-col items-center">
                    <div class="w-full p-[2px] rounded-[22px] shadow-sm" style="background: linear-gradient(135deg, #4285F4 0%, #34A853 35%, #FBBC05 70%, #EA4335 100%);">
                        <div class="w-full bg-white rounded-[20px] p-3.5 flex flex-col items-center">

                            <p class="text-xs font-semibold text-slate-800 tracking-wide mb-1.5" style="font-family: 'Outfit', sans-serif;">
                                Escaneie
                            </p>

                            <!-- The Sharp QR Code Image -->
                            <div class="bg-white p-1 flex items-center justify-center">
                                <img id="qrImageElement" src="https://api.qrserver.com/v1/create-qr-code/?size=450x450&data={{ urlencode(url('/r/' . $card->slug)) }}&margin=0" alt="QR Code Google Review" crossorigin="anonymous" class="w-36 h-36 object-contain">
                            </div>

                            <p class="text-[10px] text-slate-500 font-normal text-center mt-1.5 leading-snug" style="font-family: 'Outfit', sans-serif;">
                                Arahkan kamera HP Anda ke kode QR untuk mengulas
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Bottom: Serial & Google 4-Color Signature Bar -->
                <div class="w-full flex flex-col items-center">
                    <div class="text-[9px] text-slate-400 font-mono tracking-wider pb-1.5 flex items-center justify-between w-full px-5">
                        <span>SN: {{ $card->serial_number }}</span>
                        <span>PIN: {{ $card->activation_code }}</span>
                    </div>

                    <div class="w-full h-2.5 flex items-center">
                        <div class="flex-1 h-full" style="background-color: #4285F4;"></div>
                        <div class="flex-1 h-full" style="background-color: #34A853;"></div>
                        <div class="flex-1 h-full" style="background-color: #FBBC05;"></div>
                        <div class="flex-1 h-full" style="background-color: #EA4335;"></div>
                    </div>
                </div>

            </div>
        </div>

        <!-- Download Buttons Panel -->
        <div class="glass-panel p-4 rounded-3xl space-y-2.5">
            <h3 class="text-xs font-bold text-slate-300 uppercase tracking-wider mb-2 font-outfit flex items-center gap-1.5">
                <i class="fa-solid fa-download text-blue-400"></i>
                Download Format Cetak
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
                    <span>Download Dokumen PDF (Vektor)</span>
                </div>
                <i class="fa-solid fa-arrow-down" :class="isGenerating ? 'fa-spin fa-circle-notch' : 'fa-arrow-down'"></i>
            </button>
        </div>

        <p class="text-center text-[11px] text-slate-500 mt-4 leading-relaxed">
            💡 Serahkan file gambar/PDF ini ke percetakan terdekat untuk dicetak di stiker vinyl, kartu akrilik, atau standee meja.
        </p>

    </div>

    <script>
        function partnerCardDesigner() {
            return {
                isGenerating: false,

                async downloadPNG() {
                    this.isGenerating = true;
                    const element = document.getElementById('printableCard');

                    try {
                        const canvas = await html2canvas(element, {
                            scale: 3
                            , useCORS: true
                            , allowTaint: false
                            , backgroundColor: null
                        });

                        const link = document.createElement('a');
                        link.download = `Google-Review-Card-{{ $card->serial_number }}.png`;
                        link.href = canvas.toDataURL('image/png');
                        link.click();
                    } catch (error) {
                        console.error(error);
                        alert('Gagal membuat file PNG. Silakan coba Cetak via Browser.');
                    } finally {
                        this.isGenerating = false;
                    }
                },

                async downloadPDF() {
                    this.isGenerating = true;
                    const element = document.getElementById('printableCard');

                    const opt = {
                        margin: [10, 10, 10, 10]
                        , filename: `Google-Review-Card-{{ $card->serial_number }}.pdf`
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
                            , format: 'a6'
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
