<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Proposal Project: {{ $client->brand_name }}</title>
    <meta name="description" content="Penawaran pembuatan aplikasi {{ $client->brand_name }} lengkap dengan source code untuk kebutuhan Skripsi / Tugas Akhir.">

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            blue: '#2563EB',
                            dark: '#0B1120',
                            light: '#F8FAFC',
                            accent: '#38BDF8'
                        }
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #0B1120;
            color: #F8FAFC;
        }

        .glass-panel {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .gradient-text {
            background-clip: text;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-image: linear-gradient(to right, #38BDF8, #2563EB);
        }
    </style>
</head>
<body class="antialiased selection:bg-brand-blue selection:text-white">

    <!-- Navbar -->
    <nav class="fixed w-full z-50 transition-all duration-300 py-4 backdrop-blur-md bg-[#0B1120]/80 border-b border-white/10">
        <div class="max-w-[1200px] mx-auto px-6 flex justify-between items-center">
            <div class="text-xl font-bold tracking-tighter text-white">
                <i class="fa-solid fa-code text-brand-accent mr-2"></i> {{ $client->brand_name }}
            </div>
            <a href="#pricing" class="bg-brand-blue hover:bg-blue-600 text-white px-5 py-2 rounded-full text-sm font-semibold transition shadow-lg shadow-blue-500/30">
                Pesan Sekarang
            </a>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="relative pt-32 pb-20 px-6 md:px-12 overflow-hidden min-h-screen flex items-center">
        <!-- Decoration -->
        <div class="absolute top-1/4 left-1/4 w-96 h-96 bg-brand-blue/20 rounded-full blur-[120px] pointer-events-none"></div>
        <div class="absolute bottom-1/4 right-1/4 w-96 h-96 bg-brand-accent/20 rounded-full blur-[120px] pointer-events-none"></div>

        <div class="max-w-[1200px] mx-auto relative z-10 w-full flex flex-col md:flex-row items-center gap-12">
            <div class="w-full md:w-1/2 text-center md:text-left">
                <div class="inline-block px-3 py-1 bg-blue-500/10 border border-blue-500/20 text-brand-accent rounded-full text-xs font-bold mb-6">
                    <i class="fa-solid fa-graduation-cap mr-1"></i> Solusi Skripsi & Tugas Akhir
                </div>
                <h1 class="text-4xl md:text-6xl font-extrabold text-white leading-tight mb-6">
                    Wujudkan Aplikasi <br><span class="gradient-text">{{ $client->brand_name }}</span> Tanpa Pusing.
                </h1>
                <p class="text-slate-300 text-lg mb-8 leading-relaxed max-w-lg mx-auto md:mx-0">
                    Kami menyiapkan <i>source code</i> lengkap, database, dan arsitektur rapi untuk aplikasi E-Commerce / CRM kamu. Siap deploy dan diuji dosen penguji!
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center md:justify-start">
                    <a href="#features" class="bg-brand-blue hover:bg-blue-600 text-white px-8 py-3.5 rounded-xl font-semibold transition shadow-lg shadow-blue-500/30 text-center">
                        Lihat Fitur <i class="fa-solid fa-arrow-right ml-2"></i>
                    </a>
                    <a href="#demo" class="glass-panel text-white hover:bg-white/10 px-8 py-3.5 rounded-xl font-semibold transition text-center">
                        Lihat Demo UI
                    </a>
                </div>
            </div>
            
            <div class="w-full md:w-1/2 relative">
                <!-- Mac mockup -->
                <div class="relative mx-auto rounded-t-xl bg-slate-800 border-t-8 border-x-8 border-slate-900 shadow-2xl overflow-hidden aspect-video">
                    <div class="absolute top-2 left-2 flex gap-1.5">
                        <div class="w-2.5 h-2.5 rounded-full bg-red-500"></div>
                        <div class="w-2.5 h-2.5 rounded-full bg-yellow-500"></div>
                        <div class="w-2.5 h-2.5 rounded-full bg-green-500"></div>
                    </div>
                    <img src="https://images.unsplash.com/photo-1555421689-491a97ff2040?auto=format&fit=crop&q=80&w=800" alt="Dashboard Preview" class="w-full h-full object-cover mt-6">
                </div>
                <div class="h-4 bg-slate-400 w-full rounded-b-xl mx-auto shadow-2xl relative">
                    <div class="absolute left-1/2 -translate-x-1/2 top-0 w-24 h-1.5 bg-slate-500 rounded-b-md"></div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features -->
    <section id="features" class="py-24 px-6 relative bg-white/5 border-y border-white/5">
        <div class="max-w-[1200px] mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold text-white mb-4">Fitur Lengkap Skripsi Kamu</h2>
                <p class="text-slate-400 max-w-xl mx-auto">Modul E-Commerce/CRM sudah dirancang memenuhi standar kompleksitas untuk penelitian Tugas Akhir.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Fitur 1 -->
                <div class="glass-panel p-8 rounded-3xl hover:bg-white/10 transition-colors">
                    <div class="w-14 h-14 bg-blue-500/20 text-brand-accent rounded-2xl flex items-center justify-center text-2xl mb-6">
                        <i class="fa-solid fa-cart-shopping"></i>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-3">Manajemen Transaksi</h3>
                    <p class="text-slate-400 text-sm leading-relaxed">Sistem keranjang belanja cerdas, perhitungan ongkos kirim otomatis (API), dan status pembayaran yang rapi.</p>
                </div>

                <!-- Fitur 2 -->
                <div class="glass-panel p-8 rounded-3xl hover:bg-white/10 transition-colors">
                    <div class="w-14 h-14 bg-blue-500/20 text-brand-accent rounded-2xl flex items-center justify-center text-2xl mb-6">
                        <i class="fa-solid fa-users-gear"></i>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-3">Admin & CRM Dashboard</h3>
                    <p class="text-slate-400 text-sm leading-relaxed">Dashboard statistik visual untuk admin memantau perilaku pelanggan, retensi, dan performa produk secara harian.</p>
                </div>

                <!-- Fitur 3 -->
                <div class="glass-panel p-8 rounded-3xl hover:bg-white/10 transition-colors">
                    <div class="w-14 h-14 bg-blue-500/20 text-brand-accent rounded-2xl flex items-center justify-center text-2xl mb-6">
                        <i class="fa-solid fa-file-code"></i>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-3">Clean Architecture</h3>
                    <p class="text-slate-400 text-sm leading-relaxed">Source code ditulis rapi menggunakan standard MVC Framework (Laravel/NextJS) agar mudah dijelaskan saat sidang.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Pricing / Package -->
    <section id="pricing" class="py-24 px-6 relative">
        <div class="max-w-[800px] mx-auto text-center">
            <h2 class="text-3xl font-bold text-white mb-6">Amankan Project Kamu Sekarang</h2>
            <p class="text-slate-400 mb-12">Tidak perlu stres dengan *error bug* berhari-hari. Fokus di penulisan bab, biarkan teknis aplikasinya kami bereskan.</p>

            <div class="glass-panel p-1 border-brand-blue/30 rounded-3xl relative overflow-hidden text-left">
                <div class="absolute inset-0 bg-gradient-to-br from-blue-600/10 to-indigo-600/10"></div>
                <div class="bg-[#0B1120] p-8 md:p-12 rounded-[22px] relative z-10 flex flex-col md:flex-row items-center gap-8">
                    <div class="flex-1">
                        <h3 class="text-2xl font-bold text-white mb-2">Paket Joki Skripsi VIP</h3>
                        <p class="text-brand-accent font-semibold mb-6">Mulai Rp 1.500.000</p>
                        <ul class="space-y-3 mb-6">
                            <li class="flex items-center text-sm text-slate-300"><i class="fa-solid fa-circle-check text-green-400 mr-3"></i> Full Source Code & Database</li>
                            <li class="flex items-center text-sm text-slate-300"><i class="fa-solid fa-circle-check text-green-400 mr-3"></i> Gratis Revisi Minor (3x)</li>
                            <li class="flex items-center text-sm text-slate-300"><i class="fa-solid fa-circle-check text-green-400 mr-3"></i> Bimbingan Penjelasan Logika Code (Zoom)</li>
                            <li class="flex items-center text-sm text-slate-300"><i class="fa-solid fa-circle-check text-green-400 mr-3"></i> Garansi Bebas Error (Hingga Sidang)</li>
                        </ul>
                    </div>
                    <div class="w-full md:w-auto shrink-0">
                        <a href="https://wa.me/6281234567890?text=Halo%20tim%20Scalify,%20saya%20tertarik%20dengan%20paket%20joki%20skripsi%20untuk%20{{ urlencode($client->brand_name) }}" class="block w-full text-center bg-white text-brand-dark px-8 py-4 rounded-xl font-bold hover:bg-slate-200 transition">
                            Tanya Dulu (WA)
                        </a>
                        <p class="text-[10px] text-slate-500 text-center mt-3">*Sistem booking kuota per bulan</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-black/50 py-12 border-t border-white/5 text-center px-6">
        <div class="max-w-[1200px] mx-auto">
            <h2 class="font-bold text-white mb-4"><i class="fa-solid fa-code text-brand-accent mr-2"></i> {{ $client->brand_name }}</h2>
            <p class="text-slate-500 text-xs max-w-md mx-auto mb-6">
                Ini adalah halaman preview eksklusif yang di-generate untuk keperluan penawaran project. Scalify membantu mahasiswa menyelesaikan target pengembangan sistem dengan cepat dan rapi.
            </p>
            <p class="text-[10px] text-slate-600">&copy; {{ date('Y') }} Scalify Education & Development.</p>
        </div>
    </footer>

</body>
</html>
