{{--
    Tombol standar. Otomatis jadi <a> jika ada prop href.
    variant: primary (biru) | secondary (putih) | soft (biru muda) | danger (merah)
    size: sm | md
    icon: class Font Awesome, contoh "fa-solid fa-plus"
--}}
@props(['variant' => 'primary', 'size' => 'md', 'icon' => null, 'href' => null, 'type' => 'button'])

@php
$variants = [
    'primary' => 'bg-blue-600 text-white hover:bg-blue-700 focus-visible:ring-blue-500/40',
    'secondary' => 'bg-white text-slate-700 border border-slate-300 hover:bg-slate-50 focus-visible:ring-slate-400/30',
    'soft' => 'bg-blue-50 text-blue-700 hover:bg-blue-100 focus-visible:ring-blue-500/30',
    'danger' => 'bg-white text-red-600 border border-red-200 hover:bg-red-50 focus-visible:ring-red-500/30',
];
// Mobile-first: target sentuh min. 36px (sm) / 40px (md); di desktop kembali ringkas.
$sizes = [
    'sm' => 'min-h-9 lg:min-h-0 px-3 lg:px-2.5 py-1.5 text-xs gap-1.5',
    'md' => 'min-h-10 lg:min-h-0 px-4 py-2 text-sm gap-2',
];
$classes = 'inline-flex items-center justify-center rounded-lg font-medium transition-colors focus:outline-none focus-visible:ring-2 disabled:opacity-60 disabled:cursor-not-allowed '
    . ($variants[$variant] ?? $variants['primary']) . ' ' . ($sizes[$size] ?? $sizes['md']);
@endphp

@if ($href)
<a href="{{ $href }}" {{ $attributes->class($classes) }}>
    @if ($icon)<i class="{{ $icon }}"></i>@endif
    {{ $slot }}
</a>
@else
<button type="{{ $type }}" {{ $attributes->class($classes) }}>
    @if ($icon)<i class="{{ $icon }}"></i>@endif
    {{ $slot }}
</button>
@endif
