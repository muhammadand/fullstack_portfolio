@extends('layouts.admin.app')

@section('content')

<div class="max-w-6xl mx-auto px-4 py-8">
    {{-- ✅ Header --}}
    <div class="flex flex-col sm:flex-row justify-between items-center mb-5 gap-4">
        <h2 class="hidden sm:block text-2xl font-semibold text-slate-800">Daftar Kategori Portfolio</h2>

        <div class="w-full sm:w-auto">
            <form method="GET" class="flex flex-row items-center w-full sm:w-auto gap-2">
                {{-- 🔍 Search Bar --}}
                <div class="flex-1 min-w-0">
                    <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama atau slug..." class="w-full border border-gray-300 rounded-md px-3 py-1.5 sm:w-56 text-sm focus:ring focus:ring-blue-900/30 focus:border-blue-900 outline-none transition" />
                </div>
                
                {{-- Buttons sejajar di satu baris --}}
                <div class="flex flex-row items-center gap-2 flex-shrink-0">
                    <button type="submit" class="flex flex-col sm:flex-row items-center justify-center gap-0.5 sm:gap-2 text-slate-500 hover:text-blue-600 sm:bg-blue-900 sm:text-white sm:px-4 sm:py-1.5 sm:rounded-md sm:shadow-sm sm:hover:bg-blue-950 transition w-10 sm:w-auto">
                        <i class="fa-solid fa-magnifying-glass text-[15px] sm:text-sm"></i>
                        <span class="text-[9px] sm:text-sm font-medium">Cari</span>
                    </button>
                    
                    <a href="{{ route('portfolio-categories.create') }}" class="flex flex-col sm:flex-row items-center justify-center gap-0.5 sm:gap-2 text-blue-600 hover:text-blue-700 sm:bg-blue-900 sm:text-white sm:px-4 sm:py-1.5 sm:rounded-md sm:shadow-sm sm:hover:bg-blue-950 transition w-10 sm:w-auto">
                        <i class="fa-solid fa-circle-plus text-[15px] sm:text-sm"></i>
                        <span class="text-[9px] sm:text-sm font-medium">Tambah</span>
                    </a>
                </div>
            </form>
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

                    {{-- Sortable column example --}}
                    <th class="py-2.5 px-3">
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

                    <th class="py-2.5 px-3">
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

                    <th class="py-2.5 px-3">Aktif</th>
                    <th class="py-2.5 px-3">Urutan</th>
                    <th class="py-2.5 px-3 text-center">Aksi</th>
                </tr>
            </thead>

            <tbody class="text-[13px]">
                @forelse($items as $i => $item)
                <tr class="border-b border-gray-50 hover:bg-gray-50/50 transition">
                    <td class="py-2 px-3">{{ $items->firstItem() + $i }}</td>
                    <td class="py-2 px-3 font-medium text-gray-800">{{ $item->name }}</td>
                    <td class="py-2 px-3 text-gray-600">{{ $item->slug }}</td>
                    <td class="py-2 px-3">
                        @if($item->is_active)
                        <span class="px-2 py-0.5 bg-green-50 text-green-600 border border-green-200 rounded-md text-[11px] font-medium">Ya</span>
                        @else
                        <span class="px-2 py-0.5 bg-red-50 text-red-600 border border-red-200 rounded-md text-[11px] font-medium">Tidak</span>
                        @endif
                    </td>
                    <td class="py-2 px-3">{{ $item->display_order }}</td>
                    <td class="py-2 px-3 text-center flex gap-1.5 justify-center">
                        <a href="{{ route('portfolio-categories.edit', $item->id) }}" class="px-2.5 py-1 bg-yellow-50 text-yellow-600 hover:bg-yellow-100 border border-yellow-200 rounded-md text-[11px] font-medium transition">
                            Edit
                        </a>
                        <form action="{{ route('portfolio-categories.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin hapus data ini?')">
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
