<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Premium Fragrance - {{ $client->brand_name }}</title>
    <meta name="description" content="Koleksi parfum mewah dan tahan lama dari {{ $client->brand_name }}.">

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            gold: '#D4AF37', // Luxury Gold
                            dark: '#0a0a0a', // Deep Black
                            light: '#fcfcfc', // Off-white
                            gray: '#888888', // Subtle Gray
                            border: '#333333'
                        }
                    }
                    , fontFamily: {
                        sans: ['Optima', 'Segoe UI', 'sans-serif']
                        , serif: ['Playfair Display', 'Georgia', 'serif']
                    , }
                }
            }
        }

    </script>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body {
            background-color: #0a0a0a;
            color: #fcfcfc;
            font-family: 'Optima', 'Segoe UI', sans-serif;
        }

        h1,
        h2,
        h3,
        .font-serif {
            font-family: 'Playfair Display', serif;
        }

        .glass-panel {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .hide-scrollbar::-webkit-scrollbar {
            display: none;
        }

        /* Tour Overlay Styles */
        #tour-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.85);
            z-index: 9998;
            display: none;
        }

        .tour-highlight {
            position: relative;
            z-index: 9999 !important;
            box-shadow: 0 0 0 4px rgba(212, 175, 55, 0.6);
            border-radius: 0.5rem;
            background-color: #111;
            pointer-events: none;
        }

        #tour-tooltip {
            position: absolute;
            z-index: 10000;
            background: #1a1a1a;
            border: 1px solid #D4AF37;
            padding: 1.5rem;
            border-radius: 0.5rem;
            width: 320px;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.5);
            display: none;
            transition: all 0.3s ease;
        }

    </style>
</head>
<body class="antialiased pb-20 selection:bg-brand-gold selection:text-black">

    <!-- Top Navbar -->
    <nav class="bg-brand-dark/90 backdrop-blur-md border-b border-brand-border py-4 px-6 md:px-12 flex justify-between items-center sticky top-0 z-50 transition-all duration-300">
        <div class="flex items-center gap-3">
            <h1 class="font-serif font-bold text-brand-light text-2xl tracking-widest uppercase">{{ $client->brand_name }}</h1>
        </div>

        <div class="hidden lg:flex items-center gap-8 text-[12px] font-medium text-gray-300 tracking-widest uppercase">
            <a href="#" class="text-brand-gold pb-1">Boutique</a>
            <a href="#discovery" class="hover:text-brand-gold transition">Discovery Set</a>
            <a href="#scent-profile" class="hover:text-brand-gold transition">Scent Profile</a>
            <a href="#reseller" class="hover:text-brand-gold transition">Become a Partner</a>
        </div>

        <div class="hidden lg:flex items-center gap-6 text-[13px]">
            <a href="javascript:void(0)" onclick="openMemberModal()" class="text-gray-300 hover:text-brand-gold transition"><i class="far fa-user text-lg"></i></a>
            <a href="javascript:void(0)" onclick="openCartModal()" class="text-gray-300 hover:text-brand-gold transition relative">
                <i class="fas fa-shopping-bag text-lg"></i>
                <span id="cart-badge" class="absolute -top-1.5 -right-2 bg-brand-gold text-black text-[9px] font-bold px-1.5 py-0.5 rounded-full">2</span>
            </a>
            <a href="{{ route('proposal.dynamic', $client->slug) }}" class="border border-brand-gold text-brand-gold hover:bg-brand-gold hover:text-black px-5 py-2 rounded-sm font-medium transition tracking-wider text-[11px] uppercase ml-4">
                View Proposal
            </a>
        </div>
    </nav>

    <!-- Floating Admin Demo Button -->
    <a href="{{ route('demo.admin.parfum', $client->slug) ?? '#' }}" class="fixed bottom-6 right-6 z-[100] bg-brand-gold text-black hover:bg-yellow-500 px-5 py-3 rounded-full shadow-[0_0_20px_rgba(212,175,55,0.4)] flex items-center gap-3 transform hover:scale-105 transition-all group animate-bounce">
        <div class="w-8 h-8 rounded-full bg-black/10 flex items-center justify-center"><i class="fas fa-tachometer-alt"></i></div>
        <div class="flex flex-col">
            <span class="text-[9px] font-bold uppercase tracking-widest leading-none mb-1 opacity-80">Simulasi Backend</span>
            <span class="leading-none text-[13px] font-bold">Dashboard Admin & POS</span>
        </div>
    </a>

    <!-- Floating Tour Button -->
    <button onclick="startTour()" class="fixed bottom-24 right-6 z-[100] bg-black border border-brand-gold text-brand-gold hover:bg-brand-gold hover:text-black px-5 py-2.5 rounded-full shadow-lg text-[12px] font-bold tracking-wider uppercase transition-all flex items-center gap-2">
        <i class="fas fa-play"></i> Tour Fitur Website
    </button>

    <!-- Hero Section -->
    <section class="relative h-[90vh] flex items-center justify-center overflow-hidden border-b border-brand-border">
        <!-- Background Video/Image Simulator -->
        <div class="absolute inset-0 z-0">
            <img src="https://images.unsplash.com/photo-1594035910387-fea47794261f?auto=format&fit=crop&q=80&w=2000" alt="Luxury Perfume" class="w-full h-full object-cover opacity-40">
            <div class="absolute inset-0 bg-gradient-to-t from-brand-dark via-transparent to-brand-dark"></div>
            <div class="absolute inset-0 bg-black/30"></div>
        </div>

        <div class="relative z-10 text-center px-4 max-w-4xl mx-auto mt-16">
            <span class="text-brand-gold text-[11px] tracking-[0.3em] uppercase mb-4 block font-semibold">The New Collection</span>
            <h1 class="text-5xl md:text-7xl font-serif text-white mb-6 leading-tight">
                Embody Your <br><i class="text-brand-gold">Signature</i> Scent
            </h1>
            <p class="text-gray-300 text-sm md:text-base max-w-2xl mx-auto mb-10 leading-relaxed font-light">
                Crafted by master perfumers. Extrait de Parfum with 24-hour longevity and mesmerizing sillage. Discover the art of fine fragrance.
            </p>

            <div class="flex flex-col sm:flex-row justify-center gap-4" id="tour-hero-cta">
                <button class="bg-brand-gold text-black px-8 py-3.5 rounded-sm text-[12px] font-bold tracking-widest uppercase hover:bg-white transition shadow-[0_0_15px_rgba(212,175,55,0.3)]">
                    Shop Collection
                </button>
                <button onclick="openQuizModal()" class="glass-panel text-white border border-gray-500 px-8 py-3.5 rounded-sm text-[12px] font-bold tracking-widest uppercase hover:bg-white/10 transition flex items-center justify-center gap-2" id="tour-quiz">
                    <i class="fas fa-search-plus text-brand-gold"></i> Find Your Scent
                </button>
            </div>
        </div>
    </section>

    <!-- Fragrance Finder Quiz Modal (Simulated) -->
    <div id="quizModal" class="fixed inset-0 z-[150] bg-black/80 backdrop-blur-md hidden items-center justify-center p-4 transition-all">
        <div class="bg-[#111] border border-brand-border w-full max-w-xl rounded-lg shadow-2xl flex flex-col relative overflow-hidden">
            <button onclick="closeQuizModal()" class="absolute top-4 right-4 text-gray-400 hover:text-white z-10"><i class="fas fa-times text-xl"></i></button>

            <div class="p-10 text-center">
                <span class="text-brand-gold text-[10px] tracking-widest uppercase mb-2 block">Fragrance Finder</span>
                <h3 class="font-serif text-2xl text-white mb-8">What is the occasion?</h3>

                <div class="grid grid-cols-2 gap-4">
                    <div class="border border-brand-border hover:border-brand-gold bg-black p-6 rounded cursor-pointer transition group">
                        <i class="fas fa-briefcase text-2xl text-gray-500 group-hover:text-brand-gold mb-3 transition"></i>
                        <h4 class="text-white text-sm font-semibold tracking-wide">Office / Daily Wear</h4>
                        <p class="text-gray-500 text-[11px] mt-2">Fresh, subtle, non-offensive</p>
                    </div>
                    <div class="border border-brand-gold bg-brand-gold/10 p-6 rounded cursor-pointer transition group relative overflow-hidden">
                        <div class="absolute top-2 right-2 w-3 h-3 bg-brand-gold rounded-full"></div>
                        <i class="fas fa-glass-cheers text-2xl text-brand-gold mb-3"></i>
                        <h4 class="text-white text-sm font-semibold tracking-wide">Night Out / Date</h4>
                        <p class="text-gray-400 text-[11px] mt-2">Seductive, sweet, bold</p>
                    </div>
                </div>

                <div class="mt-8 flex justify-between items-center border-t border-brand-border pt-6">
                    <div class="flex gap-1">
                        <div class="w-8 h-1 bg-brand-gold rounded"></div>
                        <div class="w-8 h-1 bg-gray-800 rounded"></div>
                        <div class="w-8 h-1 bg-gray-800 rounded"></div>
                    </div>
                    <button class="bg-white text-black px-6 py-2 rounded-sm text-[11px] font-bold tracking-widest uppercase hover:bg-brand-gold transition">
                        Next Question <i class="fas fa-arrow-right ml-2"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Discovery Set Push (Solusi Blind Buy) -->
    <section id="discovery" class="py-24 px-6 md:px-12 max-w-7xl mx-auto border-b border-brand-border" id="tour-discovery">
        <div class="flex flex-col lg:flex-row items-center gap-12">
            <div class="w-full lg:w-1/2 relative group">
                <div class="absolute inset-0 bg-brand-gold rounded-full blur-[100px] opacity-20 group-hover:opacity-30 transition duration-700"></div>
                <img src="https://images.unsplash.com/photo-1615634260167-c8cdede054de?auto=format&fit=crop&q=80&w=800" class="relative z-10 w-full rounded-sm object-cover h-[500px] border border-brand-border">

                <!-- Overlay Label -->
                <div class="absolute bottom-6 left-6 z-20 glass-panel p-4 rounded-sm border-l-2 border-brand-gold">
                    <p class="text-white font-serif text-lg">The Discovery Set</p>
                    <p class="text-gray-300 text-[11px] uppercase tracking-widest">5 x 3ml Vials</p>
                </div>
            </div>

            <div class="w-full lg:w-1/2">
                <span class="text-brand-gold text-[11px] tracking-widest uppercase mb-3 block"><i class="fas fa-star mr-1"></i> Best Seller Strategy</span>
                <h2 class="font-serif text-3xl md:text-5xl text-white mb-6 leading-tight">Solusi Sempurna untuk <br><span class="italic text-gray-400">Blind Buy</span></h2>
                <p class="text-gray-400 text-sm leading-relaxed mb-8">
                    Ragu wangi mana yang cocok dengan *chemistry* tubuh Anda? Cobalah kelima varian *best seller* kami sebelum membeli botol penuh. Ini adalah strategi andalan untuk meyakinkan pelanggan baru dan meningkatkan konversi penjualan.
                </p>

                <ul class="space-y-4 mb-10">
                    <li class="flex items-center gap-4 text-sm text-gray-300">
                        <i class="fas fa-check text-brand-gold"></i> Termasuk voucher diskon senilai harga Discovery Set untuk pembelian Full Bottle.
                    </li>
                    <li class="flex items-center gap-4 text-sm text-gray-300">
                        <i class="fas fa-check text-brand-gold"></i> 5 varian berbeda (Fresh, Woody, Floral, Sweet, Spicy).
                    </li>
                    <li class="flex items-center gap-4 text-sm text-gray-300">
                        <i class="fas fa-check text-brand-gold"></i> Ukuran praktis untuk dibawa bepergian (Travel Size).
                    </li>
                </ul>

                <button onclick="addToCart('Discovery Set', 150000)" class="bg-brand-gold text-black px-8 py-3 rounded-sm text-[12px] font-bold tracking-widest uppercase hover:bg-white transition flex items-center justify-center w-full sm:w-auto">
                    Beli Discovery Set - Rp 150.000
                </button>
            </div>
        </div>
    </section>

    <!-- Scent Profile Catalog (Fitur Krusial) -->
    <section id="scent-profile" class="py-24 px-6 md:px-12 max-w-7xl mx-auto">
        <div class="text-center mb-16">
            <span class="text-brand-gold text-[11px] tracking-[0.3em] uppercase mb-4 block font-semibold">The Collection</span>
            <h2 class="font-serif text-4xl text-white mb-4">Extrait de Parfum</h2>
            <p class="text-gray-400 max-w-2xl mx-auto text-sm">Konsentrasi tertinggi untuk ketahanan wangian lebih dari 12 jam di kulit, dan berhari-hari di pakaian.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- Product 1 -->
            <div class="group cursor-pointer" id="tour-scent-profile">
                <div class="relative bg-[#111] aspect-[4/5] flex items-center justify-center mb-6 overflow-hidden rounded-sm border border-brand-border">
                    <div class="absolute inset-0 bg-black/20 group-hover:bg-transparent transition-all z-10"></div>
                    <img src="https://images.unsplash.com/photo-1590736969955-71cc94801759?auto=format&fit=crop&q=80&w=600" class="object-cover h-full w-full transform group-hover:scale-105 transition duration-700">

                    <!-- Quick Add Hover -->
                    <div class="absolute bottom-0 left-0 w-full p-4 transform translate-y-full group-hover:translate-y-0 transition duration-300 z-20">
                        <button onclick="addToCart('Midnight Enigma (50ml)', 450000)" class="w-full bg-white text-black py-3 text-[11px] font-bold uppercase tracking-widest hover:bg-brand-gold transition">
                            Add to Cart
                        </button>
                    </div>
                </div>

                <div class="text-center">
                    <h3 class="font-serif text-xl text-white mb-1">Midnight Enigma</h3>
                    <p class="text-brand-gold text-[10px] tracking-widest uppercase mb-3">Woody • Spicy • Dark</p>
                    <p class="text-gray-300 font-medium mb-4">Rp 450.000 <span class="text-gray-500 text-[10px] font-normal">/ 50ml</span></p>

                    <!-- Scent Profile Details (The crucial part) -->
                    <div class="border-t border-brand-border pt-4 text-[11px] text-gray-400 text-left space-y-2">
                        <div class="flex justify-between">
                            <span class="uppercase tracking-wider text-gray-500">Top:</span>
                            <span class="text-gray-300">Bergamot, Black Pepper</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="uppercase tracking-wider text-gray-500">Middle:</span>
                            <span class="text-gray-300">Tobacco, Cedarwood</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="uppercase tracking-wider text-gray-500">Base:</span>
                            <span class="text-gray-300">Vanilla, Leather, Oud</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Product 2 -->
            <div class="group cursor-pointer">
                <div class="relative bg-[#111] aspect-[4/5] flex items-center justify-center mb-6 overflow-hidden rounded-sm border border-brand-border">
                    <img src="https://images.unsplash.com/photo-1541643600914-78b084683601?auto=format&fit=crop&q=80&w=600" class="object-cover h-full w-full transform group-hover:scale-105 transition duration-700">
                    <div class="absolute bottom-0 left-0 w-full p-4 transform translate-y-full group-hover:translate-y-0 transition duration-300 z-20">
                        <button onclick="addToCart('Ethereal Bloom (50ml)', 450000)" class="w-full bg-white text-black py-3 text-[11px] font-bold uppercase tracking-widest hover:bg-brand-gold transition">
                            Add to Cart
                        </button>
                    </div>
                </div>

                <div class="text-center">
                    <h3 class="font-serif text-xl text-white mb-1">Ethereal Bloom</h3>
                    <p class="text-brand-gold text-[10px] tracking-widest uppercase mb-3">Floral • Sweet • Fresh</p>
                    <p class="text-gray-300 font-medium mb-4">Rp 450.000 <span class="text-gray-500 text-[10px] font-normal">/ 50ml</span></p>

                    <div class="border-t border-brand-border pt-4 text-[11px] text-gray-400 text-left space-y-2">
                        <div class="flex justify-between">
                            <span class="uppercase tracking-wider text-gray-500">Top:</span>
                            <span class="text-gray-300">Lychee, Pear</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="uppercase tracking-wider text-gray-500">Middle:</span>
                            <span class="text-gray-300">Turkish Rose, Peony</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="uppercase tracking-wider text-gray-500">Base:</span>
                            <span class="text-gray-300">White Musk, Cashmeran</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Product 3 -->
            <div class="group cursor-pointer">
                <div class="relative bg-[#111] aspect-[4/5] flex items-center justify-center mb-6 overflow-hidden rounded-sm border border-brand-border">
                    <div class="absolute top-4 right-4 bg-brand-gold text-black text-[9px] font-bold px-2 py-1 uppercase tracking-widest z-20">Best Seller</div>
                    <img src="https://images.unsplash.com/photo-1622618991746-fe6004db3a47?auto=format&fit=crop&q=80&w=600" class="object-cover h-full w-full transform group-hover:scale-105 transition duration-700">
                    <div class="absolute bottom-0 left-0 w-full p-4 transform translate-y-full group-hover:translate-y-0 transition duration-300 z-20">
                        <button onclick="addToCart('Oceanic Azure (50ml)', 420000)" class="w-full bg-white text-black py-3 text-[11px] font-bold uppercase tracking-widest hover:bg-brand-gold transition">
                            Add to Cart
                        </button>
                    </div>
                </div>

                <div class="text-center">
                    <h3 class="font-serif text-xl text-white mb-1">Oceanic Azure</h3>
                    <p class="text-brand-gold text-[10px] tracking-widest uppercase mb-3">Fresh • Aquatic • Citrus</p>
                    <p class="text-gray-300 font-medium mb-4">Rp 420.000 <span class="text-gray-500 text-[10px] font-normal">/ 50ml</span></p>

                    <div class="border-t border-brand-border pt-4 text-[11px] text-gray-400 text-left space-y-2">
                        <div class="flex justify-between">
                            <span class="uppercase tracking-wider text-gray-500">Top:</span>
                            <span class="text-gray-300">Sea Salt, Grapefruit</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="uppercase tracking-wider text-gray-500">Middle:</span>
                            <span class="text-gray-300">Sage, Seaweed</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="uppercase tracking-wider text-gray-500">Base:</span>
                            <span class="text-gray-300">Ambrette, Patchouli</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Social Proof / Reviews -->
    <section class="py-20 bg-[#0a0a0a] border-t border-b border-brand-border" id="tour-reviews">
        <div class="max-w-6xl mx-auto px-6">
            <h2 class="font-serif text-3xl text-center text-white mb-12">What They Say</h2>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="glass-panel p-6 rounded-sm">
                    <div class="flex text-brand-gold mb-4 text-xs">
                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                    </div>
                    <p class="text-gray-300 text-sm italic mb-6">"Longevity nya gila sih! Semprot jam 7 pagi buat ngantor, jam 6 sore pas pulang masih kecium banget projection-nya. Blind buy tersukses."</p>
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 bg-gray-800 rounded-full flex items-center justify-center text-xs text-gray-400">R</div>
                        <div>
                            <p class="text-white text-xs font-bold uppercase tracking-wider">Rangga D.</p>
                            <p class="text-brand-gold text-[10px]">Verified Buyer - Midnight Enigma</p>
                        </div>
                    </div>
                </div>

                <div class="glass-panel p-6 rounded-sm">
                    <div class="flex text-brand-gold mb-4 text-xs">
                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                    </div>
                    <p class="text-gray-300 text-sm italic mb-6">"Awalnya ragu beli parfum online. Tapi beli Discovery Set dulu, akhirnya jatuh cinta sama Ethereal Bloom. Wanginya mahal banget ga pasaran."</p>
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 bg-gray-800 rounded-full flex items-center justify-center text-xs text-gray-400">S</div>
                        <div>
                            <p class="text-white text-xs font-bold uppercase tracking-wider">Sarah M.</p>
                            <p class="text-brand-gold text-[10px]">Verified Buyer - Discovery Set</p>
                        </div>
                    </div>
                </div>

                <div class="glass-panel p-6 rounded-sm">
                    <div class="flex text-brand-gold mb-4 text-xs">
                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i>
                    </div>
                    <p class="text-gray-300 text-sm italic mb-6">"Sillage nya juara. Masuk ruangan meeting langsung ditanya pake parfum apa. Packagingnya juga niat banget buat kado."</p>
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 bg-gray-800 rounded-full flex items-center justify-center text-xs text-gray-400">A</div>
                        <div>
                            <p class="text-white text-xs font-bold uppercase tracking-wider">Aldi V.</p>
                            <p class="text-brand-gold text-[10px]">Verified Buyer - Oceanic Azure</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Reseller / Affiliate Section -->
    <section id="reseller" class="py-24 px-6 md:px-12 max-w-7xl mx-auto" id="tour-reseller">
        <div class="bg-gradient-to-br from-[#1a1a1a] to-[#0a0a0a] border border-brand-gold/30 rounded-lg p-8 md:p-12 relative overflow-hidden">
            <!-- Background element -->
            <div class="absolute -right-20 -bottom-20 opacity-5">
                <i class="fas fa-gem text-[300px]"></i>
            </div>

            <div class="relative z-10 flex flex-col md:flex-row items-center justify-between gap-10">
                <div class="w-full md:w-3/5">
                    <span class="text-brand-gold text-[11px] tracking-widest uppercase mb-2 block"><i class="fas fa-handshake mr-1"></i> B2B Partnership</span>
                    <h2 class="font-serif text-3xl md:text-4xl text-white mb-4">Tumbuh Bersama Kami</h2>
                    <p class="text-gray-400 text-sm mb-6 leading-relaxed">
                        Platform e-commerce kami dilengkapi dengan sistem Affiliate dan Reseller yang canggih. Bergabunglah menjadi mitra resmi {{ $client->brand_name }} dan nikmati kemudahan sistem dropship, laporan komisi real-time, dan margin keuntungan hingga 40%.
                    </p>

                    <div class="grid grid-cols-2 gap-4 mb-8">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded bg-brand-gold/10 border border-brand-gold/30 flex items-center justify-center text-brand-gold"><i class="fas fa-chart-line"></i></div>
                            <span class="text-white text-xs font-semibold">Real-time Dashboard</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded bg-brand-gold/10 border border-brand-gold/30 flex items-center justify-center text-brand-gold"><i class="fas fa-percentage"></i></div>
                            <span class="text-white text-xs font-semibold">Tiering Diskon Otomatis</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded bg-brand-gold/10 border border-brand-gold/30 flex items-center justify-center text-brand-gold"><i class="fas fa-box-open"></i></div>
                            <span class="text-white text-xs font-semibold">Dropship Support</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded bg-brand-gold/10 border border-brand-gold/30 flex items-center justify-center text-brand-gold"><i class="fas fa-gift"></i></div>
                            <span class="text-white text-xs font-semibold">Marketing Kit Disediakan</span>
                        </div>
                    </div>
                </div>

                <div class="w-full md:w-2/5 glass-panel p-6 rounded border-brand-border">
                    <h3 class="text-white font-serif text-xl mb-4 text-center">Daftar Kemitraan</h3>
                    <form class="space-y-4">
                        <div>
                            <input type="text" placeholder="Nama Lengkap" class="w-full bg-black border border-brand-border rounded px-4 py-3 text-sm text-white focus:border-brand-gold focus:outline-none transition">
                        </div>
                        <div>
                            <input type="tel" placeholder="Nomor WhatsApp" class="w-full bg-black border border-brand-border rounded px-4 py-3 text-sm text-white focus:border-brand-gold focus:outline-none transition">
                        </div>
                        <div>
                            <select class="w-full bg-black border border-brand-border rounded px-4 py-3 text-sm text-gray-400 focus:border-brand-gold focus:outline-none transition appearance-none">
                                <option>Pilih Tipe Kemitraan</option>
                                <option>Reseller (Stockist)</option>
                                <option>Affiliate / Dropshipper</option>
                            </select>
                        </div>
                        <button type="button" class="w-full bg-brand-gold text-black py-3 rounded text-[12px] font-bold tracking-widest uppercase hover:bg-white transition mt-2">
                            Kirim Pengajuan
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-black py-12 border-t border-brand-border text-center">
        <h2 class="font-serif text-2xl text-white tracking-widest uppercase mb-4">{{ $client->brand_name }}</h2>
        <p class="text-gray-500 text-xs mb-8">Elevating everyday moments through the art of fine perfumery.</p>
        <p class="text-gray-600 text-[10px]">&copy; 2026 {{ $client->brand_name }}. Web System designed by Scalify Intelligence.</p>
    </footer>

    <!-- Interactive Tour UI -->
    <div id="tour-overlay"></div>
    <div id="tour-tooltip" class="flex flex-col">
        <div class="flex items-center gap-2 mb-3">
            <div class="w-6 h-6 rounded-full bg-brand-gold text-black flex items-center justify-center font-bold text-[11px]" id="tour-step-indicator">1</div>
            <h4 class="font-serif font-bold text-[16px] text-brand-gold flex-1" id="tour-title">Judul Tour</h4>
            <button onclick="closeTour()" class="text-gray-500 hover:text-white transition"><i class="fas fa-times"></i></button>
        </div>
        <p class="text-[13px] text-gray-300 mb-5 leading-relaxed" id="tour-content">Isi petunjuk tour.</p>
        <div class="flex justify-between items-center mt-auto border-t border-gray-700 pt-3">
            <button id="tour-prev" onclick="prevStep()" class="text-[11px] font-semibold text-gray-400 hover:text-white transition invisible uppercase tracking-wider">Sebelumnya</button>
            <button id="tour-next" onclick="nextStep()" class="bg-brand-gold text-black px-4 py-1.5 rounded-sm text-[11px] font-bold uppercase tracking-wider hover:bg-white transition">Selanjutnya</button>
        </div>
    </div>

    <!-- Simulated Modals (Checkout & Member) -->
    <!-- Cart Modal -->
    <div id="cartModal" class="fixed inset-0 z-[160] bg-black/80 backdrop-blur-md hidden items-center justify-end p-0 transition-all">
        <div class="bg-[#111] border-l border-brand-border w-full max-w-md h-full shadow-2xl flex flex-col relative animate-slide-left">
            <div class="p-6 border-b border-brand-border flex justify-between items-center bg-[#0a0a0a]">
                <h3 class="font-serif text-xl text-white">Your Cart</h3>
                <button onclick="closeCartModal()" class="text-gray-400 hover:text-white"><i class="fas fa-times text-xl"></i></button>
            </div>

            <div class="p-6 flex-1 overflow-y-auto" id="cart-items">
                <!-- Cart items will be injected here -->
            </div>

            <div class="p-6 border-t border-brand-border bg-[#0a0a0a]">
                <div class="flex justify-between text-gray-400 text-sm mb-2">
                    <span>Subtotal</span>
                    <span id="cart-subtotal" class="font-bold text-white">Rp 0</span>
                </div>
                <div class="bg-brand-gold/10 border border-brand-gold/30 rounded p-3 mb-4 flex items-center justify-between cursor-pointer" onclick="openMemberModal()">
                    <div class="flex items-center gap-3">
                        <i class="fas fa-crown text-brand-gold"></i>
                        <div>
                            <p class="text-[11px] font-bold text-white">Login Member</p>
                            <p class="text-[10px] text-gray-400">Dapatkan diskon & poin!</p>
                        </div>
                    </div>
                    <i class="fas fa-chevron-right text-gray-500 text-[10px]"></i>
                </div>
                <button onclick="proceedToCheckout()" class="w-full bg-brand-gold text-black py-3 rounded text-[12px] font-bold tracking-widest uppercase hover:bg-white transition">
                    Checkout <i class="fas fa-lock ml-2 text-[10px]"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Checkout / Payment Modal -->
    <div id="checkoutModal" class="fixed inset-0 z-[170] bg-black/90 backdrop-blur-md hidden items-center justify-center p-4 transition-all">
        <div class="bg-[#111] border border-brand-border w-full max-w-2xl rounded-lg shadow-2xl flex flex-col relative overflow-hidden">
            <div class="p-6 border-b border-brand-border flex justify-between items-center bg-[#0a0a0a]">
                <h3 class="font-serif text-xl text-white">Checkout & Payment</h3>
                <button onclick="closeCheckoutModal()" class="text-gray-400 hover:text-white"><i class="fas fa-times text-xl"></i></button>
            </div>
            <div class="flex flex-col md:flex-row">
                <div class="p-6 w-full md:w-1/2 border-r border-brand-border">
                    <h4 class="text-brand-gold text-[11px] tracking-widest uppercase mb-4 font-bold">1. Shipping Info</h4>
                    <div class="space-y-3 mb-6">
                        <input type="text" placeholder="Nama Lengkap" value="Rangga Dirgantara" class="w-full bg-black border border-brand-border rounded px-3 py-2 text-xs text-white" readonly>
                        <input type="text" placeholder="Alamat Pengiriman" value="Jl. Sudirman No. 123, Jakarta Selatan" class="w-full bg-black border border-brand-border rounded px-3 py-2 text-xs text-white" readonly>
                        <select class="w-full bg-black border border-brand-border rounded px-3 py-2 text-xs text-white">
                            <option>JNE Regular - Rp 15.000</option>
                            <option>SiCepat BEST - Rp 22.000</option>
                        </select>
                    </div>

                    <h4 class="text-brand-gold text-[11px] tracking-widest uppercase mb-4 font-bold">2. Payment Method</h4>
                    <div class="space-y-2">
                        <label class="flex items-center gap-3 p-3 border border-brand-gold bg-brand-gold/5 rounded cursor-pointer">
                            <input type="radio" name="payment" checked class="accent-brand-gold">
                            <span class="text-xs text-white font-medium">QRIS (OVO, Gopay, Dana, dll)</span>
                            <i class="fas fa-qrcode ml-auto text-brand-gold"></i>
                        </label>
                        <label class="flex items-center gap-3 p-3 border border-brand-border hover:border-gray-500 rounded cursor-pointer">
                            <input type="radio" name="payment" class="accent-brand-gold">
                            <span class="text-xs text-gray-300 font-medium">Virtual Account BCA</span>
                        </label>
                    </div>
                </div>
                <div class="p-6 w-full md:w-1/2 bg-[#0a0a0a] flex flex-col items-center justify-center text-center">
                    <p class="text-xs text-gray-400 mb-1">Total Pembayaran</p>
                    <p class="text-3xl font-serif text-white mb-6" id="checkout-total">Rp 0</p>

                    <div class="bg-white p-2 rounded-lg inline-block mb-4">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/d/d0/QR_code_for_mobile_English_Wikipedia.svg" class="w-32 h-32 opacity-80 mix-blend-multiply">
                    </div>
                    <p class="text-[10px] text-brand-gold mb-6 animate-pulse">Menunggu pembayaran (Scan QRIS)</p>

                    <button onclick="simulatePaymentSuccess()" class="w-full bg-green-600 text-white py-3 rounded text-[12px] font-bold tracking-widest uppercase hover:bg-green-500 transition shadow-[0_0_15px_rgba(22,163,74,0.3)]">
                        SIMULASI: BAYAR SEKARANG
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Success & Tracking Modal -->
    <div id="successModal" class="fixed inset-0 z-[180] bg-black/90 backdrop-blur-md hidden items-center justify-center p-4 transition-all">
        <div class="bg-[#111] border border-brand-border w-full max-w-lg rounded-lg shadow-2xl p-8 text-center relative overflow-hidden">
            <button onclick="closeSuccessModal()" class="absolute top-4 right-4 text-gray-400 hover:text-white"><i class="fas fa-times text-xl"></i></button>

            <div class="w-20 h-20 bg-green-500/20 text-green-500 rounded-full flex items-center justify-center mx-auto mb-6 border border-green-500">
                <i class="fas fa-check text-3xl"></i>
            </div>
            <h3 class="font-serif text-2xl text-white mb-2">Payment Successful!</h3>
            <p class="text-gray-400 text-sm mb-6">Order ID: <span class="text-white font-bold">#ORD-9982</span></p>

            <!-- Loyalty Points notification -->
            <div class="bg-brand-gold/10 border border-brand-gold/30 rounded p-4 mb-6 inline-block w-full">
                <p class="text-brand-gold text-[11px] uppercase tracking-widest font-bold mb-1"><i class="fas fa-star"></i> Loyalty Reward</p>
                <p class="text-white text-sm">Anda mendapatkan <span class="font-bold text-brand-gold">+150 Points</span> dari transaksi ini!</p>
            </div>

            <!-- Tracking Status -->
            <div class="text-left mt-6 pt-6 border-t border-brand-border">
                <h4 class="text-white font-bold mb-4 text-sm">Order Status</h4>
                <div class="relative border-l-2 border-brand-gold ml-3 space-y-6">
                    <div class="relative pl-6">
                        <div class="absolute w-3 h-3 bg-brand-gold rounded-full -left-[7px] top-1"></div>
                        <p class="text-white text-xs font-bold">Payment Confirmed</p>
                        <p class="text-gray-500 text-[10px]">Just now</p>
                    </div>
                    <div class="relative pl-6 opacity-50">
                        <div class="absolute w-3 h-3 bg-gray-600 rounded-full -left-[7px] top-1"></div>
                        <p class="text-white text-xs font-bold">Preparing Order</p>
                        <p class="text-gray-500 text-[10px]">In progress...</p>
                    </div>
                    <div class="relative pl-6 opacity-50">
                        <div class="absolute w-3 h-3 bg-gray-600 rounded-full -left-[7px] top-1"></div>
                        <p class="text-white text-xs font-bold">Shipped</p>
                        <p class="text-gray-500 text-[10px]">Pending</p>
                    </div>
                </div>
            </div>

            <button onclick="closeSuccessModal(); openMemberModal();" class="mt-8 bg-white text-black px-6 py-2 rounded-sm text-[11px] font-bold tracking-widest uppercase hover:bg-brand-gold transition">
                Ke Member Area
            </button>
        </div>
    </div>

    <!-- Member Dashboard Modal -->
    <div id="memberModal" class="fixed inset-0 z-[160] bg-black/90 backdrop-blur-md hidden items-center justify-center p-4 transition-all">
        <div class="bg-[#111] border border-brand-border w-full max-w-3xl rounded-lg shadow-2xl flex flex-col relative overflow-hidden">
            <div class="p-6 border-b border-brand-border flex justify-between items-center bg-[#0a0a0a]">
                <h3 class="font-serif text-xl text-brand-gold"><i class="fas fa-crown mr-2"></i> Exclusive Member Area</h3>
                <button onclick="closeMemberModal()" class="text-gray-400 hover:text-white"><i class="fas fa-times text-xl"></i></button>
            </div>

            <div class="flex flex-col md:flex-row">
                <!-- Sidebar Profile -->
                <div class="p-6 w-full md:w-1/3 bg-[#0a0a0a] border-r border-brand-border text-center">
                    <div class="w-20 h-20 rounded-full bg-brand-dark border-2 border-brand-gold mx-auto mb-4 flex items-center justify-center">
                        <i class="fas fa-user-tie text-2xl text-brand-gold"></i>
                    </div>
                    <h4 class="text-white font-bold text-lg">Rangga D.</h4>
                    <div class="bg-gradient-to-r from-yellow-600 to-yellow-400 text-black text-[10px] font-bold uppercase tracking-widest py-1 px-3 rounded-full inline-block mt-2 mb-6">
                        GOLD MEMBER
                    </div>

                    <div class="bg-[#111] border border-brand-border rounded p-4 mb-6">
                        <p class="text-gray-400 text-[10px] uppercase tracking-widest mb-1">Your Points</p>
                        <p class="text-2xl font-serif text-brand-gold" id="member-points">1,250</p>
                        <p class="text-[10px] text-gray-500 mt-2">= Rp 125.000 Diskon</p>
                    </div>

                    <button class="w-full text-left text-xs text-white hover:text-brand-gold py-2 border-b border-brand-border"><i class="fas fa-box w-6"></i> My Orders</button>
                    <button class="w-full text-left text-xs text-gray-400 hover:text-brand-gold py-2 border-b border-brand-border"><i class="fas fa-heart w-6"></i> Wishlist</button>
                    <button class="w-full text-left text-xs text-red-500 hover:text-red-400 py-2"><i class="fas fa-sign-out-alt w-6"></i> Logout</button>
                </div>

                <!-- Main Content (Orders) -->
                <div class="p-6 w-full md:w-2/3 bg-[#111]">
                    <h4 class="text-white font-serif text-lg mb-4">Recent Orders</h4>

                    <div class="space-y-4">
                        <!-- Order 1 -->
                        <div class="border border-brand-border rounded p-4 flex flex-col md:flex-row justify-between items-start md:items-center gap-4 bg-black/50">
                            <div>
                                <div class="flex items-center gap-3 mb-1">
                                    <span class="text-brand-gold font-bold text-sm">#ORD-9982</span>
                                    <span class="bg-blue-900/50 text-blue-400 border border-blue-800 text-[9px] px-2 py-0.5 rounded uppercase tracking-wider font-bold">Sedang Dikirim</span>
                                </div>
                                <p class="text-xs text-gray-400">1x Ethereal Bloom (50ml) • 1x Discovery Set</p>
                                <p class="text-[10px] text-gray-500 mt-1">Total: Rp 600.000 (JNE Resi: 0129381923)</p>
                            </div>
                            <button class="bg-[#1a1a1a] border border-gray-600 text-white px-4 py-2 rounded text-[10px] font-bold uppercase hover:bg-gray-800 transition whitespace-nowrap">
                                Lacak Pesanan
                            </button>
                        </div>

                        <!-- Order 2 -->
                        <div class="border border-brand-border rounded p-4 flex flex-col md:flex-row justify-between items-start md:items-center gap-4 opacity-70">
                            <div>
                                <div class="flex items-center gap-3 mb-1">
                                    <span class="text-gray-400 font-bold text-sm">#ORD-8110</span>
                                    <span class="bg-green-900/50 text-green-500 border border-green-800 text-[9px] px-2 py-0.5 rounded uppercase tracking-wider font-bold">Selesai</span>
                                </div>
                                <p class="text-xs text-gray-400">1x Discovery Set</p>
                                <p class="text-[10px] text-gray-500 mt-1">Total: Rp 150.000</p>
                            </div>
                            <button class="text-brand-gold border-b border-brand-gold text-[10px] font-bold uppercase pb-0.5 hover:text-white transition whitespace-nowrap">
                                Beri Ulasan
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script>
        // Modal Logic
        const quizModal = document.getElementById('quizModal');

        function openQuizModal() {
            quizModal.classList.remove('hidden');
            quizModal.classList.add('flex');
        }

        function closeQuizModal() {
            quizModal.classList.add('hidden');
            quizModal.classList.remove('flex');
        }

        // Tour Logic
        const tourSteps = [{
                elementId: 'tour-quiz'
                , title: 'Fragrance Finder / Quiz'
                , content: 'Solusi untuk pelanggan yang ragu memilih aroma. Quiz interaktif ini meminimalisir risiko "Blind Buy" dengan merekomendasikan parfum berdasarkan kepribadian atau acara.'
            }
            , {
                elementId: 'tour-discovery'
                , title: 'Strategi Discovery Set'
                , content: 'Mendorong pelanggan membeli kemasan tester (vials) sebelum Full Bottle. Sistem e-commerce dapat diatur untuk otomatis mengirimkan voucher diskon setelah mereka membeli paket ini.'
            }
            , {
                elementId: 'tour-scent-profile'
                , title: 'Scent Profile Detail'
                , content: 'Setiap produk menampilkan Top, Middle, dan Base notes secara terstruktur. Ini sangat penting untuk bisnis parfum agar pelanggan bisa membayangkan aroma sebelum membeli.'
            }
            , {
                elementId: 'tour-reviews'
                , title: 'Social Proof Spesifik'
                , content: 'Modul review yang fokus pada "Longevity" (ketahanan) dan "Sillage" (sebaran wangi). Review adalah nyawa untuk penjualan produk wewangian secara online.'
            }
            , {
                elementId: 'tour-reseller'
                , title: 'Portal Kemitraan (B2B)'
                , content: 'Formulir terintegrasi untuk merekrut Agen, Reseller, dan Affiliate. Data yang masuk akan langsung tersambung ke Dashboard Admin untuk Anda kelola.'
            }
        ];

        let currentStep = 0;
        const overlay = document.getElementById('tour-overlay');
        const tooltip = document.getElementById('tour-tooltip');

        function startTour() {
            window.scrollTo(0, 0);
            currentStep = 0;
            overlay.style.display = 'block';
            tooltip.style.display = 'flex';
            setTimeout(() => showStep(currentStep), 300);
        }

        function closeTour() {
            overlay.style.display = 'none';
            tooltip.style.display = 'none';
            tourSteps.forEach(step => {
                const el = document.getElementById(step.elementId);
                if (el) el.classList.remove('tour-highlight');
            });
        }

        function showStep(index) {
            tourSteps.forEach(step => {
                const el = document.getElementById(step.elementId);
                if (el) el.classList.remove('tour-highlight');
            });

            const step = tourSteps[index];
            const targetEl = document.getElementById(step.elementId);

            if (targetEl) {
                targetEl.scrollIntoView({
                    behavior: 'smooth'
                    , block: 'center'
                });

                setTimeout(() => {
                    targetEl.classList.add('tour-highlight');
                    const rect = targetEl.getBoundingClientRect();
                    let top = rect.bottom + window.scrollY + 15;
                    let left = rect.left + window.scrollX;

                    if (rect.bottom + 200 > window.innerHeight) {
                        top = rect.top + window.scrollY - 180;
                    }

                    if (window.innerWidth < 500) {
                        left = 20;
                        tooltip.style.width = (window.innerWidth - 40) + 'px';
                    } else {
                        tooltip.style.width = '320px';
                        if (left + 320 > window.innerWidth) {
                            left = window.innerWidth - 340;
                        }
                    }

                    tooltip.style.top = top + 'px';
                    tooltip.style.left = left + 'px';

                    document.getElementById('tour-step-indicator').innerText = index + 1;
                    document.getElementById('tour-title').innerText = step.title;
                    document.getElementById('tour-content').innerText = step.content;
                    document.getElementById('tour-prev').style.visibility = index === 0 ? 'hidden' : 'visible';
                    document.getElementById('tour-next').innerText = index === tourSteps.length - 1 ? 'Selesai' : 'Selanjutnya';
                }, 400);
            }
        }

        function nextStep() {
            if (currentStep < tourSteps.length - 1) {
                currentStep++;
                showStep(currentStep);
            } else {
                closeTour();
            }
        }

        // Cart & Simulation Logic
        let cart = [];

        function formatRupiah(angka) {
            return new Intl.NumberFormat('id-ID', {
                style: 'currency'
                , currency: 'IDR'
                , minimumFractionDigits: 0
            }).format(angka);
        }

        function updateCartUI() {
            const cartItemsEl = document.getElementById('cart-items');
            const cartSubtotalEl = document.getElementById('cart-subtotal');
            const cartBadge = document.getElementById('cart-badge');

            cartItemsEl.innerHTML = '';
            let total = 0;

            if (cart.length === 0) {
                cartItemsEl.innerHTML = '<div class="text-center text-gray-500 mt-10"><i class="fas fa-box-open text-3xl mb-3"></i><p>Keranjang masih kosong.</p></div>';
            } else {
                cart.forEach((item, index) => {
                    total += item.price;
                    cartItemsEl.innerHTML += `
                        <div class="flex justify-between items-center border-b border-brand-border py-4">
                            <div class="flex gap-3 items-center">
                                <div class="w-12 h-12 bg-gray-800 rounded flex items-center justify-center text-brand-gold"><i class="fas fa-spray-can"></i></div>
                                <div>
                                    <h5 class="text-white text-sm font-serif">${item.name}</h5>
                                    <p class="text-brand-gold text-xs font-bold">${formatRupiah(item.price)}</p>
                                </div>
                            </div>
                            <button onclick="removeFromCart(${index})" class="text-red-500 hover:text-red-400"><i class="fas fa-trash text-xs"></i></button>
                        </div>
                    `;
                });
            }

            cartSubtotalEl.innerText = formatRupiah(total);
            document.getElementById('checkout-total').innerText = formatRupiah(total + 15000); // add shipping
            cartBadge.innerText = cart.length;
        }

        function addToCart(name, price) {
            cart.push({
                name
                , price
            });
            updateCartUI();

            // Show toast notification
            const toast = document.createElement('div');
            toast.className = 'fixed top-20 right-6 bg-brand-gold text-black px-6 py-3 rounded shadow-lg z-[200] font-bold text-xs uppercase tracking-wider animate-bounce';
            toast.innerHTML = `<i class="fas fa-check mr-2"></i> Ditambahkan ke keranjang`;
            document.body.appendChild(toast);

            setTimeout(() => toast.remove(), 2000);
        }

        function removeFromCart(index) {
            cart.splice(index, 1);
            updateCartUI();
        }

        // Modal Controls
        function openCartModal() {
            document.getElementById('cartModal').classList.remove('hidden');
            document.getElementById('cartModal').classList.add('flex');
        }

        function closeCartModal() {
            document.getElementById('cartModal').classList.add('hidden');
            document.getElementById('cartModal').classList.remove('flex');
        }

        function proceedToCheckout() {
            if (cart.length === 0) return alert('Keranjang kosong!');
            closeCartModal();
            document.getElementById('checkoutModal').classList.remove('hidden');
            document.getElementById('checkoutModal').classList.add('flex');
        }

        function closeCheckoutModal() {
            document.getElementById('checkoutModal').classList.add('hidden');
            document.getElementById('checkoutModal').classList.remove('flex');
        }

        function simulatePaymentSuccess() {
            closeCheckoutModal();
            document.getElementById('successModal').classList.remove('hidden');
            document.getElementById('successModal').classList.add('flex');
            // Update points in member dashboard
            document.getElementById('member-points').innerText = "1,400"; // 1250 + 150
            cart = [];
            updateCartUI();
        }

        function closeSuccessModal() {
            document.getElementById('successModal').classList.add('hidden');
            document.getElementById('successModal').classList.remove('flex');
        }

        function openMemberModal() {
            closeCartModal();
            document.getElementById('memberModal').classList.remove('hidden');
            document.getElementById('memberModal').classList.add('flex');
        }

        function closeMemberModal() {
            document.getElementById('memberModal').classList.add('hidden');
            document.getElementById('memberModal').classList.remove('flex');
        }

        // Initialize empty cart
        cart = []; // start empty to show simulation capability
        updateCartUI();

    </script>
</body>
</html>
