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
                    <i class="fa-solid fa-handshake text-5xl text-white drop-shadow-md"></i>
                </div>
                <h2 class="text-3xl font-bold text-white mb-4 drop-shadow-md">Sobat Scalify Partner</h2>
                <p class="text-blue-100/80 text-lg max-w-md mx-auto">Sebarkan link referral Anda dan dapatkan komisi uang tunai dari setiap project yang berhasil closing!</p>
            </div>
        </div>

        <!-- Right Side - Form -->
        <div class="w-full lg:w-1/2 overflow-y-auto p-6 sm:p-8 lg:p-10 relative flex-1">
            <div class="w-full max-w-md mx-auto min-h-full flex flex-col justify-center pb-4 sm:pb-0">

                <!-- Header -->
                <div class="mb-8">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-8 h-8 bg-blue-500 rounded-lg flex items-center justify-center shadow-[0_0_15px_rgba(59,130,246,0.5)]">
                            <i class="fa-solid fa-bolt text-white text-sm"></i>
                        </div>
                        <span class="text-xl font-bold tracking-wide text-white drop-shadow-sm">SCALIFY PARTNER</span>
                    </div>

                    <h1 class="text-3xl font-bold text-white mb-2 tracking-tight">Daftar Sekarang</h1>
                    <p class="text-blue-200/60 text-sm">Bergabunglah dan mulai dapatkan komisi tambahan</p>
                </div>

                {{-- Alert Messages --}}
                @if(session('success'))
                <div class="bg-green-500/20 backdrop-blur-md text-green-200 p-4 rounded-xl mb-6 text-sm border border-green-500/30 shadow-lg flex items-center gap-3">
                    <i class="fa-solid fa-check-circle text-lg"></i>
                    <p>{{ session('success') }}</p>
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
                <form action="{{ route('affiliate.register.submit') }}" method="POST" class="space-y-4">
                    @csrf

                    <!-- Nama Lengkap -->
                    <div>
                        <label class="block text-blue-100/80 font-medium mb-1.5 text-sm">Nama Lengkap</label>
                        <input type="text" name="name" value="{{ old('name') }}" required class="w-full glass-input rounded-xl px-4 py-3 text-sm placeholder-slate-400 text-white" placeholder="Masukkan nama Anda">
                    </div>

                    <!-- Email -->
                    <div>
                        <label class="block text-blue-100/80 font-medium mb-1.5 text-sm">Email Address</label>
                        <input type="email" name="email" value="{{ old('email') }}" required class="w-full glass-input rounded-xl px-4 py-3 text-sm placeholder-slate-400 text-white" placeholder="admin@scalify.com">
                    </div>

                    <!-- Password -->
                    <div>
                        <label class="block text-blue-100/80 font-medium mb-1.5 text-sm">Password</label>
                        <input type="password" name="password" required class="w-full glass-input rounded-xl px-4 py-3 text-sm placeholder-slate-400 text-white" placeholder="Buat password">
                    </div>

                    <!-- Bank Info -->
                    <div>
                        <label class="block text-blue-100/80 font-medium mb-1.5 text-sm">Info Rekening / E-Wallet</label>
                        <input type="text" name="bank_info" value="{{ old('bank_info') }}" required class="w-full glass-input rounded-xl px-4 py-3 text-sm placeholder-slate-400 text-white" placeholder="BCA 12345678 a.n Budi">
                        <p class="text-xs text-blue-200/50 mt-1">*Digunakan untuk transfer komisi</p>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-500 text-white py-3.5 rounded-xl font-bold text-base shadow-[0_0_20px_rgba(37,99,235,0.4)] hover:shadow-[0_0_25px_rgba(59,130,246,0.6)] transition-all duration-300 transform hover:-translate-y-0.5 mt-2">
                        Kirim Pendaftaran
                    </button>

                    <div class="text-center mt-4 pt-4 border-t border-white/10">
                        <p class="text-sm text-blue-200/80">Sudah punya akun? <a href="{{ route('affiliate.login') }}" class="text-white font-bold hover:underline">Masuk di sini</a></p>
                    </div>

                    <a href="{{ url('/sobat-scalify') }}" class="text-blue-200/50 text-center text-xs block mt-6 hover:text-white transition-colors">Kembali ke Beranda</a>
                </form>

            </div>
        </div>

    </div>
</div>
@endsection
