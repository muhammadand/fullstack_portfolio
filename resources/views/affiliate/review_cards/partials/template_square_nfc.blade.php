{{-- Template 1: Square NFC Tap & QR (Google 4-Color Quadrant Frame) --}}
<div id="cardSquareNfc" 
     class="card-render-node relative rounded-[32px] overflow-hidden shadow-2xl transition-all duration-300 select-none"
     style="width: 330px; min-height: 375px; font-family: 'Outfit', sans-serif; box-shadow: 0 20px 45px -15px rgba(0, 0, 0, 0.4); border: 1px solid rgba(0,0,0,0.08);">

    <!-- Background 4 Google Color Quadrants -->
    <div class="absolute inset-0 grid grid-cols-2 grid-rows-2 z-0">
        <div style="background-color: #4285F4;"></div> <!-- Top Left: Google Blue -->
        <div style="background-color: #EA4335;"></div> <!-- Top Right: Google Red -->
        <div style="background-color: #34A853;"></div> <!-- Bottom Left: Google Green -->
        <div style="background-color: #FBBC05;"></div> <!-- Bottom Right: Google Yellow -->
    </div>

    <!-- Inner Content Wrapper with colored margins -->
    <div class="relative z-10 p-3.5 pt-4 flex flex-col items-center">

        <!-- Top Floating Google 'G' Circle Badge overlapping into Blue & Red header -->
        <div class="w-14 h-14 rounded-full bg-white shadow-md flex items-center justify-center p-2.5 z-20 -mb-7 border border-slate-100">
            <svg class="w-full h-full drop-shadow-sm" viewBox="0 0 24 24">
                <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" />
                <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" />
                <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.06H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.94l2.85-2.22.81-.63z" />
                <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.06l3.66 2.84c.87-2.6 3.3-4.52 6.16-4.52z" />
            </svg>
        </div>

        <!-- Inner White Card -->
        <div class="w-full bg-white rounded-[24px] pt-9 pb-3.5 px-3.5 shadow-sm border border-black/5 flex flex-col items-center">
            
            @if($card->business_name)
            <div class="mb-1 px-3 py-0.5 rounded-full bg-slate-100 text-slate-700 text-[10.5px] font-semibold max-w-[220px] truncate text-center">
                {{ $card->business_name }}
            </div>
            @endif

            <!-- Subtitle -->
            <p class="text-[12.5px] font-medium text-slate-600 leading-tight tracking-tight text-center">
                Bantu Kami Dengan
            </p>

            <!-- Headline: Google Review -->
            <h2 class="text-[22px] font-bold text-slate-900 tracking-tight leading-none mt-1 mb-1.5 text-center font-outfit">
                Google Review
            </h2>

            <!-- 5 Gold Stars Rating -->
            <div class="flex items-center justify-center gap-1 mb-3.5">
                <i class="fa-solid fa-star text-[#FBBC05] text-[13px]"></i>
                <i class="fa-solid fa-star text-[#FBBC05] text-[13px]"></i>
                <i class="fa-solid fa-star text-[#FBBC05] text-[13px]"></i>
                <i class="fa-solid fa-star text-[#FBBC05] text-[13px]"></i>
                <i class="fa-solid fa-star text-[#FBBC05] text-[13px]"></i>
            </div>

            <!-- Two-Action Section: NFC (Left) vs QR Code (Right) -->
            <div class="w-full flex items-center justify-between px-1 relative">
                
                <!-- Left Action: Tempelkan HP Kamu (NFC Tap) -->
                <div class="flex-1 flex flex-col items-center justify-center text-center pr-2">
                    <div class="h-16 flex items-center justify-center">
                        <!-- Clean Vector NFC Phone Tap Illustration -->
                        <svg class="w-16 h-14 text-slate-800" viewBox="0 0 95 62" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <!-- NFC Badge Pill -->
                            <rect x="2" y="16" width="36" height="28" rx="14" stroke="#1E293B" stroke-width="2.2" fill="#F8FAFC" />
                            <text x="20" y="33.5" font-family="'Outfit', sans-serif" font-size="9.5" font-weight="700" fill="#1E293B" text-anchor="middle">NFC</text>
                            
                            <!-- Concentric Arc Waves -->
                            <path d="M41 21 C44.5 25, 44.5 35, 41 39" stroke="#1E293B" stroke-width="2.2" stroke-linecap="round" fill="none" />
                            <path d="M45.5 17 C50 23, 50 37, 45.5 43" stroke="#1E293B" stroke-width="2.2" stroke-linecap="round" fill="none" />

                            <!-- Smartphone Body -->
                            <rect x="56" y="5" width="28" height="48" rx="5" stroke="#1E293B" stroke-width="2.2" fill="#FFFFFF" />
                            <!-- Speaker slit -->
                            <line x1="66" y1="9.5" x2="74" y2="9.5" stroke="#1E293B" stroke-width="1.8" stroke-linecap="round" />
                            <!-- Screen Inner Preview Line -->
                            <line x1="60" y1="14" x2="80" y2="14" stroke="#E2E8F0" stroke-width="1.2" stroke-linecap="round" />

                            <!-- Hand Holding Phone Fingers -->
                            <path d="M52 28 C52 26.5, 53.5 25.5, 56 25.5" stroke="#1E293B" stroke-width="2.2" stroke-linecap="round" />
                            <path d="M52 34 C52 32.5, 53.5 31.5, 56 31.5" stroke="#1E293B" stroke-width="2.2" stroke-linecap="round" />
                            <path d="M52 40 C52 38.5, 53.5 37.5, 56 37.5" stroke="#1E293B" stroke-width="2.2" stroke-linecap="round" />
                            <!-- Palm / Wrist Support -->
                            <path d="M53 43 C49 46, 50 51, 55 54 L63 58" stroke="#1E293B" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M78 44 L85 50 C87 52, 86 55, 83 57 L78 60" stroke="#1E293B" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </div>
                    <p class="text-[9.5px] font-bold text-slate-800 tracking-tight mt-1 leading-tight uppercase font-outfit">
                        Tempelkan HP Kamu
                    </p>
                </div>

                <!-- Center Divider Line with 'ATAU' Pill Badge -->
                <div class="relative flex flex-col items-center justify-center self-stretch w-5">
                    <div class="w-[1.5px] h-full bg-slate-200"></div>
                    <span class="absolute bg-white px-1.5 py-0.5 text-[8.5px] font-bold text-slate-400 border border-slate-200 rounded-full tracking-wider leading-none select-none">
                        ATAU
                    </span>
                </div>

                <!-- Right Action: Scan QR Code -->
                <div class="flex-1 flex flex-col items-center justify-center text-center pl-2">
                    <div class="h-16 flex items-center justify-center">
                        <div class="bg-white p-1 rounded-lg border border-slate-200/80 shadow-xs flex items-center justify-center">
                            <img src="https://api.qrserver.com/v1/create-qr-code/?size=400x400&data={{ urlencode(url('/r/' . $card->slug)) }}&margin=0" 
                                 alt="QR Review" 
                                 crossorigin="anonymous" 
                                 class="w-[58px] h-[58px] object-contain">
                        </div>
                    </div>
                    <p class="text-[9.5px] font-bold text-slate-800 tracking-wider mt-1 leading-tight uppercase font-outfit">
                        Scan QR
                    </p>
                </div>

            </div>

            <!-- Footer: Serial & Activation Code -->
            <div class="w-full mt-3 pt-2 border-t border-slate-100 flex items-center justify-between text-[8.5px] font-mono text-slate-400 px-1">
                <span>SN: {{ $card->serial_number }}</span>
                <span>PIN: {{ $card->activation_code }}</span>
            </div>

        </div>

    </div>

</div>
