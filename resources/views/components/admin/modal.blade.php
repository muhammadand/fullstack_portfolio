{{--
    Modal standar untuk komponen Livewire.
    Props: title, icon (Font Awesome, opsional), size (md | lg | xl), close (nama method Livewire penutup).
    Slot default = isi, slot "footer" opsional.
--}}
@props(['title', 'icon' => null, 'size' => 'lg', 'close' => 'closeModal'])

@php
$sizes = ['md' => 'max-w-md', 'lg' => 'max-w-2xl', 'xl' => 'max-w-4xl'];
@endphp

<div class="fixed inset-0 z-50 flex items-center justify-center p-4" role="dialog" aria-modal="true" aria-label="{{ $title }}"
    x-data @keydown.escape.window="$wire.{{ $close }}()">
    <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm" wire:click="{{ $close }}"></div>

    <div class="relative w-full {{ $sizes[$size] ?? $sizes['lg'] }} max-h-[90vh] flex flex-col bg-white rounded-xl shadow-xl border border-slate-200">
        <div class="flex items-center justify-between gap-3 px-5 py-4 border-b border-slate-200">
            <h3 class="text-sm font-semibold text-slate-900 flex items-center gap-2 min-w-0">
                @if ($icon)<i class="{{ $icon }} text-blue-600"></i>@endif
                <span class="truncate">{{ $title }}</span>
            </h3>
            <button type="button" wire:click="{{ $close }}" class="w-8 h-8 shrink-0 flex items-center justify-center rounded-lg text-slate-400 hover:text-slate-600 hover:bg-slate-100" aria-label="Tutup">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <div class="p-5 overflow-y-auto">{{ $slot }}</div>

        @isset($footer)
        <div class="flex items-center justify-end gap-2 px-5 py-3 border-t border-slate-200 bg-slate-50 rounded-b-xl">{{ $footer }}</div>
        @endisset
    </div>
</div>
