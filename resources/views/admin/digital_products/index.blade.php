@extends('layouts.admin.app')

@section('content')
{{-- Page Header --}}
<x-admin.page-header title="Produk Digital (Lynk.id)" subtitle="Kelola katalog produk digital Lynk.id yang dapat dipromosikan oleh Affiliate.">
    <x-admin.button icon="fa-solid fa-plus" :href="route('admin.digital_products.create')">
        Tambah Produk Digital
    </x-admin.button>
</x-admin.page-header>

{{-- Alerts --}}
@if(session('success'))
<x-admin.alert type="success">{{ session('success') }}</x-admin.alert>
@endif

@if(session('error'))
<x-admin.alert type="error">{{ session('error') }}</x-admin.alert>
@endif

{{-- Main Card Table --}}
<x-admin.card :padding="false">
    {{-- Toolbar Filter & Pencarian --}}
    <form method="GET" action="{{ route('admin.digital_products.index') }}" class="flex flex-col sm:flex-row gap-2.5 p-4 border-b border-slate-200">
        <div class="relative flex-1 sm:max-w-sm">
            <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-sm text-slate-400"></i>
            <x-admin.input name="q" :value="request('q') ?? request('search')" placeholder="Cari nama, kategori, kode Lynk..." class="pl-9" />
        </div>

        <div class="sm:w-48">
            <x-admin.select name="category" onchange="this.form.submit()">
                <option value="">Semua Kategori</option>
                @foreach($categories as $cat)
                <option value="{{ $cat }}" {{ request('category') === $cat ? 'selected' : '' }}>{{ $cat }}</option>
                @endforeach
            </x-admin.select>
        </div>

        <div class="flex gap-2">
            <x-admin.button type="submit" variant="secondary">Filter</x-admin.button>
            @if(request('q') || request('search') || request('category'))
            <x-admin.button variant="secondary" icon="fa-solid fa-xmark" :href="route('admin.digital_products.index')">Reset</x-admin.button>
            @endif
        </div>
    </form>

    {{-- Table List --}}
    <div class="overflow-x-auto">
        <table class="min-w-full text-sm">
            <thead class="bg-slate-50 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                <tr>
                    <th class="px-4 py-3 w-12">#</th>
                    <th class="px-4 py-3">Produk</th>
                    <th class="px-4 py-3">Kategori</th>
                    <th class="px-4 py-3">Kode Lynk.id</th>
                    <th class="px-4 py-3">Harga</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 text-slate-600">
                @forelse($products as $product)
                <tr class="hover:bg-slate-50/70 transition-colors">
                    <td class="px-4 py-3 text-slate-400">{{ $products->firstItem() + $loop->index }}</td>
                    <td class="px-4 py-3 max-w-sm">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 rounded-xl bg-amber-50 border border-amber-200/80 flex items-center justify-center text-amber-600 shrink-0 overflow-hidden">
                                @if($product->thumbnail && \Illuminate\Support\Facades\Storage::disk('public')->exists($product->thumbnail))
                                <img src="{{ asset('storage/' . $product->thumbnail) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                                @else
                                <i class="fa-solid fa-cube text-base"></i>
                                @endif
                            </div>
                            <div class="min-w-0">
                                <a href="{{ route('admin.digital_products.edit', $product->id) }}" class="font-medium text-slate-900 hover:text-blue-600 block truncate" title="{{ $product->name }}">
                                    {{ $product->name }}
                                </a>
                                <p class="text-xs text-slate-400 truncate mt-0.5" title="{{ $product->short_description }}">
                                    {{ $product->short_description ?: 'Tidak ada deskripsi singkat' }}
                                </p>
                            </div>
                        </div>
                    </td>
                    <td class="px-4 py-3 whitespace-nowrap">
                        <span class="inline-flex items-center px-2 py-0.5 rounded-md text-xs font-medium bg-slate-100 text-slate-700 border border-slate-200/80">
                            {{ $product->category ?: 'General' }}
                        </span>
                    </td>
                    <td class="px-4 py-3 whitespace-nowrap">
                        <code class="px-2 py-0.5 bg-amber-50 border border-amber-200/80 rounded font-mono text-xs text-amber-800 font-semibold">
                            {{ $product->lynk_slug }}
                        </code>
                    </td>
                    <td class="px-4 py-3 whitespace-nowrap">
                        <div class="font-bold text-slate-900 text-xs sm:text-sm">
                            Rp {{ number_format($product->price, 0, ',', '.') }}
                        </div>
                    </td>
                    <td class="px-4 py-3 whitespace-nowrap">
                        @if($product->is_active)
                        <x-admin.badge color="green">
                            <i class="fa-solid fa-circle-check text-[10px]"></i> Aktif
                        </x-admin.badge>
                        @else
                        <x-admin.badge color="slate">
                            <i class="fa-solid fa-circle-xmark text-[10px]"></i> Nonaktif
                        </x-admin.badge>
                        @endif
                    </td>
                    <td class="px-4 py-3 whitespace-nowrap">
                        <div class="flex items-center justify-end gap-1.5">
                            @if($product->demo_url)
                            <x-admin.button variant="secondary" size="sm" icon="fa-solid fa-arrow-up-right-from-square" :href="$product->demo_url" target="_blank" title="Lihat Live Demo" />
                            @endif
                            <x-admin.button variant="secondary" size="sm" icon="fa-solid fa-pen" :href="route('admin.digital_products.edit', $product->id)">
                                Edit
                            </x-admin.button>
                            <form action="{{ route('admin.digital_products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk digital ini?')">
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
                        <div class="w-12 h-12 rounded-2xl bg-slate-100 text-slate-400 flex items-center justify-center mx-auto mb-3">
                            <i class="fa-solid fa-cubes-stacked text-xl"></i>
                        </div>
                        <p class="text-sm font-medium text-slate-700">
                            {{ request('q') || request('search') || request('category') ? 'Tidak ada produk digital yang cocok dengan filter.' : 'Belum ada produk digital terdaftar.' }}
                        </p>
                        <p class="text-xs text-slate-400 mt-1">
                            {{ request('q') || request('search') || request('category') ? 'Coba ganti kata kunci pencarian atau reset filter.' : 'Silakan tambahkan produk digital baru untuk katalog affiliate Lynk.id.' }}
                        </p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination Links --}}
    @if ($products->hasPages())
    <div class="px-4 py-3 border-t border-slate-200">
        {{ $products->links('pagination::tailwind') }}
    </div>
    @endif
</x-admin.card>
@endsection
