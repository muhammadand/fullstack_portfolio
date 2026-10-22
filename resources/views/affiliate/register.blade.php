@extends('auth.app')

@section('content')
<div class="min-h-screen lg:h-screen lg:overflow-hidden flex items-center justify-center p-3 sm:p-4 md:p-6 relative z-10">
    <!-- Main Glass Container -->
    <div class="w-full max-w-6xl max-h-[94vh] glass-panel rounded-2xl sm:rounded-3xl shadow-[0_8px_32px_0_rgba(0,0,0,0.4)] flex flex-col md:flex-row overflow-hidden border border-white/10 my-auto">

        <!-- Left Side - Illustration / Brand Info -->
        <div class="hidden lg:flex lg:w-1/2 items-center justify-center p-8 lg:p-10 relative border-r border-white/10" style="background: radial-gradient(circle at center, rgba(99,102,241,0.15) 0%, transparent 70%);">

            <!-- Floating Shapes -->
            <div class="floating-shape absolute top-16 left-12 w-16 h-16 rounded-xl"></div>
            <div class="floating-shape absolute top-32 right-16 w-12 h-12 rounded-full"></div>
            <div class="floating-shape absolute bottom-24 left-24 w-16 h-16 rounded-2xl"></div>
            <div class="floating-shape absolute bottom-12 right-12 w-10 h-10 rounded-lg"></div>

            <!-- Main Illustration & Info -->
            <div class="relative z-10 text-center max-w-sm mx-auto">
                <div class="w-16 h-16 sm:w-20 sm:h-20 bg-gradient-to-br from-indigo-500/20 to-blue-500/20 backdrop-blur-md rounded-2xl border border-indigo-400/30 shadow-2xl flex items-center justify-center mx-auto mb-4">
                    <i class="fa-solid fa-handshake-angle text-3xl sm:text-4xl text-indigo-400 drop-shadow-[0_0_15px_rgba(99,102,241,0.5)]"></i>
                </div>
                <h2 class="text-2xl font-extrabold text-white mb-2 tracking-tight drop-shadow-md">Sobat Scalify Partner</h2>
                <p class="text-indigo-100/80 text-xs sm:text-sm leading-relaxed mb-5">
                    Dapatkan komisi uang tunai dari setiap project yang berhasil closing. Pantau komisi Anda secara real-time dan transparan.
                </p>

                <!-- Feature Badges -->
                <div class="flex flex-wrap items-center justify-center gap-1.5">
                    <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-indigo-500/10 border border-indigo-400/20 text-indigo-300 text-[11px] font-semibold backdrop-blur-md">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 shadow-[0_0_8px_#34d399]"></span>
                        Pendaftaran Gratis
                    </div>
                    <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-indigo-500/10 border border-indigo-400/20 text-indigo-300 text-[11px] font-semibold backdrop-blur-md">
                        <i class="fa-solid fa-bolt text-amber-400 text-[9px]"></i>
                        Komisi Langsung Aktif
                    </div>
                    <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-indigo-500/10 border border-indigo-400/20 text-indigo-300 text-[11px] font-semibold backdrop-blur-md">
                        <i class="fa-solid fa-wand-magic-sparkles text-indigo-400 text-[9px]"></i>
                        PWA Ready
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Side - Form -->
        <div class="w-full lg:w-1/2 flex items-center justify-center p-5 sm:p-7 lg:p-8 relative flex-1 overflow-y-auto max-h-[92vh]">
            <div class="w-full max-w-sm my-auto">

                <!-- Header -->
                <div class="mb-4">
                    <div class="flex items-center justify-between mb-2.5">
                        <div class="flex items-center gap-2.5">
                            <div class="w-7 h-7 sm:w-8 sm:h-8 bg-gradient-to-tr from-indigo-600 to-blue-500 rounded-lg flex items-center justify-center shadow-[0_0_15px_rgba(99,102,241,0.6)]">
                                <i class="fa-solid fa-bolt text-white text-xs"></i>
                            </div>
                            <span class="text-sm sm:text-base font-extrabold tracking-wider text-white drop-shadow-sm">SCALIFY PARTNER</span>
                        </div>

                        <!-- Login Switch Button -->
                        <div class="flex items-center gap-2">
                            <a href="{{ route('affiliate.login') }}" class="text-[11px] font-bold text-indigo-200 border border-indigo-500/30 bg-indigo-500/10 px-2.5 py-1 rounded-md hover:bg-indigo-500/20 transition-all shadow-sm backdrop-blur-sm">
                                LOGIN
                            </a>
                        </div>
                    </div>

                    <h1 class="text-xl sm:text-2xl font-extrabold text-white mb-0.5 tracking-tight">Daftar Partner</h1>
                    <p class="text-indigo-200/70 text-xs">Mulai langkah Anda meraih komisi tanpa batas</p>
                </div>

                {{-- Alert Messages --}}
                @if(session('error'))
                <div class="bg-rose-500/15 backdrop-blur-md text-rose-200 p-2.5 rounded-xl mb-3 text-xs border border-rose-500/30 shadow-lg flex items-center gap-2">
                    <i class="fa-solid fa-circle-exclamation text-rose-400"></i>
                    <p>{{ session('error') }}</p>
                </div>
                @endif

                @if(session('success'))
                <div class="bg-emerald-500/15 backdrop-blur-md text-emerald-200 p-2.5 rounded-xl mb-3 text-xs border border-emerald-500/30 shadow-lg flex items-center gap-2">
                    <i class="fa-solid fa-circle-check text-emerald-400"></i>
                    <p>{{ session('success') }}</p>
                </div>
                @endif

                @if ($errors->any())
                <div class="bg-rose-500/15 backdrop-blur-md text-rose-200 p-2.5 rounded-xl mb-3 text-xs border border-rose-500/30 shadow-lg">
                    <div class="flex items-center gap-1.5 font-semibold mb-0.5 text-rose-300">
                        <i class="fa-solid fa-triangle-exclamation text-[10px]"></i>
                        <span>Terjadi Kesalahan Pendaftaran:</span>
                    </div>
                    <ul class="list-disc ml-5 space-y-0.5 text-[11px]">
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <!-- Register Form Container -->
                <div class="bg-gradient-to-b from-indigo-950/40 to-slate-900/60 border border-indigo-500/30 rounded-2xl p-4 sm:p-4.5 backdrop-blur-md shadow-xl relative overflow-hidden">
                    <form action="{{ route('affiliate.register.submit') }}" method="POST" class="space-y-2.5">
                        @csrf

                        <!-- Nama Lengkap -->
                        <div>
                            <label class="block text-indigo-100/80 font-medium mb-1 text-xs flex items-center gap-1.5">
                                <i class="fa-regular fa-user text-indigo-400 text-[11px]"></i>
                                Nama Lengkap
                            </label>
                            <input type="text" name="name" value="{{ old('name') }}" required class="w-full glass-input rounded-xl px-3 py-2 text-xs sm:text-sm placeholder-slate-400 text-white border-white/10 focus:border-indigo-400" placeholder="Masukkan nama lengkap Anda">
                        </div>

                        <!-- Email -->
                        <div>
                            <label class="block text-indigo-100/80 font-medium mb-1 text-xs flex items-center gap-1.5">
                                <i class="fa-regular fa-envelope text-indigo-400 text-[11px]"></i>
                                Alamat Email
                            </label>
                            <input type="email" name="email" value="{{ old('email') }}" required class="w-full glass-input rounded-xl px-3 py-2 text-xs sm:text-sm placeholder-slate-400 text-white border-white/10 focus:border-indigo-400" placeholder="nama@email.com">
                        </div>

                        <!-- Password -->
                        <div>
                            <label class="block text-indigo-100/80 font-medium mb-1 text-xs flex items-center gap-1.5">
                                <i class="fa-solid fa-lock text-indigo-400 text-[11px]"></i>
                                Password
                            </label>
                            <div class="relative">
                                <input type="password" name="password" id="password" required class="w-full glass-input rounded-xl px-3 py-2 pr-10 text-xs sm:text-sm placeholder-slate-400 text-white border-white/10 focus:border-indigo-400" placeholder="Minimal 6 karakter">
                                <button type="button" onclick="togglePassword()" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-white transition-colors cursor-pointer" title="Lihat Password">
                                    <svg id="eye-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="w-full bg-gradient-to-r from-indigo-600 via-blue-600 to-indigo-600 hover:from-indigo-500 hover:to-blue-500 text-white py-2.5 rounded-xl font-bold text-xs sm:text-sm shadow-[0_0_20px_rgba(99,102,241,0.4)] hover:shadow-[0_0_25px_rgba(99,102,241,0.6)] transition-all duration-300 transform hover:-translate-y-0.5 flex items-center justify-center gap-2 cursor-pointer mt-1">
                            <i class="fa-solid fa-user-plus text-xs"></i>
                            <span>Daftar Sebagai Partner</span>
                        </button>
                    </form>
                </div>

                <!-- Footer Links -->
                <div class="mt-3 text-center">
                    <p class="text-xs text-indigo-200/70">
                        Sudah punya akun partner?
                        <a href="{{ route('affiliate.login') }}" class="text-indigo-400 hover:text-indigo-300 font-bold ml-1 transition-colors">
                            Masuk di sini
                        </a>
                    </p>
                </div>

                <div class="mt-2 text-center">
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
    // Toggle Password Visibility
    function togglePassword() {
        const passwordInput = document.getElementById('password');
        const eyeIcon = document.getElementById('eye-icon');

        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            eyeIcon.innerHTML = `
                <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" />
            `;
        } else {
            passwordInput.type = 'password';
            eyeIcon.innerHTML = `
                <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
            `;
        }
    }

</script>
@endsection
