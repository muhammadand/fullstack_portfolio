@extends('layouts.admin.app')

@section('content')
<div class="px-4 lg:px-6 py-6 lg:py-8">
    <div class="mb-6 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Data Pelamar</h1>
            <p class="text-slate-500 text-sm mt-1">Kelola data pelamar (Career Applications).</p>
        </div>
        <div class="flex flex-wrap items-center gap-2.5 w-full md:w-auto">
            <!-- Search Form -->
            <form action="{{ route('career-applications.index') }}" method="GET" class="relative w-full md:w-64">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                    <i class="fa-solid fa-magnifying-glass text-sm"></i>
                </div>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari pelamar..." class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-200 text-slate-700 text-sm rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition-all">
            </form>

            <a href="{{ route('career-applications.create') }}" class="px-4 py-2.5 bg-blue-900 hover:bg-blue-950 text-white text-sm font-semibold rounded-lg transition-colors shadow-sm flex items-center justify-center gap-2 w-full md:w-auto">
                <i class="fa-solid fa-plus"></i> Create
            </a>
        </div>
    </div>

    {{-- ✅ Alert --}}
    @if (session('success'))
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
                    <th class="py-2.5 px-3">Nama Pelamar</th>
                    <th class="py-2.5 px-3">Kontak</th>
                    <th class="py-2.5 px-3">Posisi Dilamar</th>
                    <th class="py-2.5 px-3">Tanggal Apply</th>
                    <th class="py-2.5 px-3 text-center">Aksi</th>
                </tr>
            </thead>

            <tbody class="text-[13px]">
                @forelse($applications as $i => $app)
                <tr class="border-b border-gray-50 hover:bg-gray-50/50 transition">
                    <td class="py-2 px-3">{{ $applications->firstItem() + $i }}</td>
                    <td class="py-2 px-3 font-medium text-gray-800 max-w-[200px] truncate">
                        {{ $app->full_name }}
                    </td>
                    <td class="py-2 px-3 text-gray-600">
                        <div>{{ $app->email }}</div>
                        <div class="text-[11px] text-gray-400">{{ $app->phone ?? '-' }}</div>
                    </td>
                    <td class="py-2 px-3 text-gray-600">
                        <span class="font-medium text-blue-700 bg-blue-50 px-2 py-0.5 rounded-md">
                            {{ $app->career->title ?? 'Posisi Dihapus' }}
                        </span>
                    </td>
                    <td class="py-2 px-3 text-gray-500">
                        {{ $app->applied_at ? $app->applied_at->format('d M Y, H:i') : '-' }}
                    </td>
                    <td class="py-2 px-3 text-center flex gap-1.5 justify-center items-center">

                        <a href="{{ route('career-applications.edit', $app->id) }}" class="px-2.5 py-1 bg-yellow-50 text-yellow-600 hover:bg-yellow-100 border border-yellow-200 rounded-md text-[11px] font-medium transition" title="Edit Data">
                            Edit
                        </a>

                        @if($app->resume)
                        <a href="{{ asset('storage/' . $app->resume) }}" target="_blank" class="px-2.5 py-1 bg-green-50 text-green-600 hover:bg-green-100 border border-green-200 rounded-md text-[11px] font-medium transition" title="Lihat CV/Resume">
                            Resume
                        </a>
                        @endif

                        <form action="{{ route('career-applications.destroy', $app->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data pelamar ini secara permanen?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-2.5 py-1 bg-red-50 text-red-600 hover:bg-red-100 border border-red-200 rounded-md text-[11px] font-medium transition" title="Hapus Data">
                                Hapus
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="py-8 text-center text-gray-500 italic text-sm">
                        Belum ada pelamar yang masuk saat ini.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- ✅ Pagination --}}
    <div class="mt-6">
        {{ $applications->links('pagination::tailwind') }}
    </div>
</div>
@endsection
