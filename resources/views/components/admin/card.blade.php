{{--
    Card standar: putih, rounded-xl, border slate-200.
    Props: title (opsional), icon (class Font Awesome, opsional), padding (default true).
    Slot "actions" opsional untuk tombol di kanan header.
--}}
@props(['title' => null, 'icon' => null, 'padding' => true])

<div {{ $attributes->class('bg-white rounded-xl border border-slate-200 shadow-sm') }}>
    @if ($title)
    <div class="flex items-center justify-between gap-3 px-5 py-4 border-b border-slate-200">
        <h3 class="text-sm font-semibold text-slate-900 flex items-center gap-2">
            @if ($icon)<i class="{{ $icon }} text-blue-600"></i>@endif
            {{ $title }}
        </h3>
        @isset($actions)
        <div class="flex items-center gap-2">{{ $actions }}</div>
        @endisset
    </div>
    @endif

    <div @class(['p-5' => $padding])>
        {{ $slot }}
    </div>
</div>
