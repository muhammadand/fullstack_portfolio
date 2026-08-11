@extends('layouts.admin.app')

@section('content')
<div class="px-6 py-8">
    <div class="mb-8 flex items-center gap-4">
        <a href="{{ route('admin.business_categories.index') }}" class="w-10 h-10 bg-white border border-slate-200 rounded-full flex items-center justify-center text-slate-500 hover:text-blue-600 hover:border-blue-600 transition-colors">
            <i class="fa-solid fa-arrow-left"></i>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Tambah Kategori Bisnis</h1>
            <p class="text-slate-500 text-sm mt-1">Buat kategori baru untuk membedakan tema dan template pesan.</p>
        </div>
    </div>

    @if($errors->any())
    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
        <ul class="list-disc pl-5">
            @foreach($errors->all() as $err)
            <li>{{ $err }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
        <form action="{{ route('admin.business_categories.store') }}" method="POST" class="p-6">
            @csrf

            <div class="mb-6">
                <label class="block text-sm font-medium text-slate-700 mb-2">Nama Kategori (Ex: Barbershop, Laundry) <span class="text-red-500">*</span></label>
                <input type="text" name="name" value="{{ old('name') }}" required class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all">
                <p class="text-xs text-slate-500 mt-1">Slug tema akan dibuat otomatis. Pastikan Anda membuat folder view sesuai nama kategori di <code>resources/views/client-proposals/[nama-kategori-huruf-kecil]/</code>.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Harga Default Project Web <span class="text-red-500">*</span></label>
                    <input type="number" name="project_price" value="{{ old('project_price', 4500000) }}" required class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all">
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Harga Default Domain & Hosting <span class="text-red-500">*</span></label>
                    <input type="number" name="domain_price" value="{{ old('domain_price', 1200000) }}" required class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all">
                </div>
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-slate-700 mb-2">Template Default Pesan WhatsApp</label>
                <textarea name="wa_template" rows="3" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all">{{ old('wa_template') }}</textarea>
            </div>

            <div class="flex justify-end pt-4 border-t border-slate-100">
                <button type="submit" class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors shadow-sm">
                    Simpan Kategori
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
