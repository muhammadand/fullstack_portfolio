@extends('layouts.app')

@section('meta_tags')
<title>Program Kemitraan & Afiliasi - Raih Penghasilan Bersama Scalify Intelligence</title>
<meta name="title" content="Program Kemitraan & Afiliasi - Raih Penghasilan Bersama Scalify Intelligence" />
<meta name="description" content="Bergabunglah dengan program Sobat Scalify Partner. Rekomendasikan layanan website & sistem kustom ke bisnis lokal, dapatkan komisi Rp 100.000 - Rp 200.000 per closing tanpa modal." />
<meta name="keywords" content="program afiliasi, affiliate marketing, komisi pembuatan website, komisi skripsi IT, uang tambahan mahasiswa, affiliate sobat scalify, bisnis online tanpa modal" />
<meta name="robots" content="index, follow" />
<link rel="canonical" href="{{ url()->current() }}" />

<!-- Open Graph / Facebook -->
<meta property="og:type" content="website" />
<meta property="og:url" content="{{ url()->current() }}" />
<meta property="og:title" content="Program Kemitraan & Afiliasi - Raih Penghasilan Bersama Scalify Intelligence" />
<meta property="og:description" content="Rekomendasikan layanan website & sistem kustom ke bisnis lokal, dapatkan komisi Rp 100.000 - Rp 200.000 per closing tanpa modal." />
<meta property="og:image" content="{{ asset('images/partner_flow.png') }}" />

<!-- Twitter -->
<meta property="twitter:card" content="summary_large_image" />
<meta property="twitter:url" content="{{ url()->current() }}" />
<meta property="twitter:title" content="Program Kemitraan & Afiliasi - Raih Penghasilan Bersama Scalify Intelligence" />
<meta property="twitter:description" content="Rekomendasikan layanan website & sistem kustom ke bisnis lokal, dapatkan komisi Rp 100.000 - Rp 200.000 per closing tanpa modal." />
<meta property="twitter:image" content="{{ asset('images/partner_flow.png') }}" />
@endsection

@section('content')
<div class="bg-brand-dark text-white min-h-screen font-sans relative overflow-hidden">

    {{-- Top Ambient Glow --}}
    <div class="absolute top-0 left-1/2 -translate-x-1/2 w-full max-w-7xl h-[450px] bg-gradient-to-b from-brand-blue/15 via-indigo-600/10 to-transparent blur-3xl pointer-events-none"></div>

    {{-- Hero Section --}}
    <section class="relative pt-20 pb-16 lg:pt-28 lg:pb-24 overflow-hidden border-b border-white/5">
        <div class="absolute inset-0 bg-hero-gradient pointer-events-none"></div>
        <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-brand-blue/15 rounded-full blur-[140px] pointer-events-none"></div>

        {{-- Subtle Grid Pattern Background --}}
        <div class="absolute inset-0 opacity-[0.035] pointer-events-none" style="background-image: radial-gradient(#ffffff 1px, transparent 1px); background-size: 28px 28px;"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">

            {{-- Eyebrow Badge --}}
            <div class="mb-4">
                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-amber-500/10 border border-amber-500/20 text-amber-300 font-bold text-[11px] sm:text-xs tracking-[0.15em] uppercase shadow-sm shadow-amber-500/10">
                    <i class="fa-solid fa-gem text-amber-400 text-xs"></i>
                    <span>Sobat Scalify Partner Program</span>
                </div>
            </div>

            {{-- Main Headline --}}
            <h1 class="font-sans font-black text-3xl sm:text-5xl lg:text-[50px] text-white leading-[1.18] tracking-[-0.03em] max-w-4xl mx-auto mb-4">
                Raih Komisi Jutaan Rupiah<br />
                <span class="bg-gradient-to-r from-blue-400 via-cyan-300 to-indigo-400 bg-clip-text text-transparent">Tanpa Modal & Tanpa Perlu Coding</span>
            </h1>

            {{-- Subtitle --}}
            <p class="text-white/65 text-xs sm:text-sm md:text-base leading-relaxed max-w-2xl mx-auto mb-8 font-normal">
                Cukup bagikan <strong>Proposal & Landing Page Siap Pakai</strong> ke bisnis lokal atau calon klien. Tim Scalify yang urus presentasi, negosiasi, dan pengerjaannya. Anda langsung terima komisi per deal!
            </p>

            {{-- Key Selling Points Pills --}}
            <div class="flex flex-wrap items-center justify-center gap-2.5 sm:gap-3 mb-10 max-w-3xl mx-auto text-xs font-semibold">
                <div class="px-3.5 py-2 rounded-xl bg-white/5 border border-white/10 text-emerald-300 flex items-center gap-2">
                    <i class="fa-solid fa-money-bill-wave text-emerald-400"></i>
                    <span>Komisi Rp 100.000 – Rp 200.000 / Deal</span>
                </div>
                <div class="px-3.5 py-2 rounded-xl bg-white/5 border border-white/10 text-cyan-300 flex items-center gap-2">
                    <i class="fa-solid fa-gift text-cyan-400"></i>
                    <span>Bahan Promosi & Proposal Gratis</span>
                </div>
                <div class="px-3.5 py-2 rounded-xl bg-white/5 border border-white/10 text-amber-300 flex items-center gap-2">
                    <i class="fa-solid fa-bolt text-amber-400"></i>
                    <span>Pendaftaran 100% Gratis & Instan</span>
                </div>
            </div>

            {{-- CTA Actions --}}
            <div class="flex flex-wrap items-center justify-center gap-3.5">
                <a href="{{ route('affiliate.register') }}" class="inline-flex items-center gap-2.5 bg-btn-gradient text-white text-xs sm:text-sm font-bold px-8 py-3.5 rounded-full shadow-glow-blue hover:scale-105 active:scale-95 transition-all">
                    <i class="fa-solid fa-user-plus text-xs"></i>
                    <span>Gabung Sekarang Gratis</span>
                    <span class="w-5 h-5 bg-white/20 rounded-full flex items-center justify-center text-[10px]">→</span>
                </a>
                <a href="{{ route('affiliate.login') }}" class="inline-flex items-center gap-2 bg-white/5 border border-white/15 hover:bg-white/10 text-white/90 hover:text-white text-xs sm:text-sm font-semibold px-6 py-3.5 rounded-full transition-all">
                    <i class="fa-solid fa-right-to-bracket text-cyan-400 text-xs"></i>
                    <span>Masuk Dashboard</span>
                </a>
            </div>

        </div>
    </section>

    {{-- How It Works Section (4 Simple Steps) --}}
    <section class="py-20 sm:py-24 px-4 sm:px-6 lg:px-8 bg-[#090d29] relative z-20 border-b border-white/5">
        <div class="max-w-7xl mx-auto">

            {{-- Header --}}
            <div class="text-center max-w-2xl mx-auto mb-16">
                <div class="text-cyan-400 font-extrabold text-[11px] sm:text-xs tracking-[0.2em] uppercase mb-1.5 inline-flex items-center gap-1.5">
                    <span class="w-1.5 h-1.5 rounded-full bg-cyan-400"></span>
                    CARA KERJA KEMITRAAN
                </div>
                <h2 class="font-sans font-black text-2xl sm:text-3xl lg:text-4xl text-white tracking-tight mb-3">
                    Alur <span class="bg-gradient-to-r from-blue-400 via-cyan-300 to-indigo-400 bg-clip-text text-transparent">Mudah Meraih Cuan</span>
                </h2>
                <p class="text-white/60 text-xs sm:text-sm font-normal">
                    Hanya 4 langkah mudah untuk mulai mendapatkan penghasilan tambahan tanpa repot membuat website sendiri.
                </p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-center">

                {{-- Left: Illustration / Mockup Card --}}
                <div class="lg:col-span-5 relative">
                    <div class="rounded-3xl p-2 bg-brand-navy/70 border border-white/10 backdrop-blur-xl shadow-2xl hover:border-cyan-400/30 transition-all duration-500 overflow-hidden">
                        <div class="absolute inset-0 bg-gradient-to-tr from-blue-500/15 to-transparent pointer-events-none"></div>
                        <img src="{{ asset('images/partner_flow.png') }}" alt="Alur Program Afiliasi Sobat Scalify" class="rounded-2xl w-full h-auto object-cover" loading="lazy" decoding="async">
                    </div>
                </div>

                {{-- Right: 4 Sequential Step Cards --}}
                <div class="lg:col-span-7 space-y-3.5 sm:space-y-4">

                    {{-- Step 1 --}}
                    <div class="flex items-start gap-4 p-4 sm:p-5 bg-brand-navy/60 backdrop-blur-xl border border-white/10 rounded-2xl hover:border-cyan-400/40 transition-all group">
                        <div class="w-11 h-11 rounded-xl bg-blue-500/15 border border-blue-400/25 text-cyan-400 flex items-center justify-center font-black text-base shrink-0 group-hover:scale-105 transition-transform shadow-sm">
                            01
                        </div>
                        <div>
                            <h4 class="font-bold text-sm sm:text-base text-white mb-1 group-hover:text-cyan-400 transition-colors">Pilih Target Pasar</h4>
                            <p class="text-white/60 text-xs sm:text-[13px] leading-relaxed font-normal">
                                Masuk ke Dashboard Partner, buka <strong>Katalog Proposal</strong>. Pilih kategori bisnis yang ingin Anda tawarkan (Wedding, Cafe, Rental Mobil, Toko Online, Travel, atau Skripsi IT).
                            </p>
                        </div>
                    </div>

                    {{-- Step 2 --}}
                    <div class="flex items-start gap-4 p-4 sm:p-5 bg-brand-navy/60 backdrop-blur-xl border border-white/10 rounded-2xl hover:border-cyan-400/40 transition-all group">
                        <div class="w-11 h-11 rounded-xl bg-indigo-500/15 border border-indigo-400/25 text-indigo-400 flex items-center justify-center font-black text-base shrink-0 group-hover:scale-105 transition-transform shadow-sm">
                            02
                        </div>
                        <div>
                            <h4 class="font-bold text-sm sm:text-base text-white mb-1 group-hover:text-indigo-300 transition-colors">Bagikan Proposal & Demo Link</h4>
                            <p class="text-white/60 text-xs sm:text-[13px] leading-relaxed font-normal">
                                Kami sudah siapkan <strong>Landing Page Demo & PDF Proposal Profesional</strong> yang otomatis disematkan ID Partner Anda. Cukup copy link dan kirim via WhatsApp atau medsos.
                            </p>
                        </div>
                    </div>

                    {{-- Step 3 --}}
                    <div class="flex items-start gap-4 p-4 sm:p-5 bg-brand-navy/60 backdrop-blur-xl border border-white/10 rounded-2xl hover:border-cyan-400/40 transition-all group">
                        <div class="w-11 h-11 rounded-xl bg-purple-500/15 border border-purple-400/25 text-purple-400 flex items-center justify-center font-black text-base shrink-0 group-hover:scale-105 transition-transform shadow-sm">
                            03
                        </div>
                        <div>
                            <h4 class="font-bold text-sm sm:text-base text-white mb-1 group-hover:text-purple-300 transition-colors">Tim Ahli Scalify yang Closing</h4>
                            <p class="text-white/60 text-xs sm:text-[13px] leading-relaxed font-normal">
                                Saat klien menghubungi dari link Anda, tim konsultan kami yang akan mempresentasikan, negosiasi harga, dan mengeksekusi pengerjaan website hingga selesai.
                            </p>
                        </div>
                    </div>

                    {{-- Step 4 --}}
                    <div class="flex items-start gap-4 p-4 sm:p-5 bg-brand-navy/60 backdrop-blur-xl border border-emerald-500/25 rounded-2xl hover:border-emerald-400/50 transition-all group">
                        <div class="w-11 h-11 rounded-xl bg-emerald-500/15 border border-emerald-400/25 text-emerald-400 flex items-center justify-center font-black text-base shrink-0 group-hover:scale-105 transition-transform shadow-sm">
                            04
                        </div>
                        <div>
                            <h4 class="font-bold text-sm sm:text-base text-white mb-1 group-hover:text-emerald-300 transition-colors">Terima Komisi Langsung Cair</h4>
                            <p class="text-white/60 text-xs sm:text-[13px] leading-relaxed font-normal">
                                Begitu klien melakukan pembayaran, komisi <strong>Rp 100.000 – Rp 200.000</strong> per deal otomatis masuk ke saldo Dashboard dan dapat ditarik langsung ke rekening/e-wallet Anda!
                            </p>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </section>

    {{-- Income Simulation Section --}}
    <section class="py-20 sm:py-24 px-4 sm:px-6 lg:px-8 bg-brand-dark relative z-20 border-b border-white/5">
        <div class="max-w-7xl mx-auto">

            <div class="text-center max-w-2xl mx-auto mb-14">
                <div class="text-cyan-400 font-extrabold text-[11px] sm:text-xs tracking-[0.2em] uppercase mb-1.5 inline-flex items-center gap-1.5">
                    <span class="w-1.5 h-1.5 rounded-full bg-cyan-400"></span>
                    SIMULASI PENGHASILAN
                </div>
                <h2 class="font-sans font-black text-2xl sm:text-3xl lg:text-4xl text-white tracking-tight mb-3">
                    Berapa Potensi <span class="bg-gradient-to-r from-blue-400 via-cyan-300 to-indigo-400 bg-clip-text text-transparent">Cuan Anda?</span>
                </h2>
                <p class="text-white/60 text-xs sm:text-sm font-normal">
                    Ilustrasi pendapatan pasif bulanan berdasarkan jumlah closing dari link proposal Anda.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 max-w-5xl mx-auto">

                {{-- Tier 1 --}}
                <div class="bg-brand-navy/60 backdrop-blur-xl border border-white/10 rounded-2xl p-6 sm:p-7 text-center flex flex-col justify-between hover:border-white/20 transition-all">
                    <div>
                        <span class="px-3 py-1 bg-white/5 border border-white/10 text-white/70 text-[11px] font-bold rounded-full uppercase tracking-wider">Santai / Part-time</span>
                        <div class="font-sans font-black text-3xl sm:text-4xl text-white mt-4 mb-1">
                            Rp 1.000.000
                        </div>
                        <div class="text-cyan-400 text-xs font-semibold mb-4">5 Klien Deal / Bulan</div>
                        <p class="text-white/60 text-xs leading-relaxed font-normal">
                            Cukup tawarkan ke 1-2 kenalan pelaku bisnis atau UMKM setiap minggunya.
                        </p>
                    </div>
                </div>

                {{-- Tier 2 (Highlighted) --}}
                <div class="bg-brand-navy/80 backdrop-blur-xl border-2 border-cyan-400/40 rounded-2xl p-6 sm:p-7 text-center flex flex-col justify-between relative shadow-xl shadow-cyan-500/10 hover:border-cyan-400 transition-all">
                    <div class="absolute -top-3 left-1/2 -translate-x-1/2 px-3.5 py-0.5 bg-gradient-to-r from-blue-600 to-cyan-500 text-white text-[10px] font-bold rounded-full uppercase tracking-wider shadow-sm">
                        Paling Populer
                    </div>
                    <div>
                        <span class="px-3 py-1 bg-cyan-500/15 border border-cyan-500/25 text-cyan-300 text-[11px] font-bold rounded-full uppercase tracking-wider">Aktif Rekomendasi</span>
                        <div class="font-sans font-black text-3xl sm:text-4xl text-white mt-4 mb-1">
                            Rp 3.000.000
                        </div>
                        <div class="text-cyan-400 text-xs font-semibold mb-4">15 Klien Deal / Bulan</div>
                        <p class="text-white/60 text-xs leading-relaxed font-normal">
                            Bagikan materi proposal ke grup komunitas bisnis, UMKM lokal, atau marketplace.
                        </p>
                    </div>
                </div>

                {{-- Tier 3 --}}
                <div class="bg-brand-navy/60 backdrop-blur-xl border border-white/10 rounded-2xl p-6 sm:p-7 text-center flex flex-col justify-between hover:border-white/20 transition-all">
                    <div>
                        <span class="px-3 py-1 bg-white/5 border border-white/10 text-white/70 text-[11px] font-bold rounded-full uppercase tracking-wider">Pro Partner</span>
                        <div class="font-sans font-black text-3xl sm:text-4xl text-white mt-4 mb-1">
                            Rp 6.000.000+
                        </div>
                        <div class="text-cyan-400 text-xs font-semibold mb-4">30+ Klien Deal / Bulan</div>
                        <p class="text-white/60 text-xs leading-relaxed font-normal">
                            Jadikan sumber penghasilan utama dengan strategi broadcast dan jaringan networking luas.
                        </p>
                    </div>
                </div>

            </div>
        </div>
    </section>

    {{-- Benefits Section (Why Join?) --}}
    <section class="py-20 sm:py-24 px-4 sm:px-6 lg:px-8 bg-[#090d29] relative z-20 border-b border-white/5">
        <div class="max-w-7xl mx-auto">

            <div class="text-center max-w-2xl mx-auto mb-16">
                <div class="text-cyan-400 font-extrabold text-[11px] sm:text-xs tracking-[0.2em] uppercase mb-1.5 inline-flex items-center gap-1.5">
                    <span class="w-1.5 h-1.5 rounded-full bg-cyan-400"></span>
                    KEUNGGULAN PROGRAM
                </div>
                <h2 class="font-sans font-black text-2xl sm:text-3xl lg:text-4xl text-white tracking-tight mb-3">
                    Kenapa Harus Bergabung <span class="bg-gradient-to-r from-blue-400 via-cyan-300 to-indigo-400 bg-clip-text text-transparent">Bersama Kami?</span>
                </h2>
                <p class="text-white/60 text-xs sm:text-sm font-normal">
                    Kami mendesain sistem kemitraan ini agar paling mudah dijalankan dan memberikan hasil maksimal bagi Anda.
                </p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 sm:gap-6">

                {{-- Benefit 1 --}}
                <div class="bg-brand-navy/60 backdrop-blur-xl border border-white/10 rounded-2xl p-6 shadow-card hover:border-brand-accent/40 hover:-translate-y-1 transition-all group flex flex-col">
                    <div class="w-12 h-12 rounded-xl bg-blue-500/15 border border-blue-400/20 text-cyan-400 flex items-center justify-center mb-5 group-hover:scale-105 transition-transform">
                        <i class="fa-solid fa-money-bill-trend-up text-lg"></i>
                    </div>
                    <h3 class="font-bold text-base text-white mb-2 group-hover:text-cyan-400 transition-colors">Komisi Transparan</h3>
                    <p class="text-white/60 text-xs sm:text-[13px] leading-relaxed font-normal">
                        Komisi jelas <strong>Rp 100.000 – Rp 200.000/klien</strong> perusahaan atau <strong>Rp 50.000 – Rp 100.000/klien</strong> mahasiswa tanpa potongan tersembunyi.
                    </p>
                </div>

                {{-- Benefit 2 --}}
                <div class="bg-brand-navy/60 backdrop-blur-xl border border-white/10 rounded-2xl p-6 shadow-card hover:border-brand-accent/40 hover:-translate-y-1 transition-all group flex flex-col">
                    <div class="w-12 h-12 rounded-xl bg-emerald-500/15 border border-emerald-400/20 text-emerald-400 flex items-center justify-center mb-5 group-hover:scale-105 transition-transform">
                        <i class="fa-solid fa-file-pdf text-lg"></i>
                    </div>
                    <h3 class="font-bold text-base text-white mb-2 group-hover:text-emerald-300 transition-colors">Proposal & Demo Siap Pakai</h3>
                    <p class="text-white/60 text-xs sm:text-[13px] leading-relaxed font-normal">
                        Tak perlu repot membuat materi promosi. Kami siapkan Landing Page interaktif & PDF Proposal berkelas untuk berbagai kategori bisnis.
                    </p>
                </div>

                {{-- Benefit 3 --}}
                <div class="bg-brand-navy/60 backdrop-blur-xl border border-white/10 rounded-2xl p-6 shadow-card hover:border-brand-accent/40 hover:-translate-y-1 transition-all group flex flex-col">
                    <div class="w-12 h-12 rounded-xl bg-purple-500/15 border border-purple-400/20 text-purple-400 flex items-center justify-center mb-5 group-hover:scale-105 transition-transform">
                        <i class="fa-solid fa-chart-pie text-lg"></i>
                    </div>
                    <h3 class="font-bold text-base text-white mb-2 group-hover:text-purple-300 transition-colors">Dashboard Real-time</h3>
                    <p class="text-white/60 text-xs sm:text-[13px] leading-relaxed font-normal">
                        Pantau jumlah klik link, status prospek klien, dan saldo penghasilan Anda secara transparan kapan saja dari gadget Anda.
                    </p>
                </div>

                {{-- Benefit 4 --}}
                <div class="bg-brand-navy/60 backdrop-blur-xl border border-white/10 rounded-2xl p-6 shadow-card hover:border-brand-accent/40 hover:-translate-y-1 transition-all group flex flex-col">
                    <div class="w-12 h-12 rounded-xl bg-amber-500/15 border border-amber-400/20 text-amber-400 flex items-center justify-center mb-5 group-hover:scale-105 transition-transform">
                        <i class="fa-solid fa-wallet text-lg"></i>
                    </div>
                    <h3 class="font-bold text-base text-white mb-2 group-hover:text-amber-300 transition-colors">Pencairan Dana Fleksibel</h3>
                    <p class="text-white/60 text-xs sm:text-[13px] leading-relaxed font-normal">
                        Tarik saldo komisi kapan saja langsung ke rekening bank Anda (BCA, Mandiri, BRI, BNI) atau E-Wallet dengan proses yang cepat.
                    </p>
                </div>

            </div>
        </div>
    </section>

    {{-- CTA Bottom Section --}}
    <section class="bg-[#0c1033] py-20 px-4 sm:px-6 lg:px-8 text-center relative overflow-hidden border-t border-white/5">
        <div class="absolute inset-0 bg-blue-glow opacity-30 pointer-events-none"></div>
        <div class="relative z-10 max-w-2xl mx-auto">
            <div class="mb-3">
                <span class="text-cyan-400 font-extrabold text-[11px] sm:text-xs tracking-[0.2em] uppercase inline-flex items-center gap-1.5">
                    <span class="w-1.5 h-1.5 rounded-full bg-cyan-400"></span>
                    DAFTAR SEKARANG
                </span>
            </div>
            <h2 class="font-sans font-black text-3xl sm:text-4xl md:text-5xl text-white mb-4 leading-tight tracking-tight">
                Siap Meraih Penghasilan Tambahan?
            </h2>
            <p class="text-white/65 mb-8 text-xs sm:text-sm md:text-base leading-relaxed px-2 font-normal">
                Tidak dipungut biaya apapun! Pendaftaran cepat hanya dalam 1 menit, langsung dapatkan link dan mulai hasilkan cuan.
            </p>

            <div class="flex flex-wrap items-center justify-center gap-3.5 mb-8">
                <a href="{{ route('affiliate.register') }}" class="inline-flex items-center gap-2.5 bg-btn-gradient text-white font-bold px-8 py-4 rounded-full shadow-glow-blue hover:scale-105 active:scale-95 transition-all text-xs sm:text-sm">
                    <i class="fa-solid fa-rocket text-xs"></i>
                    <span>Daftar Gratis Sekarang</span>
                    <span class="w-6 h-6 bg-white/20 rounded-full flex items-center justify-center text-[10px]">→</span>
                </a>
            </div>

            <div class="flex flex-wrap items-center justify-center gap-6 text-white/50 text-xs sm:text-sm font-medium">
                <span class="flex items-center gap-1.5"><i class="fa-solid fa-check text-emerald-400"></i> Pendaftaran 100% Gratis</span>
                <span class="flex items-center gap-1.5"><i class="fa-solid fa-check text-emerald-400"></i> Komisi Pasti Cair</span>
                <span class="flex items-center gap-1.5"><i class="fa-solid fa-check text-emerald-400"></i> Support Full Tim Ahli</span>
            </div>
        </div>
    </section>

</div>
@endsection
