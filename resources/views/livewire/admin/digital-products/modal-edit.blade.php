@php
$p = $this->editProduct;
$levels = $this->levels;
@endphp

@if($p)
<x-admin.modal :title="'Edit ' . $p->name" icon="fa-solid fa-pen" size="lg">
    <form wire:submit="saveEdit" id="edit-digital-product-form" class="space-y-5">
        <div class="rounded-lg bg-slate-50 border border-slate-200 px-4 py-3 text-sm flex flex-wrap justify-between gap-2">
            <span class="text-slate-500">SKU <code class="ml-1 font-mono text-slate-700">{{ $p->sku_code }}</code></span>
            <span class="text-slate-500">Modal <strong class="ml-1 text-slate-900">Rp {{ number_format($p->cost_price, 0, ',', '.') }}</strong></span>
        </div>

        <label class="flex items-center gap-3 cursor-pointer">
            <input type="checkbox" wire:model="editIsActive" class="w-4 h-4 rounded border-slate-300 text-blue-600 focus:ring-blue-500/30">
            <span class="text-sm text-slate-700">Aktifkan produk (tampil dan bisa dijual)</span>
        </label>

        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1.5">Urutan Tampil</label>
            <x-admin.input name="editDisplayOrder" type="number" min="0" wire:model="editDisplayOrder" />
            @error('editDisplayOrder')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
        </div>

        <div>
            <h4 class="text-sm font-medium text-slate-700 mb-1">Harga Jual Manual per Level</h4>
            <p class="text-xs text-slate-400 mb-3">Kosongkan untuk memakai harga otomatis (modal + margin level).</p>
            <div class="space-y-3">
                @foreach($levels as $level)
                <div wire:key="edit-price-{{ $level->id }}">
                    <div class="flex items-center gap-3">
                        <label class="w-48 shrink-0 text-sm text-slate-600">
                            {{ $level->name }}
                            <span class="block text-xs text-slate-400">Otomatis: Rp {{ number_format($level->applyMargin((float) $p->cost_price), 0, ',', '.') }}</span>
                        </label>
                        <div class="relative flex-1">
                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-sm text-slate-400">Rp</span>
                            <x-admin.input name="editPrices.{{ $level->id }}" type="number" min="0" step="1" placeholder="Otomatis" wire:model="editPrices.{{ $level->id }}" class="pl-9" />
                        </div>
                    </div>
                    @error('editPrices.' . $level->id)<p class="text-xs text-red-600 mt-1 ml-[calc(12rem+0.75rem)]">{{ $message }}</p>@enderror
                </div>
                @endforeach
            </div>
        </div>

        <p class="text-xs text-slate-400">Data dari supplier (nama, modal, status, cut-off) tidak bisa diedit karena akan ditimpa saat sync berikutnya.</p>
    </form>

    <x-slot:footer>
        <x-admin.button wire:click="closeModal" variant="secondary">Batal</x-admin.button>
        <x-admin.button type="submit" form="edit-digital-product-form" wire:loading.attr="disabled" wire:target="saveEdit" icon="fa-solid fa-floppy-disk">
            <span wire:loading.remove wire:target="saveEdit">Simpan</span>
            <span wire:loading wire:target="saveEdit">Menyimpan...</span>
        </x-admin.button>
    </x-slot:footer>
</x-admin.modal>
@endif
