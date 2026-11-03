@extends('layouts.admin.app')

@section('content')
<x-admin.page-header title="Daftar Kategori Blog" subtitle="Kelola kategori artikel blog untuk memudahkan navigasi pembaca.">
    <x-admin.button icon="fa-solid fa-plus" :href="route('blog-categories.create')">Tambah Kategori</x-admin.button>
</x-admin.page-header>

@if (session('success'))
<x-admin.alert type="success">{{ session('success') }}</x-admin.alert>
@endif

<x-admin.card :padding="false">
    {{-- Toolbar pencarian --}}
    <form method="GET" class="flex flex-col sm:flex-row gap-2 p-4 border-b border-slate-200">
        <div class="relative flex-1 sm:max-w-sm">
            <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-sm text-slate-400"></i>
            <x-admin.input name="q" :value="request('q')" placeholder="Cari nama kategori..." class="pl-9" />
        </div>
        <div class="flex gap-2">
            <x-admin.button type="submit" variant="secondary">Cari</x-admin.button>
            @if (request('q'))
            <x-admin.button variant="secondary" icon="fa-solid fa-xmark" :href="route('blog-categories.index')">Reset</x-admin.button>
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
                @forelse ($categories as $i => $category)
                <tr class="hover:bg-slate-50/70 transition-colors">
                    <td class="px-4 py-3 text-slate-400">{{ $categories->firstItem() + $i }}</td>
                    <td class="px-4 py-3 max-w-xs">
                        <span class="block font-medium text-slate-900 truncate" title="{{ $category->name }}">{{ $category->name }}</span>
                        @if($category->description)
                        <span class="text-xs text-slate-500 truncate block">{{ $category->description }}</span>
                        @endif
                    </td>
                    <td class="px-4 py-3 whitespace-nowrap text-slate-500 font-mono text-xs">{{ $category->slug }}</td>
                    <td class="px-4 py-3 whitespace-nowrap text-slate-600">{{ $category->display_order }}</td>
                    <td class="px-4 py-3 whitespace-nowrap">
                        @if ($category->is_active)
                        <x-admin.badge color="green"><i class="fa-solid fa-circle text-[6px]"></i> Aktif</x-admin.badge>
                        @else
                        <x-admin.badge color="slate"><i class="fa-solid fa-circle text-[6px]"></i> Nonaktif</x-admin.badge>
                        @endif
                    </td>
                    <td class="px-4 py-3">
                        <div class="flex items-center justify-end gap-1.5">
                            <x-admin.button variant="secondary" size="sm" icon="fa-solid fa-pen" :href="route('blog-categories.edit', $category->id)">Edit</x-admin.button>
                            <form action="{{ route('blog-categories.destroy', $category->id) }}" method="POST" onsubmit="return confirm('Hapus kategori blog ini?')">
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
                        <p class="text-sm text-slate-500">{{ request('q') ? 'Tidak ada kategori yang cocok dengan pencarian.' : 'Belum ada kategori blog yang ditambahkan.' }}</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if ($categories->hasPages())
    <div class="px-4 py-3 border-t border-slate-200">
        {{ $categories->links('pagination::tailwind') }}
    </div>
    @endif
</x-admin.card>
@endsection
