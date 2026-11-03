@extends('layouts.admin.app')

@section('content')
<x-admin.page-header title="Daftar Portfolio" subtitle="Kelola portfolio yang tampil di website.">
    <x-admin.button icon="fa-solid fa-plus" :href="route('portfolio.create')">Buat Portfolio</x-admin.button>
</x-admin.page-header>

@if (session('success'))
<x-admin.alert type="success">{{ session('success') }}</x-admin.alert>
@endif

<x-admin.card :padding="false">
    {{-- Toolbar pencarian & filter --}}
    <form method="GET" class="flex flex-col sm:flex-row flex-wrap gap-2 p-4 border-b border-slate-200">
        <div class="relative flex-1 sm:min-w-[240px] sm:max-w-sm">
            <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-sm text-slate-400"></i>
            <x-admin.input name="q" :value="request('q', request('search'))" placeholder="Cari judul, klien, atau kategori..." class="pl-9" />
        </div>
        <div class="w-full sm:w-44">
            <x-admin.select name="category_id" placeholder="Semua kategori" :options="$categories->pluck('name', 'id')" :selected="request('category_id')" />
        </div>
        <div class="w-full sm:w-36">
            <x-admin.select name="is_active" placeholder="Semua status" :options="['1' => 'Aktif', '0' => 'Nonaktif']" :selected="request('is_active')" />
        </div>
        <div class="flex gap-2">
            <x-admin.button type="submit" variant="secondary">Cari</x-admin.button>
            @if (request()->hasAny(['q', 'search', 'category_id', 'is_active']))
            <x-admin.button variant="secondary" icon="fa-solid fa-xmark" :href="route('portfolio.index')">Reset</x-admin.button>
            @endif
        </div>
    </form>

    <div class="overflow-x-auto">
        <table class="min-w-full text-sm">
            <thead class="bg-slate-50 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                <tr>
                    <th class="px-4 py-3 w-12">#</th>
                    <th class="px-4 py-3">Portfolio</th>
                    <th class="px-4 py-3">Kategori</th>
                    <th class="px-4 py-3">Klien</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 text-slate-600">
                @forelse ($portfolios as $item)
                <tr class="hover:bg-slate-50/70 transition-colors">
                    <td class="px-4 py-3 text-slate-400">{{ $portfolios->firstItem() + $loop->index }}</td>
                    <td class="px-4 py-3 max-w-xs">
                        <div class="flex items-center gap-3 min-w-0">
                            @if ($item->thumbnail_image)
                            <img src="{{ asset('storage/' . $item->thumbnail_image) }}" alt="{{ $item->title }}" class="w-14 h-10 shrink-0 rounded-lg object-cover border border-slate-200">
                            @else
                            <div class="w-14 h-10 shrink-0 rounded-lg bg-slate-100 border border-slate-200 flex items-center justify-center text-slate-400">
                                <i class="fa-regular fa-image"></i>
                            </div>
                            @endif
                            <div class="min-w-0">
                                <a href="{{ route('portfolio.read', $item->slug) }}" target="_blank" class="block font-medium text-slate-900 hover:text-blue-600 truncate" title="{{ $item->title }}">
                                    {{ $item->title }}
                                </a>
                                <span class="text-xs text-slate-500 truncate block">{{ $item->category->name ?? 'Tanpa kategori' }}</span>
                            </div>
                        </div>
                    </td>
                    <td class="px-4 py-3 whitespace-nowrap">
                        <span class="text-slate-600">{{ $item->category->name ?? '-' }}</span>
                    </td>
                    <td class="px-4 py-3 whitespace-nowrap">
                        <span class="text-slate-600">{{ $item->client_name ?: '-' }}</span>
                    </td>
                    <td class="px-4 py-3">
                        <div class="flex flex-wrap gap-1.5">
                            @if ($item->is_active)
                            <x-admin.badge color="green"><i class="fa-solid fa-circle text-[6px]"></i> Aktif</x-admin.badge>
                            @else
                            <x-admin.badge color="slate"><i class="fa-solid fa-circle text-[6px]"></i> Nonaktif</x-admin.badge>
                            @endif
                            @if ($item->is_featured)
                            <x-admin.badge color="blue"><i class="fa-solid fa-star text-[10px]"></i> Unggulan</x-admin.badge>
                            @endif
                        </div>
                    </td>
                    <td class="px-4 py-3">
                        <div class="flex items-center justify-end gap-1.5">
                            <x-admin.button variant="secondary" size="sm" icon="fa-solid fa-eye" :href="route('portfolio.read', $item->slug)" target="_blank" title="Lihat di website" aria-label="Lihat di website" />
                            <x-admin.button variant="secondary" size="sm" icon="fa-solid fa-pen" :href="route('portfolio.edit', $item)">Edit</x-admin.button>
                            <form action="{{ route('portfolio.destroy', $item) }}" method="POST" onsubmit="return confirm('Hapus portfolio ini?')">
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
                        <p class="text-sm text-slate-500">{{ request()->hasAny(['q', 'search', 'category_id', 'is_active']) ? 'Tidak ada portfolio yang cocok dengan pencarian.' : 'Belum ada portfolio yang ditambahkan.' }}</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if ($portfolios->hasPages())
    <div class="px-4 py-3 border-t border-slate-200">
        {{ $portfolios->links('pagination::tailwind') }}
    </div>
    @endif
</x-admin.card>
@endsection
