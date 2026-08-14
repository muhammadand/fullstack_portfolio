@extends('layouts.app')

@section('hide_navbar_mobile', true)
@section('hide_footer_mobile', true)

@push('meta')
<x-affiliate.pwa-meta />
@endpush

@push('styles')
<style>
    .glass-panel {
        background: rgba(255, 255, 255, 0.05);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        border: 1px solid rgba(255, 255, 255, 0.1);
    }

    .glass-card {
        background: linear-gradient(135deg, rgba(59, 130, 246, 0.2), rgba(30, 58, 138, 0.1));
        backdrop-filter: blur(16px);
        -webkit-backdrop-filter: blur(16px);
        border: 1px solid rgba(255, 255, 255, 0.15);
        box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.3);
    }

    body {
        background-color: #0B1120;
    }

</style>
@endpush

@section('content')
<!-- Background Decoration -->
<div class="fixed top-0 left-0 w-full h-64 bg-blue-600/20 rounded-full blur-[100px] -translate-y-1/2 pointer-events-none z-0"></div>
<div class="fixed bottom-0 right-0 w-64 h-64 bg-indigo-600/20 rounded-full blur-[100px] translate-y-1/2 translate-x-1/3 pointer-events-none z-0"></div>

<div class="relative z-10 w-full max-w-md mx-auto min-h-screen px-4 pt-6 pb-24 text-white font-sans">

    <!-- Top Bar -->
    <div class="flex items-center gap-4 mb-6">
        <a href="{{ route('affiliate.dashboard') }}" class="w-10 h-10 rounded-full glass-panel flex items-center justify-center text-slate-300 hover:text-white transition-colors">
            <i class="fa-solid fa-arrow-left"></i>
        </a>
        <h1 class="text-xl font-bold">Edit Profile</h1>
    </div>

    @if(session('success'))
    <div class="bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 p-4 rounded-2xl mb-6 text-sm flex items-center gap-3">
        <i class="fa-solid fa-circle-check"></i>
        {{ session('success') }}
    </div>
    @endif

    @if($errors->any())
    <div class="bg-rose-500/10 border border-rose-500/20 text-rose-400 p-4 rounded-2xl mb-6 text-sm">
        <ul class="list-disc ml-5 space-y-1">
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <!-- Form Edit Profile -->
    <form action="{{ route('affiliate.profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
        @csrf

        <!-- Profile Photo Section -->
        <div class="glass-panel p-5 rounded-3xl flex flex-col items-center">
            <div class="relative mb-4 group">
                <div class="w-24 h-24 rounded-full bg-gradient-to-tr from-blue-500 to-indigo-500 flex items-center justify-center text-white text-3xl font-bold shadow-xl overflow-hidden border-2 border-white/20">
                    @if($affiliate->avatar)
                    <img src="{{ asset('storage/' . $affiliate->avatar) }}" alt="Avatar" class="w-full h-full object-cover">
                    @else
                    {{ substr($affiliate->name, 0, 1) }}
                    @endif
                </div>
                <!-- Upload Overlay -->
                <label for="avatar_upload" class="absolute inset-0 bg-black/50 rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity cursor-pointer">
                    <i class="fa-solid fa-camera text-white text-xl"></i>
                </label>
            </div>

            <label for="avatar_upload" class="px-4 py-2 bg-white/10 hover:bg-white/20 border border-white/10 rounded-xl text-xs font-medium cursor-pointer transition-colors flex items-center gap-2">
                <i class="fa-solid fa-cloud-arrow-up"></i> Ubah Foto Profil
            </label>
            <input type="file" id="avatar_upload" name="avatar" accept="image/*" class="hidden" onchange="previewAvatar(this)">
            <p class="text-[10px] text-slate-400 mt-2">Maks. 3 MB (JPEG, PNG, WEBP)</p>
        </div>

        <div class="glass-panel p-5 rounded-3xl">
            <div class="space-y-4">

                <!-- Nama -->
                <div>
                    <label class="block text-xs font-medium text-slate-400 mb-1.5 ml-1">Nama Lengkap</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400">
                            <i class="fa-regular fa-user"></i>
                        </div>
                        <input type="text" name="name" value="{{ old('name', $affiliate->name) }}" required class="w-full bg-slate-900/50 border border-slate-700/50 text-white rounded-xl py-3 pl-10 pr-4 focus:outline-none focus:border-blue-500/50 focus:ring-1 focus:ring-blue-500/50 transition-all text-sm placeholder:text-slate-600">
                    </div>
                </div>

                <!-- Email -->
                <div>
                    <label class="block text-xs font-medium text-slate-400 mb-1.5 ml-1">Email</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400">
                            <i class="fa-regular fa-envelope"></i>
                        </div>
                        <input type="email" name="email" value="{{ old('email', $affiliate->email) }}" required class="w-full bg-slate-900/50 border border-slate-700/50 text-white rounded-xl py-3 pl-10 pr-4 focus:outline-none focus:border-blue-500/50 focus:ring-1 focus:ring-blue-500/50 transition-all text-sm placeholder:text-slate-600">
                    </div>
                </div>

                <!-- Bank Info -->
                <div>
                    <label class="block text-xs font-medium text-slate-400 mb-1.5 ml-1">Informasi Bank / E-Wallet</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 pt-3 pointer-events-none text-slate-400">
                            <i class="fa-solid fa-building-columns"></i>
                        </div>
                        <textarea name="bank_info" rows="3" required class="w-full bg-slate-900/50 border border-slate-700/50 text-white rounded-xl py-3 pl-10 pr-4 focus:outline-none focus:border-blue-500/50 focus:ring-1 focus:ring-blue-500/50 transition-all text-sm placeholder:text-slate-600" placeholder="Contoh: BCA 1234567890 a/n John Doe">{{ old('bank_info', $affiliate->bank_info) }}</textarea>
                    </div>
                </div>

            </div>
        </div>

        <div class="glass-panel p-5 rounded-3xl">
            <h3 class="text-sm font-semibold text-white mb-4 flex items-center gap-2">
                <i class="fa-solid fa-lock text-slate-400"></i> Keamanan
            </h3>

            <!-- Password -->
            <div>
                <label class="block text-xs font-medium text-slate-400 mb-1.5 ml-1">Password Baru (Opsional)</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400">
                        <i class="fa-solid fa-key"></i>
                    </div>
                    <input type="password" name="password" minlength="8" class="w-full bg-slate-900/50 border border-slate-700/50 text-white rounded-xl py-3 pl-10 pr-4 focus:outline-none focus:border-blue-500/50 focus:ring-1 focus:ring-blue-500/50 transition-all text-sm placeholder:text-slate-600" placeholder="Kosongkan jika tidak ingin mengubah">
                </div>
            </div>
        </div>

        <button type="submit" class="w-full py-3.5 bg-blue-600 hover:bg-blue-500 text-white font-bold rounded-2xl transition-all shadow-[0_0_15px_rgba(37,99,235,0.3)] flex items-center justify-center gap-2">
            <i class="fa-solid fa-floppy-disk"></i> Simpan Perubahan
        </button>

    </form>
</div>

<!-- Bottom Navigation -->
<x-affiliate.bottom-nav />
<x-affiliate.scripts />

<script>
    function previewAvatar(input) {
        if (input.files && input.files[0]) {
            if (input.files[0].size > 3 * 1024 * 1024) {
                alert('Ukuran file maksimal adalah 3 MB.');
                input.value = '';
                return;
            }

            var reader = new FileReader();
            reader.onload = function(e) {
                // Update avatar preview
                const avatarContainer = input.parentElement.querySelector('.w-24.h-24');
                avatarContainer.innerHTML = `<img src="${e.target.result}" alt="Preview" class="w-full h-full object-cover">`;
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

</script>
@endsection
