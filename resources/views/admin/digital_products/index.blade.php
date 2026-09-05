@extends('layouts.admin.app')

@section('content')
<div class="px-4 lg:px-6 py-6 lg:py-8">
    <!-- Header -->
    <div class="mb-8 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-800 flex items-center gap-2.5">
                <i class="fa-solid fa-cubes-stacked text-amber-500"></i>
                Produk Digital (Lynk.id)
            </h1>
            <p class="text-slate-500 text-sm mt-1">Kelola katalog produk digital Lynk.id yang dapat dibagikan oleh Affiliate.</p>
        </div>
        <a href="{{ route('admin.digital_products.create') }}" class="inline-flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2.5 rounded-xl shadow-sm text-sm font-semibold transition-colors w-full sm:w-auto">
            <i class="fa-solid fa-plus"></i>
            <span>Tambah Produk Digital</span>
        </a>
    </div>

    <!-- Alert Messages -->
    @if(session('success'))
    <div class="bg-emerald-50 border-l-4 border-emerald-500 text-emerald-700 p-4 rounded-r-xl mb-6 text-sm flex items-center gap-3" role="alert">
        <i class="fa-solid fa-circle-check text-emerald-500 text-base"></i>
        <span>{{ session('success') }}</span>
    </div>
    @endif

    @if(session('error'))
    <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded-r-xl mb-6 text-sm flex items-center gap-3" role="alert">
        <i class="fa-solid fa-circle-exclamation text-red-500 text-base"></i>
        <span>{{ session('error') }}</span>
    </div>
    @endif

    <!-- Filters & Search -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-4 mb-6">
        <form method="GET" action="{{ route('admin.digital_products.index') }}" class="flex flex-col sm:flex-row gap-3">
            <div class="flex-1 relative">
                <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400 text-sm">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </span>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama produk, kategori, atau kode Lynk..." class="w-full pl-10 pr-4 py-2 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all">
            </div>

            <div class="sm:w-48">
                <select name="category" onchange="this.form.submit()" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all bg-white">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $cat)
                    <option value="{{ $cat }}" {{ request('category') === $cat ? 'selected' : '' }}>{{ $cat }}</option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="px-4 py-2 bg-slate-800 hover:bg-slate-900 text-white rounded-lg text-sm font-medium transition-colors">
                Filter
            </button>
            @if(request('search') || request('category'))
            <a href="{{ route('admin.digital_products.index') }}" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg text-sm font-medium transition-colors text-center">
                Reset
            </a>
            @endif
        </form>
    </div>

    <!-- Table List -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200">
                        <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Produk</th>
                        <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Kategori</th>
                        <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Kode Lynk.id</th>
                        <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Harga Produk</th>
                        <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    @forelse($products as $product)
                    <tr class="hover:bg-slate-50/80 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3.5">
                                <div class="w-11 h-11 rounded-xl bg-amber-50 border border-amber-200 flex items-center justify-center text-amber-600 shrink-0 font-bold overflow-hidden">
                                    @if($product->thumbnail)
                                    <img src="{{ asset('storage/' . $product->thumbnail) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                                    @else
                                    <i class="fa-solid fa-cube text-base"></i>
                                    @endif
                                </div>
                                <div class="min-w-0">
                                    <div class="font-bold text-slate-900 text-sm leading-snug line-clamp-1">{{ $product->name }}</div>
                                    <p class="text-xs text-slate-400 line-clamp-1 mt-0.5">{{ $product->short_description ?? 'Tidak ada deskripsi singkat' }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-medium bg-slate-100 text-slate-700 border border-slate-200">
                                {{ $product->category ?? 'General' }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-1.5">
                                <code class="px-2 py-1 bg-amber-50 border border-amber-200 rounded text-xs font-mono text-amber-700 font-bold">
                                    {{ $product->lynk_slug }}
                                </code>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm font-bold text-slate-900">
                                Rp {{ number_format($product->price, 0, ',', '.') }}
                            </div>
                            <div class="text-[11px] text-slate-400 mt-0.5">
                                Komisi diatur per affiliate
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            @if($product->is_active)
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                Aktif
                            </span>
                            @else
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-slate-100 text-slate-600">
                                <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span>
                                Nonaktif
                            </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right space-x-1.5">
                            <a href="{{ route('admin.digital_products.edit', $product->id) }}" class="inline-flex items-center justify-center w-8 h-8 bg-amber-100 hover:bg-amber-200 text-amber-800 rounded-lg transition-colors" title="Edit Produk">
                                <i class="fa-solid fa-pen text-xs"></i>
                            </a>
                            <form action="{{ route('admin.digital_products.destroy', $product->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk digital ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="inline-flex items-center justify-center w-8 h-8 bg-red-100 hover:bg-red-200 text-red-700 rounded-lg transition-colors" title="Hapus Produk">
                                    <i class="fa-solid fa-trash text-xs"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-slate-500">
                            <div class="w-12 h-12 rounded-full bg-slate-100 text-slate-400 flex items-center justify-center mx-auto mb-3 text-lg">
                                <i class="fa-solid fa-cubes-stacked"></i>
                            </div>
                            <p class="font-medium text-sm text-slate-700">Belum ada produk digital yang ditemukan.</p>
                            <p class="text-xs text-slate-400 mt-1">Silakan tambahkan produk baru untuk affiliate Lynk.id.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($products->hasPages())
        <div class="px-6 py-4 border-t border-slate-200">
            {{ $products->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
