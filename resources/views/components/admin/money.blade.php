{{--
    Angka responsif: ringkas di HP (Rp 5,66 jt), lengkap di desktop (Rp 5.663.000). Nilai lengkap ada di title.
    Props: value, rupiah (default true). Contoh: <x-admin.money :value="$total" />, <x-admin.money :value="$klik" :rupiah="false" />
--}}
@props(['value' => 0, 'rupiah' => true])
@php $full = \App\Support\Num::full($value, $rupiah); $short = \App\Support\Num::compact($value, $rupiah); @endphp
<span {{ $attributes->class('admin-num whitespace-nowrap') }} title="{{ $full }}">@if($full === $short){{ $full }}@else<span class="lg:hidden">{{ $short }}</span><span class="hidden lg:inline">{{ $full }}</span>@endif</span>
