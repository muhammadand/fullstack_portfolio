{{-- Teks bantuan di bawah field, otomatis diganti pesan error jika ada. --}}
@props(['for' => null])

@if ($for && $errors->has($for))
<p class="mt-1.5 text-xs text-red-600">{{ $errors->first($for) }}</p>
@elseif ($slot->isNotEmpty())
<p {{ $attributes->class('mt-1.5 text-xs text-slate-500') }}>{{ $slot }}</p>
@endif
