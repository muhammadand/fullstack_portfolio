@extends('layouts.app')

@section('meta_tags')
<title>Program Afiliasi Sobat Scalify - Dapatkan Komisi dari Skripsi & Web</title>
<meta name="title" content="Program Afiliasi Sobat Scalify - Dapatkan Komisi dari Skripsi & Web" />
<meta name="description" content="Bergabunglah dengan program Sobat Scalify Partner. Rekomendasikan layanan jasa pembuatan skripsi, website, dan sistem cerdas kepada rekan Anda dan dapatkan komisi pasif hingga 10% setiap bulannya." />
<meta name="keywords" content="program afiliasi, affiliate marketing, komisi pembuatan website, komisi skripsi IT, uang tambahan mahasiswa, affiliate sobat scalify, bisnis online tanpa modal" />
<meta name="robots" content="index, follow" />
<link rel="canonical" href="{{ url()->current() }}" />

<!-- Open Graph / Facebook -->
<meta property="og:type" content="website" />
<meta property="og:url" content="{{ url()->current() }}" />
<meta property="og:title" content="Program Afiliasi Sobat Scalify - Dapatkan Komisi dari Skripsi & Web" />
<meta property="og:description" content="Rekomendasikan layanan jasa pembuatan skripsi dan website kami, lalu dapatkan komisi menarik setiap bulannya." />
<meta property="og:image" content="{{ asset('images/partner_flow.png') }}" />

<!-- Twitter -->
<meta property="twitter:card" content="summary_large_image" />
<meta property="twitter:url" content="{{ url()->current() }}" />
<meta property="twitter:title" content="Program Afiliasi Sobat Scalify - Dapatkan Komisi dari Skripsi & Web" />
<meta property="twitter:description" content="Rekomendasikan layanan jasa pembuatan skripsi dan website kami, lalu dapatkan komisi menarik setiap bulannya." />
<meta property="twitter:image" content="{{ asset('images/partner_flow.png') }}" />
@endsection

@section('content')
<div class="bg-slate-50 min-h-screen font-sans">

    {{-- Hero Section --}}
    <section class="relative pt-32 pb-24 overflow-hidden" style="background-color: #0A0E2A;">
        <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/stardust.png')] opacity-10 pointer-events-none"></div>
        <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-blue-600 rounded-full mix-blend-screen filter blur-[150px] opacity-20 pointer-events-none translate-x-1/2 -translate-y-1/2"></div>
        <div class="absolute bottom-0 left-0 w-[400px] h-[400px] bg-indigo-500 rounded-full mix-blend-screen filter blur-[120px] opacity-20 pointer-events-none -translate-x-1/2 translate-y-1/2"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
            <div class="inline-flex items-center px-4 py-2 rounded-full bg-blue-500/10 border border-blue-400/30 text-blue-300 text-sm font-semibold mb-6 tracking-wide uppercase shadow-[0_0_15px_rgba(59,130,246,0.15)] backdrop-blur-md">
                <i class="fa-solid fa-gem mr-2 text-yellow-400"></i> Partner Program
            </div>
            <h1 class="text-4xl sm:text-5xl lg:text-5xl lg:leading-tight font-bold font-display leading-tight mb-6 text-white drop-shadow-lg">
                Jadilah <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-indigo-300">Sobat Scalify Partner</span><br />& Dapatkan Penghasilan Tambahan
                <h1 class="text-4xl sm:text-5xl lg:text-5xl lg:leading-tight font-bold font-display leading-tight mb-6 text-white drop-shadow-lg">
                    Jadilah <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-indigo-300">Sobat Scalify Partner</span><br />& Dapatkan Penghasilan Tambahan
                </h1>
                <p class="text-lg text-blue-100/80 mb-10 max-w-3xl mx-auto leading-relaxed">
                    Kami sediakan <strong class="text-white">Proposal & Landing Page Profesional</strong> secara gratis. Anda tinggal pilih target pasarnya (Wedding, Cafe, Retail, dll) lalu bagikan! Nikmati komisi <strong class="text-white text-xl">Rp 500.000 per Klien</strong> dari setiap deal yang berhasil.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('affiliate.register') }}" class="px-8 py-4 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-bold rounded-xl shadow-[0_0_20px_rgba(59,130,246,0.4)] hover:shadow-[0_0_30px_rgba(59,130,246,0.6)] transition-all duration-300 transform hover:-translate-y-1 flex items-center justify-center gap-2 border border-blue-500/50">
                        <i class="fa-solid fa-user-plus"></i> Gabung Sekarang Gratis
                    </a>
                    <a href="{{ route('affiliate.login') }}" class="px-8 py-4 bg-white/5 border border-white/20 text-white font-semibold rounded-xl hover:bg-white/10 backdrop-blur-md transition-all duration-300 flex items-center justify-center gap-2">
                        Masuk Dashboard
                    </a>
                </div>
        </div>
    </section>

    {{-- How It Works Section --}}
    <section class="py-24 relative overflow-hidden bg-slate-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-5xl font-bold mb-4 font-display" style="color: #191970;">Alur <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-indigo-500">Program Afiliasi</span></h2>
                <p class="text-slate-500 text-lg max-w-2xl mx-auto">Sangat mudah! Ikuti langkah di bawah ini untuk mulai mendapatkan penghasilan dari komisi referral Anda.</p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center mb-16">
                {{-- Illustration Image --}}
                <div class="order-2 lg:order-1 relative rounded-3xl p-2 bg-white border border-slate-100 shadow-2xl transform hover:scale-[1.02] transition-transform duration-500">
                    <div class="absolute inset-0 bg-gradient-to-tr from-blue-500/5 to-transparent rounded-3xl z-10 pointer-events-none"></div>
                    <img src="{{ asset('images/partner_flow.png') }}" alt="Alur Program Afiliasi Sobat Scalify" class="relative rounded-2xl w-full h-auto object-cover" loading="lazy" decoding="async">
                </div>

                {{-- Steps Explanation --}}
                <div class="order-1 lg:order-2 space-y-6">
                    {{-- Step 1 --}}
                    <div class="flex items-start gap-4 p-5 bg-white rounded-2xl shadow-sm border border-slate-100 hover:shadow-md transition-shadow">
                        <div class="w-12 h-12 shrink-0 rounded-xl bg-blue-100 text-blue-600 flex items-center justify-center text-xl font-bold font-display">
                            1
                        </div>
                        <div>
                            <h4 class="text-lg font-bold text-slate-800 mb-1">Pilih Target Pasar</h4>
                            <p class="text-sm text-slate-600 leading-relaxed">Masuk ke Dashboard, lalu buka <b>Katalog Proposal</b>. Pilih kategori bisnis yang ingin Anda sasar (seperti Wedding, Cafe, Jasa, dll).</p>
                        </div>
                    </div>

                    {{-- Step 2 --}}
                    <div class="flex items-start gap-4 p-5 bg-white rounded-2xl shadow-sm border border-slate-100 hover:shadow-md transition-shadow">
                        <div class="w-12 h-12 shrink-0 rounded-xl bg-indigo-100 text-indigo-600 flex items-center justify-center text-xl font-bold font-display">
                            2
                        </div>
                        <div>
                            <h4 class="text-lg font-bold text-slate-800 mb-1">Bagikan Proposal & Web</h4>
                            <p class="text-sm text-slate-600 leading-relaxed">Kami sudah siapkan Landing Page & PDF Proposal profesional yang tertanam otomatis dengan ID Anda. Tinggal <i>copy-paste</i> atau kirim via WA.</p>
                        </div>
                    </div>

                    {{-- Step 3 --}}
                    <div class="flex items-start gap-4 p-5 bg-white rounded-2xl shadow-sm border border-slate-100 hover:shadow-md transition-shadow">
                        <div class="w-12 h-12 shrink-0 rounded-xl bg-purple-100 text-purple-600 flex items-center justify-center text-xl font-bold font-display">
                            3
                        </div>
                        <div>
                            <h4 class="text-lg font-bold text-slate-800 mb-1">Tim Kami yang Closing</h4>
                            <p class="text-sm text-slate-600 leading-relaxed">Ketika klien menghubungi dari link Anda, tim profesional kami yang akan melakukan presentasi, negosiasi, dan pengerjaan project hingga selesai.</p>
                        </div>
                    </div>

                    {{-- Step 4 --}}
                    <div class="flex items-start gap-4 p-5 bg-white rounded-2xl shadow-sm border border-slate-100 hover:shadow-md transition-shadow">
                        <div class="w-12 h-12 shrink-0 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center text-xl font-bold font-display">
                            4
                        </div>
                        <div>
                            <h4 class="text-lg font-bold text-slate-800 mb-1">Terima Komisi Rp 500Rb</h4>
                            <p class="text-sm text-slate-600 leading-relaxed">Setelah project deal dan klien melakukan pembayaran, komisi <b>Rp 500.000</b> (untuk project perusahaan) akan langsung cair ke Dashboard Anda!</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Benefits Section --}}
    <section class="py-24 bg-white relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-5xl font-bold mb-4 font-display text-slate-800">Kenapa Bergabung Bersama Kami?</h2>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="text-center p-8 bg-slate-50 rounded-3xl border border-slate-100">
                    <div class="w-20 h-20 mx-auto rounded-full bg-blue-100 flex items-center justify-center text-3xl text-blue-600 mb-6">
                        <i class="fa-solid fa-money-bill-trend-up"></i>
                    </div>
                    <h4 class="text-xl font-bold text-slate-800 mb-3">Komisi Besar & Tetap</h4>
                    <p class="text-slate-500">Dapatkan komisi flat <strong>Rp 500.000</strong> per klien perusahaan, atau <strong>Rp 150.000</strong> untuk klien mahasiswa. Semakin banyak share, semakin untung!</p>
                </div>
                <div class="text-center p-8 bg-slate-50 rounded-3xl border border-slate-100">
                    <div class="w-20 h-20 mx-auto rounded-full bg-emerald-100 flex items-center justify-center text-3xl text-emerald-600 mb-6">
                        <i class="fa-solid fa-file-pdf"></i>
                    </div>
                    <h4 class="text-xl font-bold text-slate-800 mb-3">Bahan Marketing Siap Pakai</h4>
                    <p class="text-slate-500">Tak perlu repot bikin bahan presentasi. Kami siapkan Landing Page & PDF Proposal super profesional untuk setiap kategori bisnis.</p>
                </div>
                <div class="text-center p-8 bg-slate-50 rounded-3xl border border-slate-100">
                    <div class="w-20 h-20 mx-auto rounded-full bg-purple-100 flex items-center justify-center text-3xl text-purple-600 mb-6">
                        <i class="fa-solid fa-clock-rotate-left"></i>
                    </div>
                    <h4 class="text-xl font-bold text-slate-800 mb-3">Pencairan Fleksibel</h4>
                    <p class="text-slate-500">Anda dapat melakukan penarikan dana ke rekening kapan saja dengan minimal penarikan yang rendah.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- CTA --}}
    <section class="py-20 relative overflow-hidden" style="background-color: #0A0E2A;">
        <div class="max-w-4xl mx-auto px-4 text-center relative z-10">
            <h2 class="text-3xl md:text-5xl font-bold text-white mb-6 font-display">Siap Meraih Penghasilan Tambahan?</h2>
            <p class="text-lg text-blue-100/80 mb-10 max-w-2xl mx-auto leading-relaxed">Tidak dipungut biaya apapun! Pendaftaran cepat, mulai bagikan link Anda sekarang juga.</p>
            <a href="{{ route('affiliate.register') }}" class="inline-flex items-center gap-3 px-8 py-4 bg-emerald-500 hover:bg-emerald-600 text-white font-bold text-lg rounded-full shadow-lg shadow-emerald-500/30 transition-all duration-300 transform hover:scale-105">
                <i class="fa-solid fa-rocket"></i> Daftar Sekarang
            </a>
        </div>
    </section>

</div>
@endsection
