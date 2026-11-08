{{--
    Kartu statistik standar (mobile-first, angka tidak pernah keluar kartu).
    Props: label, value (angka), rupiah (bool), icon (Font Awesome), tone (blue|emerald|amber|red|indigo|sky|purple|slate), href (opsional).
    Slot opsional = keterangan kecil di bawah angka. Contoh:
      <x-admin.stat label="Omzet" :value="$omzet" rupiah icon="fa-solid fa-wallet" tone="emerald">bulan ini</x-admin.stat>
--}}
@props(['label', 'value' => 0, 'rupiah' => false, 'icon' => null, 'tone' => 'blue', 'href' => null])
@php
    $tones = [
        'blue' => 'bg-blue-50 text-blue-600', 'emerald' => 'bg-emerald-50 text-emerald-600', 'amber' => 'bg-amber-50 text-amber-600',
        'red' => 'bg-red-50 text-red-600', 'indigo' => 'bg-indigo-50 text-indigo-600', 'sky' => 'bg-sky-50 text-sky-600',
        'purple' => 'bg-purple-50 text-purple-600', 'slate' => 'bg-slate-100 text-slate-600',
    ];
    $tag = $href ? 'a' : 'div';
@endphp
<{{ $tag }} @if($href) href="{{ $href }}" @endif {{ $attributes->class('block min-w-0 bg-white rounded-xl border border-slate-200 shadow-sm p-3 lg:p-4' . ($href ? ' hover:border-blue-300 transition-colors' : '')) }}>
    <div class="flex items-center gap-2.5 lg:gap-3 min-w-0">
        @if($icon)
        <span class="w-8 h-8 lg:w-10 lg:h-10 rounded-lg lg:rounded-xl shrink-0 flex items-center justify-center text-xs lg:text-sm {{ $tones[$tone] ?? $tones['blue'] }}"><i class="{{ $icon }}"></i></span>
        @endif
        <div class="min-w-0 flex-1">
            <p class="text-[11px] lg:text-xs font-medium text-slate-500 truncate">{{ $label }}</p>
            <p class="text-lg lg:text-xl font-bold text-slate-900 leading-tight truncate"><x-admin.money :value="$value" :rupiah="$rupiah" /></p>
        </div>
    </div>
    @if($slot->isNotEmpty())
    <div class="mt-2 text-[11px] text-slate-500 truncate">{{ $slot }}</div>
    @endif
</{{ $tag }}>
