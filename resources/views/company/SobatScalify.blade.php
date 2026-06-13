@extends('layouts.app')

@section('meta_tags')
<title>Sobat Scalify — Jasa Pembuatan Website, Skripsi & Sistem Cerdas</title>
<meta name="title" content="Sobat Scalify — Jasa Pembuatan Website, Skripsi & Sistem Cerdas" />
<meta name="description" content="Sobat Scalify menyediakan layanan jasa pembuatan skripsi, website custom, dan implementasi metode cerdas (SCM, CRM, Forecasting, SPK, Data Science). Wujudkan proyek IT Anda bersama kami." />
<meta name="keywords" content="jasa buat skripsi, jasa bikin website, metode SCM, CRM, Forecasting, SPK, sistem pendukung keputusan, data sains, pembuatan aplikasi IT, mahasiswa IT, tugas akhir IT, Sobat Scalify" />
<meta name="author" content="Sobat Scalify" />
<meta name="robots" content="index, follow" />
<meta property="og:title" content="Sobat Scalify — Jasa Pembuatan Website, Skripsi & Sistem Cerdas" />
<meta property="og:description" content="Layanan jasa pembuatan website dan implementasi berbagai metode (SCM, CRM, Forecasting, SPK, Data Science) untuk skripsi dan bisnis." />
<meta property="og:type" content="website" />
<meta property="og:url" content="{{ url()->current() }}" />
@endsection

@section('content')
<div class="bg-white text-gray-800 min-h-screen font-sans">
    {{-- Hero Section --}}
    <section class="relative pt-24 pb-16 lg:pt-32 lg:pb-24 overflow-hidden">
        {{-- Background Accents --}}
        <div class="absolute inset-0 bg-gradient-to-b from-gray-50 to-white pointer-events-none"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div class="text-center lg:text-left">
                    <div class="inline-flex items-center px-4 py-2 rounded-full bg-brand-navy/10 text-brand-accent text-sm font-semibold mb-6 tracking-wide uppercase shadow-sm" style="background: rgba(25,25,112,0.1); color: #191970;">
                        <i class="fa-solid fa-graduation-cap mr-2"></i> Partner Tugas Akhir & Bisnis
                    </div>
                    <h1 class="text-4xl sm:text-5xl lg:text-5xl font-bold font-display leading-tight mb-6" style="color: #191970;">
                        Wujudkan <span class="text-brand-accent relative inline-block">Proyek IT</span> & Skripsi Anda
                    </h1>
                    <p class="text-lg text-gray-600 mb-8 leading-relaxed max-w-2xl mx-auto lg:mx-0">
                        Pusing dengan coding error atau bingung penerapan algoritma? Kami hadir untuk membantu penyelesaian website, tugas akhir, dan skripsi dengan implementasi metode komputasi terkini.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                        <a href="https://wa.me/6285221694067?text=Halo%20Sobat%20Scalify,%20saya%20ingin%20konsultasi%20mengenai%20pembuatan%20website/skripsi." target="_blank" class="px-8 py-4 bg-btn-gradient text-white font-semibold rounded-full shadow-glow-sm hover:shadow-glow-blue transition-all duration-300 transform hover:-translate-y-1 flex items-center justify-center gap-2">
                            <i class="fa-brands fa-whatsapp text-xl"></i> Konsultasi Sekarang
                        </a>
                        <a href="#layanan" class="px-8 py-4 bg-white border-2 text-gray-700 font-semibold rounded-full transition-all duration-300 flex items-center justify-center gap-2" style="color: #191970; border-color: #191970;">
                            Lihat Layanan <i class="fa-solid fa-arrow-down"></i>
                        </a>
                    </div>
                </div>
                <div class="relative hidden lg:block">
                    <img src="{{ asset('images/sobatscal.jpg') }}" alt="Sobat Scalify Team" class="relative rounded-2xl shadow-2xl object-cover w-full h-[500px]" fetchpriority="high">
                </div>
            </div>
        </div>
    </section>

    {{-- Layanan & Metode Section --}}
    <section id="layanan" class="py-20 bg-gray-50 border-t border-gray-100 relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <h2 class="text-3xl md:text-4xl font-bold mb-4 font-display" style="color: #191970;">Spesialisasi & <span class="text-brand-accent">Metode Terapan</span></h2>
                <p class="text-gray-600 text-lg">Kami berpengalaman menerapkan berbagai metode komputasi kompleks ke dalam sistem berbasis web yang fungsional dan modern.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                {{-- Card 1: SCM --}}
                <div class="bg-white p-8 rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-100 group relative overflow-hidden">
                    <div class="w-14 h-14 rounded-xl flex items-center justify-center mb-6" style="background: rgba(25,25,112,0.1);">
                        <i class="fa-solid fa-truck-fast text-2xl group-hover:scale-110 transition-transform" style="color: #191970;"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-3 transition-colors" style="color: #191970;">SCM (Supply Chain)</h3>
                    <p class="text-gray-600 leading-relaxed">Implementasi sistem manajemen rantai pasok untuk melacak barang, optimasi rute distribusi, hingga inventory control terpadu.</p>
                </div>

                {{-- Card 2: CRM --}}
                <div class="bg-white p-8 rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-100 group relative overflow-hidden">
                    <div class="w-14 h-14 rounded-xl flex items-center justify-center mb-6" style="background: rgba(25,25,112,0.1);">
                        <i class="fa-solid fa-users-viewfinder text-2xl group-hover:scale-110 transition-transform" style="color: #191970;"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-3 transition-colors" style="color: #191970;">CRM (Customer Rel.)</h3>
                    <p class="text-gray-600 leading-relaxed">Pengembangan sistem CRM untuk analisis perilaku pelanggan, segmentasi target promosi, dan peningkatan retensi klien.</p>
                </div>

                {{-- Card 3: Forecasting --}}
                <div class="bg-white p-8 rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-100 group relative overflow-hidden">
                    <div class="w-14 h-14 rounded-xl flex items-center justify-center mb-6" style="background: rgba(25,25,112,0.1);">
                        <i class="fa-solid fa-chart-line text-2xl group-hover:scale-110 transition-transform" style="color: #191970;"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-3 transition-colors" style="color: #191970;">Forecasting (Peramalan)</h3>
                    <p class="text-gray-600 leading-relaxed">Penerapan metode peramalan seperti Double Exponential Smoothing, ARIMA, atau WMA untuk prediksi data akurat.</p>
                </div>

                {{-- Card 4: SPK --}}
                <div class="bg-white p-8 rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-100 group relative overflow-hidden">
                    <div class="w-14 h-14 rounded-xl flex items-center justify-center mb-6" style="background: rgba(25,25,112,0.1);">
                        <i class="fa-solid fa-scale-balanced text-2xl group-hover:scale-110 transition-transform" style="color: #191970;"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-3 transition-colors" style="color: #191970;">Sistem Pendukung Keputusan</h3>
                    <p class="text-gray-600 leading-relaxed">Implementasi algoritma SAW, AHP, TOPSIS, WP, atau Profile Matching untuk sistem pemilihan / rekomendasi presisi.</p>
                </div>

                {{-- Card 5: Data Science --}}
                <div class="bg-white p-8 rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-100 group relative overflow-hidden">
                    <div class="w-14 h-14 rounded-xl flex items-center justify-center mb-6" style="background: rgba(25,25,112,0.1);">
                        <i class="fa-solid fa-network-wired text-2xl group-hover:scale-110 transition-transform" style="color: #191970;"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-3 transition-colors" style="color: #191970;">Data Science & AI</h3>
                    <p class="text-gray-600 leading-relaxed">Pengolahan dataset besar dengan algoritma klasifikasi (C4.5, Naive Bayes), clustering (K-Means), dan integrasi AI modern.</p>
                </div>

                {{-- Card 6: Custom Web --}}
                <div class="bg-white p-8 rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-100 group relative overflow-hidden">
                    <div class="w-14 h-14 rounded-xl flex items-center justify-center mb-6" style="background: rgba(25,25,112,0.1);">
                        <i class="fa-solid fa-laptop-code text-2xl group-hover:scale-110 transition-transform" style="color: #191970;"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-3 transition-colors" style="color: #191970;">Custom Web Apps</h3>
                    <p class="text-gray-600 leading-relaxed">Pembuatan website company profile, sistem informasi akademik, dan aplikasi web custom lainnya sesuai spesifikasi Anda.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- Workflow Section --}}
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold mb-4 font-display" style="color: #191970;">Cara <span class="text-brand-accent">Kerja Kami</span></h2>
                <p class="text-gray-600 text-lg">Proses transparan, cepat, dan profesional demi mencapai hasil pengerjaan maksimal.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 text-center relative">
                {{-- Connecting line (desktop only) --}}
                <div class="hidden md:block absolute top-[40px] left-1/2 w-3/4 h-0.5 bg-gray-200 -translate-x-1/2 z-0"></div>

                <div class="relative z-10 bg-white px-4">
                    <div class="w-20 h-20 mx-auto bg-brand-navy text-white rounded-full flex items-center justify-center text-2xl font-bold mb-6 shadow-xl border-4 border-white" style="background-color: #191970;">1</div>
                    <h4 class="font-bold text-xl mb-2" style="color: #191970;">Konsultasi</h4>
                    <p class="text-gray-600">Diskusikan judul, kebutuhan fitur, dan metode yang akan diimplementasikan.</p>
                </div>
                <div class="relative z-10 bg-white px-4">
                    <div class="w-20 h-20 mx-auto bg-white border border-gray-200 rounded-full flex items-center justify-center text-2xl font-bold mb-6 shadow-xl border-4 border-white" style="color: #191970;">2</div>
                    <h4 class="font-bold text-xl mb-2" style="color: #191970;">Kesepakatan</h4>
                    <p class="text-gray-600">Penentuan timeline pengerjaan dan rincian biaya secara transparan di awal.</p>
                </div>
                <div class="relative z-10 bg-white px-4">
                    <div class="w-20 h-20 mx-auto bg-brand-navy text-white rounded-full flex items-center justify-center text-2xl font-bold mb-6 shadow-xl border-4 border-white" style="background-color: #191970;">3</div>
                    <h4 class="font-bold text-xl mb-2" style="color: #191970;">Pengerjaan</h4>
                    <p class="text-gray-600">Proses development intensif dengan pembaruan (progress) berkala kepada Anda.</p>
                </div>
                <div class="relative z-10 bg-white px-4">
                    <div class="w-20 h-20 mx-auto bg-white border border-gray-200 rounded-full flex items-center justify-center text-2xl font-bold mb-6 shadow-xl border-4 border-white" style="color: #191970;">4</div>
                    <h4 class="font-bold text-xl mb-2" style="color: #191970;">Revisi & Rilis</h4>
                    <p class="text-gray-600">Tahap testing aplikasi, perbaikan, penyerahan source code, dan panduan penggunaan.</p>
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

            <a href="https://wa.me/6285221694067?text=Halo%20Sobat%20Scalify,%20saya%20tertarik%20dengan%20jasa%20pembuatan%20website/skripsi.%20Bisa%20dibantu?" target="_blank" class="inline-flex items-center gap-3 px-8 py-4 bg-btn-gradient text-white shadow-glow-sm hover:shadow-glow-blue font-bold text-lg rounded-full transition-all duration-300 transform hover:scale-105">
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
@endsection
