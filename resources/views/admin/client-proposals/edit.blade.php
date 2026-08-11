@extends('layouts.admin.app')

@section('content')
<div class="px-4 sm:px-6 py-4 sm:py-8">
    <div class="mb-6 sm:mb-8 flex items-center gap-4">
        <a href="{{ route('admin.client_proposals.index') }}" class="w-10 h-10 bg-white border border-slate-200 rounded-full flex items-center justify-center text-slate-500 hover:text-blue-600 hover:border-blue-600 transition-colors">
            <i class="fa-solid fa-arrow-left"></i>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Edit Client Proposal</h1>
            <p class="text-slate-500 text-sm mt-1">Ubah data klien <strong>{{ $client_proposal->brand_name }}</strong>.</p>
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
        <form action="{{ route('admin.client_proposals.update', $client_proposal->id) }}" method="POST" class="p-4 sm:p-6">
            @csrf
            @method('PUT')

            <div class="mb-6">
                <label class="block text-sm font-medium text-slate-700 mb-2">Kategori Bisnis (Tema)</label>
                <select name="business_category_id" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all">
                    <option value="">-- Tanpa Kategori Khusus (Gunakan Default) --</option>
                    @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ old('business_category_id', $client_proposal->business_category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
                <p class="text-xs text-slate-500 mt-1">Pilih kategori untuk menentukan tema halaman yang akan ditampilkan.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Nama Brand Klien <span class="text-red-500">*</span></label>
                    <input type="text" name="brand_name" value="{{ old('brand_name', $client_proposal->brand_name) }}" required class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all">
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Nama Badan/Orang</label>
                    <input type="text" name="client_name" value="{{ old('client_name', $client_proposal->client_name) }}" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Nomor WhatsApp <span class="text-red-500">*</span></label>
                    <input type="text" name="wa_number" value="{{ old('wa_number', $client_proposal->wa_number) }}" required class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all">
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Harga Project Web <span class="text-red-500">*</span></label>
                    <input type="number" name="project_price" value="{{ old('project_price', $client_proposal->project_price) }}" required class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all">
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Harga Domain & Hosting <span class="text-red-500">*</span></label>
                    <input type="number" name="domain_price" value="{{ old('domain_price', $client_proposal->domain_price) }}" required class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all">
                </div>
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-slate-700 mb-2">Template Pesan WhatsApp</label>
                <textarea name="wa_template" rows="3" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all">{{ old('wa_template', $client_proposal->wa_template) }}</textarea>
            </div>

            <div class="flex justify-end pt-4 border-t border-slate-100">
                <button type="submit" class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors shadow-sm">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
