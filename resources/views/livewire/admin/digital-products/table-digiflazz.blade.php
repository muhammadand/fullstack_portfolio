@php
$levels = $this->levels;
$filtered = $search !== '' || $category !== '' || $brand !== '' || $status !== '';
@endphp

<table class="min-w-full text-sm">
    <thead class="bg-slate-50 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
        <tr>
            <th class="px-4 py-3 w-12">No</th>
            <th class="px-4 py-3">Produk</th>
            <th class="px-4 py-3">SKU</th>
            <th class="px-4 py-3 text-right">Modal</th>
            @foreach($levels as $level)
            <th class="px-4 py-3 text-right">{{ ucfirst($level->code) }}</th>
            @endforeach
            <th class="px-4 py-3">Supplier</th>
            <th class="px-4 py-3">Cut-off</th>
            <th class="px-4 py-3">Status</th>
            <th class="px-4 py-3 text-right">Aksi</th>
        </tr>
    </thead>
    <tbody class="divide-y divide-slate-100 text-slate-600">
        @forelse($products as $product)
        <tr wire:key="dg-{{ $product->id }}" class="hover:bg-slate-50/70 transition-colors">
            <td class="px-4 py-3 text-slate-400">{{ $products->firstItem() + $loop->index }}</td>
            <td class="px-4 py-3 max-w-xs">
                <button type="button" wire:click="openDetail({{ $product->id }})" class="font-medium text-slate-900 hover:text-blue-600 block truncate max-w-full text-left" title="{{ $product->name }}">
                    {{ $product->name }}
                </button>
                <p class="text-xs text-slate-400 truncate">
                    {{ $product->brand?->category?->name }} · {{ $product->brand?->name }}{{ $product->type ? ' · ' . $product->type : '' }}
                </p>
            </td>
            <td class="px-4 py-3 whitespace-nowrap">
                <code class="px-2 py-0.5 bg-slate-100 border border-slate-200 rounded font-mono text-xs text-slate-700">{{ $product->sku_code }}</code>
            </td>
            <td class="px-4 py-3 whitespace-nowrap text-right text-slate-900 font-medium">Rp {{ number_format($product->cost_price, 0, ',', '.') }}</td>
            @foreach($levels as $level)
            <td class="px-4 py-3 whitespace-nowrap text-right">Rp {{ number_format($product->priceFor($level), 0, ',', '.') }}</td>
            @endforeach
            <td class="px-4 py-3 whitespace-nowrap">
                @if($product->buyer_product_status && $product->seller_product_status)
                <x-admin.badge color="green">Normal</x-admin.badge>
                @else
                <x-admin.badge color="orange">Gangguan</x-admin.badge>
                @endif
            </td>
            <td class="px-4 py-3 whitespace-nowrap text-xs">
                @if($product->start_cut_off && $product->end_cut_off)
                {{ substr($product->start_cut_off, 0, 5) }} - {{ substr($product->end_cut_off, 0, 5) }}
                @if($product->isInCutOff())
                <x-admin.badge color="yellow">Sekarang</x-admin.badge>
                @endif
                @else
                <span class="text-slate-400">-</span>
                @endif
            </td>
            <td class="px-4 py-3 whitespace-nowrap">
                @if($product->is_missing)
                <x-admin.badge color="orange"><i class="fa-solid fa-triangle-exclamation text-[10px]"></i> Hilang</x-admin.badge>
                @elseif($product->is_active)
                <x-admin.badge color="green"><i class="fa-solid fa-circle-check text-[10px]"></i> Aktif</x-admin.badge>
                @else
                <x-admin.badge color="slate"><i class="fa-solid fa-circle-xmark text-[10px]"></i> Belum aktif</x-admin.badge>
                @endif
            </td>
            <td class="px-4 py-3 whitespace-nowrap">
                <div class="flex items-center justify-end gap-1.5">
                    <x-admin.button wire:click="toggle({{ $product->id }})" wire:loading.attr="disabled" wire:target="toggle({{ $product->id }})"
                        size="sm" :variant="$product->is_active ? 'secondary' : 'soft'">
                        {{ $product->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                    </x-admin.button>
                    <x-admin.button wire:click="openDetail({{ $product->id }})" variant="secondary" size="sm" icon="fa-solid fa-eye" title="Detail" aria-label="Detail" />
                    <x-admin.button wire:click="openEdit({{ $product->id }})" variant="secondary" size="sm" icon="fa-solid fa-pen" title="Edit" aria-label="Edit" />
                    <x-admin.button wire:click="deleteProduct({{ $product->id }})"
                        wire:confirm="Hapus produk {{ $product->name }}? Override harga dan riwayat modalnya ikut terhapus."
                        variant="danger" size="sm" icon="fa-solid fa-trash-can" title="Hapus" aria-label="Hapus" />
                </div>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="{{ 8 + $levels->count() }}" class="px-4 py-12 text-center">
                <div class="w-12 h-12 rounded-2xl bg-slate-100 text-slate-400 flex items-center justify-center mx-auto mb-3">
                    <i class="fa-solid fa-boxes-stacked text-xl"></i>
                </div>
                <p class="text-sm font-medium text-slate-700">{{ $filtered ? 'Tidak ada produk yang cocok dengan filter.' : 'Katalog masih kosong.' }}</p>
                <p class="text-xs text-slate-400 mt-1">{{ $filtered ? 'Coba ganti kata kunci atau reset filter.' : 'Klik "Sync Produk" untuk mengambil price-list dari Digiflazz.' }}</p>
            </td>
        </tr>
        @endforelse
    </tbody>
</table>
