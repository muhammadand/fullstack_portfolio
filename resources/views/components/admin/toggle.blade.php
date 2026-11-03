{{--
    Toggle switch (checkbox). Selalu mengirim 0 saat tidak dicentang,
    supaya status bisa dimatikan lagi ketika update.
--}}
@props(['name', 'label', 'checked' => false, 'description' => null])

<label class="flex items-center justify-between gap-4 cursor-pointer">
    <span>
        <span class="block text-sm font-medium text-slate-700">{{ $label }}</span>
        @if ($description)
        <span class="block text-xs text-slate-500">{{ $description }}</span>
        @endif
    </span>
    <span class="relative inline-flex shrink-0">
        <input type="hidden" name="{{ $name }}" value="0">
        <input type="checkbox" name="{{ $name }}" value="1" @checked($checked) {{ $attributes->class('peer sr-only') }}>
        <span class="w-9 h-5 rounded-full bg-slate-200 transition-colors peer-checked:bg-blue-600 peer-focus-visible:ring-2 peer-focus-visible:ring-blue-500/40"></span>
        <span class="absolute top-0.5 left-0.5 w-4 h-4 rounded-full bg-white shadow-sm transition-transform peer-checked:translate-x-4"></span>
    </span>
</label>
