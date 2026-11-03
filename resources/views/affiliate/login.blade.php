@extends('auth.app')
@section('title', 'Login Partner')
@section('brand', 'SCALIFY PARTNER')

@section('aside')
<h2 class="font-sans font-extrabold text-3xl text-white tracking-tight leading-tight mb-3">Sobat Scalify Partner</h2>
<p class="text-sm text-white/55 leading-relaxed mb-6">Masuk instan dengan <strong class="text-white/80">Magic Link</strong> tanpa perlu mengingat password. Sesi Anda tersimpan di aplikasi PWA ini.</p>
<span class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-white/5 border border-white/10 text-white/70 text-xs font-semibold">
    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>PWA Ready · Sesi Permanen
</span>
@endsection

@section('content')
<div class="mb-6 text-center lg:text-left">
    <h1 class="font-sans font-extrabold text-2xl sm:text-3xl text-white tracking-tight">Login Partner</h1>
    <p class="text-sm text-white/55 mt-1.5">Tempel Magic Link atau masuk dengan email</p>
</div>

{{-- Magic Link --}}
<div class="p-4 rounded-2xl bg-brand-blue/10 border border-brand-accent/25 mb-5">
    <div class="flex items-center gap-2.5 mb-1">
        <span class="w-7 h-7 rounded-lg bg-brand-blue/25 text-brand-accent flex items-center justify-center text-xs"><i class="fa-solid fa-wand-magic-sparkles"></i></span>
        <h2 class="text-sm font-bold text-white">Login Cepat dengan Magic Link</h2>
    </div>
    <p class="text-xs text-white/55 mb-3 leading-relaxed">Tempel link akses unik yang Anda miliki.</p>

    <form id="magic-link-form" onsubmit="handleMagicSubmit(event)" class="space-y-3">
        <div class="relative">
            <input type="text" id="magic_link_input" required autocomplete="off" inputmode="url" placeholder="https://.../partner/magic-login/..."
                class="w-full h-12 rounded-xl bg-white/5 border border-white/15 focus:border-brand-accent/60 focus:bg-white/10 focus:outline-none text-base text-white placeholder:text-white/30 pl-4 pr-24 transition-colors">
            <button type="button" id="paste-btn" onclick="pasteFromClipboard()"
                class="absolute right-1.5 top-1/2 -translate-y-1/2 h-9 px-3 rounded-lg bg-white/10 hover:bg-white/15 text-white/80 text-xs font-semibold flex items-center gap-1.5 transition-colors">
                <i class="fa-regular fa-clipboard"></i>Paste
            </button>
        </div>
        <button type="submit" id="magic-submit-btn"
            class="w-full h-12 rounded-xl bg-btn-gradient text-white font-bold text-sm shadow-glow-sm hover:shadow-glow-blue flex items-center justify-center gap-2 transition-all active:scale-[0.98]">
            <i class="fa-solid fa-arrow-right-to-bracket text-xs"></i><span id="magic-btn-text">Masuk Instan</span>
        </button>
    </form>
</div>

{{-- Email & password (terbuka otomatis bila ada error) --}}
<div x-data="{ open: {{ $errors->any() ? 'true' : 'false' }} }">
    <button type="button" @click="open = !open" :aria-expanded="open"
        class="w-full flex items-center gap-3 text-xs text-white/50 hover:text-white transition-colors py-1">
        <span class="flex-1 h-px bg-white/10"></span>
        <span class="flex items-center gap-1.5 font-medium">Atau masuk dengan email <i class="fa-solid fa-chevron-down text-[9px] transition-transform" :class="open && 'rotate-180'"></i></span>
        <span class="flex-1 h-px bg-white/10"></span>
    </button>

    <form x-show="open" x-transition.opacity style="display:none" action="{{ route('affiliate.login.submit') }}" method="POST"
        class="space-y-4 mt-4" x-data="{ loading: false }" @submit="loading = true">
        @csrf
        <x-auth.field name="email" type="email" label="Email" icon="fa-envelope" :value="old('email')"
            autocomplete="email" inputmode="email" placeholder="nama@email.com" />
        <x-auth.field name="password" type="password" label="Password" icon="fa-lock"
            autocomplete="current-password" placeholder="Masukkan password" />
        <x-auth.button variant="secondary" icon="fa-envelope">Login via Email</x-auth.button>
    </form>
</div>

<p class="text-center text-xs text-white/50 mt-6">
    Belum punya akun?
    <a href="{{ route('affiliate.register') }}" class="font-bold text-brand-accent hover:text-white transition-colors">Daftar</a>
</p>
<a href="{{ url('/sobat-scalify') }}" class="mt-3 flex items-center justify-center gap-1.5 text-xs text-white/40 hover:text-white transition-colors">
    <i class="fa-solid fa-arrow-left text-[10px]"></i> Kembali ke Sobat Scalify
</a>

<script>
    // Magic Login via GET (bebas masalah CSRF / 419 Page Expired)
    function executeMagicLogin() {
        const input = document.getElementById('magic_link_input');
        const val = input.value.trim();
        const btnText = document.getElementById('magic-btn-text');

        if (!val) {
            scalifyToast('warning', 'Tempel Magic Link Anda terlebih dahulu.');
            input.focus();
            return;
        }

        if (!val.includes('/partner/magic-login/')) {
            scalifyAlert('error', 'Format link tidak sesuai', 'Pastikan link yang Anda tempel mengandung "/partner/magic-login/...".');
            return;
        }

        btnText.textContent = 'Memverifikasi...';

        try {
            if (val.startsWith('http://') || val.startsWith('https://')) {
                const parsed = new URL(val);
                window.location.href = parsed.pathname + parsed.search;
            } else {
                window.location.href = val.startsWith('/') ? val : '/' + val;
            }
        } catch (e) {
            window.location.href = val;
        }
    }

    function handleMagicSubmit(e) {
        e.preventDefault();
        executeMagicLogin();
    }

    async function pasteFromClipboard() {
        const input = document.getElementById('magic_link_input');
        try {
            const text = (await navigator.clipboard.readText()).trim();
            if (text) {
                input.value = text;
                input.focus();
                if (text.includes('/partner/magic-login/')) executeMagicLogin();
            }
        } catch (err) {
            input.focus();
            scalifyToast('info', 'Tempel link secara manual di kolom ini.');
        }
    }

    // Auto-submit saat paste langsung (Ctrl+V / tekan lama di HP)
    document.getElementById('magic_link_input').addEventListener('paste', function () {
        setTimeout(() => {
            if (this.value.trim().includes('/partner/magic-login/')) executeMagicLogin();
        }, 150);
    });
</script>
@endsection
