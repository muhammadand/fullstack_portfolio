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

    .tab-btn {
        background: rgba(255, 255, 255, 0.03);
        border: 1px solid rgba(255, 255, 255, 0.08);
        color: #94A3B8;
        transition: all 0.2s ease-in-out;
    }

    .tab-btn:hover {
        color: #FFFFFF;
        background: rgba(255, 255, 255, 0.06);
    }

    .tab-btn.active {
        background: #2563EB;
        color: #FFFFFF;
        border-color: rgba(96, 165, 250, 0.4);
        box-shadow: 0 4px 12px rgba(37, 99, 235, 0.25);
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

<x-affiliate.page-loader />

<!-- Subtle Background Decoration -->
<div class="fixed top-0 left-0 w-full h-72 bg-blue-600/10 rounded-full blur-[120px] -translate-y-1/2 pointer-events-none z-0"></div>
<div class="fixed bottom-0 right-0 w-72 h-72 bg-indigo-600/10 rounded-full blur-[120px] translate-y-1/2 translate-x-1/3 pointer-events-none z-0"></div>

<div class="relative z-10 w-full max-w-md mx-auto min-h-screen px-4 pt-6 pb-28 text-white font-sans">

    <!-- Top Bar -->
    <div class="flex items-center justify-between mb-4">
        <div class="flex items-center gap-3">
            <a href="{{ route('affiliate.dashboard') }}" wire:navigate class="w-10 h-10 rounded-full glass-panel flex items-center justify-center text-slate-300 hover:text-white transition-colors" title="Kembali ke Dashboard">
                <i class="fa-solid fa-arrow-left text-sm"></i>
            </a>
            <div>
                <h1 class="text-base font-bold text-white tracking-tight">Pusat Edukasi & AI Hub</h1>
                <p class="text-[11px] text-slate-400 font-medium">Strategi Closing & Marketing Kit</p>
            </div>
        </div>
        <div class="w-9 h-9 rounded-xl glass-panel flex items-center justify-center text-blue-400 text-sm">
            <i class="fa-solid fa-wand-magic-sparkles"></i>
        </div>
    </div>

    <!-- Target Benchmark Card -->
    <div class="glass-card-glow p-4 rounded-2xl mb-5 flex items-center justify-between">
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
            Rp 200.000 - 500.000/Deal
        </span>
    </div>

    <!-- Clean Scrollable Tab Switcher -->
    <div class="overflow-x-auto hide-scrollbar -mx-4 px-4 mb-6">
        <div class="flex gap-2 w-max pb-1">
            <button onclick="switchTab('roadmap')" id="tab-btn-roadmap" class="tab-btn active px-3.5 py-2 rounded-xl text-xs font-semibold flex items-center gap-2 shrink-0">
                <i class="fa-solid fa-compass text-xs"></i> Roadmap 1 Deal
            </button>
            <button onclick="switchTab('ai-studio')" id="tab-btn-ai-studio" class="tab-btn px-3.5 py-2 rounded-xl text-xs font-semibold flex items-center gap-2 shrink-0">
                <i class="fa-solid fa-wand-magic-sparkles text-xs"></i> AI Social Studio
            </button>
            <button onclick="switchTab('marketing-kit')" id="tab-btn-marketing-kit" class="tab-btn px-3.5 py-2 rounded-xl text-xs font-semibold flex items-center gap-2 shrink-0">
                <i class="fa-solid fa-images text-xs"></i> Marketing Kit & Banner
            </button>
            <button onclick="switchTab('categories')" id="tab-btn-categories" class="tab-btn px-3.5 py-2 rounded-xl text-xs font-semibold flex items-center gap-2 shrink-0">
                <i class="fa-solid fa-layer-group text-xs"></i> Target Kategori
            </button>
            <button onclick="switchTab('case-study')" id="tab-btn-case-study" class="tab-btn px-3.5 py-2 rounded-xl text-xs font-semibold flex items-center gap-2 shrink-0">
                <i class="fa-solid fa-briefcase text-xs"></i> Case Study Klien
            </button>
            <button onclick="switchTab('objection')" id="tab-btn-objection" class="tab-btn px-3.5 py-2 rounded-xl text-xs font-semibold flex items-center gap-2 shrink-0">
                <i class="fa-solid fa-shield-halved text-xs"></i> Penakluk Penolakan
            </button>
        </div>
    </div>

    <!-- Modular Tab Partials -->
    @include('affiliate.partials.guide.roadmap')
    @include('affiliate.partials.guide.ai_studio')
    @include('affiliate.partials.guide.marketing_kit')
    @include('affiliate.partials.guide.categories')
    @include('affiliate.partials.guide.case_studies')
    @include('affiliate.partials.guide.objection')


</div>

<!-- Hidden Canvas for Banner Generation -->
<canvas id="bannerCanvas" width="1080" height="1080" style="display:none;"></canvas>

<!-- Bottom Navigation -->
<x-affiliate.bottom-nav />

<x-affiliate.scripts />

<!-- Guide Javascript Logic -->
@include('affiliate.partials.guide.scripts')

@endsection
