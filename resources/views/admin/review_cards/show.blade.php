@extends('layouts.admin.app')

@section('content')
<div class="px-4 lg:px-6 py-6 lg:py-8" x-data="cardDesigner()">

    <!-- Top Navigation & Header -->
    <div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <div class="flex items-center gap-2 text-xs text-slate-500 mb-1">
                <a href="{{ route('admin.review_cards.index') }}" class="hover:text-blue-600">Review Cards</a>
                <span>/</span>
                <span class="text-slate-800 font-mono font-medium">{{ $card->serial_number }}</span>
            </div>
            <h1 class="text-2xl font-bold text-slate-800 flex items-center gap-2.5">
                <i class="fa-solid fa-id-card text-blue-600"></i>
                Desain & Cetak Google Review Card
            </h1>
            <p class="text-slate-500 text-sm mt-0.5">Template stiker / standee akrilik meja siap download (PNG & PDF) untuk percetakan.</p>
        </div>

        <div class="flex items-center gap-2 w-full sm:w-auto">
            <a href="{{ route('admin.review_cards.edit', $card->id) }}" class="inline-flex items-center gap-2 bg-slate-100 hover:bg-slate-200 text-slate-700 px-4 py-2.5 rounded-xl text-sm font-semibold transition-colors">
                <i class="fa-solid fa-pen-to-square text-xs"></i>
                Edit Data
            </a>
            <a href="{{ route('admin.review_cards.index') }}" class="inline-flex items-center gap-2 bg-slate-800 hover:bg-slate-900 text-white px-4 py-2.5 rounded-xl text-sm font-semibold transition-colors">
                <i class="fa-solid fa-arrow-left text-xs"></i>
                Kembali
            </a>
        </div>
    </div>

    <!-- Main Workspace: Card Preview & Sidebar Controls -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">

        <!-- Left: Live Card Preview (Siap Cetak) -->
        <div class="lg:col-span-7 flex flex-col items-center">

            <div class="w-full bg-slate-100/80 p-6 sm:p-10 rounded-3xl border border-slate-200/80 flex flex-col items-center justify-center shadow-inner relative overflow-hidden">
                <div class="text-center mb-4 text-xs font-semibold uppercase tracking-wider text-slate-400">
                    Preview Tampilan Fisik (Stiker / Akrilik)
                </div>

                <!-- Google Fonts Outfit & Plus Jakarta Sans -->
                <link rel="preconnect" href="https://fonts.googleapis.com">
                <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
                <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@500;600;700&display=swap" rel="stylesheet">

                <!-- THE PHYSICAL CARD CANVAS -->
                <div id="printableCard" class="bg-white text-slate-900 rounded-[30px] shadow-2xl relative overflow-hidden flex flex-col items-center justify-between transition-all duration-300" style="width: 340px; min-height: 540px; font-family: 'Outfit', sans-serif; border: 1px solid rgba(0,0,0,0.06); box-shadow: 0 20px 45px -15px rgba(0, 0, 0, 0.2);">

                    <!-- Top Area: Google G, 5 Stars, Headline & Google Wordmark -->
                    <div class="w-full pt-8 px-6 flex flex-col items-center text-center">

                        <!-- Official Google G Multi-Color SVG -->
                        <div class="w-14 h-14 mb-3 flex items-center justify-center">
                            <svg class="w-full h-full drop-shadow-sm" viewBox="0 0 24 24">
                                <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" />
                                <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" />
                                <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.06H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.94l2.85-2.22.81-.63z" />
                                <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.06l3.66 2.84c.87-2.6 3.3-4.52 6.16-4.52z" />
                            </svg>
                        </div>

                        <!-- 5 Gold Stars Rating (Exact Vibrant Shape) -->
                        <div class="flex items-center justify-center gap-1.5 mb-2.5">
                            <i class="fa-solid fa-star text-[#F59E0B] text-xl"></i>
                            <i class="fa-solid fa-star text-[#F59E0B] text-xl"></i>
                            <i class="fa-solid fa-star text-[#F59E0B] text-xl"></i>
                            <i class="fa-solid fa-star text-[#F59E0B] text-xl"></i>
                            <i class="fa-solid fa-star text-[#F59E0B] text-xl"></i>
                        </div>

                        <!-- Headline Text: "Nos avalie no" / "Ulas Kami di" -->
                        <p class="text-slate-800 font-medium text-[16px] leading-tight tracking-normal mb-1" style="font-family: 'Outfit', sans-serif;" x-text="headlineText">Nos avalie no</p>

                        <!-- Official Google Full Wordmark SVG (100% Authentic Brand Geometry) -->
                        <div class="flex items-center justify-center my-0.5">
                            <svg viewBox="0 0 272 92" class="h-8 w-auto drop-shadow-sm">
                                <path fill="#EA4335" d="M115.75 47.18c0 12.77-9.99 22.18-22.25 22.18s-22.25-9.41-22.25-22.18C71.25 34.32 81.24 25 93.5 25s22.25 9.32 22.25 22.18zm-9.74 0c0-7.98-5.79-13.44-12.51-13.44S80.99 39.2 80.99 47.18c0 7.9 5.79 13.44 12.51 13.44s12.51-5.55 12.51-13.44z" />
                                <path fill="#FBBC05" d="M163.75 47.18c0 12.77-9.99 22.18-22.25 22.18s-22.25-9.41-22.25-22.18c0-12.85 9.99-22.18 22.25-22.18s22.25 9.32 22.25 22.18zm-9.74 0c0-7.98-5.79-13.44-12.51-13.44s-12.51 5.46-12.51 13.44c0 7.9 5.79 13.44 12.51 13.44s12.51-5.55 12.51-13.44z" />
                                <path fill="#4285F4" d="M209.75 26.34v39.82c0 16.38-9.66 23.07-21.08 23.07-10.75 0-17.22-7.19-19.66-13.07l8.48-3.53c1.51 3.61 5.21 8.19 11.17 8.19 7.31 0 11.84-4.53 11.84-13.02v-3.19h-.34c-2.18 2.69-6.38 5.04-11.68 5.04-11.09 0-21.25-9.66-21.25-22.09 0-12.52 10.16-22.26 21.25-22.26 5.29 0 9.49 2.35 11.68 4.96h.34v-3.92h9.45zm-8.82 20.92c0-7.81-5.21-13.44-11.84-13.44-6.72 0-12.35 5.63-12.35 13.44 0 7.72 5.63 13.35 12.35 13.35 6.63 0 11.84-5.63 11.84-13.35z" />
                                <path fill="#34A853" d="M225 3v65h-9.5V3h9.5z" />
                                <path fill="#EA4335" d="M262.02 54.48l7.56 5.04c-2.44 3.61-8.32 9.83-18.48 9.83-12.6 0-22.01-9.74-22.01-22.18 0-13.19 9.49-22.18 20.92-22.18 11.51 0 17.14 9.16 18.98 14.11l1.01 2.52-29.65 12.28c2.27 4.45 5.8 6.72 10.75 6.72 4.96 0 8.4-2.44 10.92-6.14zm-13.78-8.15l19.82-8.23c-1.09-2.77-4.37-4.7-8.23-4.7-4.95 0-11.84 4.37-11.59 12.93z" />
                                <path fill="#4285F4" d="M35.29 41.41V32H67c.31 1.64.47 3.58.47 5.68 0 7.06-1.93 15.79-8.15 22.01-6.05 6.3-13.78 9.66-24.02 9.66C16.32 69.35.36 53.89.36 34.91.36 15.93 16.32.47 35.3.47c10.5 0 17.98 4.12 23.6 9.49l-6.64 6.64c-4.03-3.78-9.49-6.72-16.97-6.72-13.86 0-24.7 11.17-24.7 25.03 0 13.86 10.84 25.03 24.7 25.03 8.99 0 14.11-3.61 17.39-6.89 2.69-2.69 4.45-6.55 5.12-11.64H35.29z" />
                            </svg>
                        </div>

                        <!-- Optional: Display Business Name if configured and toggled -->
                        <template x-if="showBusinessName && businessName">
                            <div class="mt-1 px-3 py-0.5 rounded-full bg-slate-100 text-slate-700 text-xs font-semibold max-w-[260px] truncate" x-text="businessName"></div>
                        </template>
                    </div>

                    <!-- Middle: QR Container with Iconic Google-Color Rainbow Gradient Border (Exact Match to Reference) -->
                    <div class="w-full px-6 py-2 flex flex-col items-center">
                        <div class="w-full p-[2px] rounded-[22px] shadow-sm" style="background: linear-gradient(135deg, #4285F4 0%, #34A853 35%, #FBBC05 70%, #EA4335 100%);">
                            <div class="w-full bg-white rounded-[20px] p-4 flex flex-col items-center">

                                <p class="text-sm font-semibold text-slate-800 tracking-wide mb-2" style="font-family: 'Outfit', sans-serif;">
                                    Escaneie
                                </p>

                                <!-- The Sharp QR Code Image -->
                                <div class="bg-white p-1 flex items-center justify-center">
                                    <img id="qrImageElement" src="https://api.qrserver.com/v1/create-qr-code/?size=450x450&data={{ urlencode(url('/r/' . $card->slug)) }}&margin=0" alt="QR Code Google Review" crossorigin="anonymous" class="w-40 h-40 object-contain">
                                </div>

                                <p class="text-[11px] text-slate-500 font-normal text-center mt-2 leading-snug" style="font-family: 'Outfit', sans-serif;">
                                    Arahkan kamera HP Anda ke kode QR untuk mengulas
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Bottom: Serial & Google 4-Color Signature Bar -->
                    <div class="w-full flex flex-col items-center">
                        <!-- Serial & PIN (Discreet / Clean) -->
                        <template x-if="showMeta">
                            <div class="text-[10px] text-slate-400 font-mono tracking-wider pb-2 flex items-center justify-between w-full px-6">
                                <span>SN: {{ $card->serial_number }}</span>
                                <span>PIN: {{ $card->activation_code }}</span>
                            </div>
                        </template>

                        <!-- The 4 Google Colors Bottom Bar (Signature) -->
                        <div class="w-full h-3 flex items-center">
                            <div class="flex-1 h-full" style="background-color: #4285F4;"></div>
                            <div class="flex-1 h-full" style="background-color: #34A853;"></div>
                            <div class="flex-1 h-full" style="background-color: #FBBC05;"></div>
                            <div class="flex-1 h-full" style="background-color: #EA4335;"></div>
                        </div>
                    </div>

                </div>
            </div>

            <p class="text-xs text-slate-400 mt-3 text-center">
                <i class="fa-solid fa-circle-info mr-1"></i>
                Ukuran cetak standar proporsi kartu akrilik meja (10 cm x 15 cm atau stiker meja 8 cm x 12 cm).
            </p>
        </div>

        <!-- Right: Action Buttons, Download & Customizer -->
        <div class="lg:col-span-5 space-y-6">

            <!-- Download Actions Card -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
                <h3 class="font-bold text-slate-800 text-base mb-1 flex items-center gap-2">
                    <i class="fa-solid fa-download text-blue-600"></i>
                    Download Desain Kartu
                </h3>
                <p class="text-xs text-slate-500 mb-5">Pilih format untuk diserahkan ke percetakan atau dicetak mandiri.</p>

                <div class="space-y-3">
                    <!-- Download PNG (High-Res 300 DPI) -->
                    <button type="button" @click="downloadPNG()" :disabled="isGenerating" class="w-full flex items-center justify-between p-3.5 bg-blue-600 hover:bg-blue-700 disabled:bg-blue-400 text-white rounded-xl font-semibold text-sm transition-all shadow-sm group">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-white/20 flex items-center justify-center">
                                <i class="fa-solid fa-file-image text-white"></i>
                            </div>
                            <div class="text-left">
                                <div>Download Gambar (PNG)</div>
                                <div class="text-[11px] text-blue-100 font-normal">Resolusi tinggi 300 DPI (Siap Cetak)</div>
                            </div>
                        </div>
                        <i class="fa-solid fa-arrow-down group-hover:translate-y-0.5 transition-transform" :class="isGenerating ? 'fa-spin fa-spinner' : 'fa-arrow-down'"></i>
                    </button>

                    <!-- Download PDF -->
                    <button type="button" @click="downloadPDF()" :disabled="isGenerating" class="w-full flex items-center justify-between p-3.5 bg-slate-800 hover:bg-slate-900 disabled:bg-slate-600 text-white rounded-xl font-semibold text-sm transition-all shadow-sm group">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-white/10 flex items-center justify-center">
                                <i class="fa-solid fa-file-pdf text-red-400"></i>
                            </div>
                            <div class="text-left">
                                <div>Download Dokumen (PDF)</div>
                                <div class="text-[11px] text-slate-400 font-normal">Format vektor cetak akrilik/kertas</div>
                            </div>
                        </div>
                        <i class="fa-solid fa-arrow-down group-hover:translate-y-0.5 transition-transform" :class="isGenerating ? 'fa-spin fa-spinner' : 'fa-arrow-down'"></i>
                    </button>

                    <!-- Print Langsung -->
                    <button type="button" @click="window.print()" class="w-full flex items-center justify-center gap-2 p-3 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl font-semibold text-sm transition-colors">
                        <i class="fa-solid fa-print"></i>
                        <span>Cetak Langsung via Printer</span>
                    </button>
                </div>
            </div>

            <!-- Customizer (Live Edit Label & Tampilan) -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 space-y-4">
                <h3 class="font-bold text-slate-800 text-sm uppercase tracking-wider pb-2 border-b border-slate-100 flex items-center gap-2">
                    <i class="fa-solid fa-sliders text-slate-400"></i>
                    Kustomisasi Tampilan Cetak
                </h3>

                <!-- Headline Text -->
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Teks Judul Ajakan</label>
                    <select x-model="headlineText" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm bg-white outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="Ulas Kami di">Ulas Kami di (Bahasa Indonesia)</option>
                        <option value="Beri Kami Ulasan di">Beri Kami Ulasan di</option>
                        <option value="Review us on">Review us on (English)</option>
                        <option value="Nos avalie no">Nos avalie no (Original)</option>
                    </select>
                </div>

                <!-- Toggle Business Name -->
                @if($card->business_name)
                <div class="flex items-center justify-between p-3 rounded-xl bg-slate-50 border border-slate-200/80">
                    <div>
                        <div class="text-xs font-semibold text-slate-800">Tampilkan Nama Usaha</div>
                        <div class="text-[11px] text-slate-500">{{ $card->business_name }}</div>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" x-model="showBusinessName" class="sr-only peer">
                        <div class="w-9 h-5 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-blue-600"></div>
                    </label>
                </div>
                @endif

                <!-- Toggle Meta Serial/PIN on Card -->
                <div class="flex items-center justify-between p-3 rounded-xl bg-slate-50 border border-slate-200/80">
                    <div>
                        <div class="text-xs font-semibold text-slate-800">Cetak Kode Serial & PIN</div>
                        <div class="text-[11px] text-slate-500">Tercetak kecil di bawah kartu</div>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" x-model="showMeta" class="sr-only peer">
                        <div class="w-9 h-5 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-blue-600"></div>
                    </label>
                </div>
            </div>

            <!-- Card Info Meta -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 space-y-3 text-xs">
                <h3 class="font-bold text-slate-800 text-sm uppercase tracking-wider pb-2 border-b border-slate-100 flex items-center gap-2">
                    <i class="fa-solid fa-circle-info text-slate-400"></i>
                    Informasi Data Kartu
                </h3>

                <div class="flex justify-between py-1 border-b border-slate-100">
                    <span class="text-slate-500">Status</span>
                    <span>
                        @if($card->status === 'active')
                        <span class="px-2 py-0.5 rounded-full font-semibold bg-emerald-50 text-emerald-700">Aktif</span>
                        @elseif($card->status === 'pending')
                        <span class="px-2 py-0.5 rounded-full font-semibold bg-amber-50 text-amber-700">Pending (Belum Aktif)</span>
                        @else
                        <span class="px-2 py-0.5 rounded-full font-semibold bg-slate-100 text-slate-600">Nonaktif</span>
                        @endif
                    </span>
                </div>

                <div class="flex justify-between py-1 border-b border-slate-100">
                    <span class="text-slate-500">Total Scan Pengunjung</span>
                    <span class="font-bold text-slate-800">{{ number_format($card->total_scans) }} kali</span>
                </div>

                <div class="flex justify-between py-1 border-b border-slate-100">
                    <span class="text-slate-500">URL Scan Gateway</span>
                    <a href="{{ url('/r/' . $card->slug) }}" target="_blank" class="font-mono text-blue-600 font-semibold hover:underline flex items-center gap-1">
                        /r/{{ $card->slug }}
                        <i class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i>
                    </a>
                </div>

                @if($card->google_review_url)
                <div class="pt-1">
                    <span class="text-slate-500 block mb-1">Target Google Review URL:</span>
                    <a href="{{ $card->google_review_url }}" target="_blank" class="text-blue-600 hover:underline block truncate font-mono text-[11px] bg-slate-50 p-2 rounded border border-slate-200">
                        {{ $card->google_review_url }}
                    </a>
                </div>
                @endif
            </div>

        </div>

    </div>

</div>

<!-- CDN html2canvas & html2pdf untuk ekspor resolusi tinggi -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>

<script>
    function cardDesigner() {
        return {
            headlineText: 'Nos avalie no',
            showBusinessName: false,
            businessName: @json($businessName),
            showMeta: true,
            isGenerating: false,

            async downloadPNG() {
                this.isGenerating = true;
                const element = document.getElementById('printableCard');

                try {
                    // Skala 3 untuk hasil cetak tajam 300 DPI
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
                    // Fallback to window print
                    window.print();
                } finally {
                    this.isGenerating = false;
                }
            }
        }
    }

</script>

<style>
    /* Cetak Khusus Mode Print */
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
@endsection
