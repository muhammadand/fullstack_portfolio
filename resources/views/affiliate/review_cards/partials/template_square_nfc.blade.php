{{-- Template 2: Square Google Review Smart NFC Card (Smart Tap NFC + QR 110mm) --}}
<div id="cardSquareNfc" class="card-render-node relative rounded-[28px] overflow-hidden shadow-2xl transition-all duration-300 select-none bg-white flex flex-col justify-between" style="width: 360px; height: 380px; font-family: 'Product Sans', 'Plus Jakarta Sans', sans-serif; box-shadow: 0 20px 45px -12px rgba(0, 0, 0, 0.35); border: 3px solid #ffffff;">

    <!-- Background 4 Google Brand Colors (Iconic 4-Color Border) -->
    <div class="absolute inset-0 grid grid-cols-2 grid-rows-2 z-0">
        <div style="background-color: #4285F4;"></div> <!-- Top-Left: Blue -->
        <div style="background-color: #EA4335;"></div> <!-- Top-Right: Red -->
        <div style="background-color: #34A853;"></div> <!-- Bottom-Left: Green -->
        <div style="background-color: #FBBC05;"></div> <!-- Bottom-Right: Yellow -->
    </div>

    <!-- Inner Card Container with Top Offset for Floating Emblem -->
    <div class="relative z-10 w-full h-full pt-6 px-3.5 pb-3.5 flex flex-col box-border">

        <!-- Inner White Card Panel (Bentuk Kotak Presisi & Mewah) -->
        <div class="relative w-full flex-1 bg-white rounded-[22px] border border-slate-100/90 shadow-sm flex flex-col items-center justify-between pt-7 pb-2 px-4 box-border overflow-visible">

            <!-- Official Circular Google G Emblem with Soft Ring -->
            <div class="absolute -top-6 left-1/2 -translate-x-1/2 flex items-center justify-center z-20">
                <div class="w-12 h-12 rounded-full bg-white flex items-center justify-center p-2.5 border-2 border-white shadow-md relative">
                    <svg class="w-full h-full" viewBox="0 0 24 24">
                        <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" />
                        <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" />
                        <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.06H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.94l2.85-2.22.81-.63z" />
                        <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.06l3.66 2.84c.87-2.6 3.3-4.52 6.16-4.52z" />
                    </svg>
                </div>
            </div>

            <!-- Top Header & Rating -->
            <div class="w-full flex flex-col items-center text-center mt-0.5">
                @if($card->business_name)
                <p class="text-[13px] font-semibold text-slate-800 tracking-tight max-w-[260px] truncate mb-0.5 text-center">
                    {{ $card->business_name }}
                </p>
                @endif

                <p class="text-[11.5px] font-normal text-[#5F6368] leading-tight tracking-normal text-center mb-0.5">
                    Bantu Ulas Kami di
                </p>

                <!-- Official Google Wordmark & Review Text -->
                <div class="flex items-center justify-center gap-1.5 mb-1.5">
                    <svg viewBox="0 0 272 92" class="h-5 w-auto">
                        <path fill="#EA4335" d="M115.75 47.18c0 12.77-9.99 22.18-22.25 22.18s-22.25-9.41-22.25-22.18C71.25 34.32 81.24 25 93.5 25s22.25 9.32 22.25 22.18zm-9.74 0c0-7.98-5.79-13.44-12.51-13.44S80.99 39.2 80.99 47.18c0 7.9 5.79 13.44 12.51 13.44s12.51-5.55 12.51-13.44z" />
                        <path fill="#FBBC05" d="M163.75 47.18c0 12.77-9.99 22.18-22.25 22.18s-22.25-9.41-22.25-22.18c0-12.85 9.99-22.18 22.25-22.18s22.25 9.32 22.25 22.18zm-9.74 0c0-7.98-5.79-13.44-12.51-13.44s-12.51 5.46-12.51 13.44c0 7.9 5.79 13.44 12.51 13.44s12.51-5.55 12.51-13.44z" />
                        <path fill="#4285F4" d="M209.75 26.34v39.82c0 16.38-9.66 23.07-21.08 23.07-10.75 0-17.22-7.19-19.66-13.07l8.48-3.53c1.51 3.61 5.21 8.19 11.17 8.19 7.31 0 11.84-4.53 11.84-13.02v-3.19h-.34c-2.18 2.69-6.38 5.04-11.68 5.04-11.09 0-21.25-9.66-21.25-22.09 0-12.52 10.16-22.26 21.25-22.26 5.29 0 9.49 2.35 11.68 4.96h.34v-3.92h9.45zm-8.82 20.92c0-7.81-5.21-13.44-11.84-13.44-6.72 0-12.35 5.63-12.35 13.44 0 7.72 5.63 13.35 12.35 13.35 6.63 0 11.84-5.63 11.84-13.35z" />
                        <path fill="#34A853" d="M225 3v65h-9.5V3h9.5z" />
                        <path fill="#EA4335" d="M262.02 54.48l7.56 5.04c-2.44 3.61-8.32 9.83-18.48 9.83-12.6 0-22.01-9.74-22.01-22.18 0-13.19 9.49-22.18 20.92-22.18 11.51 0 17.14 9.16 18.98 14.11l1.01 2.52-29.65 12.28c2.27 4.45 5.8 6.72 10.75 6.72 4.96 0 8.4-2.44 10.92-6.14zm-13.78-8.15l19.82-8.23c-1.09-2.77-4.37-4.7-8.23-4.7-4.95 0-11.84 4.37-11.59 12.93z" />
                        <path fill="#4285F4" d="M35.29 41.41V32H67c.31 1.64.47 3.58.47 5.68 0 7.06-1.93 15.79-8.15 22.01-6.05 6.3-13.78 9.66-24.02 9.66C16.32 69.35.36 53.89.36 34.91.36 15.93 16.32.47 35.3.47c10.5 0 17.98 4.12 23.6 9.49l-6.64 6.64c-4.03-3.78-9.49-6.72-16.97-6.72-13.86 0-24.7 11.17-24.7 25.03 0 13.86 10.84 25.03 24.7 25.03 8.99 0 14.11-3.61 17.39-6.89 2.69-2.69 4.45-6.55 5.12-11.64H35.29z" />
                    </svg>
                    <span class="text-[18px] font-bold text-[#202124] tracking-tight">Review</span>
                </div>

                <!-- 5 Gold Stars Rating -->
                <div class="flex items-center justify-center gap-1 mb-1">
                    <svg class="w-4 h-4 fill-[#FBBC05]" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z" /></svg>
                    <svg class="w-4 h-4 fill-[#FBBC05]" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z" /></svg>
                    <svg class="w-4 h-4 fill-[#FBBC05]" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z" /></svg>
                    <svg class="w-4 h-4 fill-[#FBBC05]" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z" /></svg>
                    <svg class="w-4 h-4 fill-[#FBBC05]" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z" /></svg>
                </div>
            </div>

            <!-- Center: High-Precision QR Container with Contactless NFC Visual Indicator -->
            <div class="flex flex-col items-center justify-center my-auto w-full">
                <div class="bg-white p-2 rounded-2xl border border-slate-200/90 shadow-xs flex items-center justify-center mb-1.5">
                    <div id="localQrSquareNfc" class="w-[104px] h-[104px] flex items-center justify-center overflow-hidden">
                        <img src="https://api.qrserver.com/v1/create-qr-code/?size=450x450&data={{ urlencode(url('/r/' . $card->slug)) }}&margin=0" alt="QR Code Google Review" crossorigin="anonymous" class="w-full h-full object-contain">
                    </div>
                </div>

                <!-- Dual Action: Tap NFC or Scan QR -->
                <div class="flex items-center justify-center gap-1.5 mb-0.5">
                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md bg-blue-50 text-[#1a73e8] text-[9.5px] font-bold tracking-wider uppercase border border-blue-100">
                        <!-- Contactless NFC Wave Icon -->
                        <svg class="w-3 h-3 text-[#1a73e8]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M6 18a10 10 0 0 1 0-12" />
                            <path d="M10 16a6 6 0 0 1 0-8" />
                            <path d="M14 14a2 2 0 0 1 0-4" />
                        </svg>
                        Tap NFC
                    </span>
                    <span class="text-slate-300 text-[10px] font-bold">•</span>
                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md bg-emerald-50 text-[#137333] text-[9.5px] font-bold tracking-wider uppercase border border-emerald-100">
                        <svg class="w-3 h-3 text-[#137333]" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M3 3h8v8H3V3zm2 2v4h4V5H5zm8-2h8v8h-8V3zm2 2v4h4V5h-4zM3 13h8v8H3v-8zm2 2v4h4v-4H5zm13-2h3v2h-3v-2zm-3 2h2v3h-2v-3zm3 3h3v3h-3v-3zm-5 1h2v2h-2v-2z" />
                        </svg>
                        Scan QR
                    </span>
                </div>

                <p class="text-[8.5px] text-[#5F6368] font-normal text-center leading-tight max-w-[240px]">
                    Dekatkan smartphone Anda atau arahkan kamera ke kode QR
                </p>
            </div>

            <!-- Bottom Metadata: Website Branding, NFC Status & Serial Number -->
            <div class="w-full flex items-center justify-between px-2 pt-1 pb-0.5 border-t border-slate-100">
                <span class="text-[7.5px] font-medium text-slate-400 tracking-wider flex items-center gap-1">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 inline-block"></span>
                    NFC ENABLED
                </span>
                <span class="text-[8px] text-slate-500 font-normal tracking-tight">
                    by <strong class="text-slate-700 font-semibold">scalifyintellegence.my.id</strong>
                </span>
                <span class="text-[7.5px] font-mono text-slate-400 tracking-wider">
                    SN: {{ $card->serial_number }}
                </span>
            </div>

        </div>

    </div>

</div>
