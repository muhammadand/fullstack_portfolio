@extends('layouts.app')

@push('styles')
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<style>
    /* Override Quill default styles to match Tailwind theme */
    .ql-editor {
        font-family: inherit;
        font-size: 14px;
        color: #475569;
        line-height: 1.8;
    }

    .ql-editor h1,
    .ql-editor h2,
    .ql-editor h3,
    .ql-editor h4,
    .ql-editor h5,
    .ql-editor h6 {
        margin-top: 1.5em;
        margin-bottom: 0.5em;
        font-weight: 700;
        color: #0f172a;
        line-height: 1.3;
    }

    .ql-editor h1 {
        font-size: 1.75rem;
    }

    .ql-editor h2 {
        font-size: 1.5rem;
    }

    .ql-editor h3 {
        font-size: 1.25rem;
    }

    .ql-editor p {
        margin-bottom: 1rem;
    }

    .ql-editor img {
        max-width: 100%;
        border-radius: 12px;
        margin: 1.5rem auto;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        display: block;
    }

    .ql-editor a {
        color: #2563eb;
        font-weight: 500;
        text-decoration: underline;
        text-decoration-color: #bfdbfe;
        text-underline-offset: 4px;
        transition: all 0.2s;
    }

    .ql-editor a:hover {
        color: #1d4ed8;
        text-decoration-color: #2563eb;
    }

    .ql-editor ul,
    .ql-editor ol {
        padding-left: 1.5rem;
        margin-bottom: 1rem;
    }

    .ql-editor li {
        margin-bottom: 0.25rem;
    }

</style>
@endpush

@section('content')
<div class="min-h-screen bg-slate-50 pt-24 pb-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Breadcrumb -->
        <div class="mb-8 flex items-center gap-3">
            <a href="{{ route('landing.careers') }}" class="text-xs font-semibold text-slate-500 hover:text-blue-600 transition-colors inline-flex items-center gap-2">
                <i class="fas fa-arrow-left"></i> Kembali ke Daftar Karir
            </a>
            <span class="text-slate-300">/</span>
            <span class="px-2.5 py-1 bg-blue-50 text-blue-600 rounded-full text-[9px] font-bold tracking-widest uppercase">
                Lowongan
            </span>
        </div>

        <div class="grid lg:grid-cols-12 gap-6 lg:gap-8">
            <!-- Main Content -->
            <div class="lg:col-span-8">
                <article class="bg-white rounded-2xl shadow-[0_4px_20px_rgb(0,0,0,0.03)] overflow-hidden">
                    <div class="p-5 sm:p-7 md:p-10">
                        <!-- Title -->
                        <h1 class="text-xl md:text-2xl font-display font-bold text-slate-900 mb-5 leading-tight">
                            {{ $career->title }}
                        </h1>

                        <!-- Meta (Location, Type, Mode, Share) -->
                        <div class="flex items-center justify-between flex-wrap gap-4 pb-6 border-b border-slate-100 mb-6">
                            <div class="flex flex-wrap gap-2">
                                @if($career->location)
                                <span class="px-2.5 py-1 bg-slate-50 text-slate-600 rounded-md text-xs font-medium border border-slate-100 flex items-center gap-1.5">
                                    <i class="fa-solid fa-location-dot text-blue-600"></i> {{ $career->location }}
                                </span>
                                @endif
                                @if($career->employment_type)
                                <span class="px-2.5 py-1 bg-slate-50 text-slate-600 rounded-md text-xs font-medium border border-slate-100 flex items-center gap-1.5">
                                    <i class="fa-solid fa-briefcase text-blue-600"></i> {{ $career->employment_type }}
                                </span>
                                @endif
                                @if($career->work_mode)
                                <span class="px-2.5 py-1 bg-slate-50 text-slate-600 rounded-md text-xs font-medium border border-slate-100 flex items-center gap-1.5">
                                    <i class="fa-solid fa-building-user text-blue-600"></i> {{ $career->work_mode }}
                                </span>
                                @endif
                            </div>

                            <!-- Share Buttons -->
                            <div class="flex items-center gap-2">
                                <button onclick="sharePost(this)" data-title="{{ $career->title }}" data-text="{{ Str::limit($career->description, 100) }}" data-url="{{ url()->current() }}" class="w-8 h-8 flex items-center justify-center bg-slate-50 text-slate-600 hover:bg-[#0f172a] hover:text-white rounded-full transition-all shadow-sm text-sm" title="Share">
                                    <i class="fas fa-share-nodes"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Job Description Box -->
                        @if ($career->description)
                        <div class="mb-6 font-medium border-l-4 border-blue-500 pl-5 bg-slate-50 py-4 pr-4 rounded-r-lg">
                            <h3 class="font-display font-bold text-slate-900 mb-2 text-sm">Deskripsi Pekerjaan</h3>
                            <p class="text-slate-600 text-[13px] md:text-sm leading-relaxed whitespace-pre-wrap">{{ $career->description }}</p>
                        </div>
                        @endif

                        <!-- Qualifications WYSIWYG -->
                        <div>
                            <h3 class="text-lg font-display font-bold text-slate-900 mb-4">Kualifikasi</h3>
                            <div class="text-[14px] text-slate-700 leading-relaxed ql-snow">
                                <div class="ql-editor" style="padding: 0; min-height: auto;">
                                    {!! $career->qualifications ?: '<p>Tidak ada kualifikasi khusus yang dicantumkan.</p>' !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </article>
            </div>

            <!-- Sidebar -->
            <aside class="lg:col-span-4">
                <div class="sticky top-28 space-y-6">
                    <!-- Ringkasan Pekerjaan Widget -->
                    <div class="bg-white rounded-2xl shadow-[0_4px_20px_rgb(0,0,0,0.03)] p-5 sm:p-7">
                        <h3 class="text-lg font-display font-bold text-slate-900 mb-5 flex items-center gap-2">
                            <span class="w-1.5 h-5 bg-blue-600 rounded-full"></span>
                            Ringkasan Lowongan
                        </h3>

                        <div class="space-y-5 mb-6">
                            <div class="flex items-start gap-3">
                                <div class="w-8 h-8 rounded-full bg-blue-50 flex items-center justify-center shrink-0">
                                    <i class="fa-solid fa-money-bill-wave text-blue-600 text-xs"></i>
                                </div>
                                <div>
                                    <p class="text-[10px] font-bold tracking-wider uppercase text-slate-400 mb-0.5">Gaji</p>
                                    <p class="text-[13px] font-semibold text-slate-800 leading-tight">
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
                            <div class="flex items-start gap-3">
                                <div class="w-8 h-8 rounded-full bg-blue-50 flex items-center justify-center shrink-0">
                                    <i class="fa-regular fa-calendar-xmark text-blue-600 text-xs"></i>
                                </div>
                                <div>
                                    <p class="text-[10px] font-bold tracking-wider uppercase text-slate-400 mb-0.5">Batas Lamaran</p>
                                    <p class="text-[13px] font-semibold text-slate-800 leading-tight">
                                        {{ $career->closing_date ? \Carbon\Carbon::parse($career->closing_date)->format('d M Y') : 'Tidak ditentukan' }}
                                    </p>
                                </div>
                            </div>
                            <div class="flex items-start gap-3">
                                <div class="w-8 h-8 rounded-full bg-blue-50 flex items-center justify-center shrink-0">
                                    <i class="fa-regular fa-calendar-check text-blue-600 text-xs"></i>
                                </div>
                                <div>
                                    <p class="text-[10px] font-bold tracking-wider uppercase text-slate-400 mb-0.5">Diposting Pada</p>
                                    <p class="text-[13px] font-semibold text-slate-800 leading-tight">
                                        {{ $career->created_at->format('d M Y') }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <a href="https://wa.me/6285221694067?text=Halo%20Scalify,%20saya%20tertarik%20dengan%20lowongan%20{{ urlencode($career->title) }}..." target="_blank" class="flex items-center justify-center gap-2 w-full bg-[#0f172a] hover:bg-blue-600 shadow-md shadow-slate-900/10 text-white font-semibold px-5 py-3 rounded-xl transition-all duration-300 hover:-translate-y-1 text-sm">
                            <i class="fa-brands fa-whatsapp text-base"></i> Lamar via WhatsApp
                        </a>
                    </div>
                </div>
            </aside>
        </div>

        <!-- More Careers Section -->
        @if ($otherCareers->count() > 0)
        <div class="mt-16">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl md:text-2xl font-display font-bold text-slate-900">
                    Mungkin Anda <span class="text-blue-600">Tertarik</span>
                </h2>
                <a href="{{ route('landing.careers') }}" class="text-xs font-semibold text-blue-600 hover:text-blue-700 hidden sm:block">Lihat Semua <i class="fas fa-arrow-right ml-1"></i></a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($otherCareers as $item)
                <div class="bg-white border border-slate-100 text-slate-800 rounded-2xl p-5 shadow-[0_2px_15px_rgb(0,0,0,0.02)] hover:shadow-[0_8px_30px_rgb(0,0,0,0.06)] hover:-translate-y-1 transition-all duration-300 flex flex-col group relative overflow-hidden">
                    <div class="absolute top-0 left-0 w-full h-1 bg-blue-600 transform origin-left scale-x-0 group-hover:scale-x-100 transition-transform duration-300"></div>

                    <div class="flex items-center gap-2 mb-3 text-[9px] font-bold tracking-widest text-slate-400 uppercase">
                        @if($item->employment_type)
                        <span class="text-blue-500 bg-blue-50 px-2 py-0.5 rounded">
                            {{ $item->employment_type }}
                        </span>
                        @endif
                    </div>

                    <h3 class="font-display text-[15px] font-bold mb-2 text-slate-900 leading-snug group-hover:text-blue-600 transition-colors">
                        {{ $item->title }}
                    </h3>

                    <div class="text-slate-500 text-[11px] mb-5 flex-1 flex flex-col gap-1.5">
                        @if($item->location)
                        <div class="flex items-center gap-1.5"><i class="fa-solid fa-location-dot"></i> {{ $item->location }}</div>
                        @endif
                        @if($item->salary_min)
                        <div class="flex items-center gap-1.5"><i class="fa-solid fa-money-bill-wave"></i> Mulai Rp {{ number_format($item->salary_min, 0, ',', '.') }}</div>
                        @endif
                    </div>

                    <a href="{{ route('careers.read', $item->slug) }}" class="text-slate-900 text-[11px] font-bold inline-flex items-center gap-1.5 hover:text-blue-600 transition-colors mt-auto group/btn uppercase tracking-wider">
                        Lihat Detail <i class="fas fa-arrow-right text-[9px] group-hover/btn:translate-x-1 transition-transform"></i>
                    </a>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</div>

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
                alert('Link berhasil disalin ke clipboard!');
            }).catch(() => {
                alert('Gagal menyalin link.');
            });
        }
    }

</script>
@endsection
