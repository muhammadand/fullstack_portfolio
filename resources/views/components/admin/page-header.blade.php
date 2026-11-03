{{--
    Page header standar halaman admin.
    Pemakaian: <x-admin.page-header title="Judul" subtitle="Deskripsi" :back="route('x.index')"> ...aksi... </x-admin.page-header>
--}}
@props(['title', 'subtitle' => null, 'back' => null])

<div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between mb-6">
    <div class="flex items-center gap-3 min-w-0">
        @if ($back)
        <a href="{{ $back }}" class="w-9 h-9 shrink-0 flex items-center justify-center rounded-lg border border-slate-200 bg-white text-slate-500 hover:text-blue-600 hover:border-blue-300 transition-colors" title="Kembali">
            <i class="fa-solid fa-arrow-left text-sm"></i>
        </a>
        @endif
        <div class="min-w-0">
            <h2 class="text-lg font-semibold text-slate-900 truncate">{{ $title }}</h2>
            @if ($subtitle)
            <p class="text-sm text-slate-500">{{ $subtitle }}</p>
            @endif
        </div>
    </div>

    @if ($slot->isNotEmpty())
    <div class="flex flex-wrap items-center gap-2">{{ $slot }}</div>
    @endif
</div>
