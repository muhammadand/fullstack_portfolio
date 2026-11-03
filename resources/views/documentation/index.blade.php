@extends('layouts.admin.app')

@section('content')
<x-admin.page-header title="Daftar Dokumentasi" subtitle="Kelola foto dan dokumentasi kegiatan Sobat Scalify.">
    <x-admin.button icon="fa-solid fa-plus" :href="route('documentation.create')">Tambah Foto</x-admin.button>
</x-admin.page-header>

@if (session('success'))
<x-admin.alert type="success">{{ session('success') }}</x-admin.alert>
@endif

@if (session('error'))
<x-admin.alert type="error">{{ session('error') }}</x-admin.alert>
@endif

<x-admin.card :padding="false">
    {{-- Toolbar pencarian --}}
    <form method="GET" class="flex flex-col sm:flex-row gap-2 p-4 border-b border-slate-200">
        <div class="relative flex-1 sm:max-w-sm">
            <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-sm text-slate-400"></i>
            <x-admin.input name="q" :value="request('q')" placeholder="Cari judul dokumentasi..." class="pl-9" />
        </div>
        <div class="flex gap-2">
            <x-admin.button type="submit" variant="secondary">Cari</x-admin.button>
            @if (request('q'))
            <x-admin.button variant="secondary" icon="fa-solid fa-xmark" :href="route('documentation.index')">Reset</x-admin.button>
            @endif
        </div>
    </form>

    <div class="overflow-x-auto">
        <table class="min-w-full text-sm">
            <thead class="bg-slate-50 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                <tr>
                    <th class="px-4 py-3 w-12">#</th>
                    <th class="px-4 py-3 w-24">Foto</th>
                    <th class="px-4 py-3">Judul & Slug</th>
                    <th class="px-4 py-3">Diupload</th>
                    <th class="px-4 py-3 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 text-slate-600">
                @forelse ($documentation as $item)
                <tr class="hover:bg-slate-50/70 transition-colors">
                    <td class="px-4 py-3 text-slate-400">{{ $documentation->firstItem() + $loop->index }}</td>
                    <td class="px-4 py-3">
                        @if ($item->images && file_exists(public_path('images/' . $item->images)))
                        <a href="{{ asset('images/' . $item->images) }}" target="_blank" rel="noopener noreferrer" class="group relative block w-14 h-14 rounded-xl overflow-hidden border border-slate-200 bg-slate-100 shadow-xs hover:ring-2 hover:ring-blue-500 transition">
                            <img src="{{ asset('images/' . $item->images) }}" alt="{{ $item->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-200">
                            <span class="absolute inset-0 bg-black/20 opacity-0 group-hover:opacity-100 flex items-center justify-center transition-opacity">
                                <i class="fa-solid fa-arrow-up-right-from-square text-white text-xs"></i>
                            </span>
                        </a>
                        @else
                        <div class="w-14 h-14 rounded-xl border border-dashed border-slate-200 bg-slate-50 flex flex-col items-center justify-center text-slate-400">
                            <i class="fa-regular fa-image text-sm"></i>
                            <span class="text-[9px] mt-0.5">No img</span>
                        </div>
                        @endif
                    </td>
                    <td class="px-4 py-3 max-w-md">
                        <span class="block font-medium text-slate-900 truncate" title="{{ $item->title }}">{{ $item->title }}</span>
                        <span class="text-xs font-mono text-slate-400 block truncate" title="{{ $item->slug }}">{{ $item->slug }}</span>
                    </td>
                    <td class="px-4 py-3 whitespace-nowrap text-slate-500">
                        {{ $item->created_at?->format('d M Y, H:i') ?? '-' }}
                    </td>
                    <td class="px-4 py-3">
                        <div class="flex items-center justify-end gap-1.5">
                            @if ($item->images && file_exists(public_path('images/' . $item->images)))
                            <x-admin.button variant="secondary" size="sm" icon="fa-solid fa-eye" :href="asset('images/' . $item->images)" target="_blank" title="Lihat Foto Penuh" />
                            @endif
                            <x-admin.button variant="secondary" size="sm" icon="fa-solid fa-pen" :href="route('documentation.edit', $item->slug)">Edit</x-admin.button>
                            <form action="{{ route('documentation.destroy', $item->slug) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus foto dokumentasi ini?')">
                                @csrf
                                @method('DELETE')
                                <x-admin.button type="submit" variant="danger" size="sm" icon="fa-solid fa-trash-can" title="Hapus" aria-label="Hapus" />
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-4 py-12 text-center">
                        <div class="w-12 h-12 rounded-2xl bg-slate-100 text-slate-400 flex items-center justify-center mx-auto mb-3">
                            <i class="fa-solid fa-camera text-xl"></i>
                        </div>
                        <p class="text-sm font-medium text-slate-700">{{ request('q') ? 'Tidak ada dokumentasi yang cocok dengan pencarian.' : 'Belum ada foto dokumentasi.' }}</p>
                        <p class="text-xs text-slate-400 mt-1">{{ request('q') ? 'Coba kata kunci lain atau reset filter.' : 'Mulai tambahkan dokumentasi kegiatan untuk ditampilkan.' }}</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if ($documentation->hasPages())
    <div class="px-4 py-3 border-t border-slate-200">
        {{ $documentation->links('pagination::tailwind') }}
    </div>
    @endif
</x-admin.card>
@endsection
