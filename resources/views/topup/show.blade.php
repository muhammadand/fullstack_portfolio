@extends('layouts.app')

@section('meta_tags')
@php $gameName = $brand['name']; @endphp
<title>Top Up {{ $gameName }} Murah, Cepat &amp; Aman | Scalify Intelligence</title>
<meta name="description" content="Top up {{ $gameName }} murah dan proses otomatis 24 jam. Masukkan ID game, pilih nominal, bayar via QRIS." />
<meta name="robots" content="index, follow" />
<link rel="canonical" href="{{ url()->current() }}" />
<meta property="og:type" content="website" />
<meta property="og:url" content="{{ url()->current() }}" />
<meta property="og:site_name" content="Scalify Intelligence" />
<meta property="og:locale" content="id_ID" />
<meta property="og:title" content="Top Up {{ $gameName }} Murah, Cepat &amp; Aman" />
<meta property="og:description" content="Top up {{ $gameName }} otomatis 24 jam. Cukup masukkan ID dan bayar via QRIS." />
<meta property="og:image" content="{{ $brand['image'] ? asset('storage/' . $brand['image']) : asset('og-image.png') }}" />
<meta name="twitter:card" content="summary_large_image" />
@endsection

@section('content')
@php
$fields = $form['fields'];
$state = [
    'fields' => $fields,
    'products' => collect($products)->keyBy('id')->all(),
    'checkoutUrl' => route('topup.checkout', $brand['slug']),
    'statusUrl' => route('topup.order.status', '__NO__'),
    'email' => auth('customer')->user()?->email ?? '',
];
$n = count($fields) > 0 ? 2 : 1; // nomor langkah "Pilih Nominal"
@endphp

<div x-data="topupForm(@js($state))" class="bg-brand-dark min-h-screen pb-32 lg:pb-16">

    {{-- Breadcrumb --}}
    <nav class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 pt-5 pb-3 text-xs text-white/50 flex items-center gap-1.5" aria-label="Breadcrumb">
        <a href="{{ route('topup.index') }}" class="hover:text-white transition-colors">Top Up Game</a>
        <i class="fa-solid fa-chevron-right text-[8px]"></i>
        <span class="text-white/80 truncate">{{ $gameName }}</span>
    </nav>

    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 lg:grid lg:grid-cols-[320px_1fr] lg:gap-8 lg:items-start">

        @include('topup.partials.show.info')

        <form @submit.prevent="submit" class="space-y-4" novalidate>
            @if(count($fields) > 0)
                @include('topup.partials.show.account')
            @endif
            @include('topup.partials.show.nominal')
            @include('topup.partials.show.email')
            @include('topup.partials.show.note')
            @include('topup.partials.show.checkout-bar')
        </form>
    </div>

    @include('topup.partials.show.payment-modal')
</div>

@include('topup.partials.show.script')
@endsection
