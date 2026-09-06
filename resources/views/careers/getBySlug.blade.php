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
<meta property="og:image" content="{{ asset('og-image.png') }}" />
<meta property="og:site_name" content="Scalify Intelligence" />
<meta property="og:locale" content="id_ID" />

{{-- Twitter --}}
<meta name="twitter:card" content="summary_large_image" />
<meta name="twitter:url" content="{{ url()->current() }}" />
<meta name="twitter:title" content="{{ $career->title }} — Karir di Scalify Intelligence" />
<meta name="twitter:description" content="Lowongan {{ $career->title }} di Scalify Intelligence. {{ Str::limit(strip_tags($career->description), 150) }}" />
<meta name="twitter:image" content="{{ asset('og-image.png') }}" />

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
<div class="min-h-screen bg-brand-dark text-white relative overflow-hidden pt-24 pb-16">
    {{-- Ambient Background Glows --}}
    <div class="absolute top-0 left-1/2 -translate-x-1/2 w-full max-w-7xl h-[400px] bg-gradient-to-b from-brand-blue/15 via-indigo-600/10 to-transparent blur-3xl pointer-events-none"></div>
    <div class="absolute top-40 right-10 w-96 h-96 bg-brand-accent/10 rounded-full blur-[120px] pointer-events-none"></div>
    <div class="absolute bottom-20 left-10 w-80 h-80 bg-emerald-500/10 rounded-full blur-[100px] pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <!-- Breadcrumb -->
        <div class="mb-8 flex items-center gap-3">
            <a href="{{ route('landing.careers') }}" class="text-xs font-semibold text-white/60 hover:text-brand-accent transition-colors inline-flex items-center gap-2">
                <i class="fas fa-arrow-left text-[11px]"></i> Kembali ke Daftar Karir
            </a>
            <span class="text-white/20">/</span>
            <span class="px-2.5 py-0.5 bg-brand-accent/15 text-brand-accent border border-brand-accent/30 rounded-full text-[9px] font-bold tracking-widest uppercase">
                Lowongan Karir
            </span>
        </div>

        <!-- Alert Success -->
        @if (session('success'))
        <div class="mb-6 p-4 rounded-2xl bg-emerald-500/15 border border-emerald-500/30 flex items-center gap-3 shadow-lg">
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

        <div class="grid lg:grid-cols-12 gap-6 lg:gap-8 items-start">
            <!-- Main Content (Article) -->
            <div class="lg:col-span-8">
                <article class="bg-[#0F172A]/70 backdrop-blur-xl border border-white/10 rounded-3xl p-6 sm:p-8 md:p-10 shadow-2xl">
                    <!-- Title -->
                    <h1 class="text-2xl sm:text-3xl md:text-4xl font-display font-extrabold text-white mb-4 leading-tight">
                        {{ $career->title }}
                    </h1>

                    <!-- Meta (Location, Type, Mode, Share) -->
                    <div class="flex items-center justify-between flex-wrap gap-4 pb-6 border-b border-white/10 mb-6">
                        <div class="flex flex-wrap gap-2 sm:gap-2.5">
                            @if($career->location)
                            <span class="px-3 py-1 bg-white/5 text-slate-300 rounded-xl text-xs font-medium border border-white/10 flex items-center gap-1.5">
                                <i class="fa-solid fa-location-dot text-brand-accent"></i> {{ $career->location }}
                            </span>
                            @endif
                            @if($career->employment_type)
                            <span class="px-3 py-1 bg-white/5 text-slate-300 rounded-xl text-xs font-medium border border-white/10 flex items-center gap-1.5">
                                <i class="fa-solid fa-briefcase text-emerald-400"></i> {{ $career->employment_type }}
                            </span>
                            @endif
                            @if($career->work_mode)
                            <span class="px-3 py-1 bg-white/5 text-slate-300 rounded-xl text-xs font-medium border border-white/10 flex items-center gap-1.5">
                                <i class="fa-solid fa-building-user text-purple-400"></i> {{ $career->work_mode }}
                            </span>
                            @endif
                        </div>

                        <!-- Share Button -->
                        <div class="flex items-center gap-2">
                            <button onclick="sharePost(this)" data-title="{{ $career->title }}" data-text="{{ Str::limit($career->description, 100) }}" data-url="{{ url()->current() }}" class="w-9 h-9 flex items-center justify-center bg-white/5 text-white/70 hover:bg-brand-accent hover:text-black rounded-xl border border-white/10 transition-all shadow-sm text-xs cursor-pointer" title="Bagikan Lowongan">
                                <i class="fas fa-share-nodes"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Job Description Box -->
                    @if ($career->description)
                    <div class="mb-8 border-l-4 border-brand-accent pl-5 bg-white/5 py-4 pr-5 rounded-r-2xl">
                        <h3 class="font-display font-bold text-white mb-2 text-sm uppercase tracking-wider flex items-center gap-2">
                            <i class="fa-solid fa-circle-info text-brand-accent text-xs"></i> Deskripsi Pekerjaan
                        </h3>
                        <p class="text-slate-300 text-xs sm:text-sm leading-relaxed whitespace-pre-wrap">{{ $career->description }}</p>
                    </div>
                    @endif

                    <!-- Qualifications WYSIWYG -->
                    <div>
                        <h3 class="text-lg sm:text-xl font-display font-bold text-white mb-4 flex items-center gap-2">
                            <span class="w-1.5 h-5 bg-gradient-to-b from-brand-accent to-indigo-500 rounded-full"></span>
                            Kualifikasi & Persyaratan
                        </h3>
                        <div class="quill-dark-content max-w-none">
                            {!! $career->qualifications ?: '<p class="text-slate-400">Tidak ada kualifikasi khusus yang dicantumkan.</p>' !!}
                        </div>
                    </div>
                </article>
            </div>

            <!-- Sidebar (Sticky Summary Widget) -->
            <aside class="lg:col-span-4">
                <div class="lg:sticky lg:top-28 space-y-6">
                    <!-- Ringkasan Pekerjaan Widget -->
                    <div class="bg-[#0F172A]/80 backdrop-blur-xl border border-white/10 rounded-3xl p-6 sm:p-7 shadow-2xl">
                        <h3 class="text-base font-display font-bold text-white mb-5 flex items-center gap-2">
                            <span class="w-1.5 h-4 bg-brand-accent rounded-full"></span>
                            Ringkasan Lowongan
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
                </div>
            </aside>
        </div>

        <!-- More Careers Section -->
        @if ($otherCareers->count() > 0)
        <div class="mt-16 sm:mt-20">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl sm:text-2xl font-display font-bold text-white">
                    Lowongan Lainnya di <span class="text-brand-accent">Scalify</span>
                </h2>
                <a href="{{ route('landing.careers') }}" class="text-xs font-semibold text-brand-accent hover:underline hidden sm:inline-flex items-center gap-1.5">
                    <span>Lihat Semua</span>
                    <i class="fas fa-arrow-right text-[10px]"></i>
                </a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
                @foreach ($otherCareers as $item)
                <div class="bg-[#0F172A]/70 backdrop-blur-xl border border-white/10 hover:border-brand-accent/40 text-white rounded-2xl p-5 shadow-card hover:shadow-glow-blue hover:-translate-y-1 transition-all duration-300 flex flex-col group relative overflow-hidden">
                    <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-brand-accent to-indigo-500 transform origin-left scale-x-0 group-hover:scale-x-100 transition-transform duration-300"></div>

                    <div class="flex items-center gap-2 mb-3 text-[9px] font-bold tracking-widest uppercase">
                        @if($item->employment_type)
                        <span class="px-2 py-0.5 bg-emerald-500/20 text-emerald-300 border border-emerald-500/30 rounded">
                            {{ $item->employment_type }}
                        </span>
                        @endif
                    </div>

                    <h3 class="font-display text-base font-bold mb-2 text-white group-hover:text-brand-accent transition-colors leading-snug">
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
                        <span>Lihat Detail</span>
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
                    <button type="button" onclick="document.getElementById('applyModal').classList.add('hidden')" class="px-5 py-2.5 bg-white/5 hover:bg-white/10 border border-white/10 text-slate-300 rounded-xl text-xs font-semibold transition">Batal</button>
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
    /* ═══ Quill Dark Content Renderer ═══════════════════════════════════ */
    .quill-dark-content {
        font-size: 15px;
        line-height: 1.8;
        color: #cbd5e1;
    }

    .quill-dark-content h1 {
        font-size: 1.75rem;
        font-weight: 700;
        color: #ffffff;
        margin: 1.5rem 0 0.75rem;
    }

    .quill-dark-content h2 {
        font-size: 1.35rem;
        font-weight: 700;
        color: #ffffff;
        margin: 1.5rem 0 0.75rem;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        padding-bottom: 0.4rem;
    }

    .quill-dark-content h3 {
        font-size: 1.15rem;
        font-weight: 600;
        color: #38bdf8;
        margin: 1.25rem 0 0.5rem;
    }

    .quill-dark-content h4,
    .quill-dark-content h5,
    .quill-dark-content h6 {
        font-size: 0.95rem;
        font-weight: 600;
        color: #e2e8f0;
        margin: 1rem 0 0.4rem;
    }

    .quill-dark-content p {
        margin-bottom: 1rem;
    }

    .quill-dark-content p:last-child {
        margin-bottom: 0;
    }

    .quill-dark-content strong {
        font-weight: 700;
        color: #ffffff;
    }

    .quill-dark-content em {
        font-style: italic;
    }

    .quill-dark-content u {
        text-decoration: underline;
    }

    .quill-dark-content a {
        color: #38bdf8;
        text-decoration: underline;
        transition: color .2s;
    }

    .quill-dark-content a:hover {
        color: #7dd3fc;
    }

    .quill-dark-content img {
        max-width: 100%;
        height: auto;
        border-radius: 16px;
        border: 1px solid rgba(255, 255, 255, 0.1);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        margin: 1.25rem 0;
        display: block;
    }

    .quill-dark-content ul {
        list-style: disc;
        padding-left: 1.75rem;
        margin-bottom: 1rem;
    }

    .quill-dark-content ol {
        list-style: decimal;
        padding-left: 1.75rem;
        margin-bottom: 1rem;
    }

    .quill-dark-content li {
        margin-bottom: 0.4rem;
        color: #cbd5e1;
    }

    .quill-dark-content blockquote {
        border-left: 4px solid #38bdf8;
        background: rgba(56, 189, 248, 0.08);
        color: #bae6fd;
        padding: 1rem 1.25rem;
        border-radius: 0 12px 12px 0;
        margin: 1.25rem 0;
        font-style: italic;
    }

    .quill-dark-content code {
        background: rgba(255, 255, 255, 0.08);
        color: #38bdf8;
        padding: 0.15rem 0.45rem;
        border-radius: 6px;
        font-size: 0.85em;
        font-family: monospace;
    }

    .quill-dark-content pre.ql-syntax {
        background: #080d1a;
        color: #e2e8f0;
        border: 1px solid rgba(255, 255, 255, 0.1);
        padding: 1rem 1.25rem;
        border-radius: 14px;
        overflow-x: auto;
        font-size: 0.85em;
        line-height: 1.7;
        margin: 1.25rem 0;
    }

    .quill-dark-content table {
        width: 100%;
        border-collapse: collapse;
        margin: 1.25rem 0;
        border-radius: 12px;
        overflow: hidden;
    }

    .quill-dark-content table th {
        background: rgba(255, 255, 255, 0.08);
        color: #ffffff;
        font-weight: 600;
        padding: 0.75rem 1rem;
        border: 1px solid rgba(255, 255, 255, 0.1);
        text-align: left;
    }

    .quill-dark-content table td {
        padding: 0.65rem 1rem;
        border: 1px solid rgba(255, 255, 255, 0.08);
        color: #cbd5e1;
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
