@extends('layouts.app')

@section('hide_navbar_mobile', true)
@section('hide_footer_mobile', true)
@section('hide_chatbot', true)

@push('meta')
<x-affiliate.pwa-meta />
@endpush

@push('styles')
<link rel="preconnect" href="https://cdnjs.cloudflare.com" crossorigin>
<link rel="dns-prefetch" href="https://cdnjs.cloudflare.com">
<style>
    .glass-panel {
        background: rgba(255, 255, 255, 0.04);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        border: 1px solid rgba(255, 255, 255, 0.08);
    }

    .glass-card-glow {
        background: linear-gradient(135deg, rgba(37, 99, 235, 0.12), rgba(30, 41, 59, 0.3));
        backdrop-filter: blur(16px);
        -webkit-backdrop-filter: blur(16px);
        border: 1px solid rgba(59, 130, 246, 0.2);
    }

    body {
        background-color: #0B1120;
    }

    .hide-scrollbar::-webkit-scrollbar {
        display: none;
    }

    .hide-scrollbar {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }

    /* Style for Dedicated Section View to force display partial content */
    .guide-dedicated-page .tab-pane {
        display: block !important;
    }

    /* Interactive Menu Card Animation */
    .menu-card-hover {
        transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .menu-card-hover:hover {
        transform: translateY(-2px);
        border-color: rgba(99, 102, 241, 0.35);
        box-shadow: 0 12px 30px -10px rgba(0, 0, 0, 0.5), 0 0 20px rgba(59, 130, 246, 0.15);
    }

    .menu-card-hover:active {
        transform: scale(0.98);
    }

    .day-tab-btn {
        background: rgba(255, 255, 255, 0.02);
        border-color: rgba(255, 255, 255, 0.08);
        color: #94A3B8;
    }

    .day-tab-btn:hover {
        background: rgba(255, 255, 255, 0.05);
        color: #FFFFFF;
    }

    .day-tab-btn.active {
        background: linear-gradient(135deg, rgba(37, 99, 235, 0.3), rgba(30, 58, 138, 0.4));
        border-color: #3B82F6;
        color: #FFFFFF;
        box-shadow: 0 0 15px rgba(59, 130, 246, 0.25);
    }

</style>
@endpush

@section('content')

@php
$currentSection = request('section');

// Metadata untuk masing-masing modul
$sectionMeta = [
'roadmap' => [
'title' => 'Roadmap 1 Deal',
'subtitle' => 'Panduan Aksi 6 Hari Sprint Closing',
'badge' => 'Sprint 6 Hari',
'badge_color' => 'bg-blue-500/15 text-blue-400 border-blue-500/30',
'icon' => 'fa-compass text-blue-400',
'next' => 'ai-studio',
'next_title' => 'AI Social Studio'
],
'ai-studio' => [
'title' => 'AI Social Studio',
'subtitle' => 'Generator Copywriting Media Sosial',
'badge' => 'Generator AI',
'badge_color' => 'bg-indigo-500/15 text-indigo-400 border-indigo-500/30',
'icon' => 'fa-wand-magic-sparkles text-indigo-400',
'next' => 'marketing-kit',
'next_title' => 'Marketing Kit'
],
'marketing-kit' => [
'title' => 'Marketing Kit & Banner',
'subtitle' => 'Asset Visual & Materi Promosi Klien',
'badge' => 'Asset Grafis',
'badge_color' => 'bg-amber-500/15 text-amber-400 border-amber-500/30',
'icon' => 'fa-images text-amber-400',
'next' => 'categories',
'next_title' => 'Target Kategori'
],
'categories' => [
'title' => 'Target Kategori & Niche',
'subtitle' => 'Riset Sektor UMKM & Angle Penawaran',
'badge' => 'Ide Niche',
'badge_color' => 'bg-emerald-500/15 text-emerald-400 border-emerald-500/30',
'icon' => 'fa-layer-group text-emerald-400',
'next' => 'case-study',
'next_title' => 'Case Study Klien'
],
'case-study' => [
'title' => 'Case Study Klien',
'subtitle' => 'Bukti Portofolio Nyata Peningkatan Omset',
'badge' => 'Bukti Nyata',
'badge_color' => 'bg-rose-500/15 text-rose-400 border-rose-500/30',
'icon' => 'fa-briefcase text-rose-400',
'next' => 'objection',
'next_title' => 'Penakluk Penolakan',
],
'objection' => [
'title' => 'Penakluk Penolakan',
'subtitle' => 'Taktik Negosiasi AI & Solusi Keberatan',
'badge' => 'AI Negosiasi',
'badge_color' => 'bg-purple-500/15 text-purple-400 border-purple-500/30',
'icon' => 'fa-shield-halved text-purple-400',
'next' => 'review-card',
'next_title' => 'Panduan Jual Review Card'
],
'review-card' => [
'title' => 'Panduan Jual Review Card',
'subtitle' => 'Strategi Closing Cepat Smart NFC Card',
'badge' => 'Hot Cuan',
'badge_color' => 'bg-sky-500/15 text-sky-400 border-sky-500/30',
'icon' => 'fa-qrcode text-sky-400',
'next' => 'roadmap',
'next_title' => 'Roadmap 1 Deal'
],
];
@endphp

<x-affiliate.page-loader />

<!-- Subtle Background Decoration -->
<div class="fixed top-0 left-0 w-full h-72 bg-blue-600/10 rounded-full blur-[120px] -translate-y-1/2 pointer-events-none z-0"></div>
<div class="fixed bottom-0 right-0 w-72 h-72 bg-indigo-600/10 rounded-full blur-[120px] translate-y-1/2 translate-x-1/3 pointer-events-none z-0"></div>

<div class="relative z-10 w-full max-w-md mx-auto min-h-screen px-4 pt-6 pb-28 text-white font-sans">

    @if(empty($currentSection) || !array_key_exists($currentSection, $sectionMeta))
    <!-- ========================================== -->
    <!-- VIEW 1: HUB UTAMA / GRID MENU EDUKASI & AI -->
    <!-- ========================================== -->

    <!-- Top Bar -->
    <div class="flex items-center justify-between mb-4">
        <div class="flex items-center gap-3">
            <a href="{{ route('affiliate.dashboard') }}" wire:navigate class="w-10 h-10 rounded-full glass-panel flex items-center justify-center text-slate-300 hover:text-white transition-colors active:scale-95" title="Kembali ke Dashboard">
                <i class="fa-solid fa-arrow-left text-sm"></i>
            </a>
            <div>
                <h1 class="text-base font-bold text-white tracking-tight">Pusat Edukasi & AI Hub</h1>
                <p class="text-[11px] text-slate-400 font-medium">Strategi Closing & Marketing Kit</p>
            </div>
        </div>
        <div class="w-9 h-9 rounded-xl glass-panel flex items-center justify-center text-blue-400 text-sm">
            <i class="fa-solid fa-graduation-cap"></i>
        </div>
    </div>

    <!-- Target Benchmark Card -->
    <div class="glass-card-glow p-4 rounded-2xl mb-6 flex items-center justify-between">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-blue-600/20 border border-blue-500/30 flex items-center justify-center text-blue-400 text-sm shrink-0">
                <i class="fa-solid fa-chart-line"></i>
            </div>
            <div>
                <span class="text-[10px] text-slate-400 uppercase tracking-wider font-semibold">Target Partner</span>
                <p class="text-xs font-bold text-white">Min. 1 Deal / Minggu (10% Komisi)</p>
            </div>
        </div>
        <span class="px-2.5 py-1 rounded-lg text-[10px] font-semibold bg-emerald-500/15 text-emerald-400 border border-emerald-500/25">
            Rp 100.000 - 200.000/Deal
        </span>
    </div>

    <!-- Featured Playbook Banner: Google Review Card -->
    <a href="{{ route('affiliate.guide', ['section' => 'review-card']) }}" wire:navigate class="menu-card-hover block p-4 rounded-3xl mb-5 border border-sky-500/40 relative overflow-hidden group cursor-pointer" style="background: radial-gradient(circle at top right, rgba(14, 165, 233, 0.22) 0%, rgba(15, 23, 42, 0.9) 100%);">
        <div class="flex items-start justify-between gap-3 mb-2">
            <div class="flex items-center gap-3">
                <div class="w-11 h-11 rounded-2xl bg-sky-500/20 border border-sky-400/40 flex items-center justify-center text-sky-400 text-xl shadow-[0_0_15px_rgba(14,165,233,0.3)] group-hover:scale-110 transition-transform">
                    <i class="fa-solid fa-qrcode"></i>
                </div>
                <div>
                    <div class="flex items-center gap-2 mb-0.5">
                        <h3 class="text-xs sm:text-sm font-extrabold text-white group-hover:text-sky-300 transition-colors">Panduan Jual Review Card</h3>
                        <span class="px-2 py-0.5 rounded-full text-[9px] font-extrabold bg-sky-500 text-white shadow-sm leading-none animate-pulse">
                            Hot Cuan
                        </span>
                    </div>
                    <p class="text-[10px] sm:text-[11px] text-slate-300">Trik closing 5 detik & profit margin s/d 800%</p>
                </div>
            </div>
        </div>
        <div class="pt-2.5 mt-2 border-t border-white/10 flex items-center justify-between text-[10px] sm:text-[11px] font-semibold text-sky-400 group-hover:text-sky-300">
            <span class="flex items-center gap-1.5 text-slate-300 font-normal">
                <i class="fa-solid fa-wand-magic-sparkles text-sky-400 text-[10px]"></i> Trik Magic Tap & Script WA
            </span>
            <span class="flex items-center gap-1 font-bold">
                Buka Playbook <i class="fa-solid fa-arrow-right text-[10px] group-hover:translate-x-1 transition-transform"></i>
            </span>
        </div>
    </a>

    <!-- Section Title -->
    <div class="flex items-center justify-between mb-3 px-1">
        <div>
            <h2 class="text-xs font-bold text-slate-300 uppercase tracking-wider flex items-center gap-1.5">
                <i class="fa-solid fa-grid-2 text-indigo-400 text-[11px]"></i> Modul Pembelajaran & Alat AI
            </h2>
            <p class="text-[11px] text-slate-400">Pilih modul yang ingin Anda pelajari atau gunakan:</p>
        </div>
    </div>

    <!-- 6 Module Grid Menu Cards -->
    <div class="grid grid-cols-2 gap-3 mb-6">

        <!-- 1. Roadmap 1 Deal -->
        <a href="{{ route('affiliate.guide', ['section' => 'roadmap']) }}" wire:navigate class="menu-card-hover glass-panel p-3.5 rounded-2xl flex flex-col justify-between border border-white/10 group cursor-pointer">
            <div>
                <div class="flex items-center justify-between mb-3">
                    <div class="w-10 h-10 rounded-xl bg-blue-500/15 border border-blue-500/30 flex items-center justify-center text-blue-400 text-lg group-hover:scale-110 transition-transform">
                        <i class="fa-solid fa-compass"></i>
                    </div>
                    <span class="px-2 py-0.5 rounded-full text-[9px] font-bold bg-blue-500/15 text-blue-300 border border-blue-400/20">
                        Sprint 6 Hari
                    </span>
                </div>
                <h3 class="text-xs font-bold text-white mb-1 group-hover:text-blue-300 transition-colors">Roadmap 1 Deal</h3>
                <p class="text-[10px] text-slate-400 leading-relaxed mb-3">Panduan aksi harian dari riset Google Maps s/d closing deal.</p>
            </div>
            <div class="pt-2 border-t border-white/5 flex items-center justify-between text-[10px] font-semibold text-blue-400 group-hover:text-blue-300">
                <span>Buka Panduan</span>
                <i class="fa-solid fa-arrow-right text-[9px] group-hover:translate-x-1 transition-transform"></i>
            </div>
        </a>

        <!-- 2. AI Social Studio -->
        <a href="{{ route('affiliate.guide', ['section' => 'ai-studio']) }}" wire:navigate class="menu-card-hover glass-panel p-3.5 rounded-2xl flex flex-col justify-between border border-white/10 group cursor-pointer">
            <div>
                <div class="flex items-center justify-between mb-3">
                    <div class="w-10 h-10 rounded-xl bg-indigo-500/15 border border-indigo-500/30 flex items-center justify-center text-indigo-400 text-lg group-hover:scale-110 transition-transform">
                        <i class="fa-solid fa-wand-magic-sparkles"></i>
                    </div>
                    <span class="px-2 py-0.5 rounded-full text-[9px] font-bold bg-indigo-500/15 text-indigo-300 border border-indigo-400/20">
                        AI Copywriter
                    </span>
                </div>
                <h3 class="text-xs font-bold text-white mb-1 group-hover:text-indigo-300 transition-colors">AI Social Studio</h3>
                <p class="text-[10px] text-slate-400 leading-relaxed mb-3">Bikin copywriting status WA Story & medsos siap closing otomatis.</p>
            </div>
            <div class="pt-2 border-t border-white/5 flex items-center justify-between text-[10px] font-semibold text-indigo-400 group-hover:text-indigo-300">
                <span>Buka AI Studio</span>
                <i class="fa-solid fa-arrow-right text-[9px] group-hover:translate-x-1 transition-transform"></i>
            </div>
        </a>

        <!-- 3. Marketing Kit & Banner -->
        <a href="{{ route('affiliate.guide', ['section' => 'marketing-kit']) }}" wire:navigate class="menu-card-hover glass-panel p-3.5 rounded-2xl flex flex-col justify-between border border-white/10 group cursor-pointer">
            <div>
                <div class="flex items-center justify-between mb-3">
                    <div class="w-10 h-10 rounded-xl bg-amber-500/15 border border-amber-500/30 flex items-center justify-center text-amber-400 text-lg group-hover:scale-110 transition-transform">
                        <i class="fa-solid fa-images"></i>
                    </div>
                    <span class="px-2 py-0.5 rounded-full text-[9px] font-bold bg-amber-500/15 text-amber-300 border border-amber-400/20">
                        Asset Promosi
                    </span>
                </div>
                <h3 class="text-xs font-bold text-white mb-1 group-hover:text-amber-300 transition-colors">Marketing Kit</h3>
                <p class="text-[10px] text-slate-400 leading-relaxed mb-3">Unduh banner promosi, poster WhatsApp & materi grafis.</p>
            </div>
            <div class="pt-2 border-t border-white/5 flex items-center justify-between text-[10px] font-semibold text-amber-400 group-hover:text-amber-300">
                <span>Unduh Materi</span>
                <i class="fa-solid fa-arrow-right text-[9px] group-hover:translate-x-1 transition-transform"></i>
            </div>
        </a>

        <!-- 4. Target Kategori & Niche -->
        <a href="{{ route('affiliate.guide', ['section' => 'categories']) }}" wire:navigate class="menu-card-hover glass-panel p-3.5 rounded-2xl flex flex-col justify-between border border-white/10 group cursor-pointer">
            <div>
                <div class="flex items-center justify-between mb-3">
                    <div class="w-10 h-10 rounded-xl bg-emerald-500/15 border border-emerald-500/30 flex items-center justify-center text-emerald-400 text-lg group-hover:scale-110 transition-transform">
                        <i class="fa-solid fa-layer-group"></i>
                    </div>
                    <span class="px-2 py-0.5 rounded-full text-[9px] font-bold bg-emerald-500/15 text-emerald-300 border border-emerald-400/20">
                        Ide Prospek
                    </span>
                </div>
                <h3 class="text-xs font-bold text-white mb-1 group-hover:text-emerald-300 transition-colors">Target Kategori</h3>
                <p class="text-[10px] text-slate-400 leading-relaxed mb-3">Katalog sektor bisnis UMKM & sudut penawaran closing terbaik.</p>
            </div>
            <div class="pt-2 border-t border-white/5 flex items-center justify-between text-[10px] font-semibold text-emerald-400 group-hover:text-emerald-300">
                <span>Lihat Niche</span>
                <i class="fa-solid fa-arrow-right text-[9px] group-hover:translate-x-1 transition-transform"></i>
            </div>
        </a>

        <!-- 5. Case Study Klien -->
        <a href="{{ route('affiliate.guide', ['section' => 'case-study']) }}" wire:navigate class="menu-card-hover glass-panel p-3.5 rounded-2xl flex flex-col justify-between border border-white/10 group cursor-pointer">
            <div>
                <div class="flex items-center justify-between mb-3">
                    <div class="w-10 h-10 rounded-xl bg-rose-500/15 border border-rose-500/30 flex items-center justify-center text-rose-400 text-lg group-hover:scale-110 transition-transform">
                        <i class="fa-solid fa-briefcase"></i>
                    </div>
                    <span class="px-2 py-0.5 rounded-full text-[9px] font-bold bg-rose-500/15 text-rose-300 border border-rose-400/20">
                        Portofolio
                    </span>
                </div>
                <h3 class="text-xs font-bold text-white mb-1 group-hover:text-rose-300 transition-colors">Case Study Klien</h3>
                <p class="text-[10px] text-slate-400 leading-relaxed mb-3">Bukti hasil omset nyata klien untuk meyakinkan calon deal Anda.</p>
            </div>
            <div class="pt-2 border-t border-white/5 flex items-center justify-between text-[10px] font-semibold text-rose-400 group-hover:text-rose-300">
                <span>Pelajari Kasus</span>
                <i class="fa-solid fa-arrow-right text-[9px] group-hover:translate-x-1 transition-transform"></i>
            </div>
        </a>

        <!-- 6. Penakluk Penolakan -->
        <a href="{{ route('affiliate.guide', ['section' => 'objection']) }}" wire:navigate class="menu-card-hover glass-panel p-3.5 rounded-2xl flex flex-col justify-between border border-white/10 group cursor-pointer">
            <div>
                <div class="flex items-center justify-between mb-3">
                    <div class="w-10 h-10 rounded-xl bg-purple-500/15 border border-purple-500/30 flex items-center justify-center text-purple-400 text-lg group-hover:scale-110 transition-transform">
                        <i class="fa-solid fa-shield-halved"></i>
                    </div>
                    <span class="px-2 py-0.5 rounded-full text-[9px] font-bold bg-purple-500/15 text-purple-300 border border-purple-400/20">
                        AI Negosiasi
                    </span>
                </div>
                <h3 class="text-xs font-bold text-white mb-1 group-hover:text-purple-300 transition-colors">Penakluk Penolakan</h3>
                <p class="text-[10px] text-slate-400 leading-relaxed mb-3">Jawaban taktis AI saat prospek ragu harga atau bilang nanti.</p>
            </div>
            <div class="pt-2 border-t border-white/5 flex items-center justify-between text-[10px] font-semibold text-purple-400 group-hover:text-purple-300">
                <span>Mulai Latihan</span>
                <i class="fa-solid fa-arrow-right text-[9px] group-hover:translate-x-1 transition-transform"></i>
            </div>
        </a>

    </div>

    <!-- Tip Card -->
    <div class="p-3.5 rounded-2xl bg-gradient-to-r from-blue-900/30 via-indigo-900/20 to-purple-900/30 border border-indigo-500/20 flex items-start gap-3">
        <div class="w-8 h-8 rounded-xl bg-indigo-500/20 text-indigo-400 flex items-center justify-center shrink-0 text-sm mt-0.5">
            <i class="fa-solid fa-lightbulb"></i>
        </div>
        <div>
            <h4 class="text-xs font-bold text-white mb-0.5">Tips Sukses Partner Scalify</h4>
            <p class="text-[11px] text-indigo-200/70 leading-relaxed">
                Pelajari dan terapkan 1 modul setiap hari. Jangan ragu menggunakan AI Studio untuk membuat materi promosi instan kapan saja.
            </p>
        </div>
    </div>

    @else
    <!-- ============================================== -->
    <!-- VIEW 2: DEDICATED PAGE PER MODUL (FULL SCREEN) -->
    <!-- ============================================== -->
    @php
    $info = $sectionMeta[$currentSection];
    @endphp

    <!-- Top Bar Dedicated Module -->
    <div class="flex items-center justify-between mb-5">
        <div class="flex items-center gap-3">
            <a href="{{ route('affiliate.guide') }}" wire:navigate class="w-10 h-10 rounded-full glass-panel flex items-center justify-center text-slate-300 hover:text-white transition-colors active:scale-95" title="Kembali ke Menu Modul">
                <i class="fa-solid fa-arrow-left text-sm"></i>
            </a>
            <div>
                <h1 class="text-base font-bold text-white tracking-tight flex items-center gap-2">
                    {{ $info['title'] }}
                </h1>
                <p class="text-[11px] text-slate-400 font-medium">{{ $info['subtitle'] }}</p>
            </div>
        </div>
        <span class="px-2.5 py-1 rounded-lg text-[10px] font-semibold border {{ $info['badge_color'] }}">
            {{ $info['badge'] }}
        </span>
    </div>

    <!-- Container Modul Khusus -->
    <div class="guide-dedicated-page space-y-5">
        @if($currentSection === 'roadmap')
        @include('affiliate.partials.guide.roadmap')
        @elseif($currentSection === 'ai-studio')
        @include('affiliate.partials.guide.ai_studio')
        @elseif($currentSection === 'marketing-kit')
        @include('affiliate.partials.guide.marketing_kit')
        @elseif($currentSection === 'categories')
        @include('affiliate.partials.guide.categories')
        @elseif($currentSection === 'case-study')
        @include('affiliate.partials.guide.case_studies')
        @elseif($currentSection === 'objection')
        @include('affiliate.partials.guide.objection')
        @elseif($currentSection === 'review-card')
        @include('affiliate.partials.guide.review_card_guide')
        @endif
    </div>

    <!-- Footer Navigation for Dedicated Module -->
    <div class="mt-8 pt-5 border-t border-white/10 flex items-center justify-between gap-3">
        <a href="{{ route('affiliate.guide') }}" wire:navigate class="flex-1 py-2.5 px-4 rounded-xl glass-panel hover:bg-white/[0.08] text-slate-300 hover:text-white text-xs font-semibold flex items-center justify-center gap-2 transition-all">
            <i class="fa-solid fa-grid-2 text-xs"></i>
            <span>Semua Modul</span>
        </a>
        <a href="{{ route('affiliate.guide', ['section' => $info['next']]) }}" wire:navigate class="flex-1 py-2.5 px-4 rounded-xl bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-500 hover:to-indigo-500 text-white text-xs font-semibold flex items-center justify-center gap-2 transition-all shadow-[0_0_15px_rgba(59,130,246,0.3)]">
            <span>Modul Lanjut</span>
            <i class="fa-solid fa-arrow-right text-xs"></i>
        </a>
    </div>

    @endif

</div>

<!-- Hidden Canvas for Banner Generation -->
<canvas id="bannerCanvas" width="1080" height="1080" style="display:none;"></canvas>

<!-- Bottom Navigation -->
<x-affiliate.bottom-nav />

<x-affiliate.scripts />

<!-- Guide Javascript Logic -->
@include('affiliate.partials.guide.scripts')

@endsection
