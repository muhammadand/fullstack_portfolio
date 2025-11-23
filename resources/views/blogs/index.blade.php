@extends('layouts.admin.app')

@section('content')

<div class="max-w-6xl mx-auto px-6 py-10">
    {{-- ✅ Header --}}
    <div class="flex flex-col sm:flex-row justify-between items-center mb-6 gap-4">
        <h2 class="text-3xl font-bold gradient-text">Daftar Blog</h2>

        <div class="flex gap-2">
            {{-- 🔍 Search Bar --}}
            <form method="GET" class="flex items-center gap-2">
                <input 
                    type="text" 
                    name="q" 
                    value="{{ request('q') }}"
                    placeholder="Cari judul atau kategori..." 
                    class="border border-gray-300 rounded-lg px-3 py-2 w-56 focus:ring focus:ring-purple-200"
                />
                <button 
                    type="submit"
                    class="bg-gradient-to-r from-purple-600 to-purple-700 text-white px-4 py-2 rounded-lg hover:opacity-90 transition"
                >
                    Cari
                </button>
            </form>

            {{-- ➕ Tambah Blog --}}
            <a href="{{ route('blogs.create') }}"
               class="bg-gradient-to-r from-purple-600 to-purple-700 text-white px-5 py-2 rounded-lg font-medium shadow hover:shadow-lg transition">
               + Tambah Blog
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
                    <th class="py-3 px-4">Judul</th>
                    <th class="py-3 px-4">Kategori</th>
                    <th class="py-3 px-4">Penulis</th>
                    <th class="py-3 px-4">Diterbitkan</th>
                    <th class="py-3 px-4">Status</th>
                    <th class="py-3 px-4 text-center">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse($blogs as $i => $blog)
                    <tr class="border-b hover:bg-gray-50 transition">
                        <td class="py-3 px-4">{{ $blogs->firstItem() + $i }}</td>
                        <td class="py-3 px-4 font-medium text-gray-900 max-w-[240px] truncate">{{ $blog->title }}</td>
                        <td class="py-3 px-4 text-gray-700">{{ $blog->category->name ?? '-' }}</td>
                        <td class="py-3 px-4 text-gray-700">{{ $blog->author->name ?? '-' }}</td>
                        <td class="py-3 px-4">
                            @if($blog->published_at)
                                <span class="text-gray-800 text-xs">{{ $blog->published_at->format('d M Y') }}</span>
                            @else
                                <span class="text-gray-400 text-xs italic">-</span>
                            @endif
                        </td>
                        <td class="py-3 px-4">
                            @if($blog->is_published)
                                <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-semibold">Published</span>
                            @else
                                <span class="px-3 py-1 bg-yellow-100 text-yellow-700 rounded-full text-xs font-semibold">Draft</span>
                            @endif
                        </td>
                        <td class="py-3 px-4 text-center flex gap-2 justify-center">
                            <a href="{{ route('blogs.show', $blog->id) }}"
                               class="px-3 py-1 bg-blue-500 hover:bg-blue-600 text-white rounded-lg text-xs font-semibold transition">
                               Lihat
                            </a>
                            <a href="{{ route('blogs.edit', $blog->id) }}"
                               class="px-3 py-1 bg-yellow-400 hover:bg-yellow-500 text-white rounded-lg text-xs font-semibold transition">
                               Edit
                            </a>
                            <form action="{{ route('blogs.destroy', $blog->id) }}" method="POST"
                                  onsubmit="return confirm('Yakin hapus blog ini?')">
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
                        <td colspan="7" class="py-6 text-center text-gray-500 italic">
                            Belum ada blog yang ditambahkan.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- ✅ Pagination --}}
    <div class="mt-6">
        {{ $blogs->links('pagination::tailwind') }}
    </div>
</div>

@endsection
