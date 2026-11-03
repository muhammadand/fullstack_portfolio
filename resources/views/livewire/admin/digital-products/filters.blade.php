<div class="flex flex-col lg:flex-row gap-2.5 p-4 border-b border-slate-200">
    <div class="relative flex-1 lg:max-w-sm">
        <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-sm text-slate-400"></i>
        <x-admin.input name="q" wire:model.live.debounce.400ms="search"
            :placeholder="$isDigiflazz ? 'Cari nama produk atau SKU...' : 'Cari nama, kategori, kode Lynk...'" class="pl-9" />
    </div>

    <div class="lg:w-44">
        <x-admin.select name="category" wire:model.live="category" placeholder="Semua Kategori" :options="$this->categories" />
    </div>

    @if($isDigiflazz)
    <div class="lg:w-48">
        <x-admin.select name="brand" wire:model.live="brand" placeholder="Semua Brand" :options="$this->brands" />
    </div>

    <div class="lg:w-44">
        <x-admin.select name="status" wire:model.live="status" placeholder="Semua Status"
            :options="['active' => 'Aktif (dijual)', 'inactive' => 'Belum diaktifkan', 'unavailable' => 'Gangguan supplier', 'missing' => 'Hilang dari katalog']" />
    </div>
    @endif

    @if($search !== '' || $category !== '' || $brand !== '' || $status !== '')
    <div>
        <x-admin.button wire:click="resetFilters" variant="secondary" icon="fa-solid fa-xmark">Reset</x-admin.button>
    </div>
    @endif
</div>
