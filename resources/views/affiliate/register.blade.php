@extends('auth.app')
@section('title', 'Daftar Partner')
@section('brand', 'SCALIFY PARTNER')

@section('aside')
<h2 class="font-sans font-extrabold text-3xl text-white tracking-tight leading-tight mb-3">Raih komisi tanpa batas.</h2>
<p class="text-sm text-white/55 leading-relaxed mb-6">Bergabung jadi Sobat Scalify Partner dan mulai dapatkan penghasilan dari setiap referral.</p>
<ul class="space-y-3 text-sm text-white/70">
    @foreach([['fa-coins', 'Komisi dari setiap transaksi'], ['fa-link', 'Link referral pribadi'], ['fa-mobile-screen', 'Aplikasi PWA, bisa diinstal']] as [$ic, $t])
    <li class="flex items-center gap-3"><span class="w-8 h-8 rounded-lg bg-white/5 border border-white/10 flex items-center justify-center text-brand-accent text-xs"><i class="fa-solid {{ $ic }}"></i></span>{{ $t }}</li>
    @endforeach
</ul>
@endsection

@section('content')
<div class="mb-7 text-center lg:text-left">
    <h1 class="font-sans font-extrabold text-2xl sm:text-3xl text-white tracking-tight">Daftar Partner</h1>
    <p class="text-sm text-white/55 mt-1.5">Mulai langkah Anda meraih komisi</p>
</div>

<form action="{{ route('affiliate.register.submit') }}" method="POST" class="space-y-4" x-data="{ loading: false }" @submit="loading = true">
    @csrf
    <x-auth.field name="name" label="Nama Lengkap" icon="fa-user" :value="old('name')" required autofocus
        autocomplete="name" placeholder="Nama lengkap Anda" />
    <x-auth.field name="email" type="email" label="Email" icon="fa-envelope" :value="old('email')" required
        autocomplete="email" inputmode="email" placeholder="nama@email.com" />
    <x-auth.field name="password" type="password" label="Password" icon="fa-lock" required
        autocomplete="new-password" placeholder="Minimal 6 karakter" />

    @if(!empty($referrer))
    <div class="flex items-center justify-between gap-3 p-3 rounded-xl bg-brand-blue/10 border border-brand-accent/25">
        <div class="flex items-center gap-3 min-w-0">
            <span class="w-9 h-9 shrink-0 rounded-lg bg-brand-blue/20 text-brand-accent flex items-center justify-center text-sm"><i class="fa-solid fa-user-check"></i></span>
            <div class="min-w-0">
                <p class="text-[10px] text-white/50">Diundang oleh partner</p>
                <p class="text-sm font-bold text-white truncate">{{ $referrer->name }}</p>
            </div>
        </div>
        <span class="shrink-0 px-2 py-1 rounded-md bg-white/10 text-brand-accent font-mono text-[11px] font-bold">{{ $refCode }}</span>
        <input type="hidden" name="referral_code" value="{{ $refCode }}">
    </div>
    @else
    <x-auth.field name="referral_code" label="Kode Referral" icon="fa-gift" optional :value="old('referral_code', $refCode ?? '')"
        class="uppercase font-mono tracking-wider" placeholder="Contoh: BUDI99" autocomplete="off" />
    @endif

    <x-auth.button icon="fa-user-plus" class="mt-2">Daftar Sebagai Partner</x-auth.button>
</form>

<p class="text-center text-xs text-white/50 mt-6">
    Sudah punya akun partner?
    <a href="{{ route('affiliate.login') }}" class="font-bold text-brand-accent hover:text-white transition-colors">Masuk</a>
</p>
<a href="{{ url('/sobat-scalify') }}" class="mt-3 flex items-center justify-center gap-1.5 text-xs text-white/40 hover:text-white transition-colors">
    <i class="fa-solid fa-arrow-left text-[10px]"></i> Kembali ke Sobat Scalify
</a>
@endsection
