@extends('auth.app')

@section('content')
<div class="min-h-screen flex items-center justify-center p-4 sm:p-8 relative z-10">
    <!-- Main Glass Container -->
    <div class="w-full max-w-7xl md:min-h-[600px] md:h-[80vh] md:max-h-[900px] glass-panel rounded-2xl sm:rounded-3xl shadow-[0_8px_32px_0_rgba(0,0,0,0.3)] flex flex-col md:flex-row overflow-hidden">

        <!-- Left Side - Illustration -->
        <div class="hidden lg:flex lg:w-1/2 items-center justify-center p-16 relative border-r border-white/10" style="background: radial-gradient(circle at center, rgba(59,130,246,0.1) 0%, transparent 70%);">
            
            <!-- Floating Shapes -->
            <div class="floating-shape absolute top-20 left-16 w-20 h-20 rounded-xl"></div>
            <div class="floating-shape absolute top-40 right-24 w-16 h-16 rounded-full"></div>
            <div class="floating-shape absolute bottom-32 left-32 w-24 h-24 rounded-2xl"></div>
            <div class="floating-shape absolute bottom-20 right-16 w-14 h-14 rounded-lg"></div>

            <!-- Main Illustration -->
            <div class="relative z-10 text-center">
                <div class="w-24 h-24 bg-white/10 backdrop-blur-md rounded-2xl border border-white/20 shadow-xl flex items-center justify-center mx-auto mb-8">
                    <i class="fa-solid fa-right-to-bracket text-5xl text-white drop-shadow-md"></i>
                </div>
                <h2 class="text-3xl font-bold text-white mb-4 drop-shadow-md">Login Partner</h2>
                <p class="text-blue-100/80 text-lg max-w-md mx-auto">Masuk ke dashboard partner untuk memantau performa referral dan pendapatan komisi Anda.</p>
            </div>
        </div>

        <!-- Right Side - Form -->
        <div class="w-full lg:w-1/2 flex items-center justify-center p-6 sm:p-8 lg:p-10 relative flex-1">
            <div class="w-full max-w-md w-full my-auto pb-4 sm:pb-0">

                <!-- Header -->
                <div class="mb-8">
                    <div class="flex items-center justify-between mb-6">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 bg-blue-500 rounded-lg flex items-center justify-center shadow-[0_0_15px_rgba(59,130,246,0.5)]">
                                <i class="fa-solid fa-bolt text-white text-sm"></i>
                            </div>
                            <span class="text-xl font-bold tracking-wide text-white drop-shadow-sm">SCALIFY PARTNER</span>
                        </div>
                        
                        <!-- Register Button -->
                        <div class="flex items-center gap-2">
                            <span class="text-xs text-slate-400 hidden sm:inline">Belum daftar?</span>
                            <a href="{{ route('affiliate.register') }}" class="text-xs font-semibold text-white border border-white/20 bg-white/5 px-4 py-2 rounded-lg hover:bg-white/10 transition-all shadow-sm backdrop-blur-sm">
                                REGISTER
                            </a>
                        </div>
                    </div>

                    <h1 class="text-3xl font-bold text-white mb-2 tracking-tight">Welcome Back!</h1>
                    <p class="text-blue-200/60 text-sm">Masuk ke akun partner Anda</p>
                </div>

                {{-- Alert Messages --}}
                @if(session('error'))
                <div class="bg-red-500/10 backdrop-blur-md text-red-200 p-4 rounded-xl mb-6 text-sm border border-red-500/20 shadow-lg flex items-center gap-3">
                    <i class="fa-solid fa-circle-exclamation text-lg"></i>
                    <p>{{ session('error') }}</p>
                </div>
                @endif
                
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
                <form action="{{ route('affiliate.login.submit') }}" method="POST" class="space-y-4">
                    @csrf

                    <!-- Email -->
                    <div>
                        <label class="block text-blue-100/80 font-medium mb-1.5 text-sm">Email Address</label>
                        <input type="email" name="email" value="{{ old('email') }}" required class="w-full glass-input rounded-xl px-4 py-3 text-sm placeholder-slate-400 text-white" placeholder="email@domain.com">
                    </div>

                    <!-- Password -->
                    <div>
                        <div class="flex justify-between items-center mb-1.5">
                            <label class="block text-blue-100/80 font-medium text-sm">Password</label>
                        </div>
                        <div class="relative">
                            <input type="password" name="password" id="password" required class="w-full glass-input rounded-xl px-4 py-3 pr-12 text-sm placeholder-slate-400 text-white" placeholder="••••••••">
                            <button type="button" onclick="togglePassword()" class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 hover:text-white transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-500 text-white py-3.5 rounded-xl font-bold text-base shadow-[0_0_20px_rgba(37,99,235,0.4)] hover:shadow-[0_0_25px_rgba(59,130,246,0.6)] transition-all duration-300 transform hover:-translate-y-0.5 mt-2">
                        Login Partner
                    </button>
                    
                    <a href="{{ url('/sobat-scalify') }}" class="text-blue-200/60 text-center text-xs block mt-4 hover:text-white transition-colors">Kembali ke Halaman Sebelumnya</a>
                </form>

            </div>
        </div>

    </div>
</div>
@endsection
