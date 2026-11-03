@extends('layouts.app')

@section('meta_tags')
<title>Top Up Game Murah, Cepat &amp; Aman — Voucher &amp; Diamond Game Favorit | Scalify Intelligence</title>
<meta name="title" content="Top Up Game Murah, Cepat &amp; Aman | Scalify Intelligence" />
<meta name="description" content="Top up diamond, voucher, dan item game favoritmu dengan harga terjangkau. Proses otomatis 24 jam, cukup masukkan ID game dan bayar via QRIS." />
<meta name="keywords" content="top up game murah, top up diamond, voucher game, topup mobile legends, topup free fire, topup game otomatis 24 jam" />
<meta name="author" content="Scalify Intelligence" />
<meta name="robots" content="index, follow" />
<link rel="canonical" href="{{ url()->current() }}" />

<meta property="og:type" content="website" />
<meta property="og:url" content="{{ url()->current() }}" />
<meta property="og:site_name" content="Scalify Intelligence" />
<meta property="og:locale" content="id_ID" />
<meta property="og:title" content="Top Up Game Murah, Cepat &amp; Aman" />
<meta property="og:description" content="Top up diamond, voucher, dan item game favoritmu. Proses otomatis 24 jam." />
<meta property="og:image" content="{{ asset('og-image.png') }}" />
<meta name="twitter:card" content="summary_large_image" />
@endsection

@section('content')
@php
$brands = $catalog['brands'] ?? [];
// slug => nama huruf kecil, dipakai Alpine untuk filter pencarian di sisi browser (tanpa request tambahan).
$searchIndex = collect($brands)->mapWithKeys(fn ($b) => [$b['slug'] => mb_strtolower($b['name'])])->all();
@endphp

<div x-data="{ q: '', all: @js($searchIndex), get visible() { const q = this.q.trim().toLowerCase(); return Object.keys(this.all).filter(s => this.all[s].includes(q)); } }">
    {{-- 1. Hero + pencarian brand --}}
    @include('topup.partials.hero')

    {{-- 2. Kategori Games + daftar brand --}}
    @include('topup.partials.brands')
</div>

{{-- 3. Keunggulan singkat --}}
@include('topup.partials.perks')

@endsection
