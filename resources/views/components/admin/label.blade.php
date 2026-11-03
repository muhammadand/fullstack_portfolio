@props(['for' => null, 'required' => false])

<label @if($for) for="{{ $for }}" @endif {{ $attributes->class('block text-sm font-medium text-slate-700 mb-1.5') }}>
    {{ $slot }}
    @if ($required)<span class="text-red-500">*</span>@endif
</label>
