@extends('layouts.admin.app')

@section('content')
<div class="px-4 lg:px-6 py-6 lg:py-8">
    <!-- Header -->
    <div class="mb-8 flex items-center gap-4">
        <a href="{{ route('admin.digital_products.index') }}" class="w-10 h-10 bg-white border border-slate-200 rounded-full flex items-center justify-center text-slate-500 hover:text-blue-600 hover:border-blue-600 transition-colors shadow-sm">
            <i class="fa-solid fa-arrow-left"></i>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Edit Produk Digital</h1>
            <p class="text-slate-500 text-sm mt-1">Perbarui informasi produk digital Lynk.id.</p>
        </div>
    </div>

    <!-- Error Alerts -->
    @if($errors->any())
    <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded-r-xl mb-6 text-sm" role="alert">
        <div class="font-bold mb-1">Terdapat kesalahan input:</div>
        <ul class="list-disc pl-5 space-y-1">
            @foreach($errors->all() as $err)
            <li>{{ $err }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <!-- Form -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
        <form action="{{ route('admin.digital_products.update', $digitalProduct->id) }}" method="POST" enctype="multipart/form-data" class="p-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <!-- Nama Produk -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-slate-700 mb-2">Nama Produk Digital <span class="text-red-500">*</span></label>
                    <input type="text" name="name" value="{{ old('name', $digitalProduct->name) }}" required class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none text-sm transition-all">
                </div>

                <!-- Slug -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Slug URL Sistem <span class="text-red-500">*</span></label>
                    <input type="text" name="slug" value="{{ old('slug', $digitalProduct->slug) }}" required class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none font-mono text-sm transition-all">
                </div>

                <!-- Kode Produk Lynk.id -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Kode Produk Lynk.id (lynk_slug) <span class="text-red-500">*</span></label>
                    <input type="text" name="lynk_slug" value="{{ old('lynk_slug', $digitalProduct->lynk_slug) }}" required class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500 outline-none font-mono text-sm transition-all">
                    <p class="text-xs text-slate-500 mt-1.5">
                        <i class="fa-solid fa-circle-info text-amber-500 mr-1"></i>
                        Kode unik di akhir URL produk Lynk.id (misal: <code>https://lynk.id/a/1035009226/<b>{{ $digitalProduct->lynk_slug }}</b></code>).
                    </p>
                </div>

                <!-- Kategori -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Kategori Produk</label>
                    <input type="text" name="category" list="category_list" value="{{ old('category', $digitalProduct->category) }}" placeholder="Pilih atau ketik kategori..." class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none text-sm transition-all">
                    <datalist id="category_list">
                        <option value="Source Code">
                        <option value="Skripsi & Algoritma">
                        <option value="Template Website">
                        <option value="Trading & Finansial">
                        <option value="E-Book & Panduan">
                    </datalist>
                </div>

                <!-- Harga Produk -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Harga Jual (Rp) <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-500 text-sm font-semibold">Rp</span>
                        <input type="number" name="price" value="{{ old('price', (int)$digitalProduct->price) }}" min="0" required class="w-full pl-12 pr-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none text-sm transition-all">
                    </div>
                </div>

                <!-- Demo URL -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Link Live Demo (Opsional)</label>
                    <input type="url" name="demo_url" value="{{ old('demo_url', $digitalProduct->demo_url) }}" placeholder="https://demo.example.com" class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none text-sm transition-all">
                </div>

                <!-- Urutan Tampilan -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Urutan Tampilan (Sort Order)</label>
                    <input type="number" name="display_order" value="{{ old('display_order', $digitalProduct->display_order) }}" min="0" class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none text-sm transition-all">
                </div>

                <!-- Cover Image / Thumbnail -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-slate-700 mb-2">Cover / Gambar Thumbnail (Opsional)</label>
                    @if($digitalProduct->thumbnail)
                    <div class="mb-3 flex items-center gap-3 p-3 bg-slate-50 rounded-lg border border-slate-200">
                        <img src="{{ asset('storage/' . $digitalProduct->thumbnail) }}" alt="Thumbnail" class="w-16 h-16 rounded-lg object-cover">
                        <div class="text-xs text-slate-500">
                            <p class="font-medium text-slate-700">Cover saat ini</p>
                            <p>Unggah file baru di bawah jika ingin mengganti.</p>
                        </div>
                    </div>
                    @endif
                    <input type="file" name="thumbnail" accept="image/*" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none text-sm transition-all file:mr-4 file:py-1 file:px-3 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                </div>

                <!-- Deskripsi Singkat -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-slate-700 mb-2">Deskripsi Singkat (Muncul di WA share / preview card)</label>
                    <textarea name="short_description" rows="2" class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none text-sm transition-all">{{ old('short_description', $digitalProduct->short_description) }}</textarea>
                </div>

                <!-- Deskripsi Lengkap -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-slate-700 mb-2">Deskripsi Lengkap</label>
                    <textarea name="description" rows="4" class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none text-sm transition-all">{{ old('description', $digitalProduct->description) }}</textarea>
                </div>

                <!-- Checkbox Status Aktif -->
                <div class="md:col-span-2">
                    <label class="inline-flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', $digitalProduct->is_active) ? 'checked' : '' }} class="w-4 h-4 rounded text-blue-600 focus:ring-blue-500 border-slate-300">
                        <span class="text-sm font-medium text-slate-700">Aktifkan produk ini di katalog Affiliate</span>
                    </label>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end gap-3 pt-5 border-t border-slate-100">
                <a href="{{ route('admin.digital_products.index') }}" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-sm font-medium rounded-lg transition-colors">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-lg transition-colors shadow-sm flex items-center gap-2">
                    <i class="fa-solid fa-save"></i>
                    Perbarui Produk
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
