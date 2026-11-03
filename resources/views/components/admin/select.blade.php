{{-- Select standar. Props: options (id => label), selected, placeholder. --}}
@props(['name', 'options' => [], 'selected' => null, 'placeholder' => null])

<select name="{{ $name }}" {{ $attributes->class([
    'w-full rounded-lg border bg-white px-3 py-2 text-sm text-slate-900 transition-colors focus:outline-none focus:ring-2',
    'border-red-400 focus:border-red-500 focus:ring-red-500/20' => $errors->has($name),
    'border-slate-300 focus:border-blue-500 focus:ring-blue-500/20' => !$errors->has($name),
]) }}>
    @if ($placeholder)
    <option value="">{{ $placeholder }}</option>
    @endif
    @foreach ($options as $value => $label)
    <option value="{{ $value }}" @selected((string) $selected === (string) $value)>{{ $label }}</option>
    @endforeach
</select>
