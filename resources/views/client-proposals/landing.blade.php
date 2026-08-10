<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Meta Tags untuk Preview Link (WhatsApp, Telegram, dsb) -->
    <title>Demo Website - {{ $client->brand_name }}</title>
    <meta name="description" content="Preview desain website eksklusif untuk {{ $client->brand_name }} yang disiapkan oleh Scalify Intelligence.">

    <!-- Open Graph / Facebook / WhatsApp -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="Demo Website - {{ $client->brand_name }}">
    <meta property="og:description" content="Preview desain website eksklusif untuk {{ $client->brand_name }} yang disiapkan oleh Scalify Intelligence.">
    <!-- Gambar yang akan muncul di link (Rekomendasi ukuran: 1200x630px) -->
    <meta property="og:image" content="{{ asset('images/agency-cover.jpg') }}">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ url()->current() }}">
    <meta property="twitter:title" content="Demo Website - {{ $client->brand_name }}">
    <meta property="twitter:description" content="Preview desain website eksklusif untuk {{ $client->brand_name }} yang disiapkan oleh Scalify Intelligence.">
    <meta property="twitter:image" content="{{ asset('images/agency-cover.jpg') }}">
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            gold: '#C59A6F'
                            , light: '#FDFBF7'
                            , dark: '#333333'
                            , beige: '#F4ECE4'
                        }
                    }
                    , fontFamily: {
                        serif: ['Playfair Display', 'serif']
                        , sans: ['Inter', 'sans-serif']
                    , }
                }
            }
        }

    </script>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;1,400&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />

    <style>
        body {
            font-family: 'Inter', sans-serif;
            color: #4A4A4A;
            background-color: #FDFBF7;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6,
        .font-serif {
            font-family: 'Playfair Display', serif;
        }

        .hero-curve {
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 100%;
            overflow: hidden;
            line-height: 0;
            transform: rotate(180deg);
            z-index: 20;
        }

        .hero-curve svg {
            position: relative;
            display: block;
            width: calc(100% + 1.3px);
            height: 120px;
        }

        .hero-curve .shape-fill {
            fill: #FDFBF7;
        }

    </style>
</head>
<body class="antialiased selection:bg-brand-gold selection:text-white">

    <!-- Navbar -->
    <nav class="fixed w-full z-50 transition-all duration-300 bg-white/95 backdrop-blur-md border-b border-gray-100 py-4 px-6 md:px-12 flex justify-between items-center" id="navbar">
        <div class="flex items-center gap-3">
            <img src="{{ asset('images/permata-qiana/logo-placeholder.png') }}" onerror="this.outerHTML='<div class=\'w-10 h-10 rounded-full border border-brand-gold flex items-center justify-center text-brand-gold font-serif text-xl\'>P</div>'" alt="Logo" class="w-10 h-10">
            <div>
                <h1 class="font-serif font-bold text-gray-800 leading-tight tracking-[0.1em] text-sm md:text-[15px]">{{ strtoupper($client->brand_name) }}</h1>
                <p class="text-[9px] tracking-[0.3em] text-gray-500 uppercase text-center mt-0.5">Wedding</p>
            </div>
        </div>

        <div class="hidden lg:flex items-center gap-10 text-[13px] font-medium text-gray-600">
            <a href="#" class="text-brand-gold">Beranda</a>
            <a href="#tentang" class="hover:text-brand-gold transition">Tentang Kami</a>
            <a href="#layanan" class="hover:text-brand-gold transition">Layanan</a>
            <a href="#galeri" class="hover:text-brand-gold transition">Galeri</a>
            <a href="#paket" class="hover:text-brand-gold transition">Paket</a>
            <a href="#testimoni" class="hover:text-brand-gold transition">Testimoni</a>
            <a href="#blog" class="hover:text-brand-gold transition">Blog</a>
            <a href="#kontak" class="hover:text-brand-gold transition">Kontak</a>
        </div>

        <div class="hidden lg:block">
            <a href="#kontak" class="bg-brand-gold hover:bg-yellow-700 text-white px-7 py-2.5 rounded-md text-[13px] font-medium transition shadow-lg shadow-brand-gold/20">Konsultasi Gratis</a>
        </div>

        <button class="lg:hidden text-gray-600"><i class="fas fa-bars text-xl"></i></button>
    </nav>

    <!-- Hero Section -->
    <section class="relative pt-32 pb-24 md:pt-48 md:pb-40 px-6 md:px-16 flex items-center min-h-[100vh] overflow-hidden bg-white">
        <!-- Background Image (Right Side) -->
        <div class="absolute top-0 right-0 w-full md:w-[60%] h-[110%] z-0">
            <!-- Gradient Overlay for smooth transition on desktop -->
            <div class="absolute inset-0 bg-gradient-to-r from-white via-white/80 to-transparent z-10 hidden md:block"></div>
            <div class="absolute inset-0 bg-white/70 md:hidden z-10"></div>
            <img src="{{ asset('images/permata-qiana/hero_wedding_couple.webp') }}" alt="Wedding Couple" class="w-full h-full object-cover object-[center_30%] rounded-bl-[200px]">
        </div>

        <div class="max-w-[1400px] mx-auto w-full relative z-20">
            <div class="max-w-2xl">
                <p class="text-brand-gold font-semibold text-[10px] md:text-[11px] tracking-[0.3em] uppercase mb-6">Wujudkan Pernikahan Impian Anda</p>
                <h1 class="font-serif text-5xl md:text-6xl lg:text-[5.5rem] font-bold text-gray-900 leading-[1.05] mb-6">
                    <span class="block text-gray-800">Momen Terindah,</span>
                    <span class="block text-brand-gold mt-2">Kami Wujudkan</span>
                </h1>
                <p class="text-gray-600 text-sm md:text-[15px] mb-10 max-w-[420px] leading-relaxed">
                    {{ $client->brand_name }} adalah penyedia layanan pernikahan terlengkap yang menghadirkan keindahan, detail dan kesempurnaan untuk hari bahagia Anda.
                </p>

                <div class="flex flex-wrap gap-4">
                    <a href="#kontak" class="bg-brand-gold hover:bg-[#B88655] text-white px-7 py-3.5 rounded-md text-[13px] font-medium transition flex items-center gap-2">
                        Konsultasi Gratis <i class="far fa-calendar-alt ml-1"></i>
                    </a>
                    <a href="{{ route('proposal.dynamic', $client->slug) }}" class="border border-gray-300 hover:border-gray-400 bg-white text-gray-700 px-7 py-3.5 rounded-md text-[13px] font-medium transition flex items-center gap-2">
                        Lihat Proposal Web <i class="fas fa-file-invoice-dollar ml-1"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="hero-curve">
            <svg data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
                <path d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V0H0V27.35A600.21,600.21,0,0,0,321.39,56.44Z" class="shape-fill"></path>
            </svg>
        </div>
    </section>

    <!-- Services Section -->
    <section id="layanan" class="py-24 px-6 md:px-12 bg-brand-light relative z-30">
        <div class="max-w-[1400px] mx-auto text-center mb-16">
            <p class="text-brand-gold font-bold text-[10px] tracking-[0.25em] uppercase mb-4">Layanan Kami</p>
            <h2 class="font-serif text-3xl md:text-[2.5rem] font-bold text-gray-900 mb-6 flex items-center justify-center gap-4">
                <span class="w-10 h-[1px] bg-brand-gold/60"></span>
                <img src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTgiIGhlaWdodD0iMTgiIHZpZXdCb3g9IjAgMCAyNCAyNCIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48cGF0aCBkPSJNMTIgMEwxNS4yNjIyIDguNzM3NzhMMjQgMTJMMTUuMjYyMiAxNS4yNjIyTDEyIDI0TDguNzM3NzggMTUuMjYyMkwwIDEyTDguNzM3NzggOC43Mzc3OEwxMiAwWiIgZmlsbD0iI0M1OUE2RiIvPjwvc3ZnPg==" alt="ornament" class="w-4 h-4">
                Layanan Wedding Terlengkap
                <img src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTgiIGhlaWdodD0iMTgiIHZpZXdCb3g9IjAgMCAyNCAyNCIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48cGF0aCBkPSJNMTIgMEwxNS4yNjIyIDguNzM3NzhMMjQgMTJMMTUuMjYyMiAxNS4yNjIyTDEyIDI0TDguNzM3NzggMTUuMjYyMkwwIDEyTDguNzM3NzggOC43Mzc3OEwxMiAwWiIgZmlsbD0iI0M1OUE2RiIvPjwvc3ZnPg==" alt="ornament" class="w-4 h-4">
                <span class="w-10 h-[1px] bg-brand-gold/60"></span>
            </h2>
            <p class="text-gray-500 text-[13px] max-w-xl mx-auto">Kami menyediakan semua kebutuhan pernikahan Anda dengan konsep eksklusif dan pelayanan terbaik.</p>
        </div>

        <div class="max-w-[1400px] mx-auto grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4 md:gap-6">
            <!-- Service 1 -->
            <div class="bg-white rounded-[20px] p-2.5 shadow-[0_4px_20px_-5px_rgba(0,0,0,0.05)] hover:shadow-xl transition-all duration-300 border border-gray-100 group flex flex-col">
                <div class="relative h-48 rounded-2xl overflow-hidden mb-4 shrink-0">
                    <img src="{{ asset('images/permata-qiana/wedding_makeup.webp') }}" alt="Makeup & Attire" class="w-full h-full object-cover group-hover:scale-110 transition duration-700">
                    <div class="absolute -bottom-4 left-3 w-10 h-10 bg-[#FDFBF7] rounded-full flex items-center justify-center text-brand-gold shadow-md border border-white">
                        <i class="fas fa-magic text-[15px]"></i>
                    </div>
                </div>
                <div class="px-2 pb-2 flex-grow flex flex-col justify-between">
                    <h3 class="font-serif text-[15px] font-bold text-gray-900 mb-2 mt-2 leading-tight">Makeup & Attire</h3>
                    <p class="text-gray-500 text-[11px] leading-relaxed">Rias pengantin profesional & busana berkualitas dengan desain eksklusif.</p>
                </div>
            </div>

            <!-- Service 2 -->
            <div class="bg-white rounded-[20px] p-2.5 shadow-[0_4px_20px_-5px_rgba(0,0,0,0.05)] hover:shadow-xl transition-all duration-300 border border-gray-100 group flex flex-col">
                <div class="relative h-48 rounded-2xl overflow-hidden mb-4 shrink-0">
                    <img src="{{ asset('images/permata-qiana/wedding_decoration.webp') }}" alt="Dekorasi Pelaminan" class="w-full h-full object-cover group-hover:scale-110 transition duration-700">
                    <div class="absolute -bottom-4 left-3 w-10 h-10 bg-[#FDFBF7] rounded-full flex items-center justify-center text-brand-gold shadow-md border border-white">
                        <i class="fas fa-tree text-[15px]"></i>
                    </div>
                </div>
                <div class="px-2 pb-2 flex-grow flex flex-col justify-between">
                    <h3 class="font-serif text-[15px] font-bold text-gray-900 mb-2 mt-2 leading-tight">Dekorasi Pelaminan</h3>
                    <p class="text-gray-500 text-[11px] leading-relaxed">Dekorasi pelaminan elegan dan mewah sesuai tema impian Anda.</p>
                </div>
            </div>

            <!-- Service 3 -->
            <div class="bg-white rounded-[20px] p-2.5 shadow-[0_4px_20px_-5px_rgba(0,0,0,0.05)] hover:shadow-xl transition-all duration-300 border border-gray-100 group flex flex-col">
                <div class="relative h-48 rounded-2xl overflow-hidden mb-4 shrink-0">
                    <img src="{{ asset('images/permata-qiana/wedding_lighting.webp') }}" alt="Panggung & Lighting" class="w-full h-full object-cover group-hover:scale-110 transition duration-700">
                    <div class="absolute -bottom-4 left-3 w-10 h-10 bg-[#FDFBF7] rounded-full flex items-center justify-center text-brand-gold shadow-md border border-white">
                        <i class="fas fa-lightbulb text-[15px]"></i>
                    </div>
                </div>
                <div class="px-2 pb-2 flex-grow flex flex-col justify-between">
                    <h3 class="font-serif text-[15px] font-bold text-gray-900 mb-2 mt-2 leading-tight">Panggung & Lighting</h3>
                    <p class="text-gray-500 text-[11px] leading-relaxed">Panggung megah, tata lighting modern untuk momen yang berkesan.</p>
                </div>
            </div>

            <!-- Service 4 -->
            <div class="bg-white rounded-[20px] p-2.5 shadow-[0_4px_20px_-5px_rgba(0,0,0,0.05)] hover:shadow-xl transition-all duration-300 border border-gray-100 group flex flex-col">
                <div class="relative h-48 rounded-2xl overflow-hidden mb-4 shrink-0">
                    <img src="{{ asset('images/permata-qiana/wedding_catering.webp') }}" alt="Catering" class="w-full h-full object-cover group-hover:scale-110 transition duration-700">
                    <div class="absolute -bottom-4 left-3 w-10 h-10 bg-[#FDFBF7] rounded-full flex items-center justify-center text-brand-gold shadow-md border border-white">
                        <i class="fas fa-utensils text-[15px]"></i>
                    </div>
                </div>
                <div class="px-2 pb-2 flex-grow flex flex-col justify-between">
                    <h3 class="font-serif text-[15px] font-bold text-gray-900 mb-2 mt-2 leading-tight">Catering</h3>
                    <p class="text-gray-500 text-[11px] leading-relaxed">Menu catering lezat dan berkualitas dengan standar penyajian terbaik.</p>
                </div>
            </div>

            <!-- Service 5 -->
            <div class="bg-white rounded-[20px] p-2.5 shadow-[0_4px_20px_-5px_rgba(0,0,0,0.05)] hover:shadow-xl transition-all duration-300 border border-gray-100 group flex flex-col">
                <div class="relative h-48 rounded-2xl overflow-hidden mb-4 shrink-0">
                    <img src="{{ asset('images/permata-qiana/wedding_organizer.webp') }}" alt="Wedding Organizer" class="w-full h-full object-cover group-hover:scale-110 transition duration-700">
                    <div class="absolute -bottom-4 left-3 w-10 h-10 bg-[#FDFBF7] rounded-full flex items-center justify-center text-brand-gold shadow-md border border-white">
                        <i class="fas fa-clipboard-list text-[15px]"></i>
                    </div>
                </div>
                <div class="px-2 pb-2 flex-grow flex flex-col justify-between">
                    <h3 class="font-serif text-[15px] font-bold text-gray-900 mb-2 mt-2 leading-tight">Wedding Organizer</h3>
                    <p class="text-gray-500 text-[11px] leading-relaxed">Perencanaan matang, eksekusi sempurna untuk hari bahagia tanpa stres.</p>
                </div>
            </div>

            <!-- Service 6 -->
            <div class="bg-white rounded-[20px] p-2.5 shadow-[0_4px_20px_-5px_rgba(0,0,0,0.05)] hover:shadow-xl transition-all duration-300 border border-gray-100 group flex flex-col">
                <div class="relative h-48 rounded-2xl overflow-hidden mb-4 shrink-0">
                    <img src="{{ asset('images/permata-qiana/wedding_bouquet.webp') }}" alt="Bunga & Aksesoris" class="w-full h-full object-cover group-hover:scale-110 transition duration-700">
                    <div class="absolute -bottom-4 left-3 w-10 h-10 bg-[#FDFBF7] rounded-full flex items-center justify-center text-brand-gold shadow-md border border-white">
                        <i class="fas fa-camera text-[15px]"></i>
                    </div>
                </div>
                <div class="px-2 pb-2 flex-grow flex flex-col justify-between">
                    <h3 class="font-serif text-[15px] font-bold text-gray-900 mb-2 mt-2 leading-tight">&amp; More</h3>
                    <p class="text-gray-500 text-[11px] leading-relaxed">Dokumentasi, hiburan, MC, undangan digital, souvenir, dan lainnya.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Gallery / Portfolio Section -->
    <section id="galeri" class="py-24 px-6 md:px-12 bg-white">
        <div class="max-w-[1400px] mx-auto text-center mb-12">
            <p class="text-brand-gold font-bold text-[10px] tracking-[0.25em] uppercase mb-4">Galeri Kami</p>
            <h2 class="font-serif text-3xl md:text-[2.5rem] font-bold text-gray-900 mb-6 flex items-center justify-center gap-4">
                <span class="w-10 h-[1px] bg-brand-gold/60"></span>
                <img src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTgiIGhlaWdodD0iMTgiIHZpZXdCb3g9IjAgMCAyNCAyNCIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48cGF0aCBkPSJNMTIgMEwxNS4yNjIyIDguNzM3NzhMMjQgMTJMMTUuMjYyMiAxNS4yNjIyTDEyIDI0TDguNzM3NzggMTUuMjYyMkwwIDEyTDguNzM3NzggOC43Mzc3OEwxMiAwWiIgZmlsbD0iI0M1OUE2RiIvPjwvc3ZnPg==" alt="ornament" class="w-4 h-4">
                Setiap Detail, Penuh Makna
                <img src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTgiIGhlaWdodD0iMTgiIHZpZXdCb3g9IjAgMCAyNCAyNCIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48cGF0aCBkPSJNMTIgMEwxNS4yNjIyIDguNzM3NzhMMjQgMTJMMTUuMjYyMiAxNS4yNjIyTDEyIDI0TDguNzM3NzggMTUuMjYyMkwwIDEyTDguNzM3NzggOC43Mzc3OEwxMiAwWiIgZmlsbD0iI0M1OUE2RiIvPjwvc3ZnPg==" alt="ornament" class="w-4 h-4">
                <span class="w-10 h-[1px] bg-brand-gold/60"></span>
            </h2>
            <p class="text-gray-500 text-[13px] max-w-xl mx-auto mb-10">Kami selalu memberikan yang terbaik dalam setiap momen spesial Anda.</p>
        </div>

        <div class="max-w-[1400px] mx-auto relative px-12 md:px-16">
            <!-- Swiper -->
            <div class="swiper mySwiper">
                <div class="swiper-wrapper pb-14">
                    <div class="swiper-slide rounded-xl overflow-hidden border border-gray-100">
                        <img src="{{ asset('images/permata-qiana/hero_wedding_couple.webp') }}" alt="Gallery Couple" class="w-full h-56 md:h-64 lg:h-[280px] object-cover hover:scale-105 transition duration-500">
                    </div>
                    <div class="swiper-slide rounded-xl overflow-hidden border border-gray-100">
                        <img src="{{ asset('images/permata-qiana/gallery_traditional.webp') }}" alt="Gallery Traditional" class="w-full h-56 md:h-64 lg:h-[280px] object-cover hover:scale-105 transition duration-500">
                    </div>
                    <div class="swiper-slide rounded-xl overflow-hidden border border-gray-100">
                        <img src="{{ asset('images/permata-qiana/gallery_aisle.webp') }}" alt="Gallery Aisle" class="w-full h-56 md:h-64 lg:h-[280px] object-cover hover:scale-105 transition duration-500">
                    </div>
                    <div class="swiper-slide rounded-xl overflow-hidden border border-gray-100">
                        <img src="{{ asset('images/permata-qiana/gallery_table.webp') }}" alt="Gallery Table" class="w-full h-56 md:h-64 lg:h-[280px] object-cover hover:scale-105 transition duration-500">
                    </div>
                    <div class="swiper-slide rounded-xl overflow-hidden border border-gray-100">
                        <img src="{{ asset('images/permata-qiana/wedding_decoration.webp') }}" alt="Gallery Decor" class="w-full h-56 md:h-64 lg:h-[280px] object-cover hover:scale-105 transition duration-500">
                    </div>
                    <div class="swiper-slide rounded-xl overflow-hidden border border-gray-100">
                        <img src="{{ asset('images/permata-qiana/wedding_catering.webp') }}" alt="Gallery Catering" class="w-full h-56 md:h-64 lg:h-[280px] object-cover hover:scale-105 transition duration-500">
                    </div>
                </div>
                <div class="swiper-pagination !bottom-0"></div>
            </div>

            <!-- Custom Navigation -->
            <div class="swiper-button-prev !text-gray-500 hover:!text-brand-gold !bg-white !w-10 !h-10 md:!w-12 md:!h-12 rounded-full shadow-[0_2px_15px_rgba(0,0,0,0.08)] border border-gray-100 !left-0 after:!text-[14px]"></div>
            <div class="swiper-button-next !text-gray-500 hover:!text-brand-gold !bg-white !w-10 !h-10 md:!w-12 md:!h-12 rounded-full shadow-[0_2px_15px_rgba(0,0,0,0.08)] border border-gray-100 !right-0 after:!text-[14px]"></div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="py-14 bg-[#FDFBF7] border-y border-[#F4ECE4]">
        <div class="max-w-[1400px] mx-auto px-6 md:px-12 grid grid-cols-2 md:grid-cols-4 gap-6 divide-x-0 md:divide-x divide-[#F4ECE4] text-center">
            <div class="flex flex-col items-center justify-center p-2">
                <i class="far fa-heart text-2xl text-brand-gold mb-3 opacity-80"></i>
                <h4 class="font-serif text-3xl md:text-[2.2rem] font-medium text-gray-800 mb-1">500+</h4>
                <p class="text-[12px] text-gray-500 tracking-wide">Pernikahan Berhasil</p>
            </div>
            <div class="flex flex-col items-center justify-center p-2">
                <i class="fas fa-user-friends text-2xl text-brand-gold mb-3 opacity-80"></i>
                <h4 class="font-serif text-3xl md:text-[2.2rem] font-medium text-gray-800 mb-1">200+</h4>
                <p class="text-[12px] text-gray-500 tracking-wide">Tim Profesional</p>
            </div>
            <div class="flex flex-col items-center justify-center p-2">
                <i class="fas fa-trophy text-2xl text-brand-gold mb-3 opacity-80"></i>
                <h4 class="font-serif text-3xl md:text-[2.2rem] font-medium text-gray-800 mb-1">5+</h4>
                <p class="text-[12px] text-gray-500 tracking-wide">Tahun Pengalaman</p>
            </div>
            <div class="flex flex-col items-center justify-center p-2">
                <i class="far fa-smile text-2xl text-brand-gold mb-3 opacity-80"></i>
                <h4 class="font-serif text-3xl md:text-[2.2rem] font-medium text-gray-800 mb-1">100%</h4>
                <p class="text-[12px] text-gray-500 tracking-wide">Kepuasan Klien</p>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="relative py-28 bg-cover bg-center" style="background-image: url('{{ asset('images/permata-qiana/floral_bg.webp') }}');">
        <div class="absolute inset-0 bg-white/75 backdrop-blur-[2px]"></div>
        <div class="relative max-w-4xl mx-auto px-6 text-center z-10">
            <h2 class="font-serif text-3xl md:text-4xl lg:text-[2.75rem] font-bold text-gray-900 mb-5 leading-tight">Siap Wujudkan Pernikahan Impian Anda?</h2>
            <p class="text-gray-600 mb-8 max-w-xl mx-auto text-[14px] leading-relaxed">Konsultasikan kebutuhan Anda bersama tim kami secara gratis. Mari rencanakan momen bahagia Anda dari sekarang.</p>
            <a href="https://wa.me/6281234567890" target="_blank" class="inline-flex items-center justify-center bg-brand-gold hover:bg-[#B88655] text-white px-8 py-3.5 rounded-md text-[13px] font-medium transition shadow-xl shadow-brand-gold/20">
                Konsultasi Sekarang <i class="fab fa-whatsapp ml-2 text-lg"></i>
            </a>
        </div>
    </section>

    <!-- Footer -->
    <footer id="kontak" class="bg-white pt-20 pb-8 border-t border-gray-100">
        <div class="max-w-[1400px] mx-auto px-6 md:px-12 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-10 lg:gap-8 mb-16">

            <div class="lg:col-span-2 pr-4">
                <div class="flex items-center gap-3 mb-6">
                    <img src="{{ asset('images/permata-qiana/logo-placeholder.png') }}" onerror="this.outerHTML='<div class=\'w-10 h-10 rounded-full border border-brand-gold flex items-center justify-center text-brand-gold font-serif text-xl\'>P</div>'" alt="Logo" class="w-10 h-10">
                    <div>
                        <h3 class="font-serif font-bold text-gray-800 leading-tight uppercase tracking-widest text-[13px]">{{ $client->brand_name }}</h3>
                        <p class="text-[9px] tracking-[0.3em] text-gray-500 uppercase mt-0.5">Wedding</p>
                    </div>
                </div>
                <p class="text-gray-500 text-[12px] leading-relaxed mb-6 max-w-[280px]">Mewujudkan setiap momen berharga Anda menjadi kenangan tak terlupakan bersama {{ $client->brand_name }}.</p>
            </div>

            <div>
                <h4 class="font-bold text-gray-900 mb-5 text-[14px]">Navigasi</h4>
                <ul class="space-y-3 text-[13px] text-gray-500">
                    <li><a href="#" class="hover:text-brand-gold transition">Beranda</a></li>
                    <li><a href="#tentang" class="hover:text-brand-gold transition">Tentang Kami</a></li>
                    <li><a href="#layanan" class="hover:text-brand-gold transition">Layanan</a></li>
                    <li><a href="#galeri" class="hover:text-brand-gold transition">Galeri</a></li>
                </ul>
            </div>

            <div>
                <h4 class="font-bold text-gray-900 mb-5 text-[14px]">Link Bermanfaat</h4>
                <ul class="space-y-3 text-[13px] text-gray-500">
                    <li><a href="#paket" class="hover:text-brand-gold transition">Paket</a></li>
                    <li><a href="#testimoni" class="hover:text-brand-gold transition">Testimoni</a></li>
                    <li><a href="#blog" class="hover:text-brand-gold transition">Blog</a></li>
                    <li><a href="#kontak" class="hover:text-brand-gold transition">Kontak</a></li>
                </ul>
            </div>

            <div>
                <h4 class="font-bold text-gray-900 mb-5 text-[14px]">Hubungi Kami</h4>
                <ul class="space-y-3 text-[13px] text-gray-500 mb-6">
                    <li class="flex items-start gap-3">
                        <i class="fas fa-phone-alt mt-1 text-brand-gold w-4"></i>
                        <span>0812-3456-7890</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <i class="far fa-envelope mt-1 text-brand-gold w-4"></i>
                        <span>info@{{ strtolower(str_replace(" ", "", $client->brand_name)) }}.com</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <i class="fas fa-map-marker-alt mt-1 text-brand-gold w-4"></i>
                        <span class="leading-relaxed">Jl. Kebahagiaan No. 88,<br>Jakarta</span>
                    </li>
                </ul>
                <div class="flex gap-3">
                    <a href="#" class="w-8 h-8 rounded-full border border-gray-200 flex items-center justify-center text-gray-500 hover:bg-brand-gold hover:text-white hover:border-brand-gold transition text-sm"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="w-8 h-8 rounded-full border border-gray-200 flex items-center justify-center text-gray-500 hover:bg-brand-gold hover:text-white hover:border-brand-gold transition text-sm"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="w-8 h-8 rounded-full border border-gray-200 flex items-center justify-center text-gray-500 hover:bg-brand-gold hover:text-white hover:border-brand-gold transition text-sm"><i class="fab fa-tiktok"></i></a>
                    <a href="#" class="w-8 h-8 rounded-full border border-gray-200 flex items-center justify-center text-gray-500 hover:bg-brand-gold hover:text-white hover:border-brand-gold transition text-sm"><i class="fab fa-youtube"></i></a>
                </div>
            </div>

        </div>

        <div class="border-t border-gray-100 pt-6 flex flex-col md:flex-row justify-between items-center max-w-[1400px] mx-auto px-6 md:px-12 text-[11px] text-gray-400">
            <p>&copy; 2026 {{ $client->brand_name }}. All rights reserved.</p>
            <div class="flex gap-4 mt-3 md:mt-0">
                <span class="font-medium text-gray-500">Jam Operasional:</span>
                <span>Senin - Sabtu (09.00 - 18.00)</span>
                <span>Minggu (10.00 - 16.00)</span>
            </div>
        </div>
    </footer>

    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
    <script>
        var swiper = new Swiper(".mySwiper", {
            slidesPerView: 1
            , spaceBetween: 16
            , loop: true
            , pagination: {
                el: ".swiper-pagination"
                , clickable: true
            }
            , navigation: {
                nextEl: ".swiper-button-next"
                , prevEl: ".swiper-button-prev"
            }
            , breakpoints: {
                480: {
                    slidesPerView: 2
                    , spaceBetween: 16
                }
                , 768: {
                    slidesPerView: 3
                    , spaceBetween: 20
                }
                , 1024: {
                    slidesPerView: 4
                    , spaceBetween: 24
                }
                , 1280: {
                    slidesPerView: 5
                    , spaceBetween: 24
                }
            }
        });

        // Navbar scroll effect
        window.addEventListener('scroll', function() {
            const navbar = document.getElementById('navbar');
            if (window.scrollY > 20) {
                navbar.classList.add('shadow-sm', 'py-3');
                navbar.classList.remove('py-4');
            } else {
                navbar.classList.remove('shadow-sm', 'py-3');
                navbar.classList.add('py-4');
            }
        });

    </script>
</body>
</html>
