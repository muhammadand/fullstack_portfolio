@extends('layouts.app')

@section('content')
<br><br><br><br><br>

<div class="max-w-5xl mx-auto px-6 py-10">
    <h2 class="text-3xl font-bold gradient-text mb-6">Tambah Portfolio Baru</h2>

    <form action="{{ route('portfolio.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        {{-- 🔹 Kategori --}}
        <div>
            <label class="block text-gray-700 font-medium mb-2">Kategori</label>
            <select name="category_id" class="w-full border-gray-300 rounded-lg px-4 py-2 focus:ring focus:ring-blue-200">
                <option value="">-- Pilih Kategori --</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                @endforeach
            </select>
        </div>

        {{-- 🔹 Judul --}}
        <div>
            <label class="block text-gray-700 font-medium mb-2">Judul</label>
            <input type="text" name="title" value="{{ old('title') }}" class="w-full border-gray-300 rounded-lg px-4 py-2 focus:ring focus:ring-blue-200">
        </div>

        {{-- 🔹 Slug --}}
        <div>
            <label class="block text-gray-700 font-medium mb-2">Slug</label>
            <input type="text" name="slug" value="{{ old('slug') }}" class="w-full border-gray-300 rounded-lg px-4 py-2 focus:ring focus:ring-blue-200">
        </div>

        {{-- 🔹 Client & Jenis Proyek --}}
        <div class="grid md:grid-cols-2 gap-4">
            <div>
                <label class="block text-gray-700 font-medium mb-2">Nama Klien</label>
                <input type="text" name="client_name" value="{{ old('client_name') }}" class="w-full border-gray-300 rounded-lg px-4 py-2">
            </div>
            <div>
                <label class="block text-gray-700 font-medium mb-2">Jenis Proyek</label>
                <input type="text" name="project_type" value="{{ old('project_type') }}" placeholder="Contoh: Website E-Commerce" class="w-full border-gray-300 rounded-lg px-4 py-2">
            </div>
        </div>

        {{-- 🔹 Deskripsi --}}
        <div>
            <label class="block text-gray-700 font-medium mb-2">Deskripsi Singkat</label>
            <textarea name="short_description" rows="2" class="w-full border-gray-300 rounded-lg px-4 py-2">{{ old('short_description') }}</textarea>
        </div>

        <div>
            <label class="block text-gray-700 font-medium mb-2">Deskripsi Lengkap</label>
            <textarea name="full_description" rows="4" class="w-full border-gray-300 rounded-lg px-4 py-2">{{ old('full_description') }}</textarea>
        </div>

        {{-- 🔹 Challenge / Solution / Result --}}
        <div class="grid md:grid-cols-3 gap-4">
            <div>
                <label class="block text-gray-700 font-medium mb-2">Tantangan</label>
                <textarea name="challenge" rows="3" class="w-full border-gray-300 rounded-lg px-4 py-2">{{ old('challenge') }}</textarea>
            </div>
            <div>
                <label class="block text-gray-700 font-medium mb-2">Solusi</label>
                <textarea name="solution" rows="3" class="w-full border-gray-300 rounded-lg px-4 py-2">{{ old('solution') }}</textarea>
            </div>
            <div>
                <label class="block text-gray-700 font-medium mb-2">Hasil</label>
                <textarea name="result" rows="3" class="w-full border-gray-300 rounded-lg px-4 py-2">{{ old('result') }}</textarea>
            </div>
        </div>

        {{-- 🔹 Upload Gambar --}}
        <div class="grid md:grid-cols-2 gap-4">
            <div>
                <label class="block text-gray-700 font-medium mb-2">Thumbnail</label>
                <input type="file" name="thumbnail_image" class="w-full border-gray-300 rounded-lg px-4 py-2">
            </div>
            <div>
                <label class="block text-gray-700 font-medium mb-2">Featured Image</label>
                <input type="file" name="featured_image" class="w-full border-gray-300 rounded-lg px-4 py-2">
            </div>
        </div>

        {{-- 🔹 Teknologi --}}
        <div>
            <label class="block text-gray-700 font-medium mb-2">Teknologi (Pisahkan dengan koma)</label>
            <input type="text" name="technologies" value="{{ old('technologies') }}" placeholder="Contoh: React, Node.js, MySQL" class="w-full border-gray-300 rounded-lg px-4 py-2">
        </div>

        {{-- 🔹 URL --}}
        <div class="grid md:grid-cols-2 gap-4">
            <div>
                <label class="block text-gray-700 font-medium mb-2">URL Proyek</label>
                <input type="url" name="project_url" value="{{ old('project_url') }}" class="w-full border-gray-300 rounded-lg px-4 py-2">
            </div>
            <div>
                <label class="block text-gray-700 font-medium mb-2">URL Github</label>
                <input type="url" name="github_url" value="{{ old('github_url') }}" class="w-full border-gray-300 rounded-lg px-4 py-2">
            </div>
        </div>

        {{-- 🔹 Tanggal & Status --}}
        <div class="grid md:grid-cols-3 gap-4">
            <div>
                <label class="block text-gray-700 font-medium mb-2">Tanggal Selesai</label>
                <input type="date" name="completion_date" value="{{ old('completion_date') }}" class="w-full border-gray-300 rounded-lg px-4 py-2">
            </div>
            <div>
                <label class="block text-gray-700 font-medium mb-2">Ditampilkan?</label>
                <input type="checkbox" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }}>
            </div>
            <div>
                <label class="block text-gray-700 font-medium mb-2">Aktif?</label>
                <input type="checkbox" name="is_active" value="1" {{ old('is_active', 1) ? 'checked' : '' }}>
            </div>
        </div>

        {{-- 🔹 Tombol --}}
        <div class="flex justify-end gap-3 mt-6">
            <a href="{{ route('portfolio.index') }}" class="bg-gray-300 text-gray-800 px-5 py-2 rounded-lg hover:bg-gray-400 transition">Batal</a>
            <button type="submit" class="bg-blue-600 text-white px-5 py-2 rounded-lg hover:bg-blue-700 transition">Simpan</button>
        </div>
    </form>
</div>
@endsection
