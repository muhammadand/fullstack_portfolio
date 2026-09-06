@extends('layouts.app')

@section('meta_tags')
<title>Karir & Peluang Bergabung — Scalify Intelligence</title>
<meta name="title" content="Karir & Peluang Bergabung — Scalify Intelligence" />
<meta name="description" content="Temukan karir impian Anda di Scalify Intelligence. Bergabunglah bersama tim digital agency, developer, dan digital marketer profesional untuk membangun produk digital masa depan." />
<meta name="keywords" content="lowongan kerja IT, karir web developer, digital agency karir, magang IT, scalify intelligence careers, lowongan programmer" />
<meta name="author" content="Scalify Intelligence" />
<meta name="robots" content="index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1" />
<link rel="canonical" href="{{ route('landing.careers') }}" />

{{-- Open Graph / Facebook --}}
<meta property="og:type" content="website" />
<meta property="og:url" content="{{ route('landing.careers') }}" />
<meta property="og:title" content="Karir & Peluang Bergabung — Scalify Intelligence" />
<meta property="og:description" content="Temukan karir impian Anda di Scalify Intelligence. Bergabunglah bersama tim digital agency kami." />
<meta property="og:image" content="{{ asset('og-image.png') }}" />
<meta property="og:site_name" content="Scalify Intelligence" />
<meta property="og:locale" content="id_ID" />

{{-- Twitter --}}
<meta name="twitter:card" content="summary_large_image" />
<meta name="twitter:url" content="{{ route('landing.careers') }}" />
<meta name="twitter:title" content="Karir & Peluang Bergabung — Scalify Intelligence" />
<meta name="twitter:description" content="Temukan karir impian Anda di Scalify Intelligence. Bergabunglah bersama tim digital agency kami." />
<meta name="twitter:image" content="{{ asset('og-image.png') }}" />

{{-- Schema.org JSON-LD Structured Data for Careers --}}
@php
$careerSchemaItems = [];
foreach ($careers as $index => $c) {
$careerSchemaItems[] = [
'@type' => 'JobPosting',
'title' => $c->title,
'description' => strip_tags($c->description ?? $c->title),
'datePosted' => $c->created_at ? $c->created_at->toIso8601String() : now()->toIso8601String(),
'validThrough' => $c->closing_date ? \Carbon\Carbon::parse($c->closing_date)->toIso8601String() : now()->addMonths(3)->toIso8601String(),
'employmentType' => $c->employment_type ?? 'FULL_TIME',
'hiringOrganization' => [
'@type' => 'Organization',
'name' => 'Scalify Intelligence',
'sameAs' => 'https://scalifyintellegence.my.id',
'logo' => asset('scalify.png')
],
'jobLocation' => [
'@type' => 'Place',
'address' => [
'@type' => 'PostalAddress',
'addressLocality' => $c->location ?? 'Jakarta / Remote',
'addressCountry' => 'ID'
]
]
];
}
$careersCollection = [
'@context' => 'https://schema.org',
'@type' => 'CollectionPage',
'name' => 'Karir & Peluang Kerja — Scalify Intelligence',
'url' => route('landing.careers'),
'description' => 'Daftar lowongan kerja, magang, dan peluang kolaborasi di agency digital Scalify Intelligence.',
'mainEntity' => [
'@type' => 'ItemList',
'itemListElement' => $careerSchemaItems
]
];
@endphp
<script type="application/ld+json">
    {
        !!json_encode($careersCollection, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) !!
    }

</script>
@endsection

@section('content')
<div class="min-h-screen bg-brand-dark text-white relative overflow-hidden">
    {{-- Ambient Midnight Glow Background Effects --}}
    <div class="absolute top-0 left-1/2 -translate-x-1/2 w-full max-w-7xl h-[480px] bg-gradient-to-b from-brand-blue/15 via-indigo-600/10 to-transparent blur-3xl pointer-events-none"></div>
    <div class="absolute top-40 right-10 w-96 h-96 bg-brand-accent/10 rounded-full blur-[120px] pointer-events-none"></div>
    <div class="absolute bottom-20 left-10 w-80 h-80 bg-emerald-500/10 rounded-full blur-[100px] pointer-events-none"></div>

    <section class="relative z-20 pt-24 pb-20 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
        <div class="flex flex-col lg:flex-row gap-10 lg:gap-14 items-start">

            <!-- Bagian Kiri: Header & Filter/Search (Sticky di Desktop) -->
            <div class="lg:w-[38%] flex flex-col items-center lg:items-start text-center lg:text-left lg:sticky lg:top-28 w-full">
                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full border border-emerald-500/30 text-emerald-400 mb-4 bg-emerald-500/10 backdrop-blur-md shadow-sm">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                    <span class="font-bold text-[10px] tracking-widest uppercase">WE'RE HIRING & COLLABORATING</span>
                </div>

                <h1 class="font-display text-3xl sm:text-4xl lg:text-[2.6rem] font-extrabold text-white mb-3.5 leading-[1.15] tracking-tight">
                    Temukan Karir <br class="hidden lg:block">
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-brand-accent via-blue-400 to-indigo-300">Impianmu</span>
                </h1>

                <p class="text-white/70 leading-relaxed text-xs sm:text-sm mb-7 max-w-md">
                    Bergabunglah bersama kami di <b class="text-white">Scalify Intelligence</b> untuk membangun produk digital berkelas, website modern, dan sistem automasi cerdas yang berdampak nyata.
                </p>

                <!-- Form Pencarian (Glass Card) -->
                <div class="w-full bg-[#0F172A]/80 backdrop-blur-xl rounded-2xl p-4 sm:p-5 border border-white/10 shadow-2xl shadow-black/40">
                    <form action="{{ route('landing.careers') }}" method="GET" class="flex flex-col gap-3.5">
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-white/40">
                                <i class="fa-solid fa-magnifying-glass text-xs"></i>
                            </div>
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari posisi, bidang, atau lokasi..." class="w-full bg-white/5 border border-white/15 text-white placeholder-white/40 rounded-xl pl-9 pr-3.5 py-2.5 text-xs focus:outline-none focus:border-brand-accent focus:ring-2 focus:ring-brand-accent/20 transition-all">
                        </div>

                        <div class="flex items-center gap-2">
                            <button type="submit" class="flex-1 bg-btn-gradient hover:opacity-95 shadow-glow-sm text-white font-bold text-xs py-2.5 px-4 rounded-xl transition-all duration-300 flex items-center justify-center gap-1.5 cursor-pointer">
                                <span>Cari Lowongan</span>
                                <i class="fa-solid fa-arrow-right text-[10px]"></i>
                            </button>

                            @if(request('search'))
                            <a href="{{ route('landing.careers') }}" class="px-3 py-2.5 bg-white/5 hover:bg-white/10 border border-white/10 text-white/70 hover:text-white rounded-xl text-xs font-semibold transition-colors" title="Reset">
                                <i class="fa-solid fa-rotate-left"></i>
                            </a>
                            @endif
                        </div>
                    </form>
                </div>

                <!-- Info Box Tambahan -->
                <div class="mt-6 p-4 rounded-2xl bg-white/5 border border-white/5 text-left w-full hidden sm:block">
                    <div class="flex items-center gap-2.5 text-amber-400 font-bold text-xs mb-1">
                        <i class="fa-solid fa-handshake"></i>
                        <span>Ingin Jadi Partner Cuan?</span>
                    </div>
                    <p class="text-[11px] text-white/60 leading-relaxed mb-2.5">
                        Selain karir full-time, Anda juga bisa menghasilkan komisi jutaan per closing melalui program kemitraan kami.
                    </p>
                    <a href="{{ route('sobat-scalify') }}" class="text-[11px] font-bold text-amber-400 hover:text-amber-300 inline-flex items-center gap-1 transition-colors">
                        Pelajari Sobat Scalify <i class="fa-solid fa-arrow-right text-[9px]"></i>
                    </a>
                </div>
            </div>

            <!-- Bagian Kanan: List Lowongan -->
            <div class="lg:w-[62%] flex flex-col gap-4 sm:gap-5 w-full">
                @if(request('search'))
                <div class="flex items-center justify-between px-1">
                    <p class="text-xs text-white/70">
                        Hasil pencarian untuk "<span class="text-brand-accent font-semibold">{{ request('search') }}</span>" ({{ $careers->total() }} lowongan)
                    </p>
                    <a href="{{ route('landing.careers') }}" class="text-xs text-brand-accent hover:underline">Hapus Filter</a>
                </div>
                @endif

                @forelse($careers as $career)
                <!-- Kartu Lowongan (Glass Card) -->
                <div class="bg-[#0F172A]/70 backdrop-blur-xl border border-white/10 hover:border-brand-accent/40 text-white rounded-2xl sm:rounded-3xl p-5 sm:p-6 shadow-card hover:shadow-glow-blue hover:-translate-y-1 transition-all duration-300 flex flex-col group relative overflow-hidden">
                    <!-- Glow Indicator di Kiri -->
                    <div class="absolute left-0 top-0 bottom-0 w-1.5 bg-gradient-to-b from-brand-accent to-indigo-500 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>

                    <div class="flex flex-col md:flex-row gap-4 sm:gap-5 items-start md:items-center justify-between w-full">

                        {{-- Left: Details --}}
                        <div class="flex-1">
                            <div class="flex flex-wrap items-center gap-2 mb-2">
                                <h3 class="font-display font-bold text-lg sm:text-xl text-white group-hover:text-brand-accent transition-colors leading-snug">
                                    {{ $career->title }}
                                </h3>

                                @if($career->closing_date && \Carbon\Carbon::parse($career->closing_date)->isPast())
                                <span class="px-2.5 py-0.5 bg-red-500/20 text-red-300 border border-red-500/30 rounded-full text-[9px] font-bold tracking-widest uppercase">Ditutup</span>
                                @else
                                @if($career->closing_date && \Carbon\Carbon::parse($career->closing_date)->diffInDays(now()) <= 7) <span class="px-2.5 py-0.5 bg-amber-500/20 text-amber-300 border border-amber-500/30 rounded-full text-[9px] font-bold tracking-widest uppercase animate-pulse">Segera Berakhir</span>
                                    @else
                                    <span class="px-2.5 py-0.5 bg-emerald-500/20 text-emerald-300 border border-emerald-500/30 rounded-full text-[9px] font-bold tracking-widest uppercase">Dibuka</span>
                                    @endif
                                    @endif
                            </div>

                            <div class="flex flex-wrap gap-2.5 sm:gap-4 text-xs text-white/60 mt-3">
                                @if($career->location)
                                <div class="flex items-center gap-1.5 bg-white/5 px-2.5 py-1 rounded-lg border border-white/5">
                                    <i class="fa-solid fa-location-dot text-brand-accent text-[11px]"></i>
                                    <span>{{ $career->location }}</span>
                                </div>
                                @endif
                                @if($career->employment_type)
                                <div class="flex items-center gap-1.5 bg-white/5 px-2.5 py-1 rounded-lg border border-white/5">
                                    <i class="fa-solid fa-briefcase text-emerald-400 text-[11px]"></i>
                                    <span>{{ $career->employment_type }}</span>
                                </div>
                                @endif
                                @if($career->work_mode)
                                <div class="flex items-center gap-1.5 bg-white/5 px-2.5 py-1 rounded-lg border border-white/5">
                                    <i class="fa-solid fa-building-user text-purple-400 text-[11px]"></i>
                                    <span>{{ $career->work_mode }}</span>
                                </div>
                                @endif
                            </div>
                        </div>

                        {{-- Right: Actions & Salary --}}
                        <div class="w-full md:w-auto flex flex-row md:flex-col items-center md:items-end justify-between gap-3 mt-2 md:mt-0 pt-3 md:pt-0 border-t md:border-t-0 border-white/10 shrink-0">
                            <div class="text-left md:text-right">
                                <p class="text-[10px] font-bold tracking-wider uppercase text-white/40 mb-0.5">Estimasi Gaji</p>
                                <p class="text-xs sm:text-sm font-bold text-white">
                                    @if($career->salary_min && $career->salary_max)
                                    Rp {{ number_format($career->salary_min, 0, ',', '.') }} - Rp {{ number_format($career->salary_max, 0, ',', '.') }}
                                    @elseif($career->salary_min)
                                    Mulai Rp {{ number_format($career->salary_min, 0, ',', '.') }}
                                    @else
                                    Sesuai Kesepakatan
                                    @endif
                                </p>
                            </div>

                            <a href="{{ route('careers.read', $career->slug) }}" class="inline-flex items-center justify-center gap-1.5 px-4 sm:px-5 py-2 sm:py-2.5 bg-white/10 hover:bg-btn-gradient text-white rounded-xl text-xs font-bold transition-all duration-300 border border-white/15 hover:border-transparent shadow-sm">
                                <span>Lihat Detail</span>
                                <i class="fa-solid fa-arrow-right text-[10px] group-hover:translate-x-0.5 transition-transform"></i>
                            </a>
                        </div>

                    </div>
                </div>
                @empty
                <div class="text-center py-16 bg-[#0F172A]/70 backdrop-blur-xl rounded-3xl border border-white/10 border-dashed shadow-2xl p-6">
                    <div class="w-16 h-16 bg-white/5 rounded-2xl flex items-center justify-center mx-auto mb-4 text-white/40 border border-white/10">
                        <i class="fa-solid fa-magnifying-glass text-2xl"></i>
                    </div>
                    <h3 class="font-display text-lg font-bold text-white mb-2">Lowongan Tidak Ditemukan</h3>
                    <p class="text-white/60 text-xs sm:text-sm mb-6 max-w-sm mx-auto">
                        Maaf, saat ini belum ada posisi yang cocok dengan kata kunci tersebut. Coba cari dengan kata kunci lain.
                    </p>
                    <a href="{{ route('landing.careers') }}" class="inline-flex items-center gap-2 bg-white/10 hover:bg-white/20 text-white font-semibold text-xs px-5 py-2.5 rounded-full border border-white/15 transition-all">
                        <i class="fa-solid fa-rotate-left"></i> Reset Pencarian
                    </a>
                </div>
                @endforelse

                {{-- Pagination --}}
                @if($careers->hasPages())
                <div class="mt-8 pagination-dark">
                    {{ $careers->appends(['search' => request('search')])->links() }}
                </div>
                @endif
            </div>

        </div>
    </section>
</div>

<style>
    /* Styling overrides for tailwind pagination inside dark layout */
    .pagination-dark nav[role="navigation"] {
        background: transparent !important;
    }

    .pagination-dark nav[role="navigation"] p {
        color: rgba(255, 255, 255, 0.6) !important;
        font-size: 0.75rem !important;
    }

    .pagination-dark nav[role="navigation"] a {
        background-color: rgba(255, 255, 255, 0.05) !important;
        color: rgba(255, 255, 255, 0.8) !important;
        border-color: rgba(255, 255, 255, 0.1) !important;
        border-radius: 0.75rem !important;
        font-size: 0.75rem !important;
    }

    .pagination-dark nav[role="navigation"] a:hover {
        background-color: rgba(255, 255, 255, 0.15) !important;
        color: #ffffff !important;
        border-color: rgba(56, 189, 248, 0.4) !important;
    }

    .pagination-dark nav[role="navigation"] span[aria-current="page"] span {
        background: linear-gradient(135deg, #2563eb, #1d4ed8) !important;
        border-color: rgba(56, 189, 248, 0.4) !important;
        color: white !important;
        border-radius: 0.75rem !important;
        font-size: 0.75rem !important;
        font-weight: bold !important;
    }

</style>
@endsection
