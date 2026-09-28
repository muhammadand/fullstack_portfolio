<!DOCTYPE html>
<html lang="id" class="h-full bg-[#0D0A08]">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Demo Self-Order & POS Kasir QRIS - {{ $client->brand_name ?? 'Artisan Coffee Roasters' }}</title>

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        cafe: {
                            espresso: '#140F0C',
                            dark: '#1C1612',
                            mocha: '#261E18',
                            roast: '#3A2C22',
                            bronze: '#C59B6C',
                            gold: '#D8AA73',
                            cream: '#FAF7F2',
                            card: '#1F1813'
                        }
                    },
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                        serif: ['"Playfair Display"', 'serif'],
                        mono: ['"JetBrains Mono"', 'monospace']
                    }
                }
            }
        }
    </script>

    <!-- Google Fonts & FontAwesome -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;600;700&family=Playfair+Display:ital,wght@0,600;0,700;1,600&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- QRCode JS & Confetti -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            -webkit-tap-highlight-color: transparent;
            user-select: none;
            background-color: #0B0806;
            color: #FAF7F2;
        }

        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }
        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        /* Mobile Frame on Desktop */
        @media (min-width: 768px) {
            .mobile-device-wrapper {
                max-width: 412px;
                height: 860px;
                max-height: 94vh;
                border-radius: 46px;
                box-shadow: 0 25px 70px -15px rgba(0, 0, 0, 0.9), 0 0 0 10px #1E1713, 0 0 0 12px #3D2E24;
                position: relative;
                overflow: hidden;
            }
        }

        /* Luxury Card Foil */
        .member-gold-card {
            background: linear-gradient(135deg, #1C1713 0%, #2D231B 45%, #423428 75%, #1F1813 100%);
            position: relative;
            overflow: hidden;
            border: 1px solid rgba(216, 170, 115, 0.4);
        }

        @keyframes shimmer {
            100% { transform: translateX(100%); }
        }
        .shimmer-btn {
            position: relative;
            overflow: hidden;
        }
        .shimmer-btn::after {
            position: absolute;
            top: 0; right: 0; bottom: 0; left: 0;
            transform: translateX(-100%);
            background-image: linear-gradient(
                90deg,
                rgba(255, 255, 255, 0) 0,
                rgba(255, 255, 255, 0.25) 50%,
                rgba(255, 255, 255, 0) 100%
            );
            animation: shimmer 2.5s infinite;
            content: '';
        }
    </style>
</head>
<body class="h-full flex flex-col items-center justify-center antialiased p-0 sm:p-4">

    <!-- SOUND SYNTHESIZER (Web Audio API - Instant, Zero Delay) -->
    <script>
        const audioCtx = new (window.AudioContext || window.webkitAudioContext)();
        function playBeep(freq = 600, duration = 0.08, type = 'sine') {
            try {
                if (audioCtx.state === 'suspended') audioCtx.resume();
                const osc = audioCtx.createOscillator();
                const gain = audioCtx.createGain();
                osc.type = type;
                osc.frequency.setValueAtTime(freq, audioCtx.currentTime);
                gain.gain.setValueAtTime(0.12, audioCtx.currentTime);
                gain.gain.exponentialRampToValueAtTime(0.001, audioCtx.currentTime + duration);
                osc.connect(gain);
                gain.connect(audioCtx.destination);
                osc.start();
                osc.stop(audioCtx.currentTime + duration);
            } catch (e) {}
        }
        function playSuccessSound() {
            try {
                if (audioCtx.state === 'suspended') audioCtx.resume();
                playBeep(523.25, 0.1);
                setTimeout(() => playBeep(659.25, 0.12), 90);
                setTimeout(() => playBeep(783.99, 0.25), 180);
                setTimeout(() => playBeep(1046.50, 0.4), 280);
            } catch (e) {}
        }
    </script>

    @php
    $cleanWa = preg_replace('/[^0-9]/', '', $client->wa_number ?? '6281234567890');
    if (str_starts_with($cleanWa, '0')) {
        $cleanWa = '62' . substr($cleanWa, 1);
    }
    $brandName = $client->brand_name ?? 'Artisan Coffee Roasters';

    $jsonPath = resource_path('views/client-proposals/cafe/data.json');
    if (file_exists($jsonPath)) {
        $cafeDatabase = json_decode(file_get_contents($jsonPath), true);
    } else {
        $cafeDatabase = [];
    }
    @endphp

    <!-- Top Banner for Desktop Preview (Exact match with sport demo) -->
    <header class="w-full max-w-4xl px-4 py-2 hidden md:flex items-center justify-between text-xs text-white/50 mb-2">
        <div class="flex items-center gap-2">
            <span class="w-2.5 h-2.5 rounded-full bg-emerald-400 animate-pulse"></span>
            <span class="font-bold text-white uppercase tracking-wider">Live Customer Mobile App Demo</span>
            <span class="text-white/20">•</span>
            <span>Self-Order Meja, QRIS Dinamis & VIP Member</span>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('landing.dynamic', $client->slug) }}" class="text-white/70 hover:text-white flex items-center gap-1.5 font-medium bg-[#1F1813] px-3.5 py-1.5 rounded-full border border-white/10 transition">
                <i class="fas fa-arrow-left text-[10px]"></i>
                <span>Kembali ke Landing Page</span>
            </a>
            @if(isset($client->slug))
            <a href="{{ route('proposal.dynamic', $client->slug) }}" class="text-[#D8AA73] hover:text-white flex items-center gap-1.5 font-medium bg-[#1F1813] px-3.5 py-1.5 rounded-full border border-[#C59B6C]/40 transition">
                <i class="fas fa-file-invoice text-[10px]"></i>
                <span>Proposal Proyek</span>
            </a>
            @endif
        </div>
    </header>

    <!-- Main Mobile Device Screen -->
    <main class="w-full h-full sm:h-auto mobile-device-wrapper bg-[#140F0C] flex flex-col relative overflow-hidden text-cafe-cream">
        
        <!-- Mobile Status Bar (Espresso & Gold Theme) -->
        <div class="bg-gradient-to-r from-[#241A14] via-[#1F1612] to-[#140F0C] text-white px-6 pt-3 pb-2 flex items-center justify-between text-[11px] font-semibold shrink-0 z-40 select-none border-b border-white/5">
            <span id="statusBarClock" class="font-bold">12:30</span>
            <!-- Dynamic Island Pill -->
            <div class="w-24 h-4 bg-black/60 rounded-full mx-auto hidden sm:flex items-center justify-center gap-1.5 px-2">
                <span class="w-1.5 h-1.5 rounded-full bg-[#C59B6C] animate-pulse"></span>
                <span class="text-[8px] text-[#D8AA73] font-mono tracking-tighter">CF-POS LIVE</span>
            </div>
            <div class="flex items-center gap-1.5 text-[10px] text-white/80">
                <i class="fas fa-signal"></i>
                <i class="fas fa-wifi"></i>
                <i class="fas fa-battery-full text-xs text-emerald-400"></i>
            </div>
        </div>

        <!-- APP CONTAINER (SCROLLABLE VIEWPORT) -->
        <div id="appViewport" class="flex-1 overflow-y-auto no-scrollbar relative bg-[#140F0C] flex flex-col pb-24 text-white">

            <!-- ================= VIEW 1: MENU SELF-ORDER (DEFAULT) ================= -->
            <section id="viewMenu" class="flex-1 flex flex-col space-y-4 p-4">
                
                <!-- Table & Location Header -->
                <div class="bg-gradient-to-r from-[#2A1F17] to-[#1F1612] rounded-2xl p-3.5 border border-[#C59B6C]/30 flex items-center justify-between shadow-lg">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-[#C59B6C] text-[#140F0C] flex items-center justify-center text-lg font-bold shadow-md">
                            <i class="fas fa-qrcode"></i>
                        </div>
                        <div>
                            <span class="text-[9px] uppercase tracking-wider text-[#D8AA73] font-bold block">Pesan di Meja (Self-Order)</span>
                            <div class="flex items-center gap-1.5 cursor-pointer" onclick="cycleTable()">
                                <h3 class="text-xs font-bold text-white" id="appTableLabel">Meja 04 (Indoor Lounge)</h3>
                                <i class="fas fa-chevron-down text-[9px] text-[#D8AA73]"></i>
                            </div>
                        </div>
                    </div>
                    <button onclick="cycleTable()" class="text-[10px] px-2.5 py-1 rounded-lg bg-white/5 hover:bg-white/10 text-white/80 border border-white/10 transition">
                        Ganti Meja
                    </button>
                </div>

                <!-- Membership Mini Banner in App -->
                <div onclick="switchAppTab('member')" class="cursor-pointer bg-gradient-to-r from-[#1F1813] via-[#2A1F17] to-[#1F1813] border border-amber-500/30 rounded-2xl p-3 flex items-center justify-between shadow-md hover:border-amber-500/60 transition">
                    <div class="flex items-center gap-2.5">
                        <div class="w-9 h-9 rounded-xl bg-amber-500/20 text-amber-400 flex items-center justify-center text-sm font-bold">
                            <i class="fas fa-crown"></i>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-white flex items-center gap-1.5">
                                <span id="appMemberName">Sarah Anggraini</span>
                                <span class="text-[8px] px-1.5 py-0.2 rounded bg-amber-400/20 text-amber-300 font-bold" id="appMemberTier">GOLD VIP</span>
                            </p>
                            <p class="text-[10px] text-[#D8AA73] font-mono"><span id="appMemberPts">2.450</span> Pts • Diskon 10% Aktif</p>
                        </div>
                    </div>
                    <span class="text-[10px] font-bold text-amber-400 flex items-center gap-1">
                        <span>Kartu</span> <i class="fas fa-arrow-right text-[8px]"></i>
                    </span>
                </div>

                <!-- Search Input -->
                <div class="relative">
                    <i class="fas fa-search absolute left-3.5 top-1/2 -translate-y-1/2 text-white/40 text-xs"></i>
                    <input type="text" id="appSearchInput" oninput="filterAppProducts(this.value)" placeholder="Cari Caramel Macchiato, Croissant..." class="w-full bg-[#1C1612] border border-white/10 rounded-xl pl-9 pr-3 py-2 text-xs text-white placeholder-white/40 focus:outline-none focus:border-[#C59B6C] transition">
                </div>

                <!-- Category Pills (Horizontal Scroll) -->
                <div class="flex items-center gap-2 overflow-x-auto no-scrollbar py-1" id="appCategoryTabs">
                    <!-- Populated by JS -->
                </div>

                <!-- Menu Items Grid -->
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <h4 class="text-xs font-bold text-white uppercase tracking-wider">
                            Pilihan Barista
                        </h4>
                        <span class="text-[10px] text-white/40" id="appProductCount">12 Menu</span>
                    </div>

                    <div class="grid grid-cols-2 gap-2.5" id="appProductGrid">
                        <!-- Populated dynamically by JS -->
                    </div>
                </div>

            </section>

            <!-- ================= VIEW 2: VIP MEMBERSHIP ================= -->
            <section id="viewMember" class="flex-1 hidden flex-col space-y-4 p-4">
                
                <div class="text-center pt-2">
                    <span class="text-[10px] uppercase tracking-widest text-[#D8AA73] font-bold">Exclusive Coffee Club</span>
                    <h3 class="font-serif font-bold text-xl text-white mt-0.5">VIP Loyalty Pass</h3>
                </div>

                <!-- Digital Gold Member Card -->
                <div class="member-gold-card rounded-3xl p-5 text-white shadow-2xl relative">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-[10px] text-[#D8AA73] tracking-widest uppercase font-semibold">{{ strtoupper($brandName) }}</p>
                            <h4 class="font-serif font-bold text-xl text-white tracking-wide mt-0.5">MEMBER PASS</h4>
                        </div>
                        <div class="w-8 h-6 rounded bg-gradient-to-r from-amber-400 to-amber-200 border border-amber-300/40 shadow-inner"></div>
                    </div>

                    <div class="my-6">
                        <p class="text-[9px] text-[#D8AA73] uppercase tracking-wider font-semibold">Nama Pemegang Kartu</p>
                        <p class="font-bold text-lg text-white tracking-wide" id="cardMemberName">Sarah Anggraini</p>
                        <p class="font-mono text-xs text-white/60 tracking-widest mt-1">•••• •••• •••• 9088</p>
                    </div>

                    <div class="flex items-end justify-between pt-3 border-t border-white/10">
                        <div>
                            <span class="text-[9px] text-[#D8AA73] uppercase font-semibold">Status Tier</span>
                            <p class="font-bold text-xs text-amber-300" id="cardMemberTier">GOLD VIP (Diskon 10%)</p>
                        </div>
                        <div class="text-right">
                            <span class="text-[9px] text-[#D8AA73] uppercase font-semibold">Saldo Poin</span>
                            <p class="font-mono font-bold text-base text-white" id="cardMemberPoints">2.450 Pts</p>
                        </div>
                    </div>
                </div>

                <!-- Sample Members Switcher (For Presentation Demo) -->
                <div class="bg-[#1C1612] p-3 rounded-2xl border border-white/10">
                    <p class="text-[11px] font-bold text-[#D8AA73] uppercase tracking-wide mb-2">
                        Pilih Akun Member untuk Demo:
                    </p>
                    <div class="space-y-1.5" id="appMemberList">
                        <!-- Populated by JS -->
                    </div>
                </div>

                <!-- Register New Member -->
                <div class="bg-[#1C1612] p-3.5 rounded-2xl border border-white/10">
                    <h5 class="text-xs font-bold text-white mb-2 flex items-center justify-between">
                        <span>Daftar Member Baru Seketika</span>
                        <span class="text-[10px] text-amber-400 font-bold">+100 Poin</span>
                    </h5>
                    <div class="space-y-2">
                        <input type="text" id="appNewName" placeholder="Nama Lengkap..." class="w-full bg-[#140F0C] border border-white/10 rounded-xl px-3 py-2 text-xs text-white">
                        <input type="text" id="appNewPhone" placeholder="Nomor WhatsApp..." class="w-full bg-[#140F0C] border border-white/10 rounded-xl px-3 py-2 text-xs text-white">
                        <button onclick="handleAppNewMember()" class="w-full py-2.5 rounded-xl bg-[#C59B6C] text-[#140F0C] text-xs font-bold hover:bg-[#D8AA73] transition">
                            + Daftarkan & Dapatkan Diskon
                        </button>
                    </div>
                </div>

            </section>

            <!-- ================= VIEW 3: RIWAYAT PESANAN ================= -->
            <section id="viewOrders" class="flex-1 hidden flex-col space-y-4 p-4">
                <div class="flex items-center justify-between pt-1">
                    <h3 class="font-serif font-bold text-base text-white">Riwayat Transaksi Meja</h3>
                    <span class="text-[10px] text-[#D8AA73] cursor-pointer" onclick="resetAppOrders()">Reset Demo</span>
                </div>

                <div class="space-y-3" id="appOrderHistoryList">
                    <!-- Populated by JS -->
                </div>
            </section>

            <!-- ================= VIEW 4: POS KASIR MONITOR ================= -->
            <section id="viewPos" class="flex-1 hidden flex-col space-y-4 p-4">
                <div class="bg-[#1C1612] p-3.5 rounded-2xl border border-[#C59B6C]/30 flex items-center justify-between">
                    <div>
                        <span class="text-[9px] uppercase tracking-wider text-emerald-400 font-bold flex items-center gap-1">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span> Terminal Kasir Aktif
                        </span>
                        <h4 class="font-bold text-xs text-white mt-0.5">Barista Shift Pagi</h4>
                    </div>
                    <div class="text-right">
                        <span class="text-[9px] text-white/50">Omset Hari Ini</span>
                        <p class="font-mono text-xs font-bold text-[#D8AA73]" id="appDailySales">Rp 1.480.000</p>
                    </div>
                </div>

                <!-- Active Kitchen Queue -->
                <div>
                    <h5 class="text-xs font-bold text-white uppercase tracking-wider mb-2">
                        Antrean Masuk dari Meja:
                    </h5>
                    <div class="space-y-2.5" id="appKitchenQueue">
                        <!-- Populated by JS -->
                    </div>
                </div>
            </section>

        </div>

        <!-- STICKY FLOATING CART BAR AT BOTTOM (WHEN ITEMS IN CART) -->
        <div id="appFloatingCart" class="absolute bottom-16 inset-x-3 bg-gradient-to-r from-[#2A1F17] to-[#1F1612] border border-[#C59B6C]/50 p-2.5 rounded-2xl shadow-2xl flex items-center justify-between z-30 transition-transform duration-300">
            <div class="flex items-center gap-2.5 cursor-pointer" onclick="openAppCartSheet()">
                <div class="relative w-9 h-9 rounded-xl bg-[#C59B6C] text-[#140F0C] flex items-center justify-center font-bold text-xs shadow-md">
                    <i class="fas fa-shopping-bag"></i>
                    <span id="appCartBadge" class="absolute -top-1.5 -right-1.5 w-5 h-5 bg-red-500 text-white rounded-full text-[9px] font-bold flex items-center justify-center border-2 border-[#140F0C]">0</span>
                </div>
                <div>
                    <p class="text-[9px] text-white/60">Total Pesanan Meja</p>
                    <p class="text-xs font-bold text-white font-mono" id="appCartTotal">Rp 0</p>
                </div>
            </div>

            <button onclick="openAppCheckoutModal()" class="shimmer-btn px-4 py-2 rounded-xl bg-gradient-to-r from-[#C59B6C] to-[#D8AA73] text-[#140F0C] text-xs font-bold flex items-center gap-1.5 shadow-md">
                <span>Bayar QRIS</span>
                <i class="fas fa-arrow-right text-[10px]"></i>
            </button>
        </div>

        <!-- BOTTOM APP NAVIGATION BAR (4 TABS) -->
        <nav class="absolute bottom-0 inset-x-0 bg-[#16110E] border-t border-white/10 px-4 py-2 flex items-center justify-around z-30 select-none">
            <button onclick="switchAppTab('menu')" id="tabBtnMenu" class="app-tab-btn active flex flex-col items-center gap-0.5 text-[#D8AA73]">
                <i class="fas fa-mug-hot text-sm"></i>
                <span class="text-[9px] font-bold">Menu Meja</span>
            </button>

            <button onclick="switchAppTab('member')" id="tabBtnMember" class="app-tab-btn flex flex-col items-center gap-0.5 text-white/50 hover:text-white">
                <i class="fas fa-id-card text-sm"></i>
                <span class="text-[9px] font-bold">Member VIP</span>
            </button>

            <button onclick="switchAppTab('orders')" id="tabBtnOrders" class="app-tab-btn flex flex-col items-center gap-0.5 text-white/50 hover:text-white">
                <i class="fas fa-clock-rotate-left text-sm"></i>
                <span class="text-[9px] font-bold">Riwayat</span>
            </button>

            <button onclick="switchAppTab('pos')" id="tabBtnPos" class="app-tab-btn flex flex-col items-center gap-0.5 text-white/50 hover:text-white">
                <i class="fas fa-cash-register text-sm"></i>
                <span class="text-[9px] font-bold">Kasir POS</span>
            </button>
        </nav>

        <!-- ================= MODALS INSIDE PHONE ================= -->
        
        <!-- 1. CART SHEET DRAWER -->
        <div id="appCartSheet" class="absolute inset-0 bg-black/80 backdrop-blur-sm hidden flex-col justify-end z-50">
            <div class="bg-[#1C1612] rounded-t-3xl border-t border-[#C59B6C]/40 p-5 max-h-[80%] flex flex-col shadow-2xl">
                <div class="flex items-center justify-between pb-3 border-b border-white/10">
                    <h4 class="text-xs font-bold text-white flex items-center gap-2">
                        <i class="fas fa-shopping-bag text-[#C59B6C]"></i> Pesanan Anda
                    </h4>
                    <button onclick="closeAppCartSheet()" class="w-6 h-6 rounded-full bg-white/10 text-white flex items-center justify-center text-xs">
                        <i class="fas fa-times"></i>
                    </button>
                </div>

                <div class="flex-grow overflow-y-auto no-scrollbar py-3 space-y-2.5" id="appCartItemsContainer">
                    <!-- Dynamic -->
                </div>

                <!-- Calculations -->
                <div class="pt-3 border-t border-white/10 space-y-1.5 text-[11px]">
                    <div class="flex justify-between text-white/60">
                        <span>Subtotal</span>
                        <span class="font-mono text-white" id="appSubtotal">Rp 0</span>
                    </div>
                    <div class="flex justify-between text-amber-400">
                        <span>Diskon Member (<span id="appDiscountRate">10%</span>)</span>
                        <span class="font-mono" id="appDiscountAmount">- Rp 0</span>
                    </div>
                    <div class="flex justify-between text-white/60">
                        <span>PB1 Resto (10%)</span>
                        <span class="font-mono text-white" id="appTaxAmount">Rp 0</span>
                    </div>
                    <div class="flex justify-between text-sm font-bold text-white pt-2 border-t border-white/10">
                        <span>Total Pembayaran</span>
                        <span class="font-mono text-[#D8AA73]" id="appGrandTotal">Rp 0</span>
                    </div>
                </div>

                <button onclick="closeAppCartSheet(); openAppCheckoutModal();" class="shimmer-btn mt-4 w-full py-2.5 rounded-xl bg-gradient-to-r from-[#C59B6C] to-[#D8AA73] text-[#140F0C] text-xs font-bold tracking-wide transition flex items-center justify-center gap-2">
                    <i class="fas fa-qrcode text-xs"></i>
                    <span>Lanjut Bayar QRIS</span>
                </button>
            </div>
        </div>

        <!-- 2. QRIS DINAMIS MODAL -->
        <div id="appQrisModal" class="absolute inset-0 bg-black/85 backdrop-blur-md hidden items-center justify-center p-4 z-50">
            <div class="bg-[#1C1612] rounded-3xl border border-[#C59B6C]/40 p-5 text-center w-full max-w-[320px] shadow-2xl relative">
                <button onclick="closeAppQrisModal()" class="absolute top-3 right-3 w-7 h-7 rounded-full bg-white/10 text-white flex items-center justify-center text-xs">
                    <i class="fas fa-times"></i>
                </button>

                <div class="flex items-center justify-between pb-2 mb-3 border-b border-white/10">
                    <div class="text-left">
                        <span class="text-[8px] uppercase tracking-wider text-[#D8AA73] font-bold">QRIS Pembayaran Meja</span>
                        <h4 class="font-serif font-bold text-xs text-white">{{ $brandName }}</h4>
                    </div>
                    <span class="px-2 py-0.5 rounded text-[9px] font-bold bg-white text-slate-900">QRIS</span>
                </div>

                <!-- QR Graphic -->
                <div class="bg-white p-3 rounded-2xl inline-block shadow-lg relative my-1">
                    <div id="appQrisGraphic"></div>
                    <div class="absolute inset-0 flex items-center justify-center pointer-events-none">
                        <div class="w-7 h-7 bg-[#140F0C] rounded-lg border border-white flex items-center justify-center">
                            <i class="fas fa-coffee text-[#D8AA73] text-[10px]"></i>
                        </div>
                    </div>
                </div>

                <div class="mt-3">
                    <p class="text-[10px] text-white/60">Total Bayar:</p>
                    <p class="text-xl font-bold font-mono text-[#D8AA73]" id="appQrisAmount">Rp 0</p>
                    <p class="text-[9px] text-white/50 mt-1">BCA, Mandiri, GoPay, OVO, Dana, ShopeePay</p>
                    <p class="text-[9px] font-mono text-amber-300 mt-1">Berlaku: <span id="appQrisTimer">04:59</span></p>
                </div>

                <div class="mt-4 pt-3 border-t border-white/10 space-y-2">
                    <button onclick="simulateAppPaymentSuccess()" class="shimmer-btn w-full py-2.5 rounded-xl bg-gradient-to-r from-emerald-500 to-teal-500 text-white text-xs font-bold tracking-wide transition flex items-center justify-center gap-1.5 shadow-md">
                        <i class="fas fa-circle-check text-xs"></i>
                        <span>Simulasi Scan Lunas</span>
                    </button>
                    <p class="text-[8px] text-white/40">Klik tombol di atas untuk mensimulasikan lunas instan.</p>
                </div>
            </div>
        </div>

        <!-- 3. STRUK NOTA THERMAL MODAL -->
        <div id="appReceiptModal" class="absolute inset-0 bg-black/85 backdrop-blur-md hidden items-center justify-center p-4 z-50">
            <div class="bg-white text-gray-900 rounded-2xl p-5 w-full max-w-[320px] shadow-2xl relative font-mono text-xs max-h-[90%] overflow-y-auto no-scrollbar">
                <button onclick="closeAppReceiptModal()" class="absolute top-3 right-3 text-gray-400 hover:text-gray-900 text-sm">
                    <i class="fas fa-times"></i>
                </button>

                <div class="text-center border-b border-dashed border-gray-400 pb-2 mb-2">
                    <h5 class="font-serif font-bold text-sm text-black uppercase">{{ $brandName }}</h5>
                    <p class="text-[9px] text-gray-600">Specialty Coffee & Roastery</p>
                    <p class="text-[9px] text-gray-500">Jakarta Selatan • {{ $cleanWa }}</p>
                </div>

                <div class="border-b border-dashed border-gray-400 pb-2 mb-2 text-[9px] space-y-0.5">
                    <div class="flex justify-between">
                        <span>No:</span> <span class="font-bold" id="appRecId">#CF-8921</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Meja:</span> <span class="font-bold" id="appRecTable">Meja 04</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Pelanggan:</span> <span id="appRecMember">Sarah (Gold VIP)</span>
                    </div>
                </div>

                <div class="border-b border-dashed border-gray-400 pb-2 mb-2 space-y-1 text-[10px]" id="appRecItems">
                    <!-- Dynamic -->
                </div>

                <div class="space-y-1 text-[10px]">
                    <div class="flex justify-between">
                        <span>Subtotal:</span> <span id="appRecSubtotal">Rp 0</span>
                    </div>
                    <div class="flex justify-between text-amber-700">
                        <span>Diskon:</span> <span id="appRecDiscount">- Rp 0</span>
                    </div>
                    <div class="flex justify-between">
                        <span>PB1 (10%):</span> <span id="appRecTax">Rp 0</span>
                    </div>
                    <div class="flex justify-between text-xs font-bold border-t border-dashed border-gray-400 pt-1">
                        <span>LUNAS (QRIS):</span> <span id="appRecTotal">Rp 0</span>
                    </div>
                </div>

                <div class="bg-gray-100 p-2 rounded text-center my-3 text-[9px]">
                    <p class="font-bold text-gray-800">🎉 Poin Bertambah +<span id="appRecEarnedPts">110</span> Pts</p>
                </div>

                <div class="flex gap-2 pt-2 border-t font-sans">
                    <button onclick="window.print()" class="w-1/2 py-2 rounded-lg bg-gray-900 text-white text-[10px] font-bold">
                        <i class="fas fa-print mr-1"></i> Cetak
                    </button>
                    <button onclick="shareAppReceiptWhatsApp()" class="w-1/2 py-2 rounded-lg bg-emerald-600 text-white text-[10px] font-bold">
                        <i class="fab fa-whatsapp mr-1"></i> Kirim WA
                    </button>
                </div>
            </div>
        </div>

    </main>

    <!-- ================= JS ENGINE ================= -->
    <script>
        const db = @json($cafeDatabase);
        
        let sampleMembers = [
            { phone: "081234567890", name: "Sarah Anggraini", tier: "Gold VIP", discount: 10, points: 2450 },
            { phone: "087788991122", name: "Dimas Prasetyo", tier: "Platinum Club", discount: 15, points: 5120 },
            { phone: "085612345678", name: "Jessica Amanda", tier: "Silver Member", discount: 5, points: 850 }
        ];

        let currentTableIdx = 0;
        let activeCategory = 'all';
        let currentMember = sampleMembers[0];
        let appCart = [
            { id: "CF-01", name: "Caramel Macchiato Reserve", price: 38000, qty: 1 },
            { id: "CF-08", name: "French Butter Croissant", price: 28000, qty: 1 }
        ];
        let orderHistory = [
            { id: "#CF-9081", table: "Meja 04", items: "2x Caramel Macchiato, 1x Truffle Fries", total: 111000, status: "Lunas (QRIS)" }
        ];
        let qrisTimerInterval = null;

        function formatRp(num) {
            return 'Rp ' + Number(num).toLocaleString('id-ID');
        }

        // Live Clock
        function updateAppClock() {
            const now = new Date();
            const h = String(now.getHours()).padStart(2, '0');
            const m = String(now.getMinutes()).padStart(2, '0');
            const el = document.getElementById('statusBarClock');
            if (el) el.innerText = `${h}:${m}`;
        }
        setInterval(updateAppClock, 1000);
        updateAppClock();

        // Switch Tabs
        function switchAppTab(tabName) {
            playBeep(650, 0.04);
            const views = ['viewMenu', 'viewMember', 'viewOrders', 'viewPos'];
            const btns = ['tabBtnMenu', 'tabBtnMember', 'tabBtnOrders', 'tabBtnPos'];

            views.forEach(v => {
                const el = document.getElementById(v);
                if (el) {
                    el.classList.add('hidden');
                    el.classList.remove('flex');
                }
            });

            btns.forEach(b => {
                const el = document.getElementById(b);
                if (el) {
                    el.classList.remove('text-[#D8AA73]');
                    el.classList.add('text-white/50');
                }
            });

            if (tabName === 'menu') {
                document.getElementById('viewMenu').classList.remove('hidden');
                document.getElementById('viewMenu').classList.add('flex');
                document.getElementById('tabBtnMenu').classList.add('text-[#D8AA73]');
                document.getElementById('tabBtnMenu').classList.remove('text-white/50');
            } else if (tabName === 'member') {
                document.getElementById('viewMember').classList.remove('hidden');
                document.getElementById('viewMember').classList.add('flex');
                document.getElementById('tabBtnMember').classList.add('text-[#D8AA73]');
                document.getElementById('tabBtnMember').classList.remove('text-white/50');
            } else if (tabName === 'orders') {
                document.getElementById('viewOrders').classList.remove('hidden');
                document.getElementById('viewOrders').classList.add('flex');
                document.getElementById('tabBtnOrders').classList.add('text-[#D8AA73]');
                document.getElementById('tabBtnOrders').classList.remove('text-white/50');
            } else if (tabName === 'pos') {
                document.getElementById('viewPos').classList.remove('hidden');
                document.getElementById('viewPos').classList.add('flex');
                document.getElementById('tabBtnPos').classList.add('text-[#D8AA73]');
                document.getElementById('tabBtnPos').classList.remove('text-white/50');
            }
        }

        // Table Cycler
        function cycleTable() {
            playBeep(700, 0.04);
            const tables = db.tables || [];
            currentTableIdx = (currentTableIdx + 1) % tables.length;
            const t = tables[currentTableIdx];
            document.getElementById('appTableLabel').innerText = `${t.name} (${t.area})`;
        }

        // Category Rendering
        function renderCategories() {
            const container = document.getElementById('appCategoryTabs');
            let html = '';
            (db.categories || []).forEach(cat => {
                const isActive = activeCategory === cat.id;
                const cls = isActive ? 'bg-[#C59B6C] text-[#140F0C] font-bold shadow-md' : 'bg-white/5 text-white/70 hover:bg-white/10';
                html += `
                    <button onclick="setAppCategory('${cat.id}')" class="whitespace-nowrap px-3.5 py-1.5 rounded-full text-xs font-medium transition ${cls}">
                        <span>${cat.name}</span>
                    </button>
                `;
            });
            container.innerHTML = html;
        }

        function setAppCategory(catId) {
            playBeep(600, 0.04);
            activeCategory = catId;
            renderCategories();
            renderProducts();
        }

        function filterAppProducts(val) {
            renderProducts(val.toLowerCase().trim());
        }

        // Products Rendering
        function renderProducts(search = '') {
            const container = document.getElementById('appProductGrid');
            const menu = db.menu || [];
            const filtered = menu.filter(item => {
                const matchCat = activeCategory === 'all' || item.category === activeCategory;
                const matchSearch = !search || item.name.toLowerCase().includes(search) || item.description.toLowerCase().includes(search);
                return matchCat && matchSearch;
            });

            document.getElementById('appProductCount').innerText = `${filtered.length} Menu`;

            let html = '';
            filtered.forEach(item => {
                html += `
                    <div class="bg-[#1C1612] rounded-2xl border border-white/5 overflow-hidden flex flex-col justify-between group shadow-md hover:border-[#C59B6C]/40 transition">
                        <div class="relative h-28 overflow-hidden">
                            <img src="${item.image}" alt="${item.name}" loading="lazy" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                            <span class="absolute top-2 left-2 px-1.5 py-0.5 rounded text-[8px] font-bold bg-black/75 text-[#D8AA73]">
                                ${item.badge}
                            </span>
                        </div>
                        <div class="p-2.5 flex flex-col justify-between flex-grow">
                            <div>
                                <h5 class="text-xs font-bold text-white line-clamp-1">${item.name}</h5>
                                <p class="text-[9px] text-white/50 line-clamp-2 mt-0.5">${item.description}</p>
                            </div>
                            <div class="flex items-center justify-between mt-2 pt-2 border-t border-white/5">
                                <span class="font-mono text-xs font-bold text-[#D8AA73]">${formatRp(item.price)}</span>
                                <button onclick="addToCart('${item.id}')" class="px-2 py-0.5 rounded-md bg-[#C59B6C] text-[#140F0C] font-bold text-xs transition active:scale-90">
                                    + Tambah
                                </button>
                            </div>
                        </div>
                    </div>
                `;
            });
            container.innerHTML = html || `<p class="col-span-2 text-center text-xs text-white/40 py-8">Menu tidak ditemukan</p>`;
        }

        // Cart Actions
        function addToCart(productId) {
            playBeep(880, 0.08, 'triangle');
            const item = (db.menu || []).find(m => m.id === productId);
            if (!item) return;

            const exist = appCart.find(c => c.id === productId);
            if (exist) {
                exist.qty += 1;
            } else {
                appCart.push({ id: item.id, name: item.name, price: item.price, qty: 1 });
            }
            renderCart();
        }

        function updateQty(idx, change) {
            playBeep(700, 0.03);
            appCart[idx].qty += change;
            if (appCart[idx].qty <= 0) {
                appCart.splice(idx, 1);
            }
            renderCart();
        }

        function calcBill() {
            const subtotal = appCart.reduce((sum, i) => sum + (i.price * i.qty), 0);
            const discountRate = currentMember ? currentMember.discount : 0;
            const discountAmount = Math.round(subtotal * (discountRate / 100));
            const afterDisc = subtotal - discountAmount;
            const tax = Math.round(afterDisc * 0.10);
            const grandTotal = afterDisc + tax;
            const totalQty = appCart.reduce((sum, i) => sum + i.qty, 0);

            return { subtotal, discountRate, discountAmount, tax, grandTotal, totalQty };
        }

        function renderCart() {
            const { subtotal, discountRate, discountAmount, tax, grandTotal, totalQty } = calcBill();

            // Floating bar
            const floatingBar = document.getElementById('appFloatingCart');
            if (totalQty > 0) {
                floatingBar.classList.remove('translate-y-24', 'opacity-0', 'pointer-events-none');
            } else {
                floatingBar.classList.add('translate-y-24', 'opacity-0', 'pointer-events-none');
            }

            document.getElementById('appCartBadge').innerText = totalQty;
            document.getElementById('appCartTotal').innerText = formatRp(grandTotal);

            // Sheet container
            const container = document.getElementById('appCartItemsContainer');
            if (appCart.length === 0) {
                container.innerHTML = `<p class="text-center text-xs text-white/40 py-6">Keranjang kosong</p>`;
            } else {
                let html = '';
                appCart.forEach((item, idx) => {
                    html += `
                        <div class="bg-[#140F0C] p-2.5 rounded-xl border border-white/5 flex items-center justify-between text-xs">
                            <div>
                                <p class="font-bold text-white line-clamp-1">${item.name}</p>
                                <p class="text-[10px] text-[#D8AA73] font-mono">${formatRp(item.price)} x ${item.qty}</p>
                            </div>
                            <div class="flex items-center gap-2">
                                <button onclick="updateQty(${idx}, -1)" class="w-6 h-6 rounded bg-white/10 text-white flex items-center justify-center">-</button>
                                <span class="font-bold font-mono text-white text-xs w-4 text-center">${item.qty}</span>
                                <button onclick="updateQty(${idx}, 1)" class="w-6 h-6 rounded bg-[#C59B6C] text-[#140F0C] flex items-center justify-center font-bold">+</button>
                            </div>
                        </div>
                    `;
                });
                container.innerHTML = html;
            }

            document.getElementById('appSubtotal').innerText = formatRp(subtotal);
            document.getElementById('appDiscountRate').innerText = `${discountRate}%`;
            document.getElementById('appDiscountAmount').innerText = `- ${formatRp(discountAmount)}`;
            document.getElementById('appTaxAmount').innerText = formatRp(tax);
            document.getElementById('appGrandTotal').innerText = formatRp(grandTotal);
        }

        function openAppCartSheet() {
            playBeep(650, 0.04);
            document.getElementById('appCartSheet').classList.remove('hidden');
            document.getElementById('appCartSheet').classList.add('flex');
        }

        function closeAppCartSheet() {
            document.getElementById('appCartSheet').classList.add('hidden');
            document.getElementById('appCartSheet').classList.remove('flex');
        }

        // QRIS Checkout
        function openAppCheckoutModal() {
            if (appCart.length === 0) {
                alert('Pilih minimal 1 menu kopi atau makanan.');
                return;
            }
            playBeep(800, 0.05);
            const { grandTotal } = calcBill();
            document.getElementById('appQrisAmount').innerText = formatRp(grandTotal);

            // Generate QR Graphic
            const container = document.getElementById('appQrisGraphic');
            container.innerHTML = '';
            new QRCode(container, {
                text: `00020101021226590014ID.LINKAJA.WWW01189360099900000000000215ID202688921004151440014ID.CO.QRIS.WWW0215ID20268892100415204581253033605406${grandTotal}5802ID5914{{ strtoupper($brandName) }}6007JAKARTA6304`,
                width: 150,
                height: 150,
                colorDark: "#140F0C",
                colorLight: "#FFFFFF",
                correctLevel: QRCode.CorrectLevel.M
            });

            startAppQrisTimer();
            document.getElementById('appQrisModal').classList.remove('hidden');
            document.getElementById('appQrisModal').classList.add('flex');
        }

        function closeAppQrisModal() {
            clearInterval(qrisTimerInterval);
            document.getElementById('appQrisModal').classList.add('hidden');
            document.getElementById('appQrisModal').classList.remove('flex');
        }

        function startAppQrisTimer() {
            clearInterval(qrisTimerInterval);
            let sec = 299;
            const timerEl = document.getElementById('appQrisTimer');
            qrisTimerInterval = setInterval(() => {
                const m = String(Math.floor(sec / 60)).padStart(2, '0');
                const s = String(sec % 60).padStart(2, '0');
                timerEl.innerText = `${m}:${s}`;
                sec--;
                if (sec < 0) clearInterval(qrisTimerInterval);
            }, 1000);
        }

        function simulateAppPaymentSuccess() {
            closeAppQrisModal();
            playSuccessSound();
            confetti({ particleCount: 70, spread: 60, origin: { y: 0.6 } });

            const { subtotal, discountAmount, tax, grandTotal } = calcBill();
            const tables = db.tables || [];
            const tableName = tables[currentTableIdx] ? tables[currentTableIdx].name : 'Meja 04';
            const invId = '#CF-' + Math.floor(1000 + Math.random() * 9000);

            // Populate Receipt
            document.getElementById('appRecId').innerText = invId;
            document.getElementById('appRecTable').innerText = tableName;
            document.getElementById('appRecMember').innerText = currentMember ? `${currentMember.name} (${currentMember.tier})` : 'Tamu';
            document.getElementById('appRecSubtotal').innerText = formatRp(subtotal);
            document.getElementById('appRecDiscount').innerText = `- ${formatRp(discountAmount)}`;
            document.getElementById('appRecTax').innerText = formatRp(tax);
            document.getElementById('appRecTotal').innerText = formatRp(grandTotal);

            const earned = Math.round(grandTotal / 1000);
            document.getElementById('appRecEarnedPts').innerText = earned;
            if (currentMember) {
                currentMember.points += earned;
                syncMemberViews();
            }

            let rItems = '';
            appCart.forEach(i => {
                rItems += `<div class="flex justify-between"><span>${i.qty}x ${i.name}</span><span>${formatRp(i.price * i.qty)}</span></div>`;
            });
            document.getElementById('appRecItems').innerHTML = rItems;

            // Push to Order History
            orderHistory.unshift({
                id: invId,
                table: tableName,
                items: appCart.map(c => `${c.qty}x ${c.name}`).join(', '),
                total: grandTotal,
                status: 'Lunas (QRIS)'
            });
            renderOrderHistory();
            renderKitchenQueue();

            // Clear Cart
            appCart = [];
            renderCart();

            document.getElementById('appReceiptModal').classList.remove('hidden');
            document.getElementById('appReceiptModal').classList.add('flex');
        }

        function closeAppReceiptModal() {
            document.getElementById('appReceiptModal').classList.add('hidden');
            document.getElementById('appReceiptModal').classList.remove('flex');
        }

        function shareAppReceiptWhatsApp() {
            const inv = document.getElementById('appRecId').innerText;
            const tot = document.getElementById('appRecTotal').innerText;
            const text = encodeURIComponent(`*NOTA PEMBAYARAN {{ $brandName }}*\nNo: ${inv}\nTotal: ${tot} (LUNAS via QRIS)\n\nTerima kasih!`);
            window.open(`https://wa.me/?text=${text}`, '_blank');
        }

        // Member Synchronization
        function syncMemberViews() {
            if (!currentMember) return;
            document.getElementById('appMemberName').innerText = currentMember.name;
            document.getElementById('appMemberTier').innerText = currentMember.tier.toUpperCase();
            document.getElementById('appMemberPts').innerText = Number(currentMember.points).toLocaleString('id-ID');

            document.getElementById('cardMemberName').innerText = currentMember.name;
            document.getElementById('cardMemberTier').innerText = `${currentMember.tier.toUpperCase()} (Diskon ${currentMember.discount}%)`;
            document.getElementById('cardMemberPoints').innerText = `${Number(currentMember.points).toLocaleString('id-ID')} Pts`;

            renderMemberList();
        }

        function renderMemberList() {
            const container = document.getElementById('appMemberList');
            let html = '';
            sampleMembers.forEach((m, idx) => {
                const isSel = currentMember && currentMember.phone === m.phone;
                html += `
                    <div onclick="selectMember(${idx})" class="p-2 rounded-xl flex items-center justify-between cursor-pointer transition ${isSel ? 'bg-[#C59B6C] text-[#140F0C] font-bold' : 'bg-white/5 text-white/80 hover:bg-white/10'}">
                        <div>
                            <p class="text-xs font-bold leading-tight">${m.name}</p>
                            <p class="text-[9px] opacity-75 font-mono">${m.phone} • ${m.tier}</p>
                        </div>
                        <span class="text-xs font-bold font-mono">${m.points} Pts</span>
                    </div>
                `;
            });
            container.innerHTML = html;
        }

        function selectMember(idx) {
            playBeep(700, 0.04);
            currentMember = sampleMembers[idx];
            syncMemberViews();
            renderCart();
        }

        function handleAppNewMember() {
            const name = document.getElementById('appNewName').value.trim();
            const phone = document.getElementById('appNewPhone').value.trim();
            if (!name || !phone) {
                alert('Isi nama dan nomor WhatsApp.');
                return;
            }
            playSuccessSound();
            const newM = { phone, name, tier: "Silver Member", discount: 5, points: 100 };
            sampleMembers.unshift(newM);
            currentMember = newM;
            syncMemberViews();
            renderCart();
            alert(`Member ${name} berhasil didaftarkan dan mendapatkan 100 Poin perdana!`);
            document.getElementById('appNewName').value = '';
            document.getElementById('appNewPhone').value = '';
        }

        // Order History View
        function renderOrderHistory() {
            const container = document.getElementById('appOrderHistoryList');
            let html = '';
            orderHistory.forEach(o => {
                html += `
                    <div class="bg-[#1C1612] p-3 rounded-2xl border border-white/5 text-xs">
                        <div class="flex items-center justify-between mb-1">
                            <span class="font-bold text-[#D8AA73] font-mono">${o.id}</span>
                            <span class="px-2 py-0.5 rounded text-[8px] font-bold bg-emerald-500/20 text-emerald-400 border border-emerald-500/30">${o.status}</span>
                        </div>
                        <p class="font-bold text-white">${o.table}</p>
                        <p class="text-[10px] text-white/50 line-clamp-1 mt-0.5">${o.items}</p>
                        <div class="flex items-center justify-between mt-2 pt-2 border-t border-white/5 font-mono">
                            <span class="text-[10px] text-white/40">Total</span>
                            <span class="font-bold text-white">${formatRp(o.total)}</span>
                        </div>
                    </div>
                `;
            });
            container.innerHTML = html || `<p class="text-center text-xs text-white/40 py-8">Belum ada riwayat pesanan</p>`;
        }

        function resetAppOrders() {
            orderHistory = [];
            renderOrderHistory();
            renderKitchenQueue();
        }

        // Kitchen Queue in POS view
        function renderKitchenQueue() {
            const container = document.getElementById('appKitchenQueue');
            let html = '';
            orderHistory.slice(0, 4).forEach(o => {
                html += `
                    <div class="bg-[#140F0C] p-2.5 rounded-xl border border-white/5 text-xs">
                        <div class="flex items-center justify-between">
                            <span class="font-bold text-white">${o.table}</span>
                            <span class="font-mono text-[#D8AA73] font-bold">${formatRp(o.total)}</span>
                        </div>
                        <p class="text-[10px] text-white/60 line-clamp-1 mt-0.5">${o.items}</p>
                    </div>
                `;
            });
            container.innerHTML = html || `<p class="text-center text-xs text-white/40 py-4">Antrean kosong</p>`;
        }

        // Master Init
        window.addEventListener('DOMContentLoaded', () => {
            renderCategories();
            renderProducts();
            renderCart();
            syncMemberViews();
            renderOrderHistory();
            renderKitchenQueue();
        });
    </script>
</body>
</html>
