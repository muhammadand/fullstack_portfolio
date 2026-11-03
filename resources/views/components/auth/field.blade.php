@props(['name', 'label', 'type' => 'text', 'icon' => null, 'hint' => null, 'optional' => false])

@php $error = $errors->first($name); @endphp

<div @if($type === 'password') x-data="{ show: false }" @endif>
    <label for="{{ $name }}" class="flex items-center justify-between text-xs font-semibold text-white/70 mb-1.5">
        <span>{{ $label }}@if($optional) <span class="text-white/35 font-normal">(opsional)</span>@endif</span>
        {{ $aside ?? '' }}
    </label>
    <div class="relative">
        @if($icon)
        <i class="fa-solid {{ $icon }} absolute left-4 top-1/2 -translate-y-1/2 text-white/35 text-sm pointer-events-none"></i>
        @endif
        <input id="{{ $name }}" name="{{ $name }}"
            @if($type === 'password') :type="show ? 'text' : 'password'" @else type="{{ $type }}" @endif
            {{ $attributes->merge(['class' => 'w-full h-12 rounded-xl bg-white/5 border text-base text-white placeholder:text-white/30 focus:bg-white/10 focus:outline-none transition-colors '
                . ($icon ? 'pl-11 ' : 'pl-4 ') . ($type === 'password' ? 'pr-12 ' : 'pr-4 ')
                . ($error ? 'border-red-400/70' : 'border-white/15 focus:border-brand-accent/60')]) }}>
        @if($type === 'password')
        <button type="button" @click="show = !show" tabindex="-1" aria-label="Tampilkan atau sembunyikan password"
            class="absolute right-1 top-1/2 -translate-y-1/2 w-10 h-10 flex items-center justify-center text-white/40 hover:text-white transition-colors">
            <i class="fa-solid text-sm" :class="show ? 'fa-eye-slash' : 'fa-eye'"></i>
        </button>
        @endif
    </div>
    @if($error)
    <p class="text-[11px] text-red-300 mt-1.5 flex items-center gap-1.5"><i class="fa-solid fa-circle-exclamation"></i>{{ $error }}</p>
    @elseif($hint)
    <p class="text-[11px] text-white/40 mt-1.5">{{ $hint }}</p>
    @endif
</div>
