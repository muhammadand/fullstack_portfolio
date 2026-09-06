@extends('layouts.app')

@section('meta_tags')
<title>{{ $career->title }} — Karir di Scalify Intelligence</title>
<meta name="title" content="{{ $career->title }} — Karir di Scalify Intelligence" />
<meta name="description" content="Lowongan {{ $career->title }} di Scalify Intelligence. {{ Str::limit(strip_tags($career->description), 150) }}" />
<meta name="keywords" content="{{ $career->title }}, lowongan kerja IT, karir scalify intelligence, digital agency karir" />
<meta name="author" content="Scalify Intelligence" />
<meta name="robots" content="index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1" />
<link rel="canonical" href="{{ url()->current() }}" />

{{-- Open Graph / Facebook --}}
<meta property="og:type" content="article" />
<meta property="og:url" content="{{ url()->current() }}" />
<meta property="og:title" content="{{ $career->title }} — Karir di Scalify Intelligence" />
<meta property="og:description" content="Lowongan {{ $career->title }} di Scalify Intelligence. {{ Str::limit(strip_tags($career->description), 150) }}" />
<meta property="og:image" content="{{ $career->featured_image ? asset('storage/' . $career->featured_image) : asset('og-image.png') }}" />
<meta property="og:site_name" content="Scalify Intelligence" />
<meta property="og:locale" content="id_ID" />

{{-- Twitter --}}
<meta name="twitter:card" content="summary_large_image" />
<meta name="twitter:url" content="{{ url()->current() }}" />
<meta name="twitter:title" content="{{ $career->title }} — Karir di Scalify Intelligence" />
<meta name="twitter:description" content="Lowongan {{ $career->title }} di Scalify Intelligence. {{ Str::limit(strip_tags($career->description), 150) }}" />
<meta name="twitter:image" content="{{ $career->featured_image ? asset('storage/' . $career->featured_image) : asset('og-image.png') }}" />

{{-- Schema.org JSON-LD Structured Data for JobPosting --}}
@php
$jobSchema = [
'@context' => 'https://schema.org',
'@type' => 'JobPosting',
'title' => $career->title,
'description' => strip_tags($career->description ?? $career->title),
'datePosted' => $career->created_at ? $career->created_at->toIso8601String() : now()->toIso8601String(),
'validThrough' => $career->closing_date ? \Carbon\Carbon::parse($career->closing_date)->toIso8601String() : now()->addMonths(3)->toIso8601String(),
'employmentType' => $career->employment_type ?? 'FULL_TIME',
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
'addressLocality' => $career->location ?? 'Jakarta / Remote',
'addressCountry' => 'ID'
]
]
];
if ($career->salary_min) {
$jobSchema['baseSalary'] = [
'@type' => 'MonetaryAmount',
'currency' => 'IDR',
'value' => [
'@type' => 'QuantitativeValue',
'minValue' => $career->salary_min,
'maxValue' => $career->salary_max ?? $career->salary_min,
'unitText' => 'MONTH'
]
];
}
@endphp
<script type="application/ld+json">
    {
        !!json_encode($jobSchema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) !!
    }

</script>
@endsection

@section('content')
<div class="min-h-screen bg-brand-dark text-white pt-24 md:pt-28 pb-32 relative overflow-hidden">
    {{-- Ambient Background Glows --}}
    <div class="absolute top-0 left-1/2 -translate-x-1/2 w-full max-w-7xl h-[450px] bg-gradient-to-b from-brand-blue/15 via-brand-indigo/10 to-transparent blur-3xl pointer-events-none"></div>
    <div class="absolute top-40 right-10 w-96 h-96 bg-brand-accent/10 rounded-full blur-[120px] pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <!-- Breadcrumb -->
        <div class="mb-8 flex items-center gap-3">
            <a href="{{ route('landing.careers') }}" class="text-sm font-semibold text-white/60 hover:text-white transition-colors inline-flex items-center gap-2">
                <i class="fas fa-arrow-left"></i> Kembali ke Karir
            </a>
            <span class="text-white/30">/</span>
            <span class="px-3 py-1 bg-white/5 border border-white/10 text-brand-accent rounded-full text-[10px] font-bold tracking-widest uppercase">
                Lowongan Karir
            </span>
        </div>

        <!-- Alert Success -->
        @if (session('success'))
        <div class="mb-8 p-4 rounded-2xl bg-emerald-500/15 border border-emerald-500/30 flex items-center gap-3 shadow-lg">
            <div class="w-8 h-8 rounded-full bg-emerald-500/20 text-emerald-400 flex items-center justify-center shrink-0">
                <i class="fa-solid fa-check text-sm"></i>
            </div>
            <div>
                <h4 class="text-sm font-bold text-white">Berhasil Dikirim!</h4>
                <p class="text-xs text-emerald-300">{{ session('success') }}</p>
            </div>
            <button onclick="this.parentElement.remove()" class="ml-auto text-emerald-300 hover:text-white transition">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
        @endif

        <div class="grid lg:grid-cols-12 gap-8 lg:gap-12">
            <!-- Main Content (Matching Blog Read Layout) -->
            <div class="lg:col-span-8 min-w-0">
                <article class="bg-brand-dark md:bg-brand-navy border border-transparent md:border-white/10 md:rounded-3xl md:shadow-xl overflow-visible md:overflow-hidden relative">

                    <!-- Featured Image / Banner -->
                    @if ($career->featured_image)
                    <div class="aspect-video w-screen relative left-1/2 -translate-x-1/2 md:w-full md:static md:translate-x-0 overflow-hidden md:rounded-t-3xl bg-white/5">
                        <img src="{{ asset('storage/' . $career->featured_image) }}" alt="{{ $career->title }}" class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-gradient-to-t from-brand-dark via-transparent to-transparent md:from-[#0f172a]/30"></div>
                    </div>
                    @endif

                    <div class="pt-6 pb-12 md:p-12 min-w-0">
                        <!-- Title -->
                        <h1 class="text-[22px] md:text-3xl lg:text-4xl font-display font-bold text-white mb-6 leading-[1.25] break-words">
                            {{ $career->title }}
                        </h1>

                        <!-- Author & Meta (Like Blog Read) -->
                        <div class="flex items-center justify-between flex-wrap gap-4 pb-6 border-b border-white/5 mb-8">
                            <div class="flex items-center gap-3 min-w-0">
                                <div class="w-10 h-10 rounded-full bg-brand-accent flex items-center justify-center text-white font-bold text-sm shadow-md flex-shrink-0">
                                    <i class="fa-solid fa-building text-xs"></i>
                                </div>
                                <div class="min-w-0 flex flex-col justify-center">
                                    <p class="font-semibold text-white/90 text-[13px] leading-tight truncate">
                                        Scalify Intelligence &bull; HR Team
                                    </p>
                                    <p class="text-[11px] text-white/50 font-medium leading-tight truncate mt-0.5">
                                        Diposting {{ $career->created_at->format('d M Y') }} &bull; {{ $career->employment_type ?? 'Full-Time' }}
                                    </p>
                                </div>
                            </div>

                            <!-- Share Buttons -->
                            <div class="flex items-center gap-2 flex-shrink-0">
                                <button onclick="sharePost(this)" data-title="{{ $career->title }}" data-text="{{ Str::limit(strip_tags($career->description), 100) }}" data-url="{{ url()->current() }}" class="w-8 h-8 flex-shrink-0 flex items-center justify-center bg-white/5 text-white/70 hover:bg-brand-accent hover:text-white rounded-full transition-all shadow-sm text-xs cursor-pointer" title="Share Link">
                                    <i class="fas fa-share-nodes"></i>
                                </button>
                                <a href="https://wa.me/?text={{ urlencode('Lowongan ' . $career->title . ' di Scalify Intelligence: ' . url()->current()) }}" target="_blank" class="w-8 h-8 flex-shrink-0 flex items-center justify-center bg-white/5 text-emerald-400 hover:bg-emerald-500 hover:text-white rounded-full transition-all shadow-sm text-xs" title="Share ke WhatsApp">
                                    <i class="fab fa-whatsapp"></i>
                                </a>
                                <a href="https://t.me/share/url?url={{ urlencode(url()->current()) }}&text={{ urlencode($career->title) }}" target="_blank" class="w-8 h-8 flex-shrink-0 flex items-center justify-center bg-white/5 text-[#229ED9] hover:bg-[#229ED9] hover:text-white rounded-full transition-all shadow-sm text-xs" title="Share to Telegram">
                                    <i class="fab fa-telegram-plane"></i>
                                </a>
                            </div>
                        </div>

                        <!-- Highlights Pills -->
                        <div class="flex flex-wrap gap-2.5 mb-8">
                            @if($career->location)
                            <span class="px-3.5 py-1.5 bg-white/5 border border-white/10 text-slate-300 rounded-xl text-xs font-medium flex items-center gap-1.5">
                                <i class="fa-solid fa-location-dot text-brand-accent"></i> {{ $career->location }}
                            </span>
                            @endif
                            @if($career->employment_type)
                            <span class="px-3.5 py-1.5 bg-white/5 border border-white/10 text-emerald-300 rounded-xl text-xs font-medium flex items-center gap-1.5">
                                <i class="fa-solid fa-briefcase text-emerald-400"></i> {{ $career->employment_type }}
                            </span>
                            @endif
                            @if($career->work_mode)
                            <span class="px-3.5 py-1.5 bg-white/5 border border-white/10 text-purple-300 rounded-xl text-xs font-medium flex items-center gap-1.5">
                                <i class="fa-solid fa-building-user text-purple-400"></i> {{ $career->work_mode }}
                            </span>
                            @endif
                        </div>

                        <!-- Job Description Excerpt Box -->
                        @if ($career->description)
                        <div class="text-white/80 text-sm md:text-base leading-relaxed mb-8 font-medium italic border-l-4 border-brand-accent pl-6 bg-white/5 py-5 pr-5 rounded-r-xl">
                            <p class="not-italic font-bold text-xs uppercase tracking-wider text-brand-accent mb-2 flex items-center gap-2">
                                <i class="fa-solid fa-circle-info"></i> Ringkasan Peran & Tanggung Jawab:
                            </p>
                            <p class="whitespace-pre-wrap">{{ $career->description }}</p>
                        </div>
                        @endif

                        <!-- Qualifications / Full Quill Content -->
                        <div class="mt-8">
                            <h2 class="text-xl md:text-2xl font-display font-bold text-white mb-6 border-b border-white/10 pb-3 flex items-center gap-2.5">
                                <span class="w-2 h-6 bg-brand-accent rounded-full"></span>
                                Kualifikasi & Kebutuhan Posisi
                            </h2>

                            <div class="quill-content max-w-none">
                                {!! $career->qualifications ?: '<p>Tidak ada kualifikasi khusus yang dicantumkan.</p>' !!}
                            </div>
                        </div>

                        <!-- Mobile CTA Button -->
                        <div class="mt-10 pt-6 border-t border-white/10 lg:hidden">
                            <button onclick="document.getElementById('applyModal').classList.remove('hidden')" class="flex items-center justify-center gap-2 w-full bg-btn-gradient hover:opacity-95 shadow-glow-sm text-white font-bold px-6 py-3.5 rounded-2xl transition-all text-sm cursor-pointer">
                                <i class="fa-solid fa-paper-plane"></i> Lamar Posisi Ini Sekarang
                            </button>
                        </div>

                    </div>
                </article>
            </div>

            <!-- Sidebar (Sticky Widget Like Blog Read Sidebar) -->
            <aside class="lg:col-span-4 space-y-6">
                <div class="lg:sticky lg:top-28 space-y-6">

                    <!-- Widget Ringkasan Lowongan -->
                    <div class="bg-brand-dark md:bg-brand-navy border border-white/10 rounded-3xl p-6 sm:p-7 shadow-xl">
                        <h3 class="text-base font-display font-bold text-white mb-5 flex items-center gap-2">
                            <span class="w-1.5 h-4 bg-brand-accent rounded-full"></span>
                            Ringkasan Pekerjaan
                        </h3>

                        <div class="space-y-4 mb-6">
                            <div class="flex items-start gap-3.5 p-3 rounded-2xl bg-white/5 border border-white/5">
                                <div class="w-9 h-9 rounded-xl bg-blue-500/20 text-blue-400 flex items-center justify-center shrink-0 border border-blue-500/30">
                                    <i class="fa-solid fa-money-bill-wave text-xs"></i>
                                </div>
                                <div>
                                    <p class="text-[10px] font-bold tracking-wider uppercase text-white/40 mb-0.5">Estimasi Gaji</p>
                                    <p class="text-xs sm:text-sm font-bold text-white leading-tight">
                                        @if($career->salary_min && $career->salary_max)
                                        Rp {{ number_format($career->salary_min, 0, ',', '.') }} - Rp {{ number_format($career->salary_max, 0, ',', '.') }}
                                        @elseif($career->salary_min)
                                        Mulai Rp {{ number_format($career->salary_min, 0, ',', '.') }}
                                        @else
                                        Sesuai Kesepakatan
                                        @endif
                                    </p>
                                </div>
                            </div>

                            <div class="flex items-start gap-3.5 p-3 rounded-2xl bg-white/5 border border-white/5">
                                <div class="w-9 h-9 rounded-xl bg-amber-500/20 text-amber-400 flex items-center justify-center shrink-0 border border-amber-500/30">
                                    <i class="fa-regular fa-calendar-xmark text-xs"></i>
                                </div>
                                <div>
                                    <p class="text-[10px] font-bold tracking-wider uppercase text-white/40 mb-0.5">Batas Lamaran</p>
                                    <p class="text-xs sm:text-sm font-semibold text-white leading-tight">
                                        {{ $career->closing_date ? \Carbon\Carbon::parse($career->closing_date)->format('d M Y') : 'Terbuka Hingga Terisi' }}
                                    </p>
                                </div>
                            </div>

                            <div class="flex items-start gap-3.5 p-3 rounded-2xl bg-white/5 border border-white/5">
                                <div class="w-9 h-9 rounded-xl bg-emerald-500/20 text-emerald-400 flex items-center justify-center shrink-0 border border-emerald-500/30">
                                    <i class="fa-regular fa-calendar-check text-xs"></i>
                                </div>
                                <div>
                                    <p class="text-[10px] font-bold tracking-wider uppercase text-white/40 mb-0.5">Diposting Pada</p>
                                    <p class="text-xs sm:text-sm font-semibold text-white leading-tight">
                                        {{ $career->created_at->format('d M Y') }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <button onclick="document.getElementById('applyModal').classList.remove('hidden')" class="flex items-center justify-center gap-2 w-full bg-btn-gradient hover:opacity-95 shadow-glow-sm hover:shadow-glow-blue text-white font-bold px-5 py-3 rounded-xl transition-all duration-300 hover:-translate-y-0.5 text-xs sm:text-sm cursor-pointer">
                            <i class="fa-solid fa-paper-plane text-sm"></i>
                            <span>Lamar Posisi Ini</span>
                        </button>
                    </div>

                    <!-- Widget Agency / Partnership CTA -->
                    <div class="bg-gradient-to-br from-blue-900/40 to-slate-900/60 border border-white/10 rounded-3xl p-6 shadow-xl relative overflow-hidden">
                        <div class="flex items-center gap-3 mb-3">
                            <div class="w-8 h-8 rounded-lg bg-amber-500/20 border border-amber-500/30 flex items-center justify-center text-amber-400">
                                <i class="fa-solid fa-handshake text-xs"></i>
                            </div>
                            <h4 class="font-bold text-white text-sm">Program Sobat Scalify</h4>
                        </div>
                        <p class="text-white/60 text-xs leading-relaxed mb-4">
                            Ingin mendapatkan penghasilan tambahan tanpa terikat jam kerja? Bergabunglah sebagai affiliate partner kami.
                        </p>
                        <a href="{{ route('sobat-scalify') }}" class="text-xs font-bold text-amber-400 hover:text-amber-300 inline-flex items-center gap-1.5 transition-colors">
                            <span>Gabung Partner Cuan</span>
                            <i class="fa-solid fa-arrow-right text-[10px]"></i>
                        </a>
                    </div>

                </div>
            </aside>
        </div>

        <!-- Related Careers (Matching Related Blogs Cards) -->
        @if ($otherCareers->count() > 0)
        <div class="mt-20 pt-12 border-t border-white/10">
            <div class="flex items-center justify-between mb-8">
                <div>
                    <span class="text-brand-accent font-bold text-xs tracking-widest uppercase">Eksplorasi Karir</span>
                    <h2 class="text-xl md:text-2xl font-display font-bold text-white mt-1">
                        Lowongan Lainnya di <span class="text-brand-accent">Scalify Intelligence</span>
                    </h2>
                </div>
                <a href="{{ route('landing.careers') }}" class="text-xs font-semibold text-brand-accent hover:underline hidden sm:inline-flex items-center gap-1.5">
                    <span>Lihat Semua Lowongan</span>
                    <i class="fas fa-arrow-right text-[10px]"></i>
                </a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($otherCareers as $item)
                <div class="bg-brand-navy/60 backdrop-blur-xl border border-white/10 hover:border-brand-accent/40 rounded-2xl sm:rounded-3xl p-5 shadow-card hover:shadow-glow-blue hover:-translate-y-1 transition-all duration-300 flex flex-col group relative overflow-hidden">
                    <div class="flex items-center gap-2 mb-3">
                        @if($item->employment_type)
                        <span class="px-2.5 py-0.5 bg-emerald-500/20 text-emerald-300 border border-emerald-500/30 rounded-full text-[9px] font-bold tracking-widest uppercase">
                            {{ $item->employment_type }}
                        </span>
                        @endif
                        <span class="text-[11px] text-white/40 font-medium">
                            {{ $item->created_at->format('d M Y') }}
                        </span>
                    </div>

                    <h3 class="font-display text-base font-bold mb-3 text-white group-hover:text-brand-accent transition-colors leading-snug">
                        {{ $item->title }}
                    </h3>

                    <div class="text-slate-400 text-xs mb-5 flex-1 flex flex-col gap-1.5">
                        @if($item->location)
                        <div class="flex items-center gap-1.5"><i class="fa-solid fa-location-dot text-brand-accent text-[11px]"></i> {{ $item->location }}</div>
                        @endif
                        @if($item->salary_min)
                        <div class="flex items-center gap-1.5"><i class="fa-solid fa-money-bill-wave text-emerald-400 text-[11px]"></i> Mulai Rp {{ number_format($item->salary_min, 0, ',', '.') }}</div>
                        @endif
                    </div>

                    <a href="{{ route('careers.read', $item->slug) }}" class="text-xs font-bold text-white/80 group-hover:text-brand-accent inline-flex items-center gap-1.5 transition-colors mt-auto tracking-wider uppercase">
                        <span>Lihat Detail Lowongan</span>
                        <i class="fas fa-arrow-right text-[10px] group-hover:translate-x-1 transition-transform"></i>
                    </a>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</div>

<!-- Apply Modal (Dark Glassmorphism Modal) -->
<div id="applyModal" class="fixed inset-0 z-[100] hidden bg-black/75 backdrop-blur-md flex items-center justify-center overflow-y-auto py-10 px-4">
    <div class="bg-[#0B1120] border border-white/15 rounded-3xl shadow-2xl w-full max-w-2xl mx-auto my-auto relative flex flex-col max-h-[90vh] text-white">
        <!-- Modal Header -->
        <div class="flex items-center justify-between p-5 md:p-6 border-b border-white/10 shrink-0">
            <div>
                <span class="text-[10px] font-bold text-brand-accent uppercase tracking-widest">Form Lamaran Kerja</span>
                <h3 class="text-lg md:text-xl font-bold text-white mt-0.5">Lamar: <span class="text-brand-accent">{{ $career->title }}</span></h3>
            </div>
            <button type="button" onclick="document.getElementById('applyModal').classList.add('hidden')" class="w-8 h-8 rounded-full bg-white/5 hover:bg-white/10 text-white/60 hover:text-white flex items-center justify-center transition-colors">
                <i class="fa-solid fa-xmark text-lg"></i>
            </button>
        </div>

        <!-- Modal Body -->
        <div class="p-5 md:p-6 overflow-y-auto">
            <form action="{{ route('career-applications.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                <input type="hidden" name="career_id" value="{{ $career->id }}">

                <!-- Full Name -->
                <div>
                    <label for="full_name" class="block text-xs font-semibold text-slate-300 mb-1.5">
                        Nama Lengkap <span class="text-red-400">*</span>
                    </label>
                    <input type="text" name="full_name" id="full_name" required placeholder="Contoh: Budi Santoso" class="w-full bg-white/5 border border-white/15 text-white placeholder-white/40 px-4 py-2.5 rounded-xl text-xs sm:text-sm focus:outline-none focus:border-brand-accent focus:ring-2 focus:ring-brand-accent/20 transition-all">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-xs font-semibold text-slate-300 mb-1.5">Email <span class="text-red-400">*</span></label>
                        <input type="email" name="email" id="email" required placeholder="nama@email.com" class="w-full bg-white/5 border border-white/15 text-white placeholder-white/40 px-4 py-2.5 rounded-xl text-xs sm:text-sm focus:outline-none focus:border-brand-accent focus:ring-2 focus:ring-brand-accent/20 transition-all">
                    </div>
                    <!-- Phone -->
                    <div>
                        <label for="phone" class="block text-xs font-semibold text-slate-300 mb-1.5">No. WhatsApp <span class="text-red-400">*</span></label>
                        <input type="text" name="phone" id="phone" required placeholder="081234567890" class="w-full bg-white/5 border border-white/15 text-white placeholder-white/40 px-4 py-2.5 rounded-xl text-xs sm:text-sm focus:outline-none focus:border-brand-accent focus:ring-2 focus:ring-brand-accent/20 transition-all">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Portfolio -->
                    <div>
                        <label for="portfolio_url" class="block text-xs font-semibold text-slate-300 mb-1.5">Link Portofolio / GitHub (URL)</label>
                        <input type="url" name="portfolio_url" id="portfolio_url" placeholder="https://github.com/..." class="w-full bg-white/5 border border-white/15 text-white placeholder-white/40 px-4 py-2.5 rounded-xl text-xs sm:text-sm focus:outline-none focus:border-brand-accent focus:ring-2 focus:ring-brand-accent/20 transition-all">
                    </div>
                    <!-- LinkedIn -->
                    <div>
                        <label for="linkedin_url" class="block text-xs font-semibold text-slate-300 mb-1.5">Link LinkedIn (URL)</label>
                        <input type="url" name="linkedin_url" id="linkedin_url" placeholder="https://linkedin.com/in/..." class="w-full bg-white/5 border border-white/15 text-white placeholder-white/40 px-4 py-2.5 rounded-xl text-xs sm:text-sm focus:outline-none focus:border-brand-accent focus:ring-2 focus:ring-brand-accent/20 transition-all">
                    </div>
                </div>

                <!-- Resume -->
                <div>
                    <label for="resume" class="block text-xs font-semibold text-slate-300 mb-1.5">Upload CV / Resume (PDF) <span class="text-red-400">*</span></label>
                    <input type="file" name="resume" id="resume" accept=".pdf,.doc,.docx" required class="block w-full text-xs text-slate-300 file:mr-3 file:py-2 file:px-3.5 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-brand-accent/20 file:text-brand-accent hover:file:bg-brand-accent/30 bg-white/5 border border-white/15 rounded-xl p-2 cursor-pointer">
                </div>

                <!-- Cover Letter -->
                <div>
                    <label for="cover_letter" class="block text-xs font-semibold text-slate-300 mb-1.5">Pesan Tambahan / Cover Letter Singkat</label>
                    <textarea name="cover_letter" id="cover_letter" rows="3" placeholder="Ceritakan singkat motivasi & keahlian terbaik Anda..." class="w-full bg-white/5 border border-white/15 text-white placeholder-white/40 px-4 py-2.5 rounded-xl text-xs sm:text-sm focus:outline-none focus:border-brand-accent focus:ring-2 focus:ring-brand-accent/20 transition-all"></textarea>
                </div>

                <!-- Footer / Actions -->
                <div class="flex justify-end gap-3 pt-3 border-t border-white/10">
                    <button type="button" onclick="document.getElementById('applyModal').classList.add('hidden')" class="px-5 py-2.5 bg-white/5 hover:bg-white/10 border border-white/10 text-slate-300 rounded-xl text-xs font-semibold transition cursor-pointer">Batal</button>
                    <button type="submit" class="px-6 py-2.5 bg-btn-gradient text-white rounded-xl text-xs font-bold shadow-glow-sm hover:opacity-95 transition flex items-center gap-2 cursor-pointer">
                        <i class="fa-solid fa-paper-plane text-xs"></i>
                        <span>Kirim Lamaran Sekarang</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    /* ═══ Quill Content Renderer (Matching Blog Read) ═══════════════════════════════════ */
    .quill-content {
        font-size: 16px;
        line-height: 1.85;
        color: rgba(255, 255, 255, 0.85);
        font-weight: 400;
        overflow-wrap: anywhere;
        word-break: break-word;
    }

    /* Headings */
    .quill-content h1 {
        font-size: 1.85rem;
        font-weight: 700;
        color: #ffffff;
        margin: 1.5rem 0 0.75rem;
    }

    .quill-content h2 {
        font-size: 1.45rem;
        font-weight: 700;
        color: #ffffff;
        margin: 1.5rem 0 0.75rem;
        border-bottom: 2px solid rgba(255, 255, 255, 0.1);
        padding-bottom: 0.4rem;
    }

    .quill-content h3 {
        font-size: 1.2rem;
        font-weight: 600;
        color: #38bdf8;
        margin: 1.25rem 0 0.5rem;
    }

    .quill-content h4,
    .quill-content h5,
    .quill-content h6 {
        font-size: 1rem;
        font-weight: 600;
        color: rgba(255, 255, 255, 0.75);
        margin: 1rem 0 0.4rem;
    }

    /* Paragraphs */
    .quill-content p {
        margin-bottom: 1rem;
    }

    .quill-content p:last-child {
        margin-bottom: 0;
    }

    /* Bold / Italic / Underline / Strike */
    .quill-content strong {
        font-weight: 700;
        color: #ffffff;
    }

    .quill-content em {
        font-style: italic;
    }

    .quill-content u {
        text-decoration: underline;
    }

    .quill-content s {
        text-decoration: line-through;
    }

    /* Links */
    .quill-content a {
        color: #38bdf8;
        text-decoration: underline;
        transition: color .2s;
    }

    .quill-content a:hover {
        color: #7dd3fc;
    }

    /* Images */
    .quill-content img {
        max-width: 100%;
        height: auto;
        border-radius: 14px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
        margin: 1rem 0;
        display: block;
    }

    /* Lists */
    .quill-content ul {
        list-style: disc;
        padding-left: 1.75rem;
        margin-bottom: 1rem;
    }

    .quill-content ol {
        list-style: decimal;
        padding-left: 1.75rem;
        margin-bottom: 1rem;
    }

    .quill-content li {
        margin-bottom: 0.35rem;
        color: rgba(255, 255, 255, 0.75);
    }

    /* Blockquote */
    .quill-content blockquote {
        border-left: 4px solid #38bdf8;
        background: rgba(255, 255, 255, 0.05);
        color: rgba(255, 255, 255, 0.75);
        padding: 1rem 1.25rem;
        border-radius: 0 8px 8px 0;
        margin: 1.25rem 0;
        font-style: italic;
    }

    /* Code */
    .quill-content code {
        background: rgba(255, 255, 255, 0.1);
        color: #38bdf8;
        padding: 0.15rem 0.45rem;
        border-radius: 4px;
        font-size: 0.875em;
        font-family: monospace;
    }

    .quill-content pre.ql-syntax {
        background: #080d1a;
        color: #e2e8f0;
        padding: 1rem 1.25rem;
        border-radius: 12px;
        overflow-x: auto;
        font-size: 0.875em;
        line-height: 1.7;
        margin: 1.25rem 0;
        border: 1px solid rgba(255, 255, 255, 0.1);
    }

    /* Table */
    .quill-content table {
        width: 100%;
        border-collapse: collapse;
        margin: 1.25rem 0;
    }

    .quill-content table th {
        background: rgba(255, 255, 255, 0.05);
        color: #ffffff;
        font-weight: 600;
        padding: 0.75rem 1rem;
        border: 1px solid rgba(255, 255, 255, 0.1);
        text-align: left;
    }

    .quill-content table td {
        padding: 0.65rem 1rem;
        border: 1px solid rgba(255, 255, 255, 0.1);
        color: rgba(255, 255, 255, 0.75);
    }

</style>

<script>
    function sharePost(btn) {
        const title = btn.getAttribute('data-title');
        const text = btn.getAttribute('data-text');
        const url = btn.getAttribute('data-url');

        if (navigator.share) {
            navigator.share({
                title: title
                , text: text
                , url: url
            }).catch((error) => console.log('Error sharing', error));
        } else {
            navigator.clipboard.writeText(url).then(() => {
                alert('Link lowongan berhasil disalin ke clipboard!');
            }).catch(() => {
                alert('Gagal menyalin link.');
            });
        }
    }

</script>
@endsection
