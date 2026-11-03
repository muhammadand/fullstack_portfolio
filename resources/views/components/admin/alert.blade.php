{{-- Alert standar. type: success | error | info --}}
@props(['type' => 'info'])

@php
$styles = [
    'success' => ['bg-emerald-50 border-emerald-200 text-emerald-800', 'fa-solid fa-circle-check text-emerald-600'],
    'error' => ['bg-red-50 border-red-200 text-red-800', 'fa-solid fa-circle-exclamation text-red-600'],
    'info' => ['bg-blue-50 border-blue-200 text-blue-800', 'fa-solid fa-circle-info text-blue-600'],
][$type] ?? ['bg-blue-50 border-blue-200 text-blue-800', 'fa-solid fa-circle-info text-blue-600'];
@endphp

<div {{ $attributes->class('flex items-start gap-3 rounded-lg border px-4 py-3 text-sm mb-6 ' . $styles[0]) }} role="alert">
    <i class="{{ $styles[1] }} mt-0.5"></i>
    <div class="flex-1">{{ $slot }}</div>
</div>
