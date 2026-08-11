@extends('layouts.admin.app')

@section('content')
<div class="px-4 sm:px-6 py-4 sm:py-8">
    <div class="mb-6 sm:mb-8 flex items-center gap-4">
        <a href="{{ route('admin.client_proposals.index') }}" class="w-10 h-10 bg-white border border-slate-200 rounded-full flex items-center justify-center text-slate-500 hover:text-blue-600 hover:border-blue-600 transition-colors">
            <i class="fa-solid fa-arrow-left"></i>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Tambah Client Proposal</h1>
            <p class="text-slate-500 text-sm mt-1">Isi formulir di bawah untuk membuat halaman penawaran baru.</p>
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
        <form action="{{ route('admin.client_proposals.store') }}" method="POST" class="p-4 sm:p-6">
            @csrf

            <div class="mb-6">
                <label class="block text-sm font-medium text-slate-700 mb-2">Kategori Bisnis (Tema)</label>
                <select name="business_category_id" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all">
                    <option value="">-- Tanpa Kategori Khusus (Gunakan Default) --</option>
                    @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ old('business_category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
                <p class="text-xs text-slate-500 mt-1">Pilih kategori untuk menentukan tema halaman yang akan ditampilkan.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Nama Brand Klien (Ex: Bunga Wedding) <span class="text-red-500">*</span></label>
                    <input type="text" name="brand_name" value="{{ old('brand_name') }}" required class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all">
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Nama Badan/Orang (Ex: Manajemen Bunga Wedding)</label>
                    <input type="text" name="client_name" value="{{ old('client_name') }}" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Nomor WhatsApp (Ex: 62812...) <span class="text-red-500">*</span></label>
                    <input type="text" name="wa_number" value="{{ old('wa_number') }}" required class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all">
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Harga Project Web (Ex: 4500000) <span class="text-red-500">*</span></label>
                    <input type="number" name="project_price" value="{{ old('project_price', 4500000) }}" required class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all">
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Harga Domain & Hosting (Ex: 1200000) <span class="text-red-500">*</span></label>
                    <input type="number" name="domain_price" value="{{ old('domain_price', 1200000) }}" required class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all">
                </div>
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-slate-700 mb-2">Template Pesan WhatsApp</label>
                <textarea name="wa_template" rows="3" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all">{{ old('wa_template', 'Halo tim Scalify, saya tertarik untuk diskusi lebih lanjut.') }}</textarea>
                <p class="text-xs text-slate-500 mt-1">Pesan yang otomatis terisi ketika klien menekan tombol hubungi kami.</p>
            </div>

            <div class="flex justify-end pt-4 border-t border-slate-100">
                <button type="submit" class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors shadow-sm">
                    Simpan Proposal
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
