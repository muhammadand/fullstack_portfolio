@extends('layouts.admin.app')

@section('content')
<x-admin.page-header title="Daftar Blog" subtitle="Kelola artikel blog dan tulisan dari partner affiliate.">
    <x-admin.button icon="fa-solid fa-plus" :href="route('blogs.create')">Buat Blog</x-admin.button>
</x-admin.page-header>

@if (session('success'))
<x-admin.alert type="success">{{ session('success') }}</x-admin.alert>
@endif

<x-admin.card :padding="false">
    {{-- Toolbar pencarian --}}
    <x-admin.filter-bar name="q" :value="request('q')" placeholder="Cari judul atau kategori..." :reset="route('blogs.index')" />

    <div class="overflow-x-auto">
        <table class="min-w-full text-sm">
            <thead class="bg-slate-50 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                <tr>
                    <th class="px-4 py-3 w-12">#</th>
                    <th class="px-4 py-3">Judul</th>
                    <th class="px-4 py-3">Penulis</th>
                    <th class="px-4 py-3">Views</th>
                    <th class="px-4 py-3">Diterbitkan</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 text-slate-600">
                @forelse ($blogs as $blog)
                <tr class="hover:bg-slate-50/70 transition-colors">
                    <td class="px-4 py-3 text-slate-400">{{ $blogs->firstItem() + $loop->index }}</td>
                    <td class="px-4 py-3 max-w-xs">
                        <a href="{{ route('blogs.show', $blog) }}" class="block font-medium text-slate-900 hover:text-blue-600 truncate" title="{{ $blog->title }}">{{ $blog->title }}</a>
                        <span class="text-xs text-slate-500">{{ $blog->category->name ?? 'Tanpa kategori' }}</span>
                    </td>
                    <td class="px-4 py-3 whitespace-nowrap">
                        @if ($blog->affiliate_id)
                        <span class="inline-flex items-center gap-1.5 text-orange-600" title="Partner Affiliate">
                            <i class="fa-solid fa-handshake text-xs"></i> {{ $blog->affiliate->name ?? 'Partner' }}
                        </span>
                        @else
                        {{ $blog->author->name ?? '-' }}
                        @endif
                    </td>
                    <td class="px-4 py-3 whitespace-nowrap">
                        <i class="fa-regular fa-eye text-slate-400 mr-1"></i>{{ number_format($blog->view_count ?? 0, 0, ',', '.') }}
                    </td>
                    <td class="px-4 py-3 whitespace-nowrap">{{ $blog->published_at?->format('d M Y') ?? '-' }}</td>
                    <td class="px-4 py-3">@include('blogs.partials.status-badge')</td>
                    <td class="px-4 py-3">
                        <div class="flex items-center justify-end gap-1.5">
                            @unless ($blog->is_published)
                            <form action="{{ route('blogs.publish', $blog) }}" method="POST">
                                @csrf
                                <x-admin.button type="submit" variant="soft" size="sm" icon="fa-solid fa-paper-plane">Publish</x-admin.button>
                            </form>
                            @endunless
                            <x-admin.button variant="secondary" size="sm" icon="fa-solid fa-pen" :href="route('blogs.edit', $blog)">Edit</x-admin.button>
                            <form action="{{ route('blogs.destroy', $blog) }}" method="POST" onsubmit="return confirm('Hapus blog ini?')">
                                @csrf
                                @method('DELETE')
                                <x-admin.button type="submit" variant="danger" size="sm" icon="fa-solid fa-trash-can" title="Hapus" aria-label="Hapus" />
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-4 py-12 text-center">
                        <i class="fa-regular fa-newspaper text-3xl text-slate-300 mb-2"></i>
                        <p class="text-sm text-slate-500">{{ request('q') ? 'Tidak ada blog yang cocok dengan pencarian.' : 'Belum ada blog yang ditambahkan.' }}</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if ($blogs->hasPages())
    <div class="px-4 py-3 border-t border-slate-200">
        {{ $blogs->links('pagination::tailwind') }}
    </div>
    @endif
</x-admin.card>
@endsection
