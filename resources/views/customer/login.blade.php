@extends('auth.app')
@section('title', 'Masuk')
@section('brand', 'Scalify Intelligence')

@section('aside')
<h2 class="font-sans font-extrabold text-3xl text-white tracking-tight leading-tight mb-3">Top up lebih cepat.</h2>
<p class="text-sm text-white/55 leading-relaxed mb-6">Masuk untuk menyimpan riwayat pesanan dan mengumpulkan poin di setiap transaksi.</p>
<ul class="space-y-3 text-sm text-white/70">
    @foreach([['fa-clock-rotate-left', 'Riwayat pesanan tersimpan'], ['fa-gift', 'Kumpulkan poin'], ['fa-bolt', 'Checkout tanpa isi ulang data']] as [$ic, $t])
    <li class="flex items-center gap-3"><span class="w-8 h-8 rounded-lg bg-white/5 border border-white/10 flex items-center justify-center text-brand-accent text-xs"><i class="fa-solid {{ $ic }}"></i></span>{{ $t }}</li>
    @endforeach
</ul>
@endsection

@section('content')
<div class="mb-7 text-center lg:text-left">
    <h1 class="font-sans font-extrabold text-2xl sm:text-3xl text-white tracking-tight">Masuk</h1>
    <p class="text-sm text-white/55 mt-1.5">Masuk ke akun customer Anda</p>
</div>

<form action="{{ route('customer.login.post') }}" method="POST" class="space-y-4" x-data="{ loading: false }" @submit="loading = true">
    @csrf
    <x-auth.field name="email" type="email" label="Email" icon="fa-envelope" :value="old('email')" required autofocus
        autocomplete="email" inputmode="email" placeholder="nama@email.com" />
    <x-auth.field name="password" type="password" label="Password" icon="fa-lock" required
        autocomplete="current-password" placeholder="Masukkan password" />

    <label class="flex items-center gap-2 text-xs text-white/60 cursor-pointer">
        <input type="checkbox" name="remember" value="1" class="rounded border-white/20 bg-white/5"> Ingat saya
    </label>

    <x-auth.button icon="fa-arrow-right-to-bracket" class="mt-2">Masuk</x-auth.button>
</form>

<p class="text-center text-xs text-white/50 mt-6">
    Belum punya akun?
    <a href="{{ route('customer.register') }}" class="font-bold text-brand-accent hover:text-white transition-colors">Daftar gratis</a>
</p>
<a href="{{ route('topup.index') }}" class="mt-3 flex items-center justify-center gap-1.5 text-xs text-white/40 hover:text-white transition-colors">
    <i class="fa-solid fa-arrow-left text-[10px]"></i> Kembali ke Top Up Game
</a>
@endsection
