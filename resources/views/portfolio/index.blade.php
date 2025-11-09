@extends('layouts.app')

@section('content')
<br><br><br><br><br>

<div class="max-w-6xl mx-auto px-6 py-10">
    {{-- ✅ Header --}}
    <div class="flex flex-col sm:flex-row justify-between items-center mb-6 gap-4">
        <h2 class="text-3xl font-bold gradient-text">Daftar Portfolio</h2>

        <div class="flex gap-2">
            {{-- ➕ Tambah --}}
            <a href="{{ route('portfolio.create') }}"
               class="gradient-primary text-white px-5 py-2 rounded-lg font-medium shadow hover:shadow-lg transition">
               + Tambah Portfolio
            </a>
        </div>
    </div>

    {{-- ✅ Filter & Search --}}
    <form method="GET" class="flex flex-col sm:flex-row gap-3 mb-6 items-center">
        <input 
            type="text" 
            name="search" 
            value="{{ request('search') }}"
            placeholder="Cari judul portfolio..." 
            class="border border-gray-300 rounded-lg px-3 py-2 w-full sm:w-56 focus:ring focus:ring-blue-200"
        />

        <select name="category_id" class="border border-gray-300 rounded-lg px-3 py-2 focus:ring focus:ring-blue-200">
            <option value="">-- Semua Kategori --</option>
            @foreach($categories as $cat)
                <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>
                    {{ $cat->name }}
                </option>
            @endforeach
        </select>

        <select name="is_active" class="border border-gray-300 rounded-lg px-3 py-2 focus:ring focus:ring-blue-200">
            <option value="">-- Semua Status --</option>
            <option value="1" {{ request('is_active') === '1' ? 'selected' : '' }}>Aktif</option>
            <option value="0" {{ request('is_active') === '0' ? 'selected' : '' }}>Nonaktif</option>
        </select>

        <button 
            type="submit"
            class="bg-blue-600 text-white px-5 py-2 rounded-lg hover:bg-blue-700 transition">
            Filter
        </button>
    </form>

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
                    <th class="py-3 px-4">Judul</th>
                    <th class="py-3 px-4">Kategori</th>
                    <th class="py-3 px-4">Status</th>
                    <th class="py-3 px-4">Gambar</th>
                    <th class="py-3 px-4 text-center">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse($portfolios as $i => $item)
                    <tr class="border-b hover:bg-gray-50 transition">
                        <td class="py-3 px-4">{{ $portfolios->firstItem() + $i }}</td>
                        <td class="py-3 px-4 font-medium text-gray-900">{{ $item->title }}</td>
                        <td class="py-3 px-4">
                            {{ $item->category ? $item->category->name : '-' }}
                        </td>
                        <td class="py-3 px-4">
                            <span class="px-2 py-1 rounded text-xs font-semibold
                                {{ $item->is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                {{ $item->is_active ? 'Aktif' : 'Nonaktif' }}
                            </span>
                        </td>
                        <td class="py-3 px-4">
                            @if($item->thumbnail_image)
                                <img src="{{ asset('storage/' . $item->thumbnail_image) }}" 
                                     alt="thumbnail" class="w-20 rounded-md shadow-sm">
                            @else
                                <span class="text-gray-400 italic">Tidak ada gambar</span>
                            @endif
                        </td>
                        <td class="py-3 px-4 text-center flex gap-2 justify-center">
                            <a href="{{ route('portfolio.show', $item->id) }}"
                               class="px-3 py-1 bg-blue-500 hover:bg-blue-600 text-white rounded-lg text-xs font-semibold transition">
                               Detail
                            </a>
                            <a href="{{ route('portfolio.edit', $item->id) }}"
                               class="px-3 py-1 bg-yellow-400 hover:bg-yellow-500 text-white rounded-lg text-xs font-semibold transition">
                               Edit
                            </a>
                            <form action="{{ route('portfolio.destroy', $item->id) }}" method="POST" 
                                  onsubmit="return confirm('Yakin hapus data ini?')" class="inline-block">
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
                            Belum ada portfolio.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- ✅ Pagination --}}
    <div class="mt-6">
        {{ $portfolios->appends(request()->query())->links('pagination::tailwind') }}
    </div>
</div>
@endsection
