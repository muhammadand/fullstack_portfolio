{{-- Template 1: Square Google Review Card (Desain Kotak Presisi Sesuai Foto & Standar Cetak 110mm) --}}
<div id="cardSquareNfc" class="card-render-node relative rounded-[28px] overflow-hidden shadow-2xl transition-all duration-300 select-none bg-white flex flex-col justify-between" style="width: 360px; height: 380px; font-family: 'Product Sans', 'Plus Jakarta Sans', sans-serif; box-shadow: 0 20px 45px -12px rgba(0, 0, 0, 0.4); border: 3px solid #ffffff;">

    <!-- Background 4 Google Brand Colors -->
    <div class="absolute inset-0 grid grid-cols-2 grid-rows-2 z-0">
        <div style="background-color: #4285F4;"></div> <!-- Top-Left: Blue -->
        <div style="background-color: #EA4335;"></div> <!-- Top-Right: Red -->
        <div style="background-color: #34A853;"></div> <!-- Bottom-Left: Green -->
        <div style="background-color: #FBBC05;"></div> <!-- Bottom-Right: Yellow -->
    </div>

    <!-- Inner Card Container with 28px top spacing so the circle badge is never clipped -->
    <div class="relative z-10 w-full h-full pt-7 px-3.5 pb-3.5 flex flex-col box-border">

        <!-- Inner White Card Panel (Bentuk Kotak Presisi 1:1) -->
        <div class="relative w-full flex-1 bg-white rounded-[22px] border border-slate-100 flex flex-col items-center justify-between pt-7 pb-3 px-4 box-border">

            <!-- Official Circular G Badge (Centered at top, seamlessly overlapping without clipping) -->
            <div class="absolute -top-6 left-1/2 -translate-x-1/2 w-12 h-12 rounded-full bg-white flex items-center justify-center p-2.5 border-2 border-slate-100 z-20" style="box-shadow: none;">
                <svg class="w-full h-full" viewBox="0 0 24 24">
                    <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" />
                    <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" />
                    <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.06H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.94l2.85-2.22.81-.63z" />
                    <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.06l3.66 2.84c.87-2.6 3.3-4.52 6.16-4.52z" />
                </svg>
            </div>

            <!-- Top Header & Rating -->
            <div class="w-full flex flex-col items-center text-center">
                @if($card->business_name)
                <div class="inline-flex items-center justify-center px-4 py-1 rounded-full bg-slate-100 text-slate-700 text-[10.5px] font-semibold tracking-normal max-w-[240px] mt-0.5 mb-1.5 text-center border border-slate-200/60 shadow-2xs leading-normal">
                    <span class="truncate">{{ $card->business_name }}</span>
                </div>
                @endif

                <!-- Subtitle in authentic Google Product Sans -->
                <p class="text-[12px] font-normal text-[#5F6368] leading-tight tracking-normal text-center mb-1" style="font-family: 'Product Sans', sans-serif;">
                    Bantu Kami Dengan
                </p>

                <!-- Headline: Google Review (Original Google Brand Typography) -->
                <h2 class="text-[20px] font-bold text-[#202124] tracking-tight leading-tight mb-1.5 text-center" style="font-family: 'Product Sans', sans-serif; letter-spacing: -0.01em;">
                    Google Review
                </h2>

                <!-- 5 Gold Stars Rating (Crisp Vector SVG) -->
                <div class="flex items-center justify-center gap-1 mb-2">
                    <svg class="w-4 h-4 fill-[#FBBC05]" viewBox="0 0 24 24">
                        <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z" /></svg>
                    <svg class="w-4 h-4 fill-[#FBBC05]" viewBox="0 0 24 24">
                        <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z" /></svg>
                    <svg class="w-4 h-4 fill-[#FBBC05]" viewBox="0 0 24 24">
                        <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z" /></svg>
                    <svg class="w-4 h-4 fill-[#FBBC05]" viewBox="0 0 24 24">
                        <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z" /></svg>
                    <svg class="w-4 h-4 fill-[#FBBC05]" viewBox="0 0 24 24">
                        <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z" /></svg>
                </div>
            </div>

            <!-- Center: QR Code Container -->
            <div class="flex flex-col items-center justify-center my-auto">
                <div class="bg-white p-2 rounded-2xl border border-slate-200/90 shadow-xs flex items-center justify-center mb-1.5">
                    <div id="localQrSquare" class="w-[102px] h-[102px] flex items-center justify-center overflow-hidden">
                        <img src="https://api.qrserver.com/v1/create-qr-code/?size=450x450&data={{ urlencode(url('/r/' . $card->slug)) }}&margin=0" alt="QR Code Google Review" crossorigin="anonymous" class="w-full h-full object-contain">
                    </div>
                </div>

                <p class="text-[10.5px] font-bold text-[#202124] tracking-widest uppercase mb-1" style="font-family: 'Product Sans', sans-serif;">
                    Scan QR
                </p>
                <p class="text-[9px] text-[#5F6368] font-normal text-center leading-snug max-w-[240px]" style="font-family: 'Product Sans', sans-serif;">
                    Arahkan kamera HP Anda ke kode QR untuk mengulas
                </p>
            </div>

            <!-- Bottom Metadata: Serial Number -->
            <div class="w-full text-center pt-1 pb-0.5">
                <span class="text-[8px] font-mono text-slate-400 tracking-wider">
                    SN: {{ $card->serial_number }}
                </span>
            </div>

        </div>

    </div>

</div>
