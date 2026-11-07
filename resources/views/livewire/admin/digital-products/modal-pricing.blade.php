@if($pricingOpen)
@php
$usage = $this->levelUsage;
$sampleCost = 10000; // contoh modal untuk pratinjau
$preview = function (array $form) use ($sampleCost) {
    $value = is_numeric($form['margin_value'] ?? null) ? (float) $form['margin_value'] : 0;

    return $sampleCost + (($form['margin_type'] ?? 'percent') === 'fixed' ? $value : $sampleCost * $value / 100);
};
@endphp

<x-admin.modal title="Pengaturan Harga" icon="fa-solid fa-tags" size="lg">
    <form wire:submit="savePricing" id="pricing-form" class="space-y-5">
        <p class="text-sm text-slate-500">
            Harga jual otomatis dihitung dari <strong>modal + margin</strong> level pembeli dan dicatat ke tabel harga produk.
        </p>

        @foreach($levelForms as $id => $form)
        <div wire:key="pricing-level-{{ $id }}" class="rounded-xl border border-slate-200 p-4 space-y-3">
            <div class="flex items-start justify-between gap-3">
                <div class="flex-1">
                    <label class="block text-xs font-medium text-slate-500 mb-1">Nama Level</label>
                    <x-admin.input name="levelForms.{{ $id }}.name" wire:model="levelForms.{{ $id }}.name" />
                    @error("levelForms.$id.name")<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
                </div>
                <div class="text-right shrink-0 pt-5">
                    <x-admin.badge color="slate">{{ $usage[$id] ?? 0 }} partner</x-admin.badge>
                </div>
            </div>

            <div class="grid sm:grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-medium text-slate-500 mb-1">Jenis Margin</label>
                    <x-admin.select name="levelForms.{{ $id }}.margin_type" wire:model.live="levelForms.{{ $id }}.margin_type"
                        :options="['percent' => 'Persentase (%)', 'fixed' => 'Nominal tetap (Rp)']" />
                    @error("levelForms.$id.margin_type")<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-xs font-medium text-slate-500 mb-1">Nilai Margin</label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-sm text-slate-400">{{ $form['margin_type'] === 'fixed' ? 'Rp' : '%' }}</span>
                        <x-admin.input name="levelForms.{{ $id }}.margin_value" type="number" min="0" step="0.01" wire:model.live.debounce.300ms="levelForms.{{ $id }}.margin_value" class="pl-9" />
                    </div>
                    @error("levelForms.$id.margin_value")<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
                </div>
            </div>

            <p class="text-xs text-slate-400">
                Contoh: modal Rp {{ number_format($sampleCost, 0, ',', '.') }} → dijual
                <strong class="text-slate-700">Rp {{ number_format($preview($form), 0, ',', '.') }}</strong>
            </p>
        </div>
        @endforeach
    </form>

    <x-slot:footer>
        <x-admin.button wire:click="closeModal" variant="secondary">Batal</x-admin.button>
        <x-admin.button type="submit" form="pricing-form" wire:loading.attr="disabled" wire:target="savePricing" icon="fa-solid fa-floppy-disk">
            <span wire:loading.remove wire:target="savePricing">Simpan</span>
            <span wire:loading wire:target="savePricing">Menyimpan...</span>
        </x-admin.button>
    </x-slot:footer>
</x-admin.modal>
@endif
