@extends('layouts.admin.app')

@section('content')
<div class="max-w-3xl mx-auto px-6 py-10">
    {{-- ✅ Header --}}
    <h2 class="text-3xl font-bold gradient-text mb-6">Tambah Kategori Blog</h2>

    {{-- ✅ Alert Error --}}
    @if ($errors->any())
        <div class="mb-4 p-4 rounded-lg bg-red-100 border border-red-300 text-red-800">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- ✅ Form --}}
    <form action="{{ route('blog-categories.store') }}" method="POST" class="bg-white p-6 rounded-xl shadow-md flex flex-col gap-4">
        @csrf

        <div>
            <label for="name" class="block mb-1 font-medium text-gray-700">Nama Kategori <span class="text-red-500">*</span></label>
            <input type="text" name="name" id="name" value="{{ old('name') }}"
                   class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring focus:ring-purple-200" required>
        </div>

        <div>
            <label for="description" class="block mb-1 font-medium text-gray-700">Deskripsi</label>
            <textarea name="description" id="description" rows="3"
                      class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring focus:ring-purple-200">{{ old('description') }}</textarea>
        </div>

        <div>
            <label for="meta_description" class="block mb-1 font-medium text-gray-700">Meta Deskripsi</label>
            <input type="text" name="meta_description" id="meta_description" value="{{ old('meta_description') }}"
                   class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring focus:ring-purple-200">
        </div>

        <div>
            <label for="display_order" class="block mb-1 font-medium text-gray-700">Urutan Tampilan</label>
            <input type="number" name="display_order" id="display_order" value="{{ old('display_order', 0) }}"
                   class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring focus:ring-purple-200">
        </div>

        <div class="flex items-center gap-2">
            <input type="checkbox" name="is_active" id="is_active" value="1" checked>
            <label for="is_active" class="font-medium text-gray-700">Aktif</label>
        </div>

        <div class="flex gap-4 mt-4">
            <a href="{{ route('blog-categories.index') }}" 
               class="px-5 py-2 rounded-lg bg-gray-300 text-gray-700 font-medium hover:bg-gray-400 transition">
               Batal
            </a>
            <button type="submit" 
                    class="px-5 py-2 rounded-lg bg-gradient-to-r from-purple-600 to-purple-700 text-white font-medium hover:opacity-90 transition">
                Simpan Kategori
            </button>
        </div>
    </form>
</div>
@endsection
