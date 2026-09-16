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
<div class="bg-brand-dark text-white min-h-screen font-sans relative overflow-hidden">
    @php
    $refCode = request()->cookie('affiliate_ref') ?? request('ref');
    $waTextRef = $refCode ? "%0A%0A[Referral: " . urlencode($refCode) . "]" : "";
    @endphp

    {{-- Top Ambient Glow --}}
    <div class="absolute top-0 left-1/2 -translate-x-1/2 w-full max-w-7xl h-[400px] bg-gradient-to-b from-brand-blue/15 via-indigo-600/10 to-transparent blur-3xl pointer-events-none"></div>

    {{-- Top Announcement Banner for Partner Program --}}
    <div class="relative bg-brand-navy/80 backdrop-blur-xl border-b border-white/10 overflow-hidden shadow-lg z-20">
        <div class="absolute top-0 right-0 w-64 h-32 bg-blue-500/15 rounded-full filter blur-3xl pointer-events-none"></div>
        <div class="absolute bottom-0 left-0 w-64 h-32 bg-indigo-500/15 rounded-full filter blur-3xl pointer-events-none"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 py-3.5 sm:py-4">
            <div class="flex flex-col sm:flex-row items-center justify-between gap-4 text-center sm:text-left">
                <div class="flex items-center gap-3.5">
                    <div class="w-10 h-10 rounded-xl bg-amber-500/15 border border-amber-500/25 flex items-center justify-center shrink-0 shadow-inner">
                        <i class="fa-solid fa-gem text-amber-400 text-base"></i>
                    </div>
                    <div>
                        <div class="flex items-center justify-center sm:justify-start gap-2">
                            <h3 class="text-white font-bold text-sm sm:text-base tracking-tight">Sobat Scalify Partner Program</h3>
                            <span class="px-2 py-0.5 bg-amber-500/20 text-amber-300 text-[10px] font-bold rounded-full border border-amber-500/30">Cuan</span>
                        </div>
                        <p class="text-white/60 text-xs font-normal">Rekomendasikan layanan kami & raih komisi eksklusif setiap bulannya!</p>
                    </div>
                </div>

                @if(Auth::guard('affiliate')->check())
                <a href="{{ route('affiliate.dashboard') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-white/10 hover:bg-white/15 text-white font-semibold rounded-xl border border-white/20 backdrop-blur-md transition-all shadow-sm whitespace-nowrap active:scale-95 text-xs sm:text-sm">
                    <span>Dashboard Partner</span>
                    <i class="fa-solid fa-arrow-right text-xs"></i>
                </a>
                @else
                <div class="flex flex-wrap items-center gap-2 sm:gap-3 justify-center sm:justify-start">
                    <a href="{{ route('partner.program') }}" class="inline-flex items-center gap-1.5 px-4 py-2 text-white/70 hover:text-white font-medium text-xs sm:text-sm transition-all whitespace-nowrap">
                        Pelajari Detail
                    </a>
                    <a href="{{ route('affiliate.register') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-btn-gradient text-white font-bold rounded-xl shadow-glow-sm hover:shadow-glow-blue transition-all whitespace-nowrap active:scale-95 text-xs sm:text-sm">
                        <span>Daftar Gratis</span>
                        <i class="fa-solid fa-arrow-right text-xs"></i>
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Hero Section --}}
    <section class="relative pt-16 pb-16 lg:pt-24 lg:pb-24 overflow-hidden border-b border-white/5">
        <div class="absolute inset-0 bg-hero-gradient pointer-events-none"></div>
        <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-brand-blue/15 rounded-full blur-[140px] pointer-events-none"></div>

        {{-- Subtle Grid Pattern --}}
        <div class="absolute inset-0 opacity-[0.035] pointer-events-none" style="background-image: radial-gradient(#ffffff 1px, transparent 1px); background-size: 28px 28px;"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-16 items-center">
                <div class="text-left">
                    {{-- Eyebrow --}}
                    <div class="mb-4">
                        <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-cyan-500/10 border border-cyan-500/20 text-cyan-400 font-bold text-[11px] sm:text-xs tracking-[0.15em] uppercase shadow-sm shadow-cyan-500/10">
                            <span class="w-1.5 h-1.5 rounded-full bg-cyan-400 animate-pulse"></span>
                            <span>Partner Tugas Akhir & Bisnis UMKM</span>
                        </div>
                    </div>

                    {{-- Main Headline --}}
                    <h1 class="font-sans font-black text-3xl sm:text-5xl lg:text-[46px] text-white leading-[1.18] tracking-[-0.03em] mb-4">
                        Jasa Pembuatan <span class="bg-gradient-to-r from-blue-400 via-cyan-300 to-indigo-400 bg-clip-text text-transparent">Website UMKM</span> & Metode Skripsi IT
                    </h1>

                    {{-- Description --}}
                    <p class="text-white/65 text-xs sm:text-sm md:text-[15px] leading-relaxed max-w-xl mb-8 font-normal">
                        Solusi terpercaya untuk digitalisasi bisnis UMKM Anda dan penyelesaian Tugas Akhir/Skripsi Informatika. Kami ahlinya implementasi algoritma sistem cerdas (SPK, SCM, Forecasting, CRM).
                    </p>

                    {{-- CTA Buttons --}}
                    <div class="flex flex-wrap items-center gap-3.5">
                        <a href="https://wa.me/6285221694067?text=Halo%20Sobat%20Scalify,%20saya%20ingin%20konsultasi%20mengenai%20pembuatan%20website/skripsi.{{ $waTextRef }}" target="_blank" class="wa-btn-track inline-flex items-center gap-2.5 bg-btn-gradient text-white text-xs sm:text-sm font-bold px-7 py-3.5 rounded-full shadow-glow-blue hover:scale-105 transition-all">
                            <i class="fa-brands fa-whatsapp text-base text-emerald-300"></i>
                            <span>Konsultasi Sekarang</span>
                            <span class="w-5 h-5 bg-white/20 rounded-full flex items-center justify-center text-[10px]">→</span>
                        </a>
                        <a href="#layanan" class="inline-flex items-center gap-2 bg-white/5 border border-white/15 hover:bg-white/10 text-white/90 hover:text-white text-xs sm:text-sm font-semibold px-6 py-3.5 rounded-full transition-all">
                            <i class="fa-solid fa-shapes text-cyan-400 text-xs"></i>
                            <span>Lihat Layanan</span>
                        </a>
                    </div>
                </div>

                {{-- Hero Visual Frame --}}
                <div class="relative hidden lg:block">
                    <div class="relative rounded-3xl p-2 bg-brand-navy/60 border border-white/10 backdrop-blur-xl shadow-2xl hover:border-brand-accent/40 transition-all duration-500">
                        <div class="absolute inset-0 bg-gradient-to-tr from-blue-500/15 to-transparent rounded-3xl pointer-events-none"></div>
                        <img src="{{ asset('images/hero_anime.png') }}" alt="Sobat Scalify Workspace Anime" class="relative rounded-2xl object-cover w-full h-[460px]" fetchpriority="high">
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Layanan & Metode Section --}}
    <section id="layanan" class="py-20 sm:py-24 px-4 sm:px-6 lg:px-8 bg-[#090d29] relative z-20 border-b border-white/5">
        <div class="max-w-7xl mx-auto">

            {{-- Header --}}
            <div class="text-left max-w-3xl mb-14">
                <div class="text-cyan-400 font-extrabold text-[11px] sm:text-xs tracking-[0.2em] uppercase mb-1.5 flex items-center gap-1.5">
                    <span class="w-1.5 h-1.5 rounded-full bg-cyan-400"></span>
                    KEAHLIAN & SPESIALISASI
                </div>
                <h2 class="font-sans font-black text-2xl sm:text-3xl lg:text-4xl text-white tracking-tight mb-3">
                    Spesialisasi & <span class="bg-gradient-to-r from-blue-400 via-cyan-300 to-indigo-400 bg-clip-text text-transparent">Metode Terapan</span>
                </h2>
                <p class="text-white/60 text-xs sm:text-sm md:text-[15px] leading-relaxed font-normal">
                    Ubah ide kompleks menjadi sistem nyata. Kami berpengalaman menerapkan berbagai algoritma cerdas ke dalam arsitektur website dan aplikasi web modern.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5 sm:gap-6">

                {{-- Card 1: SCM --}}
                <a href="{{ route('layanan.scm') }}" class="group bg-brand-navy/60 backdrop-blur-xl border border-white/10 hover:border-brand-accent/40 rounded-2xl p-6 sm:p-7 shadow-card hover:-translate-y-1 transition-all duration-300 block">
                    <div class="w-12 h-12 rounded-xl bg-blue-500/15 border border-blue-400/20 flex items-center justify-center mb-5 text-cyan-400 group-hover:scale-105 transition-transform">
                        <i class="fa-solid fa-truck-fast text-lg"></i>
                    </div>
                    <h3 class="text-lg font-bold text-white mb-2 group-hover:text-cyan-400 transition-colors">Supply Chain (SCM)</h3>
                    <p class="text-white/60 text-xs sm:text-[13px] leading-relaxed font-normal mb-4">
                        Optimasi jalur distribusi, inventory control cerdas (EOQ, ROP, Safety Stock), & tracking logistik terpadu untuk efisiensi operasional.
                    </p>
                    <div class="text-cyan-400 font-bold text-xs flex items-center gap-1.5 group-hover:gap-2.5 transition-all">
                        <span>Pelajari Metode & Rumus</span> <i class="fa-solid fa-arrow-right text-[10px]"></i>
                    </div>
                </a>

                {{-- Card 2: CRM --}}
                <div class="group bg-brand-navy/60 backdrop-blur-xl border border-white/10 hover:border-brand-accent/40 rounded-2xl p-6 sm:p-7 shadow-card hover:-translate-y-1 transition-all duration-300">
                    <div class="w-12 h-12 rounded-xl bg-purple-500/15 border border-purple-400/20 flex items-center justify-center mb-5 text-purple-400 group-hover:scale-105 transition-transform">
                        <i class="fa-solid fa-users-viewfinder text-lg"></i>
                    </div>
                    <h3 class="text-lg font-bold text-white mb-2 group-hover:text-purple-300 transition-colors">Customer Relationship (CRM)</h3>
                    <p class="text-white/60 text-xs sm:text-[13px] leading-relaxed font-normal">
                        Analisis perilaku pelanggan, segmentasi presisi (RFM Analysis), sistem loyalitas, & pipeline retensi untuk mendongkrak omset.
                    </p>
                </div>

                {{-- Card 3: Forecasting --}}
                <div class="group bg-brand-navy/60 backdrop-blur-xl border border-white/10 hover:border-brand-accent/40 rounded-2xl p-6 sm:p-7 shadow-card hover:-translate-y-1 transition-all duration-300">
                    <div class="w-12 h-12 rounded-xl bg-emerald-500/15 border border-emerald-400/20 flex items-center justify-center mb-5 text-emerald-400 group-hover:scale-105 transition-transform">
                        <i class="fa-solid fa-chart-line text-lg"></i>
                    </div>
                    <h3 class="text-lg font-bold text-white mb-2 group-hover:text-emerald-300 transition-colors">Peramalan Akurat (Forecasting)</h3>
                    <p class="text-white/60 text-xs sm:text-[13px] leading-relaxed font-normal">
                        Implementasi Double Exponential Smoothing, ARIMA, Single Moving Average, atau WMA untuk proyeksi penjualan, cuaca, dan stok barang.
                    </p>
                </div>

                {{-- Card 4: SPK --}}
                <div class="group bg-brand-navy/60 backdrop-blur-xl border border-white/10 hover:border-brand-accent/40 rounded-2xl p-6 sm:p-7 shadow-card hover:-translate-y-1 transition-all duration-300">
                    <div class="w-12 h-12 rounded-xl bg-amber-500/15 border border-amber-400/20 flex items-center justify-center mb-5 text-amber-400 group-hover:scale-105 transition-transform">
                        <i class="fa-solid fa-scale-balanced text-lg"></i>
                    </div>
                    <h3 class="text-lg font-bold text-white mb-2 group-hover:text-amber-300 transition-colors">Sistem Pendukung Keputusan (SPK)</h3>
                    <p class="text-white/60 text-xs sm:text-[13px] leading-relaxed font-normal">
                        Komputasi keputusan multi-kriteria presisi: SAW, AHP, TOPSIS, Weighted Product (WP), Promethee, hingga Profile Matching.
                    </p>
                </div>

                {{-- Card 5: Data Science & AI --}}
                <div class="group bg-brand-navy/60 backdrop-blur-xl border border-white/10 hover:border-brand-accent/40 rounded-2xl p-6 sm:p-7 shadow-card hover:-translate-y-1 transition-all duration-300">
                    <div class="w-12 h-12 rounded-xl bg-rose-500/15 border border-rose-400/20 flex items-center justify-center mb-5 text-rose-400 group-hover:scale-105 transition-transform">
                        <i class="fa-solid fa-brain text-lg"></i>
                    </div>
                    <h3 class="text-lg font-bold text-white mb-2 group-hover:text-rose-300 transition-colors">Data Science & AI</h3>
                    <p class="text-white/60 text-xs sm:text-[13px] leading-relaxed font-normal">
                        Klasifikasi C4.5 / Decision Tree, Naive Bayes, K-Means Clustering, NLP Sentiment Analysis, serta integrasi AI LLM terapan.
                    </p>
                </div>

                {{-- Card 6: Custom Web Apps --}}
                <div class="group bg-brand-navy/60 backdrop-blur-xl border border-white/10 hover:border-brand-accent/40 rounded-2xl p-6 sm:p-7 shadow-card hover:-translate-y-1 transition-all duration-300">
                    <div class="w-12 h-12 rounded-xl bg-cyan-500/15 border border-cyan-400/20 flex items-center justify-center mb-5 text-cyan-400 group-hover:scale-105 transition-transform">
                        <i class="fa-solid fa-laptop-code text-lg"></i>
                    </div>
                    <h3 class="text-lg font-bold text-white mb-2 group-hover:text-cyan-300 transition-colors">Custom Web Apps & UMKM</h3>
                    <p class="text-white/60 text-xs sm:text-[13px] leading-relaxed font-normal">
                        Sistem Informasi Manajemen, Portal Akademik, Company Profile, Kasir POS, hingga ERP kustom yang dibangun eksklusif dan teruji.
                    </p>
                </div>

            </div>
        </div>
    </section>

    {{-- Workflow Section --}}
    <section class="py-20 sm:py-24 relative overflow-hidden bg-brand-dark border-b border-white/5">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">

            {{-- Header --}}
            <div class="text-center max-w-2xl mx-auto mb-16">
                <div class="text-cyan-400 font-extrabold text-[11px] sm:text-xs tracking-[0.2em] uppercase mb-1.5 inline-flex items-center gap-1.5">
                    <span class="w-1.5 h-1.5 rounded-full bg-cyan-400"></span>
                    WORKFLOW & PROSES
                </div>
                <h2 class="font-sans font-black text-2xl sm:text-3xl lg:text-4xl text-white tracking-tight mb-3">
                    Cara <span class="bg-gradient-to-r from-blue-400 via-cyan-300 to-indigo-400 bg-clip-text text-transparent">Kerja Kami</span>
                </h2>
                <p class="text-white/60 text-xs sm:text-sm leading-relaxed font-normal">
                    Proses transparan, terstruktur, dan terukur. Anda dapat memantau setiap progres proyek dengan mudah dari awal hingga selesai.
                </p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 relative">

                {{-- Step 1 --}}
                <div class="bg-brand-navy/60 backdrop-blur-xl border border-white/10 rounded-2xl p-6 text-center hover:border-cyan-400/40 transition-all group flex flex-col items-center">
                    <div class="w-14 h-14 rounded-2xl bg-white/5 border border-white/15 flex items-center justify-center text-cyan-400 font-black text-xl mb-4 group-hover:scale-105 group-hover:border-cyan-400/50 transition-all shadow-sm">
                        01
                    </div>
                    <h4 class="font-bold text-base text-white mb-2">Konsultasi</h4>
                    <p class="text-white/60 text-xs sm:text-[13px] leading-relaxed font-normal">
                        Diskusikan judul, kebutuhan fitur, dan algoritma yang ingin Anda implementasikan tanpa batasan.
                    </p>
                </div>

                {{-- Step 2 --}}
                <div class="bg-brand-navy/60 backdrop-blur-xl border border-white/10 rounded-2xl p-6 text-center hover:border-cyan-400/40 transition-all group flex flex-col items-center">
                    <div class="w-14 h-14 rounded-2xl bg-white/5 border border-white/15 flex items-center justify-center text-cyan-400 font-black text-xl mb-4 group-hover:scale-105 group-hover:border-cyan-400/50 transition-all shadow-sm">
                        02
                    </div>
                    <h4 class="font-bold text-base text-white mb-2">Kesepakatan</h4>
                    <p class="text-white/60 text-xs sm:text-[13px] leading-relaxed font-normal">
                        Penentuan estimasi waktu pengerjaan dan rincian biaya yang 100% transparan tanpa biaya tersembunyi.
                    </p>
                </div>

                {{-- Step 3 --}}
                <div class="bg-brand-navy/60 backdrop-blur-xl border border-white/10 rounded-2xl p-6 text-center hover:border-cyan-400/40 transition-all group flex flex-col items-center">
                    <div class="w-14 h-14 rounded-2xl bg-white/5 border border-white/15 flex items-center justify-center text-cyan-400 font-black text-xl mb-4 group-hover:scale-105 group-hover:border-cyan-400/50 transition-all shadow-sm">
                        03
                    </div>
                    <h4 class="font-bold text-base text-white mb-2">Pengerjaan</h4>
                    <p class="text-white/60 text-xs sm:text-[13px] leading-relaxed font-normal">
                        Proses coding intensif. Kami memberikan update progres berkala agar Anda selalu memegang kendali.
                    </p>
                </div>

                {{-- Step 4 --}}
                <div class="bg-brand-navy/60 backdrop-blur-xl border border-white/10 rounded-2xl p-6 text-center hover:border-cyan-400/40 transition-all group flex flex-col items-center">
                    <div class="w-14 h-14 rounded-2xl bg-white/5 border border-white/15 flex items-center justify-center text-emerald-400 font-black text-xl mb-4 group-hover:scale-105 group-hover:border-emerald-400/50 transition-all shadow-sm">
                        04
                    </div>
                    <h4 class="font-bold text-base text-white mb-2">Revisi & Rilis</h4>
                    <p class="text-white/60 text-xs sm:text-[13px] leading-relaxed font-normal">
                        Testing bersama, serah terima source code lengkap, panduan instalasi, dan jaminan support purna jual.
                    </p>
                </div>

            </div>
        </div>
    </section>

    {{-- Documentation Gallery Section --}}
    <section x-data="{ lightboxOpen: false, lightboxImage: '' }" class="py-20 sm:py-24 px-4 sm:px-6 lg:px-8 bg-[#090d29] border-b border-white/5 relative z-20">
        <div class="max-w-7xl mx-auto">

            {{-- Header --}}
            <div class="text-center max-w-2xl mx-auto mb-14">
                <div class="text-cyan-400 font-extrabold text-[11px] sm:text-xs tracking-[0.2em] uppercase mb-1.5 inline-flex items-center gap-1.5">
                    <span class="w-1.5 h-1.5 rounded-full bg-cyan-400"></span>
                    GALERI AKTIVITAS
                </div>
                <h2 class="font-sans font-black text-2xl sm:text-3xl lg:text-4xl text-white tracking-tight mb-3">
                    Dokumentasi & <span class="bg-gradient-to-r from-blue-400 via-cyan-300 to-indigo-400 bg-clip-text text-transparent">Aktivitas Nyata</span>
                </h2>
                <p class="text-white/60 text-xs sm:text-sm font-normal">
                    Momen bimbingan, pengerjaan proyek, dan hasil karya bersama Sobat Scalify.
                </p>
            </div>

            @if($documentation->isEmpty())
            <div class="flex flex-col items-center justify-center py-16 rounded-2xl text-center bg-white/5 border border-white/10">
                <i class="fa-solid fa-camera-retro text-white/30 text-4xl mb-3"></i>
                <p class="text-white/60 font-medium text-sm">Belum ada dokumentasi untuk saat ini.</p>
            </div>
            @else
            {{-- Grid Masonry --}}
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4" style="grid-auto-rows: 200px; grid-auto-flow: dense;">
                @php
                $spans = ['row-span-2', 'row-span-1', 'row-span-3', 'row-span-1', 'row-span-2', 'row-span-2', 'row-span-1'];
                @endphp

                @foreach($documentation as $doc)
                <div @click="lightboxOpen = true; lightboxImage = '{{ $doc->images ? asset('images/' . $doc->images) : '' }}'" class="relative group overflow-hidden rounded-2xl cursor-pointer border border-white/10 hover:border-cyan-400/50 shadow-card hover:shadow-glow-sm transition-all duration-300 {{ $spans[$loop->index % count($spans)] }}">
                    @if($doc->images)
                    <img src="{{ asset('images/' . $doc->images) }}" alt="{{ $doc->title }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" loading="lazy">
                    @else
                    <div class="w-full h-full bg-white/5 flex items-center justify-center">
                        <i class="fa-solid fa-image text-white/30 text-3xl"></i>
                    </div>
                    @endif

                    {{-- Gradient Overlay --}}
                    <div class="absolute inset-0 bg-gradient-to-t from-[#0B1120] via-[#0B1120]/40 to-transparent opacity-0 group-hover:opacity-100 transition-all duration-300"></div>

                    {{-- Text Content --}}
                    <div class="absolute bottom-0 left-0 right-0 p-4 translate-y-2 opacity-0 group-hover:translate-y-0 group-hover:opacity-100 transition-all duration-300">
                        <p class="text-white font-bold text-sm leading-tight drop-shadow-md">{{ $doc->title }}</p>
                        <div class="w-6 h-0.5 bg-cyan-400 mt-1.5 rounded-full"></div>
                    </div>
                </div>
                @endforeach
            </div>
            @endif
        </div>

        {{-- Lightbox Modal --}}
        <div x-show="lightboxOpen" style="display: none;" class="fixed inset-0 z-[100] flex items-center justify-center bg-[#0B1120]/95 backdrop-blur-xl p-4" x-transition.opacity.duration.300ms @keydown.escape.window="lightboxOpen = false">
            <button @click="lightboxOpen = false" aria-label="Tutup detail foto" class="absolute top-6 right-6 text-white/60 hover:text-white transition-colors z-50 bg-white/10 w-11 h-11 rounded-full flex items-center justify-center hover:bg-white/20">
                <i class="fa-solid fa-xmark text-xl"></i>
            </button>
            <div @click.away="lightboxOpen = false" class="relative max-w-5xl max-h-[85vh] w-full flex justify-center items-center">
                <img :src="lightboxImage" x-show="lightboxImage" class="max-w-full max-h-[85vh] object-contain rounded-2xl shadow-2xl border border-white/15" x-transition.scale.95.duration.300ms>
            </div>
        </div>
    </section>

    {{-- CTA Section --}}
    <section class="bg-[#0c1033] py-20 px-4 sm:px-6 lg:px-8 text-center relative overflow-hidden border-t border-white/5">
        <div class="absolute inset-0 bg-blue-glow opacity-30 pointer-events-none"></div>
        <div class="relative z-10 max-w-2xl mx-auto">
            <div class="mb-3">
                <span class="text-cyan-400 font-extrabold text-[11px] sm:text-xs tracking-[0.2em] uppercase inline-flex items-center gap-1.5">
                    <span class="w-1.5 h-1.5 rounded-full bg-cyan-400"></span>
                    MULAI KONSULTASI
                </span>
            </div>
            <h2 class="font-sans font-black text-3xl sm:text-4xl md:text-5xl text-white mb-4 leading-tight tracking-tight">
                Siap Mengeksekusi Ide & Proyek Anda?
            </h2>
            <p class="text-white/65 mb-8 text-xs sm:text-sm md:text-base leading-relaxed px-2 font-normal">
                Jangan biarkan pengerjaan skripsi atau proyek IT Anda terhambat. Diskusikan sekarang bersama kami dan dapatkan solusi cerdas, tuntas, dan bergaransi.
            </p>

            <div class="flex flex-wrap items-center justify-center gap-3.5 mb-8">
                <a href="https://wa.me/6285221694067?text=Halo%20Sobat%20Scalify,%20saya%20tertarik%20dengan%20jasa%20pembuatan%20website/skripsi.%20Bisa%20dibantu?{{ $waTextRef }}" target="_blank" id="wa-btn-footer" class="wa-btn-track inline-flex items-center gap-2.5 bg-btn-gradient text-white font-bold px-8 py-4 rounded-full shadow-glow-blue hover:scale-105 transition-all text-xs sm:text-sm">
                    <i class="fa-brands fa-whatsapp text-base text-emerald-300"></i>
                    <span>Hubungi Kami via WhatsApp</span>
                    <span class="w-6 h-6 bg-white/20 rounded-full flex items-center justify-center text-[10px]">→</span>
                </a>
            </div>

            <div class="flex flex-wrap items-center justify-center gap-6 text-white/50 text-xs sm:text-sm font-medium">
                <span class="flex items-center gap-1.5"><i class="fa-solid fa-check text-emerald-400"></i> Konsultasi Gratis</span>
                <span class="flex items-center gap-1.5"><i class="fa-solid fa-check text-emerald-400"></i> Pengerjaan Tepat Waktu</span>
                <span class="flex items-center gap-1.5"><i class="fa-solid fa-check text-emerald-400"></i> Bergaransi Purna Jual</span>
            </div>
        </div>
    </section>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const waButtons = document.querySelectorAll('.wa-btn-track');

        waButtons.forEach(btn => {
            btn.addEventListener('click', function(e) {
                fetch('/api/track-wa-click', {
                    method: 'POST'
                    , headers: {
                        'Content-Type': 'application/json'
                        , 'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                    , body: JSON.stringify({
                        ref: new URLSearchParams(window.location.search).get('ref')
                    })
                }).catch(err => console.error('Tracking error:', err));
            });
        });
    });

</script>
@endsection
