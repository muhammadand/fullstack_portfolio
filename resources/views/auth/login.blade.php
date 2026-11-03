@extends('auth.app')
@section('title', 'Masuk')
@section('brand', 'MUHAMMAD ANDI')

@section('aside')
<h2 class="font-sans font-extrabold text-3xl text-white tracking-tight leading-tight mb-3">Selamat datang kembali.</h2>
<p class="text-sm text-white/55 leading-relaxed mb-6">Kelola konten, produk, dan bisnis Anda dari satu panel yang rapi.</p>
<ul class="space-y-3 text-sm text-white/70">
    @foreach([['fa-gauge-high', 'Dashboard ringkas'], ['fa-box', 'Produk & katalog terpusat'], ['fa-shield-halved', 'Akses aman & terenkripsi']] as [$ic, $t])
    <li class="flex items-center gap-3"><span class="w-8 h-8 rounded-lg bg-white/5 border border-white/10 flex items-center justify-center text-brand-accent text-xs"><i class="fa-solid {{ $ic }}"></i></span>{{ $t }}</li>
    @endforeach
</ul>
@endsection

@section('content')
<div class="mb-7 text-center lg:text-left">
    <h1 class="font-sans font-extrabold text-2xl sm:text-3xl text-white tracking-tight">Masuk</h1>
    <p class="text-sm text-white/55 mt-1.5">Masuk ke panel admin Anda</p>
</div>

<form action="{{ route('login.post') }}" method="POST" class="space-y-4" x-data="{ loading: false }" @submit="loading = true">
    @csrf
    <x-auth.field name="email" type="email" label="Email" icon="fa-envelope" :value="old('email')" required autofocus
        autocomplete="email" inputmode="email" placeholder="nama@email.com" />

    <x-auth.field name="password" type="password" label="Password" icon="fa-lock" required
        autocomplete="current-password" placeholder="Masukkan password">
        <x-slot:aside><a href="#" class="text-[11px] font-medium text-brand-accent hover:text-white transition-colors">Lupa password?</a></x-slot:aside>
    </x-auth.field>

    <x-auth.button icon="fa-arrow-right-to-bracket" class="mt-2">Masuk ke Dashboard</x-auth.button>
</form>

<p class="text-center text-xs text-white/50 mt-6">
    Belum punya akun?
    <a href="{{ route('register') }}" class="font-bold text-brand-accent hover:text-white transition-colors">Daftar</a>
</p>
<a href="{{ route('index.company.profile') }}" class="mt-3 flex items-center justify-center gap-1.5 text-xs text-white/40 hover:text-white transition-colors">
    <i class="fa-solid fa-arrow-left text-[10px]"></i> Kembali ke halaman utama
</a>
@endsection
