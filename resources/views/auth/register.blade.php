@extends('auth.app')
@section('title', 'Daftar')
@section('brand', 'MUHAMMAD ANDI')

@section('aside')
<h2 class="font-sans font-extrabold text-3xl text-white tracking-tight leading-tight mb-3">Buat akun baru.</h2>
<p class="text-sm text-white/55 leading-relaxed">Daftarkan akun untuk mengelola panel dengan peran yang sesuai.</p>
@endsection

@section('content')
<div class="mb-7 text-center lg:text-left">
    <h1 class="font-sans font-extrabold text-2xl sm:text-3xl text-white tracking-tight">Buat Akun</h1>
    <p class="text-sm text-white/55 mt-1.5">Daftarkan akun baru Anda</p>
</div>

<form action="{{ route('register.post') }}" method="POST" class="space-y-4" x-data="{ loading: false }" @submit="loading = true">
    @csrf
    <x-auth.field name="name" label="Nama Lengkap" icon="fa-user" :value="old('name')" required autofocus
        autocomplete="name" placeholder="Nama lengkap" />
    <x-auth.field name="email" type="email" label="Email" icon="fa-envelope" :value="old('email')" required
        autocomplete="email" inputmode="email" placeholder="nama@email.com" />
    <x-auth.field name="password" type="password" label="Password" icon="fa-lock" required
        autocomplete="new-password" placeholder="Minimal 8 karakter" />

    <div>
        <label for="role" class="block text-xs font-semibold text-white/70 mb-1.5">Role</label>
        <div class="relative">
            <i class="fa-solid fa-user-shield absolute left-4 top-1/2 -translate-y-1/2 text-white/35 text-sm pointer-events-none"></i>
            <select id="role" name="role" required
                class="w-full h-12 appearance-none rounded-xl bg-white/5 border border-white/15 focus:border-brand-accent/60 focus:bg-white/10 focus:outline-none text-base text-white pl-11 pr-10 cursor-pointer transition-colors">
                @foreach(['admin' => 'Admin', 'super_admin' => 'Super Admin', 'editor' => 'Editor'] as $value => $label)
                <option value="{{ $value }}" class="bg-brand-mid text-white" @selected(old('role') === $value)>{{ $label }}</option>
                @endforeach
            </select>
            <i class="fa-solid fa-chevron-down absolute right-4 top-1/2 -translate-y-1/2 text-white/40 text-xs pointer-events-none"></i>
        </div>
        @error('role')<p class="text-[11px] text-red-300 mt-1.5">{{ $message }}</p>@enderror
    </div>

    <x-auth.button icon="fa-user-plus" class="mt-2">Daftar Akun</x-auth.button>
</form>

<p class="text-center text-xs text-white/50 mt-6">
    Sudah punya akun?
    <a href="{{ route('login') }}" class="font-bold text-brand-accent hover:text-white transition-colors">Masuk</a>
</p>
@endsection
