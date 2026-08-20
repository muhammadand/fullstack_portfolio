@extends('layouts.admin.app')

@section('content')
<div class="px-4 lg:px-6 py-6 lg:py-8">
    <div class="mb-8 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div class="hidden sm:block">
            <h1 class="text-2xl font-bold text-slate-800">Business Categories</h1>
            <p class="text-slate-500 text-sm mt-1">Kelola kategori bisnis untuk template halaman dan proposal.</p>
        </div>
        <a href="{{ route('admin.business_categories.create') }}" class="flex flex-col sm:flex-row items-center justify-center gap-1 sm:gap-2 text-blue-600 hover:text-blue-700 sm:bg-blue-600 sm:hover:bg-blue-700 sm:text-white sm:px-4 sm:py-2.5 sm:rounded-lg sm:shadow-sm transition-colors w-full sm:w-auto mt-2 sm:mt-0">
            <i class="fa-solid fa-circle-plus text-xl sm:text-sm"></i>
            <span class="text-[11px] sm:text-sm font-medium">Tambah Kategori</span>
        </a>
    </div>

    @if(session('success'))
    <div class="bg-emerald-100 border-l-4 border-emerald-500 text-emerald-700 p-4 mb-6" role="alert">
        <p>{{ session('success') }}</p>
    </div>
    @endif

    @if(session('error'))
    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
        <p>{{ session('error') }}</p>
    </div>
    @endif

    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200">
                        <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">ID</th>
                        <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Nama Kategori</th>
                        <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Slug Tema</th>
                        <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Harga Default</th>
                        <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    @forelse($categories as $cat)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-4 text-sm font-medium text-slate-500">
                            #{{ $cat->id }}
                        </td>
                        <td class="px-6 py-4">
                            <div class="font-bold text-slate-800">{{ $cat->name }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 bg-slate-100 rounded text-xs font-mono text-slate-600">{{ $cat->slug }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm font-bold text-emerald-600">Rp {{ number_format($cat->project_price, 0, ',', '.') }}</div>
                        </td>
                        <td class="px-6 py-4 text-right space-x-2">
                            <a href="{{ route('admin.business_categories.edit', $cat->id) }}" class="px-3 py-1.5 bg-yellow-100 hover:bg-yellow-200 text-yellow-700 text-xs font-medium rounded-lg transition-colors" title="Edit Data">
                                <i class="fa-solid fa-pen"></i>
                            </a>
                            <form action="{{ route('admin.business_categories.destroy', $cat->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-3 py-1.5 bg-red-100 hover:bg-red-200 text-red-700 text-xs font-medium rounded-lg transition-colors" title="Hapus Data">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center text-slate-500">
                            Belum ada data kategori bisnis yang ditambahkan.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
