<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $client->brand_name }} — Haute Parfumerie & E-Commerce System</title>
    <meta name="description" content="Platform E-Commerce & Membership Eksklusif untuk {{ $client->brand_name }}.">

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        luxury: {
                            black: '#070707',
                            dark: '#0f0f0f',
                            card: '#141414',
                            cardLight: '#1a1a1a',
                            border: '#242424',
                            borderGold: 'rgba(212, 175, 55, 0.25)',
                            gold: '#c9a86a',
                            goldLight: '#e6caa0',
                            goldMuted: '#9e7f47',
                            textMuted: '#8a8a8a',
                            textSubtle: '#b0b0b0',
                            white: '#fbfbfb'
                        }
                    },
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'Inter', 'sans-serif'],
                        serif: ['Playfair Display', 'Georgia', 'serif'],
                    },
                    letterSpacing: {
                        widest2: '0.25em',
                        widest3: '0.35em'
                    }
                }
            }
        }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;1,400;1,600&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body {
            background-color: #070707;
            color: #fbfbfb;
            font-family: 'Plus Jakarta Sans', sans-serif;
            letter-spacing: -0.01em;
        }

        .font-serif {
            font-family: 'Playfair Display', Georgia, serif;
        }

        .glass-card {
            background: rgba(20, 20, 20, 0.65);
            backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.07);
        }

        .glass-card-gold {
            background: rgba(20, 20, 20, 0.75);
            backdrop-filter: blur(16px);
            border: 1px solid rgba(201, 168, 106, 0.25);
        }

        .gold-gradient-text {
            background: linear-gradient(135deg, #f7e7ce 0%, #c9a86a 50%, #8f6c31 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        /* Subtle luxury image zoom */
        .img-zoom-container {
            overflow: hidden;
        }
        .img-zoom {
            transition: transform 0.8s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .img-zoom-container:hover .img-zoom {
            transform: scale(1.06);
        }

        /* Tour Overlay Styles */
        #tour-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.88);
            z-index: 9998;
            display: none;
        }

        .tour-highlight {
            position: relative;
            z-index: 9999 !important;
            box-shadow: 0 0 0 2px #c9a86a, 0 0 35px rgba(201, 168, 106, 0.3) !important;
            border-radius: 0.5rem;
            background-color: #0f0f0f !important;
        }

        #tour-tooltip {
            position: absolute;
            z-index: 10000;
            background: #121212;
            border: 1px solid #c9a86a;
            padding: 1.5rem;
            border-radius: 0.5rem;
            width: 320px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.9);
            display: none;
            transition: all 0.3s ease;
        }
    </style>
</head>
<body class="antialiased selection:bg-luxury-gold selection:text-black">

    <!-- Subtle Top Proposal Notification -->
    <header class="border-b border-luxury-border/60 bg-luxury-black/90 py-2.5 px-6 md:px-12 text-[11px] text-luxury-textSubtle">
        <div class="max-w-7xl mx-auto flex flex-col sm:flex-row items-center justify-between gap-2">
            <div class="flex items-center gap-2">
                <span class="inline-block w-1.5 h-1.5 rounded-full bg-luxury-gold"></span>
                <span>Live Interactive Prototype untuk <strong>{{ $client->brand_name }}</strong></span>
                <span class="text-luxury-border hidden md:inline">|</span>
                <span class="text-luxury-textMuted hidden md:inline">E-Commerce, Membership & Growth Engine</span>
            </div>
            <div class="flex items-center gap-4">
                <a href="{{ route('proposal.dynamic', $client->slug) }}" class="text-luxury-gold hover:text-white transition font-medium flex items-center gap-1.5 tracking-wide">
                    Proposal Penawaran <i class="fas fa-arrow-right text-[9px]"></i>
                </a>
                <span class="text-luxury-border">|</span>
                <a href="{{ route('demo.admin.parfum', $client->slug) ?? '#' }}" class="text-luxury-textSubtle hover:text-luxury-gold transition font-medium flex items-center gap-1">
                    <i class="fas fa-sliders text-[10px]"></i> Simulasi Admin & POS
                </a>
            </div>
        </div>
    </header>

    <!-- Refined Minimal Luxury Navigation -->
    <nav class="sticky top-0 z-50 bg-luxury-black/85 backdrop-blur-md border-b border-luxury-border/50 py-4 px-6 md:px-12 transition-all duration-300">
        <div class="max-w-7xl mx-auto flex items-center justify-between">
            <!-- Brand Logo -->
            <a href="#" class="flex flex-col">
                <span class="font-serif text-xl md:text-2xl font-normal tracking-[0.2em] text-luxury-white uppercase">{{ $client->brand_name }}</span>
                <span class="text-[8px] tracking-widest3 text-luxury-gold uppercase font-light -mt-0.5">Haute Parfumerie</span>
            </a>

            <!-- Clean Nav Links -->
            <div class="hidden lg:flex items-center gap-9 text-[11px] font-medium tracking-[0.18em] uppercase text-luxury-textSubtle">
                <a href="#best-seller" class="hover:text-luxury-gold transition">Best Seller</a>
                <a href="#membership" class="hover:text-luxury-gold transition">Membership Club</a>
                <a href="#discovery" class="hover:text-luxury-gold transition">Discovery Set</a>
                <a href="#bundling" class="hover:text-luxury-gold transition">Curated Bundles</a>
                <a href="#sales-engine" class="hover:text-luxury-gold transition">Sistem Penjualan</a>
                <a href="#reseller" class="hover:text-luxury-gold transition">Partnership</a>
            </div>

            <!-- Action Controls -->
            <div class="flex items-center gap-5 text-sm">
                <!-- Member Area Modal Trigger -->
                <button onclick="openMemberModal()" class="text-luxury-textSubtle hover:text-luxury-gold transition flex items-center gap-2 text-[11px] tracking-wider uppercase font-medium" title="Member & Loyalty Area">
                    <i class="far fa-user text-xs"></i>
                    <span class="hidden sm:inline">Member Area</span>
                </button>

                <!-- Cart Bag Trigger -->
                <button onclick="openCartModal()" class="text-luxury-textSubtle hover:text-luxury-gold transition relative p-1" title="Shopping Bag">
                    <i class="fas fa-bag-shopping text-sm"></i>
                    <span id="cart-badge" class="absolute -top-1 -right-2 bg-luxury-gold text-black text-[9px] font-bold w-4 h-4 rounded-full flex items-center justify-center">2</span>
                </button>

                <!-- Clean Proposal CTA -->
                <a href="{{ route('proposal.dynamic', $client->slug) }}" class="hidden md:inline-flex border border-luxury-gold/60 text-luxury-gold hover:bg-luxury-gold hover:text-black px-4 py-1.5 rounded-sm text-[10px] font-semibold tracking-widest uppercase transition duration-300">
                    Buka Proposal
                </a>
            </div>
        </div>
    </nav>

    <!-- Floating Tour Button (Unobtrusive & Elegant) -->
    <div class="fixed bottom-6 right-6 z-[90] flex items-center gap-3">
        <button onclick="startTour()" class="bg-luxury-card/90 backdrop-blur-md border border-luxury-gold/40 text-luxury-gold hover:bg-luxury-gold hover:text-black px-4 py-2.5 rounded-full shadow-2xl text-[11px] font-semibold tracking-wider uppercase transition flex items-center gap-2">
            <i class="fas fa-circle-nodes text-xs"></i>
            <span>Tour Fitur Website</span>
        </button>
    </div>

    <!-- HERO SECTION: Quiet Luxury & Strategic Proposal Pitch -->
    <section class="relative min-h-[88vh] flex items-center justify-center overflow-hidden border-b border-luxury-border/40 py-20">
        <!-- Background Ambient Media -->
        <div class="absolute inset-0 z-0">
            <img src="https://images.unsplash.com/photo-1594035910387-fea47794261f?auto=format&fit=crop&q=80&w=2000" alt="Luxury Fragrance" class="w-full h-full object-cover opacity-25 filter grayscale-[20%]">
            <div class="absolute inset-0 bg-gradient-to-t from-luxury-black via-luxury-black/70 to-luxury-black/85"></div>
            <div class="absolute top-1/3 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[500px] h-[500px] bg-luxury-gold/10 rounded-full blur-[140px] pointer-events-none"></div>
        </div>

        <div class="relative z-10 max-w-5xl mx-auto px-6 text-center">
            <!-- Refined Badge -->
            <div class="inline-flex items-center gap-2 border border-luxury-borderGold bg-luxury-card/60 backdrop-blur-md px-3.5 py-1 rounded-full mb-8">
                <span class="w-1.5 h-1.5 rounded-full bg-luxury-gold"></span>
                <span class="text-[10px] tracking-widest2 uppercase text-luxury-goldLight font-medium">Digital Flagship & Retention Engine</span>
            </div>

            <!-- Headline -->
            <h1 class="text-4xl sm:text-6xl lg:text-7xl font-serif text-luxury-white mb-6 leading-[1.15] font-normal">
                Elevating <span class="italic font-normal text-luxury-gold">The Art of Perfumery</span> <br>
                Through Digital Precision
            </h1>

            <!-- Subtitle -->
            <p class="text-luxury-textSubtle text-sm sm:text-base max-w-2xl mx-auto mb-10 leading-relaxed font-light">
                Dirancang khusus untuk <strong>{{ $client->brand_name }}</strong> — menggabungkan kemewahan visual, sistem <span class="text-luxury-white font-medium">Membership Poin</span> untuk mengunci repeat order, etalase <span class="text-luxury-white font-medium">Best Seller</span> interaktif, dan checkout mandiri tanpa potongan fee marketplace.
            </p>

            <!-- Refined CTAs -->
            <div class="flex flex-col sm:flex-row justify-center items-center gap-4 mb-16" id="tour-hero-cta">
                <a href="#best-seller" class="w-full sm:w-auto bg-luxury-gold text-black px-7 py-3.5 rounded-sm text-[11px] font-bold tracking-[0.2em] uppercase hover:bg-luxury-white transition duration-300 shadow-[0_4px_20px_rgba(201,168,106,0.25)]">
                    Jelajahi Koleksi
                </a>
                <button onclick="openMemberModal()" class="w-full sm:w-auto border border-luxury-border hover:border-luxury-gold text-luxury-white px-7 py-3.5 rounded-sm text-[11px] font-medium tracking-[0.2em] uppercase transition duration-300 bg-luxury-card/50">
                    Simulasi Membership
                </button>
                <button onclick="openQuizModal()" class="w-full sm:w-auto text-luxury-textSubtle hover:text-luxury-gold px-5 py-3.5 text-[11px] font-medium tracking-wider uppercase transition flex items-center justify-center gap-2" id="tour-quiz">
                    <i class="fas fa-wand-magic-sparkles text-luxury-gold text-xs"></i> Scent Finder Quiz
                </button>
            </div>

            <!-- 4 Strategic Pillars (Minimal Grid) -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-left border-t border-luxury-border/50 pt-8">
                <div class="p-3">
                    <span class="text-luxury-gold text-[10px] tracking-widest uppercase font-semibold block mb-1">01 / Retention</span>
                    <h2 class="text-luxury-white text-xs font-serif font-bold mb-1">Membership Club</h2>
                    <p class="text-luxury-textMuted text-[11px] leading-relaxed">Tiering & poin belanja otomatis untuk melipatgandakan repeat order.</p>
                </div>
                <div class="p-3">
                    <span class="text-luxury-gold text-[10px] tracking-widest uppercase font-semibold block mb-1">02 / Curation</span>
                    <h2 class="text-luxury-white text-xs font-serif font-bold mb-1">Best Seller System</h2>
                    <p class="text-luxury-textMuted text-[11px] leading-relaxed">Piramida aroma (Top, Heart, Base) yang mengedukasi calon pembeli.</p>
                </div>
                <div class="p-3">
                    <span class="text-luxury-gold text-[10px] tracking-widest uppercase font-semibold block mb-1">03 / Conversion</span>
                    <h2 class="text-luxury-white text-xs font-serif font-bold mb-1">Discovery Set</h2>
                    <p class="text-luxury-textMuted text-[11px] leading-relaxed">Solusi blind-buy dengan voucher 100% cashback untuk full bottle.</p>
                </div>
                <div class="p-3">
                    <span class="text-luxury-gold text-[10px] tracking-widest uppercase font-semibold block mb-1">04 / Efficiency</span>
                    <h2 class="text-luxury-white text-xs font-serif font-bold mb-1">Seamless Checkout</h2>
                    <p class="text-luxury-textMuted text-[11px] leading-relaxed">Multi-payment QRIS & VA, auto resi WA, dan sinkronisasi POS kasir.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- SECTION 1: THE BEST SELLER SHOWCASE -->
    <section id="best-seller" class="py-24 px-6 md:px-12 max-w-7xl mx-auto border-b border-luxury-border/40" id="tour-best-seller">
        <div class="flex flex-col md:flex-row md:items-end justify-between mb-16 gap-6">
            <div>
                <span class="text-luxury-gold text-[10px] tracking-widest2 uppercase font-semibold block mb-2">Curated Signatures</span>
                <h2 class="font-serif text-3xl md:text-5xl text-luxury-white font-normal">Extrait de Parfum Collection</h2>
            </div>
            <p class="text-luxury-textMuted text-xs max-w-md leading-relaxed">
                Konsentrasi murni 30% fragrance oil untuk daya tahan 12–16 jam. Tiap varian dilengkapi piramida notes terstruktur guna meminimalisir keraguan blind buy.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Product Card 1 (Midnight Enigma) -->
            <div class="group bg-luxury-dark border border-luxury-border hover:border-luxury-gold/50 rounded-sm p-6 transition duration-500 flex flex-col justify-between">
                <div>
                    <div class="relative bg-luxury-black aspect-[3/4] rounded-sm overflow-hidden mb-6 img-zoom-container">
                        <span class="absolute top-3 left-3 z-10 bg-luxury-black/80 backdrop-blur-md border border-luxury-borderGold text-luxury-gold text-[9px] font-semibold tracking-widest uppercase px-2.5 py-1">
                            #1 Top Seller
                        </span>
                        <img src="https://images.unsplash.com/photo-1590736969955-71cc94801759?auto=format&fit=crop&q=80&w=600" alt="Midnight Enigma" class="object-cover w-full h-full opacity-85 img-zoom">
                        
                        <!-- Quick Add Hover -->
                        <div class="absolute inset-x-0 bottom-0 p-4 bg-gradient-to-t from-black via-black/80 to-transparent translate-y-full group-hover:translate-y-0 transition duration-300">
                            <button onclick="addToCart('Midnight Enigma (50ml)', 450000)" class="w-full bg-luxury-gold text-black py-2.5 text-[10px] font-bold uppercase tracking-widest hover:bg-luxury-white transition">
                                Tambah ke Bag
                            </button>
                        </div>
                    </div>

                    <div class="flex items-center justify-between text-[10px] text-luxury-textMuted uppercase tracking-wider mb-2">
                        <span>Woody • Smoky • Amber</span>
                        <span class="text-luxury-gold font-medium"><i class="fas fa-star text-[9px] mr-1"></i>4.9 (620)</span>
                    </div>

                    <h3 class="font-serif text-2xl text-luxury-white mb-2">Midnight Enigma</h3>
                    <p class="text-luxury-textMuted text-xs mb-6 font-light leading-relaxed">Aura maskulin nan misterius. Cocok untuk acara malam dan momen formal berkelas.</p>

                    <!-- Scent Pyramid -->
                    <div class="border-t border-luxury-border/60 pt-4 text-[11px] space-y-2 mb-6">
                        <div class="flex justify-between text-luxury-textMuted">
                            <span class="uppercase tracking-wider text-[10px]">Top</span>
                            <span class="text-luxury-textSubtle">Bergamot, Black Pepper, Cardamom</span>
                        </div>
                        <div class="flex justify-between text-luxury-textMuted">
                            <span class="uppercase tracking-wider text-[10px]">Heart</span>
                            <span class="text-luxury-textSubtle">Tobacco Leaf, Dark Cedarwood</span>
                        </div>
                        <div class="flex justify-between text-luxury-textMuted">
                            <span class="uppercase tracking-wider text-[10px]">Base</span>
                            <span class="text-luxury-goldLight">Madagascar Vanilla, Oud, Amber</span>
                        </div>
                    </div>
                </div>

                <div class="border-t border-luxury-border/60 pt-4 flex items-center justify-between">
                    <div>
                        <span class="text-luxury-textMuted text-[10px] line-through block">Rp 550.000</span>
                        <span class="text-luxury-white text-base font-serif font-medium">Rp 450.000</span>
                    </div>
                    <button onclick="addToCart('Midnight Enigma (50ml)', 450000)" class="border border-luxury-gold/50 text-luxury-gold hover:bg-luxury-gold hover:text-black px-4 py-1.5 text-[10px] font-bold uppercase tracking-widest transition">
                        Beli Sekarang
                    </button>
                </div>
            </div>

            <!-- Product Card 2 (Ethereal Bloom) -->
            <div class="group bg-luxury-dark border border-luxury-border hover:border-luxury-gold/50 rounded-sm p-6 transition duration-500 flex flex-col justify-between">
                <div>
                    <div class="relative bg-luxury-black aspect-[3/4] rounded-sm overflow-hidden mb-6 img-zoom-container">
                        <span class="absolute top-3 left-3 z-10 bg-luxury-black/80 backdrop-blur-md border border-luxury-borderGold text-luxury-gold text-[9px] font-semibold tracking-widest uppercase px-2.5 py-1">
                            Signature Floral
                        </span>
                        <img src="https://images.unsplash.com/photo-1541643600914-78b084683601?auto=format&fit=crop&q=80&w=600" alt="Ethereal Bloom" class="object-cover w-full h-full opacity-85 img-zoom">
                        
                        <div class="absolute inset-x-0 bottom-0 p-4 bg-gradient-to-t from-black via-black/80 to-transparent translate-y-full group-hover:translate-y-0 transition duration-300">
                            <button onclick="addToCart('Ethereal Bloom (50ml)', 450000)" class="w-full bg-luxury-gold text-black py-2.5 text-[10px] font-bold uppercase tracking-widest hover:bg-luxury-white transition">
                                Tambah ke Bag
                            </button>
                        </div>
                    </div>

                    <div class="flex items-center justify-between text-[10px] text-luxury-textMuted uppercase tracking-wider mb-2">
                        <span>Floral • Fresh • Sensual</span>
                        <span class="text-luxury-gold font-medium"><i class="fas fa-star text-[9px] mr-1"></i>4.95 (490)</span>
                    </div>

                    <h3 class="font-serif text-2xl text-luxury-white mb-2">Ethereal Bloom</h3>
                    <p class="text-luxury-textMuted text-xs mb-6 font-light leading-relaxed">Sentuhan mawar Turki yang anggun berpadu manisnya lychee segar dan white musk.</p>

                    <div class="border-t border-luxury-border/60 pt-4 text-[11px] space-y-2 mb-6">
                        <div class="flex justify-between text-luxury-textMuted">
                            <span class="uppercase tracking-wider text-[10px]">Top</span>
                            <span class="text-luxury-textSubtle">Sweet Lychee, Crisp Pear</span>
                        </div>
                        <div class="flex justify-between text-luxury-textMuted">
                            <span class="uppercase tracking-wider text-[10px]">Heart</span>
                            <span class="text-luxury-textSubtle">Turkish Rose, Pink Peony</span>
                        </div>
                        <div class="flex justify-between text-luxury-textMuted">
                            <span class="uppercase tracking-wider text-[10px]">Base</span>
                            <span class="text-luxury-goldLight">White Musk, Cashmeran, Amber</span>
                        </div>
                    </div>
                </div>

                <div class="border-t border-luxury-border/60 pt-4 flex items-center justify-between">
                    <div>
                        <span class="text-luxury-textMuted text-[10px] line-through block">Rp 550.000</span>
                        <span class="text-luxury-white text-base font-serif font-medium">Rp 450.000</span>
                    </div>
                    <button onclick="addToCart('Ethereal Bloom (50ml)', 450000)" class="border border-luxury-gold/50 text-luxury-gold hover:bg-luxury-gold hover:text-black px-4 py-1.5 text-[10px] font-bold uppercase tracking-widest transition">
                        Beli Sekarang
                    </button>
                </div>
            </div>

            <!-- Product Card 3 (Oceanic Azure) -->
            <div class="group bg-luxury-dark border border-luxury-border hover:border-luxury-gold/50 rounded-sm p-6 transition duration-500 flex flex-col justify-between">
                <div>
                    <div class="relative bg-luxury-black aspect-[3/4] rounded-sm overflow-hidden mb-6 img-zoom-container">
                        <span class="absolute top-3 left-3 z-10 bg-luxury-black/80 backdrop-blur-md border border-luxury-borderGold text-luxury-gold text-[9px] font-semibold tracking-widest uppercase px-2.5 py-1">
                            Fresh Daily
                        </span>
                        <img src="https://images.unsplash.com/photo-1622618991746-fe6004db3a47?auto=format&fit=crop&q=80&w=600" alt="Oceanic Azure" class="object-cover w-full h-full opacity-85 img-zoom">
                        
                        <div class="absolute inset-x-0 bottom-0 p-4 bg-gradient-to-t from-black via-black/80 to-transparent translate-y-full group-hover:translate-y-0 transition duration-300">
                            <button onclick="addToCart('Oceanic Azure (50ml)', 420000)" class="w-full bg-luxury-gold text-black py-2.5 text-[10px] font-bold uppercase tracking-widest hover:bg-luxury-white transition">
                                Tambah ke Bag
                            </button>
                        </div>
                    </div>

                    <div class="flex items-center justify-between text-[10px] text-luxury-textMuted uppercase tracking-wider mb-2">
                        <span>Aquatic • Citrus • Sage</span>
                        <span class="text-luxury-gold font-medium"><i class="fas fa-star text-[9px] mr-1"></i>4.88 (310)</span>
                    </div>

                    <h3 class="font-serif text-2xl text-luxury-white mb-2">Oceanic Azure</h3>
                    <p class="text-luxury-textMuted text-xs mb-6 font-light leading-relaxed">Kesegaran hembusan angin laut Mediterania, garam mineral, dan grapefruit aromatik.</p>

                    <div class="border-t border-luxury-border/60 pt-4 text-[11px] space-y-2 mb-6">
                        <div class="flex justify-between text-luxury-textMuted">
                            <span class="uppercase tracking-wider text-[10px]">Top</span>
                            <span class="text-luxury-textSubtle">Sea Salt, Italian Grapefruit</span>
                        </div>
                        <div class="flex justify-between text-luxury-textMuted">
                            <span class="uppercase tracking-wider text-[10px]">Heart</span>
                            <span class="text-luxury-textSubtle">Mineral Sage, Seaweed Breeze</span>
                        </div>
                        <div class="flex justify-between text-luxury-textMuted">
                            <span class="uppercase tracking-wider text-[10px]">Base</span>
                            <span class="text-luxury-goldLight">Ambrette Seed, Clean Patchouli</span>
                        </div>
                    </div>
                </div>

                <div class="border-t border-luxury-border/60 pt-4 flex items-center justify-between">
                    <div>
                        <span class="text-luxury-textMuted text-[10px] line-through block">Rp 500.000</span>
                        <span class="text-luxury-white text-base font-serif font-medium">Rp 420.000</span>
                    </div>
                    <button onclick="addToCart('Oceanic Azure (50ml)', 420000)" class="border border-luxury-gold/50 text-luxury-gold hover:bg-luxury-gold hover:text-black px-4 py-1.5 text-[10px] font-bold uppercase tracking-widest transition">
                        Beli Sekarang
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- SECTION 2: MEMBERSHIP & LOYALTY PRIVILEGE CLUB -->
    <section id="membership" class="py-24 px-6 md:px-12 max-w-7xl mx-auto border-b border-luxury-border/40" id="tour-membership">
        <div class="text-center max-w-3xl mx-auto mb-16">
            <span class="text-luxury-gold text-[10px] tracking-widest2 uppercase font-semibold block mb-2">Customer Lifetime Value Engine</span>
            <h2 class="font-serif text-3xl md:text-5xl text-luxury-white font-normal mb-4">
                The Privileged <span class="italic text-luxury-gold">Membership Club</span>
            </h2>
            <p class="text-luxury-textMuted text-xs md:text-sm leading-relaxed">
                Tiap transaksi langsung terakumulasi menjadi saldo Poin Reward yang dapat dipotongkan ke pesanan berikutnya, menciptakan siklus repeat order yang kuat tanpa bergantung pada promo diskon agresif.
            </p>
        </div>

        <!-- 3 Tier Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
            <!-- Tier 1 -->
            <div class="bg-luxury-dark border border-luxury-border rounded-sm p-8 flex flex-col justify-between">
                <div>
                    <span class="text-[9px] tracking-widest uppercase text-luxury-textMuted block mb-1">Tier 01</span>
                    <h3 class="font-serif text-xl text-luxury-white mb-4">Bronze Member</h3>
                    <p class="text-luxury-textMuted text-xs mb-6 leading-relaxed">Otomatis aktif saat customer membuat akun pertama kali di website {{ $client->brand_name }}.</p>
                    
                    <ul class="space-y-3 text-xs text-luxury-textSubtle border-t border-luxury-border/50 pt-6">
                        <li class="flex items-center gap-2.5"><span class="w-1 h-1 rounded-full bg-luxury-gold"></span> 1 Poin per Rp 1.000 belanja</li>
                        <li class="flex items-center gap-2.5"><span class="w-1 h-1 rounded-full bg-luxury-gold"></span> Voucher Ulang Tahun Rp 50.000</li>
                        <li class="flex items-center gap-2.5"><span class="w-1 h-1 rounded-full bg-luxury-gold"></span> Akses katalog private drop</li>
                    </ul>
                </div>
                <div class="border-t border-luxury-border/50 pt-6 mt-8">
                    <span class="text-[10px] uppercase tracking-wider text-luxury-textMuted">Requirement: Akun Baru</span>
                </div>
            </div>

            <!-- Tier 2 -->
            <div class="bg-luxury-dark border border-luxury-border rounded-sm p-8 flex flex-col justify-between">
                <div>
                    <span class="text-[9px] tracking-widest uppercase text-luxury-gold block mb-1">Tier 02</span>
                    <h3 class="font-serif text-xl text-luxury-white mb-4">Silver Privileged</h3>
                    <p class="text-luxury-textMuted text-xs mb-6 leading-relaxed">Diberikan untuk pelanggan yang telah melakukan repeat order minimal 3 botol (1.500 Pts).</p>
                    
                    <ul class="space-y-3 text-xs text-luxury-textSubtle border-t border-luxury-border/50 pt-6">
                        <li class="flex items-center gap-2.5"><span class="w-1 h-1 rounded-full bg-luxury-gold"></span> 1.5x Poin Reward per transaksi</li>
                        <li class="flex items-center gap-2.5"><span class="w-1 h-1 rounded-full bg-luxury-gold"></span> Gratis Ongkir Seluruh Indonesia</li>
                        <li class="flex items-center gap-2.5"><span class="w-1 h-1 rounded-full bg-luxury-gold"></span> Bonus 2x Tester Vials setiap order</li>
                    </ul>
                </div>
                <div class="border-t border-luxury-border/50 pt-6 mt-8">
                    <span class="text-[10px] uppercase tracking-wider text-luxury-gold">Requirement: 1.500 Poin</span>
                </div>
            </div>

            <!-- Tier 3 (VIP) -->
            <div class="bg-luxury-card border border-luxury-borderGold rounded-sm p-8 flex flex-col justify-between relative">
                <div class="absolute top-4 right-4 text-[9px] tracking-widest uppercase text-luxury-gold font-bold border border-luxury-borderGold px-2 py-0.5">
                    VIP TIER
                </div>
                <div>
                    <span class="text-[9px] tracking-widest uppercase text-luxury-gold block mb-1">Tier 03</span>
                    <h3 class="font-serif text-xl text-luxury-white mb-4">Gold Haute VIP</h3>
                    <p class="text-luxury-textMuted text-xs mb-6 leading-relaxed">Perlakuan istimewa untuk kolektor loyalitas tertinggi brand {{ $client->brand_name }}.</p>
                    
                    <ul class="space-y-3 text-xs text-luxury-textSubtle border-t border-luxury-border/50 pt-6">
                        <li class="flex items-center gap-2.5"><span class="w-1 h-1 rounded-full bg-luxury-gold"></span> 2x Poin Reward ganda tiap order</li>
                        <li class="flex items-center gap-2.5"><span class="w-1 h-1 rounded-full bg-luxury-gold"></span> Private Pre-order edisi terbatas</li>
                        <li class="flex items-center gap-2.5"><span class="w-1 h-1 rounded-full bg-luxury-gold"></span> Kemasan custom grafir nama gratis</li>
                    </ul>
                </div>
                <div class="border-t border-luxury-border/50 pt-6 mt-8">
                    <span class="text-[10px] uppercase tracking-wider text-luxury-gold">Requirement: 4.000 Poin</span>
                </div>
            </div>
        </div>

        <!-- Member Demo Banner -->
        <div class="bg-luxury-dark border border-luxury-border p-6 md:p-8 flex flex-col sm:flex-row items-center justify-between gap-6">
            <div>
                <h4 class="font-serif text-lg text-luxury-white font-normal mb-1">Ingin Mencoba Tampilan Member Dashboard?</h4>
                <p class="text-luxury-textMuted text-xs">Lihat bagaimana customer memeriksa poin cashback, riwayat pesanan, dan resi kurir real-time.</p>
            </div>
            <button onclick="openMemberModal()" class="bg-luxury-gold text-black px-6 py-3 rounded-sm text-[10px] font-bold tracking-widest uppercase hover:bg-luxury-white transition duration-300 shrink-0">
                Buka Simulasi Member Area
            </button>
        </div>
    </section>

    <!-- SECTION 3: DISCOVERY SET (THE ANTI BLIND-BUY CONVERSION) -->
    <section id="discovery" class="py-24 px-6 md:px-12 max-w-7xl mx-auto border-b border-luxury-border/40" id="tour-discovery">
        <div class="flex flex-col lg:flex-row items-center gap-14">
            <div class="w-full lg:w-1/2 relative img-zoom-container rounded-sm border border-luxury-border">
                <img src="https://images.unsplash.com/photo-1615634260167-c8cdede054de?auto=format&fit=crop&q=80&w=800" alt="The Discovery Set" class="w-full h-[450px] object-cover opacity-85 img-zoom">
                <div class="absolute bottom-6 left-6 bg-luxury-black/80 backdrop-blur-md border border-luxury-borderGold p-4">
                    <p class="font-serif text-base text-luxury-white">The Discovery Set</p>
                    <p class="text-[9px] uppercase tracking-widest text-luxury-gold">5 x 3ml Tester Vials</p>
                </div>
            </div>

            <div class="w-full lg:w-1/2">
                <span class="text-luxury-gold text-[10px] tracking-widest2 uppercase font-semibold block mb-2">Solusi Blind Buy</span>
                <h2 class="font-serif text-3xl md:text-5xl text-luxury-white font-normal mb-6 leading-tight">
                    Eksplorasi Sebelum <br><span class="italic text-luxury-gold">Membeli Botol Penuh</span>
                </h2>
                <p class="text-luxury-textMuted text-xs md:text-sm leading-relaxed mb-8">
                    Strategi andalan brand parfum modern untuk menghilangkan keraguan pembeli online. Customer mencoba 5 varian tester, lalu mendapatkan <strong>voucher potongan 100%</strong> senilai harga Discovery Set saat membeli Full Bottle 50ml.
                </p>

                <div class="space-y-4 text-xs text-luxury-textSubtle mb-8">
                    <div class="flex items-start gap-3">
                        <span class="text-luxury-gold font-serif text-sm">✦</span>
                        <span><strong>Cashback 100%:</strong> Biaya Rp 150.000 kembali dalam bentuk kupon diskon untuk botol 50ml.</span>
                    </div>
                    <div class="flex items-start gap-3">
                        <span class="text-luxury-gold font-serif text-sm">✦</span>
                        <span><strong>5 Spektrum Aroma:</strong> Fresh Aquatic, Floral Romantic, Woody Spicy, Sweet Gourmand, dan Clean Amber.</span>
                    </div>
                    <div class="flex items-start gap-3">
                        <span class="text-luxury-gold font-serif text-sm">✦</span>
                        <span><strong>Matchmaker Quiz:</strong> Terhubung dengan kuis rekomendasi personal.</span>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row gap-4">
                    <button onclick="addToCart('Discovery Set (5x 3ml)', 150000)" class="bg-luxury-gold text-black px-7 py-3.5 rounded-sm text-[10px] font-bold tracking-widest uppercase hover:bg-luxury-white transition duration-300">
                        Beli Discovery Set — Rp 150.000
                    </button>
                    <button onclick="openQuizModal()" class="border border-luxury-border hover:border-luxury-gold text-luxury-white px-6 py-3.5 rounded-sm text-[10px] font-medium tracking-widest uppercase transition">
                        Coba Scent Quiz
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- SECTION 4: CURATED BUNDLING & PROMO -->
    <section id="bundling" class="py-24 px-6 md:px-12 max-w-7xl mx-auto border-b border-luxury-border/40" id="tour-promo">
        <div class="flex flex-col md:flex-row md:items-end justify-between mb-16 gap-6">
            <div>
                <span class="text-luxury-gold text-[10px] tracking-widest2 uppercase font-semibold block mb-2">Average Order Value Booster</span>
                <h2 class="font-serif text-3xl md:text-5xl text-luxury-white font-normal">Curated Bundles & Offers</h2>
            </div>
            
            <!-- Live Minimal Timer -->
            <div class="flex items-center gap-2 text-xs text-luxury-textSubtle bg-luxury-dark border border-luxury-border px-4 py-2 rounded-sm">
                <span class="text-luxury-gold uppercase text-[10px] tracking-wider">Flash Offer:</span>
                <span class="font-mono font-bold text-luxury-white" id="timer-hours">08</span>:
                <span class="font-mono font-bold text-luxury-white" id="timer-mins">42</span>:
                <span class="font-mono font-bold text-luxury-white" id="timer-secs">19</span>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Bundle 1 -->
            <div class="bg-luxury-dark border border-luxury-border rounded-sm p-6 flex flex-col justify-between">
                <div>
                    <span class="text-[9px] uppercase tracking-widest text-luxury-gold block mb-2">Duo Set (2x 50ml)</span>
                    <h3 class="font-serif text-xl text-luxury-white mb-2">Signature Couple Set</h3>
                    <p class="text-luxury-textMuted text-xs mb-6 leading-relaxed">Kombinasi Midnight Enigma (Maskulin) & Ethereal Bloom (Feminin) + Free Leather Travel Case.</p>
                </div>
                <div class="border-t border-luxury-border/60 pt-4 flex items-center justify-between">
                    <div>
                        <span class="text-luxury-textMuted text-[10px] line-through block">Rp 900.000</span>
                        <span class="text-luxury-white font-serif text-lg">Rp 765.000</span>
                    </div>
                    <button onclick="addToCart('Signature Couple Set (2x 50ml)', 765000)" class="border border-luxury-gold/60 text-luxury-gold hover:bg-luxury-gold hover:text-black px-4 py-1.5 text-[10px] font-bold uppercase tracking-widest transition">
                        Beli Bundle
                    </button>
                </div>
            </div>

            <!-- Bundle 2 -->
            <div class="bg-luxury-card border border-luxury-borderGold rounded-sm p-6 flex flex-col justify-between relative">
                <div class="absolute top-3 right-3 text-[9px] tracking-widest uppercase text-luxury-gold font-bold">Best Value</div>
                <div>
                    <span class="text-[9px] uppercase tracking-widest text-luxury-gold block mb-2">Trio Connoisseur (3x 50ml)</span>
                    <h3 class="font-serif text-xl text-luxury-white mb-2">All-Occasion Wardrobe</h3>
                    <p class="text-luxury-textMuted text-xs mb-6 leading-relaxed">3 botol 50ml lengkap (Day, Night, Weekend) + Free Discovery Set + Bebas Ongkir.</p>
                </div>
                <div class="border-t border-luxury-border/60 pt-4 flex items-center justify-between">
                    <div>
                        <span class="text-luxury-textMuted text-[10px] line-through block">Rp 1.320.000</span>
                        <span class="text-luxury-white font-serif text-lg">Rp 1.100.000</span>
                    </div>
                    <button onclick="addToCart('All-Occasion Wardrobe (3x 50ml)', 1100000)" class="bg-luxury-gold text-black hover:bg-luxury-white px-4 py-1.5 text-[10px] font-bold uppercase tracking-widest transition">
                        Beli Trio Set
                    </button>
                </div>
            </div>

            <!-- Bundle 3 (Coupon Voucher) -->
            <div class="bg-luxury-dark border border-luxury-border rounded-sm p-6 flex flex-col justify-between">
                <div>
                    <span class="text-[9px] uppercase tracking-widest text-luxury-gold block mb-2">Welcome Privilege</span>
                    <h3 class="font-serif text-xl text-luxury-white mb-2">Voucher Member Pertama</h3>
                    <p class="text-luxury-textMuted text-xs mb-4 leading-relaxed">Potongan langsung Rp 50.000 untuk transaksi pertama di website {{ $client->brand_name }}.</p>
                    <div class="border border-dashed border-luxury-borderGold/60 p-2.5 text-center my-3">
                        <span class="font-mono text-luxury-gold font-bold text-sm tracking-widest">PARFUM50K</span>
                    </div>
                </div>
                <div class="border-t border-luxury-border/60 pt-4">
                    <button onclick="applyVoucherCode('PARFUM50K')" class="w-full border border-luxury-border hover:border-luxury-gold text-luxury-white py-2 text-[10px] font-bold uppercase tracking-widest transition">
                        Pasang Kupon ke Cart
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- SECTION 5: SISTEM PENJUALAN & SEAMLESS CHECKOUT -->
    <section id="sales-engine" class="py-24 px-6 md:px-12 max-w-7xl mx-auto border-b border-luxury-border/40" id="tour-sales">
        <div class="text-center max-w-3xl mx-auto mb-16">
            <span class="text-luxury-gold text-[10px] tracking-widest2 uppercase font-semibold block mb-2">Omnichannel E-Commerce</span>
            <h2 class="font-serif text-3xl md:text-5xl text-luxury-white font-normal mb-4">
                Sistem Penjualan <span class="italic text-luxury-gold">Tanpa Gesekan</span>
            </h2>
            <p class="text-luxury-textMuted text-xs md:text-sm leading-relaxed">
                Pengalaman checkout mandiri 24/7 yang cepat dan terintegrasi penuh dengan WhatsApp notifikasi serta dashboard POS kasir toko fisik.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="bg-luxury-dark border border-luxury-border p-8 rounded-sm">
                <span class="text-luxury-gold font-serif text-2xl block mb-4">01</span>
                <h3 class="font-serif text-lg text-luxury-white mb-2">1-Click Multi Payment</h3>
                <p class="text-luxury-textMuted text-xs leading-relaxed">
                    Pembayaran QRIS instan (Gopay, ShopeePay, Dana, BCA QR) dan Virtual Account semua bank terverifikasi otomatis dalam detik.
                </p>
            </div>

            <div class="bg-luxury-dark border border-luxury-border p-8 rounded-sm">
                <span class="text-luxury-gold font-serif text-2xl block mb-4">02</span>
                <h3 class="font-serif text-lg text-luxury-white mb-2">WhatsApp Order Engine</h3>
                <p class="text-luxury-textMuted text-xs leading-relaxed">
                    Customer dapat memilih checkout web biasa atau kirim draft invoice ke WhatsApp admin, lengkap dengan link pembayaran dan resi.
                </p>
            </div>

            <div class="bg-luxury-dark border border-luxury-border p-8 rounded-sm">
                <span class="text-luxury-gold font-serif text-2xl block mb-4">03</span>
                <h3 class="font-serif text-lg text-luxury-white mb-2">Sinkronisasi Kasir POS</h3>
                <p class="text-luxury-textMuted text-xs leading-relaxed">
                    Stok toko fisik dan website tersinkronisasi langsung. Dilengkapi laporan omset, profit, dan data customer terpusat.
                </p>
            </div>
        </div>
    </section>

    <!-- SECTION 6: RESELLER & MITRA (B2B) -->
    <section id="reseller" class="py-24 px-6 md:px-12 max-w-7xl mx-auto border-b border-luxury-border/40" id="tour-reseller">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div>
                <span class="text-luxury-gold text-[10px] tracking-widest2 uppercase font-semibold block mb-2">B2B Distribution</span>
                <h2 class="font-serif text-3xl md:text-5xl text-luxury-white font-normal mb-6">
                    Kembangkan Jaringan <br><span class="italic text-luxury-gold">Mitra & Reseller</span>
                </h2>
                <p class="text-luxury-textMuted text-xs md:text-sm leading-relaxed mb-6">
                    Portal pendaftaran agen, reseller stockist, dan affiliate resmi. Dilengkapi sistem komisi otomatis dan tiering diskon grosir langsung di website {{ $client->brand_name }}.
                </p>

                <div class="grid grid-cols-2 gap-4 text-xs text-luxury-textSubtle">
                    <div class="border-l border-luxury-gold/50 pl-3">
                        <p class="text-luxury-white font-semibold mb-0.5">Real-time Commission</p>
                        <p class="text-luxury-textMuted text-[11px]">Laporan penjualan affiliate transparan.</p>
                    </div>
                    <div class="border-l border-luxury-gold/50 pl-3">
                        <p class="text-luxury-white font-semibold mb-0.5">Tier Diskon Grosir</p>
                        <p class="text-luxury-textMuted text-[11px]">Harga otomatis turun saat qty bertambah.</p>
                    </div>
                </div>
            </div>

            <div class="bg-luxury-dark border border-luxury-border p-8 rounded-sm">
                <h3 class="font-serif text-lg text-luxury-white mb-4 text-center">Simulasi Pendaftaran Mitra</h3>
                <form class="space-y-3" onsubmit="event.preventDefault(); alert('Formulir kemitraan berhasil disimulasikan! Data otomatis masuk ke dashboard admin.');">
                    <input type="text" placeholder="Nama Lengkap" required class="w-full bg-luxury-black border border-luxury-border px-3 py-2.5 text-xs text-luxury-white focus:border-luxury-gold focus:outline-none rounded-sm">
                    <input type="tel" placeholder="Nomor WhatsApp" required class="w-full bg-luxury-black border border-luxury-border px-3 py-2.5 text-xs text-luxury-white focus:border-luxury-gold focus:outline-none rounded-sm">
                    <select class="w-full bg-luxury-black border border-luxury-border px-3 py-2.5 text-xs text-luxury-textSubtle focus:border-luxury-gold focus:outline-none rounded-sm">
                        <option>Reseller Stockist (Grosir)</option>
                        <option>Affiliate & Dropshipper</option>
                    </select>
                    <button type="submit" class="w-full bg-luxury-gold text-black py-2.5 text-[10px] font-bold uppercase tracking-widest hover:bg-luxury-white transition mt-2">
                        Ajukan Kemitraan
                    </button>
                </form>
            </div>
        </div>
    </section>

    <!-- SECTION 7: PROPOSAL CLOSING -->
    <section class="py-24 px-6 md:px-12 max-w-4xl mx-auto text-center">
        <span class="text-luxury-gold text-[10px] tracking-widest2 uppercase font-semibold block mb-2">Exclusive Development Proposal</span>
        <h2 class="font-serif text-3xl md:text-5xl text-luxury-white font-normal mb-6">
            Siap Membangun Ekosistem Digital <br><span class="italic text-luxury-gold">{{ $client->brand_name }}</span>?
        </h2>
        <p class="text-luxury-textMuted text-xs md:text-sm max-w-xl mx-auto mb-10 leading-relaxed">
            Seluruh fitur dan arsitektur di atas siap dikembangkan dan disesuaikan dengan identitas brand Anda.
        </p>

        <div class="flex flex-col sm:flex-row justify-center gap-4">
            <a href="{{ route('proposal.dynamic', $client->slug) }}" class="bg-luxury-gold text-black px-8 py-3.5 rounded-sm text-[10px] font-bold tracking-widest uppercase hover:bg-luxury-white transition duration-300 shadow-xl">
                Buka Proposal Bisnis Lengkap
            </a>
            <a href="{{ route('demo.admin.parfum', $client->slug) ?? '#' }}" class="border border-luxury-border hover:border-luxury-gold text-luxury-white px-8 py-3.5 rounded-sm text-[10px] font-medium tracking-widest uppercase transition bg-luxury-dark">
                Coba Dashboard Admin & POS
            </a>
        </div>
    </section>

    <!-- Footer -->
    <footer class="border-t border-luxury-border/40 py-12 px-6 text-center text-xs text-luxury-textMuted">
        <p class="font-serif text-xl tracking-[0.2em] text-luxury-white uppercase mb-2">{{ $client->brand_name }}</p>
        <p class="text-[10px] tracking-widest uppercase text-luxury-gold mb-6">Haute Parfumerie & Lifestyle</p>
        <p class="text-[10px] text-luxury-textMuted">&copy; 2026 {{ $client->brand_name }}. E-Commerce & Membership Architecture by Scalify Intelligence.</p>
    </footer>

    <!-- INTERACTIVE TOUR UI OVERLAY -->
    <div id="tour-overlay"></div>
    <div id="tour-tooltip" class="flex flex-col">
        <div class="flex items-center gap-2 mb-3">
            <div class="w-5 h-5 rounded-full bg-luxury-gold text-black flex items-center justify-center font-bold text-[10px]" id="tour-step-indicator">1</div>
            <h4 class="font-serif font-bold text-sm text-luxury-gold flex-1" id="tour-title">Judul Tour</h4>
            <button onclick="closeTour()" class="text-luxury-textMuted hover:text-white transition"><i class="fas fa-times text-xs"></i></button>
        </div>
        <p class="text-xs text-luxury-textSubtle mb-5 leading-relaxed" id="tour-content">Isi petunjuk tour.</p>
        <div class="flex justify-between items-center mt-auto border-t border-luxury-border pt-3">
            <button id="tour-prev" onclick="prevStep()" class="text-[10px] font-semibold text-luxury-textMuted hover:text-white transition invisible uppercase tracking-wider">Sebelumnya</button>
            <button id="tour-next" onclick="nextStep()" class="bg-luxury-gold text-black px-3.5 py-1 rounded text-[10px] font-bold uppercase tracking-wider hover:bg-white transition">Selanjutnya</button>
        </div>
    </div>

    <!-- MODAL 1: Scent Quiz Modal -->
    <div id="quizModal" class="fixed inset-0 z-[150] bg-black/85 backdrop-blur-md hidden items-center justify-center p-4 transition-all">
        <div class="bg-luxury-dark border border-luxury-border w-full max-w-lg rounded-sm shadow-2xl flex flex-col relative overflow-hidden">
            <button onclick="closeQuizModal()" class="absolute top-4 right-4 text-luxury-textMuted hover:text-white z-10"><i class="fas fa-times"></i></button>

            <div class="p-8 text-center">
                <span class="text-luxury-gold text-[9px] font-semibold tracking-widest uppercase mb-2 block">Matchmaker Scent Selector</span>
                <h3 class="font-serif text-2xl text-luxury-white mb-2">Pilih Karakter Wewangian Anda</h3>
                <p class="text-luxury-textMuted text-xs mb-6">Pilih suasana yang paling mencerminkan preferensi harian Anda.</p>

                <div class="grid grid-cols-2 gap-3 text-left mb-6" id="quiz-options">
                    <div onclick="selectQuizOption(this, 'Midnight Enigma (50ml)', 450000)" class="border border-luxury-border hover:border-luxury-gold bg-luxury-black p-4 rounded-sm cursor-pointer transition">
                        <span class="text-luxury-gold font-serif text-sm block mb-1">Night & Gala</span>
                        <p class="text-luxury-textSubtle text-[11px]">Aroma hangat tembakau, cedarwood, dan vanilla.</p>
                    </div>
                    <div onclick="selectQuizOption(this, 'Ethereal Bloom (50ml)', 450000)" class="border border-luxury-border hover:border-luxury-gold bg-luxury-black p-4 rounded-sm cursor-pointer transition">
                        <span class="text-luxury-gold font-serif text-sm block mb-1">Romantic Floral</span>
                        <p class="text-luxury-textSubtle text-[11px]">Mawar Turki, lychee segar, dan white musk.</p>
                    </div>
                    <div onclick="selectQuizOption(this, 'Oceanic Azure (50ml)', 420000)" class="border border-luxury-border hover:border-luxury-gold bg-luxury-black p-4 rounded-sm cursor-pointer transition">
                        <span class="text-luxury-gold font-serif text-sm block mb-1">Fresh Aquatic</span>
                        <p class="text-luxury-textSubtle text-[11px]">Sea salt, sage mineral, dan grapefruit segar.</p>
                    </div>
                    <div onclick="selectQuizOption(this, 'Discovery Set (5x 3ml)', 150000)" class="border border-luxury-border hover:border-luxury-gold bg-luxury-black p-4 rounded-sm cursor-pointer transition">
                        <span class="text-luxury-gold font-serif text-sm block mb-1">Discovery Set</span>
                        <p class="text-luxury-textSubtle text-[11px]">Coba kelima varian tester dengan cashback 100%.</p>
                    </div>
                </div>

                <div id="quiz-result" class="hidden bg-luxury-black border border-luxury-borderGold p-4 rounded-sm mb-4">
                    <p class="text-[10px] text-luxury-gold uppercase tracking-wider mb-1">Rekomendasi Terbaik:</p>
                    <p class="text-luxury-white font-serif text-base" id="quiz-rec-name">Midnight Enigma</p>
                    <button id="quiz-add-btn" class="mt-3 bg-luxury-gold text-black px-5 py-2 text-[10px] font-bold uppercase tracking-widest hover:bg-white transition">
                        Tambahkan ke Bag
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL 2: Cart Bag Drawer -->
    <div id="cartModal" class="fixed inset-0 z-[160] bg-black/85 backdrop-blur-md hidden items-center justify-end p-0 transition-all">
        <div class="bg-luxury-dark border-l border-luxury-border w-full max-w-md h-full shadow-2xl flex flex-col relative">
            <div class="p-6 border-b border-luxury-border flex justify-between items-center bg-luxury-black">
                <span class="font-serif text-base text-luxury-white uppercase tracking-wider">Shopping Bag</span>
                <button onclick="closeCartModal()" class="text-luxury-textMuted hover:text-white"><i class="fas fa-times"></i></button>
            </div>

            <!-- List Cart Items -->
            <div class="p-6 flex-1 overflow-y-auto space-y-3" id="cart-items">
                <!-- Injected via JS -->
            </div>

            <!-- Cart Footer -->
            <div class="p-6 border-t border-luxury-border bg-luxury-black">
                <div class="flex gap-2 mb-4">
                    <input type="text" id="voucher-input" placeholder="Kode Kupon (PARFUM50K)" class="flex-1 bg-luxury-dark border border-luxury-border px-3 py-2 text-xs text-luxury-white uppercase focus:border-luxury-gold focus:outline-none">
                    <button onclick="applyVoucherManual()" class="border border-luxury-gold text-luxury-gold px-4 py-2 text-[10px] font-bold uppercase tracking-wider hover:bg-luxury-gold hover:text-black transition">
                        Gunakan
                    </button>
                </div>

                <div id="discount-row" class="hidden justify-between text-luxury-gold text-xs mb-2">
                    <span>Diskon Kupon</span>
                    <span id="discount-amount">- Rp 50.000</span>
                </div>

                <div class="flex justify-between text-luxury-textSubtle text-sm mb-4">
                    <span>Subtotal</span>
                    <span id="cart-subtotal" class="font-serif font-medium text-luxury-white">Rp 0</span>
                </div>

                <button onclick="proceedToCheckout()" class="w-full bg-luxury-gold text-black py-3.5 text-[10px] font-bold uppercase tracking-widest hover:bg-luxury-white transition duration-300">
                    Lanjut ke Checkout
                </button>
            </div>
        </div>
    </div>

    <!-- MODAL 3: Checkout Modal -->
    <div id="checkoutModal" class="fixed inset-0 z-[170] bg-black/90 backdrop-blur-md hidden items-center justify-center p-4 transition-all">
        <div class="bg-luxury-dark border border-luxury-border w-full max-w-2xl rounded-sm shadow-2xl flex flex-col relative overflow-hidden">
            <div class="p-6 border-b border-luxury-border flex justify-between items-center bg-luxury-black">
                <span class="font-serif text-base text-luxury-white">Checkout & Payment Simulation</span>
                <button onclick="closeCheckoutModal()" class="text-luxury-textMuted hover:text-white"><i class="fas fa-times"></i></button>
            </div>

            <div class="flex flex-col md:flex-row">
                <div class="p-6 w-full md:w-1/2 border-r border-luxury-border">
                    <span class="text-[10px] tracking-widest uppercase text-luxury-gold block mb-3 font-semibold">1. Pengiriman</span>
                    <div class="space-y-2 mb-6 text-xs">
                        <input type="text" value="Rangga Dirgantara" class="w-full bg-luxury-black border border-luxury-border p-2 text-luxury-white rounded-sm" readonly>
                        <input type="text" value="SCBD Suites Lt. 18, Jakarta Selatan" class="w-full bg-luxury-black border border-luxury-border p-2 text-luxury-white rounded-sm" readonly>
                        <select class="w-full bg-luxury-black border border-luxury-border p-2 text-luxury-white rounded-sm">
                            <option>SiCepat BEST (Express) - Rp 20.000</option>
                            <option>JNE Regular - Rp 15.000</option>
                        </select>
                    </div>

                    <span class="text-[10px] tracking-widest uppercase text-luxury-gold block mb-3 font-semibold">2. Pembayaran</span>
                    <div class="space-y-2 text-xs">
                        <label class="flex items-center gap-2 p-2 border border-luxury-borderGold bg-luxury-black rounded-sm cursor-pointer">
                            <input type="radio" name="payment" checked class="accent-luxury-gold">
                            <span class="text-luxury-white font-medium">QRIS Instan (Semua E-Wallet)</span>
                        </label>
                        <label class="flex items-center gap-2 p-2 border border-luxury-border bg-luxury-black rounded-sm cursor-pointer">
                            <input type="radio" name="payment" class="accent-luxury-gold">
                            <span class="text-luxury-textSubtle">Virtual Account Bank</span>
                        </label>
                    </div>
                </div>

                <div class="p-6 w-full md:w-1/2 bg-luxury-black flex flex-col items-center justify-center text-center">
                    <span class="text-[10px] uppercase tracking-wider text-luxury-textMuted mb-1">Total Transaksi</span>
                    <p class="text-2xl font-serif text-luxury-white mb-4" id="checkout-total">Rp 0</p>

                    <div class="bg-white p-2.5 rounded-sm mb-4 inline-block">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/d/d0/QR_code_for_mobile_English_Wikipedia.svg" class="w-28 h-28 opacity-90 mix-blend-multiply" alt="QRIS">
                    </div>

                    <button onclick="simulatePaymentSuccess()" class="w-full bg-luxury-gold text-black py-2.5 text-[10px] font-bold uppercase tracking-widest hover:bg-luxury-white transition">
                        Simulasikan Bayar Sukses
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL 4: Success Modal -->
    <div id="successModal" class="fixed inset-0 z-[180] bg-black/90 backdrop-blur-md hidden items-center justify-center p-4 transition-all">
        <div class="bg-luxury-dark border border-luxury-border w-full max-w-md rounded-sm p-8 text-center relative">
            <button onclick="closeSuccessModal()" class="absolute top-4 right-4 text-luxury-textMuted hover:text-white"><i class="fas fa-times"></i></button>

            <span class="text-luxury-gold text-2xl font-serif block mb-2">✦</span>
            <h3 class="font-serif text-2xl text-luxury-white mb-1">Pembayaran Diterima</h3>
            <p class="text-luxury-textMuted text-xs mb-6">Order ID: <span class="text-luxury-white font-mono">#ORD-9982</span> • Resi otomatis dikirim via WhatsApp.</p>

            <div class="bg-luxury-black border border-luxury-borderGold p-4 rounded-sm text-left mb-6">
                <span class="text-[10px] uppercase tracking-wider text-luxury-gold block mb-1">Loyalty Points Earned</span>
                <p class="text-luxury-white text-xs">+450 Poin ditambahkan ke akun Anda.</p>
            </div>

            <button onclick="closeSuccessModal(); openMemberModal();" class="w-full bg-luxury-gold text-black py-3 text-[10px] font-bold uppercase tracking-widest hover:bg-luxury-white transition">
                Buka Member Area
            </button>
        </div>
    </div>

    <!-- MODAL 5: Member Dashboard Modal -->
    <div id="memberModal" class="fixed inset-0 z-[160] bg-black/90 backdrop-blur-md hidden items-center justify-center p-4 transition-all">
        <div class="bg-luxury-dark border border-luxury-border w-full max-w-2xl rounded-sm shadow-2xl flex flex-col relative overflow-hidden">
            <div class="p-5 border-b border-luxury-border flex justify-between items-center bg-luxury-black">
                <span class="font-serif text-base text-luxury-white">Member & Loyalty Club — {{ $client->brand_name }}</span>
                <button onclick="closeMemberModal()" class="text-luxury-textMuted hover:text-white"><i class="fas fa-times"></i></button>
            </div>

            <div class="flex flex-col md:flex-row">
                <div class="p-6 w-full md:w-1/3 bg-luxury-black border-r border-luxury-border text-center">
                    <div class="w-16 h-16 rounded-full border border-luxury-borderGold mx-auto mb-3 flex items-center justify-center text-luxury-gold font-serif text-xl">
                        R
                    </div>
                    <h4 class="text-luxury-white text-sm font-serif">Rangga Dirgantara</h4>
                    <span class="text-[9px] uppercase tracking-widest text-luxury-gold block mt-1 mb-4">Gold VIP Member</span>

                    <div class="border border-luxury-border p-3 text-center mb-4">
                        <span class="text-[9px] uppercase tracking-wider text-luxury-textMuted block">Saldo Poin</span>
                        <span class="text-2xl font-serif text-luxury-white font-medium" id="member-points">1,700</span>
                        <span class="text-[9px] text-luxury-textMuted block mt-0.5">= Rp 170.000</span>
                    </div>
                </div>

                <div class="p-6 w-full md:w-2/3 bg-luxury-dark">
                    <span class="text-[10px] uppercase tracking-widest text-luxury-gold block mb-3 font-semibold">Riwayat Pesanan</span>
                    <div class="border border-luxury-border p-3 bg-luxury-black text-xs space-y-1">
                        <div class="flex justify-between font-mono text-luxury-gold">
                            <span>#ORD-9982</span>
                            <span class="text-luxury-white">Rp 620.000</span>
                        </div>
                        <p class="text-luxury-textSubtle text-[11px]">1x Midnight Enigma (50ml) • 1x Discovery Set</p>
                        <p class="text-luxury-textMuted text-[10px]">Kurir: SiCepat (Resi: 0029381902) • Dikirim</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- SCRIPTS -->
    <script>
        let cart = [
            { name: 'Midnight Enigma (50ml)', price: 450000 },
            { name: 'Discovery Set (5x 3ml)', price: 150000 }
        ];
        let discount = 0;

        function formatRupiah(num) {
            return new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0
            }).format(num);
        }

        function updateCartUI() {
            const cartItemsEl = document.getElementById('cart-items');
            const cartSubtotalEl = document.getElementById('cart-subtotal');
            const cartBadge = document.getElementById('cart-badge');
            const discountRow = document.getElementById('discount-row');
            const discountAmountEl = document.getElementById('discount-amount');

            cartItemsEl.innerHTML = '';
            let rawTotal = 0;

            if (cart.length === 0) {
                cartItemsEl.innerHTML = '<p class="text-center text-luxury-textMuted text-xs py-10">Bag Anda masih kosong.</p>';
            } else {
                cart.forEach((item, index) => {
                    rawTotal += item.price;
                    cartItemsEl.innerHTML += `
                        <div class="flex justify-between items-center border border-luxury-border p-3 bg-luxury-black">
                            <div>
                                <h5 class="text-luxury-white text-xs font-serif">${item.name}</h5>
                                <p class="text-luxury-gold text-[11px]">${formatRupiah(item.price)}</p>
                            </div>
                            <button onclick="removeFromCart(${index})" class="text-luxury-textMuted hover:text-red-400 text-xs p-1">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </div>
                    `;
                });
            }

            if (discount > 0) {
                discountRow.classList.remove('hidden');
                discountRow.classList.add('flex');
                discountAmountEl.innerText = '- ' + formatRupiah(discount);
            } else {
                discountRow.classList.add('hidden');
                discountRow.classList.remove('flex');
            }

            const finalTotal = Math.max(0, rawTotal - discount);
            cartSubtotalEl.innerText = formatRupiah(finalTotal);
            document.getElementById('checkout-total').innerText = formatRupiah(finalTotal + 20000);
            cartBadge.innerText = cart.length;
        }

        function addToCart(name, price) {
            cart.push({ name, price });
            updateCartUI();

            const toast = document.createElement('div');
            toast.className = 'fixed top-20 right-6 bg-luxury-card border border-luxury-borderGold text-luxury-white px-5 py-3 rounded-sm shadow-2xl z-[200] text-xs uppercase tracking-wider flex items-center gap-2';
            toast.innerHTML = `<span class="text-luxury-gold">✦</span> Ditambahkan ke bag: ${name}`;
            document.body.appendChild(toast);
            setTimeout(() => toast.remove(), 2000);
        }

        function removeFromCart(index) {
            cart.splice(index, 1);
            updateCartUI();
        }

        function applyVoucherCode(code) {
            discount = 50000;
            updateCartUI();
            openCartModal();
        }

        function applyVoucherManual() {
            const val = document.getElementById('voucher-input').value.trim().toUpperCase();
            if (val === 'PARFUM50K' || val === 'PROMO50') {
                discount = 50000;
                updateCartUI();
                alert('Voucher Rp 50.000 berhasil diterapkan.');
            } else {
                alert('Kode voucher tidak ditemukan.');
            }
        }

        function openCartModal() {
            document.getElementById('cartModal').classList.remove('hidden');
            document.getElementById('cartModal').classList.add('flex');
        }
        function closeCartModal() {
            document.getElementById('cartModal').classList.add('hidden');
            document.getElementById('cartModal').classList.remove('flex');
        }

        function proceedToCheckout() {
            if (cart.length === 0) return alert('Bag masih kosong.');
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
            document.getElementById('member-points').innerText = "2,150";
            cart = [];
            discount = 0;
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

        function openQuizModal() {
            document.getElementById('quizModal').classList.remove('hidden');
            document.getElementById('quizModal').classList.add('flex');
        }
        function closeQuizModal() {
            document.getElementById('quizModal').classList.add('hidden');
            document.getElementById('quizModal').classList.remove('flex');
        }

        function selectQuizOption(el, name, price) {
            document.querySelectorAll('#quiz-options > div').forEach(d => {
                d.classList.remove('border-luxury-gold');
            });
            el.classList.add('border-luxury-gold');

            document.getElementById('quiz-result').classList.remove('hidden');
            document.getElementById('quiz-rec-name').innerText = name;
            document.getElementById('quiz-add-btn').onclick = function() {
                addToCart(name, price);
                closeQuizModal();
                openCartModal();
            };
        }

        // Live Countdown Simulation
        let timeLeft = (8 * 3600) + (42 * 60) + 19;
        setInterval(() => {
            if (timeLeft > 0) {
                timeLeft--;
                const h = Math.floor(timeLeft / 3600);
                const m = Math.floor((timeLeft % 3600) / 60);
                const s = timeLeft % 60;
                document.getElementById('timer-hours').innerText = String(h).padStart(2, '0');
                document.getElementById('timer-mins').innerText = String(m).padStart(2, '0');
                document.getElementById('timer-secs').innerText = String(s).padStart(2, '0');
            }
        }, 1000);

        // Tour Logic
        const tourSteps = [
            {
                elementId: 'best-seller',
                title: '1. Sistem Best & Top Seller',
                content: 'Katalog terstruktur dengan piramida aroma (Top, Heart, Base) dan estimasi ketahanan untuk meyakinkan pembeli online.'
            },
            {
                elementId: 'membership',
                title: '2. Membership & Poin Loyalty',
                content: 'Sistem akumulasi poin reward dan tiering (Bronze, Silver, Gold VIP) untuk mengunci repeat buyer.'
            },
            {
                elementId: 'discovery',
                title: '3. Discovery Set (Anti Blind-Buy)',
                content: 'Solusi blind buy: customer membeli paket 5 varian tester dan mendapatkan cashback 100% saat membeli full bottle.'
            },
            {
                elementId: 'bundling',
                title: '4. Curated Bundles & Flash Sale',
                content: 'Paket bundling untuk menaikkan Average Order Value (AOV) dan fitur kupon voucher otomatis.'
            },
            {
                elementId: 'sales-engine',
                title: '5. Fast Checkout & Kasir POS',
                content: 'Multi-payment QRIS & VA instan, notifikasi WhatsApp otomatis, dan sinkronisasi stok toko fisik.'
            },
            {
                elementId: 'reseller',
                title: '6. Portal Kemitraan Reseller',
                content: 'Sistem komisi dan harga grosir otomatis untuk merekrut agen & affiliate.'
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
                targetEl.scrollIntoView({ behavior: 'smooth', block: 'center' });

                setTimeout(() => {
                    targetEl.classList.add('tour-highlight');
                    const rect = targetEl.getBoundingClientRect();
                    let top = rect.bottom + window.scrollY + 15;
                    let left = rect.left + window.scrollX;

                    if (rect.bottom + 200 > window.innerHeight) {
                        top = rect.top + window.scrollY - 180;
                    }

                    if (window.innerWidth < 500) {
                        left = 16;
                        tooltip.style.width = (window.innerWidth - 32) + 'px';
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

        function prevStep() {
            if (currentStep > 0) {
                currentStep--;
                showStep(currentStep);
            }
        }

        updateCartUI();
    </script>
</body>
</html>
