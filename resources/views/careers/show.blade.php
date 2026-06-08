@extends('layouts.admin.app')

@section('content')
<div class="max-w-5xl mx-auto px-4 py-6">
    {{-- Header --}}
    <div class="flex items-center justify-between mb-4">
        <div class="flex items-center gap-3">
            <a href="{{ route('careers.index') }}" class="p-1.5 hover:bg-gray-200 rounded-xl transition-colors">
                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </a>
            <h2 class="text-lg tracking-tight font-bold text-gray-900">Detail Karir</h2>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('careers.edit', $career->id) }}" class="px-3 py-1.5 bg-yellow-50 text-yellow-600 hover:bg-yellow-100 border border-yellow-200 rounded-md text-[13px] font-medium transition">
                Edit Lowongan
            </a>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="p-4 md:p-5 space-y-5">

            {{-- Title & Status --}}
            <div class="border-b border-gray-100 pb-4">
                <div class="flex justify-between items-start gap-4">
                    <div>
                        <h1 class="text-xl font-bold text-gray-900 mb-2">{{ $career->title }}</h1>
                        <div class="flex flex-wrap gap-2 text-[12px] text-gray-500">
                            @if($career->employment_type)
                            <span class="flex items-center gap-1.5 bg-blue-50 text-blue-700 px-2 py-1 rounded-md">
                                <i class="fa-solid fa-briefcase"></i> {{ $career->employment_type }}
                            </span>
                            @endif
                            @if($career->work_mode)
                            <span class="flex items-center gap-1.5 bg-purple-50 text-purple-700 px-2 py-1 rounded-md">
                                <i class="fa-solid fa-building-user"></i> {{ $career->work_mode }}
                            </span>
                            @endif
                            @if($career->location)
                            <span class="flex items-center gap-1.5 bg-gray-50 text-gray-700 px-2 py-1 border border-gray-200 rounded-md">
                                <i class="fa-solid fa-location-dot"></i> {{ $career->location }}
                            </span>
                            @endif
                        </div>
                    </div>
                    <div>
                        @if ($career->is_active)
                        <span class="px-3 py-1 bg-green-50 border border-green-200 text-green-700 rounded-md text-[12px] font-medium whitespace-nowrap">Aktif</span>
                        @else
                        <span class="px-3 py-1 bg-red-50 border border-red-200 text-red-700 rounded-md text-[12px] font-medium whitespace-nowrap">Tidak Aktif</span>
                        @endif
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                {{-- Left Content --}}
                <div class="md:col-span-2 space-y-6">
                    <div>
                        <h3 class="text-[14px] font-bold text-slate-800 mb-2">Deskripsi Pekerjaan</h3>
                        <div class="text-[13px] text-gray-700 whitespace-pre-wrap leading-relaxed">{{ $career->description ?: 'Tidak ada deskripsi.' }}</div>
                    </div>

                    <div>
                        <h3 class="text-[14px] font-bold text-slate-800 mb-2">Kualifikasi</h3>
                        <div class="text-[13px] text-gray-700 leading-relaxed ql-snow">
                            <div class="ql-editor" style="padding: 0; min-height: auto;">
                                {!! $career->qualifications ?: 'Tidak ada kualifikasi yang dicantumkan.' !!}
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Right Sidebar details --}}
                <div class="md:col-span-1 bg-gray-50 p-4 rounded-xl border border-gray-100 h-fit space-y-4">
                    <div>
                        <p class="text-[12px] font-medium text-gray-500 mb-1">Gaji yang ditawarkan</p>
                        <p class="font-semibold text-[13px] text-gray-900">
                            @if($career->salary_min && $career->salary_max)
                            Rp {{ number_format($career->salary_min, 0, ',', '.') }} - Rp {{ number_format($career->salary_max, 0, ',', '.') }}
                            @elseif($career->salary_min)
                            Mulai dari Rp {{ number_format($career->salary_min, 0, ',', '.') }}
                            @elseif($career->salary_max)
                            Hingga Rp {{ number_format($career->salary_max, 0, ',', '.') }}
                            @else
                            <span class="text-gray-500 italic">Dirahasiakan / Sesuai kesepakatan</span>
                            @endif
                        </p>
                    </div>

                    <div class="pt-3 border-t border-gray-200">
                        <p class="text-[12px] font-medium text-gray-500 mb-1">Batas Lamaran (Closing Date)</p>
                        <p class="font-semibold text-[13px] text-gray-900">
                            {{ $career->closing_date ? \Carbon\Carbon::parse($career->closing_date)->format('d F Y') : 'Tidak ditentukan' }}
                        </p>
                    </div>

                    <div class="pt-3 border-t border-gray-200">
                        <p class="text-[12px] font-medium text-gray-500 mb-1">Dibuat pada</p>
                        <p class="font-semibold text-[13px] text-gray-900">
                            {{ $career->created_at->format('d M Y H:i') }}
                        </p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<style>
    .ql-editor {
        font-family: inherit;
        font-size: 13px;
        color: #374151;
    }

    .ql-editor h1,
    .ql-editor h2,
    .ql-editor h3,
    .ql-editor h4,
    .ql-editor h5,
    .ql-editor h6 {
        margin-bottom: 0.5em;
        font-weight: 600;
        color: #1e293b;
    }

    .ql-editor img {
        max-width: 100%;
        border-radius: 8px;
        margin-top: 0.5rem;
        margin-bottom: 0.5rem;
    }

</style>
@endsection
