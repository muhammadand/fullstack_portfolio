{{-- Badge status. color: green | yellow | orange | blue | slate --}}
@props(['color' => 'slate'])

@php
$colors = [
    'green' => 'bg-emerald-50 text-emerald-700 ring-emerald-600/20',
    'yellow' => 'bg-amber-50 text-amber-700 ring-amber-600/20',
    'orange' => 'bg-orange-50 text-orange-700 ring-orange-600/20',
    'blue' => 'bg-blue-50 text-blue-700 ring-blue-600/20',
    'slate' => 'bg-slate-100 text-slate-700 ring-slate-500/20',
];
@endphp

<span {{ $attributes->class('inline-flex items-center gap-1 rounded-md px-2 py-0.5 text-xs font-medium ring-1 ring-inset whitespace-nowrap ' . ($colors[$color] ?? $colors['slate'])) }}>{{ $slot }}</span>
