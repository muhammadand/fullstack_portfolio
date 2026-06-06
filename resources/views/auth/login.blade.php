@extends('auth.app')
@section('content')
<div class="h-screen flex items-center justify-center p-8 relative z-10">
    <!-- Main Glass Container -->
    <div class="w-full max-w-7xl h-full max-h-[900px] glass-panel rounded-3xl shadow-[0_8px_32px_0_rgba(0,0,0,0.3)] flex overflow-hidden">

        <!-- Left Side - Illustration -->
        <div class="hidden lg:flex lg:w-1/2 items-center justify-center p-16 relative border-r border-white/10" style="background: radial-gradient(circle at center, rgba(59,130,246,0.1) 0%, transparent 70%);">

            <!-- Floating Shapes (handled by CSS in app.blade.php) -->
            <div class="floating-shape absolute top-20 left-16 w-20 h-20 rounded-xl"></div>
            <div class="floating-shape absolute top-40 right-24 w-16 h-16 rounded-full"></div>
            <div class="floating-shape absolute bottom-32 left-32 w-24 h-24 rounded-2xl"></div>
            <div class="floating-shape absolute bottom-20 right-16 w-14 h-14 rounded-lg"></div>

            <!-- Main Illustration -->
            <div class="relative z-10">
                <!-- 3D Card (Glass styled in CSS) -->
                <div class="card-3d rounded-2xl relative">
                    <div class="absolute top-6 left-6 w-20 h-1 bg-white/40 rounded-full shadow-[0_0_10px_rgba(255,255,255,0.5)]"></div>
                    <div class="absolute top-10 left-6 w-32 h-1 bg-white/30 rounded-full"></div>
                    <div class="absolute top-16 left-6 w-12 h-12 bg-white/20 rounded-full"></div>
                </div>

                <!-- Lock Icon -->
                <div class="lock-3d absolute -bottom-4 -right-12 w-24 h-24 rounded-2xl flex items-center justify-center z-20">
                    <svg class="w-12 h-12 text-white drop-shadow-md" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Right Side - Form -->
        <div class="w-full lg:w-1/2 flex items-center justify-center p-8 lg:p-10 relative">
            <div class="w-full max-w-md">

                <!-- Header -->
                <div class="mb-8">
                    <div class="flex items-center justify-between mb-10">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 bg-blue-500 rounded-lg flex items-center justify-center shadow-[0_0_15px_rgba(59,130,246,0.5)]">
                                <i class="fa-solid fa-bolt text-white text-sm"></i>
                            </div>
                            <span class="text-xl font-bold tracking-wide text-white drop-shadow-sm">MUHAMMAD ANDI</span>
                        </div>

                        <!-- Register Button -->
                        <div class="flex items-center gap-2">
                            <span class="text-xs text-slate-400 hidden sm:inline">Belum punya akun?</span>
                            <a href="{{ route('register') }}" class="text-xs font-semibold text-white border border-white/20 bg-white/5 px-4 py-2 rounded-lg hover:bg-white/10 transition-all shadow-sm backdrop-blur-sm">
                                REGISTER
                            </a>
                        </div>
                    </div>

                    <h1 class="text-4xl font-bold text-white mb-2 tracking-tight">Welcome Back!</h1>
                    <p class="text-blue-200/60 text-sm">Masuk ke akun panel Anda</p>
                </div>

                {{-- Error Message --}}
                @if ($errors->any())
                <div class="bg-red-500/10 backdrop-blur-md text-red-200 p-4 rounded-xl mb-6 text-sm border border-red-500/20 shadow-lg">
                    <ul class="list-disc ml-4 space-y-1">
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <!-- Form -->
                <form action="{{ route('login.post') }}" method="POST" class="space-y-5">
                    @csrf

                    <!-- Email -->
                    <div>
                        <label class="block text-blue-100/80 font-medium mb-2 text-sm">Email Address</label>
                        <input type="email" name="email" value="{{ old('email') }}" required class="w-full glass-input rounded-xl px-5 py-3.5 text-sm placeholder-slate-400" placeholder="admin@scalify.com">
                    </div>

                    <!-- Password -->
                    <div>
                        <div class="flex justify-between items-center mb-2">
                            <label class="block text-blue-100/80 font-medium text-sm">Password</label>
                            <a href="#" class="text-xs text-blue-400 hover:text-blue-300 transition-colors">Lupa Password?</a>
                        </div>
                        <div class="relative">
                            <input type="password" name="password" id="password" required class="w-full glass-input rounded-xl px-5 py-3.5 pr-12 text-sm placeholder-slate-400" placeholder="••••••••">
                            <button type="button" onclick="togglePassword()" class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 hover:text-white transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-500 text-white py-3.5 rounded-xl font-bold text-base shadow-[0_0_20px_rgba(37,99,235,0.4)] hover:shadow-[0_0_25px_rgba(59,130,246,0.6)] transition-all duration-300 transform hover:-translate-y-0.5 mt-4">
                        Login to Dashboard
                    </button>
                    <a href="{{ route('index.company.profile') }}" class="text-blue-200/60 text-center text-xs block mt-5">Kembali ke halaman utama</a>
                </form>

            </div>
        </div>

    </div>
</div>
@endsection
