@extends('layouts.app')



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

        <!-- Alert Success -->
        @if (session('success'))
        <div class="mb-6 p-4 rounded-xl bg-green-50 border border-green-200 flex items-center gap-3">
            <div class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center shrink-0">
                <i class="fa-solid fa-check text-green-600 text-sm"></i>
            </div>
            <div>
                <h4 class="text-sm font-bold text-green-800">Berhasil!</h4>
                <p class="text-xs text-green-600">{{ session('success') }}</p>
            </div>
            <button onclick="this.parentElement.remove()" class="ml-auto text-green-600 hover:text-green-800">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
        @endif

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
                            <div class="quill-content max-w-none">
                                {!! $career->qualifications ?: '<p>Tidak ada kualifikasi khusus yang dicantumkan.</p>' !!}
                            </div>
                        </div>
                    </div>
                </article>
            </div>

            <style>
                /* ═══ Quill Content Renderer ═══════════════════════════════════ */
                .quill-content {
                    font-size: 16px;
                    line-height: 1.8;
                    color: #374151;
                }

                /* Headings */
                .quill-content h1 {
                    font-size: 2rem;
                    font-weight: 700;
                    color: #111827;
                    margin: 1.5rem 0 0.75rem;
                }

                .quill-content h2 {
                    font-size: 1.5rem;
                    font-weight: 700;
                    color: #111827;
                    margin: 1.5rem 0 0.75rem;
                    border-bottom: 2px solid #e5e7eb;
                    padding-bottom: 0.4rem;
                }

                .quill-content h3 {
                    font-size: 1.25rem;
                    font-weight: 600;
                    color: #1e3a8a;
                    margin: 1.25rem 0 0.5rem;
                }

                .quill-content h4,
                .quill-content h5,
                .quill-content h6 {
                    font-size: 1rem;
                    font-weight: 600;
                    color: #374151;
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
                    color: #111827;
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
                    color: #1e3a8a;
                    text-decoration: underline;
                    transition: color .2s;
                }

                .quill-content a:hover {
                    color: #1e40af;
                }

                /* Images - semua alignment dari Quill */
                .quill-content img {
                    max-width: 100%;
                    height: auto;
                    border-radius: 12px;
                    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
                    margin: 1rem 0;
                    display: block;
                }

                .quill-content .ql-align-center img,
                .quill-content .ql-align-center {
                    text-align: center;
                }

                .quill-content .ql-align-right img,
                .quill-content .ql-align-right {
                    text-align: right;
                }

                .quill-content .ql-align-left img,
                .quill-content .ql-align-left {
                    text-align: left;
                }

                .quill-content .ql-align-justify {
                    text-align: justify;
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
                    color: #374151;
                }

                /* Indented list items (Quill uses data-indent) */
                .quill-content li.ql-indent-1 {
                    padding-left: 1.5rem;
                }

                .quill-content li.ql-indent-2 {
                    padding-left: 3rem;
                }

                .quill-content li.ql-indent-3 {
                    padding-left: 4.5rem;
                }

                /* Blockquote */
                .quill-content blockquote {
                    border-left: 4px solid #1e3a8a;
                    background: #f0f4ff;
                    color: #374151;
                    padding: 1rem 1.25rem;
                    border-radius: 0 8px 8px 0;
                    margin: 1.25rem 0;
                    font-style: italic;
                }

                /* Code */
                .quill-content code {
                    background: #f3f4f6;
                    color: #1e3a8a;
                    padding: 0.15rem 0.45rem;
                    border-radius: 4px;
                    font-size: 0.875em;
                    font-family: 'Fira Code', monospace;
                }

                .quill-content pre.ql-syntax {
                    background: #1e293b;
                    color: #e2e8f0;
                    padding: 1rem 1.25rem;
                    border-radius: 10px;
                    overflow-x: auto;
                    font-size: 0.875em;
                    line-height: 1.7;
                    margin: 1.25rem 0;
                }

                /* Video embed */
                .quill-content .ql-video {
                    width: 100%;
                    aspect-ratio: 16/9;
                    border-radius: 12px;
                    border: none;
                    margin: 1rem 0;
                }

                /* Table */
                .quill-content table {
                    width: 100%;
                    border-collapse: collapse;
                    margin: 1.25rem 0;
                }

                .quill-content table th {
                    background: #f0f4ff;
                    color: #111827;
                    font-weight: 600;
                    padding: 0.75rem 1rem;
                    border: 1px solid #e5e7eb;
                    text-align: left;
                }

                .quill-content table td {
                    padding: 0.65rem 1rem;
                    border: 1px solid #e5e7eb;
                    color: #374151;
                }

                .quill-content table tr:nth-child(even) td {
                    background: #f9fafb;
                }

                /* Subscript / Superscript */
                .quill-content sub {
                    vertical-align: sub;
                    font-size: 0.75em;
                }

                .quill-content sup {
                    vertical-align: super;
                    font-size: 0.75em;
                }

            </style>

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

                        <button onclick="document.getElementById('applyModal').classList.remove('hidden')" class="flex items-center justify-center gap-2 w-full bg-[#0f172a] hover:bg-blue-600 shadow-md shadow-slate-900/10 text-white font-semibold px-5 py-3 rounded-xl transition-all duration-300 hover:-translate-y-1 text-sm">
                            <i class="fa-solid fa-paper-plane text-base"></i> Lamar Sekarang
                        </button </div>
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

<!-- Apply Modal -->
<div id="applyModal" class="fixed inset-0 z-[100] hidden bg-slate-900/50 backdrop-blur-sm flex items-center justify-center overflow-y-auto py-10 px-4">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-2xl mx-auto my-auto relative flex flex-col max-h-[90vh]">
        <!-- Modal Header -->
        <div class="flex items-center justify-between p-5 md:p-6 border-b border-slate-100 shrink-0">
            <h3 class="text-lg md:text-xl font-bold text-slate-800">Lamar Posisi: <span class="text-blue-600">{{ $career->title }}</span></h3>
            <button type="button" onclick="document.getElementById('applyModal').classList.add('hidden')" class="text-slate-400 hover:text-red-500 transition-colors">
                <i class="fa-solid fa-xmark text-xl"></i>
            </button>
        </div>

        <!-- Modal Body -->
        <div class="p-5 md:p-6 overflow-y-auto">
            <form action="{{ route('career-applications.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                @csrf
                <input type="hidden" name="career_id" value="{{ $career->id }}">

                <!-- Full Name -->
                <div>
                    <label for="full_name" class="block text-sm font-medium text-slate-700 mb-1.5">
                        Nama Lengkap <span class="text-red-500">*</span>
                    </label>

                    <input type="text" name="full_name" id="full_name" required class="w-full px-4 py-3 rounded-lg border border-slate-200 focus:border-blue-500 focus:ring-blue-500 text-sm text-black">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-slate-700 mb-1.5">Email <span class="text-red-500">*</span></label>
                        <input type="email" name="email" id="email" required class="w-full px-4 py-3 rounded-lg border border-slate-200 focus:border-blue-500 focus:ring-blue-500 text-sm text-black">
                    </div>
                    <!-- Phone -->
                    <div>
                        <label for="phone" class="block text-sm font-medium text-slate-700 mb-1.5">No. HP / WhatsApp</label>
                        <input type="text" name="phone" id="phone" class="w-full px-4 py-3 rounded-lg border border-slate-200 focus:border-blue-500 focus:ring-blue-500 text-sm text-black">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <!-- Portfolio -->
                    <div>
                        <label for="portfolio_url" class="block text-sm font-medium text-slate-700 mb-1.5">Link Portofolio (URL)</label>
                        <input type="url" name="portfolio_url" id="portfolio_url" placeholder="https://..." class="w-full px-4 py-3 rounded-lg border border-slate-200 focus:border-blue-500 focus:ring-blue-500 text-sm text-black">
                    </div>
                    <!-- LinkedIn -->
                    <div>
                        <label for="linkedin_url" class="block text-sm font-medium text-slate-700 mb-1.5">Link LinkedIn (URL)</label>
                        <input type="url" name="linkedin_url" id="linkedin_url" placeholder="https://linkedin.com/in/..." class="w-full px-4 py-3 rounded-lg border border-slate-200 focus:border-blue-500 focus:ring-blue-500 text-sm text-black">
                    </div>
                </div>

                <!-- Resume -->
                <div>
                    <label for="resume" class="block text-sm font-medium text-slate-700 mb-1.5">Upload CV / Resume (PDF) <span class="text-red-500">*</span></label>
                    <input type="file" name="resume" id="resume" accept=".pdf,.doc,.docx" required class="block w-full text-sm text-black file:mr-4 file:py-2.5 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 border border-slate-200 rounded-lg p-2 bg-slate-50">
                </div>

                <!-- Cover Letter -->
                <div>
                    <label for="cover_letter" class="block text-sm font-medium text-slate-700 mb-1.5">Pesan Tambahan / Cover Letter</label>
                    <textarea name="cover_letter" id="cover_letter" rows="4" class="w-full px-4 py-3 rounded-lg border border-slate-200 focus:border-blue-500 focus:ring-blue-500 text-sm text-black"></textarea>
                </div>

                <!-- Footer / Actions -->
                <div class="flex justify-end gap-3 pt-4 mt-6 border-t border-slate-100">
                    <button type="button" onclick="document.getElementById('applyModal').classList.add('hidden')" class="px-5 py-2.5 bg-slate-100 text-slate-600 rounded-lg text-sm font-medium hover:bg-slate-200 transition">Batal</button>
                    <button type="submit" class="px-5 py-2.5 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700 transition flex items-center gap-2">
                        <i class="fa-solid fa-paper-plane"></i> Kirim Lamaran
                    </button>
                </div>
            </form>
        </div>
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
