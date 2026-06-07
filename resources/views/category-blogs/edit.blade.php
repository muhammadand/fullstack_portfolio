@extends('layouts.admin.app')

@section('content')
<div class="min-h-screen bg-white py-6 px-4 sm:px-6 lg:px-8">
    <div class="max-w-6xl mx-auto">
        {{-- ✅ Header --}}
        <div class="mb-6">
            <h2 class="text-xl tracking-tight font-bold text-slate-900">Edit Kategori Blog</h2>
            <p class="text-[13px] text-slate-500">Perbarui informasi kategori blog Anda</p>
        </div>

        {{-- ✅ Alert Error --}}
        @if ($errors->any())
        <div class="mb-4 p-4 rounded-xl bg-red-50 border-l-4 border-red-500 text-red-800">
            <h3 class="text-[13px] font-medium mb-1">Terdapat beberapa kesalahan:</h3>
            <ul class="list-disc pl-5 text-[13px] space-y-0.5">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        {{-- ✅ Form --}}
        <form action="{{ route('blog-categories.update', $category->id) }}" method="POST" class="bg-white p-6 rounded-xl shadow-sm border border-slate-200 flex flex-col gap-4">
            @csrf
            @method('PUT')

            <div>
                <label for="name" class="block mb-1 text-[13px] font-medium tracking-wide text-slate-700">Nama Kategori <span class="text-red-500">*</span></label>
                <input type="text" name="name" id="name" value="{{ old('name', $category->name) }}" class="w-full border border-gray-300 rounded-xl px-3 py-2 text-[13px] focus:ring-2 focus:ring-slate-800 focus:border-transparent transition-colors" required>
            </div>

            <div>
                <label for="description" class="block mb-1 text-[13px] font-medium tracking-wide text-slate-700">Deskripsi</label>
                <textarea name="description" id="description" rows="3" class="w-full border border-gray-300 rounded-xl px-3 py-2 text-[13px] focus:ring-2 focus:ring-slate-800 focus:border-transparent transition-colors resize-none">{{ old('description', $category->description) }}</textarea>
            </div>

            <div>
                <label for="meta_description" class="block mb-1 text-[13px] font-medium tracking-wide text-slate-700">Meta Deskripsi</label>
                <input type="text" name="meta_description" id="meta_description" value="{{ old('meta_description', $category->meta_description) }}" class="w-full border border-gray-300 rounded-xl px-3 py-2 text-[13px] focus:ring-2 focus:ring-slate-800 focus:border-transparent transition-colors">
            </div>

            <div>
                <label for="display_order" class="block mb-1 text-[13px] font-medium tracking-wide text-slate-700">Urutan Tampilan</label>
                <input type="number" name="display_order" id="display_order" value="{{ old('display_order', $category->display_order) }}" class="w-full border border-gray-300 rounded-xl px-3 py-2 text-[13px] focus:ring-2 focus:ring-slate-800 focus:border-transparent transition-colors">
            </div>

            <div class="flex items-center justify-between pt-2">
                <span class="text-[13px] font-medium tracking-wide text-slate-700">Aktif</span>
                <label for="is_active" class="flex items-center cursor-pointer">
                    <div class="relative">
                        <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $category->is_active) ? 'checked' : '' }} class="sr-only peer">
                        <div class="w-9 h-5 bg-gray-200 rounded-full peer-focus:ring-2 peer-focus:ring-slate-300 peer-checked:bg-slate-900 transition-colors duration-200"></div>
                        <div class="absolute left-[2px] top-[2px] bg-white w-4 h-4 rounded-full transition-transform duration-200 peer-checked:translate-x-full"></div>
                    </div>
                </label>
            </div>

            <div class="flex justify-end gap-3 pt-4 border-t border-slate-100 mt-2">
                <a href="{{ route('blog-categories.index') }}" class="px-5 py-2.5 rounded-xl border border-slate-200 text-gray-700 hover:bg-slate-50 transition-all duration-300 hover:-translate-y-0.5 hover:shadow-md text-[13px] font-medium flex items-center justify-center">
                    Batal
                </a>
                <button type="submit" class="bg-slate-900 text-white px-5 py-2.5 rounded-xl text-[13px] font-medium transition-all duration-300 hover:bg-slate-800 hover:-translate-y-0.5 hover:shadow-lg flex items-center justify-center">
                    Perbarui Kategori
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
