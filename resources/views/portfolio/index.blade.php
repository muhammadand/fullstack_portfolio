@extends('layouts.admin.app')

@section('content')


<div class="max-w-6xl mx-auto px-4 py-8">
    {{-- ✅ Header --}}
    <div class="flex flex-col sm:flex-row justify-between items-center mb-5 gap-4">
        <h2 class="hidden sm:block text-2xl font-semibold text-slate-800">Daftar Portfolio</h2>

        <div class="hidden sm:flex flex-col sm:flex-row w-full sm:w-auto gap-2">
            {{-- ➕ Tambah (Desktop Only) --}}
            <a href="{{ route('portfolio.create') }}" class="flex flex-col sm:flex-row items-center justify-center gap-1 sm:gap-2 text-blue-600 hover:text-blue-700 sm:bg-blue-900 sm:text-white sm:px-4 sm:py-1.5 sm:rounded-md sm:shadow-sm sm:hover:bg-blue-950 transition w-full sm:w-auto">
                <i class="fa-solid fa-circle-plus text-xl sm:text-sm"></i>
                <span class="text-[11px] sm:text-sm font-medium">Create</span>
            </a>
        </div>
    </div>

    {{-- ✅ Filter & Search --}}
    <form method="GET" class="flex flex-col gap-3 mb-6">
        <div class="flex flex-row items-center w-full gap-2">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari judul portfolio..." class="flex-1 min-w-0 border border-gray-300 rounded-md px-3 py-1.5 text-sm focus:ring focus:ring-blue-900/30 focus:border-blue-900 outline-none transition" />

            <div class="flex flex-row items-center gap-2 flex-shrink-0">
                <button type="submit" class="flex flex-col sm:flex-row items-center justify-center gap-0.5 sm:gap-2 text-slate-500 hover:text-blue-600 sm:bg-blue-900 sm:text-white sm:px-4 sm:py-1.5 sm:rounded-md sm:shadow-sm sm:hover:bg-blue-950 transition w-10 sm:w-auto">
                    <i class="fa-solid fa-filter text-[15px] sm:text-sm"></i>
                    <span class="text-[9px] sm:text-sm font-medium">Filter</span>
                </button>

                <a href="{{ route('portfolio.create') }}" class="sm:hidden flex flex-col items-center justify-center gap-0.5 text-blue-600 hover:text-blue-700 transition w-10">
                    <i class="fa-solid fa-circle-plus text-[15px]"></i>
                    <span class="text-[9px] font-medium">Create</span>
                </a>
            </div>
        </div>

        <div class="flex flex-row gap-2 w-full">
            <select name="category_id" class="w-1/2 border border-gray-300 rounded-md px-2 py-1.5 text-[13px] sm:text-sm focus:ring focus:ring-blue-900/30 focus:border-blue-900 outline-none transition bg-white">
                <option value="">-- Kategori --</option>
                @foreach($categories as $cat)
                <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>
                    {{ Str::limit($cat->name, 15) }}
                </option>
                @endforeach
            </select>

            <select name="is_active" class="w-1/2 border border-gray-300 rounded-md px-2 py-1.5 text-[13px] sm:text-sm focus:ring focus:ring-blue-900/30 focus:border-blue-900 outline-none transition bg-white">
                <option value="">-- Status --</option>
                <option value="1" {{ request('is_active') === '1' ? 'selected' : '' }}>Aktif</option>
                <option value="0" {{ request('is_active') === '0' ? 'selected' : '' }}>Nonaktif</option>
            </select>
        </div>
    </form>

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
                    <th class="py-2.5 px-3">Judul</th>
                    <th class="py-2.5 px-3">Kategori</th>
                    <th class="py-2.5 px-3">Status</th>
                    <th class="py-2.5 px-3">Gambar</th>
                    <th class="py-2.5 px-3 text-center">Aksi</th>
                </tr>
            </thead>

            <tbody class="text-[13px]">
                @forelse($portfolios as $i => $item)
                <tr class="border-b border-gray-50 hover:bg-gray-50/50 transition">
                    <td class="py-2 px-3">{{ $portfolios->firstItem() + $i }}</td>
                    <td class="py-2 px-3 font-medium text-gray-800">{{ $item->title }}</td>
                    <td class="py-2 px-3">
                        {{ $item->category ? $item->category->name : '-' }}
                    </td>
                    <td class="py-2 px-3">
                        <span class="px-2 py-0.5 rounded-md text-[11px] font-medium border
                                {{ $item->is_active ? 'bg-green-50 text-green-600 border-green-200' : 'bg-red-50 text-red-600 border-red-200' }}">
                            {{ $item->is_active ? 'Aktif' : 'Nonaktif' }}
                        </span>
                    </td>
                    <td class="py-2 px-3">
                        @if($item->thumbnail_image)
                        <img src="{{ asset('storage/' . $item->thumbnail_image) }}" alt="thumbnail" class="w-16 rounded shadow-sm border border-gray-200">
                        @else
                        <span class="text-gray-400 italic">Tidak ada gambar</span>
                        @endif
                    </td>
                    <td class="py-2 px-3 text-center flex gap-1.5 justify-center">
                        <a href="{{ route('portfolio.edit', $item->id) }}" class="px-2.5 py-1 bg-yellow-50 text-yellow-600 hover:bg-yellow-100 border border-yellow-200 rounded-md text-[11px] font-medium transition">
                            Edit
                        </a>
                        <form action="{{ route('portfolio.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin hapus data ini?')" class="inline-block">
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
