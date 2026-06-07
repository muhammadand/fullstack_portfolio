@extends('layouts.admin.app')

@section('content')
<div class="max-w-4xl mx-auto px-6 py-10">
    <div class="mb-6">
        <h2 class="text-3xl font-bold text-slate-800">Edit Profile</h2>
        <p class="text-sm text-slate-500 mt-1">Kelola informasi profil dan keamanan akun Anda.</p>
    </div>

    @if(session('success'))
    <div class="mb-6 p-4 rounded-lg bg-green-100 border border-green-300 text-green-800">
        {{ session('success') }}
    </div>
    @endif

    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Foto Profil --}}
                <div class="col-span-1 md:col-span-2 flex items-center gap-6">
                    <div class="shrink-0 relative group">
                        @if($user->profile_photo)
                        <img src="{{ asset('storage/' . $user->profile_photo) }}" alt="Profile Photo" class="w-24 h-24 rounded-full object-cover border-4 border-slate-100">
                        @else
                        <div class="w-24 h-24 rounded-full bg-slate-200 flex items-center justify-center text-slate-400 border-4 border-slate-100">
                            <i class="fa-solid fa-user text-3xl"></i>
                        </div>
                        @endif
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Ganti Foto Profil</label>
                        <input type="file" name="profile_photo" accept="image/*" class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 transition">
                        <p class="mt-2 text-xs text-slate-400">Format: JPG, PNG, GIF (Maks. 2MB)</p>
                        @error('profile_photo') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="col-span-1 md:col-span-2 border-t border-slate-100 my-2"></div>

                {{-- Nama --}}
                <div class="col-span-1 md:col-span-2">
                    <label class="block text-sm font-medium text-slate-700 mb-2">Nama Lengkap</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" required class="w-full border border-slate-300 rounded-lg px-4 py-2 focus:ring focus:ring-blue-200 focus:border-blue-500 outline-none transition">
                    @error('name') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>

                {{-- Email --}}
                <div class="col-span-1">
                    <label class="block text-sm font-medium text-slate-700 mb-2">Email</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" required class="w-full border border-slate-300 rounded-lg px-4 py-2 focus:ring focus:ring-blue-200 focus:border-blue-500 outline-none transition">
                    @error('email') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>

                {{-- Phone --}}
                <div class="col-span-1">
                    <label class="block text-sm font-medium text-slate-700 mb-2">Telepon</label>
                    <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" class="w-full border border-slate-300 rounded-lg px-4 py-2 focus:ring focus:ring-blue-200 focus:border-blue-500 outline-none transition">
                    @error('phone') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>

                <div class="col-span-1 md:col-span-2 border-t border-slate-100 my-2"></div>

                {{-- Password --}}
                <div class="col-span-1">
                    <label class="block text-sm font-medium text-slate-700 mb-2">Password Baru <span class="text-slate-400 font-normal">(Opsional)</span></label>
                    <input type="password" name="password" class="w-full border border-slate-300 rounded-lg px-4 py-2 focus:ring focus:ring-blue-200 focus:border-blue-500 outline-none transition" placeholder="Kosongkan jika tidak diubah">
                    @error('password') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>

                {{-- Konfirmasi Password --}}
                <div class="col-span-1">
                    <label class="block text-sm font-medium text-slate-700 mb-2">Konfirmasi Password Baru</label>
                    <input type="password" name="password_confirmation" class="w-full border border-slate-300 rounded-lg px-4 py-2 focus:ring focus:ring-blue-200 focus:border-blue-500 outline-none transition" placeholder="Kosongkan jika tidak diubah">
                </div>
            </div>

            <div class="mt-8 pt-6 border-t border-slate-200 flex justify-end">
                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg font-medium shadow hover:bg-blue-700 transition">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
