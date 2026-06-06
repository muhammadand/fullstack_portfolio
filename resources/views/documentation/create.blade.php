@extends('layouts.admin.app')

@section('content')
<div class="max-w-2xl mx-auto px-6 py-10">

    {{-- Header --}}
    <div class="flex items-center gap-4 mb-8">
        <a href="{{ route('documentation.index') }}" class="w-9 h-9 rounded-xl bg-white border border-slate-200 flex items-center justify-center transition-all hover:scale-105 hover:shadow-sm">
            <i class="fa-solid fa-arrow-left text-slate-500 text-sm"></i>
        </a>
        <div>
            <h2 class="text-2xl font-bold text-slate-800">Tambah Foto</h2>
            <p class="text-slate-400 text-sm mt-0.5">Upload foto dokumentasi Sobat Scalify</p>
        </div>
    </div>

    {{-- Form Card --}}
    <div class="bg-white rounded-2xl p-8 shadow-sm border border-slate-100">
        <form action="{{ route('documentation.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            {{-- Title Field --}}
            <div class="mb-6">
                <label class="block text-sm font-semibold text-slate-700 mb-2">
                    Nama / Judul
                    <span class="text-red-500">*</span>
                </label>
                <input type="text" name="title" value="{{ old('title') }}" placeholder="Contoh: Budi Santoso" class="w-full px-4 py-3 rounded-xl text-sm text-slate-800 placeholder-slate-300 bg-slate-50 border border-slate-200 outline-none transition-all duration-200 focus:ring-2 focus:ring-blue-500/30 focus:border-blue-400">
                @error('title')
                <p class="mt-1.5 text-xs text-red-500"><i class="fa-solid fa-circle-exclamation mr-1"></i>{{ $message }}</p>
                @enderror
            </div>

            {{-- Image Upload --}}
            <div class="mb-8">
                <label class="block text-sm font-semibold text-slate-700 mb-2">Foto</label>

                {{-- Drop Zone --}}
                <label for="image-input" class="group flex flex-col items-center justify-center w-full h-56 rounded-2xl cursor-pointer transition-all duration-200 border-2 border-dashed border-slate-200 bg-slate-50 hover:border-blue-400 hover:bg-blue-50/30" id="drop-zone">

                    <img id="preview-img" src="" alt="Preview" class="hidden w-full h-full object-cover rounded-2xl">

                    <div id="drop-placeholder" class="flex flex-col items-center text-center px-6">
                        <div class="w-14 h-14 rounded-2xl bg-blue-50 border border-blue-100 flex items-center justify-center mb-3 transition-transform group-hover:scale-110">
                            <i class="fa-solid fa-cloud-arrow-up text-blue-500 text-xl"></i>
                        </div>
                        <p class="text-slate-600 text-sm font-medium">Klik atau drag foto ke sini</p>
                        <p class="text-slate-400 text-xs mt-1">PNG, JPG, JPEG — maks 10MB</p>
                    </div>

                    <input type="file" name="images" id="image-input" accept="image/*" class="hidden">
                </label>

                @error('images')
                <p class="mt-1.5 text-xs text-red-500"><i class="fa-solid fa-circle-exclamation mr-1"></i>{{ $message }}</p>
                @enderror
            </div>

            {{-- Actions --}}
            <div class="flex items-center gap-3">
                <button type="submit" class="flex-1 flex items-center justify-center gap-2 py-3 rounded-xl text-sm font-semibold text-white bg-gradient-to-r from-blue-600 to-indigo-600 shadow-md hover:shadow-blue-200 transition-all duration-200 hover:scale-[1.02] active:scale-[0.98]">
                    <i class="fa-solid fa-floppy-disk"></i> Simpan Foto
                </button>
                <a href="{{ route('documentation.index') }}" class="px-5 py-3 rounded-xl text-sm font-semibold text-slate-500 bg-slate-100 hover:bg-slate-200 transition-all duration-200 hover:scale-[1.02]">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>

<script>
    const input = document.getElementById('image-input');
    const preview = document.getElementById('preview-img');
    const placeholder = document.getElementById('drop-placeholder');

    input.addEventListener('change', function() {
        if (this.files && this.files[0]) {
            const reader = new FileReader();
            reader.onload = e => {
                preview.src = e.target.result;
                preview.classList.remove('hidden');
                placeholder.classList.add('hidden');
            };
            reader.readAsDataURL(this.files[0]);
        }
    });

</script>
@endsection
