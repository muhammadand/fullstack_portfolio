@props(['icon' => null, 'variant' => 'primary'])

{{-- Butuh scope Alpine { loading } dari <form>. --}}
<button {{ $attributes->merge(['type' => 'submit', 'class' => 'w-full h-12 rounded-xl font-bold text-sm flex items-center justify-center gap-2 transition-all active:scale-[0.98] disabled:opacity-70 disabled:cursor-not-allowed '
    . ($variant === 'primary' ? 'bg-btn-gradient text-white shadow-glow-sm hover:shadow-glow-blue' : 'bg-white/5 border border-white/15 text-white/85 hover:bg-white/10')]) }}
    :disabled="loading">
    <i x-show="loading" style="display:none" class="fa-solid fa-circle-notch fa-spin"></i>
    @if($icon)<i x-show="!loading" class="fa-solid {{ $icon }} text-xs"></i>@endif
    <span>{{ $slot }}</span>
</button>
