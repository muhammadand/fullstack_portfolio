@extends('layouts.admin.app')

@section('content')
<x-admin.page-header title="Daftar Kategori Portfolio" subtitle="Kelola kategori untuk mengelompokkan karya portfolio.">
    <x-admin.button icon="fa-solid fa-plus" :href="route('portfolio-categories.create')">Tambah Kategori</x-admin.button>
</x-admin.page-header>

@if (session('success'))
<x-admin.alert type="success">{{ session('success') }}</x-admin.alert>
@endif

<x-admin.card :padding="false">
    {{-- Toolbar pencarian --}}
    <form method="GET" class="flex flex-col sm:flex-row gap-2 p-4 border-b border-slate-200">
        <div class="relative flex-1 sm:max-w-sm">
            <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-sm text-slate-400"></i>
            <x-admin.input name="q" :value="request('q')" placeholder="Cari nama atau slug..." class="pl-9" />
        </div>
        <div class="flex gap-2">
            <x-admin.button type="submit" variant="secondary">Cari</x-admin.button>
            @if (request('q'))
            <x-admin.button variant="secondary" icon="fa-solid fa-xmark" :href="route('portfolio-categories.index')">Reset</x-admin.button>
            @endif
        </div>
    </form>

    <div class="overflow-x-auto">
        <table class="min-w-full text-sm">
            <thead class="bg-slate-50 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                <tr>
                    <th class="px-4 py-3 w-12">#</th>
                    <th class="px-4 py-3">Nama Kategori</th>
                    <th class="px-4 py-3">Slug</th>
                    <th class="px-4 py-3">Urutan</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 text-slate-600">
                @forelse ($items as $i => $item)
                <tr class="hover:bg-slate-50/70 transition-colors">
                    <td class="px-4 py-3 text-slate-400">{{ $items->firstItem() + $i }}</td>
                    <td class="px-4 py-3 max-w-xs">
                        <span class="block font-medium text-slate-900 truncate" title="{{ $item->name }}">{{ $item->name }}</span>
                        @if($item->description)
                        <span class="text-xs text-slate-500 truncate block">{{ $item->description }}</span>
                        @endif
                    </td>
                    <td class="px-4 py-3 whitespace-nowrap text-slate-500 font-mono text-xs">{{ $item->slug }}</td>
                    <td class="px-4 py-3 whitespace-nowrap text-slate-600">{{ $item->display_order }}</td>
                    <td class="px-4 py-3 whitespace-nowrap">
                        @if ($item->is_active)
                        <x-admin.badge color="green"><i class="fa-solid fa-circle text-[6px]"></i> Aktif</x-admin.badge>
                        @else
                        <x-admin.badge color="slate"><i class="fa-solid fa-circle text-[6px]"></i> Nonaktif</x-admin.badge>
                        @endif
                    </td>
                    <td class="px-4 py-3">
                        <div class="flex items-center justify-end gap-1.5">
                            <x-admin.button variant="secondary" size="sm" icon="fa-solid fa-pen" :href="route('portfolio-categories.edit', $item->id)">Edit</x-admin.button>
                            <form action="{{ route('portfolio-categories.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Hapus kategori ini?')">
                                @csrf
                                @method('DELETE')
                                <x-admin.button type="submit" variant="danger" size="sm" icon="fa-solid fa-trash-can" title="Hapus" aria-label="Hapus" />
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-4 py-12 text-center">
                        <i class="fa-regular fa-folder-open text-3xl text-slate-300 mb-2"></i>
                        <p class="text-sm text-slate-500">{{ request('q') ? 'Tidak ada kategori yang cocok dengan pencarian.' : 'Belum ada kategori portfolio yang ditambahkan.' }}</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if ($items->hasPages())
    <div class="px-4 py-3 border-t border-slate-200">
        {{ $items->links('pagination::tailwind') }}
    </div>
    @endif
</x-admin.card>
@endsection
