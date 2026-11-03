{{-- Input teks standar. Border merah otomatis jika ada error untuk "name". --}}
@props(['name'])

@php $field = rtrim(str_replace(['[', ']'], ['.', ''], $name), '.'); @endphp

<input name="{{ $name }}" {{ $attributes->merge(['type' => 'text'])->class([
    'w-full rounded-lg border bg-white px-3 py-2 text-sm text-slate-900 placeholder:text-slate-400 transition-colors focus:outline-none focus:ring-2',
    'border-red-400 focus:border-red-500 focus:ring-red-500/20' => $errors->has($field),
    'border-slate-300 focus:border-blue-500 focus:ring-blue-500/20' => !$errors->has($field),
]) }}>
