@php
$p = $this->detailProduct;
$levels = $this->levels;
$histories = $this->detailCostHistories;
$rows = $p ? [
    'SKU' => $p->sku_code,
    'Kategori' => $p->brand?->category?->name ?? '-',
    'Brand' => $p->brand?->name ?? '-',
    'Tipe' => $p->type ?? '-',
    'Penjual (supplier)' => $p->seller_name ?? '-',
    'Deskripsi' => $p->description ?: '-',
    'Stok' => $p->unlimited_stock ? 'Unlimited' : number_format($p->stock, 0, ',', '.'),
    'Multi transaksi' => $p->multi ? 'Ya' : 'Tidak',
    'Cut-off' => ($p->start_cut_off && $p->end_cut_off) ? substr($p->start_cut_off, 0, 5) . ' - ' . substr($p->end_cut_off, 0, 5) : '-',
    'Sync terakhir' => $p->last_synced_at?->format('d M Y H:i') ?? '-',
] : [];
@endphp

@if($p)
<x-admin.modal :title="$p->name" icon="fa-solid fa-eye" size="xl">
    <div class="flex flex-wrap gap-2 mb-4">
        @if($p->is_missing)
        <x-admin.badge color="orange">Hilang dari katalog</x-admin.badge>
        @endif
        <x-admin.badge :color="$p->is_active ? 'green' : 'slate'">{{ $p->is_active ? 'Aktif (dijual)' : 'Belum aktif' }}</x-admin.badge>
        <x-admin.badge :color="($p->buyer_product_status && $p->seller_product_status) ? 'green' : 'orange'">
            Supplier: {{ ($p->buyer_product_status && $p->seller_product_status) ? 'Normal' : 'Gangguan' }}
        </x-admin.badge>
        @if($p->isInCutOff())
        <x-admin.badge color="yellow">Sedang cut-off</x-admin.badge>
        @endif
    </div>

    <div class="grid md:grid-cols-2 gap-6">
        <div>
            <h4 class="text-xs font-semibold uppercase tracking-wider text-slate-500 mb-2">Informasi Produk</h4>
            <dl class="divide-y divide-slate-100 text-sm">
                @foreach($rows as $label => $value)
                <div class="flex justify-between gap-4 py-2">
                    <dt class="text-slate-500 shrink-0">{{ $label }}</dt>
                    <dd class="text-slate-900 text-right break-words min-w-0">{{ $value }}</dd>
                </div>
                @endforeach
            </dl>
        </div>

        <div class="space-y-5">
            <div>
                <h4 class="text-xs font-semibold uppercase tracking-wider text-slate-500 mb-2">Harga</h4>
                <dl class="divide-y divide-slate-100 text-sm">
                    <div class="flex justify-between gap-4 py-2">
                        <dt class="text-slate-500">Modal</dt>
                        <dd class="text-slate-900 font-semibold">Rp {{ number_format($p->cost_price, 0, ',', '.') }}</dd>
                    </div>
                    @foreach($levels as $level)
                    @php $manual = $p->priceOverrides->firstWhere('price_level_id', $level->id); @endphp
                    <div class="flex justify-between gap-4 py-2">
                        <dt class="text-slate-500">{{ $level->name }}
                            @if($manual)<x-admin.badge color="blue" class="ml-1">manual</x-admin.badge>@endif
                        </dt>
                        <dd class="text-slate-900 font-semibold">Rp {{ number_format($p->priceFor($level), 0, ',', '.') }}</dd>
                    </div>
                    @endforeach
                </dl>
            </div>

            <div>
                <h4 class="text-xs font-semibold uppercase tracking-wider text-slate-500 mb-2">Riwayat Perubahan Modal</h4>
                @forelse($histories as $h)
                <div class="flex justify-between gap-4 py-1.5 text-sm border-b border-slate-100 last:border-0">
                    <span class="text-slate-500">{{ $h->changed_at->format('d M Y H:i') }}</span>
                    <span class="text-slate-900">
                        Rp {{ number_format($h->old_cost, 0, ',', '.') }}
                        <i class="fa-solid fa-arrow-right text-[10px] text-slate-400 mx-1"></i>
                        <span class="{{ $h->new_cost > $h->old_cost ? 'text-red-600' : 'text-emerald-600' }} font-semibold">Rp {{ number_format($h->new_cost, 0, ',', '.') }}</span>
                    </span>
                </div>
                @empty
                <p class="text-xs text-slate-400">Belum ada perubahan modal.</p>
                @endforelse
            </div>
        </div>
    </div>

    @if($p->raw_payload)
    <details class="mt-5">
        <summary class="text-xs font-semibold uppercase tracking-wider text-slate-500 cursor-pointer">Data mentah Digiflazz</summary>
        <pre class="mt-2 p-3 bg-slate-50 border border-slate-200 rounded-lg text-xs text-slate-700 overflow-x-auto">{{ json_encode($p->raw_payload, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
    </details>
    @endif

    <x-slot:footer>
        <x-admin.button wire:click="closeModal" variant="secondary">Tutup</x-admin.button>
        <x-admin.button wire:click="openEdit({{ $p->id }})" icon="fa-solid fa-pen">Edit</x-admin.button>
    </x-slot:footer>
</x-admin.modal>
@endif
