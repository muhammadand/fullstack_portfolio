<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sewa Mobil & Transportasi - {{ $client->brand_name }}</title>
    <meta name="description" content="Layanan sewa mobil profesional dan terpercaya oleh {{ $client->brand_name }}.">

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            blue: '#0d6efd', // Vibrant blue like the image
                            dark: '#212529', // Dark text
                            light: '#f8f9fa', // Light bg
                            gray: '#6c757d', // Gray text
                            border: '#dee2e6'
                        }
                    }
                    , fontFamily: {
                        sans: ['Inter', 'sans-serif']
                    , }
                }
            }
        }

    </script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body {
            font-family: 'Inter', sans-serif;
            color: #212529;
            background-color: #f8f9fa;
        }

        .hide-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .hide-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        /* Tour Overlay Styles */
        #tour-overlay {
            position: fixed;
            inset: 0;
            background: rgba(33, 37, 41, 0.8);
            z-index: 9998;
            display: none;
        }

        .tour-highlight {
            position: relative;
            z-index: 9999 !important;
            box-shadow: 0 0 0 4px rgba(13, 110, 253, 0.5);
            border-radius: 0.5rem;
            background-color: white;
            pointer-events: none;
        }

        #tour-tooltip {
            position: absolute;
            z-index: 10000;
            background: white;
            padding: 1.25rem;
            border-radius: 0.75rem;
            width: 300px;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
            display: none;
            transition: all 0.3s ease;
        }

    </style>
</head>
<body class="antialiased pb-20">

    <!-- Top Navbar -->
    <nav class="bg-white border-b border-brand-border py-3 px-6 md:px-12 flex justify-between items-center sticky top-0 z-50">
        <div class="flex items-center gap-2">
            <div class="w-8 h-8 rounded bg-brand-blue flex items-center justify-center text-white">
                <i class="fas fa-car"></i>
            </div>
            <h1 class="font-bold text-brand-dark text-lg tracking-tight">{{ strtoupper($client->brand_name) }}</h1>
        </div>

        <div class="hidden lg:flex items-center gap-6 text-[13px] font-medium text-brand-gray">
            <a href="#" class="text-brand-blue font-semibold border-b-2 border-brand-blue pb-1">Home</a>
            <a href="#armada" class="hover:text-brand-blue transition">Browse Cars</a>
            <a href="#layanan" class="hover:text-brand-blue transition">Services</a>
            <a href="#syarat" class="hover:text-brand-blue transition">Financing</a>
            <a href="#" class="hover:text-brand-blue transition">About Us</a>
            <a href="#" class="hover:text-brand-blue transition">Contact</a>
        </div>

        <div class="hidden lg:flex items-center gap-4 text-[13px]">
            <a href="#" class="text-brand-dark hover:text-brand-blue font-medium"><i class="far fa-heart mr-1"></i> Sign In</a>
            <a href="{{ route('proposal.dynamic', $client->slug) }}" class="bg-brand-blue hover:bg-blue-700 text-white px-4 py-2 rounded font-medium transition">
                View Proposal
            </a>
        </div>
    </nav>

    <!-- Floating Admin Demo Button -->
    <a href="{{ route('demo.admin.rental', $client->slug) }}" class="fixed bottom-6 right-6 z-[100] bg-brand-dark hover:bg-black text-white px-5 py-3 rounded-full shadow-xl flex items-center gap-3 transform hover:scale-105 transition-all group animate-bounce">
        <div class="w-7 h-7 rounded-full bg-white/20 flex items-center justify-center"><i class="fas fa-laptop-code text-xs"></i></div>
        <div class="flex flex-col">
            <span class="text-[9px] text-gray-300 uppercase tracking-widest leading-none mb-1 group-hover:text-white">Simulasi Pemilik</span>
            <span class="leading-none text-[13px] font-semibold">Dashboard Admin</span>
        </div>
    </a>

    <!-- Floating Tour Button -->
    <button onclick="startTour()" class="fixed bottom-20 right-6 z-[100] bg-white border border-brand-blue text-brand-blue hover:bg-blue-50 px-4 py-2.5 rounded-full shadow-lg text-[13px] font-semibold transition-all flex items-center gap-2">
        <i class="fas fa-play-circle"></i> Mulai Panduan
    </button>

    <!-- Hero Section -->
    <section class="bg-white relative pt-12 pb-32 px-6 md:px-12 flex flex-col items-center border-b border-brand-border">
        <div class="max-w-5xl mx-auto w-full text-center relative z-10">
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold text-brand-dark leading-tight mb-4 tracking-tight">
                Find Your Perfect Car<br>
                Drive Your <span class="text-brand-blue">Dreams</span>
            </h1>

            <p class="text-brand-gray text-[14px] md:text-[15px] mb-8 max-w-2xl mx-auto leading-relaxed" id="tour-welcome">
                Explore thousands of verified cars from trusted sellers. Best prices. Easy financing. Drive with confidence.
            </p>

            <div class="flex flex-wrap justify-center gap-3 mb-10" id="tour-booking-cta">
                <button onclick="document.getElementById('armada').scrollIntoView()" class="bg-brand-blue hover:bg-blue-700 text-white px-6 py-2.5 rounded text-[13px] font-semibold transition">
                    Browse Cars
                </button>
                <a href="#armada" class="bg-white hover:bg-gray-50 border border-brand-border text-brand-dark px-6 py-2.5 rounded text-[13px] font-semibold transition">
                    Sell Your Car
                </a>
            </div>

            <!-- Trust Badges -->
            <div class="flex flex-wrap justify-center gap-8 md:gap-12 text-left mb-12">
                <div class="flex items-center gap-3">
                    <i class="fas fa-car-side text-brand-blue text-xl"></i>
                    <div>
                        <p class="text-[13px] font-bold text-brand-dark">10,000+</p>
                        <p class="text-[11px] text-brand-gray">Cars Listed</p>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <i class="fas fa-user-check text-brand-blue text-xl"></i>
                    <div>
                        <p class="text-[13px] font-bold text-brand-dark">Trusted Sellers</p>
                        <p class="text-[11px] text-brand-gray">Verified & Reviewed</p>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <i class="fas fa-tags text-brand-blue text-xl"></i>
                    <div>
                        <p class="text-[13px] font-bold text-brand-dark">Best Prices</p>
                        <p class="text-[11px] text-brand-gray">Market Competitive</p>
                    </div>
                </div>
            </div>

            <!-- Hero Image / Cars -->
            <div class="relative w-full max-w-4xl mx-auto h-48 md:h-64 mt-4">
                <img src="https://images.unsplash.com/photo-1549317661-bd32c8ce0db2?auto=format&fit=crop&q=80&w=1200" class="absolute inset-0 w-full h-full object-cover rounded-xl shadow-lg border border-gray-100 opacity-90" style="object-position: center 70%;">
                <div class="absolute inset-0 bg-gradient-to-t from-white via-white/20 to-transparent rounded-xl"></div>
            </div>
        </div>

        <!-- Floating Search Bar -->
        <div class="max-w-4xl w-full mx-auto bg-white rounded-xl shadow-xl border border-brand-border absolute -bottom-16 left-1/2 transform -translate-x-1/2 z-20" id="tour-filter">
            <div class="flex border-b border-brand-border">
                <button class="flex items-center gap-2 px-6 py-3.5 bg-brand-blue text-white text-[13px] font-semibold rounded-tl-xl">
                    <i class="fas fa-search"></i> Search Cars
                </button>
                <button class="flex items-center gap-2 px-6 py-3.5 text-brand-gray hover:text-brand-dark text-[13px] font-medium border-r border-brand-border">
                    <i class="fas fa-car"></i> Body Type
                </button>
                <button class="flex items-center gap-2 px-6 py-3.5 text-brand-gray hover:text-brand-dark text-[13px] font-medium border-r border-brand-border">
                    <i class="fas fa-tag"></i> Price Range
                </button>
            </div>
            <div class="p-4 flex flex-wrap md:flex-nowrap gap-3 items-end">
                <div class="flex-1 min-w-[120px]">
                    <label class="block text-[11px] text-brand-gray mb-1">Make</label>
                    <select class="w-full text-[13px] border border-brand-border rounded px-3 py-2 text-brand-dark focus:outline-none focus:border-brand-blue">
                        <option>All Makes</option>
                        <option>Toyota</option>
                        <option>Honda</option>
                    </select>
                </div>
                <div class="flex-1 min-w-[120px]">
                    <label class="block text-[11px] text-brand-gray mb-1">Model</label>
                    <select class="w-full text-[13px] border border-brand-border rounded px-3 py-2 text-brand-dark focus:outline-none focus:border-brand-blue">
                        <option>All Models</option>
                    </select>
                </div>
                <div class="flex-1 min-w-[120px]">
                    <label class="block text-[11px] text-brand-gray mb-1">Max Price</label>
                    <select class="w-full text-[13px] border border-brand-border rounded px-3 py-2 text-brand-dark focus:outline-none focus:border-brand-blue">
                        <option>No Max</option>
                    </select>
                </div>
                <button class="bg-brand-blue text-white px-6 py-2 rounded text-[13px] font-semibold h-[38px] w-full md:w-auto">
                    Search
                </button>
            </div>
        </div>
    </section>

    <!-- Featured Listings -->
    <section id="armada" class="pt-28 pb-16 px-6 md:px-12 max-w-6xl mx-auto">
        <div class="flex justify-between items-end mb-6">
            <h2 class="text-xl font-bold text-brand-dark">Featured Listings</h2>
            <a href="#" class="text-[13px] text-brand-blue font-medium hover:underline">View All Vehicles</a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
            <!-- Car 1 -->
            <div class="bg-white rounded-lg border border-brand-border overflow-hidden group hover:shadow-lg transition">
                <div class="relative h-40 bg-gray-100">
                    <img src="https://images.unsplash.com/photo-1542282088-fe8426682b8f?auto=format&fit=crop&q=80&w=400" class="w-full h-full object-cover">
                    <button class="absolute top-2 right-2 w-7 h-7 bg-white/80 rounded-full flex items-center justify-center text-gray-500 hover:text-red-500">
                        <i class="far fa-heart text-xs"></i>
                    </button>
                </div>
                <div class="p-4">
                    <h3 class="font-bold text-[14px] text-brand-dark mb-0.5 truncate">2023 Toyota Avanza</h3>
                    <p class="text-[11px] text-brand-gray mb-2">1.5 G CVT</p>
                    <p class="font-bold text-brand-blue text-lg mb-3">Rp 350.000 <span class="text-[10px] font-normal text-brand-gray">/hari</span></p>

                    <div class="grid grid-cols-2 gap-2 text-[10px] text-brand-gray border-t border-brand-border pt-3 mb-3">
                        <div class="flex items-center gap-1.5"><i class="fas fa-tachometer-alt"></i> 15,000 km</div>
                        <div class="flex items-center gap-1.5"><i class="fas fa-cog"></i> Automatic</div>
                        <div class="flex items-center gap-1.5"><i class="fas fa-gas-pump"></i> Bensin</div>
                        <div class="flex items-center gap-1.5"><i class="fas fa-map-marker-alt"></i> Jakarta</div>
                    </div>
                    <button onclick="openBookingModal()" class="w-full bg-brand-blue/10 text-brand-blue hover:bg-brand-blue hover:text-white py-2 rounded text-[12px] font-semibold transition">
                        Pesan Sekarang
                    </button>
                </div>
            </div>

            <!-- Car 2 -->
            <div class="bg-white rounded-lg border border-brand-border overflow-hidden group hover:shadow-lg transition">
                <div class="relative h-40 bg-gray-100">
                    <img src="https://images.unsplash.com/photo-1609521263047-f8f205293f24?auto=format&fit=crop&q=80&w=400" class="w-full h-full object-cover">
                    <button class="absolute top-2 right-2 w-7 h-7 bg-white/80 rounded-full flex items-center justify-center text-gray-500 hover:text-red-500">
                        <i class="far fa-heart text-xs"></i>
                    </button>
                </div>
                <div class="p-4">
                    <h3 class="font-bold text-[14px] text-brand-dark mb-0.5 truncate">2022 Honda Brio</h3>
                    <p class="text-[11px] text-brand-gray mb-2">RS Urbanite</p>
                    <p class="font-bold text-brand-blue text-lg mb-3">Rp 300.000 <span class="text-[10px] font-normal text-brand-gray">/hari</span></p>

                    <div class="grid grid-cols-2 gap-2 text-[10px] text-brand-gray border-t border-brand-border pt-3 mb-3">
                        <div class="flex items-center gap-1.5"><i class="fas fa-tachometer-alt"></i> 22,100 km</div>
                        <div class="flex items-center gap-1.5"><i class="fas fa-cog"></i> Automatic</div>
                        <div class="flex items-center gap-1.5"><i class="fas fa-gas-pump"></i> Bensin</div>
                        <div class="flex items-center gap-1.5"><i class="fas fa-map-marker-alt"></i> Bandung</div>
                    </div>
                    <button onclick="openBookingModal()" class="w-full bg-brand-blue/10 text-brand-blue hover:bg-brand-blue hover:text-white py-2 rounded text-[12px] font-semibold transition">
                        Pesan Sekarang
                    </button>
                </div>
            </div>

            <!-- Car 3 (Booked) -->
            <div class="bg-white rounded-lg border border-brand-border overflow-hidden group" id="tour-booked-car">
                <div class="relative h-40 bg-gray-100">
                    <img src="https://images.unsplash.com/photo-1533473359331-0135ef1b58bf?auto=format&fit=crop&q=80&w=400" class="w-full h-full object-cover grayscale opacity-80">
                    <div class="absolute inset-0 bg-black/30 flex items-center justify-center flex-col">
                        <span class="text-white font-bold text-[10px] bg-brand-dark px-2 py-1 rounded">DISEWA S/D 25 AGUST</span>
                    </div>
                </div>
                <div class="p-4 opacity-70">
                    <h3 class="font-bold text-[14px] text-brand-dark mb-0.5 truncate">2021 Toyota Innova</h3>
                    <p class="text-[11px] text-brand-gray mb-2">Reborn 2.4 G</p>
                    <p class="font-bold text-brand-dark text-lg mb-3">Rp 550.000 <span class="text-[10px] font-normal text-brand-gray">/hari</span></p>

                    <div class="grid grid-cols-2 gap-2 text-[10px] text-brand-gray border-t border-brand-border pt-3 mb-3">
                        <div class="flex items-center gap-1.5"><i class="fas fa-tachometer-alt"></i> 41,000 km</div>
                        <div class="flex items-center gap-1.5"><i class="fas fa-cog"></i> Automatic</div>
                        <div class="flex items-center gap-1.5"><i class="fas fa-gas-pump"></i> Diesel</div>
                        <div class="flex items-center gap-1.5"><i class="fas fa-map-marker-alt"></i> Jakarta</div>
                    </div>
                    <button disabled class="w-full bg-gray-100 text-gray-400 py-2 rounded text-[12px] font-semibold cursor-not-allowed border border-brand-border">
                        Telah Disewa
                    </button>
                </div>
            </div>

            <!-- Car 4 -->
            <div class="bg-white rounded-lg border border-brand-border overflow-hidden group hover:shadow-lg transition">
                <div class="relative h-40 bg-gray-100">
                    <img src="https://images.unsplash.com/photo-1541899481282-d53bffe3c35d?auto=format&fit=crop&q=80&w=400" class="w-full h-full object-cover">
                    <button class="absolute top-2 right-2 w-7 h-7 bg-white/80 rounded-full flex items-center justify-center text-gray-500 hover:text-red-500">
                        <i class="far fa-heart text-xs"></i>
                    </button>
                </div>
                <div class="p-4">
                    <h3 class="font-bold text-[14px] text-brand-dark mb-0.5 truncate">2022 Hyundai Creta</h3>
                    <p class="text-[11px] text-brand-gray mb-2">Prime IVT</p>
                    <p class="font-bold text-brand-blue text-lg mb-3">Rp 450.000 <span class="text-[10px] font-normal text-brand-gray">/hari</span></p>

                    <div class="grid grid-cols-2 gap-2 text-[10px] text-brand-gray border-t border-brand-border pt-3 mb-3">
                        <div class="flex items-center gap-1.5"><i class="fas fa-tachometer-alt"></i> 12,500 km</div>
                        <div class="flex items-center gap-1.5"><i class="fas fa-cog"></i> Automatic</div>
                        <div class="flex items-center gap-1.5"><i class="fas fa-gas-pump"></i> Bensin</div>
                        <div class="flex items-center gap-1.5"><i class="fas fa-map-marker-alt"></i> Jakarta</div>
                    </div>
                    <button onclick="openBookingModal()" class="w-full bg-brand-blue/10 text-brand-blue hover:bg-brand-blue hover:text-white py-2 rounded text-[12px] font-semibold transition">
                        Pesan Sekarang
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- Browse By Brands -->
    <section class="py-12 px-6 md:px-12 max-w-6xl mx-auto border-t border-brand-border">
        <h2 class="text-lg font-bold text-brand-dark mb-6 text-center">Browse by Brand</h2>
        <div class="flex flex-wrap justify-center gap-6">
            <div class="w-16 h-16 rounded-full bg-white border border-brand-border shadow-sm flex items-center justify-center hover:border-brand-blue transition cursor-pointer">
                <i class="fas fa-car text-xl text-gray-400"></i>
            </div>
            <div class="w-16 h-16 rounded-full bg-white border border-brand-border shadow-sm flex items-center justify-center hover:border-brand-blue transition cursor-pointer">
                <i class="fas fa-truck-pickup text-xl text-gray-400"></i>
            </div>
            <div class="w-16 h-16 rounded-full bg-white border border-brand-border shadow-sm flex items-center justify-center hover:border-brand-blue transition cursor-pointer">
                <i class="fas fa-car-side text-xl text-gray-400"></i>
            </div>
            <div class="w-16 h-16 rounded-full bg-white border border-brand-border shadow-sm flex items-center justify-center hover:border-brand-blue transition cursor-pointer">
                <i class="fas fa-caravan text-xl text-gray-400"></i>
            </div>
            <div class="w-16 h-16 rounded-full bg-white border border-brand-border shadow-sm flex items-center justify-center hover:border-brand-blue transition cursor-pointer text-[10px] font-bold text-gray-400">
                +More
            </div>
        </div>
    </section>

    <!-- Categories Banner -->
    <section class="max-w-6xl mx-auto px-6 md:px-12 mb-16">
        <div class="bg-brand-blue rounded-xl p-8 text-white flex flex-col md:flex-row items-center justify-between gap-6">
            <div>
                <h2 class="text-xl font-bold mb-2">Browse by Category</h2>
                <p class="text-[13px] text-blue-100 max-w-md">Find the perfect vehicle type that fits your needs, whether it's an SUV for family trips or a compact car for city driving.</p>
            </div>
            <div class="flex flex-wrap gap-6 justify-center">
                <div class="text-center cursor-pointer hover:opacity-80 transition">
                    <i class="fas fa-car-suv text-2xl mb-1"></i>
                    <p class="text-[11px] font-medium">SUV</p>
                </div>
                <div class="text-center cursor-pointer hover:opacity-80 transition">
                    <i class="fas fa-car-side text-2xl mb-1"></i>
                    <p class="text-[11px] font-medium">Sedan</p>
                </div>
                <div class="text-center cursor-pointer hover:opacity-80 transition">
                    <i class="fas fa-truck-pickup text-2xl mb-1"></i>
                    <p class="text-[11px] font-medium">Truck</p>
                </div>
                <div class="text-center cursor-pointer hover:opacity-80 transition">
                    <i class="fas fa-car text-2xl mb-1"></i>
                    <p class="text-[11px] font-medium">Hatchback</p>
                </div>
            </div>
            <button class="bg-white text-brand-blue px-5 py-2 rounded text-[12px] font-semibold shrink-0">
                View All Categories
            </button>
        </div>
    </section>

    <!-- Why Buy With Us -->
    <section class="py-16 bg-white border-t border-brand-border">
        <div class="max-w-6xl mx-auto px-6 md:px-12">
            <h2 class="text-xl font-bold text-brand-dark mb-10">Why Choose {{ $client->brand_name }}?</h2>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div class="flex gap-4">
                    <div class="w-10 h-10 rounded bg-blue-50 text-brand-blue flex items-center justify-center shrink-0">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <div>
                        <h4 class="text-[13px] font-bold text-brand-dark mb-1">Verified Quality</h4>
                        <p class="text-[12px] text-brand-gray leading-relaxed">All cars are inspected and verified for your peace of mind.</p>
                    </div>
                </div>
                <div class="flex gap-4">
                    <div class="w-10 h-10 rounded bg-blue-50 text-brand-blue flex items-center justify-center shrink-0">
                        <i class="fas fa-tags"></i>
                    </div>
                    <div>
                        <h4 class="text-[13px] font-bold text-brand-dark mb-1">Best Price Guarantee</h4>
                        <p class="text-[12px] text-brand-gray leading-relaxed">Get the best value with our market price promise.</p>
                    </div>
                </div>
                <div class="flex gap-4">
                    <div class="w-10 h-10 rounded bg-blue-50 text-brand-blue flex items-center justify-center shrink-0">
                        <i class="fas fa-lock"></i>
                    </div>
                    <div>
                        <h4 class="text-[13px] font-bold text-brand-dark mb-1">Secure Transactions</h4>
                        <p class="text-[12px] text-brand-gray leading-relaxed">Safe, transparent, and hassle-free buying experience.</p>
                    </div>
                </div>
                <div class="flex gap-4">
                    <div class="w-10 h-10 rounded bg-blue-50 text-brand-blue flex items-center justify-center shrink-0">
                        <i class="fas fa-headset"></i>
                    </div>
                    <div>
                        <h4 class="text-[13px] font-bold text-brand-dark mb-1">24/7 Support</h4>
                        <p class="text-[12px] text-brand-gray leading-relaxed">Our support team is here to help you anytime.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Booking Modal (Multi-step Simulation) -->
    <div id="bookingModal" class="fixed inset-0 z-[150] bg-brand-dark/50 backdrop-blur-sm hidden items-center justify-center p-4">
        <div class="bg-white w-full max-w-md rounded-xl overflow-hidden shadow-2xl flex flex-col max-h-[90vh]">

            <div class="bg-brand-dark p-5 text-white relative shrink-0">
                <button onclick="closeBookingModal()" class="absolute top-5 right-5 text-gray-400 hover:text-white"><i class="fas fa-times"></i></button>
                <h3 class="font-bold text-[15px] mb-1">Pemesanan Kendaraan</h3>
                <p class="text-gray-400 text-[11px]">Simulasi proses booking online & verifikasi (e-KYC)</p>

                <!-- Progress Steps -->
                <div class="flex justify-between items-center mt-5 px-2">
                    <div class="flex flex-col items-center">
                        <div class="w-6 h-6 rounded-full bg-brand-blue text-white font-bold flex items-center justify-center text-[10px]" id="step-1-indicator">1</div>
                        <span class="text-[9px] font-medium mt-1 text-gray-300">Detail</span>
                    </div>
                    <div class="flex-1 h-0.5 bg-gray-600 mx-2">
                        <div class="h-full bg-brand-blue transition-all duration-300 w-0" id="progress-1"></div>
                    </div>
                    <div class="flex flex-col items-center opacity-50" id="step-2-indicator">
                        <div class="w-6 h-6 rounded-full border border-gray-500 text-gray-300 font-bold flex items-center justify-center text-[10px]">2</div>
                        <span class="text-[9px] font-medium mt-1 text-gray-300">e-KYC</span>
                    </div>
                    <div class="flex-1 h-0.5 bg-gray-600 mx-2">
                        <div class="h-full bg-brand-blue transition-all duration-300 w-0" id="progress-2"></div>
                    </div>
                    <div class="flex flex-col items-center opacity-50" id="step-3-indicator">
                        <div class="w-6 h-6 rounded-full border border-gray-500 text-gray-300 font-bold flex items-center justify-center text-[10px]">3</div>
                        <span class="text-[9px] font-medium mt-1 text-gray-300">Bayar</span>
                    </div>
                </div>
            </div>

            <div class="p-5 overflow-y-auto hide-scrollbar flex-1 bg-gray-50">

                <!-- Step 1: Detail Booking -->
                <div id="booking-step-1" class="space-y-4 block">
                    <div class="p-3 bg-white border border-brand-border rounded flex gap-3 items-center">
                        <img src="https://images.unsplash.com/photo-1542282088-fe8426682b8f?auto=format&fit=crop&q=80&w=200" class="w-16 h-12 object-cover rounded">
                        <div>
                            <h4 class="font-bold text-[13px] text-brand-dark">Toyota Avanza</h4>
                            <p class="text-[11px] text-brand-gray mt-0.5">Rp 350.000 / Hari</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-[10px] font-bold text-brand-gray mb-1 uppercase tracking-wide">Tgl Pengambilan</label>
                            <input type="date" class="w-full bg-white border border-brand-border rounded px-3 py-2 text-[12px] focus:outline-none focus:border-brand-blue" value="2026-08-20">
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-brand-gray mb-1 uppercase tracking-wide">Tgl Pengembalian</label>
                            <input type="date" class="w-full bg-white border border-brand-border rounded px-3 py-2 text-[12px] focus:outline-none focus:border-brand-blue" value="2026-08-22">
                        </div>
                    </div>

                    <div>
                        <label class="block text-[10px] font-bold text-brand-gray mb-2 uppercase tracking-wide">Jenis Layanan</label>
                        <div class="grid grid-cols-2 gap-2">
                            <label class="border border-brand-blue bg-blue-50 rounded p-2.5 flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="layanan" checked class="w-3 h-3 text-brand-blue">
                                <span class="text-[12px] font-bold text-brand-dark">Lepas Kunci</span>
                            </label>
                            <label class="border border-brand-border bg-white hover:bg-gray-50 rounded p-2.5 flex items-center gap-2 cursor-pointer transition">
                                <input type="radio" name="layanan" class="w-3 h-3 text-brand-blue">
                                <span class="text-[12px] font-medium text-brand-dark">Dengan Sopir</span>
                            </label>
                        </div>
                    </div>

                    <button onclick="goToStep(2)" class="w-full bg-brand-blue hover:bg-blue-700 text-white font-semibold py-2.5 rounded text-[13px] mt-2 transition">
                        Lanjut Isi Data
                    </button>
                </div>

                <!-- Step 2: e-KYC Upload -->
                <div id="booking-step-2" class="space-y-4 hidden" id="tour-ekyc">
                    <div class="bg-blue-50 border border-blue-100 p-3 rounded flex gap-3 text-blue-800 mb-1">
                        <i class="fas fa-shield-alt mt-0.5 text-brand-blue"></i>
                        <div>
                            <h4 class="font-bold text-[12px]">Verifikasi Identitas</h4>
                            <p class="text-[10px] mt-0.5 text-blue-600">Mohon unggah dokumen untuk keamanan sewa lepas kunci.</p>
                        </div>
                    </div>

                    <div>
                        <label class="block text-[10px] font-bold text-brand-gray mb-1 uppercase tracking-wide">Nama Sesuai KTP</label>
                        <input type="text" class="w-full bg-white border border-brand-border rounded px-3 py-2 text-[12px] focus:outline-none focus:border-brand-blue" placeholder="Nama lengkap">
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div class="border border-dashed border-gray-300 rounded bg-white p-4 flex flex-col items-center justify-center text-center cursor-pointer hover:bg-gray-50 transition">
                            <i class="fas fa-id-card text-xl text-gray-400 mb-2"></i>
                            <span class="text-[11px] font-semibold text-brand-dark block">Upload KTP</span>
                        </div>
                        <div class="border border-dashed border-gray-300 rounded bg-white p-4 flex flex-col items-center justify-center text-center cursor-pointer hover:bg-gray-50 transition">
                            <i class="fas fa-address-card text-xl text-gray-400 mb-2"></i>
                            <span class="text-[11px] font-semibold text-brand-dark block">Upload SIM A</span>
                        </div>
                    </div>

                    <div class="flex gap-2 pt-2">
                        <button onclick="goToStep(1)" class="w-1/3 bg-white border border-brand-border hover:bg-gray-50 text-brand-dark font-medium py-2.5 rounded text-[12px] transition">
                            Kembali
                        </button>
                        <button onclick="goToStep(3)" class="w-2/3 bg-brand-blue hover:bg-blue-700 text-white font-semibold py-2.5 rounded text-[12px] transition">
                            Lanjut Pembayaran
                        </button>
                    </div>
                </div>

                <!-- Step 3: Payment -->
                <div id="booking-step-3" class="space-y-4 hidden">
                    <div class="text-center mb-4 p-4 bg-white border border-brand-border rounded">
                        <p class="text-[11px] text-brand-gray mb-1">Total Tagihan (2 Hari Sewa)</p>
                        <h4 class="font-bold text-xl text-brand-dark">Rp 700.000</h4>
                    </div>

                    <div>
                        <label class="block text-[10px] font-bold text-brand-gray mb-2 uppercase tracking-wide">Metode Pembayaran</label>
                        <div class="space-y-2">
                            <label class="border border-brand-blue bg-blue-50 rounded p-3 flex items-center justify-between cursor-pointer">
                                <div class="flex items-center gap-2">
                                    <input type="radio" name="payment" checked class="w-3 h-3 text-brand-blue">
                                    <span class="font-bold text-[12px] text-brand-dark">Virtual Account</span>
                                </div>
                                <i class="fas fa-university text-brand-blue"></i>
                            </label>
                            <label class="border border-brand-border bg-white rounded p-3 flex items-center justify-between cursor-pointer">
                                <div class="flex items-center gap-2">
                                    <input type="radio" name="payment" class="w-3 h-3 text-brand-blue">
                                    <span class="font-medium text-[12px] text-brand-dark">QRIS</span>
                                </div>
                                <i class="fas fa-qrcode text-gray-400"></i>
                            </label>
                        </div>
                    </div>

                    <div class="flex gap-2 pt-2">
                        <button onclick="goToStep(2)" class="w-1/3 bg-white border border-brand-border hover:bg-gray-50 text-brand-dark font-medium py-2.5 rounded text-[12px] transition">
                            Kembali
                        </button>
                        <button onclick="finishBooking()" class="w-2/3 bg-green-600 hover:bg-green-700 text-white font-semibold py-2.5 rounded text-[12px] transition flex justify-center items-center gap-2">
                            <i class="fas fa-lock"></i> Bayar Sekarang
                        </button>
                    </div>
                </div>

                <!-- Success State -->
                <div id="booking-success" class="hidden flex-col items-center justify-center py-6 text-center">
                    <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center text-green-600 text-2xl mb-4">
                        <i class="fas fa-check"></i>
                    </div>
                    <h3 class="font-bold text-lg text-brand-dark mb-1">Booking Berhasil!</h3>
                    <p class="text-[12px] text-brand-gray mb-6 max-w-[250px]">Mobil telah direservasi. Kode booking dikirimkan via WhatsApp.</p>

                    <button onclick="closeBookingModal()" class="bg-brand-dark hover:bg-black text-white px-6 py-2 rounded font-semibold text-[13px] transition">Tutup</button>
                </div>

            </div>
        </div>
    </div>

    <!-- Interactive Tour UI -->
    <div id="tour-overlay"></div>
    <div id="tour-tooltip" class="flex flex-col">
        <div class="flex items-center gap-2 mb-2">
            <div class="w-6 h-6 rounded bg-brand-blue text-white flex items-center justify-center font-bold text-[10px]" id="tour-step-indicator">1</div>
            <h4 class="font-bold text-[13px] text-brand-dark flex-1" id="tour-title">Judul Tour</h4>
            <button onclick="closeTour()" class="text-gray-400 hover:text-brand-dark"><i class="fas fa-times"></i></button>
        </div>
        <p class="text-[12px] text-brand-gray mb-4 leading-relaxed" id="tour-content">Isi petunjuk tour.</p>
        <div class="flex justify-between items-center mt-auto border-t border-brand-border pt-3">
            <button id="tour-prev" onclick="prevStep()" class="text-[11px] font-semibold text-brand-gray hover:text-brand-dark invisible">Sebelumnya</button>
            <button id="tour-next" onclick="nextStep()" class="bg-brand-dark hover:bg-black text-white px-3 py-1.5 rounded text-[11px] font-semibold transition">Selanjutnya</button>
        </div>
    </div>

    <!-- Script for Booking Modal and Tour -->
    <script>
        // Booking Modal Logic
        const modal = document.getElementById('bookingModal');

        function openBookingModal() {
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            goToStep(1);
        }

        function closeBookingModal() {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        function goToStep(step) {
            document.getElementById('booking-step-1').classList.add('hidden');
            document.getElementById('booking-step-2').classList.add('hidden');
            document.getElementById('booking-step-3').classList.add('hidden');
            document.getElementById('booking-success').classList.add('hidden');
            document.getElementById(`booking-step-${step}`).classList.remove('hidden');

            if (step >= 1) {
                document.getElementById('step-1-indicator').classList.remove('border', 'border-gray-500', 'bg-transparent', 'text-gray-300');
                document.getElementById('step-1-indicator').classList.add('bg-brand-blue', 'text-white');
            }
            if (step >= 2) {
                document.getElementById('progress-1').style.width = '100%';
                document.getElementById('step-2-indicator').classList.remove('opacity-50');
                document.getElementById('step-2-indicator').querySelector('div').classList.remove('border', 'border-gray-500', 'text-gray-300');
                document.getElementById('step-2-indicator').querySelector('div').classList.add('bg-brand-blue', 'text-white');
            } else {
                document.getElementById('progress-1').style.width = '0%';
                document.getElementById('step-2-indicator').classList.add('opacity-50');
                document.getElementById('step-2-indicator').querySelector('div').classList.add('border', 'border-gray-500', 'text-gray-300');
                document.getElementById('step-2-indicator').querySelector('div').classList.remove('bg-brand-blue', 'text-white');
            }

            if (step >= 3) {
                document.getElementById('progress-2').style.width = '100%';
                document.getElementById('step-3-indicator').classList.remove('opacity-50');
                document.getElementById('step-3-indicator').querySelector('div').classList.remove('border', 'border-gray-500', 'text-gray-300');
                document.getElementById('step-3-indicator').querySelector('div').classList.add('bg-brand-blue', 'text-white');
            } else {
                document.getElementById('progress-2').style.width = '0%';
                document.getElementById('step-3-indicator').classList.add('opacity-50');
                document.getElementById('step-3-indicator').querySelector('div').classList.add('border', 'border-gray-500', 'text-gray-300');
                document.getElementById('step-3-indicator').querySelector('div').classList.remove('bg-brand-blue', 'text-white');
            }
        }

        function finishBooking() {
            document.getElementById('booking-step-3').classList.add('hidden');
            document.getElementById('booking-success').classList.remove('hidden');
            document.getElementById('booking-success').classList.add('flex');
            modal.querySelector('.bg-brand-dark').style.display = 'none';
        }

        // Tour Logic
        const tourSteps = [{
                elementId: 'tour-welcome'
                , title: 'Website Rental'
                , content: 'Desain website yang bersih, profesional, dan informatif untuk meningkatkan kepercayaan (trust) pelanggan saat ingin menyewa.'
            }
            , {
                elementId: 'tour-filter'
                , title: 'Filter Pencarian'
                , content: 'Kolom pencarian cepat untuk memfilter mobil berdasarkan Merek, Model, dan Harga layaknya e-commerce profesional.'
            }
            , {
                elementId: 'tour-booked-car'
                , title: 'Live Availability'
                , content: 'Mobil yang sedang disewa akan otomatis menampilkan status "Telah Disewa", mencegah double booking secara sistem.'
            }
            , {
                elementId: 'tour-booking-cta'
                , title: 'Sistem e-KYC'
                , content: 'Pelanggan dapat melakukan pemesanan online langsung dengan mengunggah KTP/SIM yang tersinkron ke dashboard Anda.'
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

                    if (rect.bottom + 150 > window.innerHeight) {
                        top = rect.top + window.scrollY - 160;
                    }

                    if (window.innerWidth < 400) {
                        left = 15;
                        tooltip.style.width = (window.innerWidth - 30) + 'px';
                    } else {
                        tooltip.style.width = '300px';
                        if (left + 300 > window.innerWidth) {
                            left = window.innerWidth - 320;
                        }
                    }

                    tooltip.style.top = top + 'px';
                    tooltip.style.left = left + 'px';

                    document.getElementById('tour-step-indicator').innerText = index + 1;
                    document.getElementById('tour-title').innerText = step.title;
                    document.getElementById('tour-content').innerText = step.content;
                    document.getElementById('tour-prev').style.visibility = index === 0 ? 'hidden' : 'visible';

                    const nextBtn = document.getElementById('tour-next');
                    nextBtn.innerText = index === tourSteps.length - 1 ? 'Selesai' : 'Selanjutnya';
                }, 300);
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

    </script>
</body>
</html>
