@extends('layouts.app')

@section('content')
<section class="bg-[#f8fafc] text-slate-800 py-24 px-4 sm:px-6 lg:px-8 relative z-20 min-h-screen">
    <div class="max-w-6xl mx-auto flex flex-col lg:flex-row gap-12 lg:gap-16 items-start">

        <!-- Bagian Kiri (Teks & Search) -->
        <div class="lg:w-[40%] flex flex-col items-center lg:items-start text-center lg:text-left lg:sticky lg:top-32 mb-8 lg:mb-0">
            <div class="inline-flex items-center justify-center px-4 py-1.5 rounded-full border border-slate-200 text-slate-800 mb-4 sm:mb-6 bg-white shadow-sm">
                <span class="font-bold text-[10px] tracking-widest uppercase">CAREERS</span>
            </div>
            <h1 class="font-display text-4xl sm:text-5xl lg:text-[2.75rem] font-semibold text-slate-900 mb-4 leading-[1.15] tracking-tight">
                Temukan Karir <span class="text-brand-blue">Impianmu</span>
            </h1>
            <p class="text-slate-500 leading-relaxed text-sm sm:text-base mb-8 max-w-lg">
                Bergabunglah bersama kami untuk membangun masa depan teknologi dan memberikan dampak nyata bagi jutaan pengguna.
            </p>

            <!-- Form Pencarian -->
            <div class="w-full bg-white rounded-[1.5rem] p-5 sm:p-6 shadow-[0_4px_20px_rgb(0,0,0,0.03)] border border-slate-100">
                <form action="{{ route('landing.careers') }}" method="GET" class="flex flex-col gap-4">
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i class="fa-solid fa-magnifying-glass text-slate-400"></i>
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari posisi atau lokasi..." class="w-full bg-slate-50 border border-slate-200 text-slate-800 rounded-xl pl-11 pr-4 py-3.5 focus:outline-none focus:ring-2 focus:ring-brand-blue focus:bg-white transition-all text-sm">
                    </div>
                    <button type="submit" class="w-full bg-btn-gradient shadow-glow-sm hover:shadow-glow-blue text-white font-semibold px-6 py-3.5 rounded-xl hover:-translate-y-1 transition-all duration-300 flex items-center justify-center gap-2">
                        Cari Lowongan <i class="fa-solid fa-arrow-right text-xs"></i>
                    </button>
                </form>
            </div>
        </div>

        <!-- Bagian Kanan (List Lowongan) -->
        <div class="lg:w-[60%] flex flex-col gap-5 w-full">
            @forelse($careers as $career)
            <!-- Kartu Lowongan -->
            <div class="bg-white border border-slate-100 text-slate-800 rounded-[1.5rem] p-6 sm:p-7 shadow-[0_4px_20px_rgb(0,0,0,0.03)] hover:shadow-[0_8px_30px_rgb(0,0,0,0.06)] hover:-translate-y-1.5 transition-all duration-300 flex flex-col group relative overflow-hidden">
                <!-- Aksen Biru di Samping -->
                <div class="absolute left-0 top-0 bottom-0 w-1.5 bg-brand-blue opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>

                <div class="flex flex-col md:flex-row gap-5 items-start md:items-center justify-between w-full">

                    {{-- Left: Details --}}
                    <div class="flex-1">
                        <div class="flex flex-wrap items-center gap-3 mb-2">
                            <h3 class="font-display font-semibold text-xl text-slate-900 group-hover:text-brand-blue transition-colors">
                                {{ $career->title }}
                            </h3>
                            @if($career->closing_date && \Carbon\Carbon::parse($career->closing_date)->isPast())
                            <span class="px-2.5 py-1 bg-red-50 text-red-600 rounded-md text-[10px] font-bold tracking-widest uppercase border border-red-100">Ditutup</span>
                            @else
                            @if($career->closing_date && \Carbon\Carbon::parse($career->closing_date)->diffInDays(now()) <= 7) <span class="px-2.5 py-1 bg-orange-50 text-orange-600 rounded-md text-[10px] font-bold tracking-widest uppercase border border-orange-100">Segera Berakhir</span>
                                @else
                                <span class="px-2.5 py-1 bg-green-50 text-green-600 rounded-md text-[10px] font-bold tracking-widest uppercase border border-green-100">Dibuka</span>
                                @endif
                                @endif
                        </div>

                        <div class="flex flex-wrap gap-3 md:gap-5 text-[13px] text-slate-500 mt-3">
                            @if($career->location)
                            <div class="flex items-center gap-1.5">
                                <i class="fa-solid fa-location-dot text-slate-400"></i>
                                {{ $career->location }}
                            </div>
                            @endif
                            @if($career->employment_type)
                            <div class="flex items-center gap-1.5">
                                <i class="fa-solid fa-briefcase text-slate-400"></i>
                                {{ $career->employment_type }}
                            </div>
                            @endif
                            @if($career->work_mode)
                            <div class="flex items-center gap-1.5">
                                <i class="fa-solid fa-building-user text-slate-400"></i>
                                {{ $career->work_mode }}
                            </div>
                            @endif
                        </div>
                    </div>

                    {{-- Right: Actions & Salary --}}
                    <div class="w-full md:w-auto flex flex-row md:flex-col items-center md:items-end justify-between gap-4 mt-4 md:mt-0 pt-4 md:pt-0 border-t md:border-t-0 border-slate-100">
                        <div class="text-left md:text-right">
                            <p class="text-[11px] font-bold tracking-wider uppercase text-slate-400 mb-1">Gaji</p>
                            <p class="text-sm font-semibold text-brand-dark">
                                @if($career->salary_min && $career->salary_max)
                                Rp {{ number_format($career->salary_min, 0, ',', '.') }} - Rp {{ number_format($career->salary_max, 0, ',', '.') }}
                                @elseif($career->salary_min)
                                Mulai Rp {{ number_format($career->salary_min, 0, ',', '.') }}
                                @else
                                Sesuai Kesepakatan
                                @endif
                            </p>
                        </div>
                        <a href="{{ route('careers.read', $career->slug) }}" class="inline-flex items-center justify-center px-5 py-2.5 bg-slate-50 hover:bg-brand-blue text-slate-600 hover:text-white rounded-xl text-sm font-semibold transition-colors duration-300 group-hover:bg-brand-blue/10 group-hover:text-brand-blue">
                            Lihat Detail
                        </a>
                    </div>

                </div>
            </div>
            @empty
            <div class="text-center py-16 bg-white rounded-[1.5rem] border border-slate-100 border-dashed shadow-sm">
                <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4 text-slate-300">
                    <i class="fa-solid fa-magnifying-glass text-2xl"></i>
                </div>
                <h3 class="font-display text-lg font-semibold text-slate-900 mb-2">Lowongan Tidak Ditemukan</h3>
                <p class="text-slate-500 text-sm mb-5">Maaf, kami tidak menemukan karir dengan kata kunci tersebut.</p>
                <a href="{{ route('landing.careers') }}" class="inline-flex items-center gap-2 text-brand-blue font-medium hover:underline text-sm">
                    <i class="fa-solid fa-rotate-left"></i> Reset Pencarian
                </a>
            </div>
            @endforelse

            {{-- Pagination --}}
            @if($careers->hasPages())
            <div class="mt-8">
                {{ $careers->appends(['search' => request('search')])->links('pagination::tailwind') }}
            </div>
            @endif
        </div>

    </div>
</section>

<style>
    /* Styling overrides for tailwind pagination inside light layout */
    nav[role="navigation"] {
        background: transparent !important;
    }

    nav[role="navigation"] p {
        color: #64748b !important;
    }

    nav[role="navigation"] a {
        background-color: white !important;
        color: #475569 !important;
        border-color: #e2e8f0 !important;
        border-radius: 0.75rem !important;
    }

    nav[role="navigation"] a:hover {
        background-color: #f8fafc !important;
    }

    nav[role="navigation"] span[aria-current="page"] span {
        background-color: #2563EB !important;
        border-color: #2563EB !important;
        color: white !important;
        border-radius: 0.75rem !important;
    }

</style>
@endsection
