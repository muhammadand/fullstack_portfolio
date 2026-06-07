@extends('layouts.admin.app')

@section('content')
<div class="max-w-4xl mx-auto px-6 py-10">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-3xl font-bold text-slate-800">Tambah User</h2>
        <a href="{{ route('users.index') }}" class="text-slate-500 hover:text-slate-700">
            &larr; Kembali
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
        <form action="{{ route('users.store') }}" method="POST">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Nama --}}
                <div class="col-span-1 md:col-span-2">
                    <label class="block text-sm font-medium text-slate-700 mb-2">Nama Lengkap</label>
                    <input type="text" name="name" value="{{ old('name') }}" required class="w-full border border-slate-300 rounded-lg px-4 py-2 focus:ring focus:ring-blue-200 focus:border-blue-500 outline-none transition">
                    @error('name') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>

                {{-- Email --}}
                <div class="col-span-1">
                    <label class="block text-sm font-medium text-slate-700 mb-2">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required class="w-full border border-slate-300 rounded-lg px-4 py-2 focus:ring focus:ring-blue-200 focus:border-blue-500 outline-none transition">
                    @error('email') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>

                {{-- Phone --}}
                <div class="col-span-1">
                    <label class="block text-sm font-medium text-slate-700 mb-2">Telepon</label>
                    <input type="text" name="phone" value="{{ old('phone') }}" class="w-full border border-slate-300 rounded-lg px-4 py-2 focus:ring focus:ring-blue-200 focus:border-blue-500 outline-none transition">
                    @error('phone') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>

                {{-- Password --}}
                <div class="col-span-1">
                    <label class="block text-sm font-medium text-slate-700 mb-2">Password</label>
                    <input type="password" name="password" required class="w-full border border-slate-300 rounded-lg px-4 py-2 focus:ring focus:ring-blue-200 focus:border-blue-500 outline-none transition">
                    @error('password') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>

                {{-- Konfirmasi Password --}}
                <div class="col-span-1">
                    <label class="block text-sm font-medium text-slate-700 mb-2">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" required class="w-full border border-slate-300 rounded-lg px-4 py-2 focus:ring focus:ring-blue-200 focus:border-blue-500 outline-none transition">
                </div>

                {{-- Role --}}
                <div class="col-span-1">
                    <label class="block text-sm font-medium text-slate-700 mb-2">Role</label>
                    <select name="role" required class="w-full border border-slate-300 rounded-lg px-4 py-2 focus:ring focus:ring-blue-200 focus:border-blue-500 outline-none transition bg-white">
                        <option value="super_admin" {{ old('role') == 'super_admin' ? 'selected' : '' }}>Super Admin</option>
                        <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="user" {{ old('role', 'user') == 'user' ? 'selected' : '' }}>User</option>
                    </select>
                    @error('role') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>

                {{-- Status Aktif --}}
                <div class="col-span-1 flex items-center pt-8">
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="is_active" value="1" class="sr-only peer" {{ old('is_active', true) ? 'checked' : '' }}>
                        <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                        <span class="ml-3 text-sm font-medium text-slate-700">Akun Aktif</span>
                    </label>
                </div>
            </div>

            <div class="mt-8 pt-6 border-t border-slate-200 flex justify-end">
                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg font-medium shadow hover:bg-blue-700 transition">
                    Simpan User
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
