@extends('auth.app')

@section('content')
<div class="min-h-screen flex items-center justify-center p-4 sm:p-8 relative z-10">
    <!-- Main Glass Container -->
    <div class="w-full max-w-7xl md:min-h-[620px] glass-panel rounded-2xl sm:rounded-3xl shadow-[0_8px_32px_0_rgba(0,0,0,0.4)] flex flex-col md:flex-row overflow-hidden border border-white/10">

        <!-- Left Side - Illustration / Brand Info -->
        <div class="hidden lg:flex lg:w-1/2 items-center justify-center p-16 relative border-r border-white/10" style="background: radial-gradient(circle at center, rgba(99,102,241,0.15) 0%, transparent 70%);">

            <!-- Floating Shapes -->
            <div class="floating-shape absolute top-20 left-16 w-20 h-20 rounded-xl"></div>
            <div class="floating-shape absolute top-40 right-24 w-16 h-16 rounded-full"></div>
            <div class="floating-shape absolute bottom-32 left-32 w-24 h-24 rounded-2xl"></div>
            <div class="floating-shape absolute bottom-20 right-16 w-14 h-14 rounded-lg"></div>

            <!-- Main Illustration -->
            <div class="relative z-10 text-center">
                <div class="w-24 h-24 bg-gradient-to-br from-indigo-500/20 to-blue-500/20 backdrop-blur-md rounded-2xl border border-indigo-400/30 shadow-2xl flex items-center justify-center mx-auto mb-8">
                    <i class="fa-solid fa-wand-magic-sparkles text-5xl text-indigo-400 drop-shadow-[0_0_15px_rgba(99,102,241,0.5)]"></i>
                </div>
                <h2 class="text-3xl font-extrabold text-white mb-4 tracking-tight drop-shadow-md">Sobat Scalify Partner</h2>
                <p class="text-indigo-100/80 text-base max-w-md mx-auto leading-relaxed">
                    Masuk secara instan menggunakan <strong>Magic Link</strong> tanpa perlu mengingat password. Sesi Anda akan tersimpan <strong>selamanya</strong> di aplikasi PWA ini.
                </p>

                <!-- PWA Install Badge -->
                <div class="mt-8 inline-flex items-center gap-2.5 px-4 py-2 rounded-full bg-indigo-500/10 border border-indigo-400/20 text-indigo-300 text-xs font-semibold backdrop-blur-md">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 shadow-[0_0_8px_#34d399]"></span>
                    PWA Ready · Sesi Permanen Aktif
                </div>
            </div>
        </div>

        <!-- Right Side - Form -->
        <div class="w-full lg:w-1/2 flex items-center justify-center p-6 sm:p-8 lg:p-10 relative flex-1">
            <div class="w-full max-w-md my-auto pb-4 sm:pb-0">

                <!-- Header -->
                <div class="mb-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 bg-gradient-to-tr from-indigo-600 to-blue-500 rounded-xl flex items-center justify-center shadow-[0_0_18px_rgba(99,102,241,0.6)]">
                                <i class="fa-solid fa-bolt text-white text-sm"></i>
                            </div>
                            <span class="text-lg font-extrabold tracking-wider text-white drop-shadow-sm">SCALIFY PARTNER</span>
                        </div>

                        <!-- Register Button -->
                        <div class="flex items-center gap-2">
                            <a href="{{ route('affiliate.register') }}" class="text-xs font-bold text-indigo-200 border border-indigo-500/30 bg-indigo-500/10 px-3.5 py-1.5 rounded-lg hover:bg-indigo-500/20 transition-all shadow-sm backdrop-blur-sm">
                                REGISTER
                            </a>
                        </div>
                    </div>

                    <h1 class="text-2xl sm:text-3xl font-extrabold text-white mb-1 tracking-tight">Login Partner</h1>
                    <p class="text-indigo-200/70 text-xs sm:text-sm">Tempelkan Magic Link atau gunakan akun email Anda</p>
                </div>

                {{-- Alert Messages --}}
                @if(session('error'))
                <div class="bg-rose-500/15 backdrop-blur-md text-rose-200 p-3.5 rounded-xl mb-5 text-sm border border-rose-500/30 shadow-lg flex items-center gap-3">
                    <i class="fa-solid fa-circle-exclamation text-lg text-rose-400"></i>
                    <p>{{ session('error') }}</p>
                </div>
                @endif

                @if(session('success'))
                <div class="bg-emerald-500/15 backdrop-blur-md text-emerald-200 p-3.5 rounded-xl mb-5 text-sm border border-emerald-500/30 shadow-lg flex items-center gap-3">
                    <i class="fa-solid fa-circle-check text-lg text-emerald-400"></i>
                    <p>{{ session('success') }}</p>
                </div>
                @endif

                @if ($errors->any())
                <div class="bg-rose-500/15 backdrop-blur-md text-rose-200 p-3.5 rounded-xl mb-5 text-sm border border-rose-500/30 shadow-lg">
                    <ul class="list-disc ml-4 space-y-1">
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <!-- METHOD 1: MAGIC LINK LOGIN (100% DIRECT GET NAVIGATION - BEBAS DARI ERROR 419 PAGE EXPIRED) -->
                <div class="bg-gradient-to-b from-indigo-950/40 to-slate-900/60 border border-indigo-500/30 rounded-2xl p-5 mb-5 backdrop-blur-md shadow-xl relative overflow-hidden">
                    <div class="flex items-center gap-2 mb-3">
                        <div class="w-6 h-6 rounded-lg bg-indigo-500/20 text-indigo-400 flex items-center justify-center text-xs">
                            <i class="fa-solid fa-wand-magic-sparkles"></i>
                        </div>
                        <h2 class="text-sm font-bold text-white tracking-wide">Login Cepat dengan Magic Link</h2>
                    </div>
                    <p class="text-xs text-indigo-200/70 mb-3.5 leading-relaxed">
                        Cukup tempel link akses unik yang Anda dapatkan (dari Admin atau dashboard):
                    </p>

                    <form id="magic-link-form" onsubmit="handleMagicSubmit(event)" class="space-y-3">
                        <div class="relative">
                            <input type="text" id="magic_link_input" placeholder="Tempel link https://.../partner/magic-login/..." class="w-full glass-input rounded-xl px-3.5 py-3 pr-24 text-xs sm:text-sm placeholder-indigo-300/40 text-white border-indigo-400/30 focus:border-indigo-400" autocomplete="off" required />
                            <button type="button" id="paste-btn" onclick="pasteFromClipboard()" class="absolute right-2 top-1/2 -translate-y-1/2 px-2.5 py-1.5 rounded-lg bg-indigo-500/20 hover:bg-indigo-500/30 text-indigo-300 border border-indigo-400/30 text-xs font-semibold transition-all flex items-center gap-1.5 cursor-pointer" title="Tempel dari Clipboard">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                </svg>
                                <span>Paste</span>
                            </button>
                        </div>

                        <button type="button" id="magic-submit-btn" onclick="executeMagicLogin()" class="w-full bg-gradient-to-r from-indigo-600 via-blue-600 to-indigo-600 hover:from-indigo-500 hover:to-blue-500 text-white py-3 rounded-xl font-bold text-sm shadow-[0_0_25px_rgba(99,102,241,0.4)] hover:shadow-[0_0_30px_rgba(99,102,241,0.6)] transition-all duration-300 transform hover:-translate-y-0.5 flex items-center justify-center gap-2 cursor-pointer">
                            <i class="fa-solid fa-arrow-right-to-bracket text-xs"></i>
                            <span id="magic-btn-text">Masuk Instan (Tanpa Password)</span>
                        </button>
                    </form>
                </div>

                <!-- DIVIDER / ACCORDION TOGGLE -->
                <div class="relative my-4 text-center">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-white/10"></div>
                    </div>
                    <button type="button" onclick="toggleEmailForm()" class="relative px-3 py-1 bg-slate-900/90 text-xs text-indigo-300/80 hover:text-white rounded-full border border-white/10 hover:border-indigo-500/30 transition-all font-medium inline-flex items-center gap-1.5 cursor-pointer">
                        <span id="toggle-text">Atau masuk dengan Email & Password</span>
                        <i id="toggle-icon" class="fa-solid fa-chevron-down text-[10px] transition-transform duration-200"></i>
                    </button>
                </div>

                <!-- METHOD 2: EMAIL & PASSWORD (COLLAPSIBLE) -->
                <div id="email-password-section" class="hidden transition-all duration-300">
                    <form action="{{ route('affiliate.login.submit') }}" method="POST" class="space-y-3.5 bg-white/[0.02] border border-white/5 rounded-2xl p-4">
                        @csrf

                        <!-- Email -->
                        <div>
                            <label class="block text-indigo-100/80 font-medium mb-1 text-xs">Email Address</label>
                            <input type="email" name="email" value="{{ old('email') }}" class="w-full glass-input rounded-xl px-3.5 py-2.5 text-xs sm:text-sm placeholder-slate-400 text-white" placeholder="email@domain.com">
                        </div>

                        <!-- Password -->
                        <div>
                            <label class="block text-indigo-100/80 font-medium mb-1 text-xs">Password</label>
                            <div class="relative">
                                <input type="password" name="password" id="password" class="w-full glass-input rounded-xl px-3.5 py-2.5 pr-10 text-xs sm:text-sm placeholder-slate-400 text-white" placeholder="••••••••">
                                <button type="button" onclick="togglePassword()" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-white transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="w-full bg-slate-800 hover:bg-slate-700 text-indigo-200 hover:text-white py-2.5 rounded-xl font-bold text-xs border border-white/10 transition-all cursor-pointer">
                            Login via Email
                        </button>
                    </form>
                </div>

                <div class="mt-5 text-center">
                    <a href="{{ url('/sobat-scalify') }}" class="text-indigo-200/60 text-xs hover:text-white transition-colors inline-flex items-center gap-1.5">
                        <i class="fa-solid fa-arrow-left text-[10px]"></i>
                        Kembali ke Sobat Scalify
                    </a>
                </div>

            </div>
        </div>

    </div>
</div>

<script>
    // Fungsi Eksekusi Magic Login Langsung via GET (Bebas dari Masalah CSRF / 419 Page Expired)
    function executeMagicLogin() {
        const input = document.getElementById('magic_link_input');
        let val = input.value.trim();

        if (!val) {
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    toast: true
                    , position: 'top-end'
                    , icon: 'warning'
                    , title: 'Silakan tempel Magic Link Anda terlebih dahulu.'
                    , background: '#1E293B'
                    , color: '#fff'
                    , showConfirmButton: false
                    , timer: 3000
                    , timerProgressBar: true
                });
            } else {
                alert('Silakan tempel Magic Link Anda terlebih dahulu.');
            }
            input.focus();
            return;
        }

        // Tampilkan status loading pada tombol
        const btnText = document.getElementById('magic-btn-text');
        if (btnText) btnText.textContent = 'Memverifikasi & Masuk...';

        // 1. Jika link lengkap dengan domain (misal http://127.0.0.1:8000/partner/magic-login/... atau domain live)
        if (val.includes('/partner/magic-login/')) {
            try {
                // Parse URL untuk memastikan diarahkan ke path yang tepat
                if (val.startsWith('http://') || val.startsWith('https://')) {
                    const parsed = new URL(val);
                    // Arahkan ke path & query string lokal / saat ini
                    window.location.href = parsed.pathname + parsed.search;
                } else {
                    window.location.href = val.startsWith('/') ? val : ('/' + val);
                }
            } catch (e) {
                window.location.href = val;
            }
            return;
        }

        // 2. Jika format tidak dikenali
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                icon: 'error'
                , title: 'Format Link Tidak Sesuai'
                , text: 'Pastikan link yang Anda tempel mengandung "/partner/magic-login/..."'
                , background: '#1E293B'
                , color: '#fff'
            });
        } else {
            alert('Format Magic Link tidak valid. Pastikan link mengandung /partner/magic-login/...');
        }

        if (btnText) btnText.textContent = 'Masuk Instan (Tanpa Password)';
    }

    // Intercept Enter key pada form
    function handleMagicSubmit(e) {
        e.preventDefault();
        executeMagicLogin();
    }

    // 1-Click Paste Clipboard
    async function pasteFromClipboard() {
        try {
            const text = await navigator.clipboard.readText();
            if (text) {
                const input = document.getElementById('magic_link_input');
                input.value = text.trim();
                input.focus();

                // Auto trigger login jika link valid
                if (text.includes('/partner/magic-login/')) {
                    executeMagicLogin();
                }
            }
        } catch (err) {
            console.log('Clipboard access denied or unavailable', err);
            const input = document.getElementById('magic_link_input');
            input.focus();
            input.select();
        }
    }

    // Auto submit jika user paste langsung via keyboard (Ctrl+V / Long Press di HP)
    document.getElementById('magic_link_input').addEventListener('paste', function(e) {
        setTimeout(() => {
            const val = this.value.trim();
            if (val.includes('/partner/magic-login/')) {
                executeMagicLogin();
            }
        }, 150);
    });

    // Toggle email form
    function toggleEmailForm() {
        const sec = document.getElementById('email-password-section');
        const icon = document.getElementById('toggle-icon');
        if (sec.classList.contains('hidden')) {
            sec.classList.remove('hidden');
            icon.classList.add('rotate-180');
        } else {
            sec.classList.add('hidden');
            icon.classList.remove('rotate-180');
        }
    }

</script>
@endsection
