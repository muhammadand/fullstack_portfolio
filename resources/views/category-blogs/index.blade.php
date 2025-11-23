@extends('layouts.admin.app')

@section('content')

<div class="max-w-6xl mx-auto px-6 py-10">
    {{-- ✅ Header --}}
    <div class="flex flex-col sm:flex-row justify-between items-center mb-6 gap-4">
        <h2 class="text-3xl font-bold gradient-text">Daftar Kategori Blog</h2>

        <div class="flex gap-2">
            {{-- 🔍 Search Bar --}}
            <form method="GET" class="flex items-center gap-2">
                <input 
                    type="text" 
                    name="q" 
                    value="{{ request('q') }}"
                    placeholder="Cari nama kategori..." 
                    class="border border-gray-300 rounded-lg px-3 py-2 w-56 focus:ring focus:ring-purple-200"
                />
                <button 
                    type="submit"
                    class="bg-gradient-to-r from-purple-600 to-purple-700 text-white px-4 py-2 rounded-lg hover:opacity-90 transition"
                >
                    Cari
                </button>
            </form>

            {{-- ➕ Tambah Kategori --}}
            <a href="{{ route('blog-categories.create') }}"
               class="bg-gradient-to-r from-purple-600 to-purple-700 text-white px-5 py-2 rounded-lg font-medium shadow hover:shadow-lg transition">
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
    <div class="overflow-x-auto bg-white rounded-xl shadow-md">
        <table class="min-w-full text-sm text-left text-gray-700">
            <thead class="gradient-primary text-black">
                <tr>
                    <th class="py-3 px-4">#</th>
                    <th class="py-3 px-4">Nama Kategori</th>
                    <th class="py-3 px-4">Slug</th>
                    <th class="py-3 px-4">Urutan</th>
                    <th class="py-3 px-4">Status</th>
                    <th class="py-3 px-4 text-center">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse($categories as $i => $category)
                    <tr class="border-b hover:bg-gray-50 transition">
                        <td class="py-3 px-4">{{ $categories->firstItem() + $i }}</td>
                        <td class="py-3 px-4 font-medium text-gray-900 max-w-[240px] truncate">{{ $category->name }}</td>
                        <td class="py-3 px-4 text-gray-700">{{ $category->slug }}</td>
                        <td class="py-3 px-4 text-gray-700">{{ $category->display_order }}</td>
                        <td class="py-3 px-4">
                            @if($category->is_active)
                                <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-semibold">Aktif</span>
                            @else
                                <span class="px-3 py-1 bg-red-100 text-red-700 rounded-full text-xs font-semibold">Nonaktif</span>
                            @endif
                        </td>
                        <td class="py-3 px-4 text-center flex gap-2 justify-center">
                            <a href="{{ route('blog-categories.edit', $category->id) }}"
                               class="px-3 py-1 bg-yellow-400 hover:bg-yellow-500 text-white rounded-lg text-xs font-semibold transition">
                               Edit
                            </a>
                            <form action="{{ route('blog-categories.destroy', $category->id) }}" method="POST"
                                  onsubmit="return confirm('Yakin hapus kategori ini?')">
                                @csrf 
                                @method('DELETE')
                                <button type="submit"
                                    class="px-3 py-1 bg-red-500 hover:bg-red-600 text-white rounded-lg text-xs font-semibold transition">
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="py-6 text-center text-gray-500 italic">
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
