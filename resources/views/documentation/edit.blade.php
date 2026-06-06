@extends('layouts.admin.app')

@section('content')
<div class="max-w-2xl mx-auto px-6 py-10">

    {{-- Header --}}
    <div class="flex items-center gap-4 mb-8">
        <a href="{{ route('documentation.index') }}" class="w-9 h-9 rounded-xl bg-white border border-slate-200 flex items-center justify-center transition-all hover:scale-105 hover:shadow-sm">
            <i class="fa-solid fa-arrow-left text-slate-500 text-sm"></i>
        </a>
        <div>
            <h2 class="text-2xl font-bold text-slate-800">Edit Foto</h2>
            <p class="text-slate-400 text-sm mt-0.5">Perbarui data dokumentasi</p>
        </div>
    </div>

    {{-- Form Card --}}
    <div class="bg-white rounded-2xl p-8 shadow-sm border border-slate-100">
        <form action="{{ route('documentation.update', $documentation->slug) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {{-- Title Field --}}
            <div class="mb-6">
                <label class="block text-sm font-semibold text-slate-700 mb-2">
                    Nama / Judul
                    <span class="text-red-500">*</span>
                </label>
                <input type="text" name="title" value="{{ old('title', $documentation->title) }}" placeholder="Contoh: Budi Santoso" class="w-full px-4 py-3 rounded-xl text-sm text-slate-800 placeholder-slate-300 bg-slate-50 border border-slate-200 outline-none transition-all duration-200 focus:ring-2 focus:ring-blue-500/30 focus:border-blue-400">
                @error('title')
                <p class="mt-1.5 text-xs text-red-500"><i class="fa-solid fa-circle-exclamation mr-1"></i>{{ $message }}</p>
                @enderror
            </div>

            {{-- Current Image --}}
            @if($documentation->images)
            <div class="mb-5">
                <p class="text-sm font-semibold text-slate-700 mb-2">Foto Saat Ini</p>
                <div class="relative w-40 h-52 rounded-2xl overflow-hidden border border-slate-200 shadow-sm">
                    <img src="{{ asset('images/' . $documentation->images) }}" alt="{{ $documentation->title }}" class="w-full h-full object-cover">
                    <div class="absolute inset-0 flex items-end p-3" style="background: linear-gradient(to top, rgba(0,0,0,0.55) 0%, transparent 60%);">
                        <p class="text-white text-xs font-medium truncate">{{ $documentation->title }}</p>
                    </div>
                </div>
            </div>
            @endif

            {{-- Image Upload --}}
            <div class="mb-8">
                <label class="block text-sm font-semibold text-slate-700 mb-2">
                    Ganti Foto
                    <span class="text-slate-400 font-normal text-xs ml-1">(opsional)</span>
                </label>

                <label for="image-input" class="group flex flex-col items-center justify-center w-full h-48 rounded-2xl cursor-pointer transition-all duration-200 border-2 border-dashed border-slate-200 bg-slate-50 hover:border-blue-400 hover:bg-blue-50/30">

                    <img id="preview-img" src="" alt="Preview" class="hidden w-full h-full object-cover rounded-2xl">

                    <div id="drop-placeholder" class="flex flex-col items-center text-center px-6">
                        <div class="w-12 h-12 rounded-2xl bg-blue-50 border border-blue-100 flex items-center justify-center mb-3 transition-transform group-hover:scale-110">
                            <i class="fa-solid fa-arrow-up-from-bracket text-blue-500 text-base"></i>
                        </div>
                        <p class="text-slate-600 text-sm font-medium">Klik untuk ganti foto</p>
                        <p class="text-slate-400 text-xs mt-1">PNG, JPG, JPEG — maks 10MB</p>
                    </div>

                    <input type="file" name="images" id="image-input" accept="image/*" class="hidden">
                </label>
            </div>

            {{-- Actions --}}
            <div class="flex items-center gap-3">
                <button type="submit" class="flex-1 flex items-center justify-center gap-2 py-3 rounded-xl text-sm font-semibold text-white bg-gradient-to-r from-blue-600 to-indigo-600 shadow-md hover:shadow-blue-200 transition-all duration-200 hover:scale-[1.02] active:scale-[0.98]">
                    <i class="fa-solid fa-floppy-disk"></i> Simpan Perubahan
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
