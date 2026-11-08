{{--
    Page header standar halaman admin.
    Pemakaian: <x-admin.page-header title="Judul" subtitle="Deskripsi" :back="route('x.index')"> ...aksi... </x-admin.page-header>
--}}
@props(['title', 'subtitle' => null, 'back' => null])

<div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between mb-4 lg:mb-6">
    <div class="flex items-center gap-3 min-w-0">
        @if ($back)
        <a href="{{ $back }}" class="w-9 h-9 shrink-0 flex items-center justify-center rounded-lg border border-slate-200 bg-white text-slate-500 hover:text-blue-600 hover:border-blue-300 transition-colors" title="Kembali">
            <i class="fa-solid fa-arrow-left text-sm"></i>
        </a>
        @endif
        <div class="min-w-0">
            <h2 class="text-base lg:text-lg font-semibold text-slate-900 truncate">{{ $title }}</h2>
            @if ($subtitle)
            <p class="text-xs lg:text-sm text-slate-500 line-clamp-2 lg:line-clamp-none">{{ $subtitle }}</p>
            @endif
        </div>
    </div>

    @if ($slot->isNotEmpty())
    <div class="flex flex-wrap items-center gap-2 [&>*]:flex-1 sm:[&>*]:flex-none">{{ $slot }}</div>
    @endif
</div>
