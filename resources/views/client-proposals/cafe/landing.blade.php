<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Demo Website - {{ $client->brand_name }}</title>
    <meta name="description" content="Preview desain website kafe eksklusif untuk {{ $client->brand_name }} yang disiapkan oleh Scalify Intelligence.">

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            coffee: '#4A3B32'
                            , caramel: '#C3976A'
                            , cream: '#FAEDCD'
                            , latte: '#E6D5C3'
                            , dark: '#1C1917'
                        }
                    }
                    , fontFamily: {
                        serif: ['Playfair Display', 'serif']
                        , sans: ['Outfit', 'sans-serif']
                    , }
                }
            }
        }

    </script>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&family=Outfit:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />

    <style>
        body {
            font-family: 'Outfit', sans-serif;
            color: #4A3B32;
            background-color: #FAEDCD;
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

        .coffee-blob {
            border-radius: 41% 59% 41% 59% / 46% 38% 62% 54%;
        }

    </style>
</head>
<body class="antialiased selection:bg-brand-caramel selection:text-white">

    <!-- Navbar -->
    <nav class="fixed w-full z-50 transition-all duration-300 bg-[#FAEDCD]/90 backdrop-blur-md border-b border-brand-latte py-4 px-6 md:px-12 flex justify-between items-center" id="navbar">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-full bg-brand-coffee flex items-center justify-center text-brand-cream font-serif text-xl shadow-md">
                <i class="fas fa-coffee text-sm"></i>
            </div>
            <div>
                <h1 class="font-serif font-bold text-brand-coffee leading-tight tracking-[0.1em] text-sm md:text-[15px]">{{ strtoupper($client->brand_name) }}</h1>
                <p class="text-[9px] tracking-[0.3em] text-brand-caramel uppercase text-center mt-0.5">Artisan Cafe</p>
            </div>
        </div>

        <div class="hidden lg:flex items-center gap-10 text-[13px] font-medium text-brand-coffee/80">
            <a href="#" class="text-brand-caramel font-semibold">Home</a>
            <a href="#menu" class="hover:text-brand-caramel transition">Our Menu</a>
            <a href="#about" class="hover:text-brand-caramel transition">The Story</a>
            <a href="#gallery" class="hover:text-brand-caramel transition">Gallery</a>
        </div>

        <div class="hidden lg:block">
            <a href="{{ route('proposal.dynamic', $client->slug) }}" class="bg-brand-coffee hover:bg-brand-dark text-brand-cream px-7 py-2.5 rounded-full text-[13px] font-medium transition shadow-lg shadow-brand-coffee/20">Lihat Proposal</a>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="relative pt-32 pb-24 md:pt-48 md:pb-32 px-6 md:px-16 flex items-center min-h-[90vh] overflow-hidden bg-brand-cream">
        <div class="max-w-[1400px] mx-auto w-full relative z-20 flex flex-col md:flex-row items-center gap-12">

            <div class="w-full md:w-1/2">
                <p class="text-brand-caramel font-semibold text-[11px] md:text-[12px] tracking-[0.3em] uppercase mb-4 flex items-center gap-2">
                    <span class="w-8 h-[1px] bg-brand-caramel"></span> Taste The Magic
                </p>
                <h1 class="font-serif text-5xl md:text-6xl lg:text-[5rem] font-bold text-brand-coffee leading-[1.1] mb-6">
                    Aroma <span class="italic text-brand-caramel">Kopi,</span><br>
                    Suasana Hangat.
                </h1>
                <p class="text-brand-coffee/70 text-[15px] md:text-[16px] mb-10 max-w-[480px] leading-relaxed">
                    Setiap cangkir di <strong>{{ $client->brand_name }}</strong> diseduh dengan biji kopi pilihan terbaik, menyajikan rasa autentik untuk menemani momen berharga Anda hari ini.
                </p>

                <div class="flex flex-wrap gap-4">
                    <a href="#menu" class="bg-brand-coffee hover:bg-brand-dark text-brand-cream px-8 py-3.5 rounded-full text-[14px] font-medium transition flex items-center gap-2 shadow-lg shadow-brand-coffee/20">
                        Lihat Menu <i class="fas fa-arrow-right ml-1 text-xs"></i>
                    </a>
                    <a href="https://wa.me/6281234567890" target="_blank" class="border border-brand-coffee/20 hover:border-brand-coffee bg-transparent text-brand-coffee px-8 py-3.5 rounded-full text-[14px] font-medium transition flex items-center gap-2">
                        Reservasi Tempat
                    </a>
                </div>
            </div>

            <div class="w-full md:w-1/2 relative flex justify-center mt-10 md:mt-0">
                <div class="relative w-[300px] h-[400px] md:w-[400px] md:h-[500px]">
                    <div class="absolute inset-0 bg-brand-caramel/20 coffee-blob transform rotate-12 scale-105"></div>
                    <img src="https://images.unsplash.com/photo-1497935586351-b67a49e012bf?auto=format&fit=crop&q=80&w=800" alt="Coffee Cup" class="w-full h-full object-cover coffee-blob shadow-2xl relative z-10 border-8 border-brand-cream">

                    <div class="absolute -bottom-6 -left-6 bg-white p-4 rounded-2xl shadow-xl z-20 flex items-center gap-4 border border-brand-cream">
                        <div class="w-12 h-12 rounded-full bg-brand-caramel/10 flex items-center justify-center text-brand-caramel text-xl">
                            <i class="fas fa-star"></i>
                        </div>
                        <div>
                            <p class="text-[11px] text-gray-500 font-medium">Rating Pelanggan</p>
                            <p class="font-serif font-bold text-lg text-brand-coffee">4.9/5.0</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <!-- Menu Highlight -->
    <section id="menu" class="py-24 px-6 md:px-12 bg-white rounded-t-[3rem] relative z-30 -mt-8 shadow-[0_-10px_40px_rgba(74,59,50,0.05)]">
        <div class="max-w-[1400px] mx-auto text-center mb-16">
            <h2 class="font-serif text-3xl md:text-[2.5rem] font-bold text-brand-coffee mb-4">Signature Menu</h2>
            <p class="text-brand-coffee/60 text-[14px] max-w-xl mx-auto">Kreasi terbaik dari barista kami, diracik khusus untuk memanjakan lidah Anda.</p>
        </div>

        <div class="max-w-[1200px] mx-auto grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Menu 1 -->
            <div class="group cursor-pointer">
                <div class="relative h-72 rounded-[2rem] overflow-hidden mb-6">
                    <img src="https://images.unsplash.com/photo-1554118811-1e0d58224f24?auto=format&fit=crop&q=80&w=600" class="w-full h-full object-cover group-hover:scale-110 transition duration-700">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent opacity-0 group-hover:opacity-100 transition duration-500"></div>
                </div>
                <div class="text-center">
                    <h3 class="font-serif text-xl font-bold text-brand-coffee mb-2">{{ $client->brand_name }} Special Latte</h3>
                    <p class="text-brand-coffee/60 text-sm mb-3">Espresso house blend dengan susu segar dan ekstrak caramel rahasia.</p>
                    <p class="font-bold text-brand-caramel">Rp 35.000</p>
                </div>
            </div>

            <!-- Menu 2 -->
            <div class="group cursor-pointer">
                <div class="relative h-72 rounded-[2rem] overflow-hidden mb-6">
                    <img src="https://images.unsplash.com/photo-1550617931-e17a7b70dce2?auto=format&fit=crop&q=80&w=600" class="w-full h-full object-cover group-hover:scale-110 transition duration-700">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent opacity-0 group-hover:opacity-100 transition duration-500"></div>
                </div>
                <div class="text-center">
                    <h3 class="font-serif text-xl font-bold text-brand-coffee mb-2">Butter Croissant</h3>
                    <p class="text-brand-coffee/60 text-sm mb-3">Pastry renyah yang dipanggang segar setiap pagi dengan french butter.</p>
                    <p class="font-bold text-brand-caramel">Rp 28.000</p>
                </div>
            </div>

            <!-- Menu 3 -->
            <div class="group cursor-pointer">
                <div class="relative h-72 rounded-[2rem] overflow-hidden mb-6">
                    <img src="https://images.unsplash.com/photo-1514432324607-a09d9b4aefdd?auto=format&fit=crop&q=80&w=600" class="w-full h-full object-cover group-hover:scale-110 transition duration-700">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent opacity-0 group-hover:opacity-100 transition duration-500"></div>
                </div>
                <div class="text-center">
                    <h3 class="font-serif text-xl font-bold text-brand-coffee mb-2">Manual Brew V60</h3>
                    <p class="text-brand-coffee/60 text-sm mb-3">Pilihan single origin beans terbaik untuk sensasi ngopi yang clean & fruity.</p>
                    <p class="font-bold text-brand-caramel">Rp 40.000</p>
                </div>
            </div>
        </div>
    </section>

    <!-- About & Ambiance -->
    <section id="about" class="py-24 px-6 md:px-12 bg-brand-coffee text-brand-cream relative overflow-hidden">
        <!-- Abstract Bg -->
        <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-brand-caramel/20 rounded-full blur-[100px] -mr-40 -mt-20"></div>

        <div class="max-w-[1400px] mx-auto flex flex-col md:flex-row items-center gap-16 relative z-10">
            <div class="w-full md:w-1/2">
                <div class="grid grid-cols-2 gap-4">
                    <img src="https://images.unsplash.com/photo-1559925393-8be0ec4767c8?auto=format&fit=crop&q=80&w=600" class="rounded-2xl w-full h-48 md:h-64 object-cover mt-8">
                    <img src="https://images.unsplash.com/photo-1525610553991-2bede1a236e2?auto=format&fit=crop&q=80&w=600" class="rounded-2xl w-full h-48 md:h-64 object-cover">
                </div>
            </div>
            <div class="w-full md:w-1/2">
                <h2 class="font-serif text-3xl md:text-5xl font-bold mb-6 text-white leading-tight">Lebih dari Sekedar <br><span class="text-brand-caramel italic">Tempat Ngopi.</span></h2>
                <p class="text-brand-cream/70 text-[15px] leading-relaxed mb-6">
                    Di <strong>{{ $client->brand_name }}</strong>, kami percaya bahwa secangkir kopi bisa menyatukan banyak cerita. Desain interior kami dirancang khusus untuk memberikan kenyamanan, baik untuk Anda yang ingin fokus bekerja, meeting santai, maupun menghabiskan waktu bersama teman terdekat.
                </p>
                <ul class="space-y-4 mb-10 text-[14px]">
                    <li class="flex items-center gap-3"><i class="fas fa-wifi text-brand-caramel"></i> High-Speed WiFi (Up to 100Mbps)</li>
                    <li class="flex items-center gap-3"><i class="fas fa-plug text-brand-caramel"></i> Stopkontak di Setiap Meja</li>
                    <li class="flex items-center gap-3"><i class="fas fa-music text-brand-caramel"></i> Playlist Akustik & Jazz Santai</li>
                </ul>
                <a href="#menu" class="inline-block border border-brand-caramel hover:bg-brand-caramel text-brand-caramel hover:text-brand-coffee px-8 py-3 rounded-full text-[13px] font-medium transition">Explore Galeri Interior</a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-brand-dark pt-20 pb-8 text-brand-cream border-t border-white/10">
        <div class="max-w-[1200px] mx-auto px-6 text-center">
            <h2 class="font-serif text-3xl font-bold text-white mb-6">{{ strtoupper($client->brand_name) }}</h2>
            <p class="text-brand-cream/60 text-sm max-w-md mx-auto mb-8">Pilihan tepat untuk menikmati seduhan kopi artisan dan suasana cafe yang estetik. Sampai jumpa di kedai kami!</p>

            <div class="flex justify-center gap-6 mb-12">
                <a href="#" class="w-10 h-10 rounded-full border border-brand-cream/20 flex items-center justify-center hover:bg-brand-caramel hover:border-brand-caramel transition"><i class="fab fa-instagram"></i></a>
                <a href="#" class="w-10 h-10 rounded-full border border-brand-cream/20 flex items-center justify-center hover:bg-brand-caramel hover:border-brand-caramel transition"><i class="fab fa-tiktok"></i></a>
                <a href="#" class="w-10 h-10 rounded-full border border-brand-cream/20 flex items-center justify-center hover:bg-brand-caramel hover:border-brand-caramel transition"><i class="fab fa-whatsapp"></i></a>
            </div>

            <p class="text-[11px] text-brand-cream/40">&copy; 2026 {{ $client->brand_name }}. Designed by Scalify Intelligence.</p>
        </div>
    </footer>

</body>
</html>
