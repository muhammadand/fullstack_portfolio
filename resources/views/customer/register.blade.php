@extends('auth.app')
@section('title', 'Daftar')
@section('brand', 'Scalify Intelligence')

@section('aside')
<h2 class="font-sans font-extrabold text-3xl text-white tracking-tight leading-tight mb-3">Buat akun customer.</h2>
<p class="text-sm text-white/55 leading-relaxed">Gratis. Semua pesanan top up Anda akan tercatat di akun ini.</p>
@endsection

@section('content')
<div class="mb-7 text-center lg:text-left">
    <h1 class="font-sans font-extrabold text-2xl sm:text-3xl text-white tracking-tight">Daftar</h1>
    <p class="text-sm text-white/55 mt-1.5">Buat akun untuk mulai top up</p>
</div>

<form action="{{ route('customer.register.post') }}" method="POST" class="space-y-4" x-data="{ loading: false }" @submit="loading = true">
    @csrf
    <x-auth.field name="name" label="Nama Lengkap" icon="fa-user" :value="old('name')" required autofocus
        autocomplete="name" placeholder="Nama lengkap" />
    <x-auth.field name="email" type="email" label="Email" icon="fa-envelope" :value="old('email')" required
        autocomplete="email" inputmode="email" placeholder="nama@email.com" />
    <x-auth.field name="phone" type="tel" label="No. WhatsApp" icon="fa-phone" :value="old('phone')" optional
        autocomplete="tel" inputmode="tel" placeholder="08xxxxxxxxxx" />
    <x-auth.field name="password" type="password" label="Password" icon="fa-lock" required
        autocomplete="new-password" placeholder="Minimal 8 karakter" />

    <x-auth.button icon="fa-user-plus" class="mt-2">Daftar</x-auth.button>
</form>

<p class="text-center text-xs text-white/50 mt-6">
    Sudah punya akun?
    <a href="{{ route('customer.login') }}" class="font-bold text-brand-accent hover:text-white transition-colors">Masuk</a>
</p>
<a href="{{ route('topup.index') }}" class="mt-3 flex items-center justify-center gap-1.5 text-xs text-white/40 hover:text-white transition-colors">
    <i class="fa-solid fa-arrow-left text-[10px]"></i> Kembali ke Top Up Game
</a>
@endsection
