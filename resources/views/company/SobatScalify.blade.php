@extends('layouts.app')

@section('meta_tags')
<title>Jasa Pembuatan Website Bisnis UMKM & Skripsi IT Terpercaya - Sobat Scalify</title>
<meta name="title" content="Jasa Pembuatan Website Bisnis UMKM & Skripsi IT Terpercaya - Sobat Scalify" />
<meta name="description" content="Sobat Scalify melayani jasa pembuatan website profesional untuk UMKM dan mahasiswa IT. Spesialis sistem cerdas SCM, CRM, Forecasting, SPK, dan Data Science untuk Tugas Akhir/Skripsi." />
<meta name="keywords" content="jasa pembuatan website, jasa website umkm, jasa pembuatan skripsi informatika, website metode skripsi, implementasi algoritma skripsi, SPK, SCM, CRM, Forecasting, Data Science, Sobat Scalify" />
<meta name="author" content="Sobat Scalify" />
<meta name="robots" content="index, follow" />
<meta property="og:title" content="Jasa Pembuatan Website Bisnis UMKM & Skripsi IT Terpercaya - Sobat Scalify" />
<meta property="og:description" content="Sobat Scalify melayani jasa pembuatan website profesional untuk UMKM dan mahasiswa IT. Spesialis sistem cerdas SCM, CRM, Forecasting, SPK, dan Data Science." />
<meta property="og:type" content="website" />
<meta property="og:url" content="{{ url()->current() }}" />
@endsection

@section('content')
<div class="bg-white text-gray-800 min-h-screen font-sans">
    @php
    $refCode = request()->cookie('affiliate_ref') ?? request('ref');
    $waTextRef = $refCode ? "%0A%0A[Referral: " . urlencode($refCode) . "]" : "";
    @endphp

    {{-- Top Announcement Banner for Partner Program --}}
    <div class="relative bg-gradient-to-r from-[#0A0E2A] to-[#191970] overflow-hidden shadow-lg mt-16 lg:mt-20">
        {{-- Glassmorphism elements --}}
        <div class="absolute top-0 right-0 -mt-8 -mr-8 w-48 h-48 bg-blue-500 rounded-full mix-blend-screen filter blur-[50px] opacity-30"></div>
        <div class="absolute bottom-0 left-0 -mb-8 -ml-8 w-32 h-32 bg-indigo-500 rounded-full mix-blend-screen filter blur-[40px] opacity-20"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 py-4 sm:py-5">
            <div class="flex flex-col sm:flex-row items-center justify-between gap-4 text-center sm:text-left">
                <div class="flex items-center gap-4">
                    <div class="hidden sm:flex w-12 h-12 bg-white/10 backdrop-blur-md rounded-full items-center justify-center border border-white/20 shadow-inner">
                        <i class="fa-solid fa-gem text-yellow-400 text-xl drop-shadow-md"></i>
                    </div>
                    <div>
                        <h3 class="text-white font-bold text-lg tracking-wide drop-shadow-md">Sobat Scalify Partner Program</h3>
                        <p class="text-blue-200 text-sm font-medium">Rekomendasikan kami & dapatkan komisi eksklusif setiap bulannya!</p>
                    </div>
                </div>

                @if(Auth::guard('affiliate')->check())
                <a href="{{ route('affiliate.dashboard') }}" class="inline-flex items-center gap-2 px-6 py-2.5 bg-white/10 hover:bg-white/20 text-white font-bold rounded-xl border border-white/30 backdrop-blur-md transition-all shadow-[0_0_15px_rgba(255,255,255,0.1)] hover:shadow-[0_0_20px_rgba(255,255,255,0.3)] whitespace-nowrap transform hover:-translate-y-0.5">
                    Dashboard Partner <i class="fa-solid fa-arrow-right text-sm"></i>
                </a>
                @else
                <div class="flex flex-wrap items-center gap-2 sm:gap-3 justify-center sm:justify-start">
                    <a href="{{ route('partner.program') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-transparent hover:bg-white/5 text-blue-100 hover:text-white font-bold rounded-xl border border-transparent transition-all whitespace-nowrap">
                        Pelajari Detail
                    </a>
                    <a href="{{ route('affiliate.register') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-white/10 hover:bg-white/20 text-white font-bold rounded-xl border border-white/30 backdrop-blur-md transition-all shadow-[0_0_15px_rgba(255,255,255,0.1)] hover:shadow-[0_0_20px_rgba(255,255,255,0.3)] whitespace-nowrap transform hover:-translate-y-0.5">
                        Daftar Gratis <i class="fa-solid fa-arrow-right text-sm"></i>
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Hero Section --}}
    <section class="relative pt-24 pb-16 lg:pt-32 lg:pb-24 overflow-hidden bg-brand-dark" style="background-color: #0A0E2A;">
        {{-- Background Accents --}}
        <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/stardust.png')] opacity-20 pointer-events-none"></div>
        <div class="absolute top-0 right-0 w-[800px] h-[800px] bg-blue-600 rounded-full mix-blend-screen filter blur-[150px] opacity-20 pointer-events-none translate-x-1/3 -translate-y-1/3"></div>
        <div class="absolute bottom-0 left-0 w-[600px] h-[600px] bg-indigo-600 rounded-full mix-blend-screen filter blur-[120px] opacity-20 pointer-events-none -translate-x-1/3 translate-y-1/3"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div class="text-center lg:text-left">
                    <div class="inline-flex items-center px-4 py-2 rounded-full bg-blue-500/10 border border-blue-400/30 text-blue-300 text-sm font-semibold mb-6 tracking-wide uppercase shadow-[0_0_15px_rgba(59,130,246,0.15)] backdrop-blur-md">
                        <i class="fa-solid fa-graduation-cap mr-2"></i> Partner Tugas Akhir & Bisnis
                    </div>
                    <h1 class="text-4xl sm:text-5xl lg:text-5xl lg:leading-tight font-bold font-display leading-tight mb-6 text-white drop-shadow-lg">
                        Jasa Pembuatan <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-indigo-300 relative inline-block">Website UMKM</span> & Metode Skripsi IT
                    </h1>
                    <p class="text-lg text-blue-100/80 mb-8 leading-relaxed max-w-2xl mx-auto lg:mx-0">
                        Solusi terbaik untuk digitalisasi bisnis UMKM Anda dan penyelesaian Tugas Akhir/Skripsi Informatika. Kami ahlinya implementasi algoritma sistem cerdas (SPK, SCM, Forecasting, CRM).
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                        <a href="https://wa.me/6285221694067?text=Halo%20Sobat%20Scalify,%20saya%20ingin%20konsultasi%20mengenai%20pembuatan%20website/skripsi.{{ $waTextRef }}" target="_blank" class="wa-btn-track px-8 py-4 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-bold rounded-xl shadow-[0_0_20px_rgba(59,130,246,0.4)] hover:shadow-[0_0_30px_rgba(59,130,246,0.6)] transition-all duration-300 transform hover:-translate-y-1 flex items-center justify-center gap-2 border border-blue-500/50">
                            <i class="fa-brands fa-whatsapp text-xl"></i> Konsultasi Sekarang
                        </a>
                        <a href="#layanan" class="px-8 py-4 bg-white/5 border border-white/20 text-white font-semibold rounded-xl hover:bg-white/10 backdrop-blur-md transition-all duration-300 flex items-center justify-center gap-2">
                            Lihat Layanan <i class="fa-solid fa-arrow-down"></i>
                        </a>
                    </div>
                </div>
                <div class="relative hidden lg:block">
                    <!-- Glassmorphism frame around the image -->
                    <div class="relative rounded-3xl p-2 bg-white/5 border border-white/10 backdrop-blur-sm shadow-[0_0_40px_rgba(25,25,112,0.5)] transform hover:scale-[1.02] transition-transform duration-500">
                        <div class="absolute inset-0 bg-gradient-to-tr from-blue-500/10 to-transparent rounded-3xl z-10 pointer-events-none"></div>
                        <img src="{{ asset('images/hero_anime.png') }}" alt="Sobat Scalify Workspace Anime" class="relative rounded-2xl object-cover w-full h-[500px]" fetchpriority="high">
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Layanan & Metode Section --}}
    <section id="layanan" class="py-24 bg-slate-50 relative overflow-hidden">
        {{-- Decorative Background --}}
        <div class="absolute top-0 left-0 w-full h-px bg-gradient-to-r from-transparent via-blue-200 to-transparent"></div>
        <div class="absolute -top-24 -left-24 w-96 h-96 bg-blue-100 rounded-full mix-blend-multiply filter blur-3xl opacity-50"></div>
        <div class="absolute -bottom-24 -right-24 w-96 h-96 bg-indigo-100 rounded-full mix-blend-multiply filter blur-3xl opacity-50"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center max-w-3xl mx-auto mb-20">
                <div class="inline-flex items-center px-4 py-2 rounded-full bg-indigo-50 text-indigo-600 text-sm font-bold mb-4 tracking-wider uppercase border border-indigo-100">
                    <i class="fa-solid fa-bolt text-yellow-500 mr-2"></i> Keahlian Kami
                </div>
                <h2 class="text-3xl md:text-5xl font-bold mb-6 font-display" style="color: #191970;">Spesialisasi & <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-indigo-500">Metode Terapan</span></h2>
                <p class="text-slate-500 text-lg md:text-xl">Ubah ide kompleks menjadi solusi cerdas. Kami ahli dalam menerapkan berbagai algoritma canggih ke dalam sistem modern.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">

                {{-- Card 1: SCM --}}
                <div class="group bg-white rounded-3xl p-8 shadow-sm hover:shadow-2xl transition-all duration-500 border border-slate-100 relative overflow-hidden transform hover:-translate-y-2">
                    <i class="fa-solid fa-boxes-packing absolute -bottom-6 -right-6 text-9xl text-slate-50 group-hover:text-blue-50 transition-colors duration-500 transform -rotate-12"></i>
                    <div class="relative z-10">
                        <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center mb-6 shadow-lg shadow-blue-200">
                            <i class="fa-solid fa-truck-fast text-2xl text-white"></i>
                        </div>
                        <h3 class="text-2xl font-bold mb-3 text-slate-800">Supply Chain (SCM)</h3>
                        <p class="text-slate-500 font-medium leading-relaxed text-sm">Optimasi jalur distribusi, inventory control cerdas, & tracking logistik terpadu untuk efisiensi bisnis.</p>
                    </div>
                </div>

                {{-- Card 2: CRM --}}
                <div class="group bg-white rounded-3xl p-8 shadow-sm hover:shadow-2xl transition-all duration-500 border border-slate-100 relative overflow-hidden transform hover:-translate-y-2">
                    <i class="fa-solid fa-users-rays absolute -bottom-6 -right-6 text-9xl text-slate-50 group-hover:text-purple-50 transition-colors duration-500 transform -rotate-12"></i>
                    <div class="relative z-10">
                        <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-purple-500 to-pink-500 flex items-center justify-center mb-6 shadow-lg shadow-purple-200">
                            <i class="fa-solid fa-users-viewfinder text-2xl text-white"></i>
                        </div>
                        <h3 class="text-2xl font-bold mb-3 text-slate-800">Customer Rel. (CRM)</h3>
                        <p class="text-slate-500 font-medium leading-relaxed text-sm">Analisis cerdas perilaku pelanggan, segmentasi presisi, & sistem retensi untuk mendongkrak penjualan.</p>
                    </div>
                </div>

                {{-- Card 3: Forecasting --}}
                <div class="group bg-white rounded-3xl p-8 shadow-sm hover:shadow-2xl transition-all duration-500 border border-slate-100 relative overflow-hidden transform hover:-translate-y-2">
                    <i class="fa-solid fa-arrow-trend-up absolute -bottom-6 -right-6 text-9xl text-slate-50 group-hover:text-emerald-50 transition-colors duration-500 transform -rotate-12"></i>
                    <div class="relative z-10">
                        <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-emerald-400 to-teal-500 flex items-center justify-center mb-6 shadow-lg shadow-emerald-200">
                            <i class="fa-solid fa-chart-line text-2xl text-white"></i>
                        </div>
                        <h3 class="text-2xl font-bold mb-3 text-slate-800">Peramalan Akurat</h3>
                        <p class="text-slate-500 font-medium leading-relaxed text-sm">Terapkan Double Exponential Smoothing, ARIMA, atau WMA untuk prediksi cuaca, saham, atau stok barang.</p>
                    </div>
                </div>

                {{-- Card 4: SPK --}}
                <div class="group bg-white rounded-3xl p-8 shadow-sm hover:shadow-2xl transition-all duration-500 border border-slate-100 relative overflow-hidden transform hover:-translate-y-2">
                    <i class="fa-solid fa-scale-unbalanced absolute -bottom-6 -right-6 text-9xl text-slate-50 group-hover:text-yellow-50 transition-colors duration-500 transform -rotate-12"></i>
                    <div class="relative z-10">
                        <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-yellow-400 to-orange-500 flex items-center justify-center mb-6 shadow-lg shadow-yellow-200">
                            <i class="fa-solid fa-scale-balanced text-2xl text-white"></i>
                        </div>
                        <h3 class="text-2xl font-bold mb-3 text-slate-800">Pendukung Keputusan</h3>
                        <p class="text-slate-500 font-medium leading-relaxed text-sm">Pemilihan terbaik dengan algoritma komputasi presisi: SAW, AHP, TOPSIS, WP, hingga Profile Matching.</p>
                    </div>
                </div>

                {{-- Card 5: Data Science --}}
                <div class="group bg-white rounded-3xl p-8 shadow-sm hover:shadow-2xl transition-all duration-500 border border-slate-100 relative overflow-hidden transform hover:-translate-y-2">
                    <i class="fa-solid fa-robot absolute -bottom-6 -right-6 text-9xl text-slate-50 group-hover:text-rose-50 transition-colors duration-500 transform -rotate-12"></i>
                    <div class="relative z-10">
                        <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-rose-500 to-red-600 flex items-center justify-center mb-6 shadow-lg shadow-rose-200">
                            <i class="fa-solid fa-network-wired text-2xl text-white"></i>
                        </div>
                        <h3 class="text-2xl font-bold mb-3 text-slate-800">Data Science & AI</h3>
                        <p class="text-slate-500 font-medium leading-relaxed text-sm">Cerdaskan sistem dengan klasifikasi C4.5, Naive Bayes, K-Means Clustering, dan AI terintegrasi.</p>
                    </div>
                </div>

                {{-- Card 6: Custom Web --}}
                <div class="group bg-white rounded-3xl p-8 shadow-sm hover:shadow-2xl transition-all duration-500 border border-slate-100 relative overflow-hidden transform hover:-translate-y-2 lg:col-span-1 md:col-span-2">
                    <i class="fa-solid fa-code absolute -bottom-6 -right-6 text-9xl text-slate-50 group-hover:text-cyan-50 transition-colors duration-500 transform -rotate-12"></i>
                    <div class="relative z-10">
                        <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-cyan-400 to-blue-500 flex items-center justify-center mb-6 shadow-lg shadow-cyan-200">
                            <i class="fa-solid fa-laptop-code text-2xl text-white"></i>
                        </div>
                        <h3 class="text-2xl font-bold mb-3 text-slate-800">Custom Web Apps</h3>
                        <p class="text-slate-500 font-medium leading-relaxed text-sm">Sistem Informasi, Portal Akademik, Company Profile, hingga ERP kustom. Semua dibangun eksklusif untuk Anda.</p>
                    </div>
                </div>

            </div>
        </div>
    </section>



    {{-- Workflow Section --}}
    <section class="py-24 relative overflow-hidden bg-slate-50">
        {{-- Soft Gradient Background & Blobs for Glass Effect --}}
        <div class="absolute inset-0 bg-gradient-to-br from-indigo-50/50 via-white to-blue-50/50 pointer-events-none"></div>
        <div class="absolute top-20 left-20 w-72 h-72 bg-blue-200/50 rounded-full mix-blend-multiply filter blur-[60px] animate-blob pointer-events-none"></div>
        <div class="absolute bottom-20 right-20 w-72 h-72 bg-purple-200/50 rounded-full mix-blend-multiply filter blur-[60px] animate-blob animation-delay-2000 pointer-events-none"></div>
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-96 h-96 bg-indigo-200/40 rounded-full mix-blend-multiply filter blur-[80px] animate-blob animation-delay-4000 pointer-events-none"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center mb-20">
                <div class="inline-flex items-center px-4 py-2 rounded-full bg-white/60 backdrop-blur-md border border-white text-indigo-600 text-sm font-bold mb-4 tracking-wider uppercase shadow-sm">
                    <i class="fa-solid fa-code-branch text-blue-500 mr-2"></i> Langkah Mudah
                </div>
                <h2 class="text-3xl md:text-5xl font-bold mb-4 font-display" style="color: #191970;">Cara <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-indigo-500">Kerja Kami</span></h2>
                <p class="text-slate-500 text-lg md:text-xl max-w-2xl mx-auto">Proses transparan, terstruktur, dan terukur. Kami pastikan Anda memantau setiap progres proyek dengan mudah.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 relative">
                {{-- Glowing Connecting line (desktop only) --}}
                <div class="hidden md:block absolute top-[60px] left-[10%] w-[80%] h-[3px] bg-gradient-to-r from-blue-200 via-indigo-300 to-purple-200 rounded-full z-0 opacity-60"></div>

                {{-- Step 1 --}}
                <div class="relative z-10 group">
                    <div class="w-24 h-24 mx-auto bg-white/60 backdrop-blur-xl border border-white rounded-3xl flex items-center justify-center text-3xl font-bold mb-8 shadow-[0_8px_30px_rgb(0,0,0,0.04)] group-hover:-translate-y-2 transition-all duration-300 relative overflow-hidden text-blue-600">
                        <div class="absolute inset-0 bg-gradient-to-br from-blue-100 to-transparent opacity-50"></div>
                        <span class="relative z-10">1</span>
                    </div>
                    <div class="bg-white/40 backdrop-blur-lg border border-white/60 p-6 rounded-3xl shadow-sm group-hover:shadow-xl transition-all duration-300 text-center relative overflow-hidden">
                        <div class="absolute inset-0 bg-gradient-to-b from-white/40 to-transparent"></div>
                        <h4 class="font-bold text-xl mb-3 relative z-10 text-slate-800">Konsultasi</h4>
                        <p class="text-slate-500 text-sm leading-relaxed relative z-10">Diskusikan judul, kebutuhan fitur, dan algoritma yang ingin Anda implementasikan tanpa batasan.</p>
                    </div>
                </div>

                {{-- Step 2 --}}
                <div class="relative z-10 group">
                    <div class="w-24 h-24 mx-auto bg-white/60 backdrop-blur-xl border border-white rounded-3xl flex items-center justify-center text-3xl font-bold mb-8 shadow-[0_8px_30px_rgb(0,0,0,0.04)] group-hover:-translate-y-2 transition-all duration-300 relative overflow-hidden text-indigo-600">
                        <div class="absolute inset-0 bg-gradient-to-br from-indigo-100 to-transparent opacity-50"></div>
                        <span class="relative z-10">2</span>
                    </div>
                    <div class="bg-white/40 backdrop-blur-lg border border-white/60 p-6 rounded-3xl shadow-sm group-hover:shadow-xl transition-all duration-300 text-center relative overflow-hidden">
                        <div class="absolute inset-0 bg-gradient-to-b from-white/40 to-transparent"></div>
                        <h4 class="font-bold text-xl mb-3 relative z-10 text-slate-800">Kesepakatan</h4>
                        <p class="text-slate-500 text-sm leading-relaxed relative z-10">Penentuan estimasi waktu pengerjaan dan rincian biaya yang 100% transparan di awal.</p>
                    </div>
                </div>

                {{-- Step 3 --}}
                <div class="relative z-10 group">
                    <div class="w-24 h-24 mx-auto bg-white/60 backdrop-blur-xl border border-white rounded-3xl flex items-center justify-center text-3xl font-bold mb-8 shadow-[0_8px_30px_rgb(0,0,0,0.04)] group-hover:-translate-y-2 transition-all duration-300 relative overflow-hidden text-purple-600">
                        <div class="absolute inset-0 bg-gradient-to-br from-purple-100 to-transparent opacity-50"></div>
                        <span class="relative z-10">3</span>
                    </div>
                    <div class="bg-white/40 backdrop-blur-lg border border-white/60 p-6 rounded-3xl shadow-sm group-hover:shadow-xl transition-all duration-300 text-center relative overflow-hidden">
                        <div class="absolute inset-0 bg-gradient-to-b from-white/40 to-transparent"></div>
                        <h4 class="font-bold text-xl mb-3 relative z-10 text-slate-800">Pengerjaan</h4>
                        <p class="text-slate-500 text-sm leading-relaxed relative z-10">Proses coding intensif. Kami mengirimkan update progres berkala agar Anda selalu memegang kendali.</p>
                    </div>
                </div>

                {{-- Step 4 --}}
                <div class="relative z-10 group">
                    <div class="w-24 h-24 mx-auto bg-white/60 backdrop-blur-xl border border-white rounded-3xl flex items-center justify-center text-3xl font-bold mb-8 shadow-[0_8px_30px_rgb(0,0,0,0.04)] group-hover:-translate-y-2 transition-all duration-300 relative overflow-hidden text-emerald-600">
                        <div class="absolute inset-0 bg-gradient-to-br from-emerald-100 to-transparent opacity-50"></div>
                        <span class="relative z-10">4</span>
                    </div>
                    <div class="bg-white/40 backdrop-blur-lg border border-white/60 p-6 rounded-3xl shadow-sm group-hover:shadow-xl transition-all duration-300 text-center relative overflow-hidden">
                        <div class="absolute inset-0 bg-gradient-to-b from-white/40 to-transparent"></div>
                        <h4 class="font-bold text-xl mb-3 relative z-10 text-slate-800">Revisi & Rilis</h4>
                        <p class="text-slate-500 text-sm leading-relaxed relative z-10">Testing bersama, serah terima source code, panduan instalasi, dan jaminan support purna jual.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Documentation Gallery Section --}}
    <section x-data="{ lightboxOpen: false, lightboxImage: '' }" class="py-20 bg-gray-50 border-t border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Header --}}
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold mb-4 font-display" style="color: #191970;">Galeri <span class="text-brand-accent">Dokumentasi</span></h2>
                <p class="text-gray-600 text-lg">Momen dan hasil karya bersama Sobat Scalify</p>
            </div>

            @if($documentation->isEmpty())
            <div class="flex flex-col items-center justify-center py-20 rounded-2xl text-center bg-white border border-gray-200 shadow-sm">
                <i class="fa-solid fa-camera-retro text-gray-300 text-5xl mb-4"></i>
                <p class="text-gray-500 font-medium text-lg">Belum ada dokumentasi untuk saat ini.</p>
            </div>
            @else
            {{-- Grid Masonry --}}
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4" style="grid-auto-rows: 200px; grid-auto-flow: dense;">
                @php
                // Pola asimetris
                $spans = ['row-span-2', 'row-span-1', 'row-span-3', 'row-span-1', 'row-span-2', 'row-span-2', 'row-span-1'];
                @endphp

                @foreach($documentation as $doc)
                <div @click="lightboxOpen = true; lightboxImage = '{{ $doc->images ? asset('images/' . $doc->images) : '' }}'" class="relative group overflow-hidden rounded-xl cursor-pointer shadow-sm hover:shadow-xl transition-all duration-300 {{ $spans[$loop->index % count($spans)] }}">
                    @if($doc->images)
                    <img src="{{ asset('images/' . $doc->images) }}" alt="{{ $doc->title }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                    @else
                    <div class="w-full h-full bg-gray-200 flex items-center justify-center">
                        <i class="fa-solid fa-image text-gray-400 text-4xl"></i>
                    </div>
                    @endif

                    {{-- Gradient Overlay --}}
                    <div class="absolute inset-0 bg-gradient-to-t from-brand-navy via-brand-navy/30 to-transparent opacity-0 group-hover:opacity-100 transition-all duration-300"></div>

                    {{-- Text Content --}}
                    <div class="absolute bottom-0 left-0 right-0 p-5 translate-y-4 opacity-0 group-hover:translate-y-0 group-hover:opacity-100 transition-all duration-300">
                        <p class="text-white font-bold text-lg leading-tight shadow-sm">{{ $doc->title }}</p>
                        <div class="w-8 h-1 bg-white mt-2 rounded-full"></div>
                    </div>
                </div>
                @endforeach
            </div>
            @endif
        </div>

        {{-- Lightbox Modal --}}
        <div x-show="lightboxOpen" style="display: none;" class="fixed inset-0 z-[100] flex items-center justify-center bg-brand-navy/95 backdrop-blur-sm" x-transition.opacity.duration.300ms @keydown.escape.window="lightboxOpen = false">
            <button @click="lightboxOpen = false" aria-label="Tutup detail foto" class="absolute top-6 right-6 sm:top-8 sm:right-8 text-white/50 hover:text-white transition-colors z-50 focus:outline-none bg-white/10 w-12 h-12 rounded-full flex items-center justify-center hover:bg-white/20">
                <i class="fa-solid fa-xmark text-2xl"></i>
            </button>
            <div @click.away="lightboxOpen = false" class="relative max-w-5xl max-h-[90vh] w-full p-4 flex justify-center items-center">
                <img :src="lightboxImage" x-show="lightboxImage" class="max-w-full max-h-[85vh] object-contain rounded-xl shadow-2xl border border-white/10" x-transition.scale.95.duration.300ms>
            </div>
        </div>
    </section>

    {{-- CTA Section --}}
    <section class="py-24 relative overflow-hidden bg-brand-dark" style="background-color: #0A0E2A;">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 relative z-10 text-center">
            <h2 class="text-3xl md:text-5xl font-bold text-white mb-6 font-display">Siap Mengeksekusi Ide Anda?</h2>
            <p class="text-white/80 text-lg mb-10 max-w-2xl mx-auto">Jangan biarkan pengerjaan skripsi atau project IT Anda berhenti di tengah jalan. Konsultasikan sekarang, kami siap memberikan solusi cerdas dengan harga yang sangat bersahabat bagi mahasiswa & pelaku usaha.</p>

            <a href="https://wa.me/6285221694067?text=Halo%20Sobat%20Scalify,%20saya%20tertarik%20dengan%20jasa%20pembuatan%20website/skripsi.%20Bisa%20dibantu?{{ $waTextRef }}" target="_blank" id="wa-btn-footer" class="wa-btn-track inline-flex items-center gap-3 px-8 py-4 bg-btn-gradient text-white shadow-glow-sm hover:shadow-glow-blue font-bold text-lg rounded-full transition-all duration-300 transform hover:scale-105">
                <i class="fa-brands fa-whatsapp text-2xl text-green-500"></i> Hubungi Kami Sekarang
            </a>

            <div class="mt-8 flex items-center justify-center gap-6 text-white/60 text-sm">
                <span><i class="fa-solid fa-check-circle text-green-400 mr-2"></i>Konsultasi Gratis</span>
                <span><i class="fa-solid fa-check-circle text-green-400 mr-2"></i>Tepat Waktu</span>
                <span><i class="fa-solid fa-check-circle text-green-400 mr-2"></i>Terpercaya</span>
            </div>
        </div>
    </section>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const waButtons = document.querySelectorAll('.wa-btn-track');

        waButtons.forEach(btn => {
            btn.addEventListener('click', function(e) {
                // Track the click via AJAX
                fetch('/api/track-wa-click', {
                    method: 'POST'
                    , headers: {
                        'Content-Type': 'application/json'
                        , 'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                    , body: JSON.stringify({
                        // If we want to read ?ref from URL just in case cookie isn't set yet
                        ref: new URLSearchParams(window.location.search).get('ref')
                    })
                }).catch(err => console.error('Tracking error:', err));
                // Let the default behavior (opening WA in new tab) proceed
            });
        });
    });

</script>
@endsection
