@extends('layouts.admin.app')

@section('content')

<div class="max-w-6xl mx-auto px-4 py-8">
    {{-- ✅ Header --}}
    <div class="flex flex-col sm:flex-row justify-between items-center mb-5 gap-4">
        <h2 class="text-2xl font-semibold text-slate-800">Daftar Kategori Blog</h2>

        <div class="flex gap-2">
            {{-- 🔍 Search Bar --}}
            <form method="GET" class="flex items-center gap-2">
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama kategori..." class="border border-gray-300 rounded-md px-3 py-1.5 w-56 text-sm focus:ring focus:ring-blue-900/30 focus:border-blue-900 outline-none transition" />
                <button type="submit" class="bg-blue-900 text-white px-3 py-1.5 rounded-md text-sm font-medium shadow-sm hover:bg-blue-950 transition">
                    Cari
                </button>
            </form>

            {{-- ➕ Tambah Kategori --}}
            <a href="{{ route('blog-categories.create') }}" class="bg-blue-900 text-white px-4 py-1.5 rounded-md text-sm font-medium shadow-sm hover:bg-blue-950 transition">
                + Tambah Kategori
            </a>
        </div>
    </div>

    {{-- ✅ Alert --}}
    @if(session('success'))
    <div class="mb-4 p-4 rounded-lg bg-green-100 border border-green-300 text-green-800">
        {{ session('success') }}
    </div>
    @endif

    {{-- ✅ Table --}}
    <div class="overflow-x-auto bg-white rounded-lg shadow-sm border border-gray-100">
        <table class="min-w-full text-sm text-left text-gray-600">
            <thead class="bg-gray-50 text-gray-700 font-medium text-xs uppercase tracking-wider">
                <tr>
                    <th class="py-2.5 px-3">#</th>
                    <th class="py-2.5 px-3">Nama Kategori</th>
                    <th class="py-2.5 px-3">Slug</th>
                    <th class="py-2.5 px-3">Urutan</th>
                    <th class="py-2.5 px-3">Status</th>
                    <th class="py-2.5 px-3 text-center">Aksi</th>
                </tr>
            </thead>

            <tbody class="text-[13px]">
                @forelse($categories as $i => $category)
                <tr class="border-b border-gray-50 hover:bg-gray-50/50 transition">
                    <td class="py-2 px-3">{{ $categories->firstItem() + $i }}</td>
                    <td class="py-2 px-3 font-medium text-gray-800 max-w-[240px] truncate">{{ $category->name }}</td>
                    <td class="py-2 px-3 text-gray-600">{{ $category->slug }}</td>
                    <td class="py-2 px-3 text-gray-600">{{ $category->display_order }}</td>
                    <td class="py-2 px-3">
                        @if($category->is_active)
                        <span class="px-2 py-0.5 bg-green-50 text-green-600 border border-green-200 rounded-md text-[11px] font-medium">Aktif</span>
                        @else
                        <span class="px-2 py-0.5 bg-red-50 text-red-600 border border-red-200 rounded-md text-[11px] font-medium">Nonaktif</span>
                        @endif
                    </td>
                    <td class="py-2 px-3 text-center flex gap-1.5 justify-center">
                        <a href="{{ route('blog-categories.edit', $category->id) }}" class="px-2.5 py-1 bg-yellow-50 text-yellow-600 hover:bg-yellow-100 border border-yellow-200 rounded-md text-[11px] font-medium transition">
                            Edit
                        </a>
                        <form action="{{ route('blog-categories.destroy', $category->id) }}" method="POST" onsubmit="return confirm('Yakin hapus kategori ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-2.5 py-1 bg-red-50 text-red-600 hover:bg-red-100 border border-red-200 rounded-md text-[11px] font-medium transition">
                                Hapus
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="py-6 text-center text-gray-500 italic text-sm">
                        Belum ada kategori yang ditambahkan.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- ✅ Pagination --}}
    <div class="mt-6">
        {{ $categories->links('pagination::tailwind') }}
    </div>
</div>

@endsection
