<table class="min-w-full text-sm">
    <thead class="bg-slate-50 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
        <tr>
            <th class="px-4 py-3 w-12">No</th>
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
        <tr wire:key="lynk-{{ $product->id }}" class="hover:bg-slate-50/70 transition-colors">
            <td class="px-4 py-3 text-slate-400">{{ $products->firstItem() + $loop->index }}</td>
            <td class="px-4 py-3 max-w-sm">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-xl bg-amber-50 border border-amber-200/80 flex items-center justify-center text-amber-600 shrink-0 overflow-hidden">
                        @if($product->thumbnail)
                        <img src="{{ asset('storage/' . $product->thumbnail) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                        @else
                        <i class="fa-solid fa-cube text-base"></i>
                        @endif
                    </div>
                    <div class="min-w-0">
                        <a href="{{ route('admin.digital_products.edit', $product->id) }}" class="font-medium text-slate-900 hover:text-blue-600 block truncate" title="{{ $product->name }}">{{ $product->name }}</a>
                        <p class="text-xs text-slate-400 truncate mt-0.5">{{ $product->short_description ?: 'Tidak ada deskripsi singkat' }}</p>
                    </div>
                </div>
            </td>
            <td class="px-4 py-3 whitespace-nowrap">
                <span class="inline-flex items-center px-2 py-0.5 rounded-md text-xs font-medium bg-slate-100 text-slate-700 border border-slate-200/80">{{ $product->category ?: 'General' }}</span>
            </td>
            <td class="px-4 py-3 whitespace-nowrap">
                <code class="px-2 py-0.5 bg-amber-50 border border-amber-200/80 rounded font-mono text-xs text-amber-800 font-semibold">{{ $product->lynk_slug }}</code>
            </td>
            <td class="px-4 py-3 whitespace-nowrap font-bold text-slate-900">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
            <td class="px-4 py-3 whitespace-nowrap">
                @if($product->is_active)
                <x-admin.badge color="green"><i class="fa-solid fa-circle-check text-[10px]"></i> Aktif</x-admin.badge>
                @else
                <x-admin.badge color="slate"><i class="fa-solid fa-circle-xmark text-[10px]"></i> Nonaktif</x-admin.badge>
                @endif
            </td>
            <td class="px-4 py-3 whitespace-nowrap">
                <div class="flex items-center justify-end gap-1.5">
                    @if($product->demo_url)
                    <x-admin.button variant="secondary" size="sm" icon="fa-solid fa-arrow-up-right-from-square" :href="$product->demo_url" target="_blank" title="Lihat Live Demo" />
                    @endif
                    <x-admin.button variant="secondary" size="sm" icon="fa-solid fa-pen" :href="route('admin.digital_products.edit', $product->id)">Edit</x-admin.button>
                    <form action="{{ route('admin.digital_products.destroy', $product->id) }}" method="POST" data-confirm="Apakah Anda yakin ingin menghapus produk digital ini?" data-confirm-danger>
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
                <p class="text-sm font-medium text-slate-700">
                    {{ $search !== '' || $category !== '' ? 'Tidak ada produk Lynk.id yang cocok dengan filter.' : 'Belum ada produk Lynk.id terdaftar.' }}
                </p>
            </td>
        </tr>
        @endforelse
    </tbody>
</table>
