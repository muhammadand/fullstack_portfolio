@extends('layouts.app')

@section('content')
<br>
<br>
<br>
<br>
<br>
<div class="max-w-6xl mx-auto px-6 py-10">
    {{-- ✅ Header --}}
    <div class="flex flex-col sm:flex-row justify-between items-center mb-6 gap-4">
        <h2 class="text-3xl font-bold gradient-text">Daftar Kategori Portfolio</h2>

        <div class="flex gap-2">
            {{-- 🔍 Search Bar --}}
            <form method="GET" class="flex items-center gap-2">
                <input 
                    type="text" 
                    name="q" 
                    value="{{ request('q') }}"
                    placeholder="Cari nama atau slug..." 
                    class="border border-gray-300 rounded-lg px-3 py-2 w-56 focus:ring focus:ring-blue-200"
                />
                <button 
                    type="submit"
                    class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition"
                >
                    Cari
                </button>
            </form>

            {{-- ➕ Tambah Kategori --}}
            <a href="{{ route('portfolio-categories.create') }}"
               class="gradient-primary text-white px-5 py-2 rounded-lg font-medium shadow hover:shadow-lg transition">
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
            <thead class="gradient-primary text-white">
                <tr>
                    <th class="py-3 px-4">#</th>

                    {{-- Sortable column example --}}
                    <th class="py-3 px-4">
                        <a href="?sort_by=name&order={{ request('order') === 'asc' ? 'desc' : 'asc' }}" class="flex items-center gap-1">
                            Nama
                            @if(request('sort_by') === 'name')
                                @if(request('order') === 'asc')
                                    ↑
                                @else
                                    ↓
                                @endif
                            @endif
                        </a>
                    </th>

                    <th class="py-3 px-4">
                        <a href="?sort_by=slug&order={{ request('order') === 'asc' ? 'desc' : 'asc' }}" class="flex items-center gap-1">
                            Slug
                            @if(request('sort_by') === 'slug')
                                @if(request('order') === 'asc')
                                    ↑
                                @else
                                    ↓
                                @endif
                            @endif
                        </a>
                    </th>

                    <th class="py-3 px-4">Aktif</th>
                    <th class="py-3 px-4">Urutan</th>
                    <th class="py-3 px-4 text-center">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse($items as $i => $item)
                    <tr class="border-b hover:bg-gray-50 transition">
                        <td class="py-3 px-4">{{ $items->firstItem() + $i }}</td>
                        <td class="py-3 px-4 font-medium text-gray-900">{{ $item->name }}</td>
                        <td class="py-3 px-4 text-gray-600">{{ $item->slug }}</td>
                        <td class="py-3 px-4">
                            @if($item->is_active)
                                <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-semibold">Ya</span>
                            @else
                                <span class="px-3 py-1 bg-red-100 text-red-700 rounded-full text-xs font-semibold">Tidak</span>
                            @endif
                        </td>
                        <td class="py-3 px-4">{{ $item->display_order }}</td>
                        <td class="py-3 px-4 text-center flex gap-2 justify-center">
                            <a href="{{ route('portfolio-categories.edit', $item->id) }}"
                               class="px-3 py-1 bg-yellow-400 hover:bg-yellow-500 text-white rounded-lg text-xs font-semibold transition">
                               Edit
                            </a>
                            <form action="{{ route('portfolio-categories.destroy', $item->id) }}" method="POST"
                                  onsubmit="return confirm('Yakin hapus data ini?')">
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
                            Belum ada kategori portfolio.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- ✅ Pagination --}}
    <div class="mt-6">
        {{ $items->links('pagination::tailwind') }}
    </div>
</div>
@endsection
